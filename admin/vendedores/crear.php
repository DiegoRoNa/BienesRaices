<?php 

//Funciones
require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor;

//CONSULTAR TODOS LOS VENDEDORES
$vendedores = Vendedor::all();

//ARREGLO DE MENSAJES DE ERRORES
$errores = Vendedor::getErrores();

//DATOS DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $vendedor = new Vendedor($_POST['vendedor']);

    $errores = $vendedor->validar();

    //Insertar registros en la tabla VENDEDORES validando que errores esté vacío
    if (empty($errores)) {

        //GUARDAR OBJETO EN LA BD
        $vendedor->guardar();  
    }
    
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Registrar vendedor</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!--MENSAJES DE ERROR-->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?=$error;?>
            </div>
        <?php endforeach; ?>

        <form action="/admin/vendedores/crear.php" method="POST" class="formulario">
            
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>
            
            <input type="submit" class="boton boton-verde" value="Registrar vendedor">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>