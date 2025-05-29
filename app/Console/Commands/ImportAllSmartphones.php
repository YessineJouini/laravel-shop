<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Http;

class ImportAllSmartphones extends Command
{
    protected $signature = 'import:all-smartphones';
    protected $description = 'Import all smartphone products from DummyJSON into the database';

    public function handle()
    {
        // Step 1: Find 'smartphones' category
        $category = Category::where('name', 'smartphones')->first();
        if (!$category) {
            $this->error('Category "smartphones" not found. Create it first.');
            return;
        }

        // Step 2: Load products from DummyJSON API
        $response = Http::get('https://dummyjson.com/products/category/smartphones');
        if (!$response->ok()) {
            $this->error('Failed to fetch products from DummyJSON.');
            return;
        }

        $products = $response->json('products');

        // Step 3: Loop through each product
        foreach ($products as $product) {
            $name = $product['title'];
            $desc = $product['description'];
            $brand = $product['brand'] ?? 'N/A';
            $weight = $product['weight'] ?? 'N/A';
            $dimensions = $product['dimensions'] ?? ['width' => 'N/A', 'height' => 'N/A', 'depth' => 'N/A'];
            $warranty = $product['warrantyInformation'] ?? 'No warranty info';
            

            $fullDescription = "$desc\n\n"
                . "Brand: $brand\n"
                . "Weight: {$weight}kg\n"
                . "Dimensions: {$dimensions['width']} x {$dimensions['height']} x {$dimensions['depth']} cm\n"
                . "Warranty: $warranty\n";
                

            // Step 4: Save the main image
            $imageUrl = $product['images'][0] ?? null;
            if (!$imageUrl) {
                $this->warn("No image found for $name. Skipping.");
                continue;
            }

            try {
                $imageContent = file_get_contents($imageUrl);
                $imageFilename = 'productImg/' . Str::slug($name) . '-' . uniqid() . '.webp';
                Storage::disk('public')->put($imageFilename, $imageContent);
            } catch (\Exception $e) {
                $this->error("Failed to download image for $name.");
                continue;
            }

            // Step 5: Create product in DB
            Product::create([
                'name' => $name,
                'description' => $fullDescription,
                'price' => $product['price'],
                'stock' => $product['stock'],
                'category_id' => $category->id,
                'image' => $imageFilename,
            ]);

            $this->info("Imported: $name");
        }

        $this->info('All smartphone products imported successfully.');
    }
}
