<?php
require_once 'includes/config.php';
require_once 'includes/src/clases/Propiedad.php';

$id_casa = (int)$_GET['id_casa'];
$datos_casa =Propiedad::datos($id_casa);

$nombre = $datos_casa['nombre'];
$localizacion = $datos_casa['localizacion'];
$servidor_fotos = $datos_casa['servidor_fotos'];
$descripcion = $datos_casa['descripcion'];

//lo he modifcado porq me salian warnings de que no estaban definidas pero ns si es mi ord o es en general
/*if (!empty($datos_casa)) {
    $nombre = isset($datos_casa['nombre']) ? $datos_casa['nombre'] : '';
    $localizacion = isset($datos_casa['localizacion']) ? $datos_casa['localizacion'] : '';
    $servidor_fotos = isset($datos_casa['servidor_fotos']) ? $datos_casa['servidor_fotos'] : '';
    $descripcion = isset($datos_casa['descripcion']) ? $datos_casa['descripcion'] : '';
} else {
    
    $nombre = '';
    $localizacion = '';
    $servidor_fotos = '';
    $descripcion = '';
}*/

$tituloPagina = 'Edición de Mi Propiedad';
$contenidoPrincipal = <<<EOS
<form class='form-marco' action="includes/src/procesarPropiedades/procesarEditarCasa.php?id_casa=$id_casa" method="POST" enctype="multipart/form-data">
<fieldset><br>
    <div><label>Nombre:</label> <input type="text" name="nombre" value="{$nombre}" / required></div><br>
    <div><label>Localización:</label> <input type="text" name="localizacion" value="{$localizacion}" / required></div><br>
    <div><label>Imagen:</label> <input type="file" name="servidor_fotos" value="{$servidor_fotos}" /></div><br>
    <div><label>Descripción:</label><textarea name="descripcion" class="cuadro-input" required>{$descripcion}</textarea></div><br>
    <button type="submit">Guardar</button>
</fieldset>
</form>
EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>


