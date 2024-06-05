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
Dear RM,
<br /> 
<p>This is to inform that <?=$name?> who has joined on <?=$joining_date ?> will complete his/her probation period this month and will be confirmed on <?=(date('d M Y ', strtotime('+ 6 months', strtotime($joining_date))))?> </p>
<br/>

<p>Kindly proceed further with the confirmation of employee .</p>
<br/>

<p>Regards</p>
<br/>
<p>Team HR</p>
</body>
</html>