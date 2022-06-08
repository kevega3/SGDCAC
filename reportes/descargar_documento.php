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

$hojaDeProductos = $spread->getActiveSheet();
$hojaDeProductos->setTitle("Pruebas");

$encabezado = ["Nombres", "Apellidos", "Cargo", "Prueba", "Prueba"];

$hojaDeProductos->fromArray($encabezado, null, 'A1');

$consulta = "select * from usuarios";
$sentencia = $con->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
$numeroDeFila = 2;

while ($producto = $sentencia->fetchObject()) {
    # Obtener registros de MySQL
    $codigo = $producto->Nombres;
    $productos = $producto->Apellidos;
    $precio_compra = $producto->Cargo;
    $precio_venta = $producto->Correo;
    $existencia = $producto->Pass;
    # Escribir registros en el documento
    $hojaDeProductos->setCellValueByColumnAndRow(1, $numeroDeFila, $codigo);
    $hojaDeProductos->setCellValueByColumnAndRow(2, $numeroDeFila, $productos);
    $hojaDeProductos->setCellValueByColumnAndRow(3, $numeroDeFila, $precio_compra);
    $hojaDeProductos->setCellValueByColumnAndRow(4, $numeroDeFila, $precio_venta);
    $hojaDeProductos->setCellValueByColumnAndRow(5, $numeroDeFila, $existencia);
    $numeroDeFila++;
}

$fileName="Reporte.xlsx";
# Crear un "escritor"
$writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
$writer->save('php://output');
?>
