<div class="well">
    <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUser; ?>" />
    <div class="row">
        <div class="form-group col-md-4">
            <label for='txtNombres'>Nombre del funcionario </label>
            <input type='text' id='txtNombres' name='txtNombres' value='<?php echo $nombres; ?>' class='form-control' placeholder='Nombre' disabled='disabled'>
        </div>
    </div>
    <div class="row">

        <div class="form-group col-md-6">
            <label for="txtEmail">Correo Electr&oacute;nico</label>
            <input type='text' id='txtEmail' name='txtEmail' value='<?php echo $correo; ?>' class='form-control' placeholder='Correo' required autofocus>
        </div>
    </div>
</div>