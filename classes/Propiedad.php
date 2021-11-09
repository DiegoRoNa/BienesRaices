<?php 

namespace App;

class Propiedad extends ActiveRecord{
    protected static $tabla = 'propiedades';//HACER DINAMICO EL METODO ALL DE ACTIVERECORD
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'idVendedor'];

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

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->idVendedor = $args['idVendedor'] ?? '';
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

}
