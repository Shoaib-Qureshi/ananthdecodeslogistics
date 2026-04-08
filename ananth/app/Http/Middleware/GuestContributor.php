<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestContributor
{
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() &&
            Auth::user()->user_role === 'guest' &&
            Auth::user()->status === 'approved'
        ) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->user_role === 'guest' && Auth::user()->status !== 'approved') {
            Auth::logout();
            return redirect()->route('contributor.login')->with('error', 'Your account is pending approval or has been rejected.');
        }

        return redirect()->route('contributor.login')->with('error', 'Please log in to access your dashboard.');
    }
}
