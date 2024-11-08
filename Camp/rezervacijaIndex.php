<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Rezervacija Index</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">
</head>
<body>
	<div class="container body-content">
<?php 
	include "php/nav.php";

	if(isset($_GET['cmd']) && $_GET['cmd']=="real"){
		include "php/realizovaneRez.php";
	}
	
	if(isset($_GET['cmd']) && $_GET['cmd']=="cek"){
		include "php/rezervacije.php";
	}

	include "php/foot.php";
?>
	</div>
</body>
</html>