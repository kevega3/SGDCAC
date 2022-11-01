<?php 

include("../../pages/conexion.php");


$user_id = $_GET['id'];

$data = "";


$query = "SELECT * FROM correos WHERE idPersona = '$user_id'";

if (!$result = mysqli_query($mysqli, $query)) {
	exit(mysqli_error($mysqli));
}
if (mysqli_num_rows($result) > 0) {

	$numero = 0;

	while($row = mysqli_fetch_assoc($result)) {
		$numero++;

		$data = $data."<input type='text' value='".$row['Correo']."' class='form-control'><br>";
	}

}else{
	$data = 'Sin información';
}
echo $data;
?>