<?php 
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario'])) {
  header ("Location: login/index.php");
}

?>
<!DOCTYPE html>
<html>
<title>Archivos</title>
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
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}
/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #112797;
  color: #FFF;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 3% 12px;
  border: 1px solid #ccc;
  border-top: none;
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
    </div>
    <?php if ($_SESSION['tipoUsuario'] == 1 || $_SESSION['tipoUsuario'] == 2) {

      ?>
      <div class="w3-container">
        <h5>Administración</h5>
      </div>
      <div class="w3-bar-block">
        <a href="usuarios.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users-cog fa-fw"></i>  Usuarios</a>
        <a href="files.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-folder-open fa-fw"></i>  Archivos</a>
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
      <h5><b><i class="fa fa-folder-open fa-fw" style="color: #607d8b!important;"></i> Archivos cargados</b></h5>
    </header>
    <hr>
    
    <div class="tab">
      <button class="tablinks active" onclick="openCity(event, 'London')">Archivos externos</button>
      <button class="tablinks" onclick="openCity(event, 'Paris')">Archivos de respuesta</button>
    </div>

    <div id="London" class="tabcontent" style="display: block;">
      <div class="w3-container">
        <?php 
        include ('conexion.php');
        $sentencia = "SELECT * FROM `historialarchivos` ORDER BY numRadico DESC";
        $resultado = $mysqli->query($sentencia);
        ?>
        <table id="" class="dataTable display table table-striped table-bordered dt-responsive nowrap" style="width:100%">
          <thead>
            <tr>
              <th>Radicado</th>
              <th>Nombre</th>
              <th>Año</th>
              <th>Mes</th>
              <th>Día</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php 
            while($fila = $resultado->fetch_assoc()){ ?>
              <tr>
                <td><?php echo $fila['numRadico']; ?></td>
                <td><?php echo $fila['nombreArchivo']; ?></td>
                <td><?php echo $fila['anoSubida']; ?></td>
                <td><?php echo $fila['mesSubida']; ?></td>
                <td><?php echo $fila['diaSubida']; ?></td>
                <td><a href="<?php echo $fila['rutaArchivo']; ?>"><i class="fas fa-eye" style="color: #2152eb!important;" title="Ver"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div id="Paris" class="tabcontent">
      <div class="w3-container">
        <?php 
        include ('conexion.php');
        $sentence = "SELECT *, U.Nombres AS Nombres, U.Apellidos AS Apellidos 
        FROM `historialrespuestas` H
        LEFT JOIN usuarios U ON H.IdUsuarioAsignado = U.IdUsuario";
        $res = $mysqli->query($sentence);
        ?>
        <table id="" class="dataTable display table table-striped table-bordered dt-responsive nowrap" style="width:100%">
          <thead>
            <tr>
              <th>Radicado</th>
              <th>Fecha</th>
              <th>Respondido por</th>
              <th>Nombre archivo</th>
              <th>Estado</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php 
            while($row = $res->fetch_assoc()){ ?>
              <tr>
                <td><?php echo $row['numRadicado']; ?></td>
                <td><?php echo $row['FechaRespuesta']; ?></td>
                <td><?php echo $row['Nombres'].' '.$row['Apellidos']; ?></td>
                <td><?php echo $row['NombreArchivo']; ?></td>
                <td>
                  <?php

                  if ($row['IdEstadoRespuesta']==2) {
                    echo "<p style='color: red;'>Rechazado</p>";
                  }elseif($row['IdEstadoRespuesta']==3){
                    echo "<p style='color: darkorange;'>En revisión</p>";
                  }else{
                    echo "<p style='color: green;'>Aprobado</p>";
                  }
                  ?>
                </td>
                <td><a href="<?php echo $row['RutaArchivo']; ?>"><i class="fas fa-eye" style="color: #2152eb!important;" title="Ver"></i></a></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    

    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
      <p style="text-align: center">© <?php echo date('Y') ?> Todos los derechos reservados a <a href="https://cuentadealtocosto.org/site/" target="_blank">Cuenta de Alto Costo</a></p>
    </footer>

    <!-- End page content -->
  </div>
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
  <script src="../js/translate.js"></script>
</body>
</html>