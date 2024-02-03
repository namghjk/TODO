<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendNotificationRegister;
use App\Mail\RegistrationSuccessEmail;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function index()
    {
        return view('auth.register', [
            'title' => 'Register',
        ]);
    }

    public function store(RegisterRequest $request)
    {
        try {

            $user = $this->authService->register($request);
            dispatch(new SendNotificationRegister($user));
            redirect()->to(route('login'))->with('success', 'Register new user successfully');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
