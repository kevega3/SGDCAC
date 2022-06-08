<?php
// Declaramos la librería
require __DIR__ . "/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spread = new Spreadsheet();

$sheet = $spread->getActiveSheet();
$sheet->setTitle("Hoja 1");
$sheet->setCellValueByColumnAndRow(1, 1, "Valor A1");
$sheet->setCellValue("B1", "Valor celda B2");
$sheet->setCellValue("B2", "Valor celda B2");
$sheet->setCellValue("B3", "Valor celda B3");
$writer = new Xlsx($spread);

$writer->save('./doc_exportados/reporte_de_excel.xlsx');
?>