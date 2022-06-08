<?php 

session_start();

if (!isset($_SESSION['usuario'])) {
	header ("Location: ../login/index.php");
}

require("class.phpmailer.php");
require("class.smtp.php");

class Gestionar{

	public function gestionDireccion(){

		if(isset($_POST['aprobar'])) {

			include ('conexion.php');

			$radicado =  $_POST['id'];
			$estado = 4;
			$resp = "CACE-".$radicado;
			$fechaAProbacion = Date('Y-m-d h:i:s');

			$actualizar = "UPDATE peticiones SET IdEstadoPeticion = '$estado', numRespuesta = '$resp', FechaAprobacion = '$fechaAProbacion' WHERE numRadicado='$radicado'";

			$stmt = $conn->prepare($actualizar);

			if ($stmt->execute()) {

				$idR = $_POST['idR'];
				$hrespuesta = "UPDATE historialrespuestas SET IdEstadoRespuesta = '4' WHERE IdRespuesta='$idR'";
				$sm = $conn->prepare($hrespuesta);

				if ($sm->execute()) {
					echo "<script>alert('La petición ha sido aprobada con número de respuesta ".$resp.".')</script>";
					echo "<script>window.location.replace('peticionesPorAprobar.php')</script>";
				}
				
			}else{
				echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
				echo "<script>window.location.replace('peticionesPorAprobar.php')</script>";
			}

			$conn = null;


		}else{
			echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
			echo "<script>window.location.replace('peticionesPorAprobar.php')</script>";
		}

	}
	public function notificar(){

		require("conexion.php");

		$idPeticion = $_POST['id'];
		$key = 'cu3nt4_d3_4lt0_c05t0';
		$enlace = md5($key.$idPeticion);
		$sentencia = "SELECT *, h.RutaArchivo AS archivo 
		FROM Peticiones P 
		INNER JOIN historialrespuestas h ON P.IdRespuesta = h.IdRespuesta 
		WHERE P.numRadicado = '$idPeticion'";
		$resultado = $mysqli->query($sentencia);
		$fila = $resultado->fetch_assoc();

		$nombreR = $fila['nombreRemitente'];
		$correoR = $fila['Correo'];
		$fechaR = $fila['FechaCreacion'];
		$tema = $fila['temaPeticion'];
		$rutaArchivo = $fila['archivo'];


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

		$mail->From = "info@cuentadealtocosto.org"; // Email desde donde env�o el correo.
		$mail->AddAddress($correoR); // Esta es la direcci�n a donde enviamos los datos del formulario

		$mail->Subject = "Respuesta de radicado CAC"; // Este es el titulo del email.
		$mensajeHtml = nl2br($mensaje);


		$mail->Body = "
		<html>
		<body>
		<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
		<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
		<div style='padding: 0px 30px;'>
		<p>Hola {$nombreR}.</p>
		<p>Se ha dado respuesta a su solictud con número de radicado <b>{$idPeticion}</b>. Para ver la respuesta, puede consultarla en nuestro sitio web teniendo en cuenta el número de radicado y la clave envíada al momento de radicar la información o puede descargar el documento de respuesta directamente.</p>

		<p>
		<div style='width: 100%; background-color: red;'>
		<a href='http://192.168.1.11:81/sgdcac/consultaWeb'><div style='width: 49%;background-color: #70C64E;color: #FFF;padding: 5px 0px;text-align: center;border-radius: 3px;float: left;'>Consultar</div></a>
		<a href='http://192.168.1.11:81/sgdcac/files/{$rutaArchivo}'><div style='width: 49%;background-color: #112797;color: #FFF;padding: 5px 0px;text-align: center;border-radius: 3px;float: left;margin-left: 1%;'>Descargar</div></a>
		</div>
		</p>
		</div>
		<div style='padding: 0px 30px;'>
		<table style='width: 100%'>
		<tr>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>REMITENTE:</td>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>CORREO</td>
		</tr>
		<tr>
		<td>{$nombreR}</td>
		<td>{$correoR}</td>
		</tr>
		<tr>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>FECHA RADICADO</td>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>No. RADICADO</td>
		</tr>
		<tr>
		<td>{$fechaR}</td>
		<td>{$idPeticion}</td>
		</tr>
		<tr>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>ASUNTO</td>
		</tr>
		<tr>
		<td colspan='2'>{$tema}</td>
		</tr>
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
$resultado = new Gestionar();
$resultado->gestionDireccion();
$resultado->notificar();


?>