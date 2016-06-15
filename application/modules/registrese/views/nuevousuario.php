<script type="text/javascript" src="<?php echo base_url("js/registrese/registrese.js"); ?>"></script>	
<div class="container">
    <div class="page-header">
        <h2>Registrarse</h2>
    </div>

    <div class="row">
        <div class="col-md-12 alert alert-info" align="justify">
            <strong>Para tener en cuenta:</strong><br>
            <ul>
                <li>El Sistema permite generar certificaciones laborales con información salarial, cargo (titular y encargo, en el 
                    caso de servidores de Carrera Administrativa) y NIT del DANE, con la opci&oacute;n de ser dirigida a una Entidad.</li>
                <li>Para certificaciones con información de funciones o histórico de cargos, el sistema redirigirá su solicitud al operador de Gestión Humana para su tramite.</li>
                <li>Se recomienda a los funcionario activos indicar el correo actual de la entidad.</li>
            </ul>            
        </div>
    </div>     
    
    
    
    <div class="well">
        <div class="row">
            <div class="col-md-12"> 
                <form id="formulario"	name="formulario">
                    
                    <label>Ingresar los siguientes datos para tener acceso a las certificaciones del DANE. </label>
                    <br><br>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="txtIdentificacion">Nro. Identificaci&oacute;n</label>
                            <input type="text" id="txtIdentificacion" name="txtIdentificacion" value="<?php echo (isset($user["num_ident"])) ? $user["num_ident"] : ""; ?>" class="form-control" placeholder="N&uacute;mero de C&eacute;dula" autofocus>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="txtTelefono">Nro. Celular</label>
                            <input type="text" id="txtTelefono" name="txtTelefono" value="<?php echo (isset($user["tel_usuario"])) ? $user["tel_usuario"] : ""; ?>" class="form-control" placeholder="Nro. Celular" >
                        </div>                                      
                    </div>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="txtEmail">Correo Electr&oacute;nico</label>
                            <input type="text" id="txtEmail" name="txtEmail" value="<?php echo (isset($user["mail_usuario"])) ? $user["mail_usuario"] : ""; ?>" class="form-control" placeholder="Correo Electr&oacute;nico " >
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
                                    Guardado correctamente.<br>
                                    La información de acceso se envio a su correo electrónico
                                </div>

                            </div>	
                            <div id="div_error" style="display:none">			
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                            </div>	

                            <div id="div_msj" style="display:none">			
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span> <span id="span_msj">&nbsp;</span></div>			
                            </div>

                            <br>
                            <input type="button" class="btn btn-primary" value="Guardar" name="btnGuardar" id="btnGuardar">

                        </div>
                    </div>				
                </form>    		
            </div>
        </div>
    </div>
</div>