<?php

$tituloPagina = 'Administrador';

$contenidoPrincipal=<<<EOS
<div class="bienvenidoAdmin"><h1>Bienvenido al Panel de Administración</h1></div>
<div class="adminPanelContainer">
            <div class="card">
                <div class="face face1">
                    <div class="content">
                    <img src="resources/management.png">
                        <h3>Usuarios</h3>
                    </div>
                </div>
                <div class="face face2">
                    <div class="content">
                        <p>Edita los datos, cambia la contraseña o elimina la cuenta de los usuarios.</p>
                            <a href="gestionarUsuarios.php">Acceder</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="face face1">
                    <div class="content">
                        <img src="resources/home.png">
                        <h3>Propiedades</h3>
                    </div>
                </div>
                <div class="face face2">
                    <div class="content">
                        <p>Edita o elimina las propiedades publicadas en Hauswap.</p>
                            <a href="gestionarPropiedades.php">Acceder</a>
                    </div>
                </div>
            </div>
			      <div class="card">
                <div class="face face1">
                    <div class="content">
                        <img src="resources/gear.png">
                        <h3>Valoraciones</h3>
                    </div>
                </div>
                <div class="face face2">
                    <div class="content">
                        <p>Gestiona las valoraciones, con la posibilidad de eliminarlas si el contenido no es apropiado.</p>
                            <a href="gestionarValoraciones.php">Acceder</a>
                    </div>
                </div>
            </div>
			      <div class="card">
                <div class="face face1">
                    <div class="content">
                        <img src="resources/transfer.png">
                        <h3>Reservas</h3>
                    </div>
                </div>
                <div class="face face2">
                    <div class="content">
                        <p>Accede a los detalles de todas las reservas, con la posibilidad de eliminarlas.</p>
                            <a href="gestionarReservas.php">Acceder</a>
                    </div>
                </div>
            </div>
        </div>

<a href="index.php" class="volverLink">
  <button class="volverButton" type="button">Volver al Inicio</button>
</a>

EOS;

require ('./includes/vistas/plantillas/plantilla.php');
?>
