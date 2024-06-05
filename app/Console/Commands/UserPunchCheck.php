<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserAttendance;
use App\Models\Notification;

class UserPunchCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:user-punchin-check';

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
       
        $userAttendance = UserAttendance::where('date',strtotime(date('Y-m-d')))->get()->pluck('user_id')->toArray();
        $users = User::where('user_role','!=','0')->where('status','1')->whereNotIn('_id',$userAttendance)->get();
        foreach ($users as $user){
            Notification::create([
                'type' => get_class($user),
                'data' => 'Absent',
                'notifiable' => '',
                'read_at' => '',
                'status' => 1,
                'created_by' => $user->_id
            ]);
            echo 'All user saved successfully';
        }
        
    }
}
