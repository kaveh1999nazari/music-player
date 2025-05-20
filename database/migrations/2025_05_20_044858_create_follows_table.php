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
        Schema::create('user_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('following_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('artist_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('album_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('album_id')->constrained('albums')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('playlist_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('playlist_id')->constrained('playlists')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_follows');
        Schema::dropIfExists('artist_follows');
        Schema::dropIfExists('album_follows');
        Schema::dropIfExists('playlist_follows');
    }
};
