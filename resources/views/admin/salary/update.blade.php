<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<h2 class="form-group inner-section1">Edit Salary</h2>
		<form method="post" id="updateSalary">
			@csrf
						<input type="hidden" name="salary_id" id="salary_id" value="{{$editSalary->_id}}">
			
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label>Select Employee</label>
						<input class="form-control" type="text" value="<?=$editSalary->getEmployee()?>"
							disabled>
					</div>
					<span class="text-danger error" id="error_employee_id"></span>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label>Net Salary</label> <input class="form-control" type="text" value="<?=$editSalary->net_salary?>"
							id="net_salary" name="net_salary"> <span
							class="text-danger error" id="error_net_salary"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<br />
					<h4 class="text-success">Earnings</h4>
					@foreach(json_decode($editSalary->earning) as $payroll)
					<div class="input-block mb-3">
						<label class="col-form-label"><?=$payroll->name?></label> <input
							class="form-control earning" type="text" name="{{$payroll->_id}}" value="<?=$payroll->value?>"
							id="earning_{{$payroll->_id}}" value="">
					</div>
					@endforeach
					<div class="addition_extra"></div>
					<div class="form-group">
    					<label>Overtime</label> 
    					<input class="form-control" type="text" id="edit_overtime" name="overtime" value="<?=$editSalary->overtime?>">
    					 <span class="text-danger error" id="error_overtime"></span> 
					</div>
				</div>

				<div class="col-sm-6">
					<br />
					<h4 class="text-success	">Deductions</h4>
					@foreach(json_decode($editSalary->deduction) as $deduction)
					<div class="input-block mb-3">
						<label class="col-form-label"><?=$deduction->name?></label> <input
							class="form-control earning" type="text" name="{{$deduction->_id}}" value="<?=$deduction->value?>"
							id="deduction_{{$deduction->_id}}">
					</div>
					@endforeach
					<div class="deduction_extra"></div>
					<div class="form-group">
    					<label>Deduction</label> 
    					<input class="form-control " type="text" id="employee_" name="employee_deduction" value="<?=$editSalary->employee_deduction?>">
    					 <span class="text-danger error" id="error_employee_deduction"></span> 
					</div>

				</div>
			</div>
			<br />
			<div class="submit-section">
				<button class="commonButton">Submit</button>
			</div>
		</form>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>

  $(document).ready(function(){
      $('#net_salary').on('keyup', function(){
        var inputValue = $(this).val();
         if(inputValue.length != 0)
        {
		$.ajax({
                type: 'post',
                url: "{{ route('getNetSalary')}}",
                data: "inputValue="+inputValue+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                	for (const [key, value] of Object.entries(response)) {
                      $('#earning_'+key).val(value)
                    }
                },
            });
              }
        else
        {
        	$('.earning').val(0);
        }
            $.ajax({
                type: 'post',
                url: "{{ route('getDeduction')}}",
                data: "inputValue="+inputValue+"",
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(response) {
                console.log(response)
                	for (const [key, value] of Object.entries(response)) {
                      $('#deduction_'+key).val(value)
                    }
                },
            });
      });
    });
    
           
   
       
      $(document).ready(function() {
        $("#employee_id").on('change',function(){
        var id = $(this).val();
       $.ajax({
            type: 'post',
            url: "{{ route('getAdditionEmployee')}}",
            data: "id="+id+"",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(response) {
           		$('.addition_extra').html(response);

            },
       });
	});     
   
   });
   
    
      $(document).ready(function() {
        $("#employee_id").on('change',function(){
        var id = $(this).val();
       $.ajax({
            type: 'post',
            url: "{{ route('getEmployeeDeduction')}}",
            data: "id="+id+"",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(response) {
           		$('.deduction_extra').html(response);

            },
       });
	});     
   
   });
   
       		$('#updateSalary').on('submit', function (event) {
    		event.preventDefault();
    		 var formData = $(this).serialize();
  			$.ajax({
                type: 'post',
                url: "{{ route('salaryUpdate')}}",
                data: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(data) {
                $('.error').html('');
                if($.isEmptyObject(data.errors)){
                window.location = "/employee-salary-index";
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
