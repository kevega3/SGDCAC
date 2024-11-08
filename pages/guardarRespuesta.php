<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
	header ("Location: ../login/index.php");
}else{
	header("Content-Type: text/html;charset=utf-8");
	require("class.phpmailer.php");
	require("class.smtp.php");

	class Responder{

		private $filename;

		public function respuesta(){

			if (isset($_POST['responder'])) {
				include ('conexion.php');
				$file = $_FILES['comunicado'];
				$idPeticion = $_POST['idpeticion'];
				$dir_subida = '../files/resp/'.Date('Y').'/'.Date('m').'/';
				$hora = Date('his');
				$reemplazar = Responder::texto($file['name']);
				$filename = $this->filename;

				$archivo_subido = $dir_subida.$hora.basename($filename);
				if (!file_exists($dir_subida)) {
					mkdir($dir_subida,0777,true);
				}
				if (!file_exists($archivo_subido)) {
					if (move_uploaded_file($file['tmp_name'], $archivo_subido)) {
						
						//$respuesta = utf8_decode($_POST['respuesta']);
						$respuesta = filter_var($_POST['respuesta'],FILTER_SANITIZE_STRING);
						$responsable = $_SESSION['IdUsuario'];
						$fecha = Date('Y-m-d h:i:s');
						$estado = 3;

						$insertar = "INSERT INTO `historialrespuestas`(`numRadicado`, `Respuesta`, `FechaRespuesta`, `IdUsuarioAsignado`, `NombreArchivo`, `RutaArchivo`,`IdEstadoRespuesta`) VALUES ('$idPeticion','$respuesta','$fecha','$responsable','$filename','$archivo_subido','3')";

						$preparar = $conn->prepare($insertar);

						if ($preparar->execute()) {
							$idRespuesta = $conn->lastInsertId();
							$actualizar = "UPDATE peticiones SET IdEstadoPeticion='$estado', IdUsuarioAsignado = '$responsable', IdRespuesta='$idRespuesta' WHERE numRadicado = '$idPeticion'";
							$stmt = $conn->prepare($actualizar);

							if ($stmt->execute()) {

								Responder::notificacion();
								echo "<script>alert('Se guardó correctamente su respuesta.')</script>";
								echo "<script>window.location.replace('peticionesPendientes.php')</script>";
							}else{
								echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
								echo "<script>window.location.replace('Gestionar.php?Id=$idPeticion')</script>";
							}
						}else{
							echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
							echo "<script>window.location.replace('Gestionar.php?Id=$idPeticion')</script>";
						}
					}
				}else{
					echo "<script>alert('Error al guardar la información. Por favor vuelva a intentarlo')</script>";
					echo "<script>window.location.replace('Gestionar.php?Id=$idPeticion')</script>";
				}				

				$conn = null;
			}else{
				echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
				echo "<script>window.location.replace('Gestionar.php?Id=$idPeticion')</script>";
			}
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

			$this->filename = strtolower(preg_replace($exp_regular, $cadena_nueva, $cadena));

		}
		public function notificacion(){

			require("conexion.php");
			$idPeticion = $_POST['idpeticion'];
			$responsable = $_SESSION['IdUsuario'];

			$fecha = Date('Y-m-d h:i:s');

			$sentencia = "SELECT * FROM usuarios WHERE IdUsuario = '$responsable'";
			$resultado = $mysqli->query($sentencia);
			$fila = $resultado->fetch_assoc();

			$nombreResponsable = $fila['Nombres']." ".$fila['Apellidos'];
			$correoResponsable = $fila['Correo'];

			$smtpHost = "smtp.office365.com";  // Dominio alternativo brindado en el email de alta 
			$smtpUsuario = "info@cuentadealtocosto.org";  // Mi cuenta de correo
			$smtpClave = "jcvxrwvsldpmczhd";  // Mi contraseña
			$correo="gestioncalidad@cuentadealtocosto.org";
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
		$mail->AddAddress($correo); // Esta es la direcci�n a donde enviamos los datos del formulario

		$mail->Subject = "Nueva solicitud para aprobación"; // Este es el titulo del email.
		$mensajeHtml = nl2br($mensaje);


		$mail->Body = "
		<html>
		<body>
		<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
		<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
		<div style='padding: 0px 30px;'>
		<p>Hola Dirección.</p>
		<p>Se ha dado respuesta a la solicitud con número de radicado <b>{$idPeticion}</b></p>
		<p>Consúltala dando <a href='https://cuentadealtocosto.org/sgdcac/'>clic aquí</a></p>
		</div>
		<div style='padding: 0px 30px;'>
		<table style='width: 100%'>
		<tr>
		<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>RESPONSABLE:</td>
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
		<td>{$idPeticion}</td>
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

$resultado = new Responder();
$resultado->respuesta();
}

?>
