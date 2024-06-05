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
Dear <?=$rm_name?>,
<br/>
<br /> 
<p>I hope this email finds you well. <?=$name?> 's probation period has been extended until <?=(date('d M Y ', strtotime('+'. $probation_period.'months', strtotime($joining_date))))?> Your support in helping [him/her] navigate this period is greatly appreciated.
 </p>
 <br/>

<p>Best regards, </p>

<p>Team HR</p>
<br/>
</body>
</html>