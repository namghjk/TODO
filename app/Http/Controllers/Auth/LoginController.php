<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function store(LoginRequest $request)
    {
        try {
            $user = $this->authService->login($request);
            return redirect()->route('posts.index')->with('user', $user);
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
