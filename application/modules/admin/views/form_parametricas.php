<script type="text/javascript" src="<?php echo base_url("js/admin/parametricas.js"); ?>"></script>	
<div class="container">
    <div class="page-header">
        <h2>Datos paramétricos del sistema</h2>
    </div>

    <div class="row">
        <div class="col-md-12 alert alert-info" align="justify">
            <strong>A continuación se presenta los datos paramétricos del sistema, para poderlos actualizar. </strong><br>
        </div>
    </div>     

    <div class="well">
        <div class="row">
            <div class="col-md-12"> 
                <form id="formulario" name="formulario">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="txtIdentificacion">Nombre del Coordinador</label>
                            <input type="text" id="txtCoordinador" name="txtCoordinador" value="<?php echo $parametricas[0]["VALOR"]; ?>" class="form-control" placeholder="Nombre Coordinador" autofocus>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtSexo">Sexo</label>
                            <select name="sexo" id="sexo" class="form-control"  >
                                    <option value='' >...</option>
                                    <option value='F' <?php if('F'==$parametricas[1]["VALOR"]){?>selected="selected"<?php }?>>Femenino</option>
                                    <option value='M' <?php if('M'==$parametricas[1]["VALOR"]){?>selected="selected"<?php }?>>Masculino</option>					
                            </select>
                        </div>                                      
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="txtEmail">Correo Electr&oacute;nico del Administrador del Sistema</label>
                            <input type="text" id="txtEmail" name="txtEmail" value="<?php echo $parametricas[2]["VALOR"]; ?>" class="form-control" placeholder="Correo Electr&oacute;nico " >
                        </div>
                    </div>

                    <br/> 			

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
    </div>
</div>