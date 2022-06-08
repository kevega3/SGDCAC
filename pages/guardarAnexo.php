<?php 


class Guardar{

	public function guardarAnexo(){

		include 'conexion.php';

		$anexos = $_POST['anexo'];
		$radicado = $_POST['radicado'];
		$estado = 0;
		$contador=0;
		foreach ($anexos as $anexo) {
			$estado = $estado +1 ;
		}

		foreach ($anexos as $anexo) {
			$fecha = Date('Y-m-d h:i:s');
			$insertar = "INSERT INTO anexos(numRadicado, anexadoA, fechaAnexo) VALUES ('$radicado','$anexo','$fecha');";
			$guardar = $conn->prepare($insertar);

			if ($guardar->execute()) {
				$contador=$contador+1;
			}else{
				echo "Error en anexo: ".$anexo;
			}
		}
		if ($estado == $contador) {
			$id = $_POST['id'];
			echo "<script>alert('Se anexó correctamente.')</script>";
			echo "<script>window.location.replace('Gestionar.php?Id=$id')</script>";
		}
	}
}

$result = new Guardar();
$result->guardarAnexo();
?>