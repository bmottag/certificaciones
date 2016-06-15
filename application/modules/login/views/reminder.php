<form id="frmReminder" name="frmReminder" method="post" action="<?php echo site_url("/login/olvido"); ?>">
<div class="row">
	<div class="col-md-12">
		<p>&nbsp;</p>
		<h3>Recordar Contraseña</h3>
		<p align="justify">Por favor ingresar la direccón de correo eletrónico que que utilizó en el registro.</p>
		<br/>
		<div class="row">
			<div class="col-md-4">&nbsp;</div>
			<div class="col-md-4">
				<label for="txtReminder">Correo electr&oacute;nico:</label>
				<input type="email" id="txtReminder" name="txtReminder" class="form-control" placeholder="Correo electr&oacute;nico" required autofocus>
				<br/>
				<button class="btn btn-primary" type="submit" id="btnRecordatorio" name="btnRecordatorio">Recordar mi contrase&ntilde;a</button>
			</div>
			<div class="col-md-4">&nbsp;</div>
		</div>
		<br/><br/>
		<div class="row">
			<div class="col-md-12">
				<p>Se enviar&aacute; un email a la direcci&oacute;n de correo electr&oacute;nico registrada, para recordarte tu usuario y contrase&ntilde;a de acceso.</p>
			</div>
		</div>
	</div>
</div>
</form>
