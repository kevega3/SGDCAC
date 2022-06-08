<?php 
class Consecutivo{

	private $numero;
	private $destinatario;
	private $institucion;
	private $tema;
	private $fecha;
	private $tipo_comunicado;
	private $responsable;
	private $quien_elabora;
	private $reviso;

	public function buscarUltimo(){
		include 'conexion.php';

		$buscar = "SELECT MAX(IdConsecutivo) AS Id FROM consecutivos";
		$resultado = $mysqli->query($buscar);
		$fila = $resultado->fetch_assoc();

		$cont = $fila['Id']+1;
		$nuevo = 'CAC'.$cont;
		echo $nuevo;

	}
	public function setDatos($numero,$destinatario,$institucion,$tema,$fecha,$tipo_comunicado,$responsable,$quien_elabora,$reviso){

		$this->numero = $numero;
		$this->destinatario = $destinatario;
		$this->institucion = $institucion;
		$this->tema = $tema;
		$this->fecha = $fecha;
		$this->tipo_comunicado = $tipo_comunicado;
		$this->responsable = $responsable;
		$this->quien_elabora = $quien_elabora;
		$this->reviso = $reviso;

		$insertar = Consecutivo::usar();
	}

	public function usar(){
		include ('conexion.php');
		$sql = "INSERT INTO `consecutivos`(`numero`, `destinatario`, `institucion`, `tema`, `fecha`, `id_tipo_comunicado`, `responsable`, `quien_elabora`, `reviso`) VALUES ('$this->numero','$this->destinatario','$this->institucion','$this->tema','$this->fecha','$this->tipo_comunicado','$this->responsable','$this->quien_elabora','$this->reviso')";

		$preparar = $conn->prepare($sql);

		if ($preparar->execute()) {
			echo "<script>alert('El consecutivo $this->numero fue apartado.')</script>";
			echo "<script>window.location.replace('consecutivos.php')</script>";
		}else{
			echo "<script>alert('Ocurrió un error al apartar el consecutivo.')</script>";
			echo "<script>window.location.replace('consecutivos.php')</script>";
		}
	}
}

if (isset($_POST['enviar'])) {
	$gestionar = new Consecutivo();
	$gestionar->setDatos($_POST['consecutivo'],$_POST['destinatario'],$_POST['inst'],$_POST['tema'],$_POST['fecha'],$_POST['tipo_comunicado'],$_POST['responsable'],$_POST['quien_elabora'],$_POST['reviso']);
}
?>