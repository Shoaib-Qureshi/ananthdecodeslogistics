<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Mail\NewRegistrationAdminNotification;
use App\Mail\ContributorApproved;
use App\Mail\ContributorRejected;
use Illuminate\Support\Facades\Mail;

class ContributorRegistrationController extends Controller
{
    public function showForm()
    {
        return view('contributor.register');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email',
            'designation'        => 'required|string|max:255',
            'intro'              => 'required|string|max:1000',
            'reason_for_joining' => 'required|string|max:2000',
        ]);

        $user = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => bcrypt(\Illuminate\Support\Str::random(32)),
            'user_role'          => 'guest',
            'status'             => 'pending',
            'designation'        => $request->designation,
            'intro'              => $request->intro,
            'reason_for_joining' => $request->reason_for_joining,
        ]);

        // Notify admin
        try {
            $adminEmail = config('mail.admin_email', 'admin@ananthdecodeslogistics.com');
            Mail::to($adminEmail)->send(new NewRegistrationAdminNotification($user));
        } catch (\Exception $e) {
            // Mail failure should not block the user-facing flow
        }

        return back()->with('success', 'Your application is under review. You will receive an email once your account is approved.');
    }

    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        // Send password reset link so the guest sets their own password
        $status = Password::sendResetLink(['email' => $user->email]);

        try {
            Mail::to($user->email)->send(new ContributorApproved($user));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "Contributor {$user->name} approved. Password reset email sent.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'required|string|max:1000']);

        $user = User::findOrFail($id);
        $user->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        try {
            Mail::to($user->email)->send(new ContributorRejected($user));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "Contributor {$user->name} rejected.");
    }
}
