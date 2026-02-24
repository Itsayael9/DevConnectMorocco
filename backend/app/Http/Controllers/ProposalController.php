<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index($id)
    {
        $proposals = Proposal::where('job_id', $id)->get();
        return response()->json($proposals);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'price'   => 'required|numeric',
        ]);

        $job = Job::findOrFail($id);

        $proposal = Proposal::create([
            'job_id'      => $id,
            'freelance_id'=> $request->user()->id,
            'message'     => $request->message,
            'price'       => $request->price,
        ]);

        $job->increment('proposals_count');

        return response()->json($proposal, 201);
    }

    public function accept(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update(['status' => 'accepted']);
        return response()->json(['message' => 'Proposition acceptée.']);
    }

    public function reject(Request $request, $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->update(['status' => 'rejected']);
        return response()->json(['message' => 'Proposition rejetée.']);
    }
}