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
        Schema::create('user_address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('current_country_id')->nullable();
            $table->foreignId('current_state_id')->nullable();
            $table->foreignId('current_city_id')->nullable();
            $table->string('current_zipcode')->nullable();
            $table->string('current_address')->nullable();
            $table->foreignId('permanent_country_id')->nullable();
            $table->foreignId('permanent_state_id')->nullable();
            $table->foreignId('permanent_city_id')->nullable();
            $table->string('permanent_zipcode')->nullable();
            $table->string('permanent_address')->nullable();
            $table->enum('present',['0','1'])->default('0'); 

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
        Schema::dropIfExists('user_address');
    }
};
