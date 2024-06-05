<?php
namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolesPermission;
use App\Models\User;
use App\Models\UserAttendance;
use App\Rules\LeaveDateRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\LeaveAllocation;
use App\Models\MasterLeaves;
use Illuminate\Support\Facades\Mail;
use App\Rules\LeaveRule;
use Carbon\Carbon;
use App\Models\MailQueue;
use App\Models\JoiningLogs;
use App\Models\Notification;

class LeaveController extends Controller
{

    //
    public function adminleaves(Request $request)
    {
        if ((Auth::user()->user_role == 0) || Permission::userpermissions('leaves', 1) || RolesPermission::userpermissions('leaves', 1)) {

            $searchEmployee = $request->user_id ?? "";
            $searchLeave = $request->search_leave_type ?? '';
            $searchStatus = $request->search_status ?? '';
            $searchFromDate = $request->fromsearch_date ?? '';
            $searchToDate = $request->tosearch_date ?? '';
            $employeecounting = User::count();
            $role = Role::where('_id', Auth::user()->user_role)->first();
            $employees = User::where('user_role', '!=', '0')->orderBy('first_name', 'ASC')
                ->where('status', '1')
                ->get();

            $pending = Leave::where('status', '1');
            $planned_leaves = Leave::where('leave_type', '1');
            $unplanned_leaves = Leave::where('leave_type', '2');
            $loss_pay = Leave::where('leave_type', '4');
            $q = Leave::orderBy('_id');

            if ((Auth::user()->user_role == 0) || (! empty($role) && ($role->name == 'HR'))) {
                $q = Leave::orderBy('_id');
                if (($searchEmployee) && ($searchEmployee != 'all') && ($searchEmployee != '')) {
                    $q = $q->where('name', '=', $searchEmployee);
                }
            }
            if (! empty($role) && ($role->name == 'Management')) {
                $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
                    ->pluck('_id')
                    ->toArray();
                $pending = $pending->whereIn('name', $userManager);
                $planned_leaves = $planned_leaves->whereIn('name', $userManager);
                $unplanned_leaves = $unplanned_leaves->whereIn('name', $userManager);
                $loss_pay = $loss_pay->whereIn('name', $userManager);

                $q = Leave::whereIn('name', $userManager);
            } else if (! empty(Auth::user()->_id) && (Auth::user()->user_role != 0) && ($role->name != 'HR')) {
                $pending = $pending->where('name', Auth::user()->_id);
                $planned_leaves = $planned_leaves->where('name', Auth::user()->_id);
                $unplanned_leaves = $unplanned_leaves->where('name', Auth::user()->_id);
                $loss_pay = $loss_pay->where('name', Auth::user()->_id);
            }
            $pending = $pending->count();
            $planned_leaves = $planned_leaves->count();
            $unplanned_leaves = $unplanned_leaves->count();
            $loss_pay = $loss_pay->count();
            $count = UserAttendance::where('date', strtotime(date('Y-m-d', strtotime('now'))))->count();

            if (! empty($role) && ($role->name == 'Employee')) {
                $q = Leave::where('name', Auth::user()->_id)->orderBy('_id');
            }
            if (! empty($request->search_leave_type)) {
                $q->where('leave_type', $request->search_leave_type);
            }
            if (! empty($request->search_status)) {
                $q->where('status', $request->search_status);
            }
            if (! empty($request->fromsearch_date)) {
                $q->where('from_date', '>=', $request->fromsearch_date);
            }
            if (! empty($request->tosearch_date)) {
                $q->where('to_date', '<=', $request->tosearch_date);
            }
            $leaves = $q->orderBy('_id', 'DESC')
                ->where('type', '!=', '2')
                ->where('status', '!=', 4)
                ->paginate(10)
                ->withQueryString();
            return view('admin.Leaves.admin-leaves', compact('employees', 'searchLeave', 'searchStatus', 'searchFromDate', 'searchToDate', 'searchEmployee', 'leaves', 'pending', 'planned_leaves', 'unplanned_leaves', 'employeecounting', 'count', 'loss_pay'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function myleaves(Request $request)
    {
        $searchEmployee = $request->user_id ?? "";
        $searchLeave = $request->search_leave_type ?? '';
        $searchStatus = $request->search_status ?? '';
        $searchFromDate = $request->fromsearch_date ?? '';
        $searchToDate = $request->tosearch_date ?? '';

        $leaves = Leave::where('name', Auth::user()->id)->orderBy('_id', 'DESC')->where('type', '!=', '2');
        if (! empty($request->search_leave_type)) {
            $leaves->where('leave_type', $request->search_leave_type);
        }
        if (! empty($request->search_status)) {
            $leaves->where('status', $request->search_status);
        }

        if (! empty($request->fromsearch_date)) {
            $leaves->where('from_date', '>=', $request->fromsearch_date);
        }
        if (! empty($request->tosearch_date)) {
            $leaves->where('to_date', '<=', $request->tosearch_date);
        }
        $employees = User::where('user_role', '!=', '0')->where('status', '1')->get();
        $userId = User::where('_id', Auth::user()->id)->first();
        $userManager = User::where('_id', $userId->reporting_manager)->first();

        $leaves = $leaves->paginate(10)->withQueryString();
        return view('admin.Leaves.admin-myleaves', compact('leaves', 'employees', 'searchEmployee', 'searchLeave', 'searchStatus', 'searchFromDate', 'searchToDate', 'userManager'));
    }

    public function myleavesUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_type' => 'required',
            // 'from_date' => 'required|date|before_or_equal:to_date|after:' . now()->subDays(5)->toDateString(),
            // 'to_date' => 'required|date|after_or_equal:from_date',
            'from_date' => 'required',
            'to_date' => 'required',
            'from_sessions' => 'required',
            'to_sessions' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $leavebalancedCheck = LeaveAllocation::where('user_id', Auth::user()->_id)->first();

        if (! empty($leavebalancedCheck)) {
            if ($request->leave_type == '1') {
                $casual = $leavebalancedCheck->casual_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                $casualDate = date('Y-m-d', strtotime($request->from_date . ' -5 days'));
                $fromDate = (date('j', strtotime($request->from_date)));
                $toDate = (date('j', strtotime($request->to_date)));
                $dateDifference = $toDate - $fromDate;

                $casualLeave = Leave::where('leave_type', '1')->where('str_from_date', strtotime($request->from_date))
                    ->where('name', Auth::user()->_id)
                    ->first();
                if (! empty($casualLeave)) {
                    if ((strtotime($request->from_date) == $casualLeave->str_from_date)) {
                        return response()->json([
                            'errors' => [
                                'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                            ]
                        ]);
                    }
                }

                if ((strtotime(date('Y-m-d')) - strtotime($casualDate)) > 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'Leave request must be submitted before 5 days in advance.'
                        ]
                    ]);
                }
                if ($dateDifference >= 5) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You can\'t applied more than 5 casual leave at one time'
                        ]
                    ]);
                }

                if ($casual < 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You don\'t have sufficient leave balance.'
                        ]
                    ]);
                }
            }

            if ($request->leave_type == '2') {
                $sick = $leavebalancedCheck->sick_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                $sickDatefrom = date('Y-m-d', strtotime($request->from_date));
                $sickDateto = date('Y-m-d', strtotime($request->to_date));

                $sickLeave = Leave::where('leave_type', '2')->where('str_from_date', strtotime($request->from_date))
                    ->where('name', Auth::user()->_id)
                    ->first();
                if (! empty($sickLeave)) {
                    if ((strtotime($request->from_date) == $sickLeave->str_from_date)) {
                        return response()->json([
                            'errors' => [
                                'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                            ]
                        ]);
                    }
                }
                if ((strtotime($sickDatefrom) > strtotime(date('Y-m-d'))) && (strtotime($sickDateto) > strtotime(date('Y-m-d')))) {
                    return response()->json([
                        'errors' => [
                            'message' => 'This leave cannot be availed post date. The leave date has to be on or before today.'
                        ]
                    ]);
                }

                if ($sick < 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You don\'t have sufficient leave balance.'
                        ]
                    ]);
                }
            }
            if ($request->leave_type == '3') {
                $earnedLeave = $leavebalancedCheck->earned_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                $earnedLeaveCheck = Leave::where('leave_type', '3')->where('str_from_date', strtotime($request->from_date))
                    ->where('name', Auth::user()->_id)
                    ->first();
                if (! empty($earnedLeaveCheck)) {
                    if ((strtotime($request->from_date) == $earnedLeaveCheck->str_from_date)) {
                        return response()->json([
                            'errors' => [
                                'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                            ]
                        ]);
                    }
                }
                if ($earnedLeave < 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You don\'t have sufficient leave balance.'
                        ]
                    ]);
                }
                if (! empty($dateDifference) >= 5) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You can\'t applied more than 5 Earned leave at one time'
                        ]
                    ]);
                }
            }
            if ($request->leave_type == '5') {
                $compOff = $leavebalancedCheck->comp_off - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                $compOffCheck = Leave::where('leave_type', '4')->where('str_from_date', strtotime($request->from_date))
                    ->where('name', Auth::user()->_id)
                    ->first();
                if (! empty($compOffCheck)) {
                    if ((strtotime($request->from_date) == $compOffCheck->str_from_date)) {
                        return response()->json([
                            'errors' => [
                                'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                            ]
                        ]);
                    }
                }
                if ($compOff < 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You don\'t have sufficient leave balance.'
                        ]
                    ]);
                }
            }
            if ($request->leave_type == '5') {
                $compOff = $leavebalancedCheck->comp_off - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                if ($compOff < 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You don\'t have sufficient leave balance.'
                        ]
                    ]);
                }
            }
            if ($request->leave_type == '6') {

                $bereavementDatefrom = date('Y-m-d', strtotime($request->from_date));
                $bereavementDateto = date('Y-m-d', strtotime($request->to_date));

                $beavermentCheck = Leave::where('leave_type', '6')->where('str_from_date', strtotime($request->from_date))
                    ->where('name', Auth::user()->_id)
                    ->first();
                if (! empty($beavermentCheck)) {
                    if ((strtotime($request->from_date) == $beavermentCheck->str_from_date)) {
                        return response()->json([
                            'errors' => [
                                'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                            ]
                        ]);
                    }
                }
                if ((strtotime($bereavementDatefrom) > strtotime(date('Y-m-d'))) && (strtotime($bereavementDateto) > strtotime(date('Y-m-d')))) {
                    return response()->json([
                        'errors' => [
                            'message' => 'Bereavement leave cannot be apply for future date.'
                        ]
                    ]);
                }

                $beaverment = $leavebalancedCheck->bereavement_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                if ($beaverment < 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You don\'t have sufficient leave balance.'
                        ]
                    ]);
                }
                if (! empty($dateDifference) > 3) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You can\'t applied more than 3 Bereavement leave at one time'
                        ]
                    ]);
                }
            }
            if ($request->leave_type == '9') {
                $emergencyleave = $leavebalancedCheck->emergency_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                $emergencyCheck = Leave::where('leave_type', '9')->where('str_from_date', strtotime($request->from_date))
                    ->where('name', Auth::user()->_id)
                    ->first();
                if (! empty($emergencyCheck)) {
                    if ((strtotime($request->from_date) == $emergencyCheck->str_from_date)) {
                        return response()->json([
                            'errors' => [
                                'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                            ]
                        ]);
                    }
                }
                $oneDaybefore = date('Y-m-d', strtotime('-1 day', strtotime($request->from_date)));
                if ((strtotime(date('Y-m-d'))) > (strtotime($oneDaybefore))) {
                    return response()->json([
                        'errors' => [
                            'message' => 'Please select date one day before.'
                        ]
                    ]);
                }
                if ($emergencyleave < 0) {
                    return response()->json([
                        'errors' => [
                            'message' => 'You don\'t have sufficient leave balance.'
                        ]
                    ]);
                }
            }
            // if($request->leave_type == '7'){
            // $maternityLeave = $leavebalancedCheck->maternity_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
            // if(! empty($maternityLeave)){
            // if((strtotime($request->from_date) >= strtotime(date('Y-m-d'))) && (strtotime($request->to_date) >= strtotime(date('Y-m-d')))){
            // return response()->json([
            // 'errors' => [
            // 'message' => 'Maternity leave cannot be apply for present date & future date.'
            // ]
            // ]);
            // }
            // }

            // }
            // if($request->leave_type == '8'){
            // $paternityLeave = $leavebalancedCheck->paternity_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
            // if(! empty($paternityLeave)){
            // if((strtotime($request->from_date) >= strtotime(date('Y-m-d'))) && (strtotime($request->to_date) >= strtotime(date('Y-m-d')))){
            // return response()->json([
            // 'errors' => [
            // 'message' => 'Paternity leave cannot be apply for present date & future date.'
            // ]
            // ]);
            // }
            // }

            // }
        $leaveCheck = Leave::where('name', Auth::user()->_id)->orderBy('_id', 'desc')
            ->where('status', '1')
            ->where('leave_type', '1')
            ->first();
        if (! empty($leaveCheck)) {
            $date_old = date('Y-m-d', strtotime($leaveCheck->from_date . ' + 1 days'));
            if (strtotime($date_old) == strtotime($request->from_date)) {
                return response()->json([
                    'errors' => [
                        'message' => 'You can\'t applied leave'
                    ]
                ]);
            }
        }

        $fromDateCheck = date('Y-m-d', strtotime('-1 day', strtotime($request->from_date)));
        $dateCheck = Leave::where('name', Auth::user()->_id)->where('str_from_date', strtotime($fromDateCheck))
            ->where('status', '2')
            ->first();
        if (! empty($dateCheck)) {
            return response()->json([
                'errors' => [
                    'message' => 'You can\'t applied leave of selected date'
                ]
            ]);
        }

        $leaves = Leave::Create([
            'name' => $request->user_id,
            'leave_type' => $request->leave_type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'str_from_date' => strtotime($request->from_date),
            'str_to_date' => strtotime($request->to_date),
            'reason' => $request->reason,
            'from_sessions' => $request->from_sessions,
            'to_sessions' => $request->to_sessions,
            'status' => "1",
            'type' => '1',
            'created_by' => Auth::user()->_id
        ]);
        Notification::create([
            'type' => get_class($leaves),
            'data' => 'Leave Request',
            'notifiable' => '',
            'read_at' => '',
            'status' => 1,
            'created_by' => $leaves->name
        ]);

        $user = User::where('_id', $leaves->name)->first();
        $reportingManager = User::where('_id', $user->reporting_manager)->first();
        $name = $user->first_name . ' ' . $user->last_name;
        $employe_id = $user->employee_id;

        // $mailQueue = MailQueue::Create([
        // 'subject' => 'Leave Application from ' . $name . '[' . $employe_id . ']',
        // 'data' => [
        // 'name' => $name,
        // 'leave_type' => $request->leave_type,
        // 'reason' => $request->reason,
        // 'from_date' => $request->from_date,
        // 'to_date' => $request->to_date,
        // 'employe_code' => $user->employee_id,
        // 'from_session' => $request->from_sessions,
        // 'to_session' => $request->to_sessions,
        // 'number_of_days' => (date('d', strtotime($request->to_date) - strtotime($request->from_date)))
        // ],
        // 'email' => $reportingManager->email,
        // 'view' => 'emails.employeeLeave',
        // 'status' => 0,
        // 'type' => 0
        // ]);

        Mail::send('emails.employeeLeave', [
            'name' => $name,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'employe_code' => $user->employee_id,
            'from_session' => $request->from_sessions,
            'to_session' => $request->to_sessions,
            'number_of_days' => (date('d', strtotime($request->to_date) - strtotime($request->from_date)))
        ], function ($user) use ($reportingManager, $name, $employe_id) {
            $user->to($reportingManager->email);
            $user->subject(' Leave Application from ' . $name . '[' . $employe_id . ']');
        });
        Session::flash('success', 'Leave added successfully');
        }else{
            return response()->json([
                'errors' => [
                    'message' => 'You don\'t have leave'
                ]
            ]);
        }
    }

    public function leaveDelete(Request $request)
    {
        if (! empty($request->all_ids)) {
            Leave::whereIn('_id', explode(',', $request->all_ids))->delete();
            Session::flash('info', 'Leave deleted successfully');
        }
    }

    public function addLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'leave_type' => 'required',
            'from_date' => 'required|date|before_or_equal:to_date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason' => 'required',
            'from_sessions' => 'required',
            'to_sessions' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $role = Role::where('_id', Auth::user()->user_role)->first();
        if ((! empty($role) && $role->name == 'Management') || (! empty($role) && $role->name == 'HR') || (Auth::user()->user_role == 0)) {
            $leaves = Leave::where('_id', $request->user_id)->first();
            $str_from_date = strtotime($request->from_date) - 1;

            if (! empty($leaves)) {
                $leaves->update([
                    '_id' => $request->user_id,
                    'name' => $request->name,
                    'leave_type' => $request->leave_type,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'str_from_date' => strtotime($request->from_date),
                    'str_to_date' => ($request->to_date),
                    'reason' => ! empty($request) ? $request->reason : '',
                    'status' => $request->status,
                    'from_sessions' => $request->from_sessions,
                    'to_sessions' => $request->to_sessions,
                    'updated_by' => Auth::user()->_id
                ]);
                Session::flash('success', 'Leave updated successfully');
                if (Auth::user()->user_role == 0 || (! empty($role) && $role->name == 'HR') || (! empty($role) && $role->name == 'Management')) {
                    return redirect()->to('/leaves');
                } else {
                    return redirect()->to('/myleaves');
                }
            } else {

                $leavebalancedCheck = LeaveAllocation::where('user_id', $request->name)->first();
                if (! empty($leavebalancedCheck)) {
                    if ($request->leave_type == '1') {
                        $casual = $leavebalancedCheck->casual_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                        $casualDate = date('Y-m-d', strtotime($request->from_date . ' -5 days'));
                        $fromDate = (date('j', strtotime($request->from_date)));
                        $toDate = (date('j', strtotime($request->to_date)));
                        $dateDifference = $toDate - $fromDate;

                        $casualLeave = Leave::where('leave_type', '1')->where('str_from_date', strtotime($request->from_date))
                            ->where('name', $request->name)
                            ->first();
                        if (! empty($casualLeave)) {
                            if ((strtotime($request->from_date) == $casualLeave->str_from_date)) {
                                return response()->json([
                                    'errors' => [
                                        'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                                    ]
                                ]);
                            }
                        }

                        if ((strtotime(date('Y-m-d')) - strtotime($casualDate)) > 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'Leave request must be submitted before 5 days in advance.'
                                ]
                            ]);
                        }
                        if ($dateDifference >= 5) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You can\'t applied more than 5 casual leave at one time'
                                ]
                            ]);
                        }

                        if ($casual < 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You don\'t have sufficient leave balance.'
                                ]
                            ]);
                        }
                    }
                    if ($request->leave_type == '2') {
                        $sick = $leavebalancedCheck->sick_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                        $sickDatefrom = date('Y-m-d', strtotime($request->from_date));
                        $sickDateto = date('Y-m-d', strtotime($request->to_date));

                        $sickLeave = Leave::where('leave_type', '2')->where('str_from_date', strtotime($request->from_date))
                            ->where('name', $request->name)
                            ->first();
                        if (! empty($sickLeave)) {
                            if ((strtotime($request->from_date) == $sickLeave->str_from_date)) {
                                return response()->json([
                                    'errors' => [
                                        'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                                    ]
                                ]);
                            }
                        }
                        if ((strtotime($sickDatefrom) > strtotime(date('Y-m-d'))) && (strtotime($sickDateto) > strtotime(date('Y-m-d')))) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'This leave cannot be availed post date. The leave date has to be on or before today.'
                                ]
                            ]);
                        }

                        if ($sick < 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You don\'t have sufficient leave balance.'
                                ]
                            ]);
                        }
                    }
                    if ($request->leave_type == '3') {
                        $earnedLeave = $leavebalancedCheck->earned_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                        $earnedLeaveCheck = Leave::where('leave_type', '3')->where('str_from_date', strtotime($request->from_date))
                            ->where('name', $request->name)
                            ->first();
                        if (! empty($earnedLeaveCheck)) {
                            if ((strtotime($request->from_date) == $earnedLeaveCheck->str_from_date)) {
                                return response()->json([
                                    'errors' => [
                                        'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                                    ]
                                ]);
                            }
                        }
                        if ($earnedLeave < 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You don\'t have sufficient leave balance.'
                                ]
                            ]);
                        }
                        if (! empty($dateDifference) >= 5) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You can\'t applied more than 5 Earned leave at one time'
                                ]
                            ]);
                        }
                    }
                    if ($request->leave_type == '5') {
                        $compOff = $leavebalancedCheck->comp_off - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                        $compOffCheck = Leave::where('leave_type', '4')->where('str_from_date', strtotime($request->from_date))
                            ->where('name', $request->name)
                            ->first();
                        if (! empty($compOffCheck)) {
                            if ((strtotime($request->from_date) == $compOffCheck->str_from_date)) {
                                return response()->json([
                                    'errors' => [
                                        'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                                    ]
                                ]);
                            }
                        }
                        if ($compOff < 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You don\'t have sufficient leave balance.'
                                ]
                            ]);
                        }
                    }
                    if ($request->leave_type == '5') {
                        $compOff = $leavebalancedCheck->comp_off - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                        if ($compOff < 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You don\'t have sufficient leave balance.'
                                ]
                            ]);
                        }
                    }
                    if ($request->leave_type == '6') {

                        $bereavementDatefrom = date('Y-m-d', strtotime($request->from_date));
                        $bereavementDateto = date('Y-m-d', strtotime($request->to_date));

                        $beavermentCheck = Leave::where('leave_type', '6')->where('str_from_date', strtotime($request->from_date))
                            ->where('name', $request->name)
                            ->first();
                        if (! empty($beavermentCheck)) {
                            if ((strtotime($request->from_date) == $beavermentCheck->str_from_date)) {
                                return response()->json([
                                    'errors' => [
                                        'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                                    ]
                                ]);
                            }
                        }
                        if ((strtotime($bereavementDatefrom) > strtotime(date('Y-m-d'))) && (strtotime($bereavementDateto) > strtotime(date('Y-m-d')))) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'Bereavement leave cannot be apply for future date.'
                                ]
                            ]);
                        }

                        $beaverment = $leavebalancedCheck->bereavement_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                        if ($beaverment < 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You don\'t have sufficient leave balance.'
                                ]
                            ]);
                        }
                        if (! empty($dateDifference) > 3) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You can\'t applied more than 3 Bereavement leave at one time'
                                ]
                            ]);
                        }
                    }
                    if ($request->leave_type == '9') {
                        $emergencyleave = $leavebalancedCheck->emergency_leave - (date('j', strtotime($request->to_date) - strtotime($request->from_date)));
                        $emergencyCheck = Leave::where('leave_type', '9')->where('str_from_date', strtotime($request->from_date))
                            ->where('name', $request->name)
                            ->first();
                        if (! empty($emergencyCheck)) {
                            if ((strtotime($request->from_date) == $emergencyCheck->str_from_date)) {
                                return response()->json([
                                    'errors' => [
                                        'message' => 'Leave date range is overlapping with leave that is already availed or applied.'
                                    ]
                                ]);
                            }
                        }
                        $oneDaybefore = date('Y-m-d', strtotime('-1 day', strtotime($request->from_date)));
                        if ((strtotime(date('Y-m-d'))) > (strtotime($oneDaybefore))) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'Please select date one day before.'
                                ]
                            ]);
                        }
                        if ($emergencyleave < 0) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You don\'t have sufficient leave balance.'
                                ]
                            ]);
                        }
                    }

                    $leaveCheck = Leave::where('name', $request->name)->orderBy('_id', 'desc')
                        ->where('status', '1')
                        ->where('leave_type', '1')
                        ->first();
                    if (! empty($leaveCheck)) {
                        $date_old = date('Y-m-d', strtotime($leaveCheck->from_date . ' + 1 days'));
                        if (strtotime($date_old) == strtotime($request->from_date)) {
                            return response()->json([
                                'errors' => [
                                    'message' => 'You can\'t applied leave'
                                ]
                            ]);
                        }
                    }

                    $fromDateCheck = date('Y-m-d', strtotime('-1 day', strtotime($request->from_date)));
                    $dateCheck = Leave::where('str_from_date', strtotime($fromDateCheck))->where('status', '2')->first();
                    if (! empty($dateCheck)) {
                        return response()->json([
                            'errors' => [
                                'message' => 'You can\'t applied leave of selected date'
                            ]
                        ]);
                    }

                    $str_from_date = strtotime($request->from_date) - 1;
                    $leaves = Leave::Create([
                        'name' => $request->name,
                        'leave_type' => $request->leave_type,
                        'from_date' => $request->from_date,
                        'to_date' => $request->to_date,
                        'str_from_date' => strtotime($request->from_date),
                        'str_to_date' => strtotime($request->to_date),
                        'reason' => $request->reason,
                        'status' => ! empty($request) ? $request->status : "1",
                        'from_sessions' => $request->from_sessions,
                        'to_sessions' => $request->to_sessions,
                        'type' => '1',
                        'created_by' => Auth::user()->_id
                    ]);
                } else {
                    return response()->json([
                        'errors' => [
                            'message' => 'Leave is not allocated this user'
                        ]
                    ]);
                }

                $updateUser = Leave::where('_id', $leaves->_id)->where('name', $leaves->name)->first();
                if ($updateUser->status == '2') {
                    $date_diff = (date('j', strtotime($updateUser->to_date) - strtotime($updateUser->from_date)));
                    $days = ($date_diff);
                    $leaveDedection = LeaveAllocation::where('user_id', $updateUser->name)->where('year', (date('n') >= 4) ? (date('Y') . '-' . (date('Y') + 1)) : (date('Y') - 1) . '-' . date('Y'))->first();

                    if ($updateUser->leave_type == '1' || $updateUser->leave_type == '9') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->casual_leave = $leaveDedection->casual_leave - ($days - $session_deduct);
                        $leaveDedection->emergency_leave = $leaveDedection->emergency_leave - ($days - $session_deduct);
                    } elseif ($updateUser->leave_type == '2') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->sick_leave = $leaveDedection->sick_leave - ($days - $session_deduct);
                    } elseif ($updateUser->leave_type == '5') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->comp_off = $leaveDedection->comp_off - ($days - $session_deduct);
                    } elseif ($updateUser->leave_type == '6') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->bereavement_leave = $leaveDedection->bereavement_leave - ($days - $session_deduct);
                    } elseif ($updateUser->leave_type == '7') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->maternity_leave = $leaveDedection->maternity_leave - ($days - $session_deduct);
                    } elseif ($updateUser->leave_type == '8') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->paternity_leave = $leaveDedection->paternity_leave - ($days - $session_deduct);
                    } elseif ($updateUser->leave_type == '3') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->earned_leave = $leaveDedection->earned_leave - ($days - $session_deduct);
                    } elseif ($updateUser->leave_type == '4') {
                        if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                            $session_deduct = 0;
                        } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                            $session_deduct = 0.5;
                        }
                        $leaveDedection->loss_of_pay_leave = $leaveDedection->loss_of_pay_leave - ($days - $session_deduct);
                    }
                    $leaveDedection->update();
                }
                Notification::create([
                    'type' => get_class($leaves),
                    'data' => 'Leave Request',
                    'notifiable' => '',
                    'read_at' => '',
                    'status' => 1,
                    'created_by' => $leaves->name
                ]);
                Session::flash('success', 'Leave added successfully');
            }
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'leave_type' => 'required',
                'from_date' => 'required|date|before_or_equal:to_date',
                'to_date' => 'required|date|after_or_equal:from_date'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ]);
            }
            $validator['name'] = Auth::user()->_id;
            $leaves = Leave::where('_id', $request->user_id)->first();
            if (! empty($leaves)) {
                $leaves->update([
                    '_id' => $request->user_id,
                    'name' => $validator['name'],
                    'leave_type' => $request->leave_type,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'str_from_date' => strtotime($request->from_date),
                    'str_to_date' => strtotime($request->to_date),
                    'reason' => $request->reason,
                    'created_by' => Auth::user()->_id,
                    'updated_by' => Auth::user()->_id
                ]);
                Session::flash('success', 'Leave updated successfully');

                if (Auth::user()->user_role == 0) {
                    return redirect()->to('/leaves');
                } else {
                    return redirect()->to('/myleaves');
                }
            } else {
                $leaves = Leave::Create([
                    'name' => $validator['name'],
                    'leave_type' => $request->leave_type,
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'str_from_date' => strtotime($request->from_date),
                    'str_to_date' => strtotime($request->to_date),
                    'reason' => $request->reason,
                    'status' => "1",
                    'created_by' => Auth::user()->id
                ]);
                Notification::create([
                    'type' => get_class($leaves),
                    'data' => 'Leave Request',
                    'notifiable' => '',
                    'read_at' => '',
                    'status' => 1,
                    'created_by' => $leaves->name
                ]);
                Session::flash('success', 'Leave added successfully');
                if (Auth::user()->user_role == 0) {
                    return redirect()->to('/leaves');
                } else {
                    return redirect()->to('/myleaves');
                }
            }
        }
    }

    public function editLeave(Request $request)
    {
        $userLeave = Leave::where('_id', $request->id)->first();
        $userName = User::where('_id', $userLeave->name)->first();
        if (! empty($userName)) {
            $employeeName = $userName->first_name . ' ' . $userName->last_name . '(' . $userName->employee_id . ')';
        }
        $data = [
            'id' => $userLeave->name,
            'employeeName' => $employeeName,
            'leave_type' => ! empty($userLeave) ? $userLeave->leave_type : '',
            'from_date' => ! empty($userLeave) ? date('Y-m-d', strtotime($userLeave->from_date)) : '',
            'to_date' => ! empty($userLeave) ? date('Y-m-d', strtotime($userLeave->to_date)) : '',
            'status' => ! empty($userLeave) ? $userLeave->status : '',
            'reason' => ! empty($userLeave) ? $userLeave->reason : ''
        ];
        return json_encode($data);
    }

    public function updateLeave(Request $request, $leave_id, $employ_id)
    {

        // $validator = Validator::make($request->all(), [
        // 'leave_type' => 'required',
        // 'from_date' => 'required|date|before_or_equal:to_date',
        // 'to_date' => 'required|date|after_or_equal:from_date'
        // // 'from_sessions' => 'required',
        // // 'to_sessions' => 'required'
        // ]);
        // if ($validator->fails()) {
        // return response()->json([
        // 'errors' => $validator->errors()
        // ]);
        // }
        $updateUser = Leave::where('_id', $leave_id)->where('name', $employ_id)->first();

        // $updateUser->leave_type = ! empty($request->leave_type) ? $request->leave_type : '';
        // $updateUser->from_date = ! empty($request->from_date) ? $request->from_date : '';
        // $updateUser->to_date = ! empty($request->to_date) ? $request->to_date : '';

        // $updateUser->str_from_date = strtotime($request->from_date);
        // $updateUser->str_to_date = strtotime($request->to_date);
        // $updateUser->status = ! empty($request->status) ? $request->status : "";
        // $updateUser->reason = ! empty($request->reason) ? $request->reason : "";
        $updateUser->status = '2';
        $updateUser->updated_by = Auth::user()->_id;
        $updateUser->update();

        Notification::create([
            'type' => get_class($updateUser),
            'data' => 'Leave Request',
            'notifiable' => '',
            'read_at' => '',
            'status' => 1,
            'created_by' => $updateUser->name
        ]);

        /* Leave Dedect here */
        if ($updateUser->status == '2') {

            $date_diff = (date('j', strtotime($updateUser->to_date) - strtotime($updateUser->from_date)));
            $days = ($date_diff);
            $leaveDedection = LeaveAllocation::where('user_id', $updateUser->name)->where('year', (date('n') >= 4) ? (date('Y') . '-' . (date('Y') + 1)) : (date('Y') - 1) . '-' . date('Y'))->first();
            if (! empty($leaveDedection)) {
                if ($updateUser->leave_type == '1' || $updateUser->leave_type == '9') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->casual_leave = $leaveDedection->casual_leave - ($days - $session_deduct);
                    $leaveDedection->emergency_leave = $leaveDedection->emergency_leave - ($days - $session_deduct);
                } elseif ($updateUser->leave_type == '2') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->sick_leave = $leaveDedection->sick_leave - ($days - $session_deduct);
                } elseif ($updateUser->leave_type == '5') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->comp_off = $leaveDedection->comp_off - ($days - $session_deduct);
                } elseif ($updateUser->leave_type == '6') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->bereavement_leave = $leaveDedection->bereavement_leave - ($days - $session_deduct);
                } elseif ($updateUser->leave_type == '7') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->maternity_leave = $leaveDedection->maternity_leave - ($days - $session_deduct);
                } elseif ($updateUser->leave_type == '8') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->paternity_leave = $leaveDedection->paternity_leave - ($days - $session_deduct);
                } elseif ($updateUser->leave_type == '3') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->earned_leave = $leaveDedection->earned_leave - ($days - $session_deduct);
                } elseif ($updateUser->leave_type == '4') {
                    if ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    } elseif ($updateUser->from_sessions == '1' && $updateUser->to_sessions == '2') {
                        $session_deduct = 0;
                    } elseif ($updateUser->from_sessions == '2' && $updateUser->to_sessions == '1') {
                        $session_deduct = 0.5;
                    }
                    $leaveDedection->loss_of_pay_leave = $leaveDedection->loss_of_pay_leave - ($days - $session_deduct);
                }
                $leaveDedection->update();
            }
            
        }

        /* End here */

        /* Email Functionality Start */
        if ($updateUser->leave_type !== '5') {
            $user = User::where('_id', $updateUser->name)->first();
            $reportingManager = User::where('_id', $user->reporting_manager)->first();
            $rm = $reportingManager->first_name . ' ' . $reportingManager->last_name;
            $name = $user->first_name . ' ' . $user->last_name;
            $user_mail = $user->email;
            $leave_status = $updateUser->status;
            if ($leave_status == '2') {
                $leave_status = 'Approved';
            } elseif ($leave_status == '3') {
                $leave_status = 'Rejected';
            }
            $leaveBalanced = LeaveAllocation::where('user_id', $updateUser->name)->first();
            // $mailQueue = MailQueue::Create([
            // 'subject' => 'Leave request has been' . ' ' . $leave_status,
            // 'data' => [
            // 'name' => $name,
            // 'leave_type' => $updateUser->leave_type,
            // 'reason' => $updateUser->reason,
            // 'from_date' => date('Y-m-d', strtotime($updateUser->from_date)),
            // 'to_date' => date('Y-m-d', strtotime($updateUser->to_date)),
            // 'employe_code' => $user->employee_id,
            // 'from_session' => $updateUser->from_sessions,
            // 'to_session' => $updateUser->to_sessions,
            // 'number_of_days' => (date('d', strtotime($updateUser->to_date) - strtotime($updateUser->from_date))),
            // 'leave_status' => $updateUser->status,
            // 'leaveBalanced' => $leaveBalanced
            // ],
            // 'email' => $user_mail,
            // 'view' => 'emails.approvedLeave',
            // 'status' => 0,
            // 'type' => 0
            // ]);

            Mail::send('emails.approvedLeave', [
                'name' => $name,
                'leave_type' => $updateUser->leave_type,
                'reason' => $updateUser->reason,
                'from_date' => $updateUser->from_date,
                'to_date' => $updateUser->to_date,
                'employe_code' => $user->employee_id,
                'from_session' => $updateUser->from_sessions,
                'to_session' => $updateUser->to_sessions,
                'number_of_days' => (date('d', strtotime($updateUser->to_date) - strtotime($updateUser->from_date))),
                'leave_status' => $updateUser->status,
                'leaveBalanced' => $leaveBalanced,
                'rm' => $rm
            ], function ($user) use ($name, $leave_status, $user_mail) {
                $user->to($user_mail);
                $user->subject('Leave request has been' . ' ' . $leave_status);
            });
        }
        /* End Here */

        Session::flash('success', 'Leave approved successfully');
        return redirect('/leaves');
    }

    public function rejectLeave($leave_id, $employ_id)
    {
        $rejectLeave = Leave::where('_id', $leave_id)->where('name', $employ_id)->first();
        $rejectLeave->status = '3';
        $rejectLeave->updated_by = Auth::user()->_id;
        $rejectLeave->update();
        if ($rejectLeave->leave_type !== '5') {
            $user = User::where('_id', $employ_id)->first();
            $reportingManager = User::where('_id', $user->reporting_manager)->first();
            $rm = $reportingManager->first_name . ' ' . $reportingManager->last_name;
            $name = $user->first_name . ' ' . $user->last_name;
            $user_mail = $user->email;
            $leave_status = $rejectLeave->status;
            if ($leave_status == '2') {
                $leave_status = 'Approved';
            } elseif ($leave_status == '3') {
                $leave_status = 'Rejected';
            }

            $leaveBalanced = LeaveAllocation::where('user_id', $rejectLeave->name)->first();

            Mail::send('emails.approvedLeave', [
                'name' => $name,
                'leave_type' => $rejectLeave->leave_type,
                'reason' => $rejectLeave->reason,
                'from_date' => $rejectLeave->str_from_date,
                'to_date' => $rejectLeave->str_to_date,
                'employe_code' => $user->employee_id,
                'from_session' => $rejectLeave->from_sessions,
                'to_session' => $rejectLeave->to_sessions,
                'number_of_days' => (date('d', strtotime($rejectLeave->to_date) - strtotime($rejectLeave->from_date))),
                'leave_status' => $rejectLeave->status,
                'leaveBalanced' => $leaveBalanced,
                'rm' => $rm
            ], function ($user) use ($name, $leave_status, $user_mail) {
                $user->to($user_mail);
                $user->subject('Leave request has been' . ' ' . $leave_status);
            });
            Session::flash('success', 'Oh! You\'re rejected a leave request 😔');
            return redirect('/leaves');
        }
    }

    public function singleDelete(Request $request)
    {
        $userDelete = Leave::where('_id', $request->id)->first();
        $userDelete->delete();
        Session::flash('success', 'Leave deleted successfully');
    }

    public function editMyLeave(Request $request)
    {
        $userLeave = Leave::where('_id', $request->id)->first();

        $userName = User::where('_id', $userLeave->name)->first();
        if (! empty($userName)) {
            $employeeName = $userName->first_name . ' ' . $userName->last_name;
        }
        $data = [
            'id' => $userLeave->name,
            'employeeName' => $employeeName,
            'leave_type' => ! empty($userLeave) ? $userLeave->leave_type : '',
            'from_date' => ! empty($userLeave) ? date('Y-m-d', $userLeave->str_from_date) : '',
            'to_date' => ! empty($userLeave) ? date('Y-m-d', $userLeave->str_to_date) : '',
            'from_sessions' => ! empty($userLeave) ? $userLeave->from_sessions : '',
            'to_sessions' => ! empty($userLeave) ? $userLeave->to_sessions : '',
            'status' => ! empty($userLeave) ? $userLeave->status : '',
            'reason' => ! empty($userLeave) ? $userLeave->reason : ''
        ];
        return json_encode($data);
    }

    public function updateMyLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_type' => 'required',
            'from_date' => 'required|date|before_or_equal:to_date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'from_sessions' => 'required',
            'to_sessions' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $updateUser = Leave::where('_id', $request->employee_id)->first();

        $updateUser->leave_type = ! empty($request->leave_type) ? $request->leave_type : '';
        $updateUser->str_from_date = ! empty($request->from_date) ? strtotime($request->from_date) : '';
        $updateUser->str_to_date = ! empty($request->to_date) ? strtotime($request->to_date) : '';
        $updateUser->status = ! empty($request->status) ? $request->status : "";
        $updateUser->reason = ! empty($request->reason) ? $request->reason : "";
        $updateUser->from_sessions = ! empty($request->from_sessions) ? $request->from_sessions : '';
        $updateUser->to_sessions = ! empty($request->to_sessions) ? $request->to_sessions : '';
        $updateUser->update();
        Session::flash('success', 'Leave updated successfully');
    }

    public function myDelete(Request $request)
    {
        $userDelete = Leave::where('_id', $request->id)->first();
        $userDelete->delete();
    }

    public function reasonView(Request $request)
    {
        $leaves = Leave::where('_id', $request->id)->first();

        $data = [
            'reason' => ! empty($leaves) ? $leaves->reason : ''
        ];
        return json_encode($data);
    }

    public function extendedReason(Request $request)
    {
        $joiningLog = JoiningLogs::where('joining_details_id', $request->id)->where('user_id', $request->user_id)->first();
        $data = [
            'reason' => ! empty($joiningLog) ? $joiningLog->reason : ''
        ];
        return json_encode($data);
    }

    public function leaveBalanced(Request $request, $id = null)
    {
        $role = Role::where('_id', Auth::user()->user_role)->first();
        if (! empty($role) && ($role->name == 'Management')) {
            $userManager = User::where('reporting_manager', Auth::user()->_id)->where('status', '1')
                ->get()
                ->pluck('_id')
                ->toArray();
            $employeeLeaveBalanced = LeaveAllocation::whereIn('user_id', $userManager)->orWhere('user_id', Auth::user()->_id)
                ->get()
                ->pluck('user_id')
                ->toArray();
            $employees = User::whereIn('_id', $employeeLeaveBalanced)->get();
        } else {
            $userManager = User::where('status', '1')->get()
                ->pluck('_id')
                ->toArray();
            $employeeLeaveBalanced = LeaveAllocation::whereIn('user_id', $userManager)->orWhere('user_id', Auth::user()->_id)
                ->get()
                ->pluck('user_id')
                ->toArray();
            $employees = User::whereIn('_id', $employeeLeaveBalanced)->get();
        }
        if (! empty($id)) {
            $user = User::where('_id', $id)->where('status', '1')->first();
        } else {
            $user = User::where('_id', Auth::user()->_id)->where('status', '1')->first();
        }

        if (! empty($id)) {
            $user = User::where('_id', $id)->where('status', '1')->first();
        } else {
            $user = User::where('_id', Auth::user()->_id)->where('status', '1')->first();
        }

        $casualLeave = Leave::where('name', Auth::user()->_id)->where('type', '1')
            ->where('leave_type', '1')
            ->where('status', '2')
            ->get();
        // $casualLeaveDiff = ! empty($casualLeave) ? $casualLeave->str_to_date - $casualLeave->str_from_date : '';

        $sickLeave = Leave::where('name', Auth::user()->_id)->where('type', '1')
            ->where('leave_type', '2')
            ->where('status', '2')
            ->first();
        $sickLeaveDiff = ! empty($sickLeave) ? $sickLeave->str_to_date - $sickLeave->str_from_date : '';

        $compLeave = Leave::where('name', Auth::user()->_id)->where('type', '1')
            ->where('leave_type', '5')
            ->where('status', '2')
            ->first();
        $compLeaveDiff = ! empty($compLeave) ? $compLeave->str_to_date - $compLeave->str_from_date : '';

        $beavermentLeave = Leave::where('name', Auth::user()->_id)->where('type', '1')
            ->where('leave_type', '6')
            ->where('status', '2')
            ->first();
        $beavermentLeaveDiff = ! empty($beavermentLeave) ? $beavermentLeave->str_to_date - $beavermentLeave->str_from_date : '';

        $maternityLeave = Leave::where('name', Auth::user()->_id)->where('type', '1')
            ->where('leave_type', '7')
            ->where('status', '2')
            ->first();
        $maternityLeaveDiff = ! empty($maternityLeave) ? $maternityLeave->str_to_date - $maternityLeave->str_from_date : '';

        $paternityLeave = Leave::where('name', Auth::user()->_id)->where('type', '1')
            ->where('leave_type', '8')
            ->where('status', '2')
            ->first();
        $paternityLeaveLeaveDiff = ! empty($paternityLeave) ? $paternityLeave->str_to_date - $paternityLeave->str_from_date : '';

        $earnedLeave = Leave::where('name', Auth::user()->_id)->where('type', '1')
            ->where('leave_type', '3')
            ->where('status', '2')
            ->first();
        $earnedLeaveDiff = ! empty($earnedLeave) ? $earnedLeave->str_to_date - $earnedLeave->str_from_date : '';

        $masterLeave = MasterLeaves::first();
        if (! empty($id)) {
            $leaveBalanced = LeaveAllocation::where('user_id', $id)->first();

            $compOff = Leave::where('name', $id)->where('type', '2')->get();
        } else {
            $id = Auth::user()->_id;
            $leaveBalanced = LeaveAllocation::where('user_id', Auth::user()->_id)->first();
            $compOff = Leave::where('name', $user->_id)->where('type', '2')->get();
        }
        $masterLeave = MasterLeaves::first();

        if (! empty($role) && ($role->name == 'Management')) {
            return view('admin.Leaves.balances-leaves', compact('leaveBalanced', 'user', 'masterLeave', 'compOff', 'employees', 'id', 'sickLeaveDiff', 'beavermentLeaveDiff', 'maternityLeaveDiff', 'paternityLeaveLeaveDiff', 'compLeaveDiff', 'earnedLeaveDiff', 'casualLeave', 'masterLeave'));
        } else {
            return view('admin.Leaves.balances-leaves', compact('leaveBalanced', 'user', 'masterLeave', 'compOff', 'id', 'sickLeaveDiff', 'beavermentLeaveDiff', 'maternityLeaveDiff', 'paternityLeaveLeaveDiff', 'compLeaveDiff', 'earnedLeaveDiff', 'casualLeave', 'employees', 'masterLeave'));
        }
    }

    public function employeeCompoff(Request $request)
    {
        $searchEmployee = $request->user_id ?? '';
        $searchFromDate = $request->fromsearch_date ?? '';
        $searchToDate = $request->tosearch_date ?? '';
        $employeeCompOff = Leave::orderBy('_id', 'DESC')->where('type', '2');

        $employees = User::where('user_role', '!=', '0')->where('status', '1')
            ->orderBy('first_name', 'ASC')
            ->get();
        if (! empty($request->user_id)) {
            $employeeCompOff->where('name', '=', $searchEmployee);
        }
        if (! empty($request->fromsearch_date)) {
            $employeeCompOff->where('from_date', '=', $searchFromDate);
        }
        if (! empty($request->tosearch_date)) {
            $employeeCompOff->where('to_date', '=', $searchToDate);
        }
        $employeeCompOff = $employeeCompOff->paginate(10);
        return view('admin.Leaves.employee-comp-off', compact('employeeCompOff', 'searchFromDate', 'searchToDate', 'employees', 'searchEmployee'));
    }

    public function MyemployeeCompoff(Request $request)
    {
        $role = Role::where('_id', Auth::user()->user_role)->first();
        if (! empty($role) && ($role->name == 'Management')) {
            $employees = User::where('reporting_manager', Auth::user()->_id)->get()
                ->pluck('_id')
                ->toArray();
            $employeeCompOff = Leave::whereIn('name', $employees)->where('type', '2')
                ->orderBy('_id', 'desc')
                ->paginate();
        } elseif ((! empty($role) && ($role->name == 'HR')) || (Auth::user()->user_role == 0)) {
            $employees = User::get()->pluck('_id')->toArray();
            $employeeCompOff = Leave::whereIn('name', $employees)->where('type', '2')->paginate();
        }
        return view('admin.Leaves.Myemployee-comp-off', compact('employeeCompOff'));
    }

    public function editMyEmployeeComp(Request $request)
    {
        $userLeave = Leave::where('_id', $request->id)->first();

        $userName = User::where('_id', $userLeave->name)->first();

        if (! empty($userName)) {
            $employeeName = $userName->first_name . ' ' . $userName->last_name;
        }
        $data = [
            'id' => $userLeave->name,
            'employeeName' => $employeeName,
            'leave_type' => ! empty($userLeave) ? $userLeave->leave_type : '',
            'str_from_date' => ! empty($userLeave) ? date('Y-m-d', $userLeave->str_from_date) : '',
            'str_to_date' => ! empty($userLeave) ? date('Y-m-d', $userLeave->str_to_date) : '',
            'status' => ! empty($userLeave) ? $userLeave->status : '',
            'reason' => ! empty($userLeave) ? $userLeave->reason : '',
            'from_sessions' => ! empty($userLeave) ? $userLeave->from_sessions : '',
            'to_sessions' => ! empty($userLeave) ? $userLeave->to_sessions : ''
        ];
        return json_encode($data);
    }

    public function updateMyEmployeeCompOff(Request $request)
    {
        $updateComp = Leave::where('_id', $request->id)->where('type', '2')->first();

        $compAllocation = LeaveAllocation::where('user_id', $updateComp->name)->first();
        if ($updateComp->status == '2') {
            if ($request->status == '1' || $request->status == '3') {
                $compAllocation->comp_off = ((isset($compAllocation->comp_off) && ! empty($compAllocation->comp_off)) ? $compAllocation->comp_off : 0) - (date('j', strtotime($updateComp->str_to_date) - strtotime($updateComp->str_from_date)));
                $compAllocation->update();
            }
        } elseif ($updateComp->status == '3') {
            if ($request->status == '2') {
                $compAllocation->comp_off = ((isset($compAllocation->comp_off) && ! empty($compAllocation->comp_off)) ? $compAllocation->comp_off : 0) + (date('j', strtotime($updateComp->str_to_date) - strtotime($updateComp->str_from_date)));
                $compAllocation->update();
            }
        } else {
            if ($request->status == '2') {
                $compAllocation->comp_off = ((isset($compAllocation->comp_off) && ! empty($compAllocation->comp_off)) ? $compAllocation->comp_off : 0) + (date('j', strtotime($updateComp->str_to_date) - strtotime($updateComp->str_from_date)));
                $compAllocation->update();
            }
        }
        $updateComp->status = ! empty($request->status) ? $request->status : "";
        $updateComp->updated_by = Auth::user()->_id;
        $updateComp->update();

        $user = User::where('_id', $updateComp->name)->first();
        $employeeMail = $user->email;
        $name = $user->first_name . ' ' . $user->last_name;
        $leave_status = $updateComp->status;
        if ($leave_status == '2') {
            $leave_status = 'Approved';
        } elseif ($leave_status == '3') {
            $leave_status = 'Rejected';
        } elseif ($leave_status == '1') {
            $leave_status = 'Pending';
        }

        // $mailQueue = MailQueue::Create([
        // 'subject' => ' Your Comp - Off request has been ' . ' ' . $leave_status,
        // 'data' => [
        // 'name' => $name,
        // 'leave_type' => $request->leave_type,
        // 'reason' => $request->reason,
        // 'from_date' => date('Y-m-d', strtotime($request->from_date)),
        // 'to_date' => date('Y-m-d', strtotime($request->to_date)),
        // 'employe_code' => $user->employee_id,
        // 'from_session' => $request->from_sessions,
        // 'to_session' => $request->to_sessions,
        // 'number_of_days' => (date('d', strtotime($request->to_date) - strtotime($request->from_date))),
        // 'leave_status' => $request->status,
        // ],
        // 'email' => $employeeMail,
        // 'view' => 'emails.employeeCompOff',
        // 'status' => 0,
        // 'type' => 0
        // ]);

        Mail::send('emails.employeeCompOff', [
            'name' => $name,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'employe_code' => $user->employee_id,
            'from_session' => $updateComp->from_sessions,
            'to_session' => $updateComp->to_sessions,
            'leave_status' => $updateComp->status,
            'number_of_days' => (date('d', strtotime($request->to_date) - strtotime($request->from_date)))
        ], function ($user) use ($leave_status, $employeeMail) {
            $user->to($employeeMail);
            $user->subject(' Your Comp - Off request has been ' . $leave_status);
        });

        Session::flash('success', 'Comp - off updated successfully');
    }

    public function editEmployeeComp(Request $request)
    {
        $userLeave = Leave::where('_id', $request->id)->first();
        $userName = User::where('_id', $userLeave->name)->first();
        if (! empty($userName)) {
            $employeeName = $userName->first_name . ' ' . $userName->last_name;
        }
        $data = [
            'id' => $userLeave->name,
            'employeeName' => $employeeName,
            'leave_type' => ! empty($userLeave) ? $userLeave->leave_type : '',
            'str_from_date' => ! empty($userLeave) ? date('Y-m-d', $userLeave->str_from_date) : '',
            'str_to_date' => ! empty($userLeave) ? date('Y-m-d', $userLeave->str_to_date) : '',
            'status' => ! empty($userLeave) ? $userLeave->status : '',
            'reason' => ! empty($userLeave) ? $userLeave->reason : '',
            'from_sessions' => ! empty($userLeave) ? $userLeave->from_sessions : '',
            'to_sessions' => ! empty($userLeave) ? $userLeave->to_sessions : ''
        ];
        return json_encode($data);
    }

    public function updateCompOff(Request $request)
    {
        $updateComp = Leave::where('_id', $request->id)->where('leave_type', 'comp_off')
            ->where('type', '2')
            ->first();
        $compAllocation = LeaveAllocation::where('user_id', $updateComp->name)->first();
        if ($updateComp->status == '2') {
            $from = $updateComp->str_from_date;
            $to = $updateComp->str_to_date;
            $diff = $to - $from;
            if ($request->status == '1' || $request->status == '3') {
                $compAllocation->comp_off = ((isset($compAllocation->comp_off) && ! empty($compAllocation->comp_off)) ? $compAllocation->comp_off : 0) - (date('j', $diff));
                $compAllocation->update();
            }
        } elseif ($updateComp->status == '3') {
            $from = $updateComp->str_from_date;
            $to = $updateComp->str_to_date;
            $diff = $to - $from;
            if ($request->status == '2') {
                $compAllocation->comp_off = ((isset($compAllocation->comp_off) && ! empty($compAllocation->comp_off)) ? $compAllocation->comp_off : 0) + (date('j', $diff));
                $compAllocation->update();
            }
        } else {
            if ($request->status == '2') {
                $from = $updateComp->str_from_date;
                $to = $updateComp->str_to_date;
                $diff = $to - $from;
                $compAllocation->comp_off = ((isset($compAllocation->comp_off) && ! empty($compAllocation->comp_off)) ? $compAllocation->comp_off : 0) + (date('j', $diff));
                $compAllocation->update();
            }
        }
        $updateComp->status = ! empty($request->status) ? $request->status : "";
        $updateComp->updated_by = Auth::user()->_id;
        $updateComp->update();

        $user = User::where('_id', $updateComp->name)->first();
        $reportingManager = User::where('_id', $user->reporting_manager)->first();
        $name = $user->first_name . ' ' . $user->last_name;
        $employe_id = $user->employee_id;
        $userMail = $user->email;
        $leave_status = $updateComp->status;
        if ($leave_status == '2') {
            $leave_status = 'Approved';
        } elseif ($leave_status == '3') {
            $leave_status = 'Rejected';
        }
        Mail::send('emails.employeeCompOff', [
            'name' => $name,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'employe_code' => $user->employee_id,
            'from_session' => $request->from_sessions,
            'to_session' => $request->to_sessions,
            'leave_status' => $updateComp->status,
            'number_of_days' => (date('d', strtotime($request->to_date) - strtotime($request->from_date)))
        ], function ($user) use ($reportingManager, $name, $employe_id, $leave_status, $userMail) {
            $user->to($userMail);
            $user->subject(' Your Comp - Off request has been ' . $leave_status);
        });

        Session::flash('success', 'Comp - off updated successfully');
    }

    public function deleteComp(Request $request)
    {
        $compDelete = Leave::where('_id', $request->id)->where('type', '2')->first();
        $compDelete->delete();
    }

    public function deleteEmployeeCompOff(Request $request)
    {
        $compDelete = Leave::where('_id', $request->id)->where('type', '2')->first();
        $compDelete->delete();
    }

    public function compOff()
    {
        $compOff = Leave::orderBy('_id', 'DESC')->where('type', '2')
            ->where('name', Auth::user()->_id)
            ->paginate(10);
        $userId = User::where('_id', Auth::user()->id)->first();
        $userManager = User::where('_id', $userId->reporting_manager)->first();
        return view('admin.Leaves.leave-grant', compact('userManager', 'compOff'));
    }

    public function addCompoff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_type' => 'required',
            'from_date' => 'required|date|before_or_equal:to_date',
            'to_date' => 'required|date|after_or_equal:from_date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $myCompoff = Leave::Create([
            'name' => $request->user_id,
            'leave_type' => $request->leave_type,
            'str_from_date' => strtotime($request->from_date),
            'str_to_date' => strtotime($request->to_date),
            'reason' => $request->reason,
            'from_sessions' => $request->from_sessions,
            'to_sessions' => $request->to_sessions,
            'status' => "1",
            'type' => '2',
            'created_by' => Auth::user()->_id
        ]);

        $user = User::where('_id', $myCompoff->name)->first();
        $reportingManager = User::where('_id', $user->reporting_manager)->first();
        $name = $user->first_name . ' ' . $user->last_name;
        $employe_id = $user->employee_id;
        $leave_status = $myCompoff->status;
        if ($leave_status == '2') {
            $leave_status = 'Approved';
        } elseif ($leave_status == '3') {
            $leave_status = 'Rejected';
        }
        Mail::send('emails.managerCompOff', [
            'name' => $name,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'employe_code' => $user->employee_id,
            'from_session' => $request->from_sessions,
            'to_session' => $request->to_sessions,
            'number_of_days' => (date('d', strtotime($request->to_date) - strtotime($request->from_date))),
            'leave_status' => $myCompoff->status
        ], function ($user) use ($reportingManager, $name, $employe_id, $leave_status) {
            $user->to($reportingManager->email);
            $user->subject('A Comp - Off request from' . ' ' . $name . '[' . $employe_id . ']');
        });
    }

    public function allCompOffDelete(Request $request)
    {
        if (! empty($request->all_ids)) {
            Leave::whereIn('_id', explode(',', $request->all_ids))->where('type', '2')->delete();
            Session::flash('info', 'Comp - off deleted successfully');
        }
    }

    public function addEmployeeComp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_type' => 'required',
            'from_date' => 'required|date|before_or_equal:to_date',
            'to_date' => 'required|date|after_or_equal:from_date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $addCompoff = Leave::Create([
            'name' => $request->name,
            'leave_type' => $request->leave_type,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'reason' => $request->reason,
            'from_sessions' => $request->from_sessions,
            'to_sessions' => $request->to_sessions,
            'status' => "1",
            'type' => '2',
            'created_by' => Auth::user()->_id
        ]);
    }

    public function withdrawLeave(Request $request, $leave_id)
    {
        $leave = Leave::where('_id', $leave_id)->update([
            'status' => 4
        ]);
        $userLeave = Leave::where('_id', $leave_id)->first();
        $user = User::where('_id', $userLeave->name)->first();
        $reportingManager = User::where('_id', $user->reporting_manager)->first();
        $rmMail = $reportingManager->email;
        $employe_id = $user->employee_id;
        $name = $user->first_name . ' ' . $user->last_name;
        Mail::send('emails.withdrawMail', [
            'name' => $name,
            'leave_type' => $userLeave->leave_type,
            'from_date' => $userLeave->str_from_date,
            'to_date' => $userLeave->str_to_date,
            'employe_code' => $user->employee_id,
            'from_session' => $userLeave->from_sessions,
            'to_session' => $userLeave->to_sessions,
            'number_of_days' => (date('d', $userLeave->str_to_date - $userLeave->str_from_date))
        ], function ($user) use ($rmMail, $name, $employe_id) {
            $user->to($rmMail);
            $user->subject('Leave from ' . $name . '[' . $employe_id . ']' . ' ' . 'has been withdrawn');
        });
        Session::flash('success', 'Leave withdraw successfully');
        return redirect('/myleaves');
    }
    public function deleteAlocation()
    {
        Leave::truncate();
    }
}
