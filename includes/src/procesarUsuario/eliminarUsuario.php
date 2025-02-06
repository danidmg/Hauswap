<?php
require_once '../../config.php';
require_once '../clases/Usuario.php';

$id_usuario = $_GET["id_usuario"];

// Elimina
    $delete = Usuario::elimina($id_usuario);

// Mensajes de resultado
    if ($delete){
        $mensaje = "La cuenta ha sido eliminada con éxito!";
    }
    else{
        $mensaje = "Lo sentimos! Ha ocurrido un error eliminando la cuenta!";
    }

// Redirige
    if (!isset($_SESSION['esAdmin'])){
        echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
    }
    else{
        echo "<meta http-equiv='refresh' content='0; url=../../../gestionarUsuarios.php?mensaje=".$mensaje."'>";
    }
    
?>