<?php
// database/seeders/ReaderSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reader;

class ReaderSeeder extends Seeder {
    public function run(): void {
        // قارئ ثابت
        Reader::factory()->create( [
            'name'  => 'Jane Reader',
            'email' => 'reader@example.com',
        ] );

        // قرّاء عشوائيون
        Reader::factory( 19 )->create();
    }
}