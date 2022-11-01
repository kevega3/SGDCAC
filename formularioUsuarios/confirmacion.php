<?php 

require("../pages/class.phpmailer.php");
require("../pages/class.smtp.php");

if(!isset($_GET["Id"])){
	exit();
} 
include ('../pages/conexion.php');
$radicado = $_GET['Id'];
$key = 'cu3nt4_d3_4lt0_c05t0';

$sentencia = "SELECT clave, numRadicado FROM peticiones WHERE MD5(concat('$key',numRadicado)) = '$radicado'";
$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();


?>
<!DOCTYPE html>
<html>
<head>
	<title>Radicado <?php echo $fila['numRadicado']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../styles/w3.css">
	<style type="text/css">
		#boton{
			color: #fff;
			border: none;
			border-radius: 3px;
			padding: 10px;
			margin-right: 20px;
			width: 25%;
			cursor: pointer;
		}
	</style>
</head>
<body style="background-color: #112797;">

	<div style="width: 80%;margin-left: auto;margin-right: auto;padding: 20px; background: #fff; border-radius: 3px;margin-top: 5%;">
		<img src="../images/logo_color.svg" style="width: 50%;margin-left: auto;margin-right: auto;display: list-item;">
		<br>
		<br>
		<center>Su solicitud ha sido registrada de forma exitosa con el radicado No. <b><?php echo $fila['numRadicado']; ?></b> con fecha <?php echo Date('Y-m-d'); ?>, hora <?php echo Date('h:i:s'); ?> y código de verificación <b><?php echo $fila['clave']; ?></b>. Por favor tenga en cuenta estos datos para que realice la consulta del estado a su solicitud a través de la página web de la Cuenta de Alto Costo. Puede consultarlo <a href="https://cuentadealtocosto.org/site/consultaweb/" target="_blank">aquí</a>.</center>
		<br>
		<center>Pulse continuar para terminar la solicitud y visualizar el documento en formato PDF. Si desea almacenelo en su disco o imprimirlo.</center>
		<br>
		<div class="w3-panel w3-pale-blue w3-border">
			<center>Muchas gracias, hemos recibido su solicitud, la misma será tramitada y en los próximos días podrá visualizar su estado.</center>
		</div>
		<br>
		<center><a href="descargarPeticion.php?Id=<?=md5($key.$fila['numRadicado'])?>" target="_blank"><button id="boton" style="background: #70c652;">Ver documento</button></a><a href="form.php"><button id="boton" style="background: red;">Cerrar</button></a></center>
	</div>
</body>
</html>
<?php 
class enviarResumen{

	public function notificar(){
		include ('../pages/conexion.php');
		$radicado = $_GET['Id'];
		$key = 'cu3nt4_d3_4lt0_c05t0';

		$sentencia = "SELECT * FROM peticiones WHERE MD5(concat('$key',numRadicado)) = '$radicado'";
		$resultado = $mysqli->query($sentencia);
		$fila = $resultado->fetch_assoc();
		$radicado = $fila['numRadicado'];
		$remitente = $fila['nombreRemitente'];
		$fechaRadicado = $fila['FechaCreacion'];
		$clave = $fila['clave'];
		$descargar = md5($key.$fila['numRadicado']);
		$correo = $fila['Correo'];

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
		$mail->AddAddress($correo); // Esta es la direcci�n a donde enviamos los datos del formulario

		$mail->Subject = "Radicado ".$radicado; // Este es el titulo del email.
		$mensajeHtml = nl2br($mensaje);


		$mail->Body = "
		<html>
		<body>
		<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
		<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
		<div style='padding: 0px 30px;'>
		<p>Hola {$remitente}.</p>
		<p>Su solicitud ha sido registrada de forma exitosa con el radicado No. <b>{$radicado}</b> con fecha y hora {$fechaRadicado} y código de verificación <b>{$clave}</b>. Por favor tenga en cuenta estos datos para que realice la consulta del estado a su solicitud a través de la página web de la <a href='https://cuentadealtocosto.org/site/consultaweb/'>Cuenta de Alto Costo</a>. Puede descargar el archivo de radicado dando <a href='https://cuentadealtocosto.org/sgdcac/formularioUsuarios/descargarPeticion.php?Id={$descargar}'>clic aquí</a></p>
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

$result = new enviarResumen();
$result->notificar();

?>
