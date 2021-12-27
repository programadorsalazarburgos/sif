var url_ok_obj = '../../src/ArtistaFormador/ReporteMensualController/';
$(function(){
	consultarPeriodosReporteDigitalMensual();
	$("#SL_periodo").change(consultarReportesAprobados);

	$("#div_table_listado_informes").delegate(".quitar_aprobado","click",function(){
		var id_informe = $(this).data('id_informe')
		parent.swal({
			title: '¿Está seguro?',
			text: "",
			type: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#3085d6',
			cancelButtonText: 'No',
			confirmButtonText: 'Sí',
		}).then(function(){
			var datos = {
				'p1' : {
					'texto_rechazo': 'rechazado por solicitud de soporte equipo SIF',
					'id_informe': id_informe,
					'id_usuario': parent.idUsuario
				}
			};
			$.ajax({
				url: url_ok_obj+'rechazarReporte',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				console.log(data);
				consultarReportesAprobados();
			}).fail(function(){
				parent.mostrarAlerta("error","No se pudo consultar reportes","Ocurrió un error al intentar consultar el listado de reportes.");
			});
		}, function(dismiss){
			console.log("Cancelada la promesa de aprobar");
			return false;
		});
	});
});

function consultarPeriodosReporteDigitalMensual(){
	var datos = {
		'p1' : {}
	};
	$.ajax({
		url: url_ok_obj+'consultarPeriodosReporteDigitalMensual',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		console.log(data);
		$("#SL_periodo").html(data).selectpicker('refresh');
		consultarReportesAprobados();
	}).fail(function(){
		parent.mostrarAlerta("error","No se pudo consultar fechas","Ocurrió un error al intentar consultar el listado de periodos de reportes.");
	});
}

function consultarReportesAprobados(){
	var datos = {
		'p1' : {
			'periodo':$("#SL_periodo").val()
		}
	};
	$.ajax({
		url: url_ok_obj+'consultarTodosLosReportesAprobados',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		$("#div_table_listado_informes").html(data);
		$("#table_listado_informes").DataTable({
			responsive: false,
			"order": [[ 2, "desc" ]],
			"language": {
				"lengthMenu": "Ver _MENU_ registros por pagina",
				"zeroRecords": "No hay información, lo sentimos.",
				"info": "Mostrando pagina _PAGE_ de _PAGES_",
				"infoEmpty": "No hay registros disponibles",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"search": "Filtrar"
			}
		}).draw(); 
	}).fail(function(){
		parent.mostrarAlerta("error","No se pudo consultar reportes","Ocurrió un error al intentar consultar el listado de reportes.");
	});
}