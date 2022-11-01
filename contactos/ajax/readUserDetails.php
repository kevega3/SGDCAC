<?php
// include Database connection file
include("../../pages/conexion.php");

// check request
if(isset($_POST['id']) && isset($_POST['id']) != "")
{
    // get User ID
    $user_id = $_POST['id'];

    // Get User Details
    $query = "SELECT *, EU.Descripcion AS estadoUsuario, TD.Descripcion AS tipoIdent, PS.Nombre AS nPais, E.Nombre AS entidad 
    FROM persona P 
    LEFT JOIN estadousuario EU ON EU.IdEstado = P.idEstado
    LEFT JOIN tipodocumento TD ON TD.IdTipoDocumento = P.tipoIdentificacion
    LEFT JOIN paises PS ON PS.IdPais = P.pais
    LEFT JOIN entidades E ON E.idEntidad = P.idEntidad 
    WHERE idPersona = '$user_id'";
    
    if (!$result = mysqli_query($mysqli, $query)) {
        exit(mysqli_error($mysqli));
    }

    $response = array();

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response = $row;
        }
    }
    else
    {
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }
    // display JSON data
    echo json_encode($response);
}
else
{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}