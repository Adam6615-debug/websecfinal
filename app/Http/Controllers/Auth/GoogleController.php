<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Check if user exists
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        return redirect()->route('login')->withErrors([
            'email' => 'No account found with this email. Please sign up.',
        ]);
    }

    // User exists, log them in
    Auth::login($user);

    return redirect('/'); // or wherever you'd like
}

}
