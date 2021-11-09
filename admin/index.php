<?php 

//Funciones
require '../includes/app.php';
estaAutenticado();

use App\Propiedad;
use App\Vendedor;

//Metodo para mostrar las propiedades con ActiveRecord
$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

$resultado = $_GET['resultado'] ?? null;//ISSET()

//ELIMINAR EL REGISTRO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //VALIDAR QUE SEA UN int
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    //ELIMINAR
    if ($id) {

        //ELIMINAR VENDEDOR O PROPIEDAD
        $tipo = $_POST['tipo'];

        if (validarTipoContenido($tipo)) {
            if ($tipo === 'vendedor') {
                //Verificar que existe ese ID
                $vendedor = Vendedor::find($id);//Devuelve un OBJETO

                //ELIMINA VENDEDOR
                $vendedor->eliminar();
                
            }else if ($tipo === 'propiedad') {
                //Verificar que existe ese ID
                $propiedad = Propiedad::find($id);//Devuelve un OBJETO

                //ELIMINA PROPIEDAD
                $propiedad->eliminar();
            }
        }

        
    }
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raíces</h1>

        <!--MENSAJES DE CREACION O ACTUALIZACIÓN DE PROPIEDAD-->
        <?php 
        $mensaje = mostrarNotificacion(intval($resultado));
        if ($mensaje) { ?>
            <p class="alerta exito"><?=s($mensaje);?></p>
        <?php } ?>
        
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva propiedad</a>
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo vendedor</a>

        <h2>Propiedades</h2>

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
                <!--foreach para recorrer ARREGLOS-->
                <?php foreach($propiedades as $propiedad): ?>
                
                    <tr>
                        <td><?=$propiedad->id;?></td>
                        <td><?=$propiedad->titulo;?></td>
                        <td><img src="/imagenes/<?=$propiedad->imagen;?>" class="imagen-tabla"></td>
                        <td>$ <?=$propiedad->precio;?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?=$propiedad->id;?>">
                                <input type="hidden" name="tipo" value="propiedad">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                        
                            <a href="propiedades/actualizar.php?id=<?=$propiedad->id;?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                
                <?php endforeach; ?>
                
            </tbody>
        </table>


        <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!--foreach para recorrer ARREGLOS-->
                <?php foreach($vendedores as $vendedor): ?>
                
                    <tr>
                        <td><?=$vendedor->id;?></td>
                        <td><?=$vendedor->nombre.' '.$vendedor->apellidos;?></td>
                        <td><?=$vendedor->telefono;?></td>
                        <td>
                            <form method="POST" class="w-100">
                                <input type="hidden" name="id" value="<?=$vendedor->id;?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                        
                            <a href="vendedores/actualizar.php?id=<?=$vendedor->id;?>" class="boton-amarillo-block">Actualizar</a>
                        </td>
                    </tr>
                
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </main>


<?php 
//CERRAR LA CONEXION A LA BD
mysqli_close($db);

incluirTemplate('footer'); 
?>