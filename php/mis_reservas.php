<!DOCTYPE html>
<html>
<head>
	<title>Mis reservas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/maincss.css">
	<link rel="shortcut icon" href="../img/favicon.png"/>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  	<script type="text/javascript" src="../js/javascript.js"></script>
  	<script type="text/javascript" src="../js/jquery.js"></script>
  	<script>
  	function myFunction() {
	    var myDiv = document.getElementById('info_back');
	    var myDiv1 = document.getElementById('inform_usuario');
	    myDiv.classList.toggle("hide");
	    myDiv1.classList.toggle("hide");
	}
	function myFunction1() {
	    var histo = document.getElementById('histo_res_back');
	    var histo1 = document.getElementById('histo_res');
	    histo.classList.toggle("hide");
	    histo1.classList.toggle("hide");
	}
	function myFunction2() {
	    var modif = document.getElementById('modif_usu_back');
	    var modif1 = document.getElementById('modif_back');
	    modif.classList.toggle("hide");
	    modif1.classList.toggle("hide");
	}
  	</script>
</head>
<body>
	<header id="main-header">
		
		<li><a href="index.php">Índice</a></li>
		<li><a class="active" href="mis_reservas.php">Mis reservas</a></li>
	  	<li><a href="reportar_incidencia.php">Reportar incidencia</a></li>
	  	<?php
	  	session_start();

	  	if (isset($_SESSION['nivel'])) {
			   	if ($_SESSION['nivel']!="Usuario") {
			   		echo '<li><a href="admin_index.php">Panel de administración</a></li>';
		  		}
		 	}
	  	?>
	  	<div class="submenu">
	    <button type="button" class="dropbtn">
	    	<?php
	    	require("../bdd/conexion.php");

      		mysqli_query($conexion, "SET NAMES 'utf8'");
	    	if (isset($_SESSION['login'])) {
	    		if (isset($_SESSION['mensaje'])) {
				$mensaje=$_SESSION['mensaje'];
				echo "<script>alert('$mensaje')</script>";
				unset($_SESSION['mensaje']);
			}
	    		$usuariologin=$_SESSION['login'];
	    	$q="SELECT * FROM usuario WHERE usu_correo='$usuariologin'";
	    	$sql=mysqli_query($conexion,$q);
	    	$user=mysqli_fetch_array($sql);
	    	echo "$user[usu_nombre] $user[usu_apellido]";
	    	}else{
	    		header("Location: ../login.php");
	    	}
	    	?>
	      	<i id="font_awesome_left" class="fa fa-caret-down"></i>
	    </button>
	    <div class="submenu-content">
	      <a style="cursor:pointer" onclick="myFunction()"><i  id="font_awesome_right" class="fa fa-user-circle-o" aria-hidden="true"></i> Mi perfil</a>
	      <a style="cursor:pointer" onclick="myFunction2()"><i id="font_awesome_right" class="fa fa-pencil" aria-hidden="true"></i> Modificar usuario</a>
	      <a style="cursor:pointer" onclick="myFunction1()"><i id="font_awesome_right" class="fa fa-history" aria-hidden="true"></i> Historial de reservas</a>
	      <?php
			
		  	if (isset($_SESSION['login'])) {
		  	?>
		  	<a href="logout.proc.php"><i id="font_awesome_right" class="fa fa-key" aria-hidden="true"></i> Cerrar sesión</a>
		  	<?php
		  	}else{
		  	?>
		  	<a href="#"><i id="font_awesome_right" class="fa fa-key" aria-hidden="true"></i> Iniciar sesión</a>
		  	<?php
		  	}
		  	?>
	    </div>
	</div>
	  	
	</header>

	
	<!--  div info usuario -->


	<div id="info_back" class="info_usu_back hide">
		<div id="inform_usuario" class="info_usu hide">
			<a style="cursor:pointer" onclick="myFunction()" title="Close" class="close">X</a>
			<?php
			$correologin=$_SESSION['login'];
			$q="SELECT * FROM usuario WHERE usu_correo='$correologin'";
			$sql=mysqli_query($conexion,$q);
			$usuinfo=mysqli_fetch_array($sql);
			echo "<img style='width:130px; border-radius:100px; margin-top:50px;' src='../img/$usuinfo[usu_foto]'><br><br>";
			echo "<p style='font-size:20px'><b>$usuinfo[usu_nombre] $usuinfo[usu_apellido]</b></p>";
			echo "<p>$usuinfo[usu_correo]</p>";
			echo "<p>$usuinfo[usu_nivel]</p>";
			echo "<hr>";
			echo "<p>$usuinfo[usu_direccion]</p>";
			echo "<p>$usuinfo[usu_telf]</p>";
			echo "<p>Reserva más reciente:</p>";
			$idusuario=$usuinfo['usu_id'];
			$q="SELECT * FROM reserva INNER JOIN recurso ON recurso.rec_id=reserva.rec_id WHERE reserva.usu_id='$idusuario' ORDER BY res_fechainicio DESC";
			$sql=mysqli_query($conexion,$q);
			$usureservas=mysqli_fetch_array($sql);
			if (mysqli_num_rows($sql)>0) {
					echo "<p>$usureservas[rec_nombre], reservado el $usureservas[res_fechainicio]</p>";
			}else{
				echo "<br><p style='color: darkgrey'><i>Aún no ha hecho ninguna reserva</i></p>";
			}
			?>
		</div>
	</div>


	<!--  div historial reserva -->


	<div id="histo_res_back" class="info_usu_back hide">
		<div id="histo_res" class="info_usu hide">
			<a style="cursor:pointer" onclick="myFunction1()" title="Close" class="close">X</a>
			<?php
			$correologin=$_SESSION['login'];
			$q="SELECT * FROM usuario WHERE usu_correo='$correologin'";
			$sql=mysqli_query($conexion,$q);
			$usuinfo=mysqli_fetch_array($sql);
			$idusuario=$usuinfo['usu_id'];
			$w="SELECT * FROM reserva INNER JOIN recurso ON reserva.rec_id=recurso.rec_id WHERE usu_id='$idusuario' AND reserva.res_habilitado='0' ORDER BY res_fechainicio DESC";
			$sqq=mysqli_query($conexion,$w);
			if (mysqli_num_rows($sqq)>0) {
				echo "<div style='width:90%; margin:35px'>";
				while($resultado=mysqli_fetch_array($sqq)){
					echo "<p>$resultado[rec_nombre]<br>Reservado el $resultado[res_fechainicio] al $resultado[res_fechadevolucion]</p><br>";
				}
				echo "</div>";
			}else{
				echo "<br><p style='color: darkgrey'><i>Aún no ha hecho ninguna reserva</i></p>";
			}
			
			?>
		</div>
	</div>

	<!--  div modificar usuario -->


	<div id="modif_usu_back" class="info_usu_back hide">
		<div id="modif_back" class="info_usu hide">
			<a style="cursor:pointer" onclick="myFunction2()" title="Close" class="close">X</a>
			<?php
			$correologin=$_SESSION['login'];
			$q="SELECT * FROM usuario WHERE usu_correo='$correologin'";
			$sql=mysqli_query($conexion,$q);
			$usuinfo=mysqli_fetch_array($sql);
			$idusuario=$usuinfo['usu_id'];
			$telf=$usuinfo['usu_telf'];
			$direccion=$usuinfo['usu_direccion'];
			$_SESSION['lugar']="mis_reservas.php";
			echo "<form method='POST' action='cambiar_miusu.proc.php' enctype='multipart/form-data'>";
			echo "<br><br><label>E-mail:</label><br><br>";
			echo "<input type='text' name='email' value='$correologin'><br>";

			?>
			<input type="checkbox" id="check" name="pass_modificar" value="true"><label>Modificar password<label><br>

			<!--El div mod es el que se ocultará y se mostrará cuandos se decida si cambiar el password o dejarlo como está-->
              <div id="mod">
                
                <label>Escriba el nuevo password:</label><br><br>
                <input id="input_pass" type="password" name="password"><br>
              </div>

			<?php
			echo "<label>Teléfono móvil:</label><br><br>";
			echo "<input type='text' name='telf' value='$telf'><br>";
			echo "<label>Dirección:</label><br><br>";
			echo "<input type='text' style='width:300px;'  name='direccion' value='$direccion'><br>";
			?>	

			<input type="checkbox" id="check_input" name="check_files" onchange="valueChanged()">
              <label>Cambiar foto de perfil</label><br>

              <!--Aquí se mostrará el input type file una vez el checkbox haya sido seleccionado:-->
              <span id="span_files"></span>

			<?php
			echo "<input type='submit' name='modificar_miusu'>";
			echo "</form>";
			if ($_SESSION['nivel']=="Usuario") {
				echo "<a href='index.php?baja=true'><button style='margin-left:40px'>Dar de baja</button></a>";
				if (isset($_GET['baja'])) {
					echo "<script>var t=confirm('¿Seguro que quiere darse de baja? Luego no podrá logearse de nuevo hasta que un administrador se lo permita.')
					if(t==true){
						window.location.replace('eliminar_usu.proc.php?des=true');
					}
					</script>";
				}
			}
			
			?>
		</div>
	</div>
	
	<?php
	if (isset($_SESSION['login'])) {
		require("../bdd/conexion.php");
		if (!$conexion) {
			echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		}else{
			mysqli_query($conexion, "SET NAMES 'utf8'");  
			$usuariologeado=$_SESSION['login'];
			$q="SELECT * FROM usuario WHERE usu_correo='$usuariologeado'";
			$sql=mysqli_query($conexion,$q);
			$result=mysqli_fetch_array($sql);
			$usuid=$result['usu_id'];
			echo "<div class='content'>";
			echo "$result[usu_nombre] $result[usu_apellido]";
			echo "<hr>";
			echo "Aquí se muestran las reservas que ha hecho y que tiene lugar hoy y los próximos días.<br><br>Luego se eliminarán una vez se haya sobrepasado la hora actual.<br><br>Al anular una de sus reservas dejará el recurso libre para aquellos que quieran reservarlo.<br><br>También puede cambiar la reserva que haya hecho para otro día u hora distinta.";

			echo "</div>";

			$timezone= +1;
			$ahora=gmdate("H:i:s",time() + 3600*($timezone+date("I")));
			$hoy = date('Y-m-d', time());
			$tiempo="SELECT * FROM reserva INNER JOIN recurso ON reserva.rec_id=recurso.rec_id WHERE reserva.usu_id='$usuid' AND rec_habilitado='0' AND res_habilitado='0' ORDER BY res_fechainicio ASC";
			
			$ejecutar=mysqli_query($conexion,$tiempo);
			echo "<div id='contenido'>";
			if (mysqli_num_rows($ejecutar)>0) {
				while ($consultar=mysqli_fetch_array($ejecutar)) {
					$tiempores=$consultar['res_fechadevolucion'];
					$fin=date("H:i:s",strtotime($tiempores));
					$dia_reserva=date("Y-m-d",strtotime($tiempores));
					$diares=strtotime($dia_reserva);
					$today=strtotime($hoy);
					$final=strtotime($fin);
					$now=strtotime($ahora);
					if ($diares>$today) {
						echo "<br><br>";
						echo "<b>$consultar[rec_nombre]</b><br><br>";
						echo "Fecha de reserva: $consultar[res_fechainicio]<br><br>";
						echo "Fecha de devolución: $consultar[res_fechadevolucion]<br><br>";
						echo "<i>$consultar[rec_descripcion]</i><br><br>";
						$id=$consultar['rec_id'];
						$idres=$consultar['res_id'];
						echo "<form method='POST' action='anular.proc.php'>";
						echo "<input type='hidden' name='idres' value='$idres'>";
						echo "<button type='submit' style='width:150px'><i class='fa fa-eraser' aria-hidden='true'></i> Anular reserva</button>";
						echo "</form><br>";
						echo "<form method='POST' action='modificar_reserva.php'>";
						echo "<input type='hidden' name='idres' value='$idres'>";
						echo "<button type='submit' style='width:150px'><i class='fa fa-wrench' aria-hidden='true'></i> Cambiar reserva</button>";
						echo "</form>";
						$reservaok=true;
					}//fin if
					elseif($diares==$today){
						if ($final>$now) {
							$reservaok=true;
						$idres=$consultar['res_id'];
							echo "<br><br>";
							echo "<b>$consultar[rec_nombre]</b><br><br>";
							echo "Fecha de reserva: $consultar[res_fechainicio]<br><br>";
							echo "Fecha de devolución: $consultar[res_fechadevolucion]<br><br>";
							echo "<i>$consultar[rec_descripcion]</i><br><br>";
							$id=$consultar['rec_id'];
							echo "<form method='POST' action='anular.proc.php'>";
							echo "<input type='hidden' name='idres' value='$idres'>";
							echo "<button type='submit' style='width:150px'><i class='fa fa-eraser' aria-hidden='true'></i> Anular reserva</button>";
							echo "</form><br>";
							echo "<form method='POST' action='modificar_reserva.php'>";
							echo "<input type='hidden' name='idres' value='$idres'>";
							echo "<button type='submit' style='width:150px'><i class='fa fa-wrench' aria-hidden='true'></i> Cambiar reserva</button>";
							echo "</form>";
						}
					}
				}//fin while
			}
				if (!isset($reservaok)) {
					echo "<br><br>Aquí se escribirán sus reservas cuando haga alguna, ya que no tiene ninguna no hay reservas que mostrar.<br><br>";
				}
			
			echo "</div>";
			
		}
	}else{
		header("Location: ../login.php");
	}
	?>
</body>
</html>