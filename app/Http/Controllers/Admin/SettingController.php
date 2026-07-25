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
            'whatsapp_number' => 'nullable|string|max:20',
            'address' => 'required|string',
            'gst_number' => 'nullable|string|max:20',
            'gst_rate' => 'nullable|numeric|min:0|max:28',
            'upi_id' => 'required|string',
            'bank_name' => 'required|string',
            'bank_account_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_ifsc_code' => 'required|string',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'shipping_charge' => 'required|numeric|min:0',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('qr_code')) {
            $oldQrPath = Setting::where('key', 'qr_code_path')->value('value');
            if ($oldQrPath && Storage::disk('public')->exists($oldQrPath)) {
                Storage::disk('public')->delete($oldQrPath);
            }

            $path = $request->file('qr_code')->store('settings/qr-codes', 'public');
            Setting::updateOrCreate(['key' => 'qr_code_path'], ['value' => $path]);
        }

        $textFields = [
            'site_name', 'contact_email', 'contact_phone', 'whatsapp_number', 'address',
            'gst_number', 'gst_rate',
            'upi_id', 'bank_name', 'bank_account_name', 'bank_account_number',
            'bank_ifsc_code', 'free_shipping_threshold', 'shipping_charge',
            'meta_description', 'meta_keywords',
        ];

        foreach ($textFields as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $request->$key]);
            }
        }

        return redirect()->back()->with('success', 'Settings saved!');
    }
}
