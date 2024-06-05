<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class addProbation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-probation';

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
        $users = User::where('user_role','!=','0')->where('status','1')->get();
        foreach ($users as $user){
            $user->probation_period = '6';
            $user->update();
        }
        echo "Probation add successfully";
    }
}
