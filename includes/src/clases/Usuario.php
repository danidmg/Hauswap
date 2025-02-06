<?php
require_once 'Aplicacion.php';

class Usuario
{

    public const ADMIN_ROLE = 1;

    public const USER_ROLE = 2;

    //Función para verificar si un usuario existe en la base de datos y si la contraseña ingresada es correcta
    public static function login($correo, $contraseña)
    {
        $usuario = self::buscaUsuario($correo);
        if ($usuario && $usuario->compruebacontraseña($contraseña, $correo)) {
            return $usuario;
        }
        return false;
    }
    
    //Función para crear un nuevo usuario en la base de datos
    public static function crea($correo, $contraseña, $nombre, $telefono, $genero, $fecha, $pais, $foto_perfil, $tipo)
    {
        $user = new Usuario($correo, self::hashcontraseña($contraseña), $nombre, $telefono, $genero, $fecha, $pais, $foto_perfil, $tipo); 
        $user->guarda();
        return $user;
    }

    //Función para buscar un usuario por correo electrónico en la base de datos.
    public static function buscaUsuario($correo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.correo='%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $user = false;
        //si se ejecuta la query, encontramos el usuario y liberamos memoria
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if($fila){
                $user = new Usuario($fila['correo'], $fila['contraseña'], $fila['nombre'], $fila['telefono'], $fila['sexo'], $fila['fecha_nacimiento'], $fila['pais'], $fila['servidor_fotoperfil'], $fila['tipo']);
            }
            $rs->free();
            
        }
        //si no, mostramos error 
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $user;
    }

    //Función que devuelve todos los usuarios en la base de datos
    public static function devuelveTodosLosUsuarios() {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);

        //Definir array de Usuario
        $usuarios = array();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {

                // Crear objeto Usuario con los datos de la fila actual
                $user = new Usuario($fila['correo'], $fila['contraseña'], $fila['nombre'], $fila['telefono'], $fila['sexo'], $fila['fecha_nacimiento'], $fila['pais'], $fila['servidor_fotoperfil'], $fila['tipo']);

                //Meter cada usuario en un array
                $usuarios[] = $user;
            }
            $result->free();
        }

        // Devolver el array de Usuarios
        return $usuarios;
    }

    //Función para buscar un usuario por su ID en la base de datos.
    public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE id=%d", $idUsuario);
        $rs = $conn->query($query);
        $result = false;

        //si se ejecuta la query, encontramos el usuario y liberamos memoria
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['correo'], $fila['contraseña'], $fila['nombre'], $fila['telefono'], $fila['sexo'], $fila['fecha_nacimiento'], $fila['pais'], $fila['servidor_fotoperfil'], $fila['tipo']);
            }
            $rs->free();


        } 
        //mostramos mensaje si no se ejecuta
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    // función para generar un hash de una contraseña para aumentar su privacidad
    public static function hashcontraseña($contraseña)
    {
        return password_hash($contraseña, PASSWORD_BCRYPT); //he cambiado el algoritmo para que siempre sea una contraseña de 60 caracteres y no de error 
    }
   
    //Función para insertar un nuevo usuario en la base de datos
    private static function inserta($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuarios(correo, nombre, contraseña, fecha_registro, telefono, sexo, fecha_nacimiento, pais, tipo, servidor_fotoperfil) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->contraseña)
            , $conn->real_escape_string(date("Y-n-j"))
            , $conn->real_escape_string($usuario->telefono)
            , $conn->real_escape_string($usuario->genero)
            , $conn->real_escape_string($usuario->fecha)            
            , $conn->real_escape_string($usuario->pais)
            , $conn->real_escape_string(2)
            , $conn->real_escape_string($usuario->foto_perfil)
        );
        if ( $conn->query($query) ) {
            //$usuario->id = $conn->insert_id;
            //$result = self::insertaRoles($usuario);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private $id, $correo, $contraseña, $nombre, $roles, $telefono, $genero, $fecha, $pais, $foto_perfil, $tipo;
    
    // Constructor privado para evitar instanciación directa
    private function __construct($correo, $contraseña, $nombre, $telefono, $genero, $fecha, $pais, $foto_perfil, $tipo)
    {
        $this->correo = $correo;
        $this->contraseña = $contraseña;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->genero = $genero;
        $this->fecha = $fecha;
        $this->pais = $pais;
        $this->foto_perfil = $foto_perfil;
        $this->tipo = $tipo;
    }

    //Getters de los atributos de Usuario
    public function getCorreo()
    {
        return $this->correo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getGenero() {
        return $this->genero;
    }
    public function getFecha() {
        return $this->fecha;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getFotoPerfil() {
        return $this->foto_perfil;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function esAdmin() {
        if ($this->tipo == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    //Funcion que comprueba contraseña de un usuario en la base de datos
    public function compruebacontraseña($password, $correo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.correo='%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if($fila){
                return password_verify($password, $fila['contraseña']); 
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return false;
    }

    //Funcion que actualiza la contraseña antigua a la cambiada en la base de datos
    public static function cambiacontraseña($id_usuario, $nuevocontraseña){
        $conn = Aplicacion::getInstance()->getConexionBd();
       $newpass= self::hashcontraseña($nuevocontraseña);
        $sql = "UPDATE usuarios SET contraseña = '$newpass' WHERE correo = '$id_usuario'";

        //si se llego a cambiar
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Contraseña cambiada con éxito" . $conn->error;
            if (!isset($_SESSION['esAdmin'])){
                echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
            }
            else{
                echo "<meta http-equiv='refresh' content='0; url=../../../gestionarUsuarios.php?mensaje=".$mensaje."'>";
            }
        } else {
            $mensaje = "Error al actualizar la contraseña" . $conn->error;
            echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
        }
       
    }
    
    //Funcion que guarda un usuario en la base de datos insertandola
    public function guarda()
    {
        return self::inserta($this);
    }

    //Funcion para sacar los datos de la base de datos
    public static function datos($correo){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT nombre, telefono, sexo, fecha_nacimiento, pais, biografia FROM usuarios WHERE correo = '$correo'";
        $resultado = $conn->query($sql);
        $fila = $resultado->fetch_assoc();

        $nombre = $fila['nombre'];
        $telefono = $fila['telefono'];
        $sexo = $fila['sexo'];
        $fecha_nacimiento = $fila['fecha_nacimiento'];
        $pais = $fila['pais'];
        $biografia = $fila['biografia'];

        $resultado->free();
        //Devuelve el array con todos los datos obtenidos
        return array(
            'nombre' => $nombre,
            'telefono' => $telefono,
            'sexo' => $sexo,
            'fecha_nacimiento' => $fecha_nacimiento,
            'pais' => $pais,
            'biografia' => $biografia
        );
    }

    //Funcion que edita los datos del usuario en la base de datos
    public static function edita($usuario, $campos){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE usuarios SET $campos WHERE correo = '$usuario'");
        if ( $conn->query($query) ) {
            $result = true;
            $mensaje = "Datos del usuario cambiados con éxito" . $conn->error;
            if (!isset($_SESSION['esAdmin'])){
                echo "<meta http-equiv='refresh' content='0; url=../../../miCuenta.php?mensaje=".$mensaje."'>";
            }
            else{
                echo "<meta http-equiv='refresh' content='0; url=../../../gestionarUsuarios.php?mensaje=".$mensaje."'>";
            }
        } else {
            $mensaje = "Error al actualizar los datos: " . $conn->error;
        }
        return $result;
    }
    
    //Funcion que elimina el usuario de la base de datos
    public static function elimina($usuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "DELETE FROM usuarios WHERE correo = '$usuario'";
        $resultado = $conn->query($sql);
        if (!isset($_SESSION['esAdmin'])){
            $_SESSION['login'] = NULL;
        }

        return $resultado;
    }
}
