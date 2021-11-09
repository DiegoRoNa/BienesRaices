<?php 
//ARCHIVO PRINCIPAL QUE MANDA LLAMAR FUNCIONES Y CLASES

require 'funciones.php';//Funciones
require 'config/database.php';//Conexion de la BD
require __DIR__.'/../vendor/autoload.php';//Autoload de composer


//CONECTAR A LA BD
$db = conectarDB();

use App\ActiveRecord;

//ACTIVE RECORD ES LA CLASE PADRE, HEREDARÁ A TODAS LAS CLASES HIJAS LA CONEXION A LA BD
ActiveRecord::setDB($db);


