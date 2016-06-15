/**
 * Funciones JavaScript para editar usuario
 * @author hhchavezv	
 * @since  2016ene14
 */
 
$(function(){ 

	
	$("#formEditEstado").validate({
		
		//Reglas de Validacion
		rules : {
                        estado    : {	required	:	true  }
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
	
	$("#btnEditar").click(function(){		
	
		if ($("#formEditEstado").valid() == true){
		
				
			if(window.confirm('Haga clic en Aceptar para guardar'))
			{
			//Activa icono guardando
			$('#btnEditar').attr('disabled','-1');
			$("#div_guardado").css("display", "none");
			$("#div_error").css("display", "none");
			$("#div_msj").css("display", "none");
			$("#div_cargando").css("display", "inline");
			
				$.ajax({
					type: "POST",
					url: base_url + "admin/updateEstado",					
					
					data: $("#formEditEstado").serialize(),
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
							
							alert('Se actualiz\xf3 correctamente.');
							var url = base_url + "admin/pendientes/"+data.formulario;    
							$(location).attr("href",url);
							
							$('#btnEditar').removeAttr('disabled');
							
						}
						else
						{
							alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
							$("#div_cargando").css("display", "none");
							$("#div_error").css("display", "inline");
							$('#btnEditar').removeAttr('disabled');
						}	
					},
					error: function(result) {
						alert('Error al guardar. Intente nuevamente o actualice la p\u00e1gina.');
						$("#div_cargando").css("display", "none");
						$("#div_error").css("display", "inline");
						$('#btnEditar').removeAttr('disabled');
					}
					
		
				});	
			}
			
		}//if			
	});
	
	
	$("#txtClave").blur(function(){
		if( $("#txtClave").val() !="" )
			validaClave( $("#txtClave").val() );
	});
	
	
	
	
	
});//End	

/**
 * Valida que una clave tenga numeros y letras mayusculas
 * @author hhchavezv	
 * @since  2016ene14
 */
function validaClave(pswd)
{
	var texto="";
	var cuenta=0;
		
		//validamos la letra mayuscula
		if ( pswd.match(/[A-Z]/) ) {
		}
		else
		{
		  texto=texto+"\n -Debe tener al menos una letra may\u00fascula";
		  cuenta=1;
		} 
		//validamos el numero
		if ( pswd.match(/\d/) ) {
		}
		else
		{
		  texto=texto+"\n -Debe tener al menos un n\u00famero";
		  cuenta=1;
		}
		texto=texto+"\n\n";
		if (cuenta==1)
		{
			alert ("Por favor tenga en cuenta que la contrase\xf1a:\n"+texto);
			$("#txtClave").val("");
		}
		

}


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
	
	
	