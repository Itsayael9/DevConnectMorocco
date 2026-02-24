<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->user()->id !== $user->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $request->validate([
            'name'         => 'string|max:255',
            'bio'          => 'string|max:500',
            'city'         => 'string|max:100',
            'skills'       => 'array',
            'github_url'   => 'url|nullable',
            'linkedin_url' => 'url|nullable',
            'website_url'  => 'url|nullable',
        ]);

        $user->update($request->only([
            'name', 'bio', 'city', 'skills',
            'github_url', 'linkedin_url', 'website_url'
        ]));

        return response()->json($user);
    }

    public function follow(Request $request, $id)
    {
        $userToFollow = User::findOrFail($id);
        $currentUser  = $request->user();

        if ($currentUser->id === $userToFollow->id) {
            return response()->json(['message' => 'Vous ne pouvez pas vous suivre vous-même.'], 400);
        }

        $userToFollow->increment('followers_count');
        $currentUser->increment('following_count');

        return response()->json(['message' => 'Utilisateur suivi avec succès.']);
    }

    public function unfollow(Request $request, $id)
    {
        $userToUnfollow = User::findOrFail($id);
        $currentUser    = $request->user();

        $userToUnfollow->decrement('followers_count');
        $currentUser->decrement('following_count');

        return response()->json(['message' => 'Utilisateur non suivi.']);
    }
}