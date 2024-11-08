<?php 
if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 6)
{
    require_once("php/konekcija.php");
    if(!isset($_POST["Izbrisi"]))
    {
        
        $upit = "SELECT * FROM gost WHERE SifraGosta = ?";  // prepared statement for selection of guest by "guest code"
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $_GET['idGost']);
        $stmt->execute();
        $rez = $stmt->get_result();
?>  
        <h2>Brisanje gosta</h2>
        <form action="brisanjeGosta.php" method="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sifra gosta</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Broj licne karte</th>
                        <th>Adresa</th>
                        <th>Broj telefona</th>
                        <th>Status gosta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($red = $rez->fetch_assoc()) 
                    {
                        ?>
                        <tr>
                            <td width="60"><?php echo $red['SifraGosta']; ?></td>
                            <td width="110"><?php echo $red['Ime']; ?></td>
                            <td width="110"><?php echo $red['Prezime']; ?></td>
                            <td width="120"><?php echo $red['BrojLicneKarte']; ?></td>
                            <td width="220"><?php echo $red['Adresa']; ?></td>
                            <td width="120"><?php echo $red['BrojTelefona']; ?></td>
                            <td width="120"><?php echo $red['StatusGosta']; ?></td>
                            <td>
                            <input type="hidden" name="idG" value="<?php echo $red['SifraGosta']; ?>"></td>
                        </tr>
                        <?php 
                    }

                    if($rez->num_rows < 1)
                    {  ?>
                        <h3>Nije moguce prikazati detalje zeljenog gosta! </h3><br>
                        <strong><a style="color:black; font-size: 20px;" href="gostIndex.php?gos=svi">Povratak na listu ⮌</a><br>
                        </strong>            
                    <?php 
                    }
                    ?>          
                </tbody>
            </table><br>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <input type="submit" value="Izbrisi" name="Izbrisi" class="btn btn-default">
                </div><br>
                <div>
                    <a class="btn btn-info btn-sm active" href="gostIndex.php?gos=svi">Odustani - nazad na listu</a>
                </div>
            </div>
        </form>
<?php 
        $stmt->close();
    }
    else if($_POST['Izbrisi'] == "Izbrisi")
    {
        $upit = "UPDATE gost SET Obrisan = 1 WHERE SifraGosta = ?"; //prepared statement for updating of "guest status" to "deleted"
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $_POST['idG']); 
        if(!$stmt->execute()) 
        {   
            echo "<strong><p style='color: black; font-size: 20px;'>Greska prilikom brisanja!!!</p></strong>";
        }
        else
        { ?>
            <h3>Uspesno ste izbrisali gosta!</h3>
            <div>
                <a class="btn btn-info btn-sm active" href="gostIndex.php?gos=svi">Nazad na listu</a>
            </div>  
<?php   
        }

        $stmt->close();
    } 
}
else
{
    ?>
        <h3>Niste ulogovani, nemate mogucnost ove radnje!</h3><br><br>
        <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br><br> 
        </strong>
<?php 
}
?>
