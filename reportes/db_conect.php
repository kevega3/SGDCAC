<?php

function ConexionBD(){
	
    $base_datos = "sgdcac";
    $usuario = "root";
    $password = "cac2020$*-+";

    try {

        $conn = new PDO('mysql:host=localhost;dbname=' . $base_datos, $usuario, $password);
        $conn->query("set names utf8;");
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $conn;
    } catch (Exception $e) {
        exit("Error obteniendo BD: " . $e->getMessage());
        return null;
    }
}
?>