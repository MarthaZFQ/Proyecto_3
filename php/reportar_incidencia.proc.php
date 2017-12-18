<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	session_start();
	if (isset($_SESSION['login'])) {
		$recurso=$_POST['reportar'];
		$desc=$_POST['info'];
		$res=$_POST['reserva'];
		require("../bdd/conexion.php");
		$timezone= +1;
	    $fecha=gmdate("Y/m/j H:i:s",time() + 3600*($timezone+date("I")));
		$q="INSERT INTO incidencia(inci_descripcion,inci_fecha_inci,res_id,inci_estado) VALUES ('$desc', '$fecha', '$res', '1')";
		mysqli_query($conexion,$q);
		echo "$q";
		$a="UPDATE reserva SET res_fechadevolucion='$fecha' WHERE res_id='$res' AND rec_id='$recurso'";
		mysqli_query($conexion,$a);
		$k="SELECT * FROM incidencia INNER JOIN reserva ON incidencia.res_id=reserva.res_id WHERE incidencia.res_id='$res'";
		echo "<br>$k";
		$consulta=mysqli_query($conexion,$k);
		if (mysqli_num_rows($consulta)>0) {
			while ($recu=mysqli_fetch_array($consulta)) {
				$id=$recu['rec_id'];
				//guardo el recurso de reserva
				$j="UPDATE recurso SET rec_habilitado='1' WHERE rec_id='$id'";
				echo "$j";
				mysqli_query($conexion,$j);
				$_SESSION['mensaje']="La incidencia ha sido reportada con éxito";
		header("Location: reportar_incidencia.php");
			}
		}

	}else{
		header("Location: ../login.php");
	
	}
	?>
</body>
</html>