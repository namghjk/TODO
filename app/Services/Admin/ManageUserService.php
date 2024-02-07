<?php

namespace App\Services\Admin;

use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UploadPostRequest;
use App\Mail\ChangeStatusPostSuccess;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ManageUserService
{

    public function update(UpdateUserRequest $request, User $manage_user)
    {

        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(404);
        }

        $manage_user->update([
            'first_name' => $request['first_name'],
            'last_name' =>  $request['last_name'],
            'status' => $request['status'],
        ]);

        if ($request->has('address')) {
            $data['address'] = $request['address'];
        }

        Session::flash('success', 'Update User successfully');
        return redirect()->to(route('manage-user.index'));
    }
}
