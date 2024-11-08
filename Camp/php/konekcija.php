<?php

$mysqli="";

$mysqli = new mysqli("127.0.0.1:3307","root","root","kamp");

if ($mysqli->error) 
{
	echo "Greska pri konektovanju na bazu!";
}

 ?>