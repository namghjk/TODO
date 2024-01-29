<?php

namespace App\Services\Post;

use App\Http\Requests\UploadPostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PostService implements HasMedia
{
    use InteractsWithMedia;
    public function store(UploadPostRequest $request)
    {
        $user = Auth::user();
        $post = new Post([
            'user_id' => $user->id,
            'title' => $request['title'],
            'description' => $request['description'],
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

        $baseSlug = Str::slug($request['title'], '-');
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
}
