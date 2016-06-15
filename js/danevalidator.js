/**********************************************************************************
 * Septiembre 15 de 2015
 * Libreria para la validacion de formularios de captura (Encuestas DANE)
 * Requiere de: 
 *  - jquery.validate.min.js
 *  - jquery.qtip.js
 **********************************************************************************/
	//var base_url = "/dimpe/cnpv/";  //Ruta base para ejecutar AJAX en CodeIgniter
	var base_url = "http://192.168.1.200/dimpe/daneweb/certificaciones/"; //Ruta base para ejecutar AJAX en CodeIgniter
	
	//********************************************************************************************
	//* 1) Establece el valor máximo de caracteres que pueden ir en una caja de texto.
	//********************************************************************************************
	$.fn.maxlength = function(expresion) {
		return this.keypress(function(event){
			if ((event.which == 8)||(event.which == 0)) 
				return true;
			else if ($(this).val().length < expresion)
					return true;
				 else
					return false;
		});     
	};
	

	//*******************************************************************************************
	//* 2) Bloquea el ingreso de caracteres de texto en una caja de texto. Solo permite números
	//*******************************************************************************************
	$.fn.bloquearTexto = function() {
		return this.keypress(function(event){
    		if ((event.which == 8)||(event.which == 0)) return true;
    		if ((event.which >=48)&&(event.which <=57)) 
    			return true;
    		else
    			return false;    		
		});     
	};
	
	//******************************************************************************************
	//* 3) Bloquea el ingreso de caracteres numericos en una caja de texto. Solo permite letras
	//******************************************************************************************
	$.fn.bloquearNumeros = function() {
	    return this.keypress(function(event){
	    		if ((event.which<48)||(event.which>57))
	    			return true;
	    		else
	    			return false;
	    });    
	};
	
	//******************************************************************************************
	//* 4) Convierte el contenido de una caja de texto todo a mayusculas
	//******************************************************************************************
	$.fn.convertirMayuscula = function(){
		return this.blur(function(event){
			$(this).val($(this).val().toUpperCase());
		});
	};
	
	//******************************************************************************************
	//* 5) Convierte el contenido de una caja de texto todo a minusculas
	//******************************************************************************************
	$.fn.convertirMinuscula = function(){
		return this.blur(function(event){
			$(this).val($(this).val().toLowerCase());
		});
	};
	
	
	

	//******************************************************************************************
	//* 6) verificar que el contenido no sean solo espacios
	//******************************************************************************************
	$.fn.verificaEspacios = function(){
		return this.blur(function(event){
			var ele = $(this).val();
			//alert ("aqui"+ele);
			var tama=ele.length;
			if( (vacio(ele) == false ) && (tama>0)) {
				alert("Introduzca un cadena de texto.")
				$(this).val("");
			}
		});
	};
	//******************************************************************************************
	//* 7) verificar que el contenido no sean solo espacios
	//******************************************************************************************
	$.fn.minlength = function(expresion){
		return this.blur(function(event){
			var ele = $(this).val();
			var tama=ele.length;
			if((tama < expresion)) {
				alert("Debe ser m\u00ednimo de "+expresion+" digitos")
				$(this).val("");
			}
		});
	
	
	
	};
	
	//ConfiguraciÃ³n de DatePickers de JqueryUI en el idioma EspaÃ±ol
	//***************************************************************
	$.datepicker.regional['es'] = { closeText: 'Cerrar',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
            dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
            weekHeader: 'Sem',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
	
	
	/**********************************************************************************************************************
	 * MÃ©todos de Validacion agregados a JQuery Validator.
	 * @author Daniel M. DÃ­az 
	 * @since  21/09/2015
	 *********************************************************************************************************************/
	
	//Agrega mÃ©todo de validacion de controles Select en jQuery.Validate
	//******************************************************************	
	$.validator.addMethod("comboBox",function (value, element, param){		
		var result = false;
		//comentariada hhchavezv 20151030 $("select:disabled").attr("disabled",false); //Habilitar todos los controles select que estÃ©n deshabilitados.
		var string = (param).toString();
		if($(element).val()==string)		    
			result = false;
		else
		    result = true;		
		return result;
	},"");
	
	
	/********************************************************************************************************************
	 * Funciones JQUERY	Adicionales.
	 * @author Daniel M. DÃ­az
	 * @since  21/09/2015 
	 ********************************************************************************************************************/
		
	//FunciÃ³n JQUERY para generar mensajes "hint" junto a cajas de texto 
	//*******************************************************************
	$.fn.hint = function(titulo, mensaje){
		var id = $(this).attr("id");
		var image = base_url + "/images/help.png";
		$(this).parent().append('&nbsp;<img id="hint'+id+'" src="'+image+'" border="0"/>&nbsp;&nbsp;');
		
		return $("#hint"+id).qtip({
			content: {
		        title: titulo,
				text: mensaje		        
		    },
		    position: {
		        my: 'top left'
		    },
		    style: {
		    	classes: 'qtip-bootstrap qtipDANE'
		    }
		});		
	};	
	
	//FunciÃ³m JQUERY para generar menajes "hint". Esta funciÃ³n despliega el hint "ABIERTO" por defecto.
	//*************************************************************************************************
	$.fn.hintOpen = function(titulo, mensaje){
		var id = $(this).attr("id");
		var tooltip = $("#"+id).qtip({
			prerender: true,
			content: {
		        title: titulo,
				text: mensaje		        
		    },
		    position: {		        
		    	container: $("#"+id)		    			    	
		    },		    		       
		    style: {
		    	classes: 'qtip-bootstrap qtipDANE'
		    },
		    show: {
		    	event: 'load',
		    	ready: true
		    },
		    hide: function(event, api) { $(this).show(); }		    
		});
		var api = tooltip.qtip('api');
		api.toggle(true); // Pass event as second parameter!
		api.show(true);
		return tooltip;
	}
	
	//Funcion JQUERY para ejecutar una funcion ajax para actualizar comboBox dependientes
	//*****************************************************************************************
	$.fn.cargarCombo = function(element,url){		
		return this.change(function(event){
			$("#"+element).attr("disabled",true);
			$("#"+element+" option[value='-']").attr("selected","selected");
			if ($(this).val()!='-'){
				$.ajax({
					type: "POST",
					url: url,
					data: "id=" + $(this).val(),
				    dataType: "html",
					cache: false,
					success: function(html){
						var target = "#" + element;
						$(target).html("");
						$(html).appendTo(target);	
						$("#"+element).attr("disabled",false);
						$("#"+element+" option[value='-']").attr("selected","selected");
					},
					error: function(result) {
						$("#"+element).attr("disabled",true);
						$("#"+element+" option[value='-']").attr("selected","selected");
					}
				});
			}
		});
	};
	
	//Funcion JQUERY para establecer el valor mÃ¡ximo de caracteres que pueden ir en un textbox.
	//*****************************************************************************************
	$.fn.largo = function(expresion) {
		return this.keypress(function(event){
			if ((event.which == 8)||(event.which == 0)) 
				return true;
			else if ($(this).val().length < expresion)
					return true;
				 else
					return false;
		});     
	};
	
	//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite nÃºmeros.
	//**************************************************************************************************
	$.fn.bloquearTexto = function() {
		return this.keypress(function(event){    		
    		if ((event.which == 8)||(event.which == 0)||(event.which == 45)) return true;
    		if ((event.which >=48)&&(event.which <=57)) 
    			return true;
    		else
    			return false;    		
		});     
	};
	
	
	//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite nÃºmeros y sin guiones.
	//**************************************************************************************************
	$.fn.bloquearTextoSinGuiones = function() {
		return this.keypress(function(event){    		
    		if ((event.which == 8)||(event.which == 0)) return true;
    		if ((event.which >=48)&&(event.which <=57)) 
    			return true;
    		else
    			return false;    		
		});     
	};
	
	//Funcion JQUERY para bloquear el ingreso de caracteres de texto en un texbox. Solo permite nÃºmeros y sin guiones.
	//**************************************************************************************************
	$.fn.bloquearTextoespeciales = function() {
		return this.keypress(function(event){   
			//alert ("2="+event.which);
    		if ((event.which != 64) && (event.which != 241) && (event.which != 45)) 
    			return true;
    		else
    			return false;    		
		});     
	};
	
	
	//Funcion JQUERY para bloquear el ingreso de caracteres numericos en un textbox. Solo permite letras.
	//****************************************************************************************************
	$.fn.bloquearNumeros = function() {
	    return this.keypress(function(event){
	    		if (((event.which<48)||(event.which>57)) && (event.which!=64))
	    			return true;
	    		else
	    			return false;
	    });    
	};
	
	//Funcion JQUERY para convertir el contenido de un textbox todo a mayusculas.
	//****************************************************************************
	$.fn.Mayusculas = function(){
		return this.blur(function(event){
			$(this).val($(this).val().toUpperCase());
		});
	};
	
	//Funcion JQUERY para convertir el contenido de un textbox todo a minusculas.
	//****************************************************************************
	$.fn.Minusculas = function(){
		return this.blur(function(event){
			$(this).val($(this).val().toLowerCase());
		});
	};
	
	//****************************************************************************************************************
	//** Compara y valida que el valor de una caja de texto contra una expresion completa escrita en jQuery
	//****************************************************************************************************************
	$.validator.addMethod("expresion",function(value, element, param){
		var comp = convertirExpresion(param);
		if (comp){
			return false;
		}	
		else{
			return true;
		}
	},"");
	
	
	$.validator.addMethod("expresion2",function(value, element, param){
		var comp = convertirExpresion(param);
		if (comp){
			return false;
		}	
		else{
			return true;
		}
	},"");
	
	//2) Evalua una cadena de texto recibida como parametro y retorna un valor de verdadero o falso 
	function convertirExpresion(cadena){
		var result = false;
		if ((typeof cadena)=='string')		
			result = (eval(cadena))?true:false;
		return result;
	}
	
	
	
	
	
/**
 * FunciÃ³n Especial
 * Esta funciÃ³n redirige al usuario a un mÃ³dulo para descarga de navegadores cuando se detecta que utiliza Internet Explorer
 * @author dmdiazf
 * @since  01/10/25
 */	
	function redirectBrowser(){
		var BrowserDetect = {
				init: function () {
					this.browser = this.searchString(this.dataBrowser) || "Other";
		            this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
		        },
		        searchString: function (data) {
		            for (var i = 0; i < data.length; i++) {
		                var dataString = data[i].string;
		                this.versionSearchString = data[i].subString;
		                if (dataString.indexOf(data[i].subString) !== -1) {
		                    return data[i].identity;
		                }
		            }
		        },
		        searchVersion: function (dataString) {
		        	var index = dataString.indexOf(this.versionSearchString);
		            if (index === -1) {
		                return;
		            }
		            var rv = dataString.indexOf("rv:");
		            if (this.versionSearchString === "Trident" && rv !== -1) {
		                return parseFloat(dataString.substring(rv + 3));
		            } 
		            else {
		                return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
		            }
		        },
		        dataBrowser: [
		            {string: navigator.userAgent, subString: "Edge", identity: "MS Edge"},
		            {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
		            {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
		            {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
		            {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
		            {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
		            {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
		        ]
		    };
		    BrowserDetect.init();
		    if ((BrowserDetect.browser == 'Explorer') && (BrowserDetect.version <= 9)){
		    	var url = base_url + "ieredirect";
				$(location).attr("href",url);
			}
	}	

	
	function vacio(q) 
	{
		//alert ("esta"+q);
		for ( i = 0; i < q.length; i++ ) 
		{
			if ( q.charAt(i) != " " ) 
			{
					return true
			}
		}
		return false
	}
	
	/**
	* Funcion para validar estructura correcta de email 
	* Acepta un rango de caracteres de "A-Z" en mayúsculas y minúsculas, rango de digitos del "0-9, y caracteres permitidos en las direcciones de correo ( '_', '-', '.', '~' )
	* Todo esto en un mínimo de 2 y no especifico el máximo "{2,}". Seguido por un "@", y seguido por el mismo patron de concordancia, para el nombre del dominio.
	* Todo esto seguido por un "."(punto). Terminado por rango de caracteres de "A-Z" en mayúsculas y minúsculas, mínimo de 2 y máximo 3 "{2,3}"
	* @author hhchavezv
	* @since  2016ene27
	*/	
		
	$.validator.addMethod("emailValido",function (value, element){		
		if ( /^[a-zA-Z0-9_\-\.~]{2,}@[a-zA-Z0-9_\-\.~]{2,}\.[a-zA-Z]{2,3}$/.test(value)  )  {
				return true;
			}
			else{
				return false;		
			}
		
		
	
	},"");