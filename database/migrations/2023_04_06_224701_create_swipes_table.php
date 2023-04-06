<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwipesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('swipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('swiper_id');
            $table->unsignedBigInteger('swiped_id');
            $table->boolean('liked');
            $table->timestamps();

            $table->foreign('swiper_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('swiped_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['swiper_id', 'swiped_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swipes');
    }
}
