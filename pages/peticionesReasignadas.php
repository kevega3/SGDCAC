<?php 

session_start();

if (!isset($_SESSION['usuario'])) {
  header ("Location: login/index.php");
}

?>
<!DOCTYPE html>
<html>
<title>Peticiones reasignadas</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
<link href="../Fontawesome/css/all.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../styles/dataTables.bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="../styles/bootstrap.min.css">
<script src="../js/jquery-3.6.0.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
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
        <a href="logout.php" class="w3-bar-item w3-button" title="Cerrar sesión"><i class="fa fa-sign-out-alt"></i></a>
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
      <a href="peticionesPendientes.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-exclamation-circle fa-fw"></i>  Pendientes</a>
      <a href="peticionesPorAprobar.php" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-clock fa-fw"></i>  Por aprobar</a>
      <a href="peticionesAprobadas" class="w3-bar-item w3-button w3-padding"><i class="fa fa-check-square fa-fw"></i>  Aprobadas</a>
      <a href="peticionesReasignadas.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-undo fa-fw"></i>  Reasignadas</a>
    </div>
    <?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 2) {

      ?>
<div class="w3-container">
      <h5>Administración</h5>
    </div>
    <div class="w3-bar-block">
      <a href="usuarios.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users-cog fa-fw"></i>  Usuarios</a>
      <a href="files.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-folder-open fa-fw"></i>  Archivos</a>
      <a href="../reportes/" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-file-download fa-fw"></i>  Reportes</a>
      <a href="../masivos/" class="w3-bar-item w3-button w3-padding"><i class="fab fa-wpforms fa-fw"></i>  Masivos</a>
      <a href="consecutivos.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-list-ol fa-fw"></i>  Consecutivos</a>
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
      <h5><b><i class="fa fa-undo fa-fw" style="color: #2196F3!important;"></i> Reasignadas</b></h5>
    </header>
    <hr>
    <?php 
    $usuario = $_SESSION['IdUsuario'];
    include ('conexion.php');
    $sentencia = "SELECT *,P.IdPeticion AS IdPeticion,numRadicado,FechaCreacion,TP.Descripcion AS TipoPeticion, T.Descripcion AS TipoPersona, Correo,temaPeticion,P.IdUsuarioAsignado 
    FROM historialreasignaciones H 
    INNER JOIN peticiones P ON P.numRadicado = H.IdPeticion 
    INNER JOIN tipopeticion TP ON TP.IdTipoPeticion = P.IdTipoPeticion 
    INNER JOIN tipopersona T ON T.IdTipoPersona = P.IdTipoPersona 
    WHERE H.IdAsignadoPor = '$usuario' GROUP BY H.IdPeticion;";
    $resultado = $mysqli->query($sentencia);
    ?>
    <div class="w3-container">
      <table id="TablaHistorial" class="dataTable display table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Radicado</th>
            <th>Fecha de radicación</th>
            <th>Tipo de petición</th>
            <th>Tipo de persona</th>
            <th>Correo</th>
            <th>Tema</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while($fila = $resultado->fetch_assoc()){ ?>
            <tr>
              <td><?php echo $fila['numRadicado']; ?></td>
              <td><?php echo $fila['FechaCreacion']; ?></td>
              <td><?php echo $fila['TipoPeticion']; ?></td>
              <td><?php echo $fila['TipoPersona']; ?></td>
              <td><?php echo $fila['Correo']; ?></td>
              <td><?php echo $fila['temaPeticion']; ?></td>
              <td style="vertical-align: middle;"><a href="ver.php?Id=<?php echo $fila['IdPeticion']; ?>" class="botonVer">Ver</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table><br>
      <!--<button class="w3-button w3-dark-grey">More Countries  <i class="fa fa-arrow-right"></i></button>-->
    </div>
    <hr>

    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
      <p style="text-align: center">© <?php echo date('Y') ?> Todos los derechos reservados a <a href="https://cuentadealtocosto.org/site/" target="_blank">Cuenta de Alto Costo</a></p>
    </footer>

    <!-- End page content -->
  </div>

  <script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>
<script src="../js/translate.js"></script>
</body>
</html>