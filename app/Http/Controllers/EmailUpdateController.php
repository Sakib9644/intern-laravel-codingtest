<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmailUpdateController extends Controller
{
    /**
     * Show the email update form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(): View
    {
        return view('email-update');
    }

    /**
     * Update the user's email address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Validate the email address
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Ignore the current user's email
            ],
        ]);

        // Update the user's email address
        if ($user) {
            $user->email = $request->input('email');
            $user->email_verified_at = null; // Reset email verification status if email is changed
           
        } else {
            // Handle the case where the user is not found
            return redirect()->route('profile.email.edit')->with('error', 'User not found');
        }

        return redirect()->route('profile.email.edit')->with('status', 'Email updated successfully');
    }
}
