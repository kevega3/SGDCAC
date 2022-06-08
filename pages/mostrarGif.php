<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<link rel="stylesheet" type="text/css" href="../styles/w3.css">
</head>
<body>
	<div class="loader">
		<img src="../images/loader.gif" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
	</div>

	<form action="reasignarPeticion.php" method="POST" id="reg">
		<input type="submit" name="">
	</form>
</body>
<script type="text/javascript">
	let theForm = document.querySelector("#reg");

	theForm.addEventListener("submit", function(){
		let loader = document.querySelector(".loader");

		loader.classList.add("active");
	}, false);
</script>
</html>