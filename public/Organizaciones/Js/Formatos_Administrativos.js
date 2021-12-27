var url_controller_formatos_administrativos = '../../Controlador/Organizaciones/C_Formatos_Administrativos.php';
var url_controller_seguimiento_propuesta = "../../Controlador/Organizaciones/C_Seguimiento_Organizaciones.php";
var url_controller_fas = "../../Controlador/Organizaciones/C_FAS_Organizaciones.php";
var session = "";
var session_type = "";
var tab_activa = "a-consultar-archivos";
var organizacion = "";
var year="";
$(document).ready(function(){
	var correctUpload = true;
	var msgError = '';
	$('[data-toggle="tooltip"]').tooltip();
	var idUsuario = $('#id_usuario').val();
	var files = {};
	$("#Form_Archivos").on('submit', function(e){
		e.preventDefault();
		if($("#SL_Convenios_Organizacion").val()==""){
			parent.swal("","Porfavor seleccione el convenio al cual pertenece(n) el(los) archivo(s)","warning");
		}
		else{
			var valido = true;
			if ($('#archivo_1').val() == '' && $('#archivo_2').val() == '' && $('#archivo_3').val() == '' && $('#archivo_4').val() == '') valido = false;
			if (valido) {
				files = uploadFiles(e,files,idUsuario);
			}
			else
			{
				parent.swal("","Debe seleccionar por lo menos un archivo","warning");
			}
		}
	});
	// parent.swal("PLATAFORMA CERRADA","El plazo para el envío de documentos Administrativos ha finalizado.","warning");
	$("#TXA_Observacion_Archivo").summernote({
		  height: 100,                 // set editor height
		  minHeight: null,             // set minimum height of editor
		  maxHeight: null,             // set maximum height of editor
		  placeholder: 'Detalle su observacion...',
		  lang: 'es-ES',
		  toolbar: [
		  ['misc', ['undo', 'redo']],
		  ['style', ['bold', 'italic', 'underline', 'clear']],
		  ['font', ['strikethrough', 'fontname']],
		  ['color', ['color']],
		  ['para', ['ul', 'ol', 'paragraph']],
		  ['height', ['height']]
		  ]
		});
	$("#P_Observacion").summernote({
		  height: 100,                 // set editor height
		  minHeight: null,             // set minimum height of editor
		  maxHeight: null,             // set maximum height of editor
		  placeholder: 'Detalle su observacion...',
		  lang: 'es-ES',
		  toolbar: [
		  ['misc', ['undo', 'redo']],
		  ['style', ['bold', 'italic', 'underline', 'clear']],
		  ['font', ['strikethrough', 'fontname']],
		  ['color', ['color']],
		  ['para', ['ul', 'ol', 'paragraph']],
		  ['height', ['height']]
		  ]
		});

	/*var bandera = true;
	$('input[type=file]').on('click', function(e){
		input = $(this);
		var key = $(this).attr('id');
		if (key != 'archivo_1' && key != 'archivo_2' && key != 'archivo_3' && key != 'archivo_4' && bandera) {
			e.preventDefault();
			if (key == 'anexos_archivo_1') {
				msg = '<h3>Recuerder que debe subir los siguentes 7 archivos:</h3>'+
				'<h4>1. Información General Recurso Humano (Contiene):</h4>'+
				'<ul>'+
				'<li>Formato de Perfil Recurso Humano</li>'+
				'<li>Hoja de vida</li>'+
				'<li>Rut</li>'+
				'<li>Cédula</li>'+
				'<li>Contrato</li>'+
				'</ul> '+
				'<h4>2. Información General Personal de Procesos de Formación (Contiene):</h4>'+
				'<ul>'+
				'<li>Formato de Perfil Recurso Humano</li>'+
				'<li>Hoja de vida</li>'+
				'<li>Rut</li>'+
				'<li>Cédula</li>'+
				'<li>Contrato</li>'+
				'</ul>				'+
				'<h4>3. Soportes Contables Recurso Humano (Contiene):</h4>'+
				'<ul>'+
				'<li>Comprobante egreso  </li>'+
				'<li>Transferencia bancaria  </li>'+
				'<li>Documento equivalente   </li>'+
				'<li>Cuenta de cobro   </li>'+
				'<li>Planilla de seguridad social   </li>'+
				'</ul>				'+
				'<h4>4. Soportes Contables Personal formador (Contiene):</h4>'+
				'<ul>'+
				'<li>Comprobante egreso  </li>'+
				'<li>Transferencia bancaria   </li>'+
				'<li>Documento equivalente   </li>'+
				'<li>Cuenta de cobro   </li>'+
				'<li>Planilla de seguridad social    </li>'+
				'<li>Reporte asistencia SICLAN   </li>'+
				'</ul>				'+
				'<h4>5. Soportes Contables Materiales del proceso (Contiene):</h4>'+
				'<ul>'+
				'<li>Comprobante egreso  </li>'+
				'<li>Transferencia bancaria   </li>'+
				'<li>Orden de compra   </li>'+
				'<li>Factura    </li>'+
				'<li>Rut</li>'+
				'<li>Planilla de seguridad social (aplica solo para servicios)   </li>'+
				'</ul>				'+
				'<h4>6. Soportes Contables Producción del Material (Contiene):</h4>'+
				'<ul>'+
				'<li>Comprobante egreso     </li>'+
				'<li>Transferencia bancaria     </li>'+
				'<li>Orden de compra   </li>'+
				'<li>Factura    </li>'+
				'<li>Rut</li>'+
				'<li>Planilla de seguridad social (aplica solo para servicios)   </li>'+
				'</ul>				'+
				'<h4>7.  Soportes Contables Divulgación (Contiene):</h4>'+
				'<ul>'+
				'<li>Comprobante egreso     </li>'+
				'<li>Transferencia bancaria     </li>'+
				'<li>Orden de compra   </li>'+
				'<li>Factura    </li>'+
				'<li>Rut</li>'+
				'<li>Planilla de seguridad social (aplica solo para servicios)   </li>'+
				'</ul>';
			}
			else
			{
				if (key == 'anexos_archivo_3') {
					msg = 'Porfavor requerde verificar los archivos antes de subirlos'
				}
				else{
					if (key == 'anexos_archivo_4') {
						msg = 'Porfavor requerde verificar los archivos antes de subirlos'
					}
					else {
						msg = ' ';
					}
				}
			}
			var box1 = bootbox.alert(msg,function() {
				bandera = false;
				input.trigger('click');
			});
			box1.css({
				'top': '15%',
				'margin-top': '15%'
			});
		}
		else
			bandera = true;

	});*/
	$('input[type=file]').on('change', function(e){
		e.preventDefault();
		var key = $(this).attr('id');
		var filesData = e.target.files;
		if (key == 'anexos_archivo_1')
		{
			if (filesData.length > 7 ) {
				correctUpload = false;
				msgError = 'Recuerde que se admiten maximo de 7 archivos para el Informe Financiero';
				bootbox.alert(msgError);
			}else
			{
				correctUpload = true;
			}
		}
		if (key == 'anexos_archivo_1' || key == 'anexos_archivo_3' || key == 'anexos_archivo_4'){
			$.each(filesData, function(index, element)
			{
				index++;
				files[key+'_'+index] = element;
			});
		}
		else
			files[key]= filesData[0];
	});

	$("#SL_Anio").html("");
	$('#SL_Anio').append(parent.getOptionsAnio());
	$("#SL_Anio").selectpicker("refresh");

	$("#SL_Mes").html("");
	$('#SL_Mes').append(parent.getOptionsMes());
	$("#SL_Mes").selectpicker("refresh");

	$("#SL_Anio_Informe").html("");
	$('#SL_Anio_Informe').append(parent.getOptionsAnio());
	$("#SL_Anio_Informe").selectpicker("refresh");

	$("#SL_Periodo_Informe").html("");
	$('#SL_Periodo_Informe').append(parent.getOptionsMes());
	$("#SL_Periodo_Informe").selectpicker("refresh");

	$("#SL_Anio_Proyeccion").html("");
	$('#SL_Anio_Proyeccion').append(parent.getOptionsAnio());
	$("#SL_Anio_Proyeccion").selectpicker("refresh");

	$("#SL_Periodo_Proyeccion").html("");
	$('#SL_Periodo_Proyeccion').append(parent.getOptionsMes());
	$("#SL_Periodo_Proyeccion").selectpicker("refresh"); 

	$("#SL_Proyecto").html("");
	$('#SL_Proyecto').append(parent.getProyectos());
	$("#SL_Proyecto").selectpicker("refresh");

	$('#SL_Proyecto').on('change', function(e){
		e.preventDefault();
		$("#SL_Rubro").html(parent.getParametroDetalleProyectoEstado(55,$(this).val(),1)).selectpicker("refresh");
	});

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php',
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
		},
		async : false
	});

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php',
		data: {requested: 'session_usertype'},
		dataType: 'json',
		success: function (data) {
			session_type = data;
		},
		async : false
	});

	$('.nav-item').on('click', function(e){
		e.preventDefault();
		if (this.firstElementChild.id != 'tab_proyeccion_gasto')
		{
			window.document.body.style.width = '100%';
			if (!parent.window.$('#btn_menu_show').children().hasClass('fa-angle-double-left'))
			{
				parent.window.$('#btn_menu_show').click();
			}
			if(this.firstElementChild.id == 'tab_informe_gestion' || this.firstElementChild.id == 'tab_subir_archivos'){
				if(session_type == 11){
					consultarSeguimientoPropuesta();
					/*parent.swal("Opción de Guardado","Ahora podrá ir guardando el informe de gestión progresivamente hasta terminarlo, cada uno de los borradores quedarán en la pestaña <b>CONSULTA DE FORMATOS</b>, dentro de los cuales podrá indicar cual es el que está <b>COMPLETADO</b> con el botón de la útlima columna <b>(SI/NO)</b>, esto con el fin de identificar cuales desea que sean revisados por el componente administrativo.","")*/
					parent.swal("Importante","Se ha <b>DESHABILITADO</b> el botón de GUARDAR del formulario desde donde se diligenciaba el <b>Informe de Gestión</b>, esto se debe a la transición en la que nos encontramos para actualizar dicho formato.<br> Por lo pronto puede dar clic en <b>EDITAR</b> a sus Informes de Gestión realizados si desea acceder a la información que ha enviado y utilizarla para diligenciar el <b>Formato temporal en WORD</b> proporcionado por el Equipo Administrativo, una vez diligenciado <b>debe ser adjuntado en la pestaña SUBIR ARCHIVOS.</b>","")
				}
			}
		}
		else
		{
			window.document.body.style.width = '200%';
			if ( parent.window.$('#btn_menu_show').children().hasClass('fa-angle-double-left')) {
				parent.window.$('#btn_menu_show').click();
			}
			if(session_type == 11){
				consultarSeguimientoPropuesta();
			}
		}
	});

	//EVENTOS DEL CONSULTAR SEGUIMIENTOS

	$("#SL_Year_Archivos_Organizacion").on('change', function(){
		$("#SL_Organizacion_Archivos").html("");
		$("#SL_Organizacion_Archivos").append("<option value=''>Seleccione la Organización</option>");
		year = $(this).val();
		var datos = {
			'opcion': 'getOrganizacionesAnio',
			'year': year
		};
		$.ajax({
			url: url_controller_formatos_administrativos,
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					informacion.forEach(cargarOrganizacionesArchivos);
					$("#SL_Organizacion_Archivos").selectpicker('refresh');
				}
				else{
				}
			},
			async : false
		});
	});

	$("#SL_Organizacion_Archivos").on('change', function(){
		if($(this).val()!=""){
			$("#DIV_DESCARGAR_TRAZABILIDAD").show();
		}
		else{
			$("#DIV_DESCARGAR_TRAZABILIDAD").hide();
		}

		$("#body_archivos").html("");

		organizacion = $(this).val();
		var datos = {
			'opcion': 'getArchivosOrganizacion',
			'organizacion': organizacion, //Aquí se envía el Id del Usuario (Coordinador Organización).
			'year': year+'%'
		};
		$.ajax({
			url: url_controller_formatos_administrativos,
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					try {
						tabla_archivos.clear();
					}
					catch(err) {
					}

					if ( $.fn.dataTable.isDataTable( '#tabla_archivos' ) ) {
						tabla_archivos = $('#tabla_archivos').DataTable().destroy();
					}

					informacion.forEach(cargarArchivos);

					if ( $.fn.dataTable.isDataTable( '#tabla_archivos' ) ) {
						tabla_archivos = $('#tabla_archivos').DataTable();
					}
					else{
						tabla_archivos = $('#tabla_archivos').DataTable({
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
								title: 'Listado de archivos por Organización '
							}
							],
						});
					}
					tabla_archivos.draw();
				}
				else{

				}
			},
			async : false
		});

		$(document).delegate(".revision",'click', function() {
			$("#MODAL_REVISION_ARCHIVOS #modal_titulo").html("REVISIÓN DEL ARCHIVO");
			id_archivo = $(this).data("id-archivo");
			$("#TXA_Observacion_Archivo").summernote('code',$(this).data('observaciones'));
			var checked = $(this).data('aprobacion');
			if (checked=="1") {
				checked = "on";
			}
			else{
				checked = "off";
			}
			$("#IN_Aprobacion_Archivos").bootstrapToggle(checked);
		});
	});

	$("#SL_Year").on('change', function(){
		$("#SL_Organizacion").html("");
		$("#SL_Organizacion").append("<option value=''>Seleccione la Organización</option>");
		year = $(this).val();
		var datos = {
			'opcion': 'getOrganizacionesAnio',
			'year': year
		};
		$.ajax({
			url: url_controller_fas,
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					informacion.forEach(cargarOrganizaciones);
					$("#SL_Organizacion").selectpicker('refresh');
				}
				else{
				}
			},
			async : false
		});
	});

	$(document).delegate(".estado_archivo", "change", function() {
		var estado = "";
		var id_archivo = $(this).data("id-archivo");
		if(this.checked){
			estado = "1";
			actualizarEstadoArchivo(id_archivo,estado, session);
		}
		else{
			estado = "0";
			actualizarEstadoArchivo(id_archivo,estado, session);
		}
	});

	$(document).delegate(".observaciones",'click', function() {
		$("#MODAL_OBSERVACION_ARCHIVOS #modal_titulo_observacion").html("OBSERVACIONES DEL ARCHIVO");
		$("#P_Observacion").summernote('code',$(this).data('observaciones'));
		$("#P_Observacion").summernote('disable');
	});

	$(document).delegate(".anexos",'click', function() {
		$("#MODAL_ANEXOS_ARCHIVOS #modal_titulo_anexo").html("ANEXOS DEL ARCHIVO <strong>"+$(this).data('nombre-archivo')+"</strong>");
		$("#body_anexos").html("");
		var datos = {
			'opcion': 'getAnexosArchivo',
			'id_archivo': $(this).data('id-archivo'),
		};
		$.ajax({
			url: url_controller_formatos_administrativos,
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					informacion.forEach(cargarAnexos);
				}
				else{
				}
			},
			async : false
		});
	});

	$("#BT_Guardar_Observacion").on('click', function(){
		var observacion_seguimiento = $("#TXA_Observacion_Archivo").val();
		var aprobacion = $("#IN_Aprobacion_Archivos").prop("checked");
		//alert(observacion_seguimiento+"-"+aprobacion);
		var datos = {
			'opcion': 'guardarRevisionArchivo',
			'id_persona': session,
			'id_archivo': id_archivo, //Aquí se envía el Id de la Tabla tb_organizacion_seguimiento_propuesta_periodo que se va a actualizar.
			'observacion': observacion_seguimiento,
			'aprobacion': aprobacion
		};
		$.ajax({
			url: url_controller_formatos_administrativos,
			data: datos,
			type: 'POST',
			success: function (info) {
				bootbox.alert("Acción Realizada", function(){
					if(aprobacion == true){
						aprobacion = 1;
					}else{
						aprobacion = 0;
					}
					$("#MODAL_REVISION_ARCHIVOS").modal('hide');
					//$("#BT_Abrir_Observaciones_"+id_periodo).data('observaciones', observacion_seguimiento);
					//$("#BT_Abrir_Observaciones_"+id_periodo).data('aprobacion', aprobacion);
					organizacion = $("#SL_Organizacion_Archivos").val();
					$("#SL_Organizacion_Archivos").val("0");
					$("#SL_Organizacion_Archivos").val(organizacion);
					$("#SL_Organizacion_Archivos").change();
				}).find('.modal-content').css({
					'background-color' : '#398439',
					'color': '#fff',
					'font-size': '12px',
					'font-weight' : 'bold',
					'margin-top': function (){
						var w = $( window ).height();
						var b = $(".modal-dialog").height();
						// should not be (w-h)/2
						var h = (w-b)/2;
						return h+"px";
					}
				});
			},
			async : false
		});
	});

	$("#FORM_TRAZABILIDAD").on('submit', function(e){
		e.preventDefault();
		generarPDFTrazabilidad($("#SL_Organizacion_Archivos").val(),$("#SL_Year_Archivos").val(), $("#SL_TRAZABILIDAD_MES option:selected").text());
	});

	// $('#a-consultar-archivos').on('click',function(e){
	// 	if(session_type == 11){
	// 		cargarArchivosSubidosOrganizacion();
	// 	}
	// });

	if(session_type == 11){ //SI ES COORDINADOR DE UNA ORGANIZACION SE OCULTAN LOS SELECCIONABLES Y SE CARGAN LOS CONVENIOS DE LA ORGANIZACIÓN.
		organizacion = session;
		$("#body_archivos").html("");
		$("#SL_Year_Archivos_Organizacion").selectpicker('hide');
		$("#SL_Organizacion_Archivos").selectpicker('hide');
		//Elementos de Consulta Formatos
		$("#SL_Year").selectpicker('hide');
		$("#SL_Organizacion").selectpicker('hide');
		
		$("#SL_Convenios_Organizacion").selectpicker('show');

		var datos = {
			'opcion': 'getConveniosOrganizacion',
			'id_organizacion': organizacion
		};
		$.ajax({
			url: url_controller_seguimiento_propuesta, 
			data: datos,
			type: 'POST',
			dataType: 'json',
			success: function (info) {
				$.each(info, function (i) {
					var year_convenio = info[i].DA_Inicio.substring(0, 4);
					$('#SL_Convenios_Organizacion').append($('<option>', {
						value : year_convenio,
						text : info[i].VC_Convenio,
						id_propuesta: info[i].PK_Id_Tabla
					}));
				});
				$("#SL_Convenios_Organizacion").selectpicker("refresh");
			},
			async : false
		});
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			tab_activa = $(e.target).attr('id');
			if(tab_activa != "a-consultar-archivos" && tab_activa != "tab_consulta_formatos"  && tab_activa != "tab_subir_archivos"){
				$("#SL_Convenios_Organizacion").selectpicker('hide');
			}else{
				$("#SL_Convenios_Organizacion").selectpicker('show');
				$("#SL_Convenios_Organizacion").trigger('change');
			}
		});
		year = $("#SL_Convenios_Organizacion").val();
	}
	else{
		$("#body_archivos").html("");
		$("#SL_Year_Archivos_Organizacion").selectpicker('show');
		$("#SL_Organizacion_Archivos").selectpicker('show');

		$("#SL_Year").selectpicker('show');
		$("#SL_Organizacion").selectpicker('show');

		$("#SL_Convenios_Organizacion").selectpicker('hide');
	}

	$("#SL_Convenios_Organizacion").on('change', function(){
		if($(this).val() != ""){
			if(tab_activa == "a-consultar-archivos"){
				cargarArchivosSubidosOrganizacion();
			}
			if(tab_activa == "tab_consulta_formatos"){
				year = $("#SL_Convenios_Organizacion").val();
				consultar_formatos_organizacion(organizacion, year);
			}
		}
	});

	$("#SL_Organizacion").on('change', function(){
		$("#body_formatos_administrativos").html("");
		organizacion = $(this).val();
		var datos = {
			'opcion': 'getFormatosAdministrativosOrganizacion',
			'organizacion': organizacion, //Aquí se envía el Id del Usuario (Coordinador Organización).
			'year': year
		};
		$.ajax({
			url: url_controller_fas,
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					try {
						tabla_fas.clear();
					}
					catch(err) {
					}

					if ( $.fn.dataTable.isDataTable( '#tabla_fas' ) ) {
						tabla_fas = $('#tabla_fas').DataTable().destroy();
					}

					informacion.forEach(cargarFAS);

					if ( $.fn.dataTable.isDataTable( '#tabla_fas' ) ) {
						tabla_fas = $('#tabla_fas').DataTable();
					}
					else{
						tabla_fas = $('#tabla_fas').DataTable({
							responsive: true,
							"order": [[ 1, "desc" ]],
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
								title: 'Listado de archivos por Organización '
							}
							],
						});
					}
					tabla_fas.draw();
				}
				else{

				}
			},
			async : false
		});

		$("#DIV_Observacion_FA").summernote({
			height: 100,                 
			minHeight: null,             
			maxHeight: null,             
			placeholder: 'Detalle su observacion...',
			lang: 'es-ES',
			toolbar: [
			['misc', ['undo', 'redo']],
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']]
			]
		});
		$("#P_Observacion_FA").summernote({
			height: 100,                 
			minHeight: null,             
			maxHeight: null,             
			placeholder: 'Detalle su observacion...',
			lang: 'es-ES',
			toolbar: [
			['misc', ['undo', 'redo']],
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']]
			]
		});
		$(document).delegate(".revision",'click', function() {
			$("#MODAL_REVISION_FAS #modal_titulo").html("REVISIÓN DEL FORMATO");
			id_tabla = $(this).data("id-informe-gestion");
			tipoInforme = $(this).data("tipo-informe");
			$("#DIV_Observacion_FA").summernote('code',$(this).data('observaciones'));
			var checked = $(this).data('aprobacion');
			if (checked=="1") {
				checked = "on";
			}
			else{
				checked = "off";
			}
			$("#IN_Aprobacion_FA").bootstrapToggle(checked);
		});
	});

	$("#BT_Guardar_Observacion_FA").on('click', function(){
		var observacion_fa = $("#DIV_Observacion_FA").summernote('code');
		var aprobacion = $("#IN_Aprobacion_FA").prop("checked");
    		//alert(observacion_fa+"-"+aprobacion);
    		var datos = {
    			'opcion': 'guardarRevisionFA',
    			'id_persona': session,
    			'tipo_informe': tipoInforme,
				'id_tabla': id_tabla, //Aquí se envía el Id de la Tabla tb_organizacion_informe_gestion que se va a actualizar.
				'observacion': observacion_fa,
				'aprobacion': aprobacion
			};
			$.ajax({
				url: url_controller_fas,
				data: datos,
				type: 'POST',
				success: function (info) {
					bootbox.alert("Acción Realizada", function(){
						if(aprobacion == true){
							aprobacion = 1;
						}else{
							aprobacion = 0;
						}
						$("#MODAL_REVISION_FAS").modal('hide');
	        		//$("#BT_Abrir_Observaciones_"+id_periodo).data('observaciones', observacion_seguimiento);
	        		//$("#BT_Abrir_Observaciones_"+id_periodo).data('aprobacion', aprobacion);
	        		organizacion = $("#SL_Organizacion").val();
	        		$("#SL_Organizacion").val("0");
	        		$("#SL_Organizacion").val(organizacion);
	        		$("#SL_Organizacion").change();
	        	}).find('.modal-content').css({
	        		'background-color' : '#398439',
	        		'color': '#fff',
	        		'font-size': '4em',
	        		'font-weight' : 'bold',
	        		'margin-top': function (){
	        			var w = $( window ).height();
	        			var b = $(".modal-dialog").height();
        				// should not be (w-h)/2
        				var h = (w-b)/2;
        				return h+"px";
        			}
        		});
	        },
	        async : false
	    });
		});
});//FIN DOCUMENT READY

function cargarArchivosSubidosOrganizacion() {

	organizacion = session;
	var datos = {
		'opcion': 'getArchivosOrganizacion',
		'tipo': session_type,
		'organizacion': organizacion,
		'year': $("#SL_Convenios_Organizacion").val()+'%'
	};
	parent.mostrarCargando();
	$.ajax({
		url: url_controller_formatos_administrativos,
		data: datos,
		type: 'POST',
		success: function (info) {
			informacion = JSON.parse(info);
			if (info != 'null') {

				try {
					tabla_archivos.clear();
				}
				catch(err) {
				}

				if ( $.fn.dataTable.isDataTable( '#tabla_archivos' ) ) {
					tabla_archivos = $('#tabla_archivos').DataTable().destroy();
				}

				informacion.forEach(cargarArchivos);

				if ( $.fn.dataTable.isDataTable( '#tabla_archivos' ) ) {
					tabla_archivos = $('#tabla_archivos').DataTable();
				}
				else{
					tabla_archivos = $('#tabla_archivos').DataTable({
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
							title: 'Listado de archivos por Organización '
						}
						],
					});
				}
				tabla_archivos.draw();

			}
			else{

			}
			parent.cerrarCargando();
		},
		async : true
	});
	$(".revision").addClass("disabled");
}

function uploadFiles(event,files,idUsuario)
{
	var datos = {};
	var data = new FormData();
	$.each(files, function(key, value)
	{
		data.append(key, value);
	});
	data.append("opcion","subirArchivos");
	data.append("idUsuario",idUsuario);
	var id_propuesta = $("#SL_Convenios_Organizacion option:selected").attr("id_propuesta");
	data.append("idPropuesta",id_propuesta);

	var meses = "";
	$('#SL_Mes :selected').each(function(i, selected){
		meses = meses + $(selected).text()+",";
	});
	meses = meses.substring(0, meses.length - 1);
	var anio = "";
	anio = $('#SL_Anio').val();
	data.append("meses",meses);
	data.append("anio",anio);
	$.ajax({
		async: false,
		url:url_controller_formatos_administrativos+'?files',
		type:'POST',
		data: data,
		cache: false,
		dataType: 'html',
		processData: false,
		contentType: false,
		beforeSend: function(){
			parent.mostrarCargando();
		},
		success: function(datos)
		{
			if (datos == true) {
				parent.cerrarCargando();
				parent.swal("Realizado!","Sus archivos se han subido correctamente.","success");
				$("#Form_Archivos")[0].reset();
				$('.selectpicker').selectpicker('refresh');
				files = {};
			}
			else
			{
				parent.cerrarCargando();
				parent.swal("Error!","Ha ocurrido un error, porfavor intente en un momento.","error");
			}
		}
	});
	return files;
}

function cargarOrganizacionesArchivos(item, index) {
	$("#SL_Organizacion_Archivos").append("<option value="+item.PK_Id_Organizacion+">"+item.VC_Nom_Organizacion+"</option>");
	//console.log(item.VC_Nom_Organizacion);
}

function cargarArchivos(item, index) {
	var url = item.VC_URL;
	if(item.IN_Estado_Final==1){
		if (item.VC_Tipo != 'SEGUIMIENTO ORGANIZACIONES' && item.VC_Tipo != 'ARMONIZACION') {
			if(item.TX_Observacion != "" && item.TX_Observacion != null && item.IN_Aprobacion==0){
				$("#body_archivos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-warning observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_ARCHIVOS' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Pendiente</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>FINAL</span></td></tr>");
			}else{
				if (item.IN_Aprobacion == 1) {
					$("#body_archivos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-success observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_ARCHIVOS' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Aprobado</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>FINAL</span></td></tr>");
				}
				else{
					$("#body_archivos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-info observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_ARCHIVOS' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Vacio</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>FINAL</span></td></tr>");
				}
			}
		}
	}
	else{
		if (item.VC_Tipo != 'SEGUIMIENTO ORGANIZACIONES' && item.VC_Tipo != 'ARMONIZACION') {
			if(item.TX_Observacion != "" && item.TX_Observacion != null && item.IN_Aprobacion==0){
				$("#tabla_archivos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-warning observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_ARCHIVOS' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Pendiente</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>PARCIAL</span></td></tr>");
			}else{
				if (item.IN_Aprobacion == 1) {
					$("#tabla_archivos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-success observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_ARCHIVOS' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Aprobado</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>PARCIAL</span></td></tr>");
				}
				else{
					$("#tabla_archivos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION_ARCHIVOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-info observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_ARCHIVOS' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Vacio</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>PARCIAL</span></td></tr>");
				}
			}
		}
	}
	$(".estado_archivo").bootstrapToggle();
}

function cargarAnexos(item, index) {
	var url = item.VC_URL;
	$("#MODAL_ANEXOS_ARCHIVOS").find("#body_anexos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td><a class='btn btn-danger' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='"+item.VC_URL+"'><span class='fa fa-download'></span></a></td></tr>");
}

function generarPDFTrazabilidad(id_organizacion,anio, mes) {
	var datos = {
		'opcion': 'getFormatosOrganizacionMes',
		'id_organizacion': id_organizacion,
		'year': anio,
		'mes' : mes
	};

	$.ajax({
		url: url_controller_formatos_administrativos,
		data: datos,
		type: 'POST',
		success: function (datos) {
			archivo = JSON.parse(datos);
			archivos = [];

			var numero_rows = Object.keys(archivo).length;
			var aprobacion = "";
			var supervisor = "";
			for(i=1;i<=numero_rows;i++){
				if(archivo[i-1].TX_Observacion != "" && archivo[i-1].TX_Observacion != null && archivo[i-1].IN_Aprobacion==0){
					aprobacion="Pendiente";
				}else{
					if (archivo[i-1].IN_Aprobacion == 1){
						aprobacion="Aprobado";
					}else{
						aprobacion="Sin revisar";
					}
				}
				supervisor = archivo[i-1].VC_Primer_Nombre+' '+archivo[i-1].VC_Primer_Apellido;
				var observacion_formato = strip(archivo[i-1].TX_Observacion);

				archivos.push(
				{
					style: 'tableExample',
					table: {
						widths: ['*','20%','*','10%','*'],
						body: [
						[
						{
							text:[{text: archivo[i-1].VC_Nombre_Archivo,style: 'subheader'}],
						},{
							text:[{text: archivo[i-1].VC_Tipo,style: 'subheader'}],
						},{
							text:[{text: observacion_formato,style: 'subheader',alignment:'justify'}],
						},{
							text:[{text: aprobacion,style: 'subheader',alignment:'justify'}],
						},{
							text:[{text: supervisor,style: 'subheader',alignment:'justify'}],
						}]
						]
					}
				}
				);
			}
		},
		async : false
	});
	construirPDFTrazabilidad(archivos);
}

function strip(html)
{
	var tmp = document.createElement("DIV");
	tmp.innerHTML = html;
	return tmp.textContent || tmp.innerText || "";
}

function construirPDFTrazabilidad(archivos) {
	var imageBogota;
	var imageClan;
	pdfData = {
		pageOrientation: 'landscape',
		pageSize: 'Legal',
		content: [
		{
			style: 'tableExample',
			table: {
				widths: ['20%','65%', '*'],

				body: [
				[
				{
					image: 'data:image/png;base64,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',
					height:80,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nREPORTE DE TRAZABILIDAD MENSUAL DE ORGANIZACIONES',alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'data:image/jpeg;base64,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',
					height:85,
					width:120,
					border: [false, false, false, false]
				},

				]
				]

			}

		},
		{text: 'TRAZABILIDAD DEL MES DE '+$("#SL_TRAZABILIDAD_MES option:selected").text().toUpperCase()+' DE '+$("#SL_Year_Archivos_Organizacion option:selected").val()+' - ORGANIZACIÓN: '+$("#SL_Organizacion_Archivos option:selected").text().toUpperCase()},
		{text: '\n'},
		{
			style: 'tableExample',
			table: {
				widths: ['*','20%','*','10%','*'],
				body: [
				[{
					text:[{text: 'NOMBRE DEL ARCHIVO',style: 'tableHeader'}],
					style: 'bgcolor'
				},{
					text:[{text: 'TIPO',style: 'tableHeader'}],
					style: 'bgcolor'
				},{
					text:[{text: 'OBSERVACION',style: 'tableHeader'}],
					style: 'bgcolor'
				},{
					text:[{text: 'APROBACIÓN',style: 'tableHeader'}],
					style: 'bgcolor'
				},{
					text:[{text: 'SUPERVISOR DE APOYO',style: 'tableHeader'}],
					style: 'bgcolor'
				}]
				]
			}
		},
		archivos
		],
		images:
		{
			image_bogota: "",
			image_clan: ""
		},
		styles: {
			bgcolor: {
				bold: true,
				fontSize: 10,
				fillColor: '#e6e6e6',
			},
			header: {
				fontSize: 15,
				bold: true,
				margin: [0, 0, 0, 10],
			},
			tableCell: {
				fontSize: 15,
				bold: true,
				margin: [0, 0, 0, 10],
			},
			subheader: {
				fontSize: 10,
				bold: false,
				margin: [0, 10, 0, 5]
			},
			tableExample: {
				margin: [0, 0, 0, 0]
			},
			tableHeader: {
				bold: true,
				fontSize: 12,
				fillColor: '#e6e6e6',
			}
		},
		defaultStyle: {
			fontSize: 10
		}
	}
	convertImgToBase64("../imagenes/bogotaPdf.jpg", function(base64Img){
		imageBogota = base64Img;
	});
	convertImgToBase64("../imagenes/clan.jpg", function(base64Img){
		imageClan = base64Img;
		pdfData.images["image_bogota"]=imageBogota;
		pdfData.images["image_clan"]=imageClan;
		pdfMake.createPdf(pdfData).download("TrazabilidadOrganizacion.pdf");
	});
}


function convertImgToBase64(url, callback, outputFormat){
	var img = new Image();
	img.crossOrigin = 'Anonymous';
	img.onload = function(){
		var canvas = document.createElement('CANVAS');
		var ctx = canvas.getContext('2d');
		canvas.height = this.height;
		canvas.width = this.width;
		ctx.drawImage(this,0,0);
		var dataURL = canvas.toDataURL(outputFormat || 'image/png');
		callback(dataURL);
		canvas = null;
	};
	img.src = url;
}

function actualizarEstadoArchivo(id_archivo,estado, usuario){
	var datos = {
		'opcion': 'actualizarEstadoArchivo',
		'id_archivo': id_archivo,
		'estado': estado,
		'usuario': usuario
	};

	$.ajax({
		url: url_controller_formatos_administrativos,
		data: datos,
		type: 'POST',
		success: function (datos) {
			parent.swal("","El estado del archivo ha sido actualizado","success");
		},
		async : false
	});
}

function consultar_formatos_organizacion(organizacion){
	$("#body_formatos_administrativos").html("");
	var datos = {
		'opcion': 'getFormatosAdministrativosOrganizacion',
			'organizacion': organizacion, //Aquí se envía el Id del Usuario (Coordinador Organización).
			'year': year //Aquí se envía el Id del Usuario (Coordinador Organización).
		};
		parent.mostrarCargando();
		$.ajax({
			url: url_controller_fas,
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {

					try {
						tabla_fas.clear();
					}
					catch(err) {
					}

					if ( $.fn.dataTable.isDataTable( '#tabla_fas' ) ) {
						tabla_fas = $('#tabla_fas').DataTable().destroy();
					}

					informacion.forEach(cargarFAS);

					if ( $.fn.dataTable.isDataTable( '#tabla_fas' ) ) {
						tabla_fas = $('#tabla_fas').DataTable();
					}
					else{
						tabla_fas = $('#tabla_fas').DataTable({
							responsive: true,
							"order": [[ 1, "desc" ]],
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
								title: 'Listado de archivos por Organización '
							}
							],
						});
					}
					tabla_fas.draw();
					$('#tabla_fas').on('draw.dt', function () {
						$(".revision").addClass("disabled");
					} );
				}
				else{

				}
				$(".revision").addClass("disabled");
				parent.cerrarCargando();
			},
			async : true
		});

	}

	function cargarOrganizaciones(item, index) {
		$("#SL_Organizacion").append("<option value="+item.FK_Coordinador+">"+item.VC_Nom_Organizacion+"</option>");
    //console.log(item.VC_Nom_Organizacion);
}

//FAS = Formatos Administrativos.
function cargarFAS(item, index){
	if(item.IN_Estado_Final==1)
	{
		if(item.TX_Observaciones != "" && item.TX_Observaciones != null && item.IN_Aprobacion==0){
			$("#body_formatos_administrativos").append("<tr><td>"+item.VC_Periodo+"/"+item.IN_Anio+"</td><td>"+item.DA_Registro+"</td><td>"+item.tipo_informe+"</td><td><a class='btn btn-danger descargar_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-folder-open'></span> Descargar</a></td><td><a class='btn btn-danger abrir_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-pencil'></span> Editar</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"' data-toggle='modal' data-target='#MODAL_REVISION_FAS' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-warning observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_FAS' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Pendiente</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_formato' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span hidden>FINAL</span></td></tr>");
		}
		else{
			if (item.IN_Aprobacion == 1) {
				$("#body_formatos_administrativos").append("<tr><td>"+item.VC_Periodo+"/"+item.IN_Anio+"</td><td>"+item.DA_Registro+"</td><td>"+item.tipo_informe+"</td><td><a class='btn btn-danger descargar_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-folder-open'></span> Descargar</a></td><td><a class='btn btn-danger abrir_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-pencil'></span> Editar</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"' data-toggle='modal' data-target='#MODAL_REVISION_FAS' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-success observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_FAS' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Aprobado</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_formato' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span hidden>FINAL</span></td></tr>");
			}
			else{
				$("#body_formatos_administrativos").append("<tr><td>"+item.VC_Periodo+"/"+item.IN_Anio+"</td><td>"+item.DA_Registro+"</td><td>"+item.tipo_informe+"</td><td><a class='btn btn-danger descargar_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-folder-open'></span> Descargar</a></td><td><a class='btn btn-danger abrir_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-pencil'></span> Editar</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"' data-toggle='modal' data-target='#MODAL_REVISION_FAS' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-info observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_FAS' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Vacío</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_formato' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span hidden>FINAL</span></td></tr>");
			}
		}
	}
	else{
		if(item.TX_Observaciones != "" && item.TX_Observaciones != null && item.IN_Aprobacion==0){
			$("#body_formatos_administrativos").append("<tr><td>"+item.VC_Periodo+"/"+item.IN_Anio+"</td><td>"+item.DA_Registro+"</td><td>"+item.tipo_informe+"</td><td><a class='btn btn-danger descargar_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-folder-open'></span> Descargar</a></td><td><a class='btn btn-danger abrir_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-pencil'></span> Editar</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"' data-toggle='modal' data-target='#MODAL_REVISION_FAS' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-warning observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_FAS' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Pendiente</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_formato' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span hidden>PARCIAL</span></td></tr>");
		}else{
			if (item.IN_Aprobacion == 1) {
				$("#body_formatos_administrativos").append("<tr><td>"+item.VC_Periodo+"/"+item.IN_Anio+"</td><td>"+item.DA_Registro+"</td><td>"+item.tipo_informe+"</td><td><a class='btn btn-danger descargar_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-folder-open'></span> Descargar</a></td><td><a class='btn btn-danger abrir_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-pencil'></span> Editar</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"' data-toggle='modal' data-target='#MODAL_REVISION_FAS' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-success observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_FAS' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Aprobado</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_formato' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span hidden>PARCIAL</span></td></tr>");
			}
			else{
				$("#body_formatos_administrativos").append("<tr><td>"+item.VC_Periodo+"/"+item.IN_Anio+"</td><td>"+item.DA_Registro+"</td><td>"+item.tipo_informe+"</td><td><a class='btn btn-danger descargar_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-folder-open'></span> Descargar</a></td><td><a class='btn btn-danger abrir_informe' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span class='fa fa-pencil'></span> Editar</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"' data-toggle='modal' data-target='#MODAL_REVISION_FAS' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-info observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION_FAS' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Vacío</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_formato' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-informe-gestion='"+item.PK_Id_Tabla+"' data-tipo-informe='"+item.tipo_informe+"'><span hidden>PARCIAL</span></td></tr>");
			}
		}
	}
	$(".estado_formato").bootstrapToggle();
}
