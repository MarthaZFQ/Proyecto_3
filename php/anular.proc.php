<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	session_start();
	if (isset($_SESSION['login'])) {
		if (isset($_POST['idres'])) {
			require("../bdd/conexion.php");
			$reservaid=$_POST['idres'];
			$q="UPDATE reserva SET res_habilitado='1' WHERE res_id='$reservaid'";
			echo "$q";
			mysqli_query($conexion,$q);
			header("Location: mis_reservas.php");
		}else{
			header("Location: index.php");
		}
	}else{
		header("Location: index.php");
	}
	?>
</body>
</html>