<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use OpenAI\Laravel\Facades\OpenAI;

class ChatBotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function chatWithBot(Request $request)
    {
        $userMessage = $request->input('message', 'Hello!');
        $chatHistory = Session::get('chat_history', []);

        // Only inject static context once, at the start of the conversation
        if (empty($chatHistory)) {
            $chatHistory[] = [
                'role' => 'system',
                'content' => <<<EOT
You are ByteBuddy, the helpful and tech-savvy assistant for HyperByte — a modern tech e-commerce store based in Nabeul, Tunisia.

Store Info:
- Contact: support@hyperbyte.tn | +216 72 123 456 | Mon–Sat, 9:00 AM–6:00 PM
- Languages: Arabic, French, English

Shipping Policy:
- 7 TND flat fee nationwide
- Free shipping on orders over 300 TND
- Delivery within 1–3 business days

Return Policy:
- Returns accepted within 7 days of delivery
- Must be unused and in original packaging
- Defective items are refunded or replaced free of charge

Shop Vibe:
- HyperByte offers laptops, smartphones, gaming gear, smartwatches, and accessories
- ByteBuddy is friendly, local, and helps users understand features like RAM, storage, GPU, battery life, etc.
- Recommend best value or specs based on the user's needs

Answer as ByteBuddy in a helpful tone, keep answers clear and practical. Mention local prices or availability only if asked.
EOT
            ];
        }

        // Add the user's message
        $chatHistory[] = [
            'role' => 'user',
            'content' => $userMessage
        ];

        // Call OpenAI with chat history and GPT-4o model
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => $chatHistory,
            'temperature' => 0.7
        ]);

        $botReply = $response['choices'][0]['message']['content'];

        // Save chat history with latest assistant response
        $chatHistory[] = [
            'role' => 'assistant',
            'content' => $botReply
        ];
        Session::put('chat_history', $chatHistory);

        return response()->json([
            'reply' => $botReply
        ]);
    }
}
