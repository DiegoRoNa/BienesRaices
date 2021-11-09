<?php 

//Funciones
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

estaAutenticado();

$propiedad = new Propiedad;

//CONSULTAR TODOS LOS VENDEDORES
$vendedores = Vendedor::all();

//ARREGLO DE MENSAJES DE ERRORES
$errores = Propiedad::getErrores();

//DATOS DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad = new Propiedad($_POST['propiedad']);

    //Generar un nombre a la imagen
    $nombreImagen = md5( uniqid( rand(), true ) ).'.jpg';

    //validar si existe una imagen
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        //subir la imagen a la memoria del servidor con la libreria Intervention Image
        //Realiza un resize a la imagen
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);//tamaño de las imagenes
        
        //GUARAR EN LA BD
        $propiedad->setImagen($nombreImagen);
    }

    $errores = $propiedad->validar();


    //Insertar registros en la tabla PROPIEDADES validando que errores esté vacío
    if (empty($errores)) {

        //SUBIDA DE ARCHIVOS
        //crear la carpeta de imagenes
        if (!is_dir(CARPETA_IMAGENES)) {//Constante de funciones.php
            mkdir(CARPETA_IMAGENES);
        }

        //GUARDAR EN EL SERVIDOR
        $image->save(CARPETA_IMAGENES.$nombreImagen);

        //GUARDAR OBJETO EN LA BD
        $propiedad->guardar();  
    }
    
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!--MENSAJES DE ERROR-->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?=$error;?>
            </div>
        <?php endforeach; ?>

        <form action="/admin/propiedades/crear.php" method="POST" class="formulario" enctype="multipart/form-data">
            
            <?php include '../../includes/templates/formularios.php'; ?>
            
            <input type="submit" class="boton boton-verde" value="Crear propiedad">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>