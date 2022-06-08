<?php
include "../pages/conexion.php";

$departamento=$_POST['departamento'];


	$sql = "SELECT IdMunicipio, Descripcion FROM municipios WHERE IdDepartamento = '$departamento'";

	$result=mysqli_query($mysqli,$sql);

	$cadena="<select id='municipio' name='municipio' class='campo'><option disabled selected value=''>Seleccionar</option>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.$ver[1].'</option>';
	}

	echo  $cadena."</select>";
?>