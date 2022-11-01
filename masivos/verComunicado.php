<?php

session_start();

include '../pages/conexion.php';

if (!isset($_SESSION['usuario'])) {
	header ("Location: ../login/index.php");
}

if(!isset($_GET["Id"])){
	exit();
}

$id = $_GET["Id"];
$sentencia = "SELECT * FROM comunicados WHERE IdComunicado = '$id'";
$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Comunicado <?php echo $_GET["Id"] ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../styles/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
	<link href="../Fontawesome/css/all.css" rel="stylesheet">
	<link href="../styles/quill.snow.css" rel="stylesheet"> 
	<script src="../js/quill.js"></script>
</head>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

	<!-- Top container -->
	<div class="w3-bar w3-top w3-blue w3-large" style="z-index:4">
		<button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
		<span class="w3-bar-item w3-right"><img src="../images/logo.svg" style="width: 230px;"></span>
	</div>
	<!-- Sidebar/menu -->
	<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
		<div class="w3-container w3-row">
			<div class="w3-col s4">
				<img src="../images/AvatarUsuario.png" class="w3-circle w3-margin-right" style="width:46px">
			</div>
			<div class="w3-col s8 w3-bar">
				<span>Bienvenid@, <strong><?php echo $_SESSION['nombre']; ?></strong></span><br>
				<a href="../pages/logout.php" class="w3-bar-item w3-button" title="Cerrar sesión"><i class="fa fa-sign-out-alt"></i></a>
				<a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
				<a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
			</div>
		</div>
		<hr>
		<div class="w3-container">
			<h5>Gestión de solicitudes</h5>
		</div>
		<div class="w3-bar-block">
			<a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
			<a href="../index.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i>  Inicio</a>
			<a href="../pages/peticionesPendientes.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-exclamation-circle fa-fw"></i>  Pendientes</a>
			<a href="../pages/peticionesPorAprobar.php" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-clock fa-fw"></i>  Por aprobar</a>
			<a href="../pages/peticionesAprobadas" class="w3-bar-item w3-button w3-padding"><i class="fa fa-check-square fa-fw"></i>  Aprobadas</a>
			<a href="../pages/peticionesReasignadas.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-undo fa-fw"></i>  Reasignadas</a>
			<a href="../pages/peticionesSinRespuesta.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-comment-slash fa-fw"></i>  No respuesta</a>
		</div>
		<?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 2) {

			?>
			<div class="w3-container">
				<h5>Administración</h5>
			</div>
			<div class="w3-bar-block">
				<?php
				if ($_SESSION['tipoUsuario'] == 1) {?>
					<a href="../pages/usuarios.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users-cog fa-fw"></i>  Usuarios</a>
					<a href="../pages/files.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-folder-open fa-fw"></i>  Archivos</a>
				<?php } ?>
				<a href="../reportes/" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-file-download fa-fw"></i>  Reportes</a>
				<a href="index.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fab fa-wpforms fa-fw"></i>  Masivos</a>
				<a href="../pages/consecutivos.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-list-ol fa-fw"></i>  Consecutivos</a>
			</div>
			<?php
		}
		?>
	</nav>
	<!-- Overlay effect when opening sidebar on small screens -->
	<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

	<!-- !PAGE CONTENT! -->
	<div class="w3-main" style="margin-left:300px;margin-top:43px;">

		<!-- Header -->
		<header class="w3-container" style="padding-top:22px">
			<h5><b><i class="fab fa-wpforms fa-fw" style="color: #FEB70F!important;"></i> Envíos masivos</b></h5>
		</header>
		<hr>

		<div class="w3-container">
			<div class="w3-row-padding" style="margin:0 -16px">
				<div class="w3-col w3-container w3-white">
					<h5>Comunicado #<?php echo $fila['Numero'] ?></h5>
					<br>
					<h5>Información del comunicado</h5>
					
				</div>
			</div>
		</div>

		<footer class="w3-container w3-padding-16 w3-light-grey">
			<p style="text-align: center">© <?php echo date('Y') ?> Todos los derechos reservados a <a href="https://cuentadealtocosto.org/site/" target="_blank">Cuenta de Alto Costo</a></p>
		</footer>

		<!-- End page content -->
	</div>
	<script src="../js/editor.js"></script>
	<script>

		function logHtmlContent() {
			console.clear();
			var test = quill.root.innerHTML;
			document.getElementById("documento").value = test;
		}
	</script>

</body>
</html>