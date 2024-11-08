<?php 
if(isset($_SESSION['Nivo']))
{
    require_once("php/konekcija.php");

    if(!isset($_POST['Sacuvaj']))
    {   
        $sifrez = $_GET["sifrez"];

        $stmt = $mysqli->prepare("SELECT * FROM rezervacija WHERE SifraRezervacije = ?");   // Prepared statement for fetching reservation details
        $stmt->bind_param("i", $sifrez);
        $stmt->execute();
        $rez = $stmt->get_result();
        $red = $rez->fetch_assoc();
        $stmt->close();

        $DatumKreiranja = date("Y-m-d");
        $SifraRezervacije = $red['SifraRezervacije'];
        $SifraGosta = $red['SifraGosta'];
        $RedniBrojMesta = $red['RedniBrojMesta'];
        $SatorPrikolica = $red['SatorPrikolica'];
        $KorisnikID = $_SESSION['ID'];

        $DatumPocetka = $red['DatumPocetka'];
        $DatumZavrsetka = $red['DatumZavrsetka'];
        $timestamp1 = strtotime($DatumPocetka);
        $timestamp2 = strtotime($DatumZavrsetka);
        $difference = abs($timestamp2 - $timestamp1);
        $BrojNocenja = floor($difference / (60 * 60 * 24));

        $stmt2 = $mysqli->prepare("SELECT * FROM ponuda WHERE Obrisan = 0");  // Prepared statement for fetching available offers
        $stmt2->execute();
        $rez2 = $stmt2->get_result();

    ?> 
    <h2>Kreiranje specifikacije</h2><br>
    <form action="" method="post">
        <div class="form-group">
            <label class="control-label col-md-2" for="DatumKreiranja">Datum kreiranja</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="DatumKreiranja" name="DatumKreiranja" type="date" value="<?php echo $DatumKreiranja ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="SifRez">Šifra rezervacije</label>
            <div class="col-md-10">
                <input  class="form-control text-box single-line" name="SifRez" readonly id="SifRez" type="number" value="<?php echo $SifraRezervacije ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="SifraGosta">Šifra gosta</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="SifraGosta" name="SifraGosta" type="number" value="<?php echo $SifraGosta ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="SifraPonude">Ponuda</label>
            <div class="col-md-10">
                <select class="form-control select" data-val="true" required data-val-required="Morate odabrati ponudu." id="SifraPonude" name="SifraPonude">
                    <?php
                    while($red2 = $rez2->fetch_assoc())
                    { ?>
                        <option value="<?php echo $red2['SifraPonude'] ?>"><?php echo $red2['NazivPonude'] .'&nbsp'. $red2['Popust'] . "%"?></option><br>
                    <?php }
                    $stmt2->close();
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo $RedniBrojMesta ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="SatorPrikolica" name="SatorPrikolica" type="number" value="<?php echo $SatorPrikolica ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="KorisnikID">KorisnikID</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="KorisnikID" name="KorisnikID" type="number" value="<?php echo $KorisnikID ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="BrojNocenja">Broj nocenja</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="BrojNocenja" name="BrojNocenja" type="number" value="<?php echo $BrojNocenja ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="Sacuvaj" name="Sacuvaj" class="btn btn-default"> 
            </div><br>
        </div>
        <div>
            <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - nazad na rezervacije</a>
        </div>
    </form><br>

    <?php
    }    
    else
    {
        if(isset($_POST['SifraPonude']))
        {
            $SifraPonude = $_POST['SifraPonude'];

            // Prepared statement for inserting a new specification
            $stmt3 = $mysqli->prepare("INSERT INTO specifikacija (DatumKreiranja, SifraRezervacije, SifraGosta, SifraPonude, RedniBrojMesta, SatorPrikolica, KorisnikID, BrojNocenja) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt3->bind_param("siiiiiii", $_POST['DatumKreiranja'], $_POST['SifRez'], $_POST['SifraGosta'], $_POST['SifraPonude'], $_POST['RedniBrojMesta'], $_POST['SatorPrikolica'], $_POST['KorisnikID'], $_POST['BrojNocenja']);
            $rez3 = $stmt3->execute();

            if(!$rez3)
            {
                die("Greska: ".$stmt3->error);
            }
            else
            { ?>
                <h3>Uspesno ste kreirali specifikaciju!</h3>
                <div>
                    <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Nazad na listu rezervacija</a>
                </div><br>
                <div>
                    <a class="btn btn-info btn-sm active" href="specifikacije.php?sve">Pregled specifikacija</a>
                </div>
        <?php   
                $stmt3->close();

                $stmt4 = $mysqli->prepare("UPDATE rezervacija SET StatusRezervacije = 'realizovana' WHERE SifraRezervacije = ?");// Prepared statement for upd. reservation stts
                $stmt4->bind_param("i", $_POST['SifRez']);
                $stmt4->execute();
                $stmt4->close();

                $stmt5 = $mysqli->prepare("UPDATE gost SET StatusGosta = 'Odjavljen' WHERE SifraGosta = ?"); // Prepared statement for updating guest status
                $stmt5->bind_param("i", $_POST['SifraGosta']);
                $stmt5->execute();
                $stmt5->close();
            }
        }
        else
        {
            echo '<script type="text/javascript">alert("Morate odabrati ponudu kako bi ste kreirali specifikaciju!");</script>';
        }
    } 
}
else
{ ?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a></strong><br><br>

<?php
}
?>