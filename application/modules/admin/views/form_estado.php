<link href="<?php echo base_url("/css/admin.css"); ?>" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo base_url("js/admin/editar_certificado.js"); ?>"></script>
<div class="container">
    <div class="page-header">
        <h3>Cambiar estado de la solicitud No.: <?php echo $idCertificado; ?></h3>
    </div>
</div>

<div class="container">
    <form id="formEditEstado" name="formEditEstado">
        <input type="hidden" id="idCertificado" name="idCertificado" value="<?php echo $idCertificado; ?>" /> 	
        <div class="row">
            <div class="col-md-4 form-group encabezadoDetalleUsuario " <?php // colores bootstrap: bg-primary bg-success bg-info bg-warning bg-danger  ?>
                 <label>No. de C&eacute;dula :</label>    
            </div>
            <div class="col-md-4 form-group ">
                <label class="label-control"><?php echo $certificado["NUM_IDENT"]; ?></label>    		
            </div>
        </div>	
        
        <div class="row">
            <div class="col-md-4 form-group encabezadoDetalleUsuario" 
                 <label>Nombre:</label>    
            </div>
            <div class="col-md-4 form-group ">
                <label class="label-control"><?php echo $certificado["NOMBRES"] . ' ' . $certificado["APELLIDOS"]; ?></label> 
            </div>
        </div>	
        
        <div class="row">
            <div class="col-md-4 form-group encabezadoDetalleUsuario" 
                 <label>Fecha de solicitud :</label>    
            </div>
            <div class="col-md-4 form-group ">
                <label class="label-control"><?php echo $certificado["FECHA_RADICADO"]; ?></label> 			
            </div>
        </div>	

        <div class="row">
            <div class="col-md-4 form-group encabezadoDetalleUsuario">
                <label>Tipo de certificado :</label>
            </div>
            <div class="col-md-4 form-group ">
                <label class="label-control"><?php echo $certificado["TIPO_CERTIFICADO"]; ?></label>    		
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-group encabezadoDetalleUsuario" 
                 <label>Correo :</label>    
            </div>
            <div class="col-md-4 form-group ">
                <label class="label-control"><?php echo $certificado["CORREO"]; ?></label> 			
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 form-group encabezadoDetalleUsuario">
                <label>Con Destino A :</label>
            </div>
            <div class="col-md-4 form-group ">
                <label class="label-control">
                    <?php 
                        if ($certificado["ENTIDAD"]){
                            echo $certificado["ENTIDAD"]; 
                        }else {
                            echo "el interesado";
                        }
                    ?>
                </label>    		
            </div>
        </div>        
        
        <div class="row">
            <div class="col-md-4 form-group encabezadoDetalleUsuario" 
                 <label>Información Adicional :</label>    
            </div>
            <div class="col-md-4 form-group ">
                <label class="label-control">
                    <?php 
                        if($certificado["NIT"]){ echo "Con NIT del DANE.<br>";} 
                        if($certificado["SALARIO"]){ echo "Con Salario.<br>";} 
                        if($certificado["ENCARGO"]){ echo "Con ENCARGO si lo tiene.";}; 
                    ?>
                </label>
            </div>
        </div>        

        <div class="row">
            <div class="col-md-4 form-group encabezadoClave">
                <label>Estado</label>
            </div>
            <div class="col-md-4 form-group ">
                <select id="estado" name="estado">
                    <option value="">Seleccione...</option>
                    <option value="2" >Generada</option>
                    <option value="3" >Cancelada</option>
                </select>	
            </div>

        </div>
        <div class="row">
            <div class="col-md-4 form-group encabezadoClave">
                <label>Obaservación</label>
            </div>
            <div class="col-md-4 form-group ">
                <input type="text" class="form-control"	id="observacion" name="observacion" />  		
            </div>

        </div>

        <br>


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
                    <div class="alert alert-success"> <span class="glyphicon glyphicon-ok">&nbsp;</span>Guardado correctamente</div>

                </div>	
                <div id="div_error" style="display:none">			
                    <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span>Error al guardar. Intente nuevamente o actualice la p&aacute;gina</div>			
                </div>	

                <div id="div_msj" style="display:none">			
                    <div class="alert alert-danger"><span class="glyphicon glyphicon-remove">&nbsp;</span> <span id="span_msj">&nbsp;</span></div>			
                </div>

                <br>
                <input type="button" class="btn btn-primary" value="Guardar" name="btnEditar" id="btnEditar">

            </div>
        </div>

    </form>	
</div>

