<?php
require_once 'includes/config.php';

// Creamos el formulario de búsqueda
$contenidoPrincipal=<<<EOS
  <form action="buscar.php" method="POST" id="buscar">
  <input type="text" id="termino" name="termino" placeholder=" ¿Dónde vas?">
  <button type="submit">Buscar</button>
</form>
EOS;

// Verificamos si se ha enviado un término de búsqueda
if (isset($_POST['termino'])) {
    // Obtenemos el término de búsqueda enviado por el usuario
    $search_term = $_POST['termino'];
    
    // Si no ha iniciado sesión, hacemos una consulta a la base de datos para buscar propiedades
    if(!isset($_SESSION['login'])){
        $sql = "SELECT nombre, localizacion, id_casa, servidor_fotos FROM propiedades WHERE (localizacion LIKE '%$search_term%' OR nombre LIKE '%$search_term%')";
    }
    else{
        // Si ha iniciado sesión, hacemos una consulta a la base de datos para buscar propiedades que no pertenezcan al usuario actual
        $sql = "SELECT nombre, localizacion, id_casa, servidor_fotos FROM propiedades WHERE (localizacion LIKE '%$search_term%' OR nombre LIKE '%$search_term%') AND id_usuario != '{$_SESSION["nombre"]}'";
    }

    // Ejecutamos la consulta y obtenemos el resultado
    $result= $conn->query($sql);


    // Verificamos si se encontraron resultados
    if ($result->num_rows > 0) {
        //$contenidoPrincipal .= "<h1>CASAS QUE COINCIDEN CON LA BÚSQUEDA:</h1>";

         // Recorremos los resultados y los mostramos en pantalla
        while($row = $result->fetch_assoc()) {

            $id_casa = $row['id_casa'];
            $nombre = $row['nombre'];
            $localizacion = $row['localizacion'];
            $servidor_fotos = $row['servidor_fotos'];

            $contenidoPrincipal .= "<h2> <a href = mostrarCasa.php?casa=".$id_casa.">" . $nombre . "</a> en " . $localizacion . "</h2>" .
            "<a href='mostrarCasa.php?casa=".$id_casa."'>
                <img src='" . $servidor_fotos ."' alt='Imagen de la propiedad' id='imagenes-pagina-index'>
            </a>";
        }
        $result->free();
    } 
    else {
        $contenidoPrincipal .= "<h1>No hay casas que coincidan con tu búsqueda</h1><br>";
    }
}
else{

    // Verificamos si el usuario ha iniciado sesión
    if (!isset($_SESSION['login'])) {
        $sql = "SELECT id_casa, nombre, servidor_fotos, localizacion FROM propiedades";
    } else {

        // Si no ha iniciado sesión, hacemos una consulta a la base de datos para obtener todas las propiedades
        $sql = "SELECT id_casa, nombre, servidor_fotos, localizacion FROM propiedades WHERE id_usuario != '{$_SESSION["nombre"]}'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        //$contenidoPrincipal .= "<h1>CASAS QUE COINCIDEN CON LA BÚSQUEDA:</h1>";
        // Recorremos los resultados y los mostramos en pantalla
        while($row = $result->fetch_assoc()) {
            $id_casa = $row['id_casa'];
            $nombre = $row['nombre'];
            $localizacion = $row['localizacion'];
            $servidor_fotos = $row['servidor_fotos'];

            $contenidoPrincipal .= "<h2> <a href = mostrarCasa.php?casa=".$id_casa.">" . $nombre . "</a> en " . $localizacion . "</h2>" .
            "<a href='mostrarCasa.php?casa=".$id_casa."'>
                <img src='" . $servidor_fotos ."' alt='Imagen de la propiedad' id='imagenes-pagina-index'>
            </a>";
        }
        $result->free();
    } 
}

$tituloPagina = 'Búsqueda';

require ('./includes/vistas/plantillas/plantilla.php');
?>
