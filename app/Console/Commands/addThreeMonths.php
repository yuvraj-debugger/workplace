<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class addThreeMonths extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-three-month';

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
        $allMail = [
            'sapna.koul@softuvo.in',
            'akash.bhatt@softuvo.in',
            'paras.bhanot@softuvo.in',
            'prince.kumar@softuvo.in',
            'shivani.saini@softuvo.in',
            'kamal.kishore@softuvo.in',
            'poonam.rana@softuvo.in',
            'anil.kumar@softuvo.in'
        ];
        $users = User::whereIn('email', $allMail)->get();
        foreach ($users as $user) {
            $user->update([
                'probation_period' => '3'
            ]);
        }
        echo "Updated 3 months";
    }
}
