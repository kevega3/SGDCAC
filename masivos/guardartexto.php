<?php 

class Documento{

	private $id;
	private $nombre;
	private $consecutivo;
	private $fechaconsecutivo;
	private $asunto;
	private $texto;
	private $cuerpo;

	public function setValores($id,$nombre,$consecutivo,$fechaconsecutivo,$asunto,$texto,$cuerpo){

		$this->id = $id;
		$this->nombre = $nombre;
		$this->consecutivo = $consecutivo;
		$this->fechaconsecutivo = $fechaconsecutivo;
		$this->asunto = $asunto;
		$this->texto = $texto;
		$this->cuerpo = $cuerpo;

	}

	public function guardarTexto(){

		include ('../pages/conexion.php');

		$actualizar = "UPDATE `comunicados` SET `Nombre`='$this->nombre',`Numero`='$this->consecutivo',`Fecha`='$this->fechaconsecutivo',`Asunto`='$this->asunto',`Texto`='$this->texto', `CuerpoCorreo`='$this->cuerpo' WHERE IdComunicado = '$this->id'";

		$guardar = $conn->prepare($actualizar);

		if ($guardar->execute()) {

			echo "<script>alert('Se guardó correctamente.')</script>";
			echo "<script>window.location.replace('destinatarios.php?Id=$this->id')</script>";
		}else{
			echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
			echo "<script>window.location.replace('comunicado.php?Id=$this->id')</script>";
		}
	}

	public function previsualizar(){

		include ('previsualizar.php');
		$consecutivo = $this->consecutivo;
		$mpdf = new PDF();
		$mpdf->setFecha($this->fechaconsecutivo);

		$html = '
		<title>Previsualización '.$this->consecutivo.'</title>
		<style>
		body{
			font-family:"Calibri, sans-serif";
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
			padding-top: -3%;
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
			padding-top: 50px;
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
		Respetado doctor(a)<br>'
		.html_entity_decode($this->texto).'
		</div>

		<div class="firma">
		<img style="width: 150px;" src="images/firma.png"/><br>
		<b>Lizbeth Acuña Merchán</b><br>
		Directora Ejecutiva
		</div>

		<body>
		';


		$mpdf->WriteHTML($html);

		$mpdf->Output();

		exit;
		
	}
}

$resultado = new Documento();
$resultado->setValores($_POST['id'],$_POST['nombre'],$_POST['consecutivo'],$_POST['fecha'],$_POST['asunto'],htmlentities($_POST['documento']),htmlentities($_POST['cuerpo']));

if (isset($_POST['guardar'])) {

	$resultado->guardarTexto();
}

if (isset($_POST['previsualizar'])) {

	$resultado->previsualizar();
}

?>