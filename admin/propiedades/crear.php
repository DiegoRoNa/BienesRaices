<?php 

//Funciones
require '../../includes/funciones.php';

$auth = estaAutenticado();

if (!$auth) {
    header('Location: /');
}

//Conexión a la BD
require '../../includes/config/database.php';
$db = conectarDB();

//CONSULTAR TODOS LOS VENDEDORES
$consulta = "SELECT * FROM vendedores;";
$resultado = mysqli_query($db, $consulta);

//ARREGLO DE MENSAJES DE ERRORES
$errores = [];

//Las declaramos aquí para poder mantener el input en caso de lanzar una alerta
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$idVendedor = '';

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

    //VALIDACIÓN DE LA IMAGEN
    if (!$imagen['name']) {
        $errores[] = 'La imagen es obligatoria';
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

        //Generar un nombre a la imagen
        $nombreImagen = md5( uniqid( rand(), true ) ).'.jpg';

        //subir la imagen a la memoria del servidor
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);

        //insertar
        $query = "INSERT INTO propiedades (idVendedor, titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado)
              VALUES($idVendedor, '$titulo', $precio, '$nombreImagen', '$descripcion', $habitaciones, $wc, $estacionamiento, CURRENT_DATE());";

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

                <select name="vendedor" id="vendedor">

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