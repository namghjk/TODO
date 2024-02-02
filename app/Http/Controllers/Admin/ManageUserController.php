<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManageUserController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(404);
        }
        $manage_users = User::paginate(5);
        return view('admin.pages.user.index', compact('manage_users'), ['title' => 'Show all users']);
    }


    public function edit(User $manage_user)
    {
        return view('admin.pages.user.edit', compact('manage_user'), ['title' => 'Edit user']);
    }

    public function update(UpdateUserRequest $request, User $manage_user)
    {

        $manage_user->update([
            'first_name' => $request['first_name'],
            'last_name' =>  $request['last_name'],
            'address' =>  $request['address'],
            'status' => $request['status'],
        ]);
        
        Session::flash('success', 'Update User successfully');
        return redirect()->to(route('manage-user.index'));
    }

    public function search(Request $request){
        $search = $request->input('search');
        $manage_users = User::paginate(2);
        if ($search !== null) {
            $manage_users = User::where(function ($query) use ($search) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%$search%'")
                    ->orWhere('email', 'like', "%$search%");
            })->paginate(5);
            return view('admin.pages.user.index', compact('manage_users', 'search'), ['title' => 'Search']);
        }
        return view('admin.pages.user.index', compact('manage_users'), ['title' => 'Show all users']);
    }
}
