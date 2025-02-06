<?php

$tituloPagina = 'Registrarse';

$contenidoPrincipal=<<<EOS

    <form action="includes/src/procesarUsuario/procesarRegistro.php" method="POST" id="registro" enctype="multipart/form-data" onchange="return validarRegistro(this);">
    <fieldset>
        <h3> Completa tus datos para registrarte </h3>
        <br/><label>Correo electrónico:</label><input type="text" name="email"required/>
        <br><br/><label>Nombre:</label><input type="text" name="username"required/>
        <br><br/><label>Contraseña:</label><input type="password" name="password"required/>
        <br><br/><label>Repita la contraseña:</label><input type="password" name="password2"required/>
        <br><br/><label>Teléfono:</label><input type="tel" name="telefono"required/>
        <br><br/><label>Género:</label><select name="genero"><option>Prefiero no contestar</option><option>Hombre</option><option>Mujer</option><option>No binario</option></select>
        <br><br/><label>Fecha de nacimiento:</label><input type="date" name="fecha"required/>
        <br><br/><label>País:</label><input type="text" name="pais"required/>
        <br><br/><label>Foto de perfil:</label> <input type="file" name="foto_perfil" id="foto_perfil" required>
        <br/><br><button type="submit" id="register2-button">REGISTRARSE</button>
    </fieldset>
    <h5>↓ ¿Ya tienes cuenta? ↓</h5>
    <a href="login.php"><button type="button" id="login2-button">INICIAR SESIÓN</button></a>

EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>
