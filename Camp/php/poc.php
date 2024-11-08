<div class="row">

<?php  

require_once("php/konekcija.php");

if(!isset($_SESSION['Nivo'])) {  ?>
	<div class="naslovna">
		<div class="slikaNaslovna">
			<img src="images/prikolicaSumrak.jpg" alt="Slika 1" width="900px" height="750px">
		</div>
	</div>

<?php
     }

if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 6 && $_SESSION['Nivo'] > 2){	?>
	
	<div class="naslovna">
		<div class="slikaNaslovna">
			<img src="images/izSatora.jpg" alt="Slika 1" width="600px" height="450px">
		</div>
	</div><br>
	<div class="col-md-4">
		<h2>Rezervacije</h2>
		<p>Na ovoj strani mogu da se dodaju, menjaju i brišu rezervacije.
		</p>
		<p><a class="btn btn-default" href="rezervacijaIndex.php?cmd=cek">Otvori stranu »</a></p>
	</div>
	<div class="col-md-4">
		<h2>Gosti</h2>
		<p>Na ovoj strani mogu da se dodaju, menjaju i brišu gosti.</p>
		<p><a class="btn btn-default" href="gostIndex.php?gos=svi">Otvori stranu »</a></p>
	</div>
	<div class="col-md-4">
		<h2>Specifikacije</h2>
		<p>Na ovoj strani mogu da se pregledaju sve specifikacije.</p>
		<p><a class="btn btn-default" href="specifikacije.php?sve">Otvori stranu »</a></p>
	</div>
	<div class="col-md-4">
		<h2>Mesta</h2>
		<p>Na ovoj strani mozete pregledati sve kapacitete kampa.</p>
		<p><a class="btn btn-default" href="mesta.php?cmd=sve">Otvori stranu »</a></p>
	</div>
	<div class="col-md-4">
		<h2>Ponude</h2>
		<p>Na ovoj strani se dodaju, menjaju i brišu ponude.</p>
		<p><a class="btn btn-default" href="ponudaIndex.php">Otvori stranu »</a></p>
	</div>
<?php  }	

if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] > 6){   ?>
	<div class="naslovna">
		<div class="slikaNaslovna">
			<img src="images/satorUSumi.jpg" alt="Slika 1" width="500px" height="700px">
		</div>
	</div><br>
	<div class="col-md-4">
		<h2>Rezervacije</h2>
		<p>Na ovoj strani se kreira rezervacija.
		</p>
		<p><a class="btn btn-default" href="rezervacijaIndex.php?cmd=cek">Otvori stranu »</a></p>
	</div>
	<div class="col-md-4">
		<h2>Licni podaci</h2>
		<p>Na ovoj strani se unose podaci o gostu.</p>
		<p><a class="btn btn-default" href="gostIndex.php?gos=svi">Otvori stranu »</a></p>
	</div>
<?php 
	$korID = $_SESSION['ID'];
	$upit2 = "SELECT * FROM gost WHERE KorisnikID = ?";
	$stmt = $mysqli->prepare($upit2);
	$stmt->bind_param("i", $korID);
	$stmt->execute();
	$rez2 = $stmt->get_result();

	if($rez2->num_rows > 0){
?>
	<div class="col-md-4">
		<h2>Specifikacije</h2>
		<p>Na ovoj strani mogu da se pregledaju prethodne specifikacije.</p>
		<p><a class="btn btn-default" href="specifikacije.php?sve">Otvori stranu »</a></p>
	</div>
	<?php  }
?>	
	<div class="col-md-4">
		<h2>Mesta</h2>
		<p>Na ovoj strani mozete pregledati sve kapacitete kampa.</p>
		<p><a class="btn btn-default" href="mesta.php?cmd=sve">Otvori stranu »</a></p>
	</div>
	<div class="col-md-4">
		<h2>Ponude</h2>
		<p>Na ovoj strani mozete pregledati postojece ponude.</p>
		<p><a class="btn btn-default" href="ponudaIndex.php">Otvori stranu »</a></p>
	</div>
<?php } 

if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 2){	?>
	<div class="col-md-4">
		<h2>Podesavanje rola</h2>
		<p>Na ovoj strani se podesavaju role.
		</p>
		<p><a class="btn btn-default" href="rolaIndex.php">Otvori stranu »</a></p>
	</div>
<?php 
	}  ?>

</div>
