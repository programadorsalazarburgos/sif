var url_service = '../../Controlador/Territorial/C_Consultar_Talleres_Laboratorio_Clan.php';
$(function(){
	$("#SL_artista_formador").html(getArtistasFormadores());
	$("#SL_artista_formador").change(function(){
		var id_artista_formador = $(this).val();
		$("#SL_mes_reporte").html(getMesesClase(id_artista_formador));
	});
	$("#BT_consultar_clases").click(function(){
		var table_talleres = $("#table_datos_historico_clase").DataTable();
		table_talleres.clear();
		var id_artista_formador = $("#SL_artista_formador").val();
		var anio_mes = $("#SL_mes_reporte").val();
		$("#table_datos_historico_clase").html(getHistorialMesClasesArtistaFormador(id_artista_formador,anio_mes));
		
		table_talleres.destroy();
	    $("#table_datos_historico_clase").DataTable({
	        responsive: true,
	        "language": {
	            "lengthMenu": "Ver _MENU_ registros por pagina",
	            "zeroRecords": "No hay información, lo sentimos.",
	            "info": "Mostrando pagina _PAGE_ de _PAGES_",
	            "infoEmpty": "No hay registros disponibles",
	            "infoFiltered": "(filtered from _MAX_ total records)",
	            "search": "Filtrar"
	        }
	    });
	    table_talleres.draw();

	});
});

function getArtistasFormadores(){
	var mostrar = "";
	var datos = {
		'opcion':'get_artistas_formadores'
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}

function getMesesClase(id_artista_formador){
	var mostrar = "";
	var datos = {
		'opcion':'get_meses_clases',
		'id_artista_formador':id_artista_formador
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}

function getHistorialMesClasesArtistaFormador(id_artista_formador,anio_mes){
	var mostrar = "";
	var datos = {
		'opcion':'get_historial_clases_mes',
		'id_artista_formador':id_artista_formador,
		'anio_mes':anio_mes
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}