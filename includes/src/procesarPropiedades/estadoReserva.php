<?php
require_once '../../config.php';
require_once '../clases/Reserva.php';

$id_reserva = $_GET["id_reserva"];
$nuevo_estado = $_GET["nuevo_estado"];

// Si llega aquí sin ID de la Reserva o el nuevo estado error porque no sabe cúal cambiar

if((!isset($nuevo_estado))||(!isset($id_reserva))){
    $mensaje =  "Lo sentimos! Ha habido un error actualizando tu reserva";
    echo "<meta http-equiv='refresh' content='0; ../../../miCuenta.php?mensaje=".$mensaje."'>";
}

// Actualiza estado
    $update = Reserva::actualizaEstado($id_reserva, $nuevo_estado);

// Mensajes de Resultado
if ($update){
    $mensaje = "Tu Reserva ha sido actualizada con éxito!";
}
else{
    $mensaje = "Lo sentimos! Ha ocurrido un error actualizando la reserva!";
}

// Redirige
    echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
?>