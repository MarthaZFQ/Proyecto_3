<!DOCTYPE html>
<html>
<head>
	<title>Reservar</title>
</head>
<body>
	<?php
	session_start();
	if (isset($_SESSION['login'])) {
		require("../bdd/conexion.php");
		if (!$conexion) {
			echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
        	echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        	echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		}else{
			$fechainicio=$_POST['fecha_inicio'];
			$fechafinal=$_POST['fecha_final'];
			if ($fechafinal<$fechainicio) {
				$_SESSION['mensaje'] = "Lo siento pero aún no son posibles los viajes en el tiempo. Elija una hora de devolución mayor a la de reserva.";
				$recu=$_POST['recurso'];
				$dia=$_POST['dia'];
				$date1 = $_POST['dia'];
				$dias=date('d/m/Y', strtotime($date1));
				header("Location: recurso.php?recurso=$recu&fecha_enviar=$dias");
			}elseif($fechafinal==$fechainicio){
				$recu=$_POST['recurso'];
				$dia=$_POST['dia'];
				$_SESSION['mensaje']= "¿Qué pretende? ¿Salir y entrar de una sala? ¿Encender y apagar un portátil? No podemos hacer una reserva de 0h. Elija una hora de devolución mayor a la hora de reserva.";
				$date1 = $_POST['dia'];
				$dias=date('d/m/Y', strtotime($date1));
				header("Location: recurso.php?recurso=$recu&fecha_enviar=$dias");
			}else{
				$horaini=$fechainicio.":00:00";
				$horafin=$fechafinal.":00:00";
				$recu=$_POST['recurso'];
				$dia1=$_POST['dia'];
				echo "$dia1";
				$timezone=+1;
				$date1 = $_POST['dia'];
				$dia=date('Y-m-d', strtotime($date1));
				$fechaini=$dia." ".$horaini;
				$fechafin=$dia." ".$horafin;

				//A partir de aquí hacemos las comprobaciones

					//Seleccionamos todos los recursos que coincidan con la fecha de reserva.
					$s="SELECT * FROM reserva WHERE rec_id='$recu' AND (res_fechainicio LIKE '%$dia%' OR res_fechadevolucion LIKE '%$dia%')";
					echo "$s";
					$query=mysqli_query($conexion,$s);
					if (mysqli_num_rows($query)>0) {
						
						while ($comparar=mysqli_fetch_array($query)) {
						echo "<br>RESERVA:<br>";	
						$horaini=$fechainicio.":00:00";
						$horafin=$fechafinal.":00:00";
						$comp_ini=$comparar['res_fechainicio'];
						$comp_fin=$comparar['res_fechadevolucion'];

						if ($fechaini==$comp_ini) {
							$irse=true;
						}

					//OCHO A 9 EL 30: ERROR ///////////////////
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
								/*Antes le he de quitar una hora a la hora final de la comparacion. Si hy una reserva que acaba a las 9
									y yo quiero reservas a las 9, sería correcto*/
									$selectedTime = "$comp_fin";
									$endTime = strtotime("H:i:s", strtotime($selectedTime));
									$endTime = strtotime("-1 hour", strtotime($selectedTime));
									$suma=date('h:i:s', $endTime);
									$comp_fin=$suma;
								for ($i=0; $i <=$hourdiff; $i++) { 
									echo "PRIMER FOR<br><br>";
									/*Ya que la suma de una hora a partir de las doce (12:00:00) no suma a las 13:00:00 sino a las 01:00:00
									vamos cambiando las fechas a las de 24h. No hay problema porque no coinciden (ej: no coincide las dos de
									la mañana con de la tarde porque no hay clase tan pronto). Excepto a las ocho, por lo que si el comp_ini es
									"20:00:00", se compara a las 8 por si acaso. Y viceversa*/

									$horaini=$fechainicio.":00:00";
									$horafin=$fechafinal.":00:00";

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


								

						}//finwhile
						if (isset($irse)) {
									$_SESSION['mensaje']="No puede reservar un recurso durante horas en las que ya se ha reservado. Vuelva a probar.";
									$dia=$_POST['dia'];
									$date1 = $_POST['dia'];
									$dias=date('d/m/Y', strtotime($date1));
									header("Location:recurso.php?fecha_enviar=$dias&recurso=$recu");
								}else{
									$todobien=true;
								}
						if (isset($todobien)) {
							$correo=$_SESSION['login'];
							$usuconsulta="SELECT * FROM usuario WHERE usu_correo='$correo'";
							$ejecutar=mysqli_query($conexion,$usuconsulta);
							$ej=mysqli_fetch_array($ejecutar);
							$idusuario=$ej['usu_id'];
							$dia1=$_POST['dia'];
							$timezone=+1;
							
						$date1 = strtr($_POST['dia'], '/', '-');
						$dia=date('Y-m-d', strtotime($date1));
							$fechaini=$dia." ".$horaini;
							$fechafin=$dia." ".$horafin;
							$suma="SELECT * FROM recurso WHERE rec_id='$recu'";
							$sqsuma=mysqli_query($conexion,$suma);
							$resultado_suma=mysqli_fetch_array($sqsuma);
							$usado=$resultado_suma['rec_usado'];
							$usado=$usado+1;
							$update="UPDATE recurso SET rec_usado='$usado' WHERE rec_id='$recu'";
							mysqli_query($conexion,$update);
							echo "$update";
							$nuevares="INSERT INTO reserva(res_fechainicio,res_fechadevolucion,usu_id,rec_id) VALUES('$fechaini','$fechafin','$idusuario','$recu')";
							echo "$nuevares<br><br>";
							mysqli_query($conexion,$nuevares);
							$_SESSION['mensaje'] = "Se ha hecho su reserva para el día $dia, desde las $horaini a las $horafin, con éxito.";
							echo "$nuevares";
							$date1 = $_POST['dia'];
							$dias=date('d/m/Y', strtotime($date1));
							header("Location: recurso.php?recurso=$recu&fecha_enviar=$dias");

						}
					}//finmysqli_num_rows
					else{
						//Si no hay reservas ese dia no hay por que hacer comprobaciones por lo que se hace la reserva y punto.
						$correo=$_SESSION['login'];
						$usuconsulta="SELECT * FROM usuario WHERE usu_correo='$correo'";
						$ejecutar=mysqli_query($conexion,$usuconsulta);
						$ej=mysqli_fetch_array($ejecutar);
						$idusuario=$ej['usu_id'];
						$dia1=$_POST['dia'];
				$timezone=+1;
				
						$recu=$_POST['recurso'];
						$date1 = strtr($_POST['dia'], '/', '-');
						$dia=date('Y-m-d', strtotime($date1));
						$fechaini=$dia." ".$horaini;
						$fechafin=$dia." ".$horafin;
						$suma_usado="SELECT * FROM recurso WHERE rec_id='$recu'";
							$resultado_sumar=mysqli_query($conexion,$suma_usado);
							$ressuma=mysqli_fetch_array($resultado_sumar);
							$usado=$ressuma['rec_usado'];
							$usado=$usado+1;
							$update="UPDATE recurso SET rec_usado='$usado' WHERE rec_id='$recu'";
							echo "$update";
							mysqli_query($conexion,$update);
						$nuevares="INSERT INTO reserva(res_fechainicio,res_fechadevolucion,usu_id,rec_id) VALUES('$fechaini','$fechafin','$idusuario','$recu')";
						echo "$nuevares<br><br>";

						mysqli_query($conexion,$nuevares);
						$_SESSION['mensaje'] = "Se ha hecho su reserva para el día $dia, desde las $horaini a las $horafin, con éxito.";
						echo "$nuevares";   
						$date1 = $_POST['dia'];
						$dias=date('d/m/Y', strtotime($date1));
						header("Location: recurso.php?recurso=$recu&fecha_enviar=$dias");
					}

			}
    	}
	}else{
		header("Location: ../login.php");
	}
	?>
</body>
</html>