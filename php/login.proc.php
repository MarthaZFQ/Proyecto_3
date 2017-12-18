<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	session_start();

	require('../bdd/conexion.php');

	if (!$conexion) {
		echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
	}else{
		$email=$_POST['email'];
		$pass=$_POST['password'];
		$password=md5($pass);
		$q="SELECT * FROM usuario WHERE usu_correo='$email' AND usu_password='$password'";
		echo "$q";
		$sql = mysqli_query($conexion, $q);

		if (mysqli_num_rows($sql)>0) {

			$q="SELECT * FROM usuario WHERE usu_correo='$email' AND usu_password='$password' AND usu_habilitado='0'";
			echo "<br>$q";
			$sql = mysqli_query($conexion, $q);
			if (mysqli_num_rows($sql)>0) {
				$user=mysqli_fetch_array($sql);
				$nivel=$user['usu_nivel'];
				
					$_SESSION['login']=$email;
					$_SESSION['nivel']=$nivel;
					header("Location: index.php");
				
			}else{
				$_SESSION['error']="Su usuario está deshabilitado y no puede acceder. Contacte con su administrador más cercano.";
				header("Location: ../login.php");
			}
		}else{
			$_SESSION['error']="Usuario o contraseña incorrecto.";
			header("Location: ../login.php");
		}
	}

	?>
</body>
</html>