<?php
include("keys.php");
header("Content-Type: text/html;charset=utf-8");
require("../pages/class.phpmailer.php");
require("../pages/class.smtp.php");

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

		
		class InsertarPeticion{

			var $radicado;

			
			public function insertarinfo(){

				include '../pages/conexion.php';

				$tipopeticion = 9;
				$date = Date('Y-m-d h:i:s');
				$tipopersona = $_POST['tipopersona'];
				$nombrepersona = $_POST['nombrepersona'];
				$apellidospersona = $_POST['apellidospersona'];

				if ($tipopersona == '1') {
					$razonsocial = '0';
					$tipoempresa = '24'; //El ID 24 en la tabla tipoempresa representa el valor "Ninguna"
				}else{
					$razonsocial = $_POST['razonsocial'];
					$tipoempresa = $_POST['tipoempresa'];
				}
				$correo = $_POST['correo'];
				$pais = $_POST['pais'];
				if ($pais == '42') {
					$departamento = $_POST['departamento'];
					$municipio = $_POST['municipio'];
				}else{
					$departamento = '100';// El ID 100 representa el valor N/A
					$municipio = '1124';//El ID 1124 representa el valor N/A
				}
				$direccion = $_POST['direccion'];
				$celular = $_POST['celular'];
				$fijo = $_POST['fijo'];
				$tipopoblacion = $_POST['tipopoblacion'];
				$tema = $_POST['tema'];
				$mensaje = $_POST['mensaje'];
				$asignar = 2; //El número 2 representa el ID del usuario del funcionario a cargo de recibir las solicitudes
				$x = 0;
				$y = 5;
				$Strings = '0123456789abcdefghijklmnopqrstuvwxyz';
				$clave = substr(str_shuffle($Strings), $x, $y);


				$mysqli ->query("INSERT INTO peticiones(clave,IdEstadoPeticion, FechaCreacion, IdTipoPeticion, IdTipoPersona, nombreRemitente, apellidosRemitente, razonSocial, idTipoEmpresa, IdPais, IdDepartamento, IdMunicipio, Direccion, Telefono, Movil, Correo, IdTipoPoblacion, temaPeticion, Mensaje, IdUsuarioAsignado) VALUES ('$clave','1','$date','$tipopeticion','$tipopersona','$nombrepersona','$apellidospersona', '$razonsocial', '$tipoempresa', '$pais', '$departamento', '$municipio', '$direccion', '$fijo', '$celular', '$correo', '$tipopoblacion', '$tema', '$mensaje','$asignar');");

				$id=$mysqli->insert_id;
				$this->radicado = "CR".Date('Ymd').$id;

				$mysqli ->query("UPDATE peticiones SET numRadicado = '$this->radicado' WHERE IdPeticion = '$id'");

				// Print auto-generated id
				//echo "El número de radicado es: ".$radicado;


				$cantidad = count($_FILES['archivo']['name']);

				if ($cantidad <=3) {

					foreach ($_FILES['archivo']['tmp_name'] as $key => $tmp_name) {
						
						$filename = $_FILES['archivo']['name'][$key];

						if ($_FILES['archivo']['error'][$key]>0) {
							echo "Error al cargar el archivo ".$filename;
							echo "<script>alert('Error al cargar el archivo ".$filename."')</script>";
							echo "<script>window.location.replace('index.php')</script>";
						}else{

							$permitidos = array("image/jpg","image/png","image/jpeg","application/pdf","image/svg");
							$limite_kb = 5000;

							if (in_array($_FILES['archivo']['type'][$key], $permitidos)) {

								if ($_FILES['archivo']['size'][$key] <= $limite_kb * 1024) {

									if ($_FILES['archivo']['name'][$key]) {
										
										$filename = $_FILES['archivo']['name'][$key];
										$temporal = $_FILES['archivo']['tmp_name'][$key];
										$type = $_FILES['archivo']['type'];

										$ano=Date('Y'); 
										$mes=Date('m');
										$dia=Date('d');

										$directorio = '../files/'.Date('Y').'/'.Date('m').'/';
										$archivo = $directorio.$filename;

										if (!file_exists($directorio)) {
											mkdir($directorio, 0777, true);
										}
										if (!file_exists($archivo)) {
											$resultado = @move_uploaded_file($temporal,$archivo);

											if ($resultado) {	
												$mysqli ->query("INSERT INTO historialarchivos(IdPeticion, numRadico, nombreArchivo, anoSubida, mesSubida, diaSubida, rutaArchivo) VALUES ('$id','$this->radicado','$filename','$ano','$mes','$dia','$archivo')");
												
											}else{
												echo "<script>alert('El archivo ".$filename." no se guardo.')</script>";
												echo "<script>window.location.replace('index.php')</script>";
											}

										}else{
											$archivo = $directorio."copy_".$filename;
											$resultado = @move_uploaded_file($temporal, $archivo);

											if ($resultado) {
												$mysqli ->query("INSERT INTO historialarchivos(IdPeticion, numRadico, nombreArchivo, anoSubida, mesSubida, diaSubida, rutaArchivo) VALUES ('$id','$this->radicado','$filename','$ano','$mes','$dia','$archivo')");
											}else{

												echo "<script>alert('El archivo ".$filename." no se guardo.')</script>";
												echo "<script>window.location.replace('index.php')</script>";
											}
										}
									}

								}else{

									echo "<script>alert('El archivo ".$filename." supera la capacidad maxima permitida de peso por archivo.')</script>";
									echo "<script>window.location.replace('index.php')</script>";
								}
								
							}else{
								echo "<script>alert('El archivo ".$filename." no tiene una extensión permitida.')</script>";
								echo "<script>window.location.replace('index.php')</script>";
							}

						}
					}
				}else{
					echo "<script>alert('No se permite la subida de más de 3 archivos.')</script>";
					echo "<script>window.location.replace('index.php')</script>";
				}
				//include ('confirmacion.php');
				$key = 'cu3nt4_d3_4lt0_c05t0';
				$conc = md5($key.$this->radicado);
				//echo "<script>window.location.replace('confirmacion.php?Id=$conc')</script>";
				$mysqli -> close();

			}
			// FINAL PRIMERA FUNCION

			public function notificar(){

				$nombrepersona = $_POST['nombrepersona'];
				$apellidospersona = $_POST['apellidospersona'];
				$nombrecompleto = $nombrepersona." ".$apellidospersona;
				$correopersona = $_POST['correo'];
				$fecha = Date('Y-m-d h:i:s');
				$tema = $_POST['tema'];
				$numRadicado = $this->radicado;


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
				$mail->AddAddress($correo); // Esta es la direcci�n a donde enviamos los datos del formulario

				$mail->Subject = "Nueva solicitud registrada"; // Este es el titulo del email.
				$mensajeHtml = nl2br($mensaje);


				$mail->Body = "
				<html>
				<body>
				<div style='width: fit-content; border: 1px solid lightgrey; border-radius: 3px;'>
				<div style='background-image: url(https://cuentadealtocosto.org/site/wp-content/uploads/2022/02/bannercorrespondencia.jpg);background-size: auto;background-repeat: no-repeat;height: 150px;'></div>
				<div style='padding: 0px 30px;'>
				<p>Hola Admin.</p>
				<p>Se ha registrado una nueva solicitud en el sistema de correspondencia de la Cuenta de Alto Costo</p>
				<p>Consúltala dando <a href='http://192.168.1.11:81/sgdcac/'>clic aquí</a></p>
				</div>
				<div style='padding: 0px 30px;'>
				<table style='width: 100%'>
				<tr>
				<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>REMITENTE:</td>
				<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>CORREO</td>
				</tr>
				<tr>
				<td>{$nombrecompleto}</td>
				<td>{$correopersona}</td>
				</tr>
				<tr>
				<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>FECHA RADICADO</td>
				<td style='color: #17318e;font-size: 12px;font-weight: bolder;padding: 10px 0px;'>No. RADICADO</td>
				</tr>
				<tr>
				<td>{$fecha}</td>
				<td>{$numRadicado}</td>
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

		$resultado = new InsertarPeticion();
		$resultado->insertarinfo();
		//$resultado->notificar();

	}else{
		echo "<script>alert('El sistema le ha identificado como un robot. Por favor intentelo de nuevo.')</script>";
		echo "<script>window.location.replace('index.php')</script>";
	}
}else{
	echo "<script>alert('El sistema le ha identificado como un robot por lo cual no se puede proceder con el registro de su petición. Por favor inténtelo de nuevo.')</script>";
	echo "<script>window.location.replace('index.php')</script>";
}

?>