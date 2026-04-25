<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Kopi Hitam',
            'price' => 5000,
            'stock' => 100,
        ]);

        Product::create([
            'name' => 'Teh Hijau',
            'price' => 7000,
            'stock' => 100,
        ]);

        Product::create([
            'name' => 'Martabak Telur',
            'price' => 15000,
            'stock' => 50,
        ]);

        Product::create([
            'name' => 'Nasi Goreng',
            'price' => 20000,
            'stock' => 50,
        ]);

        Product::create([
            'name' => 'Ayam Goreng',
            'price' => 25000,
            'stock' => 30,
        ]);
    }
}
