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
    	mysqli_query($conexion, "SET NAMES 'utf8'");

      $nombre_recu=$_POST['nombre_recurso'];
      $original=$_POST['id'];
      $descripcion=$_POST['descripcion'];

      if (isset($_FILES['usu_foto']['name'])) {
        $img=$_FILES['usu_foto']['name'];
        $org1=$img;
        $q="SELECT rec_img FROM recurso WHERE rec_img='$img'";
        $sql = mysqli_query($conexion, $q);
        //Ya que subir una imagen con el mismo nombre a la bdd se sobreescribe, le añadimos un número en un while para que no haya errores
          if (mysqli_num_rows($sql)>0) {
            $contador=0;
            $ok=false;
            while ($ok==false) {
              $img=$org1;
              $contador=$contador+1;
              $img=$contador.$img;
              $q="SELECT rec_img FROM recurso WHERE rec_img='$img'";
              $sql = mysqli_query($conexion, $q);

              if (mysqli_num_rows($sql)==0) {
                $ok=true;
              }
            }  
          }//fin mysqli_num_rows

          $a="UPDATE recurso SET rec_nombre='$nombre_recu', rec_descripcion='$descripcion', rec_img='$img' WHERE rec_id='$original'";

          if (mysqli_query($conexion,$a) == true) {

            if(isset($ok)){
              $temp = explode(".", $_FILES["usu_foto"]["name"]);
              $newfilename = $img;
              move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $newfilename);
            }else{
              move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $img);
            }
            $_SESSION['mensaje']="Se ha modificado el recurso con éxito";
            header("Location: admin_index.php?opt=2");

          }

        }else{

          /*Si no se ha seleccionado imagen cogemos la imagen que ya tiene*/
          $q="SELECT rec_img FROM recurso WHERE rec_id='$original'";
          echo "$q";
          $sql=mysqli_query($conexion,$q);

          while($foto = mysqli_fetch_array($sql)){
            $img=$foto['rec_img'];
          }

          $a="UPDATE recurso SET rec_nombre='$nombre_recu', rec_descripcion='$descripcion', rec_img='$img' WHERE rec_id='$original'";
          
          echo "$a";
          mysqli_query($conexion,$a);
          $_SESSION['mensaje']="Se ha modificado el recurso con éxito";
          header("Location: admin_index.php?opt=2");

        }//fin else isset files name

    }//fin else conexion
  }//fin isset nivel no es usuario
  else{
    header("Location: ../login.php");
  }
}//fin isset nivel
else{
  header("Location: ../login.php");
}
?>