<?php 
if(isset($_SESSION['Nivo']) && $_GET['cmd'] == "sve")
{ 
	require_once("php/konekcija.php");  ?>
<div class="row">
<br><br><br>
    <div class="col-md-6">
        <h3>Mesta za šatore</h3>
        <p><a class="btn btn-success btn-sm active" href="mesta.php?tip=sat">Šatorska mesta</a></p><br><br>
        <div class="slike">
		    <div class="slikaMesta">
			    <img src="images/gomilaSatora2.jpg" alt="Slika 3" width="700px" height="450px">
		    </div>
	    </div>
    </div>
    <div class="col-md-6">
        <h3>Mesta za prikolice i kamper kombije</h3>
        <p><a class="btn btn-success btn-sm active" href="mesta.php?tip=prik">Mesta za prikolice</a></p><br><br>
        <div class="slike">
		    <div class="slikaMesta">
			    <img src="images/prikolice.jpg" alt="Slika 3" width="600px" height="450px">
		    </div>
	    </div>
    </div>
</div>
<br><br><br><br><br><br><br><br><br>
    
<?php 
}else
{ ?>  
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br>
    </strong>
<?php 
} ?>