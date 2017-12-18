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
        $objetivo=$_SESSION['recurso_delete'];
        $q="UPDATE recurso SET rec_habilitado='1' WHERE rec_id='$objetivo'";
        echo "$q";
        $resultado = mysqli_query($conexion, $q);
        unset($_SESSION['recurso_delete']);
        header("Location: admin_index.php?opt=2");
      }
      if (isset($_GET['habl'])) {
        mysqli_query($conexion, "SET NAMES 'utf8'");
        $objetivo=$_SESSION['recurso_habl'];
        $q="UPDATE recurso SET rec_habilitado='0' WHERE rec_id='$objetivo'";
        echo "$q";
        $resultado = mysqli_query($conexion, $q);
        unset($_SESSION['recurso_habl']);
        header("Location: admin_index.php?opt=2");
      }
    }//fin else
  }else{
    header("Location: ../login.php");
  }
}else{
  header("Location: ../login.php");
}
?>