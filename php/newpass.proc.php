<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		session_start();
		if(isset($_SESSION['login'])){
			header("Location: index.php");
		}else{
			require("../bdd/conexion.php");

			$nombre=$_POST['nombre'];
			$pass1=$_POST['pass'];
			$pass2=$_POST['pass2'];
			
			if ($pass1==$pass2) {
				$pass=md5($pass1);
				$q="UPDATE usuario SET usu_password='$pass' WHERE usu_correo='$nombre'";
				$resultado = mysqli_query($conexion, $q);
				$_SESSION['mensaje']="Se ha cambiado su contraseña satisfactoriamente.";
				header("Location: ../login.php");
			}else{
				$_SESSION['mensaje']="Se ha equivocado al introducir las contraseñas, inténtelo de nuevo.";
				header("Location: newpass.php");
			}

		}
	?>
</body>
</html>