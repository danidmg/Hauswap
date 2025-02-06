<?php
require_once 'Aplicacion.php';

class Propiedad {

    private $id_casa;
    private $id_usuario;
    private $nombre;
    private $localizacion;
    private $numero_valoraciones;
    private $servidor_fotos;
    private $descripcion;
    private $estrellas;
    
    // Constructor privado para evitar instanciación directa
    private function __construct($id_casa, $id_usuario, $nombre, $localizacion, $numero_valoraciones, $servidor_fotos, $descripcion, $estrellas) {
        $this->id_casa = $id_casa;
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->localizacion = $localizacion;
        $this->numero_valoraciones = $numero_valoraciones;
        $this->servidor_fotos = $servidor_fotos;
        $this->descripcion = $descripcion;
        $this->estrellas = $estrellas;
    }

    //Getters de los atributos de Propiedad
    public function getIdCasa()
    {
        return $this->id_casa;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getLocal() {
        return $this->localizacion;
    }

    public function getVal() {
        return $this->numero_valoraciones;
    }
    public function getDescr() {
        return $this->descripcion;
    }

    public function getEstrellas() {
        return $this->estrellas;
    }

    public function getFoto() {
        return $this->servidor_fotos;
    }

    //Función que devuelve todas las propiedades en la base de datos
    public static function devuelveTodasLasPropiedades() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM propiedades";
        $result = $conn->query($sql);

        //Definir array de propiedades
        $propiedades = array();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                // Crear objeto propiedades con los datos de la fila actual
                $propiedad = new Propiedad($fila['id_casa'], $fila['id_usuario'], $fila['nombre'], $fila['localizacion'], $fila['numero_valoraciones'], $fila['servidor_fotos'], $fila['descripcion'], $fila['estrellas']);

                //Meter cada propiedades en un array
                $propiedades[] = $propiedad;
            }
            $result->free();
        }

        // Devolver el array de propiedades
        return $propiedades;
    }


    //Función que devuelve todas las propiedades en la base de datos
    public static function devuelveRestodePropiedades() {
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Si no ha iniciado sesión
        if(!isset($_SESSION['login'])){
            $sql = "SELECT * FROM propiedades";
        }
        else{
            // Si ha iniciado sesión, hacemos una consulta a la base de datos para buscar propiedades que no pertenezcan al usuario actual
            $sql = "SELECT * FROM propiedades WHERE id_usuario != '{$_SESSION["nombre"]}'";
        }

        $result = $conn->query($sql);

        //Definir array de propiedades
        $propiedades = array();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                // Crear objeto propiedades con los datos de la fila actual
                $propiedad = new Propiedad($fila['id_casa'], $fila['id_usuario'], $fila['nombre'], $fila['localizacion'], $fila['numero_valoraciones'], $fila['servidor_fotos'], $fila['descripcion'], $fila['estrellas']);

                //Meter cada propiedades en un array
                $propiedades[] = $propiedad;
            }
            $result->free();
        }

        // Devolver el array de propiedades
        return $propiedades;
    }


     //Función para insertar una nueva propiedad en la base de datos
    private static function inserta($casa){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO propiedades (id_casa, id_usuario, nombre, localizacion, numero_valoraciones, servidor_fotos ,descripcion, estrellas) VALUES (%d, '%s', '%s', '%s', %d, '%s', '%s', %d)"
            , $conn->real_escape_string($casa->id_casa) // usamos esta funcion en todos lo valores?? hay int y varchar
            , $conn->real_escape_string($casa->id_usuario)
            , $conn->real_escape_string($casa->nombre)
            , $conn->real_escape_string($casa->localizacion)
            , $conn->real_escape_string($casa->numero_valoraciones)
            , $conn->real_escape_string($casa->servidor_fotos)            
            , $conn->real_escape_string($casa->descripcion)
            , $conn->real_escape_string($casa->estrellas)
        );
        if ( $conn->query($query) ) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

 //Función para guardar una nueva propiedad en la base de datos
    public function guarda(){
        return self::inserta($this);
    }

 //Función para crear una nueva propiedad en la base de datos
    public static function crea($id_usuario, $nombre, $localizacion, $servidor_fotos, $descripcion){
        $uuid = uniqid();
        $id_casa = hexdec(substr($uuid, 0, 8)) & 0x7fffffff;
        $casa = new Propiedad($id_casa, $id_usuario, $nombre, $localizacion, 0, $servidor_fotos, $descripcion, 0);
        $casa->guarda();
        return $casa;
    }

    //edita y actualiza una propiedad en la base de datos
    public static function edita($casa, $campos){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE propiedades SET $campos WHERE id_casa = $casa");
        //ejecuta la consulta y si funciona devuelve true
        if ( $conn->query($query) ) {
            return true;
        }
        else{
            return false;
        }
    }

    //elimina una propiedad de la base de datos
    public static function elimina($casa){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "DELETE FROM propiedades WHERE id_casa = $casa";
        //ejecuta la consulta y si funciona devuelve true
        if ($conn->query($sql)) {
            return true;
        }
        else{
            return false;
        }
    }

    //funcion para sacar los datos de la base de datos
    public static function datos($id_casa){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT nombre, localizacion, servidor_fotos, descripcion FROM propiedades WHERE id_casa = $id_casa";
        $resultado = $conn->query($sql);
        
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
    
            $nombre = $fila['nombre'];
            $localizacion = $fila['localizacion'];
            $servidor_fotos = $fila['servidor_fotos'];
            $descripcion = $fila['descripcion'];
    
            //liberamos memoria
            $resultado->free();
    
            return array(
                'nombre' => $nombre,
                'localizacion' => $localizacion,
                'servidor_fotos' => $servidor_fotos,
                'descripcion' => $descripcion
            );
        } else {
            //devuelve array vacio si no hay resultado
            return array();
        }
    }

    // Actualiza los valores de numero_valoracion y estrellas segun la nueva valoracion
    public static function nuevaValoracion($id_casa, $estrellas){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE propiedades SET numero_valoraciones = numero_valoraciones + 1, estrellas = '$estrellas' WHERE id_casa = $id_casa");
        //ejecuta la consulta y si funciona devuelve true
        if ( $conn->query($query) ) {
            return true;
        }
        else{
            return false;
        }
    }
    

} 
?>