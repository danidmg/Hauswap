<?php

require_once 'includes/config.php';

$tituloPagina = 'Administrador reservas';

// Importa la clase Reserva
require_once 'includes/src/clases/Reserva.php';
require_once 'includes/src/clases/Aplicacion.php';

// Obtener todas las reservas
$reservas = Reserva::devuelveTodasLasReservas();

//incializamos los datos
$datos = '';

//recoge la info de todos los usuarios
foreach ($reservas as $reserva) {

    $datos .= "<div id ='div-datos'>
        <p>
            <strong>ID de Reserva: </strong>{$reserva->getReserva()}<br>
            <strong>Id de Casa 1:  </strong>{$reserva->getCasa1()}<br>
            <strong>Id de Casa 2: </strong>{$reserva->getCasa2()}<br>
            <strong>Fecha de entrada: </strong>{$reserva->getFechaEntrada()}<br>
            <strong>Fecha de salida: </strong>{$reserva->getFechaSalida()}<br>
            <strong>Estado: </strong>{$reserva->getEstado()}<br>
            <br>

            <button id='boton-eliminar-reserva' type='button' onclick='eliminarReserva({$reserva->getReserva()})'>Eliminar</button><br>
        </p>
     </div>";      
}

$contenidoPrincipal=<<<EOS

    <h1>Gestionar Reservas</h1>
    $datos

EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>
