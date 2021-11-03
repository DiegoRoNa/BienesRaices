<?php 

//CONEXIÓN A LA BASE DE DATOS

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost', 'root', '', 'bienes_raices');

    if (!$db) {
        echo 'Error, no se pudo contectar';
        exit;
    }

    return $db; //Retornando una instancia MYSQLI
}
