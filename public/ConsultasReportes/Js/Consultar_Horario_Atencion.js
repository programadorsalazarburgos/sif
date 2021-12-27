var url_ok_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
var horarios = [];
var bandera_matriculados = false;
var bandera_acumulado = false;
var grupos = [];
var colors = ['#577F92', '#443453', '#A2B9B2', '#f6b067', '#b52a65', '#235921', '#99140f', '#183e6e', '#258073', '#878727'];
document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'timeGridWeek',
          firstDay: 1,
          allDaySlot: false,
          selectable: true,
          slotMinTime: '06:00:00',
          slotMaxTime: '23:00:00',
          hiddenDays: [0],
          dayHeaderContent : (args) => {
    			if (args.date.getDay() === 1) {
	    	  		return 'Lunes';
    			}
    			if (args.date.getDay() === 2) {
	    	  		return 'Martes';
    			}
    			if (args.date.getDay() === 3) {
	    	  		return 'Miércoles';
    			}
    			if (args.date.getDay() === 4) {
	    	  		return 'Jueves';
    			}
    			if (args.date.getDay() === 5) {
	    	  		return 'Viernes';
    			}
    			if (args.date.getDay() === 6) {
	    	  		return 'Sábado';
    			}
  			},
          events: horarios
  });
  calendar.render();
      
	$("#SL_ARTISTA_FORMADOR").html(parent.getOptionsArtistasFormadores()).selectpicker("refresh");

	$("#SL_CREA").html(parent.getOptionsClanes()).selectpicker("refresh");
	$("#SL_AREA_ARTISTICA").html(parent.getOptionParametroDetalle(6)).selectpicker("refresh");

	$("#BT_CONSULTAR_FILTROS").on("click", function(){
		consultarHorarioCreaAreaEstado();
	});

	$("#BT_CONSULTAR_FORMADOR").on("click", function(){
		consultarHorarioArtistaFormador();
	});

	$("#BT_BENEFICIARIOS_MATRICULADOS").on("click", function(){
		bandera_matriculados = !bandera_matriculados;
		if (bandera_matriculados) {
			$("#table_matriculados").show();
		}
		else{
			$("#table_matriculados").hide();	
		}
	});

	$("#BT_BENEFICIARIOS_ACUMULADO").on("click", function(){
		bandera_acumulado = !bandera_acumulado;
		if (bandera_acumulado) {
			$("#table_acumulado").show();
		}
		else{
			$("#table_acumulado").hide();	
		}
	});

	// $("#calendar").delegate(".fc-timegrid-event","click", function(){
	// 	alert($(this).data("id_grupo"));
	// });

	function agregarHorario(datos){
		var acronimo_linea_atencion = {"arte_escuela":"AE","emprende_clan":"IC","laboratorio_clan":"CV"};
		var hora_inicio = String(datos['TI_hora_inicio_clase']);
		var hora_fin = datos['TI_hora_fin_clase'];
		horarios.push({
			title: acronimo_linea_atencion[datos['linea_atencion']] + '-' + datos['FK_grupo'],
			startTime: hora_inicio,
			endTime: hora_fin,
			color: colors[datos['index_grupo']],
			daysOfWeek: [datos['IN_dia']],
			id_grupo: datos['FK_grupo'],
			linea_atencion: datos['linea_atencion'],
			matriculados: datos['total_estudiantes'],
			crea: datos['nombre_crea'],
			area_artistica: datos['area_artistica'],
			colegio: datos['colegio'],
			artista_formador: datos['artista_formador'],
			acumulado: datos['total_acumulado'],
			listado_activos: datos['listado_activos'],
			listado_acumulado: datos['listado_acumulado']
		});
	};

	function consultarHorarioCreaAreaEstado(){
		$("[id^='dia_']").html("");
		$("[id^='ul_horario_dia_']").html("");
		var id_crea = $("#SL_CREA").val().join(',');
		var area_artistica = $("#SL_AREA_ARTISTICA").val().join(',');
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
			horarios = [];
			grupos = [];
			for (var i = data.length - 1; i >= 0; i--) {
		    	if(grupos.indexOf(data[i]['FK_grupo']) == -1){
					grupos.push(data[i]['FK_grupo']);
				}
				data[i]['index_grupo'] = grupos.indexOf(data[i]['FK_grupo']);
				if(data[i]['index_grupo'] > 9){
					data[i]['index_grupo'] = parseInt(String(data[i]['index_grupo']).substring(1,2));
				}
		    	agregarHorario(data[i]);
			}
			cargarCalendario();
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
			horarios = [];
			grupos = [];
		    for (var i = data.length - 1; i >= 0; i--) {
		    	if(grupos.indexOf(data[i]['FK_grupo']) == -1){
					grupos.push(data[i]['FK_grupo']);
				}
				data[i]['index_grupo'] = grupos.indexOf(data[i]['FK_grupo']);
				if(data[i]['index_grupo'] > 9){
					data[i]['index_grupo'] = parseInt(String(data[i]['index_grupo']).substring(1,2));
				}
		    	agregarHorario(data[i]);
		    }
		    cargarCalendario();
		}).fail(function(result){
		      console.log("Error: "+result);
		});
	}

	function cargarCalendario(){
		var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'timeGridWeek',
          firstDay: 1,
          allDaySlot: false,
          selectable: true,
          slotMinTime: '06:00:00',
          slotMaxTime: '23:00:00',
          hiddenDays: [0],
          dayHeaderContent : (args) => {
    			if (args.date.getDay() === 1) {
	    	  		return 'Lunes';
    			}
    			if (args.date.getDay() === 2) {
	    	  		return 'Martes';
    			}
    			if (args.date.getDay() === 3) {
	    	  		return 'Miércoles';
    			}
    			if (args.date.getDay() === 4) {
	    	  		return 'Jueves';
    			}
    			if (args.date.getDay() === 5) {
	    	  		return 'Viernes';
    			}
    			if (args.date.getDay() === 6) {
	    	  		return 'Sábado';
    			}
  			},
          events: horarios,
          eventClick: function(info) {
    		$("#modal_title").html(info.event.title+"<button type='button' class='close' data-dismiss='modal'>&times;</button>");
    		$("#INFO_CREA").html(info.event.extendedProps.crea);
    		$("#INFO_AREA_ARTISTICA").html(info.event.extendedProps.area_artistica);
			$("#INFO_COLEGIO").html(info.event.extendedProps.colegio);
    		$("#INFO_ARTISTA_FORMADOR").html(info.event.extendedProps.artista_formador);
    		$("#INFO_BENEFICIARIOS_MATRICULADOS").html(info.event.extendedProps.matriculados+" <small style='color:white;'>(mostrar/ocultar)</small>");
    		$("#INFO_BENEFICIARIOS_ATENDIDOS_ACUMULADO").html(info.event.extendedProps.acumulado+" <small style='color:white;'>(mostrar/ocultar)</small>");
    		
    		$("#table_matriculados_body").html('');
    		$.each(info.event.extendedProps.listado_activos, function(index, value){
    			$("#table_matriculados_body").append("<tr><td>"+value.IN_Identificacion+"</td><td>"+value.VC_Primer_Nombre+' '+value.VC_Segundo_Nombre+' '+value.VC_Primer_Apellido+' '+value.VC_Segundo_Apellido+"</td><td>"+value.DT_fecha_ingreso+"</td></tr>");
    		});
    		
    		$("#table_acumulado_body").html('');
    		$.each(info.event.extendedProps.listado_acumulado, function(index, value){
    			$("#table_acumulado_body").append("<tr><td>"+value.IN_Identificacion+"</td><td>"+value.VC_Primer_Nombre+' '+value.VC_Segundo_Nombre+' '+value.VC_Primer_Apellido+' '+value.VC_Segundo_Apellido+"</td><td>"+value.primer_asistencia+"</td><td>"+value.asistencias+"</td></tr>");
    		});

    		consultarDetalleGrupo(info.event.extendedProps.id_grupo, info.event.extendedProps.linea_atencion);
  		
    		$("#myModal").modal("show");
  			}
          });
        calendar.render();
	}

	function cargarGraphAtencionMensual(dataProvider){
		var chart = AmCharts.makeChart("chart_atencion_mensual", {
      			"theme": "light",
      "type": "serial",
      "marginRight": 80,
      "autoMarginOffset": 20,
      "marginTop":20,
      "dataProvider": dataProvider,
      "valueAxes": [{
        "id": "v1",
        "axisAlpha": 1
      }],
      "graphs": [{
        "labelText": "[[value]]",
        "useNegativeColorIfDown": true,
        "balloonText": "[[category]]<br><b>Cantidad: [[value]]</b>",
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletBorderColor": "#FFFFFF",
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "lineColor": "#fdd400",
        "negativeLineColor": "#67b7dc",
        "valueField": "Y"
      }],
      "chartScrollbar": {
        "scrollbarHeight": 5,
        "backgroundAlpha": 0.1,
        "backgroundColor": "#868686",
        "selectedBackgroundColor": "#67b7dc",
        "selectedBackgroundAlpha": 1
      },
      "chartCursor": {
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true
      },
      "categoryField": "X",
      "categoryAxis": {
        "labelRotation": 40,
        "parseDates": false,
        "axisAlpha": 0,
        "minHorizontalGap": 60
      },
      "export": {
        "enabled": true
      }
    		});
	}

	function consultarDetalleGrupo(id_grupo, linea_atencion){
		$.ajax({
			async: true,
			url: url_ok_obj,
			type: 'POST',
			data: {
				'funcion' : 'getAtencionMensualGrupo',
				'p1' : id_grupo,
				'p2' : linea_atencion
			}
		}).done(function(data){
			data = $.parseJSON(data);
		   	cargarGraphAtencionMensual(data);
		}).fail(function(result){
		   	console.log("Error: "+result);
		});

		// $.ajax({
		// 	async: true,
		// 	url: url_ok_obj,
		// 	type: 'POST',
		// 	data: {
		// 		'funcion' : 'getColegioGrupo',
		// 		'p1' : {
		// 			'id_grupo': id_grupo,
		// 			'tipo_grupo': linea_atencion,
		// 		}
		// 	}
		// }).done(function(data){
		// 	console.log(data);
		//    	$("#INFO_COLEGIO").html(data);
		// }).fail(function(result){
		//    	console.log("Error: "+result);
		// });
	}
});