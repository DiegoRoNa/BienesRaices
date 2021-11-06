<?php 
//ARCHIVO PRINCIPAL QUE MANDA LLAMAR FUNCIONES Y CLASES

require 'funciones.php';//Funciones
require 'config/database.php';//Conexion de la BD
require __DIR__.'/../vendor/autoload.php';//Autoload de composer


//CONECTAR A LA BD
$db = conectarDB();

use App\Propiedad;

Propiedad::setDB($db);//todos los objetos creados de Propiedad tienen la referencia a la BD


