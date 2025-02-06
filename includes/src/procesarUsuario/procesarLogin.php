<?php
require_once '../../config.php';
require_once '../clases/Usuario.php';

// Capturo las variables username y password
$username = htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
$password = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));


$usuario = Usuario::login($username, $password);

if (!$usuario) {
    $_SESSION['login'] = false;
} else {
    $_SESSION['login'] = true;
    $_SESSION['nombre'] = $usuario->getcorreo();
    $_SESSION['nombreReal'] = $usuario->getNombre();
    $_SESSION['fotoPerfil'] = $usuario->getFotoPerfil();
    if ($usuario->esAdmin()) {
        $_SESSION['esAdmin'] = true;
    }
}

if ($_SESSION["login"] == true) {
    $mensaje = "Bienvenido/a ${_SESSION["nombre"]}";
    echo "<meta http-equiv='refresh' content='0; url=../../../index.php?mensaje=" . $mensaje . "'>";
} else {
    $mensaje = "Usuario erróneo";
    echo "<meta http-equiv='refresh' content='0; url=../../../login.php?mensaje=" . $mensaje . "'>";
}
?>