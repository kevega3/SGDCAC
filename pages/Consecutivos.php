<?php 

session_start();

if (!isset($_SESSION['usuario'])) {
  header ("Location: login/index.php");
}

?>
<!DOCTYPE html>
<html>
<title>Consecutivos</title>
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
      <?php
        if ($_SESSION['tipoUsuario'] == 1) {?>
      <a href="usuarios.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users-cog fa-fw"></i>  Usuarios</a>
      <a href="files.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-folder-open fa-fw"></i>  Archivos</a>
      <?php } ?>
      <a href="../reportes/" class="w3-bar-item w3-button w3-padding"><i class="fa fas fa-file-download fa-fw"></i>  Reportes</a>
      <a href="../masivos/" class="w3-bar-item w3-button w3-padding"><i class="fab fa-wpforms fa-fw"></i>  Masivos</a>
      <a href="consecutivos.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-list-ol fa-fw"></i>  Consecutivos</a>
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
      <h5><b><i class="fa fa-list-ol fa-fw" style="color: #2196F3!important;"></i> Consecutivos</b></h5>
    </header>
    <hr>

    <div class="w3-container">
      <h5>Separar consecutivo</h5>
      <hr>
      <?php
      include('gestConsecutivo.php'); 
      $generar = new Consecutivo();
      ?>
      <form action="gestConsecutivo.php" method="POST">

        <div class="w3-container w3-third">
          <label>Consecutivo</label><br>
          <input type="text" name="consecutivo" class="w3-input w3-border w3-margin-bottom" value="<?php $generar->buscarUltimo(); ?>" readonly required>
        </div>
        <div class="w3-container w3-third">
          <label>Destinatario</label><br>
          <input type="text" name="destinatario" class="w3-input w3-border w3-margin-bottom" required>
        </div>
        <div class="w3-container w3-third">
          <label>Institución</label><br>
          <input type="text" name="inst" required class="w3-input w3-border w3-margin-bottom">
        </div>
        <div class="w3-container w3-third">
          <label>Tema</label><br>
          <input type="text" name="tema" class="w3-input w3-border w3-margin-bottom" required>
        </div>
        <div class="w3-container w3-third">
          <label>Tipo de comunicado</label><br>
          <select name="tipo_comunicado" class="w3-input w3-border w3-margin-bottom" required>
            <option>Seleccionar</option>
            <?php 
            include('conexion.php');
            $obtener = "SELECT * FROM tipocomunicado";
            $respuesta = $mysqli->query($obtener);
            while($fila = $respuesta->fetch_assoc()){
              echo '<option value="'.$fila['IdTipoComunicado'].'">'.$fila['Descripcion'].'</option>';
            }

            ?>
          </select>
        </div>
        <div class="w3-container w3-third">
          <label>Fecha</label><br>
          <input class="w3-input w3-border w3-margin-bottom" type="datetime-local" required name="fecha">
        </div>
        <div class="w3-container w3-third">
          <label>Responsable</label><br>
          <input type="text" name="responsable" required class="w3-input w3-border w3-margin-bottom">
        </div>

        <div class="w3-container w3-third">
          <label>Quien elabora</label><br>
          <input type="text" name="quien_elabora" required class="w3-input w3-border w3-margin-bottom">
        </div>
        <div class="w3-container w3-third">
          <label>Reviso</label><br>
          <input type="text" name="reviso" required class="w3-input w3-border w3-margin-bottom">
        </div>
        <div class="w3-container w3-third">
          <input type="submit" name="enviar" value="Separar" class="w3-button w3-block w3-green w3-section w3-padding">
        </div>
      </form>
    </div>
    <div class="w3-container">
      <h5>Listado de consecutivos</h5>
      <hr>
      <table id="TablaHistorial" class="dataTable display table table-striped table-bordered dt-responsive nowrap w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white" style="width:100%">
        <thead>
            <tr>
                <th>Consecutivo</th>
                <th>Destinatario</th>
                <th>Institución</th>
                <th>Tema</th>
                <th>Fecha</th>
                <th>Comunicado</th>
                <th>Responsable</th>
                <th>Quien elabora</th>
                <th>Revisó</th>
            </tr>
        </thead>
        <tbody>
            <?php 

            $buscar = "SELECT *, T.Descripcion AS Comunicado FROM consecutivos C INNER JOIN tipocomunicado T ON T.IdTipoComunicado = C.id_tipo_comunicado";
            $resultado = $mysqli->query($buscar);
            while($fila = $resultado->fetch_assoc()){?>

            <tr>
              <td><?php echo $fila['numero']; ?></td>
              <td><?php echo $fila['destinatario']; ?></td>
              <td><?php echo $fila['institucion']; ?></td>
              <td><?php echo $fila['tema']; ?></td>
              <td><?php echo $fila['fecha']; ?></td>
              <td><?php echo $fila['Comunicado']; ?></td>
              <td><?php echo $fila['responsable']; ?></td>
              <td><?php echo $fila['quien_elabora']; ?></td>
              <td><?php echo $fila['reviso']; ?></td>
            </tr>

            <?php } ?>
        </tbody>
    </table>

    </div>
    
    <hr>

    <!-- Footer -->
    <footer class="w3-container w3-padding-16 w3-light-grey">
      <p style="text-align: center">© <?php echo date('Y') ?> Todos los derechos reservados a <a href="https://cuentadealtocosto.org/site/" target="_blank">Cuenta de Alto Costo</a></p>
    </footer>

    <!-- End page content -->
  </div>
  <script type="text/javascript">
  $('#TablaHistorial').DataTable({
    scrollX: true
  });
</script>
</body>
</html>
