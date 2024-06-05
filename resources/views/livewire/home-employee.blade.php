<?php
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
?>
<div>

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="setting">
                <div class="dashboardSection">
                <?php if($employeeBirthday){?>
                    <div class="animateusergreeting">
                	<div class="text-center"><h3 class="animate-charcter"> HAPPY BIRTHDAY !</h3></div>

                    </div>
                	<?php }elseif ($employeeWorkAnniversary){?>
                	
                    <div class="animateusergreeting">
                	<div class="text-center"><h3 class="animate-charcter"> HAPPY WORK ANNIVERSARY !</h3></div>

                    </div>
                	<?php }?>
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Button trigger modal -->
                           
                            <div class="dashboardSection__body mb-3">
                                <div class="cardHeading">
                                    <h4>Timesheet</h4>
                                     <a href="{{route('admin.attendanceActivity')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                                <div class="punchSection">
                                    @if(!empty($this->attendances->punch_in))
                                        <div class="punchImg">
                                            <img src="{{ asset('/images/punch.svg')}}" />
                                        </div>
                                        <div class="punchTime">
                                            <p>Punch In at <br /> <span class="green">{{!empty(@$this->attendances->punch_in)?date('D, jS M Y h.i A',$this->attendances->punch_in):''}}</span></p>            
                                        </div>
                                    @endif
                                      @if($this->attendanceStatus != '1')
                                             @if(!empty($this->attendances->punch_out))
                                            <div class="punchImg">
                                                <img src="{{ asset('/images/punchout.svg')}}" />
                                            </div>
                                            <div class="punchTime">
                                                <p>Punch Out at <br /> <span class="red" style="color:red;">{{!empty($this->attendances)?date('D, jS M Y h.i A',$this->attendances->punch_out):''}}</span></p>            
                                            </div>
                                        @endif
                                        @endif
                                </div>
                                <div class="punchTimer">
                                    <div class="timeWrapper">
                                        <div class="timeWrapper__circle pulse" >
                                            <div class="clock"></div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <p class="red">Punch Out</p>
                                        <input class="form-check-input" wire:model="attendanceStatus" type="checkbox" name="attendanceStatus" data-status="{{$attendanceStatus}}" role="switch" value="1" id="flexSwitchCheckDefault" wire:change="mark()">
                                        <p class="green">Punch In</p>
                                    </div>
                                    <div class="extraTime mb-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6 class="break">Break</h6>
                                                <h5>{{!empty(@$this->attendances)?$this->attendances->breakTime():'00:00'}} hrs</h5>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="overTime">Overtime</h6>
                                                <h5>{{$todaytotalovertime}} hrs</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                                <div wire:ignore.self class="modal fade statisticsModal" id="statistics" tabindex="-1" aria-bs-labelledby="exampleModalToggleLabel" aria-bs-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Statistics</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h4>Statistics</h4>
                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="attendanceCard">
                                                            <p>Today</p>
                                                            @if($todaytotalsecs > 8*60*60)
                                                                @php $todaytotalsecs = 8*60*60; $todaytotal = '08:00'; @endphp

                                                            @else

                                                            @endif
                                                            <p class="orange progressText">{{$todaytotal}} / 8 hrs</p>

                                                            <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-warning" style="width: {{($todaytotalsecs/(8*60*60))*100}}%"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="attendanceCard">
                                                            <p>This Week</p>
                                                            <p class="blue progressText">{{$weeklytotal}} / {{$totalWeeklyhrs}} hrs</p>
                                                            <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                @if($totalWeeklyhrs > 0)
                                                                    <div class="progress-bar bg-primary" style="width:{{($weeklytotalsecs/($totalWeeklyhrs*60*60))*100}}%"></div>
                                                                @else
                                                                    <div class="progress-bar bg-primary" style="width:0%"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="attendanceCard">
                                                            <p>This Month</p>
                                                            <p class="green progressText">{{$monthlytotal}} / {{$totalMonthlyhrs}} hrs</p>
                                                            <div data-secs = {{$monthlytotalsecs}} data-msec="{{$totalMonthlyhrs*60*60}}" class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                @if((int)$totalMonthlyhrs > 0)
                                                                    <div class="progress-bar bg-success" style="width: {{((int)$monthlytotalsecs/((int)$totalMonthlyhrs*60*60))*100}}%"></div>
                                                                @else
                                                                    <div class="progress-bar bg-success" style="width: 0%"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="attendanceCard">
                                                            <p>Remaining</p>
                                                            @if($todaytotalovertimesecs > 0)
                                                                @php $todayremainingtotal = '00:00'; $todayremainingtotalsecs = 0; @endphp

                                                            @endif
                                                            <p class="red progressText">{{$todayremainingtotal}} / 8 hrs</p>
                                                            <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar bg-danger" style="width: {{($todayremainingtotalsecs/(8*60*60))*100}}%"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="attendanceCard">
                                                            <p>Overtime</p>
                                                            <p class="grey progressText">{{$monthlytotalovertime}} hrs</p>
                                                            <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                                @if((int)$totalMonthlyhrs > 0)

                                                                @else 
                                                                <div class="progress-bar bg-grey" style="width: 0%"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary modalcanceleffect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-3">
                            
                            <div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h4>Upcoming Holidays</h4>
                                    <a href="/holidays"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                                 @if(! empty($holidays)&& count($holidays)>0)
                                <table class="table">
                                    @foreach ($holidays as $upcomingHoliday)
                                        <tr>
                                            <td><b>{{date('d M, Y',strtotime($upcomingHoliday->date))}}</b></td>
                                            <td class="text-end">{{$upcomingHoliday->title}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                @else
                                    <div class="noData">
                                    <!-- <img src="{{asset ('images/Checklist-vector.svg')}}" width="100px" height="200px"/> -->
                                    <img src="{{asset ('images/upcomingholidays.svg')}}" width="100px" height="200px"/>

                                    <p><b>Uh oh!</b> No holidays to show.</p>
						        </div>
						        @endif
                            </div>
                        </div>
                        
                           <div class="col-lg-3">
                            <div class="profileCard commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h3>Track Leave</h3>
                                    <a href="{{route('myleaves')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                                <div class="table-responsive">
                                   @if(! empty($leave)&& count($leave)>0)
                                    <table class="table">
                                    <tr>
                                         <th>Name</th>
                                         <th>From</th>
                                         <th>To</th>
                                     </tr>
                                   
                                        @foreach ($leave as $upcoming_leave)
                                           
                                            <tr>
                                                 <td><b>{{$upcoming_leave->getleaveemployee_name()->first_name.' '.$upcoming_leave->getleaveemployee_name()->last_name}}</b></td>
                                                 <td>{{date('d M, Y',($upcoming_leave->str_from_date))}}</td>
                                                 <td>{{date('d M, Y',($upcoming_leave->str_to_date))}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                   @else
                                    <div class="noData">
                                        <img src="{{asset ('images/Checklist-vector.svg')}}" width="100px" height="200px"/>
                                        <p><b>Hurrah!</b> You've nothing new to track.</p>
    						        </div>
                                @endif
                                </div>
                            </div>
                        </div>
<!--                          <div class="col-lg-3"> -->
<!--                             <div class="profileCard commonBoxShadow rounded-1 holidayCard"> -->
<!--                                 <div class="cardHeading"> -->
<!--                                     <h3>Apply Leave</h3> -->
<!--                                     <a href="/leaves"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a> -->
<!--                                 </div> -->
<!--                                <table class="table"> -->
<!--                                  <tr> -->
<!--                                      <th>Name</th> -->
<!--                                      <th>From</th> -->
<!--                                      <th>To</th> -->
<!--                                      <th>Type</th> -->
<!--                                  </tr> -->
                                 
<!--                                   @foreach ($leave as $upcoming_leave) -->
<!--                                   <tr> -->
<!--                                  <td><b>{{$upcoming_leave->getleaveemployee_name()->first_name.' '.$upcoming_leave->getleaveemployee_name()->last_name}}</b></td> -->
<!--                                  <td>{{$upcoming_leave->from_date}}</td> -->
<!--                                  <td>{{$upcoming_leave->to_date}}</td> -->
<!--                                  <td> -->
                                 
<!-- //                                  if($upcoming_leave->leave_type == "1"){ -->
<!-- //                                      echo "Casual Leave"; -->
<!-- //                                  }elseif ($upcoming_leave->leave_type == "2"){ -->
<!-- //                                      echo "Sick Leave"; -->
<!-- //                                  }elseif ($upcoming_leave->leave_type == "3"){ -->
<!-- //                                      echo "Earned Leave"; -->
<!-- //                                  }else{ -->
<!-- //                                      echo "Loss Of Pay"; -->
<!-- //                                  } -->
<!--                                  </td></tr> -->
<!--                                  @endforeach -->
                                 
                                  	
<!--                                 </table> -->
<!--                             </div> -->
<!--                         </div> -->
                        
<!--                          <div class="col-lg-3"> -->
<!--                             <div class="profileCard commonBoxShadow rounded-1 holidayCard"> -->
<!--                                 <div class="cardHeading"> -->
<!--                                     <h3>Apply Leave</h3> -->
<!--                                     <a href="/leaves"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a> -->
<!--                                 </div> -->
<!--                             </div> -->
<!--                         </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Page wrapper end -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>

<script>
<?php if($employeeBirthday || $employeeWorkAnniversary){?>
const duration = 15 * 1000,
  animationEnd = Date.now() + duration,
  defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

function randomInRange(min, max) {
  return Math.random() * (max - min) + min;
}

const interval = setInterval(function() {
  const timeLeft = animationEnd - Date.now();

  if (timeLeft <= 0) {
    return clearInterval(interval);
  }

  const particleCount = 50 * (timeLeft / duration);
  confetti(
    Object.assign({}, defaults, {
      particleCount,
      origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
    })
  );
  confetti(
    Object.assign({}, defaults, {
      particleCount,
      origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
    })
  );
}, 250);
<?php }?>

    setTimeout(function() {
    	$('.animateusergreeting').hide();
     }, 15 * 1000);
    

</script>
<script>
    $(document).ready(function () {
        $('.month').select2({
            tags: false,
            multiple: false
        }).on('change', function (e){
            @this.set('month', $(this).val());
            var y = $('.year').val();
            var m = $(this).val();
            var d = new Date(y, m, 0).getDate();
            var lastDay = new Date(y, m + 1, 0);
            $("#datePickerFilter").datepicker('remove'); //detach
            $('#datePickerFilter').datepicker({
                autoclose: true, 
                dateFormat: 'dd-mm-yy',
                startDate: new Date(y+'-'+m+'-01'),
                endDate: new Date(y+'-'+m+'-'+d),
                onSelect: function(taskduedate) {
                    @this.set('dateFilter', taskduedate);
                }
            });
        }); 
        
        $('.year').select2({
            tags: false,
            multiple: false
        }).on('change', function (e) {
           @this.set('year', $(this).val());
            var y = $(this).val();
            var m = @this.month;
            var d = new Date(y, m, 0).getDate();
            var lastDay = new Date(y, m + 1, 0);
            $("#datePickerFilter").datepicker('remove'); //detach
            $('#datePickerFilter').datepicker({
                autoclose: true, 
                dateFormat: 'dd-mm-yy',
                startDate: new Date(y+'-'+m+'-01'),
                endDate: new Date(y+'-'+m+'-'+d),
                onSelect: function(taskduedate) {
                    @this.set('dateFilter', taskduedate);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        var year = $('.year').val();
        var month = @this.month;
        var d = new Date(year, month, 0).getDate();
        var lastDay = new Date(year, month + 1, 0);
        console.log('year==='+year);
        console.log('month==='+month);
        console.log('month==='+d);
        $('#datePickerFilter').datepicker({
            autoclose: true, 
            dateFormat: 'dd-mm-yy',
           
        }).on("changeDate", function (e) {
                console.log('date');
                @this.set('dateFilter', $(this).val());
            
        });
    });

</script>

<script>
let myVar = setInterval(myTimer ,1000);
function myTimer() {
  const d = new Date();
  $('.clock').html(d.toLocaleTimeString('en-US',{ hour12: false }));
}
</script>