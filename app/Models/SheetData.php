<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheetDataTable extends Migration
{
    public function up()
    {
        Schema::create('sheet_data', function (Blueprint $table) {
            $table->id();
            $table->string('column1');
            $table->string('column2');
            $table->string('column3');
            $table->string('column4');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sheet_data');
    }
}
