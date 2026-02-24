<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function togglePost(Request $request, $id)
    {
        $post     = Post::findOrFail($id);
        $userId   = $request->user()->id;

        $existing = Like::where('user_id', $userId)
                        ->where('likeable_id', $id)
                        ->where('likeable_type', 'post')
                        ->first();

        if ($existing) {
            $existing->delete();
            $post->decrement('likes_count');
            return response()->json(['liked' => false, 'likes_count' => $post->likes_count]);
        }

        Like::create([
            'user_id'       => $userId,
            'likeable_id'   => $id,
            'likeable_type' => 'post',
        ]);

        $post->increment('likes_count');
        return response()->json(['liked' => true, 'likes_count' => $post->likes_count]);
    }

    public function toggleComment(Request $request, $id)
    {
        $comment  = Comment::findOrFail($id);
        $userId   = $request->user()->id;

        $existing = Like::where('user_id', $userId)
                        ->where('likeable_id', $id)
                        ->where('likeable_type', 'comment')
                        ->first();

        if ($existing) {
            $existing->delete();
            $comment->decrement('likes_count');
            return response()->json(['liked' => false]);
        }

        Like::create([
            'user_id'       => $userId,
            'likeable_id'   => $id,
            'likeable_type' => 'comment',
        ]);

        $comment->increment('likes_count');
        return response()->json(['liked' => true]);
    }
}