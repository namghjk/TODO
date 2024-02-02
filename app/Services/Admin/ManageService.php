<?php

namespace App\Services\Admin;

use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\UploadPostRequest;
use App\Mail\ChangeStatusPostSuccess;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ManageService implements HasMedia
{
    use InteractsWithMedia;

    public function destroy($id)
    {
        $manage_post = Post::find($id);
        $manage_post->delete();
    }

    public function deleteAll()
    {
        $manage_post = Post::all();
        $manage_post->delete();
    }

    public function store(UploadPostRequest $request)
    {

        $validatedData = $request->validated();

        $user = Auth::user();
        $manage_post = new Post([
            'user_id' => $user->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'content' => $request['content'],
        ]);

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            try {
                $thumbnail = $request->file('thumbnail');
                $manage_post->addMedia($thumbnail)->toMediaCollection('thumbnail');
            } catch (FileCannotBeAdded $e) {
                throw new \Exception('Failed to upload thumbnail.');
            }
        }

        $baseSlug = Str::slug($validatedData['title'], '-');
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }


        $manage_post->slug = $slug;
        $manage_post->save();

        return $manage_post;
    }

    public function update( UpdatePostRequest $request, Post $manage_post)
    {

        $user = Auth::user();
      
        $manage_post->title = $request['title'];
        $manage_post->description = $request['description'];
        $manage_post->content = $request['content'];
        $manage_post->status = $request['status'];

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $manage_post->media()->delete();
            $thumbnail = $request->file('thumbnail');
            $manage_post->addMedia($thumbnail)->toMediaCollection('thumbnail');
            $manage_post->thumbnail = $manage_post->getFirstMediaUrl('thumbnail');
        }



        $baseSlug = Str::slug($request['title'], '-');
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->where('id', '!=', $manage_post->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $manage_post->slug = $slug;
        $manage_post->save();

        return $manage_post;
    }
}
