<?php
session_start();

if (isset($_SESSION['Nivo'])) {
    require_once("php/konekcija.php");

    function sanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    function renderGuestForm($statusRequired = true) {
        ?>
        <h2>Kreiranje novog gosta</h2>
        <form action="kreiranjeGosta.php" method="post" id="gostForma">
            <div class="form-group">
                <label class="control-label col-md-2" for="Ime">Ime</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required id="Ime" name="Ime" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="Prezime">Prezime</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required id="Prezime" name="Prezime" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="BrojLicneKarte">Broj lične karte</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required id="BrojLicneKarte" name="BrojLicneKarte" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="Adresa">Adresa</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required id="Adresa" name="Adresa" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="BrojTelefona">Broj telefona</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required placeholder="06x/xxx-xxx(x)" id="BrojTelefona" name="BrojTelefona" type="text">
                </div>
            </div>
            <?php if ($statusRequired): ?>
            <div class="form-group">
                <label class="control-label col-md-2" for="StatusGosta">Status gosta</label>
                <div class="col-md-10">
                    <select class="form-control select" required id="StatusGosta" name="StatusGosta">
                        <option value="Odjavljen">Odjavljen</option>
                        <option value="Prijavljen">Prijavljen</option>
                    </select>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" value="Kreiraj" name="dugme" class="btn btn-default">
                </div>
            </div>
        </form>
        <br>
        <div>
            <a class="btn btn-info btn-sm active" href="gostIndex.php?gos=svi">Odustani - povratak na listu</a>
        </div>
        <?php
    }

    if ($_SESSION['Nivo'] < 6 || $_SESSION['Nivo'] > 6) {
        if (!isset($_POST['dugme'])) {
            renderGuestForm($_SESSION['Nivo'] < 6);
        } else {
            $ime = sanitizeInput($_POST['Ime']);
            $prezime = sanitizeInput($_POST['Prezime']);
            $brojLicneKarte = sanitizeInput($_POST['BrojLicneKarte']);
            $adresa = sanitizeInput($_POST['Adresa']);
            $brojTelefona = sanitizeInput($_POST['BrojTelefona']);
            $statusGosta = $_SESSION['Nivo'] < 6 ? sanitizeInput($_POST['StatusGosta']) : null;

            if (!empty($ime) && !empty($prezime) && !empty($brojLicneKarte) && !empty($adresa) && !empty($brojTelefona) && ($_SESSION['Nivo'] > 6 || !empty($statusGosta))) {
                $stmt = $mysqli->prepare("INSERT INTO gost (KorisnikID, Ime, Prezime, BrojLicneKarte, Adresa, BrojTelefona, StatusGosta) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $statusValue = $_SESSION['Nivo'] < 6 ? $statusGosta : '';
                $stmt->bind_param("issssss", $_SESSION['ID'], $ime, $prezime, $brojLicneKarte, $adresa, $brojTelefona, $statusValue);

                if ($stmt->execute()) {
                    echo "<h3>Uspešno ste uneli gosta!</h3>";
                } else {
                    die("Greška: " . $stmt->error);
                }
                $stmt->close();
                ?>
                <div>
                    <a class="btn btn-info btn-sm active" href="gostIndex.php?gos=svi">Nazad na listu</a>
                </div>
                <?php
            } else {
                echo '<script>alert("Morate uneti sve podatke kako biste uneli gosta!");</script>';
            }
        }
    } else {
        ?>
        <h3>Niste ulogovani ili nemate pravo pristupa ovom sektoru!</h3><br>
        <strong>
            <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu⮌</a>
            &emsp; &emsp; &emsp;
            <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a>
        </strong>
        <?php
    }
}
?>

<script>
    var brojTelefonaInput = document.getElementById("BrojTelefona");
    var phoneRegex = /^(06\d\/\d{3}\-\d{3,4})$/;

    function validatePhoneNumber() {
        var brojTelefona = brojTelefonaInput.value;

        if (!phoneRegex.test(brojTelefona)) {
            alert("Morate uneti broj telefona u ispravnom formatu: 06x/xxx-xxx(x)");
            return false;
        }
        return true;
    }

    brojTelefonaInput.addEventListener("blur", validatePhoneNumber);
</script>
