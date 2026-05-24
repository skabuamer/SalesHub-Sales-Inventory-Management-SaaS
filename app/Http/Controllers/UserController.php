<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class UserController extends Controller
{
    // pages route methods
    function loginPage()
    {
        return Inertia::render('LoginPage');
    }
    function registerPage()
    {
        return Inertia::render('RegisterPage');
    }
    function forgotPasswordPage()
    {
        return Inertia::render('ForgotPasswordPage');
    }
    function verifyOtpPage()
    {
        return Inertia::render('VerifyOtpPage');
    }
    function resetPasswordPage()
    {
        return Inertia::render('ResetPasswordPage');
    }

    // api route methods
    function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            $token = JWTToken::CreateToken($request->input('email'), $user->id);

            return redirect()->route('dashboard')->with([
                'status' => 'success',
                'message' => 'User registered successfully',
                "error" => "",
            ])->cookie('token', $token, 60 * 24 * 30);
        } catch (Exception $e) {

            return redirect()->route('registerPage')->with([
                'status' => 'fail',
                'message' => "Something went wrong",
                "error" => "",
            ]);
        }
    }

    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if ($user && Hash::check($request->password, $user->password)) {
            $token = JWTToken::CreateToken($request->input('email'), $user->id);

            $data = [
                'status' => 'true',
                'message' => 'User logged in successfully',
                "error" => "",
            ];
            return redirect()->route('dashboard')->with($data)->cookie('token', $token, 60 * 24 * 30);
        } else {
            $data = [
                'status' => 'false',
                'message' => 'Login Failed',
                "error" => "Wrong Email or Password",
            ];
            return redirect()->route('loginPage')->with($data);
        }
    }

    function dashboard(Request $request)
    {
        $user = $request->headers->get('email');

        $userData = User::where('email', $user)->select('name')->first();
        return Inertia::render('Dashboard', [
            'user' => $userData,
        ]);
    }

    function logout(Request $request)
    {
        $data = [
            'status' => 'true',
            'message' => 'User logged out successfully',
            "error" => "",
        ];
        return redirect()->route('loginPage')->with($data)->cookie('token', '', -1);
    }

    function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->input('email');
        $otp = rand(1000, 9999);

        $count = User::where('email', $email)->count();

        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', $email)->update([
                'otp' => $otp
            ]);
            $request->session()->put('email', $email);
            return redirect()->route('user.verifyOtp')->with([
                'status' => 'success',
                'message' => 'OTP sent successfully',
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'fail',
                'error' => 'Provided Email is not registered! Please register first. '
            ]);
        }
    }

    function verifyOtp(Request $request)
    {
        // $email = $request->input('email');
        $request->validate([
            'otp' => 'required',
        ]);
        $email = $request->session()->get('email');
        $otp = $request->input('otp');

        $count = User::where('email', $email)->where('otp', $otp)->count();

        if ($count == 1) {
            User::where('email', $email)->update([
                'otp' => 0
            ]);
            // $token = JWTToken::CreateTokenForSetPass($email);

            $request->session()->put('otp_verified', 'yes');

            return redirect()->route('resetPasswordPage')->with([
                'status' => 'success',
                'message' => 'OTP verified successfully',
                'error' => ''
            ]);
        } else {
            return back()->with([
                'status' => 'failed',
                'error' => 'OTP is invalid',
            ]);
        }
    }

    function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        try {
            $mail = $request->session()->get('email');
            $password = $request->input('password');

            $otpVerified = $request->session()->get('otp_verified');

            if ($otpVerified === 'yes') {
                User::where('email', $mail)->update([
                    'password' => Hash::make($password)
                ]);
                $request->session()->forget('otp_verified');
                return redirect()->route('loginPage')->with([
                    'status' => 'success',
                    'message' => 'Password reset successfully',
                    'error' => ''
                ]);
            } else {
                return redirect()->route('forgotPassword')->with([
                    'status' => 'fail',
                    'message' => 'Something went wrong',
                    'error' => ''
                ]);
            }
        } catch (Exception $e) {
            return redirect()->route('resetPasswordPage')->with([
                'status' => 'failed',
                'message' => 'Something went wrong',
                'error' => ''
            ]);
        }
    }

    function profile(Request $request)
    {
        $user_id = $request->header('userId');
        $user = User::where('id', $user_id)->first();
        return Inertia::render('profile', [
            'user' => $user,
        ]);
    }

    function updateProfile(Request $request)
    {
        $user_id = $request->header('userId');

        User::where('id', $user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with([
            'status' => 'success',
            'message' => 'Profile updated successfully',
        ]);
    }
}
