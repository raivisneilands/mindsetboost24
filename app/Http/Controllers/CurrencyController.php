<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function set(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|in:EUR,USD,GBP,CAD,AUD',
        ]);

        session(['currency' => $request->currency]);

        return redirect()->back(); // go back to previous page
    }
}
