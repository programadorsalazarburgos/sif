var url_service = '../../Controlador/Pedagogico/C_Evaluacion_Artista_Formador_Y_Organizacion.php';
var slider_artista_formador_1,slider_artista_formador_2,slider_artista_formador_3,slider_artista_formador_4,slider_artista_formador_5;
var slider_organizacion_1,slider_organizacion_2,slider_organizacion_3,slider_organizacion_4,slider_organizacion_5,slider_organizacion_6,slider_organizacion_7;
$(function(){
	$("#SL_artista_formador").html(parent.getOptionsArtistasFormadores(true));
	$("#SL_area_artistica").html(parent.getOptionsAreasArtisticas());
	$("#SL_organizacion_ev").html(parent.getOptionsOrganizaciones());
	slider_artista_formador_1 = $("#slider_artista_formador_1").bootstrapSlider();
	slider_artista_formador_2 = $("#slider_artista_formador_2").bootstrapSlider();
	slider_artista_formador_3 = $("#slider_artista_formador_3").bootstrapSlider();
	slider_artista_formador_4 = $("#slider_artista_formador_4").bootstrapSlider();
	slider_artista_formador_5 = $("#slider_artista_formador_5").bootstrapSlider();

	slider_organizacion_1 = $("#slider_organizacion_1").bootstrapSlider();
	slider_organizacion_2 = $("#slider_organizacion_2").bootstrapSlider();
	slider_organizacion_3 = $("#slider_organizacion_3").bootstrapSlider();
	slider_organizacion_4 = $("#slider_organizacion_4").bootstrapSlider();
	slider_organizacion_5 = $("#slider_organizacion_5").bootstrapSlider();
	slider_organizacion_6 = $("#slider_organizacion_6").bootstrapSlider();
	slider_organizacion_7 = $("#slider_organizacion_7").bootstrapSlider();

	slider_artista_formador_1.bootstrapSlider('setValue',0);
	slider_artista_formador_2.bootstrapSlider('setValue',0);
	slider_artista_formador_3.bootstrapSlider('setValue',0);
	slider_artista_formador_4.bootstrapSlider('setValue',0);
	slider_artista_formador_5.bootstrapSlider('setValue',0);

	slider_organizacion_1.bootstrapSlider('setValue',0);
	slider_organizacion_2.bootstrapSlider('setValue',0);
	slider_organizacion_3.bootstrapSlider('setValue',0);
	slider_organizacion_4.bootstrapSlider('setValue',0);
	slider_organizacion_5.bootstrapSlider('setValue',0);
	slider_organizacion_6.bootstrapSlider('setValue',0);
	slider_organizacion_7.bootstrapSlider('setValue',0);

	$("input[id^='slider_artista_formador_']").change(function(){
		setProgressBarTotalPuntosArtistaFormador();
	});

	$("input[id^='slider_organizacion_']").change(function(){
		setProgressBarTotalPuntosOrganizacion();
	});

	$("#form_evaluacion_artista_formador").submit(function(event){
		event.preventDefault();
		var datos = ($(this).serialize());
		if(validarPuntuacionSlidersArtistasFormadores()){
			$.ajax({
				url:url_service,
				type:'POST',
				data: datos,
				success: function(data){
					parent.mostrarAlerta("success","Evaluación guardada","Se ha guardado exitosamente la evaluación No. " + data);
					$("#SL_artista_formador").selectpicker('deselectAll')
					$("#SL_area_artistica").selectpicker('deselectAll')
					$("#justificacion_1").val('');
					$("#justificacion_2").val('');
					$("#justificacion_3").val('');
					$("#justificacion_4").val('');
					$("#justificacion_5").val('');
					slider_artista_formador_1.bootstrapSlider('setValue',0);
					slider_artista_formador_2.bootstrapSlider('setValue',0);
					slider_artista_formador_3.bootstrapSlider('setValue',0);
					slider_artista_formador_4.bootstrapSlider('setValue',0);
					slider_artista_formador_5.bootstrapSlider('setValue',0);
					$("#modal-evaluacion-artista-formador").modal('toggle');
				}
			});
		}else{
			parent.mostrarAlerta("warning","Advertencia","Debe asignar un puntaje cuantitativo para cada ítem usando los seleecionadores rojos.");
		}
	});

	$("#form_evaluacion_organizacion").submit(function(){
		event.preventDefault();
		var datos = $(this).serialize();
		if(validarPuntuacionSlidersOrganizaciones()){
			$.ajax({
				url: url_service,
				type: 'POST',
				data: datos,
				success: function(data){
					parent.mostrarAlerta("success","Evaluación guardada","Se ha guardado exitosamente la evaluación No. " + data);
					$("#justificacion_org_1").val('');
					$("#justificacion_org_2").val('');
					$("#justificacion_org_3").val('');
					$("#justificacion_org_4").val('');
					$("#justificacion_org_5").val('');
					$("#justificacion_org_6").val('');
					$("#justificacion_org_7").val('');
					slider_organizacion_1.bootstrapSlider('setValue',0);
					slider_organizacion_2.bootstrapSlider('setValue',0);
					slider_organizacion_3.bootstrapSlider('setValue',0);
					slider_organizacion_4.bootstrapSlider('setValue',0);
					slider_organizacion_5.bootstrapSlider('setValue',0);
					slider_organizacion_6.bootstrapSlider('setValue',0);
					slider_organizacion_7.bootstrapSlider('setValue',0);
					$("#modal-evaluacion-organizacion").modal('toggle');
				}
			});
		}else{
			parent.mostrarAlerta("warning","Advertencia","Debe asignar un puntaje cuantitativo para cada ítem usando los seleecionadores rojos.");
		}
	});
});

function setProgressBarTotalPuntosArtistaFormador(){
	var total_puntos = 0;
	total_puntos += slider_artista_formador_1.bootstrapSlider('getValue');
	total_puntos += slider_artista_formador_2.bootstrapSlider('getValue');
	total_puntos += slider_artista_formador_3.bootstrapSlider('getValue');
	total_puntos += slider_artista_formador_4.bootstrapSlider('getValue');
	total_puntos += slider_artista_formador_5.bootstrapSlider('getValue');
	$("#progresbar_total_puntaje_artista_formador").css("width",(total_puntos + "%"));
	$("#progresbar_total_puntaje_artista_formador span").text("Puntaje: " + total_puntos);
}

function setProgressBarTotalPuntosOrganizacion(){
	var total_puntos = 0;
	total_puntos += slider_organizacion_1.bootstrapSlider('getValue');
	total_puntos += slider_organizacion_2.bootstrapSlider('getValue');
	total_puntos += slider_organizacion_3.bootstrapSlider('getValue');
	total_puntos += slider_organizacion_4.bootstrapSlider('getValue');
	total_puntos += slider_organizacion_5.bootstrapSlider('getValue');
	total_puntos += slider_organizacion_6.bootstrapSlider('getValue');
	total_puntos += slider_organizacion_7.bootstrapSlider('getValue');
	$("#progresbar_total_puntaje_organizacion").css("width",(total_puntos + "%"));
	$("#progresbar_total_puntaje_organizacion span").text("Puntaje: " + total_puntos);
}

function validarPuntuacionSlidersArtistasFormadores(){
	if($("#slider_artista_formador_1").val() == 0
		|| $("#slider_artista_formador_2").val() == 0
		|| $("#slider_artista_formador_3").val() == 0
		|| $("#slider_artista_formador_4").val() == 0
		|| $("#slider_artista_formador_5").val() == 0){
		return false;
	}else{
		return true;
	}
}

function validarPuntuacionSlidersOrganizaciones(){
	if($("#slider_organizacion_1").val() == 0
		|| $("#slider_organizacion_2").val() == 0
		|| $("#slider_organizacion_3").val() == 0
		|| $("#slider_organizacion_4").val() == 0
		|| $("#slider_organizacion_5").val() == 0
		|| $("#slider_organizacion_6").val() == 0
		|| $("#slider_organizacion_7").val() == 0){
		return false;
	}else{
		return true;
	}
}
