var url_ok_obj = '../../src/GestionClan/GestionClanController/';
var url_asignacion_obj = '../../src/GestionClan/AsignacionController/';
$(function(){
	$("#SL_organizacion").html(parent.getOptionsOrganizaciones()).selectpicker('refresh');

	var table_grupos_arte_escuela = $("#table_grupos_arte_escuela").DataTable({ 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip' 
	}); 

	var table_grupos_emprende_clan = $("#table_grupos_emprende_clan").DataTable({ 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip' 
	}); 

	var table_grupos_laboratorio_clan = $("#table_grupos_laboratorio_clan").DataTable({ 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip' 
	});

	$(".nav-link").click(function(){
		cargarGruposActivos($(this).data('tipo_grupo'));
	});

	$("table").delegate(".asignar_organizacion_grupo","click",function(){
		var id_grupo = $(this).data("id_grupo");
		var tipo_grupo = $(this).data("tipo_grupo");
		var acronimo_linea_atencion = $(this).data("acronimo_linea_atencion");
		$("#title_modal_buscar_organizacion").text("Seleccione la organización para asignar al grupo: AE-" + id_grupo);
		$("#BT_confirmar_asignacion_organizacion_grupo").data('id_grupo',id_grupo);
		$("#BT_confirmar_asignacion_organizacion_grupo").data('tipo_grupo',tipo_grupo);
		$("#BT_confirmar_asignacion_organizacion_grupo").data('acronimo_linea_atencion',acronimo_linea_atencion);
	});

	$("#BT_confirmar_asignacion_organizacion_grupo").click(function(){
		var id_grupo = $(this).data('id_grupo');
		var tipo_grupo = $(this).data('tipo_grupo');
		var acronimo_linea_atencion = $(this).data('acronimo_linea_atencion');
		var id_organizacion = $("#SL_organizacion").val();
		asignarOrganizacionGrupo(id_grupo,tipo_grupo,id_organizacion);
		var nombre_grupo = acronimo_linea_atencion + '-' + id_grupo;
		generarNotificacion(nombre_grupo,id_organizacion);
		parent.mostrarAlerta("success","Asignación existosa","Se ha asignado la organización exitosamente al grupo: " + acronimo_linea_atencion + "-" + id_grupo);
	});

	function cargarGruposActivos(tipo_grupo){
		var datos = {
			'p1' : {
				'tipo_grupo' : tipo_grupo,
				'tipo_mostrar' : 'asignar_organizacion'
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarTablaGruposAsignarOrganizacion',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			switch (tipo_grupo) { 
				case 'arte_escuela':
					table_grupos_arte_escuela.clear().draw();
					table_grupos_arte_escuela.rows.add($(data)).draw(); 
					break; 
				case 'emprende_clan':
					table_grupos_emprende_clan.clear().draw();
					table_grupos_emprende_clan.rows.add($(data)).draw(); 
					break; 
				case 'laboratorio_clan':
					table_grupos_laboratorio_clan.clear().draw();
					table_grupos_laboratorio_clan.rows.add($(data)).draw(); 
					break; 
				default: 
					console.log("Tipo grupo para cargar tabla no valido");
					break;
			}
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido cargar los grupos sin organización");
		});
	}

	function asignarOrganizacionGrupo(id_grupo,tipo_grupo,id_organizacion){
		var datos = {
			p1: {
				'id_grupo': id_grupo,
				'tipo_grupo' : tipo_grupo,
				'id_organizacion': id_organizacion,
				'id_usuario': parent.idUsuario
			}
		};
		$.ajax({
			url: url_asignacion_obj+'asignarOrganizacionGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			cargarGruposActivos(tipo_grupo);
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido asignar el grupo a la organización.");
			console.log(data);
		});
	}

	function generarNotificacion(grupoNombre,id_organizacion) {
		$.ajax({
			url: url_asignacion_obj+'getAdministradorOrganizacion',
			type: 'POST',
			data: {p1:id_organizacion},
			success: function(data){
				organizacion = JSON.parse(data)[0];
				if (organizacion.FK_Coordinador != 0 && organizacion.FK_Coordinador != undefined ) {
					var notificacionData = {
						VC_Url:"GestionClan/Asignacion_Artista_Formador_Grupo.php",
						VC_Icon:"fa-2x fa fa-address-book",
						VC_Contenido:"Se le ha asignado el grupo: "+grupoNombre+" a la organización "+organizacion.VC_Nom_Organizacion+" por favor asignele un artista formador.",
						userId:organizacion.FK_Coordinador,
					}
					window.parent.sendNotificationUser(notificacionData);
				}
			}

		});
	}
	cargarGruposActivos('arte_escuela');
});
