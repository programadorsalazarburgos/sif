var url_controller = '../../Controlador/Pedagogico/C_Valoracion_Grupo.php';
var url_pedagogico_controller = '../../src/PedagogicoCREA/PedagogicoCREAController/';
var numPreguntas = 0; 
var preGrupo = "AE";
var gestoCognitivo = '';
var table_listado_estudiantes_grupo;
var valoracion = null;
$(document).ready(function(){
	$("#SL_GRUPO").html(parent.getGruposDeUnUsuario(parent.idUsuario)).selectpicker("refresh");
	$('#SL_grupo').on('change', function(e){
		e.preventDefault();
		codigoGrupo = $("#SL_grupo").val();
		tipoGrupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		var datos = {
			'opcion':'getValoracion',
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
					valoracion = JSON.parse(datos);
					var estado = '';
					if (valoracion.IN_Estado == null) {
						estado = "Sin Revisar";
					} 
					else{
						if (valoracion.IN_Estado == '1') {
							estado = 'Aprobado';
						}
						else
						{
							estado = 'No Aprobado';
						}
					}
					$('#LB_Estado').text(estado);
					if (valoracion.TX_Observacion != '' && valoracion.TX_Observacion != null) {
						$('#DIV_Observacion').show();
						$('#LB_Observacion').text(valoracion.TX_Observacion);
					}else{
						$('#DIV_Observacion').show();
						$('#LB_Observacion').text("No cuenta con observaciones sobre la ultima valoración realizada");
					}
				}else{
					$('#DIV_Observacion').hide();
					$('#LB_Observacion').text("");
				}
			}
		}); 
	});
	$('#wrapper').hide();

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php', 
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			usuario_id = data;
			datos_usuario = JSON.parse(parent.consultarDatosBasicosUsuario(data));
			nombre_formador = datos_usuario[0].VC_Primer_Nombre+' '+datos_usuario[0].VC_Segundo_Nombre+' '+datos_usuario[0].VC_Primer_Apellido+' '+datos_usuario[0].VC_Segundo_Apellido;
			$('#LB_Formador').text("Arista Formador: "+ nombre_formador);
			init();
		},
		async : false
	});

	$('#SL_GRUPO').on('change', function(e){
		e.preventDefault();
		codigoGrupo = $("#SL_GRUPO").val();
		nombreGrupo = $("#SL_GRUPO").find(':selected').text();
		tipoGrupo = $("#SL_GRUPO").find(':selected').data('tipo_grupo');
		$('#FORM_PLANEACION_AE').hide();
		$('#FORM_PLANEACION_EC_LC').hide();
		if (tipoGrupo == 'arte_escuela'){
			$('#FORM_PLANEACION_AE').show();
			cargarEncabezadoPlaneacion(codigoGrupo, nombreGrupo, tipoGrupo, "#FORM_PLANEACION_AE");
		}
		else{
			$('#FORM_PLANEACION_EC_LC').show();
			cargarEncabezadoPlaneacion(codigoGrupo, nombreGrupo, tipoGrupo, "#FORM_PLANEACION_EC_LC");
		}
		$('#input-finalizado-1').change();
		$('#input-finalizado-3').change();

	});

	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var fecha = d.getFullYear() + '-' +
	((''+month).length<2 ? '0' : '') + month + '-' +
	((''+day).length<2 ? '0' : '') + day;
	$("#SL_grupo").html(parent.getGruposDeUnUsuario(parent.idUsuario)).selectpicker('refresh');   
	$("#LB_Fecha_Elaboracion").text("Fecha de Elaboración: "+fecha);
	//$("#SL_grupo").append(getGruposArteEscuela() + getGruposEmprendeClan());
	$("#FORM_Realizar_Valoracion").on('submit',function(e){
		e.preventDefault();
		codigoGrupo = $("#SL_grupo").val();
		tipo_grupo = $("#SL_grupo").find(':selected').data('tipo_grupo');
		if(tipo_grupo=='arte_escuela'){
			showForm(1,'arte_escuela');
			$("#id_del_grupo").html("Grupo: "+"AE-"+codigoGrupo);
			preGrupo = "AE";
		}
		if(tipo_grupo=='emprende_clan'){
			showForm(2,'emprende_clan');
			$("#id_del_grupo").html("Grupo: "+"EC-"+codigoGrupo);
			preGrupo = "EC";
		}
	});

	///////Archivos///////
	var files = {};
	var archivoValido = true;
	$('input[type=file]').on('change', function(e){
		e.preventDefault();
		var key = $(this).attr('id');
		var filesData = e.target.files;
		var fileName = filesData[0].name;
		var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
		archivoValido = fileNameExt.toUpperCase() === 'pdf'.toUpperCase();

		if (archivoValido) {
			files[key]= filesData[0];
		}
		else{
			var box1 = bootbox.alert(
				"El archivo anexo debe estar en formato PDF.");
			box1.css({
				'top': '30%',
				'margin-top': '15%' 
			});
		}
	});
	
	function init() {
		tableListado = $('#table-listado-valoraciones').DataTable( {
			"paging":   true,
			"ordering": true,
			"info":     false,
			"columnDefs": [
			{
				"targets": [0],
				"visible": false,
				"searchable": false
			},],
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
			dom: 'Blfrtip',
			buttons: [
			{
				extend: 'excelHtml5',
				text: 'Descargar Listado',
				filename: 'ListadoPlaneacioens',
				exportOptions: {
					columns: [ 1,2 ],
					modifier: {
						page: 'all'
					}
				}
			},
			]
		});
		refreshListado();
	}

	function refreshListado() {
		let datos = {
			p1: usuario_id
		};
		tableListado.clear().draw();
		$.ajax({
			url: url_pedagogico_controller+"getListadoPlaneaciones",
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(result){
				tableListado.rows.add($(result)).draw();
				$('[data-toggle="tooltip"]').tooltip();
			},error: function(result){
				console.error("Error: "+result);
			}
		});
	}



	$("#FORM_VALORACION").on('submit', function(e){
		e.preventDefault();
		if (archivoValido) {
			
			var datos = table_listado_estudiantes_grupo.$("select, input").serializeArray();
			datos.push({
				name: 'SL_PERIODO', 
				value: $('#SL_PERIODO').val()
			});	
			var ciclos = ""; 
			$('#SL_CICLO :selected').each(function(i, selected){ 
				ciclos = ciclos + $(selected).val()+",";
			});
			ciclos = ciclos.slice(0, -1);
			datos.push({
				name: 'ciclos', 
				value: ciclos
			});	
			datos.push({
				name: 'opcion', 
				value: "guardarDatos"
			});		
			datos.push({
				name: 'codigoGrupo', 
				value: codigoGrupo
			});
			datos.push({
				name: 'tipo_grupo', 
				value: tipo_grupo
			});
			datos.push({
				name: 'artistaFormadorId', 
				value: artistaFormadorId
			});
			datos.push({
				name: 'gestoCognitivo', 
				value: gestoCognitivo
			});

			$.ajax({
				async: false,
				url:url_controller,
				type:'POST',
				data: datos,
				success: function(idValoracion){
					if (uploadFiles(files,idValoracion))
					{
						var box1 = bootbox.alert(
							"Se ha registrado la valoracion del grupo "+preGrupo+"-"+codigoGrupo+".<br><br>Va a ser redirigido a la página de consultar de grupos donde encontrará la Valoración realizada.",
							function(){
								location.href = '../ConsultasReportes/Consultar_Grupos.php';
							});
						box1.css({
							'top': '30%',
							'margin-top': '15%' 
						});
					}
				}
			}); 
		}
		else{
			var box1 = bootbox.alert(
				"Recuerde que el archivo anexo debe estar en formato PDF.");
			box1.css({
				'top': '30%',
				'margin-top': '15%' 
			});
		}
	});
});

function uploadFiles(files,idValoracion){
	var data = new FormData();
	$.each(files, function(key, value)
	{
		data.append(key, value);
	});
	data.append("opcion","subirArchivosValoracion");
	data.append("idValoracion",idValoracion);
	var datosState = false;
	$.ajax({
		async: false,
		url:url_controller+'?files',
		type:'POST',
		data: data,
		cache: false,
		dataType: 'html',
		processData: false, 
		contentType: false, 
		beforeSend: function(){
			$("#modal_enviando").modal('show');
		},
		success: function(datos)
		{
			$("#modal_enviando").modal('hide');
			datosState = datos;
		}
	});
	return datosState;
}

var estudiantes;
function showForm(linea,lineaText){

	table_listado_estudiantes_grupo = $("#table_listado_estudiantes_grupo").DataTable({
		responsive: true,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
			"search": "Filtrar"
		},
		"paging": true,
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excel',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Listado estudiantes grupo '+ preGrupo +'-' + codigoGrupo
		}
		],
		"columns": [
		{ "width": "10%" },
		{ "width": "10%" },
		{ "width": "10%" },
		{ "width": "10%" },
		{ "width": "10%" },
		{ "width": "20%" },
		{ "width": "20%" },
		{ "width": "20%" },
		{ "width": "20%" }
		]
	});
	table_listado_estudiantes_grupo.clear().draw();
	var d = new Date();
	var month = d.getMonth()+1;
	var fecha = d.getFullYear() + '-' +
	((''+month).length<2 ? '0' : '') + month;
	$.ajax({
		async : false,
		url: url_controller,
		type: 'POST',
		dataType: 'json',
		data: {codigoGrupo: codigoGrupo,lineaAtencion:lineaText,fecha:fecha,opcion:'getEstudiantesGrupo'},
		success: function(datos)
		{
			estudiantes= datos;
			var ratingCog = '';
			var ratingAct = '';
			var ratingCon = '';
			if (valoracion != null && valoracion != undefined && valoracion != '') valoracionEstudiantes = cargarValoracion(valoracion);
			$.each(datos, function(i) 
			{
				ratingCog = '<div class="col">'+
				'<div class="box box-blue box-example-movie">'+
				'<div class="box-body">'+
				'<select id="SL_Rating_Cog_'+estudiantes[i].id+'" name="SL_Rating_Cog_'+estudiantes[i].id+'" class="box-rating" autocomplete="off">'+
				'<option value="1">Bajo</option>'+
				'<option value="2" selected>Básico</option>'+
				'<option value="3" >Alto</option>'+
				'<option value="4">Superior</option>'+
				'</select>'+
				'</div></div></div>';
				ratingAct = '<div class="col">'+
				'<div class="box box-blue box-example-movie">'+
				'<div class="box-body">'+
				'<select id="SL_Rating_Act_'+estudiantes[i].id+'" name="SL_Rating_Act_'+estudiantes[i].id+'" class="box-rating" autocomplete="off">'+
				'<option value="1">Bajo</option>'+
				'<option value="2" selected>Básico</option>'+
				'<option value="3" >Alto</option>'+
				'<option value="4">Superior</option>'+
				'</select>'+
				'</div></div></div>';
				ratingCon = '<div class="col">'+
				'<div class="box box-blue box-example-movie">'+
				'<div class="box-body">'+
				'<select id="SL_Rating_Con_'+estudiantes[i].id+'" name="SL_Rating_Con_'+estudiantes[i].id+'" class="box-rating" autocomplete="off">'+
				'<option value="1">Bajo</option>'+
				'<option value="2" selected>Básico</option>'+
				'<option value="3" >Alto</option>'+ 
				'<option value="4">Superior</option>'+
				'</select>'+
				'</div></div></div>';
				var rowNode  = table_listado_estudiantes_grupo.row.add( [
					i+1, //Nº
					datos[i].Nombre, //Nombres
					datos[i].Apellido, //Nombres
					datos[i].VC_Descripcion_Grado, //Curso
					datos[i].Asistencias, //Asistencia
					ratingCog, //Cognitivo
					ratingAct, //Actitudinal
					ratingCon, //Convivencial
					"<input type='hidden' name='IN_Asistencia_"+estudiantes[i].id+"' id='IN_Asistencia_"+estudiantes[i].id+"' value='"+datos[i].Asistencias+"'>"+
					"<input type='hidden' name='IN_Observacion_"+estudiantes[i].id+"' id='IN_Observacion_"+estudiantes[i].id+"'>"+
					"<button  id='BT_Observacion_"+estudiantes[i].id+"' class='btn btn-primary btn-modal  form-control' type='button' data-toggle='modal'"+
					"data-target='#MODAL_EJEMPLO_UNO' data-button='"+datos[i].Nombre+" "+datos[i].Apellido+";"+estudiantes[i].id+"' data-placement='top' title='Recomendaciones y Observaciones'>"+
					"<i class='glyphicon glyphicon-edit'></i></button>" //Recomendaciones,
					
					]).draw().node();
				if (valoracion != null && valoracion != undefined && valoracion != '')
				{
					try{
						if (valoracionEstudiantes[estudiantes[i].id] != undefined) { 
							//if (rowNode.childNodes[8].children[3].value == valoracionEstudiantes[estudiantes[i].id].FK_Estudiante) {
								rowNode.childNodes[5].children[0].children[0].children[0].children[0].value = valoracionEstudiantes[estudiantes[i].id].IN_Val_Cognitivo;
								rowNode.childNodes[6].children[0].children[0].children[0].children[0].value = valoracionEstudiantes[estudiantes[i].id].IN_Val_Actitudinal;
								rowNode.childNodes[7].children[0].children[0].children[0].children[0].value = valoracionEstudiantes[estudiantes[i].id].IN_Val_Convivencial;
								rowNode.childNodes[8].children[1].value = valoracionEstudiantes[estudiantes[i].id].TX_Recomendacion;
								if (valoracionEstudiantes[estudiantes[i].id].TX_Recomendacion != '' && valoracionEstudiantes[estudiantes[i].id].TX_Recomendacion != null && valoracionEstudiantes[estudiantes[i].id].TX_Recomendacion != undefined) {
									rowNode.childNodes[8].children[2].className = 'btn btn-success btn-modal  form-control';
								}
								else{
									rowNode.childNodes[8].children[2].className = 'btn btn-primary btn-modal  form-control';
								}
							//}
						}
					}
					catch(err)
					{
						console.log(err);
					}
				}
			});
			$('[data-toggle="modal"]').tooltip(
			{
				"animation": 1
			});
			$('.box-rating').barrating('show', {
				theme: 'bars-movie'
			});
		}
	});//
	var estudianteSelec;//
	$('.btn-modal').on('click', function(e){
		e.preventDefault();
		estudianteSelec = $(this).attr('data-button').split(';');
		$('#LB_Estudiante').text(estudianteSelec[0]);
		$('#TXT_Observacion').val($('#IN_Observacion_'+estudianteSelec[1]).val()!=undefined?$('#IN_Observacion_'+estudianteSelec[1]).val():'');
	});
	$('#table_listado_estudiantes_grupo').on( 'draw.dt', function () {
		$('.box-rating').barrating('show', {
			theme: 'bars-movie'
		});
		$('[data-toggle="modal"]').tooltip(
		{
			"animation": 1
		});
		$('.btn-modal').on('click', function(e){
			e.preventDefault();
			estudianteSelec = $(this).attr('data-button').split(';');
			$('#LB_Estudiante').text(estudianteSelec[0]);
			$('#TXT_Observacion').val($('#IN_Observacion_'+estudianteSelec[1]).val()!=undefined?$('#IN_Observacion_'+estudianteSelec[1]).val():'');
		});
	} );

	$("#FORM_Observacion").on('submit',function(e){
		e.preventDefault();
		$('#BT_Observacion_'+estudianteSelec[1]).removeClass('btn-primary').addClass('btn-success');
		$('#IN_Observacion_'+estudianteSelec[1]).val($('#TXT_Observacion').val());
		$('#MODAL_EJEMPLO_UNO').modal('hide');
	});
	$("#DIV_SELECCIONAR_GRUPO").hide('fast');
	$("#DIV_FORM_VALORACION").show('fast');	
	if (linea == 1) {
		$('#LB_Linea_Atencion').text('Línea de Atención: Arte En La Escuela');
	}
	if (linea == 2) {
		$('#LB_Linea_Atencion').text('Línea de Atención: Emprende Clan');
	}
	$('#LB_Entidad').text("Entidad/Organización: "+getEntidad(codigoGrupo,linea).VC_Nom_Organizacion);
	getHorario(codigoGrupo,linea);
	var cognitive = getCognitiveArray();
	var areaArtistica;
	$.ajax({
		async : false,
		url: url_controller,
		type: 'POST',
		dataType: 'json',
		data: {idGrupo: codigoGrupo,tipoGrupo:lineaText,opcion:'getCInformacionGrupo'},
		success: function(datos)
		{
			$("#LB_Area_Artistica").append("Área Artística: "+datos[0].VC_Nom_Area);
			$("#LB_Colegio").append(datos[0].VC_Nom_Colegio);
			$("#LB_Clan").append(" "+datos[0].VC_Nom_Clan);
			$("#LB_Fecha_Inicio").append("Fecha de Inicio: El grupo no ha iniciado");
			var lugar_atencion = "";
			if(datos[0].IN_lugar_atencion == 1){
				lugar_atencion = "COLEGIO";
			}else{
				if(datos[0].IN_lugar_atencion == 2){
					lugar_atencion = "CLAN";		
				}
				else{
					if(datos[0].IN_lugar_atencion == 3) {
						lugar_atencion = "CLAN y COLEGIO";				
					}
				}
			}
			if (linea == 2) {
				lugar_atencion = 'CLAN';
			}
			$("#LB_Lugar_Atencion").append("Lugar de Atención: "+lugar_atencion);
			areaArtistica = datos[0].PK_Area_Artistica;
		}
	});
	$('[data-toggle="tooltip"]').tooltip(
	{
		"animation": 1
	});
	gestoCognitivo = ' Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.';
	$('#SL_CICLO').on('change', function(e){
		e.preventDefault();
		gestoCognitivo = '';
		var ciclos = ""; 
		$('#SL_CICLO :selected').each(function(i, selected){ 
			textGestoCognitivo = cognitive["A"+areaArtistica]["D"+$("#SL_PERIODO").val()+$(selected).val()];
			textGestoCognitivo = textGestoCognitivo != undefined ? textGestoCognitivo: 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.'; 
			gestoCognitivo = gestoCognitivo+textGestoCognitivo+", ";
			console.log("this");
		});
		gestoCognitivo = gestoCognitivo.slice(0, -2);
		$('#H_Cognitivo').text(gestoCognitivo);
		heighMaximo = $('#div_cognitivo').height();
		$('#div_actitudinal').height(heighMaximo);
		$('#div_convivencial').height(heighMaximo);
	});
	$('#SL_PERIODO').on('change', function(e){
		e.preventDefault();
		gestoCognitivo = '';
		var ciclos = ""; 
		$('#SL_CICLO :selected').each(function(i, selected){ 
			textGestoCognitivo = cognitive["A"+areaArtistica]["D"+$("#SL_PERIODO").val()+$(selected).val()];
			textGestoCognitivo = textGestoCognitivo != undefined ? textGestoCognitivo: 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.'; 
			gestoCognitivo = gestoCognitivo+textGestoCognitivo+", ";
			console.log("this");
		});
		gestoCognitivo = gestoCognitivo.slice(0, -2);
		$('#H_Cognitivo').text(gestoCognitivo);
		heighMaximo = $('#div_cognitivo').height();
		$('#div_actitudinal').height(heighMaximo);
		$('#div_convivencial').height(heighMaximo);
	});
	if (valoracion) {
		var ciclo = valoracion.FK_Ciclo.split(",");
		$.each(ciclo, function (i) {
			if (ciclo[i] != '') {
				$("#SL_CICLO option[value='" + ciclo[i]+ "']").prop('selected', true);
			}
		}); 

		$('#SL_PERIODO').val(valoracion.FK_Periodo);
		$('.selectpicker').selectpicker('refresh');
		$('#SL_PERIODO').change();
		heighMaximo = $('#div_cognitivo').height();
		$('#div_actitudinal').height(140);
		$('#div_convivencial').height(140);
	}
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
function getCognitiveArray() {
	var cognitive = {
		"A1":{ //DANZA
			"D10": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D20": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D30": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D40": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D11": 'Descubrir el cuerpo, como un todo así como sus partes y sus posibilidades de movimiento a través de estímulos.',
			"D21": 'Identificar los elementos de la experiencia del movimiento.',
			"D31": 'Reconocer el potencial creativo y expresivo del movimiento en la consolidación de una imagen de sí mismo.',
			"D41": 'Explora de manera autónoma la experiencia creativa de la danza (integración ritmo, musicalidad, cuerpo y movimiento).',
			"D12": 'Descubrir capacidades técnicas básicas desde y para el movimiento.',
			"D22": 'Identificar y apropiar los aspectos expresivos de las técnicas básicas de ejecución del movimiento.',
			"D32": 'Desarrollar capacidad de escucha y expresión de emociones y sensaciones a través del movimiento.',
			"D42": 'Reconocer las posibilidades del trabajo en equipo en el contexto del proceso de formación como experiencia creativa.',
			"D13": 'Descubrir las habilidades y destrezas corporales a través de secuencias de movimiento.',
			"D23": 'Ejecución de secuencias de movimiento con una estructura (principio, desarrollo y fin) que incorporen diversos aspectos espaciales, temporales, energéticos, rítmicos y afectivos.',
			"D33": 'Desarrollar posibilidades creativas, reflexivas y socioafectivas que relacionan la danza con el contexto sociocultural.',
			"D43": 'Proponer y construir posibilidades compositivas que desarrollan capacidades analíticas en torno a los distintos géneros de la danza.',
			"D14": 'Desarrolla conciencia de la experiencia dancística en la aplicación y ejecución de secuencias de movimiento.',
			"D24": 'Apropiar secuencias de movimiento que demuestren la aplicación de habilidades y destrezas corporales.',
			"D34": 'Proponer y modificar secuencias de movimiento que demuestren la aplicación de habilidades y destrezas corporales.',
			"D44": 'Participar propositivamente en la creación de un montaje coreográfico colectivo que fortalezca y ayude a consolidar un posible proyecto de vida.'
		},
		"A2":{//MUSICA
			"D10": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D20": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D30": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D40": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D11": "Imita y  disfruta de juegos  melódicos y rítmicos.",
			"D21": "Explora diversas formas de comunicación y se expresa creativamente a través de diferentes juegos rítmicos y melódicos.",
			"D31": "Vocaliza juegos y melodías cantadas y mantiene la regularidad rítmica.",
			"D41": "Interpreta ritmo tipos y melodías cortas en los instrumentos de percusión y melódicos. inventa otras posibilidades sonoras utilizando su cuerpo y la voz.",
			"D12": "Manifiesta su creatividad en los juegos y canciones propuestas.",
			"D22": "Expresa sus emociones y sentimientos a través de el lenguaje musical.",
			"D32": "Interpreta canciones cortas empleando su voz cantada.",
			"D42": "Aplica insumos técnico expresivos  en la interpretación de instrumentos melódicos y de percusión.",
			"D13": "Imita corporalmente células rítmicas de uno y dos compases.",
			"D23": "Interpreta instrumentos melódicos y de percusión.",
			"D33": "Interpreta y memoriza canciones empleando su voz cantada.",
			"D43": "Aplica insumos técnico expresivos en la interpretación de instrumentos melódicos y de percusión.",
			"D14": "Propone y crea melodías y ritmos a partir de juegos de improvisación.",
			"D24": "Interpreta melodías en instrumentos armónicos y melódicos.",
			"D34": "Interpreta con su voz canciones a una y dos voces.",
			"D44": "Aplica insumos técnico expresivos en el uso de su voz y en la interpretación de instrumentos melódicos y de percusión."
		},
		"A3":{//ARTES PLASTICAS
			"D10": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D20": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D30": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D40": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D11":"Establece relaciones y diferencias entre cuerpos (objetos, animales) y su propio cuerpo.",
			"D12":"Entiende las diferencias entre forma,  espacio,color y textura.",
			"D13":"Reconoce elementos como la distancia, el tamaño, la proporción, la distinción de formatos y superficies.",
			"D14":"Idea una propuesta personal que relacione  familia y escuela  con lo aprendido en el taller. ",
			"D21":"Reconoce los elementos visuales tales como: línea,punto,  trazo, mancha, color y figuras geométricas.",
			"D22":"Diferencia entre espacios negativos y positivos; y elementos bidimensionales y tridimensionales.",
			"D23":"Identifica sólidos geométricos y estructuras básicas tridimensionales.",
			"D24":"Idea una propuesta personal que relacione  escuela y barrio  con lo aprendido en el taller.",
			"D31":"Reconoce diferentes técnicas y conceptos de las artes plásticas y visuales.  ",
			"D32":"Establece  relaciones de contenido, temática, contexto y lenguaje, entre distintos referentes tanto de la plástica como de su entorno.",
			"D33":"Comprende la función del símbolo como insumo o mecanismo de representación en las artes plásticas y visuales.",
			"D34":"Idea una propuesta personal que relacione  localidad y ciudad  con lo aprendido en el taller. ",
			"D41":"Emplea la reflexión y el análisis para el desarrollo de procesos creativos en las artes plásticas y visuales.",
			"D42":"Conoce las posibilidades de las prácticas  interdisciplinares. ",
			"D43":"Interpreta obras plásticas a partir del reconocimiento de sus valores formales y conceptuales.",
			"D44":"Idea una propuesta personal que relacione  ciudad, país, continente  con lo aprendido en el taller."
		},
		"A4":{ //DANZA
			"D10": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D20": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D30": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D40": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D11": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D21": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D31": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D41": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D12": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D22": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D32": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D42": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D13": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D23": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D33": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D43": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D14": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D24": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D34": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D44": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.'
		},
		"A5":{//TEATRO
			"D10": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D20": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D30": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D40": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D11": "Explora y reconoce sus emociones y las de sus compañeros.",
			"D21": "Juega a la mimesis e imitación distintiva de animales, objetos y personas.",
			"D31": "Se entusiasma y persiste con los ejercicios y dinámicas de taller propuestos.",
			"D41": "Crea historias y acciones espontáneamente a partir de distintias motivaciones.",
			"D12": "Explora su capacidad imaginativa para crear mundos posibles y diversos.",
			"D22": "Descubre su cuerpo como herramienta importante para comunicarse con su entorno.",
			"D32": "Persevera para superar los obstáculos individuales y/o tareas grupales.",
			"D42": "Construye relatos, imágenes o historias usando su corporalidad, emociones y su capacidad de juego.",
			"D13": "Expone sus ideas de manera crítica y reflexiva.",
			"D23": "Reconoce la importancia del trabajo en colectivo",
			"D33": "Evalúa y defiende su proceso.",
			"D43": "Propone y construye relaciones posibles basados en la ficción y la realidad.",
			"D14": "Reconoce su corporalidad, la del otro para construir espacios de significación estética.",
			"D24": "Integra el cuerpo , la voz, el gesto y la emocionalidad en procesos de creativos.",
			"D34": "Encuentra en su entorno elementos valiosos de creación y de interpretación.",
			"D44": "Desarrolla aptitudes inventivas y corporales para la expresion simbólica desde sus propias narrativas o desde textos teatrales"
		},
		"A6":{//AUDIOVISUALES
			"D10": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D20": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D30": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D40": 'Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.',
			"D11": "Desarrolla los sentidos, observa y escucha el mundo que le rodea a través de la exploración audiovisual.",
			"D21": "Percibe la experiencia artística desde los elementos visuales y sonoros.",
			"D31": "Imagina mundos posibles en sus narraciones.",
			"D41": "Enriquece la experiencia artística audiovisual interactuando con elementos dispuestos dentro del ambiente.",
			"D12": "Busca imágenes y sonidos para contar sus propias narraciones.",
			"D22": "Observa situaciones cotidianas configurando diálogos e historias como insumos para sus creaciones.",
			"D32": "Explora su propio entorno para generar historias más creativas.",
			"D42": "Experimentar con el cuerpo como motor para la creación y realización audiovisual.",
			"D13": "Propone soluciones a situaciones creativas utilizando recursos técnicos.",
			"D23": "Usa un lenguaje propio para su expresión creativa por medio de las artes audiovisuales.",
			"D33": "Indaga por sus sentimientos y pensamientos para involucrarse en la creación audiovisual.",
			"D43": "Involucra los aprendizajes audiovisuales exclusivamente para los propósitos creativos del desarrollo del taller, Explora los diversos roles de la realización audiovisual.",
			"D14": "Se relaciona con espacios de circulación y producción audiovisual.",
			"D24": "Construye narraciones audiovisuales utilizando diferentes técnicas y articulando elementos como planimetría y planos sonoros.",
			"D34": "Formula preguntas claras sobre técnicas y roles cinematográficos.",
			"D44": "Busca puntos de vista y narrativas arriesgadas que contribuyen a la expresión artística de temas y experiencias propias."
		}
	};
	return cognitive;
}
function cargarValoracion(valoracion) {
	var ciclo = valoracion.FK_Ciclo.split(",");
	$.each(ciclo, function (i) {
		if (ciclo[i] != '') {
			$("#SL_CICLO option[value='" + ciclo[i]+ "']").prop('selected', true);
		}
	}); 
	$('#SL_PERIODO').val(valoracion.FK_Periodo);
	$('.selectpicker').selectpicker('refresh');
	$('#SL_PERIODO').change();
	var datos = {
		'opcion': 'getValoracion',
		'valoracionId': valoracion.PK_Id_Valoracion
	};
	var valoracionEstudiantes;
	var valoracionEstudiantesId = [];
	var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php';
	$.ajax({
		async: false,
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			valoracionEstudiantes = JSON.parse(data);
			console.log("this");
			$.each(valoracionEstudiantes, function(i,val) 
			{
				valoracionEstudiantes[i].id = valoracionEstudiantes[i].FK_Estudiante;
				valoracionEstudiantesId[valoracionEstudiantes[i].FK_Estudiante] = valoracionEstudiantes[i];
				table_listado_estudiantes_grupo.$("#IN_Observacion_"+valoracionEstudiantes[i].FK_Estudiante).val(valoracionEstudiantes[i].TX_Recomendacion);
				if (valoracionEstudiantes[i].TX_Recomendacion != null && valoracionEstudiantes[i].TX_Recomendacion != undefined && valoracionEstudiantes[i].TX_Recomendacion != '') {
					table_listado_estudiantes_grupo.$('#BT_Observacion_'+valoracionEstudiantes[i].FK_Estudiante).removeClass('btn-primary').addClass('btn-success');
				}
				table_listado_estudiantes_grupo.$('#SL_Rating_Cog_'+valoracionEstudiantes[i].FK_Estudiante).barrating('set',valoracionEstudiantes[i].IN_Val_Cognitivo);
				table_listado_estudiantes_grupo.$('#SL_Rating_Act_'+valoracionEstudiantes[i].FK_Estudiante).barrating('set',valoracionEstudiantes[i].IN_Val_Actitudinal);
				table_listado_estudiantes_grupo.$('#SL_Rating_Con_'+valoracionEstudiantes[i].FK_Estudiante).barrating('set',valoracionEstudiantes[i].IN_Val_Convivencial);
			});
		}
	});
	return valoracionEstudiantesId;
}