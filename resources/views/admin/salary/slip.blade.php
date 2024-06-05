<x-admin-layout>
<style>
img.inv-logo {
    width: 150px;
}
.payslip-title {
    text-align: center;
}
.invoice-details {
    text-align: end;
}

</style>
<div class="page-wrapper">
	<div class="content container-fluid">
		<div class="page-head-box">
			<h3>Payslip</h3>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">Salary Slip</li>
				</ol>
			</nav>
		</div>
	
		<div class="row">
		<?php 
							
							$number = $employeeSalary->net_salary - $totalDeduction + $employeeSalary->overtime - $employeeSalary->employee_deduction ;
							$no = floor($number);
							$hundred = null;
							$digits_1 = strlen($no);
							$i = 0;
							$str = array();
							$words = array('0' => '', '1' => 'One', '2' => 'Two',
							    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
							    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
							    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
							    '13' => 'Thirteen', '14' => 'Fourteen',
							    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
							    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
							    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
							    '60' => 'Sixty', '70' => 'Seventy',
							    '80' => 'Eighty', '90' => 'Ninety');
							$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
							while ($i < $digits_1) {
							    $divider = ($i == 2) ? 10 : 100;
							    $number = floor($no % $divider);
							    $no = floor($no / $divider);
							    $i += ($divider == 10) ? 1 : 2;
							    if ($number) {
							        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
							        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
							        $str [] = ($number < 21) ? $words[$number] .
							        " " . $digits[$counter] . $plural . " " . $hundred
							        :
							        $words[floor($number / 10) * 10]
							        . " " . $words[$number % 10] . " "
								    . $digits[$counter] . $plural . " " . $hundred;
							    } else $str[] = null;
							}
							$str = array_reverse($str);
							$result = implode('', $str);
							?>
			<div class="col-md-12">
			
				<div class="card">
					<div class="card-body">
						<h4 class="payslip-title">Payslip for the month of <?=date('M,Y',strtotime($employeeSalary->created_at))?></h4>
						<div class="row">
							<div class="col-sm-6 m-b-20">
								<img src="{{asset('images/logo.svg')}}" class="inv-logo" alt="Logo">
								<br/>
								<ul class="list-unstyled mb-0">
									<li>Softuvo Solutions Pvt. Ltd.</li>
									<li>D-199, Phase 8B, Industrial Area, Sector 74,</li>
									<li>Sahibzada Ajit Singh Nagar, Punjab 160055</li>
								</ul>
							</div>
							<div class="col-sm-6 m-b-20">
								<div class="invoice-details">
									<h3 class="text-uppercase">Payslip #<?=$employeeSalary->getRemoveID()?><?=date('m',strtotime($employeeSalary->created_at))?><?=date('y',strtotime($employeeSalary->created_at))?></h3>
									<ul class="list-unstyled">
										<li>Salary Month: <span><?=date('M, Y',strtotime($employeeSalary->created_at))?></span></li>
									</ul>
								</div>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col-lg-12 m-b-20">
								<ul class="list-unstyled">
									<li><h5 class="mb-0">
								   <strong>{{$employeeSalary->getEmployee()}}</strong>
										</h5></li>
									<li><span>{{$employeeSalary->getEmployeeDesignation()}}</span></li>
									<li>Employee ID: {{$employeeSalary->getEmployeeId()}}</li>
									<li>Joining Date: {{$employeeSalary->getEmployeeJoiningDate()}}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div>
									<h4 class="m-b-10">
										<strong>Earnings</strong>
									</h4>
									<table class="table table-bordered">
										<tbody>
											@foreach(json_decode($employeeSalary->earning) as $payroll)
											@if($payroll->addition_bonus != '1')
											<tr>
												<td><strong><?=$payroll->name?></strong> <span class="float-end"><?=$payroll->value?></span></td>
											</tr>
											@endif
					                     @endforeach
					                     
										<tr>
												<td><b><strong>Gross Salary</strong></b> <span class="float-end"><?=$employeeSalary->net_salary;?></span></td>
											</tr>
											@foreach(json_decode($employeeSalary->earning) as $payroll)
											@if($payroll->addition_bonus == '1')
											@php
											$employeeSalary->net_salary = $employeeSalary->net_salary + $payroll->value;
 											@endphp
											<tr>
											<td><strong><?=$payroll->name?></strong> <span class="float-end"><?=$payroll->value?></span></td>
											</tr>
										    @endif
											@endforeach
											@if(! empty($employeeSalary->overtime))
					                     	<tr>
												<td><strong>Overtime</strong> <span class="float-end"><?=$employeeSalary->overtime?></span></td>
											</tr>
										@endif
											
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-sm-6">
								<div>
									<h4 class="m-b-10">
										<strong>Deductions</strong>
									</h4>
									<table class="table table-bordered">
										<tbody>
										
											@foreach(json_decode($employeeSalary->deduction) as $deduction)
											<tr>
												<td><strong><?=$deduction->name?></strong> <span class="float-end"><?=$deduction->value?></span></td>
											</tr>
					                     @endforeach
					                     @if(! empty($employeeSalary->employee_deduction))
					                     <tr>
												<td><strong>Deduction</strong> <span class="float-end"><?=$employeeSalary->employee_deduction?></span></td>
											</tr>
										@endif
										<?php 
										
										$allTotalDeduction =  $totalDeduction + (! empty($employeeSalary->employee_deduction) ? $employeeSalary->employee_deduction : 0);
										
										?>
										<tr>
												<td><b><strong>Total Deduction: ₹ </strong></b> <span class="float-end"><?=$allTotalDeduction?></span></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							</div>
							<br/>
							<div class="col-sm-12 text-center">
								<b><strong>Net Salary: ₹ <?=($employeeSalary->net_salary - $allTotalDeduction) + $employeeSalary->overtime?> </strong></b>(<?=$result."Rupees  ".'Only'?>)
									
							</div>
								<div class="col-auto float-end ms-auto">
								<div class="btn-group btn-group-sm">
									<a class="btn btn-primary" target="_blank" href="/genarate-pdf/{{$employeeSalary->_id}}">Download</a>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</x-admin-layout>
