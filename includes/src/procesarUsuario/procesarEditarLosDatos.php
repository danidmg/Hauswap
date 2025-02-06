<?php
require_once '../../config.php';
require_once '../clases/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_GET["id_usuario"];

    // Cogemos los datos del formulario y actualizamos la base de datos
    $campos = array();

    $nombre = htmlspecialchars(trim(strip_tags($_REQUEST["username"])));
    echo $nombre;
    if (!empty($nombre)) {
        $campos[] = "nombre = '$nombre'";
    }
    $telefono = htmlspecialchars(trim(strip_tags($_REQUEST["telefono"])));
    if (!empty($telefono)) {
        $campos[] = "telefono = '$telefono'";
    }
    $genero = htmlspecialchars(trim(strip_tags($_REQUEST["genero"])));
    if (!empty($genero)) {
        $campos[] = "sexo = '$genero'";
    }
    $fecha = htmlspecialchars(trim(strip_tags($_REQUEST["fecha"])));
    if (!empty($fecha)) {
        $campos[] = "fecha_nacimiento = '$fecha'";
    }
    $pais = htmlspecialchars(trim(strip_tags($_REQUEST["pais"])));
    if (!empty($pais)) {
        $campos[] = "pais = '$pais'";
    }
    $biografia = htmlspecialchars(trim(strip_tags($_REQUEST["biografia"])));
    if (!empty($biografia)) {
        $campos[] = "biografia = '$biografia'";
    }

    if (is_uploaded_file($_FILES['foto_perfil']['tmp_name'])) {
        // Verificar que se ha subido un archivo y no ha ocurrido ningún error
        if ($_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
          // Verificar que el archivo subido es una imagen
          $tipo_imagen = exif_imagetype($_FILES['foto_perfil']['tmp_name']);
          if ($tipo_imagen !== IMAGETYPE_JPEG && $tipo_imagen !== IMAGETYPE_PNG) {
            $mensaje =  "Error: el archivo subido no es una imagen.";
            echo "<meta http-equiv='refresh' content='1; ../../../miCuenta.php?mensaje=".$mensaje."'>";
            exit;
          }
          // Verificar que el tamaño del archivo es menor o igual a 2 MB
          if ($_FILES['foto_perfil']['size'] > 2 * 1024 * 1024) {
            $mensaje =  "Error: el archivo subido es demasiado grande (máximo 2 MB).";
            echo "<meta http-equiv='refresh' content='1; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
            exit;
          }
          // Procesar la imagen
          $imagen = $_FILES['foto_perfil']['tmp_name'];
      
        } 
        else {
          $mensaje = "Error al subir el archivo.";
          echo "<meta http-equiv='refresh' content='1; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
          exit;
        }
    
      $ruta_imagen = '../../../imagenes/';
      $nombre_imagen = uniqid() . '.' . pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
      $ruta_destino = $ruta_imagen . $nombre_imagen;
      move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta_destino);
      
      $ruta_imagen = './imagenes/';
      $campos[] = "servidor_fotoperfil = '". $ruta_imagen . $nombre_imagen . "'";
    }

    if (!empty($campos)) {
        $camposStr = implode(", ", $campos);
        Usuario::edita($correo, $camposStr);
    }
}

?>