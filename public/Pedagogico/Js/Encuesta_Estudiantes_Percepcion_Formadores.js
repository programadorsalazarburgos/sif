var url_service = '../../Controlador/Pedagogico/C_Encuesta_Estudiantes_Percepcion_Formadores.php';
$(function(){
	$("#SL_area_artistica").html(getOptionsAreasArtisticas()).change(cargarArtistasDeAreaArtistica);
	cargarArtistasDeAreaArtistica();
	$("input[id^='slider_']").slider({
		min: 1,
		max: 5,
		value: 3,
		formatter: function(value) {
			return getTextoRespuesta(value);
		}
	});
	$("input[id^='slider_']").change(function(){
		var id = $(this).attr("id");
		id = id.slice(7,8);
		var valor = $(this).val();
		$("#emoji_respuesta_" + id + " center").html("<img alt='carita de respuesta' src='src_emoji/" + valor + ".png' height='40'>" + getTextoRespuesta(valor));
	});
	$("#Form_encuesta_estudiantes_perecepcion_formadores").submit(function(event){
		event.preventDefault();
		var datos = ($(this).serialize());
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			beforeSend: function(){

			},
			async:false
		}).done(function(data){
			console.log(data);
			$("#LB_nombre_estudiante").html($("#TB_nombre_estudiante").val());
			$("#modal_encuesta_finalizada").modal("show");
		}).fail(function(jqXHR,textStatus){
			correo_soporte = "<a href:'mailto:sif@idartes.gov.co'>sif@idartes.gov.co</a>";
			alertify.alert('Error','No se han podido guardar los datos, por favor intente de nuevo y si el problema persiste pongase en contacto con '+ correo_soporte +'. Fail: ' + textStatus);
		});
	});
	$("#BT_realizar_de_nuevo").click(function(){
		$("#modal_encuesta_finalizada").modal("hide");
		$("#TB_observaciones").val("");
		$("input[id^='slider_']").val(3).slider('setValue', 3).trigger("change");
		$("#TB_nombre_estudiante").val("").focus();
	});
});

function getTextoRespuesta(valor){
	var r = "";
	valor = valor.toString();
	switch(valor){
		case '1':
			r = 'Nunca';
			break;
		case '2':
			r = 'Pocas veces';
			break;
		case '3':
			r = 'Algunas veces';
			break;
		case '4':
			r = 'La mayoría de veces';
			break;
		case '5':
			r = 'Siempre';
			break;
		default:
			r = 'No definido: ' + valor;
			break;
	}
	return r;
}

function cargarArtistasDeAreaArtistica(){
	var mostrar = "";
	var datos = {
		'funcion' : 'getOptionsArtistasFormadoresDeAreaArtistica',
		p1: $("#SL_area_artistica").val()
	};
	$.ajax({
		url : url_service_options,
		data :datos,
		type :'POST',
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	$("#SL_artista_formador").html(mostrar).selectpicker('refresh');
}
