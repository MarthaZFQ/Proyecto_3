<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	require("../bdd/conexion.php");
	session_start();
	if (isset($_SESSION['nivel'])) {
		if (isset($_GET['ok'])) {
			$idrecurso=$_SESSION['id_reparar'];
			unset($_SESSION['id_reparar']);
			$q="SELECT * FROM incidencia INNER JOIN reserva ON incidencia.res_id=reserva.res_id INNER JOIN recurso ON reserva.rec_id=recurso.rec_id WHERE recurso.rec_id='$idrecurso'";
			echo "$q";
			$query=mysqli_query($conexion,$q);
			if (mysqli_num_rows($query)>0) {
				while ($info=mysqli_fetch_array($query)) {
					$reserva=$info['res_id'];
					$consulta="UPDATE incidencia SET inci_estado='0' WHERE res_id='$reserva'";
					echo "$consulta";
					mysqli_query($conexion,$consulta);
					$cons="UPDATE recurso SET rec_habilitado='0', rec_habilitado='0' WHERE rec_id='$idrecurso'";
					echo "$cons";
					mysqli_query($conexion,$cons);
					header("Location: admin_index.php?opt=2");
				}
			}
			
	}else{
		header("Location: login.php");
	}else{
		header("Location: login.php");
}
	?>
</body>
</html>