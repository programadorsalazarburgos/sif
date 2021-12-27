$(function(){
	$("#SL_area_artistica").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
	$.ajax({
		url: '../../src/GestionClan/GestionClanController/consultarZonas',
		type: 'POST',
		data: {},
		async: true
	}).done(function(result){
	      $("#SL_zona").html(result).selectpicker('refresh');
	}).fail(function(result){
	      console.log("Error: "+result);
	});
	$("#table_consulta").hide();
	$("#BT_consultar").on("click",function(ev){
		if (($('#SL_dias').val()).length > 0 & ($('#SL_area_artistica').val()).length > 0){
			var datos={
				'p1':{
					'id_zona':$("#SL_zona").val(),
					'id_area_artistica':$("#SL_area_artistica").val(),
					'dias':$("#SL_dias").val()
				}
			};
			$.ajax({
				url: '../../src/GestionClan/GestionClanController/consultarDisponibilidadArtistas',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				console.log(data);
				$("#table_consulta tbody").html(data);
				$("#table_consulta").show("slow");
			}).fail(function(result){
				console.log("Error: "+result);
			});
		}else{
			parent.mostrarAlerta("warning","Advertencia","Seleccione mínimo un area artistica y/o un día");
			$("#table_consulta").hide();
		}
	});
});