<?php 

namespace App;

class Vendedor extends ActiveRecord{
    protected static $tabla = 'vendedores';//HACER DINAMICO EL METODO ALL DE ACTIVERECORD
    protected static $columnasDB = ['id', 'nombre', 'apellidos', 'telefono'];

    public $id;
    public $nombre;
    public $apellidos;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }


    public function validar(){
        //VALIDAR LOS DATOS
        if (!$this->nombre) {
            self::$errores[] = 'El nombre es obligatorio';
        }

        if (!$this->apellidos) {
            self::$errores[] = 'Los apellidos son obligatorios';
        }

        if (!$this->telefono) {
            self::$errores[] = 'El telefono es obligatorio';
        }

        if (!preg_match('/[0-9]{10}/', $this->telefono)) {
            self::$errores[] = 'Formato no válido en el teléfono';
        }

        return self::$errores;
    }
}
