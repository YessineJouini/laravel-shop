<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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

        // top products by category 
        $topProducts = Product::leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
    ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
    ->select(
        'products.id',
        'products.name',
        'products.price',
        'products.image', 
        'products.category_id',
        'categories.name as category_name',
        DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sales')
    )
    ->groupBy(
        'products.id',
        'products.name',
        'products.price',
        'products.image',
        'products.category_id',
        'categories.name'
    )
    ->orderByDesc('total_sales')
    ->get()
    ->groupBy('category_name')
    ->map(fn($group) => $group->first());


        //  if no sales exist
        if ($topProducts->isEmpty()) {
            $topProducts = Product::with('category')
                ->inRandomOrder()
                ->take(5)
                ->get()
                ->groupBy(fn($p) => $p->category->name)
                ->map(fn($g) => $g->first());
        }

        // Build context 
        $productContext = "Top Products by Category:\n";
        foreach ($topProducts as $product) {
            $productContext .= "- " . ($product->category->name ?? 'General') . ": " . $product->name .
                " (Price: " . number_format($product->price, 3) . " TND)\n";
        }

        //  context 
        if (empty($chatHistory)) {
            $systemMessage = <<<EOT
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

$productContext

Answer as ByteBuddy in a helpful tone, keep answers clear and practical. Mention local prices or availability only if asked.
EOT;

            $chatHistory[] = [
                'role' => 'system',
                'content' => $systemMessage
            ];
        }

        //  user message
        $chatHistory[] = [
            'role' => 'user',
            'content' => $userMessage
        ];

        // openai with chat history
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => $chatHistory,
            'temperature' => 0.7
        ]);

        $botReply = $response['choices'][0]['message']['content'];

        //  chat history with latest assistant response
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
