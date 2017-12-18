<!DOCTYPE html>
<html>
<head>
	<title>Crear usuario</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/maincss.css">
	<link rel="shortcut icon" href="../img/favicon.png"/>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  	<script type="text/javascript" src="../js/javascript.js"></script>
  	<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body>
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
			unset($_SESSION['mensaje']);
			session_destroy();
		}
	?>

		<div class="title" style="margin-top:20px; width:50%">
		<h3>Creación de usuario</h3>
		</div>
		<div class="login" style="margin-bottom: 20px; width:50%"><br>
		<form action="alta.proc.php" method="POST" enctype="multipart/form-data">
			<label>Nombre:</label><br><br>
			<input type="text" name="nombre" minlength="3" maxlength="20" required>
			<i title="De entre 3 a 20 carácteres" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i>
			<br>

			<label>Apellido:</label><br><br>
			<input type="text" name="apellido" minlength="4" maxlength="35" required>
			<i title="De entre 4 a 35 carácteres" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i>
			<br>

			<label>E-mail:</label><br><br>
			<input type="text" name="email" minlength="12" maxlength="35" required>
			<i title="De entre 12 a 35 carácteres" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i>
			<br>

			<label>Escriba su contraseña:</label><br><br>
			<input type="password" name="password" minlength="4" maxlength="20" required>
			<i title="De entre 4 a 20 carácteres" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i>
			<br>

			<label>Repita su contraseña:</label><br><br>
			<input type="password" name="password1" required>
			<br>

			<label>Escriba su dirección: (opcional)</label><br><br>
			<input type="text" name="direccion">
			<br>

			<label>Escriba su teléfono: (opcional)</label><br><br>
			<input type="number" name="telf">
			<br>			

			<label>Escriba la respuesta de seguridad:<br><i><b>¿Cómo se llama su primera mascota?</b></i></label><br><br>
			<input type="password" name="mascota" minlength="2" required>
			<i title="Será necesario para cambiar de contraseña (min 2 carácteres)" class="fa fa-question-circle masterTooltip" aria-hidden="true"></i><br>

			<label>Foto de perfil <i>(opcional)</i>:</label><br><br>
			<input type="file" name="usu_foto" accept="image/jpg,image/png,image/jpeg">
			<i title="Sólo formatos jpg, png y .jpeg. Si no elige una foto se le asignará una" class="fa fa-question-circle masterTooltip" aria-hidden="true"></i>
			<br>
			<button id="btn" type="submit" name="submit">Crear <i class="fa fa-user-circle" aria-hidden="true"></i></button>
			<a href="../login.php"><button id="btn" type="button">Volver <i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button></a>
		</form><br><br>
		
	</div>
</body>
</html>