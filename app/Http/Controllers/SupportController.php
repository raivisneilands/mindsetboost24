<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function showForm()
    {
        return view('support.form');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        // Send email
        Mail::raw("Support request from {$request->name} ({$request->email}):\n\n{$request->message}", function ($mail) use ($request) {
            $mail->to('support@mindsetboost24.com')
                 ->subject('New Support Request');
        });

        return redirect()->route('support.form')->with('success', 'Your message has been sent! We’ll reply soon.');
    }
}
