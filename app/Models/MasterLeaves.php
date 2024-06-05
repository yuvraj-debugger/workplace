<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class MasterLeaves extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'master_leaves';

    protected $tagName = 'master leaves';

    protected $fillable = [
        '_id',
        'office_casual_leave',
        'office_sick_leave',
        'office_bereavement_leave',
        'office_loss_of_pay_leave',
        'office_maternity_leave',
        'office_paternity_leave',
        'office_earned_leave',
        'home_casual_leave',
        'home_sick_leave',
        'home_bereavement_leave',
        'home_loss_of_pay_leave',
        'home_maternity_leave',
        'home_paternity_leave',
        'home_earned_leave',
        'office_materirty_paternity_months',
        'home_materirty_paternity_months',
        'office_earned_leave_months',
        'home_earned_leave_months',
        'status',
        'type',
        'created_by'
    ];
}
