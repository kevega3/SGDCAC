<?php 

session_start();

if (!isset($_SESSION['usuario'])) {
  header ("Location: login/index.php");
}
$usuario = $_SESSION['IdUsuario'];
$tipoUsuario=$_SESSION['tipoUsuario'];
include ('pages/conexion.php');
?>
<!DOCTYPE html>
<html>
<title>Cuenta de Alto Costo</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="Fontawesome/css/font-awesome.min.css">
<link href="Fontawesome/css/all.css" rel="stylesheet">
<style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

  <!-- Top container -->
  <div class="w3-bar w3-top w3-blue w3-large" style="z-index:4">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
    <span class="w3-bar-item w3-right"><img src="images/logo.svg" style="width: 230px;"></span>
  </div>

  <!-- Sidebar/menu -->
  <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container w3-row">
      <div class="w3-col s4">
        <img src="images/AvatarUsuario.png" class="w3-circle w3-margin-right" style="width:46px">
      </div>
      <div class="w3-col s8 w3-bar">
        <span>Bienvenid@, <strong><?php echo $_SESSION['nombre']; ?></strong></span><br>
        <a href="pages/logout.php" class="w3-bar-item w3-button" title="Cerrar sesión"><i class="fa fa-sign-out-alt"></i></a>
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
      <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-home fa-fw"></i>  Inicio</a>
      <a href="pages/peticionesPendientes.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-exclamation-circle fa-fw"></i>  Pendientes</a>
      <a href="pages/peticionesPorAprobar.php" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-clock fa-fw"></i>  Por aprobar</a>
      <a href="pages/peticionesAprobadas.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-check-square fa-fw"></i>  Aprobadas</a>
      <a href="pages/peticionesReasignadas.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-undo fa-fw"></i>  Reasignadas</a>
      <a href="pages/peticionesSinRespuesta.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-comment-slash fa-fw"></i>  No respuesta</a>
    </div>
    <?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 2) {

      ?>
      <div class="w3-container">
        <h5>Administración</h5>
      </div>
      <div class="w3-bar-block">
        <?php
        if ($_SESSION['tipoUsuario'] == 1) {?>
          <a href="pages/usuarios.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users-cog fa-fw"></i>  Usuarios</a>
          <a href="pages/files.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-folder-open fa-fw"></i>  Archivos</a>
        <?php } ?>
        <a href="reportes/" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-file-download fa-fw"></i>  Reportes</a>
        <a href="masivos/" class="w3-bar-item w3-button w3-padding"><i class="fab fa-wpforms fa-fw"></i>  Masivos</a>
        <a href="pages/consecutivos.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-list-ol fa-fw"></i>  Consecutivos</a>
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
      <h5><b><i class="fa fa-dashboard"></i> Solicitudes</b></h5>
    </header>

    <div class="w3-row-padding w3-margin-bottom">
      <div class="w3-quarter" style="margin-top: 10px;">
        <a href="pages/peticionesPendientes.php">
          <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #B90102;color: #FFF;">
            <div class="w3-left"><i class="fa fa-exclamation-circle w3-xxxlarge"></i></div>
            <div class="w3-right">
              <?php
              $pendientes = "SELECT count(numRadicado) AS Total FROM peticiones WHERE IdUsuarioAsignado = '$usuario' AND (IdEstadoPeticion = 1 OR IdEstadoPeticion = 2)";
              $result1 = $mysqli->query($pendientes);
              $fila1 = $result1->fetch_assoc();
              ?>
              <h3><?php echo $fila1['Total']; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Pendientes</h4>
          </div>
        </a>
      </div>
      <div class="w3-quarter" style="margin-top: 10px;">
        <a href="pages/peticionesPorAprobar.php">
          <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #F57801;color: #FFF;">
            <div class="w3-left"><i class="fa fas fa-clock w3-xxxlarge"></i></div>
            <div class="w3-right">
              <?php
              if ($tipoUsuario==2) {
                $aprobar = "SELECT count(numRadicado) AS Total FROM peticiones WHERE IdEstadoPeticion = 3";
              }else{
                $aprobar = "SELECT count(numRadicado) AS Total FROM peticiones WHERE IdUsuarioAsignado = '$usuario' AND IdEstadoPeticion = 3";
              }
              
              $result2 = $mysqli->query($aprobar);
              $fila2 = $result2->fetch_assoc();
              ?>
              <h3><?php echo $fila2['Total']; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Por aprobar</h4>
          </div>
        </a>
      </div>
      <div class="w3-quarter" style="margin-top: 10px;">
        <a href="pages/peticionesAprobadas.php">
          <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #009788;color: #FFF;">
            <div class="w3-left"><i class="fa fa-check-square w3-xxxlarge"></i></div>
            <div class="w3-right">
              <?php
              $aprobadas = "SELECT count(numRadicado) AS Total FROM peticiones WHERE IdUsuarioAsignado = '$usuario' AND IdEstadoPeticion = 4";
              $result3 = $mysqli->query($aprobadas);
              $fila3 = $result3->fetch_assoc();
              ?>
              <h3><?php echo $fila3['Total']; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Aprobadas</h4>
          </div>
        </a>
      </div>
      <div class="w3-quarter" style="margin-top: 10px;">
        <a href="pages/peticionesReasignadas.php">
          <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #6C45E5;color: #FFF;">
            <div class="w3-left"><i class="fa fa-undo w3-xxxlarge"></i></div>
            <div class="w3-right">
              <?php
              $reasignadas = "SELECT COUNT(DISTINCT IdPeticion) AS Total FROM historialreasignaciones WHERE IdAsignadoPor = '$usuario'";
              $result4 = $mysqli->query($reasignadas);
              $fila4 = $result4->fetch_assoc();
              ?>
              <h3><?php echo $fila4['Total']; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Reasignadas</h4>
          </div>
        </a>
      </div>
      <div class="w3-quarter" style="margin-top: 10px;">
        <a href="pages/peticionesSinRespuesta.php">
          <div class="w3-container w3-padding-16" style="border-radius: 8px; background-color: #22269E;color: #FFF;">
            <div class="w3-left"><i class="fa fa-comment-slash w3-xxxlarge"></i></div>
            <div class="w3-right">
              <?php
              $reasignadas = "SELECT count(numRadicado) AS Total FROM peticiones WHERE IdUsuarioAsignado = '$usuario' AND IdEstadoPeticion = 5";
              $result4 = $mysqli->query($reasignadas);
              $fila4 = $result4->fetch_assoc();
              ?>
              <h3><?php echo $fila4['Total']; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>No respuesta</h4>
          </div>
        </a>
      </div>  
    </div>

    <?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 2) {

      ?>
      <h5><b><i class="fa fa-dashboard"></i> Administrar</b></h5>
      <div class="w3-row-padding w3-margin-bottom">

        <?php
        if ($_SESSION['tipoUsuario'] == 1) {?>
          <div class="w3-quarter" style="margin-top: 10px;">
            <a href="pages/usuarios.php">
              <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #5B30AF;color: #FFF;">
                <div class="w3-left"><i class="fa fa-users-cog w3-xxxlarge"></i></div>
                <div class="w3-right">
                  <?php
                  $usuarios = "SELECT COUNT(IdUsuario) AS Total FROM usuarios";
                  $result5 = $mysqli->query($usuarios);
                  $fila5 = $result5->fetch_assoc();
                  ?>
                  <h3><?php echo $fila5['Total']; ?></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Usuarios</h4>
              </div>
            </a>
          </div>
          
          <div class="w3-quarter" style="margin-top: 10px;">
            <a href="pages/files.php">
              <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #8158CF;color: #FFF;">
                <div class="w3-left"><i class="fa fa-folder-open w3-xxxlarge"></i></div>
                <div class="w3-right">
                  <?php
                  $archivos = "SELECT COUNT(IdArchivo) AS Total FROM historialarchivos";
                  $result5 = $mysqli->query($archivos);
                  $fila5 = $result5->fetch_assoc();
                  ?>
                  <h3>5</h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Archivos</h4>
              </div>
            </a>
          </div>
          <?php
        }
        ?>
        <div class="w3-quarter" style="margin-top: 10px;">
          <a href="reportes/">
            <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #4645D8;color: #FFF;">
              <div class="w3-left"><i class="fa fa-file-download w3-xxxlarge"></i></div>
              <div class="w3-right">
                <h3><br></h3>
              </div>
              <div class="w3-clear"></div>
              <h4>Reportes</h4>
            </div>
          </a>
        </div>
        <div class="w3-quarter" style="margin-top: 10px;">
          <a href="masivos/">
            <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #5E9CFE;color: #FFF;">
              <div class="w3-left"><i class="fab fa-wpforms w3-xxxlarge"></i></div>
              <div class="w3-right">
                <h3><br></h3>
              </div>
              <div class="w3-clear"></div>
              <h4>Masivos</h4>
            </div>
          </a>
        </div>

        <div class="w3-quarter" style="margin-top: 10px;">
          <a href="pages/consecutivos.php">
            <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #4C6FFF;color: #FFF;">
              <div class="w3-left"><i class="fa fa-list-ol w3-xxxlarge"></i></div>
              <div class="w3-right">
                <h3><br></h3>
              </div>
              <div class="w3-clear"></div>
              <h4>Consecutivos</h4>
            </div>
          </a>
        </div>
      </div>


      <!--<h5><b><i class="fa fa-dashboard"></i> Gestión de contactos</b></h5>
      <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-quarter" style="margin-top: 10px;">
          <a href="contactos/">
            <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #4645D8; color: #FFF;">
              <div class="w3-left"><i class="far fa-address-card w3-xxxlarge"></i></div>
              <div class="w3-right">
                <h3><br></h3>
              </div>
              <div class="w3-clear"></div>
              <h4>Contactos</h4>
            </div>
          </a>
        </div>

        <div class="w3-quarter" style="margin-top: 10px;">
          <a href="contactos/listas.php">
            <div class="w3-container w3-padding-16" style="border-radius:8px;background-color: #3C77DF;color: #FFF;">
              <div class="w3-left"><i class="fa fa-list w3-xxxlarge"></i></div>
              <div class="w3-right">
                <h3><br></h3>
              </div>
              <div class="w3-clear"></div>
              <h4>Listas</h4>
            </div>
          </a>
        </div>
        <div class="w3-quarter" style="margin-top: 10px;">
            <a href="contactos/importarContactos.php">
              <div class="w3-container w3-padding-16 w3-win8-indigo" style="border-radius:8px;background-color: #62C3E9;color: #FFF;">
                <div class="w3-left"><i class="fa fal fa-upload w3-xxxlarge"></i></div>
                <div class="w3-right">
                  <h3><br></h3>
                </div>
                <div class="w3-clear"></div>
                <h4>Importar</h4>
              </div>
            </a>
          </div>
          
      </div>-->

      <?php
    }
    ?>
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

</body>
</html>
