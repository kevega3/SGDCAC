<?php 

session_start();

include '../pages/conexion.php';

if (!isset($_SESSION['usuario'])) {
  header ("Location: ../login/index.php");
}

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
      <button onclick="document.getElementById('id01').style.display='block'" style="float: right;" class="w3-button w3-green">Crear nuevo  <i class="fa fa-plus"></i></button><br><br><br>
      <?php 
      include ('../pages/conexion.php');
      $sentencia = "SELECT * FROM comunicados";
      $resultado = $mysqli->query($sentencia);
      ?>
      <table id="TablaHistorial" class="dataTable display table table-striped table-bordered dt-responsive nowrap" style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Número</th>
            <th>Fecha</th>
            <th>Asunto</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          while($fila = $resultado->fetch_assoc()){ ?>
            <tr>
              <td><?php echo $fila['IdComunicado']; ?></td>
              <td><?php echo $fila['Nombre']; ?></td>
              <td><?php echo $fila['Numero']; ?></td>
              <td><?php echo $fila['Fecha']; ?></td>
              <td><?php echo $fila['Asunto']; ?></td>
              <td style="vertical-align: middle;">

                <?php 
                if ($fila['Enviado'] == 0) {
                  ?>
                  <a href="comunicado.php?Id=<?php echo $fila['IdComunicado']; ?>" class="botonVer">Continuar</a>
                  <?php
                }else{
                  ?>
                  <a href="verComunicado.php?Id=<?php echo $fila['IdComunicado']; ?>" class="botonVer">Ver</a>
                  <?php
                }
                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table><br>
      <!--<button class="w3-button w3-dark-grey">More Countries  <i class="fa fa-arrow-right"></i></button>-->
    </div>
    <hr>
    <div id="id01" class="w3-modal">
      <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

        <div class="w3-center"><br>
          <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
        </div>

        <form class="w3-container" method="POST" action="guardarComunicado.php">
          <div class="w3-section">
            <div class="w3-half">
              <label><b>Nombre de comunicado</b></label>
              <input class="w3-input w3-border w3-margin-bottom" type="text" name="nombre" required style="width: 90%;">
            </div>
            <div class="w3-half">
              <?php include('../pages/gestConsecutivo.php'); $gestionar = new Consecutivo(); ?>
              <label><b>Consecutivo</b></label>
              <input class="w3-input w3-border w3-margin-bottom" type="text" name="consecutivo" value="<?php $gestionar->buscarUltimo(); ?>" readonly required style="width: 90%;">
            </div>
            <div class="w3-half">
              <label><b>Fecha del comunicado</b></label>
              <input class="w3-input w3-border w3-margin-bottom" type="date" name="fecha" required style="width: 90%;">
            </div>
            <div class="w3-half">
              <label><b>Asunto</b></label>
              <input class="w3-input w3-border w3-margin-bottom" type="text" name="asunto" required style="width: 90%;">
            </div>
            <div class="w3-col">
              <label><b>Enviar desde:</b></label>
              <select class="w3-input w3-border w3-margin-bottom" style="width: 95%;" name="cuenta" required>
                <option disabled selected>Seleccionar</option>
                <?php
                $cuentas = "SELECT * FROM smtp_options";
                $resp = $mysqli->query($cuentas);

                while($row = $resp->fetch_assoc()){
                  echo "<option value=".$row["IdCorreo"].">".$row['nombre']."</option>";
                }
                ?>
              </select>
            </div>
            <input class="w3-button w3-block w3-green w3-section w3-padding" style="width: 95%;" type="submit" name="crear" value="Guardar">
          </div>
        </form>

        <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
          <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red">Cancelar</button>
        </div>

      </div>
    </div>
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