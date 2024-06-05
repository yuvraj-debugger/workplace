<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Shift List</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Shift List
					</li>
				</ol>
			</nav>
		</div>
		@if(session('success'))
		<div class="alert alert-success alert-block" id="success">{{
			session('success') }}</div>
		@endif
		@if(session('info'))
			<div class="alert alert-danger" id="info">
				{{ session('info') }}
			</div>
		@endif
		<div class="pageFilter mb-3">
			<div class="row">

					<div class="col-md-6">
                 
                        <form  method="get" action="">
                            <div class="leftFilters">
                                <div class="col-lg-4 col-md-6 col-sm-6 form-group mt-0">
                                	<label for="floatingSelect">Shift</label>
                                    <select class="form-select employee_id js-select2"  name="search_shift" aria-label="Floating label  select example">
                                        <option value="all">All</option>
                                        @foreach($employeeShifts as $shift)
                                        <option value="{{$shift->shift_name}}" {{ ($searchShift == $shift->shift_name) ? 'selected' : '' }}>{{$shift->shift_name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- <button class="btn btn-search"><img src="{{ asset('/images/iconSearch.svg')}}" /> Search here</button> -->
                                <div class="col-lg-8 col-md-6 col-sm-6">
                                    <div class="buttons leavedBtns">
                                         <button type="submit" value="Submit" class="btn btn-search topLeaves me-2"><img src="images/iconSearch.svg" /> Search here</button>
                                         <button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("employee-shift") }}'">Reset</button>

                                    </div>
                                    <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5">
                                    	<button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("leaves") }}'">Reset</button>
                                    </div> -->
                                </div>    
                            </div>
                            
                        </form>
                    </div>
					<div class="col-md-6">
						<div class="rightFilter attendance">
						<a type="button" class="addBtn mt-3" data-bs-toggle="modal"
							data-bs-target="#assignShiftModal" onclick="$('.error').html('')">Assign Shifts </a>
						<a type="button" class="addBtn mt-3" data-bs-toggle="modal"
							data-bs-target="#myModal" onclick="$('.error').html('')"> Add
							Shifts </a>
					</div>
				</div>
			</div>
		</div>
		<div class="dashboardSection">
			<div class="dashboardSection__body">
				<div class="commonDataTable">
					<div class="table-responsive">
					 <div class="deleteSelection">
                                <a href="javascript:void(0);" id="deleteAll"  style="display: none;">Delete</a>
                            </div>
						<table class="table">
							<thead>
								<tr>
									<th><div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input select_all_ids"  type="checkbox" value="" id="flexCheckDefault"></div>
                                     </th>
									<th>Shift Name</th>
									<th>Min Start Time</th>
									<th>Start Time</th>
									<th>Max Start Time</th>
									<th>Min End Time</th>
									<th>End Time</th>
									<th>Max End Time</th>
									<th>Break Time</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							
							 @if(empty($employeeShifts) || count($employeeShifts) <= 0)
                                        <tr><td class="text-center" colspan="9">No Data Found</td></tr>
                                    @else
							 @foreach($employeeShifts as $key=>$employeeShift)
							<tr>
							
							<td> <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input userDelete"  name="single_ids" type="checkbox" value="{{$employeeShift->_id}}" id="flexCheckDefault">
                                                </div></td>
							<td>{{ucfirst($employeeShift->shift_name)}}</td>
							<td>{{$employeeShift->min_start_time}}</td>
							<td>{{$employeeShift->start_time}}</td>
							<td>{{$employeeShift->max_start_time}}</td>
							<td>{{$employeeShift->min_end_time}}</td>
							<td>{{$employeeShift->end_time}}</td>
							<td>{{$employeeShift->max_end_time}}</td>
							<td>{{$employeeShift->break_time}} Mins</td>
							<td><?=($employeeShift->status == '1') ? 'Active' :'Inactive';?></td>
							<td>
								<div class="actionIcons">
									<ul>
										<li><a class="edit" data-bs-toggle="modal"  onclick="editShift('{{ $employeeShift->id }}')"  href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
										
										
										<li><button class="bin shiftDelete policyDelete"  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$employeeShift->id}}"><i class="fa-regular fa-trash-can"></i></button></li>
									</ul>
								</div>
							</td>
							</tr>
							@endforeach
							@endif
							</tbody>
						</table>
						{{$employeeShifts->links()}}
					</div>
				</div>
			</div>
		</div>



		<div class="modal fade commonModalNew" id="myModal" tabindex="-1"
			aria-labelledby="leaveModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5 ml-auto">Add Shift</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal"
							aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form method="post" class="px-3" enctype="multipart/form-data"
							id="addShift">
							@csrf
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>Shift Name</label> <span class="text-danger">*</span><input
											type="text" id="shift_name" name="shift_name"
											class="form-control" /> <span class="text-danger error"
											id="error_shift_name"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Min Start Time</label> <span class="text-danger">*</span><input
											type="time" id="min_start_time" name="min_start_time"
											class="form-control " /> <span class="text-danger error"
											id="error_min_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Start Time</label><span class="text-danger">*</span> <input
											type="time" id="start_time" name="start_time"
											class="form-control " /> <span class="text-danger error"
											id="error_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max Start Time</label><span class="text-danger">*</span>
										<input type="time" id="max_start_time" name="max_start_time"
											class="form-control " /> <span class="text-danger error"
											id="error_max_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Min End Time</label><span class="text-danger">*</span>
										<input type="time" id="min_end_time" name="min_end_time"
											class="form-control " /> <span class="text-danger error"
											id="error_min_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>End Time</label><span class="text-danger">*</span> <input
											type="time" id="end_time" name="end_time"
											class="form-control" /> <span class="text-danger error"
											id="error_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max End Time</label><span class="text-danger">*</span>
										<input type="time" id="max_end_time" name=max_end_time
											class="form-control " /> <span class="text-danger error"
											id="error_max_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Break Time (In Minutes)</label>
										<select  class="form-control js-select2" name="break_time" id="break_time">
                                         <option value="">Select Minute </option>
                                          <option value="15">15</option>
                                          <option value="30">30</option>
                                          <option value="45">45</option>
                                          <option value="60">60</option>
                                        </select>
										<span
											class="text-danger error" id="error"></span>
									</div>
								</div>
								<br />
								<div class="col-lg-6">
									<div class="form-group">
										<label>Week</label>
										<div class="wday-box">
											<label class="checkbox-inline">
												<input type="checkbox" value="monday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">M</span>
											</label> 
											<label class="checkbox-inline">
												<input type="checkbox" value="tuesday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">T</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="wednesday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">W</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="thursday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">T</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="friday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">F</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="saturday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">S</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="sunday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">S</span>
											</label>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="add_note" name="add_note"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>

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



<div class="modal fade commonModalNew" id="updateShiftModal" tabindex="-1" aria-labelledby="updateShiftModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="updateShiftModalLabel">Edit Shift</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="updateShift">
					@csrf
				<input type="hidden" name="shift_id"  id="shift_id" value="">
					<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>Shift Name</label> <span class="text-danger">*</span><input
											type="text" id="edit_shift_name" name="shift_name"
											class="form-control" /> <span class="text-danger error"
											id="edit_error_shift_name"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Min Start Time</label> <span class="text-danger">*</span><input
											type="time" id="edit_min_start_time" name="min_start_time"
											class="form-control " /> <span class="text-danger error"
											id="error_min_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Start Time</label><span class="text-danger">*</span> <input
											type="time" id="edit_start_time" name="start_time"
											class="form-control " /> <span class="text-danger error"
											id="error_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max Start Time</label><span class="text-danger">*</span>
										<input type="time" id="edit_max_start_time" name="max_start_time"
											class="form-control " /> <span class="text-danger error"
											id="error_max_start_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Min End Time</label><span class="text-danger">*</span>
										<input type="time" id="edit_min_end_time" name="min_end_time"
											class="form-control " /> <span class="text-danger error"
											id="error_min_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>End Time</label><span class="text-danger">*</span> <input
											type="time" id="edit_end_time" name="end_time"
											class="form-control" /> <span class="text-danger error"
											id="error_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Max End Time</label><span class="text-danger">*</span>
										<input type="time" id="edit_max_end_time" name=max_end_time
											class="form-control " /> <span class="text-danger error"
											id="error_max_end_time"></span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Break Time (In Minutes)</label>
										
										<select  class="form-control js-select2" name="break_time" id="edit_break_time">
                                          <option value="">Select Minute </option>
                                          <option value="15">15</option>
                                          <option value="30">30</option>
                                          <option value="45">45</option>
                                          <option value="60">60</option>
                                        </select>
										<span
											class="text-danger error" id="error"></span>
									</div>
								</div>
								<br />
								<div class="col-lg-6">
									<div class="form-group">
										<label>Week(s)</label>
										<div class="wday-box">
											<label class="checkbox-inline">
												<input type="checkbox" value="monday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">M</span>
											</label> 
											<label class="checkbox-inline">
												<input type="checkbox" id="tuesday" value="tuesday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">T</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="wednesday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">W</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="thursday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">T</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="friday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">F</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="saturday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">S</span>
											</label>
											<label class="checkbox-inline">
												<input type="checkbox" value="sunday" name="week[]" class="days recurring form-check-input">
												<span class="checkmark">S</span>
											</label>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_add_note" name="add_note"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>

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



<div class="modal fade commonModalNew" id="assignShiftModal" tabindex="-1" aria-labelledby="assignShiftModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="assignShiftModalLabel">Assign Shifts</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="addSchedule">
				@csrf
				<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Department </label><span class="text-danger">*</span><select class="form-control js-select2"
										name="schedule_department" id="schedule_department">
										<<option value="1">Select All</option>
										@foreach($allDepartment as $department)
										<option value="{{$department->_id}}">{{$department->title}}</option>
										@endforeach
									</select> <span class="text-danger error" id="schedule_errors_schedule_department"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Employee </label><span class="text-danger">*</span>
									<select class="form-control js-select2"
										name="schedule_employee" id="schedule_employee">
										<option value="1">Select All</option>
									</select> <span class="text-danger error" id="schedule_errors_schedule_employee"></span>
								</div>
							</div>
								<div class="col-lg-6">
									<div class="form-group mt-0">
										<label for="floatingInput">From</label> <input type="date"
											class="form-control" id="from_date" placeholder="Date"
											name="schdule_from_date" value="">
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group mt-0">
										<label for="floatingInput">To</label> <input type="date"
											class="form-control" id="to_date" placeholder="Date"
											name="schdule_to_date" value="">
									</div>
								</div>
							
							<div class="col-lg-6">
								<div class="form-group">
									<label>Shifts </label> <span class="text-danger">*</span><select class="form-control js-select2"
										name="schedule_shift" id="schedule_shift">
										<option value=""></option>
										@foreach($employeeShifts as $shift)
										<option value="{{$shift->_id}}" >{{$shift->shift_name}}</option>
										@endforeach
									</select> <span class="text-danger error" id="schedule_errors_schedule_shift"></span>
								</div>
							</div>
								<div class="col-lg-6">
								<div class="form-group">
									<label>Min Start Time</label><input
										type="time" id="schedule_min_start_time" name="schedule_min_start_time"
										class="form-control "  /> <span class="text-danger error"
										id="schedule_errors_schedule_min_start_time"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Start Time</label> <input
										type="time" id="schedule_start_time" name="schedule_start_time"
										class="form-control "  /> <span class="text-danger error"
										id="schedule_errors_schedule_start_time"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Max Start Time</label>
									<input type="time" id="schedule_max_start_time" name="schedule_max_start_time"
										class="form-control "  /> <span class="text-danger error"
										id="schedule_errors_schedule_max_start_time"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Min End Time</label>
									<input type="time" id="schedule_min_end_time" name="schedule_min_end_time"
										class="form-control "   /> <span class="text-danger error"
										id="schedule_errors_schedule_min_end_time"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>End Time</label> <input
										type="time" id="schedule_end_time" name="schedule_end_time"
										class="form-control"  /> <span class="text-danger error"
										id="schedule_errors_schedule_end_time"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Max End Time</label>
									<input type="time" id="schedule_max_end_time" name=schedule_max_end_time
										class="form-control " /> <span class="text-danger error"
										id="schedule_errors_schedule_max_end_time"></span>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Break Time (In Minutes)</label>
									<select  class="form-control js-select2" name=schedule_break_time id="schedule_break_time">
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
							<div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="notes_schedule" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
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
</x-admin-layout>
<script>
$('.select_all_ids').click(function(){
    $('.userDelete').prop('checked',$(this).prop('checked'));
});

$('input[type=checkbox]').click(function(){
    var check=0;
    $('input[type=checkbox]').each(function () {
        checked=$(this).is(":checked");
        console.log(checked);
        if(checked)
        {
        	check=1
        }
    });
    
    
    if(check)
    {
    	$('#deleteAll').show();
    }
    else
    {
    	$('#deleteAll').hide();
    }
});



$('#deleteAll').click(function(e){
		e.preventDefault();
		var all_ids = [];
        $('input:checkbox[name="single_ids"]:checked').each(function(){
        	all_ids.push($(this).val());
       });

   		 $.ajax({
                type: 'post',
                url: "{{ route('multipleDeleteShift')}}",
                data: "all_ids="+all_ids+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                   location.reload(true);
                }
            });
});

 $(function(){
  $('#break_time').select2({
    dropdownParent: $('#myModal')
  });
}); 

 $(function(){
  $('#repeat_every').select2({
    dropdownParent: $('#myModal')
  });
}); 
$(function(){
  $('#edit_repeat_every').select2({
    dropdownParent: $('#updateShiftModal')
  });
}); 
$(function(){
  $('#schedule_department').select2({
    dropdownParent: $('#assignShiftModal')
  });
}); 


$(function(){
  $('#schedule_employee').select2({
    dropdownParent: $('#assignShiftModal')
  });
}); 


$(function(){
  $('#schedule_shift').select2({
    dropdownParent: $('#assignShiftModal')
  });
}); 
 $(document).ready(function() {
  $('#addShift').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addEmployeeShift')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			 window.location = "/employee-shift";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
});


function editShift(id)
{
  $('#updateShiftModal').modal('show');
  $('#shift_id').val(id);
  $.ajax({
                type: 'post',
                url: "{{ route('editEmployeeShift')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#edit_shift_name').val(data.shift_name);
                $('#edit_min_start_time').val(data.min_start_time);
                $('#edit_start_time').val(data.start_time);
                $('#edit_max_start_time').val(data.max_start_time);
                $('#edit_min_end_time').val(data.min_end_time);
                $('#edit_end_time').val(data.end_time);
                $('#edit_max_end_time').val(data.max_end_time);
                $('#edit_break_time').val(data.break_time).trigger('change');
                $('#edit_recurring_shift').val(data.recurring_shift).is(":checked");
                
                if(data.recurring_shift == "off"){
                  $('#edit_recurring_shift').attr("checked",false);
                }else{
                 	$('#edit_recurring_shift').attr("checked",true);
                 }
                $('#edit_repeat_every').val(data.repeat_every).trigger('change');
                data.week.split(',').forEach(function(item){
                	$("input[value='" + item + "']").prop('checked', true);
                })
                $('#edit_add_note').val(data.add_note);
                $('.error').html('')
                },
            });
}



$('#updateShift').submit(function(e) {
            e.preventDefault();
                    var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('updateEmployeeShift')}}",
                data:  formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/employee-shift";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#edit_error_'+key).html(value)
                	})
                }
                },
            });
        });


 $(".shiftDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('shiftDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });
        
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
                url: "{{ route('addScheduleShift')}}",
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
            console.log(data);
             $('#schedule_employee').html('<option value="2">Select All</option>');
             
                $.each(data.userdetail, function (key, value) {
                    $("#schedule_employee").append('<option value="' + value
                        .id + '">' + value.name + '</option>');
                });

            },
       });
	});     
   
   });     
        
        
        
        
        
        
        
        
        
        
        
   setTimeout(function() {
	$('#info').hide();
 }, 3000);
    setTimeout(function() {
    	$('#success').hide();
     }, 3000);
</script>


