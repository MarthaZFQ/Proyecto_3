<!DOCTYPE html>
<html>
<head>
	<title>Modificar recurso</title>
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
	if (isset($_SESSION['nivel'])) {
		if ($_SESSION['nivel']!="Usuario") {
		echo "<div class='modify'>";
			if (isset($_POST['idrecurso'])) {
				?>
				<form method='POST' action="modificar_recurso.proc.php" enctype="multipart/form-data">
					<label>Nombre del recurso:</label><br><br>
					<?php
					require("../bdd/conexion.php");
	   				mysqli_query($conexion, "SET NAMES 'utf8'");
	   				$idrecurso=$_POST['idrecurso'];
	   				$q="SELECT * FROM recurso WHERE rec_id=$idrecurso";
	   				$sql=mysqli_query($conexion,$q);
	   				$recurso=mysqli_fetch_array($sql);
	   				$nombre=$recurso['rec_nombre'];
	   				$id=$recurso['rec_id'];
	   				$descripcion=$recurso['rec_descripcion'];
	   				echo "<input type='hidden' name='id' value='$id' required>";
					echo "<input type='text' name='nombre_recurso' value='$nombre' required><br>";
					echo "<label>Descripción del recurso:</label><br><br>";
					echo "<textarea name='descripcion' style='resize: none; width:400px; height:150px' required>$descripcion</textarea><br><br>";
					?>
					<input type="checkbox" id="check_input" name="check_files" onchange="valueChanged()">
	              	<label>Cambiar foto:</label>
	              	<i title="Puedes elegir cambiar del recurso o dejarla como está" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i><br>

	              	<!--Aquí se mostrará el input type file una vez el checkbox haya sido seleccionado:-->
	              	<span id="span_files"></span>
	              	<button type="submit" class="same_w" name='Enviar'>Cambiar <i class="fa fa-check-circle" aria-hidden="true"></i></button>
	              	<a href="admin_index.php?opt=2"><button class="same_w" type="button">Volver <i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button></a><br>
		            </form>
		          
				<?php
			}//fin if get
		}else{
			header("Location: ../login.php");
		}
	}else{
		header("Location: ../login.php");
	}
	
	?>
	</div>
</body>
</html>