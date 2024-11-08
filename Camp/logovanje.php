<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Logovanje</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/stil.css" rel="stylesheet">
</head>
<body>
	<div class="container body-content">
	<?php
	include "php/nav.php";
	?>
	<h3>Ulogujte se na svoj nalog</h3>
	<form action="log.php" method="post">
		<div class="form-group">
			<div class="form-group">
				<label class="control-label col-md-2" for="un">Username</label><br>
				<div class="col-md-10">
					<input class="form-control text-box single-line" type="text" name="username" id="un" autofocus required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2" for="passw">Password</label><br>
				<div class="col-md-10">
					<input class="form-control text-box single-line" type="password" name="passw" id="passw" required>
				</div>
			</div><br>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-10">
					<button name="dugme" id="dugme" value="log" type="submit" class="btn btn-success">Uloguj se</button>
				</div>
			</div>
		</div>
	</form><br><br><br>
	<div class="slike">
		<div class="slikaLogovanje">
			<img src="images/prikoliceOgradjene.jpg" alt="Slika 10" width="900px" height="600px">
		</div>
	</div><br><br>
	<?php 
	include "php/foot.php";
	?>	
	</div>
</body>
</html>