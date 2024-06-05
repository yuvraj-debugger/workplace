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
Dear <?=$name?>,
<br/>
<br /> 
<p>I hope this message finds you well. After careful consideration your probation period has been extended until <?=(date('d M Y ', strtotime('+'. $probation_period.'months', strtotime($joining_date))))?> We appreciate your efforts and look forward to continued collaboration.
 </p>
 
 <br/>
 
 <p>Best regards, </p>
<br/>
<p>Team HR</p>
<br/>
</body>
</html>