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

		if (isset($_POST['consulta'])) {

			include ('../pages/conexion.php');

			$radicado = $_POST['radicado'];
			$codigo = $_POST['codigo'];

			if ($radicado == "" || $codigo == "") {
				echo "<script>alert('Debe diligenciar el campo de Número de radicado y Código de verificación. Intentelo de nuevo.');</script>";
				echo "<script>window.location.replace('index.php')</script>";
			}else{

				$consulta = "SELECT * FROM peticiones WHERE numRadicado = '$radicado' AND clave = '$codigo'";

				$resultado = $mysqli->query($consulta);
				$fila = $resultado->fetch_assoc();
				$key = 'cu3nt4_d3_4lt0_c05t0';

				if (isset($fila['IdPeticion'])) {
					$id = $fila['IdPeticion'];
					$radicado = $fila['numRadicado'];
					$conc = md5($key.$radicado);
					echo "<script>window.location.replace('verSolicitud.php?Id=$conc')</script>";
				}else{
					echo "<script>alert('El número de radicado o el código de verificación no son correctos. Intentelo de nuevo.');</script>";
					echo "<script>window.location.replace('index.php')</script>";
				}
			}

		}else{
			echo "<script>alert('Ocurrio un error. Por favor intentelo de nuevo.')</script>";
			echo "<script>window.location.replace('index.php')</script>";
		}

	}else{
		echo "<script>alert('El sistema le ha identificado como un robot por lo cual no se puede proceder con el registro de su petición. Por favor inténtelo de nuevo.')</script>";
		echo "<script>window.location.replace('index.php')</script>";
	}
}else{
	echo "<script>alert('El sistema le ha identificado como un robot por lo cual no se puede proceder con el registro de su petición. Por favor inténtelo de nuevo.')</script>";
	echo "<script>window.location.replace('index.php')</script>";
}


?>