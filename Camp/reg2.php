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

		if (isset($_POST['dugme']) && $_POST['dugme'] == "reg") 
		{
			if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['passw']) && !empty($_POST['confpass'])) 
			{
				$username = $_POST['username'];
				$email = $_POST['email'];
				$pass = $_POST['passw'];
				$confpass = $_POST['confpass'];

				$stmt = $mysqli->prepare("SELECT * FROM korisnici WHERE Username = ?"); // checking if there is user with same user name
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$rez = $stmt->get_result();

				$stmt2 = $mysqli->prepare("SELECT * FROM korisnici WHERE Email = ?"); // checking if there is user with same email
				$stmt2->bind_param("s", $email);
				$stmt2->execute();
				$rez2 = $stmt2->get_result();

				if ($red = $rez->fetch_assoc()) 
				{ ?>
					<h3>Username vec postoji u bazi! Molimo Vas unesite drugo korisnicko ime. -> Pritisnite "back" za povratak na formu za unos</h3>
					<?php
					session_unset();
					session_destroy();
				} 
				else if ($red2 = $rez2->fetch_assoc()) 
				{ ?>
					<h3> Mejl je vec iskoriscen za pravljenje naloga! Molimo Vas upotrgebite drugu e-mail adresu za kreiranje naloga. -> Pritisnite "back" za povratak na formu za unos</h3>
					<?php
					session_unset();
					session_destroy();
				} 
				else if ($pass != $confpass) 
				{ ?>
					<h3>Morate uneti isti password u oba polja! Pritisnite "back" za povratak na formu za unos</h3>
					<?php
					session_unset();
					session_destroy();
				} 
				else 
				{
					$passH = password_hash($pass, PASSWORD_BCRYPT);  // hashing of passsword
					
					$stmt3 = $mysqli->prepare("INSERT INTO korisnici (Username, Pass, Email) VALUES (?, ?, ?)");
					$stmt3->bind_param("sss", $username, $passH, $email);   // inserting new user in db

					if (!$stmt3->execute()) 
					{
						die("Greska: " . $mysqli->error);
					} 
					else 
					{ ?>
						<h3>Uspesno ste se registrovali!</h3><br>
						<br><strong><a style="color:black; font-size: 20px;" href="logovanje.php" id="regLink">Logovanje ⮎</a></strong><br>
					<?php
					}
				}

				$stmt->close();
				$stmt2->close();
				$stmt3->close();
			} 
			else 
			{ ?>
				<h3>Morate popuniti sva polja. Pritisnite "back" za povratak na formu za unos</h3>
				<?php
				session_unset();
				session_destroy();
			}
		}
		include "php/foot.php";
		?>
	</div>
</body>
</html>
