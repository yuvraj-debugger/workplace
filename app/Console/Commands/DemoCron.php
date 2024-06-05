<?php
  
namespace App\Console\Commands;
  
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\UserAttendance;
use App\Models\UserAttendanceDetail;
  
class DemoCron extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    
    protected $signature = 'demo:cron';
    
    /**
     * The console command description.
     *
     * @var string
     */
    
    protected $description = 'Command description';
  
    /**
     * Create a new command instance.
     *
     * @return void
     */
    
    public function __construct(){
        parent::__construct();
    }
  
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        info("Cron Job running at ". now());
        $today = date('Y-m-d', strtotime('now'));

        $attendances = UserAttendance::where('date', strtotime($today))->get();
        foreach($attendances as $attendance){
            if($attendance['punch_out'] == ''){
               $detail = UserAttendanceDetail::where('attendance_id', $attendance['_id'])->where('punch_out', '')->first();

               UserAttendanceDetail::where('_id', $detail['_id'])->update([
                    'punch_out' => strtotime('now')
               ]);
               UserAttendance::where('_id', $attendance['_id'])->update(['punch_out' => strtotime('now')]);
            }
        }
        return 'success';
  
     
    }
}