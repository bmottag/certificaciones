<script type="text/javascript" src="<?php echo base_url("js/admin/certificaciones_pendientes.js"); ?>"></script>
<div class="container">
    <div class="page-header" align="center">
        <h3>B&uacute;squeda de Usuarios con certificaciones pendientes</h3>		
    </div>
</div>
<div class="container">	
    <div class="row" style=" font-size: 12px;">
        <div class="col-md-1"></div>
        <div class="well col-md-12">

            <div class="row">

                <div class="form-group col-md-3">
                    <label>N&uacute;mero de Documento de Identificaci&oacute;n:</label><br/>
                    <input type="text" id="txtNroId" name="txtNroId" value="" class="form-control input-sm" placeholder="Num. Identificacion">
                </div>
                <div class="form-group col-md-3">
                    <label>Nombre</label><br/>
                    <input type="text" id="txtNombre" name="txtNombre" value="" class="form-control input-sm" placeholder="Nombre">
                </div>

                <div class="form-group col-md-3">
                    <label>Apellido</label><br/>					
                    <input type="text" id="txtApellido" name="txtApellido" value="" class="form-control input-sm" placeholder="Apellido">

                </div>

                <div class="form-group col-md-3" style="text-align: center;" >
                    <br>
                    <button type="button" id="btnBuscarUsuarios" name="btnBuscarUsuarios" class="btn btn-sm btn-primary">Buscar</button>
                </div>
            </div>
            <div class="row" 
            </div>

        </div>			

    </div>	
    <br/>
    <div class="row" >
        <div id="resultAAdmin" class="col-md-12">
            <div class="centergrid" >
                <table id="jqGrid" style="font-size:12px;"></table>
                <div id="jqGridPager"></div>
            </div>
        </div>
    </div>
</div>