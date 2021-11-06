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
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->idVendedor = $args['idVendedor'] ?? '';
    }


    public function guardar(){

        //DATOS SANITIZADOS DESDE LA FUNCION sanitizarDatos()
        $atributos = $this->sanitizarAtributos();

        //insertar en la BD
        $query = "INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos));//JOIN convierte a un string, las llaves del arreglo de atributos
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));//JOIN convierte a un string, los valores del arreglo de atributos
        $query .= "'); ";

        $resultado = self::$db->query($query);

        var_dump($resultado);
        exit;

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

        /*
        //VALIDACIÓN DE LA IMAGEN
        if (!$this->imagen['name']) {
            self::$errores[] = 'La imagen es obligatoria';
        }

        //VALIDAR EL TAMAÑO DE LA IMAGEN(5MB)
        $tamaño = 1000 * 5000;

        if ($this->imagen['size'] > $tamaño) {
            self::$errores[] = 'La imagen es demasiado pesada';
        }
        */

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

}
