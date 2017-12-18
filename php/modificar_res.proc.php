<!DOCTYPE html>
<html>
<head>
	<title>Modificar reserva</title>
</head>
<body>
	<?php
		session_start();
		require("../bdd/conexion.php");
		if (isset($_SESSION['login'])) {
			if (isset($_POST['id_reserva'])) {
				$idreserva=$_POST['id_reserva'];
				$idrecurso=$_POST['recurso'];
				$fechainicio=$_POST['fecha_inicio'];
				$fechafinal=$_POST['fecha_final'];
				$dia=$_POST['dia'];
				$dia = date("Y-m-j", strtotime($dia));
				$horaini=$fechainicio.":00:00";
				$horafin=$fechafinal.":00:00";
				$recu=$_POST['recurso'];
				$fechaini=$dia." ".$horaini;
				$fechafin=$dia." ".$horafin;

				echo "dia: $dia<br>";
				echo "recurso id: $idrecurso <br>";
				echo "id_reserva: $idreserva <br>";
				echo "fechaini: $horaini <br>";
				echo "fechafinal: $horafin <br>";
				$q="SELECT * FROM reserva WHERE res_id='$idreserva' AND res_fechainicio='$horaini' AND res_fechadevolucion='$horafin' AND res_habilitado='0'";
				echo "$q";
				$sql=mysqli_query($conexion,$q);
				if (mysqli_num_rows($sql)>0) {
					echo "<br>Se ha elegido las mismas horas";
					$_SESSION['mensaje']="Si quiere cambiar su reserva elija horas distintas, de lo contrario, ¿realmente quiere cambiar su reserva?";
					header("Location: mis_reservas.php");
				}elseif($fechafinal<$fechainicio){
					$_SESSION['mensaje']="Lo siento pero aún no son posibles los viajes en el tiempo. Elija una hora de devolución mayor a la de reserva.";
					header("Location: mis_reservas.php");
				}elseif($fechainicio==$fechafinal){
					$_SESSION['mensaje']= "¿Qué pretende? ¿Salir y entrar de una sala? ¿Encender y apagar un portátil? No podemos hacer una reserva de 0h. Elija una hora de devolución mayor a la hora de reserva.";
					header("Location: mis_reservas.php");
				}else{
					echo "<br>No se ha elegido la misma hora<br><br>";
					$j="SELECT * FROM reservA WHERE res_id <> $idreserva AND res_habilitado='0' AND (res_fechainicio LIKE '%$dia%' AND res_fechadevolucion LIKE '%$dia%')";
					echo "$j";

					$query=mysqli_query($conexion,$j);
					if (mysqli_num_rows($query)>0) {
						
						while ($comparar=mysqli_fetch_array($query)) {
						echo "<br>RESERVA:<br>";	
						$comp_ini=$comparar['res_fechainicio'];
						$comp_fin=$comparar['res_fechadevolucion'];
						echo "<br><br>Horainicio_rserva $comp_ini<br>";
						echo "Horafinal_rserva $comp_fin<br>";
						echo "<br><br>HORA INICIAL: $horaini<br>";
						echo "HORA FIN: $horafin<br>";
						$hourdiff = round((strtotime($horaini) - strtotime($horafin))/3600, 1);
						$hourdiff=abs($hourdiff);
						echo "<br>";
						echo "Diferencia horaria: $hourdiff<br><br>";
								$comp_ini = date("H:i:s",strtotime($comp_ini));

								$comp_fin = date("H:i:s",strtotime($comp_fin));
								echo "FOR QUE COMPARA $horaini con $comp_fin<br><br>";
								for ($i=0; $i <=$hourdiff; $i++) { 
									echo "PRIMER FOR<br><br>";
									/*Ya que la suma de una hora a partir de las doce (12:00:00) no suma a las 13:00:00 sino a las 01:00:00
									vamos cambiando las fechas a las de 24h. No hay problema porque no coinciden (ej: no coincide las dos de
									la mañana con de la tarde porque no hay clase tan pronto). Excepto a las ocho, por lo que si el comp_ini es
									"20:00:00", se compara a las 8 por si acaso. Y viceversa*/
									
									

									echo "Se compara HoraIni: $horaini con ComparacionFinal: $comp_fin<br><br><br>";
									if ($horaini=="20:00:00") {
										$comp_res="08:00:00";
										if($horaini==$comp_res){
											echo "NO";
											echo "PARAR";
											echo "HA ENTRADO POR AQUÍ <br><br>";
											$irse=true;
											break;
										}else{
											echo "SIGUIENTE<br><br>";
										}
									}//fin primera comprobacion 20.

									if ($horaini=="08:00:00") {
										$comp_res="20:00:00";
										if($horaini==$comp_res){
											echo "NO";
											echo "PARAR";
											echo "HA ENTRADO POR AQUÍ <br><br>";
											$irse=true;
											break;
										}else{
											echo "SIGUIENTE POR AQUÍ<br><br>";
										}
									}//fin primera comprobacion 08.

									if($horaini==$comp_fin){
										echo "<br>NO";
										echo "PARAR";
										$irse=true;
										break;
									}else{
										echo "SIGUIENTE<br>";
									}

									$selectedTime = "$horaini";
									$endTime = strtotime("h:i", strtotime($selectedTime));
									$endTime = strtotime("+1 hour", strtotime($selectedTime));
									$suma=date('h:i:s', $endTime);
									if ($suma=="01:00:00") {
										$horaini="13:00:00";
									}elseif($suma=="02:00:00"){
										$horaini="14:00:00";
									}elseif($suma=="03:00:00"){
										$horaini="15:00:00";
									}elseif($suma=="04:00:00"){
										$horaini="16:00:00";
									}elseif($suma=="05:00:00"){
										$horaini="17:00:00";
									}elseif ($suma=="06:00:00") {
										$horaini="18:00:00";
									}elseif ($suma=="07:00:00") {
										$horaini="19:00:00";
									}elseif($suma=="08:00:00"){
										$horaini="20:00:00";
									}else{
										$horaini= $suma;
									}
									echo "<br>Se cambia la hora HoraIni a: $horaini<br><br>";

								}//fin for


								if (isset($irse)) {
									$_SESSION['mensaje']="No puede reservar un recurso durante horas en las que ya se ha reservado. Vuelva a probar.";
									header("Location:recurso.php?fecha_enviar=$dia&recurso=$recu");
								}else{
									$todobien=true;
								}

						}//finwhile
						if (isset($todobien)) {
							$correo=$_SESSION['login'];
							$usuconsulta="SELECT * FROM usuario WHERE usu_correo='$correo'";
							$ejecutar=mysqli_query($conexion,$usuconsulta);
							$ej=mysqli_fetch_array($ejecutar);
							$idusuario=$ej['usu_id'];
							$horaini=$fechainicio.":00:00";
							$horafin=$fechafinal.":00:00";
							$borrar="UPDATE reserva SET res_habilitado='1' WHERE res_id='$idreserva'";
							echo "$borrar";
							mysqli_query($conexion,$borrar);
							$nuevares="INSERT INTO reserva(res_fechainicio,res_fechadevolucion,usu_id,rec_id,res_habilitado) VALUES('$fechaini','$fechafin','$idusuario','$recu','0')";
							mysqli_query($conexion,$nuevares);
							$_SESSION['mensaje'] = "Se ha hecho su reserva para el día $dia, desde las $horaini a las $horafin, con éxito.";
							echo "$nuevares";
							header("Location: mis_reservas.php");
						}
					}//finmysqli_num_rows
					else{
						//Si no hay reservas ese dia no hay por que hacer comprobaciones por lo que se hace la reserva y punto.
						$correo=$_SESSION['login'];
						$usuconsulta="SELECT * FROM usuario WHERE usu_correo='$correo'";
						$ejecutar=mysqli_query($conexion,$usuconsulta);
						$ej=mysqli_fetch_array($ejecutar);
						$idusuario=$ej['usu_id'];
						$horaini=$fechainicio.":00:00";
						$horafin=$fechafinal.":00:00";
						$borrar="UPDATE reserva SET res_habilitado='1' WHERE res_id='$idreserva'";
							echo "$borrar";
							mysqli_query($conexion,$borrar);
						$nuevares="INSERT INTO reserva(res_fechainicio,res_fechadevolucion,usu_id,rec_id) VALUES('$fechaini','$fechafin','$idusuario','$recu')";
						mysqli_query($conexion,$nuevares);
						$_SESSION['mensaje'] = "Se ha hecho su reserva para el día $dia, desde las $horaini a las $horafin, con éxito.";
						echo "$nuevares";
						header("Location: mis_reservas.php");
					}

				}
			}elseif(isset($_GET['admin'])){
				$idreserva=$_POST['id_reserva'];
				$idrecurso=$_POST['recurso'];
				$fechainicio=$_POST['fecha_inicio'];
				$fechafinal=$_POST['fecha_final'];
				$dia=$_POST['dia'];
				$dia = date("Y-m-j", strtotime($dia));
				$horaini=$fechainicio.":00:00";
				$horafin=$fechafinal.":00:00";
				$recu=$_POST['recurso'];
				$fechaini=$dia." ".$horaini;
				$fechafin=$dia." ".$horafin;

				echo "dia: $dia<br>";
				echo "recurso id: $idrecurso <br>";
				echo "id_reserva: $idreserva <br>";
				echo "fechaini: $horaini <br>";
				echo "fechafinal: $horafin <br>";
				$q="SELECT * FROM reserva WHERE res_id='$idreserva' AND res_fechainicio='$horaini' AND res_fechadevolucion='$horafin' AND res_habilitado='0'";
				echo "$q";
				$sql=mysqli_query($conexion,$q);
				if (mysqli_num_rows($sql)>0) {
					echo "<br>Se ha elegido las mismas horas";
					$_SESSION['mensaje']="Si quiere cambiar su reserva elija horas distintas, de lo contrario, ¿realmente quiere cambiar su reserva?";
					header("Location: admin_index.php?opt=3");
				}elseif($fechafinal<$fechainicio){
					$_SESSION['mensaje']="Lo siento pero aún no son posibles los viajes en el tiempo. Elija una hora de devolución mayor a la de reserva.";
					header("Location: admin_index.php?opt=3");
				}elseif($fechainicio==$fechafinal){
					$_SESSION['mensaje']= "¿Qué pretende? ¿Salir y entrar de una sala? ¿Encender y apagar un portátil? No podemos hacer una reserva de 0h. Elija una hora de devolución mayor a la hora de reserva.";
					header("Location: admin_index.php?opt=3");
				}else{
					echo "<br>No se ha elegido la misma hora<br><br>";
					$j="SELECT * FROM reservA WHERE res_id <> $idreserva AND res_habilitado='0' AND (res_fechainicio LIKE '%$dia%' AND res_fechadevolucion LIKE '%$dia%')";
					echo "$j";

					$query=mysqli_query($conexion,$j);
					if (mysqli_num_rows($query)>0) {
						
						while ($comparar=mysqli_fetch_array($query)) {
						echo "<br>RESERVA:<br>";	
						$comp_ini=$comparar['res_fechainicio'];
						$comp_fin=$comparar['res_fechadevolucion'];
						echo "<br><br>Horainicio_rserva $comp_ini<br>";
						echo "Horafinal_rserva $comp_fin<br>";
						echo "<br><br>HORA INICIAL: $horaini<br>";
						echo "HORA FIN: $horafin<br>";
						$hourdiff = round((strtotime($horaini) - strtotime($horafin))/3600, 1);
						$hourdiff=abs($hourdiff);
						echo "<br>";
						echo "Diferencia horaria: $hourdiff<br><br>";
								$comp_ini = date("H:i:s",strtotime($comp_ini));

								$comp_fin = date("H:i:s",strtotime($comp_fin));
								echo "FOR QUE COMPARA $horaini con $comp_fin<br><br>";
								for ($i=0; $i <=$hourdiff; $i++) { 
									echo "PRIMER FOR<br><br>";
									/*Ya que la suma de una hora a partir de las doce (12:00:00) no suma a las 13:00:00 sino a las 01:00:00
									vamos cambiando las fechas a las de 24h. No hay problema porque no coinciden (ej: no coincide las dos de
									la mañana con de la tarde porque no hay clase tan pronto). Excepto a las ocho, por lo que si el comp_ini es
									"20:00:00", se compara a las 8 por si acaso. Y viceversa*/
									
									

									echo "Se compara HoraIni: $horaini con ComparacionFinal: $comp_fin<br><br><br>";
									if ($horaini=="20:00:00") {
										$comp_res="08:00:00";
										if($horaini==$comp_res){
											echo "NO";
											echo "PARAR";
											echo "HA ENTRADO POR AQUÍ <br><br>";
											$irse=true;
											break;
										}else{
											echo "SIGUIENTE<br><br>";
										}
									}//fin primera comprobacion 20.

									if ($horaini=="08:00:00") {
										$comp_res="20:00:00";
										if($horaini==$comp_res){
											echo "NO";
											echo "PARAR";
											echo "HA ENTRADO POR AQUÍ <br><br>";
											$irse=true;
											break;
										}else{
											echo "SIGUIENTE POR AQUÍ<br><br>";
										}
									}//fin primera comprobacion 08.

									if($horaini==$comp_fin){
										echo "<br>NO";
										echo "PARAR";
										$irse=true;
										break;
									}else{
										echo "SIGUIENTE<br>";
									}

									$selectedTime = "$horaini";
									$endTime = strtotime("h:i", strtotime($selectedTime));
									$endTime = strtotime("+1 hour", strtotime($selectedTime));
									$suma=date('h:i:s', $endTime);
									if ($suma=="01:00:00") {
										$horaini="13:00:00";
									}elseif($suma=="02:00:00"){
										$horaini="14:00:00";
									}elseif($suma=="03:00:00"){
										$horaini="15:00:00";
									}elseif($suma=="04:00:00"){
										$horaini="16:00:00";
									}elseif($suma=="05:00:00"){
										$horaini="17:00:00";
									}elseif ($suma=="06:00:00") {
										$horaini="18:00:00";
									}elseif ($suma=="07:00:00") {
										$horaini="19:00:00";
									}elseif($suma=="08:00:00"){
										$horaini="20:00:00";
									}else{
										$horaini= $suma;
									}
									echo "<br>Se cambia la hora HoraIni a: $horaini<br><br>";

								}//fin for


								if (isset($irse)) {
									$_SESSION['mensaje']="No puede reservar un recurso durante horas en las que ya se ha reservado. Vuelva a probar.";
									header("Location:recurso.php?fecha_enviar=$dia&recurso=$recu");
								}else{
									$todobien=true;
								}

						}//finwhile
						if (isset($todobien)) {
							$correo=$_SESSION['login'];
							$usuconsulta="SELECT * FROM usuario WHERE usu_correo='$correo'";
							$ejecutar=mysqli_query($conexion,$usuconsulta);
							$ej=mysqli_fetch_array($ejecutar);
							$idusuario=$ej['usu_id'];
							$horaini=$fechainicio.":00:00";
							$horafin=$fechafinal.":00:00";
							$borrar="UPDATE reserva SET res_habilitado='1' WHERE res_id='$idreserva'";
							echo "$borrar";
							mysqli_query($conexion,$borrar);
							$nuevares="INSERT INTO reserva(res_fechainicio,res_fechadevolucion,usu_id,rec_id,res_habilitado) VALUES('$fechaini','$fechafin','$idusuario','$recu','0')";
							mysqli_query($conexion,$nuevares);
							$_SESSION['mensaje'] = "Se ha hecho su reserva para el día $dia, desde las $horaini a las $horafin, con éxito.";
							echo "$nuevares";
							header("Location: admin_index.php?opt=3");
						}
					}//finmysqli_num_rows
					else{
						//Si no hay reservas ese dia no hay por que hacer comprobaciones por lo que se hace la reserva y punto.
						$correo=$_SESSION['login'];
						$usuconsulta="SELECT * FROM usuario WHERE usu_correo='$correo'";
						$ejecutar=mysqli_query($conexion,$usuconsulta);
						$ej=mysqli_fetch_array($ejecutar);
						$idusuario=$ej['usu_id'];
						$horaini=$fechainicio.":00:00";
						$horafin=$fechafinal.":00:00";
						$borrar="UPDATE reserva SET res_habilitado='1' WHERE res_id='$idreserva'";
							echo "$borrar";
							mysqli_query($conexion,$borrar);
						$nuevares="INSERT INTO reserva(res_fechainicio,res_fechadevolucion,usu_id,rec_id) VALUES('$fechaini','$fechafin','$idusuario','$recu')";
						mysqli_query($conexion,$nuevares);
						$_SESSION['mensaje'] = "Se ha hecho su reserva para el día $dia, desde las $horaini a las $horafin, con éxito.";
						echo "$nuevares";
						header("Location: admin_index.php?opt=3");
					}

				}
			}
		}else{
			header("Location: ../login.php");
		}
	?>
</body>
</html>