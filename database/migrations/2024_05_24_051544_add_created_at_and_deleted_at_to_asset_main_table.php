<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('asset_main', function (Blueprint $table) {
    //         //
    //         $table->timestamp('created_at')->nullable();
    //         $table->timestamp('deleted_at')->nullable();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_main', function (Blueprint $table) {
            //
        });
    }
};
