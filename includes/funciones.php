<?php 

require 'app.php';


//FUNCIÓN PARA HACER DINAMICO EL USO DE LOS TEMPLATES
function incluirTemplate(string $nombre, bool $inicio = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado() : bool {
    session_start();

    //SESSION DE AUTENTICACION
    $auth = $_SESSION['login'];
    
    if ($auth) {
        return true;
    }

    return false;
}