<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->string('location')->after('return_date')->nullable();
            $table->text('note')->after('location')->nullable();
        });
    }

    public function down()
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dropColumn(['location', 'note']);
        });
    }
};
