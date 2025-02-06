<?php

$tituloPagina = 'Cambiar Contraseña';
$id_usuario = $_GET["id_usuario"]; 
$contenidoPrincipal = <<<EOS
<form class='form-marco' action="includes/src/procesarUsuario/procesarCambiarContrasena.php?id_usuario=$id_usuario" method="POST" onchange="return validarCambioContraseña(this);">
<fieldset>
    <legend>Actualizar Contraseña</legend>
    <div><label>Contraseña Actual:</label> <input type="password" name="oldpass" required></div><br>
    <div><label>Nueva Contraseña:</label> <input type="password" name="password" required></div><br>
    <div><label>Repita la nueva contraseña:</label> <input type="password" name="password2" required></div><br>
    <button type="submit">Guardar Cambios</button>
</fieldset>
</form>
EOS;
require ('./includes/vistas/plantillas/plantilla.php');
?>