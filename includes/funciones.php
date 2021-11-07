<?php 


//ESTAMOS CARGANDO LAS RUTAS DE LOS TEMPLATES, EN UNA VARIABLE GLOBAL
define('TEMPLATES_URL', __DIR__ . '\templates');
//define('FUNCIONES_URL', __DIR__ - 'funciones.php');
define('CARPETA_IMAGENES', __DIR__.'/../imagenes/');


//FUNCIÓN PARA HACER DINAMICO EL USO DE LOS TEMPLATES
function incluirTemplate(string $nombre, bool $inicio = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado() {
    session_start();

    //SESSION DE AUTENTICACION
    if (!$_SESSION['login']) {
        header('Location: /');
    }

}

//ESCAPAR / SANITIZAR HTML
function s($html) : string{
    $s = htmlspecialchars($html);//sanitiza el HTML
    return $s;
}
