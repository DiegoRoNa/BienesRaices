<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Bienes Raíces</title>

    <link rel="stylesheet" href="build/css/app.css">
</head>
<body>

    <!--CLASE INICIO DE LA PAGINA PRINCIPAL-->
    <header class="header <?=$inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="index.php">
                    <img src="build/img/logo.svg" alt="Logotipo de Bienes raices">
                </a>

                <div class="mobile-menu">
                    <img src="build/img/barras.svg" alt="Icono menú responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                    </nav>
                </div>
                
            </div>

            <!--TITULO DE LA PAGINA PRINCIPAL-->
            <?php if($inicio): ?>
                <h1>Venta de Casas y Departamentos de lujo</h1>
            <?php endif;?>
            
        </div>
    </header>