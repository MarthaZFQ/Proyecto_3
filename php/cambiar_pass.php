<?php
	session_start();
	if(isset($_SESSION['login'])){
		header("location: ../login.php");
	}
	if (isset($_SESSION['mensaje'])) {
		$mensaje=$_SESSION['mensaje'];
		echo "<script type='text/javascript'>
		alert('$mensaje')
		</script>";
		session_destroy();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cambiar de contraseña</title>
		<link rel="stylesheet" href="../css/maincss.css">
		<link rel="shortcut icon" href="../img/favicon.png"/>
	  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	  	<script type="text/javascript" src="../js/javascript.js"></script>
	  	<script type="text/javascript" src="../js/jquery.js"></script>
	</head>
	<body>
		
		<div class="title" style="margin-top:80px;">
			CAMBIAR CONTRASEÑA
		</div>
		<div class="login">
		<br>
		<form  action="pass.proc.php" method="POST">
			<label>Introduzca su e-mail:</label><br><br>
			<input type="text" name="user" size="25" required/><br/><br/>
			<label>Introduzca la respuesta a la pregunta de seguridad:<br><br><i><b>¿Cuál es el nombre de su primera mascota?</b></i></label><br><br>
			<input type="password" name="mascota" size="25" required/><br/><br/>
			<input type="submit" value="Cambiar contraseña"/><br><br>
			<a href="../login.php"><button type='button'>Volver al inicio de sesión</button></a><br>
		</form><br><br>
	</div>
	</body>
</html>