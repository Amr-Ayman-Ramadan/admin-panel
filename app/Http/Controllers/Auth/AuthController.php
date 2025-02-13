<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Mail\PasswordResetMail;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function loginPage()
    {
        return view('Pages.Auth.login');
    }
    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            toast("Login Success", "success");
            return redirect()->intended('/');
        }
        toast("Credenciales incorrectas", "error");
        return  back();
    }

    public function forgetPasswordPage()
    {
        return view('Pages.Auth.forgetPassword');
    }
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $user = Admin::where("email", $request->get('email'))->first();

        if (!$user) {
            toast("Email no found", "error");
            return back();
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $url = route('auth.reset-password-form', ['token' => $token, 'email' => $user->email]);
        Mail::to($user->email)->send(new PasswordResetMail($url));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetPasswordForm($token)
    {
        return view('Pages.Auth.resetPassword', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $passwordReset = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('auth.loginPage')->with('success', 'Your password has been reset successfully.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        toast("Logout Success", "success");
        return to_route('auth.loginPage');
    }
}
