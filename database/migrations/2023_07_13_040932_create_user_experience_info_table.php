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
        Schema::create('user_experience_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('company_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('employee_type')->nullable();
            $table->string('relevant_experience')->nullable();
            $table->string('skills')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('net_pay')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_state')->nullable();
            $table->string('company_country')->nullable();
            $table->string('company_pincode')->nullable();
            $table->string('company_website')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_designation')->nullable();
            $table->string('manager_contact')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('verification_status')->nullable();
            $table->string('leaving_reason')->nullable();
            $table->string('documents')->nullable();
            $table->date('period_from')->nullable();
            $table->date('period_to')->nullable();

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
        Schema::dropIfExists('user_experience_info');
    }
};
