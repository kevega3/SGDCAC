<?php

if (isset($_FILES['prueba'])) {

	foreach ($_FILES['prueba']['tmp_name'] as $key => $tmp_name) {

		$file_name = $_FILES['prueba']['name'][$key];

		echo $file_name."<br>";

	}
}

?>