<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
	                <h3 class="text-center">Personal Information</h3>
	                <form enctype="multipart/form-data" class="px-3" id="personalInformation">
	                @csrf
	                <input type="hidden" name="user_id" id="user_id" value="{{$userData->_id}}"/>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control js-select2" value="{{$userData->gender}}">
                                    <option value="">Select Gender</option>
                                    <option value="male" @if($userData->gender == "male") selected @endif >Male</option>
                                    <option value="female" @if($userData->gender == "female") selected @endif>Female</option>
                                    <option value="other" @if($userData->gender == "other") selected @endif>Other</option>
                                </select>
                                  <span class="text-danger error" id="error_gender"></span> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="WhatsApp">Whatsapp</label>
                                <input name="whatsapp" type="number" class="form-control" placeholder="Enter Whatsapp" value="{{$userData->whatsapp}}" />
                                                                <span class="text-danger error" id="error_whatsapp"></span> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Personal Email</label>
                                <input type="text" name="personal_email" class="form-control" placeholder="Enter Personal Email"  value="{{$userData->personal_email}}"/>
                                    <span class="text-danger error" id="error_personal_email"></span> 
                                
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nationality">Nationality<sup>*</sup></label>
                                <select name="nationality"  class="form-control country js-select2" value="{{$userData->nationality}}">
                                    <option value="">Select Nationality</option>
                                      @foreach($countries as $country)
                                        <option value="{{ $country->name }}" @if($userData->nationality == $country->name ) selected @endif >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                                                 <span class="text-danger error" id="error_nationality"></span> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" name="religion" class="form-control" placeholder="Enter Religion" value="{{$userData->religion}}"/>
                                <span class="text-danger error" id="error_religion"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="bloodGroup">Blood Group</label>
                                 <select name="blood_group" class="form-control js-select2"  value="{{$userData->blood_group}}" >
                                    <option value="">Select Blood Group</option>
                                    @foreach($bloodGroup as $blood)
                                  
                                     <option value="{{$blood->blood_group}}" @if($userData->blood_group == $blood->blood_group ) selected @endif >{{ $blood->blood_group}}</option>
                                    @endforeach
                                </select>
                               <span class="text-danger error" id="error_blood_group"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="martialStatus">Martial Status<sup>*</sup></label>
                                <select name="marital_status" class="form-control js-select2" id="marital_status" value="{{$userData->marital_status}}">
                                    <option value="">Select Martial Status</option>
                                    <option value="married" @if($userData->marital_status == "married" ) selected @endif>Married</option>
                                    <option value="single" @if($userData->marital_status == "single" ) selected @endif>Single</option>
                                </select>
                                <span class="text-danger error" id="error_marital_status"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Employment of Spouse</label>
                                <select name="spouse_employment" class="form-control js-select2" id="spouse_employment" value="{{$userData->spouse_employment}}">
                                    <option value="" selected>Select Spouse Employment</option>
                                    <option value="private" @if($userData->spouse_employment == "private" ) selected @endif>Private</option>
                                    <option value="public" @if($userData->spouse_employment == "public" ) selected @endif>Public</option>
                                </select>
                                <span class="text-danger error" id="error_spouse_employment"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No. of Children</label>
                                    <input name="children" type="text" class="form-control" placeholder="No. of Children" value="{{$userData->children}}" /> 
                                    <span class="text-danger error" id="error_children"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Passport No.</label>
                                <input name="passport_number" type="text" class="form-control" placeholder="Enter Passport No." value="{{$userData->passport_number}}" />
                                <span class="text-danger error" id="error_passport_number"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Passport Expiry Date</label>
                                <input name="passport_expiry_date" type="date" class="form-control" placeholder="Enter Date" value="{{! empty($userData->passport_expiry_date) ? date('Y-m-d',$userData->passport_expiry_date) : ''}}" />
                                <span class="text-danger error" id="error_passport_expiry_date"></span>
                            </div>
                        </div>

                    </div>

                    <h3 class="my-4">Current Address</h3>

                    <div class="row">

                         <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="state">State</label>
                                <input name="current_state_id" type="text" class="form-control" placeholder="Enter State" id="current_state_id" value="{{$userData->getCurrentState()}}"/>
                                <span class="text-danger error" id="error_current_state_id"></span> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="city">City</label>
                                 <input name="current_city_id" type="text" class="form-control" placeholder="Enter City" id="current_city_id" value="{{$userData->getCurrentCity()}}"/>
                                 <span class="text-danger error" id="error_current_city_id"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select name="selectedCurrentCountry" id="current-countries" class="form-control country js-select2"  value="{{$userData->getCurrentCountry()	}}">
                                    <option value="">Select Country</option>
                                         @foreach($countries as $country)
                                        <option value="{{ $country->_id }}" @if($userData->getCurrentCountry() == $country->name ) selected @endif >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error" id="error_selectedCurrentCountry"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Zipcode</label>
                                <input type="number" name="currentzipcode" class="form-control" placeholder="Enter Zipcode" id="current_zipcode_id" value="{{$userData->getCurrentZipcode()}}" />
                                <span class="text-danger error" id="error_currentzipcode"></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input name="currentaddress" type="text" class="form-control" placeholder="Enter Address" id="current_address" value="{{$userData->getCurrentAddress()}}"/>
                                <span class="text-danger error" id="error_currentaddress"></span>
                            </div>
                            <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="1"  name="present" onclick="addressSame()" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Same as Present
                                </label>
                            </div>
                        </div>
                    </div>

                    <h3 class="my-4">Permanent Address</h3>

                    <div class="row">
                         <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="state">State</label>
                                <input name="permanent_state_id" type="text" class="form-control" placeholder="Enter State"  id="permanent_state_id" value="{{$userData->getPermanentState()}}" /> 
                                <span class="text-danger error" id="error_permanent_state_id"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="city">City</label>
                               <input name="permanent_city_id" type="text" class="form-control" placeholder="Enter City" id="permanent_city_id" value="{{$userData->getPermanentCity()}}" />
                               <span class="text-danger error" id="error_permanent_city_id"></span>
                            </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select name="selectedPermanentCountry" id="permanent-countries" class="form-control country js-select2"  value="{{$userData->getPermanentCountry()}}">
                                    <option value="">Select Country</option>
                                     @foreach($countries as $country)
                                        <option value="{{ $country->_id }}" @if($userData->getPermanentCountry() == $country->name ) selected @endif  >{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error" id="error_selectedPermanentCountry"></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Zipcode</label>
                                <input type="number" name="permanentzipcode" class="form-control" placeholder="Enter Zipcode" id="permanent_zipcode_id" value="{{$userData->getZipAddress()}}" />
                                <span class="text-danger error" id="error_permanentzipcode"></span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="permanentaddress" class="form-control" placeholder="Enter Address" id="permanent_address" value="{{$userData->getPermanetAddress()}}" />
                                <span class="text-danger error" id="error_permanentaddress"></span>
                            </div>
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
                                <button class="btn commonButton modalsubmiteffect" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
function addressSame()
{
  $('#permanent_state_id').val($('#current_state_id').val());
  $('#permanent_city_id').val($('#current_city_id').val());
  $('#permanent-countries').val($('#current-countries').val()).trigger('change');
  $('#permanent_zipcode_id').val($('#current_zipcode_id').val());
  $('#permanent_address').val($('#current_address').val());
  
}

$('#personalInformation').on('submit', function (event) {
    		event.preventDefault();
             var formData = $(this).serialize();
            console.log(formData);
  			$.ajax({
                type: 'post',
                url: "{{ route('addPersonalInformation')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                    console.log(data);
                    $('.error').html('');
                    if($.isEmptyObject(data.errors)){
                    window.location = "/employee-profile/<?=$userData->_id?>";
                    }else{
                    	$.each( data.errors, function( key, value ) {
                    		$('#error_'+key).html(value)
                    	})
                    }
            	} 
                
            });

		});


</script>
</x-admin-layout>