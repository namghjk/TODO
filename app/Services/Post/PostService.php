<?php

namespace App\Services\Post;

use App\Http\Requests\UploadPostRequest;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PostService implements HasMedia
{
    use InteractsWithMedia;

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
    }

    public function deleteAll()
    {
        $user = Auth::user();
        $user->posts()->delete();
    }

    public function store(UploadPostRequest $request)
    {
        
    
        $validatedData = $request->validated();

        $user = Auth::user();
        $post = new Post([
            'user_id' => $user->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'content' => $request['content'],
        ]);

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            try {
                $thumbnail = $request->file('thumbnail');
                $post->addMedia($thumbnail)->toMediaCollection('thumbnail');
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

        $post->slug = $slug;
        $post->save();

        return $post;
    }

    public function update(UploadPostRequest $request, Post $post)
    {
        $validatedData = $request->validated();

        $post->title = $validatedData['title'];
        $post->description = $validatedData['description'];
        $post->content = $request['content'];

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            
                $post->media()->delete();
                $thumbnail = $request->file('thumbnail');
                $post->addMedia($thumbnail)->toMediaCollection('thumbnail');
                $post->thumbnail = $post->getFirstMediaUrl('thumbnail');
            
        }

        $baseSlug = Str::slug($validatedData['title'], '-');
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $post->slug = $slug;
        $post->save();

        return $post;
    }
}
