<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterLeaves;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\LeaveAllocation;
use App\Models\Leave;
use App\Models\MailQueue;
use App\Models\Schedule;
use App\Models\ScheduleLogs;
use App\Models\UserJoiningDetail;
use App\Models\UserAttendanceDetail;
use App\Models\NotificationRead;
use App\Models\UserAttendance;
use App\Models\Notification;

class MasterLeaveController extends Controller
{

    public function masterLeaves()
    {

        $masterLeave = MasterLeaves::first();
        return view('admin.Leaves.master-leaves', compact('masterLeave'));
    }

    public function addmasterLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'office_casual_leave' => 'required',
            'office_sick_leave' => 'required',
            'office_bereavement_leave' => 'required',
//             'office_loss_of_pay_leave' => 'required',
            'office_maternity_leave' => 'required',
            'office_paternity_leave' => 'required',
            'office_earned_leave' => 'required',
            'home_casual_leave' => 'required',
            'home_sick_leave' => 'required',
            'home_bereavement_leave' => 'required',
//             'home_loss_of_pay_leave' => 'required',
            'home_maternity_leave' => 'required',
            'home_paternity_leave' => 'required',
            'home_earned_leave' => 'required',
            'office_materirty_paternity_months' => 'required',
            'home_materirty_paternity_months' => 'required',
            'office_earned_leave_months'=>'required',
            'home_earned_leave_months'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $masterLeave = MasterLeaves::updateOrCreate([
            'type' => '1'
        ], [
            'office_casual_leave' => $request->office_casual_leave,
            'office_sick_leave' => $request->office_sick_leave,
            'office_bereavement_leave' => $request->office_bereavement_leave,
            'office_loss_of_pay_leave' => $request->office_loss_of_pay_leave,
            'office_maternity_leave' => $request->office_maternity_leave,
            'office_paternity_leave' => $request->office_paternity_leave,
            'office_earned_leave' => $request->office_earned_leave,
            'home_casual_leave' => $request->home_casual_leave,
            'home_sick_leave' => $request->home_sick_leave,
            'home_bereavement_leave' => $request->home_bereavement_leave,
            'home_loss_of_pay_leave' => $request->home_loss_of_pay_leave,
            'home_maternity_leave' => $request->home_maternity_leave,
            'home_paternity_leave' => $request->home_paternity_leave,
            'home_earned_leave' => $request->home_earned_leave,
            'office_materirty_paternity_months' => $request->office_materirty_paternity_months,
            'home_materirty_paternity_months' => $request->home_materirty_paternity_months,
            'office_earned_leave_months'=>$request->office_earned_leave_months,
            'home_earned_leave_months'=>$request->home_earned_leave_months,
            'created_by' => Auth::user()->_id
        ]);
        Session::flash('success', 'Master Leave updated successfully');
        Schedule::truncate();
    }
}
