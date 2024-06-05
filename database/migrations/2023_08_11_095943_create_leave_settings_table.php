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
        
        Schema::create('leave_settings', function (Blueprint $table) {
            $table->id();
            $table->string('payroll_component')->nullable();
            $table->string('max_week_before_expected')->nullable();
            $table->string('max_week_after_expected')->nullable();
            $table->string('doj_month_old')->nullable();
            $table->string('credit_resigned')->nullable();
            $table->string('credit_probation')->nullable();
            $table->string('wfh')->nullable();
            $table->string('wfh_status')->nullable();
            $table->string('permanent_max_week_before')->nullable();
            $table->string('temporary_max_week_before')->nullable();
            $table->string('permanent_max_week_after')->nullable();
            $table->string('temporary_max_week_after')->nullable();
            $table->string('normal_not_clubbed')->nullable();
            $table->string('adoptive_doj_month_old')->nullable();
            $table->string('adoptive_credit_resigned')->nullable();
            $table->string('adoptive_credit_probation')->nullable();
            $table->string('adoptive_wfh')->nullable();
            $table->string('adoptive_wfh_status')->nullable();
            $table->string('adoptive_permanent_max_week_before')->nullable();
            $table->string('adoptive_temporary_max_week_before')->nullable();
            $table->string('adoptive_permanent_max_week_after')->nullable();
            $table->string('adoptive_temporary_max_week_after')->nullable();
            $table->string('adoptive_not_clubbed')->nullable();
            $table->string('miscarriage_doj_month_old')->nullable();
            $table->string('miscarriage_credit_resigned')->nullable();
            $table->string('miscarriage_credit_probation')->nullable();
            $table->string('miscarriage_wfh')->nullable();
            $table->string('miscarriage_wfh_status')->nullable();
            $table->string('miscarriage_permanent_max_week_before')->nullable();
            $table->string('miscarriage_temporary_max_week_before')->nullable();
            $table->string('miscarriage_permanent_max_week_after')->nullable();
            $table->string('miscarriage_temporary_max_week_after')->nullable();
            $table->string('miscarriage_not_clubbed')->nullable();
            $table->string('adoptive_max_week_after_expected')->nullable();
            $table->string('miscarriage_max_week_after_expected')->nullable();
            $table->string('normal_wfh_permanent')->nullable();
            $table->string('normal_wfh_temporary')->nullable();
            $table->string('miscarriage_max_week_after_expected')->nullable();
            $table->string('approval_required')->nullable();
            $table->string('approval_days')->nullable();
            $table->string('notification_apply')->nullable();
            $table->string('notification')->nullable();
            $table->string('effect_appraisal')->nullable();
            $table->string('increase_appraisal')->nullable();
            $table->string('effect_experience')->nullable();
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
        Schema::dropIfExists('leave_settings');
    }
};
