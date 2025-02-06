<?php
require_once 'includes/config.php';
require_once 'includes/src/clases/Propiedad.php';

$id_casa = (int)$_GET['id_casa'];
$id_intercambio = (int)$_GET['id_intercambio'];

$datos_casa =Propiedad::datos($id_casa);
$localizacion = $datos_casa['localizacion'];
$nombre = $datos_casa['nombre'];

$tituloPagina = 'Valorar';
$contenidoPrincipal ="";

$contenidoPrincipal .= <<<EOS
    <form class='form-marco' action="includes/src/procesarPropiedades/procesarValoracion.php" method="POST" enctype="multipart/form-data" onchange="return validarValoracion(this);">
      <fieldset>
        <legend><br>Mi viaje a $nombre en $localizacion</legend>
        <input type="hidden" name="id_casa" value="$id_casa">
        <input type="hidden" name="id_intercambio" value="$id_intercambio">
        <label for="estrellas">Valoración:</label>
        <div class='nuevaValoracion'>
          <input type="radio" name="estrellas" value="1" class="submit_star" id="submit_star_1" data-estrellas="1"><label for="submit_star_1"></label></input>
          <input type="radio" name="estrellas" value="2" class="submit_star" id="submit_star_2" data-estrellas="2"><label for="submit_star_2"></label></input>
          <input type="radio" name="estrellas" value="3" class="submit_star" id="submit_star_3" data-estrellas="3"><label for="submit_star_3"></label></input>
          <input type="radio" name="estrellas" value="4" class="submit_star" id="submit_star_4" data-estrellas="4"><label for="submit_star_4"></label></input>
          <input type="radio" name="estrellas" value="5" class="submit_star" id="submit_star_5" data-estrellas="5" checked><label for="submit_star_5"></label></input>
        </div>
        <br>
        <label for="opinion">Comentario:</label>
        <textarea name="opinion" id="opinion" rows="4" cols="50"></textarea>
        <br><br>
        <input type="submit" value="Enviar" id="save-review">
        <br><br>
      </fieldset>
    </form>
EOS;



require ('./includes/vistas/plantillas/plantilla.php');
?>
