var url_ok_obj = '../../src/ConsultasReportes/Controlador/ReporteAdministrativoController.php';
$(function(){
	var array_asignacion = [];
	var array_creacion = [];
	var array_reporte = [];
	total_asignados = 0;
	total_removidos = 0;

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

			title: 'Estudiantes asignados en mes'
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

			title: 'Estudiantes asignados en mes'
		}
		]
	});
	var table_grupos_administrados = $("#table_grupos_administrados").DataTable({ 
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

			title: 'Grupos administrados en mes'
		}
		]
	});

	var d = new Date();
	$("#SL_mes").html(parent.getOptionsMes()).val(d.getMonth() + 1).selectpicker("refresh").change(cargarDatosAsignacion).trigger("change");
	$("#SL_anio").change(cargarDatosAsignacion);

	$("#table_total_beneficiarios_administrados").delegate(".cargar_ninos_administrados","click",function(){
		var func = "";
		switch($(this).data('tipo_accion')){
			case 'asignados':
				func = 'consultarListadoAsignacionEstudiantes';
				break;
			case 'removidos':
				func = 'consultarListadoRemocionEstudiantes';
				break;
			default:
				console.log("Otro tipo_accion");
				break;
		}
		var datos = {
			'funcion' : func,
			'p1' : {
				'linea_atencion' : $(this).data('linea_atencion'),
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val(),
				'id_persona' : parent.idUsuario
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			table_estudiantes_administrados.clear().draw();
			table_estudiantes_administrados.rows.add($(data)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando listado de beneficiarios asignados',
				html: '<small>No se ha podido cargar los datos de cada niño asignado.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	});

	$("#table_total_beneficiarios_creados").delegate(".cargar_ninos_creados","click",function(){
		var tipo_estudiante_origen = $(this).data('tipo_origen_estuiante');
		var datos = {
			'funcion' : 'consultarListadoCreacionEstudiantes',
			'p1' : {
				'tipo_estudiante' : tipo_estudiante_origen,
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val(),
				'id_persona' : parent.idUsuario
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			table_estudiantes_creados.clear().draw();
			table_estudiantes_creados.rows.add($(data)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando listado de beneficiarios asignados',
				html: '<small>No se ha podido cargar los datos de cada niño creado.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	});

	$("#table_grupos_administrados").delegate(".cargar_grupos_creados","click",function(){
		var datos = {
			'funcion' : 'consultarGruposCreadosUsuario',
			'p1' : {
				'anio' : $("#SL_anio").val(),
				'mes' : $("#SL_mes").val(),
				'id_persona' : parent.idUsuario
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			console.log(data);
			// table_grupos_administrados.clear().draw();
			// table_grupos_administrados.rows.add($(data)).draw();
		}).fail(function(result){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Error consultando listado de grupos administrados',
				html: '<small>No se ha podido cargar los datos de cada grupod administrado.</small>',
				type: 'warning',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		});
	});

	$("#BT_generar_reporte").click(function(){
		generarReportePDF();
	});

	function cargarDatosAsignacion(){
		total_asignados = 0;
		total_removidos = 0;
		var datos = {
			"funcion" : "consultarDatosAsignacionLineaAtencion",
			"p1" : {
				"anio" : $("#SL_anio").val(),
				"mes" : $("#SL_mes").val(),
				"id_usuario" : parent.idUsuario
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			data = $.parseJSON(data);
			for (var i = 0; i < data.length; i++) {
				array_asignacion[data[i]['linea_atencion']] = [];
				array_asignacion[data[i]['linea_atencion']]['asignados'] = data[i]['asignados'];
				array_asignacion[data[i]['linea_atencion']]['removidos'] = data[i]['removidos'];
				array_asignacion[data[i]['linea_atencion']]['grupos_creados'] = data[i]['grupos_creados'];
				array_asignacion[data[i]['linea_atencion']]['grupos_cerrados'] = data[i]['grupos_cerrados'];
				array_asignacion[data[i]['linea_atencion']]['linea_atencion'] = data[i]['linea_atencion'];
				array_asignacion[data[i]['linea_atencion']]['linea_atencion_mostrar'] = data[i]['linea_atencion_mostrar'];
				total_asignados += parseInt(data[i]['asignados']);
				total_removidos += parseInt(data[i]['removidos']);
			}
			var texto_mostrar = "";
				texto_mostrar += "<tr>";
				texto_mostrar += "<td>"+array_asignacion['arte_escuela']['linea_atencion_mostrar']+"</td>";
				texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-info' data-tipo_accion='asignados' data-linea_atencion='"+array_asignacion['arte_escuela']['linea_atencion']+"'>"+array_asignacion['arte_escuela']['asignados']+"</a></td>";
				texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-danger' data-tipo_accion='removidos' data-linea_atencion='"+array_asignacion['arte_escuela']['linea_atencion']+"'>"+array_asignacion['arte_escuela']['removidos']+"</a></td>";
				texto_mostrar += "</tr>";
				texto_mostrar += "<tr>";
				texto_mostrar += "<td>"+array_asignacion['emprende_clan']['linea_atencion_mostrar']+"</td>";
				texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-info' data-tipo_accion='asignados' data-linea_atencion='"+array_asignacion['emprende_clan']['linea_atencion']+"'>"+array_asignacion['emprende_clan']['asignados']+"</a></td>";
				texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-danger' data-tipo_accion='removidos' data-linea_atencion='"+array_asignacion['emprende_clan']['linea_atencion']+"'>"+array_asignacion['emprende_clan']['removidos']+"</a></td>";
				texto_mostrar += "</tr>";
				texto_mostrar += "<tr>";
				texto_mostrar += "<td>"+array_asignacion['laboratorio_clan']['linea_atencion_mostrar']+"</td>";
				texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-info' data-tipo_accion='asignados' data-linea_atencion='"+array_asignacion['laboratorio_clan']['linea_atencion']+"'>"+array_asignacion['laboratorio_clan']['asignados']+"</a></td>";
				texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_administrados' class='cargar_ninos_administrados btn btn-danger' data-tipo_accion='removidos' data-linea_atencion='"+array_asignacion['laboratorio_clan']['linea_atencion']+"'>"+array_asignacion['laboratorio_clan']['removidos']+"</a></td>";
				texto_mostrar += "</tr>";
				texto_mostrar += "<tr>";
				texto_mostrar += "<td><b>Total:</b></td>";
				texto_mostrar += "<td><b>"+total_asignados+"</b></td>";
				texto_mostrar += "<td><b>"+total_removidos+"</b></td>";
				texto_mostrar += "</tr>";
			$("#table_total_beneficiarios_administrados tbody").html(texto_mostrar);
		}).fail(function(result){
			console.log("Error: "+result);
		});
		cargarDatosCreacionEstudiantes();
	}

	function cargarDatosCreacionEstudiantes(){
		var datos = {
			"funcion" : "consultarTotalEstudiantesCreadosPorUsuario",
			"p1" : {
				"anio" : $("#SL_anio").val(),
				"mes" : $("#SL_mes").val(),
				"id_usuario" : parent.idUsuario
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			data = $.parseJSON(data)
			array_creacion['matricula'] = data['matricula'];
			array_creacion['formulario'] = data['formulario'];
			array_creacion['creaencasa'] = data['creaencasa'];
			var texto_mostrar = "";
			texto_mostrar += "<tr>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_creados' class='cargar_ninos_creados btn btn-success ' data-tipo_origen_estuiante='matricula'>"+data['matricula']+"</a></td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_creados' class='cargar_ninos_creados btn btn-success ' data-tipo_origen_estuiante='creaencasa'>"+data['creaencasa']+"</a></td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_estudiantes_creados' class='cargar_ninos_creados btn btn-success ' data-tipo_origen_estuiante='formulario'>"+data['formulario']+"</a></td>";
			texto_mostrar += "</tr>";
			$("#table_total_beneficiarios_creados tbody").html(texto_mostrar);
		}).fail(function(result){
			console.log("Error: "+result);
		});
		cargarDatosAdministracionGrupos();
	}

	function cargarDatosAdministracionGrupos(){
		var datos = {
			"funcion" : "consultarTotalGruposAdministradosPorUsuario",
			"p1" : {
				"anio" : $("#SL_anio").val(),
				"mes" : $("#SL_mes").val(),
				"id_usuario" : parent.idUsuario
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			data = $.parseJSON(data)
			var texto_mostrar = "";
			texto_mostrar += "<tr>";
			texto_mostrar += "<td>Arte Escuela</td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_grupos_administrados' class='cargar_grupos_creados btn btn-success' disabled='disabled' data-tipo_grupo='arte_escuela'>"+data['arte_escuela']['creados']+"</a></td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_grupos_administrados' class='cargar_grupos_cerrados btn btn-danger' disabled='disabled' data-tipo_grupo='arte_escuela'>"+data['arte_escuela']['cerrados']+"</a></td>";
			texto_mostrar += "</tr>";

			texto_mostrar += "<tr>";
			texto_mostrar += "<td>Impulso Colectivo</td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_grupos_administrados' class='cargar_grupos_creados btn btn-success' disabled='disabled' data-tipo_grupo='emprende_clan'>"+data['emprende_clan']['creados']+"</a></td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_grupos_administrados' class='cargar_grupos_cerrados btn btn-danger' disabled='disabled' data-tipo_grupo='emprende_clan'>"+data['emprende_clan']['cerrados']+"</a></td>";
			texto_mostrar += "</tr>";

			texto_mostrar += "<tr>";
			texto_mostrar += "<td>Converge</td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_grupos_administrados' class='cargar_grupos_creados btn btn-success' disabled='disabled' data-tipo_grupo='laboratorio_clan'>"+data['laboratorio_clan']['creados']+"</a></td>";
			texto_mostrar += "<td><a href='#' data-toggle='modal' data-target='#modal_detalle_grupos_administrados' class='cargar_grupos_cerrados btn btn-danger' disabled='disabled' data-tipo_grupo='laboratorio_clan'>"+data['laboratorio_clan']['cerrados']+"</a></td>";
			texto_mostrar += "</tr>";
			$("#table_total_grupos_administrados tbody").html(texto_mostrar);
			cargarDatosReporteDigitalMensual();
		}).fail(function(result){
			console.log("Error: "+result);
		});
	}

	function generarReportePDF(){
		var datos_usuario = $.parseJSON(parent.consultarDatosBasicosUsuario(parent.idUsuario))[0];
		var nombre_completo_usuario = datos_usuario['VC_Primer_Nombre']+' '+datos_usuario['VC_Segundo_Nombre']+' '+datos_usuario['VC_Primer_Apellido']+' '+datos_usuario['VC_Segundo_Apellido'];
		var rol_usuario = datos_usuario['rol_usuario'];
		if(rol_usuario == 'RESPONSABLE CREA' || rol_usuario == 'ASISTENTE ADMINISTRATIVO'){
			var texto_revision_informacion = "";
			var firma_coordinador_crea = "";
			var firma_firma_coordinador_crea = "";
			var nombre_crea = "";
			var nombre_coordinador_crea = "";
			if(rol_usuario != 'RESPONSABLE CREA'){
				$.ajax({
					url: url_ok_obj,
					type: 'POST',
					data: {
						'funcion' : 'consultarCreaDeAsistenteAdministrativo',
						'p1' : parent.idUsuario
					},
					async: false
				}).done(function(data){
					data = $.parseJSON(data);
					nombre_crea = data[0]['VC_Nom_Clan'];
					nombre_coordinador_crea = data[0]['nombre_coordinador'];
					firma_firma_coordinador_crea = data[0]['firma_coordinador'];
				      //nombre_crea = data;
				}).fail(function(result){
				      console.log("Error: "+result);
				});
				texto_revision_informacion = '\nYo '+nombre_coordinador_crea+', certifico que he revisado la información reportada por el '+rol_usuario+': '+nombre_completo_usuario+' y valido la veracidad de la misma.\n\n';
				firma_coordinador_crea = '_____________________________________\n'+nombre_coordinador_crea+'\nRESPONSABLE - '+nombre_crea
			}else{
				$.ajax({
					url: url_ok_obj,
					type: 'POST',
					data: {
						'funcion' : 'consultarCreaDeCoordinador',
						'p1' : parent.idUsuario
					},
					async: false
				}).done(function(data){
					  nombre_crea = data;
					  firma_firma_coordinador_crea = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAACFCAYAAAAtmkC4AAAABHNCSVQICAgIfAhkiAAAAF96VFh0UmF3IHByb2ZpbGUgdHlwZSBBUFAxAAAImeNKT81LLcpMVigoyk/LzEnlUgADYxMuE0sTS6NEAwMDCwMIMDQwMDYEkkZAtjlUKNEABZgamFmaGZsZmgMxiM8FAEi2FMk61EMyAAABH0lEQVR4nO3BMQEAAADCoPVPbQlPoAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4GKMEAAdM062UAAAAASUVORK5CYII='
				}).fail(function(result){
				      console.log("Error: "+result);
				});
				
			}
			var fecha_hora_servidor = parent.getFechaYHoraServidor();
			var mes_reporte = ($("#SL_mes option:selected").text() + " de " + $("#SL_anio option:selected").text()).toLowerCase();
			var codigo_verificacion = fecha_hora_servidor.replace(/-/g,"").replace(/:/g,"").replace(/ /g,"");
			codigo_verificacion += " (No valido aún por desarrollo)";
			var contenido_reporte = {
			pageSize: 'FOLIO',
			/*footer: {
				columns: [
				{ text: 'SIF', style: 'footerStyle',id:"lastrow"}
				]
			},*/
			content:[
			{
				table: {
					widths: ['20%','55%', '*'],

					body: [
					[
					{
						image: 'data:image/png;base64,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',
						height:60,
						width:120,
						border: [false, false, false, false]
					},
					{
						text: '\nREPORTE MENSUAL SIF \n GESTION CREA '+mes_reporte.toUpperCase()+'',
						bold:true,
						alignment:'center',
						fontSize: '16',
						border: [false, false, false, false]
					},
					{
						image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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',
						height:60,
						width:120,
						border: [false, false, false, false]
					},
					]
					]

				}
			},
			{
				table: {
					widths: ['15%','50%','15%','20%'],
					body: [
					[{ text: 'Funcionario', bold: true },nombre_completo_usuario,{ text: 'Identificación', bold: true },datos_usuario['VC_Identificacion']],
					[{ text: 'Correo', bold: true },datos_usuario['VC_Correo'],{ text: 'Mes reporte', bold: true },mes_reporte.toUpperCase()],
					[{ text: 'CREA', bold: true },nombre_crea,{ text: 'Fecha de reporte', bold: true },fecha_hora_servidor]
					]
				}
			},
			/*
			{
				columns: [
					{
					
					width: 'auto',
					text: 'First column'
					},
				],
			},*/
			{ text: '\nGESTIÓN DE BENEFICIARIOS', bold: true, fontSize: 18, alignment: 'center', color: '#009f99' },
			{text: 'Total de beneficiarios nuevos registrados:', alignment: 'left'},
			{
				table: {
					widths: ['20%','10%','5%','20%','10%','5%','20%','10%'],
					body: [
					[
						{ text: 'SIMAT:', bold: false },
						{ text: array_creacion['matricula'], bold: true, alignment: 'center' },
						{
							text: '',
							border: [true, false, true, false]
						},
						{ text: 'CREAENCASA:', bold: false },
						{ text: array_creacion['creaencasa'], bold: true, alignment: 'center' },
						{
							text: '',
							border: [true, false, true, false]
						},
						{ text: 'FORMULARIO:', bold: false },
						{ text: array_creacion['formulario'], bold: true, alignment: 'center' }
					]
					]
				}
			},
			{text: 'Total de beneficiarios asignados y removidos en los grupos:', alignment: 'left'},
			{
				table: {
					widths: ['30%','15%','10%','30%','15%'],
					body: [
					[
						{
							colSpan: 2,
							alignment: 'center',
							bold: true,
							text: 'ASIGNADOS'
						},
						'',
						{
							rowSpan: 4,
							text: '',
							border: [true, false, true, false]
						},
						{
							colSpan: 2,
							alignment: 'center',
							bold: true,
							text: 'REMOVIDOS'
						},
						''
					],
					[
						{ text: 'Arte en la escuela:', bold: false },
						{ text: array_asignacion['arte_escuela']['asignados'], bold: true, alignment: 'center' },
						'',
						{ text: 'Arte en la escuela:', bold: false },
						{ text: array_asignacion['arte_escuela']['removidos'], bold: true, alignment: 'center' }
					],
					[
						{ text: 'Impulso Colectivo:', bold: false },
						{ text: array_asignacion['emprende_clan']['asignados'], bold: true, alignment: 'center' },
						'',
						{ text: 'Impulso Colectivo:', bold: false },
						{ text: array_asignacion['emprende_clan']['removidos'], bold: true, alignment: 'center' }
					],
					[
						{ text: 'Converge:', bold: false },
						{ text: array_asignacion['laboratorio_clan']['asignados'], bold: true, alignment: 'center' },
						'',
						{ text: 'Converge:', bold: false },
						{ text: array_asignacion['laboratorio_clan']['removidos'], bold: true, alignment: 'center' }
					],
					]
				}
			},
			{ text: '\nGESTIÓN DE GRUPOS', bold: true, fontSize: 18, alignment: 'center', color: '#009f99' },
			{text: 'Total de nuevos grupos creados y cerrados:', alignment: 'left'},
			{
				table: {
					widths: ['30%','15%','10%','30%','15%'],
					body: [
					[
						{
							colSpan: 2,
							alignment: 'center',
							bold: true,
							text: 'CREADOS'
						},
						'',
						{
							rowSpan: 4,
							text: '',
							border: [true, false, true, false]
						},
						{
							colSpan: 2,
							alignment: 'center',
							bold: true,
							text: 'CERRADOS'
						},
						''
					],
					[
						{ text: 'Arte en la escuela:', bold: false },
						{ text: array_asignacion['arte_escuela']['grupos_creados'], bold: true, alignment: 'center' },
						'',
						{ text: 'Arte en la escuela:', bold: false },
						{ text: array_asignacion['arte_escuela']['grupos_cerrados'], bold: true, alignment: 'center' }
					],
					[
						{ text: 'Impulso Colectivo:', bold: false },
						{ text: array_asignacion['emprende_clan']['grupos_creados'], bold: true, alignment: 'center' },
						'',
						{ text: 'Impulso Colectivo:', bold: false },
						{ text: array_asignacion['emprende_clan']['grupos_cerrados'], bold: true, alignment: 'center' }
					],
					[
						{ text: 'Converge:', bold: false },
						{ text: array_asignacion['laboratorio_clan']['grupos_creados'], bold: true, alignment: 'center' },
						'',
						{ text: 'Converge:', bold: false },
						{ text: array_asignacion['laboratorio_clan']['grupos_cerrados'], bold: true, alignment: 'center' }
					]
				]
				}
			},
			/*'\nTotal de grupos finalizados o cerrados:', // de ' + mes_reporte,
			{
				table: {
					widths: ['30%','15%'],
					body: [
					[{ text: 'Arte en la escuela:', bold: true },{ text: array_asignacion['arte_escuela']['grupos_cerrados'], bold: true }],
					[{ text: 'Emprende CREA:', bold: true },{ text: array_asignacion['emprende_clan']['grupos_cerrados'], bold: true }],
					[{ text: 'Laboratorio CREA:', bold: true },{ text: array_asignacion['laboratorio_clan']['grupos_cerrados'], bold: true }]
					]
				}
			},*/
			// '\nTotal estudiantes asignados: '+total_asignados,
			// 'Total estudiantes removidos: '+total_removidos,
			{ text: '\nGESTIÓN DE REPORTES DIGITALES MENSUALES', bold: true, fontSize: 18, alignment: 'center', color: '#009f99' },
			{
				table: {
					widths: ['40%','15%','15%','15%','15%'],
					body: [
					[
						{ text: 'Línea de Atención', bold: true, alignment: 'center' },
						{ text: 'Pendientes', bold: true, alignment: 'center' },
						{ text: 'Aprobados', bold: true, alignment: 'center' },
						{ text: 'Rechazados', bold: true, alignment: 'center' },
						{ text: 'Total', bold: true, alignment: 'center' },
					],
					[
						{ text: 'Arte en la Escuela', bold: false, alignment: 'left' },
						{ text: array_reporte['arte_escuela']['pendientes'], bold: false, alignment: 'center' },
						{ text: array_reporte['arte_escuela']['aprobados'], bold: false, alignment: 'center' },
						{ text: array_reporte['arte_escuela']['rechazados'], bold: false, alignment: 'center' },
						{ text: array_reporte['arte_escuela']['total'], bold: false, alignment: 'center' },
					],
					[
						{ text: 'Impulso Colectivo', bold: false, alignment: 'left' },
						{ text: array_reporte['emprende_clan']['pendientes'], bold: false, alignment: 'center' },
						{ text: array_reporte['emprende_clan']['aprobados'], bold: false, alignment: 'center' },
						{ text: array_reporte['emprende_clan']['rechazados'], bold: false, alignment: 'center' },
						{ text: array_reporte['emprende_clan']['total'], bold: false, alignment: 'center' },
					],
					[
						{ text: 'Converge', bold: false, alignment: 'left' },
						{ text: array_reporte['laboratorio_clan']['pendientes'], bold: false, alignment: 'center' },
						{ text: array_reporte['laboratorio_clan']['aprobados'], bold: false, alignment: 'center' },
						{ text: array_reporte['laboratorio_clan']['rechazados'], bold: false, alignment: 'center' },
						{ text: array_reporte['laboratorio_clan']['total'], bold: false, alignment: 'center' },
					],
					[
						{ text: 'TOTAL', bold: false, alignment: 'right' },
						{ text: array_reporte['total']['pendientes'], bold: true, alignment: 'center' },
						{ text: array_reporte['total']['aprobados'], bold: true, alignment: 'center' },
						{ text: array_reporte['total']['rechazados'], bold: true, alignment: 'center' },
						{ text: array_reporte['total']['general'], bold: true, alignment: 'center' },
					],
				]
				}
			},
			'\nYo '+nombre_completo_usuario+', certifico que la información reportada en el presente formato es verdadera, correcta y corresponde exactamente a la creación y asignación de beneficiarios del programa CREA registrados en el Sistema Integrado de Formación (SIF) durante el mes de '+mes_reporte,
			texto_revision_informacion,
			{
				table: {
					widths: ['50%','50%'],
					body: [
					[
						{ image: datos_usuario['TX_Firma_Escaneada'],width: 150 },
						{ image: firma_firma_coordinador_crea,width: 150 },						
					],
					[
						{ text: '_____________________________________\n'+nombre_completo_usuario+'\nContratista - '+rol_usuario+'\nPrograma CREA- Formación y Creación Artística\nSubdirección de Formación Artística\nInstituto Distrital de las Artes - Idartes', bold: false },
						{ text: firma_coordinador_crea, bold: false }
					],
					]
				},
				layout: 'noBorders'
			}
			]};
			pdfMake.createPdf(contenido_reporte).open();
		}else{
			parent.mostrarAlerta('warning','Permisos insuficientes','Este reporte unicamente puede ser descargado por Responsable CREA y/o Asistente Administrativo CREA');
		}
	}

	function cargarDatosReporteDigitalMensual(){
		var mes = $("#SL_mes").val().length == 1 ? '0' + $("#SL_mes").val() : $("#SL_mes").val();
		var periodo = $("#SL_anio").val() + "-" + mes;
		var datos = {
			"funcion" : "consultarDatosReporteDigitalMensual",
			"p1" : {
				"periodo" : periodo,
				"id_usuario" : parent.idUsuario
			}
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			array_reporte = $.parseJSON(data);
		}).fail(function(result){
			console.log("Error: "+result);
		});
	}
});