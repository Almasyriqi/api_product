<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama = ['Elektronik', 'Fashion Pria', 'Fashion Wanita', 'Handphone & Tablet', 'Olahraga'];

        for ($i=0; $i < 5; $i++) { 
            DB::table('categories')->insert([
                'nama' => $nama[$i],
            ]);
        }
    }
}
