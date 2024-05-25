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
        Schema::create('repair', function (Blueprint $table) {
            $table->increments('repair_id');
            $table->integer('request_repair_id')->unsigned();
            $table->integer('user_repair_by')->unsigned();
            

            $table->foreign('request_repair_id')
                  ->references('request_repair_id')->on('request_repair')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('user_repair_by')
                  ->references('user_id')->on('user')
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
        Schema::dropIfExists('repair');
    }
};
