<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
	header ("Location: login/index.php");
}

class NuevoUSuario{

	public function guardar(){
		if ($_POST['registrar']) {
			
			include 'conexion.php';

			$nombres = $_POST['nombres'];
			$apellidos = $_POST['apellidos'];
			$identificacion = $_POST['identificacion'];
			$cargo = $_POST['cargo'];
			$coordinacion = $_POST['coordinacion'];
			$tipousuario = $_POST['usuario'];
			$correo = $_POST['correo'];
			$pass = $_POST['pass'];

			$insertar = "INSERT INTO `usuarios`(`IdEstado`, `Nombres`, `Apellidos`, `numIdent`, `Cargo`, `Correo`, `IdTipoUsuario`, `IdCoordinacion`, `Pass`,`intentos`) VALUES (1,'$nombres','$apellidos','$identificacion','$cargo','$correo','$tipousuario','$coordinacion','$pass','0')";
			$save = $conn->prepare($insertar);

			if ($save->execute()) {
				echo "<script>alert('Se guardó correctamente.')</script>";
				echo "<script>window.location.replace('usuarios.php')</script>";
			}else{
				echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
				echo "<script>window.location.replace('usuarios.php')</script>";
			}

			$conn = null;

		}else{
			echo "<script>alert('Algo salió mal, intentelo de nuevo.')</script>";
			echo "<script>window.location.replace('usuarios.php')</script>";
		}
	}
}
$resultado = new NuevoUSuario();
$resultado->guardar();


?>
