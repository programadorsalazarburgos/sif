var url_ok_obj = '../../src/Circulacion/CirculacionController/';
$(function(){
	if(parent.idRol == 3){
		$("#registrar_asistencia_evento_tab").hide();
	}
	var table_estudiantes_evento = $("#table_estudiantes_evento").DataTable({
		iDisplayLength: '100',
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No existen estudiantes asignados al evento.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		}
	});

	var table_nuevo_artista_evento = $("#table_nuevo_artista_evento").DataTable({
		iDisplayLength: '10',
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No existen resultados de busqueda.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		}
	});

	$("body").delegate('.mayuscula','keyup',function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#DIV_fecha_evento").hide();

	$("[id*=modificar]").change(function(){
		$("#TX_modificar_nombre").val(generarNombreEventoModificar());
	});

	$("#nuevo_evento_tab").click(function(ev){
		$("#nuevo_evento").html(obtenerFormulario("NuevoEvento"));
		$("#SL_tipo_evento").html(getTiposEvento()).selectpicker('refresh').change(mostrarFechaParaEvento).trigger("change");
		$("#SL_area_artistica").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
		$("#SL_clan").html(parent.getOptionsClanes(0)).selectpicker('refresh');
		$("#SL_artista_formador").html(parent.getOptionsArtistasFormadores(true) + parent.getOptionsUsuariosRol(15,0,'Rol Gestor Pedagógico Territorial')).selectpicker('refresh');
		$("#SL_tipo_evento_recursos").selectpicker("refresh");

		var hoy = new Date();
		var ini = new Date(hoy.setDate(hoy.getDate()+10));
		ini.setHours(0);
		$('#fecha_evento').datetimepicker({
			autoclose: true,
			minuteStep: 30,
			weekStart: 1,
			//startDate: '+9d'
			//startDate: ini
		});
		$('#fecha_fin_evento').datetimepicker({
			autoclose:true,
			minuteStep: 30,
			weekStart:1,
	    	//startDate: '+9d'
	    	startDate: ini
	    });
	});
	$("#nuevo_evento").delegate("select","change",function(ev){
		$("#nombre").val(generarNombreEvento());
	}).delegate("input","change",function(ev){
		$("#nombre").val(generarNombreEvento());
	}).delegate("#fecha_evento","change",function (ev) {
		$("#fecha_fin_evento input").val("");
		$("#fecha_fin_evento").datetimepicker("setStartDate",$("#fecha_evento input").val());
		console.log("cambio fecha inicio");
	}).delegate("#fecha_fin_evento","change", function (ev) {
		$("#fecha_evento").datetimepicker("setEndDate",$("#fecha_fin_evento input").val());
		console.log("cambio fecha FIN");
	}).delegate("#SL_tipo_evento_recursos","change",function(ev){
		switch($(this).val()){
			case 'propio':
			$("#div_alert_tipo_evento_recurso").removeClass("alert-danger").addClass("alert-warning").html("<strong>Evento Interno!</strong> El evento es <u>propio</u> y se debe especificar los recursos e insumos que <strong>proporcionará el CREA</strong>.");
			$("#div_quien_invita").html("");
			break;
			case 'externo':
			$("#div_alert_tipo_evento_recurso").removeClass("alert-warning").addClass("alert-danger").html("<strong>Evento Externo!</strong> El evento es <u>externo</u> y se debe especificar los recursos e insumos <strong>requeridos para asistir al evento</strong>.");
			$("#div_quien_invita").html("<textarea id='quien_invita' name='quien_invita' required='required' rows='2' class='form-control' placeholder='Nombre de quien invita'></textarea>");
			break;
			default:
			console.log("Otro tipo de recurso no valido" + $(this).val());
			break;
		}
	}).delegate("#form_nuevo_evento","submit",function(event){
		event.preventDefault();
		if($("#fecha_inicio_evento").val() == ""){
			parent.mostrarAlerta("warning","Indique una fecha","Para la creación del evento es obligatorio la fecha");
			$("#fecha_inicio_evento").trigger("focus");
		}else{
			$("#BT_guardar_evento").attr("disabled","disabled");
			datos = {
				p1: {
					'id_tipo_evento' : $("#SL_tipo_evento").val(),
					'fecha_inicio_evento' : $("#fecha_inicio_evento").val(),
					'fecha_fin_evento' : $("#fecha_fin_evento").val(),
					'nombre' : $("#nombre").val(),
					'id_organizador' : parent.idUsuario,
					'lugar' : $("#lugar").val(),
					'objetivo' : $("#objetivo").val(),
					'area_artistica' : $("#SL_area_artistica").val(),
					'artista_formador' : $("#SL_artista_formador").val(),
					'clan' : $("#SL_clan").val(),
					'quien_invita' : $("#quien_invita").val(),
					'publico_asistente' : $("#publico_asistente").val()
				},
				p2:{
					'transporte': $("#transporte").val(),
					'tecnica_produccion': $("#tecnica_produccion").val(),
					'vestuario': $("#vestuario").val(),
					'escenografia': $("#escenografia").val(),
					'maquillaje': $("#maquillaje").val(),
					'alimentacion': $("#alimentacion").val(),
					'comunicaciones_instrumentos': $("#comunicaciones_instrumentos").val()
				}
			};
			$.ajax({
				url: url_ok_obj+'guardarNuevoEvento',
				type:'POST',
				data: datos,
			}).done(function(data){
				//Envío Notificaciones
				// var notificacion = {
				// 	vc_url:'Circulacion/Asignar_Estudiante_Evento.php',
				// 	vc_icon:'fa-2x fa fa-bullhorn',
				// 	vc_contenido:'Se ha creado el evento '+$('#nombre').val()+' para su aprobación'
				// }
				// role = 13; //Equipo de Circulación
				// window.parent.sendNotificationRole(notificacion,role);
				respuestaObservacion="Evento <b>" + data + "</b> credo satisfactoriamente!";
				$("select[id*='SL_']").each(function (i, el) {
					$(this).selectpicker('refresh');
				});
				parent.mostrarAlerta("success","Felicitaciones",respuestaObservacion);
			}).fail(function(data){
				parent.mostrarAlerta("error","Error","No se pudo crear el evento.");
			});
			document.getElementById("form_nuevo_evento").reset();
			$("#BT_guardar_evento").removeAttr("disabled");
		}
	});

	$("#modificar_evento_tab").click(function(){
		$("#modificar_evento").html(obtenerFormulario("ModificarEvento"));
		$("#SL_evento_modificar").html(getOptionEventosPropios()).selectpicker('refresh').trigger('change');
		$("#SL_modificar_tipo_evento").html(getTiposEvento()).selectpicker('refresh').change(mostrarFechaParaModificarEvento);
		$("#DIV_fecha_fin_evento_modificar").hide();
		$("#SL_clan_modificar_evento").html(parent.getOptionsClanes()).selectpicker('refresh');
		$("#SL_area_artistica_modificar_evento").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
		$("#SL_artista_formador_modificar_evento").html(parent.getOptionsArtistasFormadores()).selectpicker('refresh');
		$('#TX_modificar_fecha_evento').datetimepicker({
			autoclose: true,
			minuteStep: 10,
			weekStart: 1,
			//startDate: '+9d'
			//startDate: ini
		});
		$('#TX_modificar_fecha_fin_evento').datetimepicker({
			autoclose:true,
			minuteStep: 10,
			weekStart:1,
	    	//startDate: '+9d'
	    	//startDate: ini
	    });
		$("#TX_modificar_fecha_evento").on("change", function (e) {
			$("#TX_modificar_fecha_fin_evento input").val("");
			$("#TX_modificar_fecha_fin_evento").datetimepicker("setStartDate",$("#TX_modificar_fecha_evento input").val());
		});

		$("#TX_modificar_fecha_fin_evento").on("change", function (e) {
			$("#TX_modificar_fecha_evento").datetimepicker("setEndDate",$("#TX_modificar_fecha_fin_evento input").val());
		});
		setTimeout(function(){
			$(".selectpicker").selectpicker("refresh");
		}, 7);
	});

	$("#modificar_evento").delegate("#SL_evento_modificar","change",function(ev){
		cargarDatosEvento($(this).val());
	}).delegate("#BT_modificar_guardar_datos_multiples","click",function(ev){
		parent.swal({
			title: "Mensaje de confirmación",
			html: "¿Seguro que desea editar los datos multiples correspondientes a CREA(s), Area(s) Artistica(s) y Formador(es) del evento?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si',
			showCancelButton: true,
			cancelButtonText: 'No, cancelar!',
			//reverseButtons: true,
		}).then(() => {
			datos = {
				p1: {
					'id_crea' : $("#SL_clan_modificar_evento").val(),
					'id_area_artistica' : $("#SL_area_artistica_modificar_evento").val(),
					'id_artista_formador' : $("#SL_artista_formador_modificar_evento").val()
				},p2: {
					'id_evento' :$("#SL_evento_modificar").val(),
					'id_usuario' : parent.idUsuario
				}
			};
			$.ajax({
				url:url_ok_obj+'modificarEventoDatosMultiples',
				type:'POST',
				data: datos
			}).done(function(data){
				if(data == 1){
					parent.mostrarAlerta('success','Modificación exitosa','Se ha modificado los datos de multiples (Area(s) Artistica(s) y Artista(s) Formador(es))del evento correctamente.');
				}else{
					parent.mostrarAlerta('error','Modificación fallida','Al parecer ha fallado la modificación del evento, por favor verificar y/o contactarse con soporte.');
					console.log(data);
				}
				$("#SL_evento_modificar").val(datos['p2']['id_evento']).selectpicker('refresh').trigger('change');
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('Error','Error','No se han podido modificar los datos basicos del evento.');
			});
			parent.mostrarAlerta('success','Mensaje del sistema','Datos basicos del evento modificados correctamente.');
		},function(dismiss) {
			parent.mostrarAlerta('warning','Se ha cancelado la modificación de los datos basicos del evento.');
		}).catch(parent.swal.noop);
	}).delegate("#BT_modificar_guardar_recursos_insumos","click",function(ev){
		parent.swal({
			title: 'Confirmar edición',
			text: "¿Seguro que desea editar los datos correspondientes a recursos e insumos del evento?",
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#3085d6',
			cancelButtonText: 'No, Cancelar',
			confirmButtonText: 'Sí, Editar',
		}).then(function(){
			if($("#SL_tipo_evento_recursos_modificar").val() == 'externo'){
				quien_invita_modificar = $("#TX_quien_invita_modificar").val();
			}else{
				quien_invita_modificar = $("#SL_tipo_evento_recursos_modificar").val();
			}
			datos = {
				p1: {
					'quien_invita_modificar' : quien_invita_modificar,
					'transporte_modificar' : $("#transporte_modificar").val(),
					'tecnica_produccion_modificar' : $("#tecnica_produccion_modificar").val(),
					'vestuario_modificar' : $("#vestuario_modificar").val(),
					'escenografia_modificar' : $("#escenografia_modificar").val(),
					'maquillaje_modificar' : $("#maquillaje_modificar").val(),
					'alimentacion_modificar' : $("#alimentacion_modificar").val(),
					'comunicaciones_instrumentos_modificar' : $("#comunicaciones_instrumentos_modificar").val()
				},p2: {
					'id_evento' :$("#SL_evento_modificar").val(),
					'id_usuario' : parent.idUsuario
				}
			};
			$.ajax({
				url:url_ok_obj+'modificarEventoRecursosInsumos',
				type:'POST',
				data: datos
			}).done(function(data){
				if(data == 1){
					parent.mostrarAlerta('success','Modificación exitosa','Se ha modificado los datos de recursos e insumos del evento correctamente.');
				}else{
					parent.mostrarAlerta('error','Modificación fallida','Al parecer ha fallado la modificación del evento, por favor verificar y/o contactarse con soporte.');
					console.log(data);
				}
				$("#SL_evento_modificar").val(datos['p2']['id_evento']).selectpicker('refresh').trigger('change');
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('error','Error','No se han podido modificar los datos basicos del evento.');
			});
			//parent.mostrarAlerta('warning','Se ha cancelado la modificación de los datos basicos del evento.');
		}, function(dismiss){
			console.log("Cancelada la promesa");
			return false;
		});
	}).delegate("#BT_modificar_guardar_datos_basicos","click",function(ev){
		parent.swal({
			title: 'Confirmar edición',
			text: "¿Seguro que desea editar los datos basicos del evento?",
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#3085d6',
			cancelButtonText: 'No, Cancelar',
			confirmButtonText: 'Sí, Editar',
		}).then(function(){
			datos = {
				p1: {
					'id_tipo_evento' : $("#SL_modificar_tipo_evento").val(),
					'fecha_inicio_evento' : $("#TX_modificar_fecha_inicio_evento").val(),
					'fecha_fin_evento' : $("#TX_modificar_fecha_fin_evento").val(),
					'nombre' : $("#TX_modificar_nombre").val(),
					'lugar' : $("#TX_modificar_lugar").val(),
					'objetivo' : $("#TX_modificar_objetivo").val(),
					'id_crea' : $("#SL_clan_modificar_evento").val(),
					'publico_asistente' : $("#TX_modificar_publico_asistente").val()
				},p2: {
					'id_evento' :$("#SL_evento_modificar").val(),
					'id_organizador' : parent.idUsuario
				}
			};
			$.ajax({
				url:url_ok_obj+'modificarEventoDatosBasicos',
				type:'POST',
				data: datos
			}).done(function(data){
				if(data == 1){
					parent.mostrarAlerta('success','Modificación exitosa','Se ha modificado los datos basicos del evento correctamente.');
				}else{
					parent.mostrarAlerta('error','Modificación fallida','Al parecer ha fallado la modificación del evento, por favor verificar y/o contactarse con soporte.');
					console.log(data);
				}
				$("#SL_evento_modificar").val(datos['p2']['id_evento']).selectpicker('refresh').trigger('change');
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('error','Error','No se han podido modificar los datos basicos del evento.');
			});
				//parent.mostrarAlerta('success','Datos basicos del evento modificados correctamente.');
			}, function(dismiss){
				parent.mostrarAlerta('error','Se ha cancelado la modificación de los datos basicos del evento.');
				console.log("Cancelada la promesa");
				return false;
			});
	}).delegate("#SL_tipo_evento_recursos_modificar","change",function(ev){
		switch($(this).val()){
			case 'propio':
			$("#div_alert_tipo_evento_recurso_modificar").removeClass("alert-danger").addClass("alert-warning").html("<strong>Evento Interno!</strong> El evento es <u>propio</u> y se debe <strong>especificar </strong> los recursos e insumos que se proporcionarán.");
			$("#div_quien_invita_modificar").html("");
			break;
			case 'externo':
			$("#div_alert_tipo_evento_recurso_modificar").removeClass("alert-warning").addClass("alert-danger").html("<strong>Evento Externo!</strong> El evento es <u>externo</u> y se debe <strong>especificar</strong> los recursos e insumos requeridos para asistir al evento.");
			$("#div_quien_invita_modificar").html("<textarea id='TX_quien_invita_modificar' name='TX_quien_invita_modificar' required='required' rows='2' class='form-control' placeholder='Nombre de quien invita'></textarea>");
			break;
			default:
			console.log("Otro tipo de recurso no valido" + $(this).val());
			break;
		}
	}).delegate("#BT_estado_evento","click",function(ev){
		$("#modal_formulario_completar_aforo").modal("show");
	});

	$("#administrar_artistas_eventos_mi_crea_tab").click(function(ev){
		$("#administrar_artistas_eventos_mi_crea").html(obtenerFormulario("AdministrarArtistasParaEventosMiCREA"));
		$("#SL_evento_administrar_artistas").html(getOptionsEventosActivosMiCrea()).selectpicker("refresh").trigger("change");
	});
	$("#administrar_artistas_eventos_mi_crea").delegate("#SL_evento_administrar_artistas","change",cargarTablaArtistasFormadoresEvento);

	$("#asignacion_participantes_evento_tab").click(function(ev){
		$("#asignacion_participantes_evento").html(obtenerFormulario("AsignacionParticipantesEvento"));
		$("#SL_evento_asignar_participante").html(getOptionsEventosDistritalesActivos()).selectpicker('refresh');
		$("#datos_participantes_asignados_evento").hide();
	});

	$("#asignacion_participantes_evento").delegate("#SL_evento_asignar_participante","change",function(ev){
		cargarParticipantesEvento();
		$("#SL_crea_desde_grupo").html(parent.getOptionsClanes()).selectpicker('refresh');
		$("#datos_participantes_asignados_evento").show("slow");
	}).delegate("#SL_crea_desde_grupo","change",function(ev){
		$("#SL_grupo").html(parent.getOptionGruposDeUnCrea($(this).val())).trigger("change").selectpicker('refresh');
	}).delegate("#SL_grupo","change",function(ev){
		datos = {
			'p1': {
				'id_grupo': $(this).val(),
				'tipo_grupo': $(this).find(':selected').data('tipo_grupo'),
				'id_evento' : $("#SL_evento_asignar_participante").val()
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarEstudiantesGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			var table_estudiantes_grupo = $("#table_estudiantes_grupo").DataTable({
				destroy: true,
				iDisplayLength: '50',
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No existen participantes en el grupo seleccionado.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			});
			table_estudiantes_grupo.clear().draw();
			table_estudiantes_grupo.rows.add($(data)).draw(); 
		}).fail(function(result){
			console.log("Error: "+result);
		});
	}).delegate("#BT_buscar_participante_grupo","click",function(ev){
		$("#SL_crea_desde_grupo").trigger("change");
	}).delegate(".asignar_estudiante_evento_desde_grupo","click",function(){
		datos = {
			p1: {
				id_evento : $(this).data("id_evento"),
				id_estudiante : $(this).data("id_estudiante"),
				id_usuario: parent.idUsuario
			}
		};
		$.ajax({
			url:url_ok_obj+'agregarEstudianteEventoDistrital',
			type:'POST',
			data: datos,
		}).done(function(data){
			if(data == 1){
				parent.mostrarAlerta("success","Estudiante asignado a evento","Se ha asignado correctamente el estudiante indicado.");
			}else{
				parent.mostrarAlerta("warning","Ourrio algo inesperado","Al parecer no se pudo asignar el participante al evento, verifique, intente nuevamente y si el problema persiste comuniquese con soporte SIF.");
			}
			cargarParticipantesEvento();
			$("#SL_grupo").trigger("change");
			$("#SL_evento").trigger("change");
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se ha podido asignar el estudiante al evento por:' + textStatus);
		});
	}).delegate(".permiso_padres","change",function(ev){
		var estado_permiso = ($(this).prop('checked')?1:0);
		datos = {
			p1: {
				id_evento : $(this).data("id_evento"),
				id_estudiante : $(this).data("id_estudiante"),
				id_usuario: parent.idUsuario,
				permiso: estado_permiso
			}
		};
		$.ajax({
			url:url_ok_obj+'actualizarPermisoPadres',
			type:'POST',
			data: datos,
		}).done(function(data){
			console.log(data);
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se ha podido cambiar el estado del permiso de padres del beneficiario al evento por:' + textStatus);
		});
	}).delegate(".remover_beneficiario_evento","click",function(ev){
		var id_beneficiario = $(this).data('id_beneficiario');
		var id_evento = $(this).data('id_evento');
		parent.swal({
			title: "Mensaje de confirmación",
			html: "¿Seguro que desea quitar el beneficiario del evento?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si',
			showCancelButton: true,
			cancelButtonText: 'No, cancelar!',
			//reverseButtons: true,
		}).then(() => {
			datos = {
				p1: {
					'id_beneficiario':id_beneficiario,
					'id_evento':id_evento,
					'id_usuario':parent.idUsuario
				}
			};
			$.ajax({
				url:url_ok_obj+'removerBeneficiarioEventoDistrital',
				type:'POST',
				data: datos
			}).done(function(data){
				if(data == 1){
					parent.mostrarAlerta('success','Modificación exitosa','Se ha removido el beneficiario del evento correctamente.');
				}else{
					parent.mostrarAlerta('error','Modificación fallida','Al parecer ha fallado la eliminación del beneficiario del evento, por favor verificar y/o contactarse con soporte.');
					console.log(data);
				}
				cargarParticipantesEvento();
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('Error','Error','No se han podido remover el beneficiario del evento.');
			});
		},function(dismiss) {
			parent.mostrarAlerta('warning','Se ha cancelado remover el beneficiario del evento.');
		}).catch(parent.swal.noop);
	});

	$("#registrar_asistencia_evento_tab").click(function(){
		$("#registrar_asistencia_evento").html(obtenerFormulario("RegistrarAsistenciaEvento"));
		parent.mostrarAlerta("warning","Recuerde que","Esta opción debe usarse para registrar asistencia unicamente cuando el evento no tenga acompañamiento de artista(s) formador(es)",5000);
		$("#SL_evento_registrar_asistencia").html(getOptionEventosPropios(1)).selectpicker('refresh').change(establecerCalendario).trigger('change');
	});

	$("#form_confirmar_aforo_evento").submit(function(event){
		event.preventDefault();
		var datos = {
			p1: {
				'id_evento' : $("#SL_evento_modificar").val(),
				'id_usuario' : parent.idUsuario,
				'asistentes_nna' : $("#IN_nna").val(),
				'asistentes_padres' : $("#IN_padres").val(),
				'asistentes_publico' : $("#IN_publico").val(),
				'estado' : 0
			}
		};
		$.ajax({
			url:url_ok_obj+'FinalizarEvento',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data == 1){
				parent.mostrarAlerta("success","Evento Finalizado.","Se a guardado el publico asistente del evento y su estado ahora es finalizado");
				$("#BT_estado_evento").attr("disabled","disabled");
				$("#modal_formulario_completar_aforo").modal("hide");
			}
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido finalizar el evento, intentelo nuevamente y si el problema persiste contactese con soporte ' + textStatus);
		});
	});

	$("#BT_guardar_asistencia_sesion_evento").click(function(){
		var estudiante_asistencia = []
		$("input[name='CH_asistencia_estudiante_evento[]']").each(function (){
			estudiante_asistencia.push([$(this).data('id_estudiante'),(Number(this.checked))]);
		});
		datos = {
			p1: {
				'id_evento' : $("#SL_evento_registrar_asistencia").val(),
				'tipo_evento': 'distrital',
				'id_grupo' : '0',
				'tipo_grupo' : $("#SL_linea_atencion_sesion_evento").val(),
				'fecha_clase': $("#TX_fecha_asistencia_evento").val(),
				'total_horas' : $("#SL_horas_sesion_evento").val(),
				'id_usuario' : parent.idUsuario,
				'observaciones' : $("#TX_observaciones").val()
			},
			p2: estudiante_asistencia
		};
		$.ajax({
			url:'../../src/ArtistaFormador/RegistrarAsistenciaController/guardarSesionClaseEvento',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data != 0){
				parent.mostrarAlerta("success","Asistencia a evento Guardada.","Se ha guardado exitosamente la sesión de asistencia: <b>" + data + "</b> al evento.");
			}
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido verificar si ya existe un registro de asistencia-sesión de clase para la fecha seleccionada : ' + textStatus);
		});
	});

	$("#TX_artista_formador_buscar").keyup(function(e){
		if(e.keyCode == 13){
			$("#BT_buscar_artista_formador").trigger("click");
		}
	});
	$("#BT_buscar_artista_formador").click(buscarArtistaFormador);

	$("#table_nuevo_artista_evento").delegate(".asignar_artista_evento","click",function(){
		var id_evento = $(this).data("id_evento");
		var datos = {
			'p1' : {
				'id_usuario' : parent.idUsuario,
				'id_artista_formador' : $(this).data("id_artista_formador"),
				'id_evento' : $("#SL_evento_administrar_artistas").val()
			}
		};
		$.ajax({
			url: url_ok_obj+'AsignarArtistaEvento',
			type:'POST',
			data: datos,
			async: false,
		}).done(function(data){
			if(data == 1)
			{
				cargarTablaArtistasFormadoresEvento();
				buscarArtistaFormador();
				parent.mostrarAlerta("success","Artista Asignado","Se ha asignado correctamente el artista formador al evento.");
			}else
			{
				parent.mostrarAlerta("warning","Algo ocurrio","Por favor verifique que el artista este asignado al evento, en caso contrario conctatese con soporte SIF.");
			}
		}).fail(function(data){
			parent.mostrarAlerta("error","error","No se ha podido consultar los tipo de evento")
		});
	});

	$("#registrar_asistencia_evento").delegate("#TX_fecha_asistencia_evento","change",function(ev){
		console.log("entro...");
		if(verificarFechaNoHaRegistradoAsistenciaEvento())
		{
			parent.mostrarAlerta("warning",'Duplicidad de asistencia', 'Ya se registro asistencia de un asesor pedagógico para el día seleccionado del evento indicado!', function(){ $("#TX_fecha_asistencia_evento").focus(); });
			$("#BT_guardar_asistencia_sesion_evento").attr("disabled","disabled");
			$('#TX_fecha_asistencia_evento').datepicker('show');
		}
		else
		{
			$("#BT_guardar_asistencia_sesion_evento").removeAttr("disabled");
		}
	});

	function getTiposEvento(){
		var mostrar = "";
		var datos = {
			'p1' : parent.idRol
		};
		$.ajax({
			url: url_ok_obj+'consultarTiposEvento',
			type:'POST',
			data: datos,
			async: false,
		}).done(function(data){
			mostrar += data;
		}).fail(function(data){
			parent.mostrarAlerta("error","error","No se ha podido consultar los tipo de evento");
		});
		return mostrar;
	}

	function getOptionEventosPropios(solamente_activos = 0){
		console.log("Se consultarn con estado activo = " + solamente_activos);
		var mostrar = "";
		var datos = {
			p1: {
				'id_usuario' : parent.idUsuario,
				'solamente_activos' : solamente_activos
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarEventosCreadosPorUsuario',
			type:'POST',
			data: datos,
			async: false,
			success: function(data){
				if(data != "")
					mostrar += data;
				else
					parent.mostrarAlerta("warning","Error cargando datos para editar","No hay creado ningun evento para modificar!");
			}
		});
		return mostrar;
	}

	function cargarDatosEvento(id_evento){
		cargarDatosBasicosEvento(id_evento);
		cargarDatosMultiplesEvento(id_evento);
		cargarRecursosInsumosEvento(id_evento);
	}

	function cargarDatosBasicosEvento(id_evento){
		var datos = {
			p1: {
				'id_evento' : id_evento
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarDatosBasicosEvento',
			type:'POST',
			data: datos,
			async: false,
			success: function(data){
				try{
					datos = $.parseJSON(data);
					datos = datos[0];
					$("#TX_modificar_nombre").val(datos['VC_Nombre']);
					$("#TX_modificar_fecha_inicio_evento").val(datos['DT_Fecha_Inicio']);
					$("#TX_modificar_fecha_fin_evento").val(datos['DT_Fecha_Fin']);
					$("#TX_modificar_lugar").val(datos['VC_Lugar']);
					$("#TX_modificar_objetivo").val(datos['VC_Objetivo']);
					$("#TX_modificar_publico_asistente").val(datos['IN_publico_asistente']);
					$("#SL_modificar_tipo_evento").val(datos['FK_Tipo_Evento']).selectpicker('refresh');
					if(datos['VC_quien_invita'] != 'propio'){
						$("#SL_tipo_evento_recursos_modificar").val('externo').selectpicker('refresh').trigger('change');
						$("#TX_quien_invita_modificar").val(datos['VC_quien_invita']);
					}else{
						$("#SL_tipo_evento_recursos_modificar").val('propio').selectpicker('refresh').trigger('change');
					}
					$("#CH_estado_evento").bootstrapToggle('enable');
					if(datos['estado_evento'] == '0'){
						$("#BT_modificar_guardar_datos_basicos").attr("disabled","disabled");
						$("#BT_modificar_guardar_datos_multiples").attr("disabled","disabled");
						$("#BT_modificar_guardar_recursos_insumos").attr("disabled","disabled");
						$("#BT_estado_evento").val("Evento Finalizado").attr("disabled","disabled");
						parent.mostrarAlerta("warning","Evento Finalizado","El evento seleccionado no se puede modficiar pues ha sido marcado como finalizado.")
						$(".form-control").attr("disabled","disabled");
					}else{
						$("#BT_modificar_guardar_datos_basicos").removeAttr("disabled");
						$("#BT_modificar_guardar_datos_multiples").removeAttr("disabled");
						$("#BT_modificar_guardar_recursos_insumos").removeAttr("disabled");
						$("#BT_estado_evento").val("Finalizar Evento").removeAttr("disabled");
						$(".form-control").removeAttr("disabled");
					}
					$("#SL_evento_modificar").removeAttr("disabled");
					$(".selectpicker").selectpicker("refresh");
				}catch(ex){
					parent.mostrarAlerta("error","Error cargando datos para editar","No se han podido cargar los datos basicos del evento por error: ");
					console.log(ex);
					console.log(data);
				}
			}
		});
	}

	function cargarDatosMultiplesEvento(id_evento){
		/*   Crea(s)   */
		var datos = {
			p1: {
				'id_evento' : id_evento
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarDatosMultiplesEvento',
			type:'POST',
			data: datos,
			async: false,
			success: function(data){
				try{
					datos = $.parseJSON(data);
					var id_crea = [], id_area_artistica = [], id_artista_formador = [];
					for (var i = 0; i < datos['crea'].length; i++) {
						id_crea.push(datos['crea'][i]['PK_Id_Clan']);
					}
					for (var i = 0; i < datos['area_artistica'].length; i++) {
						id_area_artistica.push(datos['area_artistica'][i]['PK_Area_Artistica']);
					}
					for (var i = 0; i < datos['artista_formador'].length; i++) {
						id_artista_formador.push(datos['artista_formador'][i]['FK_Artista_Formador']);
					}
					$("#SL_clan_modificar_evento").val(id_crea).selectpicker('refresh');
					$("#SL_area_artistica_modificar_evento").val(id_area_artistica).selectpicker('refresh');
					$("#SL_artista_formador_modificar_evento").val(id_artista_formador).selectpicker('refresh');
				}catch(ex){
					parent.mostrarAlerta("error","Error cargando datos para editar","No se han podido cargar los datos correspondientes a recursos e insumos del evento por error: " + ex);
					console.log(ex);
					console.log(data);
				}
			}
		});
	}

	function cargarRecursosInsumosEvento(id_evento){
		var datos = {
			p1: {
				'id_evento' : id_evento
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarRecursosInsumosEvento',
			type:'POST',
			data: datos,
			async: false,
			success: function(data){
				try{
					datos = $.parseJSON(data);
					datos = datos[0];
					$("#transporte_modificar").val(datos['VC_transporte']);
					$("#tecnica_produccion_modificar").val(datos['VC_tecnica_produccion']);
					$("#vestuario_modificar").val(datos['VC_vestuario']);
					$("#escenografia_modificar").val(datos['VC_escenografia']);
					$("#maquillaje_modificar").val(datos['VC_maquillaje']);
					$("#alimentacion_modificar").val(datos['VC_alimentacion']);
					$("#comunicaciones_instrumentos_modificar").val(datos['VC_comunicaciones']);
				}catch(ex){
					parent.mostrarAlerta("error","Error cargando datos para editar","No se han podido cargar los datos correspondientes a recursos e insumos del evento por error: " + ex);
					console.log(ex);
					console.log(data);
				}
			}
		});
	}

	function mostrarFechaParaEvento(){
		$("#SL_tipo_evento").hide("slow");
		var tipo_evento = $("#SL_tipo_evento").val();
		switch(tipo_evento){
			case '14':
			case '15':
			case '19':
			$("#DIV_fecha_fin_evento").hide();
			break;
			case '16':
			case '17':
			$("#DIV_fecha_fin_evento").show();
			break;
			default:
			console.log("Otro SL_tipo_evento" + tipo_evento);
		}
		$("#DIV_fecha_evento").show("fast");
		$("#SL_clan").selectpicker("refresh");
	}

	function mostrarFechaParaModificarEvento(){
		$("#SL_modificar_tipo_evento").hide("slow");
		var tipo_evento = $("#SL_modificar_tipo_evento").val();
		switch(tipo_evento){
			case '14':
			case '15':
			case '19':
			$("#DIV_fecha_fin_evento_modificar").hide();
			break;
			case '16':
			case '17':
			$("#DIV_fecha_fin_evento_modificar").show();
			break;
			default:
			console.log("Otro SL_tipo_evento" + tipo_evento);
		}
		$("#SL_clan_modificar_evento").selectpicker("refresh");
	}

	function generarNombreEvento(){
		var nombre_evento = "";
		var tipo_evento = $("#SL_tipo_evento").val();
		nombre_evento += $("#SL_tipo_evento option:selected" ).text();
			nombre_evento += "-" + $("#lugar").val();
			nombre_evento += "-" + $("#fecha_inicio_evento").val().split(" ")[0];
		// Si es evento local
		if(tipo_evento == "14" || tipo_evento == "15"){

		}else{ // cuando es evento distrital
			nombre_evento += "-" + $("#fecha_fin_evento").val().split(" ")[0];
		}
		return nombre_evento;
	}

	function generarNombreEventoModificar(){
		var nombre_evento = "";
		var tipo_evento = $("#SL_modificar_tipo_evento").val();
		nombre_evento += $("#SL_modificar_tipo_evento option:selected" ).text();
		nombre_evento += "-" + $("#TX_modificar_lugar").val();
		nombre_evento += "-" + $("#TX_modificar_fecha_inicio_evento").val().split(" ")[0];
		// Si es evento local
		if(tipo_evento == "14" || tipo_evento == "15"){

		}else{ // cuando es evento distrital
			nombre_evento += "-" + $("#TX_modificar_fecha_fin_evento").val().split(" ")[0];
		}
		return nombre_evento;
	}

	function establecerCalendario(){
		dias_duracion_evento = parent.diasDuracionEvento($("#SL_evento_registrar_asistencia").val());
		$("#TX_fecha_asistencia_evento").val("");
		$("TX_fecha_asistencia_evento").datepicker('destroy');
		$("#TX_fecha_asistencia_evento").datepicker({
			format: 'yyyy-mm-dd',
			weekStart: 1,
			language: 'es',
			autoclose: true,
			title: 'Fecha de la sesión'
		});
		$('#TX_fecha_asistencia_evento').datepicker('setStartDate',dias_duracion_evento[0]);
		$('#TX_fecha_asistencia_evento').datepicker('setEndDate',dias_duracion_evento[1]);
		$('#TX_fecha_asistencia_evento').datepicker('show');
		$('#TX_fecha_asistencia_evento').datepicker('update',dias_duracion_evento[0]);
		cargarDatosEstudiantesEvento();
	}

	function cargarDatosEstudiantesEvento(){
		if($("#SL_evento_registrar_asistencia").val()=="")
		{
			parent.mostrarAlerta("warning",'Advertencia','Para continuar debe seleccionar el evento');
			return false;
		}
		var tipo_sesion_clase = 0;
		if (parent.idRol == 5) {
			tipo_sesion_clase = 1;
		}
		datos = {
			p1: {
				'id_evento': $("#SL_evento_registrar_asistencia").val(),
				'tipo_evento': $("#SL_evento_registrar_asistencia").find(':selected').data('tipo_evento'),
				'opcion' : {
					'registrar_asistencia' : true,
					'id_rol' : parent.idRol,
					'tipo_sesion_clase': tipo_sesion_clase
				}
			}
		}
		$.ajax({
			url:url_ok_obj+'cargarEstudiantesDeEventoDistrital',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			console.log(data);
			if(data == ""){
				$("#BT_guardar_asistencia_sesion_evento").attr("disabled","disabled");
			}else{
				$("#BT_guardar_asistencia_sesion_evento").removeAttr("disabled");
			}
			var table_estudiantes_evento = $("#table_estudiantes_evento").DataTable({
				destroy: true,
				iDisplayLength: '50',
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No existen artistas formadores asignados al evento.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay participantes para este evento",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			});
			table_estudiantes_evento.clear().draw();
			table_estudiantes_evento.rows.add($(data)).draw();
			table_estudiantes_evento.search('').on( 'draw', function () {
				$('.asistencia_evento').bootstrapToggle({
					on: 'SÍ',
					off: 'NO',
					onstyle: 'success',
					offstyle: 'danger'
				});
			}).draw();

			$('#TX_fecha_asistencia_evento').datepicker('show');
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido cargar los datos de los estudiantes:  ' + textStatus)
		});

	}

	function verificarFechaNoHaRegistradoAsistenciaEvento(){
		var registro_asistencia = false;
		datos = {
			p1: {
				'id_evento' : $("#SL_evento_registrar_asistencia").val(),
				'id_grupo' : '0',
				'tipo_grupo' : 'no_aplica_registrado_asesor_pedagogico',
				'fecha_clase': $("#TX_fecha_asistencia_evento").val()
			}
		};
		$.ajax({
			url:'../../src/ArtistaFormador/RegistrarAsistenciaController/validarFechaSesionClaseEvento',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data == 1) registro_asistencia = true;
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido verificar si ya existe un registro de asistencia-sesión de clase para la fecha seleccionada : ' + textStatus);
		});
		return registro_asistencia;
	}

	function getOptionsEventosActivosMiCrea(){
		var mostrar = "";
		var datos = {
			'p1' : parent.idUsuario
		};
		$.ajax({
			url: url_ok_obj+'getOptionsEventosActivosMiCrea',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			mostrar += data;
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se han podido cambiar el estado del evento.');
		});
		return mostrar;
	}

	function cargarTablaArtistasFormadoresEvento(){
		var datos = {
			'p1' : $("#SL_evento_administrar_artistas").val()
		};
		$.ajax({
			url: url_ok_obj+'cargarTablaArtistasFormadoresEvento',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			var table_artistas_formadores_evento = $("#table_artistas_formadores_evento").DataTable({
				destroy: true,
				iDisplayLength: '10',
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No existen artistas formadores asignados al evento.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			});
			table_artistas_formadores_evento.clear().draw();
			table_artistas_formadores_evento.rows.add($(data)).draw();
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se han podido cargar el listado de artistas asociados al evento.');
		});
	}

	function buscarArtistaFormador(){
		var texto = $("#TX_artista_formador_buscar").val();
		if(texto.length <= 3){
			parent.mostrarAlerta("warning","La busqueda debe tener más de 3 caracteres");
		}else{
			var datos = {
				'p1' : {
					'texto' : texto,
					'id_evento' : $("#SL_evento_administrar_artistas").val()
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarArtistasFormadoresNoAsociadosAEvento',
				type:'POST',
				data: datos,
				async: false
			}).done(function(data){
				table_nuevo_artista_evento.clear().draw();
				table_nuevo_artista_evento.rows.add($(data)).draw();
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('error','Error','No se han podido cambiar el estado del evento.');
			});
		}
	}

	function getOptionsEventosDistritalesActivos(){
		var mostrar = "";
		var datos = {
		};
		$.ajax({
			url : url_ok_obj+'getOptionsEventosDistritalesActivos',
			data :datos,
			type :'POST',
			success: function(data){
				mostrar += data;
			},
			async: false
		});
		return mostrar;
	}

	function obtenerFormulario(tipo_formulario){
		var mostrar = '';
		var datos = {
			p1: {
				'tipo_formulario': tipo_formulario
			}
		}
		$.ajax({
			url: url_ok_obj+'obtenerFormulario',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			mostrar += data;
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido cargar el formulario: " + tipo_formulario);
			console.log(data);
		});
		return mostrar;
	}

	function cargarParticipantesEvento(){
		datos = {
			p1 : {
				'id_evento' : $("#SL_evento_asignar_participante").val(),
				'opcion' : {
					'id_rol' : parent.idRol
				}
			}
		};
		$.ajax({
			url:url_ok_obj+'cargarEstudiantesDeEventoDistrital',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			var table_participantes = $("#table_participantes").DataTable({
				destroy: true,
				iDisplayLength: '50',
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No existen participantes en el grupo seleccionado.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			}); 
			table_participantes.clear().draw();
			table_participantes.rows.add($(data)).on( 'draw', function () {
				$('.permiso_padres').bootstrapToggle({
					on: 'SÍ',
					off: 'NO',
					onstyle: 'success',
					offstyle: 'danger'
				});
			}).draw();
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se han podido cargar los estudiantes asociados al evento.');
		});
	}
});
