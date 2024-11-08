<?php

if(isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 2)
{
    require_once("php/konekcija.php");

    $upit = "SELECT * FROM korisnici WHERE RolaID >= ?";
    $stmt = $mysqli->prepare($upit);
    $rola_id = 2;
    $stmt->bind_param("i", $rola_id);

    $stmt->execute();
    $rez = $stmt->get_result();

?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>KorisnikID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>RolaID</th>
                </tr>
            </thead>
            <tbody> <?php   
                while($red = $rez->fetch_assoc()) 
                { ?>
                    <tr>
                        <td width="60"><?php echo htmlspecialchars($red['KorisnikID']); ?></td>
                        <td width="150"><?php echo htmlspecialchars($red['Username']); ?></td>
                        <td width="150"><?php echo htmlspecialchars($red['Email']); ?></td>
                        <td width="100"><?php echo htmlspecialchars($red['RolaID']); ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm active" href="izmenaRole.php?korisnikID=<?php echo htmlspecialchars($red['KorisnikID']); ?>">Izmeni</a>                                    
                        </td>
                    </tr> <?php 
                } ?>          
            </tbody>
        </table><br><br>
<?php
    $stmt->close();

} else
{
    ?>
        <h3>Niste ulogovani, nemate mogucnost ove radnje!</h3><br><br>
        <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br><br></strong>
<?php 
}
?>
