<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/estilos.css" />
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<script src="https://kit.fontawesome.com/c26d45708e.js" crossorigin="anonymous"></script>
	<title><?= $tituloPagina ?></title>
	<script src="js/functions.js"></script>
	<script src="js/chat.js"></script>
</head>
<body>
<div id="contenedor">
<?php
if(!isset($mensaje))
	$mensaje = "";
if(isset($_GET['mensaje'])){
    $mensaje = $_GET['mensaje'];}

require ('includes/vistas/comun/cabecera.php');
?>
	<main>
		<article> 
			<h1> <?= $mensaje ?> </h1>
			<?= $contenidoPrincipal?>
		</article>
	</main>
</div>
<?php
require('includes/vistas/comun/pie.php');
?>
</body>
</html>
