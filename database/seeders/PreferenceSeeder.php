<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\Models\Reader;
use App\Models\Category;

use App\Models\Preference;

class PreferenceSeeder extends Seeder {
    public function run(): void {
        $faker = Faker::create();
        $readerIds = Reader::pluck( 'id' )->all();
        $categoryIds = Category::pluck( 'id' )->all();

        foreach ( $readerIds as $readerId ) {
            $prefCats = $faker->randomElements( $categoryIds, rand( 1, count( $categoryIds ) ) );
            Preference::create( [
                'reader_id' => $readerId,
                'categories' => json_encode( $prefCats ),
                'email_notifications' => $faker->boolean( 50 ),
            ] );
        }
    }
}
