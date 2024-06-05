<?php 
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\RolesPermission;
use App\Models\Role;

?>
<x-admin-layout>

<div class="page-wrapper">
	<div class="content container-fluid">
	
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
									<th>Employee ID</th>
								    <th>Employee</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Reason</th>
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
                                             
                                           @php
                                        if($employ->status==1){
                                         $status='Pending';
                                        } 
                                        if($employ->status==2){
                                        $status='Approved';
                                        }
                                        if($employ->status==3){
                                         $status='Rejected';
                                         }
                                     @endphp 
                                     <td>{{$status}}</td>
                                     <td>
                                         <div class="actionIcons">
                                             <ul>
                                                 @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) 
                                                 @if($employ->status != 2)
                                                    <li><a class="edit" data-bs-toggle="modal"  onclick="editEmployeeCompoff('{{$employ->id }}')"  href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                 @endif
                                                 @endif
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) )
                                                 
                                                    
          							 			 @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
          							 			 @if($employ->status != 2)
                                                 	<li><button class="bin EmployeecompoffDelete policyDelete" type="button "  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$employ->id}}"><i class="fa-regular fa-trash-can"></i></button></li>
                                                 @endif
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
			
			<div class="modal fade" id="updateEmployeeCompModal" tabindex="-1" aria-labelledby="updateleaveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModalLabel">Employee Comp - Off</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" class="px-3" enctype="multipart/form-data" id="UpdateEmployeeCompOff"> 
                                 			<input type="hidden" name="employee_id" id="employee_id" value="">
           
                    <div class="row">
                     <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Choose Member</label>
                                 <input type="text" id="single_employee" class="form-control" value="" disabled>
                                 <span class="text-danger error" id="error_name"></span> 
                            </div>
                        </div>
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
                            <div class="form-group mt-4">
                                <button class="btn commonButton modalsubmiteffect">Submit</button>
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

 $(function(){
  $('#edit_status').select2({
    dropdownParent: $('#updateEmployeeCompModal')
  });
  });

function editEmployeeCompoff(id)
{
$('#updateEmployeeCompModal').modal('show')
  $('#employee_id').val(id);
  var id_ = $('#employee').val();
  
  
   
      $.ajax({
                type: 'post',
                url: "{{ route('editMyEmployeeComp')}}",
                data: "id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                  if(data.id==='{{Auth::user()->_id}}')
                  {
                  console.log(true)
                  	$('#statusCheck').hide();
                  }else
                  {
                  	$('#statusCheck').show();
                  }
                console.log(data)
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
  $('#UpdateEmployeeCompOff').submit(function(e) {
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
                url: "{{ route('updateMyEmployeeCompOff')}}",
                data:  "leave_type="+leave_type+"&from_date="+from_date+"&to_date="+to_date+"&employeeId="+employeeId+"&status="+status+"&reason="+reason+"&id="+id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                 $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/my-employee-comp-off";
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

 $(".EmployeecompoffDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('deleteEmployeeCompOff')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });


</script>
</x-admin-layout>