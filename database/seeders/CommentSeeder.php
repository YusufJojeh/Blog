<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\Admin;
use App\Models\Author;
use App\Models\Reader;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Bookmark;
use App\Models\Preference;

class CommentSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();
        $postIds = Post::pluck( 'id' )->all();
        $readerIds = Reader::pluck( 'id' )->all();

        foreach ( $postIds as $postId ) {
            $count = rand( 0, 5 );
            for ( $i = 0; $i < $count; $i++ ) {
                Comment::create( [
                    'post_id' => $postId,
                    'user_id' => $faker->randomElement( $readerIds ),
                    'content' => $faker->sentence,
                    'approved' => $faker->boolean( 70 ),
                    'flagged' => $faker->boolean( 5 ),
                ] );
            }
        }
    }
}
