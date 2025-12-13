<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Perbaikan import namespace

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. INSERT KATEGORI DULU
        // (Wajib duluan supaya product bisa referensi ke id kategori ini)
        $categories = [
            ['id' => 1, 'name' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Fashion Pria', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Fashion Wanita', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Rumah Tangga', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);

        // 2. BARU INSERT PRODUK
        DB::table('products')->insert([
            [
                'name' => 'Kamera Canon EOS',
                'description' => 'Kamera DSLR canggih dengan fitur autofocus cepat dan kualitas gambar tinggi.',
                'price' => 5500000,
                'stock' => 50,
                'image' => 'https://via.placeholder.com/300x300?text=Canon+EOS',
                'category_id' => 1, // Elektronik
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sepatu Nike Air',
                'description' => 'Sepatu lari ringan dengan bantalan udara yang nyaman untuk aktivitas olahraga.',
                'price' => 1250000,
                'stock' => 100,
                'image' => 'https://via.placeholder.com/300x300?text=Nike+Air',
                'category_id' => 4, // Olahraga
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kemeja Flannel',
                'description' => 'Kemeja motif kotak-kotak bahan katun premium, cocok untuk gaya kasual.',
                'price' => 199000,
                'stock' => 200,
                'image' => 'https://via.placeholder.com/300x300?text=Kemeja',
                'category_id' => 2, // Fashion Pria
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blender Philips',
                'description' => 'Blender kuat untuk menghaluskan bumbu dan buah dengan cepat.',
                'price' => 450000,
                'stock' => 30,
                'image' => 'https://via.placeholder.com/300x300?text=Blender',
                'category_id' => 5, // Rumah Tangga
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smartwatch Samsung',
                'description' => 'Jam tangan pintar dengan fitur pemantau kesehatan dan notifikasi.',
                'price' => 2100000,
                'stock' => 45,
                'image' => 'https://via.placeholder.com/300x300?text=Smartwatch',
                'category_id' => 1, // Elektronik
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tas Ransel Canvas',
                'description' => 'Tas punggung bahan kanvas kuat, muat laptop 14 inch.',
                'price' => 350000,
                'stock' => 80,
                'image' => 'https://via.placeholder.com/300x300?text=Tas+Ransel',
                'category_id' => 2, // Fashion Pria
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}