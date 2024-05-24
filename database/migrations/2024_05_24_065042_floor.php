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
        Schema::create('floor', function (Blueprint $table) {
            $table->increments('floor');
            $table->string('floor_number', 60);
            $table->integer('building_building')->unsigned();

            $table->foreign('building_building')
                  ->references('building')->on('building')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->index('building_building', 'fk_floor_building1_idx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floor');
    }
};
