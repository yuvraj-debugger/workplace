<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MasterLeaves;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveAllocation as Allocation;

class LeaveAllocation extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:leave-allocation';

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
        $users = User::where('user_role', '!=', '0')->get();
        $leaveallocation = MasterLeaves::first();
        foreach ($users as $user) {
            $user_id = $user->_id;
            $workplace_id = $user->workplace;
            if ($workplace_id == 1) {
                Allocation::Create([
                    'user_id' => $user_id,
                    'workplace_id' => $workplace_id,
                    'casual_leave' => 0,
                    'sick_leave' => 0,
                    'bereavement_leave' => $leaveallocation->office_bereavement_leave,
                    'loss_of_pay_leave' => 0,
                    'maternity_leave' => $leaveallocation->office_maternity_leave,
                    'paternity_leave' => $leaveallocation->office_paternity_leave,
                    'earned_leave' => $leaveallocation->office_earned_leave,
                    'months' => $leaveallocation->office_materirty_paternity_months,
                    'earned_months' => $leaveallocation->office_earned_leave_months,
                    'emergency_leave' => 3,
                    'type' => 1,
                    'status' => 1,
                    'year' => (date('n')>=4) ? (date('Y').'-'.(date('Y')+1)) : (date('Y')-1).'-'.date('Y'),
                    'date' => strtotime(date('Y-m-d'))
                ]);
            } else {
                Allocation::Create([
                    'user_id' => $user_id,
                    'workplace_id' => $workplace_id,
                    'casual_leave' => 0,
                    'sick_leave' => 0,
                    'bereavement_leave' => $leaveallocation->home_bereavement_leave,
                    'loss_of_pay_leave' => $leaveallocation->home_loss_of_pay_leave,
                    'maternity_leave' => $leaveallocation->home_maternity_leave,
                    'paternity_leave' => $leaveallocation->home_paternity_leave,
                    'earned_leave' => $leaveallocation->home_earned_leave,
                    'months' => $leaveallocation->home_materirty_paternity_months,
                    'earned_months' => $leaveallocation->home_earned_leave_months,
                    'emergency_leave' => 3,
                    'type' => 1,
                    'status' => 1,
                    'year' => (date('n')>=4) ? (date('Y').'-'.(date('Y')+1)) : (date('Y')-1).'-'.date('Y'),
                    'date' => strtotime(date('Y-m-d'))
                ]);
            }
            echo "Leave allocated successfully";
        }

       
    }
}
