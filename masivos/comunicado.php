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
<title>Envío masivo</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
<link href="../Fontawesome/css/all.css" rel="stylesheet">
<link href="../styles/quill.snow.css" rel="stylesheet"> 
<script src="../js/quill.js"></script>
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
      <a href="index.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-file-download fa-fw"></i>  Reportes</a>
    </div>
    <?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 2) {

      ?>
<div class="w3-container">
      <h5>Administración</h5>
    </div>
    <div class="w3-bar-block">
      <a href="../pages/usuarios.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users-cog fa-fw"></i>  Usuarios</a>
      <a href="../pages/files.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-folder-open fa-fw"></i>  Archivos</a>
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
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <label class="paso-activo">Documento</label>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="destinatarios.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Destinatarios</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="verCargados.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Cargados</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="resumen.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Resumen</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="colaEnvios.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Cola de envíos</label></a>
          </div>
          <div class="w3-container w3-text-indigo" style="margin-top: 10%;">
            <form action="guardartexto.php" method="POST" target="_blank"id="Form">
              <input type="hidden" name="id" value="<?php echo $id ?>">
              <div class="w3-half">
                <label><b>Nombre de comunicado</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="nombre" required style="width: 90%;" value="<?php echo $fila['Nombre']; ?>">
              </div>
              <div class="w3-half">
                <label><b>Consecutivo</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="consecutivo" required readonly style="width: 90%;" value="<?php echo $fila['Numero']; ?>">
              </div>
              <div class="w3-half">
                <label><b>Fecha del comunicado</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="date" name="fecha" required style="width: 90%;" value="<?php echo $fila['Fecha']; ?>">
              </div>
              <div class="w3-half">
                <label><b>Asunto</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="asunto" required style="width: 90%;" value="<?php echo $fila['Asunto']; ?>">
              </div>

              <div class="w3-half">
                <label><b>Correo remitente</b></label>
                <br>
                <select class="w3-input w3-border w3-margin-bottom">
                  <option>Seleccionar</option>
                </select>
              </div>

              <div class="w3-col" style="margin-bottom: 4%;">
                <label><b>Cuerpo del correo:</b></label>
                <br><br>
                <textarea required style="height: 150px; width:100%;" name="cuerpo"><?php echo $fila['CuerpoCorreo']; ?></textarea>
              </div>
              <div class="w3-col">
                <label><b>Cuerpo del documento</b></label><br><br>
                <div id="editor" style="height: 400px; color:black;"><?php echo html_entity_decode($fila['Texto']); ?></div>
                <textarea name="documento" id="documento" style="display: none;"></textarea>
              </div>
              <div class="w3-col" style="margin-top: 2%;">
                <button name="guardar" class="w3-btn w3-half w3-green" onclick="logHtmlContent()">Guardar</button>
                <button name="previsualizar" target="_blank" class="w3-btn w3-half w3-blue" onclick="logHtmlContent()">Previsualizar</button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <!-- Footer -->
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