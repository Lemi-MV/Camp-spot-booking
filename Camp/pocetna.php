<?php session_start(); ?>

<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Pocetna</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">

</head>
<body> 
	<div class="container body-content">
<?php
	include "php/nav.php";

	if(isset($_SESSION['Ispis']))
	{
		echo $_SESSION['Ispis'];
		$_SESSION['Ispis']="";
	}
?>	
		<div class="jumbotron">
			<h2>Kamp</h2>
			<p class="lead">Zavrsni rad - Kamp</p>
		</div>		
<?php
	include "php/poc.php";

	include "php/foot.php";
?>
	</div>

</body>
</html>