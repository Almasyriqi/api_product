<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['Logitech H111 Headset Stereo Single Jack 3.5mm', 'Philips Rice Cooker - Inner Pot 2L Bakuhanseki - HD3110/33', 
        'Iphone 12 64Gb/128Gb/256Gb Garansi Resmi IBOX/TAM - Hitam, 64Gb', 'Papan alat bantu Push Up Rack Board Fitness Workout Gym', 
        'Jim Joker - Sandal Slide Kulit Pria Bold 2S Hitam - Hitam'];
        $slug = ['logitech-h111-headset-stereo-single-jack-3-5mm', 'philips-rice-cooker -inner-pot-2l-bakuhanseki-hd3110-33',
        'iphone-12-64gb-128gb-256gb-garansi-resmi-ibox-tam-hitam-64gb', 'papan-alat-bantu-push-up-rack-board-fitness-workout-gym',
        'jim-joker-sandal-slide-kulit-pria-bold-2s-hitam-hitam'];
        $price = [80000, 249000, 11340000, 90000, 305000];
        $category_id = [1,1,4,5,2];

        for ($i=0; $i < 5; $i++) { 
            DB::table('products')->insert([
                'category_id' => $category_id[$i],
                'name' => $name[$i],
                'slug' => $slug[$i],
                'price' => $price[$i],
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }
    }
}
