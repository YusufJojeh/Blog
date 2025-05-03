<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Author;
use App\Models\Category;
use App\Models\Post;

class PostSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();
        $statuses = [ 'pending', 'approved', 'rejected' ];
        $categoryIds = Category::pluck( 'id' )->all();
        $authorIds = Author::pluck( 'id' )->all();

        for ( $i = 0; $i < 20; $i++ ) {
            $status = $faker->randomElement( $statuses );
            Post::create( [
                'title' => $faker->sentence,
                'content' => $faker->paragraphs( 3, true ),
                'image' => $faker->optional()->imageUrl( 640, 480, 'nature' ),
                'category_id' => $faker->optional()->randomElement( $categoryIds ),
                'author_id' => $faker->optional()->randomElement( $authorIds ),
                'status' => $status,
                'published_at' => $status === 'approved' ? $faker->dateTimeBetween( '-1 month' ) : null,
                'flagged' => $faker->boolean( 10 ),
            ] );
        }
    }
}