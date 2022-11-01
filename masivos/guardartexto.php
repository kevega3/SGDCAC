<?php 

class Documento{

	private $id;
	private $nombre;
	private $consecutivo;
	private $fechaconsecutivo;
	private $asunto;
	private $texto;
	private $cuerpo;
	private $archivos;

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

	public function setArchivo($archivo){

		$this->archivos = $archivo;

	}

	public function subirArchivos(){

		include '../pages/conexion.php';

		foreach ($this->archivos['tmp_name'] as $key => $tmp_name) {

			$filename = Documento::texto($this->archivos['name'][$key]);

			$temporal = $this->archivos['tmp_name'][$key];
			$type = $this->archivos['type'];
			$fechaActual = Date('Y-m-d h:i:s');

			$directorio = '../files/masivos/'.Date('Y').'/'.Date('m').'/';
			$ruta = $directorio.$filename;

			if (!file_exists($directorio)) {
				mkdir($directorio, 0777, true);
			}

			if (!file_exists($ruta)) {
				$res = @move_uploaded_file($temporal,$ruta);
			}else{
				$ruta = $directorio.date('ymdhis').$filename;
				$res = @move_uploaded_file($temporal,$ruta);
			}
			if ($res) {
				$mysqli->query("INSERT INTO `adjuntosmasivos`(`IdComunicado`, `nombre`, `ubicacion`, `fechaSubida`) VALUES ('$this->id','$filename','$ruta','$fechaActual');");
			}	
		}

	}

	public function previsualizar(){

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
		Respetado doctor(a)<br>'
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

	public function texto($cadena){

    	//Ahora reemplazamos las letras
		$cadena = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$cadena
		);

		$cadena = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$cadena );

		$cadena = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$cadena );

		$cadena = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô', 'Ó'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
			$cadena );

		$cadena = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$cadena );

		$cadena = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C'),
			$cadena
		);

		$exp_regular = array();
		$exp_regular[0] = '/ /';
		$exp_regular[1] = '/​/';
		$exp_regular[2] = '/ /';

		$cadena_nueva = array();
		$cadena_nueva[0] = '_';
		$cadena_nueva[1] = '_';
		$cadena_nueva[2] = '_';

		$filename = strtolower(preg_replace($exp_regular, $cadena_nueva, $cadena));

		return $filename;
	}
}

$resultado = new Documento();

$resultado->setValores($_POST['id'],$_POST['nombre'],$_POST['consecutivo'],$_POST['fecha'],$_POST['asunto'],htmlentities($_POST['documento']),htmlentities($_POST['cuerpo']));

if (isset($_POST['guardar'])) {

	if ($_FILES['archivo']['name']['0'] == '') {

		$resultado->guardarTexto();

	}else{

		$resultado->setArchivo($_FILES['archivo']);
		$resultado->subirArchivos();
		$resultado->guardarTexto();
	}

}

if (isset($_POST['previsualizar'])) {

	$resultado->previsualizar();
}

?>
