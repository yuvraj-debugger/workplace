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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('nationality')->nullable(); 
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('spouse_employment')->nullable();
            $table->string('children')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_expiry_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('users');
        });
    }
};
