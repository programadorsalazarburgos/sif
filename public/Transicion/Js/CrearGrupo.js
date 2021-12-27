$(function(){
	$("#SL_artista_crea").html(parent.getOptionsArtistasFormadores()).selectpicker("refresh");
	$("#SL_artista_nidos").html(parent.getOptionsArtistasFormadoresNidos()).selectpicker("refresh");
	$(".checkbox_dias_clase").change(function(){
		var dia_semana = $(this).data('dia_clase');
		if($(this).prop('checked')){
			$("#SL_hora_inicio_dia_0" + dia_semana).removeAttr("disabled");
			$("#SL_hora_inicio_dia_0" + dia_semana).attr("required","required");
			$("#SL_hora_fin_dia_0" + dia_semana).removeAttr("disabled");
			$("#SL_hora_fin_dia_0" + dia_semana).attr("required","required");

			$("#SL_hora_inicio_dia_0" + dia_semana).html(getHorasInicio()).selectpicker('refresh');
			$("#SL_hora_fin_dia_0" + dia_semana).html(getHorasInicio()).selectpicker('refresh');
		}else{
			$("#SL_hora_inicio_dia_0" + dia_semana).attr("disabled","disabled");
			$("#SL_hora_inicio_dia_0" + dia_semana).removeAttr("required");
			$("#SL_hora_fin_dia_0" + dia_semana).attr("disabled","disabled");
			$("#SL_hora_fin_dia_0" + dia_semana).removeAttr("required");
		}
		$('#SL_hora_inicio_dia_0' + dia_semana).selectpicker('refresh');
		$('#SL_hora_fin_dia_0' + dia_semana).selectpicker('refresh');
	});

	$("#SL_crea").html(parent.getOptionsClanes()).selectpicker("refresh");

	$("#form_nuevo_grupo").submit(function(event){
		event.stopPropagation();
		event.preventDefault();

		var o = {};
		var a = $(this).serializeArray();
		$.each(a, function () {
			 if (o[this.name]) {
					 if (!o[this.name].push) {
							 o[this.name] = [o[this.name]];
					 }
					 o[this.name].push(this.value || '');
			 } else {
					 o[this.name] = this.value || '';
			 }
		});
		o['id_usuario'] = parent.idUsuario;
		datos_formulario = o;
		var total_check_seleccionados = 0;
		$(".checkbox_dias_clase").each(function(){
			if($(this).is(":checked"))
				total_check_seleccionados++;
		});
		if(total_check_seleccionados == 0){
			parent.mostrarAlerta("warning","Información Incompleta","Debe seleccionar por lo menos un (01) día de atención.");
			return;
		}
		$.ajax({
			url: '../../src/GestionClan/GestionClanController/'+'crearGrupoTransicion',
			type: 'POST',
			data: {
				p1:datos_formulario
			}
		}).done(function(data){
			if(data == 1){
				parent.mostrarAlerta("success","Grupo Creado","Se ha creado el grupo de transición correctamente");
			}else{
				parent.mostrarAlerta("error","Error","No se ha podido crear el grupo de transición." + data);
			}
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido crear el grupo de transición." + data);
			console.log(data)
		});
	});

	function getHorasInicio(){
		var mostrar = "";
		var hora = 6;
		var minuto = 0;
		var intervalo = 15;
		while (hora <= 21){
			while (minuto < 60){
				mostrar += "<option value='" + ((hora < 10) ? '0'+hora : hora) + ":" + ((minuto < 10) ? '0'+minuto : minuto) + "'>" + ((hora < 10) ? '0'+hora : hora) + ":" + ((minuto < 10) ? '0'+minuto : minuto) + "</option>";
				minuto += intervalo;
			}
			hora++;
			minuto = 0;
		}
		return mostrar;
	}
});