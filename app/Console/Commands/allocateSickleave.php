<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MasterLeaves;
use App\Models\UserJoiningDetail;
use App\Models\LeaveAllocation;

class allocateSickleave extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:allocated-sick-leave';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userJoining = UserJoiningDetail::get()->pluck('user_id')->toArray();
        
        $users = User::where('user_role', '!=', '0')->whereNotIn('_id', $userJoining)
            ->where('status', '1')
            ->get();
            
        foreach ($users as $user) {
            if (strtotime(date('Y-m-d')) == strtotime((date('Y-m-d ', strtotime('+ 3 months', strtotime($user->joining_date)))))) {
                 
                $masterLeave = MasterLeaves::first();
                
                $months = date('j', strtotime(date('Y-m-d')));
                $joiningMonth = date('j',strtotime($user->joining_date));
                
                $month = $months - $joiningMonth;
                $casual=$masterLeave->casual/12;
                $sick=$masterLeave->sick_leave/12;
                
                
                $casual_leave=3*$casual;
                $sick_leave=(12-$joiningMonth)*$sick;
                if($month>0)
                {
                    $month=date('j', strtotime(date('Y-m-d')));
                    $casual_leave=$month*$casual;
                }
                
                $leaveAllocation = LeaveAllocation::updateOrCreate([
                    'user_id' => $user->_id,
                    'year'=>(date('n')>=4) ? (date('Y').'-'.(date('Y')+1)) : (date('Y')-1).'-'.date('Y')
                ], [
                    'user_id' => $user->_id,
                    'workplace_id' => $user->workplace,
                    'casual_leave' => $casual_leave,
                    'sick_leave' => $sick_leave,
                    'bereavement_leave' => $masterLeave->bereavement_leave,
                    'loss_of_pay_leave' => $masterLeave->loss_of_pay_leave,
                    'maternity_leave' => $masterLeave->maternity_leave,
                    'paternity_leave' => $masterLeave->paternity_leave,
                    'earned_leave' => $masterLeave->earned_leave,
                    'months' => $masterLeave->months,
                    'earned_months' => $masterLeave->earned_months,
                    'type' => '1',
                    'status' => '1',
                    'year' => date('Y'),
                    'date' => strtotime(date('Y-m-d'))
                ]);
                echo "Sick leave allocated successfully";
            }
           
        }
       
    }
}
