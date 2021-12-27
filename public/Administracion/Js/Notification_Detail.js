var url_controller = '../../Controlador/Administracion/C_Notificaciones.php';
var url_notificacion = '../../src/Administracion/Controlador/NotificacionController.php';
$(function(){
	idUsuario = $("#id_usuario").val();
	idNotificacion = $("#id_notificacion").val();
	var table_groups = $('#table-groups').DataTable({
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',

			title: 'Notificaciones'
		}
		],
		autoWidth: false,
		info:false,
		"language": {
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar",
			"paginate": {
				"first":      "First",
				"last":       "Last",
				"next":       "Next",
				"previous":   "Prev"
			},
		},
		"lengthChange": false,
	});
	table_groups.clear().draw();
	/*var datos = {
		'opcion':'getGroupsNotification',
		'idNotificacion': idNotificacion
	};*/
	var datos = {
		'funcion':'getGroupsNotification',
		'p1': idNotificacion
	};	
	$.ajax({
		async: false,
		//url:url_controller,
		url:url_notificacion,    
		type:'POST',
		data: datos,
		success: function(data){
			grupos = JSON.parse(data);
			$.each(grupos, function (i) {
				if (grupos[i].PK_Grupo != null) {
					var rowNode = table_groups.row.add( [
						grupos[i].PK_Grupo,
						grupos[i].VC_Nom_Clan,
						grupos[i].VC_Nom_Area,
						grupos[i].VC_Nom_Organizacion,
						grupos[i].VC_Primer_Nombre+" "+grupos[i].VC_Segundo_Nombre+" "+grupos[i].VC_Primer_Apellido+" "+grupos[i].VC_Segundo_Apellido,
						grupos[i].Horario,
						grupos[i].TX_observaciones,
						]).draw();
				}
			}); 
			$('#title-form').prepend("Grupos de "+grupos.linea);
			$('#small-title').html("Sin asistencia");
		}
	});

});