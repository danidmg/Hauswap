<!-- ACTUALIZAR EL RESTO DE SCRIPTS PARA QUE LA USEN-->
<?php
require_once 'Aplicacion.php';

class Valoracion {

    private $id_valoracion;
    private	$id_casa;
    private $id_reserva;
    private $id_usuario;
    private $estrellas;
    private $opinion;
    private $fecha;

    // Constructor privado para evitar instanciación directa
    private function __construct($id_casa, $id_reserva, $id_usuario, $estrellas, $opinion, $fecha) {
        $uuid = uniqid();
        $this->id_valoracion = hexdec(substr($uuid, 0, 8)) & 0x7fffffff;
        $this->id_casa = $id_casa;
        $this->id_reserva = $id_reserva;
        $this->id_usuario = $id_usuario;
        $this->estrellas = $estrellas;
        $this->opinion = $opinion;
        $this->fecha = $fecha;
    }

    //Getters de los atributos de Valoracion
    public function getValoracion()
    {
        return $this->id_valoracion;
    }

    public function getCasa()
    {
        return $this->id_casa;
    }

    public function getReserva() {
        return $this->id_reserva;
    }

    public function getUsuario() {
        return $this->id_usuario;
    }
    public function getEstrella() {
        return $this->estrellas;
    }

    public function getOpinion() {
        return $this->opinion;
    }

    public function getFecha() {
          // Convertir la cadena de fecha original a un timestamp Unix
          $timestamp = strtotime($this->fecha);
          // Formatear el timestamp como una nueva cadena de fecha
          $nueva_fecha = date("d/m/y", $timestamp);
  
          return $nueva_fecha;
    }

    //Función que devuelve todas las valoraciones en la base de datos
    public static function devuelveTodasLasValoraciones() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones";
        $result = $conn->query($sql);

        //Definir array de Usuario
        $valoraciones = array();
    

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                // Crear objeto Valoracion con los datos de la fila actual
                $valoracion = new Valoracion($fila['id_casa'], $fila['id_reserva'], $fila['id_usuario'], $fila['estrellas'], $fila['opinion'], $fila['fecha']);
                $valoracion->id_valoracion = $fila['id_valoracion'];

                //Meter cada valoracion en un array
                $valoraciones[] = $valoracion;
            }
            $result->free();
        }
        
        // Devolver el array de Valoraciones
        return $valoraciones;
    }

    //Función que busca la valoracion de una reserva
    public static function buscaValoracion($id_reserva, $id_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones WHERE $id_reserva = id_reserva AND '$id_usuario' = id_usuario";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $result->free();
            return true;
        }
        return false;
    }

    //Función para insertar una nueva valoracion en la base de datos
    private static function inserta($valoracion){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO valoraciones (id_valoracion, id_casa, id_reserva, id_usuario, estrellas, opinion, fecha) VALUES (%d, %d, %d, '%s', %d, '%s', '%s')"
            , $conn->real_escape_string($valoracion->id_valoracion)
            , $conn->real_escape_string($valoracion->id_casa)
            , $conn->real_escape_string($valoracion->id_reserva)
            , $conn->real_escape_string($valoracion->id_usuario)
            , $conn->real_escape_string($valoracion->estrellas)
            , $conn->real_escape_string($valoracion->opinion)
            , $conn->real_escape_string($valoracion->fecha)
        );
        if ( $conn->query($query) ) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    //Funcion que guarda una valoracion en la base de datos insertandola
    public function guarda(){
        return self::inserta($this);
    }

    //Funcion que crea una valoracion en la base de datos guardandola
    public static function crea($id_casa, $id_reserva, $id_usuario, $estrellas, $opinion, $fecha){
        $valoracion = new Valoracion($id_casa, $id_reserva, $id_usuario, $estrellas, $opinion, $fecha);
        $valoracion->guarda();
        return $valoracion;
    }

    //Funcion que edita una valoracion en la base de datos 
    public static function edita($valoracion, $campos){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE valoraciones SET $campos WHERE id_valoracion = $valoracion");
        if ( $conn->query($query) ) {
            $result = true;
            header('Location: ../../../miCuenta.php');
        } else {
            $mensaje = "Error al actualizar los datos: " . $conn->error;
        }
        return $result;
    }

     //no se si las dos hacen lo mismo pero por no tocar lo que ya esta escrito he añadido otra
     public static function eliminaValoracion($valoracion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "DELETE FROM valoraciones WHERE id_valoracion = $valoracion";
        if ($conn->query($sql)) {
            return true;
        }
        else{
            return false;
        }
    }

    public static function calcula($id_casa, &$five_star_percentage, &$four_star_percentage, &$three_star_percentage, &$two_star_percentage, &$one_star_percentage, &$total_five_star_review, &$total_four_star_review, &$total_three_star_review, &$total_two_star_review, &$total_one_star_review){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql3 = "SELECT * FROM valoraciones WHERE id_casa = $id_casa";
        $result3 = $conn->query($sql3);


        if($result3->num_rows > 0) {
            $total_review = $result3->num_rows;
            
            $total_rating = 0;
            $average_rating = 0;

            //recogemos la informacion de las valoraciones de la propiedad
            while($row3 = $result3->fetch_assoc()) {
                $total_rating += $row3['estrellas'];
                if($row3['estrellas'] == 5) {
                    $total_five_star_review++;
                } else if($row3['estrellas'] == 4) {
                    $total_four_star_review++;
                } else if($row3['estrellas'] == 3) {
                    $total_three_star_review++;
                } else if($row3['estrellas'] == 2) {
                    $total_two_star_review++;
                } else if($row3['estrellas'] == 1) {
                    $total_one_star_review++;
                }
            }
            //calculamos la nota media de las reseñas y el porcentaje de las estrellas obtenidas
            $average_rating = round($total_rating / $total_review, 1);
            $five_star_percentage = round(($total_five_star_review / $total_review) * 100);
            $four_star_percentage = round(($total_four_star_review / $total_review) * 100);
            $three_star_percentage = round(($total_three_star_review / $total_review) * 100);
            $two_star_percentage = round(($total_two_star_review / $total_review) * 100);
            $one_star_percentage = round(($total_one_star_review / $total_review) * 100);

            return $average_rating;
        }
        else{
            return 0;
        }

    }

    public static function contar($id_casa){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT COUNT(*) AS count FROM valoraciones WHERE id_casa = $id_casa";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $cuantas = $row['count'];
                return $cuantas;
            }
        }
        else{
            return 0;
        }
    }

    public static function getValoraciones($id_casa){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM valoraciones WHERE id_casa = $id_casa";
        $result = $conn->query($sql);

        //Definir array de Usuario
        $valoraciones = array();
    

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                // Crear objeto Valoracion con los datos de la fila actual
                $valoracion = new Valoracion($fila['id_casa'], $fila['id_reserva'], $fila['id_usuario'], $fila['estrellas'], $fila['opinion'], $fila['fecha']);
                $valoracion->id_valoracion = $fila['id_valoracion'];

                //Meter cada valoracion en un array
                $valoraciones[] = $valoracion;
            }
            $result->free();
        }
        
        // Devolver el array de Valoraciones
        return $valoraciones;
    }
} 
?>