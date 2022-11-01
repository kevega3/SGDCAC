<?php 

session_start();
header("Content-Type: text/html;charset=utf-8");
if (!isset($_SESSION['usuario'])) {
  header ("Location: login/index.php");
}
if(!isset($_GET["Id"])){
  exit();
}
$id = $_GET["Id"];
include ('conexion.php');
$sentencia = "SELECT *, EP.Descripcion AS EstadoPeticion,TP.Descripcion AS TipoPeticion, TPS.Descripcion AS TipoPersona, TE.Descripcion AS TipoEmpresa, PA.Nombre AS Pais, DEP.Nombre AS Departamento, Mun.Descripcion AS Municipio, TPL.Descripcion AS Poblacion FROM peticiones P
LEFT JOIN estadopeticion EP ON EP.IdEstado = P.IdEstadoPeticion
LEFT JOIN tipopeticion TP ON TP.IdTipoPeticion = P.IdTipoPeticion
LEFT JOIN tipopersona TPS ON TPS.IdTipoPersona = P.IdTipoPersona
LEFT JOIN tipoempresa TE ON TE.IdTipoEmpresa = P.idTipoEmpresa
LEFT JOIN paises PA ON PA.IdPais = P.IdPais
LEFT JOIN departamento DEP ON DEP.IdDepartamento = P.IdDepartamento
LEFT JOIN municipios MUN ON MUN.IdMunicipio = P.IdMunicipio
LEFT JOIN tipopoblacion TPL ON TPL.IdTipoPoblacion = P.IdTipoPoblacion WHERE IdPeticion = '$id'";

$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<title>Observaciones</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/w3.css">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
<link href="../Fontawesome/css/all.css" rel="stylesheet">
<style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
  .accordion {
    background-color: #FFF;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
    margin: 3px 8px;
  }
  .active, .accordion:hover {
    background-color: #ccc; 
  }
  .accordion:after {
    content: '\002B';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
  }

  .active:after {
    content: "\2212";
  }
  .panel {
    padding: 20px 18px;
    display: none;
    background-color: white;
    overflow: hidden;
    margin: 1px 9px;
  }
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
      <a href="peticionesPendientes.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-exclamation-circle fa-fw"></i>  Pendientes</a>
      <a href="peticionesPorAprobar.php" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-clock fa-fw"></i>  Por aprobar</a>
      <a href="peticionesAprobadas" class="w3-bar-item w3-button w3-padding"><i class="fa fa-check-square fa-fw"></i>  Aprobadas</a>
      <a href="peticionesReasignadas.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-undo fa-fw"></i>  Reasignadas</a>
      <a href="peticionesSinRespuesta.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-comment-slash fa-fw"></i>  No respuesta</a>
    </div>
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
    <button class="accordion">Datos personales del remitente</button>
    <div class="panel">
      <div class="w3-col w3-container w3-white" style="padding: 0px 8px;">
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
    <button class="accordion">Datos de la petición</button>
    <div class="panel">
      <div class="w3-col w3-container w3-white" style="padding-bottom: 16px;">
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
              <div style="padding: 7px; border: 1px solid #70c64e; margin-top: 3%;"><a target="_blank" style="color: grey;" href="<?php echo $file['rutaArchivo'] ?>"><i class="fas fa-file"></i>  <?php echo $file['nombreArchivo'] ?></a></div>
              <?php   
            }
          }
          ?>
        </div>
      </div>
    </div>

    <button class="accordion">Gestión de solicitud</button>
    <div class="panel">
     <div class="w3-col w3-container w3-white" style="padding-bottom: 16px;">
      <div class="w3-twothird w3-container w3-text-indigo">
        <label><b>Respuesta:</b></label>
        <textarea class="w3-input w3-border" style="height: 170px;" readonly><?php echo $fila['Respuesta']; ?></textarea>
      </div>
      <div class="w3-third w3-container w3-text-indigo">
        <label><b>Número de respuesta</b></label>
        <input type="text" class="w3-input w3-border" name="numRespuesta" readonly value="<?php echo $fila['numRespuesta']; ?>">
        <br>
        <label><b>Fecha de respuesta</b></label>
        <input type="text" class="w3-input w3-border" name="fechaRespuesta" readonly value="<?php echo $fila['fechaRespuesta']; ?>">
      </div>
    </div>
  </div>
  <button class="accordion active">Observaciones</button>
  <div class="panel" style="display: block;">
    <?php
    $radicado = $fila['numRadicado']; 
    $sentence = "SELECT *FROM observaciones WHERE numRadicado = '$radicado'";
    $result = $mysqli->query($sentence);
    $row = $result->fetch_assoc();
    ?>    
    <div class="w3-col w3-container w3-white" style="padding-bottom: 16px;">
      <div class="w3-twothird w3-container w3-text-indigo">
        <label><b>Observación:</b></label>
        <textarea class="w3-input w3-border" style="height: 170px;" readonly><?php echo $row['observacion']; ?></textarea>
      </div>
      <div class="w3-third w3-container w3-text-indigo">
        <label><b>Fecha de registro:</b></label>
        <input type="text" class="w3-input w3-border" name="numRespuesta" readonly value="<?php echo $row['fechaRegistro']; ?>">
      </div>
    </div>
  </div>
  <button class="accordion active">Gestionar</button>
  <div class="panel" style="display: block;">    
    <div class="w3-col w3-container w3-white" style="padding-bottom: 16px;">
      <div class="w3-col w3-container w3-text-indigo">
        <label><b>Respuesta:</b></label>
        <form action="gestionarObservacion.php" method="POST">
          <input type="hidden" name="radicado" value="<?php echo $fila['numRadicado'] ?>">
          <textarea class="w3-input w3-border" name="Respuesta" style="height: 170px;" required></textarea>
          <br>
          <input type="submit" class="w3-btn w3-green" name="responder" value="Responder">
        </form>
      </div>
    </div>
  </div>
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

let theForm = document.querySelector("#reg");

theForm.addEventListener("submit", function(){
  let loader = document.querySelector(".loader");

  loader.classList.add("active");
}, false);

let myForm = document.querySelector("#resp");

myForm.addEventListener("submit", function(){
  let load = document.querySelector(".loader");

  load.classList.add("active");
}, false);
</script>

<script>
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        panel.style.display = "none";
      } else {
        panel.style.display = "block";
      }
    });
  }
</script>
</body>
</html>