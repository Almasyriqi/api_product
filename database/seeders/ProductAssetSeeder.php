<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image = ['logitech-h111.png', 'logitech-h111-headset-stereo-single-jack-3-5mm.png', 
        'philips-rice-cooker-inner-pot-2l-bakuhanseki-hd3110-33.png', 'philips.png', 
        'philips-rice-cooker.png', 'iphone-12-64gb-128gb-256gb.png',
        'papan-alat-bantu-push-up.png', 'jim-joker-sandal-slide-kulit-pria-bold-2s-hitam-hitam.png'];
        $product_id = [1,1,2,2,2,3,4,5];

        for ($i=0; $i < 8; $i++) { 
            DB::table('product_assets')->insert([
                'product_id' => $product_id[$i],
                'image' => $image[$i],
                'created_at' => now(), 
                'updated_at' => now()
            ]);
        }
    }
}
