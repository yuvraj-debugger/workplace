<?php
use Illuminate\Support\Facades\Auth;
?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>User Activities</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">user-activities</li>
				</ol>
			</nav>
		</div>
		<div class="dashboardSection">
			<div class="dashboardSection__body">
				<div class="commonDataTable">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Module Name</th>
									<th>Action</th>
									<th>Date</th>
									<th>Time</th>
									<th>Details</th>
									<th>Created By</th>
								</tr>
							</thead>
							
							<tbody>
							
							@foreach($userActivities as $key=>$activity)
								<tr>
								    <td>{{$key+1}}</td>
									<td>{{$activity->module_name}}</td>
									<td>{{$activity->action}}</td>
									<td>{{date('d M, Y',strtotime($activity->updated_at))}}</td>
									<td>{{! empty($activity->updated_at) ? date('H:i',strtotime($activity->updated_at)) : ''}}</td>
									<td><a href="activity-details/{{$activity->_id}}">View</a></td>
									<?php 
									if(Auth::user()->user_role == '0'){
									    ?>
									    <td><a href="profile/{{! empty ($activity->getUserId()) ? $activity->getUserId()->_id : ''}}">{{! empty($activity->getUserId()) ? $activity->getUserId()->first_name . ' '.$activity->getUserId()->last_name : ''}}</a></td>
								<?php }else{?>
									<td><a href="employee-profile/{{! empty ($activity->getUserId()) ? $activity->getUserId()->_id : ''}}">{{! empty ($activity->getUserId()) ? $activity->getUserId()->first_name . ' '.$activity->getUserId()->last_name : ''}}</a></td>
									<?php }?>
								</tr>
							@endforeach()
							</tbody>
						</table>
						{{$userActivities->links('pagination::bootstrap-4')}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</x-admin-layout>
