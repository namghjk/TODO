<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(404);
        }
        return view('admin.pages.user.index', compact('user'), ['title' => 'Show all posts']);
    }
}
