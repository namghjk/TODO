<?php

namespace App\Services\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendForgotPasswordEmailJob;
use App\Mail\RegistrationSuccessEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AuthService
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $user;
        }


        throw new \Exception('Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function register(RegisterRequest $request)
    {
        if ($request->confirmPassword != $request->password) {
            Session::flash('error', 'Password does not match');
            return redirect()->back()->withInput();
        }
        $user = new User([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'address' => $request['address'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->assignRole('user');
        $user->save();
       
        return $user;
    }

    public function forgetPassword(ForgotPassRequest $request)
    {
        $token = Str::random(64);

        $existingRequest = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if ($existingRequest) {
            Session::flash('error', 'A password reset request has already been sent for this email address.');
            return redirect()->to(route('forgot_password'));
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        dispatch(new SendForgotPasswordEmailJob($request->email, $token));
    }

    public function resetPassword($token)
    {
        $resetRequest = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (!$resetRequest) {
            // Yêu cầu reset không tồn tại
            throw new \Exception('Invalid reset link');
        }

        $expirationTime = 60 * 60; // Thời gian hết hạn: 1 giờ
        $createdAt = Carbon::parse($resetRequest->created_at);
        $currentTime = Carbon::now();

        if ($currentTime->diffInSeconds($createdAt) > $expirationTime) {
            // Liên kết reset đã hết hạn
            throw new \Exception('The reset link has expired');
        }
    }

    public function postResetPassword($email, $token, $password, $confirmPassword)
    {
        if ($password != $confirmPassword) {
            throw new \Exception('Password does not match');
        }

        $updatePassword = DB::table('password_resets')->where([
            'email' => $email,
            'token' => $token,
        ])->first();

        if (!$updatePassword) {
            throw new \Exception('Invalid reset link');
        }

        DB::table('users')->where('email', $email)->update(['password' => Hash::make($password)]);

        DB::table('password_resets')->where('email', $email)->delete();
    }
}
