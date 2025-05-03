<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Reader;
use App\Models\Post;

use App\Models\Bookmark;

class BookmarkSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();
        $readerIds = Reader::pluck( 'id' )->all();
        $postIds = Post::pluck( 'id' )->all();

        foreach ( $readerIds as $readerId ) {
            $count = rand( 0, 5 );
            $bookmarks = $faker->randomElements( $postIds, $count );
            foreach ( $bookmarks as $postId ) {
                Bookmark::create( [
                    'reader_id' => $readerId,
                    'post_id' => $postId,
                ] );
            }
        }
    }
}