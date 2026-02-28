<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Product_Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'price' => 21999000,
                'description' => 'Smartphone flagship Apple dengan chip A17 Pro, kamera 48MP, dan bodi titanium.',
                'tags' => 'apple,iphone,smartphone',
                'category' => 'Elektronik',
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'price' => 19999000,
                'description' => 'Smartphone premium Samsung dengan S Pen, kamera 200MP, dan AI features.',
                'tags' => 'samsung,galaxy,smartphone',
                'category' => 'Elektronik',
            ],
            [
                'name' => 'MacBook Air M3',
                'price' => 17999000,
                'description' => 'Laptop tipis dan ringan dengan chip Apple M3, layar Liquid Retina 13 inci.',
                'tags' => 'apple,macbook,laptop',
                'category' => 'Elektronik',
            ],
            [
                'name' => 'Kaos Polos Premium',
                'price' => 89000,
                'description' => 'Kaos polos bahan cotton combed 30s, nyaman dipakai sehari-hari.',
                'tags' => 'kaos,pakaian,cotton',
                'category' => 'Fashion',
            ],
            [
                'name' => 'Jaket Hoodie Oversize',
                'price' => 175000,
                'description' => 'Hoodie oversize fleece premium, cocok untuk casual dan hangout.',
                'tags' => 'jaket,hoodie,fashion',
                'category' => 'Fashion',
            ],
            [
                'name' => 'Sepatu Running Nike Air Max',
                'price' => 1599000,
                'description' => 'Sepatu lari Nike dengan teknologi Air Max untuk kenyamanan maksimal.',
                'tags' => 'nike,sepatu,running',
                'category' => 'Olahraga',
            ],
            [
                'name' => 'Kopi Arabika Gayo 250g',
                'price' => 75000,
                'description' => 'Biji kopi arabika single origin dari dataran tinggi Gayo, Aceh.',
                'tags' => 'kopi,arabika,gayo',
                'category' => 'Makanan & Minuman',
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'price' => 45000,
                'description' => 'Suplemen vitamin C dosis tinggi untuk menjaga daya tahan tubuh.',
                'tags' => 'vitamin,suplemen,kesehatan',
                'category' => 'Kesehatan',
            ],
            [
                'name' => 'Helm AGV K3 SV',
                'price' => 3500000,
                'description' => 'Helm full face AGV dengan visor anti-fog dan ventilasi optimal.',
                'tags' => 'helm,agv,motor',
                'category' => 'Otomotif',
            ],
            [
                'name' => 'Novel Laskar Pelangi',
                'price' => 79000,
                'description' => 'Novel best-seller karya Andrea Hirata tentang perjuangan anak Belitung.',
                'tags' => 'novel,buku,sastra',
                'category' => 'Buku & Alat Tulis',
            ],
        ];

        foreach ($products as $item) {
            $category = Product_Category::where('name', $item['category'])->first();

            Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                    'tags' => $item['tags'],
                    'categories_id' => $category?->id,
                ]
            );
        }
    }
}
