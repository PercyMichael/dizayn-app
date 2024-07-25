<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.signin');
    }




    public function store(Request $request)
    {
        // dump($request->all());
        $validated = $request->validate(['email' => ['required'], 'password' => ['required']]);

        # code...
        if (!Auth::attempt($validated)) {
            throw ValidationException::withMessages(['invalid' => 'Sorry, invalid credentials']);
        }

        $request->session()->regenerate();
        $user = Auth::user();


        return redirect('/')->with('welcome', 'Welcome back, ' . ucfirst($user->name) . '.');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/signin')->with('status', 'You have successfully signed out of your account.');
    }
}
