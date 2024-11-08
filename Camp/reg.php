<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Registracija</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/stil.css" rel="stylesheet">
</head>

<body>
    <div class="container body-content">
        <?php
        include "php/nav.php";
        include "php/konekcija.php";

        if (isset($_POST['dugme']) && $_POST['dugme'] == "reg") {
            if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['passw']) && !empty($_POST['confpass'])) {

                $username = $_POST['username'];
                $email = $_POST['email'];
                $pass = $_POST['passw'];
                $confpass = $_POST['confpass'];

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<h3>Neispravna email adresa. Molimo Vas unesite ispravan email format.</h3>";  // Email adress validation
                    exit;  
                }

                if (strlen($pass) < 8) {
                    echo "<h3>Lozinka mora biti dužine najmanje 8 karaktera.</h3>";  // Password length check
                    exit;
                }

                $upit = "SELECT * FROM korisnici WHERE Username = ?";  
                $stmt = $mysqli->prepare($upit);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $rez = $stmt->get_result();                           // Checking if username already exist in db

                $upit2 = "SELECT * FROM korisnici WHERE Email = ?";   
                $stmt2 = $mysqli->prepare($upit2);
                $stmt2->bind_param("s", $email);
                $stmt2->execute();
                $rez2 = $stmt2->get_result();                        // Checking if email already exists in db

                if ($rez->num_rows > 0) {
                    echo "<h3>Ovo korisnicko ime već postoji u bazi! Molimo Vas unesite drugo korisničko ime.</h3>";
                } elseif ($rez2->num_rows > 0) {
                    echo "<h3>Email je već iskorišćen za pravljenje naloga! Molimo Vas koristite drugu email adresu.</h3>";
                } elseif ($pass != $confpass) {
                    echo "<h3>Morate uneti isti password u oba polja!</h3>";
                } else {
                    $passH = password_hash($pass, PASSWORD_BCRYPT);  // hashing of passsword

                    $upit3 = "INSERT INTO korisnici (Username, Pass, Email) VALUES (?, ?, ?)";
                    $stmt3 = $mysqli->prepare($upit3);
                    $stmt3->bind_param("sss", $username, $passH, $email);        //inserting user in db        
 
                    if ($stmt3->execute()) {
                        echo "<h3>Uspešno ste se registrovali!</h3><br>";
                        echo "<br><strong><a style='color:black; font-size: 20px;' href='logovanje.php' id='regLink'>Logovanje ⮎</a></strong><br>";
                    } else {
                        echo "<h3>Došlo je do greške: " . htmlspecialchars($mysqli->error) . "</h3>";
                    }

                    $stmt3->close();
                }

                $stmt->close();
                $stmt2->close();
            } else {
                echo "<h3>Morate popuniti sva polja.</h3>";
            }
        }

        include "php/foot.php";
        ?>
    </div>
</body>

</html>
