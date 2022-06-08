<?php
include ("../formularioUsuarios/keys.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Formulario de consulta</title>
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

				<div class="col-sm-12" style="margin-bottom: 4%;">
					<label><b>Apreciado usuario:</b></label>
					<br>
					<br>
					<label>Para consultar el estado de su solicitud usted debe conocer el número de radicado y el código de verificación que se le asignó cuando envió su consulta (como se muestra en la siguiente imagen). Por favor ingrese esos datos en cada casilla correspondiente.</label>
					<br>
					<br>
					<img src="../images/radicado.png" style="display: block;margin-left: auto;margin-right: auto;width: 60%;border: 1px solid black;">
				</div>
				<form action="consultar.php" method="POST">
					<input type="hidden" name="google-response-token" id="google-response-token">
					<div class="col-sm-6">
						<label class="w3-text-indigo"><b>Número de radicado</b> *</label>
						<br>
						<input type="text" name="radicado" class="w3-input w3-border" maxlength="20" minlength="3" style="width: 90%;" required>
					</div>

					<div class="col-sm-6">
						<label class="w3-text-indigo"><b>Código de verificación</b> *</label>
						<br>
						<input type="text" maxlength="5" name="codigo" class="w3-input w3-border" style="width: 90%;" required>
					</div>

					<div class="col-sm-12" style="margin: 3% 0%;">
						<center><input class="w3-btn" type="submit" name="consulta" value="Consultar" style="width: 40%;border-radius: 3px;background: #70c652;color: #FFF;"></center>
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