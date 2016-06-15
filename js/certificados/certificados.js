/**
 * Funciones JavaScript para editar usuario
 * @author hhchavezv	
 * @since  2016ene14
 */
 
$(function(){ 

	$("#formulario").validate({
		
		//Reglas de Validacion
		rules : {
			tipo_certi       : {	required	:	true }
		},
		//Mensajes de validacion
		messages : {	
			tipo_certi   : {	required    :   "Debe seleccionar un tipo de certificaci&oacute;n."}
		
			
		},
		//Mensajes de error
		errorPlacement: function(error, element) {
			element.after(error);		        
			error.css('display','inline');
			error.css('margin-left','10px');				
			error.css('color',"#FF0000");
			
		//	$(element).focus();
		},
		submitHandler: function(form) {
			return true;
			
		}
	});
	
	$("#btnGuardar").click(function(){		
	
		if ($("#formulario").valid() == true){
		
				
			if(window.confirm('Haga clic en Aceptar para guardar'))
			{
			//Activa icono guardando
			$('#btnGuardar').attr('disabled','-1');
			$("#div_guardado").css("display", "none");
			$("#div_error").css("display", "none");
			$("#div_msj").css("display", "none");
			$("#div_cargando").css("display", "inline");
			
				$.ajax({
					type: "POST",
					url: base_url + "certificados/GenerarSolicitud",					
					
					data: $("#formulario").serialize(),
					//dataType: "html",
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
                                            
 
						if( data.result == "error" )// cedula ya existe
						{
							alert(data.mensaje);
							$("#div_cargando").css("display", "none");
							$('#btnGuardar').removeAttr('disabled');							
							
							$("#span_msj").html(data.mensaje);
							$("#div_msj").css("display", "inline");
							return false;
						
						} 

						
										
					  if( data.result )//true
						{	
							//Oculta icono guardando
							$("#div_cargando").css("display", "none");
							$("#div_guardado").css("display", "inline");
							
							alert('Su solicitud se recibió correctamente.');

							
							$('#btnGuardar').removeAttr('disabled');
                                                        
                                                        
                                                        
									
							
							$("#span_msj_documento").html(data.mensaje);
					                                                           
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
							
						}
						else
						{
							alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnGuardar').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnGuardar').removeAttr('disabled');
					}
					
		
				});	
			}
			
		}//if			
	});
	

	
	
	
	
});//End	



/**
 * Funcion para evitar caracter espacio en caja de texto
 * @author hhchavezv	
 * @since  2016ene27
 */
	$.fn.bloqueaEspacio = function() {
		
		return this.keypress(function(event)
		{
			if ( (event.which == 32) ) //espacio
				return false;
			else
				return true;
		});     
	};
	
	
	