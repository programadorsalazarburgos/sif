var url_ok_obj = '../../src/Circulacion/CirculacionController/';
$(function(){
	$("#eventos_distritales_tab").click(function(ev){
		var datos = {
			p1: 'distrital'
			// p1: 'local'
		}
		$.ajax({
			url: url_ok_obj+'consultarReporteAforos',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#div_table_eventos_distritales").html(data);
			$("#table_eventos_distritales").DataTable({
				responsive: false,
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
					title: 'Reporte Aforo eventos distritales 2019'
				}
				]
			}).draw(); 
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido consultar los datos");
			console.log(data);
		});
	});

	$("#eventos_locales_tab").click(function(ev){
		var datos = {
			// p1: 'distrital'
			p1: 'local'
		}
		$.ajax({
			url: url_ok_obj+'consultarReporteAforos',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#div_table_eventos_locales").html(data);
			table_eventos2 = $("#table_eventos_locales").DataTable({
				iDisplayLength: '50',
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
					title: 'Reporte Aforo eventos locales 2019'
				}
				]
			}).draw();
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido consultar los datos");
			console.log(data);
		});
	});
});