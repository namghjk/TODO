<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show()
    {
        $posts = Post::where('status', 1)->get();
        return view('news.show', compact('posts'), ['title' => 'News']);
    }

    public function detailNews($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('news.detail', compact('post'), ['title' => 'Detail News']);
    }
}
