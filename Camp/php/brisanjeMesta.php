<?php 
if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 4)
{
    require_once("php/konekcija.php");

    if(!isset($_POST['Obrisi']) && isset($_GET['rbsb']))
    {
        $upit = "SELECT * FROM smestaj WHERE RedniBrojMesta = ?";  // preparing statement for selection of place by "sequence number of place"
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $_GET['rbsb']); 
        $stmt->execute();
        $rez = $stmt->get_result();
        $red = $rez->fetch_assoc();

        if($rez->num_rows < 1)
        {  ?>
            <h3>Nije moguce prikazati detalje zeljenog mesta!</h3><br>
            <strong><a style="color:black; font-size: 20px;" href="mesta.php?cmd=sve">Povratak na listu ⮌</a><br>
            </strong>            
        <?php 
        }
        else
        {
            $RedniBrojSobe = $red['RedniBrojMesta'];
            $TipMesta = $red['Tip'];
            $Opis = $red['Opis'];
            $Kapacitet = $red['Kapacitet'];
            $SatorPrikolica = $red['SatorPrikolica'];
            $Rentira = $red['Rentira'];
            $StrujaPrikljucak = $red['StrujaPrikljucak'];
            $VodaPrikljucak = $red['VodaPrikljucak'];
            $Cena = $red['Cena'];
?>   
            <h2>Brisanje mesta</h2>
            <br>
            <form action="" method="post">
                <fieldset>
                    <legend><h4><strong><?php echo htmlspecialchars($red['Tip']); ?></strong></h4></legend>
                    <div class="form-group">
                        <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo htmlspecialchars($red['RedniBrojMesta']); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Tip">Tip mesta</label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="Tip" name="Tip" type="text" value="<?php echo htmlspecialchars($red['Tip']); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Opis">Opis</label>
                        <div class="col-md-10">
                            <textarea readonly class="form-control textarea" id="Opis" name="Opis"><?php echo htmlspecialchars($red['Opis']); ?></textarea>
                        </div>
                    </div>   

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Kapacitet">Kapacitet</label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="RedniBrKapacitetojMesta" name="Kapacitet" type="number" value="<?php echo $red['Kapacitet'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="SatorPrikolica" name="SatorPrikolica" type="text" value="<?php echo $red['SatorPrikolica'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Rentira">Rentira</label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="Rentira" name="Rentira" type="text" value="<?php echo $red['Rentira'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="StrujaPrikljucak">Struja Prikljucak</label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="StrujaPrikljucak" name="StrujaPrikljucak" type="text" value="<?php echo $red['StrujaPrikljucak'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="VodaPrikljucak">Voda Prikljucak</label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="VodaPrikljucak" name="VodaPrikljucak" type="text" value="<?php echo $red['VodaPrikljucak'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2" for="Cena">Cena </label>
                        <div class="col-md-10">
                            <input readonly class="form-control text-box single-line" id="Cena" name="Cena" type="number" value="<?php echo $red['Cena'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <input type="submit" value="Obrisi" name="Obrisi" class="btn btn-default">
                        </div>
                        <div>
                            <a class="btn btn-info btn-sm active" href="mesta.php?cmd=sve">Odustani - nazad na listu</a>
                        </div>
                    </div>
                </fieldset>   
            </form>
<?php   
        }
        $stmt->close();
    }
    else if(isset($_POST['Obrisi']) && $_POST['Obrisi'] === "Obrisi")
    {
        $upit = "UPDATE smestaj SET Obrisan = 1 WHERE RedniBrojMesta = ?"; // prearing statement for updating of "status of place" to "deleted"
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $_POST['RedniBrojMesta']); 

        if(!$stmt->execute())
        {
            echo "<strong><p style='color: black; font-size: 20px;'> Greska prilikom brisanja!!!</p></strong>";
        }
        else
        { ?>
            <h3>Uspesno ste obrisali mesto!</h3>
            <div>
                <a class="btn btn-info btn-sm active" href="mesta.php?cmd=sve">Nazad na listu</a>
            </div>
<?php
        }

        $stmt->close();
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
