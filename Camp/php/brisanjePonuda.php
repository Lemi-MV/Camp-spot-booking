<?php 
if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 4)
{
    require_once("php/konekcija.php");
    if(!isset($_POST["Izbrisi"]))
    {
        $upit = "SELECT * FROM ponuda WHERE SifraPonude = ?"; //preparing statement for selecting offers by "offer code"
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $_GET['idPonuda']); 
        $stmt->execute();
        $rez = $stmt->get_result();

        ?>
        <h2>Brisanje ponude</h2><br><br>
        <form action="brisanjePonude.php" method="post">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sifra ponude</th>
                        <th>NazivPonude</th>
                        <th>Opis</th>
                        <th>Popust</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($red = $rez->fetch_assoc()) 
                    {
                        ?>
                        <tr>
                            <td width="60"><?php echo htmlspecialchars($red['SifraPonude']); ?></td>
                            <td width="150"><?php echo htmlspecialchars($red['NazivPonude']); ?></td>
                            <td width="150"><?php echo htmlspecialchars($red['Opis']); ?></td>
                            <td width="120"><?php echo htmlspecialchars($red['Popust']); ?></td>
                            <td>
                                <input type="hidden" name="idP" value="<?php echo htmlspecialchars($red['SifraPonude']); ?>">
                            </td>
                        </tr>
                        <?php 
                    }

                    if($rez->num_rows < 1)
                    {  
                        ?>
                        <h3>Nije moguce prikazati detalje zeljene ponude!</h3><br>
                        <strong>
                            <a style="color:black; font-size: 20px;" href="ponudaIndex.php">Povratak na listu ponuda ⮌</a>
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
                    <a class="btn btn-info btn-sm active" href="ponudaIndex.php">Odustani - nazad na listu</a>
                </div>
            </div>
        </form>
        <?php 
        $stmt->close();
    }
    else if(isset($_POST['Izbrisi']) && $_POST['Izbrisi'] === "Izbrisi")
    {
        $upit = "UPDATE ponuda SET Obrisan = 1 WHERE SifraPonude = ?";  // Preparing statement for updating of offer to "Deleted"
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $_P
