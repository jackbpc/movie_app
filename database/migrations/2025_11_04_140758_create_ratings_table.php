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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Foreign key to movies table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Foreign key to users table
            $table->unsignedTinyInteger('rating'); // Rating value (e.g., 1-5)
            $table->text('comment')->nullable(); // Optional comment
            $table->timestamps();

            // Unique constraint to prevent a user from submitting more than one rating per movie
            $table->unique(['movie_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
