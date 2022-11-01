<?php 


class Borrar{

	public function borrarDestinatario(){

		include '../pages/conexion.php';
		$comunicado =  $_GET['comunicado'];

		if (isset($_GET['Id'])) {

			$id = $_GET['Id'];
			
			$sentencia = "DELETE FROM envios WHERE IdDestinatario='$id'";
			$out = $conn->prepare($sentencia);

			if ($out->execute()) {
				echo "<script>alert('Se eliminó correctamente.')</script>";
				echo "<script>window.location.replace('verCargados.php?Id=$comunicado')</script>";
			}else{
				echo "<script>alert('Error en la eliminación del registro.')</script>";
				echo "<script>window.location.replace('verCargados.php?Id=$comunicado')</script>";
			}		

		}else{

			$sentencia = "DELETE FROM envios WHERE IdComunicado = '$comunicado'";
			$out = $conn->prepare($sentencia);

			if ($out->execute()) {
				echo "<script>alert('Se eliminaron correctamente.')</script>";
				echo "<script>window.location.replace('verCargados.php?Id=$comunicado')</script>";
			}else{
				echo "<script>alert('Error en la eliminación de los registros.')</script>";
				echo "<script>window.location.replace('verCargados.php?Id=$comunicado')</script>";
			}

		}
	}
}
$resultado = new Borrar();
$resultado->borrarDestinatario();
?>