<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;
use App\Models\VerifyUser;
use App\Models\User;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    public function userSignup()
    {
        if (Auth::check()) {
            return redirect()->intended(('dashboard/'));
        }
        return view('auth.signup');
    }

    function uniqueUsername($baseUsername)
    {
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    public function saveSignup(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $baseUsername = Str::slug($request->input('name'));
        $uniqueUsername = $this->uniqueUsername($baseUsername);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $uniqueUsername;
        $user->password = Hash::make($request['password']);
        $user->save();

        VerifyUser::create([
            'token' => Str::random(60),
            'user_id' => $user->id,
        ]);

        Mail::to($user->email)->send(new VerifyEmail($user));
         
        return redirect("login")->with('message', 'Account created, please verify your email.');
    }

    public function verifyEmail($token)
    {
        $verifiedUser = VerifyUser::where('token', $token)->first();
            if (isset($verifiedUser)) {
                $user = $verifiedUser->user;
                if (!$user->email_verified_at) {
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                    return redirect("login")->with('message', 'Your email has been verified, please login!');
                } else {
                    return redirect("login")->with('message', 'Your email has already been verified, please login!');
                }
            } else {
                // return redirect("login")->with('message', 'Something went wrong!!');
                return redirect('login')->withErrors(['Something went wrong!']);
        }
    }

    public function userLogin()
    {
        if (Auth::check()) {
            return redirect()->intended(('dashboard/'));
        }
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);        
        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            
            if (Auth::user()->email_verified_at == null) {
                Auth::logout();
                return redirect('login')->withErrors(['Please verify your email to continue!']);
            }
            return redirect()->intended(('dashboard/'));
        }else{
            return redirect('login')->withErrors(['Username or Password is incorrect.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('login')->with('message', 'Successfully logged out!');
    }

    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'Password reset link sent on your registered email address!');
    }
    
    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }
    
    
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')->where([['email', $request->email], ['token', $request->token]])->first();

        if(!$updatePassword){
            return redirect()->back()->withErrors(['Invalid token!']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->email_verified_at = Carbon::now();
        $user->save();

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('message', 'Password changed, please login with new password!');
    }

    public function redirectToGoogle()
    {
        $googleUrl = 'https://accounts.google.com/o/oauth2/v2/auth?';
        $params = http_build_query([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'offline',
        ]);

        return redirect($googleUrl . $params);
    }

    public function handleGoogleCallback(Request $request)
    {
        $code = $request->input('code');
        
        if ($code) {
            $client = new Client();
            
            // Exchange code for access token
            $response = $client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $accessToken = $data['access_token'];
            
            // Get the user information
            $googleUser = $client->get('https://www.googleapis.com/oauth2/v1/userinfo?alt=json', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            $googleUserInfo = json_decode($googleUser->getBody(), true);

            // Handle contributor Google login flow
            if (session('google_oauth_flow') === 'contributor') {
                session()->forget('google_oauth_flow');

                $user = User::where('email', $googleUserInfo['email'])->where('user_role', 'guest')->first();

                if (!$user) {
                    return redirect()->route('contributor.register')
                        ->with('info', 'No Expert Desk account found for this Google account. Please apply first.');
                }

                if ($user->status === 'pending') {
                    return redirect()->route('contributor.login')
                        ->with('error', 'Your application is pending admin approval. Please wait for the approval email.');
                }

                if ($user->status === 'rejected') {
                    return redirect()->route('contributor.login')
                        ->with('error', 'Your application was not approved. Please contact us for more information.');
                }

                Auth::login($user);
                return redirect()->route('dashboard');
            }

            // Check if user exists in your database
            $user = User::where('email', $googleUserInfo['email'])->first();

            if ($user) {
                Auth::login($user);
            } else {
                // Register the user if they don’t exist

                $baseUsername = Str::slug($googleUserInfo['name']);
                $uniqueUsername = $this->uniqueUsername($baseUsername);

                $user = new User();
                $user->name = $googleUserInfo['name'];
                $user->email = $googleUserInfo['email'];
                $user->username = $uniqueUsername;
                $user->password = ''; // No password since using Google login
                $user->email_verified_at = Carbon::now();
                $user->save();

                Auth::login($user);
            }

            return redirect()->intended('dashboard');
        } else {
            return redirect('login')->withErrors('Something went wrong, please try again.');
        }
    }
}

