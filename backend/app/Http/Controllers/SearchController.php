<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Project;
use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function global(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json(['message' => 'Requête trop courte.'], 400);
        }

        $users    = User::where('name', 'like', "%{$query}%")->limit(5)->get();
        $posts    = Post::where('content', 'like', "%{$query}%")->limit(5)->get();
        $projects = Project::where('title', 'like', "%{$query}%")->limit(5)->get();
        $jobs     = Job::where('title', 'like', "%{$query}%")->limit(5)->get();

        return response()->json([
            'users'    => $users,
            'posts'    => $posts,
            'projects' => $projects,
            'jobs'     => $jobs,
        ]);
    }
}