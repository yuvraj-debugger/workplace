<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class LeaveAllocation extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'employee_leaves_allocation';

    protected $tagName = 'employee leaves allocation';

    protected $fillable = [
        '_id',
        'user_id',
        'workplace_id',
        'date',
        'year',
        'casual_leave',
        'sick_leave',
        'bereavement_leave',
        'loss_of_pay_leave',
        'maternity_leave',
        'paternity_leave',
        'earned_leave',
        'months',
        'earned_months',
        'emergency_leave',
        'comp_off',
        'type',
        'status',
        'created_by'
    ];
}
