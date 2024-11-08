<?php
if (isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 2) {
    require_once("php/konekcija.php");

    $upit = "SELECT * FROM rola";  // Fetching of existing roles
    $rez = $mysqli->query($upit);
?>

<h3>Postojeće role</h3><br>
<table class="table table-hover">
    <thead>
        <tr>
            <th>RolaID</th>
            <th>Naziv role</th>
            <th>Nivo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($red = $rez->fetch_assoc()) {
            ?>
            <tr>
                <td width="60"><?php echo htmlspecialchars($red['RolaID']); ?></td>
                <td width="150"><?php echo htmlspecialchars($red['NazivRole']); ?></td>
                <td width="60"><?php echo htmlspecialchars($red['Nivo']); ?></td>
            </tr>
            <?php
        } 
        ?>
    </tbody>
</table><br><br>

<p>-----------------------------------------------------------------------------------------------------------------------------------------</p><br>

<?php
    if (isset($_GET['korisnikID']) && !isset($_POST["Izmeni"])) {
        $korisnikID = filter_input(INPUT_GET, 'korisnikID', FILTER_SANITIZE_NUMBER_INT);
        
        if ($korisnikID) {
            $upit2 = $mysqli->prepare("SELECT * FROM korisnici WHERE KorisnikID = ?");
            $upit2->bind_param("i", $korisnikID);
            $upit2->execute();
            $rez2 = $upit2->get_result();
            $red2 = $rez2->fetch_assoc();

            $KorisnikID = $red2['KorisnikID'];
            $Username = $red2['Username'];
            $Email = $red2['Email'];
            $RolaID = $red2['RolaID'];
?>

<h3>Korisnici</h3><br>
<form action="izmenaRole.php" method="post">
    <div class="form-group">
        <label class="control-label col-md-2" for="KorisnikID">Korisnik ID</label>
        <div class="col-md-10">
            <input class="form-control text-box single-line" readonly id="KorisnikID" name="KorisnikID" type="number" value="<?php echo htmlspecialchars($KorisnikID); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="Username">Username</label>
        <div class="col-md-10">
            <input class="form-control text-box single-line" readonly id="Username" name="Username" type="text" value="<?php echo htmlspecialchars($Username); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="Email">Email</label>
        <div class="col-md-10">
            <input class="form-control text-box single-line" readonly id="Email" name="Email" type="text" value="<?php echo htmlspecialchars($Email); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2" for="RolaID">Rola ID</label>
        <div class="col-md-10">
            <input class="form-control text-box single-line" id="RolaID" name="RolaID" type="number" value="<?php echo htmlspecialchars($RolaID); ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <input type="submit" value="Sacuvaj izmene" name="Izmeni" class="btn btn-default">
        </div>
        <div>
            <a class="btn btn-info btn-sm active" href="rolaIndex.php">Odustani - nazad na listu</a>
        </div>
    </div>
</form><br>

<?php
        }
    } elseif (isset($_POST['Izmeni']) && $_POST['Izmeni'] === "Sacuvaj izmene") {
        $rolaID = filter_input(INPUT_POST, 'RolaID', FILTER_SANITIZE_NUMBER_INT);
        $korisnikID = filter_input(INPUT_POST, 'KorisnikID', FILTER_SANITIZE_NUMBER_INT);

        if ($rolaID && $korisnikID) {
            $upit3 = $mysqli->prepare("UPDATE korisnici SET RolaID = ? WHERE KorisnikID = ?");
            $upit3->bind_param("ii", $rolaID, $korisnikID);
            $rez3 = $upit3->execute();

            if ($rez3) {
?>
                <h3>Uspešno ste izmenili rolu korisnika!</h3>
                <div>
                    <a class="btn btn-info btn-sm active" href="rolaIndex.php">Nazad na listu</a>
                </div>
<?php
            } else {
                echo "<h3>Došlo je do greške pri izmeni role.</h3>";
            }
        }
    }
} else {
?>
    <h3>Niste ulogovani, nemate mogućnost ove radnje!</h3><br><br>
    <strong>
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu⮌</a> &emsp; &emsp; &emsp;
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br><br>
    </strong>
<?php
}
?>
