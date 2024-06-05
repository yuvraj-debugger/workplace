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
        Schema::create('user_emergency_contact', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('name')->nullable();
            $table->string('relationship')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_two')->nullable();
            $table->string('email')->nullable();
            $table->string('email')->nullable();
            $table->enum('type',['primary','secondary'])->default('primary'); 

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
        Schema::dropIfExists('user_emergency_contact');
    }
};
