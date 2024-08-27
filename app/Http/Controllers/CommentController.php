<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'content' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id' // Make sure to add this validation rule
        ]);

        // Create a new comment
        $comment = Comment::create($validated);
        $user = User::find($comment->user_id);
        event(new SendNotification($user));
        return response()->json($comment, Response::HTTP_CREATED);
    }
    public function getComments($postId)
    {
        // Fetch all comments related to the specified post ID
        $comments = Comment::with(['user'])->where('post_id', $postId)->get();
        return response()->json($comments, Response::HTTP_OK);
    }
    public function deleteComment($postId, $commentId)
    {
        $comment = Comment::where('post_id', $postId)->find($commentId);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], Response::HTTP_NOT_FOUND);
        }

        // Check if the authenticated user is the owner of the comment
        // if ($comment->user_id != auth()->id()) {
        //     return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        // }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], Response::HTTP_OK);
    }
}
