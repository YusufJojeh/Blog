<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // شغِّل seeders الفرعيّة
        $this->call( [
            AdminSeeder::class,
            AuthorSeeder::class,
            ReaderSeeder::class,
        ] );
    }
}