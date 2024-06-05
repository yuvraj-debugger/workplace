<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link
	href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
	rel="stylesheet">
</head>
<body>
Hi ,

<?=$name?> [<?=$employe_code?>] has applied for a leave.
<br />
	<p>Your leave application has been <?php
	if($leave_status == '2'){
	    echo "Approved";
	}elseif($leave_status == '3'){
	    echo "Rejected";
	}
	    ?></p>
	<p>Leave Type:
	
	<?php
if ($leave_type == '1') {
    echo "Casual Leave";
} elseif ($leave_type == '2') {
    echo "Sick Leave";
} elseif ($leave_type == '3') {
    echo "Earned Leave";
} elseif($leave_type == '4') {
    echo "Loss Of Pay";
}elseif($leave_type == '5') {
    echo "Comp - Off";
}elseif($leave_type == '6') {
    echo "Bereavement Leave";
}elseif($leave_type == '7') {
    echo "Maternity Leave";
}elseif($leave_type == '8') {
    echo "Paternity Leave";
}elseif($leave_type == '9') {
    echo "Emergency Leave";
}

?>
	</p>
	<p>From Date: <?=date('d M Y',strtotime($from_date))?></p>
	<p>To Date: <?=date('d M Y',strtotime($to_date)) ?></p>
	<p>Number of days: <?=date($number_of_days)?></p>
	<p>Reason:<?=$reason?></p>
	<p>Leave Balance:
	<?php 
	if($leave_type == '1'){
	    echo ! empty($leaveBalanced->casual_leave) ? $leaveBalanced->casual_leave : '0';
	}elseif ($leave_type == '2') {
	    echo  ! empty($leaveBalanced->sick_leave) ? $leaveBalanced->sick_leave : '0';
	}elseif ($leave_type == '3') {
	    echo  ! empty($leaveBalanced->earned_leave) ? $leaveBalanced->earned_leave : '0';
	}elseif ($leave_type == '4') {
	    echo  ! empty($leaveBalanced->loss_of_pay_leave) ? $leaveBalanced->loss_of_pay_leave : '0';
	}elseif ($leave_type == '5') {
	    echo  ! empty($leaveBalanced->comp_off) ? $leaveBalanced->comp_off : '0';
	}elseif ($leave_type == '6') {
	    echo  ! empty($leaveBalanced->bereavement_leave) ? $leaveBalanced->bereavement_leave : '0';
	}elseif ($leave_type == '7') {
	    echo  ! empty($leaveBalanced->maternity_leave) ? $leaveBalanced->maternity_leave : '0';
	}elseif ($leave_type == '8') {
	    echo  ! empty($leaveBalanced->paternity_leave) ? $leaveBalanced->paternity_leave : '0';
	}
	
	?>
	</p>
	<p>From Session:
	<?php
if ($from_session == '1') {
    echo "Session 1";
} else {
    echo "Session 2";
}
?></p>
	<p>To Session: <?php
if ($to_session == '1') {
    echo "Session 1";
} else {
    echo "Session 2";
}

?></p>

<br/>
<p>Regards</p> 
<br/>
<p>{{$rm}}</p>





</body>
</html>