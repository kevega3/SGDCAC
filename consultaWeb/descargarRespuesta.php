<?php
require('../formularioUsuarios/fpdf/fpdf.php');
date_default_timezone_set('America/Bogota');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale(LC_TIME, 'Spanish');
header("Content-Type: text/html;charset=utf-8");

if(!isset($_GET["Id"])){
	echo "Error";
}
$id = $_GET["Id"];
include ('../pages/conexion.php');
include ('../pages/fecha.php');
$key = 'cu3nt4_d3_4lt0_c05t0';
$sentencia = "SELECT *, PA.Nombre AS Pais,DEP.Nombre AS Departamento, H.Respuesta AS Respuesta FROM peticiones P 
INNER JOIN paises PA ON PA.IdPais = P.IdPais
INNER JOIN departamento DEP ON DEP.IdDepartamento = P.IdDepartamento
INNER JOIN historialrespuestas H ON H.IdRespuesta = P.IdRespuesta
WHERE MD5(concat('$key',P.numRadicado)) = '$id'";
$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();

$radicado = $fila['numRadicado'];
$clave = $fila['clave'];
$asunto = $fila['temaPeticion'];
$mensaje = $fila['Respuesta'];
$direccion = $fila['Direccion'];
$pais = $fila['Pais'];
$idPais = $fila['IdPais'];
$dep = $fila['Departamento'];
$telefono = "Tel. ".$fila['Telefono']." - ".$fila['Movil'];
$correo = $fila['Correo'];
$tipopersona = $fila['IdTipoPersona'];
if ($tipopersona==2) {
	$razonSocial = $fila['razonSocial'];
}else{
	$razonSocial = '';
}
$nombre = $fila['nombreRemitente']." ".$fila['apellidosRemitente'];
$fechaAprobacion = fechaCastellano($fila['FechaAprobacion']);


class PDF extends FPDF
{
	function Header()
	{
		global $radicado;
		global $clave;
		global $fechaAprobacion;
    // Logo
		$this->Image('../formularioUsuarios/fpdf/base.jpg',0,0,210);
    // Arial bold 15
		$this->SetFont('Arial','B',9);
    // Movernos a la derecha
		$this->Cell(120);
    // Título
		$this->Cell(50,0,$fechaAprobacion,0,0,'R');
		$this->Ln(5);
		$this->SetFont('Arial','B',9);
		$this->Cell(170,0,utf8_decode("Al contestar cite los siguientes datos"),0,1,'R');
		$this->Ln(5);
		$this->SetFont('Arial','',9);
		$this->Cell(170,0,utf8_decode("Radicado N°. ").$radicado,0,0,'R');
		$this->Ln(5);
		$this->Cell(170,0,utf8_decode("Código de verificación: ").$clave,0,0,'R');
    // Salto de línea
		$this->Ln(15);
	}

// Pie de página
	function Footer()
	{
    // Posición: a 1,5 cm del final
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',8);
    // Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}
$pdf = new PDF('P', 'mm', array(273,210));
$pdf->SetMargins(30, 25 , 30); // Establecemos los márgenes izquierda, arriba y derecha
$pdf->SetAutoPageBreak(true,35); // Margen inferior
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,10,utf8_decode('Respetado(a)'),0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,utf8_decode($nombre),0,1);
$pdf->Ln(5);
if ($razonSocial == '0') {
}else{
	$pdf->Cell(0,1,$razonSocial,0,1);
	$pdf->Ln(5);
}
$pdf->SetFont('Arial','',11);
if ($idPais == '42') {
	$pdf->Cell(0,1,utf8_decode($dep),0,1);
}else{
	$pdf->Cell(0,1,utf8_decode($pais),0,1);
}
$pdf->Ln(10);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(160,6,'Asunto: '.'Respuesta '.utf8_decode($asunto),0,'J');
$pdf->Ln(5);
$pdf->MultiCell(160,6,utf8_decode($mensaje),0,'J');
$pdf->Ln(5);
$pdf->Cell(0,30,'Atentamente,',0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,utf8_decode('CUENTA DE ALTO COSTO'),0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,10,utf8_decode('Carrera 45 N° 103-34 Oficina 802'),0,1);
$pdf->Cell(0,0,utf8_decode('Bogotá D.C.'),0,1);
$pdf->Cell(0,10,'Conmutador: 7965330',0,1);
$pdf->Cell(0,0,'administrativa@cuentadealtocosto.org',0,1);
$pdf->Output('I', $radicado.'.pdf');
?>