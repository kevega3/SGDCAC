<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
	header ("Location: ../login/index.php");
}else{

	header("Content-Type: text/html;charset=utf-8");
	require("../pages/class.phpmailer.php");
	require("../pages/class.smtp.php");

	class Gestionar{

		public $respuesta;
		public $fecha;


		public function __construct ($respuesta,$fecha){
			$this->respuesta = $respuesta;
			$this->fecha = $fecha;
		}

		public function guardarRespuesta(){


			if (isset($_POST['responder'])) {
				
				include ('conexion.php');
				$radicado =  $_POST['radicado'];

				$sentencia = "UPDATE observaciones SET Respuesta = '$this->respuesta', fechaRespuesta = '$this->fecha' , IdEstado = '4' WHERE numRadicado = '$radicado'";

				$smtm = $conn->prepare($sentencia);

				if ($smtm->execute()) {

					echo "<script>alert('Se guardó correctamente su respuesta.')</script>";
					echo "<script>window.location.replace('peticionesPendientes.php')</script>";					
				}else{
					echo "<script>alert('Se presentó un error, por favor vuelva a intentarlo.')</script>";
					echo "<script>window.location.replace('peticionesPendientes.php')</script>";
				}
				
			}else{
				echo "<script>alert('No se identifica ningún dato.')</script>";
				echo "<script>window.location.replace('peticionesPendientes.php')</script>";
			}

		}

		public function notificacion(){

			require("conexion.php");
			$radicado =  $_POST['radicado'];

			$sentencia = "SELECT * FROM peticiones WHERE numRadicado = '$radicado'";
			$resultado = $mysqli->query($sentencia);
			$fila = $resultado->fetch_assoc();

			$nombreResponsable = $fila['nombreRemitente']." ".$fila['apellidosRemitente'];
			$correoResponsable = $fila['Correo'];

			$sentence = "SELECT * FROM observaciones WHERE numRadicado = '$radicado'";
			$result = $mysqli->query($sentence);
			$row = $result->fetch_assoc();

			$observacion = $row['observacion'];
			$respuesta = $this->respuesta;
			$fecha = $this->fecha;

			$smtpHost = "smtp.office365.com";  // Dominio alternativo brindado en el email de alta 
			$smtpUsuario = "info@cuentadealtocosto.org";  // Mi cuenta de correo
			$smtpClave = "jcvxrwvsldpmczhd";  // Mi contraseña
			$mensaje = "Mensaje de la CAC";

			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Port = 587; 
			$mail->IsHTML(true); 
			$mail->CharSet = "utf-8";


		// VALORES A MODIFICAR //
			$mail->Host = "smtp.office365.com"; 
			$mail->Username = "info@cuentadealtocosto.org"; 
			$mail->Password = "jcvxrwvsldpmczhd";

			$mail->From = "info@cuentadealtocosto.org"; 
			$mail->AddAddress($correoResponsable); 
			$mail->Subject = "Observación";


			$mail->Body = "
			<html>
			<body>
			<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
			<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
			<div style='padding: 0px 30px;'>
			<p>Hola {$nombreResponsable}.</p>
			<p>Se ha dado respuesta a su observación en la solicitud con número de radicado <b>{$radicado}</b></p>
			</div>
			<div style='padding: 0px 30px;'>
			<table style='width: 100%'>
			<tr>
			<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>REMITENTE:</td>
			<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>CORREO</td>
			</tr>
			<tr>
			<td>{$nombreResponsable}</td>
			<td>{$correoResponsable}</td>
			</tr>
			<tr>
			<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>FECHA DE RESPUESTA</td>
			<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>No. RADICADO</td>
			</tr>
			<tr>
			<td>{$fecha}</td>
			<td>{$radicado}</td>
			</tr>
			<tr>
			<td colspan='2' style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>OBSERVACIÓN</td>
			</tr>
			<tr>
			<td>{$observacion}</td>
			<tr>
			<tr>
			<td colspan='2' style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>RESPUESTA</td>
			</tr>
			<tr>
			<td>{$respuesta}</td>
			<tr>
			</table>
			</div>
			</div>
			</body>
			</html>
			";

			$mail->AltBody = "{$mensaje}";

			$mail->SMTPoptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			$estadoEnvio = $mail->Send();
			if ($estadoEnvio) {
			}else{
				echo "Ocurrio un error en el envío de la información. Por favor comunicarse con el administrador.";
			}
		}
	}

	$resultado = new Gestionar($_POST['Respuesta'],Date('Y-m-d h:i:s'));
	//$resultado->guardarRespuesta();
	$resultado->notificacion();
}
?>