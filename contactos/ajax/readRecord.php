<?php
	// include Database connection file 
include("db_connection.php");

	// Design initial table header 
$data = '<table id="TablaHistorial" class="dataTable display table table-striped table-bordered dt-responsive nowrap"  style="width:100%">
<thead>
<tr>
<th>No.</th>
<th>Codigo</th>
<th>Fecha</th>
<th style="width:650px">Observacion</th>
<th></th>
<th></th>
</tr>
</thead>
<tbody>';

$query = "SELECT * FROM matriculaobs";

if (!$result = mysqli_query($con, $query)) {
	exit(mysqli_error($con));
}

    // if query results contains rows then featch those rows 
if(mysqli_num_rows($result) > 0)
{
	$number = 1;
	while($row = mysqli_fetch_assoc($result))
	{
		$data .= '
		
		<tr>
		<td>'.$number.'</td>
		<td>'.$row['codalumno'].'</td>
		<td>'.$row['fecha'].'</td>
		<td>'.$row['obs'].'</td>
		<td>
		<button onclick="GetUserDetails('.$row['idobs'].')" class="btn btn-warning"><i class="fa fa-edit"></i></button>
		</td>
		<td>
		<button onclick="DeleteUser('.$row['idobs'].')" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
		</td>
		</tr>';
		$number++;
	}

}
else
{
    	// records now found 
	$data .= '<tr><td colspan="6">No hay registros!</td></tr>';
}

$data .= '</tbody></table>';

echo $data;
?>