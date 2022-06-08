<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
	header ("Location: ../login/index.php");
}

require("class.phpmailer.php");
require("class.smtp.php");

class Gestionar{

	public function gestionDireccion(){

		if(isset($_POST['devolver'])) {
			include ('conexion.php');
			$radicado = $_POST['id'];
			$motivo = $_POST['motivo'];
			$estado = 2;
			$fecha = Date('Y-m-d h:i:s');
			$idDevuelto = $_POST['responsable'];
			$idR = $_POST['idR'];


			$devolver = "
			INSERT INTO `devoluciones`(`numRadicado`, `fechaDevolucion`, `motivo`, `IdUsuario`) VALUES ('$radicado','$fecha','$motivo','$idDevuelto');
			
			UPDATE peticiones SET IdEstadoPeticion = '$estado' WHERE numRadicado = '$radicado';
			UPDATE historialrespuestas SET IdEstadoRespuesta = '2' WHERE IdRespuesta = '$idR'
			";
			$stmt = $conn->prepare($devolver);

			if ($stmt->execute()) {
				Gestionar::notificar();
				echo "<script>alert('La petición ha sido devuleta.')</script>";
				echo "<script>window.location.replace('peticionesPorAprobar.php')</script>";
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
		$fecha = Date('Y-m-d h:i:s');

		$sentencia = "SELECT *, U.Nombres AS NombreR, U.Apellidos AS ApellidosR, U.Correo AS CorreoR,P.Correo AS CorreoRe 
		FROM peticiones P 
		INNER JOIN usuarios U ON U.IdUsuario = P.IdUsuarioAsignado WHERE numRadicado = '$idPeticion'";
		$resultado = $mysqli->query($sentencia);
		$fila = $resultado->fetch_assoc();

		$nombreR = $fila['nombreRemitente']." ".$fila['apellidosRemitente'];
		$correoR = $fila['CorreoRe'];
		$fechaR = $fila['FechaCreacion'];
		$nombreRs = $fila['NombreR']." ".$fila['ApellidosR'];
		$correoResponsable = $fila['CorreoR'];

		$smtpHost = "smtp.office365.com";  // Dominio alternativo brindado en el email de alta 
		$smtpUsuario = "info@cuentadealtocosto.org";  // Mi cuenta de correo
		$smtpClave = "jcvxrwvsldpmczhd";  // Mi contraseña
		//$correo="ngutierrez@cuentadealtocosto.org";
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
		$mail->AddAddress($correoResponsable); // Esta es la direcci�n a donde enviamos los datos del formulario

		$mail->Subject = "Solicitud devuelta"; // Este es el titulo del email.
		$mensajeHtml = nl2br($mensaje);


		$mail->Body = "
		<html>
		<body>
		<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
		<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
		<div style='padding: 0px 30px;'>
		<p>Hola {$nombreRs}.</p>
		<p>Se ha devuelto la solicitud con número de radicado <b>{$idPeticion}</b>. Por favor vuelve a generar la respuesta.</p>
		<p>Consúltala dando <a href='http://192.168.1.11:81/sgdcac/'>clic aquí</a></p>
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
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>FECHA DEVOLUCIÓN</td>
		</tr>
		<tr>
		<td colspan='2'>{$fecha}</td>
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
?>