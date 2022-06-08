<?php 

if (!isset($_GET['Id'])) {
	header ("Location: index.php");
}
$id = $_GET["Id"];
$key = 'cu3nt4_d3_4lt0_c05t0';
include ('../pages/conexion.php');

$sentencia = "SELECT *, EP.Descripcion AS EstadoPeticion,TP.Descripcion AS TipoPeticion, TPS.Descripcion AS TipoPersona, TE.Descripcion AS TipoEmpresa, PA.Nombre AS Pais, DEP.Nombre AS Departamento, Mun.Descripcion AS Municipio, TPL.Descripcion AS Poblacion, H.RutaArchivo AS ArchivoRespuesta FROM peticiones P
LEFT JOIN estadopeticion EP ON EP.IdEstado = P.IdEstadoPeticion
LEFT JOIN tipopeticion TP ON TP.IdTipoPeticion = P.IdTipoPeticion
LEFT JOIN tipopersona TPS ON TPS.IdTipoPersona = P.IdTipoPersona
LEFT JOIN tipoempresa TE ON TE.IdTipoEmpresa = P.idTipoEmpresa
LEFT JOIN paises PA ON PA.IdPais = P.IdPais
LEFT JOIN departamento DEP ON DEP.IdDepartamento = P.IdDepartamento
LEFT JOIN municipios MUN ON MUN.IdMunicipio = P.IdMunicipio
LEFT JOIN tipopoblacion TPL ON TPL.IdTipoPoblacion = P.IdTipoPoblacion 
LEFT JOIN historialrespuestas H ON P.IdRespuesta = H.IdRespuesta
WHERE MD5(concat('$key',P.numRadicado)) = '$id'";

$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ver solicitud</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../styles/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
	<link href="../Fontawesome/css/all.css" rel="stylesheet">
</head>
<style type="text/css">
	table{
		font-size: 13px;
		width: 100%;
	}
	table.datos th{
		background-color: #e4e9ef;
		padding: 5px;
	}
	a{
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
				<div class="w3-col w3-container w3-white" style="padding: 15px 20px;">
					<label>INFORMARCIÓN DE LA SOLICITUD CON NÚMERO DE RADICADO <b><?php echo $fila['numRadicado']; ?></b></label>
				</div>
			</div>
			<div class="w3-row-padding">
				<div class="w3-col w3-container w3-white" style="padding: 15px 0px;text-align: center;">
					<div class="w3-col w3-container w3-white" style="width: 100%;">
						<table class="datos">
							<tr>
								<th>TIPO DE SOLICITUD</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><?php echo $fila['TipoPeticion']; ?></td>
								<th>TIPO DE PERSONA</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><?php echo $fila['TipoPersona']; ?></td>
							</tr>
							<tr>
								<th>FECHA RADICADO</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><?php echo $fila['FechaCreacion']; ?></td>
								<th>REMITENTE</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><?php echo $fila['nombreRemitente']." ".$fila['apellidosRemitente']; ?></td>
							</tr>
							<tr>
								<th>ASUNTO</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><?php echo $fila['temaPeticion']; ?></td>
								<th>CORREO</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><?php echo $fila['Correo']; ?></td>
							</tr>
							<tr>
								<th>DOCUMENTO</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><a href="../formularioUsuarios/descargarPeticion.php?Id=<?=md5($key.$fila['numRadicado'])?>" target="_blank">Ver documento de radicación</a></td>
								<th>DOCUMENTOS ADJUNTOS</th>
								<td style="background-color: #e4e9ef;padding: 5px;text-align: left;"><a  href="#" onclick="myFunction()">Ver adjuntos</a></td>
							</tr>

						</table>
					</div>
				</div>
			</div>
			<div class="w3-row-padding" style="margin:10px 0px">
				<div class="w3-col w3-container w3-white" style="padding: 15px 20px;">
					<h5>Estado de la solicitud: <?php echo $fila['EstadoPeticion']; ?></h5>	

					<div class="w3-container w3-center" style="background: #002897;padding: 10px;width: 60%;margin-left: auto;margin-right: auto;border-radius: 3px;margin-top: 4%;">
						<table>
							<tr>		

								<?php 

								if ($fila['IdEstadoPeticion']=='1') {
									?>
									<td>
										<div style="background-color: #26C54E;" id="circulo-tramite">
											<img src="images/A-radicado.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">Radicado</label>
									</td>
									<td>
										<div style="background-color: #c1c1c1;" id="circulo-tramite">
											<img src="images/A-tramite.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">En tramite</label>
									</td>
									<td>
										<div style="background-color: #c1c1c1;" id="circulo-tramite">
											<img src="images/A-resp.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">Finalizado</label>
									</td>
									<?php	
								}if ($fila['IdEstadoPeticion']=='2' || $fila['IdEstadoPeticion']=='3') {

									?> 
									<td>
										<div style="background-color: #c1c1c1;" id="circulo-tramite">
											<img src="images/A-radicado.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">Radicado</label>
									</td>
									<td>
										<div style="background-color: #26C54E;" id="circulo-tramite">
											<img src="images/A-tramite.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">En tramite</label>
									</td>
									<td>
										<div style="background-color: #c1c1c1;" id="circulo-tramite">
											<img src="images/A-resp.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">Finalizado</label>
									</td>
									<?php
								}if ($fila['IdEstadoPeticion']=='4') {
									
									?>
									<td>
										<div style="background-color: #c1c1c1;" id="circulo-tramite">
											<img src="images/A-radicado.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">Radicado</label>
									</td>
									<td>
										<div style="background-color: #c1c1c1;" id="circulo-tramite">
											<img src="images/A-tramite.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">En tramite</label>
									</td>
									<td>
										<div style="background-color: #26C54E;" id="circulo-tramite">
											<img src="images/A-resp.png" style="width: 80px;">
										</div>
										<label style="color: #FFF;">Finalizado</label>
										
									</td>

									<?php
								}

								?>
							</tr>
						</table>
					</div>
					
					<?php 
					if ($fila['IdEstado'] == 4) {
						$archivo = $fila['ArchivoRespuesta'];
						echo "<a href='$archivo'>Descargar respuesta</a>";
					}					
					?>
					<a href="index.php"><button style="float: right;background-color: red;color: #FFF;border: none;padding: 6px 10px;margin-top: 4%;cursor: pointer;">Cerrar</button></a>
				</div>

			</div>
		</div>

		<!-- End page content -->
	</div>

</body>
<script type="text/javascript">
	function myFunction() {
		var myWindow = window.open("archivos.php?Id=<?php echo $id; ?>", "", "width=1200,height=400");
	}
</script>
</html>