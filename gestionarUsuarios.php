<?php

require_once 'includes/config.php';

$tituloPagina = 'Administrador usuarios';

// Importa la clase Usuario
require_once 'includes/src/clases/Usuario.php';

// Obtiene todos los usuarios de la base de datos
$usuarios = Usuario::devuelveTodosLosUsuarios();

//incializamos los datos
$datos = '';

//recoge la info de todos los usuarios
foreach ($usuarios as $usuario) {
    $datos .= "<div id ='div-datos'>
                    <img src={$usuario->getFotoPerfil()} alt='Foto de perfil' id='foto-perfil'>
                    <p>
                        <strong>Correo: </strong>{$usuario->getCorreo()}<br>
                        <strong>Nombre:  </strong>{$usuario->getNombre()}<br>
                        <strong>Teléfono: </strong>{$usuario->getTelefono()}<br>
                        <strong>Género: </strong>{$usuario->getGenero()}<br>
                        <strong>Fecha de nacimiento: </strong>{$usuario->getFecha()}<br>
                        <strong>País: </strong>{$usuario->getPais()}<br>
                    </p>

                    <br>
                    <a href=\"edicionLosDatos.php?id_usuario={$usuario->getCorreo()}\"><button type=\"button\">Editar los datos</button></a>
                    <a href=\"cambiarContrasena.php?id_usuario={$usuario->getCorreo()}\"><button type=\"button\">Cambiar contraseña</button></a>";

    if (!$usuario->esAdmin()) {
        $datos .= "<button id='boton-eliminar-cuenta' type='button' onclick='eliminarCuenta(\"{$usuario->getCorreo()}\")'>Eliminar cuenta</button>";
    }

    $datos .= "</div>";
}

$contenidoPrincipal = <<<EOS
    <h1>Gestionar Usuarios</h1>
    $datos
EOS;


require('./includes/vistas/plantillas/plantilla.php');
?>
