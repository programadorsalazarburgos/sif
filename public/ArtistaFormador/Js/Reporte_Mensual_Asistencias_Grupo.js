var url_ok_obj = '../../src/ArtistaFormador/ReporteMensualController/';
var datos_array_reporte_mensual = "";
var anio_mes_dia = parent.getFechaYHoraServidor().substring(0,10);

$(function(){
	pdfMake.fonts = {
		arial: {
			normal: 'arial.ttf',
			bold: 'arialbd.ttf',
			italics: 'ariali.ttf',
			bolditalics: 'arialbi.ttf'
		},
		Roboto: {
			normal: 'Roboto-Regular.ttf',
			bold: 'Roboto-Medium.ttf',
			italics: 'Roboto-Italic.ttf',
			bolditalics: 'Roboto-MediumItalic.ttf' 
		},
		ArialOl: {
			normal: 'ARIAOTL.TTF',
			bold: 'ARIAOTL.TTF',
			italics: 'ARIAOTL.TTF',
			bolditalics: 'ARIAOTL.TTF' 
		}
	}
	if(parent.idRol != 1){
		$("#nuevo_reporte_link").hide();
	}
	
	if(parent.idRol != 18 && parent.idUsuario != 2138 && parent.idUsuario != 2591 && parent.idUsuario != 3009 && parent.idUsuario != 1924 && parent.idUsuario != 3006 && parent.idUsuario != 2123 && parent.idUsuario != 1258 && parent.idUsuario != 3124 && parent.idUsuario != 1944 && parent.idUsuario != 3125 && parent.idUsuario != 388){ //Si NO son los usuarios administradores NI usuarios del Equipo SED ocultar el filtro de búsqueda.
		$("#div_filtros").hide();
	}
	
	$("#nuevo_reporte_link").click(function(){
		$("#TX_mes").datepicker({
			format: "yyyy-mm",
			language: 'es',
			startDate: new Date(' 2021-3-1'),
			endDate: new Date(anio_mes_dia),
			viewMode: "months",
			minViewMode: "months",
		}).on('changeDate', function (ev) {
			$("#TX_mes").val(ev.format(0,"yyyy-mm"));
			datos = {
				'p1': {
					'mes': ev.format(0,"yyyy-mm"),
					'id_usuario': parent.idUsuario
				}
			};
			// $.ajax({
			// 	url: url_ok_obj+'consultarGruposRegistroMiAsistenciaMes',
			// 	type: 'POST',
			// 	data: datos,
			// 	async: false
			// }).done(function(data){
			// 	console.log(data);
			// 	if(data=="0"){
			// 		parent.mostrarAlerta("info","Sin Registros","No hay ninguna sesión de clase registrada para el mes seleccionado");
			// 		$("#div_nuevo_reporte").html("");
			// 		$("#SL_grupo").html("").selectpicker("refresh");
			// 		$("#SL_organizacion").html("").selectpicker("refresh");
			// 	}
			// 	else{
			// 		$("#SL_grupo").html(data).selectpicker("refresh").trigger("change");
			// 	}
			// }).fail(function(result){
			// 	console.log("Error: "+result);
			// });
		});
		setTimeout(function(){
			$("#TX_mes").datepicker("show");
		}, 7);
	});

	$("#SL_Year").html(parent.getOptionParametroDetalle(7)).selectpicker("refresh");
	$("#SL_Linea_Atencion").html(parent.getOptionsLineasAtencion()).selectpicker("refresh");
	$("#SL_artista_formador").html(parent.getOptionsArtistasFormadores(false)).selectpicker("refresh");

	$("#SL_Linea_Atencion, #SL_Year").on('change', function(){
		$("#SL_Convenio").html(parent.getOptionsConveniosByLineaAtencionYear($("#SL_Linea_Atencion").val(), $("#SL_Year").val())).selectpicker("refresh");
		if($("#SL_Linea_Atencion").val() != "arte_escuela"){
			$("#SL_Colegio").val("").selectpicker("refresh");
			$("#SL_Colegio").attr('disabled',true).selectpicker("refresh");
		}
		else{
			$("#SL_Colegio").attr('disabled',false).selectpicker("refresh");
		}
	});

	$("#SL_Year, #SL_Convenio").on('change', function(){
		$("#SL_Colegio").html(parent.getOptionsColegiosConvenio($("#SL_Convenio").val(), $("#SL_Year").val())).selectpicker("refresh");
	});

	$('#SL_grupo').on('change', function(e){
		datos = {
			'p1': {
				'fecha_mes': $("#TX_mes").val(),
				'id_usuario': parent.idUsuario,
				'id_grupo': $("#SL_grupo").val(),
				'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo')
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarOrganizacionSesionClaseMesGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#SL_organizacion").html(data).selectpicker("refresh").trigger("change");
		});
	});

	$("#SL_organizacion").on('change', function(e){
		if(!existeReportePeriodo()){
			$("#div_nuevo_reporte").html(cargarFormularioInforme());
			var datos = {
				'p1': {
					'fecha_mes': $("#TX_mes").val(),
					'id_usuario': parent.idUsuario,
					'id_grupo': $("#SL_grupo").val(),
					'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
					'id_organizacion': $("#SL_organizacion").val(),
					'en_grupo' : 0
				}
			};
			cargarDatosReporteGrupo(datos,'nuevo');
		}else{
			$("#div_nuevo_reporte").html("");
			parent.mostrarAlerta("warning","Ya existe reporte","Ya existe un reporte para el mes y grupo seleccionado. Por favor seleccione otro grupo o verifique en la pestaña LISTADO.");
		}
	});

	$('#bt_consultar_filtros_generales').on('click', function(e){
		var year = $("#SL_Year").val();
		var linea_atencion = $("#SL_Linea_Atencion").val();
		var convenio = $("#SL_Convenio").val();
		var colegio = $("#SL_Colegio").val();
		if(year == "" || linea_atencion == "" || (linea_atencion == "arte_escuela" && colegio == "") || convenio == ""){
			parent.mostrarAlerta("warning","Filtros incompletos","Debe diligenciar todos los filtros.");
		}
		else{
			datos = {
				'p1': {
					'year': year,
					'linea_atencion': linea_atencion,
					'convenio': convenio,
					'colegio': colegio,
				}
			};
			$.ajax({
				url: url_ok_obj + 'consultarReportesAprobadosFiltros',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				$("#div_table_listado_informes").html(data);
				$("#table_listado_informes").DataTable({
					responsive: false,
					"order": [[ 2, "desc" ]],
					"language": {
						"lengthMenu": "Ver _MENU_ registros por pagina",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando pagina _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtered from _MAX_ total records)",
						"search": "Filtrar"
					}
				}).draw(); 
			}).fail(function(){
				parent.mostrarAlerta("error","No se logró consultar los reportes","Ocurrió un error al intentar consultar el listado de reportes.");
			});
		}
	});

	$('#bt_consultar_artista_formador').on('click', function(e){
		if($("#SL_artista_formador").val()==""){
			parent.mostrarAlerta("warning","Búsqueda por Artista Formador","Debe seleccionar el Artista Formador");
		}
		else{
		datos = {
			'p1': {
				'id_formador': $("#SL_artista_formador").val()
			}
		};
		$.ajax({
			url: url_ok_obj + 'consultarReportesAprobadosArtistaFormador',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#div_table_listado_informes").html(data);
			$("#table_listado_informes").DataTable({
				responsive: false,
				"order": [[ 2, "desc" ]],
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			}).draw(); 
		}).fail(function(){
			parent.mostrarAlerta("error","No se logró consultar los reportes","Ocurrió un error al intentar consultar el listado de reportes.");
		});
	}
	});
	
	$("#div_nuevo_reporte").delegate("#BT_enviar_para_revision","click",function(e){
		parent.swal({
			title: '¿Desea enviar el reporte para revisión?',
			text: "Se enviarán a revisión únicamente los datos existentes hasta éste momento en el reporte.",
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#3085d6',
			cancelButtonText: 'No estoy seguro',
			confirmButtonText: 'Enviar',
		}).then(function(){
			var datos = {
				p1: datos_array_reporte_mensual
			};
			$.ajax({
				url: url_ok_obj+'guardarReporteMensualRevision',
				type: 'POST',
				data: datos,
				async: true,
				beforeSend : function(){
					$("#BT_enviar_para_revision").attr("disabled","disabled");
				}
			}).done(function(data){
				$("#TX_mes").datepicker("update", "");
				$("#SL_grupo").html("").selectpicker("refresh");
				$("#SL_organizacion").html("").selectpicker("refresh");
				$("#div_nuevo_reporte").html("");
				parent.mostrarAlerta("success","Enviado","Se ha enviado el reporte al Responsable CREA para la verificación.");
				$("#listado_link").trigger("click");
				var texto_notificacion = "El artista " + datos_array_reporte_mensual.datos_basicos.nombre_artista + " ha enviado el reporte mensual de asistencia del grupo " + datos_array_reporte_mensual.datos_basicos.nombre_grupo + " para revisión.";
				var notificacion = { 
					VC_Url:"ArtistaFormador/Reporte_Mensual_Asistencias_Grupo.php?option_ext=informe_enviado&id_informe=" + 1,
					VC_Icon:"fa-2x fas fa-clipboard-check", 
					VC_Contenido: texto_notificacion,
					userId: datos_array_reporte_mensual.datos_basicos.id_coordinador_crea,
				}
				window.parent.sendNotificationUser(notificacion);
				$("#BT_enviar_para_revision").removeAttr("disabled");
			}).fail(function(result){
				console.log("Error: "+result);
			});
		}, function(dismiss){
			console.log("Cancelada la promesa");
			return false;
		});
	}).delegate("#BT_modificar_datos_informe","click",redirigirARegistroAsistencias);

	$("#listado_link").click(function(ev){
		if(parent.idRol != 3 && parent.idRol != 4 && parent.idUsuario != 1987){	// Si no es Responsable CREA o usuario supervisor de convenio SEC
			datos = {
				'p1': {
					'id_usuario': parent.idUsuario
				}
			};
			var url_ok_obj_listado = url_ok_obj + 'consultarMisReportes'
		}else{
			datos = {
				'p1': {
					'id_usuario': parent.idUsuario
				}
			};
			var url_ok_obj_listado = url_ok_obj + 'consultarReportesPorRevisar'
		}
		$.ajax({
			url: url_ok_obj_listado,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#div_table_listado_informes").html(data);
			$("#table_listado_informes").DataTable({
				responsive: false,
				"order": [[ 2, "asc" ]],
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			}).draw(); 
		}).fail(function(){
			parent.mostrarAlerta("error","No se pudo consultar reportes","Ocurrió un error al intentar consultar el listado de reportes.");
		});
	}).trigger("click");

	$("#div_table_listado_informes").delegate(".btn_modal_reporte","click",function(ev){
		var id_informe = $(this).data("id_informe");
		$("#cerrar_modal_novedad").data("id_informe",id_informe);
		var tipo_visualizacion = $(this).data("tipo_visualizacion");
		$("#div_modal_reporte").html(cargarFormularioInforme());
		switch(tipo_visualizacion){
			case 'corregir':
			datos = {
				'p1': {
					'fecha_mes': $(this).data('fecha_reporte'),
					'id_usuario': parent.idUsuario,
					'id_grupo': $(this).data('id_grupo'),
					'tipo_grupo': $(this).data('tipo_linea_atencion'),
					'id_organizacion': $(this).data('id_organizacion'),
					'en_grupo' : 0
				}
			};
			cargarDatosReporteGrupo(datos,'corregir',id_informe);
			break;
			case 'consulta':
			case 'revisar':
			datos = {
				'p1': {
					'id_informe': id_informe
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarJSONReporte',
				type: 'POST',
				data: datos,
				async: true
			}).done(function(data){
				try{
					data = $.parseJSON(data)[0]['TX_json'];
					data = $.parseJSON(data);
					establecerDatosHTMLReporte(data,tipo_visualizacion,id_informe);
				}catch(ex){
					console.log(ex);
					parent.mostrarAlerta("error","Fallo decodificar JSON","El sistema no ha podido decodificar los datos del reporte, por favor intente nuevamente y si el problema persiste comuniquese con soporte.");
				}
			}).fail(function(result){
				parent.mostrarAlerta("Error","No se pudó cargar reporte","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte");
				console.log(result);
			});
			break;
			default:
			console.log("opción no valida");
			break;
		}
	});

	$("#div_table_listado_informes").delegate(".descargar_pdf","click",function(e){
		var id_informe = $(this).data("id_informe");
		datos = {
			'p1': {
				'id_informe': id_informe
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarJSONReporte',
			type: 'POST',
			data: datos,
			async: true
		}).done(function(data){
			try{
				var firma = $.parseJSON(data)[0]['TX_Firma_Escaneada'];
				if(firma != null){
					data = $.parseJSON(data)[0]['TX_json'];
					data = $.parseJSON(data);
					generarReportePDF(data,id_informe, firma);
				}
				else{
					parent.mostrarAlerta("warning", "El PDF no pudo ser generado", "Aún no ha cargado su firma al sistema, por favor dirígase a la opción 'PERFIL DE USUARIO' ubicado en la parte superior derecha de la pantalla para cargarla.");
				}
			}catch(ex){
				console.log(ex);
				parent.mostrarAlerta("error","Fallo decodificar JSON","El sistema no ha podido decodificar los datos del reporte, por favor intente nuevamente y si el problema persiste comuniquese con soporte.");
			}
		}).fail(function(result){
			parent.mostrarAlerta("Error","No se pudó cargar reporte","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte");
			console.log(result);
		});
	});

	$("#div_table_listado_informes").delegate(".ver_anexos","click",function(e){
		var id_informe = $(this).data("id_informe");
		var fecha_reporte = $(this).data("fecha_reporte");
		var id_grupo = $(this).data("id_grupo");
		var tipo_linea_atencion = $(this).data("tipo_linea_atencion");
		var linea_atencion_acronimo = {
			'arte_escuela' : 'AE',
			'emprende_clan' : 'IC',
			'laboratorio_clan' : 'CV'
		};
		$("#modal_ver_anexos_title").html("Anexos Grupo:"+linea_atencion_acronimo[tipo_linea_atencion]+"-"+id_grupo+" Periodo:"+fecha_reporte);
		$("#modal_ver_anexos").modal("show");

		datos = {
			'p1': {
				'id_informe': id_informe
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarJSONReporte',
			type: 'POST',
			data: datos,
			async: true
		}).done(function(data){
			try{
				data = $.parseJSON(data)[0]['TX_json'];
				data = $.parseJSON(data);
				var detallado_sesiones_clase = "";
				$.each( data['detallado_sesiones_clase'], function(k,v){
					detallado_sesiones_clase += "<tr>";
					detallado_sesiones_clase += "<td>" + v['fecha_clase'] + "</td>";
					detallado_sesiones_clase += "<td align='center'>"+ ((v['VC_anexo'] == null || v['VC_anexo'] == "")?'<span class="badge badge-danger">Sin anexo</span>':'<button title="Descargar Anexo" type="button" class="btn btn-info descargar_anexo" data-vc_anexo="'+v['VC_anexo']+'?v='+(Math.floor(Math.random() * 100) + 1)+'"><span class="glyphicon glyphicon glyphicon-save-file" aria-hidden="true"></span></button>') + "</td>";
					detallado_sesiones_clase += "<td>" + v['observaciones'] + "</td>";
					detallado_sesiones_clase += "</tr>";
				});
				$("#tbody_listado_anexos").html(detallado_sesiones_clase).delegate(".descargar_anexo","click",function(){
					const url_anexo=$(this).data('vc_anexo')
					const url_actual = window.location.href
					let indice = url_actual.indexOf("public")
					let extraida = url_actual.substring(0, indice)
					const url_final=extraida+'uploadedFiles/'+url_anexo
					var win = window.open(url_final, '_blank')
					win.focus()
				});
			}catch(ex){
				console.log(ex);
				parent.mostrarAlerta("error","Falló al decodificar datos del reporte","El sistema no ha podido decodificar los datos del reporte, por favor intente nuevamente y si el problema persiste comuniquese con soporte.");
			}
		}).fail(function(result){
			parent.mostrarAlerta("Error","No se pudó cargar reporte","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte");
			console.log(result);
		});
	});

	$("#div_modal_reporte").delegate("#BT_rechazar_informe","click",function(e){
		var id_informe = $(this).data("id_informe");
		var texto_rechazo = "";
		parent.alertify.prompt( 'Causa del rechazo', 'Especifique el brevemente la causa del rechazo', 'X'
			, function(evt, value) {
				texto_rechazo = value;
				var datos = {
					'p1' : {
						'texto_rechazo': texto_rechazo,
						'id_informe': id_informe,
						'id_usuario': parent.idUsuario
					}
				};
				$.ajax({
					url: url_ok_obj+'rechazarReporte',
					type: 'POST',
					data: datos,
					async: false
				}).done(function(data){
					if (data == 1) {
						parent.mostrarAlerta("success","Guardado","Se ha rechazado este reporte correctamente por la razón: " + texto_rechazo);
						var texto_notificacion = "Se ha rechazado el reporte mensual de asistencia para el grupo " + datos_array_reporte_mensual.datos_basicos.nombre_grupo + " del " + datos_array_reporte_mensual.datos_basicos.nombre_crea;
						var notificacion = { 
							VC_Url:"ArtistaFormador/Reporte_Mensual_Asistencias_Grupo.php?option_ext=informe_rechazado&id_informe=" + id_informe + "&texto_rechazo=" + texto_rechazo,
							VC_Icon:"fa-2x fas fa-exclamation-triangle", 
							VC_Contenido: texto_notificacion,
							userId: datos_array_reporte_mensual.datos_basicos.id_usuario,
						}
						window.parent.sendNotificationUser(notificacion);
					}else{
						parent.mostrarAlerta("warning","Advertencia","Al parecer no se pudo modificar el estado del reporte, por favor verifique.");
					}
					$("#modal_informe_mensual").modal("hide");
					$("#listado_link").trigger("click");
				}).fail(function(result){
					console.log("Error: "+result);
					parent.mostrarAlerta("error","Error","No se pudo rechazar el reporte");
				});
			}
			, function() { parent.alertify.error('Cancelado') });
	}).delegate("#BT_aprobar_informe","click",function(e){
		var id_informe = $(this).data("id_informe");
		parent.swal({
			title: 'Ud acepta que ha corroborado la información y esta es correcta.',
			text: "Se cambiará el estado del reporte a aprobado y se permitirá la impresión al artista formador\n¿Desea aprobar el reporte?",
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#3085d6',
			cancelButtonText: 'No estoy seguro',
			confirmButtonText: 'Sí, aprobar',
		}).then(function(){
			var datos = {
				'p1' : {
					'id_informe': id_informe,
					'id_usuario': parent.idUsuario
				}
			};
			$.ajax({
				url: url_ok_obj+'aprobarReporte',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				if (data == 1) {
					parent.mostrarAlerta("success","Guardado","Se ha aprobado este reporte correctamente.");
					var texto_notificacion = "Se ha aprobado el reporte mensual de asistencia para el grupo " + datos_array_reporte_mensual.datos_basicos.nombre_grupo + " del " + datos_array_reporte_mensual.datos_basicos.nombre_crea;
					var notificacion = { 
						VC_Url:"ArtistaFormador/Reporte_Mensual_Asistencias_Grupo.php?option_ext=informe_aprobado&id_informe=" + id_informe,
						VC_Icon:"fa-2x fas fa-clipboard-check", 
						VC_Contenido: texto_notificacion,
						userId: datos_array_reporte_mensual.datos_basicos.id_usuario,
					}
					window.parent.sendNotificationUser(notificacion);
				}else{
					parent.mostrarAlerta("warning","Advertencia","Al parecer no se pudo modificar el estado del reporte, por favor verifique.");
				}
				$("#modal_informe_mensual").modal("hide");
				$("#listado_link").trigger("click");
			}).fail(function(result){
				console.log("Error: "+result);
				parent.mostrarAlerta("error","Error","No se pudo rechazar el reporte");
			});
		}, function(dismiss){
			console.log("Cancelada la promesa de aprobar");
			return false;
		});
	}).delegate("#BT_enviar_corregido","click",function(ev){
		var id_informe = $(this).data("id_informe");
		parent.swal({
			title: 'Se enviará nuevamente el reporte para verificación',
			text: "¿Acepta que ha realizado los cambios solicitados por el supervisor?",
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#3085d6',
			cancelButtonText: 'No estoy seguro',
			confirmButtonText: 'Sí, enviar',
		}).then(function(){
			var datos = {
				'p1' : {
					'id_informe': id_informe,
					'id_usuario': parent.idUsuario,
					'datos_array_reporte_mensual': datos_array_reporte_mensual
				}
			};
			$.ajax({
				url: url_ok_obj+'enviarReporteCorregido',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				if (data == 1) {
					parent.mostrarAlerta("success","Guardado","Se ha enviado el reporte corregido nuevamente para su aprobación.");
					var texto_notificacion = "El artista " + datos_array_reporte_mensual.datos_basicos.nombre_artista + " ha corregido el reporte mensual de asistencia del grupo " + datos_array_reporte_mensual.datos_basicos.nombre_grupo;
					var notificacion = { 
						VC_Url:"ArtistaFormador/Reporte_Mensual_Asistencias_Grupo.php?option_ext=informe_rechazado&id_informe=" + id_informe,
						VC_Icon:"fa-2x fab fa-angellist", 
						VC_Contenido: texto_notificacion,
						userId: datos_array_reporte_mensual["datos_basicos"]["id_coordinador_crea"],
					}
					window.parent.sendNotificationUser(notificacion);
				}else{
					parent.mostrarAlerta("warning","Advertencia","Al parecer no se pudo modificar el estado del reporte, por favor verifique.");
				}
				$("#modal_informe_mensual").modal("hide");
				$("#listado_link").trigger("click");
			}).fail(function(result){
				console.log("Error: "+result);
				parent.mostrarAlerta("error","Error","No se pudo enviar el reporte corregido para verificar.");
			});
		}, function(dismiss){
			console.log("Cancelada la promesa de aprobar");
			return false;
		});
	}).delegate("#BT_corregir_novedades","click",function(ev){
		var id_grupo = $(this).data("id_grupo");
		var tipo_grupo = $(this).data("tipo_grupo");
		var mes_reporte = $(this).data("mes_reporte");
		var id_crea = $(this).data("id_crea");
		var id_artista_formador = $(this).data("id_artista_formador");
		$("#modal_informe_mensual").modal("hide");
		$("#modal_corregir_novedad").modal("show");
		$("#modal_corregir_novedad_title").text("Agregar nueva novedad al mes");
		$("#div_modal_corregir_novedad").html("<select class='form-control selectpicker' id='SL_novedad' data-live-search='true'></select>Asistencia del formador: <input class='form-control' data-toggle='toggle' data-onstyle='primary' id= 'CH_asistencia' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' checked ><input type='text' readonly='readonly' placeholder='Día del mes' class='form-control' id='TX_novedad_dia'><textarea class='form-control' id='TX_observacion_novedad' placeholder='Observaciones'></textarea><input type='button' class='form-control btn btn-info' value='Guardar' id='BT_guardar_nueva_novedad'>");
		$("#SL_novedad").html(parent.getOptionsNovedades()).selectpicker("refresh");
		$("#CH_asistencia").bootstrapToggle();
		$("#TX_novedad_dia").datepicker({
			format: "yyyy-mm-dd",
			language: 'es',
			startDate: new Date(' 2020-3-1'),
			endDate: new Date(anio_mes_dia),
			viewMode: "days",
			minViewMode: "days",
		}).on('changeDate', function (ev) {
			$("#TX_novedad_dia").val(ev.format(0,"yyyy-mm-dd"));
		});
	}).delegate("#BT_modificar_datos_informe","click",redirigirARegistroAsistencias);

	$("#div_modal_corregir_novedad").delegate("#BT_guardar_nueva_novedad","click",function(ev){
		var id_novedad = $("#SL_novedad").val();
		var texto_novedad = $("#SL_novedad").find(':selected').text()
		var fecha_novedad = $("#TX_novedad_dia").val();
		var observacion_novedad = $("#TX_observacion_novedad").val();
		if(fecha_novedad == "" ){
			parent.mostrarAlerta("warning","Advertencia","Debe diligenciar todos los campos");
		}else{
			var id_informe = $("#cerrar_modal_novedad").data('id_informe');
			var datos = {
				'p1' : {
					'id_usuario':parent.idUsuario,
					'fecha_novedad': fecha_novedad,
					'asistencia': (($("#CH_asistencia").prop('checked')?1:0)),
					'id_novedad': id_novedad,
					'texto_novedad':texto_novedad,
					'observacion': observacion_novedad,
					'id_artista_formador': datos_array_reporte_mensual.datos_basicos.id_usuario,
					'id_grupo': datos_array_reporte_mensual.datos_basicos.id_grupo,
					'tipo_grupo':datos_array_reporte_mensual.datos_basicos.tipo_grupo
				}
			};
			$.ajax({
				url: url_ok_obj+'registrarNuevaNovedad',
				type: 'POST',
				dataType: 'html',
				data: datos,
				async: false
			}).done(function(data){
				$("#modal_corregir_novedad").modal("hide");
				setTimeout(function() {
					$("#modal_informe_mensual").modal("show");
				}, 500);
				var nueva_novedad = {
					'id':data,
					'DA_fecha_sesion_clase':fecha_novedad,
					'IN_asistencia':(($("#CH_asistencia").prop('checked')?1:0)),
					'IN_novedad': id_novedad,
					'novedad_texto' : texto_novedad,
					'TX_observacion': observacion_novedad
				};
				if(!datos_array_reporte_mensual.detallado_novedades){
					datos_array_reporte_mensual.detallado_novedades = [];
					datos_array_reporte_mensual.detallado_novedades[0] = nueva_novedad;
				}else{
					datos_array_reporte_mensual.detallado_novedades.push(nueva_novedad);
				}
				var datos = {
					'p1' : {
						'id_informe': id_informe,
						'id_usuario': parent.idUsuario,
						'datos_array_reporte_mensual': datos_array_reporte_mensual
					}
				};
				$.ajax({
					url: url_ok_obj+'enviarReporteCorregido',
					type: 'POST',
					data: datos,
					async: false
				}).done(function(data){
					if(data == 1){
						establecerDatosHTMLReporte(datos_array_reporte_mensual,"revisar",id_informe);
					}else{
						parent.mostrarAlerta("warning","Advertencia","Al parecer no se pudo guardar la novedad para la actualización del reporte.")
					}
				});
			}).fail(function(result){
				console.log("Error: "+result);
				parent.mostrarAlerta("error","No se pudo guardar la novedad","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte");
			});
		}
	}).delegate("#BT_guardar_edicion_novedad","click",function(ev){
		var id_novedad = $(this).data('id_novedad');
		var id_tipo_novedad = $("#SL_novedad").val();
		var texto_novedad = $("#SL_novedad").find(':selected').text()
		var asistencia_formador = ($("#CH_asistencia").prop('checked')?1:0);
		var fecha_novedad = $("#TX_novedad_dia").val();
		var observacion_novedad = $("#TX_observacion_novedad").val();
		if(fecha_novedad == "" ){
			parent.mostrarAlerta("warning","Advertencia","Debe diligenciar todos los campos");
		}else{
			var id_informe = $("#cerrar_modal_novedad").data('id_informe');
			var datos_actualizar = {
				'p1' : {
					'id_usuario':parent.idUsuario,
					'id_novedad':id_novedad,
					'fecha_novedad': fecha_novedad,
					'asistencia': asistencia_formador,
					'id_tipo_novedad': id_tipo_novedad,
					'texto_novedad':texto_novedad,
					'observacion': observacion_novedad,
					'id_artista_formador': datos_array_reporte_mensual.datos_basicos.id_usuario,
					'id_grupo': datos_array_reporte_mensual.datos_basicos.id_grupo,
					'tipo_grupo':datos_array_reporte_mensual.datos_basicos.tipo_grupo
				}
			};
			$.ajax({
				url: url_ok_obj+'actualizarNovedad',
				type: 'POST',
				dataType: 'html',
				data: datos_actualizar,
				async: false
			}).done(function(data){
				if (data == 1) {
					var datos_reporte_actualizar_sesion = {
						'p1': {
							'fecha_mes': datos_array_reporte_mensual.datos_basicos.mes_reporte,
							'id_usuario': datos_array_reporte_mensual.datos_basicos.id_usuario,
							'id_grupo': datos_array_reporte_mensual.datos_basicos.id_grupo,
							'tipo_grupo': datos_array_reporte_mensual.datos_basicos.tipo_grupo,
							'id_organizacion': datos_array_reporte_mensual.datos_basicos.id_organizacion,
							'en_grupo' : 0
						}
					};
					cargarDatosReporteGrupo(datos_reporte_actualizar_sesion,'eliminar_novedad',datos.p1.id_informe);
					parent.mostrarAlerta("success","Exito","Se ha actualizado la novedad de forma exitosa");
				}else{
					console.log(data);
				}
			}).fail(function(data){
				parent.mostrarAlerta("error","No se pudo guardar la novedad","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte");
				console.log(data);
			});
			$("#modal_corregir_novedad").modal("hide");
			setTimeout(function() {
				$("#modal_informe_mensual").modal("show");
			}, 500);
		}
	});

	function cargarFormularioInforme(){
		var html_informe = "";
		$.ajax({
			url: url_ok_obj+'consultarFormularioReporteMensual',
			type: 'POST',
			dataType: 'html',
			async: false
		}).done(function(data){
			html_informe += data;
		}).fail(function(result){
			console.log("Error: "+result);
			parent.mostrarAlerta("error","No se pudo cargar reporte","Por favor recargue el sitio e intente de nuevo. Si el problema persiste comuniquese con soporte");
			html_informe += "Error";
		});
		return html_informe;
	}

	function existeReportePeriodo(){
		var existe = false;
		datos = {
			'p1': {
				'fecha_mes': $("#TX_mes").val(),
				'id_usuario': parent.idUsuario,
				'id_grupo': $("#SL_grupo").val(),
				'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
				'id_organizacion': $("#SL_organizacion").val()
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarexistenciaReporteMes',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data == 1){
				existe = true;
			}
		}).fail(function(){
			parent.mostrarAlerta("error","No se pudo verificar existencia","Ocurrió un error al intentar verificar si ya existe un reporte con estos parametros.");
		});
		return existe;
	}

	function establecerDatosHTMLReporte (data, tipo_accion, id_informe=0){
		dr = data;
		data = null;
		var id_elementos = "";
		setTimeout(function(){
			if(tipo_accion != 'nuevo'){
				id_elementos = "#modal_informe_mensual ";
			}
			$(id_elementos+".SPAN_nombre_artista").text(dr['datos_basicos']['nombre_artista']);
			$(id_elementos+"#SPAN_identificacion_artista").text(dr['datos_basicos']['VC_Identificacion']);
			$(id_elementos+"#SPAN_correo_artista").text(dr['datos_basicos']['VC_Correo']);
			if(dr['datos_basicos']['convenio'] === undefined){
				dr['datos_basicos']['convenio'] = '';
			}
			$(id_elementos+"#SPAN_nombre_grupo").text(dr['datos_basicos']['nombre_grupo']+dr['datos_basicos']['convenio']);
			$(id_elementos+"#SPAN_linea_atencion").text(dr['datos_basicos']['linea_atencion']);
			$(id_elementos+"#SPAN_mes_reporte").text(dr['datos_basicos']['mes_reporte']);
			$(id_elementos+"#SPAN_organizacion").text(dr['datos_basicos']['nombre_organizacion']);
			$(id_elementos+"#SPAN_nombre_colegio").text(dr['datos_basicos']['nombre_colegio']);
			$(id_elementos+"#SPAN_area_artistica").text(dr['datos_basicos']['nombre_area_artistica']);
			$(id_elementos+"#SPAN_nombre_coordinador_crea").text(dr['datos_basicos']['nombre_coordinador_crea']);

			$(id_elementos+"#SPAN_total_horas_sesion_clase").text(dr['total_horas_sesiones_clase']);
			$(id_elementos+"#SPAN_total_horas_sesion_evento").text(dr['total_horas_sesiones_evento']);

			var detallado_sesiones_clase_y_eventos = "";
			var i = 1;
			let es_suplencia = false;
			$.each( dr['detallado_sesiones_clase'], function(k,v){
				detallado_sesiones_clase_y_eventos += "<tr>";

				detallado_sesiones_clase_y_eventos += "<td align='center'>" + (i++) + ((v['VC_anexo'] == null || v['VC_anexo'] == "")?'':'<button title="Ver Anexo" type="button" class="btn btn-info descargar_anexo" data-vc_anexo="'+v['VC_anexo']+'?v='+(Math.floor(Math.random() * 100) + 1)+'"><span class="glyphicon glyphicon glyphicon-save-file" aria-hidden="true"></span></button>') + "</td>";
				detallado_sesiones_clase_y_eventos += "<td>" + v['fecha_clase'] + "</td>";
				if(v['lugar_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['lugar_atencion'] + "</td>";
				}
				if(v['tipo_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['tipo_atencion'] + "</td>";
				}
				if(v['material'] === undefined || v['material'] === null){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['material'] + "</td>";
				}
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['horas_clase'] + "</td>";
				detallado_sesiones_clase_y_eventos += "<td>" + v['observaciones'] + "</td>";
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_matriculados'] + "</td>";
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_con_asistencia'] + "</td>";
				detallado_sesiones_clase_y_eventos += "</tr>";
				if(v['suplencia']==1){
					es_suplencia=true;
				}
			});

			if(es_suplencia){
				$("#span_suplencia").text('  -  SUPLENCIA')
			}

			$.each( dr['detallado_sesiones_evento'], function(k,v){
				detallado_sesiones_clase_y_eventos += "<tr>";
				detallado_sesiones_clase_y_eventos += "<td align='center'>EV-" + (i + 1) + "</td>";
				detallado_sesiones_clase_y_eventos += "<td>" + v['DA_fecha_sesion_clase'] + "</td>";
				if(v['lugar_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['lugar_atencion'] + "</td>";
				}
				if(v['tipo_atencion'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['tipo_atencion'] + "</td>";
				}
				if(v['material'] === undefined){
					detallado_sesiones_clase_y_eventos += "<td align='center'></td>";
				}
				else{
					detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['material'] + "</td>";
				}
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['horas_clase'] + "</td>";
				detallado_sesiones_clase_y_eventos += "<td>" + v['TX_observaciones'] + "</td>";
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_matriculados'] + "</td>";
				detallado_sesiones_clase_y_eventos += "<td align='center'>" + v['estudiantes_con_asistencia'] + "</td>";
				detallado_sesiones_clase_y_eventos += "</tr>";
			});

			$("#table_listado_sesiones tbody").html(detallado_sesiones_clase_y_eventos).delegate(".descargar_anexo","click",function(){
				const url_anexo=$(this).data('vc_anexo')
				const url_actual = window.location.href
				let indice = url_actual.indexOf("public")
				let extraida = url_actual.substring(0, indice)
				const url_final=extraida+'uploadedFiles/'+url_anexo
				var win = window.open(url_final, '_blank')
				win.focus()
			});

			var detallado_novedades = "";
			$.each( dr['detallado_novedades'], function(k,v){
				detallado_novedades += "<tr>";
				detallado_novedades += "<td align='center'>" + v['DA_fecha_sesion_clase'] + "</td>";
				detallado_novedades += "<td align='center'>" + (v['IN_asistencia']==0?'NO':'SÍ') + "</td>";
				detallado_novedades += "<td>" + v['novedad_texto'] + "</td>";
				detallado_novedades += "<td>" + v['TX_observacion'] + "</td>";
				if(tipo_accion == 'revisar'){
					detallado_novedades += "<td><a class='btn btn-info editar_novedad' data-id_novedad='" + v.id + "' data-fecha_novedad='" + v.DA_fecha_sesion_clase + "' data-asistencia_formador = '" + v.IN_asistencia + "' data-id_tipo_novedad = '" + v.IN_novedad + "' data-observacion='" + v.TX_observacion + "' data-tipo_grupo='"+dr.datos_basicos.tipo_grupo+"'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
					detallado_novedades += "<a class='btn btn-danger eliminar_novedad' data-id_novedad='" + v.id + "' data-tipo_grupo='"+dr.datos_basicos.tipo_grupo+"'><span class='glyphicon glyphicon-trash ' aria-hidden='true'></span></a></td>";
				}
				detallado_novedades += "</tr>";
			});

			$("#table_listado_novedades tbody").html(detallado_novedades).delegate(".editar_novedad","click",function(ev){
				var id_novedad =  $(this).data("id_novedad");
				var fecha_novedad = $(this).data("fecha_novedad");
				var asistencia_formador =  $(this).data("asistencia_formador");
				var id_tipo_novedad =  $(this).data("id_tipo_novedad");
				var observacion =  $(this).data("observacion");
				var tipo_grupo =  $(this).data("tipo_grupo");
				$("#modal_informe_mensual").modal("hide");
				$("#modal_corregir_novedad").modal("show");
				$("#div_modal_corregir_novedad").html("<select class='form-control selectpicker' id='SL_novedad' data-live-search='true'></select>Asistencia del formador: <input class='form-control' data-toggle='toggle' data-onstyle='primary' id= 'CH_asistencia' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' checked ><input type='text' readonly='readonly' placeholder='Día del mes' class='form-control' id='TX_novedad_dia'><textarea class='form-control' id='TX_observacion_novedad' placeholder='Observaciones'></textarea><input type='button' class='form-control btn btn-info' value='Actualizar' id='BT_guardar_edicion_novedad'>");
				$("#SL_novedad").html(parent.getOptionsNovedades()).val(id_tipo_novedad).selectpicker("refresh");
				$("#CH_asistencia").bootstrapToggle();
				if(asistencia_formador == 1){
					$("#CH_asistencia").bootstrapToggle('on');
				}else{
					$("#CH_asistencia").bootstrapToggle('off');
				}
				$("#BT_guardar_edicion_novedad").data('id_novedad',id_novedad);
				$("#TX_novedad_dia").datepicker({
					format: "yyyy-mm-dd",
					language: 'es',
					startDate: new Date(' 2020-3-1'),
					endDate: new Date(anio_mes_dia),
					viewMode: "days",
					minViewMode: "days",
				}).on('changeDate', function (ev) {
					$("#TX_novedad_dia").val(ev.format(0,"yyyy-mm-dd"));
				}).val(fecha_novedad);
				$("#TX_observacion_novedad").text(observacion);
				$("#modal_corregir_novedad_title").text("Editar novedad");
			}).delegate(".eliminar_novedad","click",function(ev){
				var id_novedad = $(this).data("id_novedad");
				var tipo_grupo = $(this).data("tipo_grupo");
				parent.swal({
					title: 'Eliminar Novedad',
					text: "¿Está seguro?",
					type: 'warning',
					showCancelButton: true,
					cancelButtonColor: '#d33',
					confirmButtonColor: '#3085d6',
					cancelButtonText: 'No estoy seguro',
					confirmButtonText: 'Sí, Eliminar',
				}).then(function(){
					var datos_eliminar = {
						'p1' : {
							'id_novedad' : id_novedad,
							'tipo_grupo' : tipo_grupo
						}
					};
					$.ajax({
						url: url_ok_obj+'eliminarNovedad',
						type: 'POST',
						data: datos_eliminar,
						async: false
					}).done(function(data){
						if(data == 1){
							parent.mostrarAlerta("success","Eliminado","Se ha eliminado la novedad.");
						}else{
							parent.mostrarAlerta("warning","Al parecer no se pudo eliminar","Por favor intente nuevamente.");
						}
						var datos_reporte_eliminar_sesion = {
							'p1': {
								'fecha_mes': datos_array_reporte_mensual.datos_basicos.mes_reporte,
								'id_usuario': datos_array_reporte_mensual.datos_basicos.id_usuario,
								'id_grupo': datos_array_reporte_mensual.datos_basicos.id_grupo,
								'tipo_grupo': datos_array_reporte_mensual.datos_basicos.tipo_grupo,
								'id_organizacion': datos_array_reporte_mensual.datos_basicos.id_organizacion,
								'en_grupo' : 0
							}
						};
						cargarDatosReporteGrupo(datos_reporte_eliminar_sesion,'eliminar_novedad',datos.p1.id_informe);
					}).fail(function(result){
						console.log("Error: "+result);
					});
				}, function(dismiss){
					console.log("Cancelada la promesa");
					return false;
				});
			});

			switch(tipo_accion){
				case 'nuevo':
					$("#div_botones").html("<p><div class='container'><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-warning form-control' id='BT_modificar_datos_informe' value='Modificar los datos'></div></div><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-success form-control' id='BT_enviar_para_revision' value='Enviar para revisión'></div></div><!--<div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-info form-control' id='BT_descargar_pre' value='Descargar parcial'></div></div>--></p>");
					datos_array_reporte_mensual = dr;
					break;
				case 'consulta' :
					$("#div_botones").html("<p class='alert alert-info'>Debe esperar la aprobación o rechazo del reporte para poder realizar su impresión o corrección.</p>");
					datos_array_reporte_mensual = dr;
					break;
				case 'revisar':
					$("#div_botones").html("<p class='alert alert-danger'>Si encuentra errores en la tabla de <b>novedades</b> y desea corregir por favor haga click aquí: <button type='button' class='btn btn-warning' id='BT_corregir_novedades' data-id_grupo='" + dr['datos_basicos']['id_grupo'] + "' data-tipo_grupo='" + dr['datos_basicos']['tipo_grupo'] + "' data-mes_reporte='" + dr['datos_basicos']['mes_reporte'] + "' data-id_crea='" + dr['datos_basicos']['id_crea'] + "' + data-id_artista_formador='" + dr['datos_basicos']['id_usuario'] + "'><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span></button></p>");
					$("#div_botones").append("<p><div class='container'><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-danger form-control' id='BT_rechazar_informe' value='Rechazar Reporte' data-id_informe='" + id_informe + "'></div></div><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-success form-control' id='BT_aprobar_informe' value='Aprobar Reporte' data-id_informe='" + id_informe + "'></div></div></p>");
					datos_array_reporte_mensual = dr;
					break;
				case 'corregir':
					$("#div_botones").html("<p class='alert alert-danger'>Si la corrección corresponde a la tabla de <b>novedades</b> debe realizarla directamente el <b>Responsable CREA.</b></p>");
					$("#div_botones").append("<p><div class='container'><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-warning form-control' id='BT_modificar_datos_informe' value='Corregir los datos'></div></div><div class='row'><div class='col-xs-8 col-xs-offset-2 col-lg-6 col-lg-offset-2'><input type='button' class='btn btn-success form-control' id='BT_enviar_corregido' value='Enviar reporte corregido' data-id_informe='" + id_informe + "'></div></div></p>");
					mostrarObservacionesInforme(id_informe);
					datos_array_reporte_mensual = dr;
					break;
				case 'eliminar_novedad':

					break;
				default:
					console.log(tipo_accion + "Desconocido.");
					break;
				}

				var detallado_asistencia_beneficiario = "<tr>";
				detallado_asistencia_beneficiario += "<th>Identificación</th>";
				detallado_asistencia_beneficiario += "<th>Nombre</th>";
				$.each( dr['detallado_sesiones_clase_participante'], function(k,v){
					detallado_asistencia_beneficiario += "<th>" + k.slice(-2) + "</th>";
				});
				detallado_asistencia_beneficiario += "</tr>";
				$.each( dr['listado_participantes'], function(k,v){
					detallado_asistencia_beneficiario += "<tr>";
					detallado_asistencia_beneficiario += "<td>" + v.documento + "</td>";
					detallado_asistencia_beneficiario += "<td>" + v.nombre + "</td>";
					$.each( dr['detallado_sesiones_clase_participante'], function(k1,v1){
						var asistencia_texto = "";
						switch(v1[v.id]){
							case '1':
							asistencia_texto = 'SÍ';
							break;
							case '0':
							asistencia_texto = 'NO';
							break;
							default:
							break;

						}
						// detallado_asistencia_beneficiario += "<td align='center'>" + ((asistencia_texto != '')?asistencia_texto:'N/R') + "</td>";
						detallado_asistencia_beneficiario += "<td align='center'>" + ((asistencia_texto != '')?asistencia_texto:'N0') + "</td>";
					});
					detallado_asistencia_beneficiario += "</tr>";
				});

				$("#table_listado_beneficiarios").html(detallado_asistencia_beneficiario);
		}, 77);
}

function mostrarObservacionesInforme(id_informe){
	var datos = {
		'p1': {
			'id_informe': id_informe
		}
	};
	$.ajax({
		url: url_ok_obj+'consultarJSONObservaciones',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		try{
			data = $.parseJSON(data)[0];
			parent.mostrarAlerta("warning","Observación",data["observacion"],'',10500);
		}catch(ex){
			console.log(ex);
			parent.mostrarAlerta("error","Error","No se ha podido decodificar el JSON de las observaciones");
		}
	}).fail(function(result){
		parent.mostrarAlerta("error","Error","No se ha podido consultar las observaciones realizadas al reporte");
		console.log("Error: "+result);
	});

}

function redirigirARegistroAsistencias(){
	parent.swal({
		title: "Redirigir a la actividad",
		text: "Será redirigido a la actividad de Registro/Eliminación y Modificación de Asistencias",
		type: "warning",
	}).then(function(isConfirm) {
		parent.$("#ventana_iframe").attr("src","../public/ArtistaFormador/Registrar_Asistencia_Grupo_Sesion_Clase.php");
	});
}

function cargarDatosReporteGrupo(datos,tipo_accion,id_informe=0){
	$.ajax({
		url: url_ok_obj+'consultarDatosNuevoReporteArtistaFormador',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		try{
			data = $.parseJSON(data);
			var linea_atencion_acronimo = {
				'arte_escuela' : 'AE',
				'emprende_clan' : 'IC',
				'laboratorio_clan' : 'CV'
			};
			var linea_atencion_nombre = {
				'arte_escuela' : 'Arte En La Escuela',
				'emprende_clan' : 'Impulso Colectivo',
				'laboratorio_clan' : 'Converge'
			};
			switch(tipo_accion){
				case 'nuevo':
					data['datos_basicos']['id_organizacion'] = $("#SL_organizacion").val();
					data['datos_basicos']['nombre_organizacion'] = $("#SL_organizacion").find(':selected').text();
					data['datos_basicos']['tipo_grupo'] = $("#SL_grupo").find(':selected').data('tipo_grupo');
					data['datos_basicos']['id_grupo'] = $("#SL_grupo").val();
					data['datos_basicos']['nombre_grupo'] = (linea_atencion_acronimo[data['datos_basicos']['tipo_grupo']] + "-" + data['datos_basicos']['id_grupo']);
					data['datos_basicos']['linea_atencion'] = linea_atencion_nombre[data['datos_basicos']['tipo_grupo']];
					data['datos_basicos']['mes_reporte'] = $("#TX_mes").val();
					break;
				case 'corregir':
					break;
				case 'eliminar_novedad':
					var datos_actualizar_json = {
						'p1' : {
							'id_informe' : id_informe
						},
						'p2' : data
					};
					$.ajax({
						url: url_ok_obj+'actualizarJSON',
						data: datos_actualizar_json,
						type: 'POST',	
						async: false
					}).done(function(data){
						if (data != 1){
					      console.log(data);
						}
						tipo_accion = 'revisar';
					}).fail(function(result){
					      parent.mostrarAlerta("warning","Al parecer no se actualizó JSON en DB","Probablemente hubo un error interno del servidor, por favor verifique nuevamente.")
					});
					
					break;
				default:
					break;
			}
			establecerDatosHTMLReporte(data,tipo_accion,id_informe);
		}catch(ex){
			console.log(ex);
			parent.mostrarAlerta("error","Fallo decodificar JSON","El sistema no ha podido decodificar los datos del reporte, por favor intente nuevamente y si el problema persiste comuniquese con soporte.");
		}
	}).fail(function(result){
		console.log("Error: "+result);
	});
}

$('iframe').ready(function(){
	var d = getUrlVars();
	if(d["option_ext"] == "actualizar_novedades_grupo"){
		$("#SL_crea").val(d['id_crea']).selectpicker("refresh").trigger("change");
		$("#SL_grupo").val(d['id_grupo']).selectpicker("refresh").trigger("change");
		$("#historial_novedades_tab").trigger("click");
		modificar_json_reporte_formador = true;
	}
});

function getUrlVars() {
	var vars = {};
	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
		vars[key] = value;
	});
	return vars;
}

function generarReportePDF(d,id_informe, firma_escaneada){
	let suplencia=false;
			// console.log(d);
			d.detallado_sesiones_clase.forEach(sesion => {
				if(sesion.suplencia==1){
					suplencia=true;
				}
			});
			var bodyDataSesion = [
			[
			{
				text: 'N° Sesión:',
				bold: true,
			},
			{
				text: 'Fecha Sesión',
				bold: true,

			},/*
			{
				text: 'Horas del Taller/Evento',
				bold: true,
			},*/
			{
				text: 'Observaciones',
				bold: true,

			},
			{
				text: 'Estudiantes Matriculados',
				bold: true,
			},
			{
				text: 'Estudiantes con asistencia',
				bold: true,

			}
			],
			];
			var bodyDataNovedad = [
			[
			{
				text: 'Fecha Sesión',
				bold: true,
			},
			{
				text: 'Asistencia',
				bold: true,

			},
			{
				text: 'Novedad',
				bold: true,
			},
			{
				text: 'Observación',
				bold: true,

			},
			],
			];

			try{
				console.log(d);
				if(d['detallado_sesiones_clase'] != undefined){
					var dt = d['detallado_sesiones_clase'];
					var i = 1;
					dt.forEach(function(df) {
						var dataRow = [];
						dataRow.push(i++);
						dataRow.push(df.fecha_clase);
						// dataRow.push(df.horas_clase);
						dataRow.push(df.observaciones);
						dataRow.push(df.estudiantes_matriculados);
						dataRow.push(df.estudiantes_con_asistencia);
						bodyDataSesion.push(dataRow)
					});
				}
			}catch(ex){
				console.log(ex);
			}

			try{
				if(d['detallado_sesiones_evento'] != undefined){
					var dt = d['detallado_sesiones_evento'];
					i = 1;
					dt.forEach(function(df) {
						var dataRow = [];
						dataRow.push('EV-'+(i++));
						dataRow.push(df.DA_fecha_sesion_clase);
						// dataRow.push(df.horas_clase);
						dataRow.push(df.observaciones);
						dataRow.push(df.estudiantes_matriculados);
						dataRow.push(df.estudiantes_con_asistencia);
						bodyDataSesion.push(dataRow)
					});
				}
			}catch(ex){
				console.log("Al parecer no hay registros de sesiones en evento." + ex);
			}

			try{
				var dt = d['detallado_novedades'];
				dt.forEach(function(df) {
					var dataRow = [];
					dataRow.push(df.DA_fecha_sesion_clase);
					dataRow.push(df.IN_asistencia);
					dataRow.push(df.IN_novedad);
					dataRow.push(df.TX_observacion);
					bodyDataNovedad.push(dataRow)
				});
			}catch(ex){
				console.log(ex);
			}
			var horizontal = generarReportePDFHorizontal(d);
			console.log(horizontal, "sddd");
			var dd = {
				"pageOrientation":"portrait",
				watermark: {text: 'APROBADO', color: 'gray', opacity: 0.777, bold: true, italics: false,marginX:0,marginY:60,font: 'ArialOl'},
				content : [
				{
					style: 'tableExample',
			        table: { // Encabezado del reporte.
			        	widths: [ '20%', '60%', '20%' ],
			        	body: [
			        	[
			        	{
			        		rowSpan: 3,
			        		image: 'data:image/png;base64,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',
			        		height:80,
			        		width:90,
			        		alignment: 'center'
			        	},
			        	{
			        		text: 'GESTIÓN PARA LA APROPIACIÓN DE LAS PRACTICAS ARTISTICAS',
			        		alignment: 'center',
			        		bold: true,
			        		fontSize: 17

			        	},
			        	{
			        		text:'Código: 2MI-GFOR-F-03' ,
			        		fontSize: 9,
			        		bold: true
			        	}
			        	],
			        	[
			        	'',
			        	{
			        		rowSpan: 2,
			        		text: 'REPORTE DE ASISTENCIA MENSUAL CREA' + (suplencia?' - SUPLENCIA':''),
			        		alignment: 'center',
			        		bold: true,
			        		fontSize: 15

			        	},
			        	{
			        		text: 'Versión: 2',
			        		fontSize: 9,
			        		bold: true
			        	}
			        	],
			        	[
			        	'',
			        	'',
			        	{
			        		text: 'Fecha: 31/05/2018',
			        		fontSize: 9,
			        		bold: true
			        	}
			        	]
			        	]
			        }
			    },
			    {
			    	text: ' '

			    },
			    {
			    	style: 'tabla_datos_artista',
			    	fontSize: 11,
			    	alignment: 'left',
			        table: { // Datos del artista
			        	widths: [ '20%', '46%', '16%','18%' ],
			        	body: [
			        	[
			        	{
			        		text: 'Cod Verificación:',
			        		bold: true,
			        	},
			        	{
			        		colSpan: 3,
			        		text: id_informe,
			        	}
			        	],
			        	[
			        	{
			        		text: 'Artista Formador:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['nombre_artista'],

			        	},
			        	{
			        		text: 'Identificación:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['VC_Identificacion'],

			        	}
			        	],
			        	[
			        	{
			        		text: 'Correo:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['VC_Correo'],

			        	},
			        	{
			        		text: 'Línea de atención:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['linea_atencion'],

			        	}
			        	],
			        	[
			        	{
			        		text: 'Organización:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['nombre_organizacion'],

			        	},
			        	{
			        		text: 'Área Artistica:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['nombre_area_artistica'],

			        	}
			        	],
			        	]
			        }
			    },
			    {
			    	text: ' '
			    },
			    {
			    	style: 'tabla_datos_grupo',
			    	fontSize: 11,
			    	alignment: 'left',
			    	table: {
			    		widths: [ '16%', '17%', '16%','17%', '16%','18%' ],
			    		body: [
			    		[
			    		{
			    			text: 'Grupo:',
			    			bold: true,
			    		},
			    		{
			    			text: d['datos_basicos']['nombre_grupo'],

			    		},
			    		{
			    			text: 'Mes de reporte:',
			    			bold: true,
			    		},
			    		{
			    			text: d['datos_basicos']['mes_reporte'],

			    		},
			    		{
			    			text: 'Fecha de reporte:',
			    			bold: true,
			    		},
			    		{
			    			text: parent.getFechaYHoraServidor(),

			    		}
			    		],
			    		[
			    		{
			    			text: 'Institución Educativa:',
			    			bold: true,
			    		},
			    		{
			    			colSpan: 5,
			    			text:  d['datos_basicos']['nombre_colegio'],

			    		},
			    		{
			    			text: ''

			    		},
			    		{
			    			text: ''

			    		},
			    		{
			    			text: ''
			    		},
			    		{
			    			text: ''

			    		}
			    		]
			    		]
			    	}
			    },
			    {
			    	text : '\nListado detallado de las sesiones de clase dictadas en el mes ' + d['datos_basicos']['mes_reporte'] + ':'

			    },
			    {
			    	style: 'tabla_datos_sesiones',
			    	fontSize: 11,
			    	alignment: 'center',
			    	table: {
			    		widths: [ '10%', '20%','40%', '15%','15%' ],
			    		body: bodyDataSesion,
			    	}
			    },
			    {
			    	text : 'Total horas sesiones clase: ' + d['total_horas_sesiones_clase'],
			    	bold: true

			    },
			    {
			    	text : 'Total horas sesiones clase evento: ' + d['total_horas_sesiones_evento'],
			    	bold: true
			    },
			    {
			    	text : '\nListado detallado de novedades del artista formador sobre las sesiones de clase dictadas en el mes ' + d['datos_basicos']['mes_reporte'] + ':'
			    },
			    {
			    	style: 'table_datos_novedades',
			    	fontSize: 11,
			    	alignment: 'center',
			    	table:{
			    		widths: [ '20%', '20%', '20%','40%'],
			    		body: bodyDataNovedad
			    	}
			    },
			    {
			    	id:"firma",
			    	text : '\nYo ' + d['datos_basicos']['nombre_artista'] + ', certifico que la información reportada en el presente formato es verdadera, correcta y corresponde exactamente a la asistencia reportada en los talleres artisticos programados.'
			    },
			    {
			    	text : '\nYo ' + d['datos_basicos']['nombre_coordinador_crea'] + ', certifico que he revisado la información reportada por el formador(a) ' + d['datos_basicos']['nombre_artista'] + ' y valido la veracidad de la misma.'
			    },
				{
					rowSpan: 1,
					image:firma_escaneada,
					height:80,
					width:110,
					alignment: 'left'
				},
			    {
			    	id:"finFirma",
			    	text: '_____________________________________ \n' + d['datos_basicos']['nombre_artista'] + '\nFirma Artista Formador(a)'
			    },
			    horizontal
			    ],
			    pageBreakBefore: function(currentNode, followingNodesOnPage, nodesOnNextPage, previousNodesOnPage) {
			    	if ((currentNode.id == "firma" && nodesOnNextPage[nodesOnNextPage.length-2].id == "finFirma") ) 
			    	{
			    		return true; 
			    	}

			    },
			    //footer: {text:  currentPage.toString() + ' de ' + pageCount()},
			    footer: function(currentPage, pageCount) { return 'Reporte mensual ' + d.datos_basicos.mes_reporte + ' de asistencias grupo ' + d.datos_basicos.nombre_grupo + ' del artista formador: ' + d['datos_basicos']['nombre_artista'] + ' página ' + currentPage.toString() + ' de ' + pageCount; },
			};
			//pdfMake.createPdf(dd).open();
			pdfMake.createPdf(dd).download("Reporte_mensual.pdf");
		}

		function generarReportePDFHorizontal(d){
			let suplencia=false;
			// console.log(d);
			d.detallado_sesiones_clase.forEach(sesion => {
				if(sesion.suplencia==1){
					suplencia=true;
				}
			});
			var widthsDataSesion = [ '30%', '10%'];
			var bodyDataSesion = [];

			try{
				if(d['detallado_sesiones_clase'] != undefined){
					var dt = d['detallado_sesiones_clase'];
				}else{
					var dt = [];
				}
					var size_column = 60/dt.length;
					var dataRow = [];

					dataRow.push({text: 'Nombre del estudiante',bold: true});
					dataRow.push({text: 'Identificación',bold: true});
					dt.forEach(function(df){
						var propietario_sesion = "no_definido";
						if(df.id_usuario != $("#SL_artista_formador").val()){
							propietario_sesion = "otro";
						}else{
							if(df.suplencia == 0){
								propietario_sesion = "propio";
							}else{
								propietario_sesion = "suplencia";
							}
						}
					//dataRow.push(df.fecha_clase + '@' + propietario_sesion);
					dataRow.push({text: df.fecha_clase.slice(-2),bold: true});
					widthsDataSesion.push(''.concat(size_column,'%'));
			});
				bodyDataSesion.push(dataRow);

				dataRow = [];
				var lp = d['listado_participantes'];
				var as = d['detallado_sesiones_clase_participante'];
				lp.forEach(function(l){
					dataRow = [];
					dataRow.push({text: l.nombre, alignment: 'left'}); 
					dataRow.push(l.documento);
					dt.forEach(function(df){
						var estado_asistencia = 'SÍ';
						if(as[df.fecha_clase][l.id] == null || as[df.fecha_clase][l.id] == ''){
							// estado_asistencia = 'N/R'
							estado_asistencia = 'N0'
						}else{
							estado_asistencia = ((as[df.fecha_clase][l.id]) == 1)?'SÍ':'NO';
						}
						dataRow.push(estado_asistencia);
					});
					bodyDataSesion.push(dataRow);
				});

			}catch(ex){
				console.log(ex);
			}

			var dd2 = 
			[
			{text: '', pageOrientation: 'landscape', pageBreak: 'before'},
			{
				style: 'tableExample',
			        table: { // Encabezado del reporte.
			        	widths: [ '20%', '60%', '20%' ],
			        	body: [
			        	[
			        	{
			        		rowSpan: 3,
			        		image: 'data:image/png;base64,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',
			        		height:80,
			        		width:90,
			        		alignment: 'center'
			        	},
			        	{
			        		text: 'GESTIÓN PARA LA APROPIACIÓN DE LAS PRACTICAS ARTISTICAS',
			        		alignment: 'center',
			        		bold: true,
			        		fontSize: 17

			        	},
			        	{
			        		text:'Código: 2MI-GFOM-F-07' ,
			        		fontSize: 9,
			        		bold: true
			        	}
			        	],
			        	[
			        	'',
			        	{
			        		rowSpan: 2,
			        		text: 'REPORTE DE ASISTENCIA MENSUAL CREA' + (suplencia?' - SUPLENCIA':''),
			        		alignment: 'center',
			        		bold: true,
			        		fontSize: 15

			        	},
			        	{
			        		text: 'Versión: 1',
			        		fontSize: 9,
			        		bold: true
			        	}
			        	],
			        	[
			        	'',
			        	'',
			        	{
			        		text: 'Fecha: 2/22/2018',
			        		fontSize: 9,
			        		bold: true
			        	}
			        	]
			        	]
			        }
			    },
			    {
			    	text: ' '

			    },
			    {
			    	style: 'tabla_datos_artista',
			    	fontSize: 11,
			    	alignment: 'left',
			        table: { // Datos del artista
			        	widths: [ '20%', '46%', '16%','18%' ],
			        	body: [
			        	[
			        	{
			        		text: 'Artista Formador:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['nombre_artista'],

			        	},
			        	{
			        		text: 'Identificación:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['VC_Identificacion'],

			        	}
			        	],
			        	[
			        	{
			        		text: 'Correo:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['VC_Correo'],

			        	},
			        	{
			        		text: 'Línea de atención:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['linea_atencion'],

			        	}
			        	],
			        	[
			        	{
			        		text: 'Organización:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['nombre_organizacion'],

			        	},
			        	{
			        		text: 'Área Artistica:',
			        		bold: true,
			        	},
			        	{
			        		text: d['datos_basicos']['nombre_area_artistica'],

			        	}
			        	],
			        	]
			        }
			    },
			    {
			    	text: ' '
			    },
			    {
			    	style: 'tabla_datos_grupo',
			    	fontSize: 11,
			    	alignment: 'left',
			    	table: {
			    		widths: [ '16%', '17%', '16%','17%', '16%','18%' ],
			    		body: [
			    		[
			    		{
			    			text: 'Grupo:',
			    			bold: true,
			    		},
			    		{
			    			text: d['datos_basicos']['nombre_grupo'],

			    		},
			    		{
			    			text: 'Mes de reporte:',
			    			bold: true,
			    		},
			    		{
			    			text: d['datos_basicos']['mes_reporte'],

			    		},
			    		{
			    			text: 'Fecha de reporte:',
			    			bold: true,
			    		},
			    		{
			    			text: parent.getFechaYHoraServidor(),

			    		}
			    		],
			    		[
			    		{
			    			text: 'Institución Educativa:',
			    			bold: true,
			    		},
			    		{
			    			colSpan: 5,
			    			text:  d['datos_basicos']['nombre_colegio'],

			    		},
			    		{
			    			text: ''

			    		},
			    		{
			    			text: ''

			    		},
			    		{
			    			text: ''
			    		},
			    		{
			    			text: ''

			    		}
			    		]
			    		]
			    	}
			    },
			    {
			    	text : '\nListado detallado de las asistencias de los beneficiarios a las sesiones de clase dictadas en el mes ' + d['datos_basicos']['mes_reporte'] + ':'

			    },
			    {
			    	style: 'tabla_datos_grupo',
			    	fontSize: 11,
			    	alignment: 'center',
			    	table: {
			    		widths: widthsDataSesion,
			    		body: bodyDataSesion
			    	},
			    },
			    ]
			//};
			//pdfMake.createPdf(dd2).download("Reporte_mensual_horizontal.pdf");
			//pdfMake.createPdf(dd2).open();
			return dd2;
		}
	});