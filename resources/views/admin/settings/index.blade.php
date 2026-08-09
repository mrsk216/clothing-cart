@extends('admin.layout')

@section('title', 'Settings')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-primary mb-6">Settings</h1>

    <div class="card p-6">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <h3 class="font-semibold text-primary mb-4">General Settings</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Clothing Cart' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'info@clothingcart.com' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+91-9876543210' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? ($settings['contact_phone'] ?? '+91-9876543210') }}" class="input-field" placeholder="919876543210">
                        <p class="text-xs text-gray-500 mt-1">Used for floating WhatsApp chat widget. Include country code.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" name="address" value="{{ $settings['address'] ?? '123, Business Street, Mumbai' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">GSTIN</label>
                        <input type="text" name="gst_number" value="{{ $settings['gst_number'] ?? '' }}" class="input-field" placeholder="22AAAAA0000A1Z5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">GST Rate (%)</label>
                        <input type="number" name="gst_rate" value="{{ $settings['gst_rate'] ?? 18 }}" class="input-field" min="0" max="28" step="0.1">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">SEO Meta Description</label>
                        <textarea name="meta_description" rows="2" class="input-field" maxlength="300">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">SEO Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" class="input-field" placeholder="fashion, clothing, apparel, accessories">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-primary mb-4">Payment Settings</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company QR Code</label>
                        @if(!empty($settings['qr_code_path']))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $settings['qr_code_path']) }}" alt="QR Code" class="w-32 h-32 object-contain border rounded">
                                <p class="text-xs text-gray-500 mt-1">Current QR code. Upload a new one to replace.</p>
                            </div>
                        @endif
                        <input type="file" name="qr_code" accept="image/*" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">UPI ID</label>
                        <input type="text" name="upi_id" value="{{ $settings['upi_id'] ?? 'company@upi' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? 'State Bank of India' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Account Name</label>
                        <input type="text" name="bank_account_name" value="{{ $settings['bank_account_name'] ?? 'Clothing Cart' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Account Number</label>
                        <input type="text" name="bank_account_number" value="{{ $settings['bank_account_number'] ?? '123456789012' }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">IFSC Code</label>
                        <input type="text" name="bank_ifsc_code" value="{{ $settings['bank_ifsc_code'] ?? 'SBIN0001234' }}" class="input-field">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-primary mb-4">Shipping Settings</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Free Shipping Threshold (₹)</label>
                        <input type="number" name="free_shipping_threshold" value="{{ $settings['free_shipping_threshold'] ?? 500 }}" class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Charge (₹)</label>
                        <input type="number" name="shipping_charge" value="{{ $settings['shipping_charge'] ?? 50 }}" class="input-field">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary">Save Settings</button>
        </form>
    </div>
</div>
@endsection
