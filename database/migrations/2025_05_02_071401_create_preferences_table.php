<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('preferences', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reader_id')->constrained('readers')->onDelete('cascade');
        $table->json('categories')->nullable();
        $table->boolean('email_notifications')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
