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
        Schema::create('employee_shift', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name')->nullable();
            $table->string('min_start_time')->nullable();
            $table->string('start_time')->nullable();
            $table->string('max_start_time')->nullable();
            $table->string('min_end_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('max_end_time')->nullable();
            $table->string('break_time')->nullable();
            $table->string('recurring_shift')->nullable();
            $table->string('repeat_every')->nullable();
            $table->string('week')->nullable();
            $table->string('add_note')->nullable();
            $table->integer('status')->default(0);
            $table->integer('type')->default(0);
            $table->integer('created_by')->default(0);
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
        Schema::dropIfExists('employee_shift');
    }
};
