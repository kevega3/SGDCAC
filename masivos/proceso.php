<?php
include '../pages/conexion.php';

foreach($_POST as $rownumber_name => $val) {

//remember to clean post values
	$rownumber = $rownumber_name;
	$val = trim(str_replace("\r","",$val));

        //from the fieldname:rownumber_id we need to get rownumber_id
	$split_data = explode(':', $rownumber);
	$rownumber_id = $split_data[1];
	$rownumber_name = $split_data[0];

	$sql_1 = "UPDATE envios SET $rownumber_name = '$val' WHERE IdDestinatario = $rownumber_id";
	if ($mysqli->query($sql_1)) {
		$last_id = $mysqli->insert_id;
//echo $sql_1;
		echo "Actualizando registro: <img src='images/loader.gif' height='15px'>";
	} else {
		printf("Errormessage: %s\n", $mysqli->error);
	}

}
?>