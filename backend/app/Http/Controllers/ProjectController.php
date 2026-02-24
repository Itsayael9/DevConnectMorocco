<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::orderBy('created_at', 'desc')->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack'  => 'array',
            'github_url'  => 'url|nullable',
            'demo_url'    => 'url|nullable',
        ]);

        $project = Project::create([
            'owner_id'    => $request->user()->id,
            'title'       => $request->title,
            'description' => $request->description,
            'tech_stack'  => $request->tech_stack ?? [],
            'github_url'  => $request->github_url,
            'demo_url'    => $request->demo_url,
            'members'     => [$request->user()->id],
        ]);

        return response()->json($project, 201);
    }

    public function show($id)
    {
        return response()->json(Project::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if ($request->user()->id !== (string) $project->owner_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $project->update($request->only([
            'title', 'description', 'tech_stack',
            'status', 'github_url', 'demo_url'
        ]));

        return response()->json($project);
    }

    public function destroy(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        if ($request->user()->id !== (string) $project->owner_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $project->delete();
        return response()->json(['message' => 'Projet supprimé.']);
    }

    public function join(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $userId  = $request->user()->id;
        $members = $project->members ?? [];

        if (!in_array($userId, $members)) {
            $members[] = $userId;
            $project->update(['members' => $members]);
        }

        return response()->json(['message' => 'Vous avez rejoint le projet.']);
    }

    public function leave(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $userId  = $request->user()->id;
        $members = array_filter($project->members ?? [], fn($m) => $m !== $userId);
        $project->update(['members' => array_values($members)]);

        return response()->json(['message' => 'Vous avez quitté le projet.']);
    }
}