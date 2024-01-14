<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return redirect()->route('auth.create')->with('error', 'Functionality disabled by the administrator');
    }

    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('home.index');
        }

        return view('auth.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('login', 'password');
        $remember = $request->filled('remember');

        if(Auth::attempt($credentials, $remember)) {
            return redirect()->intended('/');
        } else {
            return redirect()->back()->with('login_error', 'Invalid credentials');
        }
    }

    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
