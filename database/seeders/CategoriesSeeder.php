<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'ソーイング',
                'slug' => Str::slug('sewing'),
            ],
            [
                'name' => '編み物',
                'slug' => Str::slug('knitting'),
            ],
            [
                'name' => '刺繍',
                'slug' => Str::slug('embroidery'),
            ],
            [
                'name' => 'アクセサリー',
                'slug' => Str::slug('accessories'),
            ],
            [
                'name' => 'レジン',
                'slug' => Str::slug('resin'),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
