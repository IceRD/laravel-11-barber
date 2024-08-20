<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', '=', 1)->orderBy('id', 'DESC')->paginate(10);

        return Inertia::render("Portal/Posts/Posts", [
            "posts" => $posts,
        ]);
    }
}
