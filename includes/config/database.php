<?php 

//CONEXIÓN A LA BASE DE DATOS

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'bienes_raices');

    if (!$db) {
        echo 'Error, no se pudo contectar';
        exit;
    }

    return $db; //Retornando una instancia MYSQLI
}
