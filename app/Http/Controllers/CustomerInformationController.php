<?php

namespace App\Http\Controllers;

use App\Mail\CustomerInformationMail;
use App\Models\CustomerInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomerInformationController extends Controller
{
    //send email
    public function create(Request $request)
    {
        $request->validate([
            'name'           => 'required|string',
            'email'          => 'required|email',
            'phone'          => 'required|integer',
            'year'           => 'required|integer',
            'make'           => 'required|string',
            'model'          => 'required|string',
            'vin'            => 'nullable|string',
            'license_plate'  => 'nullable|string',
            'kilometres'     => 'nullable|integer',
            'asset_number'   => 'nullable|integer',
            'complaint'      => 'required|string',
        ]);
        $customer_info = CustomerInformation::create($request->all());
        Mail::to('sebgallant@hotmail.com')->cc('hatrickzach@gmail.com')->send(new CustomerInformationMail($customer_info));
        return redirect()->route('main');
    }
    public function mailExample()
    {
        $data = CustomerInformation::where('id', 1)->first();
        return new CustomerInformationMail($data);
    }
    public function complaints() {
        $submissions = CustomerInformation::get()->all();
        return view('complaint_list', ['submissions' => $submissions]);
    }
}
