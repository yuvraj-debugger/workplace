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
        Schema::create('user_bank_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('username')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('pan')->nullable();

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
        Schema::dropIfExists('user_bank_info');
    }
};
