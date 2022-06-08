<?php
include '../pages/conexion.php';
include ("keys.php");
header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>CAC | Correspondencia</title>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>"></script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<link href="../Fontawesome/css/all.css" rel="stylesheet">
</head>
<style>
#contenedor li {
	padding: 18px;
	margin: 8px 0;
	background: #ddd;
	list-style: none;
}
#contenedor li a {
	cursor: pointer;
	float: right;
	padding: 3px 7px;
}
</style>
<body>

	<div class="container text-center">   

		<div class="row">
			<div class="col-lg-12">
				<div class="well">

					<div class="col-sm-12">
						<img src="banner.jpg" alt="logo" class="logo">
					</div>

				</div>
				<form action="guardarPeticion.php" method="POST" enctype="multipart/form-data" id="reg">
					<input type="hidden" name="google-response-token" id="google-response-token">
					<div class="well" style="padding: 0px;">
						<div id="form">1. Datos personales</div>

						<div class="col-sm-6"> 
							<table class="table-form">
								<tr>
									<td>Tipo de persona <span>*</span></td>
									<td>
										<select id="tipopersona" name="tipopersona" class="campo" onChange="mostrar(this.value);" required>
											<option disabled selected value="0">Seleccionar</option>
											<?php 
											$sqlpersona = "SELECT * FROM tipopersona";
											$result = $mysqli->query($sqlpersona);

											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo "<option value='".$row['IdTipoPersona']."'>".$row['Descripcion']."</option>";
												}
											}
											?>
										</select>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>Nombre del remitente <span>*</span></td>
									<td><input type="text" class="campo" name="nombrepersona" onkeypress="return validar_texto(event)"></td>
									<td><i class="fas fa-question-circle" title="Nombre de la persona que realiza la solicitud"></i></td>
								</tr>
								<tr>
									<td>Apellidos <span>*</span></td>
									<td><input type="text" class="campo" name="apellidospersona" onkeypress="return validar_texto(event)"></td>
									<td><i class="fas fa-question-circle" title="Apellido(s) de la persona que realiza la solicitud."></i></td>
								</tr>
								
								<tr id="juridica2" hidden>
									<td>Razón social <span>*</span></td>
									<td><input type="text" class="campo" name="razonsocial" onkeypress="return varios(event)"></td>
									<td><i class="fas fa-question-circle" title="Razón social de la empresa."></i></td>
								</tr>
								<tr id="juridica3" hidden>
									<td>Tipo de Empresa <span>*</span></td>
									<td>
										<select name="tipoempresa" class="campo">
											<option disabled selected value="">Seleccionar</option>
											<?php 
											$sqlempresa = "SELECT * FROM tipoempresa";
											$result = $mysqli->query($sqlempresa);

											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo "<option value='".$row['IdTipoEmpresa']."'>".$row['Descripcion']."</option>";
												}
											}
											?>
										</select>
									</td>
									<td><i class="fas fa-question-circle" title="En este campo debe seleccionar el tipo de empresa."></i></td>
								</tr>
								<tr>
									<td>Correo electrónico <span>*</span></td>
									<td><input type="mail" class="campo" name="correo" onkeypress="return varios(event)" required></td>
									<td><i class="fas fa-question-circle" title="La respuesta a su solicitud será enviada al correo registrado en este campo. Por favor valide que el correo está bien diligenciado."></i></td>
								</tr>
								<tr>
									<td>Tipo de entidad <span>*</span></td>
									<td>
										<select id="tipopoblacion" name="tipopoblacion" class="campo" required>
											<option disabled selected value="">Seleccionar</option>
											<?php 
											$sqlpersona = "SELECT * FROM tipopoblacion";
											$result = $mysqli->query($sqlpersona);

											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo "<option value='".$row['IdTipoPoblacion']."'>".$row['Descripcion']."</option>";
												}
											}
											?>
										</select>
									</td>
									<td></td>
								</tr>
							</table>
						</div>

						<div class="col-sm-6">
							<table class="table-form">
								<tr>
									<td>País <span>*</span></td>
									<td>
										<select id="pais" name="pais" class="campo" required>
											<option selected value="42">Colombia</option>
											<?php 
											$sqlpersona = "SELECT * FROM paises";
											$result = $mysqli->query($sqlpersona);

											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo "<option value='".$row['IdPais']."'>".$row['Nombre']."</option>";
												}
											}
											?>
										</select>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>Departamento <span>*</span></td>
									<td>
										<select id="departamento" name="departamento" class="campo">
											<option disabled selected value="0">Seleccionar</option>
											<?php 
											$sqlpersona = "SELECT * FROM departamento";
											$result = $mysqli->query($sqlpersona);

											if ($result->num_rows > 0) {
												while ($row = $result->fetch_assoc()) {
													echo "<option value='".$row['IdDepartamento']."'>".$row['Nombre']."</option>";
												}
											}
											?>
										</select>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>Municipio <span>*</span></td>
									<td><div id="municipios"></div></td>
									<td></td>
								</tr>
								<tr>
									<td>Dirección <span>*</span></td>
									<td><input type="text" class="campo" name="direccion" onkeypress="return varios(event)" required></td>
									<td><i class="fas fa-question-circle" title="Dirección de la empresa o persona."></i></td>
								</tr>
								<tr>
									<td>Teléfono movil <span>*</span></td>
									<td><input type="text" class="campo" name="celular" onkeypress="return solo_numeros(event)" required></td>
									<td><i class="fas fa-question-circle" title="Ingrese número de celular."></i></td>
								</tr>
								<tr>
									<td>Teléfono fijo <span>*</span></td>
									<td><input type="text" class="campo" onkeypress="return solo_numeros(event)" name="fijo"></td>
									<td><i class="fas fa-question-circle" title="Ingrese número de télefono fijo (Con extensión si aplica)"></i></td>
								</tr>								
							</table>
						</div>
					</div>

					<div class="well" style="padding: 0px;">
						<div id="form">2. Datos su solicitud</div>

						<div class="col-sm-6"> 
							<table class="table-form">
								<tr>
									<td>Asunto de su petición <span>*</span></td>
									<td><input type="text" class="campo" name="tema" onkeypress="return varios(event)" required></td>
									<td><i class="fas fa-question-circle" title="Ingrese el asunto de su petición."></i></td>
								</tr>
								<tr>
									<td>Mensaje <span>*</span></td>
									<td><textarea maxlength="1999" onkeypress="return varios(event)" required name="mensaje" id="textarea"></textarea><br><span id="contador" style="font-size: 11px;">Carácteres disponibles: 2000</span></td>
									<td><i class="fas fa-question-circle" title="En este campo puede escribir sus comentarios o descripción de la petición."></i></td>
								</tr>
							</table>
						</div>

						<div class="col-sm-6">
							<div style="text-align: left;font-size: 11px;    border: 1px solid;border-radius: 5px;padding: 5px;margin-bottom: 5%;background: #F0F0F0;">
								<p><b>Siga las recomendaciones a continuación para adjuntar correctamente sus archivos:</b></p>
								<ul>
									<li>Se pueden adjuntar máximo 3 archivos</li>
									<li>El tamaño máximo para subida de cada archivo es de 5.0MB</li>
									<li>Extensiones permitidas: PDF, PNG, JPG, JPEG</li>
								</ul>
							</div>
							<table class="table-form">
								<tr>
									<td style="text-align: left;">Subida de archivos:</td>
									<td><input type="button" value="Agregar campo" onclick="crear_elemento();" style="float: right;"></td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="contenedor">
											<li><input type="file" name="archivo[]" onchange="validar();validar_tamanio(this);"  id="files" accept=".png,.pdf,.jpeg,.jpg,.svg" required></li>
										</div>
									</td>
								</tr>
							</table>
							
						</div>

						<div class="col-sm-12">
							<hr>
							<p><input type="checkbox" name="datos_personales" required>   He leído y acepto la <a href="https://cuentadealtocosto.org/site/wp-content/uploads/2021/09/sgi_dg_22_politica-de-tratamiento-de-datos-personales-cac-v4.pdf" target="_blank">Política de Tratamiento de Datos</a>.</p>
							<hr>
							<div class="loader">
								<img src="../images/loader.gif" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
							</div>
							<input type="submit" name="Enviar" value="Enviar">
							<br><br>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="../js/function.js"></script>
	<script type="text/javascript">
		// RESPONSIVE TOKEN DE GOOGLE RE-CAPTCHA PARA EVITAR EL SPAM
		function getReCaptcha(){
			grecaptcha.ready(function() {
				grecaptcha.execute('<?php echo SITE_KEY; ?>', {action: 'homepage'}).then(function(token) {
					document.getElementById("google-response-token").value = token;
				});
			});
		}
		
		getReCaptcha();
		setInterval(function(){getReCaptcha();},110000);



		let theForm = document.querySelector("#reg");

		theForm.addEventListener("submit", function(){
			let loader = document.querySelector(".loader");

			loader.classList.add("active");
		}, false);

</script>
</body>
</html>