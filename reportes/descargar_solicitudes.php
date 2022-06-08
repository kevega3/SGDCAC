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
$hojaDeSolicitudes->setTitle("Solicitudes");

$encabezado = ["IdPeticion", "Radicado", "Estado", "Fecha de creación", "Tipo de persona","Nombre remitente","Apellidos remitente","Razón social","Tipo de empresa","País","Departamento","Municipio","Dirección","Télefono","Movil","Correo","Tipo de población","Tema","Mensaje","Número de respuesta","Respuesta","Fecha de aprobación","Asignado a"];

$hojaDeSolicitudes->fromArray($encabezado, null, 'A1');

$fechaActual = Date('Y-m-d 23:59:59');

if (!empty($_POST['desde'])) {
    if (!empty($_POST['hasta'])) {
        $fecha = "P.FechaCreacion BETWEEN '".$_POST['desde']."' AND '".$_POST['hasta']."'";
    }else{
        $fecha = "P.FechaCreacion BETWEEN '".$_POST['desde']."' AND '".$fechaActual."'";
    }
}elseif (!empty($_POST['hasta'])) {
    $fecha = "P.FechaCreacion BETWEEN '2022-01-01 00:00:00' AND '".$_POST['hasta']."'";
}else{
    
    $fecha = "P.FechaCreacion BETWEEN '2022-01-01 00:00:00' AND '".$fechaActual."'";
}
if ($_POST['estado'] == '0') {
    $estado = "";
}else{
    $estado = " AND P.IdEstadoPeticion = '".$_POST['estado']."'";
}
if ($_POST['asignado'] == '0') {
    $asignado = "";
}else{
    $asignado = " AND P.IdUsuarioAsignado ='".$_POST['asignado']."'";
}

$consulta = "SELECT P.IdPeticion,P.numRadicado,E.Descripcion AS Estado,P.FechaCreacion, TPP.Descripcion AS TipoPersona, P.nombreRemitente, P.apellidosRemitente, P.razonSocial,TE.Descripcion AS TipoEmpresa,PS.Nombre AS Pais, D.Nombre AS Departamento,M.Descripcion AS Municipio, P.Direccion,P.Telefono,P.Movil,P.Correo,TPL.Descripcion AS TipoPoblacion,P.temaPeticion,P.Mensaje,P.numRespuesta,HR.Respuesta AS Respuesta, P.FechaAprobacion, U.Nombres, U.Apellidos, P.IdUsuarioAsignado
FROM peticiones P 
LEFT JOIN estadopeticion E ON E.IdEstado = P.IdEstadoPeticion 
LEFT JOIN tipopersona TPP ON TPP.IdTipoPersona = P.IdTipoPersona 
LEFT JOIN tipoempresa TE ON TE.IdTipoEmpresa = P.idTipoEmpresa 
LEFT JOIN paises PS ON PS.IdPais = P.IdPais 
LEFT JOIN departamento D ON D.IdDepartamento = P.IdDepartamento 
LEFT JOIN municipios M ON M.IdMunicipio = P.IdMunicipio 
LEFT JOIN tipopoblacion TPL ON TPL.IdTipoPoblacion = P.IdTipoPoblacion 
LEFT JOIN historialrespuestas HR ON HR.IdRespuesta = P.IdRespuesta 
LEFT JOIN usuarios U ON U.IdUsuario = P.IdUsuarioAsignado 
WHERE ".$fecha.$estado.$asignado;

$sentencia = $con->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
$numeroDeFila = 2;

while ($solicitud = $sentencia->fetchObject()) {
    # Obtener registros de MySQL
    $IdPeticion = $solicitud->IdPeticion;
    $numRadicado = $solicitud->numRadicado;
    $Estado = $solicitud->Estado;
    $FechaCreacion = $solicitud->FechaCreacion;
    $TipoPersona = $solicitud->TipoPersona;
    $nombreRemitente = $solicitud->nombreRemitente;
    $apellidosRemitente = $solicitud->apellidosRemitente;
    $razonSocial = $solicitud->razonSocial;
    $TipoEmpresa = $solicitud->TipoEmpresa;
    $Pais = $solicitud->Pais;
    $Departamento = $solicitud->Departamento;
    $Municipio = $solicitud->Municipio;
    $Direccion = $solicitud->Direccion;
    $Telefono = $solicitud->Telefono;
    $Movil = $solicitud->Movil;
    $Correo = $solicitud->Correo;
    $TipoPoblacion = $solicitud->TipoPoblacion;
    $temaPeticion = $solicitud->temaPeticion;
    $Mensaje = $solicitud->Mensaje;
    $numRespuesta = $solicitud->numRespuesta;
    $Respuesta = $solicitud->Respuesta;
    $FechaAprobacion = $solicitud->FechaAprobacion;
    $asignadoA = $solicitud->Nombres." ".$solicitud->Apellidos;
    # Escribir registros en el documento
    $hojaDeSolicitudes->setCellValueByColumnAndRow(1, $numeroDeFila, $IdPeticion);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(2, $numeroDeFila, $numRadicado);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(3, $numeroDeFila, $Estado);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(4, $numeroDeFila, $FechaCreacion);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(5, $numeroDeFila, $TipoPersona);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(6, $numeroDeFila, $nombreRemitente);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(7, $numeroDeFila, $apellidosRemitente);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(8, $numeroDeFila, $razonSocial);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(9, $numeroDeFila, $TipoEmpresa);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(10, $numeroDeFila, $Pais);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(11, $numeroDeFila, $Departamento);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(12, $numeroDeFila, $Municipio);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(13, $numeroDeFila, $Direccion);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(14, $numeroDeFila, $Telefono);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(15, $numeroDeFila, $Movil);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(16, $numeroDeFila, $Correo);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(17, $numeroDeFila, $TipoPoblacion);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(18, $numeroDeFila, $temaPeticion);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(19, $numeroDeFila, $Mensaje);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(20, $numeroDeFila, $numRespuesta);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(21, $numeroDeFila, $Respuesta);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(22, $numeroDeFila, $FechaAprobacion);
    $hojaDeSolicitudes->setCellValueByColumnAndRow(23, $numeroDeFila, $asignadoA);

    $numeroDeFila++;
}

$fileName="Solicitudes.xlsx";
# Crear un "escritor"
$writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>
