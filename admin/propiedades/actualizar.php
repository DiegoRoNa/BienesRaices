<?php 

//Funciones

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';

estaAutenticado();

//RESTRINGIR EL ID DE LA URL A UN INT
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}


//CONSULTAR TODOS LAS PROPIEDADES
$propiedad = Propiedad::find($id);//Devuelve un OBJETO

//CONSULTAR TODOS LOS VENDEDORES
$vendedores = Vendedor::all();

//ARREGLO DE MENSAJES DE ERRORES
$errores = Propiedad::getErrores();


//DATOS DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los valores nuevos
    $args = $_POST['propiedad'];

    //sincronizar el objeto $propiedad con el arreglo $args
    $propiedad->sincronizar($args);

    //validar que no esten vacios los input
    $errores = $propiedad->validar();

    //SUBIDA DE IMAGEN NUEVA
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

    //Insertar registros en la tabla PROPIEDADES validando que errores esté vacío
    if (empty($errores)) {
        //validar si existe una imagen
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            //GUARDAR IMAGEN EN EL SERVIDOR
            $image->save(CARPETA_IMAGENES.$nombreImagen);
        }
        
        //actualizar
        $propiedad->guardar();
    }
    
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Actualizar propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!--MENSAJES DE ERROR-->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?=$error;?>
            </div>
        <?php endforeach; ?>
        
        

        <form method="POST" class="formulario" enctype="multipart/form-data">
            
            <?php include '../../includes/templates/formularios.php'; ?>

            <input type="submit" class="boton boton-verde" value="Actualizar propiedad">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>