<?php
// database/seeders/AuthorSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder {
    public function run(): void {
        // مؤلف ثابت
        Author::factory()->create( [
            'name'  => 'John Writer',
            'email' => 'author@example.com',
        ] );

        // مؤلفون عشوائيون
        Author::factory( 9 )->create();
    }
}