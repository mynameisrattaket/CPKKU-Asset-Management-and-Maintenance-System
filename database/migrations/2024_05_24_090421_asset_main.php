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
        Schema::create('asset_main', function (Blueprint $table) {
            $table->integer('asset_id')->unsigned();
            $table->string('asset_name', 255);
            $table->string('asset_number', 255);
            $table->string('asset_s/n_number', 255)->nullable();
            $table->string('asset_countingunit', 255);
            $table->integer('asset_price');
            $table->timestamp('asset_regis_at')->useCurrent();
            $table->timestamp('asset_created_at')->useCurrent();
            $table->string('asset_live', 255);
            $table->integer('asset_scrap_price');
            $table->integer('asset_deteriorated');
            $table->integer('asset_deteriorated_price');
            $table->date('asset_deteriorated_at');
            $table->date('asset_deteriorated_end');
            $table->integer('asset_price_account');
            $table->integer('asset_deteriorated_total');
            $table->string('asset_deteriorated_account', 255);
            $table->string('asset_deteriorated_total_account', 255);
            $table->string('asset_account', 255);
            $table->string('asset_code', 255);
            $table->string('asset_brand', 255);
            $table->integer('asset_amount');
            $table->dateTime('asset_warranty_start')->nullable();
            $table->dateTime('asset_warranty_end')->nullable();
            $table->integer('asset_status_id')->unsigned();
            $table->integer('user_import_id')->unsigned();
            $table->string('asset_detail', 255)->nullable();
            $table->string('asset_paln', 255);
            $table->string('asset_project', 255);
            $table->string('asset_activity', 255);
            $table->string('asset_budget', 255);
            $table->string('asset_fund', 255);
            $table->string('asset_major', 255);
            $table->string('asset_location', 255);
            $table->string('asset_reception_type', 255);
            $table->string('asset_document_number', 255);
            $table->string('asset_get', 255);
            $table->date('asset_deteriorated_stop')->nullable();
            $table->string('asset_type', 255)->nullable();
            $table->string('asset_comment', 255)->nullable();
            $table->string('asset_how', 255)->nullable();
            $table->string('asset_company', 255)->nullable();
            $table->string('asset_company_address', 255)->nullable();
            $table->string('asset_type_sub', 255)->nullable();
            $table->string('asset_type_main', 255)->nullable();
            $table->string('asset_revenue', 255)->nullable();
            $table->string('asset_img', 255)->nullable();
            $table->integer('room_room_id')->unsigned();
            $table->integer('room_floor_id')->unsigned();
            $table->integer('room_building_id')->unsigned();
            $table->integer('faculty_faculty_id')->unsigned();

            $table->primary('asset_id');

            $table->foreign('asset_status_id')
                  ->references('asset_status_id')->on('asset_status')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('user_import_id')
                  ->references('user_id')->on('user')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('room_room_id')
                  ->references('room_id')->on('room')
                  ->onDelete('no action')
                  ->onUpdate('no action');

            $table->foreign('faculty_faculty_id')
                  ->references('faculty_id')->on('faculty')
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
        Schema::dropIfExists('asset_main');
    }
};
