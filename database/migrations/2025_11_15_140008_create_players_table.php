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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('playing_experience')->default(0);
            $table->string('home_town')->nullable();
            $table->string('nationality')->nullable();
            $table->tinyInteger('role')->default(0)->comment('1:Wicket Keeper, 2: Batter, 3: Bowler, 4:All Rounder');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
