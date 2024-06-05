<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Schedule;

class ScheduleShiftJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
            $date=$this->data['from_date'];
            while($date<=$this->data['to_date']){    
                Schedule::create([
                'department_id' => $this->data['department_id'],
                'employee_id' => $this->data['employee_id'],
                'date'=>$date,
                'shifts_id' => $this->data['shifts_id'],
                'min_start_time' => $this->data['min_start_time'],
                'start_time' => $this->data['start_time'],
                'max_start_time' => $this->data['max_start_time'],
                'end_time' => $this->data['end_time'],
                'max_end_time' => $this->data['max_end_time'],
                'break_time' => $this->data['break_time'],
                'status' => $this->data['status'],
                'type' => $this->data['type'],
                'created_by' =>$this->data['created_by']
            ]);
                $date=date('Y-m-d',strtotime($this->data['from_date'].' +1 day'));
        }
    }
}
