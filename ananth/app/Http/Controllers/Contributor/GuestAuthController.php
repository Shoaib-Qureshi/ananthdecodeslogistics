<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->user_role === 'guest' && Auth::user()->status === 'approved') {
            return redirect('/dashboard');
        }
        return view('contributor.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->user_role !== 'guest') {
                Auth::logout();
                return back()->with('error', 'This login is for contributors only.');
            }

            if ($user->status === 'pending') {
                Auth::logout();
                return back()->with('error', 'Your account is pending admin approval. Please wait for the approval email.');
            }

            if ($user->status === 'rejected') {
                Auth::logout();
                return back()->with('error', 'Your application was not approved. Please contact us for more information.');
            }

            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/contributor-login')->with('success', 'You have been logged out.');
    }
}
