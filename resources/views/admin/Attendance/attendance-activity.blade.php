<x-admin-layout>
<main class="main-wrapper">

<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Attendance</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Attendance</li>
				</ol>
			</nav>
		</div>

		<div class="setting">
			<div class="dashboardSection">
				<div class="row">
					<div class="col-lg-6">
						<div class="profileCard commonBoxShadow rounded-1 my-3">
<!-- 							<a class="editIcon" data-bs-toggle="modal" -->
<!-- 								data-bs-target="#eduInfo" href="javascript:void(0);"> <img -->
<!-- 								src="images/editIcon.svg"> -->
<!-- 							</a> -->
							<h3>Attendance Records</h3>
						
							<ul class="eduList">
							@if(! empty($userPunchIn))
							 @foreach($userPunchIn as $punchInTime)
								<li class="mb-0">
									<p>
										<b>Punch In at</b>
									</p>
									<p class="grey">
										<i class="fa-solid fa-clock"></i> {{date('H:i:s',$punchInTime->punch_in)}}
									</p>
								</li>
								@endforeach
								@endif
							</ul>
						</div>
					</div>
<!-- 					<div class="col-lg-6"> -->
<!-- 						<div class="dashboardSection__body"> -->
<!-- 							<h4>Statistics</h4> -->
<!-- 							<div class="row g-4"> -->
<!-- 								<div class="col-lg-6"> -->
<!-- 									<div class="attendanceCard"> -->
<!-- 										<p>Today</p> -->
<!-- 										<p class="orange progressText">3.45 / 8 hrs</p> -->

<!-- 										<div class="progress" role="progressbar" -->
<!-- 											aria-label="Warning example" aria-valuenow="75" -->
<!-- 											aria-valuemin="0" aria-valuemax="100"> -->
											<div class="progress-bar bg-warning" style="width: 75%"></div>
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->

<!-- 								<div class="col-lg-6"> -->
<!-- 									<div class="attendanceCard"> -->
<!-- 										<p>This Week</p> -->
<!-- 										<p class="blue progressText">3.45 / 8 hrs</p> -->
<!-- 										<div class="progress" role="progressbar" -->
<!-- 											aria-label="Warning example" aria-valuenow="75" -->
<!-- 											aria-valuemin="0" aria-valuemax="100"> -->
											<div class="progress-bar bg-primary" style="width: 75%"></div>
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->

<!-- 								<div class="col-lg-6"> -->
<!-- 									<div class="attendanceCard"> -->
<!-- 										<p>This Month</p> -->
<!-- 										<p class="green progressText">3.45 / 8 hrs</p> -->
<!-- 										<div class="progress" role="progressbar" -->
<!-- 											aria-label="Warning example" aria-valuenow="75" -->
<!-- 											aria-valuemin="0" aria-valuemax="100"> -->
											<div class="progress-bar bg-success" style="width: 75%"></div>
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->

<!-- 								<div class="col-lg-6"> -->
<!-- 									<div class="attendanceCard"> -->
<!-- 										<p>Remaining</p> -->
<!-- 										<p class="red progressText">3.45 / 8 hrs</p> -->
<!-- 										<div class="progress" role="progressbar" -->
<!-- 											aria-label="Warning example" aria-valuenow="75" -->
<!-- 											aria-valuemin="0" aria-valuemax="100"> -->
											<div class="progress-bar bg-danger" style="width: 75%"></div>
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->

<!-- 								<div class="col-12"> -->
<!-- 									<div class="attendanceCard"> -->
<!-- 										<p>Overtime</p> -->
<!-- 										<p class="grey progressText">4 hrs</p> -->
<!-- 										<div class="progress" role="progressbar" -->
<!-- 											aria-label="Warning example" aria-valuenow="75" -->
<!-- 											aria-valuemin="0" aria-valuemax="100"> -->
											<div class="progress-bar bg-grey" style="width: 75%"></div>
<!-- 										</div> -->
<!-- 									</div> -->
<!-- 								</div> -->

<!-- 							</div> -->
<!-- 						</div> -->
<!-- 					</div> -->
				</div>
			</div>
		</div>

		<div class="pageFilter mb-3">
			<div class="row">
				<div class="col-xl-6">
				  <form  method="get" action="">
					<div class="leftFilters">
						<div class="form-floating">
							<input type="date" class="form-control"
								id="floatingInput" placeholder="Date" name="date" value="{{$searchDate}}"> <label
								for="floatingInput">Date</label>
						</div>
						 
						<button class="btn btn-search mt-0">
							<img src="images/iconSearch.svg" /> Search here
						</button>
						  <div class="col-sm">
                            	<button type="button" value="reset" class="btn btn-search mt-0" onclick="window.location='{{ url("attendance-activity") }}'">Reset</button>
                            </div>
					</div>
				</form>
				</div>
			</div>
		</div>

		<div class="dashboardSection__body">
			<div class="commonDataTable">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Date</th>
								<th>Punch In</th>
								<th>Punch Out</th>
								<th>Production</th>
							</tr>
						</thead>
						<tbody>
					@if(! empty($attendanceDetails))
					      @foreach($attendanceDetails as $userTime)
							<tr>
								<td> {{! empty ($userTime->punch_in) ? date('d M Y',$userTime->punch_in) : ''}}</td>
								<td> {{! empty($userTime->punch_in) ? date('H:i:s a',$userTime->punch_in) : ''}}</td>
							    <td> {{! empty($userTime->punch_out) ? date('H:i:s a',$userTime->punch_out) : ''}}</td>
							    <td><?php 
							    if(! empty($userTime->punch_out)){
							    $mins = ($userTime->punch_out)-($userTime->punch_in);
							    echo gmdate("H:i:s", $mins);
							    }
?>
							    </td>
							    
								
							</tr>
					      @endforeach
					      @endif
							
						</tbody>
					</table>
				 {{$attendanceDetails->links('pagination::bootstrap-4')}}
				</div>
			</div>
	
		</div>

	</div>
</div>

</main>

</x-admin-layout>