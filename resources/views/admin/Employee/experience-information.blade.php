<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
                            <h3 class="mb-2 fs-5 d-flex justify-content-between align-items-center">Experience Information</h3>
                     	<form  method="post" class="px-3" id="addExperienceInformation">
	                @csrf
                           	                <input type="hidden" name="user_id" id="user_id" value="{{$userData->_id}}"/>
                           
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Company Name <span class="text-red">*</span></label>
                                    <input name='company_name' type="text" class="form-control" placeholder="Company Name" />
                                      <span class="text-danger error" id="errorsexperience_company_name"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Designation <span class="text-red">*</span></label>
                                    <input type="text" name='designation' class="form-control" placeholder="Designation" />
                                    <span class="text-danger error" id="errorsexperience_designation"></span> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dapartment">Select Employee Type <span class="text-red">*</span></label>
                                    <select name='employee_type'  class="form-control js-select2">
                                        <option selected value="">Select Employee Type</option>
                                        <option value="permanent">Permanent</option>
                                        <option value="freelancer">Freelancer</option>
                                        <option value="contract">Contract</option>
                                    </select>
                                          <span class="text-danger error" id="errorsexperience_employee_type"></span> 
                                </div>
                            </div>

                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period From <span class="text-red">*</span></label>
                                    <input type="date" name='period_from' class="form-control" placeholder="Period From" />
                                      <span class="text-danger error" id="errorsexperience_period_from"></span> 
                                </div>
                            </div>
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Period To <span class="text-red">*</span></label>
                                    <input type="date" name='period_to' class="form-control" placeholder="Period To" />
                                      <span class="text-danger error" id="errorsexperience_period_to"></span> 
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Relevant Experience <span class="text-red">*</span></label>
                                    <input type="text" name='relevant_experience' class="form-control" placeholder="Relevant Experience" />
                                   <span class="text-danger error" id="errorsexperience_relevant_experience"></span> 
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Skills</label>
                                    <input type="text" name='skills' class="form-control" placeholder="Skills" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Employee ID <span class="text-red">*</span></label>
                                    <input name='employee_id'  type="text" class="form-control" placeholder="Employee ID" value="" />
                                   <span class="text-danger error" id="errors_employee_id"></span> 
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Net Pay</label>
                                    <input name='net_pay' type="text" class="form-control" placeholder="Net Pay" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company City</label>
                                    <input name='company_city' type="text" class="form-control" placeholder="Company City" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company State</label>
                                    <input name='company_state' type="text" class="form-control" placeholder="Company State" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Country</label>
                                    <select name="company_country" id="company-country" class="form-control country js-select2">
                                      <option value="">Select Country</option>
                                         @foreach($countries as $country)
                                        <option value="{{ $country->_id }}">{{ $country->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Pin Code</label>
                                    <input name='company_pincode' type="text" class="form-control" placeholder="Company Pin Code" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Company Website</label>
                                    <input name='company_website' type="text" class="form-control" placeholder="Company Website" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Name of Reporting Manager</label>
                                    <input name='manager_name' type="text" class="form-control" placeholder="Name of Reporting Manager" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Designation of Reporting Manager</label>
                                    <input name='manager_designation' type="text" class="form-control" placeholder="Designation of Reporting Manager" />
                                </div>
                            </div> 
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Contact Number of Reporting Manager</label>
                                    <input name='manager_contact' type="text" class="form-control" placeholder="Contact Number of Reporting Manager" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email of Reporting Manager</label>
                                    <input name='manager_email' type="email" class="form-control" placeholder="Email of Reporting Manager" />
                                </div>
                            </div>
                              <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="dapartment">Verification Status</label>
                                    <select name='verification_status'  class="form-control js-select2">
                                        <option value="initiated">Initiated</option>
                                        <option value="pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="verified">Verified</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Document</label>
                                    <div class="fileUploader">
                                        <input type="file" name='documents' title="Upload Documents">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group" >
                               	<label>Notes</label>
										<textarea id="add_notes_experience" name="notes"
										class="form-control" rows="5" cols="80"
										placeholder="Enter Notes"  ></textarea>
                            </div>
                           <span class="text-danger error" id="edit_bank_user_role"></span> 
                        </div>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group mt-4">
                                    <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>

		$('#addExperienceInformation').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
  			$.ajax({
                type: 'post',
                url: "{{ route('addExperience')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                  window.location = "/employee-profile/<?=$userData->_id?>?activetab=experience";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errorsexperience_'+key).html(value)
                	})
                }
            	} 
                
            });

		});


</script>
</x-admin-layout>