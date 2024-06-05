<?php
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
                	<?php }?>
                    <div class="row">
                        <?php 
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        if((Auth::user()->user_role == 0 ||  (! empty($role) &&  $role->name=="HR")) ||  (! empty($role) &&  $role->name=="Management")){
                        ?>
                        <div class="{{(Auth::user()->user_role == 0)? 'col-xxl-3' : 'col-xxl-4'}} col-xl-6">
                            <div class="profileCard commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h3>Review</h3>
                                    <a href="leaves?search_leave_type=&search_status=1&fromsearch_date=&tosearch_date="><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                               @if((! empty($leavePending) && count($leavePending)>0) || (! empty($compOff) && count($compOff)>0) || ! empty($pendingConfirmation) && count($pendingConfirmation)>0)
                                <h1 class="leaveCounter"><?=count($leavePending) + count($compOff) + count($pendingConfirmation) ;?> <img src="{{asset ('images/review.png')}}" /></h1>
                                <p>Things To Review</p>
                                
                                <hr />
                                <div class="leavesdashboard">
                                <?php 
                                if(! empty($leavePending) && count($leavePending)>0){
                                    ?>
                                    
                                <ul class="trackList">
                                	<li><a href="leaves?search_leave_type=&search_status=1&fromsearch_date=&tosearch_date=">
                                		<span>
											<img src="{{asset ('images/sunbed.png')}}" />
										</span>
										Leaves
										</a>
                                	</li>
                                </ul>
                                <?php }?>
                                <?php 
                                $role=Role::where('_id',Auth::user()->user_role)->first();
                                
                                if(! empty($compOff) && count($compOff)>0){
                                ?>
                                <?php 
                                if((! empty($role) &&  $role->name=="Management")){
                                ?>
                                <ul class="trackList">
                                	<li><a href="/my-employee-comp-off">
                                		<span>
											<img src="{{asset ('images/empcompoff.png')}}" />
										</span>
										Leave Comp Off
										</a>
                                	</li>
                                </ul>
                                <?php }?>
                                <?php }?>
                                
                                 <?php 
                                $role=Role::where('_id',Auth::user()->user_role)->first();
                                
                                if(! empty($compOff) && count($compOff)>0){
                                ?>
                                <?php }?>
                                
                                
                                  <?php 
                                $role=Role::where('_id',Auth::user()->user_role)->first();
                                
                                if(! empty($compOff) && count($compOff)>0){
                                ?>
                                <?php 
                                if((Auth::user()->user_role  == 0) || ((! empty($role) &&  $role->name=="HR"))){
                                ?>
                                <ul class="trackList">
                                	<li><a href="/employee-comp-off">
                                		<span>
											<img src="{{asset ('images/empcompoff.png')}}" />
										</span>
										Leave Comp Off
										</a>
                                	</li>
                                </ul>
                                <?php }?>
                                <?php }?>
                                
                                <br/>
                                <?php 
                                $role=Role::where('_id',Auth::user()->user_role)->first();
                                if((! empty($role) &&  $role->name=="Management")){
                                ?>
                                  <?php 
                                  if(! empty($pendingConfirmation) && count($pendingConfirmation)>0){
                                ?>
                                <ul class="trackList">
                                	<li><a href="/employee-probation">
                                		<span>
											<!-- <?=count($pendingConfirmation)?>  -->
                                            <img src="{{asset ('images/empconfirm.png')}}" alt="">
										</span>
										Employee Confirmation
										</a>
                                	</li>
                                </ul>
                                <?php 
                                  }}elseif((Auth::user()->user_role  == 0) || (! empty($role) &&  $role->name=="HR")) {
                                  ?>
                                    <?php 
                                    if(! empty($pendingConfirmation) && count($pendingConfirmation)>0){
                                ?>
                                  <ul class="trackList">
                                	<li><a href="/employee-probation">
                                		<span>
											<!-- <?=count($pendingConfirmation)?>  -->
                                            <img src="{{asset ('images/empconfirm.png')}}" alt="">
										</span>
										Employee Confirmation
										</a>
                                	</li>
                                </ul>
                                  <?php }}?>
                                   </div>
                             
                             
                                @else
                                <div class="noData">
                                    <img src="{{asset ('images/Checklist-vector.svg')}}" width="100px" height="200px"/>
                                    <p><b>Hurrah!</b> You've nothing to review.</p>
                                </div>
                                @endif
                                </div>
                            
                            </div>
                            <?php } ?>
                        <?php 
                        if(! Auth::user()->user_role == 0 ){
                        ?>
                            <div class="col-xxl-4 col-xl-6">
                                <!-- Button trigger modal -->
                            
                                <div class="dashboardSection__body timesheet">
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
                                                <p>Punch In at <br /> <span class="green">{{!empty($this->attendances)?date('D, jS M Y h.i A',$this->attendances->punch_in):''}}</span></p>            
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
                                            <div class="timeWrapper__circle pulse">
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
                                                    <h5>{{$overAllTime}} hrs</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <!-- Modal -->
                                <div wire.ignore>
                                    <div class="modal fade statisticsModal" id="statistics" tabindex="-1" aria-bs-labelledby="exampleModalToggleLabel" aria-bs-hidden="true">
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

                                                                    <div class="progress-bar bg-grey" style="width: {{((int)$monthlytotalovertimesecs/((int)$totalMonthlyhrs*60*60))*100}}%"></div>
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
                            </div>
                            <?php }?>
                            
                        <div class="{{(Auth::user()->user_role == 0)? 'col-xxl-3 col-xl-6' : 'col-xxl-4'}} col-xl-6">
                            <div class="profileCard commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h3>Who is in?</h3>
                                    <a href="/admin-whoisin"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                                <h6 class="mb-2">Not Yet In</h6>
                                <div class="row">
                                    <?php 
                                $role=Role::where('_id',Auth::user()->user_role)->first();
                                $userAdmin = User::where('_id',Auth::user()->_id)->where('user_role','0')->first();
                                if($userAdmin ||   ! empty($role) && $role->name=="HR"){
                                ?>
                                    <ul class="candidateInImg-list mb-2">
                                    @if(!empty($userNotLogIn))
                                    @foreach ($userNotLogIn as $notIn)
                                    <li>
                                        <img class="" src="{{(($notIn->photo) ? $notIn->photo : url('images/user.png'))}}" alt="" class="rounded-circle img-fluid" title="{{! empty($notIn) ? $notIn->first_name.' '.$notIn->last_name: ''}}">
                                    </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                    <?php }?>
                                    
                                    <ul class="candidateInImg-list mb-2">
                                    @if(!empty($NotIn))
                                    @foreach ($NotIn as $userNotIn)
                                    <li>
                                        <img class="" src="{{(($userNotIn->photo) ? $userNotIn->photo : url('images/user.png'))}}" alt="" class="rounded-circle img-fluid" title="{{! empty($userNotIn) ? $userNotIn->first_name.' '.$userNotIn->last_name: ''}}">
                                    </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                </div>
                                
                                <h6 class="mb-2">Late Arrivals</h6>
                                    <div class="row">
                                    <?php 
                                    $role=Role::where('_id',Auth::user()->user_role)->first();
                                    
                                $userAdmin = User::where('_id',Auth::user()->_id)->where('user_role','0')->first();
                                if($userAdmin || ! empty($role) && $role->name=="HR"){
                                ?>
                                <ul class="candidateInImg-list mb-2">
                                    @if(!empty($userLateArrival))
                                    @foreach ($userLateArrival as $userLate)
                                    <li>
                                        <img class="" src="{{(($userLate->photo) ? $userLate->photo : url('images/user.png'))}}" alt="" class="rounded-circle img-fluid" title="{{! empty($userLate) ? $userLate->first_name.' '.$userLate->last_name: ''}}">
                                    </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                    <?php }?>
                                    <ul class="candidateInImg-list mb-2">
                                    @if(!empty($lateArrival))
                                    @foreach ($lateArrival as $lateUser)
                                    <li>
                                        <img class="" src="{{(($lateUser->photo) ? $lateUser->photo : url('images/user.png'))}}" alt="" class="rounded-circle img-fluid" title="{{! empty($lateUser) ? $lateUser->first_name.' '.$lateUser->last_name: ''}}">
                                    </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                    
                                </div>
                                <h6 class="mb-2">On Time</h6>
                                <?php 
                                
                                $userAdmin = User::where('_id',Auth::user()->_id)->where('user_role','0')->first();
                                if($userAdmin ||  ! empty($role) && $role->name=="HR"){ 
                                ?>
                                    <ul class="candidateInImg-list mb-2">
                                    @if(!empty($allUserPunchIn))
                                    @foreach ($allUserPunchIn as $allUserIn)
                                    
                                    <li>
                                        <img class="" src="{{(($allUserIn->photo) ? $allUserIn->photo : url('images/user.png'))}}" alt="" class="rounded-circle img-fluid" title="{{! empty($allUserIn) ? $allUserIn->first_name.' '.$allUserIn->last_name: '' }}">
                                    </li>
                                    @endforeach
                                    @endif
                                    </ul>
                                    <?php }?>
                                    <ul class="candidateInImg-list mb-2">
                                    @if(!empty($onTime))
                                    @foreach ($onTime as $userontime)
                                    
                                    <li>
                                        <img class="" src="{{(($userontime->photo) ? $userontime->photo : url('images/user.png'))}}" alt="" class="rounded-circle img-fluid" title="{{! empty($userontime) ? $userontime->first_name.' '.$userontime->last_name: ''}}">
                                    </li>
                                    @endforeach
                                    @endif
                                    </ul>
                            </div>
                         </div>
                        
                            <?php     
                            $role=Role::where('_id',Auth::user()->user_role)->first();
                            
                            if(! empty($role) && $role->name=="Management"){
                                ?>
                            <div class="col-xxl-4 col-xl-6">
                                <div class="profileCard commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h3>Team on Leave</h3>
                                    <a href="{{route('leaves')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                                <!-- <div class="table-responsive"> -->
                                                             
                                 @if(! empty($leaveApproved)&& count($leaveApproved)>0)
                                    <table class="table">
                                    <tr>
                                        <th>Name</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                    </tr>
                                        @foreach ($leaveApproved as $pending)
                                            <tr>
                                                <td><b>{{! empty($pending->getleaveemployee_name()) ? $pending->getleaveemployee_name()->first_name.' '.$pending->getleaveemployee_name()->last_name :''}}</b></td>
                                                <td class="text-end">{{date('d M, Y',strtotime($pending->from_date))}} </td>
                                                <td class="text-end" >{{date('d M, Y',strtotime($pending->to_date ))}}</td>
                                                <td class="text-end"><?=($pending->status == '2') ? 'Approved' : '';?></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    @else
                                    <div class="noData">
                                    	<img src="{{asset ('images/Checklist-vector.svg')}}" width="100px" height="200px"/>
                                    <p><b>Hurrah!</b> It's empty here! No one is in your team on leave.</p>

						        <!-- </div> -->
                                @endif
                                </div>
                            </div>
                        </div>
                            
                        <?php }?> 
                        
                        
                        <?php       
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
            $userAdmin = User::where('_id',Auth::user()->_id)->where('user_role','0')->first();
            if($userAdmin || $role->name=="HR"){
            ?>
                         <div class="{{(Auth::user()->user_role == 0)? 'col-xxl-3' : 'col-xxl-4'}} col-xl-6">
                            <div class="profileCard commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h3>Employees on Leave</h3>
                                    <a href="leaves?search_leave_type=&search_status=2&fromsearch_date=&tosearch_date="><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                                <table class="table">
                                  @if(count($onLeave) > 0)
                                  <tr>
                                     <th>Name</th>
                                     <th>From</th>
                                     <th>To</th>
                                     <th>Type</th>
                                 </tr>
                               
                                 @foreach ($onLeave as $onLeaves)
                                        <tr>
                                            <td><b>{{! empty($onLeaves->getleaveemployee_name()) ? $onLeaves->getleaveemployee_name()->first_name.' '.$onLeaves->getleaveemployee_name()->last_name : ''}}</b></td>
                                             <td class="text">{{date('d M, Y',strtotime($onLeaves->from_date))}} </td>
                                             <td class="text" >{{date('d M, Y',strtotime($onLeaves->to_date ))}}</td>
                                            <td class="text">
                                            <?php 
                                 
                                            if($onLeaves->leave_type == "1"){
                                     echo "Casual Leave";
                                            }elseif ($onLeaves->leave_type == "2"){
                                     echo "Sick Leave";
                                            }elseif ($onLeaves->leave_type == "3"){
                                     echo "Earned Leave";
                                 }else{
                                     echo "Loss Of Pay";
                                 }
                                 ?>
                                            
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    @else
                                     <div class="noData">
                                    <img src="{{asset ('images/Checklist-vector.svg')}}" width="100px" height="200px"/>
                                    <p><b>Hurrah!</b> You've nothing new to track.</p>

						        </div>
						        @ENDIF
                                </table>
                            </div>
                        </div>
                        <?php }?>
                         <?php       
            $userAdmin = User::where('_id',Auth::user()->_id)->where('user_role','0')->first();
            $role=Role::where('_id',Auth::user()->user_role)->first();
            if(! empty($role)){
            if(! $userAdmin&&($role->name!='HR')){
            ?>
                        <div class="col-xxl-4 col-xl-6">
                            <div class="profileCard commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h3>Track Leave</h3>
                                    <a href="/myleaves"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                              @if(! empty($managerLeave)&& count($managerLeave)>0)
                               <table class="table">
                                 <tr>
                                     <th>Name</th>
                                     <th>From</th>
                                     <th>To</th>
                                     <th>Type</th>
                                 </tr>
                                  @foreach ($managerLeave as $managerleaves)
                                  <tr>
                                 <td><b>{{! empty($managerleaves->getleaveemployee_name()) ? $managerleaves->getleaveemployee_name()->first_name.' '.$managerleaves->getleaveemployee_name()->last_name : ''}}</b></td>
                                 <td>{{date('d M, Y',strtotime($managerleaves->from_date))}}</td>
                                 <td>{{date('d M, Y',strtotime($managerleaves->to_date))}}</td>
                                 <td><?php 
                                 
                                 if($managerleaves->leave_type == "1"){
                                     echo "Casual Leave";
                                 }elseif ($managerleaves->leave_type == "2"){
                                     echo "Sick Leave";
                                 }elseif ($managerleaves->leave_type == "3"){
                                     echo "Earned Leave";
                                 }elseif ($managerleaves->leave_type == "4"){
                                     echo "Loss Of Pay";
                                 }elseif ($managerleaves->leave_type == "5"){
                                     echo "Comp- Off";
                                 }elseif ($managerleaves->leave_type == "6"){
                                     echo "Bereavement Leave";
                                 }elseif ($managerleaves->leave_type == "9"){
                                     echo "Emergency Leave";
                                 }
                                 ?></td></tr>
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
                        <?php }}?>
                        <?php       
            $role=Role::where('_id',Auth::user()->user_role)->first();
            if(! empty($role)){
            if($role->name=='HR'){
            ?>
                        <div class="col-xxl-4 col-xl-6">
                            <div class="profileCard commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h3>Track Leave</h3>
                                    <a href="/myleaves"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                              @if(! empty($hrLeave)&& count($hrLeave)>0)
                               <table class="table">
                                 <tr>
                                     <th>Name</th>
                                     <th>From</th>
                                     <th>To</th>
                                     <th>Type</th>
                                 </tr>
                                  @foreach ($hrLeave as $hrLeaves)
                                  <tr>
                                 <td><b>{{! empty($hrLeaves->getleaveemployee_name()) ? $hrLeaves->getleaveemployee_name()->first_name.' '.$hrLeaves->getleaveemployee_name()->last_name : ''}}</b></td>
                                 <td>{{date('d M, Y',$hrLeaves->str_from_date)}}</td>
                                 <td>{{date('d M, Y',$hrLeaves->str_to_date)}}</td>
                                 <td><?php 
                                 
                                 if($hrLeaves->leave_type == "1"){
                                     echo "Casual Leave";
                                 }elseif ($hrLeaves->leave_type == "2"){
                                     echo "Sick Leave";
                                 }elseif ($hrLeaves->leave_type == "3"){
                                     echo "Earned Leave";
                                 }else{
                                     echo "Loss Of Pay";
                                 }
                                 ?></td></tr>
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
                        <?php }}?>
                        <?php 
              
                    $role=Role::where('_id',Auth::user()->user_role)->first();
                    if((Auth::user()->user_role == 0) || (! empty($role) && $role->name=='HR')){
                        if(! empty($BirthdayCollection && count($BirthdayCollection) > 0) || ! empty($AniverseryCollection && count($AniverseryCollection) > 0)){
                    ?>
                        <div class="col-xxl-3 col-xl-6 birthdaycolumn">
                        <div class="birthdaycard profileCard commonBoxShadow rounded-1 holidayCard">
<div class="greetingcontent">
    <div class="imagescontainer">
    <?php 
//     $collectionData = $BirthdayCollection->merge($AniverseryCollection);
//     foreach ($collectionData as $datas){
//         $data = array_unique($datas);
//         dd($data);
//     }
//     die();
    
    ?>
       
          @if(! empty($BirthdayCollection && count($BirthdayCollection) > 0))
        		 @foreach($BirthdayCollection as $birthdayImage)
        		  <div class="empcard">
            		<img src="{{$birthdayImage['photo']}}" alt="" class="birthdayemployee">
            		<h5>{{$birthdayImage['name']}}</h5>
            		</div>
            		
              	  @endforeach
           @endif
           @if(! empty($AniverseryCollection && count($AniverseryCollection) > 0))
             @foreach($AniverseryCollection as $AnniversaryImage)
             <div class="empcard">
                <img src="{{$AnniversaryImage['photo']}}" alt="" class="birthdayemployee">
                <h5>{{$AnniversaryImage['name']}}</h5>
                </div>
             @endforeach
          @endif
    </div>
    <div class="birthdaycardinner">
        <h1>Send warm wishes on their <span>Special Day</span></h1>
        @if(! empty($BirthdayCollection && count($BirthdayCollection) > 0))
        <p>Birthday Today - 
        
            <?php 
                     foreach ($BirthdayCollection as $birthday){
                         $names[] = $birthday['name'];
                        }
                        
                        echo '<span>'.implode(', ',$names).'</span>';
                   ?>
           </p>
           @endif
           @if(! empty($AniverseryCollection && count($AniverseryCollection) > 0))
        <p>Anniversary Today -
        
             <?php 
                                                foreach ($AniverseryCollection as $anniversary){
                                                    $names[] = $anniversary['name'];
                                                    }
                                                    echo '<span>'.implode(', ',$names).'</span>';
                                                
                                                ?>
            
            
        </p>
        @endif
    </div>

</div>
<img src="{{asset ('images/balloon1.svg')}}" alt="" class="balloon1">
<img src="{{asset ('images/balloon2.svg')}}" alt="" class="balloon2">
</div>
                        </div>
                <?php }}?>

                        <div class="{{(Auth::user()->user_role == 0)? 'col-xxl-3' : 'col-xxl-4'}} col-xl-6">
                            
                            <div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h4>Upcoming Holidays</h4>
                                    <a href="{{route('admin.holidays')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                                </div>
                                @if(! empty($holidays)&& count($holidays)>0)
                                <table class="table">
                                   @if(! empty($holidays))
                                    @foreach ($holidays as $upcomingHoliday)
                                        <tr>
                                            <td><b>{{date('d M, Y',($upcomingHoliday->date))}}</b></td>
                                            <td class="text-end">{{$upcomingHoliday->title}}</td>
                                        </tr>
                                    @endforeach
                                    @endif 
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
                    <?php 
                    $role=Role::where('_id',Auth::user()->user_role)->first();
                    if((Auth::user()->user_role == 0) || (! empty($role) && $role->name=='HR')){
                    ?>
                    
                    
                    <div class="{{(Auth::user()->user_role == 0)? 'col-xxl-3' : 'col-xxl-4'}} col-xl-6">
                            
                            <div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h4>Employee Birthday's</h4>
                                </div>
                                <table class="table">
                                   @if(! empty($BirthdayCollection))
                                    @foreach ($BirthdayCollection as $userBirthday)
                                        <tr>
                                            <td>{{$userBirthday['day']}} {{ date("F", mktime(0, 0, 0, $userBirthday['month'], 12)) }}</td>
                                            <td><a href="/employee-profile/{{$userBirthday['id']}}"><b>{{$userBirthday['name']}}</b></a></td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="{{(Auth::user()->user_role == 0)? 'col-xxl-3' : 'col-xxl-4'}} col-xl-6">
                            
                            <div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard">
                                <div class="cardHeading">
                                    <h4>Employee Work Anniversary's</h4>
                                </div>
                                <table class="table">
                                   @if(! empty($AniverseryCollection))
                                    @foreach ($AniverseryCollection as $anniversary)
                                        <tr>
                                             <td>{{$anniversary['day']}} {{ date("F", mktime(0, 0, 0, $anniversary['month'], 12)) }}</td>
                                            <td><a href="/employee-profile/{{$anniversary['id']}}"><b>{{$anniversary['name']}}</b></a></td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    
                    <?php }?>
                </div>
                    </div>

              </div>
            </div>
         

          </div>
        </div>
        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tsparticles-confetti@2.12.0/tsparticles.confetti.bundle.min.js"></script>

<script type="text/javascript">
$(window).load(function() {
    $('#myModal').modal('show');
});
</script>
<script>
<?php if($employeeBirthday){?>
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
  $(document).ready(function() {
    $('.month').select2({
      tags: false,
      multiple: false
    }).on('change', function(e) {
      @this.set('month', $(this).val());
      var y = $('.year').val();
      var m = $(this).val();
      var d = new Date(y, m, 0).getDate();
      var lastDay = new Date(y, m + 1, 0);
      $("#datePickerFilter").datepicker('remove'); //detach
      $('#datePickerFilter').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
        startDate: new Date(y + '-' + m + '-01'),
        endDate: new Date(y + '-' + m + '-' + d),
        onSelect: function(taskduedate) {
          @this.set('dateFilter', taskduedate);
        }
      });
    });
    $('.year').select2({
      tags: false,
      multiple: false
    }).on('change', function(e) {
      @this.set('year', $(this).val());
      var y = $(this).val();
      var m = @this.month;
      var d = new Date(y, m, 0).getDate();
      var lastDay = new Date(y, m + 1, 0);
      $("#datePickerFilter").datepicker('remove'); //detach
      $('#datePickerFilter').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
        startDate: new Date(y + '-' + m + '-01'),
        endDate: new Date(y + '-' + m + '-' + d),
        onSelect: function(taskduedate) {
          @this.set('dateFilter', taskduedate);
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    var year = $('.year').val();
    var month = @this.month;
    var d = new Date(year, month, 0).getDate();
    var lastDay = new Date(year, month + 1, 0);
    console.log('year===' + year);
    console.log('month===' + month);
    console.log('month===' + d);
    $('#datePickerFilter').datepicker({
      autoclose: true,
      dateFormat: 'dd-mm-yy',
    }).on("changeDate", function(e) {
      console.log('date');
      @this.set('dateFilter', $(this).val());
    });
  });
</script>
<script>
let myVar = setInterval(myTimer ,1000);
function myTimer() {
  const d = new Date();
  $('.clock').html(d.toLocaleTimeString());
}
</script>