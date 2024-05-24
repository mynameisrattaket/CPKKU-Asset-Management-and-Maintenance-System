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
        Schema::create('user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_first_name', 80);
            $table->string('user_email', 80)->unique();
            $table->string('user_password', 80);
            $table->timestamp('user_Last_login_at')->useCurrent();
            $table->string('user_last_name', 80);
            $table->integer('faculty_faculty_id')->unsigned();
            $table->string('user_major', 80);
            $table->integer('user_type_id')->unsigned();
            
            $table->foreign('faculty_faculty_id')
                  ->references('faculty_id')->on('faculty')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('user_type_id')
                  ->references('user_type_id')->on('user_type')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->index('faculty_faculty_id', 'fk_user_faculty1_idx');
            $table->index('user_type_id', 'fk_user_user_type1_idx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
