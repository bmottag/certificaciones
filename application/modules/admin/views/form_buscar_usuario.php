<script type="text/javascript" src="<?php echo base_url("js/admin/usuarios.js"); ?>"></script>	

<div class="container">
	<div class="page-header">
		<h2>Buscar usuario por número de cédula</h2>
	</div> 
	<div class="well">
		<div class="row">
			<div class="form-group col-md-2">
				<label >C&eacute;dula</label>
				<input type="text" id="txtCedula" name="txtCedula" value="<?php echo (isset($identifica))?$identifica:""; ?>" class="form-control" placeholder="N&uacute;mero de C&eacute;dula"  required autofocus>
			</div>
                        <div class="form-group col-md-2"><br>
                                <input type="button" class="btn btn-primary" value="BUSCAR" name="btnBuscar" id="btnBuscar">
			</div>
                </div>
	</div>

    
<!--Inicio Formulario cambio de correo -->
	
    <div class="row" id="div_msjForm" style="display:none">
        <div class="col-md-12 alert alert-info" align="justify">
            <strong>A continuación se presenta los datos del usuario, para poderlos actualizar. </strong><br>
        </div>
    </div>     

    
        <div class="row" id="div_formulario" style="display:none">
            <div class="col-md-12"> 
                <form id="formulario" name="formulario">
                    <div class="row" id="datosUsuario"></div>
                    
                    <div class="row" align="center">
                        <div style="width:50%;" align="center">

                            <div id="div_cargando" style="display:none">		

                                <div class="progress progress-striped active">
                                    <div class="progress-bar" role="progressbar"
                                         aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 45%">
                                        <span class="sr-only">45% completado</span>
                                    </div>
                                </div>
                            </div>	
                            <div id="div_guardado" style="display:none">			
                                <div class="alert alert-success"> 
                                    <span class="glyphicon glyphicon-ok">&nbsp;</span>
                                    Guardado correctamente.
                                </div>

                            </div>	
                            <div id="div_error" style="display:none">			
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                            </div>	

                            <div id="div_msj" style="display:none">			
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span> <span id="span_msj">&nbsp;</span></div>			
                            </div>

                            <br>
                            <input type="button" class="btn btn-primary" value="Actualizar" name="btnGuardar" id="btnGuardar">

                        </div>
                    </div>				
                </form>
            </div>
        </div>
   
<!--Fin Formulario cambio de correo -->    
    
</div>