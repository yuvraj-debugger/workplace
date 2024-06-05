@foreach($employeeDeduction as $deduction)
<div class="input-block mb-3">
	<label class="col-form-label"><?=$deduction->name?></label> <input
		class="form-control" type="text" name="{{$deduction->_id}}" id="earning_{{$deduction->_id}}">
</div>
@endforeach