<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Handle the contact form submission logic (e.g., send an email, save to database, etc.)
        // For now, we will just return a success response
        return response()->json(['success' => true, 'message' => 'Thank you for contacting us!']);
    }
}
