<?php
date_default_timezone_set('America/Bogota');

class Prueba{
	
	public function ver(){
echo Date('Y-m-d h:i:s');
}
}
$test = new Prueba();
$test->ver();
?>
