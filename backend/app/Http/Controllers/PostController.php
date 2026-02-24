<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at', 'desc')
                     ->paginate(10);
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'    => 'required|in:project,idea,opportunity,info,question',
            'content' => 'required|string',
            'title'   => 'string|nullable',
            'tags'    => 'array',
            'media'   => 'array',
        ]);

        $post = Post::create([
            'user_id' => $request->user()->id,
            'type'    => $request->type,
            'title'   => $request->title,
            'content' => $request->content,
            'tags'    => $request->tags ?? [],
            'media'   => $request->media ?? [],
        ]);

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->increment('views_count');
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($request->user()->id !== (string) $post->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $post->update($request->only(['title', 'content', 'tags', 'media']));
        return response()->json($post);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($request->user()->id !== (string) $post->user_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $post->delete();
        return response()->json(['message' => 'Post supprimé.']);
    }
}