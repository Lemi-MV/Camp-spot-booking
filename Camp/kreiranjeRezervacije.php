<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Kreiranje Rezervacije</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">
</head>
<body>
	<div class="container body-content">
<?php 
	include "php/nav.php";

	if(isset($_POST['dugme']) && $_POST['dugme'] == "Rezervisi"){
		include "php/kreiranjeRezervacija.php";
	}

	if(isset($_POST['dugme']) && $_POST['dugme'] == "sacuvaj"){
		include "php/upisRezervacije.php";
	}
	include "php/foot.php";
?>
	</div>
</body>
</html>