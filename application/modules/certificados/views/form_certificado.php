<script type="text/javascript" src="<?php echo base_url("js/certificados/certificados.js"); ?>"></script>
<div class="container">
    <div class="page-header">
        <h2>Solicitar Certificaci&oacute;n</h2>              
    </div>	
    <div class="well">
        <div class="row">
            <div class="col-md-12"> 
                <form id="formulario"	name="formulario">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="txtIdentificacion">Nro. Identificaci&oacute;n</label>
                            <h5><?php echo (isset($identifica)) ? number_format($identifica) : ""; ?> </h5>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="txtNombres">Nombres </label>
                            <h5><?php echo (isset($nombres)) ? $nombres : ""; ?></h5>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="txtApellidos">Apellidos</label>
                            <h5><?php echo (isset($apellidos)) ? $apellidos : ""; ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="alert alert-info">
                                <strong>Para tener en cuenta:</strong><br>
                                <ul>
                                    <li>Si usted requiere una certificación laboral con información salarial y cargo (titular y encargo, en el caso de servidores de Carrera Administrativa), que contenga además NIT del DANE o dirigida a alguna Entidad, seleccione la opción “Certificación Laboral”.</li>
                                    <li>Si va a solicitar una certificación con funciones o histórico de cargos, seleccione alguna de las otras opciones, ésta será tramitada por el Área de Gestión Humana, en un plazo m&iacute;nimo de diez (10) d&iacute;as h&aacute;biles.</li>

                                </ul>
                            </div>
                        </div>
                    </div>                             

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cmbTipoCertificacion">Seleccionar tipo de certificaci&oacute;n:</label>
                            <select class="form-control" id="tipo_certi" name="tipo_certi" class="form-control" autofocus>
                                <option value="">Seleccione...</option>
                                <?php for ($i = 0; $i < count($tiposcerti); $i++) { ?> 
                                    <option  value="<?php echo $tiposcerti[$i]["ID_TIPO"]; ?>"><?php echo $tiposcerti[$i]["TIPO_CERTIFICADO"]; ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="form-group col-md-4 col-md-offset-2 ">
                            <label for="cmbTipoCertificacion">Seleccionar informaci&oacute;n adicional del certificado</label><br>
                            <input type="checkbox" name="nit" value="1" > Con NIT del DANE<br>
                            <?php if ($this->session->userdata("estado") == "ACTIVO") { ?>
                                <input type="checkbox" name="salario" value="1"> Con salario<br>
                                <input type="checkbox" name="encargo" value="1" > Con ENCARGO si lo tiene
                            <?php } ?>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtIdentificacion">Si la certificaci&oacute;n va dirigida a una Entidad espec&iacute;fica, por favor ind&iacute;quela a continuaci&oacute;n. De lo contrario deje el campo en blanco y ser&aacute; dirigida al interesado.</label>
                            <input type="text" id="txtEntidad" name="txtEntidad" class="form-control" placeholder="Entidad">                                                
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
                                <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente
                                    <br><span id="span_msj_documento" class="pdf">&nbsp;</span>
                                </div>
                            </div>	
                            <div id="div_error" style="display:none">			
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                            </div>	

                            <div id="div_msj" style="display:none">			
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span> <span id="span_msj">&nbsp;</span></div>
                            </div>

                            <br>
                            <input type="button" class="btn btn-primary" value="Enviar Solicitud" name="btnGuardar" id="btnGuardar">

                        </div>
                    </div>				
                </form>    		
            </div>
        </div>
    </div>
</div>