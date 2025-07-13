<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
        'image_url' => 'http://localhost:8000/storage/banners/banner.jpg'
        ]);
        Banner::create([
        'image_url' => 'http://localhost:8000/storage/banners/shoes-banner.jpg'
        ]);
        Banner::create([
        'image_url' => 'http://localhost:8000/storage/banners/men-clothing.jpg'
        ]);
        Banner::create([
        'image_url' => 'http://localhost:8000/storage/banners/watch-banner.jpg'
        ]);
        Banner::create([
        'image_url' => 'http://localhost:8000/storage/banners/women-clothes-banner.jpg'
        ]);
        Product::create([
        'name' => 'Smart Watch',
        'price' => 3499.00,
        'image' => 'http://localhost:8000/storage/products/smart-watch.jpg',
        'description' => 'Smartwatch with heart rate monitor.',
        'category_id'=>'2'
    ]);
        Product::create([
        'name' => 'HP Laptop',
        'price' => 74499.00,
        'image' => 'http://localhost:8000/storage/products/Laptop.jpg',
        'description' => '',
        'category_id' => 3
    ]);
        Product::create([
        'name' => 'Shoes',
        'price' => 7449.00,
        'image' => 'http://localhost:8000/storage/products/shoe.jpg',
        'description' => '',
        'category_id' => 1
    ]);
        Product::create([
        'name' => 'Men Clothing',
        'price' => 2449.00,
        'image' => 'http://localhost:8000/storage/products/men-clothes.jpg',
        'description' => '',
        'category_id' => 4
    ]);
        Product::create([
        'name' => 'Women Clothing',
        'price' => 1449.00,
        'image' => 'http://localhost:8000/storage/products/women-clothes.jpg',
        'description' => '',
        'category_id' => 4
    ]);
        
        
    }
}
