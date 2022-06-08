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
const btn=document.querySelector('input[type=submit]');

document.querySelector('form').addEventListener('change',function(ev){
  if(ev.target.type=='file'){
  // I collect the inps here to allow for dynamic pages (varying number of inputs):
  const inps=[...document.querySelectorAll('input[type=file]')];
  btn.disabled=inps.some(inp=>{ // check whether the condition has been violated at least once
    if (inp.files.length>inp.dataset.max){ // show warning for first violation
      alert("Solo se pueden adjuntar máximo 3 archivos.");
      return true;
    }
  })
}
})

        // CODIGO PARA LA SUBIDA DE ARCHIVOS
      const MAXIMO_TAMANIO_BYTES = 5000000; // 1MB = 1 millón de bytes

      // Obtener referencia al elemento
      const $miInput = document.querySelector("#files");

      $miInput.addEventListener("change", function () {
        // si no hay archivos, regresamos
        if (this.files.length <= 0) return;

        // Validamos el primer archivo únipcamente
        const archivo = this.files[0];
        if (archivo.size > MAXIMO_TAMANIO_BYTES) {
          const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
          alert(`El tamaño máximo es ${tamanioEnMb} MB`);
          // Limpiar
          $miInput.value = "";
        } else {
          // Validación pasada. Envía el formulario o haz lo que tengas que hacer
        }
      });

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