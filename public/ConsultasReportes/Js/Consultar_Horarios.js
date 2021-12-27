var url_ok_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(function(){
	$("#SL_ARTISTA_FORMADOR").html(parent.getOptionsArtistasFormadores()).selectpicker("refresh");

	$("#SL_CREA").html(parent.getOptionsClanes()).selectpicker("refresh");
	$("#SL_AREA_ARTISTICA").html(parent.getOptionParametroDetalle(6)).selectpicker("refresh");

	$("#BT_CONSULTAR_FILTROS").on("click", function(){
		consultarHorarioCreaAreaEstado();
	});

	$("#BT_CONSULTAR_FORMADOR").on("click", function(){
		consultarHorarioArtistaFormador();
	});

	function generarLapsoHorario(datos){
		var menor = 24;
		var mayor = 0;
		var cantidad_grupos = new Array();
		var mostrar = "";
		for (var i = datos.length - 1; i >= 0; i--) {
			var temp_1 = parseInt(datos[i]['TI_hora_inicio_clase'].substring(0,2));
			var temp_2 = parseInt(datos[i]['TI_hora_fin_clase'].substring(0,2));
			if(temp_1 < menor){
				menor = temp_1;
			}
			if(temp_2 > mayor){
				mayor = temp_2
			}
			if(cantidad_grupos.indexOf(datos[i]['FK_grupo']) == -1){
				cantidad_grupos.push(datos[i]['FK_grupo']);
			}
			datos[i]['index_grupo'] = cantidad_grupos.indexOf(datos[i]['FK_grupo']);
			if(datos[i]['index_grupo'] > 9){
				datos[i]['index_grupo'] = parseInt(String(datos[i]['index_grupo']).substring(1,2));
			}
		}
		for (var i = menor; i <= mayor; i++) {
			mostrar += "<li><span>" + i + ":00</span></li>";
			mostrar += "<li><span>" + i + ":00</span></li>";
		}
		//$("#ul_horas_horario").html(mostrar);
		return datos;
	}

	function agregarDatosSesionClaseAHorario(datos){
		var acronimo_linea_atencion = {"arte_escuela":"AE","emprende_clan":"IC","laboratorio_clan":"CV"};
		var hora_inicio = String(datos['TI_hora_inicio_clase']);
		var hora_fin = datos['TI_hora_fin_clase'];
		var width = datos['width'];
		hora_inicio = hora_inicio.substring(0, 5);
		hora_fin = hora_fin.substring(0, 5);
		var mostrar = '<li class="cd-schedule__event">';
		mostrar += '<a href="#0" data-start="'+hora_inicio+'" data-end="'+hora_fin+'" data-width="'+width+'" data-id_grupo="' + datos['FK_grupo'] + '" data-linea_atencion="' + datos['linea_atencion'] + '"  data-content="informacion_grupo" data-event="event-' + (datos['index_grupo']+1) + '">';
		mostrar += '<em class="cd-schedule__name">  ' + acronimo_linea_atencion[datos['linea_atencion']] + '-' + datos['FK_grupo'] + '</em>';
		mostrar += '</a>';
		mostrar += '</li>';
		$("#ul_horario_dia_" + datos['IN_dia']).append(mostrar);
	};

	function consultarHorarioCreaAreaEstado(){
		$("[id^='dia_']").html("");
		$("[id^='ul_horario_dia_']").html("");
		var id_crea = $("#SL_CREA").val();
		var area_artistica = $("#SL_AREA_ARTISTICA").val();
		var estado = $("#SL_ESTADO").val();
		parent.mostrarCargando();
		$.ajax({
			async: true,
			url: url_ok_obj,
			type: 'POST',
			data: {
				'funcion' : 'consultarHorarioCreaAreaEstado',
				'p1' : id_crea,
				'p2' : area_artistica,
				'p3' : estado
			}
		}).done(function(data){
			parent.cerrarCargando();
			data = $.parseJSON(data);
			data = generarLapsoHorario(data);
		    for (var i = data.length - 1; i >= 0; i--) {
		    	/*var width = 100;
		    	var marginleft = 0;
		    	var coincidencias = 1;
		    	for (var j = data.length - 1; j >= 0; j--) {
		    		if ((i != j) && data[i]["IN_dia"] == data[j]["IN_dia"]) {
		    			coincidencias = coincidencias + 1;
		    			width = 100/coincidencias;
		    			data[i]["width"] = width;
		    			data[i]["marginleft"] = width;
		    		}
		    	}	*/
		    	agregarDatosSesionClaseAHorario(data[i]);
		    }
		    $.getScript("../LibreriasExternas/shedule2/assets/js/main.js");
		}).fail(function(result){
		      console.log("Error: "+result);
		});
	}

	function consultarHorarioArtistaFormador(){
		$("[id^='dia_']").html("");
		$("[id^='ul_horario_dia_']").html("");
		var id_artista = $("#SL_ARTISTA_FORMADOR").val();
		parent.mostrarCargando();
		$.ajax({
			async: true,
			url: url_ok_obj,
			type: 'POST',
			data: {
				'funcion' : 'consultarHorarioArtistaFormador',
				'p1' : id_artista
			}
		}).done(function(data){
			parent.cerrarCargando();
			data = $.parseJSON(data);
			data = generarLapsoHorario(data);
		    for (var i = data.length - 1; i >= 0; i--) {
		    	/*var marginleft = 0;
		    	var coincidencias = 1;
		    	for (var j = data.length - 1; j >= 0; j--) {
		    		if ((i != j) && data[i]["IN_dia"] == data[j]["IN_dia"]) {
		    			coincidencias = coincidencias + 1;
		    			width = 100/coincidencias;
		    			data[i]["width"] = width;
		    			data[i]["marginleft"] = width;
		    		}
		    	}*/
		    	agregarDatosSesionClaseAHorario(data[i]);
		    }
		    $.getScript("../LibreriasExternas/shedule2/assets/js/main.js");
		    $("#SL_CREA").trigger("click");
		}).fail(function(result){
		      console.log("Error: "+result);
		});
	}
});