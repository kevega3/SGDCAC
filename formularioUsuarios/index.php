<?php
date_default_timezone_set("America/Bogota");
$dias = array("do","lu","ma","mi","ju","vi","sa");

$do=1; // Sin acceso
$lu=1; // Dia permitido
$ma=1; // Dia permitido
$mi=1; // Dia permitido
$ju=1; // Dia permitido
$vi=1; // Dia permitido
$sa=0; // Dia permitido
$HoraActual = (int)date("G"); // La hora actual del País
$inicio= 7; # Desde las ocho de la mañana.
$fin= 18; # Hasta las 16 horas de la tarde.

$hoy=$dias[date("w")]; // Mostramos dia actual

$HoraActual = intval(date("H"));// Hora actual del Pais de residencia.
if ($HoraActual >= $inicio && $HoraActual < $fin) {
    # Aquí mostrara el acceso permitido al sistema
	if(($hoy=="do") && ($do==0)){
		include('disponibilidad.php');
	}

	elseif(($hoy=="sa") && ($sa==0)){
		include('disponibilidad.php');
	}
	else{
		include('form.php');
	}

} else {
    # Mostrar mensaje de sistema bloqueado, etc.
	include('disponibilidad.php');
}

?>
