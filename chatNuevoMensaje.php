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
    $correoUsuario = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
    $correoContacto = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $mensaje = mysqli_real_escape_string($conn, $_POST['message']);

    if(!empty($mensaje)) {
        $sql = "INSERT INTO mensajes (id_remitente, id_destinatario, contenido) VALUES ('$correoUsuario', '$correoContacto', '$mensaje')";
        $result = $conn->query($sql);
    }
}
?>