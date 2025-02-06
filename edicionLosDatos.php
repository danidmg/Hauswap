<?php
require_once 'includes/config.php';
require_once 'includes/src/clases/Usuario.php';

// Obtiene el correo electrónico del usuario a partir de su sesión iniciada
$correo = $_GET['id_usuario'];

// Obtiene los datos del usuario a partir de su correo electrónico utilizando el método estático "datos" de la clase Usuario
$datos_usuario =Usuario::datos($correo);

// Asigna los datos obtenidos a diferentes variables para su uso posterior en el formulario
$nombre = $datos_usuario['nombre'];
$telefono = $datos_usuario['telefono'];
$sexo = $datos_usuario['sexo'];
$fecha_nacimiento = $datos_usuario['fecha_nacimiento'];
$pais = $datos_usuario['pais'];
$biografia = $datos_usuario['biografia'];

// Define el título de la página y comienza la sección principal del contenido
$tituloPagina = 'Edición de loss Datos';
$contenidoPrincipal = <<<EOS
<form class='form-marco' action="includes/src/procesarUsuario/procesarEditarLosDatos.php?id_usuario=$correo" method="POST" enctype="multipart/form-data" onchange="return validarEdicionDatos(this);">
<fieldset>
    <legend>Editar los Datos</legend>
    <div><label>Nombre:</label> <input type="text" name="username" value="{$nombre}"/ required></div><br>
    <div><label>Teléfono:</label> <input type="tel" name="telefono" value="{$telefono}"/ required></div><br>
EOS;

// Crea un conjunto de botones de opción para el género del usuario, estableciendo el botón de opción correspondiente a su género actual como seleccionado por defecto
if($sexo == "Hombre"){
    $contenidoPrincipal .= "<div><label>Género:</label><p id=genero-radio> <input type='radio' name='genero' value='Hombre' checked='checked' /> Hombre <input type='radio' name='genero' value='Mujer' /> Mujer <input type='radio' name='genero' value='No binario' /> No binario <input type='radio' name='genero' value='Prefiero no contestar'/> Prefiero no contestar</p></div><br>";
}
else if($sexo == "Mujer"){
    $contenidoPrincipal .= "<div><label>Género:</label><p id=genero-radio> <input type='radio' name='genero' value='Hombre' /> Hombre <input type='radio' name='genero' value='Mujer'checked='checked' /> Mujer <input type='radio' name='genero' value='No binario' /> No binario <input type='radio' name='genero' value='Prefiero no contestar'/> Prefiero no contestar</p></div><br>";
}
else if($sexo == "No binario"){
    $contenidoPrincipal .= "<div><label>Género:</label><p id=genero-radio> <input type='radio' name='genero' value='Hombre' /> Hombre <input type='radio' name='genero' value='Mujer' /> Mujer <input type='radio' name='genero' value='No binario' checked='checked'/> No binario <input type='radio' name='genero' value='Prefiero no contestar'/> Prefiero no contestar</p></div><br>";
}
else if($sexo == "Prefiero no contestar"){
    $contenidoPrincipal .= "<div><label>Género:</label><p id=genero-radio> <input type='radio' name='genero' value='Hombre' /> Hombre <input type='radio' name='genero' value='Mujer' /> Mujer <input type='radio' name='genero' value='No binario' /> No binario <input type='radio' name='genero' value='Prefiero no contestar' checked='checked' /> Prefiero no contestar</p></div><br>";
}

// Muestra el contenido principal y lo imprime por pantalla
$contenidoPrincipal .= "<div><label>Fecha de nacimiento:</label> <input type='date' name='fecha' value='{$fecha_nacimiento}' /></div><br>
    <div><label>País:</label> <input type='text' name='pais' value='{$pais}'/ required></div><br>
    <div><label>Biografía:</label> <textarea name='biografia' class='cuadro-input'>{$biografia}</textarea></div><br>
    <br/><label>Foto de perfil:</label> <input type='file' name='foto_perfil' id='foto_perfil'> <br>
    <br/><button type='submit'>Guardar</button>
</fieldset>";

require ('./includes/vistas/plantillas/plantilla.php');
?>