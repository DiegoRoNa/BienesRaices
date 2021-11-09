<?php 

use App\Vendedor;


//Funciones
require '../../includes/app.php';

estaAutenticado();

//RESTRINGIR EL ID DE LA URL A UN INT
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /admin');
}


//CONSULTAR TODOS LOS VENDEDORES
$vendedor = Vendedor::find($id);

//ARREGLO DE MENSAJES DE ERRORES
$errores = Vendedor::getErrores();


//DATOS DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los valores nuevos
    $args = $_POST['vendedor'];

    //sincronizar el objeto $vendedor con el arreglo $args
    $vendedor->sincronizar($args);

    //validar que no esten vacios los input
    $errores = $vendedor->validar();


    //Insertar registros en la tabla VENDEDORES validando que errores esté vacío
    if (empty($errores)) {
        
        //actualizar
        $vendedor->guardar();
    }
    
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Actualizar vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!--MENSAJES DE ERROR-->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?=$error;?>
            </div>
        <?php endforeach; ?>

        <form method="POST" class="formulario">
            
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>
            
            <input type="submit" class="boton boton-verde" value="Actualizar vendedor">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>