<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassRequest;
use App\Http\Requests\LoginRequest;
use App\Jobs\SendForgotPasswordEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('Admin.pages.auth.forgotPassword', [
            'title' => 'Forgot Password',
        ]);
    }

    public function postForgetPassword(ForgotPassRequest $request)
    {

        $token = Str::random(64);

        $existingRequest = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if ($existingRequest) {
            Session::flash('error', 'A password reset request has already been sent for this email address.');
            return redirect()->to(route('forgotPassword'));
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        dispatch(new SendForgotPasswordEmailJob($request->email, $token));

        Session::flash('success', 'We have sent an email to reset your password');
        return redirect()->to(route('forgotPassword'));
    }



    public function resetPassword($token)
    {
        $resetRequest = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (!$resetRequest) {
            // Yêu cầu reset không tồn tại
            Session::flash('error', 'Invalid reset link');
            return redirect()->to(route('forgotPassword'));
        }

        $expirationTime = 60 * 60; // Thời gian hết hạn: 1 giờ
        $createdAt = Carbon::parse($resetRequest->created_at);
        $currentTime = Carbon::now();

        if ($currentTime->diffInSeconds($createdAt) > $expirationTime) {
            // Liên kết reset đã hết hạn
            Session::flash('error', 'The reset link has expired');
            return redirect()->to(route('forgotPassword'));
        }
        return view('Admin.pages.newPassword', ['title' => 'Reset Password'], compact('token'));
    }



    public function postResetPassword(LoginRequest $request)
    {

        if ($request->confirmPassword != $request->password) {
            Session::flash('error', 'Password does not match');
            return redirect()->back()->withInput();
        }
        
        $updatePassword = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if (!$updatePassword) {
            Session::flash('error', 'Invalid reset link');
            redirect()->to(route('resetPassword'));
        }

        User::where("email", $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();
        Session::flash('success', 'Password reset successfully');
        return redirect()->to(route('login'));
    }
}
