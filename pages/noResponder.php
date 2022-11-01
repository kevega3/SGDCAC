<?php 
date_default_timezone_set('America/Bogota'); 
class Respuesta{

	private $id;
	private $motivo;

	public function set_datos($id,$motivo){
		$this->id = $id;
		$this->motivo = $motivo;
	}

	public function denegar(){
		include 'conexion.php';
		$fecha = Date('Y-m-d h:i:s');
		$instancia = Respuesta::set_datos($_POST['idpeticion'],$_POST['motivo']);
		$insertar = "INSERT INTO rechazos (IdPeticion,Motivo, Fecha) VALUES ('$this->id','$this->motivo','$fecha');";
		$procesar = $conn->prepare($insertar);

		if ($procesar->execute()) {
			$mysqli->query("UPDATE peticiones SET IdEstadoPeticion = '5' WHERE IdPeticion = '$this->id'");
			echo "<script>alert('Se cambió el estado de la solicitud.')</script>";
			echo "<script>window.location.replace('peticionesPendientes.php')</script>";
		}else{
			echo "<script>alert('Error al rechazar petición. Vuelva a intentarlo.')</script>";
			echo "<script>window.location.replace('Gestionar.php?Id=$id')</script>";
		}

	}
}
$result = new Respuesta();
$result->denegar();
?>
