<?php 

$fechaActual = Date('Y-m-d');
if (!empty($_POST['desde'])) {
	if (!empty($_POST['hasta'])) {
		$fecha = "FechaRespuesta BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'";
	}else{
		$fecha = "FechaRespuesta BETWEEN '".$_POST['desde']."' AND '".$fechaActual."'";
	}
}elseif (!empty($_POST['hasta'])) {
	$fecha = "FechaRespuesta BETWEEN '2022-01-01' AND '".$_POST['hasta']."'";
}else{
	
	$fecha = "FechaRespuesta BETWEEN '2022-01-01' AND '".$fechaActual."'";
}

if (!empty($_POST['radicado'])) {
	$radicado = " AND numRadico ='".$_POST['radicado']."'";
}else{
	$radicado = "";
}

$consulta = "SELECT * FROM historialrespuestas HR
INNER JOIN usuarios U ON U.IdUsuario = HR.IdUsuarioAsignado
WHERE ".$fecha.$radicado;

echo $consulta;
?>