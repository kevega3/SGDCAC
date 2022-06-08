<?php
$fechaActual = Date('Y-m-d');
if (!empty($_POST['desde'])) {
	if (!empty($_POST['hasta'])) {
		$fecha = "fechaReasignacion BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'";
	}else{
		$fecha = "fechaReasignacion BETWEEN '".$_POST['desde']."' AND '".$fechaActual."'";
	}
}elseif (!empty($_POST['hasta'])) {
	$fecha = "fechaReasignacion BETWEEN '2022-01-01' AND '".$_POST['hasta']."'";
}else{
	
	$fecha = "fechaReasignacion BETWEEN '2022-01-01' AND '".$fechaActual."'";
}
if ($_POST['asignado'] == '0') {
	$asignadoa = "";
}else{
	$asignadoa = " AND U.IdUsuarioAsignado ='".$_POST['asignado']."'";
}

if ($_POST['asignadop'] == '0') {
	$asignadop = "";
}else{
	$asignadop = " AND P.IdAsignadoPor ='".$_POST['asignado']."'";
}

$consulta = "SELECT IdReasignacion,IdPeticion,US.Nombres AS NombresRecibe,US.Apellidos AS ApellidosRecibe, U.Nombres AS NombresEnvia, U.Apellidos AS ApellidosEnvia, MotivoReasignacion, fechaReasignacion  
	FROM historialreasignaciones HR
	LEFT JOIN usuarios US ON US.IdUsuario = HR.IdUsuarioAsignado
	LEFT JOIN usuarios U ON U.IdUsuario = HR.IdAsignadoPor 
	WHERE ".$fecha.$asignadoa.$asignadop;

echo $consulta;
?>