<?php
require_once 'includes/config.php';
require_once 'includes/src/clases/Propiedad.php';

// Obtener los datos de la base de datos 

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['login'])) {
    //Si el usuario no ha iniciado sesión, seleccionar todas las propiedades
    $sql = "SELECT id_casa, nombre, servidor_fotos FROM propiedades";
} else {
    // Si el usuario ha iniciado sesión, seleccionar todas las propiedades excepto las del usuario
    $sql = "SELECT id_casa, nombre, servidor_fotos FROM propiedades WHERE id_usuario != '{$_SESSION["nombre"]}'";
}

$result = $conn->query($sql);
$tituloPagina = 'Index';

$contenidoPrincipal = "";

if (isset($_SESSION['login'])){
    // Si el usuario es un administrador, añadir un botón para acceder al panel de administración
    if (isset($_SESSION['esAdmin'])){
        $contenidoPrincipal .= "<div class='botonAdminIndex'><a href= admin.php><button type=button>Panel de Administración</button></a></div>";
    }
}

// Añadir un formulario de búsqueda en la página
$contenidoPrincipal .= <<<EOS
  <form action="buscar.php" method="POST" id="buscar">
  <input type="text" id="termino" name="termino" placeholder=" ¿Dónde vas?">
  <button type="submit">Buscar</button>
  </form>
  EOS;

// Si se han encontrado propiedades en la base de datos
if ($result->num_rows > 0) {

    // Añadir un slideshow con las imágenes de las propiedades
    $contenidoPrincipal .= "
    
    <div class='slideshow-container'>";
    $i = 0;

    while($row = $result->fetch_assoc()) {
        $i++;
        $id_casa = $row['id_casa'];
        $servidor_fotos = $row['servidor_fotos'];
        $nombre = $row['nombre'];

        $contenidoPrincipal .= "
            <div class='slider fade'>
                <a href='mostrarCasa.php?casa=" . $id_casa . "'>
                <img src='". $servidor_fotos ."' alt='Imagen de la propiedad'>
                </a>
                <div class='nombre-casa'>". $nombre ."</div>
            </div>
        ";
    }

    // Añadir botones para avanzar y retroceder en el slideshow
    $contenidoPrincipal .= "
        <a class='prev' onclick='siguiente(-1)'>❮</a>
        <a class='next' onclick='siguiente(1)'>❯</a>
        </div>
        <br>

        <div class='puntos'>
    ";

    // Añadir puntos para indicar la posición actual del slideshow
    $j = 0;
    while($j < $i){
        $j++;

        $contenidoPrincipal.= "<span class='punto' onclick='actual(". $j .")'></span>";
    }

    $contenidoPrincipal .= "</div>
    <script>mostrar(1);</script>
    ";

    // Añadir una sección con las propiedades mejor valoradas


    // Obtener todas las propiedades que no son del propio usuario
    $propiedades = Propiedad::devuelveRestodePropiedades();

    // Función de comparación para ordenar por estrellas de forma descendente
    function compararPorEstrellas($propiedad1, $propiedad2) {
        return $propiedad2->getEstrellas() - $propiedad1->getEstrellas();
    }
    
    // Ordenar el array de propiedades por estrellas
    usort($propiedades, 'compararPorEstrellas');

    // Obtener las tres primeras propiedades del array ordenado
    $mejoresPropiedades = array_slice($propiedades, 0, 3);

    $contenidoPrincipal .= "<div class='mejor-valoradas'>
    <h2>CASAS MEJOR VALORADAS</h2>";

    // Mostrar las tres mejores propiedades
    foreach ($mejoresPropiedades as $propiedad) {
        $id_casa = $propiedad->getIdCasa();
        $nombre = $propiedad->getNombre();
        $estrellas = $propiedad->getEstrellas();
        $foto = $propiedad->getFoto();
        
        $contenidoPrincipal .= 
        "<div class='mejor-casa'>
            <a href='mostrarCasa.php?casa=$id_casa'>
            <img src='$foto' alt='Imagen de la propiedad'>
            <p>$nombre $estrellas/5</p>
            </a>
        </div>";
                     
    }
    $contenidoPrincipal .=  "</div>";


    $contenidoPrincipal .= "
       <div class= 'como-funciona'>
       <h2>CÓMO FUNCIONA HAUSWAP</h2>
       <p>HauSwap es una web de intercambio de casas que te permitirá alojarte en residencias privadas de todo el mundo y poner tu propia casa a disposición de otros viajeros, intercambiando así vuestras casas simultáneamente. ¡Una forma única de viajar ahorrando dinero!<br><br>

       Publica tu casa, adjuntando fotos o videos, una descripción e información sobre experiencias que recomiendas. Busca casas en tus destinos favoritos donde quieras experimentar una vida diferente o desconectar. Cuando estés interesado en hacer swap con otra propiedad, usa el chat para contactar con el otro propietario. Al terminar el swap, podrás valorar la experiencia.<br><br>
       
       Podrás elegir entre miles de casas y asegurarte de que eliges un entorno cómodo y familiar. Ya sea que estés buscando una casa en la playa, un apartamento en la ciudad o una cabaña en el bosque…<br><br>
       
       HauSwap es segura y fácil de usar, y te permite comunicarte directamente con otros propietarios antes del swap. Fomenta la creación de vínculos, la hospitalidad, confianza y respeto.<br><br>
       </p>
       </div>
    ";
    $result->free();
}

$contenidoPrincipal .= <<<EOS
EOS;

require('./includes/vistas/plantillas/plantilla.php');

?>