<?php
require_once "vendor/autoload.php";

# Nuestra base de datos
require_once "db_conect.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

# Obtener base de datos
$con = ConexionBD();

$documento = new Spreadsheet();
$documento
    ->getProperties()
    ->setCreator("Nestor Tapia")
    ->setLastModifiedBy('BaulPHP')
    ->setTitle('Archivo generado desde MySQL')
    ->setDescription('Productos y proveedores exportados desde MySQL');

$hojaDeProductos = $documento->getActiveSheet();
$hojaDeProductos->setTitle("Productos");

# Encabezado de los productos
$encabezado = ["Codigo", "Producto", "Precio de compra", "Precio de venta", "Existencia"];
# El último argumento es por defecto A1
$hojaDeProductos->fromArray($encabezado, null, 'A1');

$consulta = "select * from tbl_productos";
$sentencia = $con->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
# Comenzamos en la fila 2
$numeroDeFila = 2;
while ($producto = $sentencia->fetchObject()) {
    # Obtener registros de MySQL
    $codigo = $producto->codigo;
    $productos = $producto->producto;
    $precio_compra = $producto->precio_compra;
    $precio_venta = $producto->precio_venta;
    $existencia = $producto->existencia;
    # Escribir registros en el documento
    $hojaDeProductos->setCellValueByColumnAndRow(1, $numeroDeFila, $codigo);
    $hojaDeProductos->setCellValueByColumnAndRow(2, $numeroDeFila, $productos);
    $hojaDeProductos->setCellValueByColumnAndRow(3, $numeroDeFila, $precio_compra);
    $hojaDeProductos->setCellValueByColumnAndRow(4, $numeroDeFila, $precio_venta);
    $hojaDeProductos->setCellValueByColumnAndRow(5, $numeroDeFila, $existencia);
    $numeroDeFila++;
}

# Ahora creamos la hoja "proveedores"
$hojaDeProveedores = $documento->createSheet();
$hojaDeProveedores->setTitle("Proveedores");

# Declaramos el encabezado
$encabezado = ["Nombres", "Dirección Email ", "Empresa", "Pais residencia"];
$hojaDeProveedores->fromArray($encabezado, null, 'A1');
# Obtener los proveedores de MySQL
$consulta = "select * from tbl_proveedores";
$sentencia = $con->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();

# Comenzamos en la 2
$numeroDeFila = 2;
while ($proveedores = $sentencia->fetchObject()) {
    # Obtener los datos de la base de datos
    $nombres = $proveedores->nombres;
    $correo = $proveedores->correo;
    $empresa = $proveedores->empresa;
    $pais = $proveedores->pais;

    # Escribir en el documento
    $hojaDeProveedores->setCellValueByColumnAndRow(1, $numeroDeFila, $nombres);
    $hojaDeProveedores->setCellValueByColumnAndRow(2, $numeroDeFila, $correo);
    $hojaDeProveedores->setCellValueByColumnAndRow(3, $numeroDeFila, $empresa);
    $hojaDeProveedores->setCellValueByColumnAndRow(4, $numeroDeFila, $pais);
    $numeroDeFila++;
}
# Crear un "escritor"
$writer = new Xlsx($documento);
# Le pasamos la ruta de guardado
$writer->save('./doc_exportados/Exportado_productos_proveedores.xlsx');
?>