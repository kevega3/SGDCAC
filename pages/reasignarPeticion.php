<?php 
session_start();
date_default_timezone_set('America/Bogota');
if (!isset($_SESSION['usuario'])) {
	header ("Location: ../login/index.php");
}

require("class.phpmailer.php");
require("class.smtp.php");


class Reasignacion{

	public function reasignar(){

		$idPeticion = $_POST['idpeticion'];
		$reasignar = $_POST['nuevoR'];
		$responsable = $_SESSION['IdUsuario'];
		$fecha = Date('Y-m-d h:i:s');
		$estado = 2;
		$motivo = $_POST['motivoReasignacion'];

		if (isset($_POST['reasignar'])) {
			include ('conexion.php');
			

			$actualizar = "UPDATE peticiones SET IdEstadoPeticion = '$estado',IdUsuarioAsignado='$reasignar' WHERE numRadicado = '$idPeticion'; INSERT INTO `historialreasignaciones`(`IdPeticion`, `IdUsuarioAsignado`, `MotivoReasignacion`, `fechaReasignacion`, `IdAsignadoPor`) VALUES ('$idPeticion','$reasignar','$motivo','$fecha','$responsable');";

			$stmt = $conn->prepare($actualizar);

			if ($stmt->execute()) {
				echo "<script>alert('Se reasgino correctamente.')</script>";
				echo "<script>window.location.replace('peticionesPendientes.php')</script>";
			}else{
				echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
				echo "<script>window.location.replace('Gestionar.php?Id=$idPeticion')</script>";
			}

			$conn = null;
		}else{
			echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
			echo "<script>window.location.replace('Gestionar.php?Id=$idPeticion')</script>";
		}
		
	}

	public function notificar(){

		require("conexion.php");
		$idPeticion = $_POST['idpeticion'];
		$reasignar = $_POST['nuevoR'];// Id nuevo responsable
		$responsable = $_SESSION['IdUsuario']; // Id quien reasigna
		$correoQuienReasigna = $_SESSION['usuario'];
		$nombresQuienReasigna = $_SESSION['nombre']." ".$_SESSION['apellido'];
		$fecha = Date('Y-m-d h:i:s');
		$motivo = $_POST['motivoReasignacion'];

		$sentencia = "SELECT * FROM usuarios WHERE IdUsuario = '$reasignar'";
		$resultado = $mysqli->query($sentencia);
		$fila = $resultado->fetch_assoc();

		$nombreNuevo = $fila['Nombres'];
		$correoNuevo = $fila['Correo'];

		$smtpHost = "smtp.office365.com";  // Dominio alternativo brindado en el email de alta 
		$smtpUsuario = "info@cuentadealtocosto.org";  // Mi cuenta de correo
		$smtpClave = "jcvxrwvsldpmczhd";  // Mi contraseña
		$correo="ngutierrez@cuentadealtocosto.org";
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
		$mail->AddAddress($correoNuevo); // Esta es la direcci�n a donde enviamos los datos del formulario

		$mail->Subject = "Reasignación de solicitud"; // Este es el titulo del email.
		$mensajeHtml = nl2br($mensaje);


		$mail->Body = "
		<html>
		<body>
		<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
		<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
		<div style='padding: 0px 30px;'>
		<p>Hola {$nombreNuevo}.</p>
		<p>Se le ha reasignado una solicitud.</p>
		<p>Consúltela dando <a href='https://cuentadealtocosto.org/sgdcac/'>clic aquí</a></p>
		</div>
		<div style='padding: 0px 30px;'>
		<table style='width: 100%'>
		<tr>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>QUIEN REASIGNA:</td>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>CORREO</td>
		</tr>
		<tr>
		<td>{$nombresQuienReasigna}</td>
		<td>{$correoQuienReasigna}</td>
		</tr>
		<tr>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>FECHA REASIGNACIÓN</td>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>No. RADICADO</td>
		</tr>
		<tr>
		<td>{$fecha}</td>
		<td>{$idPeticion}</td>
		</tr>
		<tr>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>MOTIVO DE REASIGNACIÓN:</td>
		</tr>
		<tr>
		<td colspan='2'>{$motivo}</td>
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

$resultado = new Reasignacion();
$resultado->reasignar();
$resultado->notificar();

?>
