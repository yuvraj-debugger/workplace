<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeShift;
use App\Models\Employeedepartment;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ScheduleLogs;
use App\Jobs\ScheduleShiftJob;

class ScheduleController extends Controller
{

    //
    public function employeeSchedule(Request $request)
    {
        $departmentSearch = $request->department_search ?? "";
        $employeeName = $request->search_name ?? '';

        $fromDate = $request->from_date ?? '';
        $toDate = $request->to_date ?? '';

        if (empty($fromDate) && empty($toDate)) {
            $fromDate = date('Y-m-d');
            $toDate = date('Y-m-d', strtotime('+4 days'));
        }

        $employees = User::where('user_role', '!=', '0')->where('status','1');

        if (($departmentSearch) && ($departmentSearch != 'all') && ($departmentSearch != '')) {
            $employees = $employees->where('department', $departmentSearch);
        }
        if (($employeeName) && ($employeeName != 'all') && ($employeeName != '')) {
            $employees = $employees->where('_id', '=', $employeeName);
        }
        $employees = $employees->paginate(10)->withQueryString();

        $employeeShifts = EmployeeShift::get();
        $allDepartment = Employeedepartment::get();
        return view('admin.schedule.index', compact('allDepartment', 'employeeShifts', 'employees', 'employeeName', 'fromDate', 'toDate', 'departmentSearch'));
    }

    public function ajaxSchedule(Request $request)
    {
        $shiftsData = EmployeeShift::where('_id', $request->id)->first();
        if (! empty($shiftsData)) {
            $min_start_time = $shiftsData->min_start_time;
            $start_time = $shiftsData->start_time;
            $max_start_time = $shiftsData->max_start_time;
            $min_end_time = $shiftsData->min_end_time;
            $end_time = $shiftsData->end_time;
            $max_end_time = $shiftsData->max_end_time;
            $break_time = $shiftsData->break_time;
        }
        $data = [
            'min_start_time' => $min_start_time,
            'start_time' => $start_time,
            'max_start_time' => $max_start_time,
            'min_end_time' => $min_end_time,
            'end_time' => $end_time,
            'max_end_time' => $max_end_time,
            'break_time' => $break_time
        ];
        return json_encode($data);
    }

    public function addSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
//             'schdule_date' => 'required',
            'schedule_shift' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if ($request->schedule_employee == '1') {
            $employees = User::where('user_role', '!=', '0')->get();
            foreach ($employees as $employee) {
                $data=[
                    'department_id' => $employee->department,
                    'employee_id' => $employee->_id,
                    'from_date' => strtotime($request->schdule_from_date),
                    'to_date'=>strtotime($request->schdule_to_date),
                    'shifts_id' => $request->schedule_shift,
                    'min_start_time' => $request->schedule_min_start_time,
                    'start_time' => $request->schedule_start_time,
                    'max_start_time' => $request->schedule_max_start_time,
                    'min_start_time' => $request->schedule_min_end_time,
                    'end_time' => $request->schedule_end_time,
                    'max_end_time' => $request->schedule_max_end_time,
                    'break_time' => $request->schedule_break_time,
                    'status' => 0,
                    'type' => 0,
                    'created_by' => Auth::user()->_id
                ];
                    ScheduleLogs::Create([
                        'content'=>$data,
                        'status'=>0,
                        'type'=>0,
                        'created_by' => Auth::user()->_id
                    ]);
                  
            }
        }elseif ($request->schedule_employee == '2'){
            $employees = User::where('user_role', '!=', '0')->where('department',$request->schedule_department)->get();
            foreach ($employees as $employee) {
                $data=[
                    'department_id' => $employee->department,
                    'employee_id' => $employee->_id,
                    'from_date' => strtotime($request->schdule_from_date),
                    'to_date'=>strtotime($request->schdule_to_date),
                    'shifts_id' => $request->schedule_shift,
                    'min_start_time' => $request->schedule_min_start_time,
                    'start_time' => $request->schedule_start_time,
                    'max_start_time' => $request->schedule_max_start_time,
                    'min_start_time' => $request->schedule_min_end_time,
                    'end_time' => $request->schedule_end_time,
                    'max_end_time' => $request->schedule_max_end_time,
                    'break_time' => $request->schedule_break_time,
                    'status' => 0,
                    'type' => 0,
                    'created_by' => Auth::user()->_id
                ];
                ScheduleLogs::Create([
                    'content'=>$data,
                    'status'=>0,
                    'type'=>0,
                    'created_by' => Auth::user()->_id
                ]);
                
            }
        } else {
          $data=[
                'department_id' => $request->schedule_department,
                'employee_id' => $request->schedule_employee,
                'from_date' => strtotime($request->schdule_from_date),
                'to_date'=>strtotime($request->schdule_to_date),
                'shifts_id' => $request->schedule_shift,
                'min_start_time' => $request->schedule_min_start_time,
                'start_time' => $request->schedule_start_time,
                'max_start_time' => $request->schedule_max_start_time,
                'min_start_time' => $request->schedule_min_end_time,
                'end_time' => $request->schedule_end_time,
                'max_end_time' => $request->schedule_max_end_time,
                'break_time' => $request->schedule_break_time,
                'status' => '1',
                'type' => '1',
                'created_by' => Auth::user()->_id
            ];
            
            ScheduleLogs::Create([
                'content'=>$data,
                'status'=>0,
                'type'=>0,
                'created_by' => Auth::user()->_id
            ]);
        }

        Session::flash('success', 'Schedule added successfully');
    }

    public function assignSchedule(Request $request)
    {
        $employeeId = User::where('_id', $request->id)->first();
        $EmployeeShift = EmployeeShift::where('_id', $employeeId->shift_id)->first();
        $scheduleShift = Schedule::where('shifts_id', $request->shif_id)->first();
        $schedule_id = Schedule::where('_id', $request->schedule_id)->first();
        if (! empty($EmployeeShift)) {
            if (! empty($employeeId)) {
                $departmentId = Employeedepartment::where('_id', $employeeId->department)->first();
                $data = [
                    'department_id' => ! empty($departmentId) ? $departmentId->_id : '',
                    'department_title' => ! empty($departmentId) ? $departmentId->title : '',
                    'employee_id' => $employeeId->_id,
                    'employee_name' => $employeeId->first_name . ' ' . $employeeId->last_name,
                    'shift_name' => $EmployeeShift->_id,
                    'min_start_time' => $EmployeeShift->min_start_time,
                    'start_time' => $EmployeeShift->start_time,
                    'max_start_time' => $EmployeeShift->max_start_time,
                    'min_end_time' => $EmployeeShift->min_end_time,
                    'end_time' => $EmployeeShift->end_time,
                    'max_end_time' => $EmployeeShift->max_end_time,
                    'break_time' => $EmployeeShift->break_time
                ];
                return json_encode($data);
            }
        }
        if (! empty($schedule_id)) {
            if (! empty($employeeId)) {
                $departmentId = Employeedepartment::where('_id', $employeeId->department)->first();
                $data = [
                    'department_id' => ! empty($departmentId) ? $departmentId->_id : '',
                    'department_title' => ! empty($departmentId) ? $departmentId->title : '',
                    'employee_id' => $schedule_id->employee_id,
                    'employee_name' => $employeeId->first_name . ' ' . $employeeId->last_name,
                    'shift_name' => $schedule_id->shifts_id,
                    'min_start_time' => $schedule_id->min_start_time,
                    'start_time' => $schedule_id->start_time,
                    'max_start_time' => $schedule_id->max_start_time,
                    'min_end_time' => $schedule_id->min_end_time,
                    'end_time' => $schedule_id->end_time,
                    'max_end_time' => $schedule_id->max_end_time,
                    'break_time' => $schedule_id->break_time
                ];
                return json_encode($data);
            }
        }
    }

    public function assignajaxShift(Request $request)
    {
        $shiftsData = EmployeeShift::where('_id', $request->id)->first();
        if (! empty($shiftsData)) {
            $min_start_time = $shiftsData->min_start_time;
            $start_time = $shiftsData->start_time;
            $max_start_time = $shiftsData->max_start_time;
            $min_end_time = $shiftsData->min_end_time;
            $end_time = $shiftsData->end_time;
            $max_end_time = $shiftsData->max_end_time;
            $break_time = $shiftsData->break_time;
        }
        $data = [
            'min_start_time' => $min_start_time,
            'start_time' => $start_time,
            'max_start_time' => $max_start_time,
            'min_end_time' => $min_end_time,
            'end_time' => $end_time,
            'max_end_time' => $max_end_time,
            'break_time' => $break_time
        ];
        return json_encode($data);
    }

    public function assignaddSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assign_schdule_date' => 'required',
            'assign_schedule_shift' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if (! empty($request->assignSchedule_id)) {
            $updateSchedule = Schedule::where('_id', $request->assignSchedule_id)->where('date',strtotime($request->assign_schdule_date))->update([
                'department_id' => $request->hidden_department_id,
                'employee_id' => $request->hidden_employee_id,
                'date' => strtotime($request->assign_schdule_date),
                'shifts_id' => $request->assign_schedule_shift,
                'min_start_time' => $request->assign_schedule_min_start_time,
                'start_time' => $request->assign_schedule_start_time,
                'max_start_time' => $request->assign_schedule_max_start_time,
                'min_start_time' => $request->assign_schedule_min_end_time,
                'end_time' => $request->assign_schedule_end_time,
                'max_end_time' => $request->assign_schedule_max_end_time,
                'break_time' => $request->assign_schedule_break_time,
                'status' => 0,
                'type' => 0,
                'created_by' => Auth::user()->_id
            ]);
            Session::flash('success', 'Schedule assigned successfully');
        } else {
            $schedule = Schedule::Create([
                'department_id' => $request->hidden_department_id,
                'employee_id' => $request->hidden_employee_id,
                'date' => $request->assign_schdule_date,
                'shifts_id' => $request->assign_schedule_shift,
                'min_start_time' => $request->assign_schedule_min_start_time,
                'start_time' => $request->assign_schedule_start_time,
                'max_start_time' => $request->assign_schedule_max_start_time,
                'min_start_time' => $request->assign_schedule_min_end_time,
                'end_time' => $request->assign_schedule_end_time,
                'max_end_time' => $request->assign_schedule_max_end_time,
                'break_time' => $request->assign_schedule_break_time,
                'status' => '1',
                'type' => '1',
                'created_by' => Auth::user()->_id
            ]);
            Session::flash('success', 'Schedule assigned successfully');
        }
    }
}
