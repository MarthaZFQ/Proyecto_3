<!DOCTYPE html>
<html>
<head>
	<title>Modificar usuario</title>
</head>
<body>
	<?php
	session_start();
	if (isset($_SESSION['nivel'])) {
		if ($_SESSION['nivel']!="Usuario") {
			$idtarget=$_GET['id'];
			require("../bdd/conexion.php");
			?>
			<div>
				<form>
					
				</form>
			</div>
			<?php
		}else{
			header("Location: ../login.php");
		}
	}
	?>
</body>
</html>