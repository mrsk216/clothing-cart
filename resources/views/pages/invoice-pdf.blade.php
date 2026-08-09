<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GST Invoice - {{ $order->invoice_number }}</title>
    <style>
        body { font-family: Helvetica, Arial, sans-serif; color: #1a1a1a; font-size: 12px; }
        .title { font-size: 20px; color: #1a365d; font-weight: bold; margin: 0 0 4px 0; }
        .subtitle { font-size: 16px; color: #1a365d; font-weight: bold; margin: 0; }
        .muted { color: #555; font-size: 11px; line-height: 1.5; }
        .section { margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1a365d; color: #fff; text-align: left; padding: 8px; font-size: 11px; }
        td { padding: 8px; border-bottom: 1px solid #e5e5e5; vertical-align: top; }
        .text-right { text-align: right; }
        .totals td { border: none; padding: 4px 8px; }
        .grand td { border-top: 2px solid #1a365d; font-weight: bold; font-size: 14px; color: #1a365d; padding-top: 8px; }
        .note { margin-top: 18px; padding: 10px; background: #f8fafc; border: 1px solid #e2e8f0; font-size: 10px; color: #475569; }
        .header-line { border-bottom: 2px solid #1a365d; padding-bottom: 12px; margin-bottom: 16px; }
        .label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 4px; }
    </style>
</head>
<body>
    <table class="header-line section">
        <tr>
            <td width="60%">
                <p class="title">{{ $settings['site_name'] ?? 'Clothing Cart' }}</p>
                <p class="muted">
                    {{ $settings['address'] ?? '' }}<br>
                    Phone: {{ $settings['contact_phone'] ?? '' }}<br>
                    Email: {{ $settings['contact_email'] ?? '' }}<br>
                    @if(!empty($settings['gst_number']))
                        GSTIN: {{ $settings['gst_number'] }}
                    @endif
                </p>
            </td>
            <td width="40%" class="text-right">
                <p class="subtitle">TAX INVOICE</p>
                <p class="muted">
                    <strong>Invoice No:</strong> {{ $order->invoice_number }}<br>
                    <strong>Order No:</strong> {{ $order->order_number }}<br>
                    <strong>Date:</strong> {{ optional($order->paid_at)->format('d M Y') ?? $order->created_at->format('d M Y') }}
                </p>
            </td>
        </tr>
    </table>

    <table class="section">
        <tr>
            <td width="50%">
                <div class="label">Bill To</div>
                <strong>{{ $order->shipping_name ?? $order->user?->name }}</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}<br>
                Phone: {{ $order->shipping_phone }}<br>
                Email: {{ $order->user?->email }}
            </td>
            <td width="50%">
                <div class="label">Payment Details</div>
                Status: Paid<br>
                Method: {{ ucwords(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}<br>
                Paid At: {{ optional($order->paid_at)->format('d M Y, h:i A') ?? 'N/A' }}
            </td>
        </tr>
    </table>

    <table class="section">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="35%">Item</th>
                <th width="15%">SKU</th>
                <th width="10%" class="text-right">Qty</th>
                <th width="15%" class="text-right">Rate</th>
                <th width="20%" class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->product_sku }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rs. {{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="text-right">Rs. {{ number_format((float) $item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals" width="40%" align="right">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">Rs. {{ number_format((float) $order->subtotal, 2) }}</td>
        </tr>
        @if((float) $order->discount > 0)
            <tr>
                <td>Discount</td>
                <td class="text-right">-Rs. {{ number_format((float) $order->discount, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td>Taxable Value</td>
            <td class="text-right">Rs. {{ number_format($taxableValue, 2) }}</td>
        </tr>
        <tr>
            <td>CGST ({{ number_format($gstRate / 2, 1) }}%)</td>
            <td class="text-right">Rs. {{ number_format($cgst, 2) }}</td>
        </tr>
        <tr>
            <td>SGST ({{ number_format($gstRate / 2, 1) }}%)</td>
            <td class="text-right">Rs. {{ number_format($sgst, 2) }}</td>
        </tr>
        @if((float) $order->shipping_charge > 0)
            <tr>
                <td>Shipping</td>
                <td class="text-right">Rs. {{ number_format((float) $order->shipping_charge, 2) }}</td>
            </tr>
        @endif
        <tr class="grand">
            <td>Grand Total</td>
            <td class="text-right">Rs. {{ number_format((float) $order->total, 2) }}</td>
        </tr>
    </table>

    <div class="note">
        This is a computer-generated GST tax invoice. GST is included in the item prices where applicable
        (assumed inclusive rate: {{ number_format($gstRate, 0) }}%).
        @if(!empty($settings['gst_number']))
            Supplier GSTIN: {{ $settings['gst_number'] }}.
        @endif
    </div>
</body>
</html>
