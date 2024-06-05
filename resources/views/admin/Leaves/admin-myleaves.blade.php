 <?php
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\RolesPermission;
use App\Models\User;
?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Leaves</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Leaves</li>
				</ol>
			</nav>
		</div>
		@if(session('info'))
		<div class="alert alert-danger alert-block" id="danger">{{
			session('info') }}</div>
		@endif @if(session('success'))
		<div class="alert alert-success alert-block" id="success">{{
			session('success') }}</div>
		@endif
		 

     <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xxl-10 col-xl-10 ">
                      <form  method="get" action="">
                        <div class="leftFilters employeeLeavesLeft">
                            <div class="row">
                            <div class="col-xl-2 form-group leavesmdcolumn">
                                <label for="floatingSelect">Leave Type</label>
                                <select class="form-select leave_type js-select2" id="floatingSelect" name="search_leave_type" aria-label="Floating label  select example">
                                    <option value="">All</option>
                                    <option value="1" {{ ($searchLeave == '1') ? 'selected' : '' }}>Casual Leave</option>
                                    <option value="2" {{ ($searchLeave == '2') ? 'selected' : '' }} >Sick Leave</option>
                                    <option value="3" {{ ($searchLeave == '3') ? 'selected' : '' }}>Earned Leave</option>
                                    <option value="4" {{ ($searchLeave == '4') ? 'selected' : '' }}>Loss Of Pay</option>
                                    <option value="5" {{ ($searchLeave == '5') ? 'selected' : '' }}>Comp - Off</option>
                                    <option value="6" {{ ($searchLeave == '6') ? 'selected' : '' }}>Bereavement Leave</option>
                                    <option value="7" {{ ($searchLeave == '7') ? 'selected' : '' }}>Maternity Leave</option>
                                    <option value="8" {{ ($searchLeave == '8') ? 'selected' : '' }}>Paternity Leave</option>
                                </select>
                            </div>
        
                            <div class="col-xl-2 form-group leavesmdcolumn">
                                <label for="floatingSelect">Leave Status</label>
                                <select class="form-select leave_status js-select2" id="floatingSelect"  name="search_status"  aria-label="Floating label select example">
                                  <option  value="" selected>All</option>
                                  <option value="1" {{ ($searchStatus == '1') ? 'selected' : '' }}>Pending </option>
                                  <option value="2" {{ ($searchStatus == '2') ? 'selected' : '' }}>  Approved</option>
                                  <option value="3" {{ ($searchStatus == '3') ? 'selected' : '' }}> Rejected</option>
                                </select>
                            </div>

                            <div class="col-xl-2 form-group leavesmddatecolumn">
                                <label for="floatingInput">From</label>
                                <input type="date" class="form-control" name="fromsearch_date" value="{{$searchFromDate}}">
                            </div>

                            <div class="col-xl-2 form-group leavesmddatecolumn">
                                <label for="floatingInput">To</label>
                                <input type="date" class="form-control" name="tosearch_date" value="{{$searchToDate}}">
                            </div>
 							<div class="col-xl-4">
                                <div class="leavebuttonsbox">

                                 <button type="submit" value="Submit" class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button>
                                 <button type="button" value="reset" class="btn btn-search resetleaves" onclick="window.location='{{ url("myleaves") }}'">Reset</button>
                                </div>

                                </div>
                            <!-- <div class="col-sm">
                            </div> -->
                            </div>
                        </form>
                        <div class="col-sm">
                            <a href="javascript:void(0);" class="btn btn-danger" id="deleteAll"  style="display: none;">Delete</a>
                        </div>
                         </div>
                            
                    </div>
                    <!-- <div class="col-xl-5"> -->
                    <?php 
                    
                    $role=Role::where('_id',Auth::user()->user_role)->first();
                    
                    ?>
                    <div class="col-xxl-2 col-xl-2">
                        <div class="rightFilter userleaves">
                            <a class="addBtn userleavesbutton"  data-bs-toggle="modal" data-bs-target="#leaveModal" style="cursor: pointer;" onclick="$('.error').html('')"><i class="fa-solid fa-plus"></i> Add Leave</a>
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
                                    <th>Leave Type</th>
                                    <th>Reason</th>
                                    <th>Updated By</th>
                                    <th>Leave Status</th>
                                    <th></th>
								</tr>

							</thead>
							<tbody>
								@if(empty($leaves) || count($leaves) <= 0)
								<tr>
									<td class="text-center" colspan="9">No Data Found</td>
								</tr>
								@else 
								@foreach($leaves as $employ)
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
                                                    <span class="green"><a href="profile/{{$employ->getleaveemployee_name()->_id}}">{{@$employ->getleaveemployee_name()->first_name}} {{@$employ->getleaveemployee_name()->last_name}}</a></span>
                                                </div>
                                              
                                                <td>{{! empty ($employ->str_from_date) ? date('d M Y',($employ->str_from_date)) : ''}}</td>
                                                <td>{{! empty ($employ->str_from_date) ? date('d M Y',($employ->str_to_date)) : ''}}</td>
                                                  @php
                                            if($employ->leave_type==1){
                                             $employ->leave_type='Casual leave';
                                            } 
                                            if($employ->leave_type==2){
                                            $employ->leave_type='Sick leave';
                                            }
                                            if($employ->leave_type==3){
                                             $employ->leave_type='Earned leave';
                                             }
                                             if($employ->leave_type==4){
                                             $employ->leave_type='LOP leave';
                                             }
                                              if($employ->leave_type =='5'){
                                               $employ->leave_type='Comp Off';
                                             }
                                              if($employ->leave_type =='6'){
                                               $employ->leave_type='Bereavement Leave';
                                             }
                                              if($employ->leave_type =='7'){
                                               $employ->leave_type='Maternity Leave';
                                             }
                                               if($employ->leave_type =='8'){
                                               $employ->leave_type='Paternity Leave';
                                             }
                                             if($employ->leave_type =='9'){
                                               $employ->leave_type='Emergency Leave';
                                             }
                                         @endphp
                                            <td>{{($employ->leave_type)}}</td>
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
                                         if($employ->status==4){
                                         $status='Withdraw';
                                         }
                                     @endphp 
                                     
                                       <td>
                                        @if($employ->updatedBy()) 
                                            <a style="color:#8dc542; font-weight:700"; href="{{url('/profile')}}/{{$employ->updatedBy()->_id}}">{{$employ->updatedBy()->first_name.' '.$employ->updatedBy()->last_name}}</a>
                                        @else
                                        No Action
                                        @endif
                                     </td>
                                     <td><span class="tags approve">{{($status)}}</span></td>
                                     @if(($employ->status != 4) &&	 ($employ->status != 2) && ($employ->status != 3))
                                      <td>
                                     <a type="button" href="{{url('/withdraw-leave')}}/{{$employ->id}}" onclick="confirm('Are you sure you want to withdraw this application?') || event.stopImmediatePropagation()"><span class="approvebutton">Withdraw</span></a>
                                     </td>
                                     @endif
                                      @if(((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) || ((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) ))
                                     <td>
                                         <div class="actionIcons">
                                             <ul>
                                                 @php
                                                  $role = Role::where('_id', Auth::user()->user_role)->first();
                                                 @endphp
                                                @if((Auth::user()->user_role==0)||(Permission::userpermissions('update',2, 'leaves')|| RolesPermission::userpermissions('update',2, 'leaves')) ) 

                                                    <li><a class="edit" data-bs-toggle="modal"  onclick="editmyLeave('{{$employ->id }}')"  href="javascript:void(0);"><i class="fa-solid fa-pen"></i></a></li>
                                                 @endif
                                                 @if((Auth::user()->user_role==0)||(Permission::userpermissions('delete',2, 'leaves') || RolesPermission::userpermissions('delete',2, 'leaves')) )
                                                 
                                                    
          							 			 @if(!empty($role)&&($role->name!='Employee') || (Auth::user()->user_role==0) || (!empty($role)&&($role->name=='HR')))
                                                 <li><button class="bin leaveDelete policyDelete" type="button "  onclick="confirm('Are you sure you want to delete this Records?') || event.stopImmediatePropagation()" data-id="{{$employ->id}}"><i class="fa-regular fa-trash-can"></i></button></li>
                                                 @endif
                                                 @endif
                                             </ul>
                                         </div>
                                     </td>
                                  
                                     
                                     @endif
								</tr>
								
								@endforeach @endif
							</tbody>
						</table>
						 {{$leaves->links('pagination::bootstrap-4')}}
						
					</div>
				</div>
			</div>
		</div>


	</div>
	
<div class="modal fade" id="leaveModal" tabindex="-1"
	aria-labelledby="leaveModalLabel" aria-hidden="true">
	
	<div class="modal-dialog">
	
		<div class="modal-content">
		
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="updateModalLabel">Add leave</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<div class="modal-body">
			<div class="loader" id="loader" style="display:none;">
                    <div class="loaderInner">
                        <img src="{{ asset('images/loading2.gif') }}">
                    </div>
                </div>
		        <span class="text-danger error" id="casual_error"></span>
		        
		        
		        
				<form method="post" class="px-3" enctype="multipart/form-data"
					id="myLeave">
					@csrf
					           			<input type="hidden" name="user_id" id="user_id" value="<?=Auth::user()->id?>">
					
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Leave Type</label> <select class="form-control"
									name="leave_type" id="leave_types">
									<option value="">Select Leave</option>
									<option value="1">Casual Leave</option>
									<option value="2">Sick Leave</option>
									 <?php 
									$user = User::where('_id',Auth::user()->id)->first();
									if((strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime('+24months', strtotime($user->joining_date)))))){
									    ?>
									<option value="3">Earned Leave</option>
									<?php }?>
									<option value="4">Loss Of Pay</option>
									<option value="5">Comp - Off</option>
									<option value="6">Bereavement Leave</option>
									 <?php 
									$user = User::where('_id',Auth::user()->id)->first();
									if((strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime('+18months', strtotime($user->joining_date))))) && ($user->gender == 'female')){
									    ?>
                                    <option value="7">Maternity Leave</option>
                                    <?php 	}
									?>
                                    <?php 
									$user = User::where('_id',Auth::user()->id)->first();
									if((strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime('+18months', strtotime($user->joining_date))))) && ($user->gender == 'male')){
									    ?>
									    <option value="8">Paternity Leave</option>
								<?php 	}
									?>
                                    <option value="9">Emergency Leave</option>
								</select> <span class="text-danger error" id="error_leave_type"></span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Reporting Manager</label> <input type="text" name="reporting_manager"
									class="form-control" id="reporting_manager"  disabled value="{{! empty($userManager) ? $userManager->first_name.' '.$userManager->last_name : '';}}"/>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>From</label> <input type="date" name="from_date"
									class="form-control " placeholder="Choose Date" /> <span
									class="text-danger error" id="error_from_date"></span>
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
								<label>To</label> <input type="date" name="to_date"
									class="form-control" id="txtDate" placeholder="Choose Date" />
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

                        $role = Role::where('_id', Auth::user()->user_role)->first();
                        ?>
                            @if(((Auth::user()->user_role==0)))
                            <div class="form-group">
								<label>Status </label> <select class="form-control"
									name="status" id="status">
									<option value="1" selected>Select Status</option>
									<option value="2">Approve</option>
									<option value="3">Reject</option>
								</select> @error('status') <span class="text-danger">{{ $message
									}}</span> @enderror
							</div>
							@endif
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Reason</label>
								<textarea class="form-control" name="reason"
									placeholder="Enter Reason"></textarea>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group mt-4">
								<button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
								<button class="btn commonButton modalsubmiteffect">Submit</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="updateMyleaveModal" tabindex="-1" aria-labelledby="updateMyleaveModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateMyModalLabel">Edit leave</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" class="px-3" enctype="multipart/form-data" id="updateMyLeave"> 
                                 			<input type="hidden" name="employee_id" id="update_employee_id" value="">
           
                    <div class="row">
                     <?php 
                        
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        
                        ?>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Member</label>
                                 <input type="text" id="single_employee" class="form-control" value="" disabled >
                                 <span class="text-danger error" id="error_name"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control" name="leave_type" id="edit_leave_types"  >
                                    <option value="">Select Leave</option>
                                    <option value="1">Casual Leave</option>
                                    <option value="2">Sick Leave</option>
                                    <option value="3">Earned Leave</option>
                                    <option value="4">Loss Of Pay</option>
                                	<option value="5">Comp - Off</option>
									<option value="6">Bereavement Leave</option>
                                    <option value="7">Maternity Leave</option>
                                    <option value="8">Paternity Leave</option>
                                </select>
                                      <span class="text-danger error" id="errors_leave_type"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>From</label>
                                <input   type="date" name="from_date" id="editDate" class="form-control " value="" placeholder="Choose Date" />
                                 <span class="text-danger error" id="errors_from_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="from_sessions" id="edit_from_sessions">
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
                                <input type="date"  name="to_date" class="form-control"  id="toDate" value="" placeholder="Choose Date" />
                                  <span class="text-danger error" id="errors_to_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group">
								<label>Sessions</label> 
								<select class="form-control"
									name="to_sessions" id="edit_to_sessions">
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
                                <textarea class="form-control" name="reason" placeholder="Enter Reason" id="editReason"></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @else
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" name="reason" placeholder="Enter Reason" id="editReason" ></textarea>
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
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
 $(function(){
  $('#all_members').select2({
    dropdownParent: $('#leaveModal')
  });
}); 
 $(function(){
  $('#leave_types').select2({
    dropdownParent: $('#leaveModal')
  });
}); 
 $(function(){
  $('#status').select2({
    dropdownParent: $('#leaveModal')
  });
}); 

$(function(){
  $('#from_sessions').select2({
    dropdownParent: $('#leaveModal')
  });
}); 
$(function(){
  $('#to_sessions').select2({
    dropdownParent: $('#leaveModal')
  });
}); 
$(function(){
  $('#edit_to_sessions').select2({
    dropdownParent: $('#updateMyleaveModal')
  });
}); 

$(function(){
  $('#edit_from_sessions').select2({
    dropdownParent: $('#updateMyleaveModal')
  });
}); 


function editmyLeave(id){
$('#updateMyleaveModal').modal('show');
$('#update_employee_id').val(id);
var employee_id =   $('#employee_id').val();

     $.ajax({
                type: 'post',
                url: "{{ route('editMyLeave')}}",
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
                $('#single_employee').val(data.employeeName);
                $('#edit_leave_types').val(data.leave_type).trigger('change');
                $('#editDate').val(data.from_date);
                $('#toDate').val(data.to_date);
                $('#edit_status').val(data.status).trigger('change');
                 $('#edit_from_sessions').val(data.from_sessions).trigger('change');
                $('#edit_to_sessions').val(data.to_sessions).trigger('change');
                $('#editReason').val(data.reason);
                $('.error').html('')
                
                },
            });



}
  $('#updateMyLeave').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $(".commonButton").attr("disabled", true);
            $.ajax({
                type: 'post',
                url: "{{ route('updateMyLeave')}}",
                data:  formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $(".commonButton").attr("disabled", false);
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			
      			window.location = "/myleaves";
      			
                }else{
                console.log(data);
                	$.each( data.errors, function( key, value ) {
                		$('#errors_'+key).html(value)
                	})
                }
                },
            });
        });



 $(".leaveDelete").click(function(){
        var id = $(this).data("id");
        $.ajax({
                type: 'post',
                url: "{{ route('myDelete')}}",
                data: "id="+id+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	location.reload(true);
                 
                },
            });
        });



 $('#myLeave').submit(function(e) {
  $('#loader').show();
            e.preventDefault(); 
            var formData = $(this).serialize();
            $(".commonButton").attr("disabled", true);
            $.ajax({
                type: 'post',
                url: "{{ route('selfleaves')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('#loader').hide();
                $(".commonButton").attr("disabled", false);
                   $('.error').html('');
                console.log(data.errors);
      			if($.isEmptyObject(data.errors)){   
               window.location = "/myleaves";
               
               
                }else{
                	$.each( data.errors, function( key, value ) {
                	  $('#casual_error').html(data.errors.message);
                	console.log(data.errors.message);
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
        
        
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
  $('#edit_leave_types').select2({
    dropdownParent: $('#updateMyleaveModal')
  });
}); 

setTimeout(function() {
    	$('#danger').hide();
     }, 3000);
    
    setTimeout(function() {
    	$('#success').hide();
     }, 3000);

</script> </x-admin-layout>