<?php
require_once 'includes/config.php';
require_once 'includes/src/clases/Valoracion.php';
require_once 'includes/src/clases/Usuario.php';

$id_casa = $_GET["casa"];
$id_usuario = "";

$sql = "SELECT nombre, descripcion, servidor_fotos, id_usuario FROM propiedades WHERE id_casa = $id_casa";

$result = $conn->query($sql);
$tituloPagina = 'Mostrar Casa';
$contenidoPrincipal = "";
$datos_valoracion ="";

if ($result->num_rows > 0) {
    //recogemos la informacion de la propiedad
    while ($row = $result->fetch_assoc()) {
        $id_usuario = $row['id_usuario']; // Guardar el id_usuario 
        $servidor_fotos = $row['servidor_fotos'];
        $nombre_casa = $row['nombre'];
        $descripcion = $row['descripcion'];

        $sql2 = "SELECT nombre, biografia, pais, sexo, servidor_fotoperfil FROM usuarios WHERE correo = '$id_usuario'";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
            //recogemos la informacion del propietario de la propiedad
            while ($row2 = $result2->fetch_assoc()) {
                $sexo = $row2["sexo"];
                $pais = $row2["pais"];
                $biografia = $row2["biografia"];
                $nombre = $row2["nombre"];
                $servidor_fotoperfil = $row2["servidor_fotoperfil"];

                //mostramos la info de la propiedad 
                $contenidoPrincipal .= "<h2>" . $nombre_casa . "</h2>" .
                    "<div id='estructura-divs'>
                <div id='fotos-div'><img src='" . $servidor_fotos . "' alt='Imagen de la propiedad' id='imagenes-pagina'><br></div>";

                //mostramos la info del propietario de dicha propiedad
                $contenidoPrincipal .= "<div id='datos-propietario'><img src='" . $servidor_fotoperfil ."' alt='Foto de perfil' id='foto-perfil-mostrarcasa'><h2>" . "Datos de " . $nombre . "</h2>" .
                    "<strong>Biografía: </strong>" . "<p>" . $biografia ."<br>" . "<strong>País: </strong>" . $pais . "<br>" . "<strong>Género: </strong>" . $sexo . "<br>" . "</p></div></div>";
            }
            //liberamos memoria
            $result2->free();
        }
    }
}

$contenidoPrincipal .= "<div id='div-mostrar'><p>" . $descripcion . "</p></div>
<a href= reservar.php?casa1=".$id_casa."><button type=button>Reserva ahora</button></a>" .
"<a href=chatConversacion.php?correoContacto=$id_usuario><button type=button>Chatea</button></a>";

//VALORACIONES
$five_star_percentage = 0;
$four_star_percentage = 0;
$three_star_percentage = 0;
$two_star_percentage = 0;
$one_star_percentage = 0;
$average_rating = 0;
$total_five_star_review = 0;
$total_four_star_review = 0;
$total_three_star_review = 0;
$total_two_star_review = 0;
$total_one_star_review = 0;

$valoraciones = Valoracion::getValoraciones($id_casa);
$average_rating = Valoracion::calcula($id_casa, $five_star_percentage, $four_star_percentage, $three_star_percentage, $two_star_percentage, $one_star_percentage, $total_five_star_review, $total_four_star_review, $total_three_star_review, $total_two_star_review, $total_one_star_review);
$cuantas = Valoracion:: contar($id_casa);

foreach ($valoraciones as $valoracion) {

    $usuario = Usuario::buscaUsuario($valoracion->getUsuario());

    $datos_valoracion .= "
    <div class='div-datos'>
        <div class='val-imgg'><img src='{$usuario->getFotoPerfil()}' alt='Foto de perfil' id='foto-perfil-mostrarcasa'></div>
        <h2>{$usuario->getNombre()}, {$valoracion->getFecha()}</h2>
        <div class='div-datos-estrellas'>";

        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $valoracion->getEstrella()) {
                $datos_valoracion .= "<i class='fas fa-star star-yellow mr-1'></i>"; // estrella amarilla
            } else {
                $datos_valoracion .= "<i class='fas fa-star star-light mr-1'></i>"; // estrella gris
            }
        }
    $datos_valoracion .= "</div>    
        <h3>{$valoracion->getOpinion()}</h3>

    </div>";
}

$num_stars = round($average_rating);

//mostramos por pantalla los datos que hemos ido obteniendo
$contenidoPrincipal .= "
<div class='container-grande-valoraciones'>
    <div class='card'>
        <div class='card-header'>
            <h1>Valoraciones</h1>
        </div>
        <div class='card-body'>
            <div class='row'>
                <div class='col-sm-4 text-center'>
                    <h1 class='text-warning mt-4 mb-4'>
                        <b><span id='average_rating'>$average_rating</span> / 5</b>
                    </h1>
                    ";
                    $num_stars = round($average_rating); // redondea el promedio a un número entero
                    for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $num_stars) {
                    $contenidoPrincipal .= "<i class='fas fa-star star-yellow mr-1 main_star'></i>"; // estrella amarilla
                    } else {
                    $contenidoPrincipal .= "<i class='fas fa-star star-light mr-1 main_star'></i>"; // estrella gris
                    }
                    }
                    $contenidoPrincipal .= "
                </div>
            </div>
        </div>
        <h3><span id='total_review'>$cuantas</span> Reseñas</h3>
    </div>
    <div class='col-sm-4'>
    <p>
    <div class='progress-label-left'><b>5</b> <i class='fas fa-star text-warning'></i></div>
    <div class='progress-label-right'>(<span>$total_five_star_review</span>)</div>
    <div class='progress'>
        <progress class='progress-bar-bg-warning' id='five_star_progress'  max='100' value= $five_star_percentage ></progress>
    </div>
    </p>
    <br>
    <p>
    <div class='progress-label-left'><b>4</b> <i class='fas fa-star text-warning'></i></div>
    <div class='progress-label-right'>(<span>$total_four_star_review</span>)</div>
    <div class='progress'>
        <progress class='progress-bar-bg-warning' id='five_star_progress'  max='100' value= $four_star_percentage ></progress>
    </div>
    </p>
    <br>
    <p>
    <div class='progress-label-left'><b>3</b> <i class='fas fa-star text-warning'></i></div>
    <div class='progress-label-right'>(<span>$total_three_star_review</span>)</div>
    <div class='progress'>
        <progress class='progress-bar-bg-warning' id='five_star_progress'  max='100' value= $three_star_percentage ></progress>
    </div>
    </p>
    <br>
    <p>
    <div class='progress-label-left'><b>2</b> <i class='fas fa-star text-warning'></i></div>
    <div class='progress-label-right'>(<span>$total_two_star_review</span>)</div>
    <div class='progress'>
        <progress class='progress-bar-bg-warning' id='five_star_progress'  max='100' value= $two_star_percentage ></progress>
    </div>
    </p>
    <br>
    <p>
    <div class='progress-label-left'><b>1</b> <i class='fas fa-star text-warning'></i></div>
    <div class='progress-label-right'>(<span>$total_one_star_review</span>)</div>
    <div class='progress'>
        <progress class='progress-bar-bg-warning' id='five_star_progress'  max='100' value= $one_star_percentage ></progress>
    </div>
    </p>
    </div>
    </div>
    <div class='valoraciones'>
        $datos_valoracion
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>";

require('./includes/vistas/plantillas/plantilla.php');

?>

