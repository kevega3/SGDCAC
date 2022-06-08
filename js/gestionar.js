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


function verificarDocumento(){
 var documento = $("#documento").val();
 var data = {
        documento : documento // se tiene una variable json y se agrega lo que le vas a mandar, el nombre y el valor
      };

      $.ajax({
      url:"consultaExiste.php", //colocas la ruta de donde está el archivo php
      type: "post",
      data: data, //Los datos que se van a enviar por el post en este caso documento
      success: function(response){

        var boton = document.getElementById("agregar");
        var campoValidacion = document.getElementById("campoValidacion");
        if(response.trim() == "1"){
         boton.disabled = false; 
        }else{boton.disabled = true;}
     }
   });
}

//Función  crear elemento
function crear_elemento(){

  var radicado = $("#documento").val();
  var btnGuardar = document.getElementById("btnGuardar");
  var boton = document.getElementById("agregar");

  $('#contenedor').append('<li>Radicado: ' + '<input type="text" readonly name="anexo[]" style="background: inherit;border: none;outline: none;" value="'+ radicado +  '">' + ' <a onclick="eliminar_elemento(this);">&times;</a></li>');
  btnGuardar.disabled = false;
  boton.disabled = true;
}

//Función eliminar elemento
function eliminar_elemento(valor){
 valor.parentNode.parentNode.removeChild(valor.parentNode);
}
