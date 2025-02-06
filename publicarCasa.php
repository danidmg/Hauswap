<?php
require_once 'includes/config.php';

$tituloPagina = 'Publicar';
$contenidoPrincipal=<<<EOS
<form class='form-marco' action="includes/src/procesarPropiedades/procesarPublicarCasa.php" method="POST" enctype="multipart/form-data">
<fieldset>
    <legend>Nueva propiedad</legend>
    <div><label>Nombre:</label> <input type="text" name="nombre" required/></div><br>
    <div><label>Localización:</label> <input type="text" name="localizacion" required/></div><br>
    <div><label>Descripción:</label><textarea name="descripcion" class="cuadro-input" required></textarea></div><br>
    <div><label>Imagen:</label> <input type="file" name="imagen" id="imagen" required></div><br>
</form>
    <input type="submit" value="Publicar">
</fieldset>
EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>
