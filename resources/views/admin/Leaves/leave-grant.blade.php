<?php
use Illuminate\Support\Facades\Auth;
?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Apply Comp-Off</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Leaves Apply</li>
				</ol>
			</nav>
		</div>
	<div class="pageFilter mb-3">
                <div class="row">
<!--                     <div class="col-xxl-10 col-xl-10"> -->
<!--                       <form  method="get" action=""> -->
<!--                         <div class="leftFilters employeeLeavesLeft"> -->
<!--                             <div class="row"> -->
<!--                             <div class="col-xl-2 form-group"> -->
<!--                                 <label for="floatingSelect">Leave Type</label> -->
<!--                                 <select class="form-select leave_type js-select2" id="floatingSelect" name="search_leave_type" aria-label="Floating label  select example"> -->
<!--                                     <option value="">All</option> -->
<!--                                     <option value="1" >Comp Off</option> -->
<!--                                 </select> -->
<!--                             </div> -->
        
<!--                             <div class="col-xl-2 form-group"> -->
<!--                                 <label for="floatingSelect">Leave Status</label> -->
<!--                                 <select class="form-select leave_status js-select2" id="floatingSelect"  name="search_status"  aria-label="Floating label select example"> -->
<!--                                   <option  value="" selected>All</option> -->
<!--                                   <option value="1" >Pending </option> -->
<!--                                   <option value="2" >  Approved</option> -->
<!--                                   <option value="3" > Rejected</option> -->
<!--                                 </select> -->
<!--                             </div> -->

<!--                             <div class="col-xl-2 form-group"> -->
<!--                                 <label for="floatingInput">From</label> -->
<!--                                 <input type="date" class="form-control" name="fromsearch_date" value=""> -->
<!--                             </div> -->

<!--                             <div class="col-xl-2 form-group"> -->
<!--                                 <label for="floatingInput">To</label> -->
<!--                                 <input type="date" class="form-control" name="tosearch_date" value=""> -->
<!--                             </div> -->
<!--  							<div class="col-xl-4"> -->
<!--                                  <button type="submit" value="Submit" class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button> -->
<!--                             </div> -->
                            <!-- <div class="col-sm">
<!--                             </div> --> 
<!--                             </div> -->
<!--                         </form> -->
<!--                         <div class="col-sm"> -->
                            <a href="javascript:void(0);" class="btn btn-danger" id="deleteAll"  style="display: none;">Delete</a>
<!--                         </div> -->
<!--                          </div> -->
                            
                    </div>
                    <!-- <div class="col-xl-5"> -->
                    <div class="col">
                        <div class="rightFilter employeeLeavesReft">
                            <a class="addBtn"  data-bs-toggle="modal" data-bs-target="#leaveModal" style="cursor: pointer;" onclick="$('.error').html('')"><i class="fa-solid fa-plus"></i> Apply Comp-Off</a>
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
									<th>Employee ID</th>
								    <th>Employee</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Leave Type</th>
                                    <th>Reason</th>
                                    <th>Updated By</th>
                                    <th>Leave Status</th>
								</tr>

							</thead>
							<tbody>
								@if(empty($compOff) || count($compOff) <= 0)
								<tr>
									<td class="text-center" colspan="9">No Data Found</td>
								</tr>
								@else 
								@foreach($compOff as $employ)
								<tr>
                                             <td>{{@$employ->getleaveemployee_name()->employee_id}}</td>
                                             <td>
                                             <div class="user-name">
                                                    <div class="user-image">
                                                        <img src="{{@$employ->getleaveemployee_name()->photo}}" alt="user-img" />
                                                    </div>
                                                    <span class="green"><a href="profile/{{$employ->getleaveemployee_name()->_id}}">{{@$employ->getleaveemployee_name()->first_name}} {{@$employ->getleaveemployee_name()->last_name}}</a></span>
                                                </div>
                                                </td>
                                                <td>{{date('d M Y',($employ->str_from_date))}}</td>
                                                <td>{{date('d M Y',($employ->str_to_date))}}</td>
                                                <td>{{($employ->leave_type == 'comp_off') ? 'Comp Off' : ''}}</td>
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
                                             
																@endforeach @endif
								</tr>
							</tbody>
						</table>
						 {{$compOff->links('pagination::bootstrap-4')}}
						
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="modal fade" id="leaveModal" tabindex="-1"
	aria-labelledby="leaveModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="leaveModalLabel">Add Comp - Off</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal"
					aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="post" class="px-3" enctype="multipart/form-data"
					id="myCompOff">
					@csrf
					           			<input type="hidden" name="user_id" id="user_id" value="<?=Auth::user()->id?>">
					
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Leave Type</label> <select class="form-control js-select2"
									name="leave_type" id="leave_types">
									<option value="comp_off">Comp Off</option>
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
									class="form-control " placeholder="Choose Date" max="<?=date('Y-m-d')?>"/> <span
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
									class="form-control" id="txtDate" placeholder="Choose Date"  max="<?=date('Y-m-d')?>" />
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
							<div class="form-group mt-4 ">
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
  $('#from_sessions').select2({
    dropdownParent: $('#leaveModal')
  });
  });
  $(function(){
  $('#to_sessions').select2({
    dropdownParent: $('#leaveModal')
  });
  });

 $('#myCompOff').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $(".commonButton").attr("disabled", true);
            $.ajax({
                type: 'post',
                url: "{{ route('addCompoff')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $(".commonButton").attr("disabled", false);
      			if($.isEmptyObject(data.errors)){      			
                window.location = "/leave-grant";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
</script>
</x-admin-layout>