<x-admin-layout>

<div class="page-wrapper">
	<div class="content container-fluid">
        <div class="page-head-box">
			<h3>Add Employee</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url ('/dashboard')}}">Dashboard</a>
					</li>
                    <li class="breadcrumb-item"><a href="{{url ('/employee')}}">Employees</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Add Employee</li>
				</ol>
			</nav>
		</div>
        <div class="dashboardSection">
            <div class="dashboardSection__body">
		<form method="post" id="addEmployee">
			@csrf 
			<div class="form-group inner-section1">
				<input id="img" type="file" class="form-control" name="photo" style="display: none;" > 
                    <span class="text-danger error" id="error_photo"></span> 
					<span id="profile_file_name"></span>
				    <img id="blah" src="{{ asset('images/user.png')}}" width="100" alt="your image" /> <label for="img" class="btn btn-default"><i class="fa-solid fa-upload"></i> Upload Profile Photo</label>
				
			</div>
			<input type="hidden" name="User_id">
			<div class="row">
                    <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">First Name<sup>*</sup></label>
                                <input  type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" />
                            </div>
                                                             <span class="text-danger error" id="error_first_name"></span> 
                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" />
                            </div>
                                                             <span class="text-danger error" id="error_last_name"></span> 
                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Email<sup>*</sup></label>
                                <input type="email"  name="email" class="form-control" id="email" placeholder="Enter Email" />
    
                            </div>
                                                             <span class="text-danger error" id="error_email"></span> 
                            
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label> Password<sup>*</sup></label>
                                <input type="password" class="form-control"  name="password" placeholder="Enter Password" autocomplete="new-password"/>
                            </div>
                                                             <span class="text-danger error" id="error_password"></span> 
                            
                        </div>

                    <div class="col-lg-6">
                            <div class="form-group">
                                <label>Birth Date</label>
                                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="Birth Date" />
                                <span class="form-control-icon">
                                </span>
                                 <span class="text-danger error" id="error_date_of_birth"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="date">Joining Date</label>
                                <input  type="date"  class="form-control " name="joining_date"  id="joining_date" placeholder="Joining Date" />
                                 <span class="text-danger error" id="error_joining_date"></span> 
                            </div>
                        </div>
                    <div class="col-lg-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" class="form-control" name="contact" id="contact" placeholder="Enter Phone" />
                                 <span class="text-danger error" id="error_contact"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender" id="gender" class="form-control js-select2">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                 <span class="text-danger error" id="error_gender"></span> 
                            </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label>Employee Code</label>
                                <input type="text" class="form-control" name="employee_id" id="employee_id" placeholder="Enter Employee Code" value="{{$employee_id}}" />
                                 <span class="text-danger error" id="error_employee_id"></span> 
                            </div>
                        </div>
                        <div class="col-lg-6" >
                            <div class="form-group">
                                <label for="dapartment">Select Department</label>
                                <select  id="department" class="form-control js-select2"  name="department">
                                    <option selected value="">Select Department</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                              <span class="text-danger error" id="error_department"></span> 
                        </div>

                    <div class="col-lg-6">
                            <div class="form-group">
                                <label for="designation">Select Designation</label>
                                <select  id="designation" class="form-control modalSelect2 js-select2" name="designation" >
                                    <option selected value="">Select Designation</option>
                                    @foreach($designations as $designation)
                                    <option value="{{$designation->id}}">{{$designation->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                               <span class="text-danger error" id="error_designation"></span> 
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group"  >
                                <label class="d-block">Select Reporting Manager</label>
                                <select class="form-control manager js-select2" name="reporting_manager"  id="reporting_manager">
                                    <option selected value="">Select Reporting Manager</option>
                                    @foreach($employee as $user)
                                        <option value='{{$user->_id}}' data-src="http://placehold.it/45x45">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} ({{$user->employee_id}})</option>
                                    @endforeach
                                </select>
                            </div>
                           <span class="text-danger error" id="error_reporting_manager"></span> 
                        </div>

                   <div class="col-lg-6">
                            <div class="form-group">
                                <label>Can this user login to the app?</label>
                                <select class="form-control js-select2" id="app_login"  name="app_login">
                                    <option value="" selected>Select </option>
                                    <option value="0">Yes</option>
                                    <option value="1">No</option>
                                </select>
                            </div>
                           <span class="text-danger error" id="error_app_login"></span> 
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Can this user receive email noification?</label>
                                <select class="form-control js-select2" id="email_notification" name="email_notification">
                                    <option value="" selected>Select </option>
                                    <option value="0">Yes</option>
                                    <option value="1">No</option>
                                </select>
                                 <span class="text-danger error" id="error_email_notification"></span> 
                            </div>
                        </div>
                       <div class="col-lg-6">
                            <div class="form-group">
                                <label>Workplace</label>
                                <select class="form-control js-select2" id="workplace" name="workplace">
                                    <option value="1">WFO</option>
                                    <option value="0">WFH</option>
                              
                                </select>
                            </div>
                            <span class="text-danger error" id="error_workplace"></span> 
                           
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control js-select2"  id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                           <span class="text-danger error" id="error_status"></span> 
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group" >
                                <label>User Role</label>
                                <select class="form-control js-select2"  id="user_role" name="user_role">
                                    @foreach($roles as $user)
                                    <option value="{{$user->id}}" @if(ucfirst(str_replace('_',' ',$user->name))=='Employee') Selected @endif >{{ucfirst(str_replace('_',' ',$user->name))}}</option>
                                    @endforeach
                                </select>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
                           <div class="col-lg-6">
                            <div class="form-group" >
                               	<label>Probation Period</label>
                            </div>
                                    <input   class="form-control" id="probation_period" name="probation_period" value='6'/>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" >
                               	<label>Employee Shift</label>
                            </div>
                                    <select class="form-control js-select2"  id="shift_id" name="shift_id">
                                    <option value=''>Select Shift</option>
                                    @foreach($employeeShifts as $employeeShift)
                                    <option value="{{$employeeShift->_id}}"><?=$employeeShift->shift_name .'( '.$employeeShift->start_time .'-'.$employeeShift->end_time.')' ?></option>
                                    @endforeach
                                </select>
                           <span class="text-danger error" id="error_shift_id"></span> 
                        </div>
                             <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="notes" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="error_user_role"></span> 
                        </div>

                    <div class="col-lg-12">
                        <div class="form-group mt-4">
                            <a class="btn btn-secondary modalcanceleffect" href="/employee">Cancel</a>
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

  	img.onchange = evt => {
      	const [file] = img.files
      	if (file) {
      	$('#profile_file_name').text(file.name);
        blah.src = URL.createObjectURL(file)
      	}
      	
  	}
  	
  	
		$('#addEmployee').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
    		
  			$.ajax({
                type: 'post',
                url: "{{ route('employeeCreate')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                window.location = "{{route($_GET['route'])}}?search_status=1";
                }else{
                let i=0;
                	$.each( data.errors, function( key, value) {
                		$('#error_'+key).html(value)
                		if(i==0)
                		{
                		$('html, body').stop().animate({
                            scrollTop: $('#'+key).offset().top
                            
                        },100);
                        }
                        ++i;
                		
                	})
                	
                }
            	} 
                
            });

		});


</script>
</x-admin-layout>