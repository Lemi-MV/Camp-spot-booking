<?php 
if (isset($_SESSION['Nivo'])) {
    require_once("php/konekcija.php");

    if ($_SESSION['Nivo'] < 6) {
        $upit = "SELECT * FROM specifikacija";
        $stmt = $mysqli->prepare($upit);
        $stmt->execute();
        $rez = $stmt->get_result(); ?>

        <h3>Specifikacije</h3><br>
        <div class="slike">
            <div class="slikaSpecifikacije">
                <img src="images/gomilaSatora3.jpg" alt="Slika 6" width="500px" height="700px">
            </div>
        </div><br><br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Šifra specifikacije</th>
                    <th>Datum kreiranja</th>
                    <th>Šifra rezervacije</th>
                    <th>Šifra gosta</th>
                    <th>Šifra ponude</th>
                    <th>Redni broj mesta</th>
                    <th>Korisnik ID</th>
                    <th>Broj noćenja</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($red = $rez->fetch_assoc()) { ?>
                    <tr>
                        <td width="50"><?php echo htmlspecialchars($red['SifraSpecifikacije']); ?></td>
                        <td width="50"><?php echo htmlspecialchars($red['DatumKreiranja']); ?></td>
                        <td width="130"><?php echo htmlspecialchars($red['SifraRezervacije']); ?></td>
                        <td width="130"><?php echo htmlspecialchars($red['SifraGosta']); ?></td>
                        <td width="130"><?php echo htmlspecialchars($red['SifraPonude']); ?></td>
                        <td width="50"><?php echo htmlspecialchars($red['RedniBrojMesta']); ?></td>
                        <td width="30"><?php echo htmlspecialchars($red['KorisnikID']); ?></td>
                        <td width="30"><?php echo htmlspecialchars($red['BrojNocenja']); ?></td>
                        <td>
                            <a class="btn btn-success btn-sm active" href="specifikacije.php?sifspec=<?php echo $red['SifraSpecifikacije']; ?>">Detalji</a>
                        </td>
                    </tr>
                <?php } 
                if ($rez->num_rows < 1) { ?>
                    <h3>Nema specifikacija!</h3><br>
                    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu ⮌</a></strong><br>
                <?php } ?>
            </tbody>
        </table>
    <?php
    } else if ($_SESSION['Nivo'] > 6) {
        $korID = $_SESSION['ID'];
        $upit2 = "SELECT SifraGosta FROM gost WHERE KorisnikID = ?";
        $stmt2 = $mysqli->prepare($upit2);
        $stmt2->bind_param("i", $korID);
        $stmt2->execute();
        $rez2 = $stmt2->get_result();
        $red2 = $rez2->fetch_assoc();
        $sifg = $red2['SifraGosta'];

        $upit = "SELECT * FROM specifikacija WHERE SifraGosta = ?";
        $stmt = $mysqli->prepare($upit);
        $stmt->bind_param("i", $sifg);
        $stmt->execute();
        $rez = $stmt->get_result();

        if ($rez->num_rows < 1) { ?>
            <h3>Nema specifikacija!</h3><br>
            <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu ⮌</a></strong><br>
        <?php } else { ?>
            <h3>Specifikacije</h3><br>
            <div class="slike">
                <div class="slikaSpecifikacije">
                    <img src="images/gomilaSatora3.jpg" alt="Slika 6" width="500px" height="700px">
                </div>
            </div><br><br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Šifra specifikacije</th>
                        <th>Datum kreiranja</th>
                        <th>Šifra rezervacije</th>
                        <th>Šifra gosta</th>
                        <th>Šifra ponude</th>
                        <th>Redni broj mesta</th>
                        <th>Korisnik ID</th>
                        <th>Broj noćenja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($red = $rez->fetch_assoc()) { ?>
                        <tr>
                            <td width="50"><?php echo htmlspecialchars($red['SifraSpecifikacije']); ?></td>
                            <td width="50"><?php echo htmlspecialchars($red['DatumKreiranja']); ?></td>
                            <td width="130"><?php echo htmlspecialchars($red['SifraRezervacije']); ?></td>
                            <td width="130"><?php echo htmlspecialchars($red['SifraGosta']); ?></td>
                            <td width="130"><?php echo htmlspecialchars($red['SifraPonude']); ?></td>
                            <td width="50"><?php echo htmlspecialchars($red['RedniBrojMesta']); ?></td>
                            <td width="30"><?php echo htmlspecialchars($red['KorisnikID']); ?></td>
                            <td width="30"><?php echo htmlspecialchars($red['BrojNocenja']); ?></td>
                            <td>
                                <a class="btn btn-success btn-sm active" href="specifikacije.php?sifspec=<?php echo $red['SifraSpecifikacije']; ?>">Detalji</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } 
    } 
} else { ?>
    <h3>Niste ulogovani, ili nemate pravo pristupa ovom sektoru!</h3><br><br>
    <strong><a style="color:black; font-size: 20px;" href="http://localhost/Kamp/pocetna.php">Povratak na početnu stranu ⮌</a> &emsp; &emsp; &emsp;<a style="color:black; font-size: 20px;" href="http://localhost/Kamp/logovanje.php">Ulogujte se ⮎</a></strong><br><br>
<?php } ?>
