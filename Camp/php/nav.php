<?php session_start(); ?>

<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="http://localhost/Kamp/pocetna.php">Kamp - Pocetna</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="oNama.php">O nama</a></li>
				<li><a href="kontakt.php">Kontakt</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php 

				if(isset($_SESSION['Username'])){
					?>
					<li><p style="color:white;"> Dobrodosli <?php echo $_SESSION['Username']; ?> </p></li>
					<li><a href="logout.php" id="logoutLink">Logout</a></li>
					<?php 
				}else{
					?>
					<li><a href="logovanje.php" id="loginLink">Ulogujte se</a></li>
					<li><a href="registracija.php" id="regLink">Registracija</a></li>			
				<?php
				}	
				?>
			</ul>				
		</div>
	</div>
</div>
<br><br><br>