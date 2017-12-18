<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>
	<?php
	session_start();
	if(isset($_SESSION['id'])){
		header("location: ../login.php");
	} else {

		require("../bdd/conexion.php");

	    	mysqli_query($conexion, "SET NAMES 'utf8'");  
		$email=$_POST['email'];
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$telf=$_POST['telf'];
		$direccion=$_POST['direccion'];
		$q="SELECT usu_nombre FROM usuario WHERE usu_correo='$email'";

		$sql = mysqli_query($conexion, $q);

		if (mysqli_num_rows($sql)>0) {
			$_SESSION['mensaje']="Este e-mail ya existe, introduzca un e-mail distinto";
			header("Location: alta.php");
		}else{

			$password=$_POST['password'];
			$password1=$_POST['password1'];

			if ($password!=$password1) {
				$_SESSION['mensaje']="Las contraseñas no coinciden, pruebe otra vez";
				header("Location: alta.php");
			}else{

				
				if ($_FILES['usu_foto']['name']!="") {
					$img=$_FILES['usu_foto']['name'];

					$original=$img;
					$q="SELECT usu_foto FROM usuario WHERE usu_foto='$img'";
					$sql = mysqli_query($conexion, $q);

					//Ya que subir una imagen con el mismo nombre a la bdd se sobreescribe, le añadimos un número en un while para que no haya errores
					if (mysqli_num_rows($sql)>0) {
						$contador=0;
						$ok=false;
						while ($ok==false) {
							$img=$original;
							$contador=$contador+1;
							$img=$contador.$img;
							$q="SELECT usu_foto FROM usuario WHERE usu_foto='$img'";
							$sql = mysqli_query($conexion, $q);

							if (mysqli_num_rows($sql)==0) {
								$ok=true;
							}
						}
						
					}

					$password=md5($password);

					$mascota=$_POST['mascota'];

					$a="INSERT INTO usuario(usu_nombre,usu_apellido,usu_correo,usu_password,usu_seguridad,usu_nivel,usu_habilitado,usu_foto,usu_direccion,usu_telf) VALUES ('$nombre','$apellido','$email','$password','$mascota','Usuario','0', '$img','$direccion','$telf')";
					echo "$a";
					mysqli_query($conexion,$a);
					
					if(isset($ok)){
						$temp = explode(".", $_FILES["usu_foto"]["name"]);
						$newfilename = $img;
						move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $newfilename);
					}else{
						move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $img);
					}

					$_SESSION['error']="Se ha creado su usuario con éxito";
					header("Location: ../login.php");



				}else{
						
					$password=md5($password);

					$mascota=$_POST['mascota'];

					$q="INSERT INTO usuario(usu_nombre,usu_apellido,usu_correo,usu_password,usu_seguridad,usu_nivel,usu_habilitado,usu_foto,usu_direccion,usu_telf) VALUES ('$nombre', '$apellido','$email','$password','mascota','Usuario','0', 'defecto.png','$direccion','$telf')";
					echo "$q";
					mysqli_query($conexion,$q);

					$_SESSION['error']="Se ha creado su usuario con éxito";
					header("Location: ../login.php");

				}
				

			}//fin del else que comprueba que tus passwords coinciden

			

		}//fin else que comprueba si el usuario ya existe
		
	}//fin del else que comprueba que no estás ya logeado
?>
</body>
</html>

