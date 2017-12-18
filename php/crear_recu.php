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

      $nombre=$_POST['nombre_recu'];
      $tipo=$_POST['tipo'];
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

          
          $a="INSERT INTO recurso(rec_tipo, rec_nombre,rec_descripcion,rec_img,rec_usado,rec_habilitado) VALUES ('$tipo', '$nombre','$descripcion','$img','0','0')";

          if (mysqli_query($conexion,$a) == true) {

            if(isset($ok)){
              $temp = explode(".", $_FILES["usu_foto"]["name"]);
              $newfilename = $img;
              move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $newfilename);
            }else{
              move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $img);
            }
            $_SESSION['mensaje']="Se ha creado el recurso con éxito";
            header("Location: admin_index.php?opt=5");

          }

        }else{

          /*Si no se ha seleccionado imagen cogemos la imagen por dececto*/
          $img="no_img.jpg";

         
          $a="INSERT INTO recurso(rec_tipo, rec_nombre,rec_descripcion,rec_img,rec_usado,rec_habilitado) VALUES ('$tipo', '$nombre','$descripcion','$img','0','0')";

          echo "$a";
          mysqli_query($conexion,$a);
          $_SESSION['mensaje']="Se ha creado el recurso con éxito";
          header("Location: admin_index.php?opt=5");

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