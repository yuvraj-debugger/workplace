<?php
namespace App\Http\Livewire;

use App\Models\Leave;
use App\Models\User;
use App\Models\UserAttendance;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class AdminWhoisin extends Component
{

    public function render()
    {
        $role = Role::where('_id', Auth::user()->user_role)->first();
        
        if (Auth::user()->user_role == 0 || ! empty($role) && $role->name=="HR") {
            $UserTime = UserAttendance::where('punch_in', '!=', '')->where('punch_in', '<=', strtotime(date('Y-m-d 09:30:00')))
            ->where('date',strtotime(date('Y-m-d')))->orderBy('punch_in','DESC')
                ->get()
                ->pluck('user_id')
                ->toArray();
                $allUserPunchIn=[];
                foreach ($UserTime as $ontime){
                    $allUserPunchIn[] = User::where('_id', $ontime)->first();
                }
          $userLate = UserAttendance::where('punch_in', '!=', '')->where('punch_in', '>=', strtotime(date('Y-m-d 09:30:00')))->where('date',strtotime(date('Y-m-d')))->orderBy('punch_in','DESC')
                ->get()
                ->pluck('user_id')
                ->toArray();
                $userLateArrival=[];
                foreach ($userLate as $lateUser){
                    $userLateArrival[]=User::where('_id', $lateUser)->first();
                }
            $userNot = UserAttendance::where('date', strtotime(date('Y-m-d')))->get()
                ->pluck('user_id')
                ->toArray();
            $userNotLogIn = User::whereNotIn('_id', $userNot)->where('user_role', '!=', '0')->where('status','1')->get();
            
//             $userLateArrival = User::whereIn('_id', $userLate)->get();

//             $allUserPunchIn = User::whereIn('_id', $UserTime)->get();

            $leavePending = Leave::where('from_date', '>=', date('Y-m-d'))->where('status', '1')->get();

            return view('livewire.admin-whoisin', compact('leavePending', 'userNotLogIn', 'userLateArrival', 'allUserPunchIn'));
        } else {

            $leavePending = Leave::where('status', '1')->get();

            $userManager = User::where('reporting_manager', Auth::user()->_id)->get()
                ->pluck('_id')
                ->toArray();

            $userAttendance = UserAttendance::whereIn('user_id', $userManager)->where('punch_in', '!=', '')
            ->where('punch_in', '>=', strtotime(date('Y-m-d 09:30:00')))->where('date',strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $userPunch = UserAttendance::whereIn('user_id', $userManager)->where('punch_in', '!=', '')
            ->where('punch_in', '<=', strtotime(date('Y-m-d 09:30:00')))->where('date',strtotime(date('Y-m-d')))
                ->get()
                ->pluck('user_id')
                ->toArray();

            $userNotIn = UserAttendance::where('date', strtotime(date('Y-m-d')))->get()
                ->pluck('user_id')
                ->toArray();

            $userLateArrival = User::whereIn('_id', $userAttendance)->get();

            $allUserPunchIn = User::whereIn('_id', $userPunch)->get();

            $userNotLogIn = User::where('reporting_manager', Auth::user()->_id)->whereNotIn('_id', $userNotIn)->where('status','1')->get();

            return view('livewire.admin-whoisin', compact('leavePending', 'userNotLogIn', 'userLateArrival', 'allUserPunchIn'));
        }
    }
}
