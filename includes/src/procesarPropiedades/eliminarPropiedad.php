<?php
require_once '../../config.php';
require_once '../clases/Propiedad.php';

$id_casa = $_GET["id_casa"];

// Si llega aquí sin ID de la casa error porque no sabe cúal eliminar
if(!isset($id_casa)){
    $mensaje =  "Lo sentimos! Ha habido un error eliminando la propiedad";
    if (!isset($_SESSION['esAdmin'])){
        echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
    }
    else{
        echo "<meta http-equiv='refresh' content='0; url=../../../gestionarPropiedades.php?mensaje=".$mensaje."'>";
    }
}

// Elimina
$delete = Propiedad::elimina($id_casa);

// Mensajes de resultado
if ($delete){
    $mensaje = "La propiedad ha sido eliminada con éxito!";
}
else{
    $mensaje = "Lo sentimos! Ha ocurrido un error eliminando la propiedad!";
}

// Redirige
if (!isset($_SESSION['esAdmin'])){
    echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
}
else{
    echo "<meta http-equiv='refresh' content='0; url=../../../gestionarPropiedades.php?mensaje=".$mensaje."'>";
}
?>