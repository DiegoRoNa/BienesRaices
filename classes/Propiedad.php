<?php 

namespace App;

class Propiedad{

    //Base de datos
    protected static $db;//SETEADO DESDE app.php
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'idVendedor'];

    //VALIDADOR DE ERRORES
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $idVendedor;

    
    //Definir la conexion a la BD
    public static function setDB($database){
        self::$db = $database;
    }


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->idVendedor = $args['idVendedor'] ?? 1;
    }

    //GUARDAR REGISTRO
    public function guardar(){
        if (isset($this->id)) {
            $this->actualizar();
        }else{
            $this->crear();
        }
    }


    //NUEVO REGISTRO
    public function crear(){

        //DATOS SANITIZADOS DESDE LA FUNCION sanitizarDatos()
        $atributos = $this->sanitizarAtributos();

        //insertar en la BD
        $query = "INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos));//JOIN convierte a un string, las llaves del arreglo de atributos
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));//JOIN convierte a un string, los valores del arreglo de atributos
        $query .= "'); ";

        $resultado = self::$db->query($query);

        return $resultado;

    }

    //ACTUALIZAR REGISTRO
    public function actualizar(){
        //DATOS SANITIZADOS DESDE LA FUNCION sanitizarDatos()
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1;";

        $resultado = self::$db->query($query);

        if ($resultado) {
            //REDIRECCIONAR AL USER
            header('Location: /admin?resultado=2');
        }  
    }

    //ITERAR LAS COLUMNAS, identificar y unir los atributos de la BD
    public function atributos(){
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue; //IGNORAR EL id, al momento de crear el objeto el ID aun no existe
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }

    //SANITIZAR LOS DATOS
    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);//escapar los datos con POO
        }

        return $sanitizado;
    }

    //SUBIDA DE IMAGENES
    public function setImagen($imagen){
        //ELIMINAR LA IMAGEN PREVIA AL ACTUALIZAR
        if (isset($this->id)) {
            //comprobar que exista el archivo en el servidor
            $existeArchivo = file_exists(CARPETA_IMAGENES.$this->imagen);
            if ($existeArchivo) {
                unlink(CARPETA_IMAGENES.$this->imagen);
            }
        }

        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //VALIDAR DATOS
    public static function getErrores(){
        return self::$errores;
    }


    public function validar(){
        //VALIDAR LOS DATOS
        if (!$this->titulo) {
            self::$errores[] = 'Debes añadir un título a la propiedad';
        }

        if (!$this->precio) {
            self::$errores[] = 'El precio es obligatorio';
        }

        if (!$this->imagen) {
            self::$errores[] = 'La imagen es obligatoria';
        }

        if (!$this->descripcion || strlen($this->descripcion) < 50) {
            self::$errores[] = 'Es necesaria una descripción y debe tener mínimo 50 caracteres';
        }
        if (!$this->habitaciones) {
            self::$errores[] = 'Coloca el número de habitaciones';
        }
        if (!$this->wc) {
            self::$errores[] = 'Coloca el número de baños';
        }
        if (!$this->estacionamiento) {
            self::$errores[] = 'Coloca el número de lugares del estacionamiento';
        }
        if (!$this->idVendedor) {
            self::$errores[] = 'Elige un vendedor';
        }
        
         return self::$errores;
    }


    //TODAS LAS PROPIEDADES
    public static function all(){
        
        //QUERY
        //CONSULTAR TODOS LOS VENDEDORES
        $query = "SELECT * FROM propiedades;";

        //EJECUTAR CONSULTA
        $resultado = self::consultarSQL($query);

        return $resultado;
    }


    //BUSCAR UN REGISTRO POR EL ID
    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = ${id};";

        //EJECUTAR CONSULTA
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);//toma el primer elemento del arreglo
    }


    //Consultar la BD tomando el query y retornando un arreglo de OBJETOS
    public static function consultarSQL($query){
        //consultar la BD
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        /*
        var_dump($array);
        exit;
        */

        //Liberar la memoria
        $resultado->free();

        //Rrtornar los resultados
        return $array;

    }

    //CONVETIR UN ARREGLO EN UN OBJETO PARA RELLENAR EL ARRAY DE consultarSQL()
    protected static function crearObjeto($registro){
        $objeto = new self; //Nuevo objeto de la clase

        //registro es un arreglo associativo, convertir a objeto
        foreach ($registro as $key => $value) {
            if (property_exists( $objeto, $key )) {//si existe un objeto con esa llave
                $objeto->$key = $value;//rellenamos el objeto
            }
        }

        return $objeto;
    }


    //SINCRONIZA EL OBJETO EN MEMORIA CON LOS CAMBIOS REALIZADOS POR EL USUARIO
    public function sincronizar( $args = [] ){
        //recorrer las llaves del arreglo
        foreach ($args as $key => $value) {
            if (property_exists( $this, $key ) && !is_null($value)) {//sincroniza con propiedades del objeto
                $this->$key = $value; //this, es el objeto de la clase
            }
        }
    }

}
