<?php
include ("../formularioUsuarios/keys.php");
if (!isset($_GET['Id'])) {
	header ("Location: index.php");
}
$id = $_GET["Id"];

$key = 'cu3nt4_d3_4lt0_c05t0';
include ('../pages/conexion.php');
$sentencia = "SELECT * FROM peticiones WHERE MD5(concat('$key',numRadicado)) = '$id'";

$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reabrir radicado</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../styles/w3.css">
	<link rel="stylesheet" href="../styles/bootstrap.min.css">
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>"></script>
</head>
<body style="background: #f5f5f5;">

	<div class="container-fluid" style="background: #fff; width: 70%;border-radius: 5px;margin-top: 1%;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12" style="margin-bottom: 2%;">
					<img src="../images/logo_color.svg" style="width: 50%;float: right;margin-top: 1%;">
				</div>
				<form action="guardarObservacion.php" method="POST">
					<input type="hidden" name="google-response-token" id="google-response-token">
					<div class="col-sm-6">
						<label class="w3-text-indigo"><b>Número de radicado</b></label>
						<br>
						<input type="text" name="radicado" class="w3-input w3-border" readonly value="<?php echo $fila['numRadicado']; ?>" style="width: 90%; background-color: #f5f5f5;">
					</div>

					<div class="col-sm-6">
						<label class="w3-text-indigo"><b>Fecha de radicado</b></label>
						<br>
						<input type="text" readonly name="fecha" class="w3-input w3-border" style="width: 90%; background-color: #f5f5f5;" value="<?php echo $fila['FechaCreacion']; ?>">
					</div>
					<div class="col-sm-12" style="margin-top: 2%;">
						<label class="w3-text-indigo"><b>Asunto *</b></label>
						<br>
						<input type="text" readonly name="asubnto" class="w3-input w3-border" style="width: 100%; background-color: #f5f5f5;" value="<?php echo $fila['temaPeticion']; ?>">
					</div>
					<div class="col-sm-12" style="margin-top: 2%;">
						<label class="w3-text-indigo"><b>Observaciones *</b></label>
						<br>
						<textarea maxlength="2000" name="observaciones" class="w3-input w3-border" style="height: 200px;" required></textarea>
					</div>

					<div class="col-sm-12" style="margin: 3% 0%;">
						<center><input class="w3-btn" type="submit" name="enviar" value="Enviar" style="width: 40%;border-radius: 3px;background: #70c652;color: #FFF;"></center>
					</div>
				</form>

			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	function getReCaptcha(){
		grecaptcha.ready(function() {
			grecaptcha.execute('<?php echo SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
				document.getElementById("google-response-token").value = token;
			});
		});
	}

	getReCaptcha();
	setInterval(function(){getReCaptcha();},110000);
</script>
</html>