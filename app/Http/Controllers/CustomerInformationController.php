<?php

namespace App\Http\Controllers;

use App\Models\CustomerInformation;
use Illuminate\Http\Request;

class CustomerInformationController extends Controller
{
    //send email
    public function create(Request $request)
    {
        $request->validate([
            'name'    => 'required|string',
            'date'    => 'required|date',
            'email'    => 'required|email',
            'cell_phone'    => 'integer',
            'home_phone'    => 'integer',
            'year'    => 'required|integer',
            'make'    => 'required|string',
            'model'    => 'required|string',
            'vin'    => 'required|string',
            'license_plate'    => 'required|string',
            'kilometres'    => 'required|integer',
            'asset_number'    => 'required|integer',
            'complaint'    => 'required|string',
        ]);
        $customer_info = CustomerInformation::create($request->all());
        return redirect()->route('main');
    }
}
