<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterUser extends Controller
{


    public function create()
    {
        // if (Auth::check()) {
        //     return redirect('/');
        // }

        return view('auth.signup');
    }


    public function store(Request $request)
    {
        // dump($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string'], 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 'password' => 'required|confirmed|min:6',
        ]);
        $user = User::create($validated);

        event(new Registered($user));
        Auth::login($user);

        return view('auth.verify-email')->with('status', 'We have sent you a verification email!');;
    }



    public function showEmailVerification()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/');
    }

    public function verifyNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}
