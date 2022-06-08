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

$encabezado = ["IdRespuesta", "Radicado", "Respuesta", "Fecha de respuesta", "Asignado a","Archivo"];

$hojaDeSolicitudes->fromArray($encabezado, null, 'A1');

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
if ($_POST['asignado'] == '0') {
	$asignadoa = "";
}else{
	$asignadoa = " AND IdUsuarioAsignado ='".$_POST['asignado']."'";
}

$consulta = "SELECT * FROM historialrespuestas HR
INNER JOIN usuarios U ON U.IdUsuario = HR.IdUsuarioAsignado
	WHERE ".$fecha.$asignadoa;

$sentencia = $con->prepare($consulta, [
	PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
$numeroDeFila = 2;

while ($solicitud = $sentencia->fetchObject()) {
    # Obtener registros de MySQL
	$IdRespuesta = $solicitud->IdRespuesta;
	$numRadicado = $solicitud->numRadicado;
	$Respuesta = $solicitud->Respuesta;
	$FechaRespuesta = $solicitud->FechaRespuesta;
	$asignadoa = $solicitud->Nombres." ".$solicitud->Apellidos;
	$archivo = "Ver archivo";
	$url = $_SERVER['HTTP_HOST']."/sgdcac/reportes/".$solicitud->RutaArchivo;
	
    # Escribir registros en el documento
	$hojaDeSolicitudes->setCellValueByColumnAndRow(1, $numeroDeFila, $IdRespuesta);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(2, $numeroDeFila, $numRadicado);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(3, $numeroDeFila, $Respuesta);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(4, $numeroDeFila, $FechaRespuesta);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(5, $numeroDeFila, $asignadoa);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(6, $numeroDeFila, $archivo);
	$hojaDeSolicitudes->getCellByColumnAndRow(6, $numeroDeFila, $archivo)->getHyperlink()->setUrl($url);

	$numeroDeFila++;
}

$fileName="Respuestas.xlsx";
# Crear un "escritor"
$writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>
