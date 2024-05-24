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
        // Drop existing tables if they exist
        Schema::dropIfExists('room');
        Schema::dropIfExists('floor');
        Schema::dropIfExists('building');

        // Create building table
        Schema::create('building', function (Blueprint $table) {
            $table->bigIncrements('building_id');
            $table->string('building_name', 255);
            $table->timestamps();
        });

        // Create floor table
        Schema::create('floor', function (Blueprint $table) {
            $table->increments('floor_id');
            $table->string('floor_number', 60);
            $table->unsignedBigInteger('building_id');

            $table->foreign('building_id')
                  ->references('building_id')->on('building')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->index('building_id', 'fk_floor_building1_idx');
            $table->timestamps();
        });

        // Create room table
        Schema::create('room', function (Blueprint $table) {
            $table->increments('room_id');
            $table->string('room_number', 65);
            $table->unsignedInteger('floor_id');
            $table->unsignedBigInteger('building_id');

            $table->foreign('floor_id')
                  ->references('floor_id')->on('floor')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('building_id')
                  ->references('building_id')->on('building')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop room table first to remove foreign key constraints
        Schema::dropIfExists('room');

        // Drop floor table
        Schema::dropIfExists('floor');

        // Drop building table
        Schema::dropIfExists('building');
    }
};

