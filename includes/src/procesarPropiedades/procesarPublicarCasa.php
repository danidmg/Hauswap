<?php
require_once '../../config.php';
require_once '../clases/Propiedad.php';

// Capturo las variables
$id_usuario = htmlspecialchars(trim(strip_tags($_SESSION["nombre"]))); 
$nombre = htmlspecialchars(trim(strip_tags($_POST['nombre'])));
$localizacion = htmlspecialchars(trim(strip_tags($_POST['localizacion'])));
$descripcion = htmlspecialchars(trim(strip_tags($_POST['descripcion'])));


// Procesar la imagen
if (isset($_FILES['imagen'])) {
  // Verificar que se ha subido un archivo y no ha ocurrido ningún error
  if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Verificar que el archivo subido es una imagen
    $tipo_imagen = exif_imagetype($_FILES['imagen']['tmp_name']);
    if ($tipo_imagen !== IMAGETYPE_JPEG && $tipo_imagen !== IMAGETYPE_PNG) {
      $mensaje =  "Error: el archivo subido no es una imagen.";
      echo "<meta http-equiv='refresh' content='1; ../../../publicarCasa.php?mensaje=".$mensaje."'>";
      exit;
    }
    // Verificar que el tamaño del archivo es menor o igual a 2 MB
    if ($_FILES['imagen']['size'] > 2 * 1024 * 1024) {
      $mensaje =  "Error: el archivo subido es demasiado grande (máximo 2 MB).";
      echo "<meta http-equiv='refresh' content='1; url=../../../publicarCasa.php?mensaje=".$mensaje."'>";
      exit;
    }
    // Procesar la imagen
    $imagen = $_FILES['imagen']['tmp_name'];

  } 
  else {
    $mensaje = "Error al subir el archivo.";
    echo "<meta http-equiv='refresh' content='1; url=../../../publicarCasa.php?mensaje=".$mensaje."'>";
    exit;
  }
} 

$ruta_imagen = '../../../imagenes/';
$nombre_imagen = uniqid() . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
$ruta_destino = $ruta_imagen . $nombre_imagen;
move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino);

$ruta_imagen = './imagenes/';
$ruta_destino = $ruta_imagen . $nombre_imagen;
// Crear la propiedad en la bd
$propiedad = Propiedad::crea($id_usuario, $nombre, $localizacion, $ruta_destino, $descripcion);

// Mensajes de resultado
if($propiedad){
  $mensaje = "Se ha creado la propiedad $nombre en $localizacion ";
}
else{
  $mensaje = "Lo sentimos! Ha habido un error creando la propiedad";
}

if (!isset($_SESSION['esAdmin'])){
        echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
    }
    else{
        echo "<meta http-equiv='refresh' content='0; url=../../../gestionarPropiedades.php?mensaje=".$mensaje."'>";
    }
?>