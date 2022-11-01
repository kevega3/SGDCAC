<?php

class Archivos{

	private $archivos;

	public function setArchivo($archivo){
		$this->archivos = $archivo;

		foreach ($this->archivos['tmp_name'] as $key => $tmp_name) {
			echo $this->archivos['name'][$key];

		}
	}

	public function mostrar(){

		echo "Nada";
	}
}

$test = new Archivos();



if ( $_FILES['archivo']['name']['0'] == '') {
	$test->mostrar();
	
	
}else{

	$test->setArchivo($_FILES['archivo']);
}


?>