<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // auto-increment primary key (unsignedBigInteger)
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id')->nullable(); // unsignedBigInteger type
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable(); // unsignedBigInteger type
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('set null');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};