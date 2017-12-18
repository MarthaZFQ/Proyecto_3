<!DOCTYPE html>
<html>
<head>
	<title>Interfaz admin</title>
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
			   		echo '<li><a class="active" href="admin_index.php">Panel de administración</a></li>';
		  		}
		 	}
	  	?>
	  	<div class="submenu">
	    <button type="button" class="dropbtn">
	    	<?php
	    	require("../bdd/conexion.php");
	    	if (isset($_SESSION['login'])) {
	    	mysqli_query($conexion, "SET NAMES 'utf8'");  
	    	$usuariologin=$_SESSION['login'];
	    	$q="SELECT * FROM usuario WHERE usu_correo='$usuariologin'";
	    	$sql=mysqli_query($conexion,$q);
	    	$user=mysqli_fetch_array($sql);
	    	echo "$user[usu_nombre] $user[usu_apellido]";
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
			$_SESSION['lugar']="admin_index.php";
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
	   	mysqli_query($conexion, "SET NAMES 'utf8'");  
	   	if (isset($_SESSION['mensaje'])) {
				$mensaje=$_SESSION['mensaje'];
				echo "<script>alert('$mensaje')</script>";
				unset($_SESSION['mensaje']);
			}
	   	?>
	   		<div class="options">
	
	   			<a id="opt1" href="admin_index.php?opt=1">Modificar usuarios</a>
			   	<a id="opt2" href="admin_index.php?opt=2">Modificar recursos</a>
			   	<a id="opt3" href="admin_index.php?opt=3">Modificar reservas</a>
			   	<a id="opt4" href="admin_index.php?opt=4">Reservas anuladas</a>
			   	<a id="opt4" href="admin_index.php?opt=5">Crear recurso</a>

	   		</div>
	   		<div class="contenido_admin">
	   				<?php
	   				if (isset($_GET['opt'])) {
	   					$opc=$_GET['opt'];
	   					switch ($opc) {
	   						case '1':
	   							$q="SELECT * FROM usuario";
				   				$sql=mysqli_query($conexion,$q);
				   				echo "<center>";
				   				echo "<div id='opciones_right'>";
				   				echo "<table style='margin-bottom:37px'>";
				   				if (mysqli_num_rows($sql)>0) {
					          		echo "<tr>";
					          		echo "<th>Usuario</th>";
					          		echo "<th>Correo</th>";
					          		echo "<th>Nivel</th>";
					          		echo "<th>Estado</th>";
					          		echo "<th>Operaciones</th>";
					          		echo "</tr>";
					          		while ($usuario=mysqli_fetch_array($sql)) {
				   					echo "<tr>";
				   					echo "<td>$usuario[usu_nombre] $usuario[usu_apellido]</td>";
				   					$correousu=$usuario['usu_correo'];
				   					echo "<td>$usuario[usu_correo]</td>";
				   					$nivelusu=$usuario['usu_nivel'];
				   					echo "<td>$usuario[usu_nivel]</td>";
				   					$nivel=$usuario['usu_habilitado'];
				   					if ($nivel==0) {
				   						echo "<td>Habilitado</td>";	
				   					}else{
				   						echo "<td>Deshabilitado</td>";	
				   					}
				   					$idusu=$usuario['usu_id'];
				   					$mail=$_SESSION['login'];
				   					if (($mail==$correousu)||($_SESSION['nivel']=="Administrador" && $nivelusu=="Usuario") ||($_SESSION['nivel']=="Superadministrador" && $nivelusu!="Superadministrador")) {
				   						echo "<td><a class='' href='editar.php?id=$idusu'><button class='same_w'><i class='fa fa-pencil' aria-hidden='true'></i> Editar</button></a>";
				   					}
				   					if ($mail!=$correousu && (($_SESSION['nivel']=="Administrador" && $nivelusu=="Usuario") ||($_SESSION['nivel']=="Superadministrador" && $nivelusu!="Superadministrador"))) {
					   					if ($nivel==0) {
					   						echo "<a class='' href='admin_index.php?target=$idusu&opt=1'><button class='same_w'><i class='fa fa-times fa-lg' aria-hidden='true'></i> Deshabilitar</button></a></td>";
					   					}else{
					   						echo "<a class='' href='admin_index.php?target1=$idusu&opt=1'><button class='same_w'><i class='fa fa-check' aria-hidden='true'></i> Habilitar</button></a></td>";
					   					}
				   					}
				   					if (isset($_GET['target'])) {
				          				$user=$_GET['target'];
				          				$q="SELECT * FROM usuario WHERE usu_id='$user'";
				          				$sql=mysqli_query($conexion,$q);
				          				$resultado=mysqli_fetch_array($sql);
				          				$usunom=$resultado['usu_nombre'];
				          				$usuape= $resultado['usu_apellido'];
				          				$usuariotarget="$usunom $usuape";
				          				$correo=$resultado['usu_correo'];
				          				$_SESSION['objetivo']=$correo;
				          				echo "<script type='text/javascript'> var result = confirm('¿Está seguro/a que quiere deshabilitar al usuario $usuariotarget? Cuando deshabilite a un usuario no será capaz de volver a entrar al servidor.')
										if (result == true) {
										    window.location='deshabilitar.proc.php?ok=true'
										}else{
											window.location='admin_index.php?opt=1'
										}
				          				</script>";
				          				unset($_POST['target']);
				          			}//fin post target
				          			if (isset($_GET['target1'])) {
				          				$user=$_GET['target1'];
				          				$q="SELECT * FROM usuario WHERE usu_id='$user'";
				          				$sql=mysqli_query($conexion,$q);
				          				$resultado=mysqli_fetch_array($sql);
				          				$usunom=$resultado['usu_nombre'];
				          				$usuape= $resultado['usu_apellido'];
				          				$usuariotarget="$usunom $usuape";
				          				$correo=$resultado['usu_correo'];
				          				$_SESSION['objetivo1']=$correo;
				          				echo "<script type='text/javascript'> var result = confirm('¿Está seguro/a que quiere habilitar al usuario $usuariotarget? Al habilitar a un usuario podrá volver a entrar al servidor.')
										if (result == true) {
										    window.location='deshabilitar.proc.php?target=true'
										}else{
											window.location='admin_index.php?opt=1'
										}
				          				</script>";
				          				unset($_POST['target1']);
				          			}//fin post target1
				   					echo "</tr>";
				   				}
				   				}
				   				echo "</table>";
				   				echo "</div>";
				   				echo "</center>";
	   							break;

	   						case '2':
	   							$q="SELECT * FROM recurso";
				   				$consulta=mysqli_query($conexion,$q);
				   				echo "<center>";
				   				echo "<div id='opciones_right'>";
				   				echo "<table style='margin-bottom:40px'>";
				   				if (mysqli_num_rows($consulta)>0) {
					          		echo "<tr>";
					          		echo "<th>Recurso</th>";
					          		echo "<th>Estado</th>";
					          		echo "<th>Incidencias</th>";
					          		echo "<th>Operaciones</th>";
					          		echo "</tr>";
					   				while($result=mysqli_fetch_array($consulta)){
					   					echo "<tr>";
					   					//RECURSO:
					   					echo "<td>$result[rec_nombre]</td>";
					   					//ESTADO:
					   					$estado=$result['rec_habilitado'];
					   					if ($estado==0) {
					   						echo "<td>Habilitado</td>";
					   					}else{
					   						echo "<td>Deshabilitado</td>";
					   					}
					   					//guardamos esta variable para luego:
					   					$deshabilitado=$result['rec_habilitado'];
					   					$recid=$result['rec_id'];
					   					//INCIDENCIA
					   					//ordenamos por desc para coger solo la ultima
					   					$j="SELECT * FROM incidencia INNER JOIN reserva ON incidencia.res_id=reserva.res_id WHERE rec_id='$recid' AND inci_estado='1' ORDER BY inci_fecha_inci DESC";
					   					$inci=mysqli_query($conexion,$j);
					   					if (mysqli_num_rows($inci)>0) {
					   						echo "<td>Con incidencia</td>";
					   					}else{
					   						echo "<td>Sin incidencia</td>";
					   					}
					   					//OPERACIONES
					   					echo "<td>";
					   					//formulario para modificar recurso
					   					echo "<form method='POST' action='modificar_recurso.php'>";
					   					echo "<input type='hidden' name='idrecurso' value='$recid'>";
					   					echo "<button class='same_w' type='submit' name='modificar_recu'><i class='fa fa-pencil' aria-hidden='true'></i> Modificar</button>";
					   					echo "</form>";
					   					//formulario borrar
					   					echo "<form method='POST' action='admin_index.php?opt=2'>";
					   					echo "<input type='hidden' name='idrecurso' value='$recid'>";
					   					if ($deshabilitado=="0") {
					   						echo "<button class='same_w' type='submit' name='eliminar_recu'><i class='fa fa-eraser' aria-hidden='true'></i> Deshabilitar</button>";
					   					}else{
					   						echo "<button class='same_w' type='submit' name='habilitar_recu'><i class='fa fa-undo' aria-hidden='true'></i> Reparado</button>";
					   					}
					   					echo "</td>";
					   					echo "</form>";
					   					
					   					//Confirmacion de que quiere deshabilitar el recurso:
					   					if (isset($_POST['eliminar_recu'])) {
					   						$id_recu=$_POST['idrecurso'];
					   						$busqueda="SELECT * FROM recurso WHERE rec_id='$id_recu'";
					   						$sss=mysqli_query($conexion,$busqueda);
					   						$res=mysqli_fetch_array($sss);
					   						$nombrerecu=$res['rec_nombre'];
					   						$_SESSION['recurso_delete']=$id_recu;
					   						echo "<script>var t= confirm('¿Seguro que quiere deshabilitar el recurso $nombrerecu? Cuando se deshabilite sus reservas quedarán anuladas.')
					   						if(t==true){
					   							window.location.replace('eliminar.proc.php?ok=true');
					   						}
					   						</script>";
					   						unset($_POST['eliminar_recu']);
					   					}
					   					//Confirmacion de que quiere habilitar el recurso:
					   					if (isset($_POST['habilitar_recu'])) {
					   						$id_recu=$_POST['idrecurso'];
					   						$querysql="SELECT * FROM recurso WHERE rec_id='$id_recu'";
					   						$ej_habl=mysqli_query($conexion,$querysql);
					   						$habil=mysqli_fetch_array($ej_habl);
					   						$nombrerecu=$habil['rec_nombre'];
					   						$_SESSION['recurso_habl']=$id_recu;
					   						echo "<script>var t= confirm('¿Seguro que el recurso $nombrerecu está reparado? Cuando se repare el recurso podrá volver a hacerse uso de él.')
					   						if(t==true){
					   							window.location.replace('eliminar.proc.php?habl=true');
					   						}
					   						</script>";
					   						unset($_POST['eliminar_recu']);
					   					}
					   					echo "</td>";
					   					echo "</tr>";
					   				}
				   				}
				   				echo "</table>";
				   				echo "</div>";
				   				echo "</center>";
	   							break;
	   						case '3':
	   						echo "<center>";
				   			echo "<div id='opciones_right'>";
	   						echo "<table style='margin-bottom:40px'>";
	   							$q="SELECT * FROM reserva WHERE res_habilitado='0' ORDER BY res_fechadevolucion DESC";
	   							$query_sql=mysqli_query($conexion, $q);
	   							if (mysqli_num_rows($query_sql)>0) {
	   								echo "<tr>";
	   								echo "<th>Recurso</th>";
					          		echo "<th>Fecha inicio</th>";
					          		echo "<th>Fecha fin</th>";
					          		echo "<th>Reservado por</th>";
					          		echo "<th>Operaciones</th>";
					          		echo "</tr>";
	   								while ($reserva= mysqli_fetch_array($query_sql)) {
	   									echo "<tr>";
	   									$id_res=$reserva['res_id'];
	   									$id_recurso=$reserva['rec_id'];
	   									$const="SELECT * FROM recurso WHERE rec_id='$id_recurso'";
	   									$q_q=mysqli_query($conexion,$const);
	   									if (mysqli_num_rows($q_q)>0) {
	   										while ($rec_info=mysqli_fetch_array($q_q)) {
	   											echo "<td>$rec_info[rec_nombre]</td>";
	   										}
	   									}
	   									echo "<td>$reserva[res_fechainicio]</td>";
	   									$devolucion=$reserva['res_fechadevolucion'];
	   									echo "<td>$devolucion</td>";
	   									$estado_res=$reserva['res_habilitado'];
	   									$usu_reserva=$reserva['usu_id'];
	   									$consulta="SELECT * FROM usuario WHERE usu_id='$usu_reserva'";
	   									$query=mysqli_query($conexion,$consulta);
	   									if (mysqli_num_rows($query)>0) {
	   										while ($info_usuario=mysqli_fetch_array($query)) {
	   											echo "<td>$info_usuario[usu_nombre] $info_usuario[usu_apellido]</td>";
	   										}
	   									}
	   								$timezone= +1;
									$ahora=gmdate("Y-m-j H:i:s",time() + 3600*($timezone+date("I")));
									if ($ahora<$devolucion) {
	   									echo "<td>";
										echo "<form method='POST' action='modificar_res.php'>";
		   								echo "<input type='hidden' name='idreserva' value='$id_res'>";
		   								echo "<button class='same_w' type='submit' name='modif_res'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Modificar</button>";
		   								echo "</form>";
		   								echo "<form method='POST' action='admin_index.php?opt=3'>";
			   							echo "<input type='hidden' name='idreserva' value='$id_res'>";
			   							echo "<button class='same_w' type='submit' name='elim_res'><i class='fa fa-window-close' aria-hidden='true'></i> Deshabilitar</button>";
			   							echo "</form>";
		   								
									}else{
	   									echo "<td style='height:38px;'>";
									}
	   								
	   								echo "</td>";
	   								echo "<tr>";
	   								}
	   								echo "</table>";
	   								if (isset($_POST['elim_res'])) {
	   									$idreserva=$_POST['idreserva'];
	   									$_SESSION['res_id']=$idreserva;
	   									$cons="SELECT * FROM reserva WHERE res_id='$idreserva'";
	   									$eje=mysqli_query($conexion,$cons);
	   									$infores=mysqli_fetch_array($eje);
	   									$iniciof=$infores['res_fechainicio'];
	   									$finf=$infores['res_fechadevolucion'];
	   									echo "<script>var t= confirm('¿Seguro que quiere deshabilitar la reserva hecha del $iniciof al $finf?')
					   						if(t==true){
					   							window.location.replace('eliminar_res.proc.php?habl=true');
					   						}
					   						</script>";
					   					unset($_POST['elim_res']);
	   								}
				   				echo "</div>";
				   				echo "</center>";
	   							}
	   							
	   							break;
	   						case '4':
	   							$q="SELECT * FROM reserva INNER JOIN recurso on reserva.rec_id=recurso.rec_id INNER JOIN usuario ON reserva.usu_id=usuario.usu_id WHERE reserva.res_habilitado='1' ORDER BY reserva.res_fechadevolucion DESC";

	   							$sent=mysqli_query($conexion,$q);
	   							echo "<center>";
					   			echo "<div id='opciones_right'>";
		   						echo "<table style='margin-bottom:37px'>";
		   						if (mysqli_num_rows($sent)>0) {
		   							echo "<tr>";
		   							echo "<th>Recurso</th>";
		   							echo "<th>Estado</th>";
		   							echo "<th>Fecha inicio</th>";
		   							echo "<th>Fecha final</th>";
		   							echo "<th>Reservado por</th>";
		   							echo "</tr>";
		   							while ($res=mysqli_fetch_array($sent)) {
		   								echo "<tr>";
		   								echo "<td>$res[rec_nombre]</td>";
		   								echo "<td>Deshabilitado</td>";
		   								echo "<td>$res[res_fechainicio]</td>";
		   								echo "<td>$res[res_fechadevolucion]</td>";
		   								echo "<td>$res[usu_nombre] $res[usu_apellido]</td>";
		   								echo "</tr>";
		   							}
		   							
		   						}
		   						echo "</table>";
		   						echo "</div>";
		   						echo "</center>";
	   							break;
	   						case '5':
	   							echo "<center>";
					   			echo "<div id='opciones_right'>";
					   			echo "<h4>Creación de recurso</h4>";
	   							echo "<form method='POST' action='crear_recu.php'  enctype='multipart/form-data'>";
	   							echo "<br><label>Nombre del recurso:</label><br><br>";
	   							echo "<input type='text' name='nombre_recu' min-lengh='5' placeholder='Nombre del recurso' required><br>";
	   							echo "<label>Tipo de recurso:</label><br><br>";
	   							echo "<select name='tipo'>";
	   							echo "<option value='Aula de informática'>Aula de informática</option>";
	   							echo "<option value='Aula de teoría'>Aula de teoría</option>";
	   							echo "<option value='Carro de portátiles'>Carro de portátiles</option>";
	   							echo "<option value='Móvil'>Móvil</option>";
	   							echo "<option value='Portátil'>Portátil</option>";
	   							echo "<option value='Proyector'>Proyector</option>";
	   							echo "<option value='Sala'>Sala</option>";
	   							echo "</select><br>";
	   							echo "<label>Descripción del recurso:</label><br><br>";
	   							echo "<textarea class='inci_area' name='descripcion' placeholder='Escriba aquí la descripción del recurso' min-lengh='10' required></textarea><br><br>";
	   							?>
	   							<input type="checkbox" id="check_input" name="check_files" onchange="valueChanged()">
					              <label>Elegir foto del recurso</label>
					              <i title="Puedes elegir una foto o dejar una foto predeterminada" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i><br>

					              <!--Aquí se mostrará el input type file una vez el checkbox haya sido seleccionado:-->
					              <span id="span_files"></span>
	   							<?php
	   							echo "<button type='submit'><i class='fa fa-paper-plane-o' aria-hidden='true'></i> Crear recurso</button>";
	   							echo "</form>";
	   							echo "</div>";
	   							echo "</center>";
	   							break;
	   						default:
	   							echo "<p style='margin-left:20px; margin-right:20px;'><br><br>Bienvenido al panel de administración. Aquí podrá ejercer sus tareas como Administrador/Superadministrador. Seleccione una de las siguientes pestañas situadas a su derecha para poder empezar a administrar.</p>";
	   							break;
	   					}
	   				}else{
	   					echo "<p style='margin-left:20px; margin-right:20px;'><br><br>Bienvenido al panel de administración. Aquí podrá ejercer sus tareas como Administrador/Superadministrador. Seleccione una de las siguientes pestañas situadas a su derecha para poder empezar a administrar.</p>";
	   				}
	   				
	   				?>
	   		</div>
	   	<?php
	}
	?>
</body>
</html>