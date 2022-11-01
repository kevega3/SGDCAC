<?php

class Correo{

	private $idC;
	private $correo;
	private $idD;
	private $nombres;
	private $apellidos;
	private $cargo;
	private $trato1;
	private $trato2;
	private $entidad;
	private $regimen;
	private $formato;
	private $numeroC;
	private $asunto;
	private $cuerpo;
	private $fecha;
	private $mpdf;
	private $cuenta;

	public function setIdComunicado($id){
		$this->idC = $id;
	}

	public function setCorreo($correo){
		$this->correo = $correo;
	}

	public function getDatosDestinatarios(){
		include ('../pages/conexion.php');
		$obtener = "SELECT * FROM envios WHERE IdComunicado = '$this->idC' AND IdDestinatario = '$this->idD'";
		$resultado = $mysqli->query($obtener);
		$fila = $resultado->fetch_assoc();

		$this->correo = $fila['correo'];
		$this->nombres = $fila['nombres'];
		$this->apellidos = $fila['apellidos'];
		$this->cargo = $fila['cargo'];
		$this->trato1 = $fila['trato1'];
		$this->trato2 = $fila['trato2'];
		$this->entidad = $fila['entidad'];
		$this->regimen = $fila['regimen'];
		
	}

	public function getDatosComunicado(){
		include ('../pages/conexion.php');
		$busqueda = "SELECT * FROM comunicados WHERE IdComunicado = '$this->idC'";
		$resultado = $mysqli->query($busqueda);
		$row = $resultado->fetch_assoc();
		$this->formato = $row['Texto'];
		$this->numeroC = $row['Numero'];
		$this->asunto = $row['Asunto'];
		$this->cuerpo = $row['CuerpoCorreo'];
		$this->fecha = $row['Fecha'];
		$this->cuenta = $row['IdCuenta'];
	}

	public function crearDoc(){
		include_once('previsualizar.php');

		$this->mpdf = new PDF(['format' => 'Letter']);
		$this->mpdf->setFecha($this->fecha);

		$html = '
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
		<label><b>Bogotá, '.$this->mpdf->convertirFecha().' | '.$this->numeroC.'<b></label>
		</div>

		<div class="cuerpo">
		<label>'.$this->trato1.'</label><br>
		<label><b>'.$this->nombres.' '.$this->apellidos.'</b></label><br>
		<label>'.$this->cargo.'</label><br>
		<label>'.$this->entidad.' '.$this->regimen.'</label>
		</div>

		<div class="cuerpo">
		ASUNTO: '.$this->asunto.'<br><br><br>'.$this->trato2.' '.$this->trato1.'<br><br>'
		.html_entity_decode($this->formato).'
		</div>

		<div class="firma">
		Atentamente,<br><br>
		<img style="width: 300px;" src="images/firma.jpg"/><br>
		<b>Lizbeth Acuña Merchán<br>
		Directora ejecutiva</b>
		</div>

		<body>
		';

		$this->mpdf->WriteHTML($html);
	}

	public function procesarCorreo(){

		if(isset($_POST['email_data'])){
			require '../pages/class.phpmailer.php';
			require '../pages/class.smtp.php';
			include ('../pages/conexion.php');
			$output = '';
			$iniciar = Correo::getDatosComunicado();
			$datos = "SELECT * FROM smtp_options WHERE IdCorreo = '$this->cuenta'";
			$resultado = $mysqli->query($datos);
			$fila = $resultado->fetch_assoc();

			foreach($_POST['email_data'] as $row)
			{
				$this->idD = $row['email'];
				$iniciar = Correo::getDatosDestinatarios();
				
				$iniciar = Correo::crearDoc();
				$mensaje = str_replace("\n","<br>",$this->cuerpo);
				$archivo = $this->mpdf->Output('','S');

				$smtpHost = "smtp.office365.com";
				$smtpUsuario = $fila['correo'];
				$smtpClave = $fila['pass_smtp'];

				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->Port = 587; 
				$mail->IsHTML(true); 
				$mail->CharSet = "utf-8";

				$mail->Host = $smtpHost; 
				$mail->Username = $smtpUsuario; 
				$mail->Password = $smtpClave;

				$mail->From = $smtpUsuario;//the From email address for the message
				$mail->FromName = "Cuenta de Alto Costo";//Sets the From name of the message
				$destinatario= $this->correo;
				$destinatario = explode(",", $destinatario);
				foreach ($destinatario as $destinatario => $value) {
					$mail->addCC(trim($value));
				}
				$asuntoArchivo = $this->numeroC."_".$this->asunto;
				$mail->addStringAttachment($archivo,$asuntoArchivo.'.pdf');
				$mail->Subject = $asuntoArchivo; // Asunto del mensaje
				//An HTML or plain text message body
				$mensajeHtml = nl2br($mensaje);
				$mail->Body = "
				<html>
				<body>

				$mensaje

				</body>
				</html>
				";

				$mail->AltBody = "{$mensaje} \n\n ";
		//Enviar un correo electrónico. Devuelve verdadero en caso de éxito o falso en caso de error

				$adjuntos = "SELECT * FROM adjuntosmasivos WHERE IdComunicado = '$this->idC'";
				$enc = $mysqli->query($adjuntos);

				while($row = $enc->fetch_assoc()){
					$ruta = $row['ubicacion'];
					$mail->AddAttachment($ruta);
				}


				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);

				$result = $mail->Send();

				if($result){
					$output = '';
					$iniciar = Correo::Actualizar();
				}else
				{
					$output .= $mail->ErrorInfo;

				}

			}

			if($output == ''){
				echo 'ok';
			}else{
				echo $output;
			}
			
		}
	}

	public function Actualizar(){
		include ('../pages/conexion.php');
		$update = "UPDATE envios SET estadoEnvio = '1' WHERE IdDestinatario = '$this->idD'";
		$resultado = $mysqli->query($update);
		$revisar = Correo::revisar();
	}

	public function revisar(){
		include('../pages/conexion.php');
		$query = "SELECT COUNT(estadoEnvio) AS contador FROM envios WHERE IdComunicado = '$this->idC' AND estadoEnvio = '0'";
		$res = $mysqli->query($query);
		$data = $res->fetch_assoc();
		if ($data['contador']=='0') {
			$actualizar = "UPDATE comunicados SET Enviado = '1' WHERE IdComunicado = '$this->idC'";
			$enviar = $mysqli->query($actualizar);
		}
	}

}
$resultado = new Correo();
$resultado->setIdComunicado($_GET['Id']);
$resultado->procesarCorreo();
?>
