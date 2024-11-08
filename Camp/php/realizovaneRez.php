<?php

if (isset($_SESSION['Nivo']) && $_SESSION['Nivo'] < 4) {
    require_once("php/konekcija.php");

    $upit = "SELECT * FROM rezervacija WHERE StatusRezervacije = ? OR StatusRezervacije = ?";
    $stmt = $mysqli->prepare($upit);

    if ($stmt) {
        $status1 = 'Realizovana';
        $status2 = 'Otkazana';

        $stmt->bind_param('ss', $status1, $status2);
        $stmt->execute();

        $rez = $stmt->get_result();
        ?>
        <h2>Realizovane i otkazane rezervacije</h2><br><br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Sifra rezervacije</th>
                    <th>Redni broj mesta</th>
                    <th>Datum pocetka</th>
                    <th>Datum zavrsetka</th>
                    <th>Broj kampera</th>
                    <th>Status rezervacije</th>
                    <th>KorisnikID</th>
                    <th>Sifra gosta</th>
                    <th>Napomena</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($rez->num_rows > 0) {
                    while ($red = $rez->fetch_assoc()) {
                        ?>
                        <tr>
                            <td width="30"><?php echo htmlspecialchars($red['SifraRezervacije']); ?></td>
                            <td width="30"><?php echo htmlspecialchars($red['RedniBrojMesta']); ?></td>
                            <td width="130"><?php echo htmlspecialchars($red['DatumPocetka']); ?></td>
                            <td width="130"><?php echo htmlspecialchars($red['DatumZavrsetka']); ?></td>
                            <td width="30"><?php echo htmlspecialchars($red['BrojKampera']); ?></td>
                            <td width="130"><?php echo htmlspecialchars($red['StatusRezervacije']); ?></td>
                            <td width="30"><?php echo htmlspecialchars($red['KorisnikID']); ?></td>
                            <td width="30"><?php echo htmlspecialchars($red['SifraGosta']); ?></td>
                            <td width="200"><?php echo htmlspecialchars($red['Napomena']); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <h3>Ne postoje trazene rezervacije! </h3><br>
                    <strong>
                        <a style="color:black; font-size: 20px;" href="rezervacijaIndex.php?cmd=cek">Povratak na prethodnu listu ⮌</a><br>
                    </strong>
                    <?php
                }
                ?>            
            </tbody>
        </table>
        <br>
        <div>
            <a class="btn btn-info btn-sm active" href="rezervacijaIndex.php?cmd=cek">Vratite se na listu</a>
        </div>
        <?php
        $stmt->close();
    } else {
        echo "<h3>Greska: " . htmlspecialchars($mysqli->error) . "</h3>";
    }
} else {
    ?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br><br>
    <strong>
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na pocetnu stranu⮌</a> 
        &emsp; &emsp; &emsp;
        <a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a><br><br>
    </strong>
    <?php
}
?>
