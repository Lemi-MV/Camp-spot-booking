<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>O nama</title>
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
        <h2>O nama</h2>
        <div class="slike">
		<div class="slikaONama">
			<img src="images/kampDzip.jpg" alt="Slika 8" width="900px" height="600px">
		</div>
	</div><br><br>
        <div class="col-md-10"><h4>
            Projekat Web aplikacija Kamp realizovan je kao završni rad skolske 2022/2023 godine u Beogradu,
        od strane Milenka Vorkapića 302/19, studenta 3. godine ITS-a, smera Informacione tehnologije.</h4><br>
        </div>
    <div class="col-md-10"><h4>
        Projektovana je i implementirana aplikacija za rezervisanje
        smeštaja u kampu. Role koje korisnicima aplikacije mogu biti dodeljene su gost, recepcioner i admin, što može da učini samo posebna rola - superadmin.
        Aplikacija pruža mogućnost za kreiranje, izmenu i brisanje mesta u kampu, ponuda i gostiju. Zatim, kreiranje, izmenu i otkazivanje rezervacija, kreiranje specifikacija i
        uvid u njihove detalje, uvid u sve goste (prijavljene i odjavljene), pregled svih mesta (šatorska i za kampere/prikolice) i 
        pregled svih rezervacija (aktivne, na čekanju, realizovane i otkazane).    
        Recepcioner ima mogućnost da radi sve sa rezervacijama i gostima, ali može samo videti ponude i mesta, te nema mogućnost da menja ili briše, 
        ni ponude ni mesta, niti može da pregleda realizovane rezervacije.
        Administrator može da izvršava sve navedene aktivnosti. Svaki korisnik, nezavisno od role, pre početka svog rada u aplikaciji mora da se uloguje.
    </h4>
    </div>
<?php 
include "php/foot.php";
?>
</div>
</body>
</html>