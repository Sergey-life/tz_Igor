<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string:255',
            'body' => 'required|string:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = Post::create($request->all());
        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    public function update(Request $request, Post $post)
    {
        if (Gate::denies('update-post', $post)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string:255',
            'body' => 'required|string:255',
        ]);

        ProcessPost::dispatch($post, $request->all());

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if (Gate::denies('delete-post', $post)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post->delete();
        return response()->json(null, 204);
    }
}

