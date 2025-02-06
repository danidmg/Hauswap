<?php
require_once '../../config.php';
require_once '../clases/Usuario.php';

$_SESSION['login'] = NULL;
$_SESSION['esAdmin'] = NULL;

$mensaje =  "Sesión Cerrada Correctamente";
echo "<meta http-equiv='refresh' content='1; url=../../../index.php?mensaje=".$mensaje."'>";
?>