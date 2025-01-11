<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInBorrowRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->string('status', 20)->change(); // เพิ่มขนาดของคอลัมน์ status เป็น VARCHAR(20)
        });
    }

    public function down()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->string('status', 10)->change(); // ลดขนาดกลับไปเป็น VARCHAR(10) หาก rollback
        });
    }
}
