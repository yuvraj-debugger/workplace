<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
	 <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Edit Experience Information</h3>
                     	<form  method="post" class="px-3" id="updatedExperienceInformation">
	                @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{$userData->_id}}"/>
                                                <input type="hidden" name="edit_experience_id" id="user_id" value="{{$employeeExperience->_id}}"/>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Company Name <span class="text-red">*</span></label>
                                    <input name='company_name' type="text" class="form-control" placeholder="Company Name" value="{{$employeeExperience->company_name}}"/>
                                      <span class="text-danger error" id="errors_company_name"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Designation <span class="text-red">*</span></label>
                                    <input type="text" name='designation' class="form-control" placeholder="Designation" value="{{$employeeExperience->designation}}"/>
                                    <span class="text-danger error" id="errors_designation"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dapartment">Select Employee Type <span class="text-red">*</span></label>
                                    <select name='employee_type'  class="form-control js-select2">
                                        <option selected value="">Select Employee Type</option>
                                        <option value="permanent" @if($employeeExperience->employee_type == 'permanent') ? selected :'' @endif>Permanent</option>
                                        <option value="freelancer" @if($employeeExperience->employee_type == 'freelancer') ? selected :'' @endif>Freelancer</option>
                                        <option value="contract" @if($employeeExperience->employee_type == 'contract') ? selected :'' @endif >Contract</option>
                                    </select>
                                          <span class="text-danger error" id="errors_employee_type"></span> 
                                </div>
                            </div>

                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period From <span class="text-red">*</span></label>
                                    <input type="date" name='period_from' class="form-control" placeholder="Period From"  value="{{date('Y-m-d',$employeeExperience->period_from)}}"/>
                                      <span class="text-danger error" id="errors_period_from"></span> 
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period To</label>
                                    <input type="date" name='period_to' class="form-control" placeholder="Period To" value="{{date('Y-m-d',$employeeExperience->period_to)}}" />
                                    <span class="text-danger error" id="errors_period_to"></span>
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Relevant Experience <span class="text-red">*</span></label>
                                    <input type="text" name='relevant_experience' class="form-control" placeholder="Relevant Experience" value="{{$employeeExperience->relevant_experience}}" />
                                   <span class="text-danger error" id="errors_relevant_experience"></span> 
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Skills</label>
                                    <input type="text" name='skills' class="form-control" placeholder="Skills" value="{{$employeeExperience->skills}}"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Employee ID <span class="text-red">*</span></label>
                                    <input name='employee_id'  type="text" class="form-control" placeholder="Employee ID"  value="{{$employeeExperience->employee_id}}" />
                                   <span class="text-danger error" id="errors_employee_id"></span> 
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Net Pay</label>
                                    <input name='net_pay' type="text" class="form-control" placeholder="Net Pay" value="{{$employeeExperience->net_pay}}"/>
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company City</label>
                                    <input name='company_city' type="text" class="form-control" placeholder="Company City" value="{{$employeeExperience->company_city}}" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company State</label>
                                    <input name='company_state' type="text" class="form-control" placeholder="Company State" value="{{$employeeExperience->company_state}}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Country</label>
                                    <select name="company_country" id="company-country" class="form-control country js-select2">
                                      <option value="">Select Country</option>
                                         @foreach($countries as $country)
                                        <option value="{{ $country->name}}"  @if($employeeExperience->getCountryAttribute() == $country->name) ? selected :'' @endif>{{ $country->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Pin Code</label>
                                    <input name='company_pincode' type="text" class="form-control" placeholder="Company Pin Code" value="{{$employeeExperience->company_pincode}}" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Website</label>
                                    <input name='company_website' type="text" class="form-control" placeholder="Company Website" value="{{$employeeExperience->company_website}}"/>
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Name of Reporting Manager</label>
                                    <input name='manager_name' type="text" class="form-control" placeholder="Name of Reporting Manager" value="{{$employeeExperience->manager_name}}" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Designation of Reporting Manager</label>
                                    <input name='manager_designation' type="text" class="form-control" placeholder="Designation of Reporting Manager" value="{{$employeeExperience->manager_designation}}"/>
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Contact Number of Reporting Manager</label>
                                    <input name='manager_contact' type="text" class="form-control" placeholder="Contact Number of Reporting Manager" value="{{$employeeExperience->manager_contact}}"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email of Reporting Manager</label>
                                    <input name='manager_email' type="email" class="form-control" placeholder="Email of Reporting Manager" value="{{$employeeExperience->manager_email}}" />
                                </div>
                            </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dapartment">Verification Status</label>
                                    <select name='verification_status'  class="form-control js-select2">
                                        <option value="initiated">Initiated</option>
                                        <option value="pending" @if($employeeExperience->verification_status == 'pending') ? selected :'' @endif >Pending</option>
                                        <option value="rejected" @if($employeeExperience->verification_status == 'rejected') ? selected :'' @endif>Rejected</option>
                                        <option value="verified" @if($employeeExperience->verification_status == 'verified') ? selected :'' @endif>Verified</option>
                                    </select>
                                </div>
                            </div>

				<div class="form-group">
				                                        <input type="file" name='documents' id="img" title="Upload Documents"

					style="display: none;" > <span id="profile_file_name"></span>
					<a  href="{{$employeeExperience->documents}}" target="_blank"><?=! empty($employeeExperience->documents) ? '<img src="/images/pdfIcon.svg" />' : ''; ?></a>
					<label for="img" class="btn btn-default"><i
					class="fa-solid fa-upload"></i> Upload Profile Photo</label><br />
				<br />
				
			</div>
			 <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="edit_notes_experience" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes">{{$employeeExperience->notes}}</textarea>
                            </div>
                           <span class="text-danger error" id="edit_bank_user_role"></span> 
                        </div>
                            
                        </div>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group mt-4">
                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
$('#updatedExperienceInformation').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
    		console.log(formData)
  			$.ajax({
                type: 'post',
                url: "{{ route('updatedExperienced')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                console.log(data);
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                                window.location = "/employee-profile/<?=$userData->_id?>?activetab=experience";

                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errors_'+key).html(value)
                	})
                }
            	} 
            });

		});










</script>
</x-admin-layout>