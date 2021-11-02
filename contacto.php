
<?php 

require 'includes/funciones.php';
incluirTemplate('header');

?>


    <main class="contenedor seccion">
        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
        </picture>

        <h2>Llene el formulario de contacto</h2>

        <form class="formulario" action="">
            <fieldset>
                <legend>Información personal</legend>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre">

                <label for="email">Correo:</label>
                <input type="email" id="email" name="email" placeholder="Tu correo">

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Tu telefono">

                <label for="mensaje">Mensaje:</label>
                <textarea id="mensaje" name="mensaje"></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <label for="opciones">Vende o compra:</label>
                <select name="opciones" id="opciones">
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="compra">Compra</option>
                    <option value="vende">Vende</option>
                </select>

                <label for="presupuesto">Precio o presupuesto:</label>
                <input type="number" id="presupuesto" name="presupuesto" placeholder="Tu precio o presupuesto">
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <p>Como desea ser contactado</p>

                <div class="forma-contacto">
                    <label for="contactar-telefono">Teléfono:</label>
                    <input type="radio" value="telefono" name="contacto" id="contactar-telefono">

                    <label for="contactar-email">Correo:</label>
                    <input type="radio" value="email" name="contacto" id="contactar-email">
                </div>

                <p>Si eligió teléfono, seleccione la fecha y la hora</p>

                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha">

                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" min="09:00" max="18:00">
            </fieldset>

            <input class="boton-verde" type="submit" value="Enviar">
        </form>
    </main>

<?php incluirTemplate('footer'); ?>