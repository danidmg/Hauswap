<?php
require_once '../../config.php';
require_once '../clases/Reserva.php';

$id_reserva = $_GET["id_reserva"];

// Si llega aquí sin ID de la Reserva error porque no sabe cúal eliminar
if(!isset($id_reserva)){
    $mensaje =  "Lo sentimos! Ha habido un error eliminando tu reserva";
    if (!isset($_SESSION['esAdmin'])){
        echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
    }
    else{
        echo "<meta http-equiv='refresh' content='0; url=../../../gestionarReservas.php?mensaje=".$mensaje."'>";
    }}

// Elimina
    $delete = Reserva::eliminaReserva($id_reserva);

// Mensajes de resultado
    if ($delete){
        $mensaje = "Tu reserva ha sido eliminada con éxito!";
    }
    else{
        $mensaje = "Lo sentimos! Ha ocurrido un error eliminando la reserva!";
    }

    if (!isset($_SESSION['esAdmin'])){
        echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
    }
    else{
        echo "<meta http-equiv='refresh' content='0; url=../../../gestionarReservas.php?mensaje=".$mensaje."'>";
    }
?>