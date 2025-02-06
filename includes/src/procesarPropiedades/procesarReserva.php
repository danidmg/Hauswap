<?php
require_once '../../config.php';
require_once '../clases/Reserva.php';

//Datos del formulario
$id_casa1 = $_GET['casa1'];
$id_casa2 = isset($_POST['id_casa2']) ? $_POST['id_casa2'] : null;
$fecha_entrada = isset($_POST['fecha_entrada']) ? $_POST['fecha_entrada'] : null;
$fecha_salida = isset($_POST['fecha_salida']) ? $_POST['fecha_salida'] : null;


$estado = 'PENDIENTE';
$fecha_entrada_formateada = date('Y-m-d', strtotime($fecha_entrada));
$fecha_salida_formateada = date('Y-m-d', strtotime($fecha_salida));


// Verificar si las fechas seleccionadas están disponibles
$sql = "SELECT COUNT(*) as count FROM reservas WHERE ((id_casa1 = ? AND fecha_entrada <= ? AND fecha_salida >= ?) OR (id_casa2 = ? AND fecha_entrada <= ? AND fecha_salida >= ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssss", $id_casa1, $fecha_salida_formateada, $fecha_entrada_formateada, $id_casa2, $fecha_salida_formateada, $fecha_entrada_formateada);
$stmt->execute();
$resultado = $stmt->get_result();

$row = $resultado->fetch_assoc();
if ($row['count'] > 0) {
  $resultado->free();
  // Mostrar mensaje de error
  $mensaje="Lo sentimos, las fechas seleccionadas no están disponibles. Por favor, elige otras fechas.</br>";
  echo "<meta http-equiv='refresh' content='0; url=../../../reservar.php?mensaje=".$mensaje."&casa1=". $id_casa1."'>";
}
else if($fecha_salida_formateada < $fecha_entrada_formateada){
  // Mostrar mensaje de error
  $mensaje="¡La fecha de salida debe ser posterior a la fecha de entrada!. Por favor, elige otras fechas.</br>";
  echo "<meta http-equiv='refresh' content='0; url=../../../reservar.php?mensaje=".$mensaje."&casa1=". $id_casa1."'>";
}
else{
  // Insertar reserva en la base de datos
  Reserva::crea($id_casa1, $id_casa2, $fecha_entrada_formateada, $fecha_salida_formateada, $estado);
  $sql = "SELECT nombre FROM propiedades WHERE propiedades.id_casa = $id_casa1";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nombre_casa1 = $row["nombre"];

  $result->free();

  $sql = "SELECT nombre FROM propiedades WHERE propiedades.id_casa = $id_casa2";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $nombre_casa2 = $row["nombre"];

  $result->free();

  // Mostrar mensaje de éxito
  $mensaje =  "La solicitud de intercambio de tu casa $nombre_casa2 con la casa $nombre_casa1 del día $fecha_entrada al día $fecha_salida se ha hecho correctamente!";

  if (!isset($_SESSION['esAdmin'])){
    echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
}
else{
    echo "<meta http-equiv='refresh' content='0; url=../../../gestionarReservas.php?mensaje=".$mensaje."'>";
}
}
?>