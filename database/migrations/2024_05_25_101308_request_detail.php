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
        Schema::create('request_detail', function (Blueprint $table) {
            $table->increments('request_detail_id'); // Primary key with auto increment
            $table->string('asset_number', 255)->nullable();
            $table->string('asset_name', 255)->nullable();
            $table->integer('request_repair_id')->unsigned(); // Foreign key
            $table->string('asset_symptom_detail', 255);
            $table->string('location', 255);
            $table->string('request_repair_note', 255)->nullable();

            // Foreign key constraint
            $table->foreign('request_repair_id')
                  ->references('request_repair_id')->on('request_repair')
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
        Schema::dropIfExists('request_detail');
    }
};
