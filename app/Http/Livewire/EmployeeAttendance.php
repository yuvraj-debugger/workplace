<?php

namespace App\Http\Livewire;

use Carbon\Carbon;

use Livewire\Component;
use App\Models\UserAttendance;
use App\Models\Holiday;
use App\Models\UserAttendanceDetail;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Livewire\WithPagination;


class EmployeeAttendance extends Component
{
    use WithPagination;
    
    public $emp_id, $user_id, $monthlytotal, $todaytotal, $weeklytotal, $totalMonthlyhrs, $totalWeeklyhrs, $todayremainingtotal,$todaytotalsecs,$weeklytotalsecs,$monthlytotalsecs,$todayremainingtotalsecs, $month, $year, $todaytotalbreak, $todaytotalovertime, $todaytotalovertimesecs, $monthlytotalovertime, $monthlytotalovertimesecs, $dateFilter;

    public $attendances = [];

    public $punch_in, $punch_out, $date, $total_hrs, $attendanceStatus = '';
    
    public function mount(){
        $this->emp_id = $this->emp_id == ''?FacadesAuth::user()->_id:$this->emp_id;
        $this->user_id = $this->emp_id;
        $this->month = date('m');
        $this->year = date('Y');
        $this->date = '';
        
        $startDate = date('Y-m-d 00:00:00',strtotime('now'));
        $endDate = date('Y-m-d 23:59:59',strtotime('now'));
        $today = date('Y-m-d', strtotime('now'));
        $attendance = UserAttendance::where(['user_id' => $this->user_id])->whereBetween('date', [strtotime($startDate), strtotime($endDate)])->first();
        if(!empty($attendance)){
            $attendanceDetails = UserAttendanceDetail::where('attendance_id', $attendance['_id'])->orderBy('_id', 'desc')->first();
            
            if(!empty($attendanceDetails)){
                if(@$attendanceDetails['punch_out'] != ''){
                    $this->attendanceStatus = '';
                }else{
                    $this->attendanceStatus = '1';
                }
            }else{
                $this->attendanceStatus = '';
            }
        }
        $sMonth = new Carbon('first day of this month');
        $weekStart = date('Y-m-d', strtotime("this week"));
        $weekEnd   = date('Y-m-d', strtotime('+6 days', strtotime($weekStart)));

        $monthStart = date('Y-m-d', strtotime($sMonth));
        $monthEnd = date('Y-m-t', strtotime($sMonth));
        $maxDays=date('t');
        $totalMonthlyHolidays = Holiday::whereBetween('date', [strtotime($monthStart), strtotime($monthEnd)])->count();     
        $totalWeeklyHolidays = Holiday::whereBetween('date', [strtotime($weekStart), strtotime($weekEnd)])->count();
        $totalMonthDays = (int)$maxDays-(int)$totalMonthlyHolidays;
        $totalWeekDays = 7-(int)$totalWeeklyHolidays;
        $this->totalMonthlyhrs = $totalMonthDays*8;
        $this->totalWeeklyhrs = $totalWeekDays*8;
      
        $this->attendances = UserAttendance::with('details')->where(['user_id' => $this->user_id, 'date' => strtotime($today)])->first();
       
        $monthlyAttendances = UserAttendance::with('details')->where(['user_id' => $this->user_id])->whereBetween('date', [strtotime($monthStart), strtotime($today)])->get()->toArray();
        $monthlyhrs =0;
        $monthlymins =0;  
        $weeklyhrs =0;
        $weeklymins =0;
        $todayhrs =0;
        $todaymins =0;
        $totalbhrs = 0;
        $totalbmins = 0;
        $totalbsecs = 0;
        $extrahrs = 0;
        $extramins = 0;
        
        foreach($monthlyAttendances as $attendanceData){
            foreach($attendanceData['details'] as $k => $attdanceData){
                if(($attdanceData['punch_in'] != '' && $attdanceData['punch_out'] != '') || ($attendanceData['date'] == strtotime($today) && $this->attendanceStatus == '1')){
                    $time1 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_in']));
                    if($attendanceData['date'] == strtotime($today) && $attendanceData['punch_out'] == ''){
                         $time2 = new \DateTime(date('Y-m-d H:i', strtotime('now')));
                    }else{
                        $time2 = new \DateTime(date('Y-m-d H:i', (int)$attdanceData['punch_out']));
                    }      
                    $diff = $time1->diff($time2);
                    $h = $diff->h;
                    $i = $diff->i;
                    $s = $diff->s;
                    $monthlyhrs+=$h;
                    $monthlymins+=$i;
                    if($attendanceData['date'] >= strtotime($weekStart) && $attendanceData['date'] <= strtotime($today)){
                        $weeklyhrs+=$h;
                        $weeklymins+=$i;
                    }

                    if($attendanceData['date'] == strtotime($today)){
                        $todayhrs+=$h;
                        $todaymins+=$i;  
                        if(@$attdanceData[$k+1]['punch_in'] != ''){
                            $btime1 = new \DateTime(date('Y-m-d H:i', $attdanceData[$k+1]['punch_in']));
                            $btime2 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_out']));
                            $bdiff = $btime1->diff($btime2);
                            $totalbhrs+=$bdiff->h;
                            $totalbmins+=$bdiff->i;
                            $totalbsecs+=$bdiff->s;

                            $totalArray[] = $bdiff->i;                    
                        }    
                    }
                } 
            }
        }
        
        $todayremaininghrs = 8-$todayhrs;
        $todayremainingmins = 60-$todaymins;
        
        $this->weeklytotal = date('H:i', mktime($weeklyhrs, $weeklymins));
        $this->monthlytotal = date('H:i', mktime($monthlyhrs, $monthlymins));
        $this->todaytotal = date('H:i', mktime($todayhrs, $todaymins));
        $this->todaytotalsecs = ($todayhrs*60*60)+($todaymins*60);
        
        if($this->todaytotalsecs > 28800){
            $otime1 = new \DateTime(date('H:i', strtotime($this->todaytotal)));
            $otime2 = new \DateTime(date('H:i', strtotime('08:00')));
            $odiff = $otime1->diff($otime2);
            $this->todaytotalovertime = date('H:i', mktime($odiff->h, ($odiff->i)));

        }else{
            $this->todaytotalovertime = '00:00';
        }
        
        $this->todaytotalbreak = date('H:i', mktime($totalbhrs, ($totalbmins)));
        $this->weeklytotalsecs = ($weeklyhrs*60*60)+($weeklymins*60);
        $this->monthlytotalsecs = ($monthlyhrs*60*60)+($monthlymins*60);
        
        $t1 = new \DateTime(date('H:i', strtotime($this->todaytotal)));
        $t2 = new \DateTime(date('H:i', strtotime('08:00')));
        $d = $t1->diff($t2);

        $this->todayremainingtotal = date('H:i', mktime($d->h, $d->i));
        $this->todayremainingtotalsecs = ($d->h*60*60)+($d->i*60);
    }
    
    public function render(){
        $today = date('Y-m-d', strtotime('now'));

        $sMonth = new Carbon('first day of this month');
        $weekStart = date('Y-m-d', strtotime("this week"));
        $weekEnd   = date('Y-m-d', strtotime('+6 days', strtotime($weekStart)));

        $monthStart = date('Y-m-d', strtotime($sMonth));
        $monthEnd = date('Y-m-t', strtotime($sMonth));
        $maxDays=date('t');
        $totalMonthlyHolidays = Holiday::whereBetween('date', [strtotime($monthStart), strtotime($monthEnd)])->count();     
        $totalWeeklyHolidays = Holiday::whereBetween('date', [strtotime($weekStart), strtotime($weekEnd)])->count();
        $totalMonthDays = (int)$maxDays-(int)$totalMonthlyHolidays;
        $totalWeekDays = 7-(int)$totalWeeklyHolidays;
        $this->totalMonthlyhrs = $totalMonthDays*8;
        $this->totalWeeklyhrs = $totalWeekDays*8;
      
        $this->attendances = UserAttendance::with('details')->where(['user_id' => $this->user_id, 'date' => strtotime($today)])->first();
       
        $monthlyAttendances = UserAttendance::with('details')->where(['user_id' => $this->user_id])->whereBetween('date', [strtotime($monthStart), strtotime($today)])->get()->toArray();

        $monthlyhrs = 0;
        $monthlymins = 0;  
        $weeklyhrs = 0;
        $weeklymins = 0;
        $todayhrs = 0;
        $todaymins = 0;
        $totalbhrs = 0;
        $totalbmins = 0;
        $totalbsecs = 0;
        $extrahrs = 0;
        $extramins = 0;
        
        foreach($monthlyAttendances as $attendanceData){
            foreach($attendanceData['details'] as $k => $attdanceData){
                if(($attdanceData['punch_in'] != '' && $attdanceData['punch_out'] != '') || ($attendanceData['date'] == strtotime($today) && $this->attendanceStatus == '1')){
                    $time1 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_in']));
                    if($attendanceData['date'] == strtotime($today) && $attdanceData['punch_out'] == ''){
                        $time2 = new \DateTime(date('Y-m-d H:i', strtotime('now')));
                    }else{
                        $time2 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_out']));
                    }
                    $diff = $time1->diff($time2);
                    $h = $diff->h;
                    $i = $diff->i;
                    $s = $diff->s;
                    $monthlyhrs+=$h;
                    $monthlymins+=$i;
                    if($attendanceData['date'] >= strtotime($weekStart) && $attendanceData['date'] <= strtotime($today)){
                        $weeklyhrs+=$h;
                        $weeklymins+=$i;
                    }
                    if($attendanceData['date'] == strtotime($today)){
                        $todayhrs+=$h;
                        $todaymins+=$i;  
                        if(@$attdanceData[$k+1]['punch_in'] != ''){
                            $btime1 = new \DateTime(date('Y-m-d H:i', $attdanceData[$k+1]['punch_in']));
                            $btime2 = new \DateTime(date('Y-m-d H:i', $attdanceData['punch_out']));
                            $bdiff = $btime1->diff($btime2);
                            $totalbhrs+=$bdiff->h;
                            $totalbmins+=$bdiff->i;
                            $totalbsecs+=$bdiff->s;
                            $totalArray[] = $bdiff->i;
                        }       
                    }
                } 
            }
        }
        $todayremaininghrs = 8-$todayhrs;
        $todayremainingmins = 60-$todaymins;
        
        $this->weeklytotal = date('H:i', mktime($weeklyhrs, $weeklymins));
        $this->monthlytotal = date('H:i', mktime($monthlyhrs, $monthlymins));
        $this->todaytotal = date('H:i', mktime($todayhrs, $todaymins));
        $this->todaytotalsecs = ($todayhrs*60*60)+($todaymins*60);
        $monthlytotalsecs = ($monthlyhrs*60*60)+($monthlymins*60);
        $totalmonthlySecs = $this->totalMonthlyhrs*60*60;
        if($monthlytotalsecs > $totalmonthlySecs){
            $secs = $monthlytotalsecs - $totalmonthlySecs;
            
            $this->monthlytotalovertime = gmdate("H:i", $secs);
            $this->monthlytotalovertimesecs = $secs;
        }else{
            $this->monthlytotalovertime = '00:00';
            $this->monthlytotalovertimesecs = '0';
        }
        
        $todaySecs = 8*60*60;
        if($this->todaytotalsecs > $todaySecs){
            $secs = $this->todaytotalsecs - $todaySecs;
            
            $this->todaytotalovertime = gmdate("H:i", $secs);
            $this->todaytotalovertimesecs = $secs;
        }else{
            $this->todaytotalovertime = '00:00';
            $this->todaytotalovertimesecs = '0';
        }

        $this->todaytotalbreak = date('H:i', mktime($totalbhrs, ($totalbmins)));
        $this->weeklytotalsecs = ($weeklyhrs*60*60)+($weeklymins*60);
        $this->monthlytotalsecs = ($monthlyhrs*60*60)+($monthlymins*60);
        
        $t1 = new \DateTime(date('H:i', strtotime($this->todaytotal)));
        $t2 = new \DateTime(date('H:i', strtotime('08:00')));
        $d = $t1->diff($t2);
        
        $this->todayremainingtotal = date('H:i', mktime($d->h, $d->i));
        $this->todayremainingtotalsecs = ($d->h*60*60)+($d->i*60);
        
        $query = UserAttendance::with('details')->where(['user_id' => $this->user_id]);
        if($this->dateFilter != ''){
            $startDate = date('Y-m-d 00:00:00',strtotime($this->dateFilter));
            $endDate = date('Y-m-d 23:59:59',strtotime($this->dateFilter));
            $query= $query->whereBetween('date',[strtotime($startDate), strtotime($endDate)]); 
        }
        
        if($this->month != '' && $this->year != '' ){
            $firstdate = $this->year.'-'.$this->month.'-'.'01';
            $fDate = strtotime($firstdate);
            $last_date = date("Y-m-t", $fDate);
            $lDate = strtotime($last_date);
            $query = $query->whereBetween('date', [$fDate, $lDate]);  
        }
        
        $allAttendances = $query->paginate(10);
        return view('livewire.employee-attendance',compact('allAttendances'));
    }

    public function mark(){
        $today = date('Y-m-d', strtotime('now'));
        $status = $this->attendanceStatus == '1'?'in':'out';

        if($status == 'out'){
            $attendance = UserAttendance::where(['user_id' => $this->user_id, 'date' => strtotime($today)])->first();
            if(empty($attendance)){
                $attendance = UserAttendance::where(['user_id' => $this->user_id])->orderBy('_id', 'desc')->first();
                $attendancedetail = UserAttendanceDetail::where('attendance_id', $attendance['_id'])->where('punch_in', '!=', '')->where('punch_out', '')->first();
                UserAttendanceDetail::where('_id', $attendancedetail['_id'])->update([
                    'punch_out' => $attendancedetail['punch_in']]);
                UserAttendance::where('_id', $attendance['_id'])->update(['punch_out'=> $attendancedetail['punch_in']]);
            }else{
                $attendancedetail = UserAttendanceDetail::where('attendance_id', $attendance['_id'])->where('punch_in', '!=', '')->where('punch_out', '')->first();

                UserAttendanceDetail::where('_id', $attendancedetail['_id'])->update([
                    'punch_out' => strtotime('now')]);
                UserAttendance::where('_id', $attendance['_id'])->update(['punch_out'=> strtotime('now')]);
            }
        }else{
            $attendance = UserAttendance::where(['user_id' => $this->user_id, 'date'=> strtotime($today)])->first();
            if(!empty($attendance)){
                UserAttendanceDetail::create([
                    'attendance_id' => $attendance['_id'],
                    'punch_in' => strtotime('now'),
                    'punch_out' => '',
                    'total_hrs' => '',
                    'date' => strtotime($today)
                ]); 
            }else{
                $attendance = UserAttendance::create([
                    'user_id' => $this->user_id,
                    'punch_in' => strtotime('now'),
                    'punch_out' => '',
                    'total_hrs' => '',
                    'date' => strtotime($today)
                   ]);  
                UserAttendanceDetail::create([
                    'attendance_id' => $attendance['_id'],
                    'punch_in' => strtotime('now'),
                    'punch_out' => '',
                    'total_hrs' => ''
                ]); 
            }
          
        }
        $this->attendanceStatus;
    }

     /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertSuccess($msg)
    {
        $this->dispatchBrowserEvent('alert',['type' => 'success',  'message' => $msg]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertError($msg)
    {
        $this->dispatchBrowserEvent('alert',['type' => 'error',  'message' => $msg]);
    }
       /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($msg)
    {
        $this->dispatchBrowserEvent('alert',['type' => 'info',  'message' => $msg]);
    }
}
