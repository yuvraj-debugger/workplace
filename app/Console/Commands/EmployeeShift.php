<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduleLogs;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class EmployeeShift extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:employee-shift';

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
        $scheduleLog = ScheduleLogs::where('status', 0)->first();
        $fromDate = date('Y-m-d', $scheduleLog->content['from_date']);
        $toDate = date('Y-m-d', $scheduleLog->content['to_date']);
        while (strtotime($fromDate) <= strtotime($toDate)) {
            $updatedSchedule = Schedule::where('employee_id', $scheduleLog->content['employee_id'])->where('date', strtotime($fromDate))->first();
            if (! empty($updatedSchedule)) {
                $schedule = Schedule::where('employee_id', $scheduleLog->content['employee_id'])->where('date', strtotime($fromDate))->update([
                    'department_id' => $scheduleLog->content['department_id'],
                    'employee_id' => $scheduleLog->content['employee_id'],
                    'date' => strtotime($fromDate),
                    'shifts_id' => $scheduleLog->content['shifts_id'],
                    'min_start_time' => $scheduleLog->content['min_start_time'],
                    'start_time' => $scheduleLog->content['start_time'],
                    'max_start_time' => $scheduleLog->content['max_start_time'],
                    'min_start_time' => $scheduleLog->content['min_start_time'],
                    'end_time' => $scheduleLog->content['end_time'],
                    'max_end_time' => $scheduleLog->content['max_end_time'],
                    'break_time' => $scheduleLog->content['break_time'],
                    'status' => 0,
                    'type' => 0,
                    'created_by' => $scheduleLog->content['created_by']
                ]);
            } else {

                $schedule = Schedule::Create([
                    'department_id' => $scheduleLog->content['department_id'],
                    'employee_id' => $scheduleLog->content['employee_id'],
                    'date' => strtotime($fromDate),
                    'shifts_id' => $scheduleLog->content['shifts_id'],
                    'min_start_time' => $scheduleLog->content['min_start_time'],
                    'start_time' => $scheduleLog->content['start_time'],
                    'max_start_time' => $scheduleLog->content['max_start_time'],
                    'min_start_time' => $scheduleLog->content['min_start_time'],
                    'end_time' => $scheduleLog->content['end_time'],
                    'max_end_time' => $scheduleLog->content['max_end_time'],
                    'break_time' => $scheduleLog->content['break_time'],
                    'status' => 0,
                    'type' => 0,
                    'created_by' => $scheduleLog->content['created_by']
                ]);
            }
            $fromDate = date('Y-m-d', strtotime($fromDate . ' + 1 day'));
        }
        $scheduleLog->status = 1;
        $scheduleLog->update();
    }
}
