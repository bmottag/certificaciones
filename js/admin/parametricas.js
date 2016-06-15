/**
 * Funciones JavaScript para editar usuario
 * @author bmottag	
 * @since  19/04/2016
 */
 
$(function(){ 
    
	$("#txtCoordinador").maxlength(240).convertirMayuscula();
	$("#txtEmail").maxlength(100).convertirMinuscula();    

	$("#formulario").validate({
		
		//Reglas de Validacion
		rules : {
			txtCoordinador       : {	required	:	true },
			sexo                 : {	required	:	true },
			txtEmail             : {	required	:	true ,
                                                        emailValido	:	true}
		},
		//Mensajes de validacion
		messages : {	
			txtCoordinador   : {	required    :   "Debe ingresar nombre del Coordonador."},
			sexo         : {	required    :   "Debe seleccionar el sexo."},
			txtEmail            : {	required    :	"Debe digitar correo electr&oacute;nico.", 
                                                emailValido :	"No es una direcci\u00f3n de correo electr\u00f3nico v\u00e1lida"}
		
			
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
					url: base_url + "admin/updateParams",					
					
					data: $("#formulario").serialize(),
					//dataType: "html",
					dataType: "json",
					contentType: "application/x-www-form-urlencoded;charset=UTF-8",
					cache: false,
					
					success: function(data){
										
                                                if( data.result )//true
						{	
							//Oculta icono guardando
							$("#div_cargando").css("display", "none");
							$("#div_guardado").css("display", "inline");
							
							alert('Se guardo correctamente.');
							
							$('#btnGuardar').removeAttr('disabled');
							
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