<!DOCTYPE html>
<html>
<head>
	<title>Login de usuario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/maincss.css">
	<link rel="shortcut icon" href="imagenes/favicon.png"/>
</head>
<body>
	<?php
		session_start();
		if (isset($_SESSION['login'])) {
			header("Location: php/index.php");
		}elseif (isset($_SESSION['error'])) {
			$error=$_SESSION['error'];
			echo "<script>alert('$error');</script>";
			unset($_SESSION['error']);
			session_destroy();
		}elseif (isset($_SESSION['mensaje'])) {
			$mensaje=$_SESSION['mensaje'];
			echo "<script>alert('$mensaje');</script>";
			unset($_SESSION['mensaje']);
			session_destroy();
		}
	?>
	<div class="center">
		<div class="title">
			INICIO DE SESIÓN
		</div>
	    <div class="login">
	    	<br>
			<form method="POST" action="php/login.proc.php">
				<label>E-mail:</label><br><br>
				<input type="text" name="email"><br><br>
				<label>Contraseña:</label><br><br>
				<input type="password" name="password"><br><br>
				<button type="submit">Entrar</button>
			</form>
			<br>
			<a href='php/alta.php'><button type="button">Registro</button></a>
			<br><br>
			<a href='php/cambiar_pass.php'><button type="button">¿Ha olvidado su contraseña?</button></a>
			<br><br>
			<br>
		</div>
	</div>
</body>
</html>