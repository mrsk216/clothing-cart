<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GST Invoice - {{ $order->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Georgia, 'Times New Roman', serif; color: #1a1a1a; background: #f5f5f5; padding: 24px; }
        .invoice { max-width: 860px; margin: 0 auto; background: #fff; padding: 40px; border: 1px solid #ddd; }
        .header { display: flex; justify-content: space-between; gap: 24px; border-bottom: 2px solid #1a365d; padding-bottom: 20px; margin-bottom: 24px; }
        .brand h1 { font-size: 28px; color: #1a365d; letter-spacing: 0.02em; }
        .brand p { font-size: 13px; color: #555; margin-top: 4px; line-height: 1.5; }
        .meta { text-align: right; }
        .meta h2 { font-size: 22px; color: #1a365d; margin-bottom: 8px; }
        .meta p { font-size: 13px; margin: 2px 0; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
        .box h3 { font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em; color: #666; margin-bottom: 8px; }
        .box p { font-size: 14px; line-height: 1.55; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #1a365d; color: #fff; text-align: left; padding: 10px 12px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.04em; }
        td { padding: 10px 12px; border-bottom: 1px solid #e5e5e5; font-size: 14px; }
        .text-right { text-align: right; }
        .totals { width: 320px; margin-left: auto; }
        .totals .row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; }
        .totals .grand { border-top: 2px solid #1a365d; margin-top: 8px; padding-top: 10px; font-size: 18px; font-weight: bold; color: #1a365d; }
        .gst-note { margin-top: 24px; padding: 12px; background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px; color: #475569; }
        .actions { max-width: 860px; margin: 0 auto 16px; display: flex; gap: 12px; justify-content: flex-end; }
        .btn { display: inline-block; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-family: system-ui, sans-serif; font-size: 14px; cursor: pointer; border: none; }
        .btn-primary { background: #1a365d; color: #fff; }
        .btn-outline { background: #fff; color: #1a365d; border: 1px solid #1a365d; }
        @media print {
            body { background: #fff; padding: 0; }
            .actions { display: none !important; }
            .invoice { border: none; padding: 0; }
        }
    </style>
</head>
<body>
@php
    $taxable = (float) $order->subtotal - (float) $order->discount;
    $gstAmount = (float) $order->tax > 0 ? (float) $order->tax : round($taxable * $gstRate / (100 + $gstRate), 2);
    $taxableValue = (float) $order->tax > 0 ? $taxable : round($taxable - $gstAmount, 2);
    $cgst = round($gstAmount / 2, 2);
    $sgst = round($gstAmount / 2, 2);
@endphp

<div class="actions">
    <button type="button" class="btn btn-outline" onclick="window.print()">Print / Save PDF</button>
    <a href="{{ route('invoice.download', $order) }}" class="btn btn-primary">Download</a>
    <a href="{{ route('order.detail', $order->id) }}" class="btn btn-outline">Back to Order</a>
</div>

<div class="invoice">
    <div class="header">
        <div class="brand">
            <h1>{{ $settings['site_name'] ?? 'Clothing Cart' }}</h1>
            <p>
                {{ $settings['address'] ?? '' }}<br>
                Phone: {{ $settings['contact_phone'] ?? '' }}<br>
                Email: {{ $settings['contact_email'] ?? '' }}<br>
                @if(!empty($settings['gst_number']))
                    GSTIN: {{ $settings['gst_number'] }}
                @endif
            </p>
        </div>
        <div class="meta">
            <h2>TAX INVOICE</h2>
            <p><strong>Invoice No:</strong> {{ $order->invoice_number }}</p>
            <p><strong>Order No:</strong> {{ $order->order_number }}</p>
            <p><strong>Date:</strong> {{ optional($order->paid_at)->format('d M Y') ?? $order->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <div class="grid">
        <div class="box">
            <h3>Bill To</h3>
            <p>
                <strong>{{ $order->shipping_name ?? $order->user?->name }}</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}<br>
                Phone: {{ $order->shipping_phone }}<br>
                Email: {{ $order->user?->email }}
            </p>
        </div>
        <div class="box">
            <h3>Payment Details</h3>
            <p>
                Status: Paid<br>
                Method: {{ ucwords(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}<br>
                Paid At: {{ optional($order->paid_at)->format('d M Y, h:i A') ?? 'N/A' }}
            </p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>SKU</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->product_sku }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">₹{{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="text-right">₹{{ number_format((float) $item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="row"><span>Subtotal</span><span>₹{{ number_format((float) $order->subtotal, 2) }}</span></div>
        @if((float) $order->discount > 0)
            <div class="row"><span>Discount</span><span>-₹{{ number_format((float) $order->discount, 2) }}</span></div>
        @endif
        <div class="row"><span>Taxable Value</span><span>₹{{ number_format($taxableValue, 2) }}</span></div>
        <div class="row"><span>CGST ({{ number_format($gstRate / 2, 1) }}%)</span><span>₹{{ number_format($cgst, 2) }}</span></div>
        <div class="row"><span>SGST ({{ number_format($gstRate / 2, 1) }}%)</span><span>₹{{ number_format($sgst, 2) }}</span></div>
        @if((float) $order->shipping_charge > 0)
            <div class="row"><span>Shipping</span><span>₹{{ number_format((float) $order->shipping_charge, 2) }}</span></div>
        @endif
        <div class="row grand"><span>Grand Total</span><span>₹{{ number_format((float) $order->total, 2) }}</span></div>
    </div>

    <div class="gst-note">
        This is a computer-generated GST tax invoice. GST is included in the item prices where applicable
        (assumed inclusive rate: {{ number_format($gstRate, 0) }}%).
        @if(!empty($settings['gst_number']))
            Supplier GSTIN: {{ $settings['gst_number'] }}.
        @endif
    </div>
</div>
</body>
</html>
