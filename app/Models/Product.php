<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'short_description', 'price', 'compare_price',
        'cost_price', 'category_id', 'sku', 'barcode', 'stock_quantity', 'low_stock_threshold',
        'track_stock', 'is_featured', 'is_active', 'unit', 'weight', 'length', 'width', 'height',
        'meta_title', 'meta_description', 'tags', 'specifications'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'track_stock' => 'boolean',
        'tags' => 'array',
        'specifications' => 'array',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function wishlistedBy(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePopular($query)
    {
        return $query->withCount('orderItems')
            ->orderBy('order_items_count', 'desc');
    }

    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('track_stock', false)->orWhere('stock_quantity', '>', 0);
        });
    }

    public function scopeLowStock($query)
    {
        return $query->where('track_stock', true)
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold');
    }

    public function getFinalPriceAttribute()
    {
        return $this->price ?: $this->compare_price;
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function getGstAmountAttribute()
    {
        return ($this->price * config('app.gst_rate', 18)) / 100;
    }

    public function getPriceWithGstAttribute()
    {
        return $this->price + $this->gst_amount;
    }

    public function getImageUrlAttribute()
    {
        $image = $this->primaryImage;
        return $image ? asset('storage/' . $image->image_path) : asset('images/placeholder.png');
    }

    public function isInStock(): bool
    {
        if (!$this->track_stock) return true;
        return $this->stock_quantity > 0;
    }
}
