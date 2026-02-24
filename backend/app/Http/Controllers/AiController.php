<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type'  => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model'    => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => 'Tu es un assistant IA pour DevConnect Morocco, une plateforme communautaire IT marocaine. Tu aides les développeurs, étudiants et freelances marocains avec leurs questions techniques, leur apprentissage et leurs opportunités professionnelles. Réponds en français ou en darija selon la langue de l\'utilisateur.',
                ],
                [
                    'role'    => 'user',
                    'content' => $request->message,
                ],
            ],
            'max_tokens' => 500,
        ]);

        return response()->json([
            'reply' => $response->json('choices.0.message.content'),
        ]);
    }

    public function suggestions(Request $request)
    {
        $suggestions = [
            'Comment démarrer avec Laravel au Maroc ?',
            'Quels sont les frameworks les plus utilisés au Maroc ?',
            'Comment trouver un stage en développement web ?',
            'Comment contribuer à un projet open source ?',
            'Quelles sont les meilleures ressources pour apprendre React ?',
        ];

        return response()->json(['suggestions' => $suggestions]);
    }
}