<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class Schedule extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'shift_schedule';

    protected $tagName = 'shift schedule';

    protected $fillable = [

        '_id',
        'department_id',
        'employee_id',
        'date',
        'from_date',
        'to_date',
        'shifts_id',
        'min_start_time',
        'start_time',
        'max_start_time',
        'min_start_time',
        'end_time',
        'max_end_time',
        'break_time',
        'status',
        'type',
        'created_by',
        'notes'
    ];

    public function getUser()
    {
        $user = User::where('_id', $this->employee_id)->first();
        return $user;
    }

    public function getUserImage()
    {
        $userImage = User::where('_id', $this->employee_id)->first();
        return ! empty($userImage) ? $userImage->photo : '';
    }

    public function getDepartment()
    {
        $department = Employeedepartment::where('_id', $this->department_id)->first();
        return $department;
    }
}
