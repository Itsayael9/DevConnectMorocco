<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return response()->json(Job::orderBy('created_at', 'desc')->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'budget'      => 'numeric|nullable',
            'skills'      => 'array',
            'deadline'    => 'date|nullable',
        ]);

        $job = Job::create([
            'company_id'  => $request->user()->id,
            'title'       => $request->title,
            'description' => $request->description,
            'budget'      => $request->budget,
            'skills'      => $request->skills ?? [],
            'deadline'    => $request->deadline,
        ]);

        return response()->json($job, 201);
    }

    public function show($id)
    {
        return response()->json(Job::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if ($request->user()->id !== (string) $job->company_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $job->update($request->only([
            'title', 'description', 'budget', 'skills', 'deadline', 'status'
        ]));

        return response()->json($job);
    }

    public function destroy(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if ($request->user()->id !== (string) $job->company_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $job->delete();
        return response()->json(['message' => 'Offre supprimée.']);
    }
}