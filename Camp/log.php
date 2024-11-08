<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Logovanje</title>
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

if (isset($_POST['dugme'])) 
{
	if (isset($_POST['username']) && isset($_POST['passw'])) 
	{
		$username = $_POST["username"];
		$pass = $_POST["passw"];	

		$collation = "utf8mb4_bin"; //case sensitive collation

		$upit = "SELECT k.KorisnikID, k.Pass, k.EMail, k.RolaID, r.Nivo FROM korisnici k 
		         JOIN rola r ON k.RolaID = r.RolaID 
		         WHERE BINARY Username = ? COLLATE " . $collation;

		if ($stmt = $mysqli->prepare($upit)) 
		{
			$stmt->bind_param("s", $username); 	

			$stmt->execute(); 	

			$rez = $stmt->get_result();  
			$red = $rez->fetch_assoc();

			if($red && password_verify($pass, $red['Pass'])) 
			{
				$_SESSION['Username']=$username;
				$_SESSION['Nivo']=$red['Nivo'];
				$_SESSION['ID']=$red['KorisnikID'];
				$_SESSION['Ispis']='<script type="text/javascript">alert("Uspesno ste se ulogovali.");</script>';

				header("Location: pocetna.php");
				exit(); 
			}
			else
			{
				echo "<strong><p style='color: black; font-size: 20px;'> Pogresan Username ili Password ili nepostojeci Username!!!</p></strong>";
				session_unset();
				session_destroy(); ?>

				<br><strong><a style="color:black; font-size: 20px;" href="logovanje.php" id="loginLink">Nazad na logovanje⮌</a></strong><br>
			<?php 
			}
			$stmt->close();  
		} else {
			echo "<strong><p style='color: red; font-size: 20px;'> Greska prilikom pripreme upita: " . $mysqli->error . "</p></strong>";  
		}
	}
}

include "php/foot.php";
?>
	</div>
</body>
</html>
