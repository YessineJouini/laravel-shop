<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ImportDummyTablets extends Command
{
    protected $signature = 'import:tablets';
    protected $description = 'Import tablet products from DummyJSON into the database';

    public function handle()
    {
        $this->info('Fetching tablets from DummyJSON...');

        $response = Http::get('https://dummyjson.com/products/category/tablets?limit=50');

        if (!$response->successful()) {
            $this->error('Failed to fetch tablet products.');
            return 1;
        }

        $products = $response->json('products');

        $category = Category::where('name', 'tablets')->first();

        if (!$category) {
            $this->error('Category "tablets" not found in DB.');
            return 1;
        }

        foreach ($products as $productData) {
            // Store thumbnail
            $imageUrl = $productData['thumbnail'];
            $imageContents = file_get_contents($imageUrl);
            $filename = 'productImg/' . Str::slug($productData['title']) . '-' . uniqid() . '.webp';
            Storage::disk('public')->put($filename, $imageContents);
            $imagePath =  $filename;

            // Build product description (without shipping, but include warranty if present)
            $description = $productData['description'] . "\n\n" .
                           "Brand: " . $productData['brand'] . "\n" .
                           "Weight: " . $productData['weight'] . " lbs\n" .
                           "Dimensions: " . $productData['dimensions']['width'] . " x " .
                                            $productData['dimensions']['height'] . " x " .
                                            $productData['dimensions']['depth'] . " in\n";

            if (!empty($productData['warrantyInformation'])) {
                $description .= "Warranty: " . $productData['warrantyInformation'] . "\n";
            }

           

            Product::updateOrCreate(
                ['name' => $productData['title']],
                [
                    'description' => $description,
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'image' => $imagePath,
                    'category_id' => $category->id,
                ]
            );

            $this->info('Imported: ' . $productData['title']);
        }

        $this->info('All tablet products imported successfully.');
        return 0;
    }
}
