<?php

namespace Database\Seeders;

use App\Models\Product_Category;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Elektronik',
            'Fashion',
            'Makanan & Minuman',
            'Kesehatan',
            'Olahraga',
            'Otomotif',
            'Buku & Alat Tulis',
            'Mainan & Hobi',
        ];

        foreach ($categories as $name) {
            Product_Category::updateOrCreate(
                ['name' => $name],
                ['name' => $name]
            );
        }
    }
}
