<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'banho e corpo' => [
                'loções para o corpo e hidratantes' =>'',
                'desodorantes e antitranspirantes' =>'',
                'sabonetes para as mãos e para o corpo' =>'',
                'Óleos de banho' =>'',
            ],
            'cuidados com a pele' => [
                'tratamentos para acne e manchas' => '',
                'esfoliantes e loções de limpeza' => '',
                'loção e hidratante facial' => '',
                'protetor solar' => '',
                'tratamentos noturnos' => '',
                'produtos anti-idade' => '',
                'máscaras e tratamentos para os olhos' => '',
            ],
            'cuidado e estilização de cabelo' => [
                'xampus e condicionadores' => [
                    'condicionador' =>'',
                    'máscara' =>'',
                    'shampoos' =>'',
                ],
                'Óleos e protetores de cabelo' => '',
            ],
            'fragrâncias' => [
                'fragrâncias femininas' => '',
            ],
            'maquiagem' => [
                'maquiagem para os olhos' => [
                    'sombras para os olhos' => '',
                    'rímel' => '',
                ],
                'maquiagem para os lábios' => [
                    'batom' => '',
                    'brilho labial' => '',
                ],
                'maquiagem facial' => [
                    'bronzers e iluminadores' =>'',
                ],
            ],
            'cuidados com as unhas' => [
                'esmaltes e nail art' => [
                    'esmalte' => '',
                ],
            ],
            'fragrâncias para casa' => [
                'difusores e óleo de fragrância' => '',
            ],
            'artigos para animais de estimação' => '',
        ];

        $this->insertCategories(null, $categories);
    }

    protected function insertCategories($parentId, $categories)
    {
        foreach ($categories as $categoryName => $subCategories) {
            $categoryId = (string) Str::uuid();
            DB::table('categories')->insert([
                'id' => $categoryId,
                'name' => $categoryName,
                'parent_id' => $parentId ? : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!empty($subCategories) && is_array($subCategories)) {
                $this->insertCategories($categoryId, $subCategories);
            }
        }
    }
}
