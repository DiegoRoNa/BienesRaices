<fieldset>
    <legend>Información general</legend>

    <label for="titulo">Título</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Título propiedad" value="<?=s($propiedad->titulo);?>">

    <label for="precio">Precio</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio propiedad" value="<?=s($propiedad->precio);?>">

    <?php if($propiedad->imagen): ?>
        <img src="/imagenes/<?=$propiedad->imagen;?>" class="imagen-small">
    <?php endif; ?>
    
    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" name="propiedad[imagen]" accept="image/jpeg, image/png">

    <label for="descripcion">Descripción</label>
    <textarea name="propiedad[descripcion]" id="descripcion"><?=s($propiedad->descripcion);?></textarea>
</fieldset>

<fieldset>
    <legend>Información de la propiedad</legend>

    <label for="habitaciones">Habitaciones</label>
    <input type="number" id="habitaciones" name="propiedad[habitaciones]" placeholder="Ej: 3" min="1" max="9" value="<?=s($propiedad->habitaciones);?>">

    <label for="wc">Baños</label>
    <input type="number" id="wc" name="propiedad[wc]" placeholder="Ej: 3" min="1" max="9" value="<?=s($propiedad->wc);?>">

    <label for="estacionamiento">Estacionamiento</label>
    <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3" min="1" max="9" value="<?=s($propiedad->estacionamiento);?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    
    <label for="idVendedor">Vendedor</label>
    <select name="propiedad[idVendedor]" id="idVendedor">
        
        <option value="">-- Seleccione --</option>
        <?php foreach($vendedores as $vendedor): ?>
            <option <?=$propiedad->idVendedor === $vendedor->id ? 'selected' : '';?>
            value="<?=$vendedor->id?>">
                <?=$vendedor->nombre.' '.$vendedor->apellidos;?>
            </option>
        <?php endforeach; ?>
        
    </select>
</fieldset>
