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


//VALIDAR TIPO DE CONTENIDO PARA ELIMINAR PROPIEDADES O VENDEDORES
function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);

    //in_array() - BUSCA UN ELEMENTO EN UN ARREGLO
    //in_array($que busca, $donde lo busca)
}


//MENSAJES PARA EL CRUD
function mostrarNotificacion($codigo){
    $mensaje = '';

    switch ($codigo) {
        case 1:
            $mensaje = 'Registrado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            # code...
            break;
    }

    return $mensaje;
}
