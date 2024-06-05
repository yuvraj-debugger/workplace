<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MasterLeaves;
use App\Models\User;
use App\Models\LeaveAllocation;

class SickLeave extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sick-leave';

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
        $master = MasterLeaves::first();
        $users = User::where('user_role', '!=', '0')->where('status','1')->get();
        foreach ($users as $user) {
            if(strtotime(date('Y-m-d')) >= strtotime((date('Y-m-d ', strtotime('+ 3 months', strtotime($user->joining_date)))))){
                $user_id = $user->_id;
                $workplace_id = $user->workplace;
                $leaveAllocation = LeaveAllocation::where('user_id', $user_id)->where('year', (date('n')>=4) ? (date('Y').'-'.(date('Y')+1)) : (date('Y')-1).'-'.date('Y'))->first();
                if ($workplace_id == '1') {
                    $leaveAllocation->sick_leave = $master->office_sick_leave;
                } else {
                    $leaveAllocation->sick_leave = $master->home_sick_leave;
                }
                $leaveAllocation->update();
                echo "Sick Leave updated successfully";
            }
        }
        
    }
}
