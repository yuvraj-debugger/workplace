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
    public function up(){
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_form')->nullable();
            $table->string('max_allowed')->nullable();
            $table->string('max_consecutive_allowed')->nullable();
            $table->string('approval_required')->nullable();
            $table->string('notification_apply')->nullable();
            $table->string('appraisal_effect')->nullable();
            $table->string('experience_effect')->nullable();
            $table->string('extend_appraisal')->nullable();
            $table->string('reduce_experience')->nullable();
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
        Schema::dropIfExists('leave_types');
    }
};
