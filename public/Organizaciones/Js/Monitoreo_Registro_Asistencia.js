var url_pedagogico_controller = '../../src/PedagogicoCREA/PedagogicoCREAController/';
var nombre_formador = "";
var fecha = "";
$(function(){
	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		plugins: [ 'interaction', 'dayGrid' ],
		locale: 'es',
		dateClick: function(info) {
			fecha = info.dateStr;
			if($("#SL_ORGANIZACION").val() == "" || $("#SL_LINEA_ATENCION").val() == "" || $("#SL_CREA").val().join() == ""){
				parent.swal("Datos incompletos", "Debe seleccionar LÍNEA, ORGANIZACIÓN y CREA","warning");  
			}
			else{
            	// alert('Fecha: ' + info.dateStr);
            	var datos = {
            		p1: {
            			'FK_organizacion': $("#SL_ORGANIZACION").val(),
            			'fecha': fecha,
            			'linea_atencion': $("#SL_LINEA_ATENCION").val(),
            			'crea': $("#SL_CREA").val().join()
	            	}
            	};
            	tableListado.clear().draw();
            	parent.mostrarCargando();
            	$.ajax({
            		async : true,
            		url: url_pedagogico_controller+'consultarEstadoRegistroAsistencias',
            		type: 'POST',
            		dataType: 'html',
            		data: datos,
            		success: function(retorno)
            		{
            			tableListado.rows.add($(retorno)).draw();
            			$("#info-event").modal("show");
            			$("#modal-title").html($("#SL_LINEA_ATENCION option:selected").text()+"<br>"+$("#SL_CREA option:selected").text()+"<br>Monitoreo de Registro Asistencia Diario <br><strong>FECHA SELECCIONADA: "+info.dateStr+"</strong>");
	            		parent.cerrarCargando();
            		},error: function(result){
            			parent.swal("Algo salió mal", "No se pudo consultar la información.","warning");  
	            	}
            	});
			}
        },
    });

	calendar.render();
	var tableListado = null;
	$.ajax({
		url: '../../Controlador/Consultas/getSession.php', 
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
			init();
		},
		async : false
	});
	$.ajax({
		url: '../../Controlador/Consultas/getSession.php', 
		data: {requested: 'session_usertype'},
		dataType: 'json',
		success: function (data) {
			rol = data;
			if(rol == 11){
				$("#SL_ORGANIZACION").prop("disabled", true);
			}
		},
		async : false
	});

	datos_usuario = JSON.parse(parent.consultarDatosBasicosUsuario(session));
	$("#SL_LINEA_ATENCION").html(parent.getOptionsLineasAtencion()).selectpicker("refresh");
	$("#SL_ORGANIZACION").html(parent.getOptionsOrganizacionesRol(session)).selectpicker("refresh");
	$("#SL_CREA").html(parent.getOptionsClanes(2)).selectpicker("refresh");
	nombre_formador = datos_usuario[0].VC_Primer_Nombre+' '+datos_usuario[0].VC_Segundo_Nombre+' '+datos_usuario[0].VC_Primer_Apellido+' '+datos_usuario[0].VC_Segundo_Apellido;

	function init() {
		tableListado = $('#table-listado-asistencia').DataTable( {
			"paging":   true,
			"ordering": true,
			"info":     false,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
			language: {
				"lengthMenu": "Ver _MENU_ registros por pagina",
				"zeroRecords": "No hay información, lo sentimos.",
				"info": "Mostrando pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
				"search": "Filtrar",
				paginate: {
					"first": "Primero",
					"previous": "Anterior",
					"next": "Siguiente",
					"last": "Último"
				}
			},
			dom: 'Bfrtip',
        buttons: [
			{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [':visible']
                },
				title: 'Monitoreo de Asistencia'
            },
        ]
		});
	}
});