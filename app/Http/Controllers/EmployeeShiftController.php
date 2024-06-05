<?php
namespace App\Http\Controllers;

use App\Models\Employeedepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\EmployeeShift;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Schedule;
use App\Models\ScheduleLogs;

class EmployeeShiftController extends Controller
{

    //
    public function employeeShift(Request $request)
    {
        $searchShift = $request->search_shift ?? "";
        $employeeShifts = EmployeeShift::orderBy('_id', 'DESC');
        if (($searchShift) && ($searchShift != 'all') && ($searchShift != '')) {
            $employeeShifts = EmployeeShift::where('shift_name', '=', $searchShift);
        }
        $employeeShifts = $employeeShifts->paginate(10)->withQueryString();
        $allDepartment = Employeedepartment::get();
        $employees = User::where('user_role', '!=', '0')->get();
        return view('admin.shift.index', compact('allDepartment', 'employeeShifts', 'employees', 'searchShift'));
    }

    public function addEmployeeShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_name' => 'required|unique:employee_shift,shift_name|regex:/^[a-zA-Z\s]+$/|min:3|max:25',
            'min_start_time' => 'required',
            'start_time' => 'required',
            'max_start_time' => 'required',
            'min_end_time' => 'required',
            'end_time' => 'required',
            'max_end_time' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $employeeShift = EmployeeShift::Create([
            'shift_name' => $request->shift_name,
            'min_start_time' => $request->min_start_time,
            'start_time' => $request->start_time,
            'max_start_time' => $request->max_start_time,
            'min_end_time' => $request->min_end_time,
            'end_time' => $request->end_time,
            'max_end_time' => $request->max_end_time,
            'break_time' => $request->break_time,
            'recurring_shift' => ! empty($request->recurring_shift) ? $request->recurring_shift : "off",
            'repeat_every' => $request->repeat_every,
            'week' => ! empty($request->week) ? json_encode($request->week) : '',
            'add_note' => $request->add_note,
            'status' => '1',
            'type' => '1',
            'created_by' => Auth::user()->_id
        ]);
        Session::flash('success', 'Shift added successfully');
    }

    public function editEmployeeShift(Request $request)
    {
        $shiftEdit = EmployeeShift::where('_id', $request->id)->first();
        if (! empty($shiftEdit)) {
            $shift_name = $shiftEdit->shift_name;
            $min_start_time = $shiftEdit->min_start_time;
            $start_time = $shiftEdit->start_time;
            $max_start_time = $shiftEdit->max_start_time;
            $min_end_time = $shiftEdit->min_end_time;
            $end_time = $shiftEdit->end_time;
            $max_end_time = $shiftEdit->max_end_time;
            $break_time = $shiftEdit->break_time;
            $week = ! empty($shiftEdit->week) ? implode(',', json_decode($shiftEdit->week)) : '';
            $add_note = $shiftEdit->add_note;
        }
        $data = [
            'shift_name' => $shift_name,
            'min_start_time' => $min_start_time,
            'start_time' => $start_time,
            'max_start_time' => $max_start_time,
            'min_end_time' => $min_end_time,
            'end_time' => $end_time,
            'max_end_time' => $max_end_time,
            'break_time' => $break_time,
            'week' => $week,
            'add_note' => $add_note
        ];
        return json_encode($data);
    }

    public function updateEmployeeShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_name' => 'required|regex:/^[a-zA-Z\s]+$/|min:3|max:25',
            'min_start_time' => 'required',
            'start_time' => 'required',
            'max_start_time' => 'required',
            'min_end_time' => 'required',
            'end_time' => 'required',
            'max_end_time' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updatedShift = EmployeeShift::where('_id', $request->shift_id)->first();
        $updatedShift->shift_name = $request->shift_name;
        $updatedShift->min_start_time = $request->min_start_time;
        $updatedShift->start_time = $request->start_time;
        $updatedShift->max_start_time = $request->max_start_time;
        $updatedShift->min_end_time = $request->min_end_time;
        $updatedShift->end_time = $request->end_time;
        $updatedShift->max_end_time = $request->max_end_time;
        $updatedShift->break_time = $request->break_time;
        $updatedShift->recurring_shift = isset($request->recurring_shift) ? "on" : "off";
        $updatedShift->repeat_every = $request->repeat_every;
        $updatedShift->week = ! empty($request->week) ? json_encode($request->week) : '';
        $updatedShift->add_note = $request->add_note;
        $updatedShift->update();
        Session::flash('success', 'Shift updated successfully');
    }

    public function shiftDelete(Request $request)
    {
        $shiftDelete = EmployeeShift::where('_id', $request->id)->first();
        $shiftDelete->status='2';
        $shiftDelete->update();
        Session::flash('info', 'Employee shift deleted successfully');
    }

    public function ajaxShift(Request $request)
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

    public function addScheduleShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
//             'schedule_department' => 'required',
//             'schedule_employee' => 'required',
//             'schdule_from_date' => 'required',
//             'schdule_to_date' => 'required',
            'schedule_shift'=>'required'
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

    public function assignEmployee(Request $request)
    {
        $allUser = User::where('department', $request->id)->where('status','1')->get();
        if (! empty($allUser)) {
            foreach ($allUser as $user) {
                $userDetail[]= array('id'=>$user->_id,'name'=>$user->first_name . ' ' . $user->last_name . '(' . $user->employee_id . ')');
            }
        }
        $data = [
            'userdetail' => $userDetail
        ];
        return json_encode($data);
    }
    public function multipleDeleteShift(Request $request)
    {
        if(! empty($request->all_ids)){
            EmployeeShift::whereIn('_id',explode(',',$request->all_ids))->delete();
            Session::flash('info', 'Employee shift deleted successfully');
        }
        
    }
   
}
