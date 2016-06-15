/**
 * Funciones JavaScript para el control de tiempo del diligenciamiento del formulario
 * @author Daniel M. Díaz
 * @since  22/01/2016
 **/

var timer = new Date();
var horaIni = new Date(timer.getFullYear(), timer.getMonth(), timer.getDate(),  timer.getHours(), timer.getMinutes(), timer.getSeconds());
var horaFin = null;

$(function(){
	window.setInterval(setHoraFin, 1000); //cada segundo
	/**
	window.setInterval(setHoraFin, 10000); //cada 10 segundos
	window.setInterval(setHoraFin, 20000); //cada 20 segundos
	window.setInterval(setHoraFin, 30000); //cada 30 segundos
	window.setInterval(setHoraFin, 40000); //cada 40 segundos
	window.setInterval(setHoraFin, 50000); //cada 50 segundos
	window.setInterval(setHoraFin, 60000); //cada 50 segundos
	**/
	function setHoraFin() { 
		//Calcular la diferencia entre horas
		var timer = new Date();
		horaFin = new Date(timer.getFullYear(), timer.getMonth(), timer.getDate(),  timer.getHours(), timer.getMinutes(), timer.getSeconds());
	}
});

function marcarCrono(index){
	var diff = horaFin - horaIni;
	var msec = diff;
	var hh = Math.floor(msec / 1000 / 60 / 60);
	msec -= hh * 1000 * 60 * 60;
	var mm = Math.floor(msec / 1000 / 60);
	msec -= mm * 1000 * 60;
	var ss = Math.floor(msec / 1000);
	msec -= ss * 1000;
	var duracion = hh + ":" + mm + ":" + ss;	
	
	//Lanzar AJAX para guardar el tiempo empleado en la duracion de la sesion
	$.ajax({
		type: "POST",
		url: base_url + "inicio/inicio/actualizarCrono",
		data: {'modulo': index,
			   'duracion': duracion
		},					
		dataType: "html",
		contentType: "application/x-www-form-urlencoded;charset=UTF-8",
		cache: false,
		success: function(data){			
			console.log(data);
		},
		error: function(data){			
			console.log(data);			
		}		
	});
	
}