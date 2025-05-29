<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ImportDummyLaptops extends Command
{
    protected $signature = 'import:laptops';
    protected $description = 'Import laptop products from DummyJSON into the database';

    public function handle()
    {
        $this->info('Fetching products from DummyJSON...');
        
        $response = Http::get('https://dummyjson.com/products/category/laptops?limit=50');
        
        if (!$response->successful()) {
            $this->error('Failed to fetch products.');
            return 1;
        }

        $products = $response->json('products');

        // Find the category you already created
        $category = Category::where('name', 'laptops')->first();

        if (!$category) {
            $this->error('Category "laptops" not found in DB.');
            return 1;
        }

        foreach ($products as $productData) {
            // Download and store thumbnail image
            $imageUrl = $productData['thumbnail'];
            $imageContents = file_get_contents($imageUrl);
            $filename = 'productImg/' . Str::slug($productData['title']) . '-' . uniqid() . '.webp';
            Storage::disk('public')->put($filename, $imageContents);
            $imagePath = 'storage/' . $filename;

            // Combine description fields
            $description = $productData['description'] . "\n\n" .
                           "Brand: " . $productData['brand'] . "\n" .
                           "Weight: " . $productData['weight'] . " lbs\n" .
                           "Dimensions: " . $productData['dimensions']['width'] . " x " . $productData['dimensions']['height'] . " x " . $productData['dimensions']['depth'] . " in\n" .
                           "Warranty: " . $productData['warrantyInformation'];
                          

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

        $this->info('All laptops imported successfully.');
        return 0;
    }
}
