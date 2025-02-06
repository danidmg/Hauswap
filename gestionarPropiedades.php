<?php

require_once 'includes/config.php';

// Importa la clase Propiedades
require_once 'includes/src/clases/Propiedad.php';

$tituloPagina = 'Administrador Propiedades';

// Obtiene todas las propiedades de la base de datos
$propiedades = Propiedad::devuelveTodasLasPropiedades();

$datos = '';

//recoge la info de todas las propiedad
foreach ($propiedades as $propiedad) {

    $datos .= "<div id ='div-datos'>
                <img src='{$propiedad->getFoto()}' alt='Imagen de la propiedad' id='imagenes-mis-propiedades'>
                    <p>
                        <strong>ID casa:  </strong>{$propiedad->getIdCasa()}<br>
                        <strong>ID usuario:  </strong>{$propiedad->getIdUsuario()}<br>
                        <strong>Nombre: </strong>{$propiedad->getNombre()}<br>
                        <strong>Localización:  </strong>{$propiedad->getLocal()}<br>
                        <strong>Valoraciones:  </strong>{$propiedad->getVal()}<br>
                        <strong>Descripción: </strong>{$propiedad->getDescr()}<br>                        
                        <strong>Estrellas:  </strong>{$propiedad->getEstrellas()}<br>

                    </p>

                    <br>
                    <a href=\"editarCasa.php?id_casa={$propiedad->getIdCasa()}\"><button type=\"button\">Editar propiedad</button></a>
                    <button id='boton-eliminar-cuenta' type='button' onclick='eliminarPropiedad({$propiedad->getIdCasa()})'>Eliminar propiedad</button>
                </div>";
}


$contenidoPrincipal=<<<EOS

    <h1>Gestionar Propiedades</h1>
    $datos

EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>