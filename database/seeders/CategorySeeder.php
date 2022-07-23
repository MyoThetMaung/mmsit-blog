<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Technology','Education','Politic','Health','Travel'];
            foreach($categories as $category){
                \App\Models\Category::factory()->create([
                    'title'     => $category,
                    'slug'      => Str::slug($category),
                    'user_id'   => rand(1,11),
                ]);
            }
    }
}
