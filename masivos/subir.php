<?php 

class Subida{

	function subirDatos(){

		$id = $_POST['id'];
		include ('../pages/conexion.php');

		if (isset($_POST['subir'])) {
			$filename=$_FILES['archivo']['name'];
			$info = new SplFileInfo($filename);
			$extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);

			if ($extension== 'csv') {
				
				$filename = $_FILES['archivo']['tmp_name'];
				$handle = fopen($filename, 'r');
				fgetcsv($handle, 1000,";");

				$numero = 1;
				$fila = 1;
				$error = 0;
				while (($data = fgetcsv($handle, 1000,";")) !== FALSE) {

					$numero++;

					$nom = utf8_encode(preg_replace('/[" "]+/', '', $data[0]));
					$ape = utf8_encode(preg_replace('/[" "]+/', '', $data[1]));
					$car = utf8_encode(preg_replace('/[" "]+/', '', $data[2]));
					$tr1 = utf8_encode(preg_replace('/[" "]+/', '', $data[3]));
					$tr2 = utf8_encode(preg_replace('/[" "]+/', '', $data[4]));
					$ent = utf8_encode(preg_replace('/[" "]+/', '', $data[5]));
					$reg = preg_replace('/[" "]+/', '', $data[6]);
						if($reg==""){
							$reg="";
						}else{
							$reg = ' - '.$reg;
						}
					$correo = preg_replace('/[" "]+/', '', $data[7]);

					$subida = "INSERT INTO `envios`(`IdComunicado`, `nombres`, `apellidos`, `cargo`,`trato1`,`trato2`, `entidad`,`regimen`, `correo`, `estadoEnvio`) VALUES ('$id','$nom','$ape','$car','$tr1','$tr2','$ent','$reg','$correo','0');";


					$guardar = $conn->prepare($subida);

					if ($guardar->execute()) {
						$fila++;

					}else{
						$error++;
					}
				}
				if ($numero == $fila) {
					$total = $fila - 1;
					echo "<script>alert('$total destinatarios cargados con éxito.')</script>";
					echo "<script>window.location.replace('verCargados.php?Id=$id')</script>";
				}else{
					echo "<script>alert('$error destinatarios con errores, por favor revise la lista y cargue los destinatarios que hacen falta.')</script>";
					echo "<script>window.location.replace('verCargados.php?Id=$id')</script>";
				}
			}else{
				echo "<script>alert('Debe cargar un archivo con extensión .csv, por favor descargue la plantilla.')</script>";
				echo "<script>window.location.replace('destinatarios.php?Id=$id')</script>";
			}
			
			fclose($handle);
		}elseif ($_POST['ind']) {
			
			$nombres = $_POST['nombre'];
			$apellidos = $_POST['apellidos'];
			$cargo = $_POST['cargo'];
			$entidad = $_POST['entidad'];
			$correo = $_POST['correo'];
			$regimen = $_POST['regimen'];
				if($regimen==""){
					$regimen="";
				}else{
					$regimen = ' - '.$regimen;
				}
			$trato1 = $_POST['trato1'];
			$trato2 = $_POST['trato2'];

			$subida = "INSERT INTO `envios`(`IdComunicado`, `nombres`, `apellidos`, `cargo`, `entidad`, `correo`,`trato1`, `trato2`, `regimen`, `estadoEnvio`) VALUES ('$id','$nombres','$apellidos','$cargo','$entidad','$correo','$trato1','$trato2','$regimen','0');";
			$guardar = $conn->prepare($subida);

			if ($guardar->execute()) {
				echo "<script>alert('Destinatario cargado con éxito.')</script>";
				echo "<script>window.location.replace('verCargados.php?Id=$id')</script>";

			}else{
				$error++;
			}
		}
		else{
			echo "<script>alert('Error en la subida del archivo, Por favor vuelva a intentarlo.')</script>";
			echo "<script>window.location.replace('destinatarios.php?Id=$id')</script>";
		}
	}
}
$resultado = new Subida();
$resultado->subirDatos();

?>
