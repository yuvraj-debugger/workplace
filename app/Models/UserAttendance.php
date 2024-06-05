<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Traits\ModelLog;

class UserAttendance extends Model
{
    use HasFactory,ModelLog;

    protected $table = 'user_attendance';

    protected $tagName = 'user attendance';

    protected $fillable = [
        'user_id',
        'punch_in',
        'punch_out',
        'date',
        'total_hrs'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(UserAttendanceDetail::class, 'attendance_id');
    }

    public function breakTime()
    {
        $details = UserAttendanceDetail::where('attendance_id', $this->_id)->orderBy('_id')->get();
        $totalbhrs = 0;
        $totalbmins = 0;
        foreach ($details as $k => $detail) {
            if (@$details[$k + 1]['punch_in'] != '') {
                $btime1 = new \DateTime(date('Y-m-d H:i', $details[$k + 1]['punch_in']));
                $btime2 = new \DateTime(date('Y-m-d H:i', (int) $detail['punch_out']));
                $bdiff = $btime1->diff($btime2);
                $totalbhrs += $bdiff->h;
                $totalbmins += $bdiff->i;
            }
        }
        return date('H:i', mktime($totalbhrs, $totalbmins));
    }

    public function productionTime()
    {
        $details = UserAttendanceDetail::where('attendance_id', $this->_id)->orderBy('_id')->get();
        $totalphrs = 0;
        $totalpmins = 0;
        foreach ($details as $k => $detail) {
            if (@$detail['punch_in'] != '' && @$detail['punch_out'] != '') {
                $ptime1 = new \DateTime(date('Y-m-d H:i', $detail['punch_in']));
                $ptime2 = new \DateTime(date('Y-m-d H:i', (int) $detail['punch_out']));
                $pdiff = $ptime1->diff($ptime2);
                $totalphrs += $pdiff->h;
                $totalpmins += $pdiff->i;
            }
        }
        return date('H:i', mktime($totalphrs, $totalpmins));
    }

    public function getUserAttendance()
    {
        $user = User::where('_id', $this->user_id)->first();
        return $user;
    }

    public function getEmployeeSchedule()
    {
        
        $schedule = Schedule::where('employee_id', $this->user_id)->first();
        return $schedule;
    }

    public function getEmployeeShifts($shift_id)
    {
        $shifts = EmployeeShift::where('_id', $shift_id)->first();
        if (! empty($shifts)) {
            return ! empty($shifts) ? $shifts->shift_name : '';
        }
    }

    public function employeeSchedule($employee_id)
    {
        $employeeSchedule = Schedule::where('employee_id', $employee_id)->first();
        $defaultSchedule = User::where('_id',$employee_id)->first();
        $defaultShiftId = EmployeeShift::where('_id',$defaultSchedule->shift_id)->first();
        if(! empty($employeeSchedule)){
            return $employeeSchedule;
        }else{
            return $defaultShiftId;
            
        }
        
    }

    public function getEmployee()
    {
        $userName = User::where('_id', $this->user_id)->first();
        return ! empty($userName) ? $userName->first_name . ' ' . $userName->last_name : '';
    }
}