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

<?=$name?> [<?=$employe_code?>] has withdrawn the leave.
<br/>
Following are the details:

<br/>
<p>
Employee : <?=$name?>  [<?=$employe_code?>]
</p>
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
}
?>
	</p>
	<p>From Date: <?=date('d M Y',$from_date)?></p>
	<p>To Date: <?=date('d M Y',$to_date) ?></p>
	<p>Number of days: <?=date($number_of_days)?></p>
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
<p>
Regards  
</p>
<br/>

<p>Note:This is an auto-generated mail. Please do not reply.
</p>
<br/>
<p>PS: "This e-mail is generated from workplace.softuvo.click"</p>

</body>
</html>