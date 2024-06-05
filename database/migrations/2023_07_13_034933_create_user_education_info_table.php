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
        Schema::create('user_education_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->date('starting_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->string('institute')->nullable();
            $table->string('degree')->nullable();
            $table->string('grade')->nullable();
            $table->string('document')->nullable();

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
        Schema::dropIfExists('user_education_info');
    }
};
