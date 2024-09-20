<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();                      // primary key
            $table->timestamp('timestamp');    // เวลาแจ้งซ่อม
            $table->string('reporter_name');   // ชื่อผู้แจ้ง
            $table->string('asset_number');    // เลขครุภัณฑ์
            $table->string('asset_name');      // ชื่อครุภัณฑ์
            $table->text('symptom_detail');    // รายละเอียดอาการ
            $table->string('location');        // สถานที่
            $table->integer('status');         // สถานะ
            $table->text('note')->nullable();  // หมายเหตุ (nullable)
            $table->timestamps();              // created_at และ updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('repairs');
    }
}
