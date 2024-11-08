<?php 
if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 4)
{
    require_once("php/konekcija.php");

    if(!isset($_POST["Izmeni"]))
    {
        $stmt = $mysqli->prepare("SELECT * FROM ponuda WHERE SifraPonude=?"); 
        $stmt->bind_param("s", $_GET['idPonuda']);
        $stmt->execute();
        $rez = $stmt->get_result();
        $red = $rez->fetch_assoc();

        if($rez->num_rows < 1)
        {  
            echo "<h3>Ponuda sa datim identifikatorom ne postoji ili je izbrisana!</h3><br>";
            echo '<strong><a style="color:black; font-size: 20px;" href="ponudaIndex.php">Povratak na listu ⮌</a></strong>';
            exit;
        }

        $SifraPonude = htmlspecialchars($red['SifraPonude']);  //safe showing of data
        $NazivPonude = htmlspecialchars($red['NazivPonude']);
        $Opis = htmlspecialchars($red['Opis']);
        $Popust = htmlspecialchars($red['Popust']);
 ?>
    <h2>Izmena ponude</h2><br><br>
    <form action="izmenaPonude.php" method="post">
        <div class="form-group">
            <label class="control-label col-md-2" for="SifraPonude">Šifra ponude</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" readonly id="SifraPonude" name="SifraPonude" type="number" value="<?php echo $SifraPonude ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="NazivPonude">Naziv ponude</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" data-val="true" required data-val-required="Morate uneti naziv ponude." id="NazivPonude" name="NazivPonude" type="text" value="<?php echo $NazivPonude ?>">                
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="Opis">Opis</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" data-val="true" required data-val-required="Morate uneti opis ponude." id="Opis" name="Opis" type="text" value="<?php echo $Opis ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2" for="Popust">Popust</label>
            <div class="col-md-10">
                <input class="form-control text-box single-line" data-val="true" required data-val-number="The field Popust must be a number." data-val-range="Dozvoljene su samo pozitivne vrednosti od 0 do 100" max="100" min="0" data-val-required="Morate uneti popust." id="Popust" name="Popust" type="number" value="<?php echo $Popust ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="Sacuvaj izmene" name="Izmeni" class="btn btn-default">
            </div>
            <div>
                <a class="btn btn-info btn-sm active" href="ponudaIndex.php">Odustani - nazad na listu</a>
            </div>
        </div>
    </form><br>
<?php 
    }
    else if(isset($_POST['Izmeni']) && $_POST['Izmeni'] == "Izmeni")
    {
        $NazivPonude = trim($_POST['NazivPonude']);  // validating of user entry on server side
        $Opis = trim($_POST['Opis']);
        $Popust = floatval($_POST['Popust']);
        $SifraPonude = $_POST['SifraPonude'];

        if(empty($NazivPonude) || empty($Opis) || $Popust < 0 || $Popust > 100) {
            echo "<strong>Neispravni podaci! Proverite unos.</strong>";
            exit;
        }

        $stmt = $mysqli->prepare("UPDATE ponuda SET NazivPonude=?, Opis=?, Popust=? WHERE SifraPonude=?");  // Updating "offer" in db
        $stmt->bind_param("ssdi", $NazivPonude, $Opis, $Popust, $SifraPonude);
        $stmt->execute();

        if($stmt->affected_rows < 1) {
            echo "<strong><p style='color: black; font-size: 20px;'>Greška prilikom izmene podataka!</p></strong>"; 
        } else {
            echo "<h3>Uspešno ste izmenili ponudu!</h3>";
            echo '<div><a class="btn btn-info btn-sm active" href="ponudaIndex.php">Nazad na listu</a></div>';
        }
    } 
}
else
{
?>
    <h3>Niste ulogovani, nemate mogućnost ove radnje!</h3><br><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br><br></strong>
<?php 
}
?>
