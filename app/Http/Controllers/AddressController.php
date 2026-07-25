<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
        ]);

        Address::where('user_id', Auth::id())->update([
            'is_default' => 0,
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'full_name' => $request->name,
            'phone' => $request->phone,
            'address_line1' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'is_default' => $request->default,
        ]);

        return redirect()->back()->with('success', 'Address added successfully!');
    }

    public function update(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        Address::where('user_id', Auth::id())->update([
            'is_default' => 0,
        ]);
        
        $address->update(['is_default' => 1]);
        return redirect()->back()->with('success', 'Address updated!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        return redirect()->back()->with('success', 'Address deleted!');
    }
}
