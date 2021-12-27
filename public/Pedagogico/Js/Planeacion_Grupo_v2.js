/*var url_service = '../../Controlador/Pedagogico/C_Valoracion_Grupo.php';
var numPreguntas = 0; */
var url_pedagogico_controller = '../../src/PedagogicoCREA/PedagogicoCREAController/';
var url_registrar_asistencia_controller = '../../src/ArtistaFormador/RegistrarAsistenciaController/'; //consultarHorarioGrupo
var slRecursos = null;
$(document).ready(function(){
	var linea_atencion_selected;
	var planeacionSelectedId = 0;
	$("#SL_METODOLOGIA").html(parent.getOptionParametroDetalle(46));
	var slMetodologia = $("#SL_METODOLOGIA").clone();
	$("#SL_GRUPO").html(parent.getGruposDeUnUsuario(parent.idUsuario)).selectpicker("refresh");
	var tipoGrupo = "";
	var nombre_formador = "";
	var usuario_id = 0;
	var numPreguntas = 0;
	var numPreguntasEdicion = 0;
	var numPreguntasVisualizacion = 0;
	var ultimo_registro;
	$.ajax({
		url: '../../Controlador/Consultas/getSession.php', 
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			usuario_id = data;
			datos_usuario = JSON.parse(parent.consultarDatosBasicosUsuario(data));
			nombre_formador = datos_usuario[0].VC_Primer_Nombre+' '+datos_usuario[0].VC_Segundo_Nombre+' '+datos_usuario[0].VC_Primer_Apellido+' '+datos_usuario[0].VC_Segundo_Apellido;
			init();
		},
		async : false
	});		
	getRecursos('#DIV_FORM_PLANEACION_AE #FORM_PLANEACION_AE');
	getRecursos('#DIV_FORM_PLANEACION_AE #FORM_PLANEACION_EC_LC');
	slRecursos = $('#FORM_PLANEACION_AE #SL_RECURSOS').clone()[0].outerHTML; 
	codigoGrupo = "";
	nombreGrupo = "";
	tipoGrupo = "";	
	$("#DIV_FORM_PLANEACION_AE #FORM_PLANEACION_AE #SL_RECURSOS").selectpicker("refresh");
	$("#DIV_FORM_PLANEACION_AE #FORM_PLANEACION_EC_LC #SL_RECURSOS").selectpicker("refresh");
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

		var datos = {
			p1: {
				'fk_grupo': codigoGrupo,
				'fk_id_linea_atencion': tipoGrupo,
				'fk_id_usuario_registro': usuario_id
			},
		}
		if(tipoGrupo == 'arte_escuela'){
			funcion = 'consultarUltimaPlaneacionAprobada';
		}
		else{
			funcion = 'consultarUltimaPropuestaProyectoAprobada';	
		}
		$.ajax({
			async : false,
			url: url_pedagogico_controller+funcion,
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(retorno)
			{
				if(retorno != null){
					ultimo_registro = retorno;
					$("#DIV_CARGAR_DATOS").show();
				}
				else{
					$("#DIV_CARGAR_DATOS").hide();
				}
			}
		});
	});

	$('#BT_CARGAR_DATOS').on('click', function(e){
		e.preventDefault();
		var formulario = "";
		if(tipoGrupo == "arte_escuela") {
			formulario = "#DIV_FORM_PLANEACION_AE #FORM_PLANEACION_AE";
		}
		else{
			formulario = "#DIV_FORM_PLANEACION_AE #FORM_PLANEACION_EC_LC";	
		}
		cargarContenidoPlaneacion(ultimo_registro, formulario);
		parent.swal("","La datos de la última planeación aprobada fueron cargados","success");
	});

	function cargarEncabezadoPlaneacion(codigoGrupo, nombreGrupo, tipoGrupo, form) {
		var datosPost = { 
			p1: {
				'id_grupo': codigoGrupo,
				'tipo_grupo': tipoGrupo
			}
		};
		$(form+" #div-preguntas").html("");
		if (form == "#FORM_PLANEACION_AE")
			numPreguntas = 0;
		if (form == "#FORM_PLANEACION_EDITAR")
			numPreguntasEdicion = 0;
		$.ajax({
			async: false,
			url: url_pedagogico_controller+'consultarInformacionGrupo',
			type:'POST',
			data: datosPost,
			dataType: 'json',
			success: function(grupo){				

				$(form+" "+"#LB_Formador").html(nombre_formador);
				$.ajax({
					async : false,
					url: url_pedagogico_controller+'consultarHorarioGrupo',
					type: 'POST',
					dataType: 'html',
					data: datosPost,
					success: function(horario)
					{
						if(horario){
							$(form+" "+"#LB_Horario").html(horario);
						}
					}
				});
				$(form+" "+"#LB_Idartes").html(grupo[0].FK_organizacion == 2 ? "SI" : "NO");
				$(form+" "+"#LB_Organizacion").html(grupo[0].FK_organizacion != 2 ? "SI" : "NO");
				$(form+" "+"#id_del_grupo").html(nombreGrupo);
				$(form+" "+"#LB_Area_Artistica").html(grupo[0].VC_Nom_Area);
				$(form+" "+"#LB_Colegio").html(grupo[0].VC_Nom_Colegio);
				$(form+" "+"#LB_Clan").html(grupo[0].VC_Nom_Clan);
				$(form+" "+"#LB_Fecha_Inicio").html("Fecha de Inicio: El grupo no ha iniciado");
				var lugar_atencion = "";
				if(grupo[0].IN_lugar_atencion == 1){
					lugar_atencion = "COLEGIO";
				}else{
					if(grupo[0].IN_lugar_atencion == 2){
						lugar_atencion = "CREA";		
					}
					else{
						if(grupo[0].IN_lugar_atencion == 3) {
							lugar_atencion = "CREA y COLEGIO";				
						}
						else
							lugar_atencion = "CREA";				
					}
				}
				var d = new Date();
				var month = d.getMonth()+1;
				var day = d.getDate();
				var fecha = d.getFullYear() + '-' +
				((''+month).length<2 ? '0' : '') + month + '-' +
				((''+day).length<2 ? '0' : '') + day;
				$(form+" "+"#LB_Fecha_Elaboracion").text(fecha);
				/*
				if (linea == 2) {
					lugar_atencion = 'CREA';
				}
				if (linea == 3) {
					lugar_atencion = datos[0].VC_Descripcion;
				}*/
				$(form+" "+"#LB_Lugar_Atencion").html(lugar_atencion);
				if (tipoGrupo == 'arte_escuela')
					$(form+" "+'#LB_Linea_Atencion').text('Arte en la escuela');
				if (tipoGrupo == 'emprende_clan')
					$(form+" "+'#LB_Linea_Atencion').text('Emprende CREA');
				if (tipoGrupo == 'laboratorio_clan')
					$(form+" "+'#LB_Linea_Atencion').text('Laboratorio CREA');
			}
		});
	}

	function init() {
		tableListado = $('#table-listado-planeaciones').DataTable( {
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
	$("#FORM_PLANEACION_AE #a-add").click(function(e){
		e.preventDefault();
		numPreguntas = numPreguntas + 1;
		$("#FORM_PLANEACION_AE #div-preguntas").append(
			'<div class="form-group col-lg-12 col-md-12" >'+
			'<input  maxlength="500" class="form-control col-lg-8 col-md-8 campo" id="TX_Referente_'+numPreguntas+'"name="TX_Referente_'+numPreguntas+'" placeholder="Referente '+numPreguntas+'" type="text">'+
			'</div>'
			); 
	});
	$('#input-finalizado-1').on('change', function(e){
		e.preventDefault();
		if ($('#input-finalizado-1').is(":checked")){
			$(".required").prop('required', true);
			$("#label-state-finalizado-1").text("Finalizado");
		}
		else{
			$("#label-state-finalizado-1").text("Sin Finalizar");
			$(".required").removeAttr('required');
		}
	});
	$('#input-finalizado-3').on('change', function(e){
		e.preventDefault();
		if ($('#input-finalizado-3').is(":checked")){
			$(".required").prop('required', true);
			$("#label-state-finalizado-3").text("Finalizado");
		}
		else{
			$("#label-state-finalizado-3").text("Sin Finalizar");
			$(".required").removeAttr('required');
		}
	});
	$("#FORM_PLANEACION_AE").on('submit', function(e){
		e.preventDefault();
		guardarPlaneacion("#FORM_PLANEACION_AE",1,null);
	});
	$("#FORM_PLANEACION_EDITAR").on('submit', function(e){
		e.preventDefault();
		if (linea_atencion_selected != 'arte_escuela')
			guardarProyecto("#FORM_PLANEACION_EDITAR",2,planeacionSelectedId);
		else
			guardarPlaneacion("#FORM_PLANEACION_EDITAR",2,planeacionSelectedId);

	});
	$("#FORM_PLANEACION_EC_LC").on('submit', function(e){
		e.preventDefault();
		guardarProyecto("#FORM_PLANEACION_EC_LC",3,null);
	});
	function guardarProyecto(form,tipoform,planeacion_id) { // 1 guardar, 2 editar
		if ($(form+' #SL_GRUPO').val() != "") {
			var recursosSelec = ""; 
			$(form+' #SL_RECURSOS :selected').each(function(i, selected){ 
				recursosSelec = recursosSelec + $(selected).val()+";";
			});

			var formularioJson = getFormData($(form));
			formularioJson['usuario_id'] = usuario_id;
			formularioJson['codigoGrupo'] = codigoGrupo;
			formularioJson['recursosSelec'] = recursosSelec;
			formularioJson['tipo_grupo'] = tipoGrupo;
			formularioJson['planeacion_id'] = planeacion_id;
			var finalizado;
			var estado;
			var texto = '';
			var titulo = '';
			if($(form+' #input-finalizado-'+tipoform).is(":checked")){
				finalizado = 1;
				titulo = "Enviar para revisión?";
				texto = "Has marcado FINALIZADO, se enviará para revisión";
				estado = "enviada";
			}
			else{
				finalizado = 0;
				titulo = "Guadar como borrador?";
				texto = "La planeación se guardará como borrador";
				estado = "guardada";
			}
			var datos1 = {
				p1: JSON.stringify(formularioJson),
				p2: finalizado,
				p3: tipoform
			}; 
			parent.swal({
				title: titulo,
				text: texto,
				type: 'warning',
				cancelButtonColor: '#d33',
				cancelButtonText: 'Cancelar',
				confirmButtonColor: '#3085d6',
				confirmButtonText: 'Sí!',
				showCancelButton: true
			}).then(function(){
				$.ajax({
					async : false,
					url: url_pedagogico_controller+"guardarProyecto",
					type: 'POST',
					dataType: 'html',
					data: datos1,
					success: function(retorno)
					{
						if(retorno == 1){
							parent.swal("Guardado", "La planeación ha sido "+estado,"success");
							refreshListado();
							$("#a_listado").click();
							$("#modalEditar").modal('hide');
						}
						else{
							parent.swal("Algo salió mal", "No se pudo guardar la planeación","warning");  
						}
					}
				});

			}, function(dismiss){
				return false;
			});
		}
		else
		{
			$(form+' #SL_GRUPO').focus();
			var box2 = bootbox.alert('Debe seleccionar un grupo');
			box2.css({
				'top': '40%',
				'margin-top': '15%'
			});
		}
	}
	function guardarPlaneacion(form,tipoform,planeacion_id) { // 1 guardar, 2 editar
		if ($(form+' #SL_METODOLOGIA').val() != "" || $(form+' #TXT_Otras_Metodologias').val() != "") {
			if ($(form+' #SL_GRUPO').val() != "") {
				var recursosSelec = ""; 
				$(form+' #SL_RECURSOS :selected').each(function(i, selected){ 
					recursosSelec = recursosSelec + $(selected).val()+";";
				});
				var referentes = "";
				if (tipoform == 2) 
					numPreguntas = numPreguntasEdicion;
				for (var i = 1; i <= numPreguntas; i++) {
					if ($(form+' #TX_Referente_'+i).val() != '' ) {
						referentes = referentes+ $(form+' #TX_Referente_'+i).val()+"////";
					}
				}  
				var metodologias = "";
				$(form+' #SL_METODOLOGIA :selected').each(function(i, selected){ 
					metodologias = metodologias + $(selected).text()+";";
				});
				var ciclos = ""; 
				$(form+' #SL_CICLO :selected').each(function(i, selected){ 
					ciclos = ciclos + $(selected).val()+",";
				});
				ciclos = ciclos.slice(0, -1);

				var formularioJson = getFormData($(form));
				formularioJson['usuario_id'] = usuario_id;
				formularioJson['metodologias'] = metodologias;
				formularioJson['ciclos'] = ciclos;
				formularioJson['referentes'] = referentes;
				formularioJson['codigoGrupo'] = codigoGrupo;
				formularioJson['recursosSelec'] = recursosSelec;
				formularioJson['tipo_grupo'] = tipoGrupo;
				formularioJson['planeacion_id'] = planeacion_id;
				var finalizado;
				var estado;
				var texto = '';
				var titulo = '';
				if($(form+' #input-finalizado-'+tipoform).is(":checked")){
					finalizado = 1;
					titulo = "Enviar para revisión?";
					texto = "Has marcado FINALIZADO, se enviará para revisión";
					estado = "enviada";
					formularioJson['in_estado'] = null;
				}
				else{
					finalizado = 0;
					titulo = "Guadar como borrador?";
					texto = "La planeación se guardará como borrador";
					estado = "guardada";
					formularioJson['in_estado'] = null;
				}
				var datos1 = {
					p1: JSON.stringify(formularioJson),
					p2: finalizado,
					p3: tipoform // 1 guardar, 2 editar
				}; 
				parent.swal({
					title: titulo,
					text: texto,
					type: 'warning',
					cancelButtonColor: '#d33',
					cancelButtonText: 'Cancelar',
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Sí!',
					showCancelButton: true
				}).then(function(){
					$.ajax({
						async : false,
						url: url_pedagogico_controller+"guardarPlaneacion",
						type: 'POST',
						dataType: 'html',
						data: datos1,
						success: function(retorno)
						{
							if(retorno == 1){
								parent.swal("Guardado", "La planeación ha sido "+estado,"success");
								refreshListado();
								$("#a_listado").click();
								$("#modalEditar").modal('hide');
							}
							else{
								parent.swal("Algo salió mal", "No se pudo guardar la planeación","warning");  
							}
						}
					});

				}, function(dismiss){
					return false;
				});
			}
			else
			{
				$(form+' #SL_GRUPO').focus();
				var box2 = bootbox.alert('Debe seleccionar un grupo');
				box2.css({
					'top': '40%',
					'margin-top': '15%'
				});
			}
		}
		else
		{
			$(form+' #SL_METODOLOGIA').focus();
			var box2 = bootbox.alert('Debe seleccionar una metodología');
			box2.css({
				'top': '40%',
				'margin-top': '15%'
			});
		}
	}
	$("#table-listado-planeaciones").delegate(".editar", "click", function(){
		$("#modalEditar").modal('show');
		numPreguntasEdicion = 0;
		var funcion = "";
		linea_atencion = $(this).data('linea-atencion');
		linea_atencion_selected = linea_atencion;
		var form = ""
		var inicialesgrupo = "";
		if (linea_atencion == 'arte_escuela') inicialesgrupo = "AE";
		if (linea_atencion == 'emprende_clan') inicialesgrupo = "EC";
		if (linea_atencion == 'laboratorio_clan') inicialesgrupo = "LC";
		if (linea_atencion == 'arte_escuela'){
			funcion = "getPlaneacion";
			form = "#FORM_PLANEACION_AE_CONTAINER";
		}
		else{
			funcion = "getGrupoPropuestaProyecto";
			form = "#FORM_PLANEACION_EC_LC_CONTAINER";
		}
		$("#FORM_PLANEACION_EDITAR").html($(form).clone());
		$('#FORM_PLANEACION_EDITAR .mes').each((key, element)=>{
			if ($(element).attr("href").indexOf("mes") != -1) {
				$(element).attr("href",$(element).attr("href").replace("mes","mesEdicion"));
			}
		});
		$('#FORM_PLANEACION_EDITAR .mescollapse').each((key, element)=>{
			if ($(element).attr("id").indexOf("mes") != -1) {
				$(element).attr("id",$(element).attr("id").replace("mes","mesEdicion"));
			}
		});
		$("#modalEditar "+form).append("<div class='col-lg-5 col-md-5 col-sm-5 text-right' style='margin-top: 15px'><button type='button' class='btn btn-danger btn-lg' data-dismiss='modal'>Cerrar</button></div><div class='col-lg-2 col-md-2 col-sm-2 text-left' style='margin-top: 15px'><div style='margin-top: 8px; margin-left: 50px;' class='material-switch pull-left' data-toggle='tooltip' title='Finalizado / Sin Finalizar' data-placement='bottom'><input  id='input-finalizado-2' name='input-finalizado-2'  class='checkState' type='checkbox'/><label for='input-finalizado-2' class='label-success'></label></div><label style='margin-top: 8px' class='col-lg-6 text-left' id='label-state-finalizado-2'>Sin Finalizar</label></div><div class='col-lg-5 col-md-5 col-sm-5 text-left' style='margin-top: 15px'><button id='submit-editar-informe' class='btn btn-success' type='submit'>Guardar</button></div>");
		$('#input-finalizado-2').on('change', function(e){
			e.preventDefault();
			if ($('#input-finalizado-2').is(":checked")){
				$(".required").prop('required', true);
				$("#label-state-finalizado-2").text("Finalizado");
			}
			else{
				$("#label-state-finalizado-2").text("Sin Finalizar");
				$(".required").removeAttr('required');
			}
		});
		let nombreGrupo = $(this).data('id-grupo');
		cargarEncabezadoPlaneacion($(this).data('id-grupo'), inicialesgrupo+"-"+nombreGrupo, linea_atencion, '#FORM_PLANEACION_EDITAR');
		planeacionSelectedId = $(this).data('id-planeacion');
		var datos = {
			p1: {
				'id_planeacion': planeacionSelectedId
			}
		};
		$.ajax({
			async: false,
			url: url_pedagogico_controller+funcion,
			type:'POST',
			dataType: 'json',
			data: datos,
			success: function(planeacion){
				if(planeacion != null){
					planeacion = planeacion;
					cargarContenidoPlaneacion(planeacion, "#FORM_PLANEACION_EDITAR "+form);
					$("#FORM_PLANEACION_EDITAR #a-add").click(function(e){
						e.preventDefault();
						numPreguntasEdicion = numPreguntasEdicion + 1;
						$("#FORM_PLANEACION_EDITAR #div-preguntas").append(
							'<div class="form-group col-lg-12 col-md-12" >'+
							'<input  maxlength="500" class="form-control campo col-lg-8 col-md-8" id="TX_Referente_'+numPreguntasEdicion+'"name="TX_Referente_'+numPreguntasEdicion+'" placeholder="Referente '+numPreguntasEdicion+'" type="text">'+
							'</div>'
							); 
					});
				}
			}
		});
		$("#modalEditar .campo").prop("readonly", false);
		$("#modalEditar .select").prop("disabled", false);
	});

	$("#table-listado-planeaciones").delegate(".ver", "click", function(){
		$("#modalEditar").modal('show');
		numPreguntasEdicion = 0;
		var funcion = "";
		linea_atencion = $(this).data('linea-atencion');
		linea_atencion_selected = linea_atencion;
		var form = ""
		if (linea_atencion == 'arte_escuela'){
			funcion = "getPlaneacion";
			form = "#FORM_PLANEACION_AE_CONTAINER";
		}
		else{
			funcion = "getGrupoPropuestaProyecto";
			form = "#FORM_PLANEACION_EC_LC_CONTAINER";
		}
		$("#FORM_PLANEACION_EDITAR").html($(form).clone());
		$('#FORM_PLANEACION_EDITAR .mes').each((key, element)=>{
			if ($(element).attr("href").indexOf("mes") != -1) {
				$(element).attr("href",$(element).attr("href").replace("mes","mesEdicion"));
			}
		});
		$('#FORM_PLANEACION_EDITAR .mescollapse').each((key, element)=>{
			if ($(element).attr("id").indexOf("mes") != -1) {
				$(element).attr("id",$(element).attr("id").replace("mes","mesEdicion"));
			}
		});
		$("#modalEditar "+form).append("<div class='col-lg-1 col-md-1 col-sm-1 col-lg-offset-11 col-md-offset-11 col-sm-offset-11 text-right'><button type='button' class='btn btn-danger btn-lg' data-dismiss='modal'>Cerrar</button></div>");
		let tipo_grupo = $(this).data('linea-atencion');
		let nombreGrupo = $(this).data('id-grupo');
		var inicialesgrupo = "";
		if (tipo_grupo == 'arte_escuela') inicialesgrupo = "AE";
		if (tipo_grupo == 'emprende_clan') inicialesgrupo = "EC";
		if (tipo_grupo == 'laboratorio_clan') inicialesgrupo = "LC";
		cargarEncabezadoPlaneacion($(this).data('id-grupo'), inicialesgrupo+"-"+nombreGrupo, tipo_grupo, '#FORM_PLANEACION_EDITAR');
		planeacionSelectedId = $(this).data('id-planeacion');
		var datos = {
			p1: {
				'id_planeacion': planeacionSelectedId
			}
		};
		$.ajax({
			async: false,
			url: url_pedagogico_controller+funcion,
			type:'POST',
			dataType: 'json',
			data: datos,
			success: function(planeacion){
				if(planeacion != null){
					planeacion = planeacion;
					cargarContenidoPlaneacion(planeacion, "#FORM_PLANEACION_EDITAR "+form);
					$("#FORM_PLANEACION_EDITAR #a-add").click(function(e){
						e.preventDefault();
						numPreguntasEdicion = numPreguntasEdicion + 1;
						$("#FORM_PLANEACION_EDITAR #div-preguntas").append(
							'<div class="form-group col-lg-12 col-md-12" >'+
							'<input  maxlength="500" class="form-control col-lg-8 col-md-8 campo" id="TX_Referente_'+numPreguntasEdicion+'"name="TX_Referente_'+numPreguntasEdicion+'" placeholder="Referente '+numPreguntasEdicion+'" type="text">'+
							'</div>'
							); 
					});
				}
			}
		});
		$("#modalEditar .campo").prop("readonly", true);
		$("#modalEditar .select").prop("disabled", true);
		$("#modalEditar .select").attr('readonly', 'readonly');
	});
	function cargarContenidoPlaneacion(planeacion,form) {
		$.each(planeacion, function(key, value) {
			$(form+' #'+key).val(value);
		});
		if (planeacion.recursos != undefined) {
			var recursos = planeacion.recursos.split(";");
			$(form+' #SL_RECURSOS').parent().parent().html(slRecursos);
			$(form+' #SL_RECURSOS').selectpicker('val', '');
			$(form+' #SL_RECURSOS').selectpicker("refresh");
			$.each(recursos, function (i) {
				if (recursos[i] != '') {
					$(form+" #SL_RECURSOS option[value='" + recursos[i]+ "']").prop('selected', true);
				}
			});
			$(form+' #SL_RECURSOS').selectpicker("refresh");
			$(form+' #TX_OTROS_RECURSOS').val(recursos[recursos.length-1]);
		}
		if (planeacion.metodologia != undefined) {
			var metodologias = planeacion.metodologia.split(";");
			$.each(metodologias, function (i) {
				if (metodologias[i] != '') {
					$(form+" #SL_METODOLOGIA option").filter(function() { return $(this).text() == metodologias[i]; }).prop('selected', true);
				}
			}); 
		}
		if (planeacion.referentes != undefined) {
			var referentes = planeacion.referentes.split("////");
			$.each(referentes, function (i) {
				if (referentes[i] != '') {						
					numPreguntasEdicion = numPreguntasEdicion + 1;
					$(form+" #div-preguntas").append(
						'<div class="form-group col-lg-12 col-md-12" >'+
						'<input  maxlength="500" class="form-control campo col-lg-8 col-md-8" id="TX_Referente_'+numPreguntasEdicion+'"name="TX_Referente_'+numPreguntasEdicion+'" placeholder="Referente '+numPreguntasEdicion+'" type="text">'+
						'</div>'
						); 

					$(form+" #TX_Referente_"+numPreguntasEdicion).val(referentes[i]);
				}
			}); 
		}
		if(planeacion.TX_Observacion != null){
			$('#modalEditar #div_correcciones').removeAttr('hidden');
			$('#modalEditar #TXTA_REVISION').summernote('code',planeacion.TX_Observacion);
			$('#modalEditar #TXTA_REVISION').summernote('disable');
		}
		else{
			$('#modalEditar #div_correcciones').attr('hidden', 'hidden');
		}
	}

	$("#table-listado-planeaciones").delegate(".descargar", "click", function(){
		id_planeacion = $(this).data('id-planeacion');
		tipo_grupo = $(this).data('linea-atencion');
		generarReportePlaneacion(id_planeacion,tipo_grupo);
	});

});
function getFormData(form){
	var unindexed_array = form.serializeArray();
	var indexed_array = {};
	$.map(unindexed_array, function(n, i){
		indexed_array[n['name']] = n['value'];
	});
	return indexed_array;
}
function getRecursos(form){
	$(form+' #SL_RECURSOS').html("");
	$.ajax({
		url:url_pedagogico_controller+"getRecursos",
		type:'POST',
		success: function(data){
			$(form+' #SL_RECURSOS').html(data);
		},
		async: false
	});
}

function generarReportePlaneacion(planeacionId,tipo_grupo) {
	var datos = {
		p1: {
			'id_planeacion': planeacionId
		}
	};
	if (tipo_grupo == 'arte_escuela')
		funcion = 'getPlaneacionDetalle';
	else	
		funcion = 'getGrupoPropuestaProyectoDetalle';
	var dataJson;
	$.ajax({
		async: false,
		url: url_pedagogico_controller+funcion,
		type:'POST',
		dataType: 'json',
		data: datos,
		success: function(planeacion){
			dataJson = planeacion;
			codigoGrupo = dataJson.FK_grupo;
			dataJson.VC_Acciones = JSON.parse(dataJson.VC_Acciones);

		}
	});

	var datosPost = { 
		p1: {
			'id_grupo': dataJson.FK_grupo,
			'tipo_grupo': dataJson.FK_Id_Linea_atencion
		}
	};
	$.ajax({
		async: false,
		url: url_pedagogico_controller+'consultarInformacionGrupo',
		type:'POST',
		data: datosPost,
		dataType: 'json',
		success: function(grupo){				
			$.ajax({
				async : false,
				url: url_pedagogico_controller+'consultarHorarioGrupo',
				type: 'POST',
				dataType: 'html',
				data: datosPost,
				success: function(horario)
				{
					if(horario){
						dataJson.horario = horario;
					}
				}
			});
			dataJson.LB_Idartes = grupo[0].FK_organizacion == 2 ? "SI" : "NO";
			dataJson.LB_Organizacion = grupo[0].FK_organizacion != 2 ? "SI" : "NO";
			dataJson.LB_Area_Artistica = grupo[0].VC_Nom_Area;
			dataJson.LB_Colegio = grupo[0].VC_Nom_Colegio;
			dataJson.LB_Clan = grupo[0].VC_Nom_Clan;
			
			var lugar_atencion = "";
			if(grupo[0].IN_lugar_atencion == 1){
				lugar_atencion = "COLEGIO";
			}else{
				if(grupo[0].IN_lugar_atencion == 2){
					lugar_atencion = "CREA";		
				}
				else{
					if(grupo[0].IN_lugar_atencion == 3) {
						lugar_atencion = "CREA y COLEGIO";				
					}
					else
						lugar_atencion = "CREA";
				}
			}
			dataJson.LB_Fecha_Elaboracion = dataJson.DA_Fecha_Registro;
			dataJson.LB_Lugar_Atencion = lugar_atencion;
			if (tipo_grupo == 'arte_escuela')
				dataJson.LB_Linea_Atencion = 'Arte en la escuela';
			if (tipo_grupo == 'emprende_clan')
				dataJson.LB_Linea_Atencion = 'Emprende CREA';
			if (tipo_grupo == 'laboratorio_clan')
				dataJson.LB_Linea_Atencion = 'Laboratorio CREA';
			
		}
	}); 
	if (dataJson.FK_Id_Linea_atencion == 'arte_escuela'){		
		dataJson.referentes = [];
		var referentes = dataJson.VC_Referentes.split("////");
		$.each(referentes, function (i) {
			if (referentes[i] != '') {
				dataJson.referentes.push(referentes[i]);
			}
		});    
		if (dataJson.FK_Ciclo == 0) {
			dataJson.VC_Ciclo = '';
		}
		dataJson.FK_Ciclo = getCiclo(dataJson.FK_Ciclo); 
		dataJson.VC_Metodologia = dataJson.VC_Metodologia.replace(/;/g, ".");
	}

	if (dataJson.FK_Id_Linea_atencion == 'arte_escuela')
		dataJson.FK_grupo_nombre = "AE-"+dataJson.FK_grupo; 
	if (dataJson.FK_Id_Linea_atencion == 'emprende_clan')
		dataJson.FK_grupo_nombre = "EC-"+dataJson.FK_grupo; 
	if (dataJson.FK_Id_Linea_atencion == 'laboratorio_clan')
		dataJson.FK_grupo_nombre = "LC-"+dataJson.FK_grupo; 
	dataJson.recursos = getRecursosText(dataJson.VC_Recursos);
	generarPdfPlaneacion(dataJson);
}
function getRecursosText(recursos) {
	var recursosString = '';
	var datos = {
		p1:{
			'recursos': recursos
		}
	};
	$.ajax({
		async: false,
		url:url_pedagogico_controller+"getRecursosText",
		type:'POST',
		dataType: 'json',
		data: datos,
		success: function(recursosData){
			//recursosData = JSON.parse(datos);
			$.each(recursosData, function (i) {
				recursosString = recursosString+recursosData[i].VC_Nombre+ ', '
			});  
			recursosString = recursosString.substr(0,recursosString.length-2);
		}
	}); 
	recursosVec = recursos.split(';');
	if (recursosVec[recursosVec.length-1] != '') {
		recursosString = recursosString + ', '+recursosVec[recursosVec.length-1];
	}
	recursosString+='.';
	return recursosString;
}
function getEntidad(codigoGrupoEntidad,linea){//linea 1: arte en la escuela, 2: emprende clan, 3:Laboratorio Clan.
	var result = "";
	var datos = {
		'opcion':'getEntidad',
		'idGrupo': codigoGrupoEntidad,
		'linea': linea
	};
	var url_controller = '../../Controlador/Pedagogico/C_Planeacion_Grupo.php';
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
function getCiclo(ciclo) {
	ciclo = ciclo.replace("0","No Aplica");
	ciclo = ciclo.replace("1","I");
	ciclo = ciclo.replace("2","II");
	ciclo = ciclo.replace("3","III");
	ciclo = ciclo.replace("4","IV");
	return ciclo;
}
function getHorario(codigo_grupo,linea) {//linea 1: arte en la escuela, 2: emprende clan
	var datosPost = { 
		p1: {
			'id_grupo': codigo_grupo,
			'tipo_grupo': linea
		}
	};
	var horarioTx = "";
	$.ajax({
		async : false,
		url: url_pedagogico_controller+'consultarHorarioGrupo',
		type: 'POST',
		dataType: 'html',
		data: datosPost,
		success: function(horario)
		{
			if(horario){
				horarioTx =horario;
			}
		}
	});
	return horario;
}
function generarPdfPlaneacion(dataJson)
{
	var pdfData = null;
	if (dataJson.FK_Id_Linea_atencion == 'arte_escuela'){
		pdfData = {
			content: [
			{
				style: 'tableExample',
				table: {
					widths: [109, '*', 158],
					heights:[12,12,20],
					body: [
					[
					{image: 'alcaldia_bogota_logo',width: 80,rowSpan: 4,alignment:'center', margin:[0,2,0,0]},
					{text:'GESTIÓN DE FORMACIÓN EN LAS PRACTICAS ARTÍSTICAS',style: 'titles',rowSpan: 2,margin: [0, 11, 0, 0]},
					{text:'Código: 1MI-GFOR-F09',style: 'general',margin: [0, 2, 0, 0]}
					],[{},
					{text:{}},
					{text:'Fecha: 26/03/2019',style: 'general',margin: [0, 2, 0, 0]}
					],
					[
					{},
					{text:'FORMATO DE PLANEACIÓN “ARTE EN LA ESCUELA Y LA CIUDAD',style: 'titles',rowSpan: 2,margin: [0, 2, 0, 0]},
					{text:'\n Versión:  2',style: 'general',margin: [0, 2, 0, 0]},
					],
					[
					{},
					{},
					{text: 'Aprobado', style: 'general', margin: [0, 2, 0, 0]},
					]
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['19%','5%','15%','5%','15%','11%','15%','15%'],
					body: [
					[{
						text: 'Linea de atención ',style: 'subtitle',
						colSpan: 2,
					},{},{
						text: dataJson.LB_Linea_Atencion,style: 'subtitle',
						colSpan: 3,
					},{},{},{
						text: 'Lugar de atención ',style: 'subtitle',
					},{
						text: dataJson.LB_Lugar_Atencion,style: 'subtitle',
						colSpan: 2,
					},{}
					],[
					{
						text: 'Artista formador ',style: 'subtitle',
						colSpan: 2,
					},{},{
						text: dataJson.nombre_usuario,style: 'subtitle',
						colSpan: 2,
					},{},{
						text: 'Área artística ',style: 'subtitle',
					},{
						text: dataJson.LB_Area_Artistica,style: 'subtitle',
					},{
						text: 'Crea al que pertenece',style: 'subtitle',
					},{
						text: dataJson.LB_Clan,style: 'subtitle',
					}
					],[
					{
						text: 'IDARTES',style: 'subtitle',
					},{
						text: dataJson.LB_Idartes,style: 'subtitle',
					},{
						text: 'Organización',style: 'subtitle',
					},{
						text: dataJson.LB_Organizacion,style: 'subtitle',
					},{
						text: 'Horario de grupo',style: 'subtitle',
					},{
						text: dataJson.horario,style: 'subtitle',
					},{
						text: 'Código del grupo',style: 'subtitle',
					},{
						text: dataJson.FK_grupo_nombre,style: 'subtitle',
					}
					],[
					{
						text: 'Ciclo/ Momento/ Multigrado/ Aceleración/',style: 'subtitle',
						colSpan: 2,
					},{},{
						text: dataJson.FK_Ciclo,style: 'subtitle',
					},{
						text: 'Nombre de la IED',style: 'subtitle',
						colSpan: 2,
					},{},{
						text: dataJson.LB_Colegio,style: 'subtitle',
						colSpan: 3,
					},{},{}
					]
					]
				}
			},
			{text: '\n'},
			{
				style: 'tableExample',
				table: {
					widths: ['50%','50%'],
					body: [
					[{
						text:[{text: 'OBJETIVO DE FORMACIÓN/ PROYECTO/ PROCESO ',style: 'subtitle'},"\n\n",{text:dataJson.VC_Objetivo}],

					},{
						text:[{text: 'PREGUNTA ORIENTADORA',style: 'subtitle'},"\n\n",{text:dataJson.VC_Pregunta}],
					}],
					[[{text: 'BREVE DESCRIPCIÓN DEL PROYECTO/ PROCESO ARTÍSTICO',style: 'subtitle'},"\n",{text:dataJson.VC_Descripcion}],
					{  text:[{text: 'METODOLOGÍA',style: 'subtitle'},"\n\n",{text:dataJson.VC_Metodologia}]}
					],
					[{
						text:[{text: 'TEMAS PROPUESTOS: ',style: 'subtitle'},"\n\n",{text:dataJson.VC_Temas}],

					},{
						text:[{text: 'RECURSOS FUNGIBLES Y TECNOLÓGICOS: ',style: 'subtitle'},"\n\n",{text:dataJson.recursos}],
					}],
					[{
						stack: [
						{text: 'REFERENTES: ',style: 'subtitle'},
						{
							ul: dataJson.referentes
						}
						]
					},{
						text:[{text: 'PROPUESTA DE CIRUCLACIÓN (MUESTRAS LOCALES Y FINALES): ',style: 'subtitle'},"\n\n",{text:dataJson.VC_Propuesta_Circulacion}],
					}]
					]
				}
			},
			{text: '\n\n'},
			{

				style: 'tableExample',
				table: {
					widths: ['20%','80%'],
					body: [

					[{
						text:[{text: 'ACCIONES EN EL AULA: ',style: 'subtitle',alignment:'center'}],
						colSpan: 2,
					},{}
					],
					[{rowSpan: 4, text: [{text: 'MES 1\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_1}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_1}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_2}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_3}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_4}]}],
					[{rowSpan: 4, text: [{text: 'MES 2\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_2}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_5}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_6}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_7}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_8}]}],
					[{rowSpan: 4, text: [{text: 'MES 3\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_3}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_9}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_10}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_11}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_12}]}],
					[{rowSpan: 4, text: [{text: 'MES 4\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_4}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_13}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_14}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_15}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_16}]}],
					[{rowSpan: 4, text: [{text: 'MES 5\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_5}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_17}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_18}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_19}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_20}]}],
					[{rowSpan: 4, text: [{text: 'MES 6\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_6}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_21}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_22}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_23}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_24}]}],
					[{rowSpan: 4, text: [{text: 'MES 7\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_7}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_25}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_26}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_27}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_28}]}],
					[{rowSpan: 4, text: [{text: 'MES 8\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_8}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_29}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_30}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_31}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_32}]}],
					[{rowSpan: 4, text: [{text: 'MES 9\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_9}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_33}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_34}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_35}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_36}]}],
					[{rowSpan: 4, text: [{text: 'MES 10\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_10}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_37}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_38}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_39}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_40}]}],
					[{rowSpan: 4, text: [{text: 'MES 11\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_11}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_41}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_42}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_43}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_44}]}],
					],

				}
			},
			{
				style: 'tableExample', 
				table: {
					widths: ['100%'],
					body: [
					[{
						text:[{text: 'ARTICULACIÓN CON EL PROYECTO EDUCATIVO INSTITUCIONAL (PEI) Línea Arte en la Escuela',style: 'subtitle',alignment:'center'}],
					}],
					[{
						text:[{text: dataJson.VC_Articulacion,alignment:'left'}],
					}],
					]
				}
			}
			],
			images: {
				alcaldia_bogota_logo:'data:image/png;base64,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'
			},
			styles: {
				header: {
					fontSize: 15,
					bold: true,
					margin: [0, 0, 0, 10]
				},
				titles: {
					bold: true,
					alignment:'center'
				},
				subheader: {
					fontSize: 12,
					bold: true,
					margin: [0, 10, 0, 5]
				},
				tableExample: {
					margin: [0, 5, 0, 15]
				},
				subtitle: {
					bold: true,
					fontSize: 10,
					color: 'black'
				}
			},
			defaultStyle: {
				fontSize: 10
			}
		}
	}
	else
	{
		pdfData = {
			content: [
			{
				style: 'tableExample',
				table: {
					widths: [109, '*', 158],
					heights:[12,12,20],
					body: [
					[
					{image: 'alcaldia_bogota_logo',width: 80,rowSpan: 4,alignment:'center', margin:[0,2,0,0]},
					{text:'GESTIÓN DE FORMACIÓN EN LAS PRACTICAS ARTÍSTICAS',style: 'titles',rowSpan: 2,margin: [0, 11, 0, 0]},
					{text:'Código: 1MI-GFOR-F09',style: 'general',margin: [0, 2, 0, 0]}
					],[{},
					{text:{}},
					{text:'Fecha: 26/03/2019',style: 'general',margin: [0, 2, 0, 0]}
					],
					[
					{},
					{text:'FORMATO DE PLANEACIÓN “ARTE EN LA ESCUELA Y LA CIUDAD',style: 'titles',rowSpan: 2,margin: [0, 2, 0, 0]},
					{text:'\n Versión:  2',style: 'general',margin: [0, 2, 0, 0]},
					],
					[
					{},
					{},
					{text: 'Aprobado', style: 'general', margin: [0, 2, 0, 0]},
					]
					]
				},layout: {
					vLineWidth: function (i, node) {
						return 0.9;
					},
					hLineWidth: function (i, node) {
						return 0.9;
					},
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['19%','10%','8%','10%','19%','22%','12%'],
					body: [
					[{
						text: 'Linea de atención ',style: 'subtitle',
						colSpan: 1,
					},{
						text: dataJson.LB_Linea_Atencion,style: 'subtitle',
						colSpan: 3,
					},{},{},{
						text: 'Lugar de atención ',style: 'subtitle',
					},{
						text: dataJson.LB_Lugar_Atencion,style: 'subtitle',
						colSpan: 2,
					},{
					}],[{
						text: 'Artista Formador(a) ',style: 'subtitle',
						colSpan: 1,
					},{
						text: dataJson.nombre_usuario,style: 'subtitle',
						colSpan: 2,
					},{},{
						text: 'Área artística ',style: 'subtitle',
					},{
						text: dataJson.LB_Area_Artistica,style: 'subtitle',
					},{
						text: 'Crea al que pertenece',style: 'subtitle',
					},{
						text: dataJson.LB_Clan,style: 'subtitle',
					}],[{
						text: 'Horario de grupo',style: 'subtitle',
					},{
						text: dataJson.horario,style: 'subtitle',
						colSpan: 4,
					},{},{},{},{
						text: 'Código del grupo',style: 'subtitle',
					},{
						text: dataJson.FK_grupo_nombre,style: 'subtitle',
					}],[{
						text: 'Información para la Línea de Laboratorio Crea',style: 'subtitle',
						colSpan: 7,alignment:'center'
					},{},{},{},{},{},{
					}],[{
						text: 'Nombre del proyecto artístico',style: 'subtitle',
						colSpan: 2,
					},{},{
						text: dataJson.VC_Nombre_Proyecto,style: 'subtitle',
						colSpan: 3,
					},{},{},{
						text: 'Manos a obra/ Súbete a la escena/ Grupo Metropolitano',style: 'subtitle',
					},{
						text: dataJson.VC_Manos,style: 'subtitle',
					}],[{
						text: 'Información para la Línea de Laboratorio Crea',style: 'subtitle',
						colSpan: 7,alignment:'center'
					},{},{},{},{},{},{
					}],[{
						text: 'Tipo de población',style: 'subtitle',
						colSpan: 2,
					},{},{
						text: dataJson.VC_Tipo_Poblacion,style: 'subtitle',
						colSpan: 3,
					},{},{},{
						text: 'Entidad aliada',style: 'subtitle',
					},{
						text: dataJson.VC_Entidad_Aliada,style: 'subtitle',
					}]
					]
				}
			},
			{text: '\n'},
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{
						text:[{text: 'ESTRUCTURA DEL PROYECTO O PROCESO ARTÍSTICO ',style: 'subtitle',alignment:'center'}],
					}],[{
						text:[{text: 'Propósito de la Entidad Aliada (Sólo para Laboratorio Crea):',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Proposito,style: 'subtitle'}]
					}],[{
						text:[{text: 'Tipo de proyecto:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Tipo_Proyecto,style: 'subtitle'}]
					}],[{
						text:[{text: 'Justificación:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Justificacion,style: 'subtitle'}]
					}],[{
						text:[{text: 'Descripción general del proyecto:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Descripcion,style: 'subtitle'}]
					}],[{
						text:[{text: 'Objetivo general:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Objetivo_General,style: 'subtitle'}]
					}],[{
						text:[{text: 'Objetivos específicos:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Objetivos_Especificos,style: 'subtitle'}]
					}],[{
						text:[{text: 'Metodología:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Metodologia,style: 'subtitle'}]
					}],[{
						text:[{text: 'Referentes conceptuales/teóricos/ visuales/ audiovisuales:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Referentes,style: 'subtitle'}]
					}],[{
						text:[{text: 'Resultados esperados:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Resultados,style: 'subtitle'}]
					}],[{
						text:[{text: 'Criterios cualitativos de evaluación del proyecto:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Criterios,style: 'subtitle'}]
					}],[{
						text:[{text: 'Materiales / recursos:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.recursos,style: 'subtitle'}]
					}],[{
						text:[{text: 'Planeador:',style: 'subtitle'}],
					}],[{
						text:[{text: dataJson.VC_Planeador,style: 'subtitle'}]
					}],
					]
				}
			},
			{text: '\n\n'},
			{

				style: 'tableExample',
				table: {
					widths: ['20%','80%'],
					body: [

					[{
						text:[{text: 'ACCIONES EN EL AULA: ',style: 'subtitle',alignment:'center'}],
						colSpan: 2,
					},{}
					],
					[{rowSpan: 4, text: [{text: 'MES 1\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_1}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_1}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_2}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_3}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_4}]}],
					[{rowSpan: 4, text: [{text: 'MES 2\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_2}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_5}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_6}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_7}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_8}]}],
					[{rowSpan: 4, text: [{text: 'MES 3\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_3}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_9}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_10}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_11}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_12}]}],
					[{rowSpan: 4, text: [{text: 'MES 4\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_4}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_13}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_14}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_15}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_16}]}],
					[{rowSpan: 4, text: [{text: 'MES 5\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_5}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_17}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_18}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_19}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_20}]}],
					[{rowSpan: 4, text: [{text: 'MES 6\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_6}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_21}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_22}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_23}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_24}]}],
					[{rowSpan: 4, text: [{text: 'MES 7\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_7}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_25}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_26}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_27}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_28}]}],
					[{rowSpan: 4, text: [{text: 'MES 8\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_8}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_29}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_30}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_31}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_32}]}],
					[{rowSpan: 4, text: [{text: 'MES 9\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_9}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_33}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_34}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_35}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_36}]}],
					[{rowSpan: 4, text: [{text: 'MES 10\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_10}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_37}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_38}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_39}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_40}]}],
					[{rowSpan: 4, text: [{text: 'MES 11\n ACCIONES:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.acciones_mes_11}]},
					{text: [{text: 'SEMANA 1:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_41}]}],['',
					{text: [{text: 'SEMANA 2:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_42}]}],['',
					{text: [{text: 'SEMANA 3:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_43}]}],['',
					{text: [{text: 'SEMANA 4:\n',style: 'subtitle'},{text:dataJson.VC_Acciones.semana_44}]}],
					],

				}
			}],
			images: {
				alcaldia_bogota_logo:'data:image/png;base64,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'
			},
			styles: {
				header: {
					fontSize: 15,
					bold: true,
					margin: [0, 0, 0, 10]
				},
				titles: {
					bold: true,
					alignment:'center'
				},
				subheader: {
					fontSize: 12,
					bold: true,
					margin: [0, 10, 0, 5]
				},
				tableExample: {
					margin: [0, 5, 0, 15]
				},
				subtitle: {
					bold: true,
					fontSize: 10,
					color: 'black'
				},
				legend: {
					italics: true,
					fontSize: 9,
					color: 'black'
				}
			},
			defaultStyle: {
				fontSize: 10
			}
		}
	}
	pdfMake.createPdf(pdfData).download("PlaneacionPDF.pdf");
	//pdfMake.createPdf(pdfData).open();
}