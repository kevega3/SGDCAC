<?php 

include("../../pages/conexion.php");


$user_id = $_GET['id'];

$data = "";


$query = "SELECT *, L.Nombre AS NombreL FROM `asignacionlista` AL LEFT JOIN listas L ON L.idLista = AL.idLista LEFT JOIN persona P ON P.idPersona = AL.idContacto WHERE idContacto = '$user_id'";

if (!$result = mysqli_query($mysqli, $query)) {
	exit(mysqli_error($mysqli));
}
if (mysqli_num_rows($result) > 0) {

	$numero = 0;

	while($row = mysqli_fetch_assoc($result)) {
		$numero++;

		$data = $data."<input type='text' value='".$row['NombreL']."' class='form-control'><br>";
	}

}else{
	$data = 'Sin información';
}
echo $data;
?>