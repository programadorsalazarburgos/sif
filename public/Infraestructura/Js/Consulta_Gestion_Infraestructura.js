var url_ok_obj = '../../src/Infraestructura/Controlador/InfraestructuraController.php';
$(function(){
	var texto = ""; // Almacena el mensaje del encabezado e igualmente para la grafica
	var d = new Date();
	$("#SL_mes").html(parent.getOptionsMes()).val(d.getMonth() + 1).selectpicker("refresh");
	$("#SL_linea_atencion").html(parent.getOptionsLineasAtencion()).selectpicker("refresh");
	
	//Quitar las opciones de administrador.
	if($("#id_rol").val()==21){
		$("#SL_tipo_consulta option").each(function() {
    		if ($(this).hasClass('administrador')) {
    			$(this).remove();
    		}
    		$("#SL_tipo_consulta").selectpicker('refresh');
		});
	}

	var table_total_accion = $("#table_total_accion").DataTable({ 
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
			title: 'Gestión Infraestructura - SIF'
		},
		{
            extend: 'pdfHtml5',
            text: 'PDF',
            title: 'Gestión Infraestructura - SIF'
        }
		]
	});

	var table_inventario_registrado = $("#table_inventario_registrado").DataTable({ 
		responsive: true,
		"pageLength": 10,
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
			title: 'Registro de Inventario - SIF'
		},
		{
            extend: 'pdfHtml5',
            text: 'PDF',
            title: 'Registro de Inventario - SIF'
        }
		]
	});

	var table_traslados_inventario = $("#table_traslados_inventario").DataTable({ 
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
			title: 'Solicitudes de Traslado de Inventario - SIF'
		},
		{
            extend: 'pdfHtml5',
            text: 'PDF',
            title: 'Solicitudes de Traslado de Inventario - SIF'
        }
		]
	});

	var table_observaciones_inventario = $("#table_observaciones_inventario").DataTable({ 
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
			title: 'Observaciones de Control de Inventario - SIF'
		},
		{
            extend: 'pdfHtml5',
            text: 'PDF',
            title: 'Observaciones de Control de Inventario - SIF'
        }
		]
	});	


	$("#SL_linea_atencion").change(cargarGraficaYTabla);
	$("#SL_tipo_consulta").change(cargarGraficaYTabla);
	$("#SL_anio").change(cargarGraficaYTabla);
	$("#SL_mes").change(cargarGraficaYTabla).trigger("change");

	$("#table_total_accion").delegate(".cargar_listado_detalle","click",function(){
		var tipo_accion = $(this).data('tipo_accion');
		var datos;
		switch(tipo_accion){
			case 'registrados':
				datos = {
					'funcion' : 'getListadoInventarioRegistradoUsuario',
					'p1' : {
						'anio' : $("#SL_anio").val(),
						'mes' : $("#SL_mes").val(),
						'id_persona' : $(this).data('id_persona')
					}
				};
				break;
			case 'traslados':
				datos = {
					'funcion' : 'getListadoTrasladoInventarioUsuario',
					'p1' : {
						'anio' : $("#SL_anio").val(),
						'mes' : $("#SL_mes").val(),
						'id_persona' : $(this).data('id_persona')
					}
				};
				break;
			case 'observaciones':
				datos = {
					'funcion' : 'getListadoObservacionesInventarioUsuario',
					'p1' : {
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
		table_inventario_registrado.clear().draw();
		table_traslados_inventario.clear().draw();
		table_observaciones_inventario.clear().draw();
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			if (tipo_accion == 'registrados') {
				table_inventario_registrado.rows.add($(data)).draw();
			}
			if (tipo_accion == 'traslados') {
				table_traslados_inventario.rows.add($(data)).draw();
			}
			if (tipo_accion == 'observaciones') {
				table_observaciones_inventario.rows.add($(data)).draw();
			}
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando listado.',
				html: '<small>No se han podido cargar los datos.</small>',
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
			case 'registros':
				cargarGraficaYTablaRegistroInventario();
				break;
			case 'traslados':
				cargarGraficaYTablaTraslados();
				break;
			case 'observaciones':
				cargarGraficaYTablaObservacionesInventario('matricula','#f0ad4e');
				break;
			default:
				console.log("Otro tipo de grafica");
				break;
		}
	}

	function cargarGraficaYTablaRegistroInventario(){
		var datos = {
			'funcion' : 'getCantidadRegistroInventarioMes',
			'p1' : {
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val()
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false,
			dataType: 'json'
		}).done(function(data){
			if(Object.keys(data).length == 0){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'Sin resultados</b>',
					html: '<small>No se han encontrado resultados para la consulta.</small>',
					type: 'warning',
					confirmButtonText: 'Aceptar',
					showCancelButton: false
				}).catch(parent.swal.noop);
			}
			var chart = AmCharts.makeChart("div_grafica_total", {
				"theme": "light",
				"type": "serial",
				"dataProvider": data,
				"valueAxes": [{
					"title": texto
				}],
				"graphs": [{
					"balloonText": "Registros realizados por [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 1,
					"title": "Income",
					"type": "column",
					"valueField": "CANTIDAD"
				}],
				"angle": 30,
				"rotate": true,
				"categoryField": "NOMBRE",
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

			table_total_accion.clear().draw();
			var html_mostrar_table = "";
			$.each(data, function(i){
				html_mostrar_table += "<tr>";
				html_mostrar_table += "<td>" + data[i].NOMBRE + "</td>";
				html_mostrar_table += "<td class='text-center'><button href='#' data-toggle='modal' data-target='#modal_detalle_inventario_registrado' class='cargar_listado_detalle btn btn-info' data-tipo_accion='registrados' data-id_persona='" + data[i].ID_USUARIO + "'>" + data[i].CANTIDAD + "</button></td>";
				html_mostrar_table += "</tr>";
			});
			table_total_accion.rows.add($(html_mostrar_table)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando</b>',
				html: '<small>No se ha podido cargar la información.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	}

	function cargarGraficaYTablaTraslados(){
		var datos = {
			'funcion' : 'getCantidadTrasladosInventarioMes',
			'p1' : {
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val()
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false,
			dataType: 'json'
		}).done(function(data){
			if(Object.keys(data).length == 0){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'Sin resultados</b>',
					html: '<small>No se han encontrado resultados para la consulta.</small>',
					type: 'warning',
					confirmButtonText: 'Aceptar',
					showCancelButton: false
				}).catch(parent.swal.noop);
			}
			var chart = AmCharts.makeChart("div_grafica_total", {
				"theme": "light",
				"type": "serial",
				"dataProvider": data,
				"valueAxes": [{
					"title": texto
				}],
				"graphs": [{
					"balloonText": "Traslados realizados por [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 1,
					"title": "Income",
					"type": "column",
					"colorField": "color",
					"valueField": "CANTIDAD"
				}],
				"angle": 30,
				"rotate": true,
				"categoryField": "NOMBRE",
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
			table_total_accion.clear().draw();
			var html_mostrar_table = "";
			$.each(data, function(i){
				html_mostrar_table += "<tr>";
				html_mostrar_table += "<td>" + data[i].NOMBRE + "</td>";
				html_mostrar_table += "<td class='text-center'><button href='#' data-toggle='modal' data-target='#modal_detalle_solicitudes_traslado' class='cargar_listado_detalle btn btn-danger' data-tipo_accion='traslados' data-id_persona='" + data[i].ID_USUARIO + "'>" + data[i].CANTIDAD + "</button></td>";
				html_mostrar_table += "</tr>";
			});
			table_total_accion.rows.add($(html_mostrar_table)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando</b>',
				html: '<small>No se ha podido cargar la información.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	}

	function cargarGraficaYTablaObservacionesInventario(){
		var datos = {
			'funcion' : 'getCantidadObservacionesInventarioMes',
			'p1' : {
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val()
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false,
			dataType: 'json'
		}).done(function(data){
			if(Object.keys(data).length == 0){
				parent.swal({
					confirmButtonColor: '#3f9a9d',
					title: 'Sin resultados</b>',
					html: '<small>No se han encontrado resultados para la consulta.</small>',
					type: 'warning',
					confirmButtonText: 'Aceptar',
					showCancelButton: false
				}).catch(parent.swal.noop);
			}
			var chart = AmCharts.makeChart("div_grafica_total", {
				"theme": "light",
				"type": "serial",
				"dataProvider": data,
				"valueAxes": [{
					"title": texto
				}],
				"graphs": [{
					"balloonText": "Observaciones realizadas por [[category]]:[[value]]",
					"fillAlphas": 1,
					"lineAlpha": 1,
					"title": "Income",
					"type": "column",
					"colorField": "color",
					"valueField": "CANTIDAD"
				}],
				"angle": 30,
				"rotate": true,
				"categoryField": "NOMBRE",
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

			table_total_accion.clear().draw();
			var html_mostrar_table = "";
			$.each(data, function(i){
				html_mostrar_table += "<tr>";
				html_mostrar_table += "<td>" + data[i].NOMBRE + "</td>";
				if($('#id_usuario').val() == data[i].ID_USUARIO || $('#id_rol').val() != 21){
					html_mostrar_table += "<td class='text-center'><button href='#' data-toggle='modal' data-target='#modal_detalle_observaciones' class='cargar_listado_detalle btn btn-danger' data-tipo_accion='observaciones' data-id_persona='" + data[i].ID_USUARIO + "'>" + data[i].CANTIDAD + "</button></td>";
				}
				else{
					html_mostrar_table += "<td class='text-center'><button href='#' disabled='disabled' data-toggle='modal' data-target='#modal_detalle_observaciones' class='cargar_listado_detalle btn btn-danger' data-tipo_accion='observaciones' data-id_persona='" + data[i].ID_USUARIO + "'>" + data[i].CANTIDAD + "</button></td>";	
				}
				html_mostrar_table += "</tr>";
			});
			table_total_accion.rows.add($(html_mostrar_table)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando</b>',
				html: '<small>No se ha podido cargar la información.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	}

	function cargarGraficaYTablaCreacionFuenteFormulario(){

	}
});
