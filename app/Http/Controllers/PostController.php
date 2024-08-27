<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index()
    {
        // Fetch all posts
        $posts = Post::with(['user', 'comments.user']) // Eager load the user and comments relationships
            ->latest()
            ->limit(5)
            ->get();
        return response()->json($posts, Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id', // Make sure to add this validation rule
        ]);

        // Create a new post
        $post = Post::create($validated);

        return response()->json($post, Response::HTTP_CREATED);
    }


    public function destroy($id)
    {
        // Fetch the post
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        // Delete the post
        $post->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
