<?php

use App\Models\Permission;
use App\Models\RolesPermission;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Attendance</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Attendance</li>
				</ol>
			</nav>
		</div>
		<div class="commonCards">
             @php
           		$userRole = Role::where('_id',Auth::user()->user_role)->first();
           		$show=true;
           		if(! empty($userRole)){
           		if($userRole->name!='employee')
           		{
           			$show = true;
           		}
           		if($userRole->name=='employee')
       			{
       				$show=false;
       			}
       			}
             @endphp
             
             @if(((Auth::user()->user_role==0)))
                <div class="row">
                     <div class="col-lg-3 col-md-3 col-6">
                        <div class="commonCards__content">
                            <h4>{{$count}}/{{$employeecounting}}</h4>
                            <p>Today Presents</p>
                        </div>
                    </div> 

                   
                </div>
               @endif
            </div>
            <div class="pageFilter mb-3">
                <div class="row">
                    <div class="col-xl-8 col-lg-7 col-md-8">
                        @php
                        $role=Role::where('_id',Auth::user()->user_role)->first();
                        @endphp
                        <form  method="get" action="">
                         
                         
                            <div class="leftFilters">
                                <div class="form-group">
                                <label for="floatingSelect">Employee</label>
                                    <select class="form-select user_list js-select2" name="employee" id="floatingSelect" aria-label="Floating label select example">
                                      <option value="all" selected>Select All</option>
                                    @foreach($employees as $employee)
                                      <option value="{{$employee['_id']}}"  {{ ($searchEmployee == $employee['_id']) ? 'selected' : '' }} >{{$employee['first_name']}} {{$employee['last_name']}} ({{$employee->employee_id}})</option>
                                      @endforeach
                                    </select>
                                    
                                </div>

                                <div class="form-group" >
                                <label for="floatingSelect">Month</label>
                                     <select class="form-select month js-select2" id="floatingSelect" name="month" aria-label="Floating label select example">
                                      @php $selected_month = date('m'); @endphp
                                    <option value="all" selected>Select Month</option>
                                        @for ($i_month = 01; $i_month <= 12; $i_month++)
                                        <option value="{{sprintf('%02d',$i_month)}}"  {{ (date('F', mktime(0,0,0,$month	,12)) == date('F', mktime(0,0,0,$i_month,12))	)? 'selected' :''}}>{{date('F', mktime(0,0,0,$i_month,12))}}</option>
                                        @endfor
                                    </select>
                                    
                                </div>
                                <div class="col-s buttons attendance" >
                                         <button type="submit" value="Submit" class="btn btn-search attendance"><img src="images/iconSearch.svg" /> Search here</button>
                                         <button type="button" value="reset" class="btn btn-search attendance" onclick="window.location='{{ url("admin-attendance") }}'">Reset</button>
                                    </div>
                                    <!-- <div class="col">
                                    	<button type="button" value="reset" class="btn btn-search" onclick="window.location='{{ url("admin-attendance") }}'">Reset</button>
                                    </div> -->
                                

                                <!-- <button class="btn btn-search"><img src="images/iconSearch.svg" /> Search here</button> -->
                            </div>
                        </form>
                    </div>
        
                    <div class="col-xl-4 col-lg-5 col-md-4">
                        <div class="rightFilter attendance">
                            <?php 
                            $role=Role::where('_id',Auth::user()->user_role)->first();
                            
                            ?>
                            @if((Auth::user()->user_role==0) || ! empty($role) &&  $role->name=="HR" )
<!--                                 <button class="" wire:click="export"> -->
<!--                                     <svg width="30" height="27" viewBox="0 0 30 27" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
<!--                                         <path d="M0 3.375C0 1.51348 1.49479 0 3.33333 0H11.6667V6.75C11.6667 7.6834 12.4115 8.4375 13.3333 8.4375H20V15.1875H11.25C10.5573 15.1875 10 15.7518 10 16.4531C10 17.1545 10.5573 17.7188 11.25 17.7188H20V23.625C20 25.4865 18.5052 27 16.6667 27H3.33333C1.49479 27 0 25.4865 0 23.625V3.375ZM20 17.7188V15.1875H25.7344L23.7031 13.1309C23.2135 12.6352 23.2135 11.8336 23.7031 11.3432C24.1927 10.8527 24.9844 10.8475 25.4688 11.3432L29.6354 15.5619C30.125 16.0576 30.125 16.8592 29.6354 17.3496L25.4688 21.5684C24.9792 22.0641 24.1875 22.0641 23.7031 21.5684C23.2188 21.0727 23.2135 20.2711 23.7031 19.7807L25.7344 17.724H20V17.7188ZM20 6.75H13.3333V0L20 6.75Z" fill="#1F1F1F"/> -->
<!--                                     </svg> -->
<!--                                 </button> -->

<!--                             <button class=""> -->
<!--                                 <svg width="22" height="26" viewBox="0 0 22 26" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
<!--                                     <path d="M11.9375 10.2498H10.0625V4.07515L6.97578 7.16304C6.79987 7.33896 6.56128 7.43778 6.3125 7.43778C6.06372 7.43778 5.82513 7.33895 5.64922 7.16304C5.47331 6.98713 5.37448 6.74854 5.37448 6.49976C5.37448 6.25098 5.47331 6.01239 5.64922 5.83648L10.3367 1.14898C10.4238 1.06181 10.5272 0.992665 10.641 0.945486C10.7548 0.898307 10.8768 0.874023 11 0.874023C11.1232 0.874023 11.2452 0.898307 11.359 0.945486C11.4728 0.992665 11.5762 1.06181 11.6633 1.14898L16.3508 5.83648C16.5267 6.01239 16.6255 6.25098 16.6255 6.49976C16.6255 6.74854 16.5267 6.98713 16.3508 7.16304C16.1749 7.33896 15.9363 7.43778 15.6875 7.43778C15.4387 7.43778 15.2001 7.33896 15.0242 7.16304L11.9375 4.07515V10.2498ZM19.4375 10.2498H11.9375V14.9373C11.9375 15.1859 11.8387 15.4244 11.6629 15.6002C11.4871 15.776 11.2486 15.8748 11 15.8748C10.7514 15.8748 10.5129 15.776 10.3371 15.6002C10.1613 15.4244 10.0625 15.1859 10.0625 14.9373V10.2498H2.5625C2.06522 10.2498 1.58831 10.4473 1.23667 10.7989C0.885044 11.1506 0.6875 11.6275 0.6875 12.1248V23.3748C0.6875 23.872 0.885044 24.349 1.23667 24.7006C1.58831 25.0522 2.06522 25.2498 2.5625 25.2498H19.4375C19.9348 25.2498 20.4117 25.0522 20.7633 24.7006C21.115 24.349 21.3125 23.872 21.3125 23.3748V12.1248C21.3125 11.6275 21.115 11.1506 20.7633 10.7989C20.4117 10.4473 19.9348 10.2498 19.4375 10.2498Z" fill="#1F1F1F"></path> -->
<!--                                 </svg> -->
                                    
<!--                             </button> -->
<!--                             <button class=""> -->
<!--                                 <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
<!--                                     <path d="M22 17.875C22.4815 17.8752 22.9445 18.0607 23.293 18.393C23.6415 18.7253 23.8488 19.1789 23.8719 19.6599C23.895 20.1409 23.7323 20.6123 23.4173 20.9765C23.1023 21.3407 22.6593 21.5698 22.18 21.6162L22 21.625H2C1.51848 21.6248 1.05551 21.4393 0.707017 21.107C0.358527 20.7747 0.151235 20.3211 0.128095 19.8401C0.104954 19.3591 0.26774 18.8877 0.582719 18.5235C0.897699 18.1593 1.34073 17.9302 1.82 17.8838L2 17.875H22ZM22 9.125C22.4973 9.125 22.9742 9.32254 23.3258 9.67417C23.6775 10.0258 23.875 10.5027 23.875 11C23.875 11.4973 23.6775 11.9742 23.3258 12.3258C22.9742 12.6775 22.4973 12.875 22 12.875H2C1.50272 12.875 1.02581 12.6775 0.674175 12.3258C0.322544 11.9742 0.125 11.4973 0.125 11C0.125 10.5027 0.322544 10.0258 0.674175 9.67417C1.02581 9.32254 1.50272 9.125 2 9.125H22ZM22 0.375C22.4973 0.375 22.9742 0.572544 23.3258 0.924175C23.6775 1.27581 23.875 1.75272 23.875 2.25C23.875 2.74728 23.6775 3.22419 23.3258 3.57583C22.9742 3.92746 22.4973 4.125 22 4.125H2C1.50272 4.125 1.02581 3.92746 0.674175 3.57583C0.322544 3.22419 0.125 2.74728 0.125 2.25C0.125 1.75272 0.322544 1.27581 0.674175 0.924175C1.02581 0.572544 1.50272 0.375 2 0.375H22Z" fill="#1F1F1F"/> -->
<!--                                 </svg> -->
<!--                             </button> -->


                            <a type="button" class="addBtn attendance" data-bs-toggle="modal" data-bs-target="#myModal" onclick="$('.error').html('')">
                            Mark Attendance
                            </a>

                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboardSection">
                <div class="dashboardSection__body pt-0 px-0">                    
                    <div class="commonDataTable attendanceTable">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        @for($d = 1; $d<= $days; $d++)
                                        <th>{{$d}}</th>
                                        @endfor
                                        
                                    </tr>
                                </thead>
                                <tbody id="ajax-attendance">
                                  <tr>
                                  @for($d = 1; $d<= $days; $d++)
                                      <td>
                                      @if((int)($days/2)==$d)
                                      	<div class="loader" id="loader" style="display:none;"><img src="{{asset('images/loading2.gif')}}"></div>
                                      @endif
                                      </td>                                  
                                 @endfor
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!--Common Data Table end-->


                </div>
            </div>
            
	</div>
	
 
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="myModalLabel">Employee Attendance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="addAttendance">
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Choose Member</label>
                                    <select id="user_id" class="form-control" name="user_id">
                                    	<option value="">Choose Member</option>
                                         @foreach($employees as $employee)
                                         
                                      		<option value="{{$employee->_id}}">{{$employee->first_name}} {{$employee['last_name']}}({{$employee['employee_id']}})</option>
                                      @endforeach
                                    </select>
                                     <span class="text-danger error" id="error_user_id"></span> 
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" id="date" class="form-control"  name="date">
                                     <span class="text-danger error" id="error_date"></span> 
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Punch In</label>
                                <input type="time" id="punch_in" class="form-control" name="punch_in">
                                     <span class="text-danger error" id="error_punch_in"></span> 
                            </div>
                        </div>
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Punch Out</label>
                                <input type="time" id="punch_out"  class="form-control" name="punch_out">
                                @error('punch_out') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>

   <?php 
    $role = Role::where('_id', Auth::user()->user_role)->first();
    
    
    if((Auth::user()->user_role==0) || (! empty($role) && $role->name == 'HR')){
    ?>

	<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModalLabel">Edit Employee Attendance</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <form method="post" enctype="multipart/form-data" id="updateAttendance">
           			<input type="hidden" name="emp_id" id="emp_id" value="">
           
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Choose Member</label>
                                 <input type="text" id="employee_user_id" class="form-control" value="" disabled>
                                     <span class="text-danger error" id="error_user_id"></span> 
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" id="user_date" class="form-control"  value="" name="date" disabled>
                                     <span class="text-danger error" id="error_date" ></span> 
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Punch In</label>
                                <input type="time" id="punch_in_time" class="form-control" value="" name="punch_in" required>
                                     <span class="text-danger error" id="errorss_punch_in"></span> 
                            </div>
                        </div>
                         <div class="col-lg-12">
                            <div class="form-group">
                                <label>Punch Out</label>
                                <input type="time" id=punch_out_time  class="form-control" name="punch_out" name="punch_out">
                            </div>
                        </div>
                         <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary modalcanceleffect" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
      					</div>
                </form>
      </div>
     
    </div>
  </div>
</div>
	<?php }?>

	
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
 $(function(){
  $('#user_id').select2({
    dropdownParent: $('#myModal')
  });
}); 

function editAttendance(id,day)
{
  $('#updateModal').modal('show');
  $('#emp_id').val(id);
  var id_ = $('#emp_id').val();
    $.ajax({
                type: 'post',
                url: "{{ route('editAttendance')}}",
                data: "id="+id+"&day="+day+"&month={{$month}}&year={{$year}}",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                var data = JSON.parse(data)
                $('#user_date').val(data.date_day);
                $('#employee_user_id').val(data.employeeName);
                },
            });
  
}
 $(document).ready(function() {
  $('#updateAttendance').submit(function(e) {
            e.preventDefault();
            var employeeId =  $('#emp_id').val();
            var date = $('#user_date').val();
           	var punchIn = $('#punch_in_time').val();
           	var punchOut = $('#punch_out_time').val();
            $.ajax({
                type: 'post',
                url: "{{ route('updateAttendance')}}",
                data:  "date="+date+"&punchIn="+punchIn+"&punchOut="+punchOut+"&employeeId="+employeeId,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                 window.location = "/admin-attendance";
                },
            });
        });
});

 $(document).ready(function() {
  $('#addAttendance').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('attendanceAdd')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
});
      $('#loader').show();
      var employeeId = $('#floatingSelect').val();
      var month = "<?=$month?>";
      $.ajax({
                type: 'post',
                url: "{{ route('ajaxAttendance')}}",
                data: "employeeId="+employeeId+"&month="+month,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
      			 $('#ajax-attendance').html(data)
      			 $('#loader').hide();
      			 
                },
            });
</script>
</x-admin-layout>