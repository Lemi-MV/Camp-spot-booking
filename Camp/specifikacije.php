<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Specifikacija</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">
</head>
<body>
	<div class="container body-content">
	<br><br>
<?php 
	include "php/nav.php";

	if(isset($_GET['sve']))
	{
		include "php/sveSpecifikacije.php";
	}

	if(isset($_GET['sifspec']))
	{
		include "php/detaljiSpecifikacije.php";
	}

	if(isset($_GET['sifrez']))
	{
		include "php/kreiranjeSpecifikacije.php";
	}
	
	include "php/foot.php";
?>
	</div>
</body>
</html>