<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ImportGamingPCs extends Command
{
    protected $signature = 'import:gaming-pcs';
    protected $description = 'Import gaming PC products from local JSON file';

    public function handle()
    {
        $this->info('Starting import of gaming PCs...');

     if (!Storage::disk('public')->exists('data/gaming_pcs.json')) {
    $this->error('File not found: data/gaming_pcs.json in public disk');
    return 1;
}

$jsonContent = Storage::disk('public')->get('data/gaming_pcs.json');

        $data = json_decode($jsonContent, true);

        if (!$data || !isset($data['products'])) {
            $this->error('Invalid JSON or missing "products" key.');
            return 1;
        }

        $products = $data['products'];

        $category = Category::where('name', 'gaming pcs')->first();

        if (!$category) {
            $this->error('Category "gaming pcs" not found.');
            return 1;
        }

        foreach ($products as $prod) {
            // Download and save thumbnail
            $imagePath = null;
            if (!empty($prod['thumbnail'])) {
                try {
                    $imageContents = file_get_contents($prod['thumbnail']);
                    $filename = 'productImg/' . Str::slug($prod['title']) . '-' . uniqid() . '.webp';
                    Storage::disk('public')->put($filename, $imageContents);
                    $imagePath = 'storage/' . $filename;
                } catch (\Exception $e) {
                    $this->warn("Could not download image for {$prod['title']}");
                }
            }

            Product::updateOrCreate(
                ['name' => $prod['title']],
                [
                    'price' => $prod['price'] ?? 0,
                    'stock' => $prod['stock'] ?? 0,
                    'image' => $imagePath,
                    'category_id' => $category->id,
                    'description' => $prod['description'] ?? '',
                ]
            );

            $this->info("Imported: {$prod['title']}");
        }

        $this->info('Gaming PCs imported successfully.');

        return 0;
    }
}
