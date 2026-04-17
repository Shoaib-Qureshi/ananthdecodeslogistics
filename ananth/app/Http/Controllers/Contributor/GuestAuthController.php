<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->user_role === 'guest' && Auth::user()->status === 'approved') {
            return redirect()->route('dashboard');
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
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('contributor.login')->with('success', 'You have been logged out.');
    }

    public function showSetPassword(Request $request)
    {
        $userId = $request->session()->get('new_contributor_user_id');

        if (!$userId) {
            return redirect()->route('contributor.login')
                ->with('info', 'Please log in, or use the password reset link sent to your email.');
        }

        $user = User::find($userId);

        if (!$user) {
            $request->session()->forget('new_contributor_user_id');
            return redirect()->route('contributor.login');
        }

        return view('contributor.set-password', ['user' => $user]);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userId = $request->session()->get('new_contributor_user_id');

        if (!$userId) {
            return redirect()->route('contributor.login')
                ->with('error', 'Session expired. Please use the password reset link or contact support.');
        }

        $user = User::findOrFail($userId);
        $user->password = bcrypt($request->password);
        $user->save();

        $request->session()->forget('new_contributor_user_id');

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Welcome! Your password has been set and you are now logged in.');
    }

    public function redirectToGoogle(Request $request)
    {
        $request->session()->put('google_oauth_flow', 'contributor');

        $googleUrl = 'https://accounts.google.com/o/oauth2/v2/auth?';
        $params = http_build_query([
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'redirect_uri'  => env('GOOGLE_REDIRECT_URI'),
            'response_type' => 'code',
            'scope'         => 'email profile',
            'access_type'   => 'offline',
        ]);

        return redirect($googleUrl . $params);
    }
}
