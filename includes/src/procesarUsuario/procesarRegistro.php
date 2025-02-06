<?php
require_once '../../config.php';
require_once '../clases/Usuario.php'; 

// Capturo las variables 
 $username = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
 $password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));
 $password2 = htmlspecialchars(trim(strip_tags($_REQUEST["password2"])));
 $nombre = htmlspecialchars(trim(strip_tags($_REQUEST["username"])));
 $telefono = htmlspecialchars(trim(strip_tags($_REQUEST["telefono"])));
 $genero = htmlspecialchars(trim(strip_tags($_REQUEST["genero"])));
 $fecha = htmlspecialchars(trim(strip_tags($_REQUEST["fecha"])));
 $pais = htmlspecialchars(trim(strip_tags($_REQUEST["pais"])));
 $ruta_destino = "";

// Procesar la imagen
if (isset($_FILES['foto_perfil'])) {
    // Verificar que se ha subido un archivo y no ha ocurrido ningún error
    if ($_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
      // Verificar que el archivo subido es una imagen
      $tipo_imagen = exif_imagetype($_FILES['foto_perfil']['tmp_name']);
      if ($tipo_imagen !== IMAGETYPE_JPEG && $tipo_imagen !== IMAGETYPE_PNG) {
        $mensaje =  "Error: el archivo subido no es una imagen.";
        echo "<meta http-equiv='refresh' content='1; ../../../registro.php?mensaje=".$mensaje."'>";
        exit;
      }
      // Verificar que el tamaño del archivo es menor o igual a 2 MB
      if ($_FILES['foto_perfil']['size'] > 2 * 1024 * 1024) {
        $mensaje =  "Error: el archivo subido es demasiado grande (máximo 2 MB).";
        echo "<meta http-equiv='refresh' content='1; url=../../../registro.php?mensaje=".$mensaje."'>";
        exit;
      }
      // Procesar la imagen
      $imagen = $_FILES['foto_perfil']['tmp_name'];
  
    } 
    else {
      $mensaje = "Error al subir el archivo.";
      echo "<meta http-equiv='refresh' content='1; url=../../../registro.php?mensaje=".$mensaje."'>";
      exit;
    }

  $ruta_imagen = '../../../imagenes/';
  $nombre_imagen = uniqid() . '.' . pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
  $ruta_destino = $ruta_imagen . $nombre_imagen;
  move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_destino);
  
  $ruta_imagen = './imagenes/';
  $ruta_destino = $ruta_imagen . $nombre_imagen;
}

$empty = 0;
$mensaje = "";

if($password != $password2){
    $mensaje .= "Las contraseñas deben coincidir!";
    echo "<meta http-equiv='refresh' content='0; url=../../../registro.php?mensaje=".$mensaje."'>";
}
else{
    $usuario = Usuario::buscaUsuario($username);
    
    if ($usuario) {
        $mensaje = "Ese usuario ya existe! Prueba con otro correo electrónico";
        echo "<meta http-equiv='refresh' content='0; url=../../../registro.php?mensaje=".$mensaje."'>";
    } else {
        $usuario = Usuario::crea($username, $password, $nombre, $telefono, $genero, $fecha, $pais, $ruta_destino, 2);
        $_SESSION['login'] = true;
        $_SESSION['nombre'] = $usuario->getcorreo();
    }
}

// Proceso las variables comprobando si es un usuario valido

if (isset($_SESSION["login"])){
    $mensaje =  "Bienvenido/a ${_SESSION["nombre"]}";
    echo "<meta http-equiv='refresh' content='0; url=../../../index.php?mensaje=".$mensaje."'>";
}
?>

