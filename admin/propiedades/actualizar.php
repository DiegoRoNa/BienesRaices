<?php 

//Funciones
require '../../includes/funciones.php';

$auth = estaAutenticado();

if (!$auth) {
    header('Location: /');
}

//RESTRINGIR EL ID DE LA URL A UN INT
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}


//Conexión a la BD
require '../../includes/config/database.php';
$db = conectarDB();

//CONSULTAR TODOS LAS PROPIEDADES
$consulta = "SELECT * FROM propiedades WHERE id = ${id};";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);

//CONSULTAR TODOS LOS VENDEDORES
$consulta = "SELECT * FROM vendedores;";
$resultado = mysqli_query($db, $consulta);

//ARREGLO DE MENSAJES DE ERRORES
$errores = [];

//Las declaramos aquí para poder mantener el input lleno con los datos
$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$imagen = $propiedad['imagen'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$idVendedor = $propiedad['idVendedor'];

//DATOS DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //RECIBIENDO DATOS DEL FORM Y SANITIZANDO
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $imagen = $_FILES['imagen'];
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $idVendedor = mysqli_real_escape_string($db, $_POST['vendedor']);


    //VALIDAR LOS DATOS
    if (!$titulo) {
        $errores[] = 'Debes añadir un título a la propiedad';
    }
    if (!$precio) {
        $errores[] = 'El precio es obligatorio';
    }

    //VALIDAR EL TAMAÑO DE LA IMAGEN(5MB)
    $tamaño = 1000 * 5000;
    if ($imagen['size'] > $tamaño) {
        $errores[] = 'La imagen es demasiado pesada';
    }

    if (!$descripcion || strlen($descripcion) < 50) {
        $errores[] = 'Es necesaria una descripción y debe tener mínimo 50 caracteres';
    }
    if (!$habitaciones) {
        $errores[] = 'Coloca el número de habitaciones';
    }
    if (!$wc) {
        $errores[] = 'Coloca el número de baños';
    }
    if (!$estacionamiento) {
        $errores[] = 'Coloca el número de lugares del estacionamiento';
    }
    if (!$idVendedor) {
        $errores[] = 'Elige un vendedor';
    }


    //Insertar registros en la tabla PROPIEDADES validando que errores esté vacío
    if (empty($errores)) {

        //SUBIDA DE ARCHIVOS
        //crear la carpeta de imagenes
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        //SI EXISTE NUEVA IMAGEN EN LA ACTUALIZACION
        if ($imagen['name']) {
            //ELMIMINAR IMAGEN ANTERIOR
            unlink($carpetaImagenes.$propiedad['imagen']);

            //Generar un nombre a la imagen nueva
            $nombreImagen = md5( uniqid( rand(), true ) ).'.jpg';

            //subir la imagen nueva a la memoria del servidor
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);

        }else{//SI NO EXISTE NUEVA IMAGEN EN LA ACTUALIZACION
            $nombreImagen = $propiedad['imagen'];//sigue siendo la que está en la BD
        }

        //actualizar
        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = ${precio}, imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}
                  WHERE id = ${id};";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            //REDIRECCIONAR AL USER
            header('Location: /admin?resultado=2');
        }    
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
            <fieldset>
                <legend>Información general</legend>

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título propiedad" value="<?=$titulo;?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?=$precio;?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

                <img src="/imagenes/<?=$imagen;?>" class="imagen-small">

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

                <select name="vendedor" id="vendedor">

                    <option value="">-- Seleccione --</option>

                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option <?=$idVendedor == $vendedor['id'] ? 'selected' : '';?> value="<?=$vendedor['id'];?>"><?=$vendedor['nombre'].' '.$vendedor['apellidos'];?></option>
                    <?php endwhile; ?>

                </select>
            </fieldset>

            <input type="submit" class="boton boton-verde" value="Actualizar propiedad">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>