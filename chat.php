<?php
// Incluir archivo de configuración y clase Usuario
require_once 'includes/config.php';
require_once 'includes/src/clases/Usuario.php';
require_once 'includes/src/clases/Mensaje.php';

// Verificar si hay sesión iniciada
if (!isset($_SESSION['login'])) {
    $mensaje = "Necesitas iniciar sesión para acceder a tus chats";
    header("Location: login.php?mensaje=" . $mensaje);
    exit();
} else {
    // Creamos un objeto de la clase usuario con el usuario que ha iniciado sesión
    $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
    $nombreUsuario = $usuario->getNombre();
    $miFotoPerfil = $usuario->getFotoPerfil();
    $correoUsuario = $usuario->getcorreo();

    // Obtener lista de contactos y chats del usuario
    //$usuario = new Usuario($_SESSION['id_usuario']);
    //$contactos = $usuario->obtenerContactos();
    //$chats = $usuario->obtenerChats();

    // Generar HTML de la página
    $tituloPagina = "Chats";
    $mensaje = "Bienvenido/a a tus chats, " . $nombreUsuario . ".";
    $contenidoPrincipal = "";

    $userlist = '';

    // Obtener el array de usuarios llamando a la función
    $usuarios = Usuario::devuelveTodosLosUsuarios();
    // Iterar sobre el array de usuarios con un bucle foreach
    foreach ($usuarios as $contacto) {
        $nombreContacto = $contacto->getNombre();
        $fotoPerfil = $contacto->getFotoPerfil();
        $correoContacto = $contacto->getcorreo();

        $ultimoMensaje = Mensaje::ultimoMensajeEntre($correoUsuario, $correoContacto);

        $previewMsg = $ultimoMensaje;
        $mensajeAcortado = substr($previewMsg, 0, 140);
        $length = strlen($mensajeAcortado);
        if($length === 140) {
            $mensajeAcortado .= "...";
        }

        if($nombreUsuario != $nombreContacto && $nombreContacto != "Admin") {
            $userlist .= "<a href='chatConversacion.php?correoContacto=$correoContacto'>
                <img src='$fotoPerfil' alt='Foto de perfil'>
                <div class='details'>
                <h4>$nombreContacto</h4>
                <p>$mensajeAcortado</p>
                </div>
                </a>";
        } 
    }

    // Generar lista de contactos 
    $contenidoPrincipal .= "
    <div class= 'wrapperChat'>
        <section class='users'>
        <header>
            <div class='content'>
                <img src='$miFotoPerfil' alt='Foto de perfil'>
                <div class='details'>
                    <h4>$nombreUsuario</h4>
                    <h5>En línea</h5>
                </div>
            </div>
        </header>
        <div class='users-list'>$userlist</div>
        </section>
    </div>
    ";

    require('./includes/vistas/plantillas/plantilla.php');
}
?>