/**
 * Funciones JavaScript para modulo de Busqueda de usuarios
 * @author hhchavezv	
 * @since  2016ene12
 */
 
	$(function(){
		
				
		//Configuracion de JQGrid
		$.jgrid.defaults.width = 1150;
		$.jgrid.defaults.styleUI = 'Bootstrap';
		$.jgrid.defaults.responsive = true;
		
		//Ejecuta Ajax JSON para llenar los datos del grid jquery por primera vez
		var txtNroId = $("#txtNroId").val();   
		var txtNombre = $("#txtNombre").val();   
		var txtApellido = $("#txtApellido").val();

		
		var data = new Array(txtNroId,txtNombre,txtApellido);
		
		$("#jqGrid").jqGrid({
			//url: base_url + "gh_actosadmin/gh_actosadmin/jsonQuery",
			url: generateGetURL("admin/busquedaCertificacionesAJAX/", data),						
			datatype: "json",
			colModel: [
			    { label: 'Nro. C&eacute;dula', name: 'txtNroId', width: 90, sorttype: 'number' },
                            { label: 'Nombre', name: 'txtNombre', width: 240 },
                            { label: 'Email', name: 'txtEmail', width: 180 },
                            { label: 'Tipo de certificado', name: 'txtTipoCert', width: 260 },
                            { label: 'Con salario', name: 'txtSalario', width: 80 },				
                            { label: 'Con NIT', name: 'txtNit', width: 70 },				
                            { label: 'Con Destino A', name: 'txtEntidad', width: 160 },
                            { label: 'Opciones', name: 'opc', width: 70 }								
			],
			
			viewrecords: true,  //show the current page, data rang and total records on the toolbar
			shrinkToFit: false, //Muestra la barra de desplazamiento horizontal
			width: 1150,
			height: 400,
			rowNum: 10,
			loadonce: true, // this is just for the demo
			pager: "#jqGridPager"
		});
		
		
		
		//Función que se ejecuta al hacer click sobre el botón de busqueda de usuarios
		//@author: hhchavezv
		//@since: 2016ene12
		$("#btnBuscarUsuarios").bind("click",function(){	
			
			$.ajax({ // verifica si hay sesion
					type: "POST",
					url: base_url + "admin/validaSesion",										
					dataType: "html",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
					
						if( resultadoValido(data) )
						{	
		
							var txtNroId = $("#txtNroId").val();   
							var txtNombre = $("#txtNombre").val();      
							var txtApellido = $("#txtApellido").val();	
							var data = new Array(txtNroId,txtNombre,txtApellido);
							$("#jqGrid").setGridParam({
								url: generateGetURL("admin/busquedaCertificacionesAJAX/", data), 
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