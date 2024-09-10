<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    private $brands = [
        'O Boticário',
        'Quem Disse, Berenice?',
        'O.U.I',
        'Eudora',
        'Creamy',
        'Skelt',
        'L\'Occitane Au Brésil',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->brands as $brand) {
            DB::table('brands')->insert([
                'id' => Str::uuid(),
                'name' => $brand,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
