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
INNER JOIN estadopeticion EP ON EP.IdEstado = P.IdEstadoPeticion
INNER JOIN tipopeticion TP ON TP.IdTipoPeticion = P.IdTipoPeticion
INNER JOIN tipopersona TPS ON TPS.IdTipoPersona = P.IdTipoPersona
INNER JOIN tipoempresa TE ON TE.IdTipoEmpresa = P.idTipoEmpresa
INNER JOIN paises PA ON PA.IdPais = P.IdPais
INNER JOIN departamento DEP ON DEP.IdDepartamento = P.IdDepartamento
INNER JOIN municipios MUN ON MUN.IdMunicipio = P.IdMunicipio
INNER JOIN tipopoblacion TPL ON TPL.IdTipoPoblacion = P.IdTipoPoblacion WHERE IdPeticion = '$id'";

$resultado = $mysqli->query($sentencia);
$fila = $resultado->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<title>Peticiones pendientes</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/w3.css">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
<link href="../Fontawesome/css/all.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
  .notfound{
    border-color: red;
  }
  .found{
    border-color: green;
  }
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
    background: #fbfbfb;
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
                <div style="padding: 7px; border: 1px solid #70c64e; margin-top: 3%;"><a target="_blank" style="color: grey;" href="<?php echo $file['rutaArchivo'] ?>"><i class="fas fa-file"></i>  <?php echo $file['nombreArchivo'] ?></a></div>
                <?php   
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="w3-row-padding" style="margin:16px -16px">
        <div class="w3-col w3-container w3-white" style="padding-bottom: 16px;">
          <h5>Gestionar</h5>
          <div class="w3-col w3-container w3-text-indigo">
            <button class="w3-btn w3-blue" onclick="openCity(event, 'Responder')">Respuesta</button>
            <button class="w3-btn w3-blue" onclick="openCity(event, 'Reasignar')">Reasignar</button>
            <button class="w3-btn w3-blue" onclick="openCity(event, 'Anexar')">Anexar a solicitud</button>
            <button class="w3-btn w3-red" onclick="openCity(event, 'noResponder')">No responder</button>


            <div id="Responder" class="tabcontent">
              <div class="w3-col w3-container w3-text-indigo">
                <br><label><b>Respuesta:</b></label><br><br>
                <form action="guardarRespuesta.php" method="POST" id="resp" enctype="multipart/form-data">
                  <div class="w3-twothird w3-container w3-text-indigo">
                    <input type="hidden" name="idpeticion" value="<?php echo $fila['numRadicado']; ?>">
                    <textarea class="w3-input w3-border" name="respuesta" style="height: 170px;"></textarea><br><br>

                  </div>
                  <div class="w3-third w3-container w3-text-indigo">
                    <input type="file" name="comunicado" value="Cargar" accept=".pdf,.docx" required>
                  </div>
                  <div class="w3-half w3-container w3-text-indigo">
                    <input type="submit" class="w3-btn w3-green" name="responder" value="Enviar para aprobación">
                  </div>
                </form>
              </div>
            </div>

            <div id="Reasignar" class="tabcontent">
              <div class="w3-half w3-container w3-text-indigo">
                <br><label><b>Reasignar a:</b></label><br><br>
                <?php
                $lista = "SELECT * FROM usuarios ORDER BY Nombres";
                $usuarios = $mysqli->query($lista);
                ?>
                <form action="reasignarPeticion.php" method="POST" id="reg">
                  <input type="hidden" name="idpeticion" value="<?php echo $fila['numRadicado']; ?>">
                  <select class="w3-select" name="nuevoR">
                    <option disabled selected value="">Seleccionar</option>
                    <?php 
                    while ($responsable = $usuarios->fetch_assoc()) {?>
                      <option value="<?php echo $responsable['IdUsuario']?>"><?php echo $responsable['Nombres']." ".$responsable['Apellidos'];?></option>

                      <?php  
                    }
                    ?> 
                  </select>
                  <br><br>
                  <label><b>Motivo:</b></label><br><br>
                  <textarea class="w3-input w3-border" name="motivoReasignacion" style="height: 170px;"></textarea><br><br>
                  <input type="submit" class="w3-btn w3-green" name="reasignar" value="Reasignar">
                </form> 
              </div>
              <div class="w3-half w3-container w3-text-indigo">
                <label><b>Historial de reasignaciones</b></label>
                <?php
                $idpeticion = $fila['numRadicado'];
                $historial = "SELECT *,A.Nombres AS NombreAsignador, A.Apellidos AS ApellidosAsignador,P.Nombres AS NombreAsignado, P.Apellidos AS ApellidosAsignado FROM historialreasignaciones HR 
                INNER JOIN usuarios A ON A.IdUsuario = HR.IdUsuarioAsignado
                INNER JOIN usuarios P on P.IdUsuario = HR.IdAsignadoPor WHERE IdPeticion = '$idpeticion' ORDER BY IdReasignacion DESC";
                $ver = $mysqli->query($historial);

                while($mostrar = $ver->fetch_assoc()){?>
                  <div class="w3-col w3-container w3-text-indigo" style="padding: 8px; margin: 10px 0px; border: 1px solid #cccccc; border-left: 8px solid #2152eb;border-radius: 5px 0px 0px 5px;">
                    <div class="w3-half">
                      <label><b>Para:</b></label>
                      <?php echo $mostrar['NombreAsignador']." ".$mostrar['ApellidosAsignador']; ?>
                    </div>
                    <div class="w3-half">
                      <label><b>De:</b></label>
                      <?php echo $mostrar['NombreAsignado']." ".$mostrar['ApellidosAsignado']; ?>
                    </div>
                    <div class="w3-col">
                      <br>
                      <label><b>Fecha:</b></label>
                      <?php echo $mostrar['fechaReasignacion']; ?>
                    </div>
                    <div class="w3-col">
                      <br>
                      <label><b>Motivo:</b></label><br>
                      <?php echo $mostrar['MotivoReasignacion']; ?>
                    </div>
                  </div>
                  <?php  
                }
                ?>
              </div>
            </div>

            <div id="Anexar" class="tabcontent">
              <div class="w3-col w3-container w3-text-indigo">
                <div class="w3-twothird w3-container w3-text-indigo">
                  <br><br>
                  <label for="user"><b>Buscar radicado: </b></label>
                  <input type="text" class="w3-input w3-border" name="documento" id="documento" onkeyup="verificarDocumento()" min="1" style="outline: none;width: 50%;display: inline-grid;" required/>
                  <span class="help-block"></span>
                  <input type="button" value="Agregar" disabled id="agregar" onclick="crear_elemento();">
                  <form action="guardarAnexo.php" method="POST" id="anexos">
                    <div id="contenedor">
                      <input type="hidden" name="radicado" value="<?php echo $fila['numRadicado']; ?>">
                      <input type="hidden" name="id" value="<?php echo $fila['IdPeticion'] ?>">
                    </div>
                    <br><br>
                    <input type="submit" class="w3-btn w3-green" value="Guardar" name="guardar" id="btnGuardar" disabled>
                  </form>
                </div>
                <div class="w3-third w3-container w3-text-indigo">
                  <label><b>Anexos a esta solicitud:</b></label>

                  <?php 
                  $radicado = $fila['numRadicado'];
                  $anexos = "SELECT * FROM anexos A INNER JOIN peticiones P ON P.numRadicado = A.numRadicado WHERE anexadoA = '$radicado'";
                  $salida = $mysqli->query($anexos);

                  while ($row = $salida->fetch_assoc()) {
                    $id = $row['IdPeticion'];
                    ?>
                    <a href="ver.php?Id=<?php echo $id; ?>" target="_blank"><?php echo "<br>".$row['numRadicado'];?></a>
                    <?php } ?>
                </div>    
              </div>
            </div>
            <div id="noResponder" class="tabcontent">
              <div class="w3-col w3-container w3-text-indigo">
                <br><label><b>Motivo:</b></label><br><br>
                <form action="noResponder.php" method="POST" id="resp" enctype="multipart/form-data">
                  <div class=" w3-container w3-text-indigo">
                    <input type="hidden" name="idpeticion" value="<?php echo $fila['IdPeticion']; ?>">
                    <textarea class="w3-input w3-border" name="motivo" style="height: 170px;"></textarea><br><br>

                  </div>
                  <div class="w3-half w3-container w3-text-indigo">
                    <input type="submit" class="w3-btn w3-green" name="responder" value="Guardar">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End page content -->
  </div>
  <script src="../js/gestionar.js"></script>
</body>
</html>