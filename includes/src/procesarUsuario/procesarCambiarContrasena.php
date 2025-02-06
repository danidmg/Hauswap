<?php
require_once '../../config.php';
require_once '../clases/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_GET["id_usuario"]; 
    $oldpassword = htmlspecialchars(trim(strip_tags($_REQUEST["oldpass"])));

    // Chequeamos que su contraseña anterior es correcta
    $usuario = Usuario::login($id_usuario, $oldpassword);     
    if (!$usuario) {
        $mensaje = "La contraseña actual no es correcta!";
        echo "<meta http-equiv='refresh' content='0; url=../../../cambiarContrasena.php?mensaje=".$mensaje."&id_usuario=$id_usuario'>";
    } 
    // Chequeamos que la nueva contraseña sea la misma
    else if($_REQUEST["password"] != $_REQUEST["password2"]){
        $mensaje .= "Las nuevas contraseñas deben coincidir!";
        echo "<meta http-equiv='refresh' content='0; url=../../../cambiarContrasena.php?mensaje=".$mensaje."&id_usuario=$id_usuario'>";
    }
    // Cambiamos la contraseña
    else{
        $newpass = htmlspecialchars(trim(strip_tags($_REQUEST["password"])));
        Usuario::cambiacontraseña($id_usuario, $newpass);
        //$newpassword = Usuario::hashcontraseña(htmlspecialchars(trim(strip_tags($_REQUEST["password"]))));
    }
}
?>