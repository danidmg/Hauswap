<?php
// Incluir archivo de configuración y clase Usuario
require_once 'includes/config.php';
require_once 'includes/src/clases/Mensaje.php';
require_once 'includes/src/clases/Usuario.php';

// Verificar si hay sesión iniciada
if (!isset($_SESSION['login'])) {
    $mensaje = "Necesitas iniciar sesión para acceder a tus chats";
    header("Location: login.php?mensaje=" . $mensaje);
    exit();
} else {
    //Obtenemos el correo (id) del contacto
    $correoUsuario = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $correoContacto = mysqli_real_escape_string($conn, $_POST['incoming_id']);

    $usuarioRemitente = Usuario::buscaUsuario($correoUsuario);
    $usuarioDestinatario = Usuario::buscaUsuario($correoContacto);

    $fotoRemitente = $usuarioRemitente->getFotoPerfil();
    $fotoDestinatario = $usuarioDestinatario->getFotoPerfil();

    // Obtener el array de mensajes llamando a la función
    $mensajes = Mensaje::devuelveMensajesEntre($correoUsuario, $correoContacto);
    // Iterar sobre el array de usuarios con un bucle foreach
    foreach ($mensajes as $msg) {
        $output = "";    
        $idRemitente = $msg->getRemitente();
        $contenidoMensaje = $msg->getContenido();
        $fechayhora = $msg->getFecha();

        if($idRemitente === $correoUsuario) { //EL usuario es el que manda el mensaje
            $output .= "
            <div class='outgoing'>
                <div class='fechayhora'><p>$fechayhora</p></div>
                <div class='details'>
                    <p>$contenidoMensaje</p>
                </div>
                <img src='$fotoRemitente' alt='Foto de perfil'>
            </div>";
        } else { //El usuario es el que recibe el mensaje
            $output .= "
                <div class='incoming'>
                    <img src='$fotoDestinatario' alt='Foto de perfil'>
                    <div class='details'>
                        <p>$contenidoMensaje</p>
                    </div>
                    <div class='fechayhora'><p>$fechayhora</p></div>
                </div>";
        }
        echo $output;
    }

}
?>