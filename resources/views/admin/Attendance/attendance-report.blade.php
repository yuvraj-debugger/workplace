<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Attendance Report</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Attendance</li>
				</ol>
			</nav>
		</div>
		<div class="pageFilter mb-3">
			<div class="row">
				<div class="col-xxl-12 col-lg-12">
					<form method="get" action="">
					<div class="leftFilters leftFiltersReports">
						<div class="col-xxl-2 col-xl-2 col-lg-3">
        					<div class="form-group mt-0">
                                    <label for="floatingSelect">Employees</label>
                                    <select class="form-select user_list js-select2-employee" name="search_user_name"   id="floatingSelect" aria-label="Floating label select example">
                                        <option value=""> Select All</option>
                                         @foreach($employees as $user)
                                            <option value="{{$user->_id}}" {{ ($search_user_name == $user->_id) ? 'selected' : '' }} >{{$user->first_name}} {{$user->last_name}} ({{$user->employee_id}})</option>
                                        @endforeach
                                    </select>
                               </div>
                         </div>
						<div class="col-xxl-2 col-xl-2 col-lg-3">
							<div class="form-group mt-0">
								<label for="floatingSelect">Department</label>
								<select class="form-select  user_designation js-select2" id="floatingSelect" name="search_department"  aria-label="Floating label select example">
								<option value="">Select All</option>
								@foreach($departments as $department)
										<option value="{{$department->_id}}" {{ ($search_department == $user->_id) ? 'selected' : '' }} >{{$department->title}}</option>
								@endforeach
								</select>
							</div>
						</div>	
						<div class="col-xxl-2 col-xl-2 col-lg-3">
							<div class="form-group mt-0">
								<label for="floatingSelect">Status</label>
								<select class="form-select  user_status js-select2" name="search_status"  id="floatingSelect" aria-label="Floating label select example">
                                    <option value='all'>All</option>
                                    <option value="1" {{ ($search_status == '1') ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ ($search_status == '2') ? 'selected' : '' }}>Inactive</option>
                                </select>
							</div>
						</div>	
						 <div class="form-group mt-0">
                                    <label for="floatingInput">From</label>                                  
                                    <input type="date" class="form-control" id="floatingInput" placeholder="Date" name="attendance_from_date_search" value="{{$attendance_from_date_search}}">
                          </div>
                           <div class="form-group mt-0">
                                    <label for="floatingInput">To</label>                                  
                                    <input type="date" class="form-control" id="floatingInput" placeholder="Date" name="attendance_to_date_search" value="{{$attendance_to_date_search}}">
                          </div>
						<div class="">
							<button type="submit" value="Submit" class="btn btn-search">
								<img src="images/iconSearch.svg" /> Search here
							</button>
						</div>
						<div class="">
							<button type="button" value="reset" class="btn btn-search resetBtn"
								onclick="window.location='{{ url("attendance-report") }}'">Reset</button>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
		<div class="dashboardSection">
			<div class="dashboardSection__body">
				<div class="commonDataTable">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
								    <th>Employees Id </th>
									<th>Employees</th>
									<th>Date</th>
									<th class="workplacecenter">Workday</th>
									<th>Work</th>
									<th>Late Arrival</th>
									<th>Missing Work</th>
									<th>Extra Time</th>
								</tr>
							</thead>
							<tbody>
							@if(! empty(count($userAttendances)) > 0)
							 @foreach($userAttendances as $employee)
							 <?php 
							 $endtime='';
							 $start_time='';
							 if(!empty($employee->employeeSchedule($employee->user_id)))
							 {
							     $endtime = ($employee->employeeSchedule($employee->user_id)->end_time) ;
							     $start_time = ($employee->employeeSchedule($employee->user_id)->start_time);
							     
							 }
							 
							 $punchIn = (int)$employee->punch_in;
							 $punchOut =(int)$employee->punch_out;
							 $WorkTime = $punchOut - $punchIn;
							 
							 $missinguser='';
							 $extrauser='';
							 $lateuser='';
							 if($punchIn >= (strtotime(date(date('Y-m-d',$employee->punch_in).' 09:30:00'))))
							 {
							     $lateuser = $employee->punch_in;
							     
							 }
							 
							 if(strtotime('-9 hours', $WorkTime)<0)
							 {
							     $missinguser=(strtotime('-9 hours', $WorkTime)<0)?-1*strtotime('-9 hours', $WorkTime):'';
							     
							 }
							 
							 if(strtotime('-9 hours', $WorkTime)>0)
							 {
							     $extrauser=strtotime('-9 hours', $WorkTime);
							     
							 }
							 
							 ?>
							<tr>
							<td>{{$employee->getUserAttendance()->employee_id}}</td>
								<td>
									<div class="user-name">
										<div class="user-image">
											<img src="{{($employee->getUserAttendance())?$employee->getUserAttendance()->photo:asset('/images/user.png')}}" alt="user-img" />
										</div>
											<span class="green"><a href="/employee-profile/{{$employee->user_id}}">{{! empty($employee->getUserAttendance())? $employee->getUserAttendance()->first_name :''}} {{! empty($employee->getUserAttendance())? $employee->getUserAttendance()->last_name  :''}} 
										<?php
											if($employee->getUserAttendance()->status == '2'){
												echo '<span class="status Inactive">(Inactive)</span>';
											}elseif($employee->getUserAttendance()->status == '3'){
												echo '<span class="status delete">(Deleted)</span>';
											}

											?>
											</a></span>
											
												<!-- <br/><span style="color:#FF7849"></span><br/> -->
									</div>
								</td>
								<td>{{! empty($employee->date) ? date('d M, Y',$employee->date) : ''}}</td>
								<td>
									<p class="mb-0">
										<?php 
										if($employee->employeeSchedule($employee->user_id))
										{
										?>
										{{! empty($employee) ? $employee->getEmployeeShifts($employee->employeeSchedule($employee->user_id)->shifts_id) : ''}} (<?=$employee->employeeSchedule($employee->user_id)->start_time. '->'. $employee->employeeSchedule($employee->user_id)->end_time?>)
									</p>
									<i class="fa fa-arrow-right text-success me-1"></i>{{! empty($employee->punch_in) ? date('H:i:s',$employee->punch_in) : ''}} | <i class="fa fa-arrow-left text-danger me-1"></i>{{! empty($employee->punch_out) ? date('H:i:s',$employee->punch_out) :''}}
								<?php 
										}else{
										    echo "<b>No Shift Assign</b>";
										}
										?>
								</td>
										
								<td><span>{{! empty($WorkTime) ? gmdate('H:i:s',$WorkTime) : ''}}</span></td>
								<td><span class="lateArrivals">{{! empty($lateuser) ? date('H:i:s',$lateuser) : '-'}}</span></td>
								<td><span class="lateArrivals">{{! empty($missinguser) && ! empty($punchOut) ? gmdate('H:i:s',$missinguser) : '-'}}</span></td>
								<td><span class="extraTime">{{! empty($extrauser) ? gmdate('H:i:s',$extrauser) : '-'}}</span></td>
							</tr>
							@endforeach
							  @else
                                <tr><td class="text-center" colspan="9">No Data Found</td></tr>
							@endif
							</tbody>
						</table>
				 {{$userAttendances->links('pagination::bootstrap-4')}}

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</x-admin-layout>