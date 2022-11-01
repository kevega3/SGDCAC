<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Documento con una Capa</title>
	<script src="../js/jquery.min.js"></script>
</head>
<body>
	<form method="POST" action="test1.php" enctype="multipart/form-data">
		<table class="table-form">
			<tr>
				<td style="text-align: left;">Subida de archivos:</td>
				<td><input type="button" value="Agregar campo" onclick="crear_elemento();" style="float: right;"></td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="contenedor">
						<li><input type="file" name="archivo[]" id="files"></li>
					</div>
				</td>
			</tr>
		</table>
		<input type="submit" name="guardar">
	</form>

	<script type="text/javascript">
		var max = 0;
		function crear_elemento(){

			var prueba = $("#files").val();

			if (max <= 1) {
				max++;
				$('#contenedor').append('<li><input type="file" id="files'+max+'" name="archivo[]" required> <a onclick="eliminar_elemento(this);" class="fa" style="margin-top: -20px;"></a></li>');
			}else{
				alert('Solo se permiten 3 archivos');
			}
		}
		function eliminar_elemento(valor){
			max--;
			valor.parentNode.parentNode.removeChild(valor.parentNode);
		}
	</script>
</body>
</html>