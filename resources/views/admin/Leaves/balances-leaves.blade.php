<?php
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
$nog =  date('n',strtotime($user->joining_date));
if($nog >= 15){
    $joining_date = (date('Y-m-01', strtotime('+ 2 months', strtotime($user->joining_date))));
    
}elseif($nog < 15 ){
    $joining_date = (date('Y-m-01', strtotime('+ 3 months', strtotime($user->joining_date))));
}
?>
<x-admin-layout>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Leaves Balances</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Leaves
						Balances</li>
				</ol>
			</nav>
		</div>
<?php 
$role = Role::where('_id', Auth::user()->user_role)->first();
if((Auth::user()->user_role==0) || (!empty($role)&&($role->name=='Management')) || (!empty($role)&&($role->name=='HR'))){
?>
		<div class="pageFilter mb-3">
			<div class="row leaves">
				<div class="col-xl-9 col-lg-9 col-md-8">
					<form method="get" action="">
						<div class="leftFilters">
							<div class="col-xl-2 col-lg-2 form-group mt-0">
								<label for="floatingSelect">Employee</label>  
								<select class="form-control js-select2" name="myEmployee" id="myEmployee">
                                    @foreach($employees as $employee)
                                    <option   value="{{$employee->_id}}"  {{ ($id == $employee->_id) ? 'selected' : '' }}>{{$employee->first_name.' '.$employee->last_name}} ({{$employee->employee_id}})</option>
                                    @endforeach
                                </select>

							</div>
						</div>
					</form>

				</div>

			</div>
		</div>
		
<?php }?>
		<div class="setting">
			<div class="dashboardSection">

				<div class="row">
					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Loss Of Pay</h3>
								<p>Granted: <?= ! empty($leaveBalanced->loss_of_pay_leave) ? $leaveBalanced->loss_of_pay_leave  : 0?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter"><?= ! empty($leaveBalanced->loss_of_pay_leave) ? $leaveBalanced->loss_of_pay_leave  : 0?></h1>
							<hr />
						</div>
					</div>

					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Bereavement Leave</h3>
								<p>Granted: <?=($user->workplace == '1') ?  $masterLeave->office_bereavement_leave : $masterLeave->home_bereavement_leave ?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter">
							@if(strtotime($joining_date)<=strtotime(date('Y-m-d')))
							
								<?=! empty($leaveBalanced) ? $leaveBalanced->bereavement_leave  :0?>
							@else
							0
							@endif
							</h1>
							<hr />
						</div>
					</div>
					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Casual Leave</h3>
								<p>Granted: <?=($user->workplace == '1') ?  $masterLeave->office_casual_leave : $masterLeave->home_casual_leave ?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter">
							@if(strtotime($joining_date)<=strtotime(date('Y-m-d')))
							<?=! empty($leaveBalanced->casual_leave) ? $leaveBalanced->casual_leave  :0?>
							@else
							0
							@endif
							</h1>
							<hr />
						</div>
					</div>
					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Sick Leave</h3>
								<p>Granted: <?=($user->workplace == '1') ?  $masterLeave->office_sick_leave : $masterLeave->home_sick_leave ?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter">
							@if(strtotime($joining_date)<=strtotime(date('Y-m-d')))
							<?=! empty($leaveBalanced->sick_leave) ? $leaveBalanced->sick_leave  : 0?>
							@else
							0
							@endif
							</h1>
							<hr />
						</div>
					</div>
					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Comp Off</h3>
								<p>Granted: <?=! empty($leaveBalanced->comp_off) ? $leaveBalanced->comp_off : 0?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter">
							@if(strtotime($joining_date)<=strtotime(date('Y-m-d')))
							<?=! empty($leaveBalanced->comp_off) ? $leaveBalanced->comp_off : 0?>
							@else
							0
							@endif
							</h1>
							<hr />
						</div>
					</div>
								<?php
								if($user->gender == 'male'){
								if (! empty($leaveBalanced->months)) {
								    if ((strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime('+' . $leaveBalanced->months . 'months', strtotime($user->joining_date)))))) {
            ?>
					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Paternity Leave</h3>
								<p>Granted: <?=($user->workplace == '1') ?  $masterLeave->office_paternity_leave : $masterLeave->home_paternity_leave ?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter">
							@if(strtotime($joining_date)<=strtotime(date('Y-m-d')))
							<?=! empty($leaveBalanced->paternity_leave) ? $leaveBalanced->paternity_leave  :0?>
							@else
							0
							@endif
							</h1>
							<hr />
						</div>
					</div>
						<?php }}}?>
								<?php
								if($user->gender == 'female'){
								if (! empty($leaveBalanced->months)) {
								    if ((strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime('+' . $leaveBalanced->months . 'months', strtotime($user->joining_date)))))) {
            ?>
					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Maternity Leave</h3>
								<p>Granted: <?=($user->workplace == '1') ?  $masterLeave->office_maternity_leave : $masterLeave->home_maternity_leave ?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter">
							@if(strtotime($joining_date)<=strtotime(date('Y-m-d')))
							<?=! empty($leaveBalanced->maternity_leave) ? $leaveBalanced->maternity_leave  :0?>
							@else
							0
							@endif
							</h1>
							<hr />
						</div>
					</div>
						<?php }}}?>
					<?php
    if (! empty($leaveBalanced->earned_months)) {
        if ((strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime('+' . $leaveBalanced->earned_months . 'months', strtotime($user->joining_date)))))) {
            ?>
					<div class='col-xxl-4 col-xl-6'>
						<div class="profileCard commonBoxShadow rounded-1 holidayCard">
							<div class="cardHeading">
								<h3>Earned Leave</h3>
								<p>Granted: <?=($user->workplace == '1') ?  $masterLeave->office_earned_leave : $masterLeave->home_earned_leave ?></p>
							</div>
							<p>Balance</p>
							<h1 class="leaveCounter">
							@if(strtotime($joining_date)<=strtotime(date('Y-m-d')))
							<?=! empty($leaveBalanced->earned_leave) ? $leaveBalanced->earned_leave  :0?>
							@else
							0
							@endif</h1>
							<hr />
						</div>
					</div>
					<?php }}?>
					
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function() {

$('#myEmployee').change(function() {
console.log('<?=url('/leave-balances')?>/'+this.value);
    window.location.href='<?=url('/leave-balances')?>/'+this.value;
});
});
</script>
</x-admin-layout>