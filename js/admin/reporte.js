/**
 * Funciones JavaScript para modulo de Busqueda de personas
 * @author hhchavezv	
 * @since  2016ene15
 */
 
	$(function(){
            
            
            
	$('#fecha_inicial, #fecha_final').datepicker({		
		 dateFormat: 'dd/mm/yy',
		 //minDate:'-1y',
		 maxDate:'now',
		 changeYear: true,
		 changeMonth: true,		 
		 showMonthAfterYear: true,		 
		 //showButtonPanel: true
		 
		 yearRange: '1901:2100'
	});            
		
				
		//Configuracion de JQGrid
		$.jgrid.defaults.width = 1100;
		$.jgrid.defaults.styleUI = 'Bootstrap';
		$.jgrid.defaults.responsive = true;
		
		//Ejecuta Ajax JSON para llenar los datos del grid jquery por primera vez
		
		var fechaIni = $("#fecha_inicial").val();   
		var fechaFin = $("#fecha_final").val();   
		
		var data = new Array(fechaIni,fechaFin);
		
		$("#jqGrid").jqGrid({
			
			url: generateGetURL("admin/busquedaCertificacionesFechaAJAX/", data),						
			datatype: "json",
			colModel: [
                                { label: 'Fecha', name: 'txtFecha', width: 70 },
                                { label: 'Nro. C&eacute;dula', name: 'txtNroId', width: 90, sorttype: 'number' },
                                { label: 'Nombre', name: 'txtNombre', width: 240 },
                                { label: 'Email', name: 'txtEmail', width: 180 },
                                { label: 'Tipo de certificado', name: 'txtTipoCert', width: 260 },
                                { label: 'Con Destino A', name: 'txtEntidad', width: 160 },
                                { label: 'Estado', name: 'txtEstado', width: 100 }
							
			],
			
			viewrecords: true,  //show the current page, data rang and total records on the toolbar
			shrinkToFit: false, //Muestra la barra de desplazamiento horizontal
			width: 1100,
			height: 400,
			rowNum: 10,
			loadonce: true, // this is just for the demo
			pager: "#jqGridPager"
		});
		
		
		
		//Función que se ejecuta al hacer click sobre el botón de busqueda de usuarios
		//@author: hhchavezv
		//@since: 2016ene12
		$("#btnBuscar").bind("click",function(){	
			
			$.ajax({ // verifica si hay sesion
					type: "POST",
					url: base_url + "admin/validaSesion",										
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
					
						if( resultadoValido(data) )
						{	
							
                                                        var fechaIni = $("#fecha_inicial").val();   
                                                        var fechaFin = $("#fecha_final").val(); 
							var data = new Array(fechaIni,fechaFin);
							$("#jqGrid").setGridParam({
								url: generateGetURL("admin/busquedaCertificacionesFechaAJAX/", data), 
								datatype:'json'
							}).trigger('reloadGrid',[{page:1}]);
						}
						else{
							alert ('La sesi\u00f3n termin\u00f3. Vuelva a ingresar por favor.');
							location.reload();
							
						}
						
						
					},
					error: function(result) {
						alert('Error al buscar. Intente nuevamente o actualice la p\u00e1gina.');
						
					}
					
		
				});
		
												
		});
		
		
		
	}); //EOC
	


function resultadoValido(data)
{
	if( (!/ERROR/.test(data)) && (!/Error/.test(data)) && (!/error/.test(data)) && (/-ok-/.test(data)) )
		return true;
	else
		return false;
}

//*************************************************************************************************
//* Genera una direccion URL para paso de parametros por GET, para el envio de AJAX en JavaScript
//*************************************************************************************************
function generateGetURL(path, data){
	var i = 0;
	var url = base_url + path;
	for (i=0; i<data.length; i++){
		if (isNaN(data[i]) && data[i].indexOf("/") > 0){
			step1 = data[i].replace('/','-');
			step2 = step1.replace('/','-');
			data[i] = step2;			
		}
		else if (data[i]==""){
			data[i] = '-';
		}
		url = url + encodeURIComponent(data[i]) + "/";		
	}
	url = url.substring(0, url.length -1);
	return decodeURIComponent(url);
}