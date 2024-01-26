<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassRequest;
use App\Http\Requests\LoginRequest;
use App\Jobs\SendForgotPasswordEmailJob;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function index()
    {
        return view('auth.forgotPassword', [
            'title' => 'Forgot Password',
        ]);
    }

    public function postForgetPassword(ForgotPassRequest $request)
    {

        try {
            $this->authService->forgetPassword($request);
            return view('auth.newPassword', ['title' => 'Reset Password'], compact('token'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->to(route('forgotPassword'));
        }

        Session::flash('success', 'We have sent an email to reset your password');
        return redirect()->to(route('forgot_password'));
    }



    public function resetPassword($token)
    {
        try {
            $this->authService->resetPassword($token);
            return view('auth.newPassword', ['title' => 'Reset Password'], compact('token'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->to(route('forgotPassword'));
        }
    }



    public function postResetPassword(LoginRequest $request)
    {

        try {
            $this->authService->postResetPassword(
                $request->email,
                $request->token,
                $request->password,
                $request->confirmPassword
            );
    
            Session::flash('success', 'Password reset successfully');
            return redirect()->to(route('login'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
