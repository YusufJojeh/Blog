<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder {
    public function run(): void {
        // مشرف رئيسي ثابت
        Admin::create( [
            'name'     => 'Super Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make( 'password' ),
        ] );

        // مشرفين عشوائيين
        Admin::factory( 4 )->create();
    }
}
