<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserAttendance;
use App\Models\UserAttendanceDetail;
use App\Models\Holiday;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\Leave;
use App\Models\User;
use App\Models\Role;
use App\Models\UserJoiningDetail;
use App\Models\Schedule;
use App\Models\Notification;
use App\Models\EmployeeShift;

class ComingSoon extends Component
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
                    if ($attendanceData['date'] == strtotime($today) && $attendanceData['punch_out'] == '') {
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

        if ($this->todaytotalsecs > 28800) {
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
                    if ($attendanceData['date'] == strtotime($today) && $attdanceData['punch_out'] == '') {
                        $time2 = new \DateTime(date('Y-m-d H:i', strtotime('now')));
                    } else {
                        $time2 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_out']));
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
        $monthlytotalsecs = ($monthlyhrs * 60 * 60) + ($monthlymins * 60);
        $totalmonthlySecs = $this->totalMonthlyhrs * 60 * 60;
        if ($monthlytotalsecs > $totalmonthlySecs) {
            $secs = $monthlytotalsecs - $totalmonthlySecs;

            $this->monthlytotalovertime = gmdate("H:i", $secs);
            $this->monthlytotalovertimesecs = $secs;
        } else {
            $this->monthlytotalovertime = '00:00';
            $this->monthlytotalovertimesecs = '0';
        }

        $todaySecs = 8 * 60 * 60;
        if ($this->todaytotalsecs > $todaySecs) {
            $secs = $this->todaytotalsecs - $todaySecs;

            $this->todaytotalovertime = gmdate("H:i", $secs);
            $this->todaytotalovertimesecs = $secs;
        } else {
            $this->todaytotalovertime = '00:00';
            $this->todaytotalovertimesecs = '0';
        }

        $this->todaytotalbreak = date('H:i', mktime($totalbhrs, ($totalbmins)));
        $this->weeklytotalsecs = ($weeklyhrs * 60 * 60) + ($weeklymins * 60);
        $this->monthlytotalsecs = ($monthlyhrs * 60 * 60) + ($monthlymins * 60);

        $t1 = new \DateTime(date('H:i', strtotime($this->todaytotal)));
        $t2 = new \DateTime(date('H:i', strtotime('08:00')));
        $d = $t1->diff($t2);

        $this->todayremainingtotal = date('H:i', mktime($d->h, $d->i));
        $this->todayremainingtotalsecs = ($d->h * 60 * 60) + ($d->i * 60);

        $query = UserAttendance::with('details')->where([
            'user_id' => $this->user_id
        ]);
        if ($this->dateFilter != '') {
            $startDate = date('Y-m-d 00:00:00', strtotime($this->dateFilter));
            $endDate = date('Y-m-d 23:59:59', strtotime($this->dateFilter));
            $query = $query->whereBetween('date', [
                strtotime($startDate),
                strtotime($endDate)
            ]);
        }

        if ($this->month != '' && $this->year != '') {
            $firstdate = $this->year . '-' . $this->month . '-' . '01';
            $fDate = strtotime($firstdate);
            $last_date = date("Y-m-t", $fDate);
            $lDate = strtotime($last_date);
            $query = $query->whereBetween('date', [
                $fDate,
                $lDate
            ]);
        }
        $startDate = date('Y-m-d', strtotime('-1 day'));

        $leave = Leave::where('from_date', '>', $startDate)->orWhere('to_date', '<', $startDate)->get();
        $allAttendances = $query->paginate(10);
        $heading = $this->heading;

        $holidays = Holiday::orderBy('date', 'ASC')->where('date', '>=', strtotime(date('Y-m-d')))->where('date','<=',strtotime(date('Y-m-d', strtotime('+3 month'))))->paginate(4);
        $onLeave = Leave::where('str_from_date', '>=', strtotime(date('Y-m-d')))->where('status', '2')->paginate(4);
        $adminUser = User::where('_id', Auth::user()->_id)->where('user_role', '0')->first();
        $role = Role::where('_id', Auth::user()->user_role)->first();
        $months =  date('m');
        $day = date('d');
        $userDob=User::where('date_of_birth', 'Like','%'.'-'.$months.'-'.$day.'%')->paginate(4);
        $upcomingBirthday=[];
        foreach ($userDob as $userDay){
            if(date('d') <= date('d',strtotime($userDay->date_of_birth))){
                $upcomingBirthday[] = array(
                    'id' => $userDay->_id,
                    'day' => date('d', strtotime($userDay->date_of_birth)),
                    'month' => date('m', strtotime($userDay->date_of_birth)),
                    'year' => date('Y', strtotime($userDay->date_of_birth)),
                    'name' => ucfirst($userDay->first_name) . ' ' . $userDay->last_name,
                    'photo'=> $userDay->photo,
                );
            }
        }
        $BirthdayCollection = collect($upcomingBirthday);
        $BirthdayCollection = $BirthdayCollection->sortBy('day');
        
        $workAniversery = User::where('joining_date', 'Like', '%'.$months.'-'.$day.'%')->paginate(4);
        
        $upcomingAniversery=[];
        foreach ($workAniversery as $userDay){
            if(date('d') <= date('d',strtotime($userDay->joining_date)))
            {
                $upcomingAniversery[] = array(
                    'id' => $userDay->_id,
                    'day' => date('d', strtotime($userDay->joining_date)),
                    'month' => date('m', strtotime($userDay->joining_date)),
                    'year' => date('Y', strtotime($userDay->joining_date)),
                    'name' => ucfirst($userDay->first_name) . ' ' . $userDay->last_name,
                    'photo'=> $userDay->photo,
                );
            }
        }

        $AniverseryCollection = collect($upcomingAniversery);
        $AniverseryCollection = $AniverseryCollection->sortBy('day');

        $employeeBirthday = User::where('_id', Auth::user()->id)->where('date_of_birth', 'LIKE', '%' . date('m-d') . '%')->first();
        $employeeWorkAnniversary = User::where('_id', Auth::user()->id)->where('joining_date', 'LIKE', '%' . date('m-d') . '%')->first();

        if (! empty($adminUser) || (! empty($role) && $role->name == "HR")) {
            $UserTime = UserAttendance::where('punch_in', '!=', '')->where('punch_in', '<=', strtotime(date('Y-m-d 09:30:00')))
                ->where('date', strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $userLate = UserAttendance::where('punch_in', '!=', '')->where('punch_in', '>=', strtotime(date('Y-m-d 09:30:00')))
                ->where('date', strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $userNot = UserAttendance::where('date', strtotime(date('Y-m-d')))->where('date', strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $userNotLogIn = User::whereNotIn('_id', $userNot)->where('user_role', '!=', '0')
                ->where('status', '1')
                ->get();

            $userLateArrival = User::whereIn('_id', $userLate)->get();

            $hrLeave = Leave::where('name', Auth::user()->_id)->where('str_from_date', '<=', strtotime(date('Y-m-d')))
                ->where('status', '1')
                ->orderBy('str_from_date')
                ->get();

            $allUserPunchIn = User::whereIn('_id', $UserTime)->get();

            $leavePending = Leave::where('status', '1')->get();
            $compOff = Leave::where('status', '1')->where('type', '2')->get();

            $pendingConfirmation = UserJoiningDetail::where('status', '0')->get();
            $managerConfirmed = UserJoiningDetail::where('status', '1')->get();

            $NotIn = [];
            $onTime = [];
            $lateArrival = [];
            $userNotIn = [];
            $userPunch = [];
            $userAttendance = [];
            $userManager = [];
            
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
            $StartoverTime = '00:00';
            $overAllTime = '00:00';
            $starttimeDiff = '0';
            
            $leavePending = Leave::where('status','1')->where('leave_type','!=','comp_off')->get();
            $compOff  = Leave::where('status','1')->where('leave_type','comp_off')->where('type','2')->get();
            
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
                        $overAllTimediff = $timeDiff + ! empty($starttimeDiff) ? $starttimeDiff : '';
                        $MaxminutesOver = ($overAllTimediff % 60);
                        $overAllTime = '0'.floor($overAllTimediff / 60) . ":".$MaxminutesOver;
                    }
                    
                }
            }
            
        } else {

            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
                ->pluck('_id')
                ->toArray();
            $pendingConfirmation = UserJoiningDetail::whereIn('user_id', $userManager)->where('status', '0')->get();

            $leaveApproved = Leave::whereIn('name', $userManager)->where('str_from_date', '>=', strtotime(date('Y-m-d')))
                ->where('status', '2')
                ->get();
            $leavePending = Leave::whereIn('name', $userManager)->where('status', '1')
                ->orderBy('from_date', 'DESC')
                ->get();

            $compOff = Leave::whereIn('name', $userManager)->where('type', '2')
                ->orderBy('from_date', 'DESC')
                ->get();

            $userAttendance = UserAttendance::whereIn('user_id', $userManager)->where('punch_in', '!=', '')
                ->where('punch_in', '>=', strtotime(date('Y-m-d 09:30:00')))
                ->where('date', strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $userPunch = UserAttendance::whereIn('user_id', $userManager)->where('punch_in', '!=', '')
                ->where('punch_in', '<=', strtotime(date('Y-m-d 09:30:00')))
                ->where('date', strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $userNotIn = UserAttendance::where('date', strtotime(date('Y-m-d')))->where('date', strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $lateArrival = User::whereIn('_id', $userAttendance)->get();

            $onTime = User::whereIn('_id', $userPunch)->get();

            $NotIn = User::where('reporting_manager', Auth::user()->_id)->whereNotIn('_id', $userNotIn)
                ->where('status', '1')
                ->get();

            $allUserPunchIn = [];
            $userLateArrival = [];
            $userNotLogIn = [];
        }
            
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
        $StartoverTime = '00:00';
        $overAllTime = '00:00';
     
        
        
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
        

        if (! empty($userManager) || (! empty($role) && $role->name == "Management")) {
            $managerEmployee = Leave::whereIn('name', $userManager)->where('from_date', '>=', date('Y-m-d'))
                ->where('status', '2')
                ->get();

            $managerLeave = Leave::where('name', Auth::user()->_id)->where('status', '1')
                ->where('leave_type', '!=', 'comp_off')
                ->orderBy('from_date', 'DESC')
                ->get();
            $onLeave = Leave::where('from_date', '>=', date('Y-m-d'))->orWhere('to_date', '<=', date('Y-m-d'))
                ->where('status', '2')
                ->get();

            return view('livewire.coming-soon', compact('heading', 'allAttendances', 'holidays', 'leavePending', 'leave', 'onLeave', 'lateArrival', 'onTime', 'NotIn', 'managerEmployee', 'managerLeave', 'leaveApproved', 'employeeBirthday', 'employeeWorkAnniversary', 'compOff', 'pendingConfirmation','overTime','overAllTime'));
        } else {
            return view('livewire.coming-soon', compact('heading', 'allAttendances', 'holidays', 'leavePending', 'leave', 'onLeave', 'allUserPunchIn', 'userLateArrival', 'userNotLogIn', 'hrLeave', 'userDob', 'workAniversery', 'employeeBirthday', 'employeeWorkAnniversary', 'BirthdayCollection', 'AniverseryCollection', 'compOff', 'pendingConfirmation', 'overTime','managerConfirmed','overAllTime'));
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
                $attendancedetail = UserAttendanceDetail::where('attendance_id', $attendance['_id'])->where('punch_in', '!=', '')
                    ->where('punch_out', '')
                    ->first();
                UserAttendanceDetail::where('_id', $attendancedetail['_id'])->update([
                    'punch_out' => $attendancedetail['punch_in']
                ]);
                UserAttendance::where('_id', $attendance['_id'])->update([
                    'punch_out' => $attendancedetail['punch_in']
                ]);
            } else {
                $attendancedetail = UserAttendanceDetail::where('attendance_id', $attendance['_id'])->where('punch_in', '!=', '')
                    ->where('punch_out', '')
                    ->first();

                UserAttendanceDetail::where('_id', $attendancedetail['_id'])->update([
                    'punch_out' => strtotime('now')
                ]);
                UserAttendance::where('_id', $attendance['_id'])->update([
                    'punch_out' => strtotime('now')
                ]);
            }
        } else {
            $attendance = UserAttendance::where([
                'user_id' => $this->user_id,
                'date' => strtotime($today)
            ])->first();
            if (! empty($attendance)) {
                UserAttendanceDetail::create([
                    'attendance_id' => $attendance['_id'],
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
                    'attendance_id' => $attendance['_id'],
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

        $this->attendanceStatus;
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