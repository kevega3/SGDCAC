<?php 

session_start();

include '../pages/conexion.php';

if (!isset($_SESSION['usuario'])) {
  header ("Location: ../login/index.php");
}

?>
<!DOCTYPE html>
<html>
<title>Reportes</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
<link href="../Fontawesome/css/all.css" rel="stylesheet">
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
      <a href="peticionesSinRespuesta.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-comment-slash fa-fw"></i>  No respuesta</a>
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
      <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fas fa-file-download fa-fw"></i>  Reportes</a>
      <a href="../masivos/" class="w3-bar-item w3-button w3-padding"><i class="fab fa-wpforms fa-fw"></i>  Masivos</a>
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
      <h5><b><i class="fa fa-file-download fa-fw" style="color: #2196F3!important;"></i> Reportes</b></h5>
    </header>
    <hr>

    <div class="w3-container">
      <div class="w3-col w3-container w3-text-indigo">
        <button class="w3-btn w3-blue" onclick="openCity(event, 'Solicitudes')">Solicitudes</button>
        <button class="w3-btn w3-blue" onclick="openCity(event, 'Reasignar')">Reasignaciones</button>
        <button class="w3-btn w3-blue" onclick="openCity(event, 'Respuestas')">Respuestas</button>
        <button class="w3-btn w3-blue" onclick="openCity(event, 'Documentos')">Archivos radicados</button>
      </div>

      <div id="Solicitudes" class="tabcontent" style="display: block;">
        <div class="w3-col w3-container w3-text-indigo">
          <br><label><b>GENERAR REPORTE DE SOLICITUDES:</b></label><br><br>
          <form action="descargar_solicitudes.php" method="POST" id="form">
            <div class="w3-half w3-container w3-text-indigo">
              <label>Desde:</label><br>
              <input type="datetime-local" name="desde" class="w3-input w3-border"><br>
              <label>Hasta:</label><br>
              <input type="datetime-local" name="hasta" class="w3-input w3-border">
            </div>
            <div class="w3-half w3-container w3-text-indigo">
              <label>Estado:</label><br>
              <select name="estado" class="w3-input w3-border">
                <option value="0">Todos</option>
                <?php 
                $estados = "SELECT * FROM estadopeticion";
                $resultE = $mysqli->query($estados);
                if ($resultE->num_rows > 0) {
                  while ($row = $resultE->fetch_assoc()) {
                    echo "<option value='".$row['IdEstado']."'>".$row['Descripcion']."</option>";
                  }
                }
                ?>
              </select><br>
              <label>Asignado a:</label><br>
              <select name="asignado" class="w3-input w3-border">
                <option value="0">Todos</option>
                <?php 
                $asignados = "SELECT * FROM usuarios";
                $resultA = $mysqli->query($asignados);
                if ($resultA->num_rows > 0) {
                  while ($row = $resultA->fetch_assoc()) {
                    echo "<option value='".$row['IdUsuario']."'>".$row['Nombres']." ".$row['Apellidos']."</option>";
                  }
                }
                ?>
              </select>
            </div>
            <div class="w3-container w3-text-indigo">
              <br><br>
              <input type="submit" class="w3-btn w3-green" name="responder" value="Descargar">
            </div>
          </form>
        </div>
      </div>

      <div id="Reasignar" class="tabcontent">
        <div class="w3-col w3-container w3-text-indigo">
          <br><label><b>GENERAR REPORTE HISTORIAL DE REASIGNACIONES:</b></label><br><br>
          <form action="descargar_reasignaciones.php" method="POST" id="form">
            <div class="w3-half w3-container w3-text-indigo">
              <label>Desde:</label><br>
              <input type="datetime-local" name="desde" class="w3-input w3-border"><br>
              <label>Hasta:</label><br>
              <input type="datetime-local" name="hasta" class="w3-input w3-border">
            </div>
            <div class="w3-half w3-container w3-text-indigo">
              <label>Asignado a:</label><br>
              <select name="asignado" class="w3-input w3-border">
                <option value="0">Todos</option>
                <?php 
                $asignados = "SELECT * FROM usuarios";
                $resultA = $mysqli->query($asignados);
                if ($resultA->num_rows > 0) {
                  while ($row = $resultA->fetch_assoc()) {
                    echo "<option value='".$row['IdUsuario']."'>".$row['Nombres']." ".$row['Apellidos']."</option>";
                  }
                }
                ?>
              </select>
              <br>
              <label>Asignado por:</label><br>
              <select name="asignadop" class="w3-input w3-border">
                <option value="0">Todos</option>
                <?php 
                $asignados = "SELECT * FROM usuarios";
                $resultA = $mysqli->query($asignados);
                if ($resultA->num_rows > 0) {
                  while ($row = $resultA->fetch_assoc()) {
                    echo "<option value='".$row['IdUsuario']."'>".$row['Nombres']." ".$row['Apellidos']."</option>";
                  }
                }
                ?>
              </select>
            </div>
            <div class="w3-container w3-text-indigo">
              <br><br>
              <input type="submit" class="w3-btn w3-green" name="responder" value="Descargar">
            </div>
          </form>
        </div>
      </div>

      <div id="Respuestas" class="tabcontent">
        <div class="w3-col w3-container w3-text-indigo">
          <br><label><b>GENERAR REPORTE HISTORIAL DE RESPUESTAS:</b></label><br><br>
          <form action="descargar_respuestas.php" method="POST" id="form">
            <div class="w3-half w3-container w3-text-indigo">
              <label>Desde:</label><br>
              <input type="date" name="desde" class="w3-input w3-border"><br>
              <label>Hasta:</label><br>
              <input type="date" name="hasta" class="w3-input w3-border">
            </div>
            <div class="w3-half w3-container w3-text-indigo">
              <label>Asignado a:</label><br>
              <select name="asignado" class="w3-input w3-border">
                <option value="0">Todos</option>
                <?php 
                $asignados = "SELECT * FROM usuarios";
                $resultA = $mysqli->query($asignados);
                if ($resultA->num_rows > 0) {
                  while ($row = $resultA->fetch_assoc()) {
                    echo "<option value='".$row['IdUsuario']."'>".$row['Nombres']." ".$row['Apellidos']."</option>";
                  }
                }
                ?>
              </select>
            </div>
            <div class="w3-container w3-text-indigo">
              <br><br>
              <input type="submit" class="w3-btn w3-green" name="responder" value="Descargar">
            </div>
          </form>
        </div>
      </div>

      <div id="Documentos" class="tabcontent">
        <div class="w3-col w3-container w3-text-indigo">
          <br><label><b>GENERAR REPORTE DE DOCUMENTOS CARGADOS:</b></label><br><br>
          <form action="descargar_archivos.php" method="POST" id="form">
            <div class="w3-half w3-container w3-text-indigo">
              <label>Desde:</label><br>
              <input type="date" name="desde" class="w3-input w3-border"><br>
              <label>Hasta:</label><br>
              <input type="date" name="hasta" class="w3-input w3-border">
            </div>
            <div class="w3-half w3-container w3-text-indigo">
              <label>Número de radicado:</label><br>
              <input type="text" name="radicado" class="w3-input w3-border">
            </div>
            <div class="w3-container w3-text-indigo">
              <br><br>
              <input type="submit" class="w3-btn w3-green" name="responder" value="Descargar">
            </div>
          </form>
        </div>
      </div>
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
<script>
  function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }
</script>
</body>
</html>