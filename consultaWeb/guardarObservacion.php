<?php 
include ("../formularioUsuarios/keys.php");

if ($_POST['google-response-token']) {

	$googleToken = $_POST['google-response-token'];

	$arrContextOptions=array(
		"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	); 

	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$googleToken}", false, stream_context_create($arrContextOptions));
	$response = json_decode($response);

	$response = (array) $response;

	if ($response['success'] && $response['score'] > 0.5) {

		header("Content-Type: text/html;charset=utf-8");
		require("../pages/class.phpmailer.php");
		require("../pages/class.smtp.php");

		class Observacion{

			public function guardarObservacion(){

				if (isset($_POST['enviar'])) {

					include ('../pages/conexion.php');

					$radicado = $_POST['radicado'];
					$fecha = Date('Y-m-d h:i:s');
					$observaciones = $_POST['observaciones'];
					$estado = 1;
					$key = 'cu3nt4_d3_4lt0_c05t0';
					$conc = md5($key.$radicado);

					$sentencia = "INSERT INTO `observaciones`(`IdEstado`, `observacion`, `fechaRegistro`, `numRadicado`) VALUES ('$estado','$observaciones','$fecha','$radicado')";
					$stmt = $conn->prepare($sentencia);

					if ($stmt->execute()) {
						echo "<script>alert('Se registró su observación.')</script>";
						echo "<script>window.location.replace('verSolicitud.php?Id=$conc')</script>";
					}else{				
						echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
						echo "<script>window.location.replace('observaciones.php?Id=$conc')</script>";
					}
				}
				else{
					echo "<script>alert('Ocurrio un error. Por favor intentelo de nuevo.')</script>";
					echo "<script>window.location.replace('index.php')</script>";
				}

			}

			public function notificacion(){
				require ("../pages/conexion.php");
				$radicado = $_POST['radicado'];
				$fecha = Date('Y-m-d h:i:s');
				$observaciones = $_POST['observaciones'];

				$sentencia = "SELECT *, P.Correo AS CorreoR ,U.Nombres AS NombreResp, U.Correo AS CorreoResponsable 
				FROM peticiones P 
				INNER JOIN usuarios U ON U.IdUsuario = P.IdUsuarioAsignado 
				WHERE numRadicado = '$radicado'";
				$resultado = $mysqli->query($sentencia);
				$fila = $resultado->fetch_assoc();

				$correoResponsable = $fila['CorreoResponsable'];
				$nombreResponsable = $fila['NombreResp'];
				$nombreRemitente = $fila['nombreRemitente']." ".$fila['apellidosRemitente'];
				$correoRemitente = $fila['CorreoR'];

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
				$mensaje = "Mensaje de la CAC";

				$mail->From = "info@cuentadealtocosto.org"; 
				$mail->AddAddress($correoResponsable); 

				$mail->Subject = "Observación radicado ".$radicado; 
				$mensajeHtml = nl2br($mensaje);


				$mail->Body = "
				<html>
				<body>
				<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
				<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
				<div style='padding: 0px 30px;'>
				<p>Hola {$nombreResponsable}.</p>
				<p>Se ha registrado una observación en la respuesta de la solicitud con radicado <b>{$radicado}</b></p>
				<p>Consúltala dando <a href='http://192.168.1.11:81/sgdcac/'>clic aquí</a></p>
				</div>
				<div style='padding: 0px 30px;'>
				<table style='width: 100%'>
				<tr>
				<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>REMITENTE:</td>
				<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>CORREO</td>
				</tr>
				<tr>
				<td>{$nombreRemitente}</td>
				<td>{$correoRemitente}</td>
				</tr>
				<tr>
				<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>FECHA DE OBSERVACIÓN</td>
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
				<td>{$observaciones}</td>
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

		$objObservacion = new Observacion();
		$objObservacion->guardarObservacion();
		$objObservacion->notificacion();

	}else{
		echo "<script>alert('El sistema le ha identificado como un robot por lo cual no se puede proceder con el registro de su petición. Por favor inténtelo de nuevo.')</script>";
		echo "<script>window.location.replace('index.php')</script>";
	}
}else{
	echo "<script>alert('El sistema le ha identificado como un robot por lo cual no se puede proceder con el registro de su petición. Por favor inténtelo de nuevo.')</script>";
	echo "<script>window.location.replace('index.php')</script>";
}



?>