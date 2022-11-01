<?php 

if (isset($_POST['Acceder'])) {
	include ('../pages/conexion.php');
	session_start();
	$usuario = $_POST['username'];
	$contrasena = $_POST['pass'];

	if ($usuario == "" || $contrasena == null) {
		echo "<script>alert('Error: usuario y/o contrseña incorrectos!');</script>";
		echo "<script>window.location.replace('index.php')</script>";
	}else{
		$sql = "SELECT * FROM usuarios WHERE Correo = '$usuario' AND Pass = '$contrasena' AND IdEstado = 1";

		if (!$consulta = $mysqli->query($sql)) {
			echo "Error al ejecutar la consulta.";
		}else{
			$filas = mysqli_num_rows($consulta);

			if ($filas == 0) {

				$upd = "UPDATE usuarios SET intentos = intentos + 1 WHERE Correo = '$usuario'";

				if ($mysqli->query($upd) === TRUE) {
					echo "<script>alert('Error: usuario y/o contraseña incorrectos.');</script>";
					echo "<script>window.location.replace('index.php');</script>";
				}else{
					echo "<script>alert('Error: usuario y/o contraseña incorrectos.');</script>";
					echo "<script>window.location.replace('index.php');</script>";
				}
				
			}else{

				while ($row = mysqli_fetch_array($consulta)) {

					$intentos = $row['intentos'];

					if ($intentos >= 5) {
						echo "<script>alert('Su usuario ha sido bloqueado por multiples intentos de acceso fallidos. Por favor comuniquese con el administrador.');</script>";
						echo "<script>window.location.replace('index.php');</script>";
					}else{
						$_SESSION['IdUsuario'] = $row['IdUsuario'];
						$_SESSION['usuario'] = $row['Correo'];
						$_SESSION['estado'] = $row['IdEstado'];
						$_SESSION['nombre'] = $row['Nombres'];
						$_SESSION['apellido'] = $row['Apellidos'];
						$_SESSION['coord'] = $row['IdCoordinacion'];
						$_SESSION['tipoUsuario']=$row['IdTipoUsuario'];
						$reiniciar = "UPDATE usuarios SET intentos = 0 WHERE Correo = '$usuario'";
						$eject = $mysqli->query($reiniciar);
						header("Location: ../index.php");
					}
				}
				
			}
		}
	}

}else{
	echo "Ocurrio un error.";
}


?>