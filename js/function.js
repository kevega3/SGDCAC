//CONTADOR DE CARACTERES PARA EL TEXTAREA
var limit = 2000;
$(function() {
  $("#textarea").on("input", function () {
        //al cambiar el texto del txt_detalle
        var init = $(this).val().length;
        total_characters = (limit - init);

        $('#contador').html("Carácteres disponibles: "+total_characters);
      });
});

// Validar tipo de archivo
function validar() {
  // Obtener nombre de archivo
  let archivo = document.getElementById('files').value,
  // Obtener extensión del archivo
  extension = archivo.substring(archivo.lastIndexOf('.'),archivo.length);
  // Si la extensión obtenida no está incluida en la lista de valores
  // del atributo "accept", mostrar un error.
  const $miInput = document.querySelector("#files");

  if(document.getElementById('files').getAttribute('accept').split(',').indexOf(extension) < 0) {
    alert('Archivo inválido. No se permite la extensión ' + extension);
    $miInput.value = "";
  }
}
function validar1() {
  // Obtener nombre de archivo
  let archivo = document.getElementById('files1').value,
  // Obtener extensión del archivo
  extension = archivo.substring(archivo.lastIndexOf('.'),archivo.length);
  // Si la extensión obtenida no está incluida en la lista de valores
  // del atributo "accept", mostrar un error.
  const $miInput = document.querySelector("#files1");

  if(document.getElementById('files1').getAttribute('accept').split(',').indexOf(extension) < 0) {
    alert('Archivo inválido. No se permite la extensión ' + extension);
    $miInput.value = "";
  }


}
function validar2() {
  // Obtener nombre de archivo
  let archivo = document.getElementById('files2').value,
  // Obtener extensión del archivo
  extension = archivo.substring(archivo.lastIndexOf('.'),archivo.length);
  // Si la extensión obtenida no está incluida en la lista de valores
  // del atributo "accept", mostrar un error.
  const $miInput = document.querySelector("#files2");

  if(document.getElementById('files2').getAttribute('accept').split(',').indexOf(extension) < 0) {
    alert('Archivo inválido. No se permite la extensión ' + extension);
    $miInput.value = "";
  }
}

function validar_tamanio(archivo){
  var maxfilesize = 5000000,
  filesize = archivo.files[0].size,
  warningarchivo = document.getElementById('lbError');

  if (filesize > maxfilesize) {
    var tamanioEnMb = maxfilesize / 1000000;
    alert(`El tamaño máximo es ${tamanioEnMb} MB`);
    archivo.value = "";
    return false;
  }else{
    return true;
  }
}

function handleFileSelect(evt) { 

 var files = evt.target.files; 
 var output = []; 
 for (var i = 0, f; f = files[i]; i++) { 

   tamano = (f.size/1048576);
   num = tamano.toString();
   enMB = num.substring(0,4);

   output.push('<span style="background: #76c35e;padding: 5px;color: #fff;">', escape(f.name), ' (',
    enMB, ' MB)','</span><br><br>'); 

 } 

 document.getElementById('list').innerHTML = '<div style="text-align: left;">' + output.join('') + '</div>'; 

} 

document.getElementById('files').addEventListener('change', handleFileSelect, false);


      // SELECTS ANIDADOS Y OCULTAMIENTO DE CAMPOS

      $(document).ready(function(){
        $('#tipopersona').val(0);
        recargarLista();

        $('#tipopersona').change(function(){
          recargarLista();
        });
      })
      function recargarLista(){
        $.ajax({
          type:"POST",
          url:"tipodocumento.php",
          data:"tipopersona=" + $('#tipopersona').val(),
          success:function(r){
            $('#tipodocumento').html(r);
          }
        });
      }

      function mostrar(id) {
        if (id == "1") {
          $("#juridica2").hide();
          $("#juridica3").hide();
        }

        if (id == "2") {
          $("#juridica2").show();
          $("#juridica3").show();
        }
      }

      $(document).ready(function(){
        $('#departamento').val(0);
        recargarList();

        $('#departamento').change(function(){
          recargarList();
        });
      })
      function recargarList(){
        $.ajax({
          type:"POST",
          url:"municipios.php",
          data:"departamento=" + $('#departamento').val(),
          success:function(r){
            $('#municipios').html(r);
          }
        });
      }

      $( function() {
        $("#pais").change( function() {
          if ($(this).val() === "42") {
            $("#departamento").prop("hidden", false);
            $("#municipio").prop("hidden", false);
          } else {
            $("#departamento").prop("hidden", true);
            $("#municipio").prop("hidden", true);
          }
        });
      });

      //Función  crear elemento
      var max = 0;
      function crear_elemento(){

        var prueba = $("#files").val();

        if (max <= 1) {
          max++;
          $('#contenedor').append('<li><input type="file" id="files'+max+'" name="archivo[]" onchange="validar'+max+'();validar_tamanio(this);" accept=".png,.pdf,.jpeg,.jpg,.svg" required> <a onclick="eliminar_elemento(this);" class="fa" style="margin-top: -20px;"></a></li>');
        }else{
          alert('Solo se permiten 3 archivos');
        }
      }

      //Función eliminar elemento
      function eliminar_elemento(valor){
        max--;
        valor.parentNode.parentNode.removeChild(valor.parentNode);
      }
      function varios(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8) return true; // 3
        patron =/[A-Za-z\@\s\0-9\ñ\Ñ\á\Á\é\É\í\Í\ó\Ó\ú\Ú,]/; // 4
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
      }
      function validar_texto(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8) return true; // 3
        patron =/[A-Za-z\@\s\ñ\Ñ\á\Á\é\É\í\Í\ó\Ó\ú\Ú,]/; // 4
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
      }

      function solo_numeros(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8) return true; // 3
        patron =/[0-9,]/; // 4
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
      }
      