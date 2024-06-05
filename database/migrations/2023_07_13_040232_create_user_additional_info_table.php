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
        Schema::create('user_additional_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->enum('allergies',['yes','no',''])->default(''); 
            $table->enum('smoke',['yes','no',''])->default(''); 
            $table->enum('drink',['yes','no',''])->default(''); 
            $table->enum('diet',['veg','non-veg',''])->default(''); 
            $table->string('hobbies')->nullable();

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
        Schema::dropIfExists('user_additional_info');
    }
};
