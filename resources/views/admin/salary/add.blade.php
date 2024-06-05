<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
    <div class="page-head-box flex-wrap">
			<h3>Add Salary</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url ('/dashboard')}}">Dashboard</a>
					</li>
          <li class="breadcrumb-item"><a href="{{url ('/employee-salary-index')}}">Employee Salary</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Add Salary</li>
				</ol>
			</nav>
		</div>
    <div class="dashboardSection__body">
		<form method="post" id="addSalary">
		@csrf
			<div class="row">
			  <div class="col-lg-6">
          <div class="form-group mt-0">
              <label>Select Employee</label>
              <select class="form-control manager js-select2" name="employee_id"  id="employee_id" required>
                  <option selected value="">Select Employee</option>
                  @foreach($employees as $user)
                      <option value='{{$user->_id}}'>{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} ({{$user->employee_id}})</option>
                  @endforeach
              </select>
          </div>
          <span class="text-danger error" id="error_employee_id"></span> 
      </div>
				<div class="col-lg-6">
            <div class="form-group mt-0">
    					<label>Net Salary</label> 
    					<input class="form-control numbersOnly" class="" type="text" id="net_salary" name="net_salary" required>
    					 <span class="text-danger error" id="error_net_salary"></span> 
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
				<br/>
					<h4 class="FormsubHeadings">Earnings</h4>
					@foreach($payrollAddition as $payroll)
					<div class="form-group mb-3">
						<label class=""><?=$payroll->name?></label> <input
							class="form-control earning" type="text" name="{{$payroll->_id}}" id="earning_{{$payroll->_id}}" value="">
					</div>
					@endforeach
					<div class="addition_extra"></div>
					 <div class="form-group">
    					<label>Overtime</label> 
    					<input class="form-control" type="text" id="overtime" name="overtime">
    					 <span class="text-danger error" id="error_overtime"></span> 
					</div>
				</div>
				
				<div class="col-sm-6">
				<br/>
					<h4 class="FormsubHeadings">Deductions</h4>
					@foreach($payrollDeduction as $deduction)
					<div class="form-group mb-3">
						<label class=""><?=$deduction->name?></label> <input
							class="form-control earning" type="text" name="{{$deduction->_id}}" id="earning_{{$deduction->_id}}">
					</div>
					@endforeach
            <div class="deduction_extra"></div>
            <div class="form-group">
    					<label>Deduction</label> 
    					<input class="form-control" type="text" id="employee_" name="employee_deduction">
    					 <span class="text-danger error" id="error_employee_deduction"></span> 
					</div>
					
				</div>
				
			</div>
			<br/>
			<div class="submit-section">
				<button class="commonButton">Submit</button>
			</div>
		</form>
    </div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>



$('.numbersOnly').keyup(function () { 
    this.value = this.value.replace(/[^0-9\.]/g,'');
});
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
                console.log(response);
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
   
    
    		$('#addSalary').on('submit', function (event) {
    		event.preventDefault();
    		 var formData = $(this).serialize();
  			$.ajax({
                type: 'post',
                url: "{{ route('salaryCreate')}}",
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
