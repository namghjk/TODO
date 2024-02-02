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

        $manage_posts = Post::paginate(2);
        return view('admin.pages.post.index', compact('manage_posts', 'user'), ['title' => 'Show all posts']);
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
            $manage_post = $this->manageService->store($request);
            return redirect()->back()->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy(Post $manage_post)
    {
        try {
            $manage_post = $this->manageService->destroy($manage_post);
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

    public function edit(Post $manage_post)
    {
        $user = Auth::user();
        // $post = Post::findOrFail($id);
        return view('admin.pages.post.edit', compact('manage_post', 'user'), ['title' => $manage_post->title]);
    }

    public function update(UpdatePostRequest $request, Post $manage_post)
    {
        $user = Auth::user();

        try {

            if ($manage_post->status !== $request->status) {
                dispatch(new SendNotificationChangePostStatus($user, $manage_post));
            }
            $post = $this->manageService->update($request, $manage_post);

            return redirect()->to(route('manage-post.index'))->with('success', 'Update post successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function search(Request $request)
    {

        $search = $request->input('search');
        $manage_posts = Post::paginate(2);
        $user = Auth::user();
        if ($search !== null) {
            $manage_posts = Post::where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('email', 'like', "%$search%");
                })->paginate(2);
            return view('admin.pages.post.index', compact('manage_posts', 'search', 'user'), ['title' => 'Search']);
        }
        return view('admin.pages.post.index', compact('manage_posts', 'user'), ['title' => 'Show all posts']);
    }
}
