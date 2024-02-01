<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\uploadPostRequest;
use App\Jobs\SendNotificationChangePostStatus;
use App\Mail\ChangeStatusPostSuccess;
use App\Models\Post;
use App\Services\Admin\ManageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ManagePostController extends Controller
{

    protected $manageService;

    public function __construct(ManageService $manageService)
    {
        $this->manageService = $manageService;
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(404);
        }

        $posts = Post::paginate(2);
        return view('admin.pages.post.index', compact('posts', 'user'), ['title' => 'Show all posts']);
    }

    public function create()
    {
        $user = Auth::user();
        return view('post.create', [
            'title' => 'Add new post',
        ])->with('user', $user);
    }

    public function store(UploadPostRequest $request)
    {
        try {
            $post = $this->manageService->store($request);
            return redirect()->back()->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $post = $this->manageService->destroy($id);
            return redirect()->to(route('admin.pages.post.index'))->with('success', 'Delete post successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteAll()
    {
        try {
            $post = $this->manageService->deleteAll();
            return redirect()->to(route('manage-post.index'))->with('success', 'Delete all post successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();
        return view('admin.pages.post.edit', compact('post', 'user'), ['title' => $post->title]);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        try {

            if ($post->status !== $request->status) {
                dispatch(new SendNotificationChangePostStatus($user, $post));
            }
            $post = $this->manageService->update($request, $post);

            return redirect()->to(route('manage-post.index'))->with('success', 'Update post successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
