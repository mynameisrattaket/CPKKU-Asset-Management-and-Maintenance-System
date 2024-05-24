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
        Schema::create('room', function (Blueprint $table) {
            $table->increments('room_id');
            $table->string('room_number', 65);
            $table->integer('floor_id')->unsigned();
            $table->integer('building_id')->unsigned();

            $table->foreign('floor_id')
                  ->references('floor')->on('floor')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('building_id')
                  ->references('building')->on('building')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->primary('room_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room');
    }
};
