@foreach($employeeAddition as $payroll)
<div class="input-block mb-3">
	<label class="col-form-label"><?=$payroll->name?></label> <input
		class="form-control" type="text" name="{{$payroll->_id}}" id="earning_{{$payroll->_id}}">
</div>
@endforeach


