<?php 

session_start();


if (isset($_SESSION['Username'])) 
  {
    session_unset();
    session_destroy();
   }
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Logout</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">
</head>
<body>
	<div class="container body-content">
<?php 	include "php/nav.php"; ?>	

<h3>Izlogovani ste!</h3><br><br>
	<div class="slike">
		<div class="slikaLogout">
			<img src="images/ognjistePrikolica.jpg" alt="Slika 7" width="900px" height="750px">
		</div>
	</div><br><br>
	<strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu ⮌</a> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp;
	<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a>
	</strong> 

<?php include "php/foot.php"; ?>
	</div>
</body>
</html>