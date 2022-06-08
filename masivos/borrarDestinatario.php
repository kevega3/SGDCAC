<?php 


class Borrar{

	public function borrarDestinatario(){
		$id = $_GET['Id'];
		$comunicado = $_GET['comunicado'];
		include '../pages/conexion.php';
		$sentencia = "DELETE FROM envios WHERE IdDestinatario='$id'";
		$out = $conn->prepare($sentencia);

		if ($out->execute()) {
			echo "<script>alert('Se eliminó correctamente.')</script>";
			echo "<script>window.location.replace('verCargados.php?Id=$comunicado')</script>";
		}else{
			echo "<script>alert('Error en la eliminación del registro.')</script>";
			echo "<script>window.location.replace('verCargados.php?Id=$comunicado')</script>";
		}
	}
}
$resultado = new Borrar();
$resultado->borrarDestinatario();
?>