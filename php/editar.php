<!DOCTYPE html>
<html>
<head>
	<title>Modificar usuario</title>
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
			$idtarget=$_GET['id'];
			require("../bdd/conexion.php");
			?>
			<div class="modify">
			<form method="POST" action="modificar.proc.php" enctype="multipart/form-data">
              <label>Modificar email:</label><br><br>
              <?php
                echo '<input type="hidden" name="usuario_cambiar" value="'.$idtarget.'">';
                $q="SELECT usu_correo FROM usuario WHERE usu_id='$idtarget'";
                $sql=mysqli_query($conexion,$q);
                $result=mysqli_fetch_array($sql);
                $correotarget=$result['usu_correo'];
                $correo=$_SESSION['login'];
                $q="SELECT usu_id FROM usuario WHERE usu_correo='$correo'";
                $sql=mysqli_query($conexion,$q);
                $result=mysqli_fetch_array($sql);
                $usuarioadmin=$result['usu_id'];
              ?>
              <input type="text" name="email" value="<?php echo "$correotarget"?>" required><br>
              <input type="checkbox" id="check" name="pass_modificar" value="true"><label>Modificar password<label>
              <i title="Puedes elegir cambiar el password o dejarlo como está" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i>
              <br>

              <!--El div mod es el que se ocultará y se mostrará cuandos se decida si cambiar el password o dejarlo como está-->
              <div id="mod">
                
                <label>Escriba el nuevo password:</label><br><br>
                <input id="input_pass" type="password" style="width:300px;" name="password"><br>
              </div>
              
              <?php
              if ($idtarget!=$usuarioadmin) {
              	echo "<label>Modificar nivel de usuario:</label><br><br>";
              ?>
              <select name="nivel">
                <option value="Usuario">Usuario</option>
                <option value="Administrador">Administrador</option>
                <?php
                $login_nivel=$_SESSION['nivel'];
                   	if($login_nivel=="Superadministrador"){
                ?>
                  	<option value="Superadministrador">Superadministrador</option>
                <?php
                	}//fin id comprobacion que el usuario logeado sea superadministrador
                ?>
                </select><br>
                <?php
                }
            	if ($idtarget==$usuarioadmin) {
              ?>

              <input type="checkbox" id="check_input" name="check_files" onchange="valueChanged()">
              <label>Cambiar foto de perfil</label>
              <i title="Puedes elegir cambiar la foto de perfil o dejarla como está" class="fa fa-info-circle masterTooltip" aria-hidden="true"></i><br>

              <!--Aquí se mostrará el input type file una vez el checkbox haya sido seleccionado:-->
              <span id="span_files"></span>
              <?php
               }
              ?>
              <button type="submit" class="medio">Cambiar <i class="fa fa-check-circle" aria-hidden="true"></i></button>
            </form>
            <a href="admin_index.php?opt=1"><button class="medio" type="button">Volver <i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button></a><br>
			</div>
			<?php
		}else{
			header("Location: ../login.php");
		}
	}
	?>
</body>
</html>