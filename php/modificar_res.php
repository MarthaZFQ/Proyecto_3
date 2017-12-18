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
			if (isset($_POST['idreserva'])) {
			require("../bdd/conexion.php");
	   		mysqli_query($conexion, "SET NAMES 'utf8'");  
			$idres=$_POST['idreserva'];
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
			echo "<form method='POST' action='modificar_res.proc.php?admin'><br><label>Fecha de su reserva:</label><br><br>";
			echo "<input type='text' style='margin-bottom: 0px'  name='dia' value='$dia_res' disabled><br><br>";
			echo "<input type='hidden' name='idreserva' value='$idres'>";

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
					}

					echo"<a href='admin_index.php?opt=2'><button type='button'>Volver</button></a>";
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