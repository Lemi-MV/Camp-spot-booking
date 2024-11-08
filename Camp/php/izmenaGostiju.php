<?php

if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 6)
{
    require_once("php/konekcija.php");
    
    if (!isset($_GET['idGost'])) {
        echo "<h3>ID gosta nije prosleđen!</h3>";
        exit;
    }

    if(!isset($_POST["Izmeni"]))
    {
        $stmt = $mysqli->prepare("SELECT * FROM gost WHERE SifraGosta = ?");   // Preaparing statement for fetching guest
        $stmt->bind_param("i", $_GET['idGost']);
        $stmt->execute();
        $rez = $stmt->get_result();
        $red = $rez->fetch_assoc();

        if($rez->num_rows < 1)
        {  ?>
            <h3>Nije moguće prikazati detalje željenog gosta! </h3><br>
            <strong><a style="color:black; font-size: 20px;" href="gostIndex.php?gos=svi">Povratak na listu ⮌</a></strong><br>
        <?php
        }

        $SifraGosta = $red['SifraGosta']; 
        $Ime = $red['Ime'];
        $Prezime = $red['Prezime'];
        $BrojLicneKarte = $red['BrojLicneKarte'];		
        $Adresa = $red['Adresa'];				
        $BrojTelefona = $red['BrojTelefona'];				
        $StatusGosta = $red['StatusGosta'];				
        ?>
        <h2>Izmena gosta</h2>
        <form action="izmenaGosta.php" method="post">
            <div class="form-group">
                <label class="control-label col-md-2" for="SifGo">Šifra gosta</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" disabled id="SifGo" name="SifGo" type="text" value="<?php echo $SifraGosta ?>">
                </div>
            </div>
            <input type="hidden" name="SifraGosta" value="<?php echo $SifraGosta ?>">

            <div class="form-group">
                <label class="control-label col-md-2" for="Ime">Ime</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" data-val="true" required data-val-required="Morate uneti ime gosta." id="Ime" name="Ime" type="text" value="<?php echo $Ime ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Prezime">Prezime</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" data-val="true" required data-val-required="Morate uneti prezime gosta." id="Prezime" name="Prezime" type="text" value="<?php echo $Prezime ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="BrojLicneKarte">Broj lične karte</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" data-val="true" required data-val-range="Dozvoljeni su samo pozitivni brojevi dužine 9 cifara" max="999999999" min="100000000" data-val-required="Morate uneti broj lične karte gosta." id="BrojLicneKarte" name="BrojLicneKarte" type="text" value="<?php echo $BrojLicneKarte ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Adresa">Adresa</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" data-val="true" required data-val-required="Morate uneti adresu gosta." id="Adresa" name="Adresa" type="text" value="<?php echo $Adresa ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="BrojTelefona">Broj telefona</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" data-val="true" required data-val-required="Morate uneti broj telefona gosta." id="BrojTelefona" name="BrojTelefona" type="text" value="<?php echo $BrojTelefona ?>" pattern="06\d\/\d{3}-\d{3,4}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="StatusGosta">Status gosta</label>
                <div class="col-md-10">
                    <select class="form-control select" data-val="true" required data-val-required="Morate odabrati status gosta." id="StatusGosta" name="StatusGosta">
                        <option value="Odjavljen" <?php echo ($StatusGosta == "Odjavljen" ? "selected" : ""); ?>>Odjavljen</option>
                        <option value="Prijavljen" <?php echo ($StatusGosta == "Prijavljen" ? "selected" : ""); ?>>Prijavljen</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" value="Sačuvaj izmene" name="Izmeni" class="btn btn-default">
                </div>
                <div>
                    <a class="btn btn-info btn-sm active" href="gostIndex.php?gos=svi">Odustani - nazad na listu</a>
                </div>
            </div>
        </form><br>
    <?php
    }
    else if($_POST['Izmeni'] == "Izmeni")
    {
        $stmt = $mysqli->prepare("UPDATE gost SET Ime=?, Prezime=?, BrojLicneKarte=?, Adresa=?, BrojTelefona=?, StatusGosta=? WHERE SifraGosta=?");
        $stmt->bind_param("ssssssi", $_POST['Ime'], $_POST['Prezime'], $_POST['BrojLicneKarte'], $_POST['Adresa'], $_POST['BrojTelefona'], $_POST['StatusGosta'], $_POST['SifraGosta']);
        $rez = $stmt->execute();     // Prepared statement for guest updating

        if($rez)
        {
            ?>
            <h3>Uspešno ste izmenili podatke gosta!</h3>
            <div>
                <a class="btn btn-info btn-sm active" href="gostIndex.php?gos=svi">Nazad na listu</a>
            </div>
        <?php
        }    
    } 
}else
{
    ?>
    <h3>Niste ulogovani, nemate mogućnost ove radnje!</h3><br><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br><br></strong>
<?php 
}
?>

<script>
    var brojTelefonaInput = document.getElementById("BrojTelefona");
    var phoneRegex = /^(06\d\/\d{3}-\d{3,4})$/;

    function validatePhoneNumber() {
        var brojTelefona = brojTelefonaInput.value;

        if (phoneRegex.test(brojTelefona)) {
        } else {
            alert("Morate uneti broj telefona u ispravnom formatu: 06x/xxx-xxx(x)");
        }
    }

    brojTelefonaInput.addEventListener("blur", validatePhoneNumber);
</script>
