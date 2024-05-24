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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floor');
    }
};
