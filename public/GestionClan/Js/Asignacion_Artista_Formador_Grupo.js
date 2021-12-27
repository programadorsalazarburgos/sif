var url_ok_obj = '../../src/GestionClan/AsignacionController/';
var grupoNombre = '';
$(function(){

	$("#div_filtros_artista_clan").hide();
	$("#SL_organizacion").html(parent.getOptionsOrganizacionesRol(parent.idUsuario)).selectpicker('refresh');
	$("#SL_crea").html(parent.getOptionsClanes()).selectpicker('refresh');
	$("#SL_colegio").html(parent.getOptionsColegios()).selectpicker('refresh');
	$("#SL_area_artistica").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
	$("#SL_zona").html(getZonas()).change(getArtistasFormadoresIdartes).selectpicker('refresh');
	setSelectOrganizacionUsuario();

	$(".nav-item").click(function(){
		getGruposActivosOrganizacionPestanaActiva($(this).data('tipo_grupo'));
	});

	$("table").delegate(".asignar_artista_formador_grupo_arte_escuela","click",asignarArtistaFormadorGrupoArteEscuela);
	$("table").delegate(".asignar_artista_formador_grupo_emprende_clan","click",asignarArtistaFormadorGrupoEmprendeClan);
	$("table").delegate(".asignar_artista_formador_grupo_laboratorio_clan","click",asignarArtistaFormadorGrupoLaboratorioClan);
	
	$("table").delegate(".quitar_artista","click",quitarArtistaFormadorGrupo);

	$("#BT_confirmar_asignacion_artista_formador_grupo").click(guardarAsignacionArtistaFormadorAGrupo);

});

function getGruposActivosOrganizacionPestanaActiva(tipo_grupo){
	const datos_select={
		id_organizacion:$("#SL_organizacion").val(),
		id_crea:$("#SL_crea").val(),
		id_colegio:$("#SL_colegio").val(),
		id_area_artistica:$("#SL_area_artistica").val(),
		tipo_grupo:tipo_grupo
	}
	if(datos_select.id_organizacion==null || datos_select.id_crea.length == 0 || datos_select.id_area_artistica.length == 0){
		parent.mostrarAlerta("warning","Seleccione por lo menos 1 dato de cada seleccionable",)
	}else{
		$("#div_filtros_artista_clan").hide();
		datos = {
			p1: datos_select
		};
		$.ajax({
			url: url_ok_obj+'consultarGruposFiltroSelect',
			type: 'POST',
			data: datos,
			async: false,
			beforeSend: function(){
				window.parent.$("#modal_enviando").modal("show");
			}
		}).done(function(data){
			var table_grupos = null;
			if ( $.fn.dataTable.isDataTable( '#table_grupos_'+tipo_grupo ) ) {
				table_grupos = $('#table_grupos_'+tipo_grupo).DataTable().destroy();
			}
			//$("#table_grupos_" + tipo_grupo + " thead").html("<tr>" + encabezado + "</tr>");
			$("#table_grupos_" + tipo_grupo + " tbody").html(data);

			if ( $.fn.dataTable.isDataTable( '#table_grupos_' + tipo_grupo ) ) {
				table_grupos = $('#table_grupos_' + tipo_grupo).DataTable();
			}
			else{
				table_grupos = $("#table_grupos_" + tipo_grupo).DataTable({
					"language": {
						"lengthMenu": "Ver _MENU_ registros por pagina",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando pagina _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtered from _MAX_ total records)",
						"search": "Filtrar"
					}
				});
			}

			table_grupos.draw();
			window.parent.$("#modal_enviando").modal("hide");
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se han podido cargar los grupos de la línea '+ tipo_grupo +'. ' + textStatus);
		});
	}
}

function asignarArtistaFormadorGrupoArteEscuela(){
	var id_grupo = $(this).data("id_grupo");
	var id_organizacion = $(this).data("id_organizacion");
	$("#tipo_grupo").val("arte_escuela");
	grupoNombre = 'AE-'+id_grupo;
	$("#title_modal_buscar_artista_formador").text("Asignar artista formador al grupo AE-" + id_grupo);
	$("#BT_confirmar_asignacion_artista_formador_grupo").data("id_grupo",id_grupo);
	setSelectArtistasFormadoresActivosOrganizacion(id_organizacion);
}

function asignarArtistaFormadorGrupoEmprendeClan(){
	var id_grupo = $(this).data("id_grupo");
	var id_organizacion = $(this).data("id_organizacion");
	$("#tipo_grupo").val("emprende_clan");
	grupoNombre = 'EC-'+id_grupo;
	$("#title_modal_buscar_artista_formador").text("Asignar artista formador al grupo EC-" + id_grupo);
	$("#BT_confirmar_asignacion_artista_formador_grupo").data("id_grupo",id_grupo);
	setSelectArtistasFormadoresActivosOrganizacion(id_organizacion);
}

function asignarArtistaFormadorGrupoLaboratorioClan(){
	var id_grupo = $(this).data("id_grupo");
	var id_organizacion = $(this).data("id_organizacion");
	$("#tipo_grupo").val("laboratorio_clan");
	grupoNombre = 'LaboratorioClan-'+id_grupo;
	$("#title_modal_buscar_artista_formador").text("Asignar artista formador al grupo LaboratorioClan-" + id_grupo);
	$("#BT_confirmar_asignacion_artista_formador_grupo").data("id_grupo",id_grupo);
	setSelectArtistasFormadoresActivosOrganizacion(id_organizacion);
}

function setSelectArtistasFormadoresActivosOrganizacion(id_organizacion){
	if(true){
		datos = {
			p1: {
				'id_organizacion': id_organizacion
			}
		};
		$.ajax({
			url:url_ok_obj+'getOptionArtistaPorOrganizacion',
			type:'POST',
			data: datos
		}).done(function(data){
			$("#SL_artista_formador").html(data).selectpicker('refresh');
		}).fail(function(data){
			parent.mostrarAlerta("error","Error!!","No se ha podido consultar los artistas formadores activos de la organización." + data);
		});
	}else{
		getArtistasFormadoresIdartes();
	}
}

function guardarAsignacionArtistaFormadorAGrupo(){
	var tipo_grupo = $("#tipo_grupo").val();
	var id_grupo = $(this).data("id_grupo");
	var id_artista_formador = $("#SL_artista_formador").val();
	if(validarZonificacionArtista(id_artista_formador)){
		if(1){
		// if(validarHorarioDisponible(tipo_grupo,id_grupo,id_artista_formador)){
			datos = {
				p1: {
					'tipo_grupo': tipo_grupo,
					'id_grupo': id_grupo,
					'id_artista_formador': id_artista_formador,
					'id_organizacion' : $("#SL_organizacion").val(),
					'id_usuario': parent.idUsuario
				}
			};
			generarNotificacion(grupoNombre,$("#SL_artista_formador").val());
			$.ajax({
				url: url_ok_obj+'asignarArtistaFormadorAGrupo',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				parent.mostrarAlerta("success","Asignación exitosa","Se ha asignado correctamente el artista formador al grupo");
				getGruposActivosOrganizacionPestanaActiva($("#tipo_grupo").val());
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta("error",'Error!','No se ha podido asignar artista formador. ' + textStatus);
			});
		}else{
			parent.mostrarAlerta("error","No es posible asignar!!","El horario del grupo se cruza con otro de los grupos que tiene asignado actualmente el artista formador.");
		}
	}else{
		parent.mostrarAlerta("error","No es posible asignar!!","El artista formador no está Zonificado, por favor asigne una zona a este artista primero.");
	}
}

function generarNotificacion(grupoNombre,id_artista_formador) {
	var notificacionData = {
		VC_Url:"ArtistaFormador/Registrar_Asistencia_Grupo_Sesion_Clase.php",
		VC_Icon:"fa-2x fa fa-users",
		VC_Contenido:"Se le ha asignado el grupo: "+grupoNombre+".",
		userId:id_artista_formador,
	}
	window.parent.sendNotificationUser(notificacionData);

}

function getZonas(){
	datos = {
	};
	$.ajax({
		url:url_ok_obj+'consultarZonas',
		type:'POST',
		data: datos
	}).done(function(data){
		$("#SL_zona").html(data).selectpicker('refresh');
	}).fail(function(data){
		parent.mostrarAlerta("error","Error!!","No se ha podido consultar las zonas." + data);
	});
}

function getArtistasFormadoresIdartes(){
	datos = {
		p1: {
			id_zona: $("#SL_zona").val()
		}
	};
	$.ajax({
		url:url_ok_obj+'consultarArtistasFormadoresDeZona',
		type:'POST',
		data: datos
	}).done(function(data){
		$("#SL_artista_formador").html(data).selectpicker('refresh');
	}).fail(function(data){
		parent.mostrarAlerta("error","Error!!","No se ha podido consultar los artistas formadores de la zona seleccionada. " + data);
	});

}

function setSelectOrganizacionUsuario(){
	datos = {
		p1: {
			id_usuario: parent.idUsuario
		}
	};
	$.ajax({
		url:url_ok_obj+'consultarIDUltimaOrganizacionUsuario',
		type:'POST',
		data: datos
	}).done(function(data){
		$("#SL_organizacion").val(data).selectpicker('refresh');
	}).fail(function(data){
		parent.mostrarAlerta("error","Error!!","No se ha podido preseleccionar la organización asociada al usuario. " + data);
	});
}

function validarZonificacionArtista(id_artista_formador){
	var resultado = true;
	datos = {
		p1: {
			'id_artista_formador': id_artista_formador
		}
	};
	$.ajax({
		url: url_ok_obj+'validarZonificacionArtista',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		if (data == "1") {
			resultado = true;
		}
		else {
			resultado = false;
		}
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta("error",'Error!','No se ha podido consultar la zonificación del artista formador. ' + textStatus);
	});
	return resultado;
}

function validarHorarioDisponible(tipo_grupo,id_grupo,id_artista_formador){
	var resultado = true;
	datos = {
		p1: {
			'tipo_grupo': tipo_grupo,
			'id_grupo': id_grupo,
			'id_artista_formador': id_artista_formador
		}
	};
	$.ajax({
		url: url_ok_obj+'validarHorarioDisponible',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		if (data == "1") {
			resultado = false;
		}
		else {
			resultado = true;
		}
	}).fail(function(jqXHR,textStatus){
		parent.mostrarAlerta("error",'Error!','No se ha podido consultar horario de grupos del artista formador. ' + textStatus);
	});
	return resultado;
}

function quitarArtistaFormadorGrupo(){
	const datos={
		'p1':{
			'id_grupo':$(this).data('id_grupo'),
			'tipo_grupo':$(this).data('tipo_grupo'),
			'id_usuario':parent.idUsuario
		}
	}
	parent.alertify.confirm('¿Está seguro?', 'Seguro que desea dejar el grupo sin artista',
		function(){
			$.ajax({
				url: url_ok_obj+'quitarArtistaFormadorGrupo',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				if(data==1){
					parent.mostrarAlerta("success","Artista Retirado","Se ha retirado el artista del grupo correctamente")
					getGruposActivosOrganizacionPestanaActiva(datos.p1.tipo_grupo);
				}else{
					parent.mostrarAlerta("error",'Error!','No se ha podido quitar el artista formador del grupo. ' + data)
				}
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta("error",'Error!','No se ha podido quitar el artista formador del grupo. ' + textStatus)
			})

		},
		function(){
			
		});
}