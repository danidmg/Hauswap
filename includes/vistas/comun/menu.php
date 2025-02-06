<?php
require_once 'includes/config.php';
require_once 'includes/src/clases/Usuario.php';
$status = 0;
if (isset($_SESSION["login"]) && ($_SESSION["login"] == true)) // Logged In
    $status = 1;
else
    $status = 0;

?>

<div id="menu-div">
    <a href="./index.php">
        Inicio
    </a> <br> <br>
    <a href="./chat.php">
        Chat
    </a> <br> <br>
    <a href="./miCuenta.php">
        Mi Cuenta
    </a> <br> <br>
    <a href="./buscar.php">
        Buscar casas
    </a> <br> <br>
    <?php
    if ($status == 0) {
        echo ' <a href="./login.php">
                    Iniciar Sesión / Registrarse
                    </a> <br> <br>';
    } else {
        echo ' <a href="includes/src/procesarUsuario/cerrarSesion.php">
                    Cerrar Sesión
                    </a> <br> <br> ';
    }

    ?>

</div>