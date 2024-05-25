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
        Schema::create('repair_detail', function (Blueprint $table) {
            $table->increments('repair_detail_id'); // Primary key with auto increment
            $table->integer('repair_repair_id')->unsigned(); // Foreign key
            $table->string('repair_detail', 500)->nullable();
            $table->integer('request_detaill_id')->unsigned(); // Foreign key

            // // Indexes
            // $table->index(['repair_repairl_id', 'request_repair_id'], 'fk_repair_detail_repair1_idx');
            // $table->index('request_detaill_id', 'fk_repair_detail_request_detail1_idx');

            // Foreign key constraints
            $table->foreign('repair_repair_id')
                  ->references('repair_id')->on('repair')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('request_detaill_id')
                  ->references('request_detail_id')->on('request_detail')
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
        Schema::dropIfExists('repair_detail');
    }
};
