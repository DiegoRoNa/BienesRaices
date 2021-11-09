<fieldset>
    <legend>Información general</legend>

    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre vendedor" value="<?=s($vendedor->nombre);?>">

    <label for="apellidos">Apellidos</label>
    <input type="text" id="apellidos" name="vendedor[apellidos]" placeholder="Apellidos vendedor" value="<?=s($vendedor->apellidos);?>">

</fieldset>

<fieldset>
    <legend>Información extra</legend>

    <label for="telefono">Teléfono</label>
    <input type="text" id="telefono" name="vendedor[telefono]" placeholder="Teléfono vendedor" value="<?=s($vendedor->telefono);?>">

</fieldset>