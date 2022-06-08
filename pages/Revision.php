<?php 

session_start();

if (!isset($_SESSION['usuario'])) {
  header ("Location: login/index.php");
}
if(!isset($_GET["Id"])){
  exit();
}
$id = $_GET["Id"];
include ('conexion.php');
$sentencia = "SELECT *, EP.Descripcion AS EstadoPeticion,TP.Descripcion AS TipoPeticion, TPS.Descripcion AS TipoPersona, TE.Descripcion AS TipoEmpresa, PA.Nombre AS Pais, DEP.Nombre AS Departamento, Mun.Descripcion AS Municipio, TPL.Descripcion AS Poblacion,U.Nombres AS NombresResponsable, U.Apellidos AS ApellidosResponsable FROM peticiones P
LEFT JOIN estadopeticion EP ON EP.IdEstado = P.IdEstadoPeticion
LEFT JOIN tipopeticion TP ON TP.IdTipoPeticion = P.IdTipoPeticion
LEFT JOIN tipopersona TPS ON TPS.IdTipoPersona = P.IdTipoPersona
LEFT JOIN tipoempresa TE ON TE.IdTipoEmpresa = P.idTipoEmpresa
LEFT JOIN paises PA ON PA.IdPais = P.IdPais
LEFT JOIN departamento DEP ON DEP.IdDepartamento = P.IdDepartamento
LEFT JOIN municipios MUN ON MUN.IdMunicipio = P.IdMunicipio
LEFT JOIN tipopoblacion TPL ON TPL.IdTipoPoblacion = P.IdTipoPoblacion
LEFT JOIN usuarios  U ON U.IdUsuario = P.IdUsuarioAsignado
WHERE IdPeticion = '$id'";

$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<title>Para aprobar</title>
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
  <div class="loader">
    <img src="../images/loader.gif" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
  </div>
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
      <a href="peticionesPorAprobar.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fas fa-clock fa-fw"></i>  Por aprobar</a>
      <a href="peticionesAprobadas" class="w3-bar-item w3-button w3-padding"><i class="fa fa-check-square fa-fw"></i>  Aprobadas</a>
      <a href="peticionesReasignadas.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-undo fa-fw"></i>  Reasignadas</a>
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
      <h5><b><i class="fa fa-exclamation-circle fa-fw"></i> Radicado <?php echo $fila['numRadicado']; ?></b></h5>
    </header>
    <hr>
    <div class="w3-panel">
      <div class="w3-row-padding" style="margin:0 -16px">
        <div class="w3-col w3-container w3-white">
          <h5>Datos personales del remitente</h5>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Número de radicado:</b></label>
            <input type="text" class="w3-input w3-border" name="numRadicado" readonly value="<?php echo $fila['numRadicado']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Tipo de petición:</b></label>
            <input type="text" class="w3-input w3-border" name="tipopeticion" readonly value="<?php echo $fila['TipoPeticion']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Tipo de persona:</b></label>
            <input type="text" class="w3-input w3-border" name="tipopersona" readonly value="<?php echo $fila['TipoPersona']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Correo:</b></label>
            <input type="text" class="w3-input w3-border" name="correo" readonly value="<?php echo $fila['Correo']; ?>">
          </div>
        </div>
        <div class="w3-col w3-container w3-white" style="padding: 16px 8px;">
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Nombre:</b></label>
            <input type="text" class="w3-input w3-border" name="nombreRemitente" readonly value="<?php echo $fila['nombreRemitente']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Apellidos:</b></label>
            <input type="text" class="w3-input w3-border" name="apellidosRemitente" readonly value="<?php echo $fila['apellidosRemitente']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Tipo de entidad:</b></label>
            <input type="text" class="w3-input w3-border" name="tipopoblacion" readonly value="<?php echo $fila['Poblacion']; ?>">
          </div> 
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Dirección:</b></label>
            <input type="text" class="w3-input w3-border" name="Dirección" readonly value="<?php echo $fila['Direccion']; ?>">
          </div> 
        </div>
        <div class="w3-col w3-container w3-white" style="padding: 0px 8px;">
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>País</b></label>
            <input type="text" class="w3-input w3-border" name="pais" readonly value="<?php echo $fila['Pais']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Departamento:</b></label>
            <input type="text" class="w3-input w3-border" name="departamento" readonly value="<?php echo $fila['Departamento']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Municipio:</b></label>
            <input type="text" class="w3-input w3-border" name="tipopersona" readonly value="<?php echo $fila['Municipio']; ?>">
          </div>
          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Teléfono movil:</b></label>
            <input type="text" class="w3-input w3-border" name="telefonoM" readonly value="<?php echo $fila['Movil']; ?>">
          </div>
        </div>

        <div class="w3-col w3-container w3-white" style="padding: 16px 8px 16px 8px;">

          <div class="w3-quarter w3-container w3-text-indigo">
            <label><b>Teléfono fijo:</b></label>
            <input type="text" class="w3-input w3-border" name="telefonoF" readonly value="<?php echo $fila['Telefono']; ?>">
          </div>
          <?php 
          $tipopersona = $fila['IdTipoPersona']; 
          if ($tipopersona == 2) {?>
            <div class="w3-quarter w3-container w3-text-indigo">
              <label><b>Razón social:</b></label>
              <input type="text" class="w3-input w3-border" name="razonsocial" readonly value="<?php echo $fila['razonSocial']; ?>">
            </div>
            <div class="w3-quarter w3-container w3-text-indigo">
              <label><b>Tipo de Empresa:</b></label>
              <input type="text" class="w3-input w3-border" name="tipoEmpresa" readonly value="<?php echo $fila['TipoEmpresa']; ?>">
            </div>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="w3-row-padding" style="margin:16px -16px">
        <div class="w3-col w3-container w3-white" style="padding-bottom: 16px;">
          <h5>Datos de la petición</h5>
          <div class="w3-twothird w3-container w3-text-indigo">
            <label><b>Tema:</b></label>
            <input type="text" class="w3-input w3-border" name="tema" readonly value="<?php echo $fila['temaPeticion']; ?>">
            <br>
            <label><b>Mensaje:</b></label>
            <textarea class="w3-input w3-border" style="height: 170px;" readonly><?php echo $fila['Mensaje']; ?></textarea>
          </div>
          <div class="w3-third w3-container w3-text-indigo">
            <label><b>Archivos adjuntos:</b></label>
            <?php 

            $peticion = $fila['IdPeticion'];
            $consulta = "SELECT * FROM historialarchivos WHERE IdPeticion='$peticion'";
            $archivos = $mysqli->query($consulta);

            $registros = $archivos->num_rows;
            if ($registros <= 0) {
              echo "<br>";
              echo "<label>No se encontraron archivos adjuntos</label>";

            }else{

              while ($file = $archivos->fetch_assoc()) {?>
                <br><br><a target="_blank" href="<?php echo $file['rutaArchivo'] ?>"><i class="fas fa-file"></i>  <?php echo $file['nombreArchivo'] ?></a>
                <?php   
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="w3-row-padding" style="margin:16px -16px">
        <div class="w3-col w3-container w3-white" style="padding-bottom: 16px;">
          <h5>Gestión</h5>
          <?php
          $respuesta=$fila['IdRespuesta'];
          $buscar = "SELECT * FROM historialrespuestas WHERE IdRespuesta = '$respuesta'";
          $result = $mysqli->query($buscar);
          $row = $result->fetch_assoc();
          ?>
          <div class="w3-col w3-container w3-text-indigo">
            <div class="w3-twothird w3-bar w3-container w3-text-indigo">
              <label><b>Respuesta:</b></label><br>
              <textarea class="w3-input w3-border" readonly name="respuesta" style="height: 193px;"><?php echo $row['Respuesta']; ?></textarea>
            </div>
            <div class="w3-third w3-bar w3-container w3-text-indigo">
              <label><b>Comunicado:</b></label>
              <br>
              <div style="padding: 7px; border: 1px solid #70c64e; margin-top: 3%;"><a target="_blank" style="color: grey;" href="<?php echo $row['RutaArchivo'] ?>"><i class="fas fa-file"></i> Ver documento</a></div>
              <br>
              <label><b>Fecha de respuesta:</b></label>
              <br>
              <input type="text" readonly class="w3-input w3-border" value="<?php echo $row['FechaRespuesta']; ?>">
              <br>
              <label><b>Respondido por:</b></label>
              <br>
              <input type="text" readonly class="w3-input w3-border" value="<?php echo $fila['NombresResponsable']." ".$fila['ApellidosResponsable']; ?>">
            </div>
            <br><br>
            <div class="w3-bar w3-container w3-text-indigo" style="margin-top: 25%;">
              <form action="aprobar.php" method="POST" id="apr" style="width: 49%; float: left;">
                <input type="hidden" name="id" value="<?php echo $fila['numRadicado']; ?>">
                <input type="hidden" name="idR" value="<?php echo $fila['IdRespuesta']; ?>">
                <input type="submit" name="aprobar" class="w3-btn w3-green" value="Aprobar" style="width: 99%;">
              </form>
              <!-- Trigger/Open The Modal -->
              <button id="myBtn" class="w3-btn w3-red" style="width: 49%;">Rechazar</button>
              <form action="devolver.php" method="POST" id="dev" style="width: 49%; float: left;">
                <input type="hidden" name="id" value="<?php echo $fila['numRadicado']; ?>">
                <input type="hidden" name="idR" value="<?php echo $fila['IdRespuesta']; ?>">
                <input type="hidden" name="responsable" value="<?php echo $fila['IdUsuarioAsignado'] ?>">
                <!-- The Modal -->
                <div id="myModal" class="modal">

                  <!-- Modal content -->
                  <div class="modal-content">
                    <span class="close">&times;</span>
                    <label><b>Motivo de devolución:</b></label><br>
                    <textarea style="width: 100%;height: 200px; margin: 0px auto; " name="motivo"></textarea>
                    <input type="submit" name="devolver" class="w3-btn w3-red" value="Enviar" style="width: 270px;margin: 0px auto;display: block;">
                  </div>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>

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

let theForm = document.querySelector("#apr");

theForm.addEventListener("submit", function(){
  let loader = document.querySelector(".loader");

  loader.classList.add("active");
}, false);

let myForm = document.querySelector("#dev");

myForm.addEventListener("submit", function(){
  let load = document.querySelector(".loader");

  load.classList.add("active");
}, false);
</script>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>