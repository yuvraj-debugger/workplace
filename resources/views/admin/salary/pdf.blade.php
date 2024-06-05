<?php 
$allTotalDeduction=0;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laravel 10 Generate PDF Example - Webappfix</title>
<link rel="stylesheet">
<style>
.payslip-title {
	text-align: center;
}
</style>
</head>
<body>
<table style="width: 100%; border-bottom: 1px solid #ddd; margin-bottom: 20px">
		<tr>
			<td style="text-align: center; font-size: 20px; font-weight: 600; padding: 0 0 10px;">Payslip for the month of <?=date('M,Y',strtotime($employeeSalary->created_at))?></td>
		</tr>
</table>
		
	<table style="width: 100%;">
		<tr>
			<td>
<!-- 				<img src="{{asset('images/logo.png')}}" class="inv-logo" alt="Logo"> -->
					<img style="width: 100%; max-width: 50px;" src="https://workplace.softuvo.click/images/mini-logo-green.svg" />
			</td>
			<td></td>
		</tr>

		<tr>
			<td style="vertical-align: top; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
				<p style="margin: 0;">Softuvo Solutions Pvt. Ltd.</p>
				<p style="margin: 0;">D-199, Phase 8B, Industrial Area, Sector 74,</p>
				<p style="margin: 0;">Sahibzada Ajit Singh Nagar, Punjab 160055</p>
			</td>
			<td style="vertical-align: top; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
				<h3 style="margin: 0">Payslip #<?=$employeeSalary->getRemoveID()?><?=date('m',strtotime($employeeSalary->created_at))?><?=date('y',strtotime($employeeSalary->created_at))?></h3>
				Salary Month: <span><?=date('M, Y',strtotime($employeeSalary->created_at))?></span>
			</td>
		</tr>

		<tr>
			<td style="padding: 15px 0 0 0"><strong>Employee Name : </strong>
				{{$employeeSalary->getEmployee()}}<br /> <strong>Designation : </strong>
				{{$employeeSalary->getEmployeeDesignation()}}<br /> <strong>Employee
					Id : </strong> {{$employeeSalary->getEmployeeId()}}<br /> <strong>Joining
					Date : </strong> {{$employeeSalary->getEmployeeJoiningDate()}}</td>
			<td></td>
		</tr>
	</table>
	<table style="width: 100%; border-collapse: collapse; margin-top: 20px">
		<tr>
			<td style="font-size: 20px; font-weight: 600; padding: 5px;">Earning</td>
			<td  style="font-size: 20px; font-weight: 600; padding: 5px;">Deduction</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%; border-collapse: collapse;">
					<tr>
						
					</tr>
						@foreach(json_decode($employeeSalary->earning) as $payroll)
											@if($payroll->addition_bonus != '1')
					<tr>
						<td  style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><strong style="display: inline-block;"><?=$payroll->name?>:</strong> <span style="display: inline-block;"> ₹ <?=$payroll->value?></span></td>
					</tr>
											@endif
					@endforeach
				@if(! empty($employeeSalary->overtime))
					                     	<tr>
												<td style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><strong>Overtime</strong> <span class="float-end"><?=$employeeSalary->overtime?></span></td>
											</tr>
										@endif
										<tr>
												<td style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><b><strong>Gross Salary</strong></b> <span class="float-end"><?=$employeeSalary->net_salary;?></span></td>
											</tr>
											@foreach(json_decode($employeeSalary->earning) as $payroll)
											@if($payroll->addition_bonus == '1')
											@php
											$employeeSalary->net_salary = $employeeSalary->net_salary + $payroll->value;
 											@endphp
											<tr>
											<td style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><strong><?=$payroll->name?></strong> <span class="float-end"><?=$payroll->value?></span></td>
											</tr>
										    @endif
											@endforeach
											@if(! empty($employeeSalary->overtime))
					                     	<tr>
												<td style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><strong>Overtime</strong> <span class="float-end"><?=$employeeSalary->overtime?></span></td>
											</tr>
										@endif
					
					
					
				</table>
			</td>

			<td>
				<table style="width: 100%; border-collapse: collapse;">
					<tr>
						
					</tr>
					@foreach($payrollDeduction as $deduction)
					<?php 
					$allTotalDeduction+=$deduction->value;
					?>
					<tr>
						<td  style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><strong style="display: inline-block;"><?=$deduction->name?>:</strong> <span style="display: inline-block;"> ₹ <?=$deduction->value?></span></td>
					</tr>
					@endforeach
					  @if(! empty($employeeSalary->employee_deduction))
					                     <tr>
												<td style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><strong>Deduction</strong> <span class="float-end"><?=$employeeSalary->employee_deduction?></span></td>
											</tr>
										@endif
										<?php 
										
										$TotalDeduction =  $allTotalDeduction + (! empty($employeeSalary->employee_deduction) ? $employeeSalary->employee_deduction : 0);
										
										?>
										<tr>
												<td style="font-size: 16px; border: 1px solid #ddd; padding: 6px;"><b><strong>Total Deduction: ₹ </strong></b> <span class="float-end"><?=$TotalDeduction?></span></td>
											</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php 
	
	
	$number =$employeeSalary->net_salary - $TotalDeduction + $employeeSalary->overtime - $employeeSalary->employee_deduction ;
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
	<table>
		<tr>
			<td style="padding-top: 20px;"><strong>Net Salary: ₹ <?= ($employeeSalary->net_salary - $TotalDeduction) + $employeeSalary->overtime?>  </strong>(<?=$result."Rupees  ".'Only'?>)</td>
		</tr>

	</table>
</body>
</html>