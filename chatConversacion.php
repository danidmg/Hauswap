<?php
// Incluir archivo de configuración y clase Usuario
require_once 'includes/config.php';
require_once 'includes/src/clases/Usuario.php';


// Verificar si hay sesión iniciada
if (!isset($_SESSION['login'])) {
    $mensaje = "Necesitas iniciar sesión para acceder a tus chats";
    header("Location: login.php?mensaje=" . $mensaje);
    exit();
} else {
    //Obtenemos el correo (id) del contacto
    $correoContacto = $_GET['correoContacto'];
    
    // Creamos un objeto de la clase usuario con el usuario que ha iniciado sesión
    $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
    $nombreUsuario = $usuario->getNombre();
    $miFotoPerfil = $usuario->getFotoPerfil();
    $correoUsuario = $usuario->getcorreo();

    //Otro objeto con el contacto
    $contacto = Usuario::buscaUsuario($correoContacto);
    $nombreContacto = $contacto->getNombre();
    $fotoContacto = $contacto->getFotoPerfil();

    //$chats = $usuario->obtenerChats();

    // Generar HTML de la página
    $tituloPagina = "Conversación";
    $mensaje = "";
    $contenidoPrincipal = "";

    // Generar vista de la conversación
    $contenidoPrincipal .= "
    <div class= 'wrapperChat'>
        <section class='chat-area'>
            <header>
                <div class='back-icon'><a href='chat.php'><img src='resources/back-icon.png' alt='Botón de atrás'><a/></div>
                <div class='fotoPerfilConversacion'><img src='$fotoContacto' alt='Foto de perfil'></div>
                <div class='details'>
                    <h4>$nombreContacto</h4>
                    <h5>En línea</h5>
                </div>
            </header>
            <div class='chat-box'>

            </div>
            <form class='typing-area' method='post'>
                <input type='text' name='outgoing_id' value='$correoUsuario' style='display: none;'>
                <input type='text' name='incoming_id' value='$correoContacto' style='display: none;'>
                <input type='text' name='message' class='input-chat' placeholder='Escribe un mensaje...'>
                <button><img src='resources/send.png'></button>
            </form>
        </section>
    </div>
    ";
    require('./includes/vistas/plantillas/plantilla.php');
}
?>