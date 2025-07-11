<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Laptop Asus ROG',
                'description' => 'Laptop gaming dengan performa tinggi',
                'price' => 15000000,
                'image' => 'https://via.placeholder.com/300',
                'stock' => 10
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Smartphone flagship dari Apple',
                'price' => 20000000,
                'image' => 'https://via.placeholder.com/300',
                'stock' => 15
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'description' => 'Smartphone Android terbaru dari Samsung',
                'price' => 12000000,
                'image' => 'https://via.placeholder.com/300',
                'stock' => 8
            ],
            [
                'name' => 'Xiaomi Mi Band 7',
                'description' => 'Smart band dengan fitur lengkap',
                'price' => 500000,
                'image' => 'https://via.placeholder.com/300',
                'stock' => 20
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
