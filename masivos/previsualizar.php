<?php

require_once __DIR__ . '/vendor/autoload.php';


Class PDF extends \Mpdf\Mpdf{

	private $fecha;

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}
	public function convertirFecha(){
		date_default_timezone_set('America/Bogota');
		setlocale(LC_TIME, 'es_ES.UTF-8');
		setlocale(LC_TIME, 'Spanish');

		$fecha = $this->fecha;
		$newDate = date("d-m-Y", strtotime($fecha));        
		$mesDesc = strftime("%d de %B de %Y", strtotime($newDate));

		return $mesDesc;
	}
}


?>