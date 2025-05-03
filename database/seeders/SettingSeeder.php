<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingSeeder extends Seeder {
    public function run(): void {
        $settings = [
            [ 'key' => 'site_name', 'value' => 'My Blog' ],
            [ 'key' => 'site_description', 'value' => 'A Laravel-powered blog platform' ],
            [ 'key' => 'posts_per_page', 'value' => '10' ],
            [ 'key' => 'maintenance_mode', 'value' => 'off' ],
        ];

        foreach ( $settings as $s ) {
            Setting::create( $s );
        }
    }
}