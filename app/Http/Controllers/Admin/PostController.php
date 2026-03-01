<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => new Post(),
            'templates' => \App\Models\Template::all()
        ]);
    }

    public function edit(Post $post)
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post,
            'templates' => \App\Models\Template::all()
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('message', 'Post deleted successfully');
    }
}
