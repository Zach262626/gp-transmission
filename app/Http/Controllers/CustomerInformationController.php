<?php

namespace App\Http\Controllers;

use App\Mail\CustomerInformationMail;
use App\Models\CustomerInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomerInformationController extends Controller
{
    // send email
    public function create(Request $request)
    {
        // Honeypot: the "website" field is hidden from real users via CSS. If it has a
        // value, the submission is from a bot — silently pretend success without saving
        // or emailing, so the bot can't tell it was rejected.
        if ($request->filled('website')) {
            return redirect()->route('main')->with('success', 'Thank you! Your information has been submitted successfully.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:20',
            'year' => 'required|integer|min:1900|max:2099',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'vin' => 'nullable|string|max:17',
            'license_plate' => 'nullable|string|max:10',
            'kilometres' => 'nullable|integer|min:0',
            'asset_number' => 'nullable|string|max:50',
            'preferred_date' => 'nullable|date|after_or_equal:today',
            'preferred_time' => 'nullable|string|in:Morning,Afternoon',
            'complaint' => 'required|string|min:10|max:5000',
        ]);

        // Persist only validated fields (avoids mass-assigning arbitrary request input).
        $customer_info = CustomerInformation::create($validated);

        try {
            Mail::to(env('ADMIN_EMAIL', 'sebgallant@hotmail.com'))
                ->cc(env('ADMIN_CC_EMAIL', 'hatrickzach@gmail.com'))
                ->send(new CustomerInformationMail($customer_info));

            return redirect()->route('main')->with('success', 'Thank you! Your information has been submitted successfully.');
        } catch (\Exception $e) {
            \Log::error('Customer information email failed: '.$e->getMessage());

            return redirect()->back()->with('warning', 'Form submitted successfully, but confirmation email could not be sent.');
        }
    }

    public function mailExample()
    {
        $data = CustomerInformation::where('id', 1)->first();

        return new CustomerInformationMail($data);
    }

    public function complaints()
    {
        $submissions = CustomerInformation::get()->sortBy('created_at')->all();

        return view('complaint_list', ['submissions' => array_reverse($submissions, true)]);
    }
}
