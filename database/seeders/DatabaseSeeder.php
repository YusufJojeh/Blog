<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call( [
            AdminSeeder::class,
            AuthorSeeder::class,
            ReaderSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            SettingSeeder::class,
            BookmarkSeeder::class,
            PreferenceSeeder::class,
        ] );
    }
}
