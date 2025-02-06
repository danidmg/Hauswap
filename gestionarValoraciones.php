<?php

require_once 'includes/config.php';

$tituloPagina = 'Administrador valoraciones';

// Importa la clase Valoracion
require_once 'includes/src/clases/Valoracion.php';

// Obtiene todas las valoraciones de la base de datos
$valoraciones = Valoracion::devuelveTodasLasValoraciones();

//incializamos los datos
$datos = '';

//recoge la info de todas las valoraciones
foreach ($valoraciones as $valoracion) {

    $datos .= "<div id='div-datos'>
                    <p>
                    <strong>Id Valoracion: </strong>{$valoracion->getValoracion()}<br>
                    <strong>Id Casa: </strong>{$valoracion->getCasa()}<br>
                    <strong>Id reserva:  </strong>{$valoracion->getReserva()}<br>
                    <strong>Id usuario: </strong>{$valoracion->getUsuario()}<br>
                    <strong>Estrellas: </strong>{$valoracion->getEstrella()}<br>
                    <strong>Opinion: </strong>{$valoracion->getOpinion()}<br>
                    <strong>Fecha: </strong>{$valoracion->getFecha()}<br>

                    <br>
                    <button id='boton-eliminar-reserva' type='button' onclick='eliminarValoracion({$valoracion->getValoracion()})'>Eliminar</button><br>
                    </p>
                </div>";
}


$contenidoPrincipal=<<<EOS

    <h1>Gestionar Valoraciones</h1>
    $datos

EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>
