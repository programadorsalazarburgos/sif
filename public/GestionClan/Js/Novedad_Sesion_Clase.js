var url_ok_obj = '../../src/GestionClan/GestionClanController/';
var url_ok_obj_registrar_asistencia = '../../src/ArtistaFormador/RegistrarAsistenciaController/';
var url_reporte = '../../src/ArtistaFormador/ReporteMensualController/';

var modificar_json_reporte_formador = false;

var hoy = new Date(), y = hoy.getFullYear(), m = hoy.getMonth();
var primerDia = new Date(y, m, 1);
var UltimoDia = new Date(y, m + 2, 0);	

if(hoy.getUTCDate()<=10)
	primerDia= new Date(y, m-1, 1); 
$(function(){
	var table_novedades = $("#table_novedades").DataTable({ 
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
			extend: 'excel',

			title: 'Novedad Grupo ' + $("#SL_grupo").find(':selected').data('tipo_grupo') + "-" + $("#SL_grupo").val()
		}
		]
	});
	$("#SL_crea").html(parent.getOptionsClanes()).selectpicker('refresh');
	$("#SL_artista_formador").html(parent.getOptionsArtistasFormadores(1)).selectpicker('refresh');
	$("#SL_novedad").html(parent.getOptionsNovedades()).selectpicker("refresh");
	$("#SL_crea").change(function(){
		$("#SL_grupo").html(parent.getOptionGruposDeUnCrea($(this).val())).selectpicker('refresh').trigger('change');
	}).trigger("change");
	$("#SL_grupo").change(function(){
		setOptionSelectArtistaGrupo();
		setNombreGrupoHistorial();
		cargarHistorialNovedadesGrupo();
	});
	cargarDatosIniciales();
	$("#DA_fecha").change(validarExistenciaNovedadDia);
	$("#BT_guardar_novedad").click(guardarNovedad);

	$("table").delegate(".opciones_historial_novedad","click",function(){
		$("#title_modal_editar_novedad").text("Modificar Novedad " + $(this).data("id_novedad"));
		$("#BT_save_editar_novedad").data("id_novedad",$(this).data("id_novedad"));
		$("#BT_save_eliminar_novedad").data("id_novedad",$(this).data("id_novedad"));

		$("#BT_save_editar_novedad").data("tipo_grupo",$(this).data("tipo_grupo"));
		$("#BT_save_eliminar_novedad").data("tipo_grupo",$(this).data("tipo_grupo"));
		$("#SL_editar_novedad_novedad").val($(this).data('in_novedad'));
		if($(this).data('in_asistencia')){
			$("#CH_editar_novedad_asistencia").bootstrapToggle('on');
		}else{
			$("#CH_editar_novedad_asistencia").bootstrapToggle('off');
		}
		$("#TX_editar_novedad_observacion").val($(this).data('observacion'));
	});

	$("#BT_save_editar_novedad").click(function(){
		datos = {
			p1: {
				id : $(this).data("id_novedad"),
				in_asistencia: $("#CH_editar_novedad_asistencia").prop('checked'),
				in_novedad: $("#SL_editar_novedad_novedad").val(),
				tx_observacion: "'" + $("#TX_editar_novedad_observacion").val() + "'"
			},
			p2: {
				tipo_grupo: $(this).data("tipo_grupo")
			}
		};
		$.ajax({
			url:url_ok_obj+'updateNovedad',
			type:'POST',
			data: datos
		}).done(function(data){
			$("#modal_editar_novedad").modal('hide');
			parent.mostrarAlerta("success","Novedad modificada","La novedad se ha modificado correctamente.",cargarHistorialNovedadesGrupo);
		}).fail(function(data){
			console.log("fail" + data);
		});
	});

	$("#BT_save_eliminar_novedad").click(function(){
		parent.alertify.confirm('¿Está seguro?', 'Seguro que desea eliminar esta novedad',
			function(){
				datos = {
					p1: {
						id : $("#BT_save_eliminar_novedad").data("id_novedad"),
						tipo_grupo: $("#BT_save_eliminar_novedad").data("tipo_grupo")
					}
				};
				$.ajax({
					url:url_ok_obj+'deleteNovedad',
					type:'POST',
					data: datos
				}).done(function(data){
					$("#modal_editar_novedad").modal('hide');
					parent.mostrarAlerta("success","Novedad eliminada","La novedad se ha eliminado correctamente.",cargarHistorialNovedadesGrupo);
				}).fail(function(data){
					console.log("fail " + data);
				});

			},
			function(){
				
			});
	});

	$("#SL_novedad").change(function(){
		/*if ($(this).val() == 1 || $(this).val() == 3 || $(this).val() == 4){
			$('#DA_fecha').datepicker('destroy');
			setCalendar(primerDia,8);
		}else if($(this).val() == 2 || $(this).val() == 6){
			$('#DA_fecha').datepicker('destroy');
			setCalendar(primerDia,hoy);		 	
		}else{
			cargarHistorialNovedadesGrupo();
		}*/
	});

	function cargarDatosIniciales(){
		setCalendar(primerDia,UltimoDia);
		setNombreGrupoHistorial();
		cargarHistorialNovedadesGrupo();
	}

	function setCalendar(minimo,maximio){
		if(typeof(minimo)=='number') minimo='-' + minimo + 'd';				
		if(typeof(maximio)=='number') maximio='+' + maximio + 'd';
		$("#DA_fecha").datepicker({
			format: 'yyyy-mm-dd',
			startDate: minimo,
			endDate: maximio,
			weekStart: 1,
			language: 'es',
			autoclose: true,
			title: 'Fecha del taller'
		});
	}

	function setNombreGrupoHistorial(){
		var mostrar = "";
		if($("#SL_grupo").find(':selected').data('tipo_grupo') == 'arte_escuela'){
			mostrar += "AE-";
		}else if($("#SL_grupo").find(':selected').data('tipo_grupo') == 'emprende_clan'){
			mostrar += "EC-";
		}
		mostrar += $("#SL_grupo").val();
		$("#B_historial_nombre_grupo").text(mostrar);
	}

	function setOptionSelectArtistaGrupo(){
		var datos = {
			'p1': {
				'id_grupo': $("#SL_grupo").val(),
				'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
				'retorna': 0
			}

		};
		$.ajax({
			url: url_ok_obj+'consultarIdArtistaFormadorGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#SL_artista_formador").val(data).selectpicker('refresh');
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido cargar el artista formador que tiene asignado el grupo.' + textStatus);
		});
	}

	function cargarHistorialNovedadesGrupo(){
		var datos = {
			'p1' : {
				tipo_grupo : $("#SL_grupo").find(':selected').data('tipo_grupo'),
				id_grupo : $("#SL_grupo").val()
			}
		}
		$.ajax({
			url:url_ok_obj+'cargarHistorialNovedadesGrupo',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			table_novedades.clear().draw();
			table_novedades.rows.add($(data)).draw(); 
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido cargar los datos de las novedades:  ' + textStatus)
		});
		$('#DA_fecha').datepicker('destroy');
		setCalendar(primerDia,UltimoDia);
		$('#DA_fecha').datepicker('setDaysOfWeekHighlighted',diasNoClaseGrupo());
	}

	function guardarNovedad(){
		if($("#DA_fecha").val() == ""){
			parent.mostrarAlerta("warning","Seleccione una fecha","Debe indicar la fecha para la cual desea guardar la nueva novedad",function(){$("#DA_fecha").focus();});
		}else{
			var estado_asistencia = 0;
			if($("#CH_asistencia").prop('checked')){
				estado_asistencia = 1;
			}
			if(!validarExistenciaNovedadDia()){

				var datos = {
					'p1' : {
						'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
						'id_grupo': $("#SL_grupo").val(),
						'fecha_novedad': $("#DA_fecha").val(),
						'id_novedad': $("#SL_novedad").val(),
						'estado_asistencia': estado_asistencia,
						'observacion': $("#TX_observacion").val(),
						'id_artista_formador': $("#SL_artista_formador").val(),
						'id_usuario': parent.idUsuario,
						'retorna': 0
					}
				};
				$.ajax({
					url: url_ok_obj+'crearNovedad',
					type: 'POST',
					data: datos,
					async: false
				}).done(function(data){
					if(data != ""){
						parent.mostrarAlerta("success","Novedad Guardada","Se ha agregado la novedad en el grupo indicado",function(){
							$("#DA_fecha").val("");
							$("#TX_observacion").val("");
							cargarHistorialNovedadesGrupo();
						});
						if (modificar_json_reporte_formador){
							// var Date = '24/02/2009';
							var elem = $("#DA_fecha").val().split('-');
							dia = elem[0];
							mes = elem[1];
							anio = elem[2];
							var datos = {
								'p1' : {
									'dia': dia,
									'mes': mes,
									'anio': anio
								}
							};
							$.ajax({
								url: url_reporte+'actualizarNovedadesReporteArtista',
								type: 'POST',
								data: datos,
								async: false
							}).done(function(data){

							}).fail(function(jqXHR,textStatus){
								parent.mostrarAlerta("error",'Error','No se ha podido modificar el reporte mensual del artista.' + textStatus);
							});
						}else{
							console.log("No modificar ni pio.");
						}
					}else{
						parent.mostrarAlerta("error","Error","No se ha podido guardar la Novedad.");
						console.log(data);
					}
				}).fail(function(jqXHR,textStatus){
					parent.mostrarAlerta("error",'Error','No se ha podido cargar el artista formador que tiene asignado el grupo.' + textStatus);
				});
			}else{
				parent.mostrarAlerta("error","Mensaje del sistema","Ya existe novedad con de tipo <strong>"+$( "#SL_novedad option:selected" ).text()+" </strong> registrada para el día indicado en ese grupo.","");				
				$('#BT_guardar_novedad').prop('disabled', true); 				
			}
		}
	}

	function validarExistenciaNovedadDia(){
		var existe=0;
		var datos = {
			'p1' : {
				'id_grupo': $("#SL_grupo").val(),
				'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo'),
				'fecha_sesion_clase': $("#DA_fecha").val(),
				'id_novedad': $("#SL_novedad").val(),
				'retorna': 0
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarNovedadGrupoDia',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data != 0){
				parent.mostrarAlerta("error","Mensaje del sistema","Ya existe novedad con de tipo <strong>"+$( "#SL_novedad option:selected" ).text()+" </strong> registrada para el día indicado en ese grupo.","");				
				$('#BT_guardar_novedad').prop('disabled', true); 
				existe=1;
			}else{
				existe=0;
				$("#BT_guardar_novedad").prop('disabled', false);
			}
		}).fail(function(jqXHR,textStatus){
			existe=1;
			parent.mostrarAlerta('Error','Mensaje del sistema','No se ha podido verificar si el grupo tiene registrada la <strong>'+$( "#SL_novedad option:selected" ).text()+' </strong> registrada para el día indicado' + textStatus);
		});
		return existe;
	}

	function diasNoClaseGrupo(){
		var dias_si_clase = [];
		var dias_no_clase = ["0","1","2","3","4","5","6"];
		var datos = {
			'p1' : {
				id_grupo : $("#SL_grupo").val()
			},
			'p2' : {
				tipo_grupo : $("#SL_grupo").find(':selected').data('tipo_grupo')
			}
		}
		$.ajax({
			url: url_ok_obj_registrar_asistencia + 'consultarDiasClaseGrupo',
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			try{
				data = $.parseJSON(data);
				dias_si_clase = data;
			}catch(err){
				console.log('Error','No se pudieron cargar los dias que no tiene clase el grupo : ');
				console.log(err);
			}
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("Error","No se han podido consultar los días del horario del grupo");
		});
		for (var i = dias_si_clase.length - 1; i >= 0; i--) {
			dias_no_clase[($.inArray(dias_si_clase[i],dias_no_clase))] = "";
		}
		return dias_no_clase;
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
});