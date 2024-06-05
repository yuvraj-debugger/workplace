<?php
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Employees Probation</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Employees
						probation</li>
				</ol>
			</nav>
		</div>
		   @if(session('success'))
                    <div class="alert alert-success" id="success">
                        {{ session('success') }}
                    </div>
				@endif
				
				<div class="pageFilter mb-3">
			<div class="row">

					<div class="col-md-6">
                 
                        <form  method="get" action="">
                            <div class="leftFilters">
                                <div class="col-lg-4 col-md-6 col-sm-6 form-group mt-0">
                                	<label for="floatingSelect">Employee Status</label>
                                    <select class="form-select employee_id js-select2"  name="status" aria-label="Floating label  select example">
                                        <option value="all">All</option>
                                        <option value="1" {{ ($searchStatus == '1') ? 'selected' : '' }}>Confirmed</option>
                                         <option value="5" {{ ($searchStatus == '5') ? 'selected' : '' }}>Probation</option>
                                          <option value="0" {{ ($searchStatus == '0') ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                                <!-- <button class="btn btn-search"><img src="{{ asset('/images/iconSearch.svg')}}" /> Search here</button> -->
                                <div class="col-lg-8 col-md-6 col-sm-6">
                                    <div class="buttons leavedBtns">
                                         <button type="submit" value="Submit" class="btn btn-search topLeaves me-2"><img src="images/iconSearch.svg" /> Search here</button>
                                         <button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("employee-probation") }}'">Reset</button>

                                    </div>
                                    <!-- <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5">
                                    	<button type="button" value="reset" class="btn btn-search topLeaves" onclick="window.location='{{ url("leaves") }}'">Reset</button>
                                    </div> -->
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
							    <th>Employee Id</th>
								<th>Name</th>
								<th>Joining Date</th>
								<th>Confirmation Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($userJoiningData as $joining)
							<tr>
							    <td>{{! empty($joining->getUserDetails()) ? $joining->getUserDetails()->employee_id : '' }}</td>
								<td><a href="employee-profile/{{! empty($joining->getUserDetails()) ? $joining->getUserDetails()->_id: '';}}" class="empprobname">{{! empty ($joining->getUserDetails()) ? ucfirst($joining->getUserDetails()->first_name).' '.$joining->getUserDetails()->last_name : '' }}</a></td>
								<td>{{! empty($joining->getUserDetails()) ? date('d M Y ', strtotime($joining->getUserDetails()->joining_date)) : ''}}</td>
								<td>{{! empty($joining->getUserDetails()->joining_date) ? date('d M Y ', strtotime('+'.$joining->probation_period.' months', strtotime($joining->getUserDetails()->joining_date))) : ''}}</td>
								<td><?php 
								if($joining->status == '1'){
								    echo "<span class='approvedby'>Approved by </span>".$joining->getManager();
								}elseif ($joining->status == '2'){
								    echo "<span class='approvedby'>Confirmed</span>";
								}elseif ($joining->status == '3'){
								    echo "<span class='rejectedby'>Rejected by </span>".$joining->getManager();
								}elseif ($joining->status == '0'){
								    echo "<span class='pendingby'>Pending from </span>". $joining->getManager();
								}elseif ($joining->status == '4'){
								    echo "<span class='rejectedby'>Rejected by HR </span>";
								}elseif ($joining->status == '5'){
								    echo "<span class='probationby'>Probation Extended</span>";
								}
								
								?></td>
								<?php 
								$role = Role::where('_id', Auth::user()->user_role)->first();
								if(!empty($role)&&($role->name!='HR') ||  (Auth::user()->user_role == '0')){
								    ?>
								   
								    <td>
								     <?php 
								    if($joining->status == '0'){
								        
								    ?>
								    <a href="/rm/approve/{{$joining->user_id}}" class="redtickcontainer"><i class="fa fa-check redshadetick" aria-hidden="true"></i> </a>
								     <a onclick="reject('{{$joining->user_id}}','{{$joining->_id}}')" class="greytickcontainer"><i
										class="fa fa-close greyshadeclose" aria-hidden="true"></i> </a>
											<?php }?>
											 <?php 
								    if($joining->status == '5'){
								    ?>
											<button class="bin eyeButtons edit probationeyeButtons" type="button" data-bs-toggle="modal" onclick="extendedReason('{{$joining->id}}','{{$joining->user_id}}')"><i class="fa fa-eye" aria-hidden="true"></i></button>
										<?php }?>
										</td>
									
								    
								    
					          <?php 		}else{
								?>
								
								<td>
								<?php 
								if($joining->status == '1'){
								?>
								<a href="/hr/approve/{{$joining->user_id}}" class="redtickcontainer"><i class="fa fa-check redshadetick" aria-hidden="true"></i> </a> 
								<a onclick="hrReject('{{$joining->user_id}}','{{$joining->_id}}')" class="greytickcontainer"><i
										class="fa fa-close greyshadeclose" aria-hidden="true"></i> </a>
											<?php }?></td>
									
									
									
										<?php }?>
								
							</tr>
							@endforeach
						</tbody>
					</table>
					{{$userJoiningData->links('pagination::bootstrap-4')}}
				</div>
			</div>
		</div>
		<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="rejectModalLabel">Probation Rejection </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="post" enctype="multipart/form-data" id="reasonUpdate">
        
					@csrf
					    <input type="hidden" name="joining_detail_id" value="" id="joining_detail_id" />
            <input type="hidden" name="user_id" value="" id="user_id" />
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" style="min-width: 100%" name="reason" id="reason" required></textarea>

                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>
<div class="modal fade commonModalNew" id="viewReason" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Reason</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     <div>
  		<span class="leavReason"></span>
	</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="hrRejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 ml-auto" id="rejectModalLabel">Probation Rejection </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="post" enctype="multipart/form-data" id="hrreasonUpdate">
        
					@csrf
					    <input type="hidden" name="joining_detail_id" value="" id="hr_joining_detail_id" />
            <input type="hidden" name="user_id" value="" id="hr_user_id" />
					<div class="col-lg-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" style="min-width: 100%" name="reason" id="hr_reason" required></textarea>

                                     <span class="text-danger error" id="errors_degree_name"></span> 
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>
		
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>

function extendedReason(id,user_id)
{
  $('#viewReason').modal('show');
  
      $.ajax({
                type: 'post',
                url: "{{ route('extendedReason')}}",
                data: "id="+id+"&user_id="+user_id,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('.leavReason').text(data.reason)
                
                },
            });

}

function reject(user_id,joining_id)
{
  $('#rejectModal').modal('show');
  $('#user_id').val(user_id);
  $('#joining_detail_id').val(joining_id);
}

 
   $('#reasonUpdate').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('Rmrejection')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/employee-probation";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#add_error_'+key).html(value)
                	})
                }
                },
            });
        });
 function hrReject(user_id,joining_id)
 {
   $('#hrRejectModal').modal('show');
   $('#hr_user_id').val(user_id);
  $('#hr_joining_detail_id').val(joining_id);
 }
 
 
    $('#hrreasonUpdate').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('Hrrejection')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			window.location = "/employee-probation";
                }else{
                console.log(data.errors)
                	$.each(data.errors, function( key, value ) {
                		$('#add_error_'+key).html(value)
                	})
                }
                },
            });
        });
 
  setTimeout(function() {
	$('#success').hide();
 }, 3000);
</script>
</x-admin-layout>