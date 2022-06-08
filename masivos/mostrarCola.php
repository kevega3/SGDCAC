<?php

require("../pages/class.phpmailer.php");
require("../pages/class.smtp.php");

Class ColaEnvios{

	private $idD;
	private $nombres;
	private $apellidos;
	private $cargo;
	private $entidad;
	private $correo;
	private $mpdf;
	private $comunicado;
	private $numeroC;
	private $asunto;
	private $cuerpo;
	private $trato1;
	private $trato2;
	private $regimen;
	private $respuesta;

	public function getDatos($idD,$nombres,$apellidos,$cargo,$entidad,$correo,$comunicado,$trato1,$trato2,$regimen){

		$this->idD = $idD;
		$this->nombres = $nombres;
		$this->apellidos = $apellidos;
		$this->cargo = $cargo;
		$this->entidad = $entidad;
		$this->correo = $correo;
		$this->comunicado = $comunicado;
		$this->trato1 = $trato1;
		$this->trato2 = $trato2;
		$this->regimen = $regimen;

	}
	public function procesarCola(){

		$destinatario = $this->correo;
		$destinatario = explode(",",$destinatario);
		$nombre = $this->nombres;
		$extraer = ColaEnvios::crearDoc();
		$archivo = $this->mpdf->Output('','S');
		$mensaje = str_replace("\n","<br>",$this->cuerpo);

		$smtpHost = "smtp.office365.com"; 
		$smtpUsuario = "info@cuentadealtocosto.org";
		$smtpClave = "jcvxrwvsldpmczhd";

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Port = 587; 
		$mail->IsHTML(true); 
		$mail->CharSet = "utf-8";

		$mail->Host = $smtpHost; 
		$mail->Username = $smtpUsuario; 
		$mail->Password = $smtpClave;

		$asuntoArchivo = $this->numeroC."_".$this->asunto;

		$mail->From = "info@cuentadealtocosto.org";
		$mail->FromName = "Cuenta de Alto Costo";
		foreach($destinatario as $destinatario=>$valor){
			$mail->addCC(trim($valor));
		}
		
		$mail->addStringAttachment($archivo, $asuntoArchivo.'.pdf');

		$mail->Subject = $asuntoArchivo;
		$mensajeHtml = nl2br($mensaje);
		$mail->Body = "
		<html>
		<body>

		$mensaje

		</body>
		</html>";

		$mail->AltBody = "{$mensaje} \n\n ";

		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		$estadoEnvio = $mail->Send(); 
		if($estadoEnvio){
			$this->respuesta = "El correo fue enviado correctamente a".$this->correo;
		} else {
			$this->respuesta = "Ocurrio un error inesperado con el correo ".$this->correo;
		}
	}

	public function crearDoc(){

		include_once('previsualizar.php');
		include ('../pages/conexion.php');
		$busqueda = "SELECT * FROM comunicados WHERE IdComunicado = '$this->comunicado'";
		$resultado = $mysqli->query($busqueda);
		$fila = $resultado->fetch_assoc();
		$cuerpo = $fila['Texto'];
		$this->numeroC = $fila['Numero'];
		$this->asunto = $fila['Asunto'];
		$this->cuerpo = $fila['CuerpoCorreo'];

		$this->mpdf = new PDF();
		$this->mpdf->setFecha($fila['Fecha']);

		$html = '
		<title>Previsualización '.$this->numeroC.'</title>
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
		<label><b>Bogotá, '.$this->mpdf->convertirFecha().' | '.$this->numeroC.'<b></label>
		</div>

		<div class="cuerpo">
		<label>'.$this->trato1.'</label><br>
		<label><b>'.$this->nombres.' '.$this->apellidos.'</b></label><br>
		<label>'.$this->cargo.'</label><br>
		<label>'.$this->entidad.' - '.$this->regimen.'</label>
		</div>

		<div class="cuerpo">
		ASUNTO: '.$this->asunto.'<br><br><br>'.$this->trato2.' '.$this->trato1.'<br><br>'
		.html_entity_decode($cuerpo).'
		</div>

		<div class="firma">
		<img style="width: 150px;" src="images/firma.png"/><br>
		<b>Lizbeth Acuña Merchán</b><br>
		Directora Ejecutiva
		</div>

		<body>
		';

		$this->mpdf->WriteHTML($html);
	}
	public function recibir(){
		echo $this->respuesta;
	}
}

?>