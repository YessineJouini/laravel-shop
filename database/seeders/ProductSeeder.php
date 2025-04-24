<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Creates 80 products using the ProductFactory
        Product::factory()->count(80)->create();
    }
}
