<div>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-head-box">
                <h3>Attendance</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                    </ol>
                </nav>
            </div>
            <div class="setting">
                <div class="dashboardSection">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="dashboardSection__body">
                                <h4>Timesheet</h4>
                                <div class="punchSection">
                                    @if(!empty(@$this->attendances['details'][0]['punch_in']))
                                        <div class="punchImg">
                                            <img src="{{ asset('/images/punch.svg')}}" />
                                        </div>
                                        <div class="punchTime">
                                            <p>Punch In at <br /> <span class="green">{{!empty(@$this->attendances['details'][0]['punch_in'])?date('D, jS M Y h.i A',$this->attendances['details'][0]['punch_in']):''}}</span></p>            
                                        </div>
                                    @endif
                                </div>
                                <div class="punchTimer">
                                    <div class="timeWrapper">
                                        <div class="timeWrapper__circle pulse" wire:poll.750ms>
                                            <div class="clock">{{ date('H:i:s', strtotime('now')) }}</div>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <p class="red">Punch Out</p>
                                        <input class="form-check-input" wire:model="attendanceStatus" type="checkbox" name="attendanceStatus" data-status="{{$attendanceStatus}}" role="switch" value="1" id="flexSwitchCheckDefault" wire:change="mark()">
                                        <p class="green">Punch In</p>
                                    </div>
                                    <div class="extraTime">
                                        <div class="row">
                                            <div class="col-6">
                                                <h6>Break</h6>
                                                <h5>{{!empty(@$this->attendances)?$this->attendances->breakTime():'00:00'}} hrs</h5>
                                            </div>
                                            <div class="col-6">
                                                <h6>Overtime</h6>
                                                <h5>{{$todaytotalovertime}} hrs</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profileCard commonBoxShadow rounded-1 my-3">
                                
                                <h3>Attendance Information</h3>
                                <ul class="eduList">
                                    @if(isset($this->attendances['details']) && count($this->attendances['details'])> 0)
                                    @foreach($this->attendances['details'] as $att)
                                    <li class="mb-0">
                                        <p><b>Punch In at</b></p>
                                        <p class="grey"><i class="fa-solid fa-clock"></i> {{ date('h:i A',$att['punch_in'])}}</p>
                                        <!-- <p><b>Punch Out at</b></p>
                                        <p class="grey"><i class="fa-solid fa-clock"></i> {{ date('h:i A',(int)$att['punch_out'])}}</p> -->
                                    </li>
                                    @endforeach
                                    @else
                                    <p class="text-center">No Data To Display</p>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="dashboardSection__body">
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

                                                <div class="progress-bar bg-grey" style="width: {{((int)$monthlytotalovertimesecs/((int)$totalMonthlyhrs*60*60))*100}}%"></div>
                                                @else 
                                                <div class="progress-bar bg-grey" style="width: 0%"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="leftFilters employeeFilter">
                            <div class="form-floating" wire:ignore>
                                <input type="text" wire:model="dateFilter" class="form-control" id="datePickerFilter" placeholder="Date" autocomplete="off">
                                <!-- <select class="form-select date" id="floatingSelectDate" wire:model="date" aria-label="Floating label select example">
                                    @php $selected_month = date('m'); @endphp
                                    @for ($i_date = 01; $i_date <= 31; $i_date++)
                                    <option value="{{$i_date}}">{{sprintf('%02d',$i_date)}}</option>
                                    @endfor
                                </select> --> 
                                <label for="floatingInput">Date</label>
                            </div>
                            <div class="form-floating" wire:ignore>
                                <select class="form-select month" id="floatingSelectMonth" wire:model="month" aria-label="Floating label select example">
                                    @php $selected_month = date('m'); @endphp
                                    @for ($i_month = 01; $i_month <= 12; $i_month++)
                                    <option value="{{sprintf('%02d',$i_month)}}">{{date('F', mktime(0,0,0,$i_month))}}</option>
                                    @endfor

      
                                </select>
                                <label for="floatingSelect">Month</label>
                            </div>
                            <div class="form-floating" wire:ignore>
                                <select class="form-select year" id="floatingSelectyear" wire:model="year" aria-label="Floating label select example">
                                @php $selected_year = date('Y'); @endphp
                                @for ($i_year = $selected_year-5; $i_year <= $selected_year+1; $i_year++)
                                    <option value="{{$i_year}}" {{ $selected_year == $i_year ?'selected':''}}>{{$i_year}}</option>
                                @endfor
                                </select>
                                <label for="floatingSelect">Year</label>
                            </div>        
                            <!-- <button class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboardSection__body">
                <div class="commonDataTable">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Punch In</th>
                                    <th>Punch Out</th>
                                    <th>Production</th>
                                    <th>Break</th>
                                    <th>Others</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($allAttendances) || count($allAttendances) == 0)
                                <tr><td class="text-center" colspan="7">No Data Found</td></tr>
                                @else
                                @foreach($allAttendances as $k =>$allAttendance)

                                @php
                                    $hrs = '';
                                    $mins = '';
                                    if(@$allAttendance['details'][count($allAttendance['details'])-1]['punch_out'] != ''){
                                       
                                        $time1 = new \DateTime(date('Y-m-d H:i', (int)$allAttendance['details'][0]['punch_in']));
                                        $time2 = new \DateTime(date('Y-m-d H:i', $allAttendance['details'][count($allAttendance['details'])-1]['punch_out']));
                                        $diff = $time1->diff($time2);
                                        $hrs = $diff->h;
                                        $mins = $diff->i;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $allAttendances->firstItem()+$k }}</td>
                        
                                    <td>{{ date('d M Y', (int)@$allAttendance['date']) }}</td>
                                    
                                    <td> {{ date('h:i A', (int)@$allAttendance['details'][0]['punch_in']) }} </td>
                                    
                                    <td> {{ $hrs != '' && $mins != '' ?date('h:i A',(int)$allAttendance['details'][count($allAttendance['details'])-1]['punch_out']):'-' }}</td>
                                    
                                    <td>{{ $allAttendance->productionTime() }}</td>
                                    
                                    <td>{{$allAttendance->breakTime()}}</td>
                                    
                                    <td>0</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- common pagination starts -->
                {{ $allAttendances->links() }}
                <!-- <div class="commonPagination my-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="commonPagination__content justify-content-end">
                                <p>Showing <span>1 to 10</span> of <span>16 entries</span></p>
                                <div class="paginationButton">
                                    <a href="javascript:void(0);">Previous</a>
                                    <a href="javascript:void(0);">1</a>
                                    <a href="javascript:void(0);">2</a>
                                    <a href="javascript:void(0);">Next</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- common pagination ends -->
            </div>
        </div>
    </div><!-- Page wrapper end -->
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

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