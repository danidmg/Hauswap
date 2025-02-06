<?php

require_once '../../config.php';
require_once '../clases/Valoracion.php';
require_once '../clases/Propiedad.php';


// Capturo las variables
$id_usuario = htmlspecialchars(trim(strip_tags($_SESSION["nombre"]))); 
$id_intercambio = htmlspecialchars(trim(strip_tags($_POST['id_intercambio'])));
$estrellas = htmlspecialchars(trim(strip_tags($_POST['estrellas'])));
$opinion = htmlspecialchars(trim(strip_tags($_POST['opinion'])));
$fecha = date('Y-m-d');
$id_casa = htmlspecialchars(trim(strip_tags($_POST['id_casa'])));
 
//Crea la valoracion en la bd
$valoracion = Valoracion::crea($id_casa, $id_intercambio, $id_usuario, $estrellas, $opinion, $fecha);

//Recalcular la media de estrellas con la nueva valoracion

//Estas variables no hacen falta pero la funcion las devuelve por referencia
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

$average_rating = Valoracion::calcula($id_casa, $five_star_percentage, $four_star_percentage, $three_star_percentage, $two_star_percentage, $one_star_percentage, $total_five_star_review, $total_four_star_review, $total_three_star_review, $total_two_star_review, $total_one_star_review);

$actualizacion = Propiedad::nuevaValoracion($id_casa, $average_rating);



//Mensajes de resultado
if($valoracion){
    $mensaje = "Se ha creado la valoracion correctamente ";
}else{
    $mensaje = "Lo sentimos! Ha habido un error creando la valoracion";
}

// Redirige
if (!isset($_SESSION['esAdmin'])){
    echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
}
else{
    echo "<meta http-equiv='refresh' content='0; url=../../../gestionarValoraciones.php?mensaje=".$mensaje."'>";
}

  

 /* 
if(isset($_POST["action"]))
{
    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;
    $review_content = array();

    $query = "
        SELECT * FROM valoraciones 
        ORDER BY id_valoracion DESC
    ";

    $result = $pdo->query($query);

    foreach($result as $row)
    {
        $review_content[] = array(
            'id_usuario'    =>    $row["id_usuario"],
            'opinion'    =>    $row["opinion"],
            'estrellas'    =>    $row["estrellas"],
            'fecha'    =>    date('l jS, F Y h:i:s A', strtotime($row["fecha"]))
        );

        if($row["estrellas"] == '5')
        {
            $five_star_review++;
        }

        if($row["estrellas"] == '4')
        {
            $four_star_review++;
        }

        if($row["estrellas"] == '3')
        {
            $three_star_review++;
        }

        if($row["estrellas"] == '2')
        {
            $two_star_review++;
        }

        if($row["estrellas"] == '1')
        {
            $one_star_review++;
        }

        $total_review++;

        $total_user_rating = $total_user_rating + $row["estrellas"];

    }

    $average_rating = $total_user_rating / $total_review;

    $output = array(
        'average_rating'    =>    number_format($average_rating, 1),
        'total_review'        =>    $total_review,
        'five_star_review'    =>    $five_star_review,
        'four_star_review'    =>    $four_star_review,
        'three_star_review'    =>    $three_star_review,
        'two_star_review'    =>    $two_star_review,
        'one_star_review'    =>    $one_star_review,
        'review_data'        =>    $review_content
    );

    echo json_encode($output);

}
*/
?>
