<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserJoiningDetail;
use Illuminate\Support\Facades\Auth;

class addConfirmation extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-confirmation';

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
        UserJoiningDetail::truncate();
        $users = User::where('user_role', '!=', '0')->get();
        foreach ($users as $user) {
            if (! empty($user->joining_date)) {
                $joiningDate = (date('Y-m-d ', strtotime('+ ' . $user->probation_period . 'months', strtotime($user->joining_date))));
                if (strtotime(date('Y-m-d')) >= strtotime($joiningDate)) {
                    UserJoiningDetail::Create([
                        'user_id' => $user->_id,
                        'probation_period' => $user->probation_period,
                        'confirmation_date' => strtotime($joiningDate),
                        'notice_period' => '',
                        'other_terms' => '',
                        'notes' => '',
                        'confirmation_check' => '',
                        'status' => '2',
                        'hr_confirmation_date' => strtotime($joiningDate),
                        'rm_confirmation_date' => strtotime($joiningDate),
                        'updated_rm' => User::where('user_role', '0')->first()->_id,
                        'updated_hr' => User::where('user_role', '0')->first()->_id,
                        'updated_by' => User::where('user_role', '0')->first()->_id
                    ]);
                }
            }
        }
    }
}
