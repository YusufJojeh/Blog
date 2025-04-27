<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('status', ['pending','approved','rejected'])
                  ->default('pending')
                  ->change();

            $table->boolean('flagged')
                  ->default(false)
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('status', ['draft','published'])
                  ->default('draft')
                  ->change();

            $table->dropColumn('flagged');
        });
    }
};
