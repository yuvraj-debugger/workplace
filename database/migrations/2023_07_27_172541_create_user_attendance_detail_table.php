<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attendance_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->index();
            $table->string('punch_in')->nullable();
            $table->string('punch_out')->nullable();
            $table->string('total_hrs')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_attendance_detail');
    }
};