<?php
require('fpdf/fpdf.php');
date_default_timezone_set('America/Bogota');
setlocale(LC_TIME, 'es_ES.UTF-8');
setlocale(LC_TIME, 'Spanish');
header("Content-Type: text/html;charset=utf-8");

if(!isset($_GET["Id"])){
	echo "Error";
}
$id = $_GET["Id"];
include ('../pages/conexion.php');
$key = 'cu3nt4_d3_4lt0_c05t0';
$sentencia = "SELECT *, PA.Nombre AS Pais FROM peticiones P 
INNER JOIN paises PA ON PA.IdPais = P.IdPais
WHERE MD5(concat('$key',numRadicado)) = '$id'";
$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();
$radicado = $fila['numRadicado'];
$clave = $fila['clave'];
$asunto = $fila['temaPeticion'];
$mensaje = $fila['Mensaje'];
$direccion = $fila['Direccion'];
$pais = $fila['Pais'];
$telefono = "Tel. ".$fila['Telefono']." - ".$fila['Movil'];
$correo = $fila['Correo'];
$tipopersona = $fila['IdTipoPersona'];
if ($tipopersona==2) {
	$razonSocial = $fila['razonSocial'];
}else{
	$razonSocial = '';
}
$nombre = $fila['nombreRemitente']." ".$fila['apellidosRemitente'];


class PDF extends FPDF
{
	function Header()
	{
		global $radicado;
		global $clave;
    // Logo
		$this->Image('fpdf/base.jpg',0,0,210);
    // Arial bold 15
		$this->SetFont('Arial','B',9);
    // Movernos a la derecha
		$this->Cell(120);
    // Título
		$this->Cell(50,0,strftime("%A %d de %B del %Y"),0,0,'R');
		$this->Ln(5);
		$this->SetFont('Arial','',9);
		$this->Cell(170,0,utf8_decode("Radicado N°. ").$radicado,0,1,'R');
		$this->Ln(5);
		$this->Cell(170,0,utf8_decode("Consulte el estado de su trámite en nuestra página web"),0,0,'R');
		$this->Ln(5);
		$this->Cell(170,0,"https://cuentadealtocosto.org/site/consultasolicitud/",0,0,'R');
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
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,10,utf8_decode('Señores'),0,1);
$pdf->Cell(0,1,'CUENTA DE ALTO COSTO',0,1);
$pdf->Ln(10);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(160,6,'Asunto: '.utf8_decode($asunto),0,'J');
$pdf->Ln(5);
$pdf->MultiCell(160,6,utf8_decode($mensaje),0,'J');
$pdf->Ln(5);
$pdf->Cell(0,5,'Archivos adjuntos:',0,1);
$archivos = "SELECT * FROM historialarchivos WHERE MD5(concat('$key',numRadico)) = '$id'";
$res = $mysqli->query($archivos);
while ($files = $res->fetch_assoc()) {
	$pdf->Cell(0,5,utf8_decode($files['nombreArchivo']),0,1);
}
$pdf->Cell(0,30,'Atentamente,',0,1);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,utf8_decode($nombre),0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,10,utf8_decode($direccion),0,1);
$pdf->Cell(0,0,utf8_decode($pais),0,1);
$pdf->Cell(0,10,$telefono,0,1);
$pdf->Cell(0,0,$correo,0,1);
$pdf->Cell(0,10,$razonSocial,0,1);
$pdf->Output('I', $radicado.'.pdf');
?>