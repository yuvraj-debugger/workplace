<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
<h3 class="text-center">Personal Information</h3>
	<form method="post" enctype="multipart/form-data" class="px-3" id="addPersonalInformation">
				@csrf
				  	<input type="hidden" name="employee_id" id="employee_id" value="<?=$employee_id?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" name="gender" id="gender" class="form-control js-select2">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="WhatsApp">Whatsapp</label>
                                <input name="whatsapp" type="number" class="form-control" placeholder="Enter Whatsapp" id="whatsapp" value="{{$userDetails->whatsapp}}"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Personal Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Personal Email" value="{{$userDetails->email}}"/>
                                                                   <span class="text-danger error" id="error_email"></span> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nationality">Nationality<sup>*</sup></label>
                                <select name="nationality"  class="form-control country js-select2" id="nationality">
                                    <option value="">Select Nationality</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                   <span class="text-danger error" id="error_nationality"></span> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Religion</label>
                                <input type="text" name="religion" class="form-control" placeholder="Enter Religion" value="{{$userDetails->religion}}"/>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="bloodGroup">Blood Group</label>
                                <input name="blood_group" type="text" class="form-control" placeholder="Enter Blood Group" value="{{$userDetails->blood_group}}"/>
                                

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="martialStatus">Martial Status<sup>*</sup></label>
                                <select name="marital_status" class="form-control js-select2" id="marital_status">
                                    <option value="">Select Martial Status</option>
                                    <option value="married">Married</option>
                                    <option value="single">Single</option>
                                </select>
                                 <span class="text-danger error" id="error_marital_status"></span> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Employment of Spouse</label>
                                <select name="spouse_employment" class="form-control js-select2" id="spouse_employment">
                                    <option value="" selected>Select Spouse Employment</option>
                                    <option value="private">Private</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No. of Children</label>
                                    <input name="children" type="text" class="form-control" placeholder="No. of Children" value="{{$userDetails->children}}" />  
                                 @error("children")
                                    <span class="error text-danger">{{$message}}</span>
                                @endError
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Passport No.</label>
                                <input name="passport_number" type="text" class="form-control" placeholder="Enter Passport No."  value="{{$userDetails->passport_number}}"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Passport Expiry Date</label>
                                <input name="passport_expiry_date" type="date" class="form-control" placeholder="Enter Date" value="{{date('Y-m-d',$userDetails->passport_expiry_date)}}"/>
                            </div>
                        </div>

                    </div>

                    <h3 class="my-4">Current Address</h3>

                    <div class="row">
                         <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="state">State</label>
                                <input name="current_state_id" id="current_state_id" type="text" class="form-control" placeholder="Enter State" value="{{$userAddress->current_state_id}}"/> 
                               
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="city">City</label>
                                 <input name="current_city_id" id="current_city_id" type="text" class="form-control" placeholder="Enter City" value="{{$userAddress->current_city_id}}" />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select name="selectedCurrentCountry" id="current-countries" class="form-control country js-select2">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->_id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Zipcode</label>
                                <input type="number" name="currentzipcode"  id="currentzipcode" class="form-control" placeholder="Enter Zipcode" value="{{$userAddress->current_zipcode}}" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input name="currentaddress" type="text" class="form-control" id="currentaddress" placeholder="Enter Address" value="{{$userAddress->current_address}}" />
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="1" onclick="copyAddress()" name="present" id="flexCheckDefault">
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
                                <input name="permanent_state_id" type="text" id="permanent_state_id" class="form-control" placeholder="Enter State" value="{{$userAddress->permanent_state_id}}" /> 
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group mt-0">
                                <label for="city">City</label>
                               <input name="permanent_city_id" type="text" class="form-control" id="permanent_city_id" placeholder="Enter City" value="{{$userAddress->permanent_city_id}}" /> 
                            </div>
                        </div>
                         <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select name="permanent_country_id" id="permanent-countries" class="form-control country js-select2">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->_id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Zipcode</label>
                                <input type="number" name="permanent_zipcode" class="form-control" id="permanent_zipcode" placeholder="Enter Zipcode" value="{{$userAddress->permanent_zipcode}}" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="permanentaddress" class="form-control" placeholder="Enter Address" id="permanent_address" value="{{$userAddress->permanent_address}}" />
                            </div>
                        </div>

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
  $('#addPersonalInformation').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            var emp_id = $('#employee_id').val();
            $.ajax({
                type: 'post',
                url: "{{ route('savePersoanlInformation')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
      			if($.isEmptyObject(data.errors)){      			
                window.location = "/employee-profile/"+emp_id;
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#error_'+key).html(value)
                	})
                }
                },
            });
        });

$('#gender').val("<?=$userDetails->gender?>").trigger('change');
$('#nationality').val("<?=$userDetails->nationality?>").trigger('change');
$('#marital_status').val("<?=$userDetails->marital_status?>").trigger('change');
$('#spouse_employment').val("<?=$userDetails->spouse_employment?>").trigger('change');
$('#current-countries').val("<?=$userAddress->current_country_id?>").trigger('change');
$('#permanent-countries').val("<?=$userAddress->permanent_country_id?>").trigger('change');


function copyAddress(){
    $('#permanent_state_id').val($('#current_state_id').val());
    $('#permanent_city_id').val($('#current_city_id').val());
    $('#permanent-countries').val($('#current-countries').val()).trigger('change');
    $('#permanent_zipcode').val($('#currentzipcode').val());
    $('#permanent_address').val($('#currentaddress').val());
}
</script>

</x-admin-layout>