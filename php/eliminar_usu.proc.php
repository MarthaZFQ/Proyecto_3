<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		if (isset($_SESSION['login'])) {
			if (isset($_GET['des'])) {
				$correo=$_SESSION['login'];
				$q="UPDATE usuario SET usu_habilitado='1' WHERE usu_correo='$correo'";
				$_SESSION['error']='Se ha deshabilitado su usuario correctamente. Tan sólo podrá entrar de nuevo cuando un administrador vuelva a habilitar su usuario.';
				unset($_SESSION['login']);
				header("Location: ../login.php")
			}
		}else{
			header("Location: ../login.php")
		}
	?>
</body>
</html>