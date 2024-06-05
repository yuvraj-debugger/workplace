<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\UserAttendance;
use App\Models\User;
use App\Models\Employeedepartment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAttendanceDetail;
use App\Models\UserAddress;
use App\Models\Leave;
use App\Models\Schedule;
use App\Models\EmployeeShift;
use App\Models\UserJoiningDetail;
use App\Models\Holiday;

class AttendanceController extends Controller
{

    //
    public function days_in_month($month, $year)
    {
        // calculate number of days in a month
        return date('t', strtotime(date($year . '-' . $month . '-01')));
    }

    public function adminattendance(Request $request)
    {
        $searchEmployee = $request->employee ?? "";
        $searchDesigantion = $request->department ?? "";
        $searchMonth = $request->month ?? "";
        $searchYear = $request->year ?? "";

        $month = ($searchMonth) ? $searchMonth : date('m');
        $year = ($searchYear) ? $searchYear : date('Y');
        $employees = User::where('user_role', '!=', '0')->orderBy('first_name','ASC');
        $departments = Employeedepartment::get();
        $count = UserAttendance::where('date', strtotime(date('Y-m-d')))->count();
        $days = $this->days_in_month(($searchMonth) ? $searchMonth : $month, $year);

        $q = User::where('user_role', '!=', '0')->orderBy('date', 'desc');

        if (($searchEmployee) && ($searchEmployee != 'all') && ($searchEmployee != '')) {
            $q = $q->where('_id', '=', $searchEmployee);
        }
        $role = Role::where('_id', Auth::user()->user_role)->first();
        if (! empty($role) && $role->name == 'Employee') {
            $q = $q->where('_id', Auth::user()->_id);
            $employees = User::where('_id', Auth::user()->_id);
            $count = UserAttendance::where('date', strtotime(date('Y-m-d')))->where('user_id', $q)->count();
        }
        if (! empty($role) && ($role->name == 'Management')) {
            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
                ->pluck('_id')
                ->toArray();
            $q = $q->whereIn('_id', $userManager);
            $employees = $employees->where('reporting_manager', Auth::user()->_id);
            $count = UserAttendance::where('date', strtotime(date('Y-m-d')))->where('user_id', $q)->count();
        }
        $employees = $employees->where('status', '1')->get();
        $employeecounting = $employees->count();
        return view('admin.Attendance.admin-attendance', compact('count', 'employeecounting', 'employees', 'departments', 'days', 'month', 'searchEmployee', 'searchDesigantion', 'searchMonth', 'year'));
    }

    public function ajaxAttendance(Request $request)
    {
        $searchEmployee = $request->employeeId ?? "";
        $searchMonth = $request->month ?? "";
        $searchYear = $request->year ?? "";
        $month = ($searchMonth) ? $searchMonth : date('m');
        
        $year = ($searchYear) ? $searchYear : date('Y');
        $days = $this->days_in_month(($searchMonth) ? $searchMonth : $month, $year);
        $q = User::select('_id','photo','first_name','last_name','employee_id')->where('user_role', '!=', '0')->orderBy('date', 'desc')->where('status', '1');
        if (($searchEmployee) && ($searchEmployee != 'all') && ($searchEmployee != '')) {
            $q = $q->where('_id', '=', $searchEmployee);
        } else {
            $role = Role::where('_id', Auth::user()->user_role)->first();
            if (! empty($role) && $role->name == 'Employee') {
                $q = $q->where('_id', Auth::user()->_id);
            }
            if (! empty($role) && ($role->name == 'Management')) {
                $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
                    ->pluck('_id')
                    ->toArray();
                $q = $q->whereIn('_id', $userManager);
            }
        }
        
        $userData = $q->get();
        // $user_data=[];

        return view('admin.Attendance.ajax-attendance', compact('userData', 'days', 'month', 'year'));
    }

    public function managementattendance(Request $request)
    {
        $searchEmployee = Auth::user()->_id;
        $searchMonth = $request->month ?? "";
        $searchYear = $request->year ?? "";

        $month = ($searchMonth) ? $searchMonth : date('m');
        $year = ($searchYear) ? $searchYear : date('Y');
        $employees = User::where('_id', $searchEmployee);
        $days = $this->days_in_month(($searchMonth) ? $searchMonth : $month, $year);

        $q = User::where('user_role', '!=', '0')->orderBy('date', 'desc');

        if (($searchEmployee) && ($searchEmployee != 'all') && ($searchEmployee != '')) {
            $q = $q->where('_id', '=', $searchEmployee);
        }
        $employees = $employees->get();
        return view('admin.Attendance.admin-attendance', compact('employees', 'days', 'month', 'searchEmployee', 'searchMonth', 'year'));
    }

    public function myAttendance(Request $request)
    {
        $searchEmployee = Auth::user()->_id;
        $searchMonth = $request->month ?? "";
        $searchYear = $request->year ?? "";

        $month = ($searchMonth) ? $searchMonth : date('m');
        $year = ($searchYear) ? $searchYear : date('Y');
        $employees = User::where('_id', $searchEmployee);
        $days = $this->days_in_month(($searchMonth) ? $searchMonth : $month, $year);

        $q = User::where('user_role', '!=', '0')->orderBy('date', 'desc');

        if (($searchEmployee) && ($searchEmployee != 'all') && ($searchEmployee != '')) {
            $q = $q->where('_id', '=', $searchEmployee);
        }
        $employees = $employees->get();

        return view('admin.Attendance.admin-attendance', compact('employees', 'days', 'month', 'searchEmployee', 'searchMonth', 'year'));
    }

    public function hrattendance(Request $request)
    {
        $searchEmployee = Auth::user()->_id;
        $searchMonth = $request->month ?? "";
        $searchYear = $request->year ?? "";

        $month = ($searchMonth) ? $searchMonth : date('m');
        $year = ($searchYear) ? $searchYear : date('Y');
        $employees = User::where('_id', $searchEmployee);
        $days = $this->days_in_month(($searchMonth) ? $searchMonth : $month, $year);

        $q = User::where('user_role', '!=', '0')->orderBy('date', 'desc');

        if (($searchEmployee) && ($searchEmployee != 'all') && ($searchEmployee != '')) {
            $q = $q->where('_id', '=', $searchEmployee);
        }
        $employees = $employees->get();
        return view('admin.Attendance.admin-attendance', compact('employees', 'days', 'month', 'searchEmployee', 'searchMonth', 'year'));
    }

    public function attendanceAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'date' => 'required',
            'punch_in' => 'required'
        ], [
            'user_id.required' => 'The member field is required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $userAttendance = UserAttendance::Create([
            'user_id' => $request->user_id,
            'date' => strtotime($request->date),
            'punch_in' => strtotime(date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->punch_in)))
        ]);
        if (! empty($userAttendance)) {
            UserAttendanceDetail::create([
                'attendance_id' => $userAttendance->_id,
                'punch_in' => strtotime(date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->punch_in))),
                'punch_out' => strtotime(date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->punch_out))),
                'total_hrs' => ''
            ]);
        }
        Session::flash('success', 'Attendance updated successfully');
    }

    public function editAttendance(Request $request)
    {
        $userAttendance = User::where('_id', $request->id)->first();
        if (! empty($userAttendance)) {
            $employeeName = $userAttendance->first_name . ' ' . $userAttendance->last_name;
        }
        $data = [
            'employeeName' => $employeeName,
            'date_day' => date('Y-m-d', strtotime(date($request->year . '-' . $request->month . '-' . $request->day)))
        ];
        return json_encode($data);
    }

    public function updateAttendance(Request $request)
    {
        $userAttendance = new UserAttendance();
        $userAttendance->user_id = ! empty($request->employeeId) ? $request->employeeId : '';
        $userAttendance->date = ! empty(strtotime($request->date)) ? strtotime($request->date) : '';
        $userAttendance->punch_in = ! empty($request->punchIn) ? strtotime(date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->punchIn))) : '';
        $userAttendance->punch_out = ! empty($request->punchOut) ? strtotime(date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->punchOut))) : "";
        $userAttendance->save();
        if (! empty($userAttendance)) {
            UserAttendanceDetail::create([
                'attendance_id' => $userAttendance->_id,
                'punch_in' => ! empty($request->punchIn) ? strtotime(date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->punchIn))) : '',
                'punch_out' => ! empty($request->punchOut) ? strtotime(date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->punchOut))) : "",
                'total_hrs' => ''
            ]);
        }

        return redirect('/employee-attendance');
    }

    public function attendanceActivity(Request $request)
    {
        $searchDate = $request->date ?? "";
        $userRecord = UserAttendance::where('user_id', Auth::user()->_id)->where('date', strtotime(date('Y-m-d')))
            ->get()
            ->pluck('_id')
            ->toArray();
        $userPunchIn = UserAttendanceDetail::whereIn('attendance_id', $userRecord)->get();
        $user = UserAttendance::where('user_id', Auth::user()->_id);
        if ($searchDate) {
            $user = $user->where('date', strtotime($searchDate));
        }
        $user = $user->get()
            ->pluck('_id')
            ->toArray();

        $attendanceDetails = UserAttendanceDetail::whereIn('attendance_id', $user)->orderBy('punch_in', 'desc')->paginate(5);
        return view('admin.Attendance.attendance-activity', compact('attendanceDetails', 'searchDate', 'userPunchIn'));
    }

    public function attendanceReport(Request $request)
    {
        $attendance_from_date_search = $request->attendance_from_date_search ?? "";
        $attendance_to_date_search = $request->attendance_to_date_search ?? "";
        $search_user_name = $request->search_user_name ?? "";
        $search_department = $request->search_department ?? "";
        $search_status = $request->search_status ?? "";

        $userAttendances = UserAttendance::orderBy('_id', 'DESC');

        if (($search_department) && ($search_department != 'all') && ($search_department != '')) {
            $users = User::where('user_role', '!=', '0')->where('department', $search_department)
                ->get()
                ->pluck('_id')
                ->toArray();
            $userAttendances = UserAttendance::whereIn('user_id', $users);
        } elseif(($search_status) && ($search_status != 'all') && ($search_status != '')){
            $users = User::where('user_role', '!=', '0')->where('status', $search_status)
            ->get()
            ->pluck('_id')
            ->toArray();
            $userAttendances = UserAttendance::whereIn('user_id', $users);
        } else {
            $users = User::where('user_role', '!=', '0')->get()
                ->pluck('_id')
                ->toArray();
            $userAttendances = UserAttendance::whereIn('user_id', $users);
        }

        if (($attendance_from_date_search) && ($attendance_from_date_search != 'all') && ($attendance_from_date_search != '')) {
            $userAttendances = $userAttendances->whereBetween('date', [
                strtotime($attendance_from_date_search),
                strtotime($attendance_to_date_search)
            ]);
        }
        if (($search_user_name) && ($search_user_name != 'all') && ($search_user_name != '')) {
            $userAttendances = $userAttendances->where('user_id', '=', $search_user_name);
        }
        $employees = User::where('user_role', '!=', '0')->get();
        $userAttendances = $userAttendances->paginate(10)->withQueryString();

        $departments = Employeedepartment::get();

        return view('admin.Attendance.attendance-report', compact('userAttendances', 'departments', 'attendance_from_date_search', 'attendance_to_date_search', 'employees', 'search_user_name','search_status','search_department'));
    }

    public function exportAttendance()
    {
        ini_set('max_execution_time', '0');
        
        $data[] = 'S.No';
        $data[] = 'Emloyee Name';
        $data[] = 'Department';
        $data[] = 'Date of Joining';
        $data[] = 'Date of Confirmation';
        for ($d = 1; $d <= $this->days_in_month(date('m'), date('y')); $d ++) {
            $data[] = $d;
        }
        $data[] = 'Shift';
        $data[] = 'Early departures';
        $data[] = 'Late coming';
        $data[] = 'Total Hrs worked';
        $data[] = 'Total days present';
        $data[] = 'Deductions';
        $data[] = 'OT';
        $data[] = 'Total Paid days';
        $days[] = $data;
        
        $allUser = User::where('user_role', '!=', '0')->where('status', '1')->get();
        
        $data = [];
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $data[] = '';
        
        for ($d = 1; $d <= $this->days_in_month(date('m'), date('y')); $d ++) {
            $data[] = date('D', strtotime(date('Y') . '-' . date('m') . '-' . $d));
        }
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $data[] = '';
        $days[] = $data;
        $holiday=Holiday::select('date')->get()->pluck('date')->toArray();
        foreach ($allUser as $key => $user) {
            $department = Employeedepartment::where('_id', $user->department)->first();
            $date_of_confirmation = UserJoiningDetail::where('user_id', $user->_id)->first();
            $employeestatus = '';
            if (! empty($date_of_confirmation)) {
                if ($date_of_confirmation->status == '2') {
                    $employeestatus = date('d M,Y', $date_of_confirmation->hr_confirmation_date);
                } else {
                    $employeestatus = 'Probation';
                }
            }
            
            $user_id = $user->_id;
            $data = [];
            $data[] = $key + 1;
            $data[] = $user->first_name . ' ' . $user->last_name;
            $data[] = ! empty($department) ? $department->title : '';
            $data[] = ! empty($user->joining_date) ? date('d M,Y', strtotime($user->joining_date)) : '';
            $data[] = ! empty($employeestatus) ? $employeestatus : '';
            $late = 0;
            $totalMinutes = 0;
            $totalHrs = 0;
            $minutes = 0;
            $userTotalPresent = 0;
            $employeeShift = 0;
            $totalPaidDays = 0;
            $earlyDeparture = 0;
            $overTime = 0;
            $totalMaxMinutes = 0;
            
            $attendance=UserAttendance::select('date')->where('user_id', $user->_id)->get()->pluck('date')->toArray();
            
            for ($d = 1; $d <= $this->days_in_month(date('m'), date('y')); $d ++) {
                $day_ = $d;
                $date_today = strtotime(date('Y') . '-' . date('m') . '-' . $day_);
                $userAttendance = in_array(strtotime(date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-' . $d))), $attendance);
                if($user->getLeaves($date_today)){
                    $data[]= $user->getLeaves($date_today);
                }elseif (! empty($userAttendance)){
                    $data[] = 'P';
                }elseif((date('w',$date_today) == 6) || (date('w',$date_today) == 0)){
                    $data[] = (date('w',$date_today) == 6) ? 'Sat' : 'Sun';
                }elseif (in_array($date_today,$holiday)){
                    $data[] = 'H';
                }elseif ($day_ < date('d')){
                        $data[] =  'A';
                 } else {
                        $data[] = '';
                    }
                
                $userdefaultShift = $user->shift_id;
                $userScheduleTime = Schedule::where('employee_id', $user->_id)->where('date', $date_today)->first();
                if(! empty($userScheduleTime)){
                    $employeeShift =  $userScheduleTime->start_time. '-'.$userScheduleTime->end_time;
                }elseif(! empty($userdefaultShift)){
                    $defaultShift = EmployeeShift::where('_id',$userdefaultShift)->first();
                    $employeeShift = $defaultShift->start_time. '-'.$defaultShift->end_time;
                }
                $userPunchTime = UserAttendance::where('user_id', $user->_id)->where('date', $date_today)->first();
                
                if (! empty($userPunchTime)) {
                    $punchIn = ! empty($userPunchTime->punch_in) ? $userPunchTime->punch_in : '';
                    $punchOut = ! empty($userPunchTime->punch_out) ? $userPunchTime->punch_out : '';
                    if(! empty($punchOut)){
                        $timeDiff = round(abs($punchOut - $punchIn) / (60), 2);
                    }
                    
                    if (! empty($timeDiff)) {
                        $totalMinutes = $totalMinutes + $timeDiff;
                    }
                }
                
                $defaultMaxTime = ! empty($defaultShift->max_start_time) ? strtotime(date('Y-m-d H:i:s', strtotime(date('Y') . '-' . date('m') . '-' . $day_ . ' ' . $defaultShift->max_start_time))) : '';
                $defaultMinStartTime = ! empty($defaultShift->min_start_time) ? strtotime(date('Y-m-d H:i:s', strtotime(date('Y') . '-' . date('m') . '-' . $day_ . ' ' . $defaultShift->min_start_time))) : '';
                $defaultMaxEndTime = ! empty($defaultShift->max_end_time) ? strtotime(date('Y-m-d H:i:s', strtotime(date('Y') . '-' . date('m') . '-' . $day_ . ' ' . $defaultShift->max_end_time))) : '';
                
                $maxTime = ! empty($userScheduleTime->max_start_time) ? strtotime(date('Y-m-d H:i:s', strtotime(date('Y') . '-' . date('m') . '-' . $day_ . ' ' . $userScheduleTime->max_start_time))) : '';
                $maxEndTime = ! empty($userScheduleTime->max_end_time) ? strtotime(date('Y-m-d H:i:s', strtotime(date('Y') . '-' . date('m') . '-' . $day_ . ' ' . $userScheduleTime->max_end_time))) : '';
                $MinstartTime = ! empty($userScheduleTime->min_start_time) ? strtotime(date('Y-m-d H:i:s', strtotime(date('Y') . '-' . date('m') . '-' . $day_ . ' ' . $userScheduleTime->min_start_time))) : '';
                if (! empty($userScheduleTime)) {
                    if (! empty($userPunchTime)) {
                        if(! empty($maxTime)){
                            if ($userPunchTime->punch_in > $maxTime) {
                                ++ $late;
                            }
                        }
                        
                    }
                }else{
                    if(! empty($userPunchTime)){
                        if ($userPunchTime->punch_in > $defaultMaxTime){
                            ++ $late;
                        }
                     }
                }
                   if (! empty($userPunchTime->punch_out)) {
                        if(! empty($maxEndTime)){
                            if ($userPunchTime->punch_out < $maxEndTime) {
                                ++ $earlyDeparture;
                            }else{
                                if ($userPunchTime->punch_out < $defaultMaxEndTime) {
                                    ++ $earlyDeparture;
                                }
                            }
                        }
                    }
                    if (! empty($userPunchTime->punch_out)) {
                        if(! empty($maxEndTime)){
                            if ($userPunchTime->punch_out > $maxEndTime) {
                                if(! empty($punchOut)){
                                    $MaxtimeDiff = round(abs($maxEndTime - $punchOut) / (60), 2);
                                    if (! empty($MaxtimeDiff)) {
                                        $totalMaxMinutes = $totalMaxMinutes + $MaxtimeDiff;
                                    }
                                }
                            }
                        }else{
                            if ($userPunchTime->punch_out > $defaultMaxEndTime) {
                                    $MaxtimeDiff = round(abs($defaultMaxEndTime - $punchOut) / (60), 2);
                                    if (! empty($MaxtimeDiff)) {
                                        $totalMaxMinutes = $totalMaxMinutes + $MaxtimeDiff;
                                    }
                            }
                        }
                       
                    }
                if(! empty($userPunchTime->punch_in)){
                    ++$userTotalPresent;
                }
                $userLeave = $userAttendance;
                if(! empty($userLeave)){
                    ++$totalPaidDays;
                }
            }
            if (! empty($totalMaxMinutes)) {
                $Maxminutes = ($totalMaxMinutes % 60);
                $overTime = floor($totalMaxMinutes / 60) . " . " . $Maxminutes;
            }
            
            
            if (! empty($totalMinutes)) {
                $minutes = ($totalMinutes % 60);
                $totalHrs = floor($totalMinutes / 60) . " . " . $minutes;
            }
            $data[] = $employeeShift;
            $data[] = $earlyDeparture;
            $data[] = $late;
            $data[] = $totalHrs;
            $data[] = $userTotalPresent;
            $data[] = date('t',$date_today) - $userTotalPresent;
            $data[] = $overTime;
            $data[] =  date('t',$date_today) - $totalPaidDays;
            $days[] = $data;
        }
        return response()->stream(
            function () use ($days) {
                $file = fopen('php://output', 'w');
                foreach ($days as $data_deatils) {
                    fputcsv($file, $data_deatils);
                }
                
                fclose($file);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="EmployeeAttendance.csv"',
            ]
            );
        
        
        
        
       
    }
}
