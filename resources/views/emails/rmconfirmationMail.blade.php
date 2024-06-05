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

<p>This is to inform that <?=$name?>  who has joined on <?=date('d M Y',strtotime($joining_date))?> will complete his/her probation period this month and will be due for confirmation on <?=(date('d M Y ', strtotime('+ 6 months', strtotime($joining_date))))?> </p>

<br/>

<p>Please give your approval whether HR department can proceed for employee confirmation letter or not ?</p>

<br/>

<p>Regards</p>
</body>
</html>