<?php
if (isset($_SESSION['Nivo']))
{
    $RedniBrojMesta = $_POST['RedniBrojMesta'];
    $SatorPrikolica = $_POST['SatorPrikolica'];
    $DatumPocetka = $_POST['DatumPocetka'];
    $DatumZavrsetka = $_POST['DatumZavrsetka'];
    $BrojKampera = $_POST['BrojKampera'];

    require_once ("php/konekcija.php");

    if (isset($_POST['dugme']))
    {
        if ($_SESSION['Nivo'] < 6)
        {
            $upit = "SELECT * FROM gost WHERE Obrisan = ?";
            $stmt = $mysqli->prepare($upit);
            $Obrisan = 0;
            $stmt->bind_param("i", $Obrisan);
            $stmt->execute();
            $rez = $stmt->get_result();
            ?>

            <h2>Kreiranje rezervacije</h2><br><br>
            <form action="kreiranjeRezervacije.php" method="post">
            <fieldset>
            <div class="form-group">
                <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="RedniBrojMesta" readonly name="RedniBrojMesta" type="text" value="<?php echo htmlspecialchars($RedniBrojMesta); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="SatorPrikolica" readonly name="SatorPrikolica" type="number" value="<?php echo htmlspecialchars($SatorPrikolica); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="DatumPocetka">Datum početka</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="DatumPocetka" readonly name="DatumPocetka" onchange="OnChangeEvent();" type="date" value="<?php echo htmlspecialchars($DatumPocetka); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="DatumZavrsetka">Datum zavrsetka</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly name="DatumZavrsetka" width="50" type="date" value="<?php echo htmlspecialchars($DatumZavrsetka); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="BrojKampera">Broj kampera </label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly id="BrojKampera" name="BrojKampera" type="number" value="<?php echo htmlspecialchars($BrojKampera); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="StatusRezervacije">Status rezervacije</label>
                <div class="col-md-10">
                    <select class="form-control select" required id="StatusRezervacije" name="StatusRezervacije">
                        <option value="cekanje">cekanje</option>
                        <option value="aktivna">aktivna</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Gost">Gost</label>
                <div class="col-md-10">
                    <select class="form-control select" data-val="true" required data-val-required="Morate odabrati gosta." id="Gost" name="Gost">
                        <?php
                        while ($red = $rez->fetch_assoc())
                        {
                            ?>
                            <option value="<?php echo htmlspecialchars($red['SifraGosta']); ?>"><?php echo htmlspecialchars($red['Ime'] . ' ' . $red['Prezime'] . ' ' . $red['BrojLicneKarte']); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Napomena">Napomena</label>
                <div class="col-md-10">
                    <textarea class="form-control textarea" id="Napomena" name="Napomena"></textarea>
                </div>
            </div>
            <br><br><br>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-6">
                    <button name="dugme" id="dugme" value="sacuvaj" type="submit" class="btn btn-success">Sacuvaj</button>
                </div>
            </div>
                    </fieldset>
        </form><br>
        <br><br><br>           
        <div class="form-group">
            <div class="col-md-offset-1 col-md-6">
                <a class="btn btn-primary btn-sm active" href="kreiranjeGosta.php">Kreiraj novog gosta</a>
            </div>
        </div><br>  
        <br><br><br>
        <div class="form-group">
            <div class="col-md-offset-1 col-md-6">
                <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - povratak na listu</a>
            </div>
        </div>

        <?php    
        }
        else if ($_SESSION['Nivo'] > 6)
        {
            $upit = "SELECT * FROM gost WHERE KorisnikID = ?";
            $stmt = $mysqli->prepare($upit);
            $stmt->bind_param("i", $_SESSION['ID']);
            $stmt->execute();
            $rez = $stmt->get_result();
            ?>

            <h2>Kreiranje rezervacije</h2><br><br>
            <form action="kreiranjeRezervacije.php" method="post">
            <fieldset>
            <div class="form-group">
                <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="RedniBrojMesta" readonly name="RedniBrojMesta" type="text" value="<?php echo htmlspecialchars($RedniBrojMesta); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="SatorPrikolica" readonly name="SatorPrikolica" type="number" value="<?php echo htmlspecialchars($SatorPrikolica); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="DatumPocetka">Datum početka</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" id="DatumPocetka" readonly name="DatumPocetka" onchange="OnChangeEvent();" type="date" value="<?php echo htmlspecialchars($DatumPocetka); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="DatumZavrsetka">Datum zavrsetka</label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly name="DatumZavrsetka" type="date" value="<?php echo htmlspecialchars($DatumZavrsetka); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="BrojKampera">Broj kampera </label>
                <div class="col-md-10">
                    <input class="form-control text-box single-line" readonly id="BrojKampera" name="BrojKampera" type="number" value="<?php echo htmlspecialchars($BrojKampera); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="StatusRezervacije">Status rezervacije</label>
                <div class="col-md-10">
                    <select class="form-control select" required id="StatusRezervacije" name="StatusRezervacije">
                        <option value="cekanje">cekanje</option>
                        <option value="aktivna">aktivna</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Gost">Gost</label>
                <div class="col-md-10">
                    <select class="form-control select" data-val="true" required data-val-required="Morate odabrati gosta." id="Gost" name="Gost">
                        <?php
                        while ($red = $rez->fetch_assoc())
                        {
                            ?>
                            <option value="<?php echo htmlspecialchars($red['SifraGosta']); ?>"><?php echo htmlspecialchars($red['Ime'] . ' ' . $red['Prezime'] . ' ' . $red['BrojLicneKarte']); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2" for="Napomena">Napomena</label>
                <div class="col-md-10">
                    <textarea class="form-control textarea" id="Napomena" name="Napomena"></textarea>
                </div>
            </div>
            <br><br><br>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-6">
                    <button name="dugme" id="dugme" value="sacuvaj" type="submit" class="btn btn-success">Sacuvaj</button>
                </div>
            </div>
                    </fieldset>
        </form><br>
        <br><br><br>           
        <div class="form-group">
            <div class="col-md-offset-1 col-md-6">
                <a class="btn btn-primary btn-sm active" href="kreiranjeGosta.php">Kreiraj novog gosta</a>
            </div>
        </div><br>  
        <br><br><br>
        <div class="form-group">
            <div class="col-md-offset-1 col-md-6">
                <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Odustani - povratak na listu</a>
            </div>
        </div>

        <?php    
        }
    }
}
else
{
    ?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br>
    </strong>
    <?php
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
