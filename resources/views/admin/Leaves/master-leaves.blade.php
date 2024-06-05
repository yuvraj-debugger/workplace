<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Master Leaves</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Master
						Leaves</li>
				</ol>
			</nav>
		</div>
		@if(session('success'))
		<div class="alert alert-success" id="success">{{ session('success') }}
		</div>
		@endif
		<div class="pageFilter mb-3">
			<div class="row">
				<form method="post" id="addMasterLeave">
					<h2>WORK FROM OFFICE</h2>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Casual Leaves</label> <input type="text"
									class="form-control" id="office_casual_leave"
									name="office_casual_leave"
									value="{{! empty($masterLeave->office_casual_leave) ? $masterLeave->office_casual_leave : ''}}"
									placeholder="Enter Casual"> <span class="text-danger error"
									id="error_office_casual_leave"></span>

							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Sick Leaves</label> <input type="text"
									class="form-control" id="office_sick_leave"
									name="office_sick_leave"
									value="{{! empty($masterLeave->office_sick_leave) ? $masterLeave->office_sick_leave  : ''}}"
									placeholder="Enter Sick"> <span class="text-danger error"
									id="error_office_sick_leave"></span>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Bereavement Leave</label> <input type="text"
									class="form-control" id="office_bereavement_leave"
									name="office_bereavement_leave"
									value="{{! empty($masterLeave->office_bereavement_leave) ? $masterLeave->office_bereavement_leave : ''}}"
									placeholder="Enter Bereavement"> <span
									class="text-danger error" id="error_office_bereavement_leave"></span>
							</div>
						</div>
						<!-- 						<div class="col-md-6"> -->
						<!-- 							<div class="form-group"> -->
						<!-- 								<label>Loss Of Pay</label> <input -->
						<!-- 									type="text" class="form-control" id="office_loss_of_pay" name="office_loss_of_pay_leave" value="{{! empty($masterLeave->office_loss_of_pay_leave) ? $masterLeave->office_loss_of_pay_leave : '0'}}" -->
						<!-- 									placeholder="Enter Loss of Pay"> -->
						<!-- 									<span class="text-danger error" id="error_office_loss_of_pay_leave"></span> -->
						<!-- 							</div> -->
						<!-- 						</div> -->

						<div class="col-md-6">
							<div class="form-group">
								<label>Earned leave</label> <input type="text"
									class="form-control" id="office_earned_leave"
									name="office_earned_leave"
									value="{{! empty($masterLeave->office_earned_leave) ? $masterLeave->office_earned_leave : ''}}"
									placeholder="Enter Paternity"> <span class="text-danger error"
									id="error_office_earned_leave"></span>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Maternity Leave (Days)</label> <input type="text"
									class="form-control" id="office_maternity_leave"
									name="office_maternity_leave"
									value="{{! empty($masterLeave->office_maternity_leave) ? $masterLeave->office_maternity_leave : ''}}"
									placeholder="Enter Maternity"> <span class="text-danger error"
									id="error_office_maternity_leave"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Paternity Leave (Days)</label> <input type="text"
									class="form-control" id="office_paternity_leave"
									name="office_paternity_leave"
									value="{{! empty($masterLeave->office_paternity_leave) ?  $masterLeave->office_paternity_leave :''}}"
									placeholder="Enter Paternity"> <span class="text-danger error"
									id="error_office_paternity_leave"></span>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Earned Leave Eligibility(Months)</label> <input type="text"
									class="form-control" id="office_earned_leave_months"
									name="office_earned_leave_months"
									value="{{! empty($masterLeave->office_earned_leave_months) ? $masterLeave->office_earned_leave_months : ''}}"
									placeholder="Enter Earned Leave Months"> <span
									class="text-danger error" id="error_office_earned_leave_months"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Maternatiy and Paternity Eligibility (Months)</label> <input type="text"
									class="form-control" id="oofice_materirty_paternity_months"
									name="office_materirty_paternity_months"
									value="{{! empty($masterLeave->office_materirty_paternity_months) ? $masterLeave->office_materirty_paternity_months : ''}}"
									placeholder="Enter Maternity & Paternity Months"> <span
									class="text-danger error"
									id="error_office_materirty_paternity_months"></span>
							</div>
						</div>

					</div>
					<br />
					<h2>WORK FROM HOME</h2>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Casual Leaves</label> <input type="text"
									class="form-control" id="home_casual_leave"
									name="home_casual_leave"
									value="{{! empty($masterLeave->home_casual_leave) ? $masterLeave->home_casual_leave : ''}}"
									placeholder="Enter Casual"> <span class="text-danger error"
									id="error_home_casual_leave"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Sick Leaves</label> <input type="text"
									class="form-control" id="home_sick_leave"
									name="home_sick_leave"
									value="{{! empty ($masterLeave->home_sick_leave) ? $masterLeave->home_sick_leave : ''}}"
									placeholder="Enter Sick"> <span class="text-danger error"
									id="error_home_sick_leave"></span>
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Bereavement Leave</label> <input type="text"
									class="form-control" id="home_bereavement_leave"
									name="home_bereavement_leave"
									value="{{! empty ($masterLeave->home_bereavement_leave) ? $masterLeave->home_bereavement_leave : ''}}"
									placeholder="Enter Bereavement"> <span
									class="text-danger error" id="error_home_bereavement_leave"></span>
							</div>
						</div>
						<!-- 						<div class="col-md-6"> -->
						<!-- 							<div class="form-group"> -->
						<!-- 								<label>Loss Of Pay</label> <input -->
						<!-- 									type="text" class="form-control" id="home_loss_of_pay_leave" name="home_loss_of_pay_leave" value="{{! empty($masterLeave->home_loss_of_pay_leave) ? $masterLeave->home_loss_of_pay_leave : '0'}}" -->
						<!-- 									placeholder="Enter Loss of Pay"> -->
						<!-- 									<span class="text-danger error" id="error_home_loss_of_pay_leave"></span> -->
						<!-- 							</div> -->
						<!-- 						</div> -->

						<div class="col-md-6">
							<div class="form-group">
								<label>Earned leave</label> <input type="text"
									class="form-control" id="home_earned_leave"
									name="home_earned_leave"
									value="{{! empty($masterLeave->home_earned_leave) ? $masterLeave->home_earned_leave : ''}}"
									placeholder="Enter Paternity"> <span class="text-danger error"
									id="error_home_earned_leave"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Maternity Leave (Days)</label> <input type="text"
									class="form-control" id="home_maternity_leave"
									name="home_maternity_leave"
									value="{{! empty($masterLeave->home_maternity_leave) ? $masterLeave->home_maternity_leave : ''}}"
									placeholder="Enter Maternity"> <span class="text-danger error"
									id="error_home_maternity_leave"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Paternity Leave (Days)</label> <input type="text"
									class="form-control" id="home_paternity_leave"
									name="home_paternity_leave"
									value="{{! empty($masterLeave->home_paternity_leave) ? $masterLeave->home_paternity_leave : ''}}"
									placeholder="Enter Paternity"> <span class="text-danger error"
									id="error_home_paternity_leave"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Earned Leave Eligibility(Months)</label> <input type="text"
									class="form-control" id="home_earned_leave_months"
									name="home_earned_leave_months"
									value="{{! empty($masterLeave->home_earned_leave_months) ? $masterLeave->home_earned_leave_months : ''}}"
									placeholder="Enter Paternity"> <span class="text-danger error"
									id="error_home_earned_leave_months"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Maternatiy and Paternity Eligibility (Months)</label> <input type="text"
									class="form-control" id="home_materirty_paternity_months"
									name="home_materirty_paternity_months"
									value="{{! empty($masterLeave->home_materirty_paternity_months) ? $masterLeave->home_materirty_paternity_months : ''}}"
									placeholder="Enter Paternity"> <span class="text-danger error"
									id="error_office_materirty_paternity_months"></span>
							</div>
						</div>


					</div>
					<br />
					<button type="submit" class="btn btn-primary wfocancel">Cancel</button>
					<button type="submit" class="btn btn-primary wfosubmit">Submit</button>


				</form>
			</div>
		</div>
	</div>
</div>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
  $('#addMasterLeave').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: "{{ route('addmasterLeave')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                 $('.error').html('');
      			if($.isEmptyObject(data.errors)){
      			      window.location = "/master-leaves-index";               		
      			      			
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });
  setTimeout(function() {
    	$('#success').hide();
     }, 3000);

</script> </x-admin-layout>