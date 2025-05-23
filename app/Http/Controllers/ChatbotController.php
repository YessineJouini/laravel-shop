<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function index()
{
    return view('chatbot.index');
}
    public function chatWithBot(Request $request)
    {
        $userMessage = $request->input('message');

        // instruction in the prompt
        $prompt = "keep responses as short as you can, " . $userMessage;

        try {
            $response = Http::timeout(400)->post('http://localhost:4891/v1/chat/completions', [
                'model' => 'mistral instruct', //  mistral-7b-instruct-v0.1.Q4_0
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.5,
                'max_tokens' => 800,
                'stream' => false,
            ]);

            // Log the full response body for debugging
            Log::info('Chatbot API response:', $response->json());

            return response()->json([
                'reply' => $response['choices'][0]['message']['content'] ?? 'No reply from model.'
            ]);
        } catch (\Exception $e) {
            // Log error with message and stack trace
            Log::error('Chatbot API error: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'reply' => 'Error: Unable to reach chatbot or processing failed.'
            ], 500);
        }
    }
}
