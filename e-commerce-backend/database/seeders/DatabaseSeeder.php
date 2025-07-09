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
        
        Product::create([
        'name' => 'Smart Watch',
        'price' => 3499.00,
        'image' => 'http://localhost:8000/storage/products/smart-watch.jpg',
        'description' => 'Smartwatch with heart rate monitor.'
    ]);
        Product::create([
        'name' => 'HP Laptop',
        'price' => 74499.00,
        'image' => 'http://localhost:8000/storage/products/Laptop.jpg',
        'description' => ''
    ]);
        
        
    }
}
