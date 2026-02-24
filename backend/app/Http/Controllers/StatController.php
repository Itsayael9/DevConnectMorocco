<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function skills()
    {
        $skills = Skill::where('category', 'language')
                       ->orderBy('usage_count', 'desc')
                       ->limit(10)
                       ->get();
        return response()->json($skills);
    }

    public function frameworks()
    {
        $frameworks = Skill::where('category', 'framework')
                           ->orderBy('usage_count', 'desc')
                           ->limit(10)
                           ->get();
        return response()->json($frameworks);
    }

    public function overview()
    {
        return response()->json([
            'top_languages'  => Skill::where('category', 'language')->orderBy('usage_count', 'desc')->limit(5)->get(),
            'top_frameworks' => Skill::where('category', 'framework')->orderBy('usage_count', 'desc')->limit(5)->get(),
        ]);
    }
}