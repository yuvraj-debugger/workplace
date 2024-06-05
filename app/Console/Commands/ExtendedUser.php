<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserJoiningDetail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;

class ExtendedUser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:user-extended';

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
        $hr_role = Role::where('name', 'HR')->first();
        $userJoining = UserJoiningDetail::where('status', '5')->get()->pluck('user_id');
        $users = User::where('user_role', '!=', '0')->whereIn('_id', $userJoining)
            ->where('status', '1')
            ->get();
        foreach ($users as $user) {
            $joiningDate = (date('Y-m-d ', strtotime('+ ' . $user->probation_period . 'months', strtotime($user->joining_date))));
            if (strtotime(date('Y-m-d')) == strtotime($joiningDate)) {
                $rm = User::where('_id', $user->reporting_manager)->first();
                UserJoiningDetail::Create([
                    'user_id' => $user->_id,
                    'probation_period' => $user->probation_period,
                    'confirmation_date' => '',
                    'notice_period' => '',
                    'other_terms' => '',
                    'notes' => '',
                    'confirmation_check' => '',
                    'status' => '0'
                ]);
                if (! empty($rm)) {
                    Mail::send('emails.rmconfirmationMail', [
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'joining_date' => $user->joining_date
                    ], function ($user) use ($rm) {
                        $user->to($rm->email);
                        $user->subject('Probation Confirmation');
                    });
                }
                $hrd = 'hrd@softuvo.in';
                Mail::send('emails.hrconfirmationMail', [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'joining_date' => $user->joining_date
                ], function ($user) use ($hrd) {
                    $user->to($hrd);
                    $user->subject('Probation Confirmation');
                });
            }
        }
        echo "Probation Mail Send Successfully";
    }
}
