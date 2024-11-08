<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Proces kreiranja Rezervacije</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">
</head>
<body>
	<div class="container body-content">
<?php 
	include "php/nav.php";
    if(isset($_POST['dugme']) && ($_POST['dugme']=="PretraziSat" || $_POST['dugme']=="PretraziPrik" ))
    {
		include "php/slobodnaMesta.php";	
    }
    
    if(isset($_GET['cmd']) && $_GET['cmd']=="sve")
    {
    	include "php/svaMesta.php";
    }

	if(isset($_GET['tip']))
	{
		include "php/tipMesta.php";
	}

    if(isset($_GET['nova']))
    {
    	include "php/kreiranjeMesta.php";
    }	

    if(isset($_GET['rbs']))
	{
		include "php/izmenaMesta.php";
	}

	if(isset($_GET['rbsb']))
	{
		include "php/brisanjeMesta.php";
	}
?>
<?php 	
	include "php/foot.php";
?>
	</div>
</body>
</html>