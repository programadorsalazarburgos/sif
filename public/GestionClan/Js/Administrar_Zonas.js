var url_ok_obj = '../../src/GestionClan/GestionClanController/';
var id_zona_modificar = 0;
$(function(){
	$("#SL_localidades_zona").html(parent.getOptionsLocalidades()).selectpicker('refresh');
	$("#SL_responsable_zona").html(parent.getOptionsUsuariosRol(18)).selectpicker('refresh');
	$("#SL_creas_zona").html(parent.getOptionsClanes()).selectpicker('refresh');	

	$("#form_nueva_zona").submit(function(event){
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
		var datos_formulario = o;
		// console.log(datos_formulario);
		datos = {
			'p1': datos_formulario
		};
		$.ajax({
			url: url_ok_obj+'crearNuevaZona',
			type: 'POST',
			data: datos,
			async:false,
			beforeSend: function(){
				$("#BT_guardar_nueva_zona").attr("disabled","disabled");
				parent.mostrarCargando();
			}
		}).done(function(data){
			parent.cerrarCargando();
			$("#BT_guardar_nueva_zona").removeAttr("disabled");
			$('#form_nueva_zona').trigger("reset");
			$('#form_nueva_zona select').selectpicker('deselectAll');
			parent.mostrarAlerta("success","Zona Creada","Se ha creado la zona satisfactoriamente");
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido crear la zona." + data);
			console.log(data)
		});
	});

	$("#nav_modificar_zona").click(function(){
		$("#SL_zona_modificar").html(parent.consultarZonas()).selectpicker('refresh');
		$("#SL_localidades_zona_modificar").html(parent.getOptionsLocalidades()).selectpicker('refresh');
		$("#SL_responsable_zona_modificar").html(parent.getOptionsUsuariosRol(18)).selectpicker('refresh');
		$("#SL_creas_zona_modificar").html(parent.getOptionsClanes()).selectpicker('refresh');
	});

	$("#nav_modificar_zona").click(function(){
		$("#SL_zona_artistas_avatar").html(parent.consultarZonas()).selectpicker('refresh');
	});

	$("#SL_zona_modificar").on('change', function(e){
		e.preventDefault();
		id_zona_modificar = $(this).val();
		var nombre_zona = $(this).find(':selected').data('nombre_zona');
		var id_responsable = $(this).find(':selected').data('id_responsable')
		var id_localidad = $(this).find(':selected').data('localidades');
		var id_crea = $(this).find(':selected').data('creas');
		$('select option').prop('selected',false);
		$("#TX_nombre_zona_modificar").val(nombre_zona);
		$("#SL_responsable_zona_modificar").val(id_responsable).selectpicker('refresh');
		if(id_localidad.toString().includes(",") > 0){
			$.each(id_localidad.split(","), function(i,e){
				$("#SL_localidades_zona_modificar option[value='" + e + "']").prop("selected", true);
			});
		}else{
			$("#SL_localidades_zona_modificar option[value='" + id_localidad + "']").prop("selected", true);
		}
		$("#SL_localidades_zona_modificar").selectpicker('refresh');
		if(id_crea.toString().includes(",") > 0){
			$.each(id_crea.split(","), function(i,e){
				$("#SL_creas_zona_modificar option[value='" + e + "']").prop("selected", true);
			});
		}else{
			$("#SL_creas_zona_modificar option[value='" + id_crea + "']").prop("selected", true);
		}
		$("#SL_creas_zona_modificar").selectpicker('refresh');
	});

	$("#SL_zona_artistas_avatar").change(function(e){
		datos = {
			'p1': $(this).val()
		};
		$.ajax({
			url: url_ok_obj+'ConsultarArtistasAreaPorZona',
			type: 'POST',
			data: datos,
			async:false,
			beforeSend: function(){
				parent.mostrarCargando();
			}
		}).done(function(data){
			parent.cerrarCargando();
			console.log(data);
		});
	});

	$("#form_modificar_zona").submit(function(event){
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
		var datos_formulario = o;
		datos = {
			'p1': datos_formulario,
			'p2': id_zona_modificar
		};
		$.ajax({
			url: url_ok_obj+'modificarZona',
			type: 'POST',
			data: datos,
			async:false,
			beforeSend: function(){
				$("#BT_guardar_zona_modificar").attr("disabled","disabled");
				parent.mostrarCargando();
			}
		}).done(function(data){
			parent.cerrarCargando();
			if(data == 1){
				parent.mostrarAlerta("success","Guardado","Se ha actualizado la zona correctamente");
				$("#BT_guardar_zona_modificar").removeAttr("disabled");
				$("#SL_zona_modificar").html(parent.consultarZonas()).val(id_zona_modificar).selectpicker('refresh');
				$("#nav_modificar_zona").trigger("click");
			}
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido modificar la zona." + data);
			console.log(data)
		});
	});
});