<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\Model;
class LeaveSetting extends Model
{
    use HasFactory;
    protected $table='leave_settings';
    protected $fillable = [
        'payroll_component','normal', 'adoptive', 'miscarriage' , 'normal_max_week_before_expected','normal_max_week_after_expected','normal_doj_month_old','normal_credit_resigned','normal_credit_probation','normal_wfh','normal_wfh_permanent','normal_wfh_temporary','normal_permanent_max_week_before','normal_temporary_max_week_before','normal_permanent_max_week_after','normal_temporary_max_week_after','normal_not_clubbed', 'adoptive_doj_month_old','adoptive_credit_resigned','adoptive_credit_probation','adoptive_wfh','adoptive_wfh_status','adoptive_permanent_max_week_before','adoptive_temporary_max_week_before','adoptive_permanent_max_week_after','adoptive_temporary_max_week_after','adoptive_not_clubbed', 'miscarriage_doj_month_old','miscarriage_credit_resigned','miscarriage_credit_probation','miscarriage_wfh','miscarriage_wfh_status','miscarriage_permanent_max_week_before','miscarriage_temporary_max_week_before','miscarriage_permanent_max_week_after','miscarriage_temporary_max_week_after','miscarriage_not_clubbed','adoptive_max_week_after_expected','miscarriage_max_week_after_expected', 'approval_required', 'approval_days', 'notification_apply', 'notification', 'effect_appraisal', 'increase_appraisal', 'effect_experience', 'reduce_experience'
    ];
}


