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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->text('job')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('links_twitter')->nullable();
            $table->string('links_linkedin')->nullable();
            $table->string('links_facebook')->nullable();
            $table->string('links_instagram')->nullable();
            $table->string('links_youtube')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
