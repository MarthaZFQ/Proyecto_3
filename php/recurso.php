<!DOCTYPE html>
<html>
<head>
	<title>Información del recurso</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../css/maincss.css">
	<link rel="shortcut icon" href="../img/favicon.png"/>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<script>
  		$.datepicker.regional['es'] = {
			 closeText: 'Cerrar',
			 prevText: '< Ant',
			 nextText: 'Sig >',
			 currentText: 'Hoy',
			 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			 weekHeader: 'Sm',
			 dateFormat: 'yy-mm-dd',
			 firstDay: 1,
			 isRTL: false,
			 showMonthAfterYear: false,
			 yearSuffix: ''
			 };
			 $.datepicker.setDefaults($.datepicker.regional['es']);
			$(function () {
			$("#fecha").datepicker();
			});
  	</script>
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
		<li><a href="mis_reservas.php">Mis reservas</a></li>
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
	    	$usuid=$user['usu_id'];
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
			if (isset($_SESSION['mensaje'])) {
				$mensaje=$_SESSION['mensaje'];
				echo "<script>alert('$mensaje')</script>";
				unset($_SESSION['mensaje']);
			}
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
			$_SESSION['lugar']="index.php";
			
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

	<div id="recurso">
		<?php


		if (!$conexion) {
			echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        	echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        	echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		}else{
			mysqli_query($conexion, "SET NAMES 'utf8'"); 
			if(isset($_GET['recurso'])){
				$recurso=$_GET['recurso'];
				$q="SELECT * FROM recurso WHERE rec_id='$recurso'";
				$consulta=mysqli_query($conexion,$q);
				$resultado=mysqli_fetch_array($consulta);
				$nombrerecu=$resultado['rec_nombre'];
				$habilitado=$resultado['rec_habilitado'];
				$descr=$resultado['rec_descripcion'];
				echo "<div class='text'>";
				$timezone= +1;

				if (isset($_GET['fecha_enviar'])) {
					$dias=$_GET['fecha_enviar'];
				}else{
					$dias=gmdate("j/m/Y",time() + 3600*($timezone+date("I")));
				}//fin if

				echo "<h3 class='h3_res'>Mostrando reservas de '$nombrerecu' el $dias</h3>";
				echo "<p style='color:grey'><i>$descr</i></p>";
			    $ahora=gmdate("Y/m/j H:i:s",time() + 3600*($timezone+date("I")));

			    if (isset($_GET['fecha_enviar'])) {
			    	$fecha=$_GET['fecha_enviar'];
					$partir = strtr($_GET['fecha_enviar'], '/', '-');
					$ahora1= date('Y-m-d', strtotime($partir));
			    }else{
			    	$fecha=gmdate("Y-m-d",time() + 3600*($timezone+date("I")));
					$ahora1=gmdate("Y-m-d",time() + 3600*($timezone+date("I")));
			    }

				$j="SELECT * FROM reserva INNER JOIN recurso ON recurso.rec_id=recurso.rec_id WHERE recurso.rec_id='6' AND (reserva.res_fechainicio LIKE '%2017-12-30%' OR reserva.res_fechadevolucion LIKE '%2017-12-30%') AND recurso.rec_habilitado='0' AND reserva.res_habilitado='0' ORDER BY reserva.res_fechainicio ASC";
				$consulta=mysqli_query($conexion,$j);
				if (mysqli_num_rows($consulta)>0) {
					echo "<table style='max-height:255px'>";
					echo "<tr class='tr_res'><th>Recurso</th>";
					echo "<th>Fecha</th>";
					echo "<th>Hora de inicio</th>";
					echo "<th>Hora de devolución</th></tr>";
					while ($resultado=mysqli_fetch_array($consulta)) {
						$horafinal=$resultado['res_fechadevolucion'];
						$fin=date("H:i:s",strtotime($horafinal));
						$f1=strtotime($fin);
						$a1=strtotime($ahora);
						echo "<tr class='tr_res'>";
						echo "<td>$nombrerecu</td>";
						echo "<td>$ahora1</td>";
						$horainicio=$resultado['res_fechainicio'];
						$inicio=date("H:i:s",strtotime($horainicio));
						echo "<td>$inicio</td>";
						echo "<td>$fin</td>";
						
					}//fin while
				}else{
					echo "<table style='height:107px; max-height: 255px'>";
					echo "<tr>";
					echo "<td><br>No hay reservas que mostrar<br><br></td>";
				}//fin mysqli_num_rows

				echo "</tr>";
				echo "</table>";

				if (isset($_GET['fecha_enviar'])) {
					$dia=$_GET['fecha_enviar'];
				}else{

					$dia=gmdate("j/m/Y",time() + 3600*($timezone+date("I")));
				}//fin else

				$ahora=gmdate("H:i:s",time() + 3600*($timezone+date("I")));
				$cierre="20:00:00";
				$ahoramismo=strtotime($ahora);
				$cierre_res=strtotime($cierre);
				if ($fecha!=$dia && $habilitado=="0") {
					if ($ahoramismo>$cierre_res && $habilitado=="0") {
						echo '<br><br><form method="POST" action="reservar.proc.php"><label>Hora de inicio:</label>';
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
						echo '</select><br><input type="submit" name="Reservar" value=Reservar>';
						echo "<input type='hidden' name='recurso' value='$recurso'>";
						echo "<input type='hidden' name='dia' value='$dia'>";
						echo "</form>";
					}//fin selects que aparecen el dia de hoy y coincide con la busqueda.
				}elseif ($habilitado=="0") {
					
					///SI LA FECHA DE HOY NO ES LA DE LA BUSQUEDA EN EL DATEPICKER
					echo '<br><br><form method="POST" action="reservar.proc.php"><label>Hora de inicio:</label>';
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
						echo '</select><br><input type="submit" name="Reservar" value=Reservar>';
						echo "<input type='hidden' name='recurso' value='$recurso'>";
						echo "<input type='hidden' name='dia' value='$dia'>";
						echo "</form>";
				}//finelseif
						
				echo "</div>";
				echo "<form method='POST' id='formulario' action='recurso.php'>";
				echo "<input id='fecha_visible' type='hidden' name='fecha_visible' disabled>";
				echo "<input id='fecha_enviar' type='hidden' name='fecha_enviar'><br>";
				echo "<input type='hidden' name='idrecu' value='$recurso'><br>";
				echo "</form>";
				echo "<div style='float:right; margin-right:4%' id='datepicker'></div>";

	/////////////////////////AL HACER TÚ UNA BÚSQUEDA SE MUESTRA LO SIGUIENTE

			}elseif(isset($_POST['idrecu'])){
				$recurso=$_POST['idrecu'];
				$q="SELECT * FROM recurso WHERE rec_id='$recurso'";
				$dia=$_POST['fecha_enviar'];
				$consulta=mysqli_query($conexion,$q);
				$resultado=mysqli_fetch_array($consulta);
				$habilitado=$resultado['rec_habilitado'];
				$nombrerecu=$resultado['rec_nombre'];
				$descr=$resultado['rec_descripcion'];
				echo "<div class='text'>";
				$timezone= +1;
			    $dias=gmdate("j/m/Y",time() + 3600*($timezone+date("I")));
			    $originalDate = $dia;
				$newDate = date("j/m/Y", strtotime($originalDate));
				$ahora=gmdate("Y/m/j H:i:s",time() + 3600*($timezone+date("I")));


			    $fecha=gmdate("Y-m-j",time() + 3600*($timezone+date("I")));
				$j="SELECT * FROM reserva INNER JOIN recurso ON recurso.rec_id=recurso.rec_id WHERE recurso.rec_id='$recurso' AND (reserva.res_fechainicio LIKE '%$dia%' OR reserva.res_fechadevolucion LIKE '%$dia%') AND recurso.rec_habilitado='0' AND reserva.res_habilitado='0' ORDER BY reserva.res_fechainicio ASC";
			    $ahora=gmdate("H:i:s",time() + 3600*($timezone+date("I")));
				$consulta=mysqli_query($conexion,$j);

				echo "<h3 class='h3_res'>Mostrando reservas de '$nombrerecu' el $newDate</h3>";	
				echo "<i><p style='color:grey'>$descr</p></i><br>";

				
				if (mysqli_num_rows($consulta)>0) {
					echo "<table style='max-height:255px'>";
					echo "<tr class='tr_res'><th>Recurso</th>";
					echo "<th>Fecha</th>";
					echo "<th>Hora de inicio</th>";
					echo "<th>Hora de devolución</th></tr>";
					while ($resultado=mysqli_fetch_array($consulta)) {
						$horafinal=$resultado['res_fechadevolucion'];
						$fin=date("H:i:s",strtotime($horafinal));
						//comparamos si la fecha que busca coincide con la hora. Si es así nos centraremos en
						//las horas 
						if ($fecha==$dia) {
							$f1=strtotime($fin);
							$a1=strtotime($ahora);
							echo "<tr class='tr_res'>";
							echo "<td>$nombrerecu</td>";
							echo "<td>$dia</td>";
							$horainicio=$resultado['res_fechainicio'];
							$inicio=date("H:i:s",strtotime($horainicio));
							echo "<td>$inicio</td>";
							echo "<td>$fin</td>";
							echo "<tr>";
							echo "<td><br>No hay reservas que mostrar<br><br></td>";
							
						}//fin else que comprueba si se trata del mismo dia
						else{
								echo "<tr class='tr_res'>";
								echo "<td>$nombrerecu</td>";
								echo "<td>$dia</td>";
								$horainicio=$resultado['res_fechainicio'];
								$inicio=date("H:i:s",strtotime($horainicio));
								echo "<td>$inicio</td>";
								echo "<td>$fin</td>";
						}//fin else
						
					}//fin while
					
				}else{
					echo "<table style='height:107px; max-height: 255px'>";
					echo "<tr>";
					echo "<td><br>No hay reservas que mostrar<br><br></td>";
				}//fin mysqli_num_rows

				echo "</tr>";
				echo "</table>";

				//////////////////////////SELECT//////////////////////
				
				$ahora=gmdate("H:i:s",time() + 3600*($timezone+date("I")));
				$cierre="20:00:00";
				$ahoramismo=strtotime($ahora);
				$cierre_res=strtotime($cierre);
				if ($fecha==$dia && $habilitado=="0") {
					if ($ahoramismo>$cierre_res && $habilitado=="0") {
						echo '<br><br><form method="POST" action="reservar.proc.php"><label>Hora de inicio:</label>';
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
						echo '</select><br><input type="submit" name="Reservar" value=Reservar>';
						echo "<input type='hidden' name='recurso' value='$recurso'>";
						echo "<input type='hidden' name='dia' value='$dia'>";
						echo "</form>";
					}//fin selects que aparecen el dia de hoy y coincide con la busqueda.
				}elseif($habilitado=="0"){
					///SI LA FECHA DE HOY NO ES LA DE LA BUSQUEDA EN EL DATEPICKER
					echo '<br><br><form method="POST" action="reservar.proc.php"><label>Hora de inicio:</label>';
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
						echo '</select><br><input type="submit" name="Reservar" value=Reservar>';
						echo "<input type='hidden' name='recurso' value='$recurso'>";
						echo "<input type='hidden' name='dia' value='$dia'>";
						echo "</form>";
				}

				}else{
					echo "<table style='height:107px; max-height: 255px'>";
					echo "<tr>";
					echo "<td><br>No hay reservas que mostrar<br><br></td>";
					echo "</tr></table>";
				}
				echo "</div>";
				echo "<form method='POST' id='formulario' action='recurso.php'>";
				echo "<input id='fecha_visible' type='hidden' name='fecha_visible' disabled>";
				echo "<input id='fecha_enviar' type='hidden' name='fecha_enviar'><br>";
				echo "<input type='hidden' name='idrecu' value='$recurso'><br>";
				echo "</form>";
				echo "<div style='float:right; margin-right:4%' id='datepicker'></div>";

			}
			
		

		?>
	</div>
	 <script>

		document.getElementById('datepicker').onchange = function(){
			document.getElementById('formulario').submit();
		};

  		$(document).ready(function() {
  			$("#datepicker").datepicker();
  		});
	 	var date = new Date();
	  	$("#datepicker").datepicker({
	  		minDate: date
	  	});

	  	$("#datepicker").change(function(){
	  		$("#fecha_visible").attr('value', $(this).val());
	  		$("#fecha_enviar").attr('value', $(this).val());
	  	});

	  	$("#fecha_visible").change(function(){
	  		$("#datepicker").datepicker("setDate",$(this).val());

	  	});
  	</script>
</body>
</html>