	$(document).on("ready", inicio);

	function inicio() 
	{
		// Notificaciones:		
		notificacion();
		function notificacion (){
			var hoy = moment().format('YYYY-MM-DD');
			$.ajax({
				url: baseurl+'Eventos/Ajax/Notificaciones',
				type: 'POST',
				dataType: 'json',
				data: {fecha: hoy},
				success: function(data){
					var num = data.length;
					if (num == 0) {
						$('#NumNotificaciones').html("");
						$('#HeadNotificaciones').html('<h3>No tienes eventos hoy</h3>');       
					}
					else if (num == 1) {
						$('#NumNotificaciones').html(num);
						$('#HeadNotificaciones').html('<h3>Tienes '+num+' evento hoy</h3>'); 
					}
					else{
						$('#NumNotificaciones').html(num);
						$('#HeadNotificaciones').html('<h3>Tienes '+num+' eventos hoy</h3>'); 
					}

					if (num > 0){
						$('#MenuNotificaciones').html("");
						for (var item in data) {
							$('#MenuNotificaciones').append('<li><a href="'+baseurl+'Eventos/Ver/'+data[item].id+'"><i class="fa fa-calendar text-aqua"></i>'+data[item].title+'</a></li>');
						}					
					}
				}
			})
		}
		



 //Date picker
 $.fn.datepicker.dates['es'] = {
 	days: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
 	daysShort: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
 	daysMin: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
 	months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
 	monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
 	format: 'yyyy-mm-dd'
 };



 $('#datepicker').datepicker({
 	language: 'es',
 	format: 'yyyy-mm-dd',
 	autoclose: true
 });

 $('#fechaModal').datepicker({
 	language: 'es',
 	format: 'yyyy-mm-dd',
 	autoclose: true
 });
 $("#select2-apoderados-container").on("DOMSubtreeModified", casos);
 $("#select2-casos-container").on("DOMSubtreeModified", casos);
 $('#tipoPersona').on("change", casos);
 $("#select2-comparendos-container").on("DOMSubtreeModified", comparendos);


 $("#crearPersona").on("click", validarDatos);

 function validarDatos() 
 {
 	var selectCaso = $('#select2-casos-container');
 	var selectComparendos = $('#select2-comparendos-container');
 	if (selectCaso.text() === "SELECCIONAR" && selectComparendos.text() === "SELECCIONAR") 
 	{
 		$('#personasAdd1').attr("class", "form-group has-error");
 		$('#personasAdd2').attr("class", "form-group has-error");
 		$('#error1').text("Debe de seleccionar un caso o un comparendo");
 		$('#error2').text("Debe de seleccionar un caso o un comparendo");
 		return false;
 	}
 }

 function casos() 
 {
 	var apoderado = $("#select2-apoderados-container").text();
 	var casos = $("#select2-casos-container").text();
 	var tipo = $('#tipoPersona').val();

 	if (apoderado != "SELECCIONAR") 
 	{
 		$('#comparendos').prop('disabled', true);
 		$('#comparendosHidden').prop('disabled', false);
 		$('#apoderadosHidden').prop('disabled', true);				
 	}

 	if (casos != "SELECCIONAR") 
 	{
 		$('#comparendos').prop('disabled', true);
 		$('#comparendosHidden').prop('disabled', false);
 		$('#casosHidden').prop('disabled', true);				
 	}

 	if (tipo != "NULL") 
 	{
 		$('#comparendos').prop('disabled', true);
 		$('#comparendosHidden').prop('disabled', false);
 		$('#tipoPersonaHidden').prop('disabled', true);				
 	}

 	if (tipo == 'NULL' && casos == "SELECCIONAR" && apoderado == "SELECCIONAR")
 	{
 		$('#comparendos').prop('disabled', false);
 		$('#comparendosHidden').prop('disabled', true);
 		$('#tipoPersonaHidden').prop('disabled', false);
 		$('#casosHidden').prop('disabled', false);	
 		$('#apoderadosHidden').prop('disabled', false);
 	}
 }
 function comparendos() 
 {
 	var comparendos = $("#select2-comparendos-container").text();

 	if (comparendos != "SELECCIONAR") 
 	{
 		$('#tipoPersona').prop('disabled', true);
 		$('#tipoPersonaHidden').prop('disabled', false);

 		$('#casos').prop('disabled', true);
 		$('#casosHidden').prop('disabled', false);

 		$('#apoderados').prop('disabled', true);
 		$('#apoderadosHidden').prop('disabled', false);

 		$("#comparendosHidden").prop('disabled', true);
 	}
 	else
 	{
 		$('#tipoPersona').prop('disabled', false);
 		$('#tipoPersonaHidden').prop('disabled', true);

 		$('#casos').prop('disabled', false);
 		$('#casosHidden').prop('disabled', true);

 		$('#apoderados').prop('disabled', false);
 		$('#apoderadosHidden').prop('disabled', true);

 		$("#comparendosHidden").prop('disabled', false);
 	}
 }

 var NuevoEvento;
 var currColor = "#3c8dbc";
 var validacion;

// Fullcalendar
$('#calendar').fullCalendar({
	header:{
		left: 'prev,next',
		center:'title',
		right: 'prevYear,nextYear'
	},

	timeFormat: 'h:mm A',

	dayClick: function(data, event, view){

		// Head
		$("#tituloEvento").html('Crear Evento');
		$('#tituloEvento').css({"color": 'rgb(250,244,227)'});
		$('#closeBotton').css({"color": 'rgb(250,244,227)'});
		$('#headerModal').css({"background-color": "#3c8dbc", "border-color": '#3c8dbc'});
		
		// botones:
		$('#guardarModal').css("display","");
		$('#editarModal').css("display","none");
		$('#eliminarModal').css("display","none");

		// Formulario:
		$("#fechaModal").val(data.format());
		$('#fechaModal_old').val("");
		$('#horaModal_old').val("");
		$('#idEvento').val("null");
		$('#tituloModal').val("");
		$("#descripcionModal").val("");
		$('#horaModal').val("");


		// casos y comparendos
		$("#ComparendoModal").html("");
		$("#ComparendoModal").next().css("display","none"); 
		$("#ComparendosModal").next().css("display","");

		$("#CasoModal").html("");
		$("#CasoModal").next().css("display","none"); 
		$("#CasosModal").next().css("display","");

		$("#CasosModal").val("NULL");
		$('#CasosModal').change();
		$("#CasosDiv").css("display","");	

		$("#ComparendosModal").val("NULL");
		$('#ComparendosModal').change();
		$("#ComparendosDiv").css("display","");	

		// Color por defecto:
		currColor = "#3c8dbc";

		// Restaurar 
		restaurar ();

		// Abrir modal
		if (data.format() >= moment().format('YYYY-MM-DD')) {
			$("#modalForm").modal();
		}else{
			$.alert({
				columnClass: 'medium',
				title: '<h4><b>Error!</b></h4>',
				content: '<h4>No puedes crear un evento antes de la fecha actual.</h4>',
				type: 'red',
				icon: 'fa fa-ban',
				buttons: {
					cancelar:{
						text: 'OK',
						btnClass: 'btn-red',
						close: function(){}
					}            
				}
			});
		}
		
	},

	eventClick: function(data, event, view){

		FechaHora = data.start._i.split(" ");
		$('#fechaModal').val(FechaHora[0]);
		$('#horaModal').val(moment(FechaHora[1], 'HH:mm:ss').format('hh:mmA'));

		var hoyHora1 = moment().format('YYYY-MM-DD HH:mm:ss');
		var fechaHora1 = FechaHora[0]+' '+FechaHora[1];

		// head
		$("#tituloEvento").html(data.title);
		$('#tituloEvento').css({"color": 'rgb(250,244,227)'});
		$('#closeBotton').css({"color": 'rgb(250,244,227)'});
		$('#headerModal').css({"background-color": data.color, "border-color": data.color});

		// botones
		if (fechaHora1 < hoyHora1) {

			$('#guardarModal').css("display","none");
			$('#editarModal').css("display","none");
			$('#eliminarModal').css("display","none");
		}
		else{
			$('#guardarModal').css("display","none");
			$('#editarModal').css("display","");
			$('#eliminarModal').css("display","");	
		}

		// Formulario:
		$('#idEvento').val(data.id);
		$('#tituloModal').val(data.title);
		$("#descripcionModal").val(data.descripcion);

		if (data.casos_id == null && data.comparendos_id == null) {
			$("#CasosDiv").css("display","none");
			$("#ComparendosDiv").css("display","none");
		}
		else if (data.casos_id == null) {
			$("#CasosDiv").css("display","none");
			$("#ComparendosDiv").css("display","");

			$("#ComparendoModal").html("");
			$("#ComparendosDiv").css("display","");	
			$("#ComparendoModal").next().css("display",""); 
			$("#ComparendoModal").append('<a href="'+baseurl+'Comparendos/Ver/'+data.comparendos_id+'">'+data.comparendos_id+'</a>'); 
			$("#ComparendosModal").next().css("display","none");
		}
		else{
			$("#CasosDiv").css("display","");
			$("#ComparendosDiv").css("display","none");

			$("#CasoModal").html("");
			$("#CasosDiv").css("display","");	
			$("#CasoModal").next().css("display",""); 
			$("#CasoModal").append('<a href="'+baseurl+'Casos/Ver/'+data.casos_id+'">'+data.casos_id+'</a>'); 
			$("#CasosModal").next().css("display","none");
		}


		// Color actual.
		currColor = data.color

		// Restaurar 
		restaurar ();

		// Abrir modal
		$("#modalForm").modal();

	}, 
	events: {
		url: baseurl+'Eventos/Ajax/Consultar',
		allDay : false
	}
});


		// Captura de color		
		$('#tituloEvento').css({"color": 'rgb(250,244,227)'});
		$('#closeBotton').css({"color": 'rgb(250,244,227)'});
		$('#headerModal').css({"background-color": currColor, "border-color": currColor});		
		$("#color-chooser > li > a").click(function () {
			currColor = $(this).css("color");
			$('#tituloEvento').css({"color": 'rgb(250,244,227)'});
			$('.close').css({"color": 'rgb(250,244,227)'});
			$('#headerModal').css({"background-color": currColor, "border-color": currColor});
			
			return currColor = rgb2hex(currColor);

			// Convercion de rgb a Hex
			function rgb2hex(rgb) {
				rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
				function hex(x) {
					return ("0" + parseInt(x).toString(16)).slice(-2);
				}
				return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
			}
		});

		// Captura de eventos de botone modal
		$('#guardarModal').click(function(){
			validacion = validarModal()
			if (validacion) {
				RecolectarDataGUI();	
				EnviarData('agregar', NuevoEvento);
			}			
		});

		$('#editarModal').click(function(){	
			validacion = validarModal()
			if (validacion) {
				RecolectarDataGUI();	
				EnviarData('editar', NuevoEvento);
			}				
		});

		$('#eliminarModal').click(function(){	
			RecolectarDataGUI();	
			EnviarData('eliminar', NuevoEvento);
		});

		// Captura de datos del modal.
		function RecolectarDataGUI(){
			NuevoEvento = {
				id: $('#idEvento').val(),
				title: $('#tituloModal').val(),
				start : $('#fechaModal').val()+" "+moment($('#horaModal').val(), 'hh:mmA').format('HH:mm:ss'),
				color : currColor,
				descripcion: $('#descripcionModal').val(),
				casos_id: $('#CasosModal').val(),
				comparendos_id: $('#ComparendosModal').val()				
			};
			return NuevoEvento;
		}

		// Acciondes de formulario por botones:
		function EnviarData(accion, objEvento){
			$.ajax({
				type: 'POST',
				url: baseurl+'Eventos/Acciones/'+accion,
				data: objEvento,
				success: function(msg){
					var obj = JSON.parse(msg);
					if (obj.type == 'Success') {
						$('#calendar').fullCalendar('refetchEvents');						
						$("#modalForm").modal('toggle');
						notificacion();
					}	
					else{
						$('#calendar').fullCalendar('refetchEvents');						
						$("#modalForm").modal('toggle');
						notificacion();
						$.alert({
							columnClass: 'medium',
							title: '<h4><b>Error!</b></h4>',
							content: '<h4>'+obj.msg+'</h4>',
							type: 'red',
							icon: 'fa fa-ban',
							buttons: {
								cancelar:{
									text: 'OK',
									btnClass: 'btn-red',
									close: function(){}
								}            
							}
						});
					}				
				}
			});
		}


		// Validar campos de modal
		function validarModal (){
			var hoyHora = moment().format('YYYY-MM-DD HH:mm:ss');
			var titulo = $('#tituloModal').val();
			var fecha = $('#fechaModal').val();
			var hora = $('#horaModal').val();
			var result = true;

			if (titulo == "") 
			{
				$('#modalTitulo').attr("class", "form-group has-error");
				$('#tituloErrorModal').text("Debes de ingresar un título.");
				result = false;
			}	
			else{
				$('#modalTitulo').attr("class", false);
				$('#modalTitulo').attr("class", "form-group");
				$('#tituloErrorModal').html("");
			}

			if(hora == "")
			{
				$('#modalHora').attr("class", "form-group has-error");
				$('#horaErrorModal').text("Debes de ingresar una hora.");
				result = false;
			}
			else {
				$('#modalHora').attr("class", false);
				$('#modalHora').attr("class", "form-group");
				$('#horaErrorModal').html("");
				hora = moment(hora, 'hh:mmA').format('HH:mm:ss');
				var fechaHora = fecha+" "+hora;
				if (fechaHora < hoyHora ) {
					$('#modalHora').attr("class", "form-group has-error");
					$('#horaErrorModal').text("Debes de ingresar una hora mayor a la actual.");
					result = false;
				}	
			}
			return result;
		}

	// Restaurar los valores por defecto de los campos
	function restaurar (){
		$('#modalTitulo').attr("class", "form-group");
		$('#tituloErrorModal').text("");
		$('#modalHora').attr("class", "form-group");
		$('#horaErrorModal').text("");
	}

// Reloj
	$("#horaModal").timepicki();



// Desavilitador de select html casos y comparendos eventos:
$("#select2-CasosModal-container").on("DOMSubtreeModified", casosModal);
$("#select2-ComparendosModal-container").on("DOMSubtreeModified", comparendosModal);


function casosModal() 
{
	var casos = $("#select2-CasosModal-container").text();

	if (casos != "SELECCIONAR (Ninguno)") 
	{
		$('#ComparendosModal').prop('disabled', true);		
	}
	else{
		$('#ComparendosModal').prop('disabled', false);
	}
}
function comparendosModal() 
{
	var comparendos = $("#select2-ComparendosModal-container").text();

	if (comparendos != "SELECCIONAR (Ninguno)") 
	{
		$('#CasosModal').prop('disabled', true);		
	}
	else{
		$('#CasosModal').prop('disabled', false);
	}
}
$("#guardar").prop('disabled', true);

// Desavilitador de select html casos y comparendos Audiencias:
$("#select2-eventoAu-container").on("DOMSubtreeModified", eventoAu);

function eventoAu() 
{
	var evento = $("#select2-eventoAu-container").text();
	var tipo = evento.split(" ", 1);
	if (tipo[0] == "Caso:") 
	{
		$('#tipoPersona_d').html('Denunciante:');
		$('#tipoPersona_c').html('Contraventor:');	
		$("#guardar").prop('disabled', false);
		$(".radiDes").css("display", '');
		$(".radiDes").prop("checked",false);		
	}
	else{
		$('#tipoPersona_d').html('Policía:');
		$('#tipoPersona_c').html('Infractor:');
		$("#guardar").prop('disabled', false);
		$(".radiDes").css("display", 'none');
		$(".radiDes").prop("checked",false);		
	}
}

$(".radiEsc_c").prop("disabled",true);
$(".radiEsc_d").prop("disabled",true);
$(".camposAd").prop("disabled",true);
$(".camposAc").prop("disabled",true);
$(".camposA").prop("disabled", true);

// Seleccion de asistencia:
$('#formIDAu input').on('change', function() {
	var asistencia_c = $('input[name=asistencia_c]:checked', '#formIDAu').val()
	var asistencia_d =$('input[name=asistencia_d]:checked', '#formIDAu').val()


	if (asistencia_c == 'SI' && asistencia_d == 'SI' ) {

		$(".radiEsc_c").prop("disabled",true);
		$(".radiEsc_c").prop("checked", false);

		$(".radiEsc_d").prop("disabled",true);
		$(".radiEsc_d").prop("checked",false);

		$(".camposAc").prop("disabled",false);
		$(".camposAc").removeProp("checked", true);

		$(".camposAd").prop("disabled",false);		
		$(".camposAd").removeProp("checked", true);

		$(".camposA").prop("disabled",false);

	}
	else{
		$(".camposA").prop("disabled", true);
	}

// contraventor
if (asistencia_c == 'NO') {

	$(".radiEsc_c").prop("disabled",false);
	$(".radiEsc_c").removeProp("checked",true);

	$(".camposAc").prop("disabled",true);
	$(".camposAc").prop("checked", false);
}

if (asistencia_c == 'SI'){
	$(".radiEsc_c").prop("disabled",true);
	$(".radiEsc_c").prop("checked", false);

	$(".camposAc").prop("disabled",false);
	$(".camposAc").removeProp("checked", true);
}


// Denunciante
if (asistencia_d == 'NO') {
	$(".radiEsc_d").prop("disabled",false);
	$(".radiEsc_d").removeProp("checked",true);

	$(".camposAd").prop("disabled",true);
	$(".camposAd").prop("checked", false);
}

if(asistencia_d == 'SI'){

	$(".radiEsc_d").prop("disabled",true);
	$(".radiEsc_d").prop("checked",false);

	$(".camposAd").prop("disabled",false);
	$(".camposAd").removeProp("checked", true);
}

});


// Formateo de fechas para mostrar:
var fechaYhora = $("#fechaYhoraMoment").text();	
var fechaFormat = moment(fechaYhora).locale("es-moment").format('LLLL');
$("#fechaYhoraMoment").html(fechaFormat);

var fechaYhora1 = $(".fechaYhoraMoment1").text();	
var fechaFormat1 = moment(fechaYhora1).locale("es-moment").format('LLLL');
$(".fechaYhoraMoment1").html(fechaFormat1);

var fechaMoment = $("#fechaMoment").text();
var fechaFormatMoment = moment(fechaMoment).locale("es-moment").format('LLL');
$("#fechaMoment").html(fechaFormatMoment);

var fechaMoment2 = $("#fechaMoment2").text();	
var fechaFormatMoment2 = moment(fechaMoment2).locale("es-moment").format('LLL');
$("#fechaMoment2").html(fechaFormatMoment2);

var fechaMoment3 = $("#fechaMoment3").text();	
var fechaFormatMoment3 = moment(fechaMoment3).locale("es-moment").format('LLL');
$("#fechaMoment3").html(fechaFormatMoment3);

var fechaMoment4 = $("#fechaMoment4").text();	
var fechaFormatMoment4 = moment(fechaMoment4).locale("es-moment").format('LLL');
$("#fechaMoment4").html(fechaFormatMoment4);
}

