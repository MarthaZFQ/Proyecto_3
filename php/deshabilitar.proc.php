<?php
session_start();
if(isset($_SESSION['nivel'])){
  if ($_SESSION['nivel']!="Usuario") {  
    require("../bdd/conexion.php");
    if(!$conexion){
      echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
      echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
      echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
      exit;
    }else{
      if (isset($_GET['ok'])) {
        mysqli_query($conexion, "SET NAMES 'utf8'");
        $objetivo=$_SESSION['objetivo'];
        $q="UPDATE usuario SET usu_habilitado='1' WHERE usu_correo='$objetivo'";
        $resultado = mysqli_query($conexion, $q);
        unset($_SESSION['objetivo']);
        header("Location: admin_index.php?opt=1");
      }
      if (isset($_GET['target'])) {
        mysqli_query($conexion, "SET NAMES 'utf8'");
        $objetivo=$_SESSION['objetivo1'];
        $q="UPDATE usuario SET usu_habilitado='0' WHERE usu_correo='$objetivo'";
        $resultado = mysqli_query($conexion, $q);
        unset($_SESSION['objetivo1']);
        header("Location: admin_index.php?opt=1");
      }
    }//fin else
  }else{
    header("Location: ../login.php");
  }
}else{
  header("Location: ../login.php");
}
?>