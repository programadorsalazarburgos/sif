var url_service = '../../Controlador/ArtistaFormador/C_Reporte_Mensual_Asistencias_Grupo.php';
var url_controller = '../../Controlador/Pedagogico/C_Valoracion_Grupo.php'; 
$(function(){
	var caracterizacion;
	var id_grupo ="";
	var tipo_grupo="";
	var id_artista_formador = "";
	$("#SL_grupo").html(parent.getGruposDeUnUsuario(parent.idUsuario));  
	//$("#SL_grupo").append(getGruposArteEscuela() + getGruposEmprendeClan());
	$('#SL_grupo').on('change', function(e){
		e.preventDefault();
		codigoGrupo = $("#SL_grupo").val();
		tipoGrupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		var datos = {
			'opcion':'getCaracterizacion',
			'codigoGrupo': codigoGrupo,
			'lineaAtencion': tipoGrupo
		};	
		$.ajax({
			async: false,
			url: '../../Controlador/Pedagogico/C_Caracterizacion_Grupo.php',
			type:'POST',
			data: datos,
			success: function(datos){
				if (datos != 'null') {
					$('#BTN_Realizar_Caracterizacion').text('Modificar Caracterización');
					caracterizacion = JSON.parse(datos);
					var estado = '';
					if (caracterizacion.IN_Estado == null) {
						estado = "Sin Revisar";
					}
					else{
						if (caracterizacion.IN_Estado == '1') {
							estado = 'Aprobado';
						}
						else
						{
							estado = 'No Aprobado';
						}
					}
					if (caracterizacion.TX_Observacion != '' && caracterizacion.TX_Observacion != null) {
						$('#DIV_Observacion').show();
						$('#LB_Observacion').text(caracterizacion.TX_Observacion);
						
						$('#LB_Estado').text(estado);
						
					}else{
						$('#DIV_Observacion').show();
						$('#LB_Observacion').text("Sin Observación");
						$('#LB_Estado').text(estado);
					}
				}else{
					$('#BTN_Realizar_Caracterizacion').text('Realizar Caracterización');
					$('#DIV_Observacion').hide();
					$('#LB_Observacion').text("");
					$('#LB_Estado').text("");
				}
			}
		}); 
	});
	$("#FORM_Realizar_Caracterizacion").on('submit',function(e){
		e.preventDefault();
		id_grupo = $("#SL_grupo").val();
		tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		$("#GUARDAR_CARACTERIZACION").attr('data-id_grupo', id_grupo);
		$("#GUARDAR_CARACTERIZACION").attr('data-linea_atencion', tipo_grupo);
		id_artista_formador = $("#id_usuario").val();
		$.ajax({
			async : false,
			url: '../../Controlador/Territorial/C_Existencia_Caracterizacion_Grupo.php',
			type: 'POST',
			dataType: 'html',
			data: id_grupo,
			success: function(retorno)
			{
				if (!retorno) {

				}else{
					//bootbox.alert("El grupo AE-"+id_grupo+" ya ha sido caracterizado, si realiza la caracterizacion serán borradas las caracterizaciones anteriores.");	
				}		
			}
		});//CIERRA AJAX
		if(tipo_grupo=='arte_escuela'){
			mostrar_Formulario_Arte_Escuela();
			cargarCaracterizacion(caracterizacion);
		}
		if(tipo_grupo=='emprende_clan'){
			mostrar_Formulario_Emprende_Clan();
			cargarCaracterizacion(caracterizacion);
		}
		if(tipo_grupo=='laboratorio_clan'){
			mostrar_Formulario_Laboratorio_Clan();
			cargarCaracterizacion(caracterizacion);
		}
	});
	$("#SLIDER_CONVIVENCIA").slider();
	$("#SLIDER_ACTITUDINALES").slider();
	$("#SLIDER_COGNITIVOS").slider();
	$("#SLIDER_PROCEDIMENTALES").slider();
	$('.selectpicker').selectpicker();

	$("#EJ_1").on('click', function(){
		$("#MODAL_EJEMPLO_UNO").modal("show");
	});
	$("#EJ_2").on('click', function(){
		$("#MODAL_EJEMPLO_DOS").modal("show");
	});
	$("#EJ_3").on('click', function(){
		$("#MODAL_EJEMPLO_TRES").modal("show");
	});
	$("#EJ_4_1").on('click', function(){
		$("#MODAL_EJEMPLO_CUATRO_UNO").modal("show");
	});
	$("#EJ_4_2").on('click', function(){
		$("#MODAL_EJEMPLO_CUATRO_DOS").modal("show");
	});
	$("#EJ_4_3").on('click', function(){
		$("#MODAL_EJEMPLO_CUATRO_TRES").modal("show");
	});
	$("#EJ_5").on('click', function(){
		$("#MODAL_EJEMPLO_CINCO").modal("show");
	});
	$("#EJ_6").on('click', function(){
		$("#MODAL_EJEMPLO_SEIS").modal("show");
	});

	$("#FORM_CARACTERIZACION").on('submit', function(e){
		e.preventDefault();
		var box1 = bootbox.confirm("Está seguro que ha verificado los datos que ha ingresado y desea enviar?", function(result){
			if (result == true) {
				var intereses = ""; 
				$('#SL_Intereses :selected').each(function(i, selected){ 
					intereses = intereses + $(selected).text()+";";
				});
				var necesidades = ""; 
				$('#SL_Necesidades :selected').each(function(i, selected){ 
					necesidades = necesidades + $(selected).text()+";";
				});
				var etnias = ""; 
				$('#SL_Etnias :selected').each(function(i, selected){ 
					etnias = etnias + $(selected).text()+";";
				});

				var ciclos = ""; 
				$('#SL_CICLO :selected').each(function(i, selected){ 
					ciclos = ciclos + $(selected).val()+",";
				});
				ciclos = ciclos.slice(0, -1);
				
				var datos = $("#FORM_CARACTERIZACION").serializeArray();
				datos.push({
					name: 'id_artista_formador', 
					value: id_artista_formador
				});
				datos.push({
					name: 'id_grupo', 
					value: id_grupo
				});
				datos.push({
					name: 'linea_atencion',
					value: tipo_grupo
				});
				datos.push({
					name: 'intereses', 
					value: intereses
				});
				datos.push({
					name: 'necesidades', 
					value: necesidades
				});
				datos.push({
					name: 'ciclos', 
					value: ciclos
				});
				datos.push({
					name: 'etnias', 
					value: etnias
				});
				datos.push({
					name: 'opcion', 
					value: 'guardarCaracterizacion'
				});

				$.ajax({
					async : false,
					url: '../../Controlador/Pedagogico/C_Caracterizacion_Grupo.php',
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function(retorno)
					{
						if (tipo_grupo == "arte_escuela"){
							var box2 = bootbox.alert("El grupo AE-"+id_grupo+" ha sido caracterizado.<br><br>Va a ser redirigido a la página de consultar de grupos donde encontrará la Caracterización realizada."
								,function(){
									location.href = '../ConsultasReportes/Consultar_Grupos.php';
								});
							box2.css({
								'top': '50%',
								'margin-top': '15%'
							});
							$("#FORM_CARACTERIZACION")[0].reset();
							$("#GUARDAR_CARACTERIZACION").prop('disabled', true);
						}
						if (tipo_grupo == "emprende_clan") {
							var box2 = bootbox.alert("El grupo EC-"+id_grupo+" ha sido caracterizado.<br><br>Va a ser redirigido a la página de consultar de grupos donde encontrará la Caracterización realizada."
								,function(){
									location.href = '../ConsultasReportes/Consultar_Grupos.php';
								});
							box2.css({
								'top': '50%',
								'margin-top': '15%' 
							});
							$("#FORM_CARACTERIZACION")[0].reset();
							$("#GUARDAR_CARACTERIZACION").prop('disabled', true);
						}
						if (tipo_grupo == "laboratorio_clan") {
							var box2 = bootbox.alert("El grupo LC-"+id_grupo+" ha sido caracterizado.<br><br>Va a ser redirigido a la página de consultar de grupos donde encontrará la Caracterización realizada."
								,function(){
									location.href = '../ConsultasReportes/Consultar_Grupos.php';
								});
							box2.css({
								'top': '50%',
								'margin-top': '15%'
							});
							$("#FORM_CARACTERIZACION")[0].reset();
							$("#GUARDAR_CARACTERIZACION").prop('disabled', true);
						}
					}
				});//CIERRA AJAX
			}
			if (result == false) {

			}
		});
		box1.css({
			'top': '50%',
			'margin-top': '15%'
		});
		
	});//FIN SUBMIT FORMULARIO
});

function cargarCaracterizacion(caracterizacion) {
	if (caracterizacion != undefined) {
		var ciclo = caracterizacion.FK_Ciclo.split(",");
		$.each(ciclo, function (i) {
			if (ciclo[i] != '') {
				$("#SL_CICLO option[value='" + ciclo[i]+ "']").prop('selected', true);
			}
		}); 
		$('#TXTA_DESCRIPCION_GRUPO').val(caracterizacion.TX_Descripcion_Grupo);
		$('#SLIDER_CONVIVENCIA').slider("setAttribute", "value", parseInt(caracterizacion.IN_Escala_Convivencia));
		$("#SLIDER_CONVIVENCIA").slider('refresh');
		$('#TXTA_CONVIVENCIA').val(caracterizacion.TX_Convivencia);
		var intereses = caracterizacion.TX_Array_Intereses.split(";");
		$.each(intereses, function (i) {
			if (intereses[i] != '') {
				$("#SL_Intereses option").filter(function() { return $(this).text() == intereses[i]; }).prop('selected', true);
			}
		}); 
		$('.selectpicker').selectpicker('refresh');
		$('#TX_OTROS_INTERESES').val(intereses[intereses.length-1]);
		$('#TXTA_INTERESES').val(caracterizacion.TX_Descripcion_Intereses);
		$('#SLIDER_ACTITUDINALES').slider("setAttribute", "value", parseInt(caracterizacion.IN_Escala_Actitudinal));
		$("#SLIDER_ACTITUDINALES").slider('refresh');
		$('#TXTA_ACTITUDINALES').val(caracterizacion.TX_Actitudinal);
		$('#SLIDER_COGNITIVOS').slider("setAttribute", "value", parseInt(caracterizacion.IN_Escala_Cognitiva));
		$("#SLIDER_COGNITIVOS").slider('refresh');
		$('#TXTA_COGNITIVOS').val(caracterizacion.TX_Cognitiva);
		$('#SLIDER_PROCEDIMENTALES').slider("setAttribute", "value", parseInt(caracterizacion.IN_Escala_Procedimental));
		$("#SLIDER_PROCEDIMENTALES").slider('refresh');
		$('#TXTA_PROCEDIMENTALES').val(caracterizacion.TX_Procedimental);
		var necesidades = caracterizacion.VC_Necesidades.split(";");
		$.each(necesidades, function (i) {
			if (necesidades[i] != '') {
				$("#SL_Necesidades option").filter(function() { return $(this).text() == necesidades[i]; }).prop('selected', true);
			}
		}); 
		$('.selectpicker').selectpicker('refresh');
		var etnias = caracterizacion.VC_Etnias.split(";");
		$.each(etnias, function (i) {
			if (etnias[i] != '') {
				$("#SL_Etnias option").filter(function() { return $(this).text() == etnias[i]; }).prop('selected', true);
			}
		}); 
		$('.selectpicker').selectpicker('refresh');
		$('#TXTA_PARTICULARIDADES').val(caracterizacion.TX_Particularidades);
		$('#TXTA_ESPACIO').val(caracterizacion.TX_Descripcion_Espacio);
		$('#TXTA_OBSERVACIONES').val(caracterizacion.TX_Observaciones);
		$('.selectpicker').selectpicker('refresh');
	}
}

function mostrar_Formulario_Arte_Escuela(){
	var codigo_grupo = $("#SL_grupo").val();
	var id_grupo = "AE-"+$("#SL_grupo").val();
	$("#id_del_grupo").html("Grupo: "+id_grupo);
	$("#DIV_SELECCIONAR_GRUPO").hide('fast');
	$("#DIV_FORM_CARACTERIZACION").show('fast');
	//AJAX CONSULTA INFORMACION GRUPO.
	$.ajax({
		async : false,
		url: '../../Controlador/ConsultasReportes/Caracterizacion_Consulta_Info_Grupo.php',
		type: 'POST',
		dataType: 'json',
		data: {codigo_grupo: codigo_grupo, tipo_grupo:'arte_escuela'},
		success: function(INFO)
		{
			if(!INFO[0]){}
				else{
					$("#LB_Area_Artistica").append("Área Artística: "+INFO[0].VC_Nom_Area);
					$("#LB_Colegio").append(INFO[0].VC_Nom_Colegio);
					$("#LB_Clan").append(INFO[0].VC_Nom_Clan);
					$("#LB_Fecha_Inicio").append("Fecha de Inicio: El grupo no ha iniciado");
					var lugar_atencion = "";
					if(INFO[0].IN_lugar_atencion == 1){
						lugar_atencion = "COLEGIO";
					}else{
						if(INFO[0].IN_lugar_atencion == 2){
							lugar_atencion = "CREA";		
						}
						else{
							if(INFO[0].IN_lugar_atencion == 3) {
								lugar_atencion = "CREA y COLEGIO";				
							}
						}
					}
					$("#LB_Lugar_Atencion").append("Lugar de Atención: "+lugar_atencion);
				}
			}
			});//FIN AJAX
			//Consulta Horario del Grupo
			$.ajax({
				async : false,
				url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
				type: 'POST',
				dataType: 'html',
				data: {opcion: 'getHorarioGrupoArteEscuela', codigo_grupo:codigo_grupo},
				success: function(INFO)
				{
					if(!INFO){}
						else{
							$("#LB_Horario").append("HORARIO:<br>"+INFO);
						}
					}
			});//FIN AJAX
			//Consulta Fecha de Primera Clase del Grupo.
			$.ajax({
				async : false,
				url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
				type: 'POST',
				dataType: 'html',
				data: {opcion: 'getFechaPrimerClaseGrupoArteEscuela', codigo_grupo:codigo_grupo},
				success: function(INFO)
				{
					if(!INFO){}
						else{
							$("#LB_Fecha_Inicio").html("Fecha de Inicio: "+INFO);
						}
					}
			});//FIN AJAX
			//Consulta Promedio de Asistentes al Grupo.
			/*$.ajax({
				async : false,
				url: '../../Controlador/GestionClan/C_Consultar_Grupos.php',
				type: 'POST',
				dataType: 'html',
				data: {opcion: 'getPromedioAsistentesGrupoArteEscuela', codigo_grupo:codigo_grupo},
				success: function(INFO)
				{
					if(!INFO){}
					else{
						$("#LB_Promedio_Asistentes").html("Promedio Asistentes: "+INFO);
					}
				}
			});//FIN AJAX*/
		}

		function mostrar_Formulario_Emprende_Clan(){
			var codigo_grupo = $("#SL_grupo").val();
			var id_grupo = "EC-"+$("#SL_grupo").val();
			$("#id_del_grupo").html("Grupo: "+id_grupo);
			$("#DIV_SELECCIONAR_GRUPO").hide('fast');
			$("#DIV_FORM_CARACTERIZACION").show('fast');
			//AJAX CONSULTA INFORMACION GRUPO.
			$.ajax({
				async : false,
				url: '../../Controlador/ConsultasReportes/Caracterizacion_Consulta_Info_Grupo.php',
				type: 'POST',
				dataType: 'json',
				data: {codigo_grupo: codigo_grupo, tipo_grupo: 'emprende_clan'},
				success: function(INFO)
				{
					if(!INFO[0]){}
						else{
							$("#LB_Area_Artistica").append("Área Artística: "+INFO[0].VC_Nom_Area);
							$("#LB_Colegio").append('MODALIDAD: '+INFO[0].VC_Nom_Modalidad);
							$("#LB_Clan").append(INFO[0].VC_Nom_Clan);
							$("#LB_Fecha_Inicio").append("Fecha de Inicio: El grupo no ha iniciado");
							var lugar_atencion = "CREA";
							$("#LB_Lugar_Atencion").append("Lugar de Atención: "+lugar_atencion);
						}
					}
			});//FIN AJAX
			//Consulta Horario del Grupo
			$.ajax({
				async : false,
				url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
				type: 'POST',
				dataType: 'html',
				data: {opcion: 'getHorarioGrupoEmprendeClan', codigo_grupo:codigo_grupo},
				success: function(INFO)
				{
					if(!INFO){}
						else{
							$("#LB_Horario").append("HORARIO:<br>"+INFO);
						}
					}
			});//FIN AJAX
			//Consulta Fecha de Primera Clase del Grupo.
			$.ajax({ 
				async : false,
				url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
				type: 'POST',
				dataType: 'html',
				data: {opcion: 'getFechaPrimerClaseGrupoEmprendeClan', codigo_grupo:codigo_grupo},
				success: function(INFO)
				{
					if(!INFO){}
						else{
							$("#LB_Fecha_Inicio").html("Fecha de Inicio: "+INFO);
						}
					}
			});//FIN AJAX
		}

		function mostrar_Formulario_Laboratorio_Clan(){
			var codigo_grupo = $("#SL_grupo").val();
			var id_grupo = "LC-"+$("#SL_grupo").val();
			$("#id_del_grupo").html("Grupo: "+id_grupo); 
			$("#DIV_SELECCIONAR_GRUPO").hide('fast');
			$("#DIV_FORM_CARACTERIZACION").show('fast');
			//AJAX CONSULTA INFORMACION GRUPO.
			$.ajax({
				async : false,
				url: '../../Controlador/ConsultasReportes/Caracterizacion_Consulta_Info_Grupo.php',
				type: 'POST',
				dataType: 'json',
				data: {codigo_grupo: codigo_grupo, tipo_grupo: 'laboratorio_clan'}, 
				success: function(INFO)
				{
					if(!INFO[0]){}
						else{
							$("#LB_Area_Artistica").append("Área Artística: "+INFO[0].VC_Nom_Area);							
							$("#LB_Clan").append(INFO[0].VC_Nom_Clan);
							$("#LB_Fecha_Inicio").append("Fecha de Inicio: El grupo no ha iniciado");
							var lugar_atencion = "CREA";
							$("#LB_Lugar_Atencion").append("Lugar de Atención: "+lugar_atencion);
						}
					}
			});//FIN AJAX
			//Consulta Horario del Grupo
			$.ajax({
				async : false,
				url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
				type: 'POST',
				dataType: 'html',
				data: {opcion: 'getHorarioGrupoLaboratorioClan', codigo_grupo:codigo_grupo},
				success: function(INFO)
				{
					if(!INFO){}
						else{
							$("#LB_Horario").append("HORARIO:<br>"+INFO);
						}
					}
			});//FIN AJAX
			//Consulta Fecha de Primera Clase del Grupo.
			$.ajax({ 
				async : false,
				url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
				type: 'POST',
				dataType: 'html',
				data: {opcion: 'getFechaPrimerClaseGrupoLaboratorioClan', codigo_grupo:codigo_grupo,tipo_grupo: 'laboratorio_clan'},
				success: function(INFO)
				{
					if(!INFO){}
						else{
							$("#LB_Fecha_Inicio").html("Fecha de Inicio: "+INFO);
						}
					}
			});//FIN AJAX
		}		