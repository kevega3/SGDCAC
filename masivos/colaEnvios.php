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
<title>Cola de envíos</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="../Fontawesome/css/font-awesome.min.css">
<link href="../Fontawesome/css/all.css" rel="stylesheet">

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
            <a href="verCargados.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Cargados</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <a href="resumen.php?Id=<?php echo $id ?>"><label class="paso-inactivo">Resumen</label></a>
            <i class="fa fa-solid fa-chevron-right" style="margin-left: 15%;"></i>
          </div>
          <div class="w3-col w3-container w3-text-indigo" style="text-align: center; width:20%">
            <label class="paso-activo">Cola de envíos</label>
          </div>

          <div class="w3-container w3-text-indigo " style="margin-top: 7%;">
            <div>
              <table id="tblRequirentes" class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <tr>
                  <th>Destinatario</th>
                  <th>Cargo</th>
                  <th>Entidad</th>
                  <th>Correo</th>
                  <th><input type="checkbox" id="checkBoxAll"></th>
                  <th><button type="button" style="font-weight: 100;padding: 4px 7px;" name="select_email" class="w3-button w3-green email_button" id="select_email" data-action="bulk">Enviar seleccionados</button></th>
                </tr>
                <?php
                $query = "SELECT * FROM `envios` WHERE IdComunicado = '$id' ORDER BY IdDestinatario ASC";
                $statement = $conn->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();

                $count = 0;

                foreach($result as $row){

                  $array = explode(",", $row['correo']);
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

                  if ($row['estadoEnvio'] == 0) {
                      $cssclass = 'w3-blue';
                      $btntext = 'Enviar';
                  }else{
                      $cssclass = 'w3-yellow';
                      $btntext = 'Reenviar';
                  }

                  $count = $count + 1;
                  echo '
                  <tr>
                  <td>'.$row["nombres"].' '.$row["apellidos"].'</td>
                  <td>'.$row["cargo"].'</td>
                  <td>'.$row["entidad"].'</td>
                  <td>'.$selected.'</td>
                  <td>
                  <input type="checkbox" name="single_select" class="single_select" data-email="'.$row["correo"].'" data-name="'.$row["nombres"].'" />
                  </td>
                  <td>
                  <center>
                  <button type="button" style="padding: 4px 7px;" name="email_button" class="w3-button '.$cssclass.' email_button" id="'.$count.'" data-email="'.$row["correo"].'" data-name="'.$row["nombres"].'" data-action="single">'.$btntext.'</button>
                  </center>
                  </td>
                  </tr>
                  ';
                }
                ?>
              </table>
            </div>

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
  $(document).ready(function(){
    $('.email_button').click(function(){
      $(this).attr('disabled', 'disabled');
      var id  = $(this).attr("id");
      var action = $(this).data("action");
      var email_data = [];
      if(action == 'single')
      {
        email_data.push({
          email: $(this).data("email"),
          name: $(this).data("name")
        });
      }
      else
      {
        $('.single_select').each(function(){
          if($(this).prop("checked") == true)
          {
            email_data.push({
              email: $(this).data("email"),
              name: $(this).data('name')
            });
          } 
        });
      }

      $.ajax({
        url:"enviar_mail.php?Id=<?php echo $id; ?>",
        method:"POST",
        data:{email_data:email_data},
        beforeSend:function(){
          $('#'+id).html('Enviando...');
          $('#'+id).addClass('w3-grey');
        },
        success:function(data){
          if(data == 'ok')
          {
            $('#'+id).text('Enviado');
            $('#'+id).removeClass('w3-blue');
            $('#'+id).addClass('w3-grey');
          }
          else
          {
            $('#'+id).text(data);
          }
          $('#'+id).attr('disabled', false);
        }
      })

    });
  });
  $(function() {

    $("#checkBoxAll").on("change", function () {
      $("#tblRequirentes tbody input[type='checkbox'].single_select").prop("checked", this.checked);
    });

  });
</script>
</body>
</html>