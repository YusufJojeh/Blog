<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder {
    public function run(): void {
        $categories = [
            [ 'name' => 'Technology', 'image' => 'categories/tech.jpg' ],
            [ 'name' => 'Health', 'image' => 'categories/health.jpg' ],
            [ 'name' => 'Lifestyle', 'image' => 'categories/lifestyle.jpg' ],
            [ 'name' => 'Travel', 'image' => 'categories/travel.jpg' ],
            [ 'name' => 'Food', 'image' => 'categories/food.jpg' ],
        ];

        foreach ( $categories as $cat ) {
            Category::create( $cat );
        }
    }
}
