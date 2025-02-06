<?php
require_once 'Aplicacion.php';

class Reserva {

    private $id_reserva;
    private $id_casa1;
    private $id_casa2;
    private $fecha_entrada;
    private $fecha_salida;
    private $estado;

    // Constructor privado para evitar instanciación directa
    private function __construct($id_casa1, $id_casa2, $fecha_entrada, $fecha_salida, $estado) {
        $uuid = uniqid();
        $this->id_reserva = hexdec(substr($uuid, 0, 8)) & 0x7fffffff;
        $this->id_casa1 = $id_casa1;
        $this->id_casa2 = $id_casa2;
        $this->fecha_entrada = $fecha_entrada;
        $this->fecha_salida = $fecha_salida;
        $this->estado = $estado;
    }

    //Getters de los atributos de Reserva
    public function getReserva()
    {
        return $this->id_reserva;
    }

    public function getCasa1()
    {
        return $this->id_casa1;
    }

    public function getCasa2() {
        return $this->id_casa2;
    }

    public function getFechaSalida() {
        return $this->fecha_salida;
    }
    public function getFechaEntrada() {
        return $this->fecha_entrada;
    }

    public function getEstado() {
        return $this->estado;
    }


    // IMP: en la la query en las variables que tenian %i he puesto %d porque si no no me da error pero no se añade la casa

    //Funcion que inserta una reserva en la bsae de datos
    private static function inserta($reserva){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "INSERT INTO reservas (id_reserva, id_casa1, id_casa2, fecha_entrada, fecha_salida, estado) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("iiisss", $reserva->id_reserva, $reserva->id_casa1, $reserva->id_casa2, $reserva->fecha_entrada, $reserva->fecha_salida, $reserva->estado);
        
        //si puede ser ejecutado
        if ($stmt->execute()) {
            // Obtener nombre de la propiedad
            $sql = "SELECT nombre FROM propiedades WHERE id_casa = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $reserva->id_casa1);
            $stmt->execute();
            $resultado = $stmt->get_result();
        
            //si no hay propiedaddes
            if ($resultado->num_rows < 0){
            echo "Error al obtener el nombre de la propiedad: " . $conn->error;
            }
        }
        else{
            echo "Error en la creación de la reserva: " . $conn->error;
        }
    }  

    //Funcion que guarda una reserva en la bsae de datos
    public function guarda(){
        return self::inserta($this);
    }

    //Funcion que crea una reserva en la bsae de datos
    public static function crea($id_casa1, $id_casa2, $fecha_entrada, $fecha_salida, $estado){
        $reserva = new Reserva($id_casa1, $id_casa2, $fecha_entrada, $fecha_salida, $estado);
        $reserva->guarda();
        return $reserva;
    }

    //Funcion que actualiza el estado una reserva en la bsae de datos
    public static function actualizaEstado($id_reserva, $nuevo_estado){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "UPDATE reservas SET estado=? WHERE id_reserva=?";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("si", $nuevo_estado, $id_reserva);
        //ejecuta la consulta y si funciona devuelve true
        if ($stmt->execute()) {
            return true;
        }
        else{
            return false;
        }
    }

    //Funcion que elimina una reserva en la bsae de datos
    public static function eliminaReserva($id_reserva){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "DELETE FROM reservas WHERE id_reserva=?";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param("i", $id_reserva);

        //ejecuta la consulta y si funciona devuelve true
        if ($stmt->execute()) {
            return true;
        }
        else{
            return false;
        }
    }

    //Funcion que devuelve todas las reservas de la bsae de datos
    public static function devuelveTodasLasReservas() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM reservas";
        $result = $conn->query($sql);

        //Definir array de reservas
        $reserva = array();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                $reserva = new Reserva($fila['id_casa1'], $fila['id_casa2'], $fila['fecha_entrada'], $fila['fecha_salida'], $fila['estado']);
                $reserva->id_reserva = $fila['id_reserva'];
                    
                $reservas[] = $reserva;
                
                
            }
            $result->free();
        }

        // Devolver el array de reservas
        return $reservas;
    }
    
} 
  
?>