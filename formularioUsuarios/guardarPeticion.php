<?php 

include("keys.php");
header("Content-Type: text/html;charset=utf-8");
require("../pages/class.phpmailer.php");
require("../pages/class.smtp.php");

class Peticion{

	private $tipopersona;
	private $nombrepersona;
	private $apellidospersona;
	private $razonsocial;
	private $tipoempresa;
	private $correo;
	private $pais;
	private $departamento;
	private $municipio;
	private $direccion;
	private $celular;
	private $fijo;
	private $tipopoblacion;
	private $tema;
	private $mensaje;
	private $radicado;
	private $archivos;
	private $id;

	public function set_datos($tipopersona,$nombrepersona,$apellidospersona,$correo,$pais,$direccion,$celular,$fijo,$tipopoblacion,$tema,$mensaje){
		$this->tipopersona = filter_var($tipopersona,FILTER_SANITIZE_STRING);
		$this->nombrepersona = filter_var($nombrepersona,FILTER_SANITIZE_STRING);
		$this->apellidospersona = filter_var($apellidospersona,FILTER_SANITIZE_STRING);
		$this->correo = filter_var($correo,FILTER_SANITIZE_STRING);
		$this->pais = filter_var($pais,FILTER_SANITIZE_STRING);
		$this->direccion = filter_var($direccion,FILTER_SANITIZE_STRING);
		$this->celular = filter_var($celular,FILTER_SANITIZE_STRING);
		$this->fijo = filter_var($fijo,FILTER_SANITIZE_STRING);
		$this->tipopoblacion = filter_var($tipopoblacion,FILTER_SANITIZE_STRING);
		$this->tema = filter_var($tema,FILTER_SANITIZE_STRING);
		$this->mensaje = filter_var($mensaje,FILTER_SANITIZE_STRING);
	}
	public function validarCaptcha(){

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
				
				$insertar = Peticion::set_datos($_POST['tipopersona'],$_POST['nombrepersona'],$_POST['apellidospersona'],$_POST['correo'],$_POST['pais'],$_POST['direccion'],$_POST['celular'],$_POST['fijo'],$_POST['tipopoblacion'],$_POST['tema'],$_POST['mensaje']);
				$insertar = Peticion::insertarDatos();
				

			}else{
				echo "<script>alert('El sistema le ha identificado como un robot. Por favor intentelo de nuevo.')</script>";
				echo "<script>window.location.replace('index.php')</script>";
			}
		}
		else{
			echo "<script>alert('El sistema le ha identificado como un robot por lo cual no se puede proceder con el registro de su petición. Por favor inténtelo de nuevo.')</script>";
			echo "<script>window.location.replace('index.php')</script>";
		}
	}

	public function insertarDatos(){

		include '../pages/conexion.php';

		if ($this->tipopersona == '1') {
			$this->razonsocial = '0';
			$this->tipoempresa = '24'; //El ID 24 en la tabla tipoempresa representa el valor "Ninguna"
		}else{
			$this->razonsocial = $_POST['razonsocial'];
			$this->tipoempresa = $_POST['tipoempresa'];
		}

		if ($this->pais == '42') {
			$this->departamento = $_POST['departamento']; // El ID 100 representa el valor N/A
			$this->municipio = $_POST['municipio']; //El ID 1124 representa el valor N/A
		}else{
			$this->departamento = '100'; // El ID 100 representa el valor N/A
			$this->municipio = '1124';
		}

		$date = Date('Y-m-d h:i:s');
		$x=0;
		$y=5;
		$Strings = '0123456789abcdefghijklmnopqrstuvwxyz';
		$clave = substr(str_shuffle($Strings), $x, $y);

		$insertar = "INSERT INTO peticiones(clave,IdEstadoPeticion, FechaCreacion, IdTipoPeticion, IdTipoPersona, nombreRemitente, apellidosRemitente, razonSocial, idTipoEmpresa, IdPais, IdDepartamento, IdMunicipio, Direccion, Telefono, Movil, Correo, IdTipoPoblacion, temaPeticion, Mensaje, IdUsuarioAsignado) VALUES ('$clave','1','$date','9','$this->tipopersona','$this->nombrepersona','$this->apellidospersona', '$this->razonsocial', '$this->tipoempresa', '$this->pais', '$this->departamento', '$this->municipio', '$this->direccion', '$this->fijo', '$this->celular', '$this->correo', '$this->tipopoblacion', '$this->tema', '$this->mensaje','2');";
		$resp = $conn->prepare($insertar);

		if ($resp->execute()) {
			
			$this->id= $conn->lastInsertId();
			$this->radicado = "CR".Date('Ymd').$this->id;
			$mysqli ->query("UPDATE peticiones SET numRadicado = '$this->radicado' WHERE IdPeticion = '$this->id'");

			$insertar = Peticion::set_archivos($_FILES['archivo']);
			$insertar = Peticion::subir_archivos();
		}
		else{
			echo "<script>alert('Error al guardar la información. Por favor vuelva a intentarlo')</script>";
			echo "<script>window.location.replace('index.php')</script>";
		}
	}

	public function set_archivos($archivos){
		$this->archivos = $archivos;
	}

	public function subir_archivos(){
		include '../pages/conexion.php';

		$cantidad = count($this->archivos['tmp_name']);
		

		if ($cantidad <=3) {
			$contador = 0;

			foreach ($this->archivos['tmp_name'] as $key => $tmp_name) {
				
				$filename = $this->archivos['name'][$key];

				if ($this->archivos['error'][$key]>0) {
					
					echo "<script>alert('Error al cargar el archivo ".$filename."')</script>";
					echo "<script>window.location.replace('index.php')</script>";
				}else{

					$permitidos = array("image/jpg","image/png","image/jpeg","application/pdf","image/svg");
					$limite_kb = 5000;

					if (in_array($this->archivos['type'][$key], $permitidos)) {

						if ($this->archivos['size'][$key] <= $limite_kb * 1024) {

							$filename = $this->archivos['name'][$key];
							$temporal = $this->archivos['tmp_name'][$key];
							$type = $this->archivos['type'];

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
									$contador = $contador + 1;
									$mysqli ->query("INSERT INTO historialarchivos(IdPeticion, numRadico, nombreArchivo, anoSubida, mesSubida, diaSubida, rutaArchivo) VALUES ('$this->id','$this->radicado','$filename','$ano','$mes','$dia','$archivo')");

								}else{
									$mysqli->query("DELETE FROM historialarchivos WHERE IdPeticion='$this->id'");
									$mysqli->query("DELETE FROM peticiones WHERE IdPeticion = '$this->id'");
									echo "<script>alert('El archivo ".$filename." no se guardó. Por favor vuelva a intentarlo.')</script>";
									echo "<script>window.location.replace('index.php')</script>";
								}

							}else{
								$archivo = $directorio.Date('Ymdhis').$filename;
								$resultado = @move_uploaded_file($temporal, $archivo);

								if ($resultado) {
									$contador = $contador + 1;
									$mysqli ->query("INSERT INTO historialarchivos(IdPeticion, numRadico, nombreArchivo, anoSubida, mesSubida, diaSubida, rutaArchivo) VALUES ('$this->id','$this->radicado','$filename','$ano','$mes','$dia','$archivo')");
								}else{

									$mysqli->query("DELETE FROM historialarchivos WHERE IdPeticion='$this->id'");
									$mysqli->query("DELETE FROM peticiones WHERE IdPeticion = '$this->id'");
									echo "<script>alert('El archivo ".$filename." no se guardó. Por favor vuelva a intentarlo.')</script>";
									echo "<script>window.location.replace('index.php')</script>";
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
		}

		if ($cantidad == $contador) {
			$enviar = Peticion::notificar();
			$key = 'cu3nt4_d3_4lt0_c05t0';
			$conc = md5($key.$this->radicado);
			echo "<script>window.location.replace('confirmacion.php?Id=$conc')</script>";
		}

	}

	public function notificar(){

		$nombrepersona = $this->nombrepersona;
		$apellidospersona = $this->apellidospersona;
		$nombrecompleto = $nombrepersona." ".$apellidospersona;
		$correopersona = $this->correo;
		$fecha = Date('Y-m-d h:i:s');
		$tema = $this->tema;
		$numRadicado = $this->radicado;

		$smtpHost = "smtp.office365.com";  
		$smtpUsuario = "info@cuentadealtocosto.org";  
		$smtpClave = "jcvxrwvsldpmczhd";  
		$correo="administrativa@cuentadealtocosto.org";
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

$respuesta = new Peticion();
$respuesta->validarCaptcha();
?>