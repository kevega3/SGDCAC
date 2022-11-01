<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sgdcac";

$mysqli = new mysqli("$servername","$username","$password","$dbname");
$mysqli->set_charset("utf8");

if ($mysqli -> connect_errno) {
	echo "Falló la conexión: " . $mysqli -> connect_error;
	exit();
}

try{
	$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
  // set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// $conn->exec("set names utf8mb4");
}catch(PDOException $e){
	echo "Ocurrio un error en la conexión: ".$e->getMessage();
}

?>
