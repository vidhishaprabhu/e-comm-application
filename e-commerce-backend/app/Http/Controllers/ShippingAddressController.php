<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;

class ShippingAddressController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone' => 'required',
            'sameAsShipping' => 'required|boolean'
        ]);

        $validated['user_id'] = $request->user()->id;

        ShippingAddress::create($validated);

        return response()->json(['message' => 'Shipping address saved'], 200);
    }
}
