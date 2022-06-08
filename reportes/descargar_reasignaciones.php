<?php
// Declaramos la librería
require __DIR__ . "/vendor/autoload.php";

require_once "db_conect.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$con = ConexionBD();

$spread = new Spreadsheet();
$spread
->getProperties()
->setCreator("Cuenta de Alto Costo")
->setLastModifiedBy('Nicolas Gutierrez')
->setTitle('Reporte sistema de correspondencia')
->setSubject('Reporte')
->setDescription('Reporte sistema de correspondencia')
->setKeywords('CAC')
->setCategory('Reportes');

$hojaDeSolicitudes = $spread->getActiveSheet();
$hojaDeSolicitudes->setTitle("Reasignaciones");

$encabezado = ["IdReasignacion", "Radicado", "Asignado a", "Motivo", "Fecha de reasignación","Reasignado por"];

$hojaDeSolicitudes->fromArray($encabezado, null, 'A1');

$fechaActual = Date('Y-m-d 23:59:59');
if (!empty($_POST['desde'])) {
	if (!empty($_POST['hasta'])) {
		$fecha = "fechaReasignacion BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'";
	}else{
		$fecha = "fechaReasignacion BETWEEN '".$_POST['desde']."' AND '".$fechaActual."'";
	}
}elseif (!empty($_POST['hasta'])) {
	$fecha = "fechaReasignacion BETWEEN '2022-01-01 00:00:00' AND '".$_POST['hasta']."'";
}else{
	
	$fecha = "fechaReasignacion BETWEEN '2022-01-01 00:00:00' AND '".$fechaActual."'";
}
if ($_POST['asignado'] == '0') {
	$asignadoa = "";
}else{
	$asignadoa = " AND IdUsuarioAsignado ='".$_POST['asignado']."'";
}

if ($_POST['asignadop'] == '0') {
	$asignadop = "";
}else{
	$asignadop = " AND IdAsignadoPor ='".$_POST['asignado']."'";
}

$consulta = "SELECT IdReasignacion,IdPeticion,US.Nombres AS NombresRecibe,US.Apellidos AS ApellidosRecibe, U.Nombres AS NombresEnvia, U.Apellidos AS ApellidosEnvia, MotivoReasignacion, fechaReasignacion  
	FROM historialreasignaciones HR
	LEFT JOIN usuarios US ON US.IdUsuario = HR.IdUsuarioAsignado
	LEFT JOIN usuarios U ON U.IdUsuario = HR.IdAsignadoPor 
	WHERE ".$fecha.$asignadoa.$asignadop;

$sentencia = $con->prepare($consulta, [
	PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
$numeroDeFila = 2;

while ($solicitud = $sentencia->fetchObject()) {
    # Obtener registros de MySQL
	$IdReasignacion = $solicitud->IdReasignacion;
	$numRadicado = $solicitud->IdPeticion;
	$asignadoa = $solicitud->NombresRecibe." ".$solicitud->ApellidosRecibe;
	$MotivoReasignacion = $solicitud->MotivoReasignacion;
	$fechaReasignacion = $solicitud->fechaReasignacion;
	$asignadop = $solicitud->NombresEnvia." ".$solicitud->ApellidosEnvia;
	
    # Escribir registros en el documento
	$hojaDeSolicitudes->setCellValueByColumnAndRow(1, $numeroDeFila, $IdReasignacion);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(2, $numeroDeFila, $numRadicado);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(3, $numeroDeFila, $asignadoa);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(4, $numeroDeFila, $MotivoReasignacion);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(5, $numeroDeFila, $fechaReasignacion);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(6, $numeroDeFila, $asignadop);

	$numeroDeFila++;
}

$fileName="Reasignaciones.xlsx";
# Crear un "escritor"
$writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>
