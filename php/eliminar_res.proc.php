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
        if (isset($_GET['habl'])) {
          mysqli_query($conexion, "SET NAMES 'utf8'");
          $objetivo=$_SESSION['res_id'];
          $sql="UPDATE reserva SET res_habilitado='1' WHERE res_id='$objetivo'";
          echo "$sql";

          if(mysqli_query($conexion,$sql)){
            echo "ok";
          }else{
            echo "mal";
          }
          unset($_SESSION['res_id']);
          $_SESSION['mensaje']='Se ha deshabilitado la reserva con éxito.';
          header("Location: admin_index.php?opt=3");
        }
        if (isset($_GET['ok'])) {
          mysqli_query($conexion, "SET NAMES 'utf8'");
          $objetivo=$_SESSION['res_id'];
          $sql="UPDATE reserva SET res_habilitado='0' WHERE res_id='$objetivo'";
          echo "$sql";

          if(mysqli_query($conexion,$sql)){
            echo "ok";
          }else{
            echo "mal";
          }
          unset($_SESSION['res_id']);
          $_SESSION['mensaje']='Se ha habilitado la reserva con éxito.';
          header("Location: admin_index.php?opt=3");
        }
    }//fin else
  }else{
    header("Location: ../login.php");
  }
}else{
  header("Location: ../login.php");
}
?>