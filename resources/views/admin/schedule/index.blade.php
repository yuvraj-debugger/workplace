	<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Daily Scheduling</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Daily Scheduling</li>
				</ol>
			</nav>
		</div>
		@if(session('success'))
		<div class="alert alert-success alert-block" id="success">{{
			session('success') }}</div>
		@endif
		
				<div class="pageFilter mb-3">
			<div class="row">
				<div class="col-xxl-10 col-xl-9 col-lg-9 col-md-9">
					<form method="get" action="" class="mb-0">
						<div class="leftFilters d-block dailySchedulingSection">
							<div class="row">
								<div class="col-xxl-2 col-xl-3 col-lg-4">
									<div class="form-group mt-0">
										<label for="floatingSelect">Employees</label>
										<select class="form-select user_list js-select2-employee" name="search_name"  id="floatingSelect" aria-label="Floating label select example">
											<option value='all' >All</option>
												@foreach($employees as $user)
												<option value="{{$user->_id}}" {{ ($employeeName == $user->_id) ? 'selected' : '' }}>{{$user->first_name}} {{$user->last_name}} ({{$user->employee_id}})</option>
											@endforeach
										</select>
									</div>
									
								</div>
								<div class="col-xxl-2 col-xl-3 col-lg-4">

									<div class="form-group mt-0">
										<label for="floatingSelect">Department</label> <select
											class="form-select month js-select2" id="floatingSelect"
											name="department_search"
											aria-label="Floating label select example">
											<option value="">Select Department</option>
											@foreach($allDepartment as $department)
											<option value="{{$department->_id}}" {{ ($departmentSearch == $department->_id) ? 'selected' : '' }}>{{$department->title}}</option>
											@endforeach
										</select>

									</div>
									
								</div>
								<div class="col-xxl-2 col-xl-3 col-lg-4">
									<div class="form-group mt-0">
										<label for="floatingInput">From</label> <input type="date"
											class="form-control" id="from_date" placeholder="Date"
											name="from_date" value="">
									</div>
								</div>

								

								<div class="col-xxl-2 col-xl-3 col-lg-4">
									<div class="form-group mt-0">
										<label for="floatingInput">To</label> <input type="date"
											class="form-control" id="to_date" placeholder="Date"
											name="to_date" value="">
									</div>
								</div>

								<div class="col-xxl-4 col-xl-5 col-lg-9 col-md-7">
									
									<div class="form-group scheduleFilterBtn">
										<button type="submit" value="Submit" class="btn btn-search">
											<img src="images/iconSearch.svg" /> Search here
										</button>
										<button type="button" value="reset" class="btn btn-search"
											onclick="window.location='{{ url("employee-schedule") }}'">Reset</button>
									</div>
									<!-- <div class="form-group mt-0">
									</div> -->
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3">
					<div class="rightFilter addscheduleBtns">
						<a type="button" class="addBtn" data-bs-toggle="modal"
							data-bs-target="#ScheduleModal" onclick="$('.error').html('')">Assign Schedule </a>
					</div>
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
									<th>Employees</th>
									<?php 
									$d =$fromDate;
									?>
									@while($d<= $toDate)
									<th>{{date('D d', strtotime($d))}}</th>
									<?php 
									$d=date('Y-m-d',strtotime($d.' +1 day'));
									?>
									@endwhile
								</tr>
							</thead>
							<tbody>
							@if(!empty($employees->count()))
								@foreach($employees as $employee)
								
								<tr>
									<td><div class="user-name">
											<div class="user-image">
												<img src="{{($employee)?$employee->photo:asset('/images/user.png')}}" alt="user-img" />
											</div>
											<span class="green"><a href="employee-profile/{{$employee->_id}}">{{ucfirst($employee->first_name).' '. $employee->last_name .' '.'('.$employee->employee_id.')'}}</a><br/><span style="color:#FF7849" class="ps-0">{{$employee->departMentAll()}}</span></span>
										</div></td>
										<?php 
										$d =$fromDate;
										?>
										
										@while($d<= $toDate)
										    
										    <td>
										    <?php
										    $schedule=$employee->checkschedule($d);
										    $defaultShift =  $employee->defaultShift();
										    if(!empty($schedule))
										    {
										    ?>
											<span   onclick="defaultSchedule('{{$employee->_id}}','{{date('Y-m-d', strtotime($d))}}','{{$schedule->shifts_id}}','{{$schedule->_id}}')" class="scheduleTiming">{{$schedule->start_time}} - {{$schedule->end_time}} ({{(gmdate('H:i:s',strtotime($schedule->end_time)-strtotime($schedule->start_time)))}} Hours) </span>
											<?php 
											
										}
										elseif(! empty($employee->shift_id)) 
										{
										   $defaultShift =  $employee->defaultShift();
										   if(! empty($defaultShift)){
										    
										?>   
										  <span onclick="defaultSchedule('{{$employee->_id}}','{{date('Y-m-d', strtotime($d))}}','{{$defaultShift->_id}}')"  class="scheduleTiming">{{$defaultShift->start_time}} - {{$defaultShift->end_time}} ({{(gmdate('H:i:s',strtotime($defaultShift->end_time)-strtotime($defaultShift->start_time)))}} Hours) </span>
										<?php 
										   } }else{
										    ?>
										   <span data-bs-toggle="modal" data-bs-target=""  onclick="assignSehedule('{{$employee->_id}}','{{date('Y-m-d', strtotime($d))}}')" class="absent" style="cursor:pointer"><i class="fa fa-plus"></i></span>
										    
									<?php 	}
										$d=date('Y-m-d',strtotime($d.' +1 day'));
										?>
										</td>
										
											@endwhile
								</tr>
								@endforeach
							@else
							<tr>
								<td colspan="6">
									No Result Found
								</td>
							</tr>
							@endif
							</tbody>
						</table>
						{{$employees->links('pagination::bootstrap-4')}}
						

					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade commonModalNew" id="ScheduleModal" tabindex="-1" aria-labelledby="ScheduleModalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="ScheduleModalLabel">Assign Schedule</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="addSchedule">
					@csrf
					<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Department </label><span class="text-danger">*</span><select class="form-control "
											name="schedule_department" id="schedule_department">
											<option value="1">Select All</option>
											@foreach($allDepartment as $department)
											<option value="{{$department->_id}}">{{$department->title}}</option>
											@endforeach
										</select> <span class="text-danger error" id="schedule_errors_schedule_department"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Employee </label><span class="text-danger">*</span><select class="form-control"
											name="schedule_employee" id="schedule_employee">
											<option value="1">Select All</option>
										</select> <span class="text-danger error" id="schedule_errors_schedule_employee"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>From</label><span class="text-danger">*</span> <input
											type="date" id="schdule_date" name="schdule_from_date"
											class="form-control " /> <span class="text-danger error"
											id="schedule_errors_schdule_from_date"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>To</label><span class="text-danger">*</span> <input
											type="date" id="schdule_date" name="schdule_to_date"
											class="form-control " /> <span class="text-danger error"
											id="schedule_errors_schdule_to_date"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Shifts </label> <span class="text-danger">*</span><select class="form-control"
											name="schedule_shift" id="schedule_shift">
											<option value=""></option>
											@foreach($employeeShifts as $shift)
											<option value="{{$shift->_id}}">{{$shift->shift_name}}</option>
											@endforeach
										</select> <span class="text-danger error" id="schedule_errors_schedule_shift"></span>
									</div>
								</div>
									<div class="col-lg-6">
									<div class="form-group">
										<label>Min Start Time</label> <span class="text-danger">*</span><input
											type="time" id="schedule_min_start_time" name="schedule_min_start_time"
											class="form-control " /> <span class="text-danger error"
											id="schedule_errors_schedule_min_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Start Time</label><span class="text-danger">*</span> <input
											type="time" id="schedule_start_time" name="schedule_start_time"
											class="form-control " /> <span class="text-danger error"
											id="schedule_errors_schedule_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max Start Time</label><span class="text-danger">*</span>
										<input type="time" id="schedule_max_start_time" name="schedule_max_start_time"
											class="form-control " /> <span class="text-danger error"
											id="schedule_errors_schedule_max_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Min End Time</label><span class="text-danger">*</span>
										<input type="time" id="schedule_min_end_time" name="schedule_min_end_time"
											class="form-control " /> <span class="text-danger error"
											id="schedule_errors_schedule_min_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>End Time</label><span class="text-danger">*</span> <input
											type="time" id="schedule_end_time" name="schedule_end_time"
											class="form-control"/> <span class="text-danger error"
											id="schedule_errors_schedule_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max End Time</label><span class="text-danger">*</span>
										<input type="time" id="schedule_max_end_time" name=schedule_max_end_time
											class="form-control " /> <span class="text-danger error"
											id="schedule_errors_schedule_max_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Break Time (In Minutes)</label><span class="text-danger">*</span>
										<select  class="form-control js-select2" name="schedule_break_time" id="schedule_break_time">
                                          <option value="">Select Minute </option>
                                          <option value="15">15</option>
                                          <option value="30">30</option>
                                          <option value="45">45</option>
                                          <option value="60">60</option>
                                        </select>
										<span
											class="text-danger error" id="schedule_errors_schedule_break_time"></span>
									</div>
								</div>
								<br />
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary modalcanceleffect"
										data-bs-dismiss="modal">Cancel</button>
									<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
								</div>
							</div>
                </form>
      </div>
    </div>
  </div>
</div>



<div class="modal fade commonModalNew" id="assignScheduleModal" tabindex="-1" aria-labelledby="assignScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="assignScheduleModalLabel">Assign Schedule</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="assignaddSchedule">
					@csrf
					           			<input type="hidden" name="assignSchedule_id" id="assignSchedule_id" value="">
					
					<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Department </label><input class="form-control"
											name="assign_department_id" id="assign_department_id" value=""  disabled>
								<input type="hidden" name="hidden_department_id" id="hidden_department_id" value="">
											
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Employee </label><input class="form-control"
											name="assign_employee_id" id="assign_employee_id"  disabled>
									<input type="hidden" name="hidden_employee_id" id="hidden_employee_id" value="">
											
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Date</label><span class="text-danger">*</span> <input
											type="date" id="assign_schdule_date" name="assign_schdule_date"
											class="form-control " /> <span class="text-danger error"
											id="assign_schedule_errors_assign_schdule_date"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Shifts </label> <select class="form-control"
											name="assign_schedule_shift" id="assign_schedule_shift">
											<option value=""></option>
											@foreach($employeeShifts as $shift)
											<option value="{{$shift->_id}}">{{$shift->shift_name}}</option>
											@endforeach
										</select> <span class="text-danger error" id="assign_schedule_errors_assign_schedule_shift"></span>
									</div>
								</div>
									<div class="col-lg-6">
									<div class="form-group">
										<label>Min Start Time</label> <span class="text-danger">*</span><input
											type="time" id="assign_schedule_min_start_time" name="assign_schedule_min_start_time"
											class="form-control"/> <span class="text-danger error"
											id="assign_schedule_errors_assign_schedule_min_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Start Time</label><span class="text-danger">*</span> <input
											type="time" id="assign_schedule_start_time" name="assign_schedule_start_time"
											class="form-control "  /> <span class="text-danger error"
											id="assign_schedule_errors_assign_schedule_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max Start Time</label><span class="text-danger">*</span>
										<input type="time" id="assign_schedule_max_start_time" name="assign_schedule_max_start_time"
											class="form-control"  /> <span class="text-danger error"
											id="assign_schedule_errors_assign_schedule_max_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Min End Time</label><span class="text-danger">*</span>
										<input type="time" id="assign_schedule_min_end_time" name="assign_schedule_min_end_time"
											class="form-control" /> <span class="text-danger error"
											id="assign_schedule_errors_assign_schedule_min_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>End Time</label><span class="text-danger">*</span> <input
											type="time" id="assign_schedule_end_time" name="assign_schedule_end_time"
											class="form-control" /> <span class="text-danger error"
											id="assign_schedule_errors_assign_schedule_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max End Time</label><span class="text-danger">*</span>
										<input type="time" id="assign_schedule_max_end_time" name=assign_schedule_max_end_time
											class="form-control " /> <span class="text-danger error"
											id="assign_schedule_errors_assign_schedule_max_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Break Time (In Minutes)</label><span class="text-danger">*</span>
										<select  class="form-control js-select2" name="assign_schedule_break_time" id="assign_schedule_break_time">
                                          <option value="">Select Minute </option>
                                          <option value="15">15</option>
                                          <option value="30">30</option>
                                          <option value="45">45</option>
                                          <option value="60">60</option>
                                        </select>
										 <span
											class="text-danger error" id="assign_schedule_errors_assign_schedule_break_time"></span>
									</div>
								</div>
								<br />
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary modalcanceleffect"
										data-bs-dismiss="modal">Cancel</button>
									<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
								</div>
							</div>
                </form>
      </div>
    </div>
  </div>
</div>




	</div>
	
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>



$(function(){
  $('#schedule_employee').select2({
    dropdownParent: $('#ScheduleModal')
  });
  $('#schedule_shift').select2({
    dropdownParent: $('#ScheduleModal')
  });
  $('#schedule_department').select2({
    dropdownParent: $('#ScheduleModal')
  });
    $('#assign_schedule_shift').select2({
    dropdownParent: $('#assignScheduleModal')
  });
  
  
  
}); 


$(document).ready(function(){ 
      $("#schedule_shift").on('change',function(){
     var id = $(this).val();
       $.ajax({
            type: 'post',
            url: "{{ route('ajaxShift')}}",
            data: "id="+id+"",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(data) {
            var data = JSON.parse(data)
            console.log(data);
            $('#schedule_min_start_time').val(data.min_start_time);
            $('#schedule_start_time').val(data.start_time);
            $('#schedule_max_start_time').val(data.max_start_time);
            $('#schedule_min_end_time').val(data.min_end_time);
            $('#schedule_end_time').val(data.end_time);
            $('#schedule_max_end_time').val(data.max_end_time);
            $('#schedule_break_time').val(data.break_time).trigger('change');
            },
       });
    });   
    
            
        $('#addSchedule').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addSchedule')}}",
                data:  formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/employee-schedule";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#schedule_errors_'+key).html(value)
                	})
                }
                },
            });
        });  
});


function defaultSchedule(id,date,shif_id,schedule_id=null)
{
  $('#assignScheduleModal').modal('show')
  $('#assignSchedule_id').val(schedule_id)
  $('#assign_schdule_date').val(date);
    var id_ = $('#assignSchedule_id').val();
   $.ajax({
                type: 'post',
                url: "{{ route('assignSchedule')}}",
                data: "id="+id+"&shif_id="+shif_id+"&schedule_id="+schedule_id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                console.log(data)
                var data = JSON.parse(data)
                $('#assign_department_id').val(data.department_title);
                $('#assign_employee_id').val(data.employee_name)
                $('#hidden_employee_id').val(data.employee_id)
                $('#hidden_department_id').val(data.department_id)
                $('#assign_schedule_shift').val(data.shift_name).trigger('change')
                $('#assign_schedule_min_start_time').val(data.min_start_time)
                $('#assign_schedule_start_time').val(data.start_time)
                $('#assign_schedule_max_start_time').val(data.max_start_time)
                $('#assign_schedule_min_end_time').val(data.min_end_time)
                $('#assign_schedule_end_time').val(data.end_time)
                $('#assign_schedule_max_end_time').val(data.max_end_time)
                $('#assign_schedule_break_time').val(data.break_time).trigger('change')
                
                },
            });
}
$(document).ready(function(){ 
      $("#assign_schedule_shift").on('change',function(){
          var id = $(this).val();
          $.ajax({
            type: 'post',
            url: "{{ route('assignajaxShift')}}",
            data: "id="+id+"",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(data) {
            var data = JSON.parse(data)
            $('#assign_schedule_min_start_time').val(data.min_start_time);
            $('#assign_schedule_start_time').val(data.start_time);
            $('#assign_schedule_max_start_time').val(data.max_start_time);
            $('#assign_schedule_min_end_time').val(data.min_end_time);
            $('#assign_schedule_end_time').val(data.end_time);
            $('#assign_schedule_max_end_time').val(data.max_end_time);
            $('#assign_schedule_break_time').val(data.break_time);
            },
       });
    });
});   



     
        $('#assignaddSchedule').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('assignaddSchedule')}}",
                data:  formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
        			window.location = "/employee-schedule";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#assign_schedule_errors_'+key).html(value)
                	})
                }
                },
            });
        });  
        
        
        
        
           $(document).ready(function() {
   
      $("#schedule_department").on('change',function(){
      var id = $(this).val();
      $("#schedule_employee").html('');
       $.ajax({
            type: 'post',
            url: "{{ route('assignEmployee')}}",
            data: "id="+id+"",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            dataType: 'json',
            success: function(data) {
             $('#schedule_employee').html('<option value="2"> Select all </option>');
                $.each(data.userdetail, function (key, value) {
                    $("#schedule_employee").append('<option value="' + value.id + '">' + value.name + '</option>');
                });

            },
       });
	});     
   
   });
        
 
          setTimeout(function() {
    	$('#success').hide();
     }, 3000);
</script>
</x-admin-layout>
