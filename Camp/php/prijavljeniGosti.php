<?php

if (isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 6) {
    require_once("php/konekcija.php");
    
    $upit = "SELECT * FROM gost WHERE StatusGosta = ? AND Obrisan = ?";
    $stmt = $mysqli->prepare($upit);
    
    if ($stmt) {
        $statusGosta = 'Prijavljen';
        $obrisan = 0;
        
        $stmt->bind_param('si', $statusGosta, $obrisan);
        $stmt->execute();
        
        $rez = $stmt->get_result();
        ?>
        <h3>Prijavljeni gosti</h3><br>
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
                while ($red = $rez->fetch_assoc()) {
                    ?>
                    <tr>
                        <td width="60"><?php echo htmlspecialchars($red['SifraGosta']); ?></td>
                        <td width="110"><?php echo htmlspecialchars($red['Ime']); ?></td>
                        <td width="110"><?php echo htmlspecialchars($red['Prezime']); ?></td>
                        <td width="120"><?php echo htmlspecialchars($red['BrojLicneKarte']); ?></td>
                        <td width="220"><?php echo htmlspecialchars($red['Adresa']); ?></td>
                        <td width="120"><?php echo htmlspecialchars($red['BrojTelefona']); ?></td>
                        <td width="120"><?php echo htmlspecialchars($red['StatusGosta']); ?></td>
                        <td>
                            <a class="btn btn-warning btn-sm active" href="izmenaGosta.php?idGost=<?php echo $red['SifraGosta']; ?>">Izmeni</a>
                        </td>
                    </tr>
                    <?php 
                }
                ?>            
            </tbody>
        </table><br><br>
        <a class="btn btn-primary btn-sm active" href="gostIndex.php?gos=svi">Nazad na listu</a>
        <?php
        $stmt->close();
    } else {
        echo "<h3>Greska: " . htmlspecialchars($mysqli->error) . "</h3>";
    }
} else {
    ?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br><br>
    </strong>
    <?php
}
?>
