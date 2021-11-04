<?php 


require 'includes/funciones.php';
incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Casas y departamentos en venta</h1>

        <?php
            $limit = 10;
            include 'includes/templates/anuncios.php'; 
        ?>
    </main>

<?php incluirTemplate('footer'); ?>