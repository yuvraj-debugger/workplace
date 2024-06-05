<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class EmployeeShift extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'employee_shift';

    protected $tagName = 'employee shift';
    
    protected $fillable = [

        'shift_name',
        'min_start_time',
        'start_time',
        'max_start_time',
        'min_end_time',
        'end_time',
        'max_end_time',
        'break_time',
        'recurring_shift',
        'repeat_every',
        'week',
        'add_note',
        'status',
        'type',
        'created_by'
    ];
}
