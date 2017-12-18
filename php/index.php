<!DOCTYPE html>
<html>
<head>
	<title>Página principal</title>
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
		
		<li><a class="active" href="index.php">Índice</a></li>
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
	    	if (isset($_SESSION['login'])) {
	    	mysqli_query($conexion, "SET NAMES 'utf8'");  
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

	<?php
	if (isset($_SESSION['error'])) {
		$error=$_SESSION['error'];
		echo "<script>alert('$error');</script>";
		unset($_SESSION['error']);
		session_destroy();
	}

	if (isset($_SESSION['login'])) {
		
		if (!$conexion) {
			echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        	echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        	echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		}else{

	        mysqli_query($conexion, "SET NAMES 'utf8'");  

	        ////////////////////////// FILTRO ////////////////////////////////

	        $q = "SELECT DISTINCT(rec_tipo) from recurso ORDER BY rec_tipo";
	        $resultados = mysqli_query($conexion, $q);
	        if(mysqli_num_rows($resultados)>0){
	        	?>
	        	<div class="content">
	        		<br>
	          	<form action='index.php' method='POST'>
	          	<label>Busqueda por tipo </label><br>
	          	<hr>
	          	<label>Tipo de recurso<label><br><br>
	          	<select name=tipo id='tipo'>
	          	<option>Cualquiera</option>
	          	<?php
	          while ($tipo=mysqli_fetch_array($resultados)){
	          //Creamos la variable opciones para distinguir la sala de teoría y las salas del resto y así poder trabajar con sus ids en javascript
	            $opciones=$tipo['rec_tipo'];
	            if($opciones=="Aula de teoría"){
	              echo "<option value='teoria'>$tipo[rec_tipo]</option>";
	            }elseif($opciones=="Sala"){
	              echo "<option value='sala'>$tipo[rec_tipo]</option>";
	            }else{
	              echo "<option>$tipo[rec_tipo]</option>";
	            }
	          }//fin del while de mysqli_fetch_array($resultados)
	          echo "</select><br><br>";
	        }
	        ?>
	        <!--Creamos este span donde se mostrará otro select en caso en el que se haya elegido las opciones de "sala de teoría" o "sala"-->
	        <span id='span'></span>
	        <label>Disponibilidad del recurso</label><br><br>
	        <select name='disponible'>
	        <option>Cualquiera</option>
	        <option>Disponible</option>
	        <option>Deshabilitado</option>
	        <?php
	        echo "</select><br>";
	        echo "<input type='checkbox' name='popularidad'>";
	        echo "<label>Filtrar por popularidad</label><br>";
	        echo"<input type='submit' name='Enviar' value='Buscar'>";
	        echo "</form>";
	        echo "</div>";

	    ///////////////////////// BÚSQUEDAS ///////////////////////////////

	    if (isset($_POST['Enviar'])) {
	    	//El tipo afecta a rec_tipo
	    	if (isset($_POST['tipo']) && $_POST['tipo']!="Cualquiera") {
	    		$tipo=$_POST['tipo'];
	    		if ($tipo!="teoria") {
	    			$string1="WHERE rec_tipo='$tipo'";
	    		}else{
	    			$string1="WHERE rec_tipo='Aula de teoría'";
	    		}
	    		$and=true;
	    	}else{
	    		$string1="";
	    	}

	    	//El subtipo afecta a rec_nombre
	    	if (isset($_POST['subtipo']) && $_POST['subtipo']!="") {
	    		$subtipo=$_POST['subtipo'];
	    		if ($_POST['subtipo']!="Cualquiera") {
	    			$string3="WHERE rec_nombre LIKE '%$subtipo%'";
		    		if (isset($and)) {
		    			$string3="AND rec_nombre LIKE '%$subtipo%'";
		    		}
	    		}else{
	    			$string3="";
	    		}
	    		$and=true;
	    	}else{
	    		$string3="";
	    	}

	    	if (isset($_POST['disponible']) && $_POST['disponible']!="Cualquiera") {
	    		$disponible=$_POST['disponible'];
	    		if ($disponible=="Disponible") {
	    			$string="WHERE rec_habilitado='0'";
	    			if (isset($and)) {
	    				$string="AND rec_habilitado='0'";
	    			}
	    		}
	    		if ($disponible=="Deshabilitado") {
	    			$string="WHERE rec_habilitado='1'";
	    			if (isset($and)) {
	    				$string="AND rec_habilitado='1'";
	    			}
	    		}
	    	}else{
	    		$string="";
	    	}

	    	if (isset($_POST['popularidad'])) {
	    		$popularidad=$_POST['popularidad'];
	    		$popularidad="ORDER BY rec_usado DESC";
	    	}else{
	    		$popularidad="";
	    	}

	    	$q="SELECT * FROM recurso $string1 $string3 $string $popularidad";
	    
	    	$resultados = mysqli_query($conexion, $q);
	    	echo "<div id='contenido'>";
	        if(mysqli_num_rows($resultados)>0){
	        	while ($filtro=mysqli_fetch_array($resultados)) {
	        		$habilitado=$filtro['rec_habilitado'];
	        			$recursoid=$filtro['rec_id'];
		        		echo "<a class='link_recurso' href='recurso.php?recurso=$recursoid'>";
		        		echo "<div id='div-recurso'>";
		        		echo "<div id='recurso-img'>";
		        		echo "<img id='img_div' src='../img/$filtro[rec_img]''><br><br>";
		        		echo "</div>";
		        		echo "<div id='recurso-cont'>";
		        		echo "<b>$filtro[rec_nombre]</b><br><br>";
		        		echo "Veces usado: $filtro[rec_usado]";
		        		echo "<hr>";
		        		$disponible=$filtro['rec_habilitado'];
						if ($disponible==0) {
							echo "DISPONIBLE<br><br>";
						}else{
							echo "DESHABILITADO<br><br>";
						}

		        		echo "</div>";
		        		echo "</div>";
		        		echo "</a>";
		        		
	        		
	        	}//fin while
	        }//fin if mysqli_num_rows
	        else{
	        	echo "<p>No hay ningúna coincidencia con su búsqueda</p>";
	        }
	        echo "</div>";


	    }//fin if Enviar
	    else{

	    	$q="SELECT * FROM recurso";
	    	$resultados = mysqli_query($conexion, $q);
	    	echo "<div id='contenido'>";
	        if(mysqli_num_rows($resultados)>0){
	        	while ($filtro=mysqli_fetch_array($resultados)) {
	        		$habilitado=$filtro['rec_habilitado'];
	        		if ($habilitado==0) {
	        			$recursoid=$filtro['rec_id'];
		        		echo "<a class='link_recurso' href='recurso.php?recurso=$recursoid'>";
		        		echo "<div id='div-recurso'>";
		        		echo "<div id='recurso-img'>";
		        		echo "<img id='img_div' src='../img/$filtro[rec_img]''><br><br>";
		        		echo "</div>";
		        		echo "<div id='recurso-cont'>";
		        		echo "<b>$filtro[rec_nombre]</b><br><br>";
		        		echo "Veces usado: $filtro[rec_usado]";
		        		echo "<hr>";
		        		$disponible=$filtro['rec_habilitado'];
						if ($disponible==0) {
							echo "DISPONIBLE<br><br>";
						}else{
							echo "DESHABILITADO<br><br>";
						}

		        		echo "</div>";
		        		echo "</div>";
		        		echo "</a>";
		        		}
	        		
	        	}//fin while
	        }//fin if mysqli_num_rows
	        echo "</div>";

	    }

		}//fin de la conexion
	}else{
		header("Location: ../login.php");
	}
	?>
</body>
</html>