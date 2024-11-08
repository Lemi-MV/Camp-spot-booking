<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Registracija</title>
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
 <h3>Kreirajte novi nalog</h3>
 <div class="slike">
		<div class="slikaRegistracija">
			<img src="images/kampPrikolica2.jpg" alt="Slika 9" width="900px" height="600px">
		</div>
	</div><br><br>
  <form action="reg.php" method="post"><br>
    <div class="form-group">
        <label class="control-label col-md-2" for="username">Username</label>
        <div class="col-md-10">
          <input type="text" id="username" required name="username" autofocus>
        </div>
    </div><br>
    <div class="form-group">
        <label class="control-label col-md-2" for="email">E-mail</label>
        <div class="col-md-10">       	
            <input type="email" id="email" required name="email">
        </div>
    </div><br>
    <div class="form-group">
       <label class="control-label col-md-2" for="passw">Password</label>
       <div class="col-md-10">
           <input type="password" id="passw" required name="passw">
       </div>
   </div><br>
   <div class="form-group">
       <label class="control-label col-md-2" for="confpass">Confirm password</label>
       <div class="col-md-10">
           <input type="password" id="confpass" required name="confpass">
       </div>
   </div><br>
   <div class="form-group">
    <div class="col-md-10">  
      <button name="dugme" id="dugme" value="reg" type="submit" class="btn btn-success">Registruj se</button>
    </div>
  </div>
</form><br>
<?php
  include "php/foot.php";
?>
</div>
</body>
</html>
