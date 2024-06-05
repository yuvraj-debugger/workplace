<div>
	<div class="page-wrapper whoIsIn">
		<div class="content container-fluid">
			<div class="page-head-box">
				<h3>Who Is In</h3>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Who is in</li>
					</ol>
				</nav>

			</div>
<!-- 			<div class="row"> -->
<!-- 				<div class="col-lg-3 ms-auto"> -->
<!-- 					<div class="searchBar"> -->
<!-- 						<div class="form-group mb-4"> -->
<!-- 							<input type="text" class="form-control" placeholder="Search by name or ID" /> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->
<!-- 			</div> -->
			<div class="row">
				<div class="col-lg-4">
					<div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard">
						<div class="cardHeading">
							<h4>Not Yet In <span class="colourYellow">(<?=count($userNotLogIn);?>)</span></h4>
<!-- 							<a href=""> -->
<!-- 								<i class="fa-solid fa-download"></i> -->
<!-- 							</a> -->
						</div>
						<div class="whosInTable">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Employee</th>
											<th>Expected In Time</th>
										</tr>
									</thead>

									<tbody>
									 @if(!empty($userNotLogIn))
                                	@foreach ($userNotLogIn as $notIn)
										<tr>
											<td>
												{{! empty($notIn) ? $notIn->first_name.' '.$notIn->last_name: ''}} <br />
												<span>{{$notIn->employee_id}}</span>
											</td>
											<td>09:00:00</td>
										</tr>
									@endforeach
									@endif
									</tbody>
								</table>
							</div>
						</div>
						
					</div>
				</div>

				<div class="col-lg-4">
					<div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard">
						<div class="cardHeading">
							<h4>Late Arrivals <span class="colourRed">(<?=count($userLateArrival);?>)</span></h4>
							<!-- <a href="http://127.0.0.1:8001/holidays"><i class="fa fa-arrow-right" aria-hidden="true"></i> </a> -->
						</div>
						 <div class="whosInTable">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Employee</th>
											<th>Late Arrival</th>
										</tr>
									</thead>

									<tbody>
                                	@foreach ($userLateArrival as $userLate)
										<tr>
											<td>
												{{! empty($userLate) ? $userLate->first_name.' '.$userLate->last_name: ''}} <br />
												<span>{{$userLate->employee_id}}</span>
											</td>
											<td>{{date('h:i A',$userLate->getuserLateTime()->punch_in)}}</td>
										</tr>
										@endforeach

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard">
						<div class="cardHeading">
							<h4>On Time <span class="colourGreen">(<?=count($allUserPunchIn);?>)</span></h4>
<!-- 							<a href=""><i class="fa-solid fa-download"></i> </a> -->
						</div>
						<div class="whosInTable">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Employee</th>
											<th>Early By</th>
										</tr>
									</thead>

									<tbody>
									 @if(!empty($allUserPunchIn))
                                		@foreach ($allUserPunchIn as $allUserIn)
										<tr>
											<td>
												{{! empty($allUserIn) ? $allUserIn->first_name.' '.$allUserIn->last_name: ''}} <br />
												<span>{{$allUserIn->employee_id}}</span>
											</td>
											<td>{{! empty($allUserIn->getuserOnTime()) ? date('h:i A',$allUserIn->getuserOnTime()->punch_in) : ''}}</td>
										</tr>
										@endforeach
										@endif

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

<!-- 				<div class="col-lg-3"> -->
<!-- 					<div class="dashboardSection__body commonBoxShadow rounded-1 holidayCard"> -->
<!-- 						<div class="cardHeading"> -->
<!-- 							<h4>On Leave <span>(01)</span></h4> -->
<!-- 							<a href=""><i class="fa-solid fa-download"></i></a> -->
<!-- 						</div> -->
<!-- 						<div class="whosInTable"> -->
<!-- 							<div class="table-responsive"> -->
<!-- 								<table class="table"> -->
<!-- 									<thead> -->
<!-- 										<tr> -->
<!-- 											<th>Employee</th> -->
<!-- 											<th>Number of days</th> -->
<!-- 										</tr> -->
<!-- 									</thead> -->

<!-- 									<tbody> -->
<!-- 										<tr> -->
<!-- 											<td> -->
<!-- 												Poonam rana <br /> -->
<!-- 												<span>#SSPL0288</span> -->
<!-- 											</td> -->
<!-- 											<td>01 Day(s) <br /><span class="pill pill-aproved">Approved<span></td> -->
<!-- 										</tr> -->

<!-- 										<tr> -->
<!-- 											<td> -->
<!-- 												Poonam rana <br /> -->
<!-- 												<span>#SSPL0288</span> -->
<!-- 											</td> -->
<!-- 											<td>01 Day(s) <br /><span class="pill pill-reject">Reject<span></td> -->
<!-- 										</tr> -->

<!-- 										<tr> -->
<!-- 											<td> -->
<!-- 												Poonam rana <br /> -->
<!-- 												<span>#SSPL0288</span> -->
<!-- 											</td> -->
<!-- 											<td>01 Day(s) <br /><span class="pill pill-reject">Reject<span></td> -->
<!-- 										</tr> -->

<!-- 									</tbody> -->
<!-- 								</table> -->
<!-- 							</div> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->

			</div>
		</div>
	</div>
</div>
