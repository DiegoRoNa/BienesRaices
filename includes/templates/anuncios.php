<?php

//OBTENER LA CONEXION A LA BD
require __DIR__.'/../config/database.php';
$db = conectarDB();

//CONSULTA A LA BD
$query = "SELECT * FROM propiedades LIMIT ${limit};";
$resultado = mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">
            <picture>
                <img loading="lazy" src="/imagenes/<?=$propiedad['imagen'];?>" alt="anuncio">
            </picture>

            <div class="contenido-anuncio">
                <h3><?=$propiedad['titulo'];?></h3>
                <p><?=$propiedad['descripcion'];?></p>
                <p class="precio">$<?=$propiedad['precio'];?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p><?=$propiedad['wc'];?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?=$propiedad['estacionamiento'];?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?=$propiedad['habitaciones'];?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?=$propiedad['id'];?>" class="boton-amarillo-block">Ver propiedad</a>
            </div><!--contenido-anuncio-->
        </div><!--anuncio-->
    <?php endwhile; ?>
</div><!--contenedor-anuncios-->

<?php 
//CERRAR LA CONEXIÓN A LA BD
mysqli_close($db);

?>

