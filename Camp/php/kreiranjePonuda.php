<?php

if (isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 4) {
    require_once("php/konekcija.php");

    if (!isset($_POST['dugme'])) {
        ?>
        <h3>Kreiranje nove ponude</h3><br>
        <form action="kreiranjePonude.php" method="post">
            <div class="form-group">
                <label class="control-label col-md-2" for="NazivPonude">Naziv ponude</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required data-val="true" data-val-required="Morate uneti naziv ponude." id="NazivPonude" name="NazivPonude" type="text" value="">
                    <span class="field-validation-valid text-danger" data-valmsg-for="NazivPonude" data-valmsg-replace="true"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="Opis">Opis</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required data-val="true" data-val-required="Morate uneti opis ponude." id="Opis" name="Opis" type="text" value="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Popust">Popust</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required data-val="true" data-val-number="The field Popust must be a number." data-val-range="Dozvoljene su samo pozitivne vrednosti od 0 do 100" max="100" min="0" data-val-required="Morate uneti popust." id="Popust" name="Popust" type="number" value="">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" value="Kreiraj" name="dugme" class="btn btn-default">
                </div>
            </div>
        </form>
        <br>
        <div>
            <a class="btn btn-info btn-sm active" href="ponudaIndex.php">Odustani - povratak na listu</a>
        </div>
        <?php
    } elseif (isset($_POST['dugme'])) {
        if (isset($_POST['NazivPonude']) && isset($_POST['Opis']) && isset($_POST['Popust'])) {
            $stmt = $mysqli->prepare("INSERT INTO ponuda (NazivPonude, Opis, Popust) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $_POST['NazivPonude'], $_POST['Opis'], $_POST['Popust']);

            if (!$stmt->execute()) {
                die("Greska: " . $stmt->error);
            } else {
                ?>
                <h3>Uspesno ste kreirali ponudu!</h3>
                <div>
                    <a class="btn btn-info btn-sm active" href="ponudaIndex.php">Povratak na listu</a>
                </div>
                <?php
            }

            $stmt->close();
        } else {
            echo '<script type="text/javascript">alert("Morate uneti sve podatke kako bi ste kreirali ponudu!");</script>';
        }
    }
} else {
    ?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br>
    </strong>
    <?php
}
?>
