<?php 

session_start();
date_default_timezone_set('America/Bogota'); 

if (!isset($_SESSION['usuario'])) {
	header ("Location: ../login/index.php");
}

class Comunicado{

	public function guardar(){
		if ($_POST['crear']) {
			
			include ('../pages/conexion.php');

			$nombre = $_POST['nombre'];
			$consecutivo = $_POST['consecutivo'];
			$fechaconsecutivo = $_POST['fecha'];
			$asunto = $_POST['asunto'];
			$fechacreacion = Date('Y-m-d h:i:s');
			$cuenta = $_POST['cuenta'];

			$insertar = "INSERT INTO `comunicados`(`Nombre`, `Numero`, `Fecha`, `Asunto`,`FechaCreacion`,`IdCuenta`) VALUES ('$nombre','$consecutivo','$fechaconsecutivo','$asunto','$fechacreacion',$cuenta)";
			$save = $conn->prepare($insertar);


			if ($save->execute()) {
				$idsolicutud = $conn->lastInsertId();

				$usuario = $_SESSION['usuario'];
				$nuevoconc = "INSERT INTO `consecutivos`( `numero`, `destinatario`, `institucion`, `tema`, `fecha`, `id_tipo_comunicado`, `responsable`, `quien_elabora`, `reviso`) VALUES ('$consecutivo','Masivo','Masivo','$asunto','$fechacreacion','1','$usuario','$usuario','Sistema de correspondencia')";
				$almacenar = $conn->prepare($nuevoconc);

				if ($almacenar->execute()) {
					echo "<script>alert('Se guardó correctamente.')</script>";
					echo "<script>window.location.replace('comunicado.php?Id=$idsolicutud')</script>";
				}else{
					echo "<script>alert('Ocurrió un error al separar el consecutivo.<')</script>";
					echo "<script>window.location.replace('index.php')</script>";
				}
			}else{
				echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
				echo "<script>window.location.replace('index.php')</script>";
			}

			$conn = null;
		}
		else{
			echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
			echo "<script>window.location.replace('index.php')</script>";
		}
	}
}

$resultado = new Comunicado();
$resultado->guardar();

?>
