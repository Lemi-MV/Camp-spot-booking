<?php 
if (isset($_SESSION['Nivo'])) {
    require_once("php/konekcija.php");

    if (isset($_GET['sifspec']) && is_numeric($_GET['sifspec'])) {
        $SifSpec = (int)$_GET['sifspec']; 

        $upit = "SELECT * FROM specifikacija WHERE SifraSpecifikacije = ?"; //preapring statement for specification query
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $SifSpec);
        $stmt->execute();
        $rez = $stmt->get_result();
        $red = $rez->fetch_assoc();

        if ($rez->num_rows < 1) {
            echo "<h3>Nije moguće prikazati detalje željene specifikacije!</h3><br>";
            echo "<strong><a style='color:black; font-size: 20px;' href='http://localhost/Kamp/pocetna.php'>Povratak na početnu stranu ⮌</a></strong>";
            exit;
        }

        $gost = $red['SifraGosta'];                       // preparing data for view
        $SatPrik = $red['SatorPrikolica'];
        $satp = ($SatPrik == 0) ? "Šator" : "Prikolica";  // preparing statement for "guest"

        $stmt2 = $mysqli->prepare($upit2);  
        $stmt2->bind_param("i", $gost);
        $stmt2->execute();
        $rez2 = $stmt2->get_result();
        $red2 = $rez2->fetch_assoc();

        $ponuda = $red['SifraPonude'];                             // preparing statement for "offer"
        $upit3 = "SELECT * FROM ponuda WHERE SifraPonude = ?";
        $stmt3 = $mysqli->prepare($upit3);
        $stmt3->bind_param("i", $ponuda);
        $stmt3->execute();
        $rez3 = $stmt3->get_result();
        $red3 = $rez3->fetch_assoc();

        $korisnik = $red['KorisnikID'];
        $upit4 = "SELECT * FROM korisnici WHERE KorisnikID = ?";  // preparing statement for "user"
        $stmt4 = $mysqli->prepare($upit4);
        $stmt4->bind_param("i", $korisnik);
        $stmt4->execute();
        $rez4 = $stmt4->get_result();
        $red4 = $rez4->fetch_assoc();

        ?>

        <h3>Detalji specifikacije</h3>

        <div class="form-group">
            <label class="control-label col-md-2" for="SifraSpecifikacije">Šifra specifikacije</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="SifraSpecifikacije" name="SifraSpecifikacije" type="number" value="<?php echo htmlspecialchars($red['SifraSpecifikacije']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="DatumKreiranja">Datum kreiranja</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="DatumKreiranja" name="DatumKreiranja" type="date" value="<?php echo htmlspecialchars($red['DatumKreiranja']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="SifRez">Šifra rezervacije</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="SifRez" name="SifRez" type="number" value="<?php echo htmlspecialchars($red['SifraRezervacije']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="Gost">Gost</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="Gost" name="Gost" type="text" value="<?php echo htmlspecialchars($red2['Ime'] . ' ' . $red2['Prezime'] . ' broj LK: ' . $red2['BrojLicneKarte']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="SifraPon">Ponuda</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="SifraPon" name="SifraPon" type="text" value="<?php echo htmlspecialchars($red3['NazivPonude'] . ' ' . $red3['Popust'] . "%"); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo htmlspecialchars($red['RedniBrojMesta']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="SatPrik">Šator / Prikolica</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="SatPrik" name="SatPrik" type="text" value="<?php echo htmlspecialchars($satp); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="Koris">Kreirao</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="Koris" name="Koris" type="text" value="<?php echo htmlspecialchars($red4['Username']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="BrojNocenja">Broj noćenja</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="BrojNocenja" name="BrojNocenja" type="number" value="<?php echo htmlspecialchars($red['BrojNocenja']); ?>">
            </div>
        </div>

        <a class="btn btn-info btn-sm active" href="specifikacije.php?sve">Nazad na specifikacije</a>
    <?php
        $stmt->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
    } else {
        echo "<h3>Neispravan unos!</h3>";
    }
} else {
    ?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br><br>
    <strong>
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu ⮌</a> &emsp;
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a>
    </strong><br><br>
<?php
}
?>
