<?php 

if(isset($_SESSION['Nivo']) && isset($_GET['tip']))
{
    require_once("php/konekcija.php"); 
    $tip = $_GET['tip'];
    $stmt = null;
    
    if($tip == "sat")
    { 
        $stmt = $mysqli->prepare("SELECT * FROM smestaj WHERE Obrisan = 0 AND SatorPrikolica = 0");
    }
    else if($tip == "prik")
    { 
        $stmt = $mysqli->prepare("SELECT * FROM smestaj WHERE Obrisan = 0 AND SatorPrikolica = 1");
    }

    if ($stmt) {
        $stmt->execute();
        $rez = $stmt->get_result();

        if($_SESSION['Nivo'] < 4)
        { 
            if ($tip == "sat") {
                echo '<h3>Sva šatorska mesta u kampu</h3><br>';
            } else if ($tip == "prik") {
                echo '<h3>Sva mesta za prikolice u kampu</h3><br>';
            }
            echo '<a class="btn btn-primary btn-sm active" href="mesta.php?nova">Kreiraj novo mesto</a><br><br><br>';
        }
        
        while($red = $rez->fetch_assoc())
        { 
?>
            <fieldset>
                <legend><h4><strong><?php echo htmlspecialchars($red['Tip']); ?></strong></h4></legend>  
                <div class="form-group">
                    <label class="control-label col-md-2" for="RedniBrojMesta">Redni broj mesta</label>
                    <div class="col-md-10">
                        <input readonly class="form-control text-box single-line" id="RedniBrojMesta" name="RedniBrojMesta" type="number" value="<?php echo htmlspecialchars($red['RedniBrojMesta']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2" for="Tip">Tip</label>
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
                        <input readonly class="form-control text-box single-line" id="Kapacitet" name="Kapacitet" type="number" value="<?php echo htmlspecialchars($red['Kapacitet']); ?>">
                    </div>
                </div>  
                
                <div class="form-group">
                    <label class="control-label col-md-2" for="SatorPrikolica">Sator / Prikolica</label>
                    <div class="col-md-10">
                        <input readonly class="form-control text-box single-line" id="SatorPrikolica" name="SatorPrikolica" type="text" value="<?php echo htmlspecialchars($red['SatorPrikolica']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2" for="Rentira">Rentira</label>
                    <div class="col-md-10">
                        <input readonly class="form-control text-box single-line" id="Rentira" name="Rentira" type="text" value="<?php echo htmlspecialchars($red['Rentira']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2" for="StrujaPrikljucak">Struja prikljucak</label>
                    <div class="col-md-10">
                        <input readonly class="form-control text-box single-line" id="StrujaPrikljucak" name="StrujaPrikljucak" type="text" value="<?php echo htmlspecialchars($red['StrujaPrikljucak']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2" for="VodaPrikljucak">Voda prikljucak</label>
                    <div class="col-md-10">
                        <input readonly class="form-control text-box single-line" id="VodaPrikljucak" name="VodaPrikljucak" type="text" value="<?php echo htmlspecialchars($red['VodaPrikljucak']); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2" for="Cena">Cena</label>
                    <div class="col-md-10">
                        <input readonly class="form-control text-box single-line" id="Cena" name="Cena" type="text" value="<?php echo htmlspecialchars($red['Cena']); ?>">
                    </div>
                </div>  

                <?php
                if($rez->num_rows < 1)
                {  
                ?>
                    <h3>Nema unetih smestaja u bazu! </h3><br>
                    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu ⮌</a></strong> 
                <?php 
                } 

                if($_SESSION['Nivo'] < 4)
                { 
                ?>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <a class="btn btn-success btn-sm active" href="mesta.php?rbs=<?php echo $red['RedniBrojMesta']; ?>">Izmeni</a> | 
                            <a class="btn btn-danger btn-sm active" href="mesta.php?rbsb=<?php echo $red['RedniBrojMesta']; ?>">Briši</a>
                        </div>
                    </div>
                <?php 
                } 
                ?>
            </fieldset>
<?php
        }
        ?>
        <br><br><br>
        <div class="form-group">
            <div>
                <a class="btn btn-info btn-sm active" href="mesta.php?cmd=sve">Nazad na izbor tipa smestaja</a>
            </div>
        </div>
<?php 
    } 
    $stmt->close();
} else { 
?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a></strong>
<?php 
}
?>
