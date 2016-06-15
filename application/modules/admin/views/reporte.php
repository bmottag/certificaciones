<script type="text/javascript" src="<?php echo base_url("js/admin/reporte.js"); ?>"></script>
<div class="container">
    <div class="page-header" align="center">
        <h3>B&uacute;squeda para un per&iacute;odo</h3>		
    </div>
</div>
<div class="container">	
    <div class="row" style=" font-size: 12px;">
        <div class="col-md-1"></div>
        <div class="well col-md-12">

            <div class="row">

                <div class="form-group col-md-3">
                    <label>Fecha Inicial</label><br/>
                    <input type='text' class="valid" name='fecha_inicial' id='fecha_inicial' class="form-control input-sm" readonly="readonly" value="" />
                </div>
                <div class="form-group col-md-3">
                    <label>Fecha Final</label><br/>
                    <input type='text' class="valid" name='fecha_final' id='fecha_final' class="form-control input-sm" readonly="readonly" value="" />
                </div>

                <div class="form-group col-md-3" style="text-align: center;" >
                    <br>
                    <button type="button" id="btnBuscar" name="btnBuscar" class="btn btn-sm btn-primary">Buscar</button>
                </div>
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