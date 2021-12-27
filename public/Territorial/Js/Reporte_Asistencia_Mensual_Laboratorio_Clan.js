var url_service = '../../Controlador/Territorial/C_Generar_Reporte_Asistencia_Laboratorio_Clan.php';
$(function(){
	$("#SL_mes_reporte").html(getMesesClases());
	$("#BT_generar_reporte").click(function(){
		var id_artista_formador = $("#SL_mes_reporte").data("id_artista_formador");
		var mes_reporte = $("#SL_mes_reporte").val();
		//$("#resultado_reporte").load("Generar_Reporte_Asistencia_Laboratorio_Clan.php?mes=" + mes_reporte + "&id_artista_formador=" + id_artista_formador);
		window.location.assign("../ReportePDF/Generar_Reporte_Asistencia_Laboratorio_Clan.php?mes=" + mes_reporte + "&id_artista_formador=" + id_artista_formador);
	});
});

function getMesesClases(){
	var mostrar = "";
	var id_artista_formador = $("#SL_mes_reporte").data("id_artista_formador");
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