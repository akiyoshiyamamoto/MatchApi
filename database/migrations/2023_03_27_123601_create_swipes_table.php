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
        Schema::create('swipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('swiper_id');
            $table->unsignedBigInteger('swipee_id');
            $table->enum('direction', ['left', 'right']);
            $table->timestamps();

            $table->foreign('swiper_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('swipee_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swipes');
    }
};
