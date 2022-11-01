<?php 
include '../pages/conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
  header ("Location: login/index.php");
}

?>
<!DOCTYPE html>
<html>
<title>Gestionar contactos</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../styles/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
<link href="../Fontawesome/css/all.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../styles/dataTables.bootstrap.min.css" />
<!--<link rel="stylesheet" type="text/css" href="../styles/bootstrap.min.css">-->
<script src="../js/jquery-3.6.0.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<style>
  html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
  .modal-backdrop{z-index: 3;}
  .row{width: 100%;}
  @media (min-width:576px){.modal-dialog{max-width:80%;margin:1.75rem auto}
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
        <a href="peticionesAprobadas.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-check-square fa-fw"></i>  Aprobadas</a>
        <a href="peticionesReasignadas.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-undo fa-fw"></i>  Reasignadas</a>
        <a href="peticionesSinRespuesta.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-comment-slash fa-fw"></i>  No respuesta</a>
      </div>
      <?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 2) {

        ?>
        <div class="w3-container">
          <h5>Administración</h5>
        </div>
        <div class="w3-bar-block">
          <a href="usuarios.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users-cog fa-fw"></i>  Usuarios</a>
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
        <h5><b><i class="fa fa-users-cog fa-fw" style="color: #607d8b!important;"></i> Gestionar contactos</b></h5>
      </header>
      <hr>
      <?php 
      $sentencia = "SELECT *, E.Descripcion AS EstadoP, EN.Nombre AS EntidadN
      FROM `persona` P
      LEFT JOIN estadousuario E ON E.IdEstado = P.idEstado
      LEFT JOIN entidades EN ON EN.idEntidad = P.idEntidad";
      $resultado = $mysqli->query($sentencia);
      ?>
      <div class="w3-container">
        <button onclick="document.getElementById('id01').style.display='block'" style="float: right;" class="w3-button w3-green">Agregar nuevo  <i class="fa fa-plus"></i></button><br><br><br>
        <table id="TablaHistorial" class="dataTable display table table-striped table-bordered dt-responsive nowrap" style="width:100%">
          <thead>
            <tr>
              <th>Estado</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Cargo</th>
              <th>Entidad</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php 
            while($fila = $resultado->fetch_assoc()){ ?>
              <tr>
                <td><?php echo $fila['EstadoP']; ?></td>
                <td><?php echo $fila['nombres']; ?></td>
                <td><?php echo $fila['apellidos']; ?></td>
                <td><?php echo $fila['cargo']; ?></td>
                <td><?php echo $fila['EntidadN']; ?></td>
                <td><button onclick="GetUserDetails('<?php echo $fila['idPersona']; ?>')"><i class="fa fa-edit"></i></button></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <hr>

      <div id="id01" class="w3-modal">
        <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

          <div class="w3-center"><br>
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
          </div>

          <form class="w3-container" method="POST" action="nuevoUsuario.php">
            <div class="w3-section">
              <div class="w3-half">
                <label><b>Nombres</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Nombre completo" name="nombres" required style="width: 90%;">
              </div>
              <div class="w3-half">
                <label><b>Apellidos</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Apellidos completos" name="apellidos" required style="width: 90%;">
              </div>
              <div class="w3-half">
                <label><b>Número de identificación</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Identificación" name="identificacion" required style="width: 90%;">
              </div>
              <div class="w3-half">
                <label><b>Cargo</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Nombre del cargo" name="cargo" required style="width: 90%;">
              </div>
              <div class="w3-half">
                <label><b>Coordinación</b></label>
                <select name="coordinacion" class="w3-input w3-border w3-margin-bottom" required style="width: 90%;">
                  <option disabled selected value="">Seleccionar</option>
                  <?php 
                  $sqlcoord = "SELECT * FROM coordinaciones";
                  $result = $mysqli->query($sqlcoord);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='".$row['IdCoordinacion']."'>".$row['Descripcion']."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="w3-half">
                <label><b>Tipo de usuario</b></label>
                <select name="usuario" class="w3-input w3-border w3-margin-bottom" required style="width: 90%;">
                  <option disabled selected value="">Seleccionar</option>
                  <?php 
                  $sqlcoord = "SELECT * FROM tipousuario";
                  $result = $mysqli->query($sqlcoord);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='".$row['IdTipoUsuario']."'>".$row['Descripcion']."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="w3-half">
                <label><b>Correo</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Correo corporativo" name="correo" required style="width: 90%;">
              </div>
              <div class="w3-half">
                <label><b>Contraseña</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="*********" name="pass" required style="width: 90%;">
              </div>
              <input class="w3-button w3-block w3-green w3-section w3-padding" type="submit" name="registrar" value="Registrar">
            </div>
          </form>

          <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
            <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red">Cancelar</button>
          </div>

        </div>
      </div>

      <!-- Modal - Update User details -->
      <div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title">Actualizar</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> 


            <div class="modal-body">
              <form action="update" method="POST">
                <div class="row">
                  <div class="col-6 p-2">
                    <div class="form-group">
                      <label for="idalumno">Nombre</label>
                      <input type="text" id="update_nombres" value="" class="form-control"/>
                    </div>
                  </div>
                  <div class="col-6 p-2">
                    <div class="form-group">
                      <label for="codalumno">Apellidos</label>
                      <input type="text" id="update_apellidos" class="form-control"/>
                    </div>
                  </div>
                  <div class="col-6 p-2">
                    <div class="form-group">
                      <label for="codalumno">Tipo identificacion</label>
                      <select id="update_tIdentificacion" class="form-control">
                        <option disabled selected id="data_ti" value="">Seleccionar</option>
                        <?php 
                        $sqlti = "SELECT * FROM tipodocumento";
                        $result = $mysqli->query($sqlti);

                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['IdTipoIdentificacion']."'>".$row['Descripcion']."</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 p-2">
                    <div class="form-group">
                      <label for="codalumno">Identificacion</label>
                      <input type="text" id="update_identificacion" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-4 p-2">
                    <label for="pais">País</label>
                    <select id="update_pais" class="form-control">
                      <option disabled selected id="pais" value="">Seleccionar</option>
                      <?php 
                      $sqlpais = "SELECT * FROM paises";
                      $result = $mysqli->query($sqlpais);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo "<option value='".$row['IdPais']."'>".$row['Nombre']."</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-4 p-2">
                    <label for="cargo">Cargo</label>
                    <input type="text" id="update_cargo" class="form-control"/>
                  </div>
                  <div class="col-4 p-2">
                    <label for="codalumno">Entidad <i class="fas fa-plus-circle"></i></label>
                    <select id="update_entidad" class="form-control">
                      <option disabled selected id="entidad" value="">Seleccionar</option>
                      <?php 
                      $sqlentidades = "SELECT * FROM entidades";
                      $result = $mysqli->query($sqlentidades);

                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo "<option value='".$row['idEntidad']."'>".$row['Nombre']."</option>";
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-6 p-2">
                    <div class="form-group">
                      <label for="correos">Correos</label>
                      <p id="update_correos"></p>
                    </div>
                  </div>
                  <div class="col-6 p-2" style="border-left: 1px solid #e9ecef;">
                    <div class="form-group">
                      <label for="correos">Teléfonos</label>
                      <p id="update_contactos"></p>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-6 p-2">
                    <div class="form-group">
                      <label for="listas">Listas <i class="fas fa-plus-circle"></i></label>
                      <p id="update_listas"></p>
                    </div>
                  </div>
                  <div class="col-6 p-2" style="border-left: 1px solid #e9ecef;">
                    <div class="form-group">
                      <label for="correos">Enlaces</label>
                      <p id="update_enlaces"></p>
                    </div>
                  </div>
                </div>

              </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="UpdateUserDetails()" >Guardar Cambios</button>
              <input type="hidden" id="hidden_user_id">
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="w3-container w3-padding-16 w3-light-grey">
        <p style="text-align: center">© <?php echo date('Y') ?> Todos los derechos reservados a <a href="https://cuentadealtocosto.org/site/" target="_blank">Cuenta de Alto Costo</a></p>
      </footer>

      <!-- End page content -->
    </div>

    <script type="text/javascript" src="js/script.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
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