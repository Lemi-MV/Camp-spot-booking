<?php 
if (isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 5) {
    include_once("php/konekcija.php");
    if (!isset($_POST['Sacuvaj'])) {
?>
        <h3>Kreiranje mesta</h3>
        <br><br>
        <h4><strong>Napomena: U polje Tip upisuje se ISKLJUCIVO JEDNA OD DVE OPCIJE -> "Satorsko" ili "Za prikolicu" (bez navodnika). </strong>
            U polje <i>Sator/Prikolica</i> potrebno je uneti 0 u slucaju kreiranja satorkog mesta, a 1 u slucaju kreiranja mesta za prikolicu/kamper. 
            U polje <i>rentira</i> unosi se 0 ukoliko se na mestu ne nalazi ni sator ni prikolica/kamper, a 1 u slucaju da se na mestu nalazi sator ili prikolica/kamper, koji zajedno sa mestom rentiramo. 
            Ukoliko se kreira satorsko mesto u polja <i>StrujaPrikljucak</i> i <i>VodaPrikljucak</i> treba uneti 0, jer ne postoje mesta za satore sa ovim prikljuccima. 
        </h4>
        <br><br>
        <form action="" method="post">
            <fieldset>
                <div class="form-group">
                    <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2" for="Tip">Tip</label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="Tip" name="Tip" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2" for="Opis">Opis</label>
                    <div class="col-md-10">
                        <textarea class="form-control textarea" required id="Opis" name="Opis"></textarea>
                    </div>
                </div>    

                <div class="form-group">
                    <label class="control-label col-md-2" for="Kapacitet">Kapacitet</label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="Kapacitet" name="Kapacitet" type="number" value="">
                    </div>
                </div>  

                <div class="form-group">
                    <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica </label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="SatorPrikolica" name="SatorPrikolica" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2" for="Rentira">Rentira</label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="Rentira" name="Rentira" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2" for="StrujaPrikljucak">Struja prikljucak</label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="StrujaPrikljucak" name="StrujaPrikljucak" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2" for="VodaPrikljucak">Voda prikljucak</label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="VodaPrikljucak" name="VodaPrikljucak" type="text" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2" for="Cena">Cena</label>
                    <div class="col-md-10">
                        <input class="form-control text-box single-line" required id="Cena" name="Cena" type="number" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" value="Sacuvaj" name="Sacuvaj" class="btn btn-default">
                    </div>
                    <div>
                        <a class="btn btn-info btn-sm active" href="mesta.php?cmd=sve">Odustani - nazad na listu</a>
                    </div>
                </div>
            </fieldset>   
        </form>

<?php
    } elseif (isset($_POST['Sacuvaj']) && $_POST['Sacuvaj'] == 'Sacuvaj') {
        if (!empty($_POST['RedniBrojMesta']) && !empty($_POST['Tip']) && !empty($_POST['Opis']) && !empty($_POST['Kapacitet']) && 
            isset($_POST['SatorPrikolica']) && isset($_POST['Rentira']) && isset($_POST['StrujaPrikljucak']) && 
            isset($_POST['VodaPrikljucak']) && !empty($_POST['Cena'])) {

            $stmt = $mysqli->prepare("INSERT INTO smestaj (RedniBrojMesta, Tip, Opis, Kapacitet, SatorPrikolica, Rentira, StrujaPrikljucak, VodaPrikljucak, Cena) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt) {
                $stmt->bind_param("issiiiiii", $_POST['RedniBrojMesta'], $_POST['Tip'], $_POST['Opis'], $_POST['Kapacitet'], 
                                  $_POST['SatorPrikolica'], $_POST['Rentira'], $_POST['StrujaPrikljucak'], 
                                  $_POST['VodaPrikljucak'], $_POST['Cena']);
                
                if ($stmt->execute()) {
?>
                    <h3>Uspesno ste kreirali mesto!</h3>
                    <div>
                        <a class="btn btn-info btn-sm active" href="mesta.php?cmd=sve">Nazad na izbor tipa smestaja</a>
                    </div>
<?php
                } else {
                    echo "<strong><p style='color: black; font-size: 20px;'>Greška prilikom kreiranja mesta: " . htmlspecialchars($stmt->error) . "</p></strong>";
                }
                $stmt->close();
            } else {
                echo "<strong><p style='color: black; font-size: 20px;'>Greška prilikom pripreme upita: " . htmlspecialchars($mysqli->error) . "</p></strong>";
            }
        } else {
            echo "<strong><p style='color: black; font-size: 20px;'>Sva polja su obavezna!</p></strong>";
        }
    }
} else {
?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br>
    <strong>
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a>
        &emsp; &emsp; &emsp;
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a>
    </strong>
<?php
}
?>
