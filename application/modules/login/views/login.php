<script src="<?php echo base_url("/js/login/login.js"); ?>"></script>


<div class="row margin-login"></div>
<div class="row">
    <div class="col-md-12 alert alert-info" align="center">
        <h3 class="list-group-item list-group-item-info">Sistema para generar certificaciones de funcionarios y exfuncionarios del DANE</h3><br>
        <button class="btn btn-info btn-lg" type="button" id="btnRegistra" name="btnRegistra">Registrarse</button>
    </div>
</div>


    <div class="row">
        <div class="col-md-12 alert alert-info" align="justify">
            <strong>Para tener en cuenta:</strong><br>
            <ul>
                <li>El Sistema permite generar certificaciones laborales con información salarial, cargo (titular y encargo, en el 
                    caso de servidores de Carrera Administrativa) y NIT del DANE, con la opci&oacute;n de ser dirigida a una Entidad.</li>
                <li>Para certificaciones con información de funciones o histórico de cargos, el sistema redirigirá su solicitud al operador de Gestión Humana para su tr&aacute;mite.</li>
                <li><a href="<?php echo base_url("files/manual_modulo_certificaciones.pdf"); ?>" target="_blank" > <img src="<?php echo base_url("images/pdf.png"); ?>"> Manual Usuario </a></li>
            </ul>            
        </div>
    </div> 



<div class="row ">
	<div class="col-md-4 well">
		<?php if (isset($enviado) && $enviado==true){ ?>
        		<div class="alert alert-info" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
          	<?php } elseif (isset($enviado) && $enviado==false){  ?>          
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
        		</div>
              	<?php } ?>

            <h4>Usuario Registrado:</h4>
            <div id="reslogin" class="alert alert-danger" role="alert"></div>
            <form id="frmIngreso" name="frmIngreso" method="post" action="<?php echo site_url("/login/userAuth"); ?>" class="form-signin">			
			<input type="email" id="txtUsuario" name="txtUsuario" class="form-control" placeholder="Correo electrónico" required autofocus>
			<br/>
			<input type="password" id="txtPassword" name="txtPassword" class="form-control" placeholder="Contraseña" required>
			<br/>
			<div class="g-recaptcha" data-sitekey="6LcqTg4TAAAAAN5yCK3f8wmkTpkilBE8rmTQr8gV"></div>
			<br/>
			<button class="btn btn-success" type="submit" id="btnIngresar" name="btnIngresar">Ingresar</button>
            
            <button class="btn btn-info" type="button" id="btnReminder" name="btnReminder">¿Olvidó su contraseña?</button>
            <p>&nbsp;</p>
          </form>	

  
	</div>	
	<div class="col-md-4 col-md-offset-4 well">
            <h4>Validar Cetificado,<br> ingresar c&oacute;go de validaci&oacute;n :</h4>
            <div id="resCodigo" class="alert alert-danger" role="alert"></div>
            <form id="frmCodigo" name="frmCodigo" method="post" action="<?php echo site_url("/login/userAuth"); ?>" class="form-signin">			
			<input type="text" id="txtCodigoValidacion" name="txtCodigoValidacion" class="form-control" placeholder="Codigo de Validación"  >

			<br/><br/>
                        <button class="btn btn-success" type="submit" id="btnValidacion" name="btnValidacion">Validar C&oacute;digo</button>
                 <p>&nbsp;</p>
            </form>
	</div>

</div>
