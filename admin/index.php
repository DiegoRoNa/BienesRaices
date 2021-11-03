<?php 

//CONEXION A LA BD
require '../includes/config/database.php';
$db = conectarDB();

//QUERY
//CONSULTAR TODOS LOS VENDEDORES
$consulta = "SELECT * FROM propiedades;";

//EJECUTAR CONSULTA
$resultadoConsulta = mysqli_query($db, $consulta);

$resultado = $_GET['resultado'] ?? null;//ISSET()

require '../includes/funciones.php';
incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raíces</h1>

        <?php if(intval($resultado) === 1): ?>
            <p class="alerta exito">Propiedad registrada correctamente</p>
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
                            <a href="#" class="boton-rojo-block">Eliminar</a>
                            <a href="#" class="boton-amarillo-block">Actualizar</a>
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