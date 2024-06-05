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

<?=$name?> [<?=$employe_code?>] Your Comp - Off request has been <?php
	if($leave_status == '2'){
	    echo "Approved";
	}elseif($leave_status == '3'){
	    echo "Rejected";
	}
	    ?>
<br /> 
<br/>
	<p>From Date: <?=date('d M, Y',strtotime($from_date))?></p>
	<p>To Date: <?=date('d M, Y',strtotime($to_date))?></p>
	<p>Number of days: <?=date($number_of_days)?></p>
	<p>Reason:<?=$reason?></p>
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

<p>Note: This is an auto-generated mail. Please do not reply.</p>
<br/>
<p>PS: "This e-mail is generated from workplace.softuvo.click"</p>

</body>
</html>