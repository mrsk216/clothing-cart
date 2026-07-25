<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'address' => 'required|string',
            'upi_id' => 'required|string',
            'bank_name' => 'required|string',
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_ifsc_code' => 'required|string',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'shipping_charge' => 'required|numeric|min:0',
            'qr_code' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle QR code upload
        if ($request->hasFile('qr_code')) {
            // Delete old QR code if exists
            $oldQrPath = Setting::where('key', 'qr_code_path')->value('value');
            if ($oldQrPath && Storage::disk('public')->exists($oldQrPath)) {
                Storage::disk('public')->delete($oldQrPath);
            }

            $path = $request->file('qr_code')->store('settings/qr-codes', 'public');
            Setting::updateOrCreate(['key' => 'qr_code_path'], ['value' => $path]);
        }

        // Save all text fields
        $textFields = [
            'site_name', 'contact_email', 'contact_phone', 'address',
            'upi_id', 'bank_name', 'bank_account_name', 'bank_account_number',
            'bank_ifsc_code', 'free_shipping_threshold', 'shipping_charge',
        ];

        foreach ($textFields as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
            }
        }

        return redirect()->back()->with('success', 'Settings saved!');
    }
}
