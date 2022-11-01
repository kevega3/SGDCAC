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

$encabezado = ["IdRespuesta", "Radicado", "Respuesta", "Fecha de respuesta", "Asignado a","Estado","Fecha devolución","Motivo","Archivo"];

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

$consulta = "SELECT *,HR.IdRespuesta AS IdResp,HR.numRadicado AS numR 
FROM historialrespuestas HR 
INNER JOIN usuarios U ON U.IdUsuario = HR.IdUsuarioAsignado 
LEFT JOIN devoluciones D ON D.IdRespuesta = HR.IdRespuesta
WHERE ".$fecha.$asignadoa;

$sentencia = $con->prepare($consulta, [
	PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
$numeroDeFila = 2;

while ($solicitud = $sentencia->fetchObject()) {
    # Obtener registros de MySQL
	$IdRespuesta = $solicitud->IdResp;
	$numRadicado = $solicitud->numR;
	$Respuesta = $solicitud->Respuesta;
	$FechaRespuesta = $solicitud->FechaRespuesta;
	$asignadoa = $solicitud->Nombres." ".$solicitud->Apellidos;
	if ($solicitud->IdEstadoRespuesta == '2') {
		$estado = 'Rechazado';
	}elseif($solicitud->IdEstadoRespuesta == '3'){
		$estado = 'Para aprobar';
	}else{
		$estado = 'Aprobado';
	}
	$fechaD = $solicitud->fechaDevolucion;
	$motivoD = $solicitud->motivo;
	$archivo = "Ver archivo";
	$url = $_SERVER['HTTP_HOST']."/sgdcac/reportes/".$solicitud->RutaArchivo;
	
    # Escribir registros en el documento
	$hojaDeSolicitudes->setCellValueByColumnAndRow(1, $numeroDeFila, $IdRespuesta);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(2, $numeroDeFila, $numRadicado);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(3, $numeroDeFila, $Respuesta);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(4, $numeroDeFila, $FechaRespuesta);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(5, $numeroDeFila, $asignadoa);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(6, $numeroDeFila, $estado);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(7, $numeroDeFila, $fechaD);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(8, $numeroDeFila, $motivoD);
	$hojaDeSolicitudes->setCellValueByColumnAndRow(9, $numeroDeFila, $archivo);
	$hojaDeSolicitudes->getCellByColumnAndRow(9, $numeroDeFila, $archivo)->getHyperlink()->setUrl($url);

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
