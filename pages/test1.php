<?php



class Buscar{

	public function buscarDato(){
		include ('conexion.php');

		$radicado = $_POST["documento"];

		$consulta = "SELECT * FROM peticiones WHERE numRadicado = '$radicado'";
		$resultado = $mysqli->query($consulta);

		if ($resultado->num_rows > 0) {
			echo "1";
		}else{
			echo "2";
		}
	}
}
$test = new Buscar();
$test->buscarDato();
?>