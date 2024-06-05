<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserAttendance;
use App\Models\UserAttendanceDetail;
use App\Models\Holiday;
use App\Models\Leave;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\Role;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Notification;
use App\Models\EmployeeSalary;
use App\Models\EmployeeShift;

class HomeEmployee extends Component
{

    public $heading;

    use WithPagination;

    public $emp_id, $user_id, $monthlytotal, $todaytotal, $weeklytotal, $totalMonthlyhrs, $totalWeeklyhrs, $todayremainingtotal, $todaytotalsecs, $weeklytotalsecs, $monthlytotalsecs, $todayremainingtotalsecs, $month, $year, $todaytotalbreak, $todaytotalovertime, $todaytotalovertimesecs, $monthlytotalovertime, $monthlytotalovertimesecs, $dateFilter;

    public $attendances = [];

    public $punch_in, $punch_out, $date, $total_hrs, $attendanceStatus = '';

    public function mount()
    {
        $this->emp_id = $this->emp_id == '' ? Auth::user()->_id : $this->emp_id;
        $this->user_id = $this->emp_id;
        $this->month = date('m');
        $this->year = date('Y');
        $this->date = '';

        $startDate = date('Y-m-d 00:00:00', strtotime('now'));
        $endDate = date('Y-m-d 23:59:59', strtotime('now'));
        $today = date('Y-m-d', strtotime('now'));
        $attendance = UserAttendance::where([
            'user_id' => $this->user_id
        ])->whereBetween('date', [
            strtotime($startDate),
            strtotime($endDate)
        ])->first();
        if (! empty($attendance)) {
            $attendanceDetails = UserAttendanceDetail::where('attendance_id', $attendance['_id'])->orderBy('_id', 'desc')->first();

            if (! empty($attendanceDetails)) {
                if (@$attendanceDetails['punch_out'] != '') {
                    $this->attendanceStatus = '';
                } else {
                    $this->attendanceStatus = '1';
                }
            } else {
                $this->attendanceStatus = '';
            }
        }
        $sMonth = new Carbon('first day of this month');
        $weekStart = date('Y-m-d', strtotime("this week"));
        $weekEnd = date('Y-m-d', strtotime('+6 days', strtotime($weekStart)));

        $monthStart = date('Y-m-d', strtotime($sMonth));
        $monthEnd = date('Y-m-t', strtotime($sMonth));
        $maxDays = date('t');
        $totalMonthlyHolidays = Holiday::whereBetween('date', [
            strtotime($monthStart),
            strtotime($monthEnd)
        ])->count();
        $totalWeeklyHolidays = Holiday::whereBetween('date', [
            strtotime($weekStart),
            strtotime($weekEnd)
        ])->count();
        $totalMonthDays = (int) $maxDays - (int) $totalMonthlyHolidays;
        $totalWeekDays = 7 - (int) $totalWeeklyHolidays;
        $this->totalMonthlyhrs = $totalMonthDays * 8;
        $this->totalWeeklyhrs = $totalWeekDays * 8;

        $this->attendances = UserAttendance::with('details')->where([
            'user_id' => $this->user_id,
            'date' => strtotime($today)
        ])->first();

        $monthlyAttendances = UserAttendance::with('details')->where([
            'user_id' => $this->user_id
        ])
            ->whereBetween('date', [
            strtotime($monthStart),
            strtotime($today)
        ])
            ->get()
            ->toArray();
        $monthlyhrs = 0;
        $monthlymins = 0;
        $weeklyhrs = 0;
        $weeklymins = 0;
        $todayhrs = 0;
        $todaymins = 0;
        $totalbhrs = 0;
        $totalbmins = 0;
        $totalbsecs = 0;
        $extrahrs = 0;
        $extramins = 0;

        foreach ($monthlyAttendances as $attendanceData) {
            foreach ($attendanceData['details'] as $k => $attdanceData) {
                if (($attdanceData['punch_in'] != '' && $attdanceData['punch_out'] != '') || ($attendanceData['date'] == strtotime($today) && $this->attendanceStatus == '1')) {
                    $time1 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_in']));
                    if ($attendanceData['date'] == strtotime($today) && (! empty($attendanceData['punch_out']) ? ($attendanceData['punch_out'] == '') : '')) {
                        $time2 = new \DateTime(date('Y-m-d H:i', strtotime('now')));
                    } else {
                        $time2 = new \DateTime(date('Y-m-d H:i', (int) $attdanceData['punch_out']));
                    }
                    $diff = $time1->diff($time2);
                    $h = $diff->h;
                    $i = $diff->i;
                    $s = $diff->s;
                    $monthlyhrs += $h;
                    $monthlymins += $i;
                    if ($attendanceData['date'] >= strtotime($weekStart) && $attendanceData['date'] <= strtotime($today)) {
                        $weeklyhrs += $h;
                        $weeklymins += $i;
                    }

                    if ($attendanceData['date'] == strtotime($today)) {
                        $todayhrs += $h;
                        $todaymins += $i;
                        if (@$attdanceData[$k + 1]['punch_in'] != '') {
                            $btime1 = new \DateTime(date('Y-m-d H:i', $attdanceData[$k + 1]['punch_in']));
                            $btime2 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_out']));
                            $bdiff = $btime1->diff($btime2);
                            $totalbhrs += $bdiff->h;
                            $totalbmins += $bdiff->i;
                            $totalbsecs += $bdiff->s;

                            $totalArray[] = $bdiff->i;
                        }
                    }
                }
            }
        }

        $todayremaininghrs = 8 - $todayhrs;
        $todayremainingmins = 60 - $todaymins;

        $this->weeklytotal = date('H:i', mktime($weeklyhrs, $weeklymins));
        $this->monthlytotal = date('H:i', mktime($monthlyhrs, $monthlymins));
        $this->todaytotal = date('H:i', mktime($todayhrs, $todaymins));
        $this->todaytotalsecs = ($todayhrs * 60 * 60) + ($todaymins * 60);
        if ($this->todaytotalsecs > 10000) {
            $otime1 = new \DateTime(date('H:i', strtotime($this->todaytotal)));
            $otime2 = new \DateTime(date('H:i', strtotime('08:00')));
            $odiff = $otime1->diff($otime2);
            $this->todaytotalovertime = date('H:i', mktime($odiff->h, ($odiff->i)));
        } else {
            $this->todaytotalovertime = '00:00';
        }

        $this->todaytotalbreak = date('H:i', mktime($totalbhrs, ($totalbmins)));
        $this->weeklytotalsecs = ($weeklyhrs * 60 * 60) + ($weeklymins * 60);
        $this->monthlytotalsecs = ($monthlyhrs * 60 * 60) + ($monthlymins * 60);

        $t1 = new \DateTime(date('H:i', strtotime($this->todaytotal)));
        $t2 = new \DateTime(date('H:i', strtotime('08:00')));
        $d = $t1->diff($t2);

        $this->todayremainingtotal = date('H:i', mktime($d->h, $d->i));
        $this->todayremainingtotalsecs = ($d->h * 60 * 60) + ($d->i * 60);
    }

    public function render()
    {
        $today = date('Y-m-d', strtotime('now'));

        $sMonth = new Carbon('first day of this month');
        $weekStart = date('Y-m-d', strtotime("this week"));
        $weekEnd = date('Y-m-d', strtotime('+6 days', strtotime($weekStart)));

        $monthStart = date('Y-m-d', strtotime($sMonth));
        $monthEnd = date('Y-m-t', strtotime($sMonth));
        $maxDays = date('t');
        $totalMonthlyHolidays = Holiday::whereBetween('date', [
            strtotime($monthStart),
            strtotime($monthEnd)
        ])->count();
        $totalWeeklyHolidays = Holiday::whereBetween('date', [
            strtotime($weekStart),
            strtotime($weekEnd)
        ])->count();
        $totalMonthDays = (int) $maxDays - (int) $totalMonthlyHolidays;
        $totalWeekDays = 7 - (int) $totalWeeklyHolidays;
        $this->totalMonthlyhrs = $totalMonthDays * 8;
        $this->totalWeeklyhrs = $totalWeekDays * 8;

        $this->attendances = UserAttendance::where([
            'user_id' => $this->user_id,
            'date' => strtotime($today)
        ])->first();

        if (! empty($this->attendances)) {
            if (empty($this->attendances->punch_out)) {
                $this->attendanceStatus = 1;
            }
        }

        $heading = $this->heading;
        $holidays = Holiday::orderBy('date', 'ASC')->where('date', '>=', date('Y-m-d'))->paginate(4);

        $startDate = date('Y-m-d', strtotime('-1 day'));

        $employeeBirthday = User::where('_id', Auth::user()->id)->where('date_of_birth', 'LIKE', '%' . date('m-d'))->first();
        $employeeWorkAnniversary = User::where('_id', Auth::user()->id)->where('joining_date', 'LIKE', '%' . date('m-d'))->first();

        $leave = Leave::where('str_from_date', '>', strtotime($startDate))->orWhere('str_to_date', '<', strtotime($startDate))
            ->where('status', '1')
            ->where('name', Auth::user()->_id)
            ->orderBy('from_date', 'DESC')
            ->get();

        $leavePending = Leave::where('status', '1')->get();
        
        
        $userTodayTime = UserAttendance::where('user_id',$this->user_id)->where('date', strtotime(date('Y-m-d')))->first();
        //         dd(date('H:i',$userTodayTime->punch_in));
        $punchOutTime = ! empty($userTodayTime) ? $userTodayTime->punch_out : '';
        $scheduleCheck = Schedule::where('employee_id', $this->user_id)->first();
        $defaultShift = User::where('_id',$this->user_id)->first();
        $employeeShift = EmployeeShift::where('_id',$defaultShift->shift_id)->first();
        $maxdefaultTime = ! empty($employeeShift) ? strtotime($employeeShift->max_end_time) : '';
        $mindefaultTime = ! empty($employeeShift) ? strtotime($employeeShift->min_start_time) : '';
        $maxEndTime = ! empty($scheduleCheck) ? strtotime($scheduleCheck->max_end_time) : '';
        $overTime = '00:00';
        $overAllTime = '';
        
        
        
        if(! empty($scheduleCheck)){
            if((! empty($punchOutTime)) && ($punchOutTime > $maxEndTime)){
                $timeDiff = round(abs($punchOutTime - $maxEndTime) / 60,2);
                if (! empty($timeDiff)) {
                    $Maxminutes = ($timeDiff % 60);
                    $overTime = '0'.floor($timeDiff / 60) . ".".$Maxminutes;
                }
                
            }
            
        }else{
            
            
            if((! empty($punchOutTime)) && ($punchOutTime > $maxdefaultTime)){
                
                
                if($userTodayTime->punch_in < $mindefaultTime ){
                    $starttimeDiff = round(abs($userTodayTime->punch_in - $mindefaultTime) / 60,2);
                    $StartMaxminutes = ($starttimeDiff % 60);
                    $StartoverTime = '0'.floor($starttimeDiff / 60) . ":".$StartMaxminutes;
                }
                
                
                $timeDiff = round(abs($punchOutTime - $maxdefaultTime) / 60,2);
                if (! empty($timeDiff)) {
                    $Maxminutes = ($timeDiff % 60);
                    $overTime = '0'.floor($timeDiff / 60) . ".".$Maxminutes;
                    $overAllTimediff = $timeDiff + $starttimeDiff;
                    $MaxminutesOver = ($overAllTimediff % 60);
                    $overAllTime = '0'.floor($overAllTimediff / 60) . ":".$MaxminutesOver;
                    
                    //                     dd($overAllTime);
                    
                }
                
            }
        }
        return view('livewire.home-employee', compact('heading', 'holidays', 'leave', 'leavePending', 'employeeBirthday', 'employeeWorkAnniversary','overTime','overAllTime'));
    }

    public function getOvertime()
    {
        $monthFirst = date('Y-m-01');
        $monthEnd = (date('Y-m-t'));
        $total = 0;
        for ($monthFirst; $monthFirst <= $monthEnd; ++ $monthFirst) {
            $userAttendance = UserAttendance::select('punch_in', 'punch_out')->where('date', strtotime($monthFirst))
                ->where('user_id', $this->emp_id)
                ->get();
            foreach ($userAttendance as $userTime) {
                if ($userTime->punch_out == '') {
                    continue;
                }
                $time = $userTime->punch_out - $userTime->punch_in;
                $total = $total + $time;
            }
        }

        $totalTime = 9 * 22 * 60 * 60;
        if ($total > $totalTime) {
            $totalTime = $total - $totalTime;
            return gmdate('H:i:s', $totalTime);
        } else {
            return '00:00';
        }
    }

    public function mark()
    {
        $today = date('Y-m-d', strtotime('now'));
        $status = $this->attendanceStatus == '1' ? 'in' : 'out';
        if ($status == 'out') {
            $attendance = UserAttendance::where([
                'user_id' => $this->user_id,
                'date' => strtotime($today)
            ])->first();
            if (empty($attendance)) {
                $attendance = UserAttendance::where([
                    'user_id' => $this->user_id
                ])->orderBy('_id', 'desc')->first();
                $attendancedetail = UserAttendanceDetail::where('attendance_id', $attendance->_id)->where('punch_in', '!=', '')
                    ->where('punch_out', '')
                    ->first();
                UserAttendance::where('_id', $attendance->_id)->update([
                    'punch_out' => $attendancedetail->punch_in
                ]);
                $this->attendanceStatus = 1;
            } else {

                $attendancedetail = UserAttendanceDetail::where('attendance_id', $attendance->_id)->where('punch_in', '!=', '')
                    ->where('punch_out', '')
                    ->first();

                UserAttendanceDetail::where('_id', $attendancedetail->_id)->update([
                    'punch_out' => strtotime('now')
                ]);
                UserAttendance::where('_id', $attendance->_id)->update([
                    'punch_out' => strtotime('now')
                ]);
                $this->attendanceStatus = 0;
            }
        } else {
            $attendance = UserAttendance::where([
                'user_id' => $this->user_id,
                'date' => strtotime($today)
            ])->first();
            if (! empty($attendance)) {
                UserAttendanceDetail::create([
                    'attendance_id' => $attendance->_id,
                    'punch_in' => strtotime('now'),
                    'punch_out' => '',
                    'total_hrs' => '',
                    'date' => strtotime($today)
                ]);
            } else {
                $attendance = UserAttendance::create([
                    'user_id' => $this->user_id,
                    'punch_in' => strtotime('now'),
                    'punch_out' => '',
                    'total_hrs' => '',
                    'date' => strtotime($today)
                ]);
                UserAttendanceDetail::create([
                    'attendance_id' => $attendance->_id,
                    'punch_in' => strtotime('now'),
                    'punch_out' => '',
                    'total_hrs' => ''
                ]);
                $employeeSchedule = Schedule::where('employee_id', $this->user_id)->first();
                $userShift = User::where('_id',$this->user_id)->first();
                $defaultShift = EmployeeShift::where('_id',$userShift->shift_id)->first();
                if (! empty($employeeSchedule)) {
                    if (strtotime($employeeSchedule->max_start_time) < $attendance->punch_in) {
                        Notification::create([
                            'type' => get_class($attendance),
                            'data' => 'Late arrival',
                            'notifiable' => '',
                            'read_at' => '',
                            'status' => 1,
                            'created_by' => Auth::user()->_id
                        ]);
                    }
                }else{
                    if (strtotime($defaultShift->max_start_time) < $attendance->punch_in) {
                        Notification::create([
                            'type' => get_class($attendance),
                            'data' => 'Late arrival',
                            'notifiable' => '',
                            'read_at' => '',
                            'status' => 1,
                            'created_by' => Auth::user()->_id
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertSuccess($msg)
    {
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => $msg
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertError($msg)
    {
        $this->dispatchBrowserEvent('alert', [
            'type' => 'error',
            'message' => $msg
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($msg)
    {
        $this->dispatchBrowserEvent('alert', [
            'type' => 'info',
            'message' => $msg
        ]);
    }
}