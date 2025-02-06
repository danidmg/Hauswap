<?php
		$mostrarMenu = false; //variable para mostrar Menu
        if (isset($_POST['mostrarOcultar'])) {
            $mostrarMenu = ! $mostrarMenu; //cambia el valor
        }  
        
// Crear una cookie para la variable y obtener el valor actual de $mostrarMenu de la cookie, si existe
if (isset($_COOKIE['mostrarMenu'])) {
    $mostrarMenu = $_COOKIE['mostrarMenu'] == 'true';
} else {
    $mostrarMenu = false;
}
// Actualizar el valor de $mostrarMenu si se envió el formulario, para que muestre o deje de mostrar
if (isset($_POST['mostrarOcultar'])) {
    $mostrarMenu = !$mostrarMenu;
    setcookie('mostrarMenu', $mostrarMenu ? 'true' : 'false', time() + 3600, '/');
}
// Mostrar Menu cuando se haga click en el botón
if ($mostrarMenu)
    require('menu.php');
?>


<header id="cabecera">
                <a href="./index.php">
                    <img src="./resources/logo.png"  alt="Logo" height="80" id="logo-cabecera">
                </a>
                
                <a href="./index.php">
                <img src="./resources/nombre.png"    alt="Nombre" height="80" id="nombre-cabecera">
                </a>
       
                <!--Botón-->
                <form method="post">
                    <button type="submit" name="mostrarOcultar" id="menu-cabecera">
                            <img src="./resources/menu.png" alt="Menu" height="70" width="70" id="boton-menu-cabecera">
                    </button>
                </form>
     </header>
