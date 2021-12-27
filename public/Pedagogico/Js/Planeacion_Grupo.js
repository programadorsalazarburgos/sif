var url_service = '../../Controlador/Pedagogico/C_Valoracion_Grupo.php';
var url_controller = '../../Controlador/Pedagogico/C_Planeacion_Grupo.php';
var numPreguntas = 0; 
$(document).ready(function(){
	var artistaFormadorId = $("#id_usuario").val();
	var datos = {
		'opcion':'getFormador',
		'idUsuario': artistaFormadorId
	};
	$.ajax({
		async: false,
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(datos){
			item = JSON.parse(datos)[0];
			formadorNombre = item.VC_Primer_Nombre+' '+item.VC_Segundo_Nombre+' '+item.VC_Primer_Apellido+' '+item.VC_Segundo_Apellido;
			$('#LB_Formador').text(""+ formadorNombre);
		}
	}); 
	$('#SL_grupo').on('change', function(e){
		e.preventDefault();
		codigoGrupo = $("#SL_grupo").val();
		tipoGrupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		var datos = {
			'opcion':'getPlaneacion',
			'codigoGrupo': codigoGrupo,
			'lineaAtencion': tipoGrupo
		};	
		$.ajax({
			async: false,
			url:url_controller,
			type:'POST',
			data: datos,
			success: function(datos){
				if (datos != 'null') {
					$('#BTN_Generar_Planeacion').text('Modificar Planeación');
					planeacion = JSON.parse(datos);
					var estado = '';
					if (planeacion.IN_Estado == null) {
						estado = "Sin Revisar";
					}
					else{
						if (planeacion.IN_Estado == '1') {
							estado = 'Aprobado';
						}
						else
						{
							estado = 'No Aprobado';
						}
					}
					$('#LB_Estado').text(estado);
					if (planeacion.VC_Observacion != '' && planeacion.VC_Observacion != null) {
						$('#DIV_Observacion').show();
						$('#LB_Observacion').text(planeacion.VC_Observacion);
					}else{
						$('#DIV_Observacion').show();
						$('#LB_Observacion').text("No cuenta con observaciones sobre la ultima planeación realizada");
					}
				}else{
					$('#BTN_Generar_Planeacion').text('Realizar Planeación');
					$('#DIV_Observacion').hide();
					$('#LB_Observacion').text("");
				}
			}
		}); 
	});
	
	$('#DIV_Ciclo').hide();
	$('#SL_CICLO').on('change',function(e){
		e.preventDefault();
		if ($(this).val() == '0' || $(this).val() == '') {
			$('#DIV_Ciclo').hide();
		}
		else
		{
			$('#DIV_Ciclo').show();
			$('#LB_Ciclo').text($('#SL_CICLO :selected').text());//
		}		
	});
	
	getRecursos();
	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var fecha = d.getFullYear() + '-' +
	((''+month).length<2 ? '0' : '') + month + '-' +
	((''+day).length<2 ? '0' : '') + day;
	$("#LB_Fecha_Elaboracion").text(fecha);
	$("#SL_grupo").html(parent.getGruposDeUnUsuario(parent.idUsuario)).selectpicker("refresh");
	//$("#SL_grupo").append(getGruposArteEscuela() + getGruposEmprendeClan());
	$("#FORM_Realizar_Planeacion").on('submit',function(e){
		e.preventDefault();
		codigoGrupo = $("#SL_grupo").val();
		tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		
		if(tipo_grupo=='arte_escuela'){
			showForm(1,'arte_escuela');
			$("#id_del_grupo").html("AE-"+codigoGrupo);
		}
		if(tipo_grupo=='emprende_clan'){
			showForm(2,'emprende_clan');
			$("#id_del_grupo").html("EC-"+codigoGrupo);
		}
		if(tipo_grupo=='laboratorio_clan'){
			showForm(3,'laboratorio_clan');
			$("#id_del_grupo").html("LC-"+codigoGrupo);
		}
	});
	$("#FORM_PLANEACION").on('submit', function(e){
		e.preventDefault();
		if ($('#SL_Metodologia').val() != "" || $('#TXT_Otras_Metodologias').val() != "") {
			var recursosSelec = ""; 
			$('#SL_Recursos :selected').each(function(i, selected){ 
				recursosSelec = recursosSelec + $(selected).val()+";";
			});
			var referentes = "";
			for (var i = 1; i <= numPreguntas; i++) {
				if ($('#TX_Referente_'+i).val() != '' ) {
					referentes = referentes+ $('#TX_Referente_'+i).val()+";";
				}
			}  
			var metodologias = "";
			$('#SL_Metodologia :selected').each(function(i, selected){ 
				metodologias = metodologias + $(selected).text()+";";
			});
			metodologias = metodologias + $('#TXT_Otras_Metodologias').val();
			var ciclos = ""; 
			$('#SL_CICLO :selected').each(function(i, selected){ 
				ciclos = ciclos + $(selected).val()+",";
			});
			ciclos = ciclos.slice(0, -1);

			var datos = $("#FORM_PLANEACION").serializeArray();
			datos.push({
				name: 'opcion', 
				value: "guardarDatos"
			});
			datos.push({
				name: 'artistaFormadorId', 
				value: artistaFormadorId
			});
			datos.push({
				name: 'metodologias', 
				value: metodologias
			});
			datos.push({
				name: 'ciclos', 
				value: ciclos
			});
			datos.push({
				name: 'referentes', 
				value: referentes
			});
			datos.push({
				name: 'codigoGrupo', 
				value: codigoGrupo
			});
			datos.push({
				name: 'recursosSelec',
				value: recursosSelec
			});
			datos.push({
				name: 'tipo_grupo',
				value: tipo_grupo
			});
			$.ajax({
				async : false,
				url: url_controller,
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(retorno)
				{
					if(tipo_grupo=='arte_escuela'){
						var box1 = bootbox.alert(
							"Se ha registrado la planeacion del grupo AE-"+codigoGrupo+".<br><br>Va a ser redirigido a la página de consultar de grupos donde encontrará la Planeación realizada."
							,function(){
								location.href = '../ConsultasReportes/Consultar_Grupos.php';
							});
						box1.css({
							'top': '30%',
							'margin-top': '15%' 
						});
					}
					if(tipo_grupo=='emprende_clan'){
						var box1 = bootbox.alert("Se ha registrado la planeacion del grupo EC-"+codigoGrupo+".<br><br>Va a ser redirigido a la página de consultar de grupos donde encontrará la Planeación realizada."
							,function(){
								location.href = '../ConsultasReportes/Consultar_Grupos.php';
							});
						box1.css({
							'top': '40%',
							'margin-top': '15%' 
						});
					}
					if(tipo_grupo=='laboratorio_clan'){
						var box1 = bootbox.alert("Se ha registrado la planeacion del grupo LC-"+codigoGrupo+".<br><br>Va a ser redirigido a la página de consultar de grupos donde encontrará la Planeación realizada."
							,function(){
								location.href = '../ConsultasReportes/Consultar_Grupos.php';
							});
						box1.css({
							'top': '40%',
							'margin-top': '15%' 
						});
					}
					$("#FORM_PLANEACION")[0].reset();
					$("#BTN_Guardar_planeacion").prop('disabled', true);
				}
			});
		}
		else
		{
			$('#SL_Metodologia').focus();
			var box2 = bootbox.alert('Debe diligenciar por lo menos una metodología');
			box2.css({
				'top': '40%',
				'margin-top': '15%'
			});
		}
	});
});
function showForm(linea,lineaText){

	$("#div_seleccionar_grupo").hide('fast');
	if (linea == 1) {
		$("#div_form_planeacion_arte").show('fast');
		$('#LB_Linea_Atencion').text('Arte En La Escuela');

		$('#LB_Entidad').text("Entidad/Organización: "+getEntidad(codigoGrupo,linea).VC_Nom_Organizacion);
		getHorario(codigoGrupo,linea);
		$.ajax({
			async : false,
			url: url_controller,
			type: 'POST',
			dataType: 'json',
			data: {idGrupo: codigoGrupo,tipoGrupo:lineaText,opcion:'getCInformacionGrupo'},
			success: function(datos)
			{
				$("#LB_Area_Artistica").append(datos[0].VC_Nom_Area);
				$("#LB_Colegio").append(datos[0].VC_Nom_Colegio);
				$("#LB_Clan").append(datos[0].VC_Nom_Clan);
				$("#LB_Fecha_Inicio").append("Fecha de Inicio: El grupo no ha iniciado");
				var lugar_atencion = "";
				if(datos[0].IN_lugar_atencion == 1){
					lugar_atencion = "COLEGIO";
				}else{
					if(datos[0].IN_lugar_atencion == 2){
						lugar_atencion = "CREA";		
					}
					else{
						if(datos[0].IN_lugar_atencion == 3) {
							lugar_atencion = "CREA y COLEGIO";				
						}
					}
				}
				if (linea == 2) {
					lugar_atencion = 'CREA';
				}
				if (linea == 3) {
					lugar_atencion = datos[0].VC_Descripcion;
				}
				$("#LB_Lugar_Atencion").append(lugar_atencion);
			}
		});
		$('[data-toggle="tooltip"]').tooltip(
		{
			"animation": 1
		});
		cargarPlaneacion(codigoGrupo,lineaText);
	}
	if (linea == 2) {
		$('#LB_Linea_Atencion').text('Emprende CREA');
	}
	if (linea == 3) {
		$('#LB_Linea_Atencion').text('Laboratorio CREA');
	}
}

function cargarPlaneacion(codigoGrupo,lineaAtencion){
	var datos = {
		'opcion':'getPlaneacion',
		'codigoGrupo': codigoGrupo,
		'lineaAtencion': lineaAtencion
	};			
	numPreguntas = 0;
	$.ajax({
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(data){
			if (data != 'null') {
				planeacion = JSON.parse(data);
				planeacion.VC_Acciones = JSON.parse(planeacion.VC_Acciones);			
				// $("#SL_CICLO option[value="+planeacion.FK_Ciclo+"]").attr('selected', 'selected');
				var ciclo = planeacion.FK_Ciclo.split(",");
				$.each(ciclo, function (i) {
					if (ciclo[i] != '') {
						$("#SL_CICLO option[value='" + ciclo[i]+ "']").prop('selected', true);
					}
				}); 
				$('#TXT_Objetivo_Formacion').val(planeacion.VC_Objetivo);
				$('#TXT_Pregunta').val(planeacion.VC_Pregunta);
				$('#TXT_Descripcion_proyecto').val(planeacion.VC_Descripcion);
				$('#TXT_Circulacion').val(planeacion.VC_Propuesta_Circulacion);
				// $('#SL_Metodologia').val(planeacion.VC_Metodologia); // selet text
				$('#TXT_Temas').val(planeacion.VC_Temas);
				var recursos = planeacion.VC_Recursos.split(";");
				$.each(recursos, function (i) {
					if (recursos[i] != '') {
						$("#SL_Recursos option[value='" + recursos[i]+ "']").prop('selected', true);
					}
				}); 
				$('#TX_Otros_Recursos').val(recursos[recursos.length-1]);


				var metodologias = planeacion.VC_Metodologia.split(";");
				$.each(metodologias, function (i) {
					if (metodologias[i] != '') {
						$("#SL_Metodologia option").filter(function() { return $(this).text() == metodologias[i]; }).prop('selected', true);
					}
				}); 
				$('#TXT_Otras_Metodologias').val(metodologias[metodologias.length-1]);
				// $('#referentes').val(planeacion.VC_Referentes); // for split - add text	
				var referentes = planeacion.VC_Referentes.split(";");
				$.each(referentes, function (i) {
					if (referentes[i] != '') {						
						numPreguntas = numPreguntas + 1;
						$("#div-preguntas").append(
							'<div class="form-group col-lg-12 col-md-12" >'+
							'<li >'+
							'<div class="col-lg-12 col-md-12"  >'+
							'<input  maxlength="500" class="form-control" id="TX_Referente_'+numPreguntas+'"name="TX_Referente_'+numPreguntas+'" placeholder="Referente '+numPreguntas+'" type="text" required>'+
							'</div> </li>'+
							'</div>'  
							);	
						$("#TX_Referente_"+numPreguntas).val(referentes[i]);
					}
				}); 
				if (planeacion.FK_Ciclo == '0' || planeacion.FK_Ciclo == '') {
					$('#DIV_Ciclo').hide();
				}
				else
				{
					$('#DIV_Ciclo').show();
					$('#LB_Ciclo').text($('#SL_CICLO :selected').text());
				}
				$('#TXT_Resultados').val(planeacion.VC_Resultados);
				$('#TXT_Articulacion').val(planeacion.VC_Articulacion);
				$('#TXT_Ciclo').val(planeacion.VC_Ciclo != null && planeacion.VC_Ciclo != '' ?planeacion.VC_Ciclo:' ');
				$('#TXT_semana_1').val(planeacion.VC_Acciones.semana_1);
				$('#TXT_semana_2').val(planeacion.VC_Acciones.semana_2);
				$('#TXT_semana_3').val(planeacion.VC_Acciones.semana_3);
				$('#TXT_semana_4').val(planeacion.VC_Acciones.semana_4);
				$('#TXT_semana_5').val(planeacion.VC_Acciones.semana_5);
				$('#TXT_semana_6').val(planeacion.VC_Acciones.semana_6);
				$('#TXT_semana_7').val(planeacion.VC_Acciones.semana_7);
				$('#TXT_semana_8').val(planeacion.VC_Acciones.semana_8);
				$('#TXT_semana_9').val(planeacion.VC_Acciones.semana_9);
				$('#TXT_semana_10').val(planeacion.VC_Acciones.semana_10);
				$('#TXT_semana_11').val(planeacion.VC_Acciones.semana_11);
				$('#TXT_semana_12').val(planeacion.VC_Acciones.semana_12);
				$('#TXT_semana_13').val(planeacion.VC_Acciones.semana_13);
				$('#TXT_semana_14').val(planeacion.VC_Acciones.semana_14);
				$('#TXT_semana_15').val(planeacion.VC_Acciones.semana_15);
				$('#TXT_semana_16').val(planeacion.VC_Acciones.semana_16);
				$('#TXT_semana_17').val(planeacion.VC_Acciones.semana_17);
				$('#TXT_semana_18').val(planeacion.VC_Acciones.semana_18);
				$('#TXT_semana_19').val(planeacion.VC_Acciones.semana_19);
				$('#TXT_semana_20').val(planeacion.VC_Acciones.semana_20);
				$('#TXT_semana_21').val(planeacion.VC_Acciones.semana_21);
				$('#TXT_semana_22').val(planeacion.VC_Acciones.semana_22);
				$('#TXT_semana_23').val(planeacion.VC_Acciones.semana_23);
				$('#TXT_semana_24').val(planeacion.VC_Acciones.semana_24);
				$('#TXT_semana_25').val(planeacion.VC_Acciones.semana_25);
				$('#TXT_semana_26').val(planeacion.VC_Acciones.semana_26);
				$('#TXT_semana_27').val(planeacion.VC_Acciones.semana_27);
				$('#TXT_semana_28').val(planeacion.VC_Acciones.semana_28);
				$('#TXT_semana_29').val(planeacion.VC_Acciones.semana_29);
				$('#TXT_semana_30').val(planeacion.VC_Acciones.semana_30);
				$('#TXT_semana_31').val(planeacion.VC_Acciones.semana_31);
				$('#TXT_semana_32').val(planeacion.VC_Acciones.semana_32);
				$('#TXT_semana_33').val(planeacion.VC_Acciones.semana_33);
				$('#TXT_semana_34').val(planeacion.VC_Acciones.semana_34);
				$('#TXT_semana_35').val(planeacion.VC_Acciones.semana_35);
				$('#TXT_semana_36').val(planeacion.VC_Acciones.semana_36);
				$('#TXT_semana_37').val(planeacion.VC_Acciones.semana_37);
				$('#TXT_semana_38').val(planeacion.VC_Acciones.semana_38);
				$('#TXT_semana_39').val(planeacion.VC_Acciones.semana_39);
				$('#TXT_semana_40').val(planeacion.VC_Acciones.semana_40);
				$('#TXT_semana_41').val(planeacion.VC_Acciones.semana_41);
				$('#TXT_semana_42').val(planeacion.VC_Acciones.semana_42);
				$('#TXT_semana_43').val(planeacion.VC_Acciones.semana_43);
				$('#TXT_semana_44').val(planeacion.VC_Acciones.semana_44);
				$('.selectpicker').selectpicker('refresh');
			}
			else
			{
				numPreguntas = numPreguntas + 1;
				$("#div-preguntas").append(
					'<div class="form-group col-lg-12 col-md-12" >'+
					'<li  >'+
					'<div class="col-lg-12 col-md-12"  >'+
					'<input  maxlength="500" class="form-control" id="TX_Referente_'+numPreguntas+'"name="TX_Referente_'+numPreguntas+'" placeholder="Referente '+numPreguntas+'" type="text" required>'+
					'</div></li> '+
					'</div>'   
					);

			}
		},
		async: false
	})
$("#a-add").click(function(e){
	e.preventDefault();
	numPreguntas = numPreguntas + 1;
	$("#div-preguntas").append(
		'<div class="form-group col-lg-12 col-md-12" >'+
		'<li >'+
		'<div class="col-lg-12 col-md-12"  >'+
		'<input  maxlength="500" class="form-control" id="TX_Referente_'+numPreguntas+'"name="TX_Referente_'+numPreguntas+'" placeholder="Referente '+numPreguntas+'" type="text">'+
		'</div> </li>'+    
		'</div>'
		); 
});

}



function getRecursos(){
	$('#SL_Recursos').html("");
	var retrun = "";
	var datos = {
		'opcion':'getRecursos'
	};
	$.ajax({
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(data){
			recursos  = JSON.parse(data);
			$.each(recursos, function (i) {
				$('#SL_Recursos').append($('<option>', { 
					value : recursos[i].PK_Id_Recurso,
					text : recursos[i].VC_Nombre
				}));
			});
			
		},
		async: false
	});
	$('.selectpicker').selectpicker('refresh');
	return retrun;
}

function getEntidad(codigoGrupo,linea){//linea 1: arte en la escuela, 2: emprende clan
	var result = "";
	var datos = {
		'opcion':'getEntidad',
		'idGrupo': codigoGrupo,
		'linea': linea
	};
	$.ajax({
		async: false,
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(data){
			result = JSON.parse(data)[0];
			if (result.VC_Nom_Organizacion == null) {
				result.VC_Nom_Organizacion = "Sin Organización";
			} 
		}
	})
	return result;
}

function getHorario(codigo_grupo,linea) {//linea 1: arte en la escuela, 2: emprende clan
	if (linea == 1) {
		opcion = 'getHorarioGrupoArteEscuela';
	}
	if (linea == 2) {
		opcion = 'getHorarioGrupoEmprendeClan';
	}
	if (linea == 3) {
		opcion = 'getHorarioGrupoLaboratorioClan';
	}
	$.ajax({
		async : false,
		url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
		type: 'POST',
		dataType: 'html',
		data: {opcion: opcion  , codigo_grupo:codigo_grupo},
		success: function(INFO)
		{
			if(INFO){
				$("#LB_Horario").append("HORARIO: <br>"+INFO);
			}
		}
	});
}