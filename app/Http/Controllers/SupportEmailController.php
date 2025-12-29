<?php

namespace App\Http\Controllers;

use App\Models\Supporemail;
use Illuminate\Http\Request;
use App\Models\SupportEmail;

class SupportEmailController extends Controller
{
    public function supportemail(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'messages'   => 'required|string',
        ]);

        Supporemail::create($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'messages'
        ]));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
