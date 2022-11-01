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
<title>Cargados</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
            <a href="destinatarios.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Destinatarios</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <label class="paso-activo">Cargados</label>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="resumen.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Resumen</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="colaEnvios.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Cola de envíos</label></a>
          </div>

          <div class="w3-container w3-text-indigo " style="margin-top: 7%;">
           <?php
           $sql = "SELECT * FROM `envios` WHERE IdComunicado = '$id' ORDER BY IdDestinatario ASC";
           $consulta = mysqli_query($mysqli, $sql);
           $cantidad = $consulta->num_rows;
           if($cantidad === 0) {
            echo "No hay resultados";
          } else {
            ?>
            <div id="status" class="w3-pale-green" style="display:none; padding: 10px; margin-bottom: 1%;"></div>      
            <table id="TablaHistorial" class="dataTable display table table-striped table-bordered dt-responsive nowrap w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white" style="width:100%">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Nombres</th>
                  <th scope="col">Apellidos</th>
                  <th scope="col">Cargo</th>
                  <th scope="col">Entidad</th>
                  <th scope="col">Regimen</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Trato1</th>
                  <th scope="col">Trato2</th>
                  <th scope="col"><a href="borrarDestinatario.php?comunicado=<?php echo $id; ?>"><i class="fa"></i> Borrar todos</a></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $rownumber=0;
                while($rowedit = mysqli_fetch_array($consulta)){
                  $rownumber++;
                  $nom = $rowedit["nombres"];
                  $ape = $rowedit["apellidos"];
                  $ciu = $rowedit["cargo"];
                  $cel = $rowedit["entidad"];
                  $mail = $rowedit["correo"];
                  $idD = $rowedit["IdDestinatario"];
                  $trato1 = $rowedit["trato1"];
                  $trato2 = $rowedit["trato2"];
                  $regimen = $rowedit["regimen"];
                  ?>
                  <tr>
                    <td id="nombres:<?php echo $idD; ?>" contenteditable="true"><?php echo $nom; ?></td>
                    <td id="Apellidos:<?php echo $idD; ?>" contenteditable="true"><?php echo $ape; ?></td>
                    <td id="Cargo:<?php echo $idD; ?>" contenteditable="true"><?php echo $ciu; ?></td>
                    <td id="Entidad:<?php echo $idD; ?>" contenteditable="true"><?php echo $cel; ?></td>
                    <td id="Regimen:<?php echo $idD; ?>" contenteditable="true"><?php echo $regimen; ?></td>
                    <td id="Correo:<?php echo $idD; ?>" contenteditable="true">                    
                      <?php
                      $array = explode(",", $mail);
                      if (is_array($array)) {
                        $selected = '';
                        $num_pat = count($array);
                        $current = 0;
                        foreach ($array as $key => $value) {
                          if ($current != $num_pat-1){
                            $selected .= $value.', ';
                          }else{
                            $selected .= $value;
                          }
                          $current++;
                        }
                      }else{
                        $selected = '';
                      }
                      echo $selected;
                      ?>
                    </td>
                    <td id="Trato1:<?php echo $idD; ?>" contenteditable="true"><?php echo $trato1; ?></td>
                    <td id="Trato2:<?php echo $idD; ?>" contenteditable="true"><?php echo $trato2; ?></td>
                    <td style="text-align:center;color: red;"><a href="borrarDestinatario.php?Id=<?php echo $idD ?>&&comunicado=<?php echo $id; ?>" title="Eliminar destinatario"><i class="fa"></i></a></td>
                  </tr>
                  <?php
                }
                ?>    
              </tbody>
            </table>
          <?php }?>
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
<script type="text/javascript">
  $(function(){
  //Mensaje
  var message_status = $("#status");
  $("td[contenteditable=true]").blur(function(){
    var rownumber = $(this).attr("id");
    var value = $(this).text();
    $.post('proceso.php' , rownumber + "=" + value, function(data){
      if(data != '')
      {
        message_status.show();
        message_status.html(data);
        //hide the message
        setTimeout(function(){message_status.html("REGISTRO ACTUALIZADO CORRECTAMENTE");},2000);
      } else {
        //message_status().html = data;
      }
    });
  });
});
</script>
<script type="text/javascript">
  $('#TablaHistorial').DataTable({
    scrollX: true
  });
</script>
</body>
</html>
