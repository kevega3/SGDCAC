<?php
if (!isset($_GET['Id'])) {
	header ("Location: index.php");
}

$id = $_GET["Id"];
$key = 'cu3nt4_d3_4lt0_c05t0';
include ('../pages/conexion.php');

$sentencia = "SELECT * FROM historialarchivos WHERE MD5(concat('$key',numRadico)) = '$id'";
$resultado = $mysqli->query($sentencia);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Archivos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../styles/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
</head>
<style type="text/css">
	table{
		font-size: 13px;
		width: 100%;
	}
	table th,td{
		background-color: #e4e9ef;
		padding: 5px;
	}
	table a{
		color: blue;
		text-decoration: underline;
	}
</style>
<body class="w3-light-grey">

	<div class="w3-bar w3-top w3-blue w3-large" style="z-index:4">
		<span class="w3-bar-item w3-left"><img src="../images/logo.svg" style="width: 230px;"></span>
	</div>

	<div class="w3-main" style="margin-top:43px;">
		<hr>
		<div class="w3-panel">
			<div class="w3-row-padding">
				<table>
					<tr>
						<th>Nombre del documento</th>
						<th>Numéro de radicado</th>
						<th>Fecha de subida</th>
						<th>Enlace</th>
					</tr>
					<?php 
					while ($fila = $resultado->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $fila['nombreArchivo']; ?></td>
							<td><?php echo $fila['numRadico']; ?></td>
							<td><?php echo $fila['anoSubida']."-".$fila['mesSubida']."-".$fila['diaSubida']; ?></td>
							<td><a href="<?php echo $fila['rutaArchivo']; ?>" target="_blank">Ver</a></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>
		</div>
	</div>

</body>
</html>