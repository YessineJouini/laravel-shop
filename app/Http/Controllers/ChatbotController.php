<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => $userMessage],
            ],
        ]);
        

        

        return response()->json([
            'reply' => $response['choices'][0]['message']['content']
        ]);
    }
}
