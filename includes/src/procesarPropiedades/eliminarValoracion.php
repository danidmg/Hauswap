<?php
require_once '../../config.php';
require_once '../clases/Valoracion.php';

$id_valoracion = $_GET["id_valoracion"];

// Si llega aquí sin ID de la valoracion error porque no sabe cúal eliminar
if(!isset($id_valoracion)){
    $mensaje =  "Lo sentimos! Ha habido un error eliminando tu valoración";
    if (!isset($_SESSION['esAdmin'])){
        echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
    }
    else{
        echo "<meta http-equiv='refresh' content='0; url=../../../gestionarValoraciones.php?mensaje=".$mensaje."'>";
    }
}

// Elimina
    $delete = Valoracion::eliminaValoracion($id_valoracion);

// Mensajes de resultado
    if ($delete){
        $mensaje = "Tu valoracion ha sido eliminada con éxito!";
    }
    else{
        $mensaje = "Lo sentimos! Ha ocurrido un error eliminando la valoracion!";
    }

    if (!isset($_SESSION['esAdmin'])){
        echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
    }
    else{
        echo "<meta http-equiv='refresh' content='0; url=../../../gestionarValoraciones.php?mensaje=".$mensaje."'>";
    }
?>