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
        Schema::create('user_joining_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->date('confirmation_date')->nullable();
            $table->string('notice_period')->nullable();
            $table->string('probation_period')->nullable();
            $table->text('other_terms')->nullable();
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
        Schema::dropIfExists('user_joining_detail');
    }
};
