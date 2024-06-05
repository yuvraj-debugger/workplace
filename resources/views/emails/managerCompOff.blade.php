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

<?=$name?> [<?=$employe_code?>]  
<br /> 
<p>A Comp - Off request from  <?=$name?> [<?=$employe_code?>]  has been sent for your review </p>
<br/>

<p>The details are given below.</p>

<p>Employee: <?=$name?> [<?=$employe_code?>]  </p>

	<p>From Date: <?=date('d M, Y',strtotime($from_date))?></p>
	<p>To Date: <?=date('d M, Y',strtotime($to_date)) ?></p>
	<p>Reason:<?=$reason?></p>
	<p>Number of days: <?=$number_of_days?></p>
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

<p>Click Here <a href="https://newworkplacetest.softuvo.click/my-employee-comp-off">https://newworkplacetest.softuvo.click/</a></p>

<p>Note: This is an auto-generated mail. Please do not reply.
</p>
<br/>
</body>
</html>