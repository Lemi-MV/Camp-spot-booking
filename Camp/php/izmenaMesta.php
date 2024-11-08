<?php
if (isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 4) {
    require_once("php/konekcija.php");

    if (!isset($_GET['rbs'])) {
        echo "<h3>ID mesta nije prosleđen!</h3>";
        exit;
    }

    if (!isset($_POST['Izmeni']) && isset($_GET['rbs'])) {
        $stmt = $mysqli->prepare("SELECT * FROM smestaj WHERE RedniBrojMesta = ? AND Obrisan = 0"); //Prepared statement for fetching place
        $stmt->bind_param("i", $_GET['rbs']);
        $stmt->execute();
        $rez = $stmt->get_result();
        $red = $rez->fetch_assoc();

        if ($rez->num_rows < 1) { ?>
            <h3>Nije moguće prikazati detalje željenog mesta! </h3><br>
            <strong><a style="color:black; font-size: 20px;" href="mesta.php?cmd=sve">Povratak na listu ⮌</a></strong>
        <?php
        } else {
            $RedniBrojMesta = $red['RedniBrojMesta'];
            $Tip = $red['Tip'];
            $Opis = $red['Opis'];
            $Kapacitet = $red['Kapacitet'];
            $SatorPrikolica = $red['SatorPrikolica'];
            $Rentira = $red['Rentira'];
            $StrujaPrikljucak = $red['StrujaPrikljucak'];
            $VodaPrikljucak = $red['VodaPrikljucak'];
            $Cena = $red['Cena'];
        ?>
            <h2>Izmena mesta</h2><br>
            <h4>Napomena: U polju <i>rentira</i>, broj 0 znači da je mesto prazno, a broj 1 znači da se nalazi naš šator ili prikolica.</h4>
            <?php if ($Tip == "Za prikolicu") { ?>
                <h4>U poljima <i>struja priključak</i> i <i>voda priključak</i> broj 0 označava da mesto nema taj priključak, a broj 1 da ga poseduje.</h4>
            <?php } ?>
            <br>
            <form action="" method="post">
                <fieldset>
                    <legend><h4><strong><?php echo htmlspecialchars($Tip); ?></strong></h4></legend>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                        <div class="col-md-10">
                            <input class="form-control text-box single-line" readonly id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo htmlspecialchars($RedniBrojMesta); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Tip">Tip</label>
                        <div class="col-md-10">
                            <input class="form-control text-box single-line" readonly id="Tip" name="Tip" type="text" value="<?php echo htmlspecialchars($Tip); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Opis">Opis</label>
                        <div class="col-md-10">
                            <textarea class="form-control textarea" required id="Opis" name="Opis"><?php echo htmlspecialchars($Opis); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Kapacitet">Kapacitet</label>
                        <div class="col-md-10">
                            <input class="form-control text-box single-line" required id="Kapacitet" name="Kapacitet" type="number" value="<?php echo htmlspecialchars($Kapacitet); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="SatorPrikolica">Šator / Prikolica</label>
                        <div class="col-md-10">
                            <input class="form-control text-box single-line" readonly id="SatorPrikolica" name="SatorPrikolica" type="text" value="<?php echo htmlspecialchars($SatorPrikolica); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Rentira">Rentira</label>
                        <div class="col-md-10">
                            <input class="form-control text-box single-line" required id="Rentira" name="Rentira" type="text" value="<?php echo htmlspecialchars($Rentira); ?>">
                        </div>
                    </div>

                    <?php if ($Tip == "Za prikolicu") { ?>
                        <div class="form-group">
                            <label class="control-label col-md-2" for="StrujaPrikljucak">Struja Priključak</label>
                            <div class="col-md-10">
                                <input class="form-control text-box single-line" required id="StrujaPrikljucak" name="StrujaPrikljucak" type="text" value="<?php echo htmlspecialchars($StrujaPrikljucak); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2" for="VodaPrikljucak">Voda Priključak</label>
                            <div class="col-md-10">
                                <input class="form-control text-box single-line" required id="VodaPrikljucak" name="VodaPrikljucak" type="text" value="<?php echo htmlspecialchars($VodaPrikljucak); ?>">
                            </div>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="StrujaPrikljucak" value="0">
                        <input type="hidden" name="VodaPrikljucak" value="0">
                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Cena">Cena</label>
                        <div class="col-md-10">
                            <input class="form-control text-box single-line" required id="Cena" name="Cena" type="number" value="<?php echo htmlspecialchars($Cena); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input type="submit" value="Sačuvaj izmene" name="Izmeni" class="btn btn-default">
                        </div>
                        <div>
                            <a class="btn btn-info btn-sm active" href="mesta.php?cmd=sve">Odustani - nazad na listu</a>
                        </div>
                    </div>
                </fieldset>
            </form>
        <?php
        }
    } elseif (isset($_POST['Izmeni']) && $_POST['Izmeni'] === "Izmeni") {
        $stmt = $mysqli->prepare("UPDATE smestaj SET Opis=?, Kapacitet=?, Rentira=?, StrujaPrikljucak=?, VodaPrikljucak=?, Cena=? WHERE RedniBrojMesta=?");
        $stmt->bind_param("siisiii", $_POST['Opis'], $_POST['Kapacitet'], $_POST['Rentira'], $_POST['StrujaPrikljucak'], $_POST['VodaPrikljucak'], $_POST['Cena'], $_POST['RedniBrojMesta']);
        $rez = $stmt->execute(); //prepared statement for updating accomodation

        if (!$rez) {
            echo "<strong><p style='color: black; font-size: 20px;'>Greška prilikom izmene!</p></strong>";
        } else {
            ?>
            <h3>Uspešno ste izmenili informacije o mestu!</h3>
            <div>
                <a class="btn btn-info btn-sm active" href="mesta.php?cmd=sve">Nazad na listu</a>
            </div>
            <?php
        }
    }
} else {
    ?>
    <h3>Niste ulogovani ili nemate pravo pristupa ovom sektoru!</h3><br>
    <strong><a style="color:black; font-size: 20px;"
