<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\RegistrationSuccessEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function index()
    {
        return view('admin.pages.register', [
            'title' => 'Register',
        ]);
    }

    public function store(RegisterRequest $request)
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


        $user->save();


        Session::flash('success', 'Register new user successfully');
        Mail::to($user->email)->send(new RegistrationSuccessEmail($user));
        return redirect()->route('login');
    }
}
