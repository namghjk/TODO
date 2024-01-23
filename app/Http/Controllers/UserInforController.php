<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserInforController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('Admin.pages.userInfor', [
            'title' => 'User Infor',
        ])->with('user', $user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'first_name' => $request['first_name'],
            'last_name' =>  $request['last_name'],
            'address' =>  $request['address'],
        ]);
        Session::flash('success', 'Update User successfully');
        return redirect(route('updateUserInfor', $user->id));
    }
}
