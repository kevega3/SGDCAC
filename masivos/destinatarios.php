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
<title>Subir destinatarios</title>
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
  .inputfile-box {
    position: relative;
  }

  .inputfile {
    display: none;
  }

  .container {
    display: inline-block;
    width: 100%;
  }

  .file-box {
    display: inline-block;
    width: 100%;
    border: 1px solid;
    padding: 5px 5px;
    box-sizing: border-box;
    height: 34px;
  }

  .file-button {
    background: #112797;
    padding: 5px;
    position: absolute;
    border: 1px solid;
    top: 0px;
    right: 0px;
    color: #fff;
  }
  input::placeholder{
    opacity: 0.5;
  }
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
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="comunicado.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Documento</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <label class="paso-activo">Destinatarios</label>
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

          <div class="w3-container w3-text-indigo " style="margin-top: 10%;">
            <div class="w3-pale-green" style="padding: 1px 20px;border-radius: 5px;">
              <p>Descargue la plantilla para la subida masiva de destinatarios dando <a href="plantillaEnvio.csv" download style="text-decoration: revert;">clic aquí</a></p>
            </div>
          </div>
          <div class="w3-container w3-text-indigo" style="margin-top: 4%;">

            <form action="subir.php" enctype="multipart/form-data" method="POST">
              <input type="hidden" name="id" value="<?php echo $id ?>">
              <div style="padding: 1px 20px;border-radius: 5px;">

                <h5>Subida de archivo</h5>
                <div class="inputfile-box">
                  <input type="file" id="file" name="archivo" accept=".csv" class="inputfile" onchange='uploadFile(this)'>
                  <label for="file">
                    <span id="file-name" class="file-box"></span>
                    <span class="file-button">
                      <i class="fa fa-upload" aria-hidden="true"></i>
                      Seleccionar archivo
                    </span>
                  </label>
                </div>
                <br>
                <input type="submit" class="w3-btn w3-blue" value="Cargar" name="subir">
              </div>
            </form>
            <hr>
          </div>

          <div class="w3-container w3-text-indigo" style="margin-top: 2%;">

            <form action="subir.php" enctype="multipart/form-data" method="POST">

              <input type="hidden" name="id" value="<?php echo $id ?>">
              <div style="padding: 1px 20px;border-radius: 5px;">

                <h5>Subida individual</h5>
                <br>
                <div class="w3-half">
                  <label>Nombres</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="nombre">
                </div>

                <div class="w3-half">
                  <label>Apellidos</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="apellidos">
                </div>

                <div class="w3-half">
                  <label>Cargo</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="cargo">
                </div>

                <div class="w3-half">
                  <label>Entidad</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="entidad">
                </div>

                <div class="w3-half">
                  <label>Regimen</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="regimen">
                </div> 

                <div class="w3-half">
                  <label>Correo</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="correo">
                </div>

                <div class="w3-half">
                  <label>Trato 1</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="trato1" placeholder="Doctor(a)">
                </div>

                <div class="w3-half">
                  <label>Trato 2</label><br>
                  <input type="text" class="w3-input w3-border w3-margin-bottom" style="width: 90%;" name="trato2" placeholder="Respetado(a)/Estimado(a)">
                </div>

                               

                <div class="w3-twothird">
                  <input type="submit" class="w3-btn w3-blue" value="Cargar" name="ind">
                </div>
                
              </div>

            </form>
            <hr>
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
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
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
<script type="text/javascript">
  function uploadFile(target) {
    document.getElementById("file-name").innerHTML = target.files[0].name;
  }
</script>
</body>
</html>
