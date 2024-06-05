<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DefaultShiftAssign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-default-shift';

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
       $users = User::where('user_role','!=','0')->where('shift_id','')->get();
       foreach ($users as $user){
           $user->shift_id = "659e2333ef274a01b40cd9df";
           $user->update();
       }
       echo "Add Default Shifting";
    }
}
