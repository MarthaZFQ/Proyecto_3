<?php
	session_start();
	if(isset($_SESSION['login'])){
		header("Location: ../login.php");
	}else{
		require("../bdd/conexion.php");
		$nombre=$_POST['user'];
		$mascota=$_POST['mascota'];

		$q="SELECT * FROM usuario WHERE usu_correo='$nombre'";

		$resultado = mysqli_query($conexion, $q);
		
		if(mysqli_num_rows($resultado)>0){
			
			$q="SELECT * FROM usuario WHERE usu_seguridad='$mascota'";
			$resultado = mysqli_query($conexion, $q);

			if (mysqli_num_rows($resultado)>0) {
				$_SESSION['usuario']=$nombre;
				header("Location: newpass.php");
			}else{
				$_SESSION['mensaje']="Esa no es la respuesta de seguridad correcta, inténtelo de nuevo.";
				header("Location: cambiar_pass.php");
			}

		}else{
			$_SESSION['mensaje']="El usuario $nombre no se encuentra en nuestra base de datos, inténtelo de nuevo.";
			header("Location: cambiar_pass.php");
		}
	}
?>
