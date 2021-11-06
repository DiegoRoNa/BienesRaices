<?php 

//Funciones
require '../../includes/app.php';

use App\Propiedad;

estaAutenticado();

//Conexión a la BD
$db = conectarDB();

//CONSULTAR TODOS LOS VENDEDORES
$consulta = "SELECT * FROM vendedores;";
$resultado = mysqli_query($db, $consulta);

//ARREGLO DE MENSAJES DE ERRORES
$errores = Propiedad::getErrores();

//Las declaramos aquí para poder mantener el input en caso de lanzar una alerta
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$creado = '';
$idVendedor = '';

//DATOS DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad = new Propiedad($_POST);

    $errores = $propiedad->validar();


    //Insertar registros en la tabla PROPIEDADES validando que errores esté vacío
    if (empty($errores)) {

        $propiedad->guardar();

        //SUBIDA DE ARCHIVOS
        //crear la carpeta de imagenes
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        //Generar un nombre a la imagen
        $nombreImagen = md5( uniqid( rand(), true ) ).'.jpg';

        //subir la imagen a la memoria del servidor
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);

        
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //REDIRECCIONAR AL USER
            header('Location: /admin?resultado=1');
        }    
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
            <fieldset>
                <legend>Información general</legend>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título propiedad" value="<?=$titulo;?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?=$precio;?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion"><?=$descripcion;?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información de la propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?=$habitaciones;?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?=$wc;?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?=$estacionamiento;?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="idVendedor" id="idVendedor">

                    <option value="">-- Seleccione --</option>

                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option <?=$idVendedor == $vendedor['id'] ? 'selected' : '';?> value="<?=$vendedor['id'];?>"><?=$vendedor['nombre'].' '.$vendedor['apellidos'];?></option>
                    <?php endwhile; ?>

                </select>
            </fieldset>

            <input type="submit" class="boton boton-verde" value="Crear propiedad">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>