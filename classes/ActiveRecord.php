<?php 

namespace App;

class ActiveRecord{
    //Base de datos
    protected static $db;//SETEADO DESDE app.php
    protected static $columnasDB = [];
    protected static $tabla = '';

    //VALIDADOR DE ERRORES
    protected static $errores = [];

    
    //Definir la conexion a la BD
    public static function setDB($database){
        self::$db = $database;
    }

    //GUARDAR REGISTRO
    public function guardar(){
        if (!is_null($this->id)) {
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
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= join(', ', array_keys($atributos));//JOIN convierte a un string, las llaves del arreglo de atributos
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));//JOIN convierte a un string, los valores del arreglo de atributos
        $query .= "'); ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            //REDIRECCIONAR AL USER
            header('Location: /admin?resultado=1');
        }  

    }

    //ACTUALIZAR REGISTRO
    public function actualizar(){
        //DATOS SANITIZADOS DESDE LA FUNCION sanitizarDatos()
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1;";

        $resultado = self::$db->query($query);

        if ($resultado) {
            //REDIRECCIONAR AL USER
            header('Location: /admin?resultado=2');
        }  
    }

    //ELIMINAR
    public function eliminar(){
        //Eliminar propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ".self::$db->escape_string($this->id)." LIMIT 1;";
        
        $resultado = self::$db->query($query);

        //REDIRECCIONAR
        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    //ITERAR LAS COLUMNAS, identificar y unir los atributos de la BD
    public function atributos(){
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
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
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }

        if ($imagen) {
            $this->imagen = $imagen;
        }
    }


    //ELIMINAR ARCHIVO
    public function borrarImagen(){

        if ($this->image) {
            //comprobar que exista el archivo en el servidor
            $existeArchivo = file_exists(CARPETA_IMAGENES.$this->imagen);
            if ($existeArchivo) {
                unlink(CARPETA_IMAGENES.$this->imagen);
            }
        }
        
    }

    //VALIDAR DATOS
    public static function getErrores(){
        return static::$errores;
    }


    public function validar(){
        static $errores = [];
        return static::$errores;
    }


    //TODAS LAS PROPIEDADES
    public static function all(){
        
        //QUERY
        //static:: HEREDA, BUSCANDO LA PROPIEDA STATIC EN LAS CLASES A HEREDAR
        $query = "SELECT * FROM ".static::$tabla.';';

        //EJECUTAR CONSULTA
        $resultado = self::consultarSQL($query);

        return $resultado;
    }


    //OBTENER DETERMINADOS REGISTROS
    public static function get($cantidad){
        
        //QUERY
        $query = "SELECT * FROM ".static::$tabla.' LIMIT '. $cantidad.';';

        //EJECUTAR CONSULTA
        $resultado = self::consultarSQL($query);

        return $resultado;
    }


    //BUSCAR UN REGISTRO POR EL ID
    public static function find($id){
        $query = "SELECT * FROM ". static::$tabla . " WHERE id = ${id};";

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
            $array[] = static::crearObjeto($registro);
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
        $objeto = new static; //Nuevo objeto de la clase

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
