<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<form method="post" enctype="multipart/form-data"
			id="addBankStatutory">
			@csrf <input type="hidden" name="id" id="edit_skills_id" value="" />
			<input type="hidden" name="user_id" id="user_id"
				value="{{$userData->_id}}">
								<label><b>ESI Account</b></label>
				    <div class="form-check mt-3">
				    <input class="form-check-input" type="checkbox" value="1"  {{! empty($userbankstatutory->esi)?'checked':''}}
							name="esi" id="esi_employee_check"> 
                            
                            <label class="form-check-label" for="EmployeeCheck">
                                Employee is covered under ESI
                            </label>
                        </div>
			<div class="row">

				<div class="col-lg-6" id="esi_number" style="{{! empty($userbankstatutory->esi)?'':'display:none'}}">
					<div class="form-group">
						<label>ESI Number</label> <input type="number" name="esi_number" 
							value="{{! empty($userbankstatutory) ? $userbankstatutory->esi_number :''}}" class="form-control" placeholder="Enter ESI Number" />
							                            							<span class="text-danger error" id="errorbank_esi_number"></span>
							
					</div>
				</div>

				<div class="col-lg-6" id="branch_office" style="{{! empty($userbankstatutory->esi)?'':'display:none'}}">
					<div class="form-group">
						<label>Branch Office</label> <input type="text" 
							name="branch_office" class="form-control" value="{{! empty($userbankstatutory) ? $userbankstatutory->branch_office : ''}}"
							placeholder="Enter Branch Office" />
							<span class="text-danger error" id="errorbank_branch_office"></span>
					</div>
				</div>

				<div class="col-lg-6" id="dispensary" style="{{! empty($userbankstatutory->esi)?'':'display:none'}}">
					<div class="form-group">
						<label>Dispensary</label> <input type="text" name="dispensary" 
							value="{{! empty($userbankstatutory) ? $userbankstatutory->dispensary :''}}" class="form-control" placeholder="Enter dispensary" />
							<span class="text-danger error" id="errorbank_dispensary"></span>

					</div>
				</div>

				<div class="col-lg-12" id="previous_checkbox" style="{{! empty($userbankstatutory->esi)?'':'display:none'}}">
					<div class="form-check mt-3">
						<input class="form-check-input" type="checkbox" value="1" {{! empty($userbankstatutory->previous_employment)?'checked':''}}
							name="previous_employment" id="previous_employment"> <label
							class="form-check-label" for="flexCheckDefault1"> In case of any
							previous employment please fill up the details as under. </label>
					</div>
				</div>
				<div class="col-lg-6" id="previous_ins_no" style="{{! empty($userbankstatutory->previous_employment)?'':'display:none'}}">
					<div class="form-group">
						<label>Previous Ins. No.</label> <input type="text"
							name="previousInsNo" value="{{! empty($userbankstatutory) ? $userbankstatutory->previousInsNo : ''}}" class="form-control" id="previousInsNo" 
							placeholder="Previous Ins. No." />
							<span class="text-danger error" id="errorbank_previousInsNo"></span>

					</div>
				</div>
				<div class="col-lg-6" id="previous_employee_code" style="{{! empty($userbankstatutory->previous_employment)?'':'display:none'}}">
					<div class="form-group">
						<label>Employer's Code No.</label> <input type="text"
							name="employerCode" value="{{! empty($userbankstatutory) ? $userbankstatutory->employerCode : ''}}" class="form-control"
							placeholder="Employer's Code No." />
							<span class="text-danger error" id="errorbank_employerCode"></span>
							
					</div>
				</div>
				<div class="col-lg-6" id="previous_address_employer" style="{{! empty($userbankstatutory->previous_employment)?'':'display:none'}}">
					<div class="form-group">
						<label>Name & Address of the Employer</label> <input type="text"
							name="nameAddress" class="form-control" value="{{! empty($userbankstatutory) ? $userbankstatutory->nameAddress :''}}"
							placeholder="Name & Address of the Employer" />
							<span class="text-danger error" id="errorbank_nameAddress"></span>
							
					</div>
				</div>
				<div class="col-lg-6" id="previous_employee_email" style="{{! empty($userbankstatutory->previous_employment)?'':'display:none'}}">
					<div class="form-group">
						<label>Email</label> <input type="text" name="employerEmail" value="{{! empty($userbankstatutory) ? $userbankstatutory->employerEmail :''}}"
							class="form-control" placeholder="Enter Email" />
							<span class="text-danger error" id="errorbank_employerEmail"></span>
							

					</div>
				</div>
				<div class="col-lg-12" id="nominee_checkbox" style="{{! empty($userbankstatutory->esi)?'':'display:none'}}">
					<div class="form-check mt-3">
						<input class="form-check-input" type="checkbox" value="1" {{! empty($userbankstatutory->nominee_detail)?'checked':''}}
							name="nominee_detail" id="nominee_detail"> <label
							class="form-check-label" for="flexCheckDefault2"> Details of
							Nominee u/s 71 of ESI Act 1948/Rule-56(2) of ESI (Central) Rules,
							1950 for payment of cash benefit in the event of death </label>
					</div>
				</div>
				<div class="col-lg-6" id="nomine_name" style="{{! empty($userbankstatutory->nominee_detail)?'':'display:none'}}">
					<div class="form-group">
						<label>Name</label> <input type="text" name="nomineeName" value="{{! empty($userbankstatutory) ? $userbankstatutory->nomineeName : ''}}"
							class="form-control" placeholder="Enter Name" />
							<span class="text-danger error" id="errorbank_nomineeName"></span>
					</div>
				</div>
				<div class="col-lg-6" id="nominee_relationship" style="{{! empty($userbankstatutory->nominee_detail)?'':'display:none'}}">
					<div class="form-group">
						<label>Relationship</label> <input type="text"
							name="nomineeRelationship" value="{{! empty($userbankstatutory) ? $userbankstatutory->nomineeRelationship : ''}}" class="form-control"
							placeholder="Enter Relationship" />
							<span class="text-danger error" id="errorbank_nomineeRelationship"></span>
					</div>
				</div>
				<div class="col-lg-6" id="nominee_address" style="{{! empty($userbankstatutory->nominee_detail)?'':'display:none'}}">
					<div class="form-group">
						<label>Address</label> <input type="text" name="nomineeAddress"
						    value="{{! empty($userbankstatutory) ? $userbankstatutory->nomineeAddress : ''}}"
							class="form-control" placeholder="Enter Address" />
							<span class="text-danger error" id="errorbank_nomineeAddress"></span>
					</div>
				</div>
				<div class="col-lg-12" id="family_checkbox" style="{{! empty($userbankstatutory->esi)?'':'display:none'}}">
					<div class="form-check mt-3">
						<input class="form-check-input" type="checkbox" value="1" {{! empty($userbankstatutory->family_particular)?'checked':''}}
							name="family_particular" id="family_particular"> <label
							class="form-check-label" for="flexCheckDefault3">Family
							Particulars of Insured person</label>
						<div class="row">
							<div class="col-lg-6" id="particular_name" style="{{! empty($userbankstatutory->family_particular)?'':'display:none'}}">
								<div class="form-group">
									<label>Name</label> <input type="text" name="particularName"
										value="{{! empty($userbankstatutory) ? $userbankstatutory->particularName : ''}}" class="form-control" placeholder="Enter Address" />
										<span class="text-danger error" id="errorbank_particularName"></span>
								</div>
							</div>
							<div class="col-lg-6" id="particular_dob" style="{{! empty($userbankstatutory->family_particular)?'':'display:none'}}">
								<div class="form-group">
									<label>Date of Birth</label> <input type="date"
										name="particularDateofbirth" value="{{! empty($userbankstatutory) ? $userbankstatutory->particularDateofbirth : ''}}" class="form-control"
										placeholder="Enter Address" />
										<span class="text-danger error" id="errorbank_particularDateofbirth"></span>
								</div>
							</div>
							<div class="col-lg-6" id="particular_relationship" style="{{! empty($userbankstatutory->family_particular)?'':'display:none'}}">
								<div class="form-group">
									<label>Relationship</label> <input type="text"
										name="particularRelationship" value="{{! empty($userbankstatutory) ? $userbankstatutory->particularRelationship : ''}}" class="form-control"
										placeholder="Enter Address" />
										<span class="text-danger error" id="errorbank_particularRelationship"></span>
								</div>
							</div>
						</div>
						<p class="">Whether residing with him/her</p>
						<div class="d-flex">
							<div class="form-check me-2">
								<input class="form-check-input" type="radio" value="1"
									id="residing_yes" name="residing" onclick="showYes()"> <label
									class="form-check-label" for="flexRadioDefault10">Yes</label>
							</div>

							<div class="form-check">
								<input class="form-check-input" type="radio" value="0" onclick="showNo()"
									id="residing_no" name="residing"> <label
									class="form-check-label" for="flexRadioDefault1">No</label>
							</div>
						</div>
						<div class="col-lg-6" id="residing_place" style="display:none">
							<div class="form-group">
								<label>Place of Residance</label> <select name="residancePlace"
									class="form-control">
									<option value="town" @if(!empty( $userbankstatutory->residing_place) == 'town') ? seleted : '' @endif>Town</option>
									<option value="state" @if(!empty($userbankstatutory->residing_place) == 'state') ? seleted : '' @endif>State</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			
				<div class="col-lg-12">
					<div class="form-check mt-3">
						<input class="form-check-input" type="checkbox" value="1"  {{! empty($userbankstatutory->pf)?'checked':''}}
							name="pf" id="pf_checkbox"> <label class="form-check-label"
							for="flexCheckDefault"> Employee is covered under PF </label>
					</div>
				</div>
				<div class="row" style="">
				<div class="col-lg-6" id="uan_number_div" style="{{! empty($userbankstatutory->pf)?'':'display:none'}}">
					<div class="form-group">
						<label>UAN</label> <input type="number" name="uan" value="{{!empty($userbankstatutory) ? $userbankstatutory->uan :''}}" id="uan_number"
							class="form-control" placeholder="Enter UAN" />
							<span class="text-danger error" id="errorbank_uan"></span>
					</div>
				</div>

				<div class="col-lg-6" id="pf_number_div" style="{{! empty($userbankstatutory->pf)?'':'display:none'}}">
					<div class="form-group">
						<label>PF Number</label> <input type="text" name="pf_number" id="pf_number"
							value="{{!empty($userbankstatutory) ? $userbankstatutory->pf_number :''}}" class="form-control" placeholder="Enter PF Number" />
					</div>
				</div>
				<div class="col-lg-6" id="pf_date" style="{{! empty($userbankstatutory->pf)?'':'display:none'}}" >
					<div class="form-group">
						<label>PF Join Date</label> <input type="date" name="pf_joinDate" id="pf_joinDate" value=""
							class="form-control" placeholder="Enter Join Date" />
					</div>
				</div>
				<div class="col-lg-6" id="fund_scheme" style="{{! empty($userbankstatutory->pf)?'':'display:none'}}"> 
					<div class="form-group">
						<label>Whether earlier a member of Employees provident Fund Scheme
							1952?</label>
						<div class="d-flex">
							<div class="form-check me-2">
								<input class="form-check-input" name="pf_scheme" value="1"
									type="radio" name="pf_scheme" id="yes_pf_scheme"> <label
									class="form-check-label" for="flexRadioDefault2"> Yes </label>
							</div>

							<div class="form-check">
								<input class="form-check-input" name="pf_scheme" value="0"
									type="radio" name="pf_scheme" id="no_pf_scheme"> <label
									class="form-check-label" for="flexRadioDefault3"> No </label>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-6" id="pension_scheme" style="display:none">
					<div class="form-group">
						<label>Whether earlier a member of Employees ‘Pension Scheme
							,1995?</label>
						<div class="d-flex">
							<div class="form-check me-2">

								<input class="form-check-input" name="pension_scheme" value="1"
									type="radio" name="pension_scheme" id="yes_pension_scheme"> <label
									class="form-check-label" for="flexRadioDefault4"> Yes </label>
							</div>
							<div class="form-check">
								<input class="form-check-input" name="pension_scheme" value="0"
									type="radio" name="pension_scheme" id="no_pension_scheme"> <label
									class="form-check-label" for="flexRadioDefault5"> No </label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary modalcanceleffect"
					data-bs-dismiss="modal">Close</button>&nbsp;
				<button type="submit" class="btn commonButton modalsubmiteffect">Submit</button>
			</div>
		</form>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$('#previous_employment').click(function(){
        if($(this).is(":checked")){
            $('#previous_ins_no').show();
            $('#previous_employee_code').show();
            $('#previous_address_employer').show();
            $('#previous_employee_email').show();
        }else{
        $('#previous_ins_no').hide();
            $('#previous_employee_code').hide();
            $('#previous_address_employer').hide();
            $('#previous_employee_email').hide();
        }
});
$('#nominee_detail').click(function(){
        if($(this).is(":checked")){
            $('#nomine_name').show();
            $('#nominee_relationship').show();
            $('#nominee_address').show();
        }
        else{
            $('#nomine_name').hide();
            $('#nominee_relationship').hide();
            $('#nominee_address').hide();
        }
});
$('#family_particular').click(function(){
        if($(this).is(":checked")){
            $('#particular_name').show();
            $('#particular_dob').show();
            $('#particular_relationship').show();
        }
        else{
            $('#particular_name').hide();
            $('#particular_dob').hide();
            $('#particular_relationship').hide();
        }
});


function showYes()
{
  document.getElementById('residing_place').style.display = 'block';
}

function showNo()
{
  document.getElementById('residing_place').style.display = 'none';

}
$('#esi_employee_check').click(function(){
 if($(this).is(":checked")){
    $('#esi_number').show();
    $('#branch_office').show();
    $('#dispensary').show();
    $('#previous_checkbox').show()
    $('#nominee_checkbox').show();
    $('#family_checkbox').show();
 }else{
  
    $('#esi_number').hide();
    $('#branch_office').hide();
    $('#dispensary').hide();
    $('#previous_checkbox').hide()
    $('#nominee_checkbox').hide();
    $('#family_checkbox').hide()
           
 }


})

$('#pf_checkbox').click(function(){
        if($(this).is(":checked")){
            $('#uan_number_div').show();
            $('#pf_number_div').show();
            $('#pf_date').show();
            $('#fund_scheme').show();
            $('#pension_scheme').show();
        }
        else{
            $('#uan_number_div').hide();
            $('#pf_number_div').hide();
            $('#pf_date').hide();
            $('#fund_scheme').hide();
            $('#pension_scheme').hide();
        }
});

		$('#addBankStatutory').on('submit', function (event) {
    		event.preventDefault();
    		var formData = new FormData(this);
    		
  			$.ajax({
                type: 'post',
                url: "{{ route('addbankstatutory')}}",
                data: formData,
                contentType:false,
                processData:false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                window.location = "/employee-profile/<?=$userData->_id?>?activetab=accountStatutory";
                }else{
                	$.each( data.errors, function( key, value ) {
                		$('#errorbank_'+key).html(value)
                	})
                }
            	} 
                
            });

		});
		
		
		


    
          var residing_yes_check = $('#residing_yes').val();
                    var residing_no_check = $('#residing_no').val();
          
        if(residing_yes_check === '1'	){
                   $("#residing_yes").prop( "checked", true );
                  showYes();
        }else{
          $("#residing_no").prop( "checked", true );
            showNo();
        
        }
             
            var yes_pf_scheme = $('#yes_pf_scheme').val();
            if(yes_pf_scheme === '1')
              {
                $("#yes_pf_scheme").prop( "checked", true );
             
              }
              else if($('#no_pf_scheme').val() === '0')
              {
                $("#no_pf_scheme").prop( "checked", true );
             
              }
              
              
             var yes_pension_scheme = $('#yes_pension_scheme').val();
            if(yes_pf_scheme === '1')
              {
                $("#yes_pension_scheme").prop( "checked", true );
             
              }else if($('#no_pension_scheme').val() === '0')
              {
                $("#no_pension_scheme").prop( "checked", true );
             
              }
              
              
              

</script>
</x-admin-layout>