<?php 

class Previsualizar{

	private $consecutivo;
	private $fechaconsecutivo;
	private $texto;
	private $asunto;

	public function obtenerDatos(){
		
		include '../pages/conexion.php';
		$id = $_GET['Id'];
		$sentencia = "SELECT * FROM comunicados WHERE IdComunicado='$id'";
		$datos = $mysqli->query($sentencia);
		$fila = $datos->fetch_assoc();

		$this->consecutivo = $fila['Numero'];
		$this->fechaconsecutivo = $fila['Fecha'];
		$this->texto = $fila['Texto'];
		$this->asunto = $fila['Asunto'];

	}

	public function ver(){

		include ('previsualizar.php');
		$consecutivo = $this->consecutivo;
		$mpdf = new PDF(['format' => 'Letter']);
		$mpdf->setFecha($this->fechaconsecutivo);

		$html = '
		<title>Previsualización '.$this->consecutivo.'</title>
		<style>
		body{
			font-family:"Calibri, sans-serif";
			line-height: 20px;
		}
		@page {
			margin-top: 120px;
			margin-right: 10px;
			margin-bottom: 120px;
			background: url("../formularioUsuarios/fpdf/base.jpg");
			background-image-resize: 6;
		}
		.date{
			width: 100%;
			text-align: right;
			padding-top: -4.5%;
			font-size: 11px;		
		}
		.cuerpo{
			padding-top: 50px;
			padding-left: 50px;
			padding-right: 100px;
			font-size: 13px;
			text-align: justify;
		}
		.firma{
			padding-top: 0px;
			padding-left: 50px;
			font-size: 13px;
		}
		</style>
		<body>
		<div class="date">
		<label><b>Bogotá, '.$mpdf->convertirFecha().' | '.$this->consecutivo.'<b></label>
		</div>

		<div class="cuerpo">
		<label>Doctor(a)</label><br>
		<label><b>Nombre destinatario</b></label><br>
		<label>Cargo destinatario</label><br>
		<label>Entidad destinatario - Regimen</label>
		</div>

		<div class="cuerpo">
		ASUNTO: '.$this->asunto.'<br><br><br>
		<b>Respetado doctor(a)</b><br>'
		.html_entity_decode($this->texto).'
		</div>

		<div class="firma">
		Atentamente,<br><br>
		<img style="width: 300px;" src="images/firma.jpg"/><br>
		<b>Lizbeth Acuña Merchán<br>
		Directora ejecutiva</b>
		</div>

		<body>
		';


		$mpdf->WriteHTML($html);

		$mpdf->Output();

		exit;
		
	}
}

$result=new Previsualizar();
$result->obtenerDatos();
$result->ver();

?>
