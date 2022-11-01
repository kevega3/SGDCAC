<?php 


include('../pages/conexion.php');

$id = $_GET['id'];
$cons = $_GET['Cons'];

$del = "DELETE FROM adjuntosmasivos WHERE IdArchivo = '$id'";

if ($mysqli->query($del)) {
	
	echo "<script>alert('Se eliminó correctamente.')</script>";
	echo "<script>window.location.replace('comunicado.php?Id=$cons')</script>";
}else{
	echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
	echo "<script>window.location.replace('comunicado.php?Id=$cons')</script>";
}

?>