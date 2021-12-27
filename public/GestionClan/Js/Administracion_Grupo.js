var url_ok_obj = '../../src/GestionClan/GestionClanController/';
var options_crea;
var options_linea_atencion;
var options_areas_artisticas;
var options_tipo_grupo_converge;
var options_institucion_converge;
var options_categoria_poblacion_converge;
var options_hora_inicio;
var options_tipo_grupo_impulso;
var options_convenio;
var options_espacio_alterno_converge;

$(function(){

	options_crea = parent.getOptionsClanes();
	options_linea_atencion = parent.getOptionsLineasAtencion();
	options_areas_artisticas = parent.getOptionsAreasArtisticas();
	options_tipo_grupo_converge = parent.getOptionParametroDetalle(38);
	options_institucion_converge = parent.getOptionParametroDetalle(36);
	options_categoria_poblacion_converge = parent.getOptionParametroDetalle(37);
	options_hora_inicio = getHorasInicio();
	options_tipo_grupo_impulso = parent.getOptionParametroDetalle(67);
	options_convenio = parent.getOptionParametroDetalle(68);
	options_espacio_alterno_converge = parent.getOptionParametroDetalle(69);

	//Cargue selects creación grupo
	$("#SL_linea_atencion").html(options_linea_atencion).selectpicker("refresh");

	$("#SL_clan").html(options_crea).change(function(){
		$("#SL_colegio_responsable").html(getColegiosResponsables($("#SL_clan").val())).selectpicker("refresh");
	}).selectpicker("refresh");
	
	$("#SL_area_artistica").html(options_areas_artisticas).change(function(){
		$("#SL_modalidad_area_artistica").html(getModalidad($("#SL_area_artistica").val())).selectpicker('refresh');
	}).selectpicker("refresh");

	$("#SL_tipo_grupo_emprende_clan").html(options_tipo_grupo_impulso).selectpicker("refresh");
	$("#SL_convenio").html(options_convenio).selectpicker("refresh");

	$("#SL_tipo_grupo_laboratorio_crea").html(options_tipo_grupo_converge).selectpicker('refresh');

	$("#SL_institucion_laboratorio_crea").html(options_institucion_converge).change(function(){
		var id_institucion = $(this).val();
		$("#SL_aliado_laboratorio_crea").html(consultarAliadosLaboratorioCrea(id_institucion)).selectpicker('refresh');
	}).selectpicker("refresh");

	$("#SL_categoria_poblacion_laboratorio").html(options_categoria_poblacion_converge).change(function(){
		var id_categoria_poblacion = $(this).val();
		$("#SL_subcategoria_poblacion_laboratorio").html(consultarTipoPoblacionLaboratorio(id_categoria_poblacion)).selectpicker('refresh');
	}).selectpicker("refresh");

	$("#SL_espacio_alterno_converge").html(options_espacio_alterno_converge).selectpicker("refresh");

	$("select[id^='SL_hora_inicio_dia_']").html(options_hora_inicio).selectpicker('refresh');
	$("select[id^='SL_hora_fin_dia_']").html(options_hora_inicio).selectpicker('refresh');
	
	//Cargue selects modificación grupo
	$("#SL_linea_atencion_modificar").html(options_linea_atencion).selectpicker("refresh");

	$("#SL_clan_modificar_grupo").html(options_crea).change(function(){
		$("#SL_grupo_modificar").html(parent.getOptionGruposDeUnCrea($("#SL_clan_modificar_grupo").val())).selectpicker('refresh');
	}).selectpicker("refresh");

	$("#SL_area_artistica_modificar").html(options_areas_artisticas).change(function(){
		$("#SL_modalidad_area_artistica_modificar").html(getModalidad($("#SL_area_artistica_modificar").val())).selectpicker('refresh');
	}).selectpicker("refresh");

	$("#SL_tipo_grupo_emprende_clan_modificar").html(options_tipo_grupo_impulso).selectpicker("refresh");
	$("#SL_convenio_modificar").html(options_convenio).selectpicker("refresh");

	$("#SL_tipo_grupo_laboratorio_crea_modificar").html(options_tipo_grupo_converge).selectpicker('refresh');

	$("#SL_institucion_laboratorio_crea_modificar").html(options_institucion_converge).selectpicker('refresh').change(function(){
		var id_institucion = $(this).val();
		$("#SL_aliado_laboratorio_crea_modificar").html(consultarAliadosLaboratorioCrea(id_institucion)).selectpicker('refresh');
	});

	$("#SL_categoria_poblacion_laboratorio_modificar").html(options_categoria_poblacion_converge).selectpicker('refresh').change(function(){
		var id_categoria_poblacion = $(this).val();
		$("#SL_subcategoria_poblacion_laboratorio_modificar").html(consultarTipoPoblacionLaboratorio(id_categoria_poblacion)).selectpicker('refresh');
	});

	$("#SL_espacio_alterno_converge_modificar").html(options_espacio_alterno_converge).selectpicker("refresh");

	$("select[id^='SL_modificar_hora_inicio_dia_']").html(options_hora_inicio).selectpicker('refresh');
	$("select[id^='SL_modificar_hora_fin_dia_']").html(options_hora_inicio).selectpicker('refresh');

	//Cargue selects cerrar grupo
	$("#SL_linea_atencion_cerrar_grupo").html(options_linea_atencion).change(cargarGruposActivosCerrar).selectpicker('refresh');
	$("#SL_crea_cerrar_grupo").html(options_crea).change(cargarGruposActivosCerrar).selectpicker('refresh');

	//Cargue selects fusionar grupo
	$("#SL_clan_fusion_grupos").html(options_crea).change(cargarGruposActivosFusionar).selectpicker('refresh');
	$("#SL_linea_atencion_fusion_grupos").html(options_linea_atencion).change(cargarGruposActivosFusionar).selectpicker('refresh');


	$(".selectpicker.linea-atencion").change(function(){
		let id_elemento_linea = $(this).attr("id");
		let val_elemento_linea = $(this).val();
		
		$(".arte-escuela").hide();
		$(".impulso-colectivo").hide();
		$(".converge").hide();
		$(".elemento-arte-escuela").attr("required", false);
		$(".elemento-impulso-colectivo").attr("required", false);
		$(".elemento-converge").attr("required", false);

		$(".checkbox_dias_clase").prop("checked",false);
		$('select[id ^= SL_hora_inicio_dia_]').attr("disabled","disabled").removeAttr('required').val('').selectpicker('refresh');
		$('select[id ^= SL_hora_fin_dia_]').attr("disabled","disabled").removeAttr('required').val('').selectpicker('refresh');

		switch(val_elemento_linea){
			case "arte_escuela":
			$(".arte-escuela").show();
			$(".elemento-arte-escuela").attr("required", true);
			$("#b_mensaje_hora_inicio_hora_fin").text("Debe indicar unicamente la hora inicio.");
			$('select[id ^= SL_hora_fin_dia_]').hide().removeAttr("required").selectpicker('hide').selectpicker('refresh');
			break;
			case "emprende_clan":
			$(".impulso-colectivo").show();
			$(".elemento-impulso-colectivo").attr("required", true);
			$("#b_mensaje_hora_inicio_hora_fin").text("Debe indicar la hora inicio y hora fin.");
			$('select[id ^= SL_hora_fin_dia_]').show().attr("required","required").selectpicker('show').selectpicker('refresh');
			break;
			case "laboratorio_clan":
			$(".converge").show();
			$(".elemento-converge").attr("required", true);
			$("#b_mensaje_hora_inicio_hora_fin").text("Debe indicar la hora inicio y hora fin.");
			$('select[id ^= SL_hora_fin_dia_]').show().attr("required","required").selectpicker('show').selectpicker('refresh');
			break;
		}
		getLugaresAtencionLinea(id_elemento_linea, val_elemento_linea);
	}).selectpicker("refresh");

	$(".selectpicker.lugar-atencion").change(function(){
		let id_elemento_lugar = $(this).attr("id");
		let val_elemento_lugar = $(this).val();
		let val_elemento_linea;
		let id_elemento_espacio_alterno;
		val_elemento_linea = id_elemento_lugar == "SL_lugar_atencion" ? $("#SL_linea_atencion").val() : $("#SL_linea_atencion_modificar").val();
		id_elemento_espacio_alterno = id_elemento_lugar == "SL_lugar_atencion" ? "#SL_espacio_alterno_converge" : "#SL_espacio_alterno_converge_modificar";
		if(val_elemento_linea == "laboratorio_clan" && val_elemento_lugar == 3){
			$(id_elemento_espacio_alterno).attr("disabled", false);
			$(id_elemento_espacio_alterno).attr("required", true);
		}else{
			$(id_elemento_espacio_alterno).attr("disabled", true);
			$(id_elemento_espacio_alterno).attr("required", false);
			$(id_elemento_espacio_alterno).selectpicker("val", "");
		}
		$(id_elemento_espacio_alterno).selectpicker("refresh");
		getModalidadesAtencionLugar(id_elemento_lugar, val_elemento_lugar, val_elemento_linea);
	}).selectpicker("refresh");

	$(".selectpicker.modalidad-atencion").change(function(){
		let id_elemento_modalidad_atencion = $(this).attr("id");
		let val_elemento_modalidad_atencion  = $(this).val();
		let id_elemento_tipo_atencion = id_elemento_modalidad_atencion == "SL_modalidad_atencion" ? "#SL_tipo_atencion" : "#SL_tipo_atencion_modificar";
		let id_elemento_lugar = id_elemento_modalidad_atencion == "SL_modalidad_atencion" ? "#SL_lugar_atencion" : "#SL_lugar_atencion_modificar";
		let id_elemento_linea = id_elemento_modalidad_atencion == "SL_modalidad_atencion" ? "#SL_linea_atencion" : "#SL_linea_atencion_modificar";
		$(id_elemento_tipo_atencion).html(parent.getOptionParametroDetalle(62)).selectpicker("refresh");

		if(val_elemento_modalidad_atencion == 1 || val_elemento_modalidad_atencion == 3){
			$(id_elemento_tipo_atencion).children("option[value^='2']").remove();
			$(id_elemento_tipo_atencion).children("option[value^='3']").remove();
		}
		if(val_elemento_modalidad_atencion == 1 || val_elemento_modalidad_atencion == 2){
			$(id_elemento_tipo_atencion).children("option[value^='4']").remove();
			$(id_elemento_tipo_atencion).children("option[value^='5']").remove();
			$(id_elemento_tipo_atencion).children("option[value^='6']").remove();
		}
		if(val_elemento_modalidad_atencion == 2 || val_elemento_modalidad_atencion == 3){
			if(($(id_elemento_linea).val()=="arte_escuela" && $(id_elemento_lugar).val()==4) || ($(id_elemento_linea).val()=="emprende_clan" && $(id_elemento_lugar).val()==3) || ($(id_elemento_linea).val()=="laboratorio_clan" && $(id_elemento_lugar).val()==4)){
				$(id_elemento_tipo_atencion).children("option[value^='4']").remove();
				$(id_elemento_tipo_atencion).children("option[value^='5']").remove();
			}
			else{
				$(id_elemento_tipo_atencion).children("option[value^='6']").remove();
			}
			$(id_elemento_tipo_atencion).children("option[value^='1']").remove();
		}

		$(id_elemento_tipo_atencion).val("").selectpicker("refresh").trigger("change");
	}).selectpicker("refresh");

	$(".selectpicker.oferta-disponible").change(function(){
		let id_elemento_oferta_disponible = $(this).attr("id");
		let val_elemento_oferta_disponible  = $(this).val();
		let id_elemento_cantidad_cupos = id_elemento_oferta_disponible == "SL_oferta_disponible" ? "#TX_cantidad_cupos" : "#TX_cantidad_cupos_modificar";
		if(val_elemento_oferta_disponible == 1){
			$(id_elemento_cantidad_cupos).attr("readonly", false);
			$(id_elemento_cantidad_cupos).attr("required", true);
		}else{
			$(id_elemento_cantidad_cupos).attr("readonly", true);
			$(id_elemento_cantidad_cupos).attr("required", false);
			$(id_elemento_cantidad_cupos).val("");
		}
	});


	$(".horas").change(function(){
		let id_elemento_horario = $(this).attr("id");
		let numero_horas = $(this).val();
		let options_numero_sesiones;

		options_numero_sesiones = id_elemento_horario == "SL_numero_horas" ? "SL_numero_sesiones" : "SL_numero_sesiones_modificar";

		if(numero_horas == 2){
			$("#"+options_numero_sesiones).html("<option value='1'>Una (01) sesión de dos (02) horas</option>").selectpicker("refresh");
		}else{
			$("#"+options_numero_sesiones).html("<option value='1'>Una (01) sesión de cuatro (04) horas</option><option value='2'>Dos (02) sesiones de dos (02) horas</option>").selectpicker("refresh");
		}

		if(id_elemento_horario == "SL_numero_horas"){
			$(".checkbox_dias_clase").prop("checked",false);
			$("select[id^='SL_hora_inicio_dia_']").attr("disabled","disabled").selectpicker('refresh');
		}else{
			$("#SL_numero_sesiones_modificar").selectpicker('refresh').trigger("change");	
		}
	});

	$('select[id ^= SL_hora_fin_dia_]').hide().removeAttr("required").selectpicker('hide').selectpicker('refresh');

	$("#nav_inactivar_cerrar_grupos").click(function(){
		$("#SL_razon_cerrar_grupo").html(getOptionsRazonCierreGrupo()).selectpicker('refresh');
		cargarGruposActivosCerrar();
	});

	$("#nav_fusionar_grupos").click(function(){
		cargarGruposActivosFusionar();
	});

	$(".checkbox_dias_clase").change(function(){
		if("arte_escuela" == $("#SL_linea_atencion").val()){
			var total_check_seleccionados = 0;
			$(".checkbox_dias_clase").each(function(){
				if($(this).is(":checked"))
					total_check_seleccionados++;
			});
			if(total_check_seleccionados > $("#SL_numero_sesiones").val()){
				$(this).prop("checked",false);
				parent.mostrarAlerta("warning","No permitido","Debe seleccionar unicamente la cantidad de días indicados.");
			}
			var dia_semana = $(this).data('dia_clase');
			if($(this).prop('checked')){
				$("#SL_hora_inicio_dia_0" + dia_semana).removeAttr("disabled");
				$("#SL_hora_inicio_dia_0" + dia_semana).attr("required","required");
			}else{
				$("#SL_hora_inicio_dia_0" + dia_semana).attr("disabled","disabled");
				$("#SL_hora_inicio_dia_0" + dia_semana).removeAttr("required");
			}
			$('#SL_hora_inicio_dia_0' + dia_semana).selectpicker('refresh');
		}else{
			var dia_semana = $(this).data('dia_clase');
			if($(this).prop('checked')){
				$("#SL_hora_inicio_dia_0" + dia_semana).removeAttr("disabled");
				$("#SL_hora_inicio_dia_0" + dia_semana).attr("required","required");
				$("#SL_hora_fin_dia_0" + dia_semana).removeAttr("disabled");
				$("#SL_hora_fin_dia_0" + dia_semana).attr("required","required");
			}else{
				$("#SL_hora_inicio_dia_0" + dia_semana).attr("disabled","disabled");
				$("#SL_hora_inicio_dia_0" + dia_semana).removeAttr("required");
				$("#SL_hora_fin_dia_0" + dia_semana).attr("disabled","disabled");
				$("#SL_hora_fin_dia_0" + dia_semana).removeAttr("required");
			}
			$('#SL_hora_inicio_dia_0' + dia_semana).selectpicker('refresh');
			$('#SL_hora_fin_dia_0' + dia_semana).selectpicker('refresh');
		}
	});

	$("#form_nuevo_grupo").submit(function(event){
		event.stopPropagation();
		event.preventDefault();

		var o = {};
		var a = $(this).serializeArray();
		$.each(a, function () {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});

		let ids_grados = "";
		$("#SL_grados :selected").each(function(i, selected) {
			ids_grados += selected.value + ", ";
		});
		ids_grados = ids_grados.slice(0,-2);

		o["id_usuario"] = parent.idUsuario;
		o["SL_grados"] = ids_grados;
		o["SL_modalidad_atencion"] = $("#SL_modalidad_atencion").val();
		o["SL_espacio_alterno_converge"] = $("#SL_espacio_alterno_converge").val();
		datos_formulario = o;
		var total_check_seleccionados = 0;
		$(".checkbox_dias_clase").each(function(){
			if($(this).is(":checked"))
				total_check_seleccionados++;
		});
		if('arte_escuela' == $("#SL_linea_atencion").val()){
			if(!(total_check_seleccionados == $("#SL_numero_sesiones").val())){
				parent.mostrarAlerta("warning","Información Incompleta","Debe seleccionar completamente el horario para los " + $("#SL_numero_sesiones").val() + " días.");
				return;
			}
		}else{
			if(total_check_seleccionados == 0){
				parent.mostrarAlerta("warning","Información Incompleta","Debe seleccionar por lo menos un (01) día de atención.");
				return;
			}
		}
		var id_crea = $('#SL_clan').val();
		var notification = false;
		var grupoNombre = '';
		datos = {
			'p1': datos_formulario
		};
		$.ajax({
			url: url_ok_obj+'crearNuevoGrupo',
			type: 'POST',
			data: datos,
			async:false,
			beforeSend: function(){
				$("#BT_guardar_datos_grupo").attr("disabled","disabled");
				parent.mostrarCargando();
			}
		}).done(function(data){
			parent.cerrarCargando();
			//console.log(data);
			var tipo_grupo_linea_atencion = "";
			switch($("#SL_linea_atencion").val()){
				case 'arte_escuela':
				tipo_grupo_linea_atencion = "AE";
				break;
				case 'emprende_clan':
				tipo_grupo_linea_atencion = "IC";
				break;
				case 'laboratorio_clan':
				tipo_grupo_linea_atencion = "CV";
				break;
				default:

				break;
			}
			$("#BT_guardar_datos_grupo").removeAttr("disabled");
			parent.mostrarAlerta("success","Grupo Creado","Grupo #" + tipo_grupo_linea_atencion + "-" + data + " creado exitosamente.");
			grupoNombre = tipo_grupo_linea_atencion + data;
			notification = true;
			$("#form_nuevo_grupo")[0].reset();
			$(".selectpicker").selectpicker('refresh');
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido crear el grupo." + data);
			console.log(data)
		});
		if (notification) {
			$.ajax({
				url: url_ok_obj+'consultarDatosGestor',
				type: 'POST',
				data: {
					p1:{
						id_crea:id_crea
					}
				}
			}).done(function(idGestor){
				$.ajax({
					url: url_ok_obj+'consultarNombreCrea',
					type: 'POST',
					data: {
						p1:{
							id_crea:id_crea
						}
					}
				}).done(function(nameCrea){

					var notificacionData = {
						VC_Url:"ConsultasReportes/Consultar_Grupos.php",
						VC_Icon:"fa-2x fa fa-users",
						VC_Contenido:"Se ha creado el grupo "+grupoNombre+" en el "+nameCrea+" ",
						userId:idGestor,
					}
					window.parent.sendNotificationUser(notificacionData);

				}).fail(function(data){
					parent.mostrarAlerta("error","Error","No se ha podido consultar los datos del Gestor Territorial." + data);
					console.log(data)
				});
				
			}).fail(function(data){
				parent.mostrarAlerta("error","Error","No se ha podido consultar los datos del Gestor Territorial." + data);
				console.log(data)
			});

			var idCoordindor = 0;
			$.ajax({
				url: url_ok_obj+'consultarDatosAdministradorCrea',
				type: 'POST',
				data: {
					p1:{
						id_crea:id_crea
					}
				}
			}).done(function(coordinadorId){
				idCoordindor = coordinadorId > 0 ? coordinadorId : 0;
				if (idCoordindor != 0 ) {
					var notificacionData = {
						VC_Url:"GestionClan/Asignacion_Estudiantes_Grupo.php",
						VC_Icon:"fa-2x fa fa-users",
						VC_Contenido:"Se ha creado el grupo "+grupoNombre+" por favor ingrese los respectivos beneficiarios.",
						userId:idCoordindor,
					}
					window.parent.sendNotificationUser(notificacionData);
				}
			}).fail(function(data){
				parent.mostrarAlerta("error","Error","No se ha podido consultar los datos del Coordinador del Crea." + data);
				console.log(data)
			});
		}
	});



$("table").delegate(".cerrar_grupo","click",function(){
	var id_grupo = $(this).data("id_grupo");
	var tipo_grupo = $(this).data("tipo_grupo");
	var acronimo_linea_atencion = $(this).data("acronimo_linea_atencion");

	$("#title_modal_cerrar_grupo").text("Cerrar grupo: " + acronimo_linea_atencion + "-" + id_grupo);

	$("#BT_cerrar_grupo").data('id_grupo',id_grupo);
	$("#BT_cerrar_grupo").data('tipo_grupo',tipo_grupo);
	$("#BT_cerrar_grupo").data('acronimo_linea_atencion',acronimo_linea_atencion);
});

$("#BT_cerrar_grupo").click(function(){
	var id_grupo = $(this).data("id_grupo");
	var tipo_grupo = $(this).data("tipo_grupo");
	var acronimo_linea_atencion = $(this).data("acronimo_linea_atencion");
	var justificacion = "Grupo cerrado por: " + $("#SL_razon_cerrar_grupo").val() + " (" + $("#TX_justificacion_cerrar_grupo").val() + ")";
	if(justificacion == ""){
		parent.mostrarAlerta("warning","Información Incompleta","Por favor ingrese una justificación para el cierre.",function(){$("#TX_justificacion_cerrar_grupo").focus()});
	}else{
		parent.mostrarAlerta("warning","Grupo Cerrado","Grupo cerrado exitosamente.");
		cerrarGrupo(id_grupo,tipo_grupo,acronimo_linea_atencion,justificacion);
	}
});

$("#BT_fusionar_grupos").click(function(){
	var grupo_uno = $("#SL_grupo_fusion_uno").val();
	var grupo_dos = $("#SL_grupo_fusion_dos").val();
	var linea_atencion_grupo_uno = $("#SL_grupo_fusion_uno").find(":selected").data("tipo_grupo");
	var linea_atencion_grupo_dos = $("#SL_grupo_fusion_dos").find(":selected").data("tipo_grupo");
	var justificacion = $("#TX_justificacion_fusion_grupos").val();
	var crea = $("#SL_clan_fusion_grupos").val();

	if(justificacion == ""){
		$("#TX_justificacion_fusion_grupos").focus();
		parent.mostrarAlerta("warning",'Por Favor', 'Debe escribir la justificación por la cual va a fusionar los grupos', function(){  });
	}else{
		if(grupo_uno == grupo_dos){
			parent.mostrarAlerta("warning",'Esta operación no se puede realizar', 'No puede fusionar un grupo con sigo mismo, seleccione grupos diferentes.', function(){  });
		}else if(linea_atencion_grupo_uno != linea_atencion_grupo_dos){
			parent.mostrarAlerta("warning",'Esta operación no se puede realizar', 'No puede fusionar grupos de lineas de atención diferentes, seleccione grupos que pertenezcan a la misma línea .', function(){  });
		}else{
			parent.alertify.confirm('¿Está Seguro?', 'Al fusionar los grupos los beneficiarios serán removidos de estos y se creará uno nuevo que contendra estos beneficiarios.',
				function(){
					fusionarGrupos(grupo_uno,grupo_dos,linea_atencion_grupo_uno,crea,justificacion);
					parent.mostrarAlerta("success",'Grupos fusionados');
				},
				function(error){

				});
		}
	}
});

$("#SL_numero_sesiones").change(function(){
	$(".checkbox_dias_clase").prop("checked",false);
	$("select[id^='SL_hora_inicio_dia_']").attr("disabled","disabled");
	$("select[id^='SL_hora_inicio_dia_']").selectpicker('refresh');
});



$("#SL_grupo_modificar").change(cargarDatosHorarioGrupoCambio);



$("#SL_numero_sesiones_modificar").change(function(){
	if($(this).val() == 2){
		$("#dia2_cambiar_horario").show('slow');
	}else{
		$("#dia2_cambiar_horario").hide();
	}
	$(".checkbox_modificar_dias_clase").prop("checked",false);
	$("select[id^='SL_modificar_hora_inicio_dia_0']").attr('disabled','disabled').selectpicker("refresh");
});

$(".checkbox_modificar_dias_clase").change(function(){
	var tipo_grupo = $("#SL_grupo_modificar").find(":selected").data("tipo_grupo");
	var dia_semana = $(this).data('dia_clase');
	if($(this).prop('checked')){
		$("#SL_modificar_hora_inicio_dia_0" + dia_semana).removeAttr("disabled").attr("required","required");
		$("#SL_modificar_hora_fin_dia_0" + dia_semana).removeAttr("disabled").attr("required","required");
	}else{
		$("#SL_modificar_hora_inicio_dia_0" + dia_semana).attr("disabled","disabled").removeAttr("required");
		$("#SL_modificar_hora_fin_dia_0" + dia_semana).attr("disabled","disabled").removeAttr("required");
	}
	if('arte_escuela' == tipo_grupo){
		var total_check_seleccionados = 0;
		$(".checkbox_modificar_dias_clase").each(function(){
			if($(this).is(":checked"))
				total_check_seleccionados++;
		});
		if(total_check_seleccionados > $("#SL_numero_sesiones_modificar").val()){
			$(this).prop("checked",false);
			parent.mostrarAlerta("warning","No permitido","Debe seleccionar unicamente la cantidad de días indicados.");
		}
		$("#SL_modificar_hora_fin_dia_0" + dia_semana).attr("disabled","disabled").removeAttr("required");
	}
	$('#SL_modificar_hora_inicio_dia_0' + dia_semana).selectpicker('refresh');
	$('#SL_modificar_hora_fin_dia_0' + dia_semana).selectpicker('refresh');
});

$(".checkbox_modificar_dias_clase_emprende_clan").change(function(){
	var dia_semana = $(this).data('dia_clase');
	if($(this).prop('checked')){
		$("#SL_modificar_hora_inicio_dia_emprende_clan_0" + dia_semana).removeAttr("disabled").attr("required","required").selectpicker('refresh');
		$("#SL_modificar_hora_fin_dia_emprende_clan_0" + dia_semana).removeAttr("disabled").attr("required","required").selectpicker('refresh');
	}else{
		$("#SL_modificar_hora_inicio_dia_emprende_clan_0" + dia_semana).attr("disabled","disabled").removeAttr("required").selectpicker('refresh');
		$("#SL_modificar_hora_fin_dia_emprende_clan_0" + dia_semana).attr("disabled","disabled").removeAttr("required").selectpicker('refresh');
	}
});

$("#div_modificar_horario_clase").hide();

$("#form_modificar_grupo").submit(function(event){
	event.stopPropagation();
	event.preventDefault();
	var o = {};
	var a = $(this).serializeArray();
	$.each(a, function () {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	let ids_grados_modificar = "";
	$("#SL_grados_modificar :selected").each(function(i, selected) {
		ids_grados_modificar += selected.value + ", ";
	});
	ids_grados_modificar = ids_grados_modificar.slice(0,-2);

	o["SL_grados_modificar"] = ids_grados_modificar;
	o["SL_modalidad_atencion_modificar"] = $("#SL_modalidad_atencion_modificar").val();
	o["SL_espacio_alterno_converge_modificar"] = $("#SL_espacio_alterno_converge_modificar").val();
	o["id_usuario_modifica_grupo"] = parent.idUsuario;
	o["id_grupo_modificar"] = $("#SL_grupo_modificar").val();
	o["linea_atencion"] = $("#SL_grupo_modificar").find(":selected").data("tipo_grupo")
	var datos_formulario = o;
	var tipo_grupo = $("#SL_grupo_modificar").find(":selected").data("tipo_grupo");
	var total_check_seleccionados = 0;
	var total_check_necesarios = $("#SL_numero_sesiones_modificar").val();
	$(".checkbox_modificar_dias_clase").each(function(){
		if($(this).is(":checked"))
			total_check_seleccionados++;
	});
	if('arte_escuela' == tipo_grupo){
		if(total_check_necesarios != total_check_seleccionados){
			parent.mostrarAlerta("warning","Información Incompleta","Debe seleccionar completamente el horario para los " + $("#SL_numero_sesiones_modificar_horario").val() + " días.");
			return;
		}
	}else{
		if(total_check_seleccionados == 0){
			parent.mostrarAlerta("warning","Información Incompleta","Debe seleccionar por lo menos un (01) día de atención.");
			return;
		}
	}
	datos = {
		'p1': datos_formulario
	};
	$.ajax({
		url: url_ok_obj+'modificarGrupo',
		type: 'POST',
		data: datos,
		async:false,
		beforeSend: function(){
			$("#BT_guardar_modificar_grupo").attr("disabled","disabled");
			parent.mostrarCargando();
		}
	}).done(function(data){
		parent.cerrarCargando();
		$("#BT_guardar_modificar_grupo").removeAttr("disabled");
		if (data == 1) {
			parent.mostrarAlerta("success","Grupo Modificado","Se ha realizado la modificación satisfactoriamente.");
			$("#div_modificar_horario_clase").hide();
			$("#SL_clan_modificar_grupo").selectpicker("val", "");
			$("#SL_grupo_modificar").selectpicker("val", "");
		}
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido modificar el grupo." + data);
		console.log(data)
	});
});
	//window.parent.$("#modal_enviando").modal("hide");
});

function getLugaresAtencionLinea(id_elemento_linea, val_elemento_linea) {
	let id_elemento_lugar;
	id_elemento_lugar = id_elemento_linea == "SL_linea_atencion" ? "#SL_lugar_atencion" : "#SL_lugar_atencion_modificar";
	if(val_elemento_linea == "arte_escuela")
		$(id_elemento_lugar).html(parent.getOptionParametroDetalle(56)).selectpicker("refresh");			
	if(val_elemento_linea == "emprende_clan")
		$(id_elemento_lugar).html(parent.getOptionParametroDetalle(57)).selectpicker("refresh");
	if(val_elemento_linea == "laboratorio_clan")
		$(id_elemento_lugar).html(parent.getOptionParametroDetalle(39)).selectpicker("refresh");
}

function getModalidadesAtencionLugar(id_elemento_lugar, val_elemento_lugar, val_elemento_linea){
	let id_elemento_linea;
	let id_elemento_modalidad;
	id_elemento_modalidad = id_elemento_lugar == "SL_lugar_atencion" ? "#SL_modalidad_atencion" : "#SL_modalidad_atencion_modificar";
	$(id_elemento_modalidad).html(parent.getOptionParametroDetalleByOrder(61)).selectpicker("refresh");
	//Ids elementos del select lugar para arte en la escuela 1->colegio, 2->crea, 3->crea y colegio, 4->remoto
	//Ids elementos del select lugar para impulso colectivo 1->crea, 2->espacio alterno, 3->remoto
	//Ids elementos del select lugar para converge 1->crea, 2->espacio aliado, 3->espacio alterno, 4->remoto
	if(val_elemento_linea == "arte_escuela" || val_elemento_linea == "laboratorio_clan"){
		if(val_elemento_lugar == 1 || val_elemento_lugar == 2 || val_elemento_lugar == 3){
			$(id_elemento_modalidad).children("option[value^='2']").hide();
			$(id_elemento_modalidad).attr("disabled", false);
			$(id_elemento_modalidad).val("").selectpicker("refresh").trigger("change");
		}
		if(val_elemento_lugar == 4){
			$(id_elemento_modalidad).children("option[value^='1']").hide();
			$(id_elemento_modalidad).selectpicker("refresh");
		}
	}else{
		if(val_elemento_lugar == 1 || val_elemento_lugar == 2){
			$(id_elemento_modalidad).children("option[value^='2']").hide();
			$(id_elemento_modalidad).attr("disabled", false);
			$(id_elemento_modalidad).val("").selectpicker("refresh").trigger("change");
		}
		if(val_elemento_lugar == 3 || val_elemento_lugar == 4){
			$(id_elemento_modalidad).children("option[value^='1']").hide();
			$(id_elemento_modalidad).selectpicker("refresh");
		}
	}
}


function getModalidad(id_area_artistica){
	var mostrar = "";
	var datos = {
		p1:{
			'id_area_artistica' : id_area_artistica
		}
	};
	$.ajax({
		url: url_ok_obj+'getOptionModalidad',
		type: 'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			parent.mostrarCargando();
		}
	}).done(function(data){
		parent.cerrarCargando();
		mostrar += data;
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido cargar las modalidades." + data);
		console.log(data)
	});
	return mostrar;
}

function getColegiosResponsables(id_clan){
	var mostrar = "";
	var datos = {
		p1:{
			'id_crea' : id_clan
		}
	};
	$.ajax({
		url: url_ok_obj+'getOptionColegiosCrea',
		type: 'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			parent.mostrarCargando();
		}
	}).done(function(data){
		mostrar += data;
		parent.cerrarCargando();
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido cargar los colegios asociados al CREA." + data);
		console.log(data)
	});
	return mostrar;
}

function cargarGruposActivosCerrar(){
	var encabezado = "<th>N°</th><th>Área Artística</th><th>Formador</th>";
	switch($("#SL_linea_atencion_cerrar_grupo").val()){
		case 'arte_escuela':
		encabezado += "<th>Colegio</th>";
		break;
		case 'emprende_clan':
		encabezado += "<th>Modalidad</th>";
		break;
		case 'laboratorio_clan':
		//encabezado += "<th>Institución</th>";
		//encabezado += "<th>Aliado</th>";
		//encabezado += "<th>Tipo ubicación</th>";
		break;
		default:
		encabezado = "<th>No es línea de atención válida</th>";
		break;
	}
	encabezado += "<th>Opciones</th>";
	datos = {
		'p1': {
			'tipo_grupo' : $("#SL_linea_atencion_cerrar_grupo").val(),
			'id_crea' : $("#SL_crea_cerrar_grupo").val(),
			'tipo_mostrar' : 'cerrar_grupo'
		}
	};
	$.ajax({
		url: url_ok_obj+'consultarDatosCompletosGrupoPorCrea',
		type: 'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			parent.mostrarCargando();
		}
	}).done(function(data){
		parent.cerrarCargando();
		var table_grupos_cerrar = null;
		if ( $.fn.dataTable.isDataTable( '#table_grupos_cerrar' ) ) {
			table_grupos_cerrar = $('#table_grupos_cerrar').DataTable().destroy();
		}
		$("#table_grupos_cerrar thead").html("<tr>" + encabezado + "</tr>");
		$("#table_grupos_cerrar tbody").html(data);

		if ( $.fn.dataTable.isDataTable( '#table_grupos_cerrar' ) ) {
			table_grupos_cerrar = $('#table_grupos_cerrar').DataTable();
		}
		else{
			table_grupos_cerrar = $("#table_grupos_cerrar").DataTable({
				responsive: true,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por página",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			});
		}

		table_grupos_cerrar.draw();

	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se han podido cargar los grupos para cerrar.");
	});
}

function cargarGruposActivosFusionar(){
	if($("#SL_clan_fusion_grupos").val() != "" && $("#SL_linea_atencion_fusion_grupos").val() != ""){
		$("#SL_grupo_fusion_uno").html(getOptionGruposDeUnCrea).selectpicker('refresh');
		$("#SL_grupo_fusion_dos").html(getOptionGruposDeUnCrea).selectpicker('refresh');
	}
	//$("#SL_grupo_fusion_uno").html(parent.getOptionGruposDeUnCrea($("#SL_clan_fusion_grupos").val())).selectpicker('refresh');
	//$("#SL_grupo_fusion_dos").html(parent.getOptionGruposDeUnCrea($("#SL_clan_fusion_grupos").val())).selectpicker('refresh');
	$("#div_fusion_grupos").show('slow');
}

function getOptionGruposDeUnCrea(){
	var mostrar = "";

	datos = {
		p1: {
			'id_crea': $("#SL_clan_fusion_grupos").val(),
			'linea_atencion': $("#SL_linea_atencion_fusion_grupos").val(),
		}
	};
	$.ajax({
		url: url_ok_obj+'getOptionGruposDeUnCrea',
		type: 'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			parent.mostrarCargando();
		}
	}).done(function (data){
		parent.cerrarCargando();
		mostrar += data;
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se pudo obtener la información de los grupos, por favor intentelo nuevamente." + data);
	});
	return mostrar;
}

function cerrarGrupo(id_grupo,tipo_grupo,acronimo_linea_atencion,justificacion){
	var datos = {
		p1: {
			'tipo_grupo': tipo_grupo,
			'id_grupo': id_grupo,
			'justificacion': justificacion,
			'id_usuario': parent.idUsuario
		}
	}
	$.ajax({
		url: url_ok_obj+'cerrarGrupo',
		type: 'POST',
		data: datos,
		async: false,
	}).done(function(data){
		if (data == "1") {
			parent.mostrarAlerta("success","Grupo Cerrado","Se ha cerrado el grupo " + acronimo_linea_atencion + "-" + id_grupo + " exitosamente.");
		}else{
			parent.mostrarAlerta("error","Error","No se ha podido cerrar el grupo por un error inesperado de aplicación: " + data);
		}
		$("#TX_justificacion_cerrar_grupo").val('');
		$("#modal_cerrar_grupo").modal('hide');
		setTimeout(function(){
			cargarGruposActivosCerrar();
		}, 4000);
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido cerrar el grupo por un error inesperado de aplicación: " + data);
	});
}

function fusionarGrupos(grupo_uno,grupo_dos,linea_atencion,crea,justificacion){
	var datos = {
		p1: {
			id_grupo_uno: grupo_uno,
			id_grupo_dos: grupo_dos,
			linea_atencion: linea_atencion,
			crea: crea,
			justificacion: justificacion,
			id_usuario: parent.idUsuario
		}
	}
	var grupoNombre = '';
	$.ajax({
		url: url_ok_obj+'fusionarGrupos',
		type: 'POST',
		data: datos,
	}).done(function(data){
		try{
			grupo = JSON.parse(data);
			parent.mostrarAlerta("success","Fusión Exitosa","Grupo # " + grupo.id_grupo + " creado exitosamente. a partir de la fusión de los grupos -" + grupo_uno + " y -" + grupo_dos,function(){
				cargarGruposActivosFusionar()
			});
			generarNotificacion(grupo.id_grupo,grupo.id_artista_formador);
		}catch(e){
			console.log(data);
			parent.mostrarAlerta("warning","Advertencia!!","No se pudo decodificar datos de nuevo grupo Fusionado");
			console.log(e);
		}
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido Fusionar el grupo." + data);
		console.log(data)
	});
}

function generarNotificacion(grupoNombre,formadorId) {
	var notificacionData = {
		VC_Url:"ArtistaFormador/Registrar_Asistencia_Grupo_Sesion_Clase.php",
		VC_Icon:"fa-2x fa fa-users",
		VC_Contenido:"Se le ha asignado el grupo "+grupoNombre+" a partir de la fusión dos grupos.",
		userId:formadorId,
	}
	window.parent.sendNotificationUser(notificacionData);
}

function getHorasInicio(){
	var mostrar = "";
	var hora = 6;
	var minuto = 0;
	var intervalo = 15;
	while (hora <= 21){
		while (minuto < 60){
			mostrar += "<option value='" + ((hora < 10) ? '0'+hora : hora) + ":" + ((minuto < 10) ? '0'+minuto : minuto) + "'>" + ((hora < 10) ? '0'+hora : hora) + ":" + ((minuto < 10) ? '0'+minuto : minuto) + "</option>";
			minuto += intervalo;
		}
		hora++;
		minuto = 0;
	}
	return mostrar;
}

function getOptionsRazonCierreGrupo(){
	var mostrar = "";
	datos = {
	};
	$.ajax({
		url: url_ok_obj+'consultarOptionsRazonesCierreGrupo',
		type: 'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			parent.mostrarCargando();
		}
	}).done(function (data){
		parent.cerrarCargando();
		mostrar += data;
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido consultar las razones de cierre del grupo." + data);
		console.log(data)
	});
	return mostrar;
}

function cargarDatosHorarioGrupoCambio(){
	$("#div_modificar_horario_clase").hide();
	precargarDatosModificarGrupo();
	$("#div_modificar_horario_clase").show();
}

function precargarDatosModificarGrupo(){
	var tipo_grupo = $("#SL_grupo_modificar").find(":selected").data("tipo_grupo");
	if ("arte_escuela" == tipo_grupo){
		$("#div-horas-modificacion-grupo-arte-escuela").show();
	}
	if("emprende_clan" == tipo_grupo){
		$("#div-modificacion-grupo-impulso-colectivo").show();
	}
	if("laboratorio_clan" == tipo_grupo){
		$("#div-modificacion-grupo-converge").show();
	}
	datos = {
		'p1': {
			'tipo_grupo' : tipo_grupo,
			'id_grupo': $("#SL_grupo_modificar").val()
		}
	};
	$.ajax({
		url: url_ok_obj+'consultarDatosCompletosGrupo',
		type: 'POST',
		data: datos,
		async:false,
		beforeSend: function(){
			parent.mostrarCargando();
		}
	}).done(function(data){  
		parent.cerrarCargando();
		try{
			datos = $.parseJSON(data);

			$("#SL_linea_atencion_modificar").val(tipo_grupo).selectpicker('refresh').trigger('change');
			$("#SL_lugar_atencion_modificar").val(datos['IN_lugar_atencion']).selectpicker('refresh').trigger("change");
			$("#SL_modalidad_atencion_modificar").val(datos['IN_modalidad_atencion']).selectpicker('refresh').trigger("change");
			$("#SL_tipo_atencion_modificar").val(datos['IN_tipo_atencion']).selectpicker('refresh');
			$("#SL_convenio_modificar").val(datos['IN_convenio']).selectpicker('refresh');
			$("#SL_area_artistica_modificar").val(datos['FK_area_artistica']).selectpicker("refresh").trigger("change");
			$("#TX_observaciones_modificar").val(datos['TX_observaciones']);

			$("[id^='CH_modificar_dia_0']").prop("checked",false);
			$("select[id^='SL_modificar_hora_inicio_dia_0']").attr('disabled','disabled').selectpicker('refresh').selectpicker('val','');
			$("select[id^='SL_modificar_hora_fin_dia_0']").attr('disabled','disabled').selectpicker("show").selectpicker('refresh').selectpicker('val','');
			horario = datos['horario'];
			switch(tipo_grupo){
				case 'arte_escuela':
				if(datos["VC_grados"] == null){
					$("#SL_grados_modificar").selectpicker('val', "");
				}else{
					$("#SL_grados_modificar").val(datos["VC_grados"]).selectpicker('val', datos["VC_grados"].split(', '));
				}
				$("select[id^='SL_modificar_hora_fin_dia_0']").selectpicker("hide");
				if(horario.length == 2){
					$("#SL_numero_horas_modificar").val(4).selectpicker('refresh').trigger("change");
					$("#SL_numero_sesiones_modificar").val(2).selectpicker('refresh');
				}else{
					numero_horas = (parseInt(horario[0]['TI_hora_fin_clase'].substr(0,2)) - parseInt(horario[0]['TI_hora_inicio_clase'].substr(0,2)));
					if(numero_horas == 2){
						$("#SL_numero_horas_modificar").val(2).selectpicker('refresh').trigger("change");
					}else if(numero_horas == 4){
						$("#SL_numero_horas_modificar").val(4).selectpicker('refresh').trigger("change");
					}
					$("#SL_numero_sesiones_modificar").val(1).selectpicker('refresh');
				}
				break;
				case 'emprende_clan':
				$("#SL_tipo_grupo_emprende_clan_modificar").selectpicker("val", datos["tipo_grupo"]);
				$("#SL_modalidad_area_artistica_modificar").val(datos["FK_modalidad"]).selectpicker("refresh");
				$("#SL_oferta_disponible_modificar").val(datos["abierto_publico"]).selectpicker("refresh").trigger("change");
				$("#TX_cantidad_cupos_modificar").val(datos["IN_cupos"]);
				break;
				case 'laboratorio_clan':
				$("#SL_tipo_grupo_laboratorio_crea_modificar").val(datos['tipo_grupo']).selectpicker('refresh');
				$("#SL_institucion_laboratorio_crea_modificar").val(datos['FK_Institucion']).selectpicker('refresh').trigger("change");
				$("#SL_aliado_laboratorio_crea_modificar").val(datos['FK_Aliado']).selectpicker('refresh');
				if(datos["IN_espacio_alterno"] != "" || datos["IN_espacio_alterno"] != null)
					$("#SL_espacio_alterno_converge_modificar").selectpicker("val", datos["IN_espacio_alterno"]);
				$("#SL_categoria_poblacion_laboratorio_modificar").val(datos['FK_Id_Categoria']).selectpicker('refresh').trigger("change");
				$("#SL_subcategoria_poblacion_laboratorio_modificar").val(datos['tipo_poblacion']).selectpicker('refresh');
				break;
				default:
				break;
			}
			$.each(horario, function( index, value ) {
				$("#CH_modificar_dia_0" + value['IN_dia']).removeAttr('disabled');
				$("#CH_modificar_dia_0" + value['IN_dia']).attr('checked','checked').prop("checked",true);;
				$("#SL_modificar_hora_inicio_dia_0" + value['IN_dia']).removeAttr('disabled').selectpicker('refresh').selectpicker('val',value['TI_hora_inicio_clase'].substr(0,5));
				$("#SL_modificar_hora_fin_dia_0" + value['IN_dia']).removeAttr('disabled').selectpicker('refresh').selectpicker('val',value['TI_hora_fin_clase'].substr(0,5));
			});
		}catch(ex){
			parent.mostrarAlerta("error","Error cargando datos para editar","No se han podido cargar los datos correspondientes del grupo por error: " + ex);
			console.log(ex);
			console.log(data);
		}
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido pregargar los datos del grupo que desea modificar." + data);
		console.log(data)
	});
}

function consultarAliadosLaboratorioCrea(id_institucion) {
	var mostrar = "";
	$.ajax({
		url: url_ok_obj+'consultarAliadosLaboratorioCrea',
		type: 'POST',
		async: false,
		data: {
			p1:{
				id_institucion:id_institucion
			}
		},
		beforeSend: function(){
			parent.mostrarCargando();
		},
	}).done(function(data){
		parent.cerrarCargando();
		mostrar += data;
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido consultar los datos de los aliados asociados a la Institución." + data);
		console.log(data)
	});
	return mostrar;
}

function consultarTipoPoblacionLaboratorio(id_categoria_poblacion) {
	var mostrar = "";
	$.ajax({
		url: url_ok_obj+'consultarTipoPoblacionLaboratorio',
		type: 'POST',
		async: false,
		data: {
			p1:{
				id_categoria_poblacion:id_categoria_poblacion
			}
		},
		beforeSend: function(){
			parent.mostrarCargando();
		},
	}).done(function(data){
		parent.cerrarCargando();
		mostrar += data;
	}).fail(function(data){
		parent.mostrarAlerta("error","Error","No se ha podido consultar los datos de los tipos de población." + data);
		console.log(data)
	});
	return mostrar;

}