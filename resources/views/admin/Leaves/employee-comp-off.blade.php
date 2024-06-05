<?php 
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\RolesPermission;
?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="content container-fluid">
			<div class="page-head-box">
				<h3>Employee Comp - Off</h3>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Employee Comp - Off</li>
					</ol>
				</nav>
			</div>
		</div>
		     <div class="pageFilter mb-3">
                <div class="row leaves">
                    <div class="col-xl-9 col-lg-9 col-md-8">
                      <form  method="get" action="">
                        <div class="leftFilters">
							  <div class="col-lg-4 col-md-6 col-sm-6 form-group mt-0">
                                <label for="floatingSelect">Employee</label>
                                    <select class="form-select employee_id js-select2"  name="user_id" aria-label="Floating label  select example">
                                        <option value="all">All</option>
                                        @foreach($employees as $emp)
                                        <option value="{{$emp['_id']}}" {{ ($searchEmployee == $emp['_id']) ? 'selected' : '' }}>{{$emp['first_name']}} {{$emp['last_name']}}(#{{$emp['employee_id']}}) </option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            <div class="col-xl-2 col-lg-2 form-group mt-0">
                            <label for="floatingInput">From</label>
                                <input type="date" class="form-control leaves" name="fromsearch_date" value="{{$searchFromDate}}">
                                
                            </div>

                            <div class="col-xl-2 col-lg-2 form-group mt-0">
                            <!-- <div class="col-xl-3 col-lg-2 col-sm form-group"> -->
                            <label for="floatingInput">To</label>
                                <input type="date" class="form-control leaves" name="tosearch_date" value="{{$searchToDate}}">
                                
                            </div>
 							<div class="col-xl-2 col-lg-2 col-sm buttons leavedBtns">
                             <!-- <div class="col-xl col-lg-2 col-sm"> -->
                                <button type="submit" value="Submit" class="btn btn-search leaves me-2"><img src="images/iconSearch.svg" /> Search here</button>
                                <button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("employee-comp-off") }}'" style="cursor:pointer">Reset</button>
                                 
                            </div>
                            </div>
                        </form>
                    
                         </div>
                        <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                         @if((Auth::user()->user_role==0) || (!empty($role)&&($role->name!="Management")))
                        <div class="col-xl-3">
                            <div class="rightFilter empLeaves">
                                <a class="addBtn leaves"  data-bs-toggle="modal" data-bs-target="#addCompOff" onclick="$('.error').html('')"><i class="fa-solid fa-plus"></i> Add Comp - off</a>
                            </div>
                    </div>
                    @endif
                            
                    </div>
                     @if((Auth::user()->user_role==0)||(Permission::userpermissions('create',2, 'leaves') || RolesPermission::userpermissions('create',2, 'leaves')))
                    <!-- <div class="col-xl-5"> -->
                   
                    @endif
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
									<th>
										<div class="form-check d-flex justify-content-center">
											<input class="form-check-input select_all_ids"
												type="checkbox" value="" id="flexCheckDefault">
										</div>
									</th>
									<th>Employee ID</th>
								    <th>Employee</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Reason</th>
                                    <th>Updated By</th>
                                    <th>Leave Status</th>
                                    <th>Action</th>
								</tr>

							</thead>
							<tbody>
							
								@if(empty($employeeCompOff) || count($employeeCompOff) <= 0)
								<tr>
									<td class="text-center" colspan="9">No Data Found</td>
								</tr>
								@else 
								@foreach($employeeCompOff as $employ)
								<tr>
								<td>
									<div class="form-check d-flex justify-content-center">
										<input class="form-check-input userDelete" name="single_ids"
											type="checkbox" value="{{$employ->_id}}"
											id="flexCheckDefault">
									</div>
								</td> 
                                             <td>{{@$employ->getleaveemployee_name()->employee_id}}</td>
                                             <td>
                                             <div class="user-name">
                                                    <div class="user-image">
                                                        <img src="{{@$employ->getleaveemployee_name()->photo}}" alt="user-img" />
                                                    </div>
                                                    <span class="green"><a href="employee-profile/{{$employ->getleaveemployee_name()->_id}}">{{@$employ->getleaveemployee_name()->first_name}} {{@$employ->getleaveemployee_name()->last_name}}</a></span>
                                                </div>
                                                </td>
                                                <td>{{date('d M Y',($employ->str_from_date))}}</td>
                                                <td>{{date('d M Y',($employ->str_to_date))}}</td>
                                                  <td>{{$employ->reason}}</td>
                                             
                                   <td>
                                        @if($employ->updatedBy()) 
                                            <a style="color:#8dc542; font-weight:700"; href="{{url('/employee-profile')}}/{{$employ->updatedBy()->_id}}">{{$employ->updatedBy()->first_name.' '.$employ->updatedBy()->last_name}}</a>
                                        @else
                                        No Action
                                        @endif
                                     </td>
                                           @php
                                        if($employ->status==1){
                                         $employ->status='Pending';
                                        } 
                                        if($employ->status==2){
                                        $employ->status='Approved';
                                        }
                                        if($employ->status==3){
                                         $employ->status='Rejected';
                                         }
                                     @endphp 
                                     <td>{{$employ->status}}</td>
                                     <td>
                                         <div class="actionIcons">
                                             <ul>
                                                 @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                                @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) 

                                                    <li><a class="edit" data-bs-toggle="modal"  onclick="editCompoff('{{$employ->id }}')"  href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                 @endif
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) )
                                                 
                                                    
          							 			 @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
                                                 <li><button class="bin compoffDelete policyDelete" type="button "  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$employ->id}}"><i class="fa-regular fa-trash-can"></i></button></li>
                                                 @endif
                                                 @endif
                                             </ul>
                                         </div>
                                     </td>
                                             
																@endforeach @endif
								</tr>
							</tbody>
						</table>
						 {{$employeeCompOff->links('pagination::bootstrap-4')}}
						
					</div>
				</div>
			</div>
			</div>
			
			<div class="modal fade" id="addCompOff" tabindex="-1" aria-labelledby="addCompOffLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="addCompOffLabel">Add Comp - off</h1>
        <button type="button" class="btn-close roundedclose" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" class="px-3" enctype="multipart/form-data" id="addEmployeeComp"> 
           
                    <div class="row">
                     <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                        @if((Auth::user()->user_role==0) || ($role->name=='HR'))
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Member</label>
                                <select class="form-control" name="name" id="all_members">
                                    <option value="">Choose Member</option>
                                    @foreach($employees as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}} ({{$user->employee_id}})</option>
                                    @endforeach
                                </select>
                                 <span class="text-danger error" id="error_name"></span> 
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control" name="leave_type" id="leave_types" >
                                <option value="comp_off">Comp Off</option>
                                </select>
                                      <span class="text-danger error" id="error_leave_type"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>From</label>
                                <input   type="date" name="from_date" class="form-control " placeholder="Choose Date" />
                                 <span class="text-danger error" id="error_from_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="from_sessions" id="from_sessions">
									<option value="">Select Session</option>
									<option value="1">Session 1</option>
									<option value="2">Session 2</option>
								</select> <span
									class="text-danger error" id="error_from_sessions"></span>
							</div>
						</div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date"  name="to_date" class="form-control"  id="txtDate" placeholder="Choose Date" />
                            </div>
                                 <span class="text-danger error" id="error_to_date"></span> 
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="to_sessions" id="to_sessions">
									<option value="">Select Session</option>
									<option value="1">Session 1</option>
									<option value="2">Session 2</option>
								</select> <span
									class="text-danger error" id="error_to_sessions"></span>
							</div>
						</div>
                        <div class="col-lg-6">
                        <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        ?>
                            @if(((Auth::user()->user_role==0) || ($role->name=='HR')))
                            <div class="form-group">
                                <label>Status </label>
                                <select class="form-control" name="status" id="status">
                                    <option value="" selected >Select Status</option>
                                    <option value="1">Pending</option>
                                    <option value="2">Approve</option>
                                    <option value="3">Reject</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                        @if(((Auth::user()->user_role==0) || ($role->name=='HR')) )
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" placeholder="Enter Reason"></textarea>
                                <span class="text-danger error" id="error_reason"></span> 
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn commonButton ml-1 modalsubmiteffect">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>     
			
<div class="modal fade" id="updateCompModal" tabindex="-1" aria-labelledby="updateleaveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="updateModalLabel">Employee Comp - Off</h1>
        <button type="button" class="btn-close roundedclose" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" class="px-3" enctype="multipart/form-data" id="editCompOff"> 
                                 			<input type="hidden" name="employee_id" id="employee_id" value="">
           
                    <div class="row">
                     <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                        @if((Auth::user()->user_role==0)|| ($role->name=='HR'))
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose Member</label>
                                 <input type="text" id="single_employee" class="form-control" value="" disabled>
                                 <span class="text-danger error" id="error_name"></span> 
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control" name="leave_type" id="edit_leave_types" disabled >
                                    <option value="comp_off">Comp Off</option>
                                </select>
                                      <span class="text-danger error" id="errors_leave_type"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>From</label>
                                <input   type="date" name="from_date" id="editDate" class="form-control " value="" placeholder="Choose Date" disabled/>
                                 <span class="text-danger error" id="errors_from_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="to_sessions" id="edit_from_sessions" disabled>
									<option value="">Select Session</option>
									<option value="1">Session 1</option>
									<option value="2">Session 2</option>
								</select> <span
									class="text-danger error" id="error_to_sessions"></span>
							</div>
						</div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>To</label>
                                <input type="date"  name="to_date" class="form-control"  id="toDate" value="" placeholder="Choose Date" disabled/>
                                  <span class="text-danger error" id="errors_to_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="to_sessions" id="edit_to_sessions" disabled>
									<option value="">Select Session</option>
									<option value="1">Session 1</option>
									<option value="2">Session 2</option>
								</select> <span
									class="text-danger error" id="error_to_sessions"></span>
							</div>
						</div>
                        <div class="col-lg-6" id="statusCheck">
                        <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        ?>
                            @if(((Auth::user()->user_role==0) || ($role->name=='HR') || ($role->name=='Management') ))
                            <div class="form-group">
                                <label>Status </label>
                                <select class="form-control" name="status" id="edit_status">
                                    <option value="" selected>Select Status</option>
                                     <option value="1">Pending</option>
                                    <option value="2">Approve</option>
                                    <option value="3">Reject</option>
                                </select>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                        @if(((Auth::user()->user_role==0)))
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" placeholder="Enter Reason" id="editReason" disabled></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @else
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" placeholder="Enter Reason" id="editReason" disabled></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-group mt-4 addoffmodalfoot">
                            <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>

                                <button class="btn commonButton ml-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
      </div>
    </div>
			
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$('#deleteAll').hide();

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

$(function(){
  $('#all_members').select2({
    dropdownParent: $('#addCompOff')
  });
}); 

$(function(){
  $('#leave_types').select2({
    dropdownParent: $('#addCompOff')
  });
}); 

$(function(){
  $('#status').select2({
    dropdownParent: $('#addCompOff')
  });
}); 

 $(function(){
  $('#from_sessions').select2({
    dropdownParent: $('#addCompOff')
  });
}); 


 $(function(){
  $('#to_sessions').select2({
    dropdownParent: $('#addCompOff')
  });
}); 

 $(function(){
  $('#edit_status').select2({
    dropdownParent: $('#updateCompModal')
  });
}); 

 $(function(){
  $('#edit_from_sessions').select2({
    dropdownParent: $('#updateCompModal')
  });
}); 

 $(function(){
  $('#edit_to_sessions').select2({
    dropdownParent: $('#updateCompModal')
  });
}); 







 $('#addEmployeeComp').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addEmployeeComp')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
      			if($.isEmptyObject(data.errors)){      			
                window.location = "/employee-comp-off";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });

function editCompoff(id)
{
  $('#updateCompModal').modal('show');
  $('#employee_id').val(id);
  var id_ = $('#employee').val();
  
  
  
      $.ajax({
                type: 'post',
                url: "{{ route('editEmployeeComp')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                console.log(data.id);
                console.log('{{Auth::user()->_id}}');
                  if(data.id==='{{Auth::user()->_id}}')
                  {
                  console.log(true)
                  	$('#statusCheck').hide();
                  }else
                  {
                  	$('#statusCheck').show();
                  }
                $('#single_employee').val(data.employeeName);
                $('#edit_leave_types').val(data.leave_type).trigger('change');
                $('#editDate').val(data.str_from_date);
                $('#toDate').val(data.str_to_date);
                $('#edit_status').val(data.status).trigger('change');
                $('#editReason').val(data.reason);
                 $('#edit_status').val(data.status).trigger('change');
                $('#edit_to_sessions').val(data.to_sessions).trigger('change');
                $('#edit_from_sessions').val(data.from_sessions).trigger('change');
                $('.error').html('')
                
                },
            });

}
$(document).ready(function() {
  $('#editCompOff').submit(function(e) {
            e.preventDefault();
            var id =  $('#employee_id').val();
            var employeeId = $('#single_employee').val();
            var leave_type = $('#edit_leave_types').val();
           	var from_date = $('#editDate').val();
           	var to_date = $('#toDate').val();
           	var status = $('#edit_status').val();
           	var reason =$('#editReason').val();
            $.ajax({
                type: 'post',
                url: "{{ route('updateCompOff')}}",
                data:  "leave_type="+leave_type+"&from_date="+from_date+"&to_date="+to_date+"&employeeId="+employeeId+"&status="+status+"&reason="+reason+"&id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                 $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/employee-comp-off";
                }else{
                console.log(data);
                	$.each( data.errors, function( key, value ) {
                		$('#errors_'+key).html(value)
                	})
                }
                },
            });
        });
});

 $(".compoffDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('deleteComp')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });

$('#deleteAll').click(function(e){
		e.preventDefault();
		var all_ids = [];
        $('input:checkbox[name="single_ids"]:checked').each(function(){
        	all_ids.push($(this).val());
       });

   		 $.ajax({
                type: 'post',
                url: "{{ route('allCompOffDelete')}}",
                data: "all_ids="+all_ids+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                   location.reload(true);
                }
            });
});
</script>
</x-admin-layout>