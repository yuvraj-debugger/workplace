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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('photo')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('contact')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('reporting_manager')->nullable();
            $table->string('app_login')->nullable();
            $table->string('email_notification')->nullable();
            $table->string('workplace')->nullable();
            $table->integer('type')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('created_by')->default(0);
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
