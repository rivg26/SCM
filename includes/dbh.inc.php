<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "scm";

$Conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$Conn) {
	die("Connection failed: ".mysqli_connect_error());
}


