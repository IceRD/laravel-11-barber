<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{

    public function index(): Response
    {
        $posts = Post::select('id', 'title', 'is_published', 'created_at')
            ->orderBy('id', 'DESC')
            ->get();

        return Inertia::render("Dashboard/Posts/Posts", [
            "posts" => $posts,
        ]);
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Dashboard/Posts/PostEdit', [
            'post' => $post
        ]);
    }

    public function update() {
        // Обновление записи
    }

    public function create(): Response {


        return Inertia::render('Dashboard/Posts/PostCreate');
    }

    public function portalIndex(): Response
    {
        $posts = Post::where('is_published', '=', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return Inertia::render("Portal/Posts/Posts", [
            "posts" => $posts,
        ]);
    }
}
