<?php session_start(); ?>

<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Gost Index</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">
</head>
<body>
	<div class="container body-content">
<?php
	include "php/nav.php";

	if(isset($_GET['gos']) && $_GET['gos']=="svi")
	{
		include "php/gosti.php";
	}

	if(isset($_GET['gos']) && $_GET['gos']=="pri")
	{	
		include "php/prijavljeniGosti.php";
	}

	include "php/foot.php";
?>
	</div>
</body>
</html>