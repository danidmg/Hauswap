<?php
//No te puedes meter a tu cuenta sin haber Iniciado Sesión
require_once 'includes/config.php';
require_once 'includes/src/clases/Usuario.php';
require_once 'includes/src/clases/Reserva.php';
require_once 'includes/src/clases/Valoracion.php';



//Sesión Iniciada
if (isset($_SESSION["login"])) {
    $admin = "SELECT * FROM usuarios WHERE correo = '${_SESSION["nombre"]}'";
    $resultado = $conn->query($admin);

    $id_usuario = $_SESSION["nombre"];
    $sql = "SELECT * FROM propiedades WHERE  id_usuario = '${_SESSION["nombre"]}'";
    $result = $conn->query($sql);
    $propiedades = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombre = $row['nombre'];
            $localizacion = $row['localizacion'];
            $servidor_fotos = $row['servidor_fotos'];
            $descripcion = $row['descripcion'];
            $id_casa = $row['id_casa'];

            $propiedades .= "<h4>" . $nombre . " en " . $localizacion . "</h4>" . "<div id='div-propiedades'>" . '<img src="' . $servidor_fotos . '"
            alt="Imagen de la propiedad" id="imagenes-mis-propiedades"><div class="descripcion-propiedad"><p>' . $descripcion . "</p></div>" .
                "<a href='editarCasa.php?id_casa=" . $id_casa . "'><button id='boton-editar-propiedad' type='button'>Editar</button></a><br>" .
                "<button id='boton-eliminar-propiedad' type='button'name='delete' onclick='eliminarPropiedad($id_casa)'>Eliminar</button></a></div>";

        }
        $result->free();
    } else {
        $propiedades = "No tienes propiedades publicadas";
    }

//RESERVAS SALIENTES

    $sql = "SELECT p2.id_casa, p2.nombre AS nombre2, p.nombre, r.id_casa1, p.servidor_fotos, p.descripcion, r.fecha_entrada, r.fecha_salida, r.estado, r.id_reserva
    FROM reservas r 
    JOIN propiedades p ON r.id_casa1 = p.id_casa 
    JOIN propiedades p2 ON r.id_casa2 = p2.id_casa
    JOIN usuarios u ON p2.id_usuario = u.correo
    WHERE u.correo = '${_SESSION["nombre"]}' AND r.estado != 'COMPLETADA'"; 
    //p es la propiedad que reservas y p2 tus casas
    $hoy = date('Y-m-d');

    $result= $conn->query($sql);
    $reservas = '';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $fecha_entrada = $row['fecha_entrada'];
            $fecha_salida = $row['fecha_salida'];
            $estado = $row['estado'];
            $id_reserva = $row['id_reserva'];
            $servidor_fotos = $row['servidor_fotos'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $id_casa1 = $row['id_casa1'];
            $id_casa = $row['id_casa'];
            $nombre2 = $row['nombre2'];

            // Si la reserva es posterior a hoy la pone completada 
            if ((strtotime($fecha_salida) < strtotime($hoy)) && ($estado != 'COMPLETADA')){
                 Reserva::actualizaEstado($id_reserva, 'COMPLETADA');
            }

            else{
                $reservas .= "<div id='div-reservas'><div id=reservas-vertical><img src='" . $servidor_fotos . "' alt='Imagen de la propiedad' id='imagenes-mis-reservas'>" ;

                //Estado de la reserva recuadro
                if($estado=='PENDIENTE'){
                    $reservas .= "<div id=estado-pendiente><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }
                else if($estado=='ACEPTADA'){
                    $reservas .= "<div id=estado-aceptada><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }
                else if($estado=='RECHAZADA'){
                    $reservas .= "<div id=estado-rechazada><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }
                else if($estado=='COMPLETADA'){
                    $reservas .= "<div id=estado-completada><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }

                //Parte común
                $reservas .="<div class='descripcion-propiedad'><h4>" . $nombre . "</h4><p>" . $descripcion . "</p>" ;

                // Según Estado de la Reserva
                if($estado=='PENDIENTE'){
                    if ($id_casa1==$id_casa)// Es tu casa la que quieren reservar
                    {
                    $reservas .="<h4 id='texto_reservas'>Quieres intercambiar tu" . $nombre2 . "con esta casa del " . $fecha_entrada . " al " . $fecha_salida . "?</h4></div>" .
                    "<a href='includes/src/procesarPropiedades/estadoReserva.php?id_reserva=" . $id_reserva . "&nuevo_estado=ACEPTADA'><button id='boton-aceptar-reserva' type='button'>Aceptar</button></a>" .
                    "<a href='includes/src/procesarPropiedades/estadoReserva.php?id_reserva=" . $id_reserva . "&nuevo_estado=RECHAZADA'><button id='boton-rechazar-reserva' type='button'>Rechazar</button></a><br></div>";
                    }
                    else{
                        $reservas .="<h4 id='texto_reservas'>Has solicitado el intercambio de tu " . $nombre2 . " con esta casa del " . $fecha_entrada . " al " . $fecha_salida . "</h4><br>" .
                        // <a href='includes/src/procesarPropiedades/eliminarReserva.php?id_reserva=" . $id_reserva . "'>
                        "<button id='boton-eliminar-reserva' type='button' onclick='eliminarReserva($id_reserva)'>Cancelar</button></a></div></div>";
                    }
                }
                else if ($estado=='ACEPTADA'){
                    $reservas .="<h4 id='texto_reservas'>Has hecho un intercambio de tu " . $nombre2 . " con esta casa del " . $fecha_entrada . " al " . $fecha_salida . "</h4></div><br></div>";
                }
                else if ($estado=='COMPLETADA'){
                    $reservas .="<h4 id='texto_reservas'>Esta reserva se ha completado! Pronto aparecerá en tus intercambios</h4></div><br></div>";
                }
                else if ($estado=='RECHAZADA'){
                    $reservas .= "<h4 id='texto_reservas'>Lo sentimos mucho! Tu reserva ha sido rechazada :( </h4>" . 
                    // <a href='includes/src/procesarPropiedades/eliminarReserva.php?id_reserva=" . $id_reserva . "'>
                    "<button id='boton-eliminar-reserva' type='button' onclick='eliminarReserva($id_reserva)'>Eliminar</button></a></div><br></div>";     
                }
            }     
        } 
        $result->free();
    }else {
        $reservas .= "No tienes reservas salientes";

    }




    //RESERVAS ENTRANTES

    $sql = "SELECT p2.id_casa, p2.nombre AS nombre2, p.nombre, r.id_casa1, p.servidor_fotos, p.descripcion, r.fecha_entrada, r.fecha_salida, r.estado, r.id_reserva
    FROM reservas r 
    JOIN propiedades p ON r.id_casa2 = p.id_casa 
    JOIN propiedades p2 ON r.id_casa1 = p2.id_casa
    JOIN usuarios u ON p2.id_usuario = u.correo
    WHERE u.correo = '${_SESSION["nombre"]}' AND r.estado != 'COMPLETADA' AND r.estado != 'RECHAZADA'"; 
    //p es la propiedad que reservas y p2 tus casas
    $hoy = date('Y-m-d');

    $result= $conn->query($sql);
    $reservas1 = '';
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $fecha_entrada = $row['fecha_entrada'];
            $fecha_salida = $row['fecha_salida'];
            $estado = $row['estado'];
            $id_reserva = $row['id_reserva'];
            $servidor_fotos = $row['servidor_fotos'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $id_casa1 = $row['id_casa1'];
            $id_casa = $row['id_casa'];
            $nombre2 = $row['nombre2'];

            // Si la reserva es posterior a hoy la pone completada 
            if ((strtotime($fecha_salida) < strtotime($hoy)) && ($estado != 'COMPLETADA')){
                 Reserva::actualizaEstado($id_reserva, 'COMPLETADA');
            }

            else{
                $reservas1 .= "<div id='div-reservas'><div id=reservas-vertical><img src='" . $servidor_fotos . "' alt='Imagen de la propiedad' id='imagenes-mis-reservas'>" ;

                //Estado de la reserva recuadro
                if($estado=='PENDIENTE'){
                    $reservas1 .= "<div id=estado-pendiente><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }
                else if($estado=='ACEPTADA'){
                    $reservas1 .= "<div id=estado-aceptada><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }
                else if($estado=='RECHAZADA'){
                    $reservas1 .= "<div id=estado-rechazada><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }
                else if($estado=='COMPLETADA'){
                    $reservas1 .= "<div id=estado-completada><p id=estado>" . "Estado: " .  $estado .  "</p></div></div>" ;
                }

                //Parte común
                $reservas1 .="<div class='descripcion-propiedad'><h4>" . $nombre . "</h4><p>" . $descripcion . "</p>" ;

                // Según Estado de la Reserva
                if($estado=='PENDIENTE'){
                    if ($id_casa1==$id_casa)// Es tu casa la que quieren reservar
                    {
                    $reservas1 .="<h4 id='texto_reservas'>Quieres intercambiar tu " . $nombre2 . " con esta casa del " . $fecha_entrada . " al " . $fecha_salida . "?</h4></div>" .
                    "<a href='includes/src/procesarPropiedades/estadoReserva.php?id_reserva=" . $id_reserva . "&nuevo_estado=ACEPTADA'><button id='boton-aceptar-reserva' type='button'>Aceptar</button></a>" .
                    "<a href='includes/src/procesarPropiedades/estadoReserva.php?id_reserva=" . $id_reserva . "&nuevo_estado=RECHAZADA'><button id='boton-rechazar-reserva' type='button'>Rechazar</button></a><br></div>";
                    }
                    else{
                        $reservas1 .="<h4 id='texto_reservas'>Has solicitado el intercambio de tu " . $nombre2 . " con esta casa del " . $fecha_entrada . " al " . $fecha_salida . "</h4><br><br>" . 
                        // <a href='includes/src/procesarPropiedades/eliminarReserva.php?id_reserva=" . $id_reserva . "'><button id='boton-eliminar-reserva' type='button'>Cancelar</button></a></div></div>";
                        "<button id='boton-eliminar-reserva' type='button' onclick='eliminarReserva($id_reserva)'>Cancelar</button></a></div></div>";

                    }
                        
                }
                else if ($estado=='ACEPTADA'){
                    $reservas1 .="<h4 id='texto_reservas'>Has hecho un intercambio de tu " . $nombre2 . " con esta casa del " . $fecha_entrada . " al " . $fecha_salida . "</h4></div><br></div>";
                }
                else if ($estado=='COMPLETADA'){
                    $reservas1 .="<h4 id='texto_reservas'>Esta reserva se ha completado! Pronto aparecerá en tus intercambios</h4></div><br></div>";
                }
                else if ($estado=='RECHAZADA'){
                    $reservas1 .= "<h4 id='texto_reservas'>Lo sentimos mucho! Tu reserva ha sido rechazada :( </h4>" .
                    // <a href='includes/src/procesarPropiedades/eliminarReserva.php?id_reserva=" . $id_reserva . "'><button id='boton-eliminar-reserva' type='button'>Eliminar</button></a></div><br></div>";     
                    "<button id='boton-eliminar-reserva' type='button'>Eliminar</button></a></div><br></div>";
                }
            }     
        } 
        $result->free();
    }else {
        $reservas1 .= "No tienes reservas entrantes";

    }

//INTERCAMBIOS

    $sql = "SELECT p.nombre, p.servidor_fotos, p.descripcion, r.id_reserva, r.fecha_entrada, r.fecha_salida, p.id_casa
    FROM propiedades p
    JOIN reservas r ON p.id_casa = r.id_casa1
    JOIN propiedades p2 ON r.id_casa2 = p2.id_casa
    JOIN usuarios u ON p2.id_usuario = u.correo
    WHERE u.correo = '${_SESSION["nombre"]}' AND r.estado = 'COMPLETADA'
    UNION
    SELECT p.nombre, p.servidor_fotos, p.descripcion, r.id_reserva, r.fecha_entrada, r.fecha_salida, p.id_casa
    FROM propiedades p
    JOIN reservas r ON p.id_casa = r.id_casa2
    JOIN propiedades p2 ON r.id_casa1 = p2.id_casa
    JOIN usuarios u ON p2.id_usuario = u.correo
    WHERE u.correo = '${_SESSION["nombre"]}' AND r.estado = 'COMPLETADA'";


    $result = $conn->query($sql);
    $intercambios = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombre = $row['nombre'];
            $servidor_fotos = $row['servidor_fotos'];
            $fecha_entrada = $row['fecha_entrada'];
            $fecha_salida = $row['fecha_salida'];
            $descripcion = $row['descripcion'];
            $id_reserva = $row['id_reserva'];
            $id_casa = $row['id_casa'];

            $intercambios .= "<h4>" . $nombre . "</h4>" . "<div id='div-intercambios'>" . '<img src="' . $servidor_fotos . '"
            alt="Imagen de la propiedad" id="imagenes-mis-intercambios"> <h4>Fuiste del ' .  $fecha_entrada . ' al ' . $fecha_salida . '</h4>
            <div class="descripcion-propiedad"><p>' . $descripcion . "</p></div>";
            if(!Valoracion::buscaValoracion($id_reserva, $id_usuario)){
                $intercambios .="<a href='valorar.php?id_casa=" . $id_casa . "&id_intercambio=" . $id_reserva . "'><button id='boton-valorar-intercambio' button type='button'>Valorar</button></a><br>" . "</div>";
            }else{
                $intercambios .= "<div id = texto-div>" . "Ya has valorado el intercambio" . "</div></div>";
            }

        }
        $result->free();
    } else {
        $intercambios .= "No has realizado intercambios";
    }

    


    $sql = "SELECT correo, nombre, telefono, sexo, fecha_nacimiento, pais, fecha_registro, biografia, servidor_fotoperfil FROM usuarios WHERE correo = '${_SESSION["nombre"]}'";

    $result = $conn->query($sql);
    $datos = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $correo = $row["correo"];
            $telefono = $row["telefono"];
            $fecha_nacimiento = $row["fecha_nacimiento"];
            $sexo = $row["sexo"];
            $pais = $row["pais"];
            $biografia = $row["biografia"];
            $servidor_fotoperfil = $row["servidor_fotoperfil"];
            $nombre = $row["nombre"];

            $datos .= "<div id ='div-datos'> <img src='" . $servidor_fotoperfil ."' alt='Foto de perfil' id='foto-perfil'>
                <p><strong>" . "Correo: </strong>" . $correo . "<br><strong>Nombre:  </strong>" . $nombre
                . "<br><strong>Teléfono: </strong>" . $telefono . "<br><strong>Género: </strong>" . $sexo .
                "<br><strong>Fecha de nacimiento: </strong>" . $fecha_nacimiento . "<br><strong>País: </strong>" . $pais . "<br><strong>Biografía: </strong>" . $biografia . "<br>" . "</p></div>";
        }
        $result->free();
    } else {
        $datos = "No hay datos del usuario";
    }

    //MIS VALORACOINES

    $sql = "SELECT id_valoracion, id_casa, id_reserva, estrellas, opinion, fecha FROM valoraciones WHERE id_usuario = '${_SESSION["nombre"]}'";

    $result = $conn->query($sql);
    $valoraciones = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_valoracion = $row["id_valoracion"];
            $id_casa = $row["id_casa"];
            $id_reserva = $row["id_reserva"];
            $estrellas = $row["estrellas"];
            $opinion = $row["opinion"];
            $fecha = $row["fecha"];

            $sql2 = "SELECT * FROM propiedades WHERE id_casa = '$id_casa'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    $nombre = $row2["nombre"];
                    $valoraciones .= "<div id ='div-valoracion'> <p><strong>Nombre de la casa: </strong>" . $nombre . "<br><strong>Estrellas: </strong>" . $estrellas . "<br><strong>Opinión: </strong>" . $opinion .
                    "<br><strong>Fecha: </strong>" . $fecha . "<br>" . "</p>" . 
                    "<button id='boton-eliminar-valoracion' type='button'name='delete' onclick='eliminarValoracion($id_valoracion)'>Eliminar</button></a></div>";

                }
            }
        }
        $result->free();
    } else {
        $valoraciones = "No hay valoraciones del usuario";
    }
    


    $mensaje = "Bienvenido/a a tu cuenta {$_SESSION["nombre"]}";
    $tituloPagina = 'MiCuenta';
    $contenidoPrincipal = <<<EOS
    <h3>MIS DATOS</h3>
    $datos
    <br>    
    EOS;

    if (!isset($_SESSION['esAdmin'])) {
        $contenidoPrincipal .= <<<EOS
        <a href="edicionLosDatos.php?id_usuario=$id_usuario"><button type="button">Editar mis datos</button></a>
        <a href="cambiarContrasena.php?id_usuario=$id_usuario"><button type=\"button\">Cambiar contraseña</button></a>
        <button id='boton-eliminar-cuenta' type='button' onclick='eliminarCuenta("$id_usuario")'>Eliminar cuenta</button></a> 
        EOS;
    }

    while ($row1 = $resultado->fetch_assoc()) {
        // usuario estándar
        if ($row1["tipo"] == 2){ 
            $contenidoPrincipal .= "<br>
            <h3>MIS PROPIEDADES</h3>
            $propiedades
            <a href=publicarCasa.php><button type=button>Nueva propiedad</button></a>
            <br>
            <h3>MIS RESERVAS </h3>
            <h4> -Entrantes </h4>
            $reservas1
            <h4> -Salientes </h4>
            $reservas
            <br>
            <h3>MIS INTERCAMBIOS REALIZADOS </h3>
            $intercambios
            <h3>MIS VALORACIONES </h3>
            $valoraciones
            <br>";        
        }
    }

    


    require('./includes/vistas/plantillas/plantilla.php');
}





//Sesión sin Iniciar te lleva a LOGIN
else {
    $mensaje = "Necesitas Iniciar Sesión para acceder a Mi Cuenta";
    echo "<meta http-equiv='refresh' content='0; url=login.php?mensaje=" . $mensaje . "'>";
}
?>