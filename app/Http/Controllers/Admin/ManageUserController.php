<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\Admin\ManageUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManageUserController extends Controller
{
    protected $manageUserService;

    public function __construct(ManageUserService $manageUserService)
    {
        $this->manageUserService = $manageUserService;
    }


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
        try {
            $manage = $this->manageUserService->update($request,$manage_user);
            return $manage;
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(404);
        }
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
