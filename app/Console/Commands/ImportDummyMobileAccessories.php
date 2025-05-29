<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ImportDummyMobileAccessories extends Command
{
    protected $signature = 'import:mobile-accessories';
    protected $description = 'Import mobile accessories products from DummyJSON into the database';

    public function handle()
    {
        $this->info('Fetching mobile accessories from DummyJSON...');
        
        $response = Http::get('https://dummyjson.com/products/category/mobile-accessories?limit=50');
        
        if (!$response->successful()) {
            $this->error('Failed to fetch products.');
            return 1;
        }

        $products = $response->json('products');

        $category = Category::where('name', 'mobile accessories')->first();

        if (!$category) {
            $this->error('Category "mobile-accessories" not found in DB.');
            return 1;
        }

        foreach ($products as $productData) {
            // Download and store thumbnail image
            $imageUrl = $productData['thumbnail'];
            $imageContents = file_get_contents($imageUrl);
            $filename = 'productImg/' . Str::slug($productData['title']) . '-' . uniqid() . '.webp';
            Storage::disk('public')->put($filename, $imageContents);
            $imagePath = 'storage/' . $filename;

            // Compact description without shipping info, but including warranty
            $description = $productData['description'] . "\n\n" .
                           "Brand: " . $productData['brand'] . "\n" .
                           "Weight: " . $productData['weight'] . " lbs\n" .
                           "Dimensions: " . $productData['dimensions']['width'] . " x " . $productData['dimensions']['height'] . " x " . $productData['dimensions']['depth'] . " in\n" .
                           "Warranty: " . $productData['warrantyInformation'] . "\n" .
                           "Return Policy: " . $productData['returnPolicy'];

            // Save or update product
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

        $this->info('All mobile accessories imported successfully.');
        return 0;
    }
}
