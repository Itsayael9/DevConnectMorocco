<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::where('post_id', $id)
                           ->orderBy('created_at', 'asc')
                           ->get();
        return response()->json($comments);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($id);

        $comment = Comment::create([
            'post_id' => $id,
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);

        $post->increment('comments_count');

        return response()->json($comment, 201);
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($request->user()->id !== (string) $comment->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $post = Post::find($comment->post_id);
        if ($post) $post->decrement('comments_count');

        $comment->delete();
        return response()->json(['message' => 'Commentaire supprimé.']);
    }
}