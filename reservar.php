<?php
require_once 'includes/config.php';

if (isset($_SESSION["login"])) {
  $sql = "SELECT id_casa, nombre FROM propiedades WHERE propiedades.id_usuario = '${_SESSION["nombre"]}'";

  // ejecutar la consulta SQL
  $result = $conn->query($sql);

  $resultado = "";
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $id_casa = $row['id_casa'];
      $nombre = $row['nombre'];

      $resultado .= "<option value='" . $id_casa . "'>" . $nombre . "</option>";
    }
    $result->free();
  }

  $sql2 = "SELECT nombre FROM propiedades WHERE propiedades.id_casa = '${_GET["casa1"]}'";

  // ejecutar la consulta SQL
  $result2 = $conn->query($sql2);

  $casa1 = "";
  if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
      $nombre = $row['nombre'];
      $casa1 = $nombre;
    }
    $result2->free();
  }

  $fechaMin = date('Y-m-d');

  $tituloPagina = 'Reservar';
  $contenidoPrincipal=<<<EOS
  <br>
  <form class ='form-marco' action="includes/src/procesarPropiedades/procesarReserva.php?casa1=${_GET["casa1"]}" method="post" onchange="return validarReserva(this);">
    <fieldset>
      <legend>Tu Reserva</legend>

      <label for="id_casa1">Casa:</label>
      <h2>$casa1</h2>
      <br>

      <label for="id_casa2">Tu Casa:</label>
      <select name="id_casa2" id="id_casa2" required>
          <option value="">Selecciona tu casa</option>
          $resultado
      </select>
      <br><br>


      <label for="fecha_entrada">Fecha de entrada:</label>
      <input type="date" name="fecha_entrada" id="fecha_entrada" min="$fechaMin" required>
      <br><br>

      <label for="fecha_salida">Fecha de salida:</label>
      <input type="date" name="fecha_salida" id="fecha_salida" min="$fechaMin" required>
      <br><br>
      
      <input type="submit" value="Reservar">
    </fieldset>
  </form>


  EOS;
  require ('./includes/vistas/plantillas/plantilla.php');
}
else {
  $mensaje =  "Necesitas Iniciar Sesión para reservar";
  echo "<meta http-equiv='refresh' content='0; url=login.php?mensaje=".$mensaje."'>";
}
?>
