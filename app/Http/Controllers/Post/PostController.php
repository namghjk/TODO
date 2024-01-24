<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\uploadPostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.post.showPost', ['title' => 'Post']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('Admin.pages.Post.createPost', [
            'title' => 'Add new post',
        ])->with('user', $user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(uploadPostRequest $request)
    {

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            try {
                $thumbnail = $request->file('thumbnail');
                $thumbnailPath = 'thumbnails/' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path('thumbnails'), $thumbnailPath);
            } catch (FileCannotBeAdded $e) {
                return redirect()->back()->with('error', 'Failed to upload thumbnail.');
            }
        }

        $user = Auth::user();
        $post = new Post([
            'user_id' => $user->id,
            'title' => $request['title'],
            'description' => $request['description'],
            'content' => $request['content'],
        ]);


        $slugOptions = $post->getSlugOptions();

        $baseSlug = Str::slug($request['title'], '-');
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $post->slug = $slug;


        if (isset($thumbnailPath)) {
            $post->thumbnail = $thumbnailPath;
        }

        $post->save();

        return redirect()->back()->with('success', 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
