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

      $email=$_POST['email'];
      $original=$_POST['usuario_cambiar'];
      $password=$_POST['password'];

      //Si se cambia el email también habrá que cambiar el id de inicio de sesión
      if ($email!=$original) {
        $_SESSION['login']=$email;
      }
      /*Si no se ha dado click a modificar el password, predeterminadamente tiene como valor ""
      por ello, si el valor del password es distinto a "", quiere decir que se ha insertado otro
      password y se ha de encriptar.*/

      if ($password!="") {
        $pass=md5($password);
      }else{

        /*Si no se quiere modificar un password se hace un select del password que ya tenía y no se encripta*/

        $q="SELECT usu_password FROM usuario WHERE usu_id='$original'";
        $resultado = mysqli_query($conexion, $q);
        $password=mysqli_fetch_array($resultado);
        $pass=$password['usu_password'];
      }//fin if password
      
      /*La respuesta de seguridad no se puede modificar ya que afecta al usuario*/
      $q="SELECT usu_seguridad FROM usuario WHERE usu_id='$original'";
      $sql = mysqli_query($conexion, $q);

      while($masc = mysqli_fetch_array($sql)){
        $mascota=$masc['usu_seguridad'];
      }

      if (isset($_FILES['usu_foto']['name'])) {
        $img=$_FILES['usu_foto']['name'];
        $org1=$img;
        $q="SELECT usu_foto FROM usuario WHERE usu_foto='$img'";
        $sql = mysqli_query($conexion, $q);
        //Ya que subir una imagen con el mismo nombre a la bdd se sobreescribe, le añadimos un número en un while para que no haya errores
          if (mysqli_num_rows($sql)>0) {
            $contador=0;
            $ok=false;
            while ($ok==false) {
              $img=$org1;
              $contador=$contador+1;
              $img=$contador.$img;
              $q="SELECT usu_foto FROM usuario WHERE usu_foto='$img'";
              $sql = mysqli_query($conexion, $q);

              if (mysqli_num_rows($sql)==0) {
                $ok=true;
              }
            }  
          }//fin mysqli_num_rows

          if (isset($_POST['nivel'])) {
            $nivel=$_POST['nivel'];
            $a="UPDATE usuario SET usu_correo='$email', usu_password='$pass', usu_nivel='$nivel', usu_seguridad='$mascota', usu_foto='$img' WHERE usu_id='$original'";
          }else{
            $a="UPDATE usuario SET usu_nombre='$email', usu_password='$pass', usu_seguridad='$mascota', usu_foto='$img' WHERE usu_id='$original'";
          }
          

          if (mysqli_query($conexion,$a) == true) {

            if(isset($ok)){
              $temp = explode(".", $_FILES["usu_foto"]["name"]);
              $newfilename = $img;
              move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $newfilename);
            }else{
              move_uploaded_file($_FILES["usu_foto"]["tmp_name"], "C:\\xampp\\htdocs\\DAW2\\Proyecto03\\img\\" . $img);
            }
            $_SESSION['mensaje']="Se ha modificado al usuario con éxito";
            header("Location: admin_index.php?opt=1");

          }

        }else{

          /*Si no se ha seleccionado imagen cogemos la imagen que ya tiene*/
          $q="SELECT usu_foto FROM usuario WHERE usu_id='$original'";

          $sql=mysqli_query($conexion,$q);

          while($foto = mysqli_fetch_array($sql)){
            $img=$foto['usu_foto'];
          }

          if (isset($_POST['nivel'])) {
            $nivel=$_POST['nivel'];
            $a="UPDATE usuario SET usu_correo='$email', usu_password='$pass', usu_nivel='$nivel', usu_seguridad='$mascota', usu_foto='$img' WHERE usu_id='$original'";
          }else{
            $a="UPDATE usuario SET usu_correo='$email', usu_password='$pass', usu_seguridad='$mascota', usu_foto='$img' WHERE usu_id='$original'";
          }
          echo "$a";
          mysqli_query($conexion,$a);
          $_SESSION['mensaje']="Se ha modificado al usuario con éxito";
          header("Location: admin_index.php?opt=1");

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