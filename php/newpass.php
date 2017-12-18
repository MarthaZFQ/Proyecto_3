<!DOCTYPE html>
<html>
<head>
	<title>Cambiar password</title>
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
			header("Location: index.php");
		}

		if (isset($_SESSION['mensaje'])) {
			$mensaje=$_SESSION['mensaje'];
			echo "<script type='text/javascript'>
			alert('$mensaje')
			</script>";
			unset($_SESSION['mensaje']);
		}
			
	?>
		<div class="title" style="margin-top:80px">
		CAMBIAR CONTRASEÑA
		</div>

	<div class="login">
		<form action="newpass.proc.php" method="POST">
			<?php
				$user=$_SESSION['usuario'];
				echo '<input type="hidden" name="nombre" value="'.$user.'">';
			?><br>
			<label>Escriba su nueva contraseña</label><br><br>
			<input type="password" name="pass" required><br>
			<label>Repita su contraseña</label><br><br>
			<input type="password" name="pass2" required><br>
			<input type="submit" name="Enviar" value="Cambiar contraseña"><br>
			</form>
			<a href="../login.php"><button>Volver al login de usuario</button></a><br><br><br>
	</div>
</body>
</html>