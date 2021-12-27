var url_ok_obj = '../../src/ArtistaFormador/RegistrarAsistenciaController/';
var files;
var horas_sesion_clase = 500;
var hoyServidor = parent.obtenerFechaHora(false);
var hoy = new Date(hoyServidor.getFullYear(),hoyServidor.getMonth(),hoyServidor.getDate()); 
var dias_cancelados_y_festivos = "";
var tipo_grupo = "";
var tipo_ubicacion = "";
var meses = ['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];

$(function(){ 
	var fecha = new Date();
	$('[data-toggle="tooltip"]').tooltip();

	$("#SL_grupo").html(parent.getGruposDeUnUsuario(parent.idUsuario)).selectpicker("refresh");
	tipo_ubicacion = $("#SL_grupo").find(':selected').data('tipo_ubicacion');
	tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
	elemento_grupo = "SL_grupo";
	elemento_espacio = "SL_ESPACIO";
	elemento_tipo_atencion = "SL_TIPO_ATENCION";
	elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION";
	$("#SL_MODALIDAD_ATENCION").html(parent.getOptionParametroDetalleByOrder(61, "IN_Ordenacion", "ASC")).selectpicker("refresh");
	$("#SL_MODALIDAD_ATENCION").on('change', function(){
		cargarOptionsSLTipoAtencion($(this).val(), elemento_tipo_atencion, elemento_espacio, elemento_grupo, tipo_ubicacion, tipo_grupo);
		$(".asistencia_clase").bootstrapToggle("off");
	});
	cargarLugaresdeAtencionLinea(tipo_grupo,'titular', tipo_ubicacion);
	cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);

	$("#SL_LUGAR_ATENCION").on('change', function(){
		tipo_ubicacion = $(this).val();
		tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		elemento_grupo = "SL_grupo";
		elemento_espacio = "SL_ESPACIO";
		elemento_tipo_atencion = "SL_TIPO_ATENCION";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION";
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});

	$("#SL_grupo").on('change', function(){
		getHorarioClaseGrupo();
		$("#SL_grupo").selectpicker("refresh");
		tipo_ubicacion = $("#SL_grupo").find(':selected').data('tipo_ubicacion');
		tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		cargarLugaresdeAtencionLinea(tipo_grupo,'titular',tipo_ubicacion);
		elemento_grupo =  "SL_grupo";
		elemento_espacio = "SL_ESPACIO";
		elemento_tipo_atencion = "SL_TIPO_ATENCION";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION";
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});

	$("#SL_TIPO_ATENCION").on('change', function(){
		cargarMaterial("SL_TIPO_ATENCION", "SL_MATERIAL");
	});

	$("#SL_TIPO_ATENCION_SUPLENCIA").on('change', function(){
		cargarMaterial("SL_TIPO_ATENCION_SUPLENCIA", "SL_MATERIAL_SUPLENCIA");
	});

	$("#SL_TIPO_ATENCION_MODIFICAR").on('change', function(){
		cargarMaterial("SL_TIPO_ATENCION_MODIFICAR", "SL_MATERIAL_MODIFICAR");
	});

	getHorarioClaseGrupo();

	$("#mi_asistencia_tab").click(function(){
		$("#SL_grupo").html(parent.getGruposDeUnUsuario(parent.idUsuario)).selectpicker("refresh");
		tipo_ubicacion = $("#SL_grupo").find(':selected').data('tipo_ubicacion');
		tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		elemento_grupo = "SL_grupo";
		elemento_espacio = "SL_ESPACIO";
		elemento_tipo_atencion = "SL_TIPO_ATENCION";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION";
		$("#SL_MODALIDAD_ATENCION").html(parent.getOptionParametroDetalleByOrder(61, "IN_Ordenacion", "ASC")).selectpicker("refresh");
		$("#SL_MODALIDAD_ATENCION").on('change', function(){
			cargarOptionsSLTipoAtencion($(this).val(), elemento_tipo_atencion, elemento_espacio, elemento_grupo, tipo_ubicacion, tipo_grupo);
			$(".asistencia_clase").bootstrapToggle("off");
		});
		cargarLugaresdeAtencionLinea(tipo_grupo,'titular', tipo_ubicacion);
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});
// $("#mi_asistencia_tab").click();

	$("#asistencia_suplente_tab").click(function(){
		$("#SL_artista_formador_titular").html(getArtistasFormadoresConGruposActivos()).selectpicker('refresh');
		getGruposArtistaTitular();
		getHorarioClaseGrupoSuplencia();
		getOrganizacionesArtistaFormador();
		tipo_ubicacion = $("#SL_grupo_suplente").find(':selected').data('tipo_ubicacion');
		tipo_grupo = $("#SL_grupo_suplente").find(':selected').data('tipo_grupo');
		elemento_grupo = "SL_grupo_suplente";
		elemento_espacio = "SL_ESPACIO_SUPLENCIA";
		elemento_tipo_atencion = "SL_TIPO_ATENCION_SUPLENCIA";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION_SUPLENCIA";
		$("#SL_MODALIDAD_ATENCION_SUPLENCIA").html(parent.getOptionParametroDetalleByOrder(61, "IN_Ordenacion", "ASC")).selectpicker("refresh");
		$("#SL_MODALIDAD_ATENCION_SUPLENCIA").on('change', function(){
			cargarOptionsSLTipoAtencion($(this).val(), elemento_tipo_atencion, elemento_espacio, elemento_grupo, tipo_ubicacion, tipo_grupo);
			$(".asistencia_clase_suplencia").bootstrapToggle("off");
		});
		cargarLugaresdeAtencionLinea(tipo_grupo,'suplencia',tipo_ubicacion);
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});

	$("#SL_artista_formador_titular").change(getGruposArtistaTitular).selectpicker('refresh');

	$("#SL_LUGAR_ATENCION_SUPLENCIA").on('change', function(){
		tipo_ubicacion = $(this).val();
		tipo_grupo = $("#SL_grupo_suplente").find(':selected').data('tipo_grupo');
		elemento_grupo = "SL_grupo_suplente";
		elemento_espacio = "SL_ESPACIO_SUPLENCIA";
		elemento_tipo_atencion = "SL_TIPO_ATENCION_SUPLENCIA";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION_SUPLENCIA";
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});

	$("#SL_grupo_suplente").on('change',function(){
		getHorarioClaseGrupoSuplencia();
		$("#SL_grupo_suplente").selectpicker("refresh");
		tipo_ubicacion = $("#SL_grupo_suplente").find(':selected').data('tipo_ubicacion');
		tipo_grupo = $("#SL_grupo_suplente").find(':selected').data('tipo_grupo');
		elemento_grupo = "SL_grupo_suplente";
		elemento_espacio = "SL_ESPACIO_SUPLENCIA";
		elemento_tipo_atencion = "SL_TIPO_ATENCION_SUPLENCIA";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION_SUPLENCIA"; 
		cargarLugaresdeAtencionLinea(tipo_grupo,'suplencia',tipo_ubicacion);
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});

	$("#modificar_asistencia_tab").click(function(){
		$("#SL_grupo_modificar").html(getGruposParaModificar()).selectpicker('refresh');
		$("#SL_grupo_modificar").change();
		getSesionesClaseGrupoModificar();
		tipo_ubicacion = $("#SL_grupo_modificar").find(':selected').data('tipo_ubicacion');
		tipo_grupo = $("#SL_grupo_modificar").find(':selected').data('tipo_grupo');
		elemento_grupo = "SL_grupo_modificar";
		elemento_espacio = "SL_ESPACIO_MODIFICAR";
		elemento_tipo_atencion = "SL_TIPO_ATENCION_MODIFICAR";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION_MODIFICAR";
		$("#SL_MODALIDAD_ATENCION_MODIFICAR").html(parent.getOptionParametroDetalleByOrder(61, "IN_Ordenacion", "ASC")).selectpicker("refresh");
		$("#SL_MODALIDAD_ATENCION_MODIFICAR").on('change', function(){
			cargarOptionsSLTipoAtencion($(this).val(), elemento_tipo_atencion, elemento_espacio, elemento_grupo, tipo_ubicacion, tipo_grupo);
			$(".asistencia_clase_modificar").change();
		});
		cargarLugaresdeAtencionLinea(tipo_grupo,'modificar',tipo_ubicacion);
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});

	$("#anexos_sesiones_clase_tab").click(function(){
		$("#SL_mes_sesiones_anexo").html("");
		var fecha = parent.getFechaYHoraServidor();
		var current_year = fecha.substr(0,4);
		var last_year = current_year;
		var current_month = fecha.substr(5,2);
		var last_month = current_month-1;
		if(current_month==0){
			last_year = current_year-1;
			last_month = 12;
		}
		
		$("#SL_mes_sesiones_anexo").append("<option value="+last_year+"-"+last_month+">"+meses[last_month-1]+" "+last_year+"</option>").trigger('change');
		$("#SL_mes_sesiones_anexo").append("<option value="+current_year+"-"+current_month+">"+meses[current_month-1]+" "+current_year+"</option>").trigger('change');
		$("#SL_mes_sesiones_anexo").selectpicker('refresh');
	});

	$("#SL_mes_sesiones_anexo").on('change', function(){
		const anio_mes = $(this).val()
		datos = {
			p1: {
				'id_usuario': parent.idUsuario,
				'anio_mes': anio_mes
			}
		};
		$.ajax({
			url:url_ok_obj+'consultarGruposConSesionesEnMes',
			type:'POST',
			data: datos,
			beforeSend: function(){
				parent.mostrarCargando();
			},
			async: false
		}).done(function(data){
			parent.cerrarCargando();
			$("#SL_grupo_anexo").html(data).selectpicker('refresh').trigger('change')
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se ha podido cargar los grupos que tienen sesiones en el mes : ' + textStatus);
		});
	})

	$("#SL_grupo_anexo").on('change', function(){
		const anio_mes = $("#SL_mes_sesiones_anexo").val()
		const id_grupo = $(this).val()
		const tipo_grupo = $(this).find(':selected').data('tipo_grupo')
		datos = {
			p1: {
				'id_usuario': parent.idUsuario,
				'fecha_mes': anio_mes,
				'id_grupo': id_grupo,
				'tipo_grupo': tipo_grupo
			}
		};
		$.ajax({
			url:url_ok_obj+'consultarTablaAnexosMes',
			type:'POST',
			data: datos,
			beforeSend: function(){
				parent.mostrarCargando();
			},
			async: false
		}).done(function(data){
			parent.cerrarCargando();
			$("#div_table_anexo").html(data)
			var table_anexo = $("#table_anexo").DataTable({ 
				"pageLength": 50,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			}).draw();
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se ha podido consultar el listado de sesiones y sus anexos : ' + textStatus);
		});
	})

	$("#div_table_anexo").delegate('.no_anexo','click',function(){
		parent.mostrarAlerta("warning","No hay anexo","No se ha subido anexo para esta sesión")
	}).delegate('.ver_anexo','click',function(){
		const url_anexo=$(this).data('vc_anexo')
		const url_actual = window.location.href
		let indice = url_actual.indexOf("public")
		let extraida = url_actual.substring(0, indice)
		const url_final=extraida+'uploadedFiles/'+url_anexo+"?v"+(Math.floor(Math.random() * 100) + 1)
		var win = window.open(url_final, '_blank')
		win.focus()
	}).delegate('.subir_anexo','click',function(){
		$('#uploadModal #btn_upload').data("id_sesion_clase",$(this).data('id_sesion_clase'));
        $('#uploadModal #btn_upload').data("linea_atencion",$(this).data('tipo_grupo'));
        $("#uploadModal").modal({backdrop: 'static', keyboard: false});
	})

	$("#SL_grupo_modificar").on('change', function(){
		getSesionesClaseGrupoModificar();
		$("#SL_grupo_modificar").selectpicker("refresh");
		tipo_ubicacion = $(this).find(':selected').data('tipo_ubicacion');
		tipo_grupo = $(this).find(':selected').data('tipo_grupo');
		salon = $("#SL_fecha_sesion_grupo_modificar").find(':selected').data('salon');
		cargarLugaresdeAtencionLinea(tipo_grupo,'modificar',tipo_ubicacion);
		if((tipo_ubicacion == "2" && tipo_grupo == 'arte_escuela') || (tipo_ubicacion == "1" && tipo_grupo == 'laboratorio_clan') || (tipo_grupo == 'emprende_clan' && tipo_ubicacion == "1")){
			$("#SL_ESPACIO_MODIFICAR").removeAttr('disabled');
			$("#SL_ESPACIO_MODIFICAR").html(parent.getEspaciosCREA($("#SL_grupo_modificar").find(':selected').data('crea'))).selectpicker("refresh");
			$("#SL_ESPACIO_MODIFICAR").val(salon).selectpicker("refresh");
		}
		else{
			if(salon == "-1" && tipo_grupo == "emprende_clan"){
				$("#SL_LUGAR_ATENCION_MODIFICAR").val(tipo_ubicacion).selectpicker("refresh");
			}
			$("#SL_ESPACIO_MODIFICAR").html("<option value='-1' selected>NO APLICA</option>").attr("disabled", "disabled").selectpicker("refresh");
		}
	});

	$("#SL_LUGAR_ATENCION_MODIFICAR").on('change', function(){
		tipo_ubicacion = $(this).val();
		tipo_grupo = $("#SL_grupo_modificar").find(':selected').data('tipo_grupo');
		elemento_grupo = "SL_grupo_modificar";
		elemento_espacio = "SL_ESPACIO_MODIFICAR";
		elemento_tipo_atencion = "SL_TIPO_ATENCION_MODIFICAR";
		elemento_modalidad_atencion = "SL_MODALIDAD_ATENCION_MODIFICAR";
		cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion);
	});

	$("#SL_fecha_sesion_grupo_modificar").on('change', function(){
		tipo_ubicacion = $(this).find(':selected').data('tipo_ubicacion');
		modalidad_atencion = $(this).find(':selected').data('modalidad');
		tipo_atencion = $(this).find(':selected').data('tipo_atencion');
		tipo_grupo = $(this).find(':selected').data('tipo_grupo');
		salon = $(this).find(':selected').data('salon');
		cargarLugaresdeAtencionLinea(tipo_grupo,'modificar', tipo_ubicacion);
		$("#SL_LUGAR_ATENCION_MODIFICAR").val(tipo_ubicacion).selectpicker("refresh").change();
		$("#SL_MODALIDAD_ATENCION_MODIFICAR").val(modalidad_atencion).selectpicker("refresh").change();
		$("#SL_TIPO_ATENCION_MODIFICAR").val(tipo_atencion).selectpicker("refresh").change();
		if((tipo_ubicacion == "2" && tipo_grupo == 'arte_escuela') || (tipo_ubicacion == "1" && tipo_grupo == 'laboratorio_clan') || (tipo_grupo == 'emprende_clan' && tipo_ubicacion == "1")){
			$("#SL_ESPACIO_MODIFICAR").removeAttr('disabled');
			$("#SL_ESPACIO_MODIFICAR").html(parent.getEspaciosCREA($("#SL_grupo_modificar").find(':selected').data('crea'))).selectpicker("refresh");
			setTimeout(function(){ $("#SL_ESPACIO_MODIFICAR").val(salon).selectpicker("refresh"); }, 1000);
		}
		else{
			if(salon == "-1" && tipo_grupo == "emprende_clan"){
				$("#SL_LUGAR_ATENCION_MODIFICAR").val(tipo_ubicacion).selectpicker("refresh");
			}
			$("#SL_ESPACIO_MODIFICAR").html("<option value='-1' selected>NO APLICA</option>").attr("disabled", "disabled").selectpicker("refresh");
		}
		cargarDatosSesionClase();
	});

	$("#TB_fecha_sesion, #TB_fecha_sesion_suplencia").change(function(){
		var elemento_horas = "";
		var tipo_asistencia = "";
		var elemento_grupo = "";
		var elemento_fecha = "";
		if($(this).attr("id") == "TB_fecha_sesion"){
			elemento_horas = "SL_HORAS_SESION";
			elemento_grupo = "SL_grupo";
			elemento_fecha = "TB_fecha_sesion";
			tipo_asistencia = "titular";
		}
		if($(this).attr("id") == "TB_fecha_sesion_suplencia"){
			elemento_horas = "SL_HORAS_SESION_SUPLENCIA";
			elemento_grupo = "SL_grupo_suplente";
			elemento_fecha = "TB_fecha_sesion_suplencia";
			tipo_asistencia = "suplencia";
		}

		if($(this).val() != ""){
			if(verificarFechaNoHaRegistradoAsistencia(elemento_grupo, elemento_fecha)){
				parent.mostrarAlerta('warning','Duplicidad de asistencia', 'Ya se registró asistencia para el día seleccionado.');
				$("#"+elemento_fecha).val("");
			}else{
				if(elemento_fecha == "TB_fecha_sesion"){
					dias_no_clase = diasNoClaseGrupo();
				}
				if(elemento_fecha == "TB_fecha_sesion_suplencia"){
					dias_no_clase = diasNoClaseGrupoSuplencia();
				}
				var f = $(this).val().split("-");
				var fecha_sesion = new Date(f[0],f[1]-1,f[2]);
				var flag = false;
				for (var i = 0; i < dias_no_clase.length; i++) {
					if (dias_no_clase[i] == fecha_sesion.getDay()) {
						flag = true;
					}
				}
				if(flag){
						$("#"+elemento_horas).val("").selectpicker("refresh");
				}
				else{
					consultarHorasClaseSesion(tipo_asistencia, elemento_horas);
				}
			}
		}
	});

	$("body").delegate(".asistencia_clase, .asistencia_clase_suplencia, .asistencia_clase_modificar","change", function(){
		var id_estudiante= $(this).data("id_estudiante");
		var select_asistencia = $(this).attr("id");
		var valor_tipo_atencion= $(this).data("tipo_atencion");
		if($(this).hasClass("asistencia_clase")){
			mostrarOcultarSelectAtencion(select_asistencia, "SL_MODALIDAD_ATENCION", "SL_TIPO_ATENCION", "atencion_estudiante_"+id_estudiante);
		}
		if($(this).hasClass("asistencia_clase_suplencia")){
			mostrarOcultarSelectAtencion(select_asistencia, "SL_MODALIDAD_ATENCION_SUPLENCIA", "SL_TIPO_ATENCION_SUPLENCIA", "atencion_estudiante_suplencia_"+id_estudiante);
		}
		if($(this).hasClass("asistencia_clase_modificar")){
			mostrarOcultarSelectAtencion(select_asistencia, "SL_MODALIDAD_ATENCION_MODIFICAR", "SL_TIPO_ATENCION_MODIFICAR", "atencion_estudiante_modificar_"+id_estudiante, valor_tipo_atencion);
		}
	});

	$("#form_registro_asistencia").submit(function(event){
		event.preventDefault();
		var mensaje = "";
		if($("#SL_LUGAR_ATENCION").val() == "") mensaje += "- Seleccione el Lugar de Atención<br>";
		if($("#SL_MODALIDAD_ATENCION").val() == "") mensaje += "- Seleccione la Modalidad de Atención<br>";
		if($("#SL_TIPO_ATENCION").val() == "") mensaje += "- Seleccione el Tipo de Atención<br>";
		if($("#SL_TIPO_ATENCION").val() == 3 && $("#SL_MATERIAL").val() == "") mensaje += "- Seleccione el Material Pedagógico<br>";
		if($("#SL_ESPACIO").val() == "") mensaje += "- Seleccione el Espacio<br>";
		if($("#TB_fecha_sesion").val() == "") mensaje += "- Seleccione la Fecha de la sesión<br>";
		if($("#SL_HORAS_SESION").val() == "") mensaje += "- Seleccione las Horas de la sesión<br>";
		if(mensaje == ""){
				if($("#TX_observaciones").val() == ""){
					parent.swal({
						title: 'Observaciones está vacío',
						text: "¿Desea guardar de todas formas?",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Sí, guardar asistencia',
						cancelButtonText: 'Cancelar y verificar datos'
					}).then(function(){
						guardarAsistencia();
					}, function(dismiss){
						console.log("Cancelada la promesa");
						$("#TX_observaciones").focus();
						return false;
					});
				}else{
					guardarAsistencia();
				}
		}
		else{
			parent.mostrarAlerta("warning","Completar Formulario", mensaje);
		}
	});
	$("#form_registro_asistencia_suplencia").submit(function(event){
		event.preventDefault();
		var mensaje = "";
		if($("#SL_LUGAR_ATENCION_SUPLENCIA").val() == "") mensaje += "- Seleccione el Lugar de Atención<br>";
		if($("#SL_MODALIDAD_ATENCION_SUPLENCIA").val() == "") mensaje += "- Seleccione la Modalidad de Atención<br>";
		if($("#SL_TIPO_ATENCION_SUPLENCIA").val() == "") mensaje += "- Seleccione el Tipo de Atención<br>";
		if($("#SL_TIPO_ATENCION_SUPLENCIA").val() == 3 && $("#SL_MATERIAL_SUPLENCIA").val() == "") mensaje += "- Seleccione el Material Pedagógico<br>";
		if($("#SL_ESPACIO_SUPLENCIA").val() == "") mensaje += "- Seleccione el Espacio<br>";
		if($("#TB_fecha_sesion_suplencia").val() == "") mensaje += "- Seleccione la Fecha de la sesión<br>";
		if($("#SL_HORAS_SESION_SUPLENCIA").val() == "") mensaje += "- Seleccione las Horas de la sesión<br>";

		if(mensaje == ""){
			if($("#TX_observaciones_suplencia").val() == ""){
				parent.swal({
					title: 'Observaciones está vacío',
					text: "¿Desea guardar de todas formas?",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Sí, guardar asistencia',
					cancelButtonText: 'Cancelar y verificar datos'
				}).then(function(){
					guardarAsistenciaSuplencia();
				}, function(dismiss){
					console.log("Cancelada la promesa");
					$("#TX_observaciones_suplencia").focus();
					return false;
				});
			}else{
				guardarAsistenciaSuplencia();
			}
		}
		else{
			parent.mostrarAlerta("warning","Completar Formulario", mensaje);
		}
	});

	$("#div_datos_sesion_clase_modificar").hide();
	$("#fieldset_registro_asistencia_no_grupo").hide();
	$("#TB_fecha_sesion").change(function(){
		$("#BT_guardar_asistencia_clase").attr('data-fecha_sesion',$("#TB_fecha_sesion").val());
	});

	$("#TB_fecha_sesion_suplencia").change(function(){ 
		$("#BT_guardar_asistencia_clase_suplencia").attr('data-fecha_sesion',$("#TB_fecha_sesion_suplencia").val()); 
	});

	$("#BT_guardar_asistencia_clase_modificar_sesion").click(function(){
		var table_estudiantes_sesion_modificar = $("#table_estudiantes_sesion_modificar").DataTable();
		table_estudiantes_sesion_modificar.search('').draw();
		var mensaje = "";
			if($("#SL_LUGAR_ATENCION_MODIFICAR").val() == "") mensaje += "- Seleccione el Lugar de Atención<br>";
			if($("#SL_MODALIDAD_ATENCION_MODIFICAR").val() == "") mensaje += "- Seleccione la Modalidad de Atención<br>";
			if($("#SL_TIPO_ATENCION_MODIFICAR").val() == "") mensaje += "- Seleccione el Tipo de Atención<br>";
			if($("#SL_TIPO_ATENCION_MODIFICAR").val() == 3 && $("#SL_MATERIAL_MODIFICAR").val() == "") mensaje += "- Seleccione el Material Pedagógico<br>";
			if($("#SL_MATERIAL_MODIFICAR").val() == "") mensaje += "- Seleccione el Material Pedagógico<br>";
			if($("#SL_ESPACIO_MODIFICAR").val() == "") mensaje += "- Seleccione el Espacio<br>";
			if($("#TB_fecha_sesion_clase_modificar").val() == "") mensaje += "- Seleccione la Fecha de la sesión<br>";
			if($("#SL_HORAS_SESION_MODIFICAR").val() == "") mensaje += "- Seleccione las Horas de la sesión<br>";
			if(mensaje == ""){
				parent.swal({
					title: '¿Desea Continuar?',
					text: "Recuerde que se remplazará toda la asistencia y las observaciones.",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Si, modificar asistencia',
					cancelButtonText: 'Cancelar y verificar datos'
				}).then(function(){
				var CH_asistencia_estudiante_modificar_sesion = new Array();
				var checkbox_tipo_atencion_estudiantes_modificar = new Array();
				$('.asistencia_clase_modificar').each(function() {
					CH_asistencia_estudiante_modificar_sesion.push(new Array($(this).data('id_estudiante'),$(this).prop('checked')));
				});

				if($("#SL_MODALIDAD_ATENCION_MODIFICAR").val() == "3"){
					$('.tipo_atencion_estudiante_modificar').each(function() {
						checkbox_tipo_atencion_estudiantes_modificar.push(new Array($(this).data('id_estudiante'),$(this).prop('checked')));
					});
				}

				CH_asistencia_estudiante_modificar_sesion = JSON.stringify(CH_asistencia_estudiante_modificar_sesion);
				checkbox_tipo_atencion_estudiantes_modificar = JSON.stringify(checkbox_tipo_atencion_estudiantes_modificar);

				consultarHorasClaseSesion('modificar', "SL_HORAS_SESION_MODIFICAR");
				datos = {
					p1: {
						'id_sesion_clase' : $("#SL_fecha_sesion_grupo_modificar").val(),
						'CH_asistencia_estudiante': CH_asistencia_estudiante_modificar_sesion,
						'observaciones': $("#TX_observaciones_modificar_sesion_clase").val(),
						'id_usuario': parent.idUsuario,
						'fk_salon': $("#SL_ESPACIO_MODIFICAR").val(),
						'lugar_atencion': $("#SL_LUGAR_ATENCION_MODIFICAR").val(),
						'modalidad_atencion': $("#SL_MODALIDAD_ATENCION_MODIFICAR").val(),
						'tipo_atencion': $("#SL_TIPO_ATENCION_MODIFICAR").val(),
						'material': $("#SL_MATERIAL_MODIFICAR").val(),
						'salon': $("#SL_ESPACIO_MODIFICAR").val(),
						'id_grupo': $("#SL_grupo_modificar").val(),
						'CH_tipo_atencion_estudiante': checkbox_tipo_atencion_estudiantes_modificar
					},p2: {
						tipo_grupo : $("#SL_fecha_sesion_grupo_modificar").find(':selected').data('tipo_grupo')
					}
				};
				$.ajax({
					url:url_ok_obj+'modificarSesionClase',
					type:'POST',
					data: datos,
					dataType: 'html'
				}).done(function(data){
					if(data == 1){
						parent.swal({
							title: 'Modificación realizada.',
							text: "Se ha modificado la sesión de clase satisfactoriamente.",
							type: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'OK'
						}).then(function(){
							$("#modificar_asistencia_tab").click();
							$("#div_datos_sesion_clase_modificar").hide();
						});
					}
					else {
						parent.mostrarAlerta('error','Error','No se ha podido modificar la asistencia');	
					}
				}).fail(function(jqXHR,textStatus){
					parent.mostrarAlerta('error','Error','No se ha podido modificar la asistencia ' + textStatus);
				});
			}, function(dismiss){
				console.log("Cancelada la promesa");
				return false;
			});
			}
			else{
				parent.mostrarAlerta("warning","Completar Formulario", mensaje);
			}
	});

	$("#SPAN_fecha_sesion").click(function(){
		$("#TB_fecha_sesion").focus();
	});

	$("#SPAN_fecha_sesion_supencia").click(function(){
		$("#TB_fecha_sesion_suplencia").focus();
	});

	$("#BT_eliminar_sesion_clase").click(function(){
		var fecha_sesion = $("#SL_fecha_sesion_grupo_modificar").find(':selected').text();
		var id_sesion_clase = $("#SL_fecha_sesion_grupo_modificar").val();

		parent.swal({
			title: '¿Desea continuar?',
			text: "Se va a eliminar el registro de asistencia del día: " + fecha_sesion,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, eliminar asistencia'
		}).then(function(){
			var datos = {
				p1:{
					'id_sesion_clase' : id_sesion_clase,
					'id_usuario' : parent.idUsuario
				},
				p2: {
					'tipo_grupo' : $("#SL_fecha_sesion_grupo_modificar").find(':selected').data('tipo_grupo')
				}
			};  
			$.ajax({
				url: url_ok_obj+'eliminarSesionClase',
				type: 'POST',
				data: datos,
				beforeSend: function(){
					parent.mostrarCargando();
					$("#BT_guardar_asistencia_clase_modificar_sesion").attr("disabled","disabled");
					$("#BT_eliminar_sesion_clase").attr("disabled","disabled");
				},
				async: false
			}).done(function(data){
				parent.cerrarCargando();
				parent.mostrarAlerta('success','Guardado','Se ha eliminado la sesión de clase correctamente.');
				$("#BT_guardar_asistencia_clase_modificar_sesion").removeAttr("disabled");
				$("#BT_eliminar_sesion_clase").removeAttr("disabled");
				$("#SL_grupo_modificar").html(getGruposParaModificar()).selectpicker('refresh');
				$("#modificar_asistencia_tab").click();
				$("#div_datos_sesion_clase_modificar").hide();
				getSesionesClaseGrupoModificar();
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('error','Error','No se ha podido eliminar la sesión de clase.' + textStatus);
			});
		}, function(dismiss){
			console.log("Cancelada la promesa");
			return false;
		});
	});

	$("#SL_clan_taller_laboratorio_no_grupo").html(parent.getOptionsClanes()).selectpicker('refresh');
	$("#SL_area_artistica_laboratorio_no_grupo").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
	$("#SL_lugar_atencion_laboratorio_no_grupo").html("").selectpicker('refresh');

	$("#div_table_estudiantes_grupo").delegate(".solicitar_remover_estudiante_grupo","click",function(ev){
		var id_estudiante = $(this).data('id_estudiante');
		var identificacion_estudiante = $(this).data('identificacion_estudiante');
		var nombre_estudiante = $(this).data('nombre_estudiante');
		$("#BT_solictar_retiro").data('id_estudiante',id_estudiante);
		$("#BT_solictar_retiro").data('identificacion_estudiante',identificacion_estudiante);
		$("#BT_solictar_retiro").data('nombre_estudiante',nombre_estudiante);
	});

	$("#BT_solictar_retiro").click(function(ev){
		var id_estudiante = $(this).data('id_estudiante');
		var identificacion_estudiante = $(this).data('identificacion_estudiante');
		var nombre_estudiante = $(this).data('nombre_estudiante');
		var id_grupo = $("#SL_grupo").val();
		var tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		solicitarRemoverEstudianteGrupo(id_estudiante,id_grupo,tipo_grupo,parent.idUsuario,identificacion_estudiante,nombre_estudiante);
	});

	$("#BT_subir_anexo").click(function(ev){
        const id_sesion_clase=$("#SL_fecha_sesion_grupo").val()
        $('#btn_upload').data("id_sesion_clase",id_sesion_clase)
        $('#btn_upload').data("linea_atencion",$("#SL_grupo").find(':selected').data('tipo_grupo'))
        $("#uploadModal").modal({backdrop: 'static', keyboard: false});
	});

	$("#BT_subir_anexo_modificar").click(function(ev){
        const id_sesion_clase=$("#SL_fecha_sesion_grupo_modificar").val()
        $('#btn_upload').data("id_sesion_clase",id_sesion_clase)
        $('#btn_upload').data("linea_atencion",$("#SL_grupo_modificar").find(':selected').data('tipo_grupo'))
        $("#uploadModal").modal({backdrop: 'static', keyboard: false});
	});
	
	$('#btn_upload').click(function(){
        subirAnexoSesion($(this).data('id_sesion_clase'), $(this).data('linea_atencion'), "file_modal", "modal");
    });
	//parent.mostrarAlerta("warning","Alerta","Le informamos que las subsanaciones de Agosto se encuentran abiertas, cierran el 1 de Septimbre a las 11:59 pm <b>y por ningún motivo será posible ampliar el plazo.</b> <br /><br />Por favor esté al día con su registro de asistencia",ejecutar='',timer_=10000);
});

function getGruposParaModificar(){
	var mostrar = "";
	datos = {
		p1: {
			'id_usuario': parent.idUsuario
		}
	};
	$.ajax({
		url:url_ok_obj+'consultarGruposParaModificar',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		mostrar += data;
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta('error','Error','No se ha podido verificar si ya existe un registro de asistencia-sesión de clase para la fecha seleccionada : ' + textStatus);
	});
	return mostrar;
}

function getHorarioClaseGrupo(){
	if($("#SL_grupo").val() == "registrar_asistencia_laboratorio_no_grupo"){
		$("#fieldset_registro_asistencia_grupos").hide("hide");
		$("#fieldset_registro_asistencia_no_grupo").show("slow");
	}else{
		$("#fieldset_registro_asistencia_grupos").show("hide");
		$("#fieldset_registro_asistencia_no_grupo").hide("slow");
		datos = {
			p1: {
				'id_grupo' : $("#SL_grupo").val()
			},
			p2: {
				'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
			}
		};
		if($("#SL_grupo").val() != null){
			$.ajax({
				url:url_ok_obj+'consultarHorarioGrupo',
				type:'POST',
				data: datos,
				beforeSend: function(){
					parent.mostrarCargando();
				},
				async: false
			}).done(function(data){
				parent.cerrarCargando();
				if(data != ""){
					try{
						var fecha = new Date();
						fecha_inicio = getDiaInicioHabilitarRegistroSesionesClase();
						data = $.parseJSON(data);
						$("#TB_horas_clase_semana").val(data['horas_clase']);
						$("#TB_dias_clase_semana").val(data['horario_clase']);
						$("#TB_fecha_sesion").val("");
						$("TB_fecha_sesion").datepicker('destroy');
						dias_no_clase = diasNoClaseGrupo();
						$("#TB_fecha_sesion").datepicker({
							format: 'yyyy-mm-dd',
							weekStart: 1,
							language: 'es',
							endDate: hoy,
							autoclose: true,
							title: 'Fecha de la sesión'
						});
						$('#TB_fecha_sesion').datepicker('setStartDate',fecha_inicio);
						// $('#TB_fecha_sesion').datepicker('setDaysOfWeekHighlighted',dias_no_clase);
						switch($("#SL_grupo").find(':selected').data('tipo_grupo')){
							case 'arte_escuela':
							// $('#TB_fecha_sesion').datepicker('setDaysOfWeekDisabled',dias_no_clase);
							break;
							case 'laboratorio_clan':
							case 'emprende_clan':
							// $('#TB_fecha_sesion').datepicker('setDaysOfWeekDisabled',[]);
							break;
							default:
							console.log("No se puede identificar grupo para activar calendario");
						}
						dias_cancelados_y_festivos = consultarDiasDelMesFestivosYCanceladosPorCoordinador();
						cargarDatosEstudiantesGrupo();
						$(".tipo_atencion_estudiante").bootstrapToggle("destroy");
						$(".tipo_atencion_estudiante").css("display", "none");
					}catch(ex){
						console.log("Excepcion: " + ex + data);
					}
				}else{
					console.log("No hay grupos asignados");
				}
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('error','Error','No se pudo cargar el horario del grupo: ' + textStatus);
			});
		}else{
			$("#mi_asistencia_tab").hide();
			$("#mi_asistencia").hide();
			parent.mostrarAlerta('warning',"No hay datos","No se han encontrados grupos asignados.");
		}
	}
}

function diasNoClaseGrupo(){
	var dias_si_clase = [];
	var datos = {
		p1: {
			'id_grupo' : $("#SL_grupo").val()
		},p2: {
			'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo')
		}
	}
	$.ajax({
		url:url_ok_obj+'consultarDiasClaseGrupo',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		data = $.parseJSON(data);
		dias_si_clase = data;
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta('error','Error','No se pudieron cargar los dias que no tiene clase el grupo : ' + textStatus);
	});
	var dias_no_clase = ["0","1","2","3","4","5","6"];  // falta el 1
	for (var i = dias_si_clase.length - 1; i >= 0; i--) {
		dias_no_clase[($.inArray(dias_si_clase[i],dias_no_clase))] = "";
	}
	return dias_no_clase;
}

function cargarDatosEstudiantesGrupo(){
	datos = {
		p1: {
			'id_grupo': $("#SL_grupo").val(),
			'estado': 1,
			'tipo_sesion_clase': 'titular'
		}, p2:{
			'tipo_grupo': $("#SL_grupo").find(':selected').data('tipo_grupo')
		}
	}

	$("#BT_guardar_asistencia_clase").attr('data-id_grupo',$("#SL_grupo").val());   
	$("#BT_guardar_asistencia_clase").attr('data-fecha_sesion',$("#TB_fecha_sesion").val());
	$("#BT_guardar_asistencia_clase").attr('data-tipo_grupo',$("#SL_grupo").find(':selected').data('tipo_grupo'));
	$.ajax({ 
		url:url_ok_obj+'consultarEstudiantesPorEstadoGrupo',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		$("#div_table_estudiantes_grupo").html(data);
		//parent.mostrarAlerta("warning","Alerta","Le informamos que las subsanaciones de Agosto se encuentran abiertas, cierran el 01 de Septiembre a las 11:59 pm <b>y por ningún motivo será posible ampliar el plazo.</b> <br /><br />Por favor esté al día con su registro de asistencia",ejecutar='',timer_=10000);
	}).fail(function(jqXHR,textStatus){
		parent.error('error','Error','No se ha podido cargar los datos de los estudiantes:  ' + textStatus)
	});

	var table_estudiantes_grupo = $("#table_estudiantes_grupo").DataTable({ 
		"pageLength": 500,
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
			exportOptions: {
				columns: ':visible' 
			},
			title: 'Asistencias clase grupo ' + $("#SL_grupo").val() + ' del mes ' + $("#SL_mes_clase").val()
		},
		],
		order: [[2, "asc"]],
		columnDefs: [
			{ orderable: false, targets: '_all' }
		],
		"searching": false
	}).on( 'draw', function () {
		$('.asistencia_clase').bootstrapToggle({
			on: 'SÍ',
			off: 'NO',
			onstyle: 'success',
			offstyle: 'danger'
		});
		$('.tipo_atencion_estudiante').bootstrapToggle({
			on: 'PRESENCIAL',
			off: 'VIRTUAL',
			onstyle: 'success',
			offstyle: 'danger'
		});
		// $(".asistencia_clase").bootstrapToggle('off');
		// $(".tipo_atencion_estudiante").bootstrapToggle('destroy');
		// $(".tipo_atencion_estudiante").css("display","none");
	}).draw();
	
	table_estudiantes_grupo.search('').draw();
}

function guardarAsistencia(){
	var table_estudiantes_grupo = $("#table_estudiantes_grupo").DataTable();
	table_estudiantes_grupo.search('').draw();
	if(!verificarReporteEnRevision()){
		if(verificarFechaNoHaRegistradoAsistencia("SL_grupo", "TB_fecha_sesion")){
			parent.mostrarAlerta('error','Duplicidad de asistencia', 'Ya se registró asistencia para el día seleccionado');
			$("#TB_fecha_sesion").focus();
		}else{
			var dia_festivo = false;
			for (var i = dias_cancelados_y_festivos.length - 1; i >= 0; i--) {
				if(dias_cancelados_y_festivos[i]['dia'] == $("#TB_fecha_sesion").val()){
					dia_festivo = true;
				}
			}
			if(dia_festivo){
				parent.mostrarAlerta('error','Día No Activo', 'Este día es feriado o la fecha fue cancelada por el cooridnador del CREA, por lo cual no está disponible el registro de asistencia.');
			}else{
				var checkbox_asistencia_estudiantes = new Array();
				var checkbox_tipo_atencion_estudiantes = new Array();
				$('.asistencia_clase').each(function() {
					checkbox_asistencia_estudiantes.push(new Array($(this).data('id_estudiante'),$(this).prop('checked')));
				});
				if($("#SL_MODALIDAD_ATENCION").val() == "3"){
					$('.tipo_atencion_estudiante').each(function() {
						checkbox_tipo_atencion_estudiantes.push(new Array($(this).data('id_estudiante'),$(this).prop('checked')));
					});
				}
				checkbox_asistencia_estudiantes = JSON.stringify(checkbox_asistencia_estudiantes);
				checkbox_tipo_atencion_estudiantes = JSON.stringify(checkbox_tipo_atencion_estudiantes);
				
				dias_no_clase = diasNoClaseGrupo();
				var f = $("#TB_fecha_sesion").val().split("-");
				var fecha_sesion = new Date(f[0],f[1]-1,f[2]);
				var flag = false;
				for (var i = 0; i < dias_no_clase.length; i++) {
					if (dias_no_clase[i] == fecha_sesion.getDay()) {
						flag = true;
					}
				}
				if(flag){
					horas_sesion_clase = $("#SL_HORAS_SESION").val();
					console.log("Día no horario");
				}else{
					consultarHorasClaseSesion('titular');
				}

				datos = {
					p1:{
						'suplencia': 0,
						'id_grupo' : $("#SL_grupo").val(),
						'fecha_clase': $("#TB_fecha_sesion").val(),
						'horas_sesion_clase': horas_sesion_clase,
						'fk_salon': $("#SL_ESPACIO").val(),
						'lugar_atencion': $("#SL_LUGAR_ATENCION").val(),
						'modalidad_atencion': $("#SL_MODALIDAD_ATENCION").val(),
						'tipo_atencion': $("#SL_TIPO_ATENCION").val(),
						'material': $("#SL_MATERIAL").val(),
						'id_usuario': parent.idUsuario,
						'id_rol' : parent.idRol,
						'observaciones': $("#TX_observaciones").val(),
						'CH_asistencia_estudiante': checkbox_asistencia_estudiantes,
						'CH_tipo_atencion_estudiante': checkbox_tipo_atencion_estudiantes
					},
					p2:{
						'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
					}
				}
				$.ajax({
					url:url_ok_obj+'guardarSesionClase',
					type:'POST',
					data: datos,
					beforeSend: function(){
						$("#BT_guardar_asistencia_clase").attr("disabled","disabled");
						parent.mostrarCargando();
					}
				}).done(function(data){
					if(data > 0){
						if($("#file")[0].files.length > 0){
							subirAnexoSesion(data, $("#SL_grupo").find(':selected').data('tipo_grupo'), "file", "formulario");
						}
						parent.cerrarCargando();
						parent.mostrarAlerta('success','Asistencia guardada', 'Se ha registrado la sesión correctamente.');
						setTimeout(function(){
							$("#form_registro_asistencia").trigger("reset");
							$("#SL_grupo").trigger("change");
							$(".tipo_atencion_estudiante").css('display', 'none');
							$(".tipo_atencion_estudiante").bootstrapToggle('destroy');
							$(".asistencia_clase").bootstrapToggle('off');
							$(".selectpicker").selectpicker("refresh");
							// $(".asistencia_clase").on("change", function(){
							// 	var id_estudiante= $(this).data("id_estudiante");
							// 	if($(this).prop('checked') && $("#SL_MODALIDAD_ATENCION").val()==3){
							// 		$("#atencion_estudiante_"+id_estudiante).bootstrapToggle("on");
							// 		$("#atencion_estudiante_"+id_estudiante).css("display","block");
							// 	}
							// 	else{
							// 		$("#atencion_estudiante_"+id_estudiante).bootstrapToggle("destroy");
							// 		$("#atencion_estudiante_"+id_estudiante).css("display","none");
							// 	}
							// });
						}, 2000);
					}else{
						parent.mostrarAlerta('error','Lo sentimos','Al parecer ha ocurrido un error en el servidor, revise su reporte de asistencia para asegurarse que la asistencia ha sido guardada, de lo contrario contáctese con el equipo de soporte SIF.');
						console.log(data);
					}
					$("#BT_guardar_asistencia_clase").removeAttr("disabled");
				}).fail(function(jqXHR,textStatus){
					parent.mostrarAlerta('error','Error','No se ha podido guardar la asistencia : ' + textStatus);
				});
			}
		}
	}else{
		parent.mostrarAlerta("error","Error","Su asistencia <b>NO</b> fue guardada. Ya existe un reporte digital para este mes, solicite al equipo de soporte SIF la desaprobación del mismo si necesita registrar más asistencias para el mes.",null,10000);
	}
}

function verificarFechaNoHaRegistradoAsistencia(elemento_grupo, elemento_fecha){
	var registro_asistencia = false;
	datos = {
		p1: {
			'id_grupo' : $("#"+elemento_grupo).val(),
			'fecha_clase': $("#"+elemento_fecha).val()
		},
		p2: {
			'tipo_grupo' : $("#"+elemento_grupo).find(':selected').data('tipo_grupo'),
		}
	};
	$.ajax({
		url:url_ok_obj+'validarFechaSesionClase',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		if(data == 1) registro_asistencia = true;
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta('error','Error','No se ha podido verificar si ya existe un registro de asistencia-sesión de clase para la fecha seleccionada : ' + textStatus);
	});
	return registro_asistencia;
}

function getArtistasFormadoresConGruposActivos(){
	var mostrar = "";
	datos = {
		p1:{
			'id_usuario_actual': parent.idUsuario
		}
	};
	$.ajax({
		url:url_ok_obj+'consultarArtistasFormadoresDeGruposActivos',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		mostrar += data;
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta('error','Error','No se han podido cargar los artistas formadores con grupos activos : ' + textStatus);
	});
	return mostrar;
}

function getGruposArtistaTitular(){
	var tipo_grupo = ['arte_escuela','emprende_clan','laboratorio_clan'];
	var mostrar = "";

	for (var i = 0; i <= tipo_grupo.length - 1; i++) {
		datos = {
			p1: {
				'id_usuario': $("#SL_artista_formador_titular").val()
			},p2:{
				'tipo_grupo':tipo_grupo[i]
			}
		};
		$.ajax({
			url:url_ok_obj+'consultarGruposUsuario',
			type:'POST',
			data: datos,
			beforeSend: function(){
				parent.mostrarCargando();
			},
			async: false
		}).done(function(data){
			parent.cerrarCargando();
			mostrar += data;
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error', 'No se han podido cargar los grupos de ' + tipo_grupo[i] + ' asignados del artista formador titular : ' + textStatus);
		});
	}

	$("#SL_grupo_suplente").html(mostrar).selectpicker('refresh');
	$("#SL_grupo_suplente").change();
	getHorarioClaseGrupoSuplencia();
}

function cargarDatosEstudiantesGrupoSuplencia(){
	datos = {
		p1: {
			'id_grupo' : $("#SL_grupo_suplente").val(),
			'estado': 1,
			'tipo_sesion_clase': 'suplencia'
		},p2: {
			tipo_grupo : $("#SL_grupo_suplente").find(':selected').data('tipo_grupo')
		}
	}

	$("#BT_guardar_asistencia_clase_suplencia").attr('data-tipo_grupo',$("#SL_grupo_suplente").find(':selected').data('tipo_grupo'));
	$("#BT_guardar_asistencia_clase_suplencia").attr('data-id_grupo',$("#SL_grupo_suplente").val());
	$("#BT_guardar_asistencia_clase_suplencia").attr('data-fecha_sesion',$("#TB_fecha_sesion_suplencia").val());  
	$.ajax({
		url:url_ok_obj+'consultarEstudiantesPorEstadoGrupo',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		$("#div_table_estudiantes_grupo_suplencia").html(data);
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta('error','Error','No se han podido cargar los datos de los estudiantes del grupo suplencia : ' + textStatus);
	});
	var table_estudiantes_grupo_suplencia = $("#table_estudiantes_grupo_suplencia").DataTable({
		iDisplayLength: '500',
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		},
		order: [[2, "asc"]],
		columnDefs: [
			{ orderable: false, targets: '_all' }
		],
		"searching": false
	}).on( 'draw', function () {
		$('.asistencia_clase_suplencia').bootstrapToggle({
			on: 'SÍ',
			off: 'NO',
			onstyle: 'success',
			offstyle: 'danger'
		});
		$('.tipo_atencion_estudiante_suplencia').bootstrapToggle({
			on: 'PRESENCIAL',
			off: 'VIRTUAL',
			onstyle: 'success',
			offstyle: 'danger'
		});
		// $(".asistencia_clase_suplencia").bootstrapToggle('off');
		// $(".tipo_atencion_estudiante_suplencia").bootstrapToggle('destroy');
		// $(".tipo_atencion_estudiante_suplencia").css("display","none");
	}).draw();
	table_estudiantes_grupo_suplencia.search('').draw();
}

function getHorarioClaseGrupoSuplencia(){
	var fecha = new Date();
	datos = {
		p1: {
			'id_grupo' : $("#SL_grupo_suplente").val()
		},
		p2: {
			'tipo_grupo' : $("#SL_grupo_suplente").find(':selected').data('tipo_grupo')
		}
	};
	$.ajax({
		url:url_ok_obj+'consultarHorarioGrupo',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		fecha_inicio = getDiaInicioHabilitarRegistroSesionesClase();
		data = $.parseJSON(data);
		$("#TB_horas_clase_semana_suplencia").val(data['horas_clase']);
		$("#TB_dias_clase_semana_suplencia").val(data['horario_clase']);
		$("#TB_fecha_sesion_suplencia").val("");
		$("TB_fecha_sesion_suplencia").datepicker('destroy');
		dias_no_clase = diasNoClaseGrupoSuplencia();
		$("#TB_fecha_sesion_suplencia").datepicker({
			format: 'yyyy-mm-dd',
			language: 'es',
			endDate: '+0d',
			autoclose: true,
			title: 'Fecha de la sesión'
		});
		$(".tipo_atencion_estudiante_suplencia").bootstrapToggle("destroy");
		$(".tipo_atencion_estudiante_suplencia").css("display", "none");
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta('error','Error','No se ha podido cargar el horario del grupo suplencia : ' + textStatus);
	});
	$('#TB_fecha_sesion_suplencia').datepicker('setStartDate',fecha_inicio);
	// $('#TB_fecha_sesion_suplencia').datepicker('setDaysOfWeekHighlighted',dias_no_clase);
	// $('#TB_fecha_sesion_suplencia').datepicker('setDaysOfWeekDisabled',dias_no_clase);
	cargarDatosEstudiantesGrupoSuplencia();
}

function diasNoClaseGrupoSuplencia(){
	var dias_si_clase = [];
	var datos = {
		p1: {
			'id_grupo' : $("#SL_grupo_suplente").val()
		},p2: {
			'tipo_grupo' : $("#SL_grupo_suplente").find(':selected').data('tipo_grupo')
		}
	}
	$.ajax({
		url:url_ok_obj+'consultarDiasClaseGrupo',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		data = $.parseJSON(data);
		dias_si_clase = data;
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta('error','Error','No se han podido cargar los días de clase del grupo suplencia : ' + textStatus);
	});
	var dias_no_clase = ["0","1","2","3","4","5","6"];  // falta el 1
	for (var i = dias_si_clase.length - 1; i >= 0; i--) {
		dias_no_clase[($.inArray(dias_si_clase[i],dias_no_clase))] = "";
	}
	return dias_no_clase;
}

function guardarAsistenciaSuplencia(){
	var table_estudiantes_grupo_suplencia = $("#table_estudiantes_grupo_suplencia").DataTable();
	table_estudiantes_grupo_suplencia.search('').draw();
	if(verificarFechaNoHaRegistradoAsistencia("SL_grupo_suplente", "TB_fecha_sesion_suplencia")){
		parent.mostrarAlerta('error','Duplicidad de asistencia', 'Ya se registró asistencia para el día seleccionado.', function(){ $("#TB_fecha_sesion_suplencia").focus(); });
		$("#TB_fecha_sesion_suplencia").focus();
	}else{
		var checkbox_asistencia_estudiantes = new Array();
		var checkbox_tipo_atencion_estudiantes = new Array();
		$('.asistencia_clase_suplencia').each(function() {
			checkbox_asistencia_estudiantes.push(new Array($(this).data('id_estudiante'),$(this).prop('checked')));
		});
		if($("#SL_MODALIDAD_ATENCION_SUPLENCIA").val() == "3"){
			$('.tipo_atencion_estudiante_suplencia').each(function() {
				checkbox_tipo_atencion_estudiantes.push(new Array($(this).data('id_estudiante'),$(this).prop('checked')));
			});
		}
		checkbox_asistencia_estudiantes = JSON.stringify(checkbox_asistencia_estudiantes);
		checkbox_tipo_atencion_estudiantes = JSON.stringify(checkbox_tipo_atencion_estudiantes);

		dias_no_clase = diasNoClaseGrupoSuplencia();
		var f = $("#TB_fecha_sesion_suplencia").val().split("-");
		var fecha_sesion = new Date(f[0],f[1]-1,f[2]);
		var flag = false;
		for (var i = 0; i < dias_no_clase.length; i++) {
			if (dias_no_clase[i] == fecha_sesion.getDay()) {
				flag = true;
			}
		}
		horas_sesion_clase = $("#SL_HORAS_SESION_SUPLENCIA").val();

		datos = {
			p1:{
				id_grupo : $("#SL_grupo_suplente").val(),
				'suplencia': 1,
				'fecha_clase': $("#TB_fecha_sesion_suplencia").val(),
				'organizacion_artista_formador': $("#SL_organizacion_artista_formador").val(),
				'horas_sesion_clase': horas_sesion_clase,
				'fk_salon': $("#SL_ESPACIO_SUPLENCIA").val(),
				'lugar_atencion': $("#SL_LUGAR_ATENCION_SUPLENCIA").val(),
				'modalidad_atencion': $("#SL_MODALIDAD_ATENCION_SUPLENCIA").val(),
				'tipo_atencion': $("#SL_TIPO_ATENCION_SUPLENCIA").val(),
				'material' : $("#SL_MATERIAL_SUPLENCIA").val(),
				'id_usuario': parent.idUsuario,
				'id_rol':parent.idRol,
				// 'observaciones': "Suplencia - " + $("#TX_observaciones_suplencia").val(),
				'observaciones': $("#TX_observaciones_suplencia").val(),
				'CH_asistencia_estudiante': checkbox_asistencia_estudiantes,
				'CH_tipo_atencion_estudiante': checkbox_tipo_atencion_estudiantes,
				'id_artista_formador_titular_grupo': $("#SL_artista_formador_titular").val()
			},
			p2:{
				'tipo_grupo' : $("#SL_grupo_suplente").find(':selected').data('tipo_grupo')
			}
		}
		$.ajax({
			url:url_ok_obj+'guardarSesionClase',
			type:'POST',
			data: datos,
			beforeSend: function(){
				$("#BT_guardar_asistencia_clase_suplencia").attr("disabled","disabled");
				parent.mostrarCargando();
			}
		}).done(function(data){
			var fuente = "formulario";
			if(data > 0){
				if($("#file_suplencia")[0].files.length > 0){
					subirAnexoSesion(data, $("#SL_grupo_suplente").find(':selected').data('tipo_grupo'), "file_suplencia", "formulario");
				}
				$("#form_registro_asistencia_suplencia").trigger("reset");
				$("#SL_grupo_suplente").trigger("change");
				$(".selectpicker").selectpicker("refresh");
				$(".asistencia_clase_suplencia").bootstrapToggle('off');
				parent.mostrarAlerta('success','Asistencia guardada', 'Se ha registrado la sesión correctamente.');
			}else{
				parent.mostrarAlerta('error','Lo sentimos','Al parecer ha ocurrido un error en el servidor, revise su reporte de asistencia para asegurarse que la asistencia ha sido guardada, de lo contrario contáctese con el equipo de soporte SIF.');
				console.log(data);
			}
			$("#BT_guardar_asistencia_clase_suplencia").removeAttr("disabled");
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se ha podido guardar la sesión de clase suplencia : ' + textStatus);
		});
	}
}

function getSesionesClaseGrupoModificar(){
	
	datos = {
		p1: {
			'id_usuario': parent.idUsuario,
			'id_grupo' : $("#SL_grupo_modificar").val(),
		},
		p2: {
			'tipo_grupo' : $("#SL_grupo_modificar").find(':selected').data('tipo_grupo'),
		}
	};
	$.ajax({
		url:url_ok_obj+'consultarFechaSesionGrupoParaModificar',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		$("#SL_fecha_sesion_grupo_modificar").html(data).selectpicker("refresh");
	}).fail(function(data){
		console.log("fail" + data);
	});
}

function cargarDatosSesionClase(){
	//var table_estudiantes_sesion_modificar = $("#table_estudiantes_sesion_modificar").DataTable();
	//table_estudiantes_sesion_modificar.clear();
	datos = {
		p1: {
			'id_sesion_clase': $("#SL_fecha_sesion_grupo_modificar").val(),	
			'tipo_sesion_clase': 'modificar',
			'id_grupo_modificar': $("#SL_grupo_modificar").val()
		}, p2:{
			'tipo_grupo': $("#SL_fecha_sesion_grupo_modificar").find(':selected').data('tipo_grupo')
		}
	}
	$("#BT_guardar_asistencia_clase_modificar_sesion").attr('data-fecha_sesion',$("#SL_fecha_sesion_grupo_modificar").val()); 
	$("#BT_guardar_asistencia_clase_modificar_sesion").attr('data-tipo_grupo',$("#SL_grupo_modificar").find(':selected').data('tipo_grupo'));
	$("#BT_guardar_asistencia_clase_modificar_sesion").attr('data-id_grupo',$("#SL_fecha_sesion_grupo_modificar").val());  
	if($("#SL_fecha_sesion_grupo_modificar").val() != null){
		$.ajax({
			url: url_ok_obj+'consultarEstudiantesAsistenciaSesionClase',
			type: 'POST',
			data: datos,
			beforeSend: function(){
				parent.mostrarCargando();
				$("#div_datos_sesion_clase_modificar").hide();
			},
			async: false
		}).done(function(data){
			parent.cerrarCargando();
			$("#div_table_estudiantes_sesion_modificar").html(data);
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se han podido cargar los datos de la sesión de clase a modficar : ' + textStatus);
		});

		var table_estudiantes_sesion_modificar = $("#table_estudiantes_sesion_modificar").DataTable({
			iDisplayLength: '500',
			"language": {
				"lengthMenu": "Ver _MENU_ registros por pagina",
				"zeroRecords": "No hay información, lo sentimos.",
				"info": "Mostrando pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"search": "Filtrar"
			},
			order: [[2, "asc"]],
			columnDefs: [
			{ orderable: false, targets: '_all' }
			],
			"searching": false
		}).on('draw', function () {
			$('.asistencia_clase_modificar').bootstrapToggle({
				on: 'SÍ',
				off: 'NO',
				onstyle: 'success',
				offstyle: 'danger'
			});
			$('.tipo_atencion_estudiante_modificar').bootstrapToggle({
				on: 'PRESENCIAL',
				off: 'VIRTUAL',
				onstyle: 'success',
				offstyle: 'danger'
			});
			//$(".asistencia_clase_modificar").bootstrapToggle('off');
		}).draw();
		table_estudiantes_sesion_modificar.search('').draw();

		$("#div_datos_sesion_clase_modificar").show("slow");
		$(".tipo_atencion_estudiante_modificar").bootstrapToggle("destroy");
		$(".tipo_atencion_estudiante_modificar").css("display", "none");
		$("#SL_MODALIDAD_ATENCION_MODIFICAR").change();
		$("#SL_TIPO_ATENCION_MODIFICAR").val($("#SL_fecha_sesion_grupo_modificar option:selected").data('tipo_atencion')).selectpicker("refresh");
		$("#SL_TIPO_ATENCION_MODIFICAR").change();
		datos = {
			p1:{
				'id_sesion_clase' : $("#SL_fecha_sesion_grupo_modificar").val(),
			},p2:{
				'tipo_grupo' : $("#SL_fecha_sesion_grupo_modificar").find(':selected').data('tipo_grupo')
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarObservacionSesionClase',
			type: 'POST',
			data: datos,
		}).done(function(data){
			$("#TX_observaciones_modificar_sesion_clase").val(data);
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta('error','Error','No se ha podido cargar las observaciones de la sesión de clase del grupo a modificar : ' + textStatus);
		});
	}else{
		$("#div_datos_sesion_clase_modificar").hide();
	}
}

function getDiaInicioHabilitarRegistroSesionesClase(){
	fecha_inicio = "";
	datos = {
	};
	$.ajax({
		url:url_ok_obj+'consultarDiaInicioHabilitarRegistroSesionClase',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		fecha_inicio += data;
	}).fail(function(data){
		parent.mostrarAlerta("error","error","No se pudo consultar las fechas que han sido canceladas por el Coordinador CREA para establecer el calendario.");
		console.log("fail" + data);
	});
	return fecha_inicio;
}

function uploadFiles(event){
	event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening
    var data = new FormData();
    $.each(files, function(key, value)
    {
    	data.append(key, value);
    });
    $.ajax({
    	url: url_service + '?files',
    	type: 'POST',
    	data: data,
    	cache: false,
    	dataType: 'html',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        beforeSend: function(){

        },
        success: function(data)
        {
        	console.log(data);
        	if(data == 'no_subio'){
        		alert("El archivo no subio por un error interno del servidor. Por favor comuniquese con el equipo de soporte para subir el archivo manualmente.");
        	}
        },
        error: function(data){
        	console.log("Error: " + data);
        }
    });
}

function solicitarRemoverEstudianteGrupo(id_estudiante,id_grupo,tipo_grupo,id_usuario,identificacion_estudiante,nombre_estudiante){
	var tipo_grupo_lt = '';
	if(tipo_grupo == 'arte_escuela'){tipo_grupo_lt = 'AE-';}
	else if(tipo_grupo == 'emprende_clan'){tipo_grupo_lt = 'EC-';}
	else if(tipo_grupo == 'laboratorio_clan'){tipo_grupo_lt = 'LaboratorioClan-';}
	var razon_retiro = $("#SL_razon_retiro_estudiante").val();
	var texto_notificacion = "El artista formador " + $("#nombre_usuario",parent.document).text() + " solicita remover al estudiante <b>" + identificacion_estudiante + "</b> - " + nombre_estudiante + " del grupo <b>" + tipo_grupo_lt + id_grupo + "</b> por la siguiente razón: <b>" + razon_retiro + "</b>";

	parent.swal({
		title: 'Estas seguro?',
		text: "Se solicitará al coordinador del CREA que remueva al estudiante",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Sí, solicitar retiro de estudiante.'
	}).then(function(){
		var id_coordinador_crea = getIdCoordinadorClan(tipo_grupo,id_grupo);
		if(id_coordinador_crea != 0){
			parent.mostrarAlerta('success','Solicitud enviada','Se ha enviado la solicitud al coordinador del Clan');
			var notificacion = { 
				VC_Url:"GestionClan/Asignacion_Estudiantes_Grupo.php?option_ext=remover_estudiante&id_estudiante=" + id_estudiante + "&id_grupo=" + id_grupo + "&tipo_grupo=" + tipo_grupo + "&id_usuario_solicita=" + id_usuario + "&identificacion_estudiante=" + identificacion_estudiante,
				VC_Icon:"fa-2x fa fa-child", 
				VC_Contenido: texto_notificacion,
				userId: id_coordinador_crea,
			}
			window.parent.sendNotificationUser(notificacion);
		}
	}, function(dismiss){
		console.log("Cancelada la promesa");
		return false;
	});
}

function getIdCoordinadorClan(tipo_grupo,id_grupo){
	var id_coordinador_crea = 0;
	var datos = {
		p1: {
			'id_grupo': id_grupo,
			'tipo_grupo': tipo_grupo
		}
	}
	$.ajax({
		url: url_ok_obj+'consultarIDCoorinadorActualClanGrupo',
		type: 'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		if(Number.isInteger(parseInt(data))){
			id_coordinador_crea = data;
		}else{
			id_coordinador_crea = 0;
			parent.mostrarAlerta("warning","Algo ha salido mal","No se pudo consultar el id del coordinador CREA");
		}
		$("#modal_retirar_estudiante").modal("hide");
	});
	return id_coordinador_crea;
}

function consultarHorasClaseSesion(tipo_sesion, id_elemento_horas){
	switch(tipo_sesion){
		case 'titular':
		id_grupo = $("#SL_grupo").val();
		tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		fecha_sesion = $("#TB_fecha_sesion").val();
		break;
		case 'suplencia':
		id_grupo = $("#SL_grupo_suplente").val();
		tipo_grupo = $("#SL_grupo_suplente").find(':selected').data('tipo_grupo')
		fecha_sesion = $("#TB_fecha_sesion_suplencia").val();
		break;
		case 'modificar':
		id_grupo = $("#SL_grupo_modificar").val();
		tipo_grupo = $("#SL_grupo_modificar").find(':selected').data('tipo_grupo');
		fecha_sesion = $("#SL_fecha_sesion_grupo_modificar").val();
		break;
		default:
		break;
	}
	datos = {
		p1: {
			'id_grupo': id_grupo,
			'fecha_sesion': fecha_sesion
		},
		p2: {
			'tipo_grupo': tipo_grupo
		}
	};
	$.ajax({
		url:url_ok_obj+'consultarHorasDeClaseDia',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		horas_sesion_clase = parseInt(data);
		$("#"+id_elemento_horas).val(horas_sesion_clase).selectpicker("refresh");
	}).fail(function(data){
		console.log("fail" + data);
		parent.mostrarAlerta("error","Mensaje del sistema","Ha ocurrido un error obteniendo las horas de clase, comuniquese con soporte");
	});
}

function getOrganizacionesArtistaFormador(){
	datos = {
		p1: {
			'id_artista_formador': parent.idUsuario
		}
	};
	$.ajax({
		url:url_ok_obj+'getOrganizacionUsuario',
		type:'POST',
		data: datos,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		async: false
	}).done(function(data){
		parent.cerrarCargando();
		$("#SL_organizacion_artista_formador").html(data).selectpicker("refresh");
	}).fail(function(data){
		console.log("fail" + data);
		parent.mostrarAlerta("error","Mensaje del sistema","Ha ocurrido un error obteniendo las organizaciones que tiene asociadas el artista formador.");
	});
}

function consultarDiasDelMesFestivosYCanceladosPorCoordinador(){
	var _return = "";
	var datos = {
		p1:{
			'id_grupo' : $("#SL_grupo").val(),
			'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
			'id_artista_formador' : parent.idUsuario
		}
	};  
	$.ajax({
		url: url_ok_obj+'consultarDiasDelMesFestivosYCanceladosPorCoordinador',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		try{
			_return = $.parseJSON(data);
		}catch(ex){
			parent.mostrarAlerta("error","Mensaje del sistema","Ha ocurrido un error decodificando JSON de días festivos y con novedad de cancelación.");
			console.log("Excepcion: " + ex + data);
		}
	});
	return _return;
}

function verificarReporteEnRevision(){
	var _return = false;
	var datos = {
		p1:{
			'id_grupo' : $("#SL_grupo").val(),
			'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
			'id_usuario' : parent.idUsuario,
			'fecha_mes' : $("#TB_fecha_sesion").val()
		}
	};  
	$.ajax({
		url: url_ok_obj+'verificarReporteEnRevision',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		try{
			if(data == 0){
				_return = false;
			}else{
				_return = true;
			}
		}catch(ex){
			parent.mostrarAlerta("error","Mensaje del sistema","Ha ocurrido un error verificando si existe reporte en revisión para este mes.");
			_return = true;
			console.log("Excepcion: " + ex + data);
		}
	});
	return _return;
}

function cargarLugaresdeAtencionLinea(linea, tipo_asistencia, tipo_ubicacion){
	if(tipo_asistencia == 'titular'){
		nombre_elemento = "SL_LUGAR_ATENCION";
	}
	if(tipo_asistencia == 'suplencia'){
		nombre_elemento = "SL_LUGAR_ATENCION_SUPLENCIA";
	}
	if(tipo_asistencia == 'modificar'){
		nombre_elemento = "SL_LUGAR_ATENCION_MODIFICAR";
	}

	if(linea == "arte_escuela"){
		$("#"+nombre_elemento).html(parent.getOptionParametroDetalle(56));	
		$("#"+nombre_elemento+" option[value='3']").remove().selectpicker('refresh');
	}
	if (linea == "emprende_clan") {
		$("#"+nombre_elemento).html(parent.getOptionParametroDetalle(57)).selectpicker('refresh');
	}
	if (linea == "laboratorio_clan") {
		$("#"+nombre_elemento).html(parent.getOptionParametroDetalle(39)).selectpicker('refresh');
	}
	$("#"+nombre_elemento).val(tipo_ubicacion).selectpicker("refresh");
	console.log(tipo_ubicacion);
}

function cargarOptionsSLTipoAtencion(modalidad_atencion, elemento_tipo_atencion, elemento_espacio, elemento_grupo, tipo_ubicacion, tipo_grupo){
	$("#"+elemento_tipo_atencion).html(parent.getOptionParametroDetalleByOrder(62, "IN_Ordenacion", "ASC")).selectpicker("refresh");
	//PRESENCIAL
	if(modalidad_atencion == 1){
		$("#"+elemento_tipo_atencion).removeAttr('disabled');
		$("#"+elemento_tipo_atencion+" option[value='2']").remove();
		$("#"+elemento_tipo_atencion+" option[value='3']").remove();
		$("#"+elemento_tipo_atencion+" option[value='4']").remove();
		$("#"+elemento_tipo_atencion+" option[value='5']").remove();
		$("#"+elemento_tipo_atencion+" option[value='6']").remove();
		$("#"+elemento_tipo_atencion).val(1).selectpicker("refresh");

		//SI ES ATENDIDO EN CREA
		if((tipo_ubicacion == "2" && tipo_grupo == 'arte_escuela') || (tipo_ubicacion == "1" && tipo_grupo == 'laboratorio_clan') || (tipo_grupo == 'emprende_clan' && (tipo_ubicacion == "1" || tipo_ubicacion == ""))){
			$("#"+elemento_espacio).removeAttr('disabled');
			$("#"+elemento_modalidad_atencion).removeAttr('disabled').selectpicker("refresh");
			$("#"+elemento_tipo_atencion).removeAttr('disabled');
			$("#"+elemento_espacio).html(parent.getEspaciosCREA($("#"+elemento_grupo).find(':selected').data('crea'))).selectpicker("refresh");
		}
	}
	//NO PRESENCIAL
	if(modalidad_atencion == 2){
		$("#"+elemento_tipo_atencion+" option[value='1']").remove();
		$("#"+elemento_tipo_atencion+" option[value='4']").remove();
		$("#"+elemento_tipo_atencion+" option[value='5']").remove();
		$("#"+elemento_tipo_atencion+" option[value='6']").remove();
		$("#"+elemento_tipo_atencion).selectpicker("refresh");

		$("#"+elemento_espacio).html("<option value='-1' selected>NO APLICA</option>").attr("disabled", "disabled").selectpicker("refresh");
	}
	//MIXTO
	if(modalidad_atencion == 3){
		$("#"+elemento_tipo_atencion+" option[value='1']").remove();
		$("#"+elemento_tipo_atencion+" option[value='2']").remove();
		$("#"+elemento_tipo_atencion+" option[value='3']").remove();
		$("#"+elemento_tipo_atencion).selectpicker("refresh");
		//SI NO ES REMOTO
		if(!(tipo_ubicacion == "4" && tipo_grupo == "arte_escuela") && !(tipo_ubicacion == "3" && tipo_grupo == "emprende_clan") && !(tipo_ubicacion == "4" && tipo_grupo == "laboratorio_clan")){
			$("#"+elemento_tipo_atencion+" option[value='6']").remove();
			$("#"+elemento_tipo_atencion).selectpicker("refresh");
		}
		else{//SI ES REMOTO
			$("#"+elemento_tipo_atencion+" option[value='1']").remove();
			$("#"+elemento_tipo_atencion+" option[value='2']").remove();
			$("#"+elemento_tipo_atencion+" option[value='3']").remove();
			$("#"+elemento_tipo_atencion+" option[value='4']").remove();
			$("#"+elemento_tipo_atencion+" option[value='5']").remove();
			$("#"+elemento_tipo_atencion).val(6).selectpicker("refresh");
		}
		// if((tipo_ubicacion == 1 && tipo_grupo == 'arte_escuela') || (tipo_ubicacion == 4 && tipo_grupo == 'arte_escuela')){
		// 	$("#"+elemento_espacio).html("<option value='-1' selected>NO APLICA</option>").attr("disabled", "disabled").selectpicker("refresh");
		// }
		// else{
		// 	$("#"+elemento_espacio).removeAttr('disabled');
		// 	$("#"+elemento_espacio).html(parent.getEspaciosCREA($("#"+elemento_grupo).find(':selected').data('crea'))).selectpicker("refresh");
		// }
	}
	$("#"+elemento_tipo_atencion).change();
}

function cargarSalonesCREALinea(tipo_ubicacion, tipo_grupo, elemento_grupo, elemento_espacio, elemento_modalidad_atencion, elemento_tipo_atencion){
	//SI ES ATENDIDO EN CREA
	if((tipo_ubicacion == "2" && tipo_grupo == 'arte_escuela') || (tipo_ubicacion == "1" && tipo_grupo == 'laboratorio_clan') || (tipo_grupo == 'emprende_clan' && (tipo_ubicacion == "1" || tipo_ubicacion == ""))){
		$("#"+elemento_espacio).removeAttr('disabled');
		$("#"+elemento_modalidad_atencion).html(parent.getOptionParametroDetalleByOrder(61, "IN_Ordenacion", "ASC")).selectpicker("refresh");
		$("#"+elemento_modalidad_atencion+" option[value='2']").remove();
		$("#"+elemento_modalidad_atencion).val("").removeAttr('disabled').change().selectpicker("refresh");
		$("#"+elemento_espacio).html(parent.getEspaciosCREA($("#"+elemento_grupo).find(':selected').data('crea'))).selectpicker("refresh");
	}
	else{
		$("#"+elemento_espacio).html("<option value='-1' selected>NO APLICA</option>").attr("disabled", "disabled").selectpicker("refresh");
		//$("#"+elemento_tipo_atencion).val(2).attr("disabled", "disabled").selectpicker("refresh");
		if((tipo_ubicacion == "4" && tipo_grupo == "arte_escuela") || (tipo_ubicacion == "3" && tipo_grupo == "emprende_clan") || (tipo_ubicacion == "4" && tipo_grupo == "laboratorio_clan")){
			$("#"+elemento_modalidad_atencion).html(parent.getOptionParametroDetalleByOrder(61, "IN_Ordenacion", "ASC")).selectpicker("refresh");
			$("#"+elemento_modalidad_atencion+" option[value='1']").remove();
			$("#"+elemento_modalidad_atencion).selectpicker("refresh");
			//$("#"+elemento_modalidad_atencion).val(2).attr("disabled", "disabled").change().selectpicker("refresh");
		}else{
			$("#"+elemento_modalidad_atencion).html(parent.getOptionParametroDetalleByOrder(61, "IN_Ordenacion", "ASC")).selectpicker("refresh");
			$("#"+elemento_modalidad_atencion+" option[value='2']").remove();
			$("#"+elemento_modalidad_atencion).selectpicker("refresh");
			$("#"+elemento_modalidad_atencion).val("").removeAttr('disabled').change().selectpicker("refresh");
		}
	}
}

function subirAnexoSesion(id_sesion_clase, linea_atencion, id_elemento, fuente){
		var data_form = new FormData();
        if($("#"+id_elemento)[0].files.length > 0){
			try{
	            anexo_sesion = $("#"+id_elemento)[0].files;
        	}catch(err){
	            console.log(err);
        	}
        	try{
				data_form.append(0, anexo_sesion[0]);
			}catch(err){
				console.log(err);
			}
        	// var files = $('#file')[0].files[0];
        	// fd.append('file',files);
        	data_form.append('p1',JSON.stringify({'id_sesion_clase':id_sesion_clase,'linea_atencion':linea_atencion}));
	        // AJAX request
        	$.ajax({	
            	url:url_ok_obj+'subirAnexoSesion',
            	type: 'POST',
            	data: data_form,
            	processData: false, // Don't process the files
            	contentType: false, // Set content type to false as jQuery will tell the server its a query string request
	            async: false
        	}).done(function(data){
            	if(data == 1){
              	$("#uploadModal").modal("hide");
				if(fuente == "modal"){
			  		parent.mostrarAlerta('success','Anexo subido','El anexo ha sido subido correctamente');
				}
			  	$("#"+id_elemento).val('');
			  	setTimeout(function(){ $("#SL_grupo_anexo").trigger('change'); }, 2000);
            	}else{
              	parent.mostrarAlerta("warning","Advertencia",'Al parecer el archivo no pudo ser subido');
	            }
        	});
		}
		else{
			parent.mostrarAlerta("warning","Seleccione un archivo",'Debe seleccionar el archivo que desea anexar');
		}
}

function cargarMaterial(elemento_tipo_atencion, elemento_material){
	if($("#"+elemento_tipo_atencion).val() != 3 && $("#"+elemento_tipo_atencion).val() != 5 && $("#"+elemento_tipo_atencion).val() != 6){
		$("#"+elemento_material).html("<option value='-1' selected>NO APLICA</option>").attr("disabled", "disabled").selectpicker("refresh");
	}
	else{
		$("#"+elemento_material).html(parent.getOptionParametroDetalleByOrder(63, "IN_Ordenacion","ASC"));
		$("#"+elemento_material).val("").removeAttr("disabled").selectpicker("refresh");
	}
}

function mostrarOcultarSelectAtencion(select_asistencia, elemento_modalidad, elemento_tipo_atencion, select_atencion, valor_tipo_atencion=0){
	if($("#"+select_asistencia).prop('checked') && $("#"+elemento_modalidad).val()==3){
		if($("#"+elemento_tipo_atencion).val()!=6){
			$("#"+select_atencion).bootstrapToggle("destroy");
			$("#"+select_atencion).css("display","none");
			$("#"+select_atencion).bootstrapToggle({
				on: 'PRESENCIAL',
				off: 'VIRTUAL',
				onstyle: 'success',
				offstyle: 'danger'
			});
			if(valor_tipo_atencion == 0)
				$("#"+select_atencion).bootstrapToggle("off");
			if(valor_tipo_atencion == 1)
				$("#"+select_atencion).bootstrapToggle("on");
			if(valor_tipo_atencion == 2)
				$("#"+select_atencion).bootstrapToggle("off");
			if(valor_tipo_atencion == 3)
				$("#"+select_atencion).bootstrapToggle("off");
		}
		else{
			$("#"+select_atencion).bootstrapToggle("destroy");
			$("#"+select_atencion).css("display","none");
			$("#"+select_atencion).bootstrapToggle({
				on: 'SINCRÓNICO',
				off: 'ASINCRÓNICO',
				onstyle: 'success',
				offstyle: 'danger'
			});
			if(valor_tipo_atencion == 0)
				$("#"+select_atencion).bootstrapToggle("on");
			if(valor_tipo_atencion == 1)
				$("#"+select_atencion).bootstrapToggle("on");
			if(valor_tipo_atencion == 2)
				$("#"+select_atencion).bootstrapToggle("on");
			if(valor_tipo_atencion == 3)
				$("#"+select_atencion).bootstrapToggle("off");
		}

		$("#"+select_atencion).css("display","block");
	}
	else{
		$("#"+select_atencion).bootstrapToggle("destroy");
		$("#"+select_atencion).css("display","none");
	}
}