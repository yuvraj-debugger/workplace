<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'leave_types';

    protected $fillable = [

        'name',
        'short_form',
        'type',
        'normal',
        'adoptive',
        'miscarriage',
        'max_allowed',
        'max_consecutive_allowed',
        'approval_required',
        'notification_apply',
        'appraisal_effect',
        'experience_effect',
        'extend_appraisal',
        'reduce_experience'
    ];
}
