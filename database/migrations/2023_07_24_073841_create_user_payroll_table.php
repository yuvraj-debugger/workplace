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
        Schema::create('user_payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->integer('annual_ctc')->nullable();
            $table->integer('basic_salary')->nullable();
            $table->integer('allowances')->nullable();
            $table->integer('deductions')->nullable();

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
        Schema::dropIfExists('user_payroll');
    }
};
