// Add Record
function addRecord() {
    // get values
    var idalumno = $("#idalumno").val();
    var codalumno = $("#codalumno").val();
    var codmatri = $("#codmatri").val();
    var obs = $("#obs").val();

    // Add record
    $.post("ajax/addRecord.php", {
        idalumno: idalumno,
        codalumno: codalumno,
        codmatri: codmatri,
        obs: obs
    }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
        readRecords();

        // clear fields from the popup
        $("#idalumno").val("");
        $("#codalumno").val("");
        $("#codmatri").val("");
        $("#obs").val("");
    });
}

// READ records
function readRecords() {
    $.get("ajax/readRecord.php", {}, function (data, status) {
        $("#records_content").html(data);
    });
}


function DeleteUser(id) {
    var conf = confirm("¿Está seguro, realmente desea eliminar el registro?");
    if (conf == true) {
        $.post("ajax/deleteUser.php", {
            id: id
        },
        function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
            );
    }
}

function GetUserDetails(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/readUserDetails.php", {
        id: id
    },
    function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_nombres").val(user.nombres);
            $("#update_apellidos").val(user.apellidos);
            $("#data_ti").val(user.tipoIdentificacion);
            $("#data_ti").html(user.tipoIdent);
            $("#update_identificacion").val(user.identificacion);
            $("#pais").val(user.IdPais);
            $("#pais").html(user.nPais);
            $("#update_cargo").val(user.cargo);
            $("#entidad").val(user.idEntidad);
            $("#entidad").html(user.entidad);
        }
        );

    getCorreos(id);
    getContactos(id);
    getListas(id);
    getEnlaces(id);
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function getCorreos(id) {
   $.get("ajax/readCorreos.php", {id:id}, function (data, status) {
    $("#update_correos").html(data);
});
}

function getContactos(id) {
   $.get("ajax/readContactos.php", {id:id}, function (data, status) {
    $("#update_contactos").html(data);
});
}

function getListas(id) {
   $.get("ajax/readListas.php", {id:id}, function (data, status) {
    $("#update_listas").html(data);
});
}

function getEnlaces(id) {
   $.get("ajax/readEnlaces.php", {id:id}, function (data, status) {
    $("#update_enlaces").html(data);
});
}

function UpdateUserDetails() {
    // get values
    var idalumno = $("#update_idalumno").val();
    var codalumno = $("#update_codalumno").val();
    var obs = $("#update_obs").val();

    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/updateUserDetails.php", {
        id: id,
        idalumno: idalumno,
        codalumno: codalumno,
        obs: obs
    },
    function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            // reload Users by using readRecords();
            readRecords();
        }
        );
}

$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});