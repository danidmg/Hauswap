<?php

$tituloPagina = 'Iniciar Sesión';

$contenidoPrincipal=<<<EOS

    <form action="includes/src/procesarUsuario/procesarLogin.php" method="POST" id="login" onchange="return validarLogin(this);">
    <fieldset>
        <h3> Inicia Sesión o Regístrate </h3>
        <br/><label>Correo electrónico:</label><input type="text" name="email"required/>
        <br/><label>Contraseña:</label><input type="password" name="password"required/>
        <br/><br/><button type="submit" id="login-button">INICIAR SESIÓN</button>
    </fieldset>
    <h5>↓ ¿No tienes cuenta? ↓</h5>
    <a href="registro.php"><button type="button" id="register-button">REGISTRARSE</button></a>

EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>

