<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    function index()
    {
        if(Auth::check()){
            return redirect()->route('leads')->withSuccess('You have successfully logged in!');
        }else{
        return view('auth.login');
        }
    }

    function login(Request $request): RedirectResponse
    {   
        $credentials = $request->validate([
            'email'     => ['required'],
            'password'  => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('email', $request->email);
            $request->session()->put('password', $request->password);
            $request->session()->put('token', $request->password);
            return redirect()->route('leads')->withSuccess('You have successfully logged in!');
        }
        return back()->withError('The provided credentials do not match our records.')->onlyInput('email');
    }

    function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
