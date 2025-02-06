<?php 

class Mensaje {
    /** Devuelve todos los mensajes entre los dos usuarios, ordenados por antiguedad en orden descendente */
    public static function devuelveMensajesEntre($correoUsuario, $correoContacto) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM mensajes WHERE (id_remitente = '$correoUsuario' AND id_destinatario = '$correoContacto')
        OR (id_remitente = '$correoContacto' AND id_destinatario = '$correoUsuario') ORDER BY id_mensaje ASC";
        $result = $conn->query($sql);

        //Definir array de Mensajes
        $mensajes = array();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                // Crear objeto Mensaje con los datos de la fila actual
                $msg = new Mensaje($fila['id_mensaje'], $fila['id_remitente'], $fila['id_destinatario'], $fila['contenido'], $fila['fecha']);

                //Meter cada usuario en un array
                $mensajes[] = $msg;
            }
            $result->free();
        }

        // Devolver el array de Usuarios
        return $mensajes;
    }

    public static function ultimoMensajeEntre($correoUsuario, $correoContacto) {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM mensajes WHERE (id_remitente = '$correoUsuario' AND id_destinatario = '$correoContacto')
        OR (id_remitente = '$correoContacto' AND id_destinatario = '$correoUsuario') ORDER BY id_mensaje DESC LIMIT 1";
        $result = $conn->query($sql);

        $mensaje = "";

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $mensaje = $fila['contenido'];
        }

        return $mensaje;
    }


    public static function devuelveTodosLosMensajes() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM mensajes";
        $result = $conn->query($sql);

        //Definir array de mensajes
        $mensajes = array();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                // Crear objeto mensajes con los datos de la fila actual
                $mensaje = new Mensaje($fila['id_mensaje'], $fila['id_remitente'], $fila['id_destinatario'], $fila['contenido'], $fila['fecha']);
                //Meter cada mensajes en un array
                $mensajes[] = $mensaje;
            }
            $result->free();
        }
        
        // Devolver el array de mensajes
        return $mensajes;
    }
    

    private $id_mensaje, $id_remitente, $id_destinatario, $contenido, $fecha;

    private function __construct($id_mensaje, $id_remitente, $id_destinatario, $contenido, $fecha)
    {
        $this->id_mensaje = $id_mensaje;
        $this->id_remitente = $id_remitente;
        $this->id_destinatario = $id_destinatario;
        $this->contenido = $contenido;
        $this->fecha = $fecha;
    }

    public function getRemitente() {
        return $this->id_remitente;
    }
    public function getDestinatario() {
        return $this->id_destinatario;
    }
    public function getContenido() {
        return $this->contenido;
    }
    public function getFecha() {
        // Convertir la cadena de fecha original a un timestamp Unix
        $timestamp = strtotime($this->fecha);
        // Formatear el timestamp como una nueva cadena de fecha
        $nueva_fecha = date("d/m,  H:i", $timestamp);

        return $nueva_fecha;
    }

}

?>