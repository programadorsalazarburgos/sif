var url_ok_obj = '../../src/ArtistaFormador/RegistrarAsistenciaController/';
$(function(){
	$("#nav_modificar_asistencia_evento").click(function(){
		$("#SL_eventos_registrados").trigger("change");
	});
	$("#SL_evento").html(parent.getOptionsEventosActivos(parent.idUsuario)).selectpicker("refresh").change(establecerCalendario);
	$("#SL_eventos_registrados").html(parent.getOptionsEventosActivos(parent.idUsuario)).selectpicker("refresh").change(cargarSesionesEvento);
	$("#SL_grupo").html(parent.getGruposDeUnUsuario(parent.idUsuario)).selectpicker('refresh').change(cargarDatosEstudiantesGrupo); 
	$("#BT_guardar_asistencia_sesion_evento").click(guardarSesionClaseEvento);
	$("#SL_sesion_evento").change(cargarDatosEstudiantesGrupoSesionEvento);
	$("#TX_fecha_asistencia_evento").change(
		function(){
			if(verificarFechaNoHaRegistradoAsistenciaEvento()){
				parent.mostrarAlerta("warning",'Duplicidad de asistencia', 'Ya se registro asistencia para el día seleccionado del evento y grupo indicado!', function(){ $("#TX_fecha_asistencia_evento").focus(); });
			}
			$('.asistencia_evento').bootstrapToggle({
				on: 'SÍ',
				off: 'NO',
				onstyle: 'success',
				offstyle: 'danger'
			});
		});
	$("#BT_editar_asistencia_sesion_evento").click(function(){
		parent.swal({
			title: 'Estas seguro?',
			text: "Se eliminaran los estudiantes que haya pasado a NO y se agregaran los que puso en SÍ",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, modificar sesión!'
		}).then(function(){
			var estudiante = [];
			$("[name^='CH_editar_asistencia_estudiante_evento']").each(function( index ) {
				if($( this ).is(':checked')){
					estudiante.push($( this ).data('id_estudiante'));
				}
			});
			var datos = {
				'p1' : {
					'id_sesion_evento' : $("#SL_sesion_evento").val(),
					'id_usuario' : parent.idUsuario,
					'horas_participacion' : $("#SL_horas_edicion_sesion_evento").val(),
					'tx_observaciones' : $("#TX_observaciones_edicion_sesion_evento").text(),
					'id_estudiante' : estudiante
				}
			};
			$.ajax({
				url: url_ok_obj+'modificarAsistenciaSesionEvento',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				if (data == 1) {
					parent.mostrarAlerta("success","Asistencia modificada","Se han modificado los datos la sesion de clase para este evento satisfactoriamente");
					cargarDatosEstudiantesGrupoSesionEvento();
				}else{
					parent.mostrarAlerta("error","Error del sistema","No se pudo modificar la sesion de clase a evento");
					console.log(data);
				}
			}).fail(function(result){
				parent.mostrarAlerta("error","Error del sistema","No se pudo modificar la sesion de clase a evento");
			});
		}, function(dismiss){
			console.log("Cancelada la promesa");
			return false;
		});
	});
	$("#BT_eliminar_asistencia_sesion_evento").click(function(){
		parent.swal({
			title: 'Estas seguro?',
			text: "Si borras la sesión no podra reversarse",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, borrar sesión!'
		}).then(function(){
			var datos = {
				'p1' : $("#SL_sesion_evento").val(),
				'p2' : parent.idUsuario
			};
			$.ajax({
				url: url_ok_obj+'eliminarAsistenciaSesionEvento',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				if (data == 1) {
					parent.mostrarAlerta("success","Asistencia eliminada","Se ha eliminado la sesion de clase para este evento satisfactoriamente");
					cargarSesionesEvento();
				}else{
					parent.mostrarAlerta("error","Error del sistema","No se pudo eliminar la sesion de clase a evento");
					console.log(data);
				}
			}).fail(function(result){
				parent.mostrarAlerta("error","Error del sistema","No se pudo eliminar la sesion de clase a evento");
			});
		}, function(dismiss){
			console.log("Cancelada la promesa");
			return false;
		});
	});

	function establecerCalendario(){
		dias_duracion_evento = parent.diasDuracionEvento($("#SL_evento").val());
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
		cargarDatosEstudiantesGrupo();
	}

	function cargarDatosEstudiantesGrupo(){
		if($("#SL_evento").val()=="")
		{
			parent.mostrarAlerta("warning",'Advertencia','Para continuar debe seleccionar el evento');
			return false;
		}
		datos = {
			p1: {
				'id_grupo': $("#SL_grupo").val(),
				'id_evento': $("#SL_evento").val(),
				'tipo_sesion_clase': 'evento',
				'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
				'tipo_evento': $("#SL_evento").find(':selected').data('tipo_evento')
			}
		}
		$.ajax({
			url:url_ok_obj+'consultarEstudiantesGrupoActivosEnEvento',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data == ""){
				$("#BT_guardar_asistencia_sesion_evento").attr("disabled","disabled");
			}else{
				$("#BT_guardar_asistencia_sesion_evento").removeAttr("disabled");
			}

			$("#div_table_estudiantes_grupo").html(data);

			table_estudiantes_grupo = $("#table_estudiantes_grupo").DataTable({
				iDisplayLength: '100',
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			}).on( 'draw', function () {
				$('.asistencia_clase').bootstrapToggle({
					on: 'SÍ',
					off: 'NO',
					onstyle: 'success',
					offstyle: 'danger'
				});
			}).draw();
			table_estudiantes_grupo.search('').draw();

		    $('#TX_fecha_asistencia_evento').datepicker('show');		
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido cargar los datos de los estudiantes:  ' + textStatus)
		});

	}

	function guardarSesionClaseEvento(){
		if($("#SL_horas_sesion_evento").val() == ""){
			$("#SL_horas_sesion_evento").selectpicker("show");
			parent.mostrarAlerta("error","Falta un dato","Debe seleccionar el total de horas de participación.");
		}else{
			if($("#SL_evento").val()){
				if(verificarFechaNoHaRegistradoAsistenciaEvento()){
					parent.mostrarAlerta("warning",'Duplicidad de asistencia', 'Ya se registro asistencia para el día seleccionado del evento y grupo indicado!', function(){ $("#TX_fecha_asistencia_evento").focus(); });
				}else{
					var estudiante_asistencia = []
					$("input[name='CH_asistencia_estudiante_evento[]']").each(function (){
						estudiante_asistencia.push([$(this).data('id_estudiante'),(Number(this.checked))]);
					});
					datos = {
						p1: {
							'id_evento' : $("#SL_evento").val(),
							'tipo_evento': $("#SL_evento").find(':selected').data('tipo_evento'),
							'id_grupo' : $("#SL_grupo").val(),
							'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
							'fecha_clase': $("#TX_fecha_asistencia_evento").val(),
							'total_horas' : $("#SL_horas_sesion_evento").val(),
							'id_usuario' : parent.idUsuario,
							'observaciones' : $("#TX_observaciones").val()
						},
						p2: estudiante_asistencia
					};
					$.ajax({
						url:url_ok_obj+'guardarSesionClaseEvento',
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
				}
			}else{
				parent.mostrarAlerta("warning","Datos incompletos!","Debe seleccionar el evento.", function(){ $("#SL_evento").selectpicker("toggle"); });
			}
		}
	}

	function verificarFechaNoHaRegistradoAsistenciaEvento(){
		var registro_asistencia = false;
		datos = {
			p1: {
				'id_evento' : $("#SL_evento").val(),
				'id_grupo' : $("#SL_grupo").val(),
				'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
				'fecha_clase': $("#TX_fecha_asistencia_evento").val()
			}
		};
		$.ajax({
			url:url_ok_obj+'validarFechaSesionClaseEvento',
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

	function cargarSesionesEvento(){
		$.ajax({
			url: url_ok_obj+'consultarOptionsSesionesRegistradasEnEventoPorArtistaFormador',
			type: 'POST',
			data: {
				'p1' : {
					'id_artista_formador' : parent.idUsuario,
					'id_evento' : $("#SL_eventos_registrados").val()
				}
			},
			async: false
		}).done(function(data){
			if(data != ""){
				$("#SL_sesion_evento").html(data).selectpicker('refresh').trigger("change");
				$("#BT_editar_asistencia_sesion_evento").removeAttr("disabled");
				$("#BT_eliminar_asistencia_sesion_evento").removeAttr("disabled");
			}else{
				parent.mostrarAlerta("warning","Advertencia","Este evento no tiene registradas sesiones");
				$("#SL_sesion_evento").html("").selectpicker('refresh').trigger("change");
				$("#div_table_estudiantes_grupo_sesion_evento").html("");
				$("#BT_editar_asistencia_sesion_evento").attr("disabled","disabled");
				$("#BT_eliminar_asistencia_sesion_evento").attr("disabled","disabled");
			}
		}).fail(function(result){
		      console.log("Error: "+data);
		      parent.mostrarAlerta("Error","Error del sistema","No se han podido consultar las sesiones de clase registradas para este evento.");
		});
	}

	function cargarDatosEstudiantesGrupoSesionEvento(){
		var horas_participacion = $("#SL_sesion_evento").find(':selected').data('horas_clase');
		var tx_observaciones = $("#SL_sesion_evento").find(':selected').data('tx_observaciones');
		$("#SL_horas_edicion_sesion_evento").val(horas_participacion).selectpicker("refresh");
		$("#TX_observaciones_edicion_sesion_evento").text(tx_observaciones);
		datos = {
			p1: {
				'id_grupo': $("#SL_sesion_evento").find(':selected').data('id_grupo'),
				'tipo_grupo': $("#SL_sesion_evento").find(':selected').data('tipo_grupo'),
				'tipo_sesion_clase' : 'editar_sesion_evento',
				'tipo_evento': $("#SL_eventos_registrados").find(':selected').data('tipo_evento'),
				'id_evento': $("#SL_eventos_registrados").val()
			}
		}
		$.ajax({
			url:url_ok_obj+'consultarEstudiantesGrupoActivosEnEvento',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data == ""){
				$("#BT_editar_asistencia_sesion_evento").attr("disabled","disabled");
				$("#BT_eliminar_asistencia_sesion_evento").attr("disabled","disabled");
			}else{
				$("#BT_editar_asistencia_sesion_evento").removeAttr("disabled");
				$("#BT_eliminar_asistencia_sesion_evento").removeAttr("disabled");
			}
			$("#div_table_estudiantes_grupo_sesion_evento").html(data);
			var table_estudiantes_grupo_sesion_evento = $("#table_estudiantes_grupo_sesion_evento").DataTable({
				iDisplayLength: '100',
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			}).on( 'draw', function () {
				$('.asistencia_clase').bootstrapToggle({
					on: 'SÍ',
					off: 'NO',
					onstyle: 'success',
					offstyle: 'danger'
				});
			}).draw();

			table_estudiantes_grupo_sesion_evento.search('').draw();
		    //$('#TX_fecha_asistencia_evento').datepicker('show');
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido cargar los datos de los estudiantes para editar la sesion de clase en evento:  ' + textStatus)
		});

		$.ajax({
			url: url_ok_obj+'cargarDatosEstudiantesGrupoSesionEvento',
			type: 'POST',
			data: {
				'p1' : $("#SL_sesion_evento").val()
			},
			async: false
		}).done(function(data){
			try{
				data = $.parseJSON(data);
				for (var i = data.length - 1; i >= 0; i--) {
					if (data[i]['IN_estado_asistencia'] == 1) {
						$("#CH_asistencia_estudiante_evento_editar_" + data[i]['FK_estudiante']).prop('checked', true);
					}
				}
				$('.editar_sesion_evento').bootstrapToggle({
					on: 'SÍ',
					off: 'NO',
					onstyle: 'success',
					offstyle: 'danger'
				});
			}catch(ex){
				parent.mostrarAlerta("warning","Advertencia!!","No se ha podido decodificar el JSON de estudiantes con asistencia al evento en esta sesión de clase");
				console.log("Excepcion: " + ex + data);
			}
		}).fail(function(result){
		      console.log("Error: "+data);
		      parent.mostrarAlerta("Error","Error del sistema","No se han podido consultar las sesiones de clase registradas para este evento.");
		});
	}
});
