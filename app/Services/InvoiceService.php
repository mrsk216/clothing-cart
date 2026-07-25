<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class InvoiceService
{
    public function buildData(Order $order): array
    {
        $order->loadMissing('items', 'user');

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $gstRate = (float) ($settings['gst_rate'] ?? config('app.gst_rate', 18));

        $taxable = (float) $order->subtotal - (float) $order->discount;
        $gstAmount = (float) $order->tax > 0
            ? (float) $order->tax
            : round($taxable * $gstRate / (100 + $gstRate), 2);
        $taxableValue = (float) $order->tax > 0
            ? $taxable
            : round($taxable - $gstAmount, 2);

        return [
            'order' => $order,
            'settings' => $settings,
            'gstRate' => $gstRate,
            'taxableValue' => $taxableValue,
            'gstAmount' => $gstAmount,
            'cgst' => round($gstAmount / 2, 2),
            'sgst' => round($gstAmount / 2, 2),
        ];
    }

    public function pdf(Order $order)
    {
        $data = $this->buildData($order);

        return Pdf::loadView('pages.invoice-pdf', $data)
            ->setPaper('a4');
    }

    public function output(Order $order): string
    {
        return $this->pdf($order)->output();
    }

    public function html(Order $order): string
    {
        return View::make('pages.invoice-pdf', $this->buildData($order))->render();
    }
}
