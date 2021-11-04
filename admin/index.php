<?php 

//Funciones
require '../includes/funciones.php';

$auth = estaAutenticado();

if (!$auth) {
    header('Location: /');
}

//CONEXION A LA BD
require '../includes/config/database.php';
$db = conectarDB();

//QUERY
//CONSULTAR TODOS LOS VENDEDORES
$consulta = "SELECT * FROM propiedades;";

//EJECUTAR CONSULTA
$resultadoConsulta = mysqli_query($db, $consulta);

$resultado = $_GET['resultado'] ?? null;//ISSET()

//ELIMINAR EL REGISTRO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //VALIDAR QUE SEA UN int
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //ELIMINAR
    if ($id) {

        //Eliminar archivo de imagen
        $query = "SELECT imagen FROM propiedades WHERE id = ${id};";
        $resultado = mysqli_query($db, $query);
        $propiedad = mysqli_fetch_assoc($resultado);
        unlink('../imagenes/'.$propiedad['imagen']);

        //Eliminar propiedad
        $query = "DELETE FROM propiedades WHERE id = ${id};";
        $resultado = mysqli_query($db, $query);

        //REDIRECCIONAR
        if ($resultado) {
            header('Location: /admin?resultado=3');
        }
    }
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raíces</h1>

        <!--MENSAJES DE CREACION O ACTUALIZACIÓN DE PROPIEDAD-->
        <?php if(intval($resultado) === 1): ?>
            <p class="alerta exito">Propiedad registrada correctamente</p>
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">Propiedad actualizada correctamente</p>
        <?php elseif(intval($resultado) === 3): ?>
            <p class="alerta exito">Propiedad eliminada correctamente</p>
        <?php endif; ?>
        
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php while($propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
                
                    <tr>
                        <td><?=$propiedad['id'];?></td>
                        <td><?=$propiedad['titulo'];?></td>
                        <td><img src="/imagenes/<?=$propiedad['imagen'];?>" class="imagen-tabla"></td>
                        <td>$ <?=$propiedad['precio'];?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?=$propiedad['id'];?>">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                        
                            <a href="propiedades/actualizar.php?id=<?=$propiedad['id'];?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                
                <?php endwhile; ?>
                
            </tbody>
        </table>
    </main>


<?php 
//CERRAR LA CONEXION A LA BD
mysqli_close($db);

incluirTemplate('footer'); 
?>