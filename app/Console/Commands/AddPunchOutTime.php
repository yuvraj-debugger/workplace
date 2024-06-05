<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserAttendance;
use App\Models\UserAttendanceDetail;

class AddPunchOutTime extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:add-punch-out';

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
        $midnight = strtotime(date('Y-m-d 23:59:00'));
            UserAttendance::where('punch_out', '')->where('date','<=',strtotime(date('Y-m-d')))->update([
                'punch_out' => $midnight
            ]);
            UserAttendanceDetail::where('punch_out', '')->where('date', '<=',strtotime(date('Y-m-d')))->update([
                'punch_out' => $midnight
            ]);
        return Command::SUCCESS;
    }
}
