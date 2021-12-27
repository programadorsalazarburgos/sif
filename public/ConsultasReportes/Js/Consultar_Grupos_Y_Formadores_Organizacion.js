var url_service_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(function(){
	$("#resultados_consulta").hide();
	var id_usuario = $("#id_usuario").val(); 
	$("#SL_organizacion").html(parent.getOptionsOrganizacionesRol(id_usuario));
	$("#SL_clan").html(parent.getOptionsClanes());
	$("#BT_cargar_datos").click(getTablesInfoHistorial);
});




function getTablesInfoHistorial(){
	if($("#SL_clan").val() != null){
		getTableHistorialGruposOrganizacion();
		getTableHistorialArtistasGruposOrganizacion();
		$("#resultados_consulta").show("slow");
	}else{
		alertify.alert("Seleccione un clan","Debe seleccionar uno (01) o más CLAN", function(){ $('#SL_clan').selectpicker('toggle'); });
		$("#resultados_consulta").hide();
	}	
}

function getTableHistorialGruposOrganizacion(){
	datos = {
		funcion: 'getHistorialGruposOrganizacion', 
		p1: {
			'id_organizacion':$("#SL_organizacion").val(),
			'id_clan':$("#SL_clan").val()
		}
	};
	$.ajax({
		url:url_service_obj,
		type:'POST',
		data: datos,
		async: false
	}).done(function(data){
		var table_historico_grupos_asignados = $("#table_historico_grupos_asignados").DataTable();
		table_historico_grupos_asignados.clear();
		$("#table_historico_grupos_asignados").html(data);
		table_historico_grupos_asignados.destroy();
		$("#table_historico_grupos_asignados").DataTable({
			responsive: true,
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

				title: 'Grupos SICLAN - Arte en la escuela'
			}
			],
		});
		table_historico_grupos_asignados.draw();
	}).fail(function(data){
		console.log("fail" + data);
	});
}

function getTableHistorialArtistasGruposOrganizacion(){
	datos = {
		funcion: 'getHistorialArtistasGruposOrganizacion', 
		p1: {
			'id_organizacion':$("#SL_organizacion").val(),
			'id_clan':$("#SL_clan").val()
		}
	};
	$.ajax({
		url:url_service_obj,
		type:'POST',
		data: datos,
		async: false
	}).done(function(data){
		console.log(data);
		
		var table_historico_artistas_grupos_asignados = $("#table_historico_artistas_grupos_asignados").DataTable();
		table_historico_artistas_grupos_asignados.clear();
		$("#table_historico_artistas_grupos_asignados").html(data);
		table_historico_artistas_grupos_asignados.destroy();
		$("#table_historico_artistas_grupos_asignados").DataTable({
			responsive: true,
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

				title: 'Grupos SICLAN - Arte en la escuela'
			}
			],
		});
		table_historico_artistas_grupos_asignados.draw();
	}).fail(function(data){
		console.log("fail" + data);
	});
}