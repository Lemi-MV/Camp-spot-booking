<?php
if (isset($_SESSION['Nivo']))
{
    require_once ("php/konekcija.php");

    if (isset($_POST['dugme']) && $_POST['dugme'] == "sacuvaj")
    {
        if (isset($_POST['StatusRezervacije']) && isset($_POST['Gost']))
        {
            $upit2 = "INSERT INTO rezervacija 
                (RedniBrojMesta, SatorPrikolica, DatumPocetka, DatumZavrsetka, BrojKampera, StatusRezervacije, KorisnikID, SifraGosta, Napomena) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            if ($stmt = $mysqli->prepare($upit2)) {
                $stmt->bind_param("sissisiss", 
                    $_POST['RedniBrojMesta'], 
                    $_POST['SatorPrikolica'], 
                    $_POST['DatumPocetka'], 
                    $_POST['DatumZavrsetka'], 
                    $_POST['BrojKampera'], 
                    $_POST['StatusRezervacije'], 
                    $_SESSION['ID'], 
                    $_POST['Gost'], 
                    $_POST['Napomena']
                );

                if ($stmt->execute()) {
                    ?>
                    <h3>Uspesno ste kreirali rezervaciju!</h3>
                    <div>
                        <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Nazad na listu</a>
                    </div>
                    <?php
                } else {
                    die("Greska: " . $stmt->error);
                }

                $stmt->close();
            } else {
                die("Greska pri pripremi upita: " . $mysqli->error);
            }
        }
        else
        {
            echo '<script type="text/javascript">alert("Morate uneti sve podatke kako bi ste kreirali rezervaciju!");</script>';
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
