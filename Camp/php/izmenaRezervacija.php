<?php
if (isset($_SESSION['Nivo'])) {
    require_once("php/konekcija.php");

    if (isset($_GET["sifrez"])) {
        $SifraRezervacije = $_GET["sifrez"];

        $stmt = $mysqli->prepare("SELECT * FROM rezervacija WHERE SifraRezervacije = ?");
        $stmt->bind_param("i", $SifraRezervacije);
        $stmt->execute();
        $rez = $stmt->get_result();
        $red = $rez->fetch_assoc();

        $stmt2 = $mysqli->prepare("SELECT * FROM gost"); //preparing statement to show all guests
        $stmt2->execute();
        $rez2 = $stmt2->get_result();
        ?>

        <h2>Izmena rezervacije</h2><br><br>

        <?php if ($_SESSION['Nivo'] < 6) { ?>
            <h4><strong> VAZNA NAPOMENA! </strong> Izmenu rezervacije koristite ukoliko zelite da promenite <i>Status rezervacije, Gosta (SifraGosta), Broj kampera</i> ili <i>Napomenu</i>. Ukoliko zelite da promenite <i>Redni broj mesta, Datum pocetka</i> ili <i>Datum zavrsetka</i> potrebno je da <i>Status rezervacije</i> promenite u Otkazana i zatim kreirate NOVU rezervaciju! 
            Brisanje rezervacije je promena <i>Statusa rezervacije</i> u Otkazana. Hvala na razumevanju!</h4>
        <?php } ?>
        
        <br><br><br>
        <form action="izmenaRezervacije.php" method="post">
            <div class="form-group">
                <label class="control-label col-md-2" for="SifraRezervacije">Šifra rezervacije</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly name="SifraRezervacije" id="SifraRezervacije" type="number" value="<?php echo htmlspecialchars($red['SifraRezervacije']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo htmlspecialchars($red['RedniBrojMesta']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="SatorPrikolica" readonly name="SatorPrikolica" type="number" value="<?php echo htmlspecialchars($red['SatorPrikolica']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="DatumPocetka">Datum početka</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly id="DatumPocetka" name="DatumPocetka" onchange="OnChangeEvent();" type="date" value="<?php echo htmlspecialchars($red['DatumPocetka']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="DatumZavrsetka">Datum zavrsetka</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly id="DatumZavrsetka" min="" name="DatumZavrsetka" type="date" value="<?php echo htmlspecialchars($red['DatumZavrsetka']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="BrojKampera">Broj kampera </label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" required id="BrojKampera" name="BrojKampera" min="1" type="number" value="<?php echo htmlspecialchars($red['BrojKampera']); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="StatusRezervacije">Status rezervacije</label>
                <div class="col-md-10">
                    <select class="form-control select" required id="StatusRezervacije" name="StatusRezervacije">
                        <?php
                        $statusi = ['cekanje', 'aktivna', 'realizovana', 'otkazana'];
                        foreach ($statusi as $status) {
                            $selected = ($red['StatusRezervacije'] == $status) ? 'selected' : '';
                            echo "<option value='$status' $selected>$status</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Gost">Gost</label>
                <div class="col-md-10">
                    <select class="form-control select" required id="Gost" name="Gost">
                        <?php
                        while ($red2 = $rez2->fetch_assoc()) {
                            $selected = ($red2['SifraGosta'] == $red['SifraGosta']) ? 'selected' : '';
                            echo "<option value='{$red2['SifraGosta']}' $selected>" . htmlspecialchars($red2['SifraGosta'] . ' ' . $red2['Ime'] . ' ' . $red2['Prezime'] . ' ' . $red2['BrojLicneKarte']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Napomena">Napomena</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="Napomena" name="Napomena" type="text" value="<?php echo htmlspecialchars($red['Napomena']); ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" value="Izmeni" name="Izmeni" class="btn btn-default">
                </div><br>
            </div>
            <div>
                <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - nazad na listu</a>
            </div>
        </form><br>
    <?php
    } elseif (isset($_POST['Izmeni']) && $_POST['Izmeni'] == "Izmeni") {
        if (!empty($_POST['StatusRezervacije']) && !empty($_POST['Gost'])) {
            $SifraRezervacije = $_POST['SifraRezervacije'];
            $StatusRezervacije = $_POST['StatusRezervacije'];
            $SifraGosta = $_POST['Gost'];
            $BrojKampera = $_POST['BrojKampera'];
            $Napomena = $_POST['Napomena'];

            $stmt3 = $mysqli->prepare("UPDATE rezervacija SET StatusRezervacije = ?, SifraGosta = ?, BrojKampera = ?, Napomena = ? WHERE SifraRezervacije = ?");
            $stmt3->bind_param("sisi", $StatusRezervacije, $SifraGosta, $BrojKampera, $Napomena, $SifraRezervacije);
            $stmt3->execute();

            if ($stmt3->affected_rows > 0) {
                echo "<h3>Uspešno ste izmenili rezervaciju!</h3>";
                echo '<div><a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Nazad na listu</a></div>';

                if ($StatusRezervacije == "aktivna") {
                    $stmt4 = $mysqli->prepare("UPDATE gost SET StatusGosta = 'Prijavljen' WHERE SifraGosta = ?");
                    $stmt4->bind_param("i", $SifraGosta);
                    $stmt4->execute();
                }
            } else {
                echo "<strong>Greška prilikom izmene podataka!</strong>";
            }
        } else {
            echo '<script type="text/javascript">alert("Status rezervacije i Gost ne smeju biti prazni!");</script>';
        }
    } else {
        header('Location: rezervacijaIndex.php');
    }
} else {
    header('Location: index.php');
}
?>


<script>
    function OnChangeEvent() {

        var pocetniDatum = document.getElementById('DatumPocetka').value;
        var datumZavrsetka = document.getElementById('DatumZavrsetka').value;

        document.getElementById("DatumZavrsetka").setAttribute('min', pocetniDatum);
        document.getElementById("DatumZavrsetka").removeAttribute("readonly");

        document.getElementById("DatumZavrsetka").value = pocetniDatum;
    }
</script>