<?php

include "../pages/conexion.php";

$tipopersona=$_POST['tipopersona'];


	$sql = "SELECT IdTipoDocumento, Descripcion FROM tipodocumento WHERE IdTipoPersona = '$tipopersona'";

	$result=mysqli_query($mysqli,$sql);

	$cadena="<select id='tipodocumento' name='tipodocumento' class='campo' required><option disabled selected value=''>Seleccionar</option>";

	while ($ver=mysqli_fetch_row($result)) {
		$cadena=$cadena.'<option value='.$ver[0].'>'.$ver[1].'</option>';
	}

	echo  $cadena."</select>";
?>