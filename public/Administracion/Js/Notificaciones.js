var url_controller = '../../Controlador/Administracion/C_Notificaciones.php';
var url_notificacion = '../../src/Administracion/Controlador/NotificacionController.php';   
$(function(){
	idUsuario = $("#id_usuario").val();
	var table_notification = $('#table-notification').DataTable({
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excelHtml5',

			title: 'Notificaciones'
		}
		],
		autoWidth: false,
		"columns": [
		{ "width": "20%" },
		{ "width": "40%" },
		false
		],
		"columnDefs": [
		{
			"targets": [ 2 ],
			"visible": false,
			"searchable": false
		},
		{
			"targets": [ 3 ],
			"visible": false,
			"searchable": false
		}
		],
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
	});
	table_notification.clear().draw();
	refreshAllNotificaciones(idUsuario);
	$('#table-notification tbody').on( 'click', 'tr', function(e) 
	{
		e.preventDefault();
		var datosTabla=table_notification.row($(this)).data();
		notificationId = datosTabla[3];
		urlTarged = datosTabla[2];
		/*var datos = {
			'opcion':'setNotificationUser',
			'idUsuario': idUsuario,
			'notificationId': notificationId
		};*/
		var datos = {
			'funcion':'setNotificationUser',
			'p1': idUsuario,
			'p2': notificationId
		};		
		$.ajax({
			async: false,
			//url:url_controller,
			url:url_notificacion,
			type:'POST',
			data: datos,
			success: function(data){
				//refreshAllNotificaciones(idUsuario);
				window.parent.refreshNotificaciones(idUsuario);
				location.href = "../"+urlTarged;
			}
		});
	});
	function refreshAllNotificaciones(idUsuario) {
		table_notification.clear().draw();
		/*var datos = {
			'opcion':'getAllNotifications',
			'idUsuario': idUsuario
		};*/
		var datos = {
			'funcion':'getAllNotifications',
			'p1': idUsuario
		};		
		$.ajax({
			async: false,
			//url:url_controller,
			url:url_notificacion,
			type:'POST',
			data: datos,
			success: function(data){
				notificaciones = JSON.parse(data);
				$.each(notificaciones, function (i) {
					var rowNode = table_notification.row.add( [
						'<h4 style="font-size: 20px;"><i class="'+notificaciones[i].VC_Icon+'"></i></h4>',
						notificaciones[i].VC_Contenido+"<br><h6 class='text-right' style='font-size: 12px; color:gray;'>"+notificaciones[i].DT_Fecha+"</h6>",
						notificaciones[i].VC_Url,
						notificaciones[i].PK_Notificacion_Id
						]).draw().node();
					if (notificaciones[i].IN_Visto == 0) {
						$( rowNode )
						.css( 'backgroundColor', '#f2f4f7' )
						.animate( { color: 'black' } );
					}
				}); 
			}
		});

	}
});