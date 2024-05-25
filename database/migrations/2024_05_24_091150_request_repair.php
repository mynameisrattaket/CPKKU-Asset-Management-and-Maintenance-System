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
        Schema::create('request_repair', function (Blueprint $table) {
            $table->increments('request_repair_id');
            $table->timestamp('request_repair_at')->useCurrent();
            $table->integer('repair_status_id')->unsigned();
            $table->integer('user_user_id')->unsigned();
            

            $table->foreign('repair_status_id')
                  ->references('repair_status_id')->on('repair_status')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('user_user_id')
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
        Schema::dropIfExists('request_repair');
    }
};
