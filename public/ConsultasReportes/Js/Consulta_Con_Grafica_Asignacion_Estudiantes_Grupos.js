var url_ok_obj = '../../src/ConsultasReportes/Controlador/ReporteAdministrativoController.php';
$(function(){
	var texto = ""; // Almacena el mensaje del encabezado e igualmente para la grafica
	var d = new Date();
	$("#SL_mes").html(parent.getOptionsMes()).val(d.getMonth() + 1).selectpicker("refresh");
	$("#SL_linea_atencion").html(parent.getOptionsLineasAtencion()).selectpicker("refresh");

	var table_detalle_estudiantes_administrados = $("#table_detalle_estudiantes_administrados").DataTable({ 
		responsive: true, 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',

			title: 'Asignacion beneficiarios a grupos'
		}
		]
	});

	var table_estudiantes_administrados = $("#table_estudiantes_administrados").DataTable({ 
		responsive: true, 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',

			title: 'Asignacion beneficiarios en mes'
		}
		]
	});

	var table_estudiantes_creados = $("#table_estudiantes_creados").DataTable({ 
		responsive: true, 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',

			title: 'Beneficiarios creados en mes'
		}
		]
	});

	$("#SL_linea_atencion").change(cargarGraficaYTabla);
	$("#SL_tipo_consulta").change(cargarGraficaYTabla);
	$("#SL_anio").change(cargarGraficaYTabla);
	$("#SL_mes").change(cargarGraficaYTabla).trigger("change");

	$("#table_detalle_estudiantes_administrados").delegate(".cargar_ninos_administrados","click",function(){
		var tipo_accion = $(this).data('tipo_accion');
		var datos_para_consulta;
		switch(tipo_accion){
			case 'asignados':
				datos_para_consulta = {
					'funcion' : 'consultarListadoAsignacionEstudiantes',
					'p1' : {
						'linea_atencion' : $("#SL_linea_atencion").val(),
						'anio' : $("#SL_anio").val(),
						'mes' : $("#SL_mes").val(),
						'id_persona' : $(this).data('id_persona')
					}
				};
				break;
			case 'removidos':
				datos_para_consulta = {
					'funcion' : 'consultarListadoRemocionEstudiantes',
					'p1' : {
						'linea_atencion' : $("#SL_linea_atencion").val(),
						'anio' : $("#SL_anio").val(),
						'mes' : $("#SL_mes").val(),
						'id_persona' : $(this).data('id_persona')
					}
				};
				break;
			case 'creados_matricula':
				datos_para_consulta = {
					'funcion' : 'consultarListadoCreacionEstudiantes',
					'p1' : {
						'tipo_estudiante' : 'matricula',
						'anio' : $("#SL_anio").val(),
						'mes' : $("#SL_mes").val(),
						'id_persona' : $(this).data('id_persona')
					}
				};
				break;
			case 'creados_formulario':
				datos_para_consulta = {
					'funcion' : 'consultarListadoCreacionEstudiantes',
					'p1' : {
						'tipo_estudiante' : 'formulario',
						'anio' : $("#SL_anio").val(),
						'mes' : $("#SL_mes").val(),
						'id_persona' : $(this).data('id_persona')
					}
				};
				break;
			default:
				console.log("Otro tipo_accion");
				break;
		}
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos_para_consulta,
			async: false
		}).done(function(data){
			if (tipo_accion != 'asignados' && tipo_accion != 'removidos') {
				table_estudiantes_creados.clear().draw();
				table_estudiantes_creados.rows.add($(data)).draw();
			}
			else {
				table_estudiantes_administrados.clear().draw();
				table_estudiantes_administrados.rows.add($(data)).draw();
			}
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando listado de asignaciones',
				html: '<small>No se ha podido cargar los datos de cada beneficiario asignado.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	});

	function cargarGraficaYTabla(){
		texto = "Este es el detalle de " + $("#SL_tipo_consulta option:selected").text() + " en el mes de " + $("#SL_mes option:selected").text();
		texto += " de " + $("#SL_anio option:selected").text();
		$("#p_texto_accion").text(texto);
		$("#b_tipo_accion_title_modal").text(texto);
		$("#div_linea_atencion").hide();
		switch($("#SL_tipo_consulta").val()){
			case 'asignaciones':
				cargarGraficaYTablaAsignacion();
				texto += " para la línea de atención " + $("#SL_linea_atencion option:selected").text();
				$("#div_linea_atencion").show();
				break;
			case 'remociones':
				cargarGraficaYTablaRemocion();
				texto += " para la línea de atención " + $("#SL_linea_atencion option:selected").text();
				$("#div_linea_atencion").show();
				break;
			case 'creaciones_simat':
				cargarGraficaYTablaCreacionEstudiante('matricula','#f0ad4e');
				break;
			case 'creaciones_formulario':
				cargarGraficaYTablaCreacionEstudiante('formulario','#ccc');
				break;
			default:
				console.log("Otro tipo de grafica");
				break;
		}
	}

	function cargarGraficaYTablaAsignacion(){
		var datos = {
			'funcion' : 'consultarTotalAsignacionEstudiantes',
			'p1' : {
				'linea_atencion' : $("#SL_linea_atencion").val(),
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val()
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			data = $.parseJSON(data);
			var chart = AmCharts.makeChart("div_grafica_asignacion", {
				"theme": "light",
				"type": "serial",
				"dataProvider": data,
				"valueAxes": [{
					"title": texto
				}],
				"graphs": [{
					"balloonText": "Asignaciones realizadas por [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 1,
					"title": "Income",
					"type": "column",
					"valueField": "total"
				}],
				"angle": 30,
				"rotate": true,
				"categoryField": "nombre",
				"categoryAxis": {
					"gridPosition": "start",
					"fillAlpha": 0.05,
					"position": "left",
					"labelFrequency": 1,
				},
				"export": {
					"enabled": true
				}
			});

			table_detalle_estudiantes_administrados.clear().draw();
			var html_mostrar_table = "";
			$.each(data, function(i){
				html_mostrar_table += "<tr>";
				html_mostrar_table += "<td>" + data[i].nombre + "</td>";
				html_mostrar_table += "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-info' data-tipo_accion='asignados' data-id_persona='" + data[i].id_persona + "'>" + data[i].total + "</a></td>";
				html_mostrar_table += "</tr>";
			});
			table_detalle_estudiantes_administrados.rows.add($(html_mostrar_table)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando</b>',
				html: '<small>No se ha podido cargar los datos de asignación.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	}

	function cargarGraficaYTablaRemocion(){
		var datos = {
			'funcion' : 'consultarTotalRemocionEstudiantes',
			'p1' : {
				'linea_atencion' : $("#SL_linea_atencion").val(),
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val()
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			data = $.parseJSON(data);
			var chart = AmCharts.makeChart("div_grafica_asignacion", {
				"theme": "light",
				"type": "serial",
				"dataProvider": data,
				"valueAxes": [{
					"title": texto
				}],
				"graphs": [{
					"balloonText": "Remociones realizadas por [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 1,
					"title": "Income",
					"type": "column",
					"colorField": "color",
					"valueField": "total"
				}],
				"angle": 30,
				"rotate": true,
				"categoryField": "nombre",
				"categoryAxis": {
					"gridPosition": "start",
					"fillAlpha": 0.05,
					"position": "left",
					"labelFrequency": 1,
				},
				"export": {
					"enabled": true
				}
			});

			table_detalle_estudiantes_administrados.clear().draw();
			var html_mostrar_table = "";
			$.each(data, function(i){
				html_mostrar_table += "<tr>";
				html_mostrar_table += "<td>" + data[i].nombre + "</td>";
				html_mostrar_table += "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-danger' data-tipo_accion='removidos' data-id_persona='" + data[i].id_persona + "'>" + data[i].total + "</a></td>";
				html_mostrar_table += "</tr>";
			});
			table_detalle_estudiantes_administrados.rows.add($(html_mostrar_table)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando</b>',
				html: '<small>No se ha podido cargar los datos de beneficiarios removidos.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	}

	function cargarGraficaYTablaCreacionEstudiante(tipo_estudiante,color_graph){
		var datos = {
			'funcion' : 'consultarTotalCreacionEstudiantes',
			'p1' : {
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val(),
				'tipo_estudiante' : tipo_estudiante,
			},
			'p2' : color_graph
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			data = $.parseJSON(data);
			var chart = AmCharts.makeChart("div_grafica_asignacion", {
				"theme": "light",
				"type": "serial",
				"dataProvider": data,
				"valueAxes": [{
					"title": texto
				}],
				"graphs": [{
					"balloonText": "Beneficiarios creados por [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 1,
					"title": "Income",
					"type": "column",
					"colorField": "color",
					"valueField": "total"
				}],
				"angle": 30,
				"rotate": true,
				"categoryField": "nombre",
				"categoryAxis": {
					"gridPosition": "start",
					"fillAlpha": 0.05,
					"position": "left",
					"labelFrequency": 1,
				},
				"export": {
					"enabled": true
				}
			});

			table_detalle_estudiantes_administrados.clear().draw();
			var html_mostrar_table = "";
			$.each(data, function(i){
				html_mostrar_table += "<tr>";
				html_mostrar_table += "<td>" + data[i].nombre + "</td>";
				html_mostrar_table += "<td class='text-center'><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_creados' class='cargar_ninos_administrados btn btn-" + ((tipo_estudiante == 'formulario')?'default':'warning') + "' data-tipo_accion='creados_" + tipo_estudiante + "' data-id_persona='" + data[i].id_persona + "'>" + data[i].total + "</a></td>";
				html_mostrar_table += "</tr>";
			});
			table_detalle_estudiantes_administrados.rows.add($(html_mostrar_table)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando</b>',
				html: '<small>No se ha podido cargar los datos de beneficiarios removidos.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	}

	function cargarGraficaYTablaCreacionFuenteFormulario(){

	}
});
