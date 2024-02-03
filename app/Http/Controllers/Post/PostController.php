<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\UploadPostRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'user') {
            abort(404);
        }
        $posts = $user->posts()->paginate(2);
        return view('post.index', compact('user', 'posts'), ['title' => 'Show all posts']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'user') {
            abort(404);
        }
        return view('post.create', [
            'title' => 'Add new post',
        ])->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadPostRequest $request)
    {
        $user = Auth::user();
        if ($user->role !== 'user') {
            abort(404);
        }
        try {
            $post = $this->postService->store($request);
            return redirect()->back()->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();
        if ($user->role !== 'user') {
            abort(404);
        }
        if ($post->user_id !== $user->id) {
            abort(404);
        }

        return view('post.edit', compact('post', 'user'), ['title' => $post->title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $user = Auth::user();
        if ($user->role !== 'user') {
            abort(404);
        } else if ($post->user_id !== auth()->id()) {
            abort(404);
        }
        try {
            $post = $this->postService->update($request, $post);
            return redirect()->route('posts.index')->with('success', 'Update post successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $user = Auth::user();
        if ($user->role !== 'user') {
            abort(404);
        }
        try {
            $this->postService->destroy($post->id);
            return redirect()->route('posts.index')->with('success', 'Delete post successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteAll()
    {
        $user = Auth::user();
        if ($user->role !== 'user') {
            abort(404);
        }
        try {
            $post = $this->postService->deleteAll();
            return redirect()->to(route('posts.index'))->with('success', 'Delete all post successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
