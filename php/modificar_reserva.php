<!DOCTYPE html>
<html>
<head>
	<title>Modificar reserva</title>
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
	  	<li><a href="#">Mis incidencias</a></li>
		<li><a class="active" href="mis_reservas.php">Mis reservas</a></li>
	  	<li><a href="reportar_incidencia.php">Reportar incidencia</a></li>
	  	<?php
	    	session_start();
	    	if (isset($_SESSION['mensaje'])) {
	   		$mensaje=$_SESSION['mensaje'];
	   	 	echo "<script>alert('$mensaje')</script>";
	   	 	unset($_SESSION['mensaje']);
	   	 } 
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
			$_SESSION['lugar']="modificar_reserva.php";
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
		?>
		<div id='contenido_mod_res'>
			<br>
			<?php
			require("../bdd/conexion.php");
	   		mysqli_query($conexion, "SET NAMES 'utf8'");  
			$idres=$_POST['idres'];
			$q="SELECT * FROM reserva INNER JOIN recurso ON reserva.rec_id=recurso.rec_id WHERE res_id='$idres' AND res_habilitado='0'";
			$sql=mysqli_query($conexion,$q);
			$timezone=+1;
			$ahora=gmdate("Y/m/j H:i:s",time() + 3600*($timezone+date("I")));
			if (mysqli_num_rows($sql)>0) {
				while ($info=mysqli_fetch_Array($sql)) {
					$valor=$info['rec_nombre'];
					$dia_res=$info['res_fechainicio'];
					$recurso=$info['rec_id'];
				}
			}
			///Segunda busqueda
			$dia_1 = date("Y-m-j", strtotime($dia_res));
			$j="SELECT * FROM reserva INNER JOIN recurso ON reserva.rec_id=recurso.rec_id WHERE reserva.rec_id='$recurso' AND res_habilitado='0' AND (res_fechadevolucion LIKE '%$dia_1%') ORDER BY res_fechainicio ASC";
			$consulta=mysqli_query($conexion,$j);
			$timezone=+1;
			$ahora=gmdate("Y/m/j H:i:s",time() + 3600*($timezone+date("I")));
			if (mysqli_num_rows($consulta)>0) {
				echo "<br><table style='height:290px'>";
				echo "<tr class='tr_res'><th>Recurso</th>";
				echo "<th>Fecha</th>";
				echo "<th>Hora de inicio</th>";
				echo "<th>Hora de devolución</th></tr>";
				while ($result=mysqli_fetch_Array($consulta)) {
					$nombrerecu=$result['rec_nombre'];
					$horafinal=$result['res_fechadevolucion'];
					$fin=date("H:i:s",strtotime($horafinal));
					$f1=strtotime($fin);
					$a1=strtotime($ahora);
					echo "<tr class='tr_res'>";
					echo "<td>$nombrerecu</td>";
					$fecha=$result['res_fechadevolucion'];
					echo "<td>$fecha</td>";
					$horainicio=$result['res_fechainicio'];
					$inicio=date("H:i:s",strtotime($horainicio));
					echo "<td>$inicio</td>";
					echo "<td>$fin</td>";
					echo "</tr>";
				}
			}//fin if mysqli_num_rows
			echo "</table>";
			echo "<form method='POST' action='modificar_res.proc.php'><br><label>Fecha de su reserva:</label><br><br>";
			echo "<input type='text' style='margin-bottom: 0px'  name='dia' value='$dia_res' disabled><br><br>";
			echo "<input type='hidden' name='id_reserva' value='$idres'>";

				$dia=$dia_res;
				$dia = date("j-m-Y", strtotime($dia));
				$timezone= +1;
			    $fecha=gmdate("Y-m-j",time() + 3600*($timezone+date("I")));
				$ahora=gmdate("H:i:s",time() + 3600*($timezone+date("I")));
				$cierre="20:00:00";
				$ahoramismo=strtotime($ahora);
				$cierre_res=strtotime($cierre);
					if ($dia!=$fecha) {
						echo '<label>Hora de inicio:</label>';
						/////////SELECT INI
						echo '<select style="margin-right: 70px" name="fecha_inicio">';
						echo '<option value="08">8:00</option>';
						echo '<option value="09">9:00</option>';
						echo '<option value="10">10:00</option>';
						echo '<option value="11">11:00</option>';
						echo '<option value="12">12:00</option>';
						echo '<option value="13">13:00</option>';
						echo '<option value="14">14:00</option>';
						echo '<option value="15">15:00</option>';
						echo '<option value="16">16:00</option>';
						echo '<option value="17">17:00</option>';
						echo '<option value="18">18:00</option>';
						echo '<option value="19">19:00</option>';
						echo "</select>";
						echo '<label>Hora de devolución:</label>';
						//////////SELECT FIN
						echo '<select name="fecha_final">';
						echo '<option value="09">9:00</option>';
						echo '<option value="10">10:00</option>';
						echo '<option value="11">11:00</option>';
						echo '<option value="12">12:00</option>';
						echo '<option value="13">13:00</option>';
						echo '<option value="14">14:00</option>';
						echo '<option value="15">15:00</option>';
						echo '<option value="16">16:00</option>';
						echo '<option value="17">17:00</option>';
						echo '<option value="18">18:00</option>';
						echo '<option value="19">19:00</option>';
						echo '<option value="20">20:00</option>';
						echo '</select><br><input type="submit" name="Reservar" value="Reservar">';
						echo "<input type='hidden' name='recurso' value='$recurso'>";
						echo "<input type='hidden' name='dia' value='$dia'>";
						echo "</form>";
					}//fin selects que aparecen el dia de hoy y coincide con la busqueda.
					else{
						if ($ahoramismo<$cierre_res) {
						echo '<br><br><form method="POST" action="reservar.proc.php"><label>Hora de inicio:</label>';
						/////////SELECT INI
						echo '<select style="margin-right: 70px" name="fecha_inicio">';
						if ($ahora<"08:00:00") {
							echo '<option value="08">8:00</option>';
						}
						if ($ahora<"09:00:00") {
							echo '<option value="09">9:00</option>';
						}
						if ($ahora<"10:00:00") {
							echo '<option value="10">10:00</option>';
						}
						if ($ahora<"11:00:00") {
							echo '<option value="11">11:00</option>';
						}
						if ($ahora<"12:00:00") {
							echo '<option value="12">12:00</option>';
						}
						if ($ahora<"13:00:00") {
							echo '<option value="13">13:00</option>';
						}
						if ($ahora<"14:00:00") {
							echo '<option value="14">14:00</option>';
						}
						if ($ahora<"15:00:00") {
							echo '<option value="15">15:00</option>';
						}
						if ($ahora<"16:00") {
							echo '<option value="16">16:00</option>';
						}
						if ($ahora<"17:00:00") {
							echo '<option value="17">17:00</option>';
						}
						if ($ahora<"18:00:00") {
							echo '<option value="18">18:00</option>';
						}
						if ($ahora<"19:00:00") {
							echo '<option value="19">19:00</option>';
						}
						echo "</select>";
						echo '<label>Hora de devolución:</label>';
						//////////SELECT FIN
						echo '<select name="fecha_final">';
						if ($ahora<"08:00:00") {
							echo '<option value="09">9:00</option>';
						}
						if ($ahora<"09:00:00") {
							echo '<option value="10">10:00</option>';
						}
						if ($ahora<"10:00:00") {
							echo '<option value="11">11:00</option>';
						}
						if ($ahora<"11:00:00") {
							echo '<option value="12">12:00</option>';
						}
						if ($ahora<"12:00:00") {
							echo '<option value="13">13:00</option>';
						}
						if ($ahora<"13:00:00") {
							echo '<option value="14">14:00</option>';
						}
						if ($ahora<"14:00:00") {
							echo '<option value="15">15:00</option>';
						}
						if ($ahora<"15:00:00") {
							echo '<option value="16">16:00</option>';
						}
						if ($ahora<"16:00") {
							echo '<option value="17">17:00</option>';
						}
						if ($ahora<"17:00:00") {
							echo '<option value="18">18:00</option>';
						}
						if ($ahora<"18:00:00") {
							echo '<option value="19">19:00</option>';
						}
						if ($ahora<"19:00:00") {
							echo '<option value="20">20:00</option>';
						}
						echo '</select><br><button type="submit" name="Reservar">Reservar</button>';
						echo "<input type='hidden' name='recurso' value='$recurso'>";
						echo "<input type='hidden' name='dia' value='$dia'>";
						echo "</form>";
					}//fin selects que aparecen el dia de hoy y coincide con la busqueda.
					}
			?>
		</form>
		<a href='mis_reservas.php'><button type="button">Volver</button></a>
	</div>
		<?php
	}else{
		header("Location: ../login.php");
	}
	?>
</body>
</html>