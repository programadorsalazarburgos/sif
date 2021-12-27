 var url_service_inventario = '../../Controlador/Infraestructura/Inventario/C_Inventario.php';
 var url_ok_obj = '../../src/Infraestructura/Controlador/InfraestructuraController.php';
 var tabla_inventario = "";
 var tabla_observaciones = "";
 var tabla_traslados = "";
 var tabla_asignaciones = "";
 var fecha_reporte = new Date().toJSON().slice(0,10);
 var session = "";
 var rol = "";
 var availableDescriptions = ["Sin descripcion"];
 var restantes = 0;
 var tipo_elemento= "";
 var placa = "";
 var id_lugar = "";
 var id_elemento = "";
 var descripcion = "";
 var id_tipo_elemento = "";
 var id_tipo_bien = "";
 var estado_baja = "";
 $(document).ready(function(){
 	var ident="";
 	$('#CHECKBOX_TIPO_CONSULTA').checkboxpicker(); //Habilitar Bootstrap Checkbox
 	$('#CHECKBOX_TIPO_CONSULTA').prop("checked",false);
 	$('#CHECKBOX_TIPO_CONSULTA').change(function() {
 		if (this.checked) { 
 			$("#DIV_FILTROS_INVENTARIO").hide();
 			$("#DIV_CONSULTA_PLACA").show();
 			$("#TXT_PLACA").prop('required', true);
 		}else{
 			$("#DIV_CONSULTA_PLACA").hide();
 			$("#DIV_FILTROS_INVENTARIO").show();
 			$("#TXT_PLACA").removeAttr('required');
 		}
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
 			rol = data;
 		},
 		async : false
 	});

 	if(rol == 14){
 		$("#BT_CONTROL_INVENTARIO").removeClass("hidden");
 	}

 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'json',
 		data: {opcion: 'listar_elementos'},
 		success: function(datos)
 		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_ELEMENTO').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#modal-editar #MODAL_SL_ELEMENTO').selectpicker("refresh");
		}
	});
 	$("#MODAL_SL_ELEMENTO").on('change',function(){
 		if ($("#MODAL_SL_ELEMENTO").val() == "2"){
 			$("#MODAL_DIV_DONANTE").show();
 			$("#MODAL_TXT_DONANTE").prop("required", true);
 		}else{
 			$("#MODAL_DIV_DONANTE").hide();
 			$("#MODAL_TXT_DONANTE").prop("required", false);
 			$("#MODAL_TXT_DONANTE").val("");
 		}
 		$('.required').prop('required', function(){
 			return  $(this).is(':visible');
 		});
 	});

 	$("#DT_FECHA_TRASLADO").datepicker({
 		format: 'yyyy/mm/dd',
 		viewMode: 'years'
 	});
 	$(".readonly").on('keydown paste', function(e){
 		e.preventDefault();
 	});

 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'json',
 		data: {opcion: 'listar_estado_bien'},
 		success: function(datos)
 		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_ESTADO_BIEN').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#modal-editar #MODAL_SL_ESTADO_BIEN').selectpicker("refresh");
		}
	});

 	listarDonantes();

 	$(document).delegate(".eliminar-observacion", "click", function() {
 		var datosTabla=tabla_observaciones.row(($(this).parent()).parent()).data();
 		var id_observacion = $(this).attr("data-id-observacion");
 		var id_inventario = $(this).attr("data-id-inventario");
 		var fecha_observacion = datosTabla[2];

 		parent.swal({
 			confirmButtonColor: '#3f9a9d',
 			title: 'CONFIRMAR ACCIÓN',
 			html: '<small>Se va a eliminar la siguiente Observación:<br><br>'+datosTabla[0]+'<br><strong><br>Desea confirmar la acción?</small>',
 			type: 'warning',
 			allowOutsideClick: false,
 			allowEscapeKey: false,
 			confirmButtonText: 'SI',
 			cancelButtonText: 'NO',
 			showCancelButton: true,
 		}).then(() => {
 			$.ajax({
 				async : false,
 				url: url_service_inventario,
 				type: 'POST',
 				dataType: 'html',
 				data: {id: id_observacion, usuario:session, fecha_observacion:fecha_observacion, opcion:'eliminar_observacion'},
 				success: function(datos)
 				{
 					if(datos == 1){
 						parent.swal("La observación fue eliminada.", "", "success");
 						cargarHistorialObservaciones(id_inventario);
 					}
 					else{
 						parent.swal("No pudo ser eliminada la observación", "Solo se permite eliminar una observación dentro de las <b>24 horas</b> siguientes al momento en que fue registrada, si este no es el caso y no le permite eliminar la observación porfavor comunicarse con el equipo de soporte.", "error");
 					}
 				}
 			});
 		},() => {}).catch(parent.swal.noop);
 	});

 	$(document).delegate(".eliminar-traslado", "click", function() {
 		var datosTabla=tabla_traslados.row(($(this).parent()).parent()).data();
 		var id_traslado = $(this).attr("data-id-traslado");
 		var id_inventario = $(this).attr("data-id-inventario");

 		parent.swal({
 			confirmButtonColor: '#3f9a9d',
 			title: 'CONFIRMAR ACCIÓN',
 			html: '<small>Se va a eliminar la siguiente Solicitud de Traslado:<br><br><strong>Origen:</strong> '+datosTabla[1]+'<br><strong>Destino:</strong> '+datosTabla[2]+'<br><strong>Cantidad:</strong> '+datosTabla[3]+'<br><strong>Argumento:</strong> '+datosTabla[4]+'<br><strong>Desea confirmar la acción?</strong></small>',
 			type: 'warning',
 			allowOutsideClick: false,
 			allowEscapeKey: false,
 			confirmButtonText: 'SI',
 			cancelButtonText: 'NO',
 			showCancelButton: true,
 		}).then(() => {
 			$.ajax({
 				async : false,
 				url: url_service_inventario,
 				type: 'POST',
 				dataType: 'html',
 				data: {id: id_traslado, usuario:session, opcion:'eliminar_traslado'},
 				success: function(datos)
 				{
 					parent.swal("La solicitud de traslado fue eliminada.", "", "success");
 					cargarHistorialTraslados(id_inventario);
 				}
 			});
 		},() => {}).catch(parent.swal.noop);
 	});

 	$(document).delegate(".eliminar-asignacion", "click", function() {
 		var datosTabla=tabla_asignaciones.row(($(this).parent()).parent()).data();
 		var id_asignacion = $(this).attr("data-id-asignacion");
 		var id_inventario = $(this).attr("data-id-inventario");

 		var datos = {
 			funcion:'eliminarAsignacionInventarioContratista',
 			p1:{
 				'id_asignacion': id_asignacion,
 				'usuario':session
 			}
 		};

 		parent.swal({
 			confirmButtonColor: '#3f9a9d',
 			title: 'CONFIRMAR ACCIÓN',
 			html: '<small>Se va a eliminar la asignación de Inventario del contratista: <br><br>'+datosTabla[0]+'<br><strong>Desea confirmar la acción?</strong></small>',
 			type: 'warning',
 			allowOutsideClick: false,
 			allowEscapeKey: false,
 			confirmButtonText: 'SI',
 			cancelButtonText: 'NO',
 			showCancelButton: true,
 		}).then(() => {
 			$.ajax({
 				async : false,
 				url: url_ok_obj,
 				type: 'POST',
 				dataType: 'html',
 				data: datos,
 				success: function(datos)
 				{
 					if(datos == 1){
 						parent.swal("La asignación de inventario fue eliminada.", "", "success");
 						cargarHistorialAsignaciones(id_inventario);	
 					}
 					else{
 						parent.swal("La asignación de inventario no pudo ser eliminada.", "", "error");
 					}
 					
 				}
 			});
 		},() => {}).catch(parent.swal.noop);
 	});

 	$(document).delegate(".observar-traslado", "click", function() {
 		var datosTabla=tabla_traslados.row(($(this).parent()).parent()).data();
 		var id_traslado = $(this).attr("data-id-traslado");
 		var tipo_traslado = $(this).attr("data-tipo-traslado");
 		var id_inventario = $(this).attr("data-id-inventario");
 		var id_destino = $(this).attr("data-id-destino");
 		var cantidad = $(this).attr("data-cantidad");
 		var estado = $(this).attr("data-estado");
 		var observacion = $(this).attr("data-observacion");
 		if(estado == "Aprobado" || estado == "Denegado"){
 			$("#modal_observar #check-revisar").bootstrapToggle('enable');
 			if(estado == "Aprobado"){
 				$("#modal_observar #check-revisar").bootstrapToggle('on');
 			}
 			if(estado == "Denegado"){
 				$("#modal_observar #check-revisar").bootstrapToggle('off');
 			}
 			$("#TXT_OBSERVACION_TRASLADO").attr("disabled", "disabled");
 			$("#div-revision-traslado").show();
 			$("#BT_GUARDAR_REVISION").attr("disabled", "disabled");
 			$("#BT_GUARDAR_REVISION").addClass("disabled");
 			$("#modal_observar #check-revisar").bootstrapToggle('disable');	
 		}
 		else{
 			$("#TXT_OBSERVACION_TRASLADO").removeAttr("disabled");
 			$("#BT_GUARDAR_REVISION").removeAttr("disabled");
 			$("#BT_GUARDAR_REVISION").removeClass("disabled");
 			$("#modal_observar #check-revisar").bootstrapToggle('enable');	
 		}
 		if (observacion != "null") {
 			$("#modal_observar #TXT_OBSERVACION_TRASLADO").val(observacion);
 		}
 		else{
 			$("#modal_observar #TXT_OBSERVACION_TRASLADO").val("");
 		}
 		if(rol != 14){
 			$("#div-revision-traslado").hide();
 			$("#TXT_OBSERVACION_TRASLADO").attr("disabled","disabled");
 		}
 		$("#modal_observar").modal("show");
 		$("#modal_observar #check-revisar").attr("data-id-traslado",id_traslado);
 		$("#modal_observar #check-revisar").attr("data-tipo-traslado",tipo_traslado);
 		$("#modal_observar #check-revisar").attr("data-id-inventario",id_inventario);
 		$("#modal_observar #check-revisar").attr("data-id-destino",id_destino);
 		$("#modal_observar #check-revisar").attr("data-cantidad",cantidad);
 	});

 	$(document).delegate(".info-traslado", "click", function() {
 		var datosTabla=tabla_traslados.row(($(this).parent()).parent()).data();
 		var id_traslado = $(this).attr("data-id-traslado");
 		var id_inventario = $(this).attr("data-id-inventario");
 		var numero_traslado = $(this).attr("data-numero-traslado");
 		var fecha_traslado = $(this).attr("data-fecha-traslado");
 		var consecutivo_salida = $(this).attr("data-consecutivo-salida");
 		$("#modal_info_complementaria").modal("show");
 		$("#modal_info_complementaria #BT_ACTUALIZAR_INFO_COMPLEMENTARIA").attr("data-id-traslado",id_traslado);
 		$("#modal_info_complementaria #BT_ACTUALIZAR_INFO_COMPLEMENTARIA").attr("data-id-inventario",id_inventario);
 		$("#TXT_NUMERO_TRASLADO").val(numero_traslado);
 		if(fecha_traslado != "null" && fecha_traslado != "0000-00-00"){
 			$("#DT_FECHA_TRASLADO").val(fecha_traslado);
 		}
 		else{
 			$("#DT_FECHA_TRASLADO").val("Sin especificar");
 		}
 		$("#TXT_CONSECUTIVO_SALIDA").val(consecutivo_salida);
 		if(rol != 14){
 			$("#TXT_NUMERO_TRASLADO, #DT_FECHA_TRASLADO, #TXT_CONSECUTIVO_SALIDA").attr("disabled","disabled");
 			$("#TXT_NUMERO_TRASLADO, #DT_FECHA_TRASLADO, #TXT_CONSECUTIVO_SALIDA").addClass("disabled");
 			$("#BT_ACTUALIZAR_INFO_COMPLEMENTARIA").hide();
 		}
 	});

 	listarSugerenciasDescripciones();

 	$("#MODAL_TXT_DESCRIPCION").on("keydown", function () {		
 		var newY = $(this).textareaHelper('caretPos').top + (parseInt($(this).css('font-size'), 10) * 1.5);
 		var newX = $(this).textareaHelper('caretPos').left;
 		var posString = "left+" + newX + "px top+" + newY + "px";
 		$(this).autocomplete("option", "position", {
 			my: "left top",
 			at: posString
 		});
 		$( "#MODAL_TXT_DESCRIPCION" ).autocomplete({        
 			source : availableDescriptions ,
 			appendTo : $('#modal_body')
 		});
 	});

 	$("#MODAL_TXT_DESCRIPCION").autocomplete({
 		source: availableDescriptions
 	});

 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'json',
 		data: {opcion: 'listar_tipo_bien'},
 		success: function(datos)
 		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#modal-editar #MODAL_SL_TIPO_BIEN').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#modal-editar #MODAL_SL_TIPO_BIEN').selectpicker("refresh");
		}
	});

 	$("#MODAL_SL_TIPO_BIEN").on('change', function(){
 		if ($(this).val() == "46"){
 			$("#MODAL_TXT_CANTIDAD").val("1");
 			$("#MODAL_TXT_CANTIDAD").prop("readonly",true);
 		}
 		else{
 			$("#MODAL_TXT_CANTIDAD").val("");
 			$("#MODAL_TXT_CANTIDAD").prop("readonly",false);	
 		}
 	});

 	$("#BT_TRASLADO").on("click", function(){
 		$("#modal-editar").modal('hide');
 		cargarHistorialTraslados(ident);
 		$("#modal-traslados").modal('show');
 		if(rol != 14){
 			$("#check-revisar").bootstrapToggle('disable');
 			$("#BT_GUARDAR_REVISION").attr("disabled", "disabled");
 			$("#BT_GUARDAR_REVISION").addClass("disabled");
 		}
 	});

 	$("#BT_ASIGNACIONES").on("click", function(){
 		$("#modal-editar").modal('hide');
		cargarHistorialAsignaciones(ident);
		$("#modal-asignaciones").modal('show');
 	});

 	$("#TXT_CANTIDAD_TRASLADO").on('keyup', function(){
 		$("#alert-cantidad").prop('hidden', 'hidden');
 	});

 	$('#sin-fecha').on('click', function(){
 		$("#DT_FECHA_TRASLADO").val("Sin especificar");
 	});

 	function formatMoney(n, currency) {

 		var string = String(n).replace(/\$ /g, "");
 		console.log(string);
 		string = string.replace(/[^0-9^,]/g, "");
 		if (string.indexOf(",") == -1) 
 			string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
 		else
 		{
 			if (string.length != string.indexOf(",")+1) {
 				var splitstring = string.split(",");
 				string = splitstring[0].replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".")+","+splitstring[1];
 			}
 			else
 				string = string.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
 		}
 		return currency+" "+string;
	}

	function deformatMoney(text) {
		var deformated = text.replace(/\$/g, "").replace(/\ /g, "").replace(/\,/g, "").replace(/\./g, "");
		return deformated;
	}

	$(document).delegate( "input", "focus", function() {
		if ($(this).hasClass( "change-event" )){
			if(this.value.length == 0){
				this.value = "0";	
			}
			//$(this).val(deformatMoney($(this).val()));
		}
	});

	$(document).delegate( "input", "blur", function() {
		if ($(this).hasClass( "change-event" )){
			if(this.value.length == 0){
				this.value = "0";
			}
			$(this).val(formatMoney($(this).val(),"$"));
		}
	});
	
	tabla_inventario = $('#tabla-lista-inventario').DataTable({
		"processing": true,
		"bDeferRender": true,
        //"sAjaxSource": "../../Controlador/Infraestructura/Inventario/file.json",
        "responsive": true,
        "paging":   true,
        "ordering": true,
        "info":     false,
        "colReorder": true,
        "language": {
        	"lengthMenu": "Ver _MENU_ registros por pagina",
        	"zeroRecords": "No hay información para ser mostrada, Realice una consulta.",
        	"info": "Mostrando pagina _PAGE_ de _PAGES_",
        	"infoEmpty": "No hay registros disponibles",
        	"infoFiltered": "(filtered from _MAX_ total records)",
        	"search": "Filtrar"
        },
        "columnDefs": [{
        	"targets": [ 0, 1, 4, 9, 10, 11, 14, 15, 16, 17, 18],
        	"visible": false,
        	"searchable": false
        }],
        dom: 'Bfrtip',
        buttons: [
        {
        	text: 'Copiar',
        	extend: 'copyHtml5',
        	exportOptions: {
        		columns: ':visible'
        	},
        	title: 'Reporte de Inventario_'+fecha_reporte
        },
        {
        	text: 'Mostrar/Ocultar',
        	extend: 'colvis'
        },
		'excel'
        ]
    });

	tabla_observaciones = $('#modal-observaciones #tabla-observaciones').DataTable({
		"responsive": true,
		"paging":   true,
		"ordering": true,
		"info":     false,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información para mostrar, Realice una consulta.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		},
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'copyHtml5',
			text: 'Copiar',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Observaciones_'+fecha_reporte
		},
		{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Observaciones_'+fecha_reporte
		},
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Observaciones_'+fecha_reporte
		}
		]
	});

	tabla_traslados = $('#modal-traslados #tabla-traslados').DataTable({
		"responsive": true,
		"paging":   true,
		"ordering": true,
		"info":     false,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información para mostrar, Realice una consulta.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		},
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'copyHtml5',
			text: 'Copiar',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de traslados'+fecha_reporte
		},
		{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de traslados'+fecha_reporte
		},
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de traslados'+fecha_reporte
		}
		]
	});

	tabla_asignaciones = $('#modal-asignaciones #tabla-asignaciones').DataTable({
		"responsive": true,
		"paging":   true,
		"ordering": true,
		"info":     false,
		"order": [[ 3, "desc" ]],
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información para mostrar, Realice una consulta.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		},
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'copyHtml5',
			text: 'Copiar',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de asignaciones '+fecha_reporte
		},
		{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de asignaciones '+fecha_reporte
		},
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de asignaciones '+fecha_reporte
		}
		]
	});

	$("#ver-historial").on('click', function(){
		$("#agregar-observacion").hide("fast");
		$("#tabla").show("slow");
	});
	$("#ver-agregar").on('click', function(){
		$("#tabla").hide("fast");
		$("#agregar-observacion").show("slow");
	});

	$("#tabla-lista-inventario").on('click','.opciones', function () 
	{
		var datosTabla=tabla_inventario.row(($(this).parent()).parent()).data();
		ident = datosTabla[0];
		if ($(this).attr('id') === 'btn-delete')
		{
			ident = datosTabla[0];
			$('#modal-delete-teacher').find('#lb-id-teacher-modal').text(datosTabla[2]);
			$('#modal-delete-teacher').find('#lb-name-teacher-modal').text(datosTabla[3]+" "+datosTabla[4]);
			$('#modal-delete-teacher').modal('show');
		}
		if ($(this).attr('id') === 'btn-dar-baja')
		{
			ident = datosTabla[0];
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'CONFIRMAR ACCIÓN',
				html: '<small>Se va a DAR DE BAJA el siguiente elemento:<br><br><strong>'+datosTabla[2]+'</strong><br><strong>Cantidad:</strong> '+datosTabla[3]+'<br><strong>Placa:</strong> '+datosTabla[5]+'<br><strong>Elemento:</strong> '+datosTabla[6]+'<br><strong>Descripción:</strong> '+datosTabla[7]+'<br><strong>Estado:</strong> '+datosTabla[8]+'<br><strong>Valor:</strong> '+datosTabla[9]+'<br><strong>Donante:</strong> '+datosTabla[10]+'<br><br>Desea confirmar la acción?</small>',
				type: 'warning',
				allowOutsideClick: false,
				allowEscapeKey: false,
				confirmButtonText: 'SI',
				cancelButtonText: 'NO',
				showCancelButton: true,
			}).then(() => {
				datos = {
					'funcion': 'darBaja',
					'p1': ident,
					'p2': session
				};
				$.ajax({
					async : false,
					url: url_ok_obj,
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function(result)
					{
						console.log(result);
						if (result == 1) {
							parent.swal("", "El elemento fue dado de baja.", "success");
							reloadTablaInventarios();	
						}
						else{
							parent.swal("", "No se pudo dar de baja al elemento", "error");
						}
						
					}
				});
			},() => {}).catch(parent.swal.noop);
		}
		if ($(this).attr('id') === 'btn-quitar-baja')
		{
			ident = datosTabla[0];

			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'CONFIRMAR ACCIÓN',
				html: '<small>Se va a QUITAR LA BAJA del siguiente elemento:<br><br><strong>'+datosTabla[2]+'</strong><br><strong>Cantidad:</strong> '+datosTabla[3]+'<br><strong>Placa:</strong> '+datosTabla[5]+'<br><strong>Elemento:</strong> '+datosTabla[6]+'<br><strong>Descripción:</strong> '+datosTabla[7]+'<br><strong>Estado:</strong> '+datosTabla[8]+'<br><strong>Valor:</strong> '+datosTabla[9]+'<br><strong>Donante:</strong> '+datosTabla[10]+'<br><br>Desea confirmar la acción?</small>',
				type: 'warning',
				allowOutsideClick: false,
				allowEscapeKey: false,
				confirmButtonText: 'SI',
				cancelButtonText: 'NO',
				showCancelButton: true,
			}).then(() => {
				$.ajax({
					async : false,
					url: '../../Controlador/Infraestructura/Inventario/C_Quitar_Baja.php',
					type: 'POST',
					dataType: 'html',
					data: {id: ident, usuario_registro:session},
					success: function(datos)
					{
						parent.swal("", "El elemento fue reactivado, pero debe ser trasladado de BODEGA hacia el CREA correspondiente.", "success");
						reloadTablaInventarios();
					}
				});
			},() => {}).catch(parent.swal.noop);
		}
		if ($(this).attr('id') === 'btn-editar')
		{	
			ident = datosTabla[0];
			$("#modal-editar #MODAL_SL_PROYECTO").val(datosTabla[16]).selectpicker("refresh");
			$("#modal-editar #MODAL_SL_PROYECTO").selectpicker("refresh");
			$("#modal-editar #MODAL_SL_PROYECTO").trigger("change");
			setTimeout(function(){
				$("#modal-editar #MODAL_SL_LUGAR").val(datosTabla[1]).selectpicker("refresh");
				$("#modal-editar #MODAL_SL_LUGAR").selectpicker("refresh");
			},1000);
			
			$("#modal-editar #MODAL_SL_TIPO_BIEN option").filter(function() { return $(this).text() == datosTabla[4]; }).prop('selected', true);
			$("#modal-editar #MODAL_SL_TIPO_BIEN").selectpicker("refresh");
			$("#modal-editar #MODAL_TXT_CANTIDAD").val(datosTabla[3]);
			if(datosTabla[4]=="DEVOLUTIVO" || datosTabla[4]=="CONSUMO CONTROLADO"){
				$("#modal-editar #MODAL_TXT_CANTIDAD").prop("readonly",true);
			}
			else{
				$("#modal-editar #MODAL_TXT_CANTIDAD").prop("readonly",false);
			}
			//$("#modal-editar #MODAL_SL_PROCEDENCIA option").filter(function() { return $(this).text() == datosTabla[6]; }).prop('selected', true);
			$("#modal-editar #MODAL_SL_ELEMENTO option").filter(function() { return $(this).text() == datosTabla[6];}).prop('selected', true);
			$("#modal-editar #MODAL_SL_ELEMENTO").selectpicker("refresh");

			$("#modal-editar #MODAL_TXT_DESCRIPCION").val(datosTabla[7]);
			$("#modal-editar #MODAL_SL_ESTADO_BIEN option").filter(function() { return $(this).text() == datosTabla[8]; }).prop('selected', true);
			$("#modal-editar #MODAL_SL_ESTADO_BIEN").selectpicker("refresh");
			$("#modal-editar #MODAL_BT_SIN_NUMERO_TRASLADO").click();
			$("#modal-editar #MODAL_TXT_NUMERO_TRASLADO").val(datosTabla[15]);
			//$("#modal-editar #MODAL_SL_ESTADO_BIEN").removeAttr('required');*/
			$("#modal-editar #MODAL_TXT_VALOR_INICIAL").val(formatMoney(datosTabla[9].replace(/\./g, ","),"$"));
			if(datosTabla[5]=="S/P"){
				flag = 0;
			}else{
				flag = 1;
			}
			if(datosTabla[13]=="S/E"){
				flag_numero_traslado = 0;
			}else{
				flag_numero_traslado = 1;
			}
			$("#modal-editar #MODAL_BT_SIN_PLACA").click();
			$("#modal-editar #MODAL_TXT_PLACA").val(datosTabla[5]);
			
			$('#modal-editar').modal('show');
			if(datosTabla[6] == "DONACIÓN"){
				$("#modal-editar #MODAL_DIV_DONANTE").show();
				$("#modal-editar #MODAL_TXT_DONANTE").val(datosTabla[11]);
			}
			else{
				$("#modal-editar #MODAL_TXT_DONANTE").val("");
				$("#modal-editar #MODAL_DIV_DONANTE").hide();	
			}

			//Preparar modal Traslado.
			$("#MODAL_SL_TIPO_TRASLADO").val("").selectpicker("refresh");
			$("#MODAL_SL_DESTINO").val("").selectpicker("refresh");
			$("#TXT_TRASLADO").val("");
			$("#modal-traslados #cabecera-traslado").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-traslados #cabecera-traslado").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-traslados #TXT_ORIGEN").val("Origen: "+datosTabla[2]);
			$("#modal-traslados #ID_ORIGEN").val(datosTabla[1]);
			$("#modal-traslados #TXT_SOLICITANTE").val("Soliticante: "+parent.nombre_usuario.innerHTML);
			$("#modal-traslados #TXT_CANTIDAD_TRASLADO").val(datosTabla[3]);
			$("#modal-traslados #TXT_CANTIDAD_TOTAL").val("Restantes: "+datosTabla[3]);
			restantes = datosTabla[3];
			tipo_elemento = datosTabla[6];
			$("#alert-cantidad").prop('hidden', 'hidden');
			if(rol != 14){
				$("#check-revisar").bootstrapToggle('disable');
				$("#BT_GUARDAR_REVISION").attr("disabled", "disabled");
 				$("#BT_GUARDAR_REVISION").addClass("disabled");
			}

			//Preparar modal asignaciones.
			$("#modal-asignaciones #cabecera").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-asignaciones #cabecera-asignacion").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-asignaciones #TXT_OBSERVACION").val("");
			$("#modal-asignaciones #SL_Estado_Observacion").val("").selectpicker("refresh");
		}
		if($(this).attr('id') === 'btn-observaciones'){
			ident = datosTabla[0];
			$("#modal-observaciones #cabecera").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-traslados #cabecera-traslado").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-observaciones #TXT_OBSERVACION").val("");
			$("#modal-observaciones #SL_Estado_Observacion").val("").selectpicker("refresh");
			cargarHistorialObservaciones(ident);
			$("#modal-observaciones").modal('show');
		}
		if ($(this).attr('id') === 'btn-traslado')
		{	
			ident = datosTabla[0];
			$("#MODAL_SL_TIPO_TRASLADO").val("").selectpicker("refresh");
			$("#MODAL_SL_DESTINO").val("").selectpicker("refresh");
			$("#TXT_TRASLADO").val("");
			$("#modal-traslados #cabecera-traslado").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-traslados #cabecera-traslado").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-traslados #TXT_ORIGEN").val("Origen: "+datosTabla[2]);
			$("#modal-traslados #ID_ORIGEN").val(datosTabla[1]);
			$("#modal-traslados #TXT_SOLICITANTE").val("Soliticante: "+parent.nombre_usuario.innerHTML);
			$("#modal-traslados #TXT_CANTIDAD_TRASLADO").val(datosTabla[3]);
			$("#modal-traslados #TXT_CANTIDAD_TOTAL").val("Restantes: "+datosTabla[3]);
			restantes = datosTabla[3];
			tipo_elemento = datosTabla[6];
			$("#alert-cantidad").prop('hidden', 'hidden');
			if(rol != 14){
				$("#check-revisar").bootstrapToggle('disable');
				$("#BT_GUARDAR_REVISION").attr("disabled", "disabled");
 				$("#BT_GUARDAR_REVISION").addClass("disabled");
			}
			$("#modal-editar").modal('hide');
 			cargarHistorialTraslados(ident);
 			$("#modal-traslados").modal('show');
 			if(rol != 14){
	 			$("#check-revisar").bootstrapToggle('disable');
 				$("#BT_GUARDAR_REVISION").attr("disabled", "disabled");
	 			$("#BT_GUARDAR_REVISION").addClass("disabled");
 			}
		}
		if($(this).attr('id') === 'btn-asignaciones'){
			ident = datosTabla[0];
			$("#modal-editar").modal('hide');
			$("#modal-asignaciones #cabecera").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-asignaciones #cabecera-asignacion").html(datosTabla[2]+" - "+datosTabla[5]+" - "+datosTabla[7]+" - "+datosTabla[8]);
			$("#modal-asignaciones #TXT_OBSERVACION").val("");
			$("#modal-asignaciones #SL_Estado_Observacion").val("").selectpicker("refresh");
			cargarHistorialAsignaciones(ident);
			$("#modal-asignaciones").modal('show');
		}
		if($(this).attr('id') === 'btn-registro-fotografico'){
			$("#modal-editar").modal('hide');
 			cargarRegistroFotografico(ident);
	 		$("#modal-registro-fotografico").modal('show');
 		}
	});

 $('#SL_PROYECTO').html(parent.getProyectos()).selectpicker('refresh');
 $("#SL_PROYECTO").on('change', function(){
		$('#SL_LUGAR').html(parent.getParametroDetalleProyectoEstado(27, $(this).val(), 1)).selectpicker('refresh');
	});
 $('#SL_LUGAR').val(consultarIdCreaUsuario()).selectpicker("refresh");

 $('#MODAL_SL_DESTINO').html(parent.getOptionsLugarInventario());
 
 $('#MODAL_SL_PROYECTO').html(parent.getProyectos()).selectpicker('refresh');
 $("#MODAL_SL_PROYECTO").on('change', function(){
		$('#MODAL_SL_LUGAR').html(parent.getParametroDetalleProyectoEstado(27, $(this).val(), 1)).selectpicker('refresh');
	});
 //$('#MODAL_SL_LUGAR').html(parent.getOptionsLugarInventario());

 $("#MODAL_SL_TIPO_TRASLADO").on('change', function(){
 	if($(this).val() == 'Temporal'){
 		$("#MODAL_SL_DESTINO").prop('disabled', false);
 		$("#MODAL_SL_DESTINO").selectpicker('val', '');
 		$('#MODAL_SL_DESTINO').append("<option value=0>Otro</option>");
 		$("#MODAL_SL_DESTINO").selectpicker('refresh');
 	}
 	if($(this).val() == 'Baja'){
 		$("#MODAL_SL_DESTINO").selectpicker('val', 28);
 		$("#MODAL_SL_DESTINO").prop('disabled', true);
 		$("#MODAL_SL_DESTINO").selectpicker('refresh');
 		$("#TXT_OTRO_DESTINO").addClass("hidden");
 		$("#TXT_OTRO_DESTINO").prop("required", false);
 	}
 	if ($(this).val() == 'Definitivo') {
 		$("#MODAL_SL_DESTINO").prop('disabled', false);
 		$("#MODAL_SL_DESTINO").selectpicker('val', '');
 		$("#MODAL_SL_DESTINO option[value='0']").remove();
 		$("#MODAL_SL_DESTINO").selectpicker('refresh');
 	}
 });

 $("#MODAL_SL_DESTINO").on('change', function(){
 	if($(this).val() == 0){
 		$("#TXT_OTRO_DESTINO").removeClass("hidden");
 		$("#TXT_OTRO_DESTINO").prop("required", true);
 	}
 	else{
 		$("#TXT_OTRO_DESTINO").addClass("hidden");
 		$("#TXT_OTRO_DESTINO").prop("required", false);
 	}
 });

 var flag_asignacion=0;
 $("#BT_NUEVA_ASIGNACION").on('click', function(){
 	if(flag_asignacion==0)
 	{
 		$(this).html("<span class='glyphicon glyphicon-list'></span> VER HISTÓRICO");
 		$(this).removeClass("btn-success");
 		$(this).addClass("btn-warning");
 		$("#div-tabla-asignaciones").hide("slow");
 		$("#NUEVA_ASIGNACION").show("slow");
 		flag_asignacion=1;
 		return;
 	}
 	if(flag_asignacion==1)
 	{
 		$(this).html("<span class='glyphicon glyphicon-plus'></span> NUEVA ASIGNACIÓN");
 		$(this).removeClass("btn-warning");
 		$(this).addClass("btn-success");
 		$("#NUEVA_ASIGNACION").hide("slow");
 		$("#div-tabla-asignaciones").show("slow");
 		flag_asignacion=0;
 		return;
 	}
 });

 var flag_registro_fotografico=0;
 $("#BT_SUBIR_FOTOS").on('click', function(){
 	if(flag_registro_fotografico==0)
 	{
 		$(this).html("<span class='fa fa-arrow-left'></span> VOLVER");
 		$(this).addClass("btn-success");
 		$("#div-slider-registro-fotografico").hide("slow");
 		$("#div_subir_fotos").show("slow");
 		flag_registro_fotografico=1;
 		return;
 	}
 	if(flag_registro_fotografico==1)
 	{
 		$(this).html("<span class='glyphicon glyphicon-plus'></span> SUBIR REGISTRO FOTOGRÁFICO");
 		$(this).addClass("btn-success");
 		$("#div_subir_fotos").hide("slow");
 		$("#div-slider-registro-fotografico").show("slow");
 		flag_registro_fotografico=0;
 		return;
 	}
 });

 $(document).delegate('input[type=file]','change', function(e){
		prepareUpload(e,$(this).attr("name"));
});

 $.ajax({
 	async : false,
 	url: url_service_inventario,
 	type: 'POST',
 	dataType: 'json',
 	data: {opcion: 'listar_tipo_bien'},
 	success: function(datos)
 	{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#SL_TIPO_BIEN').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			
		}
	});

 $.ajax({
 	async : false,
 	url: url_service_inventario,
 	type: 'POST',
 	dataType: 'json',
 	data: {opcion: 'listar_elementos'},
 	success: function(datos)
 	{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#SL_ELEMENTO').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>").selectpicker("refresh");
			});
		}
	});
	// listarDonantes();
	$.ajax({
		async : false,
		url: url_service_inventario,
		type: 'POST',
		dataType: 'json',
		data: {opcion: 'listar_estado_bien'},
		success: function(datos)
		{
			//console.log(datos);
			$.each(datos, function(i) 
			{
				$('#SL_ESTADO_BIEN').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
				$('#SL_Estado_Observacion').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
		}
	});

	$("#SL_CONTRATISTA").html("").selectpicker("refresh");
 		
 	datos = {
 		'funcion': 'listarUsuariosActivos',
 	};
 	$.ajax({
 		async : false,
 		url: url_ok_obj,
 		type: 'POST',
 		dataType: 'json',
 		data: datos,
 		success: function(datos)
 		{
 			$.each(datos, function(i) 
 			{
 				$('#SL_CONTRATISTA').append("<option value="+datos[i].Id_Persona+">"+datos[i].Nombre+"</option>");
 			});
 			$("#SL_CONTRATISTA").selectpicker("refresh");
 		}
 	});
	//TERMINA CARGA DE LAS LISTAS DESPLEGABLES

	var hoyServidor = parent.obtenerFechaHora(false);
	var hoy = new Date(hoyServidor.getFullYear(),hoyServidor.getMonth(),hoyServidor.getDate());
	$("#TB_FECHA_RECBE").datepicker({
		defaultDate: hoy,
		format: 'yyyy-mm-dd',
		weekStart: 1,
		language: 'es',
		endDate: hoy,
		autoclose: true,
		title: 'Fecha recibe'
	});

	$('#TB_FECHA_RECBE').datepicker('setDate', 'today');

	var flag=0;
	$("#modal-editar #MODAL_BT_SIN_PLACA").click(function(){
		if(flag==0)
		{
			$("#modal-editar #MODAL_TXT_PLACA").val("S/P");
			$("#modal-editar #MODAL_TXT_PLACA").prop('readonly', true);
			$(this).removeClass("btn-success");
			$(this).addClass("btn-danger");
			flag=1;
			return;
		}
		if(flag==1)
		{
			$("#modal-editar #MODAL_TXT_PLACA").prop('readonly', false);
			$("#modal-editar #MODAL_TXT_PLACA").val("");
			$(this).removeClass("btn-danger");
			$(this).addClass("btn-success");
			flag=0;
			return;
		}
	});

	var flag_numero_traslado=0;
	$("#modal-editar #MODAL_BT_SIN_NUMERO_TRASLADO").click(function(){
		if(flag_numero_traslado==0)
		{
			$('#MODAL_TXT_NUMERO_TRASLADO').val("S/E");
			$('#MODAL_TXT_NUMERO_TRASLADO').prop('readonly', true);
			$(this).removeClass("btn-success");
			$(this).addClass("btn-danger");
			flag_numero_traslado=1;
			return;
		}
		if(flag_numero_traslado==1)
		{
			$('#MODAL_TXT_NUMERO_TRASLADO').prop('readonly', false);
			$('#MODAL_TXT_NUMERO_TRASLADO').val("");
			$(this).removeClass("btn-danger");
			$(this).addClass("btn-success");
			flag_numero_traslado=0;
			return;
		}
	});

	var bandera=0;
	$("#BT_SIN_PLACA").click(function(){
		if(bandera==0)
		{
			$("#TXT_PLACA").val("S/P");
			$("#TXT_PLACA").prop('readonly', true);
			$(this).removeClass("btn-success");
			$(this).addClass("btn-danger	");
			bandera=1;
			return;
		}
		if(bandera==1)
		{
			$("#TXT_PLACA").prop('readonly', false);
			$("#TXT_PLACA").val("");
			$(this).removeClass("btn-danger");
			$(this).addClass("btn-success");
			bandera=0;
			return;
		}
	});

	$('#modal-editar MODAL_BT_LIMPIAR').on('click', function(){
		$('#modal-editar MODAL_TXT_PLACA').prop('readonly', false);
		// tabla_inventario = $('#tabla-lista-inventario').DataTable();
		tabla_inventario.clear().draw();
	});
	$('#BT_LIMPIAR').on('click', function(){
		$("#FORM_CONSULTA_INVENTARIO")[0].reset();
		$('#SL_LUGAR').val("");
		$('#SL_LUGAR').trigger('change.abs.preserveSelected');
		$('#SL_LUGAR').selectpicker('refresh');
		$('#SL_ELEMENTO').val("");
		$('#SL_ELEMENTO').trigger('change.abs.preserveSelected');
		$('#SL_ELEMENTO').selectpicker('refresh');
		$('#SL_TIPO_ELEMENTO').val("");
		$('#SL_TIPO_ELEMENTO').trigger('change.abs.preserveSelected');
		$('#SL_TIPO_ELEMENTO').selectpicker('refresh');

		$('#TXT_PLACA').prop('readonly', false);
		$("#BT_SIN_PLACA").removeClass("btn-danger");
		$("#BT_SIN_PLACA").addClass("btn-success");
		flag=0;
		// tabla_inventario = $('#tabla-lista-inventario').DataTable();
		tabla_inventario.clear().draw();
	});

	tabla_traslados.on( 'draw', function () { 
		$('#check-revisar').bootstrapToggle({ 
			on: 'SÍ', 
			off: 'NO', 
			onstyle: 'success', 
			offstyle: 'danger' 
		}); 
	}); 

	$("#FM-REVISAR").on( "submit", function(e) {
		e.preventDefault();
		var toggle = $("#check-revisar").data('bs.toggle');
		var id_traslado = $("#check-revisar").attr("data-id-traslado");
		var tipo_traslado = $("#check-revisar").attr("data-tipo-traslado");
		var id_inventario = $("#check-revisar").attr("data-id-inventario");
		var id_destino = $("#check-revisar").attr("data-id-destino");
		var cantidad = $("#check-revisar").attr("data-cantidad");
		var observacion = $("#TXT_OBSERVACION_TRASLADO").val();
		var estado = "";
		var id_inventario_destino="";
		if($("#check-revisar").prop("checked"))
		{	
			estado = 1;
			var mensaje_confirmacion = "";
			var accion = "";
			var type = "";
			if(tipo_traslado == "Definitivo" || tipo_traslado == "Baja"){
				if (tipo_elemento == "OTRO(S)") {
					var coincidencias = consultarCoincidenciasTraslado(id_inventario, id_destino);
					if (coincidencias == 0 && cantidad != restantes) {
						mensaje_confirmacion = "No se encontraron coincidencias en el DESTINO, el traslado se realizará creando un nuevo elemento.<br><strong>Desea aprobar el traslado Definitivo?</strong>";
						accion = "crea_nuevo_elemento";
						type = "warning";
					}
					if (coincidencias == 0 && cantidad == restantes) {
						mensaje_confirmacion = "No se encontrarón coincidencias.<br>Se actualizará el LUGAR de este elemento ya que el traslado incluye todas las unidades existentes.<br><strong>Desea aprobar el traslado Definitivo?</strong>";
						accion = "actualiza_crea";
						type = "warning";
					}
					if (coincidencias == 1) {
						mensaje_confirmacion = "Se encontró una coincidencia, se unificará este traslado al elemento idéntico en el DESTINO.<br><strong>Desea aprobar el traslado Definitivo?</strong>";
						accion = "fusiona_elementos";
						type = "warning";
					}
					if (coincidencias > 1) {
						mensaje_confirmacion = "No se pudo realizar el Traslado.<br> Se encontró más de una coincidencia en el DESTINO, porfavor unifique los elementos para poder efectuar el traslado.";
						accion = "ninguna";
						type = "error";
					}
				}
				else{
					if(cantidad == 1){
						mensaje_confirmacion ="<strong>Desea aprobar el traslado Definitivo?</strong>";
						accion = "actualiza_crea";
						type = "warning";
					}
					else{
						mensaje_confirmacion ="Parece que este es un bien Devolutivo y su cantidad es mayor a 1. <br>No es posible trasladar un elemento con estás características.<br>";
						accion = "ninguna";
						type = "error";
					}
				}
			}
			if (tipo_traslado == "Temporal") {
				mensaje_confirmacion ="<strong>Desea aprobar el traslado temporal?</strong>";
				accion = "actualizar_observacion";
				type = "warning";
			}
		}
		else
		{
			estado = 0;
			mensaje_confirmacion = "Confirma que desea denegar este traslado?";
			accion = "actualizar_observacion";
			type = "warning";
		}

		if(accion != "ninguna"){
			parent.swal({
				confirmButtonColor: '#3f9a9d', title: 'CONFIRMAR ACCIÓN', html: '<small>'+mensaje_confirmacion+'</small>',	type: type, allowOutsideClick: false, allowEscapeKey: false, confirmButtonText: 'SI', cancelButtonText: 'NO', showCancelButton: true,
			}).then(() => {
				actualizarEstadoTraslado(tipo_traslado, id_traslado, estado, id_inventario, id_destino, cantidad, observacion, restantes, session, accion);
				$("#modal_observar").modal('hide');
				cargarHistorialTraslados(id_inventario);
			},() => {toggle.off(true);}).catch(parent.swal.noop);
		}
		if(accion == "ninguna"){
			parent.swal("",mensaje_confirmacion,type);
		}

	});

	$("#FM-INFO_COMPLEMENTARIA").on( "submit", function(e) {
		e.preventDefault();
		var id_traslado = $("#BT_ACTUALIZAR_INFO_COMPLEMENTARIA").attr("data-id-traslado");
		var id_inventario = $("#BT_ACTUALIZAR_INFO_COMPLEMENTARIA").attr("data-id-inventario");
		var numero_traslado = $("#TXT_NUMERO_TRASLADO").val();
		var fecha_traslado = $("#DT_FECHA_TRASLADO").val();
		var consecutivo_salida = $("#TXT_CONSECUTIVO_SALIDA").val();

		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'CONFIRMAR ACCIÓN',
			html: '<small>Confirma que desea registrar la Información del traslado?</small>',
			type: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			confirmButtonText: 'SI',
			cancelButtonText: 'NO',
			showCancelButton: true,
		}).then(() => {
			actualizarInfoComplementariaTraslado(id_traslado,numero_traslado,fecha_traslado,consecutivo_salida,session);
			cargarHistorialTraslados(id_inventario);
		},() => {toggle.off(true);}).catch(parent.swal.noop);

	});

	$('#FORM_CONSULTA_INVENTARIO').on('submit', function(e){
		e.preventDefault();
		parent.mostrarCargando();
		if ($('#CHECKBOX_TIPO_CONSULTA').prop("checked") == true){
			placa = $('#TXT_PLACA').val();
			id_lugar = $('#SL_LUGAR').val();
			id_lugar = id_lugar.join();
			id_elemento = "";
			descripcion = "";
			id_tipo_elemento = "";
			id_tipo_bien = "";
			estado_baja = "";
		}else{
			placa = "NULL";
			id_lugar = $('#SL_LUGAR').val();
			id_lugar = id_lugar.join();
			id_elemento = $('#SL_ELEMENTO').val();
			id_elemento = id_elemento.join();
			id_tipo_bien = $('#SL_TIPO_BIEN').val();
			estado_baja = $('#SL_ESTADO_BAJA').val();
			descripcion = $('#TX_DESCRIPCION').val();
		}
		// tabla_inventario = $('#tabla-lista-inventario').DataTable();
		tabla_inventario.clear().draw();
		var datos = {
			funcion: 'consultarInventario',
			p1:{
				'vc_placa': placa || "NULL",
				'fk_id_clan':id_lugar || "NULL",
				'fk_id_elemento':id_elemento || "NULL",
				'vc_descripcion':descripcion || "NULL",
				'fk_id_tipo_bien':id_tipo_bien || "NULL",
				'in_estado_baja':estado_baja || -1
			},
			p2: "consultarInventario"
		};

		setTimeout(function(){
			$.ajax({
				url: url_ok_obj,
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(datos)
				{
					tabla_inventario.clear().draw();
					tabla_inventario.rows.add($(datos)).draw();

					evaluarOpciones(id_lugar);		
					parent.cerrarCargando();
				},
				async : true
			});
		},500);
	});

	$("#BT_CONTROL_INVENTARIO").on("click", function(){
		if($("#SL_LUGAR option:selected").length == 0 || $("#SL_LUGAR option:selected").length > 1){
			parent.swal("","Por favor seleccione un CREA","warning");
		}
		else{
			parent.mostrarCargando();
			datos = {
				'funcion': 'crearExcelConsultaInventario',
				'p1': $("#SL_LUGAR option:selected").text(),
				'p2': $("#SL_LUGAR option:selected").val()
			};
			$.ajax({
				async : true,
				url: url_ok_obj,
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(datos)
				{
					console.log(datos);
					if (datos != false) {
						$('#a_download').attr("href", '../../src/Infraestructura/Controlador/'+datos);
						document.getElementById('a_download').click();
						parent.cerrarCargando();
					}else{
						parent.cerrarCargando();
						parent.swal("Algo resultó mal...","Vuelve a intentarlo en un momento.","error");
					}
				}
			});
		}
	});

	$('#FM_ACTUALIZAR_INVENTARIO').on('submit', function(e){
		e.preventDefault();
		var placa = [];
		placa[0] = $('#MODAL_TXT_PLACA').val();
		var sl_lugar = document.getElementById("MODAL_SL_LUGAR");
		var cantidad = $("#MODAL_TXT_CANTIDAD").val();
		var sl_tipo_bien = document.getElementById("MODAL_SL_TIPO_BIEN");
		var sl_elemento = document.getElementById("MODAL_SL_ELEMENTO");
		var donante = $("#MODAL_TXT_DONANTE").val();
		var descripcion = $("#MODAL_TXT_DESCRIPCION").val();
		var sl_estado = document.getElementById("MODAL_SL_ESTADO_BIEN");
		var numero_traslado = $("#MODAL_TXT_NUMERO_TRASLADO").val();
		var bandera_placa = "0";

		var valor = $("#MODAL_TXT_VALOR_INICIAL").val();
		if (valor == "" ) {
			valor = " - - -";
		}

		if (donante == "" ) {
			donante = " - - -";
		}

		var datos = {
			'funcion': 'validarPlaca',
			p1:{
				'placa' : placa,
				'id' : ident
			}
		}

		$.ajax({
			async : false,
			url: url_ok_obj,
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(datos)
			{
				if (Object.keys(datos).length > 0) {
					parent.swal("La placa "+placa+" ya existe", "Digite una distinta.", "warning");
					bandera_placa = 1;
				}else{
					bandera_placa = 0;
				}
			}
		});

		if(bandera_placa == 0){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'CONFIRMAR ACCIÓN',

				html: '<small>Actualizar Elemento del <span style=color:rgb(166,0,17)>'+sl_lugar.options[sl_lugar.selectedIndex].text+'?</span>'+'<br><br><span style=color:rgb(166,0,17)>Cantidad:</span>'+cantidad+'<br><span style=color:rgb(166,0,17)>Placa:</span>'+placa+'<br><span style=color:rgb(166,0,17)>Elemento:</span>'+sl_elemento.options[sl_elemento.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Donante:</span>'+donante+'<br><span style=color:rgb(166,0,17)>Tipo Bien:</span>'+sl_tipo_bien.options[sl_tipo_bien.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Descripción:</span>'+descripcion+'<br><span style=color:rgb(166,0,17)>Estado:</span>'+sl_estado.options[sl_estado.selectedIndex].text+'<br><span style=color:rgb(166,0,17)>Número de Traslado:</span>'+numero_traslado+'<br><span style=color:rgb(166,0,17)>Valor Unitario Inicial:</span>'+valor+'</small>',
				type: 'warning',
				allowOutsideClick: false,
				allowEscapeKey: false,
				confirmButtonText: 'SI',
				cancelButtonText: 'NO',
				showCancelButton: true,
			}).then(() => {
				var myform = $('#FM_ACTUALIZAR_INVENTARIO');
				var disabled = myform.find(':input:disabled').removeAttr('disabled');
				var formulario = parent.getFormData(myform);
				disabled.attr('disabled','disabled');
				formulario["id"] = ident;
				formulario["usuario_registro"] = session;
				var datos = {
					'funcion': 'actualizarInventario',
					p1:formulario
				};
				$.ajax({
					async : true,
					url: url_ok_obj,
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function(data)
					{
						if (data == 1){
							$("#modal-editar").modal('hide');
							parent.swal("Actualizado Exitosamente!", "", "success");
							listarDonantes();
							reloadTablaInventarios();
						}
						else{
							parent.swal("No se pudo actualizar el elemento", "Porfavor intente de nuevo.", "error");
							$("#modal-editar").modal('hide');												
						}
						listarSugerenciasDescripciones();
					}
				});
			},() => {}).catch(parent.swal.noop);
		}
	});

	$("#FM-OBSERVACION").on('submit', function(e){
		e.preventDefault();
		var observacion = $("#TXT_OBSERVACION").val();
		var estado = $("#SL_Estado_Observacion").val();

		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'CONFIRMAR ACCIÓN',
			html: '<small>Confirma que desea agregar la siquiente Observación?<strong><br>Elemento: </strong>'+$("#cabecera").html()+'<br><br><strong>Nueva Observación: </strong>'+observacion+'<br><strong>Nuevo Estado: </strong>'+$('#SL_Estado_Observacion :selected').text()+'</small>',
			type: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			confirmButtonText: 'SI',
			cancelButtonText: 'NO',
			showCancelButton: true,
		}).then(() => {
			$.ajax({
				async : false,
				url: url_service_inventario,
				type: 'POST',
				dataType: 'html',
				data: {id: ident, observacion:observacion,  estado:estado, usuario_registro:session,opcion:'guardar_observacion'},
				success: function(datos)
				{
					var notificacion = { 
						vc_url:"Infraestructura/ConsultarInventario.php",
						vc_icon:"fa fa-list-alt",
						vc_contenido:"Se ha registrado la siguiente observación: '"+observacion+"' y el estado: '"+$("#SL_Estado_Observacion :selected").text()+"' al Bien: "+$("#cabecera").html()
					}
					window.parent.sendNotificationRole(notificacion,'14');
					parent.swal("", "La observación fue registrada exitosamente.", "success");
					$("#modal-observaciones").modal("hide");
				}
			});
		},() => {}).catch(parent.swal.noop);
	});

	$("#FM-TRASLADO").on('submit', function(e){
		e.preventDefault();
		if(parseInt($("#TXT_CANTIDAD_TRASLADO").val()) > parseInt(restantes)) {
			$("#alert-cantidad").prop("hidden", "");
		}
		else{
			var tipo = $("#MODAL_SL_TIPO_TRASLADO").val();
			var origen = $("#ID_ORIGEN").val();
			var destino = $("#MODAL_SL_DESTINO option:selected").val();
			if($("#MODAL_SL_DESTINO").val() == 0){
				destino = $("#TXT_OTRO_DESTINO").val();
			}
			var argumento = $("#TXT_TRASLADO").val();
			var cantidad_traslado = $("#TXT_CANTIDAD_TRASLADO").val();

			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'CONFIRMAR ACCIÓN',
				html: '<small>Confirma que desea solicitar el traslado de este bien?</small>',
				type: 'warning',
				allowOutsideClick: false,
				allowEscapeKey: false,
				confirmButtonText: 'SI',
				cancelButtonText: 'NO',
				showCancelButton: true,
			}).then(() => {
				datos = {
					'funcion': 'crearSolicitudDeTraslado',
					p1: {
						'id': ident,
						'tipo': tipo,
						'origen': origen,
						'destino': destino,
						'argumento': argumento,
						'cantidad': cantidad_traslado,
						'usuario': session
					}
				};
				$.ajax({
					async : false,
					url: url_ok_obj,
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function(result)
					{
						console.log(result);
						if(result == 1){
							var notificacion = { 
								vc_url:"Infraestructura/ConsultarInventario.php",
								vc_icon:"fa fa-list-alt", 
								vc_contenido:"Solicitud de traslado del Bien: "+$("#cabecera-traslado").html()
							}
							window.parent.sendNotificationRole(notificacion,'14');
							parent.swal("", "Su solicitud ha sido enviada y estará sujeta a revisión para ser aprobada.", "success");
							$("#MODAL_SL_TIPO_TRASLADO").val("").selectpicker("refresh");
							$("#MODAL_SL_DESTINO").val("").selectpicker("refresh");
							$("#TXT_TRASLADO").val("");
							$("#TXT_CANTIDAD_TRASLADO").val(restantes);
							cargarHistorialTraslados(ident);
							$("#ver-historial-traslados").click();
						}
						else{
							parent.swal("Algo salió mal", "La solicitud no pudo ser enviada.", "error");
						}
					}
				});
			},() => {}).catch(parent.swal.noop);
		}	
	});

	$('#tabla-lista-inventario').on('click', 'td:first-child', function () {
		if(rol != 14){
			$(".editar, .dar-baja, .quitar-baja").hide();
		}
	});

	$(".readonly").on('keydown paste', function(e){
		e.preventDefault();
	});

	$("#FM_ASIGNAR_INVENTARIO").on('submit', function(e){
		e.preventDefault();
		var contratista = $("#SL_CONTRATISTA option:selected").text();
		var id_contratista = $("#SL_CONTRATISTA option:selected").val();
		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'CONFIRMAR ACCIÓN',
			html: '<small>Confirma que desea ASIGNAR el elemento al contratista <br><b>'+contratista+'</b>?</small>',
			type: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			confirmButtonText: 'SI',
			cancelButtonText: 'NO',
			showCancelButton: true,
		}).then(() => {
			datos = {
				'funcion': 'asignarInventarioContratista',
				p1: {
					'id_contratista': id_contratista,
					'id_inventario': ident,
					'fecha_recibe': $("#TB_FECHA_RECBE").val(),
					'usuario': session
				}
			};
			$.ajax({
				async : false,
				url: url_ok_obj,
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(result)
				{
					console.log(result);
					if(result == 1){
						var notificacion = {
							VC_Url:"",
							VC_Icon:"fa fa-list-alt",
							VC_Contenido:"Se le ha asignado el BIEN: "+$("#cabecera-asignacion").html(),
							userId:id_contratista
						}
						window.parent.sendNotificationUser(notificacion);
						parent.swal("", "El bien ha sido asignado a "+contratista, "success");
						$("#SL_CONTRATISTA").val("").selectpicker("refresh");
						
						cargarHistorialAsignaciones(ident);
						$("#BT_NUEVA_ASIGNACION").click();
					}
					else{
						parent.swal("Algo salió mal", "El bien no pudo ser asignado a "+contratista, "error");
					}
				}
			});
		},() => {}).catch(parent.swal.noop);	
	});

    $("#FM_REGISTRO_FOTOGRAFICO").on('submit', function(e){
        e.preventDefault();
        var files = $("#REGISTRO_FOTOGRAFICO_1")[0].files;
        if(files.length == 0){
            parent.mostrarAlerta("warning","Debe seleccionar un archivo","");
        }
        else{
             var datos = new FormData();
             
             $.each(files, function(key, value)
             {
                 datos.append("archivo_"+(key+1), value);
             });
        
             datos.append("funcion", 'updateRegistroFotografico');
             datos.append("p1", ident);
             datos.append("p3", session);
             parent.swal({
                 confirmButtonColor: '#3f9a9d',
                 title: 'CONFIRMAR ACCIÓN',
                 html: '<small>¿Confirma que desea guardar el registro fotográfico? <br><b>Nota</b>: Se reemplazará el registro fotográfico existente de este elemento.</small>',
                 type: 'warning',
                 allowOutsideClick: false,
                 allowEscapeKey: false,
                 confirmButtonText: 'SI',
                 cancelButtonText: 'NO',
                 showCancelButton: true,
             }).then(() => {
                 $.ajax({
                     async : false,
                     url: url_ok_obj,
                     type: 'POST',
                     dataType: 'html',
                     processData: false,
                     contentType:false,
                     data: datos,
                     success: function(result)
                     {
                         /*console.log(result);*/
                         if(result == 1){
                             parent.swal("", "Se ha guardado el registro fotográfico","success");
                             /*cargarHistorialAsignaciones(ident);*/
                             document.getElementById('div_archivos_adjuntos').innerHTML = '<br>';
                             newp = document.createElement('h4');
                             newp.innerHTML = "Se subirán los siguientes elementos:";
                             document.getElementById('div_archivos_adjuntos').appendChild(newp);
                             $("#REGISTRO_FOTOGRAFICO_1").filestyle('clear');
                             cargarRegistroFotografico(ident);
                             $("#BT_SUBIR_FOTOS").trigger('click');
                         }
                         else{
                             parent.swal("Algo salió mal", "El registro fotográfico no pudo ser guardado.", "error");
                         }
                     }
                 });
             },() => {}).catch(parent.swal.noop);
        }
    });

});

// PREPARE UPLOAD DE ARCHIVOS
// Grab the files and set them to our variable
function prepareUpload(event, name)
{
	files = event.target.files;
	document.getElementById('div_archivos_adjuntos').innerHTML = '<br>';
	newh = document.createElement('h4');
	newh.innerHTML = "Se subirán los siguientes elementos:";
    document.getElementById('div_archivos_adjuntos').appendChild(newh);
	files_size = 0;
	$.each(files, function(index, value) {
		files_size += files[index]["size"];
		newp = document.createElement('p');
		newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm; color:white !important;';
		newp.innerHTML= files[index]["name"];
        document.getElementById('div_archivos_adjuntos').appendChild(newp);
	});
	if(files_size > 20500000){
        document.getElementById('div_archivos_adjuntos').innerHTML = '<br>';
        newp = document.createElement('h4');
        newp.innerHTML = "Se subirán los siguientes elementos:";
		document.getElementById('div_archivos_adjuntos').appendChild(newp);
		parent.mostrarAlerta("warning","Tamaño excedido", "El tamaño máximo por elemento es 20MB");
		$("#REGISTRO_FOTOGRAFICO_1").filestyle('clear');
	}
}

 function cargarHistorialObservaciones(ident){
 	tabla_observaciones.clear().draw();
 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'json',
 		data: {id_inventario: ident, opcion:'historial_observaciones'},
 		success: function(datos)
 		{
					//console.log(datos);
					$.each(datos, function(i) 
					{
						tabla_observaciones.row.add( [
							datos[i].VC_Observacion,
							datos[i].Estado,
							datos[i].DA_Fecha,
							datos[i].nombre,
							"<a type='button' class='btn btn-danger eliminar-observacion' data-id-observacion='"+datos[i].PK_Id_Control_Inventario+"' data-id-inventario='"+ident+"' title='Eliminar'><i class='fa fa-times'></i></a>"
							]).draw();
						$('[data-toggle="tooltip"]').tooltip(
						{
							"animation": 1
						});
					});
					
				}
			});
 }

 function cargarHistorialTraslados(ident){
 	tabla_traslados.clear().draw();
 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'json',
 		data: {id_inventario: ident, opcion:'historial_traslados'},
 		success: function(datos)
 		{
 			$.each(datos, function(i) 
 			{
 				if(datos[i].IN_Estado == 1 || datos[i].IN_Estado == 0){
 					tabla_traslados.row.add( [
 						datos[i].VC_Tipo_Traslado,
 						datos[i].Origen,
 						datos[i].Destino,
 						datos[i].Cantidad,
 						datos[i].TX_Argumento,
 						datos[i].DA_Fecha_Solicitud,
 						datos[i].Solicitante,
 						datos[i].Estado,
 						datos[i].Fecha_Revision,
 						datos[i].Usuario_Revisa,
 						"<a type='button' class='btn btn-sm btn-danger eliminar-traslado disabled' data-id-traslado='"+datos[i].PK_Id_Traslado+"' data-id-inventario='"+ident+"' title='Eliminar' disabled><i class='fa fa-times'></i></a> <a type='button' class='btn btn-sm btn-primary observar-traslado' data-id-traslado='"+datos[i].PK_Id_Traslado+"' data-tipo-traslado='"+datos[i].VC_Tipo_Traslado+"' data-id-inventario='"+ident+"' data-id-destino='"+datos[i].FK_Destino+"' data-cantidad='"+datos[i].Cantidad+"' data-estado='"+datos[i].Estado+"' data-observacion='"+datos[i].TX_Observacion+"' title='Observación'>Observación <i class='fa fa-search'></i></a> <a type='button' class='btn btn-sm btn-info info-traslado' data-id-traslado='"+datos[i].PK_Id_Traslado+"' data-id-inventario='"+ident+"' data-numero-traslado='"+datos[i].TX_Numero_Traslado+"' data-fecha-traslado='"+datos[i].DA_Fecha_Traslado+"' data-consecutivo-salida='"+datos[i].TX_Consecutivo_Salida+"' title='Info Traslado'><i class='fa fa-edit'></i></a>"
 						]).draw();
 				}
 				else{
 					tabla_traslados.row.add( [
 						datos[i].VC_Tipo_Traslado,
 						datos[i].Origen,
 						datos[i].Destino,
 						datos[i].Cantidad,
 						datos[i].TX_Argumento,
 						datos[i].DA_Fecha_Solicitud,
 						datos[i].Solicitante,
 						datos[i].Estado,
 						datos[i].Fecha_Revision,
 						datos[i].Usuario_Revisa,
 						"<a type='button' class='btn btn-sm btn-danger eliminar-traslado' data-id-traslado='"+datos[i].PK_Id_Traslado+"' data-id-inventario='"+ident+"' title='Eliminar'><i class='fa fa-times'></i></a> <a type='button' class='btn btn-sm btn-primary observar-traslado' data-id-traslado='"+datos[i].PK_Id_Traslado+"' data-tipo-traslado='"+datos[i].VC_Tipo_Traslado+"' data-id-inventario='"+ident+"' data-id-destino='"+datos[i].FK_Destino+"' data-cantidad='"+datos[i].Cantidad+"' data-estado='Sin revisar' data-observacion='"+datos[i].TX_Observacion+"' title='Observación'>Observación <i class='fa fa-search'></i></a> <a type='button' class='btn btn-sm btn-info info-traslado' data-id-traslado='"+datos[i].PK_Id_Traslado+"' data-id-inventario='"+ident+"' data-numero-traslado='"+datos[i].TX_Numero_Traslado+"' data-fecha-traslado='"+datos[i].DA_Fecha_Traslado+"' data-consecutivo-salida='"+datos[i].TX_Consecutivo_Salida+"' title='Info Traslado'><i class='fa fa-edit'></i></a>"
 						]).draw();
 				}
 				$('[data-toggle="tooltip"]').tooltip(
 				{
 					"animation": 1
 				});
 			});
 			if(rol != 14){
 				$("#div-revision-traslado").hide();
 				$("#TXT_OBSERVACION_TRASLADO").attr("disabled","disabled");
 			}
 			else{
 				$("#div-revision-traslado").show();
 				$("#TXT_OBSERVACION_TRASLADO").removeAttr("disabled");		
 			}
 		}
 	});
 }

 function cargarHistorialAsignaciones(ident){
 	tabla_asignaciones.clear().draw();
 	var datos = {
 		funcion: 'consultarHistorialAsignacionesBien',
 		p1:{
 			'id_inventario': ident
 		}
 	};
 	$.ajax({
 		async : false,
 		url: url_ok_obj,
 		type: 'POST',
 		dataType: 'json',
 		data: datos,
 		success: function(datos)
 		{
 			$.each(datos, function(i) 
 			{

 				if(datos[i].DA_Fecha_Entrega != null){
 					tabla_asignaciones.row.add( [
 						datos[i].Contratista,
 						datos[i].DA_Fecha_Recibe,
 						datos[i].DA_Fecha_Entrega,
 						datos[i].DT_Fecha,
 						datos[i].Usuario,
 						"<a type='button' class='btn btn-sm btn-danger eliminar-asignacion disabled' data-id-asignacion='"+datos[i].PK_Id_Tabla+"' data-id-inventario='"+datos[i].FK_Id_Inventario+"' title='Eliminar' disabled><i class='fa fa-times'></i></a>"
 						]).draw();
 				}
 				else{
 					tabla_asignaciones.row.add( [
 						datos[i].Contratista,
 						datos[i].DA_Fecha_Recibe,
 						datos[i].DA_Fecha_Entrega,
 						datos[i].DT_Fecha,
 						datos[i].Usuario,
 						"<a type='button' class='btn btn-sm btn-danger eliminar-asignacion' data-id-asignacion='"+datos[i].PK_Id_Tabla+"' data-id-inventario='"+datos[i].FK_Id_Inventario+"' title='Eliminar'><i class='fa fa-times'></i></a>"
 						]).draw();
 				}

 				$('[data-toggle="tooltip"]').tooltip(
 				{
 					"animation": 1
 				});
 			});
 		}
 	});
 }

 function cargarRegistroFotografico(ident){
    var datos = {
        'funcion': 'getRegistroFotografico',
        p1: ident
    }
    $.ajax({
        async : false,
        url: url_ok_obj,
        type: 'POST',
        dataType: 'html',
        data: datos,
        success: function(datos)
        {
            $("#div-slider-registro-fotografico").html(datos);
        }
    });
 }

 function listarDonantes(){
 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'json',
 		data: {opcion: 'listar_donantes'},
 		success: function(datos)
 		{
 			$.each(datos, function(i) 
 			{
 				$('#modal_donantes').append("<option value=\""+datos[i].VC_Donante+"\">");
 			});
 		}
 	});
 }

 function listarSugerenciasDescripciones(){
 	availableDescriptions = [''];
 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'json',
 		data: {opcion:'listar_descripciones'},
 		success: function(datos)
 		{
 			$.each(datos, function(i) 
 			{
 				availableDescriptions.push(datos[i].VC_Descripcion);
 			});

 		}
 	});
 }

 function reloadTablaInventarios(){
 	parent.mostrarCargando();
 	if ($('#CHECKBOX_TIPO_CONSULTA').prop("checked") == true){
 		placa = $('#TXT_PLACA').val();
 		id_lugar = $('#SL_LUGAR').val();
 		id_lugar = id_lugar.join();
 		id_elemento = "";
 		descripcion = "";
 		id_tipo_elemento = "";
 		id_tipo_bien = "";
 		estado_baja = "";
 	}else{
 		placa = "NULL";
 		id_lugar = $('#SL_LUGAR').val();
 		id_lugar = id_lugar.join();
 		id_elemento = $('#SL_ELEMENTO').val();
 		id_elemento = id_elemento.join();
 		id_tipo_bien = $('#SL_TIPO_BIEN').val();
 		estado_baja = $('#SL_ESTADO_BAJA').val();
 		descripcion = $('#TX_DESCRIPCION').val();
 	}

 	// tabla_inventario = $('#tabla-lista-inventario').DataTable();
 	tabla_inventario.clear().draw();

 	var datos = {
 		funcion: 'consultarInventario',
 		p1:{
 			'vc_placa': placa || "NULL",
 			'fk_id_clan':id_lugar || "NULL",
 			'fk_id_elemento':id_elemento || "NULL",
 			'vc_descripcion':descripcion || "NULL",
 			'fk_id_tipo_bien':id_tipo_bien || "NULL",
 			'in_estado_baja':estado_baja || -1
 		},
 		p2: "consultarInventario"
 	};

 	$.ajax({
 		url: url_ok_obj,
 		type: 'POST',
 		dataType: 'html',
 		data: datos,
 		success: function(datos)
 		{
 			tabla_inventario.rows.add($(datos)).draw(); 			
 			evaluarOpciones(id_lugar);		
 			parent.cerrarCargando();
 		},
 		async : true
 	});
 }

 function consultarCoincidenciasTraslado(id_inventario, id_destino){
 	var resultado = "";
 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'html',
 		data: {id_inventario:id_inventario, id_destino:id_destino, opcion:'consultarCoincidenciasTraslado'},
 		success: function(result)
 		{
 			resultado = result;
 		}
 	});
 	return resultado;
 }

 function actualizarEstadoTraslado(tipo_traslado, id_traslado, estado, id_inventario, id_destino, cantidad, observacion, restantes, usuario, accion){
 	if(accion != "ninguna"){
 		$.ajax({
 			async : false,
 			url: url_service_inventario,
 			type: 'POST',
 			dataType: 'html',
 			data: {tipo_traslado, id_traslado: id_traslado, estado:estado, id_inventario:id_inventario, id_destino:id_destino, cantidad:cantidad, observacion:observacion, restantes:restantes, usuario:usuario, accion:accion, opcion:'efectuar_Traslado'},
 			success: function(result)
 			{
 				if(estado == 1){
 					if (result == 1 && tipo_traslado=='Definitivo'){
 						parent.swal("Se efectuó el traslado.", "", "success");
 						$("#BT_LIMPIAR").click();
 						$("#modal-traslados").modal('hide');
 					}
 					else{
 						if (result == 1 && tipo_traslado=='Baja'){
 							parent.swal("Se efectuó la BAJA.", "", "success");
 							$("#BT_LIMPIAR").click();
 							$("#modal-traslados").modal('hide');
 						}else{
 							parent.swal("Algo salió mal", "No se pudo efectuar la acción.", "error");
 						}
 					}
 				}
 				else{
 					if (result == 1) {
 						parent.swal("Se denegó el traslado.", "", "success");
 						cargarHistorialTraslados(id_inventario);
 					}
 				}
 				
 			}
 		});
 	}
 }

 function actualizarInfoComplementariaTraslado(id_traslado,numero_traslado,fecha_traslado,consecutivo_salida,session){
 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'html',
 		data: {id_traslado: id_traslado, numero_traslado:numero_traslado, fecha_traslado:fecha_traslado, consecutivo_salida:consecutivo_salida, usuario:session, opcion:'actualizar_info_complementaria_traslado'},
 		success: function(datos)
 		{
 			parent.swal("Se actualizó la información del traslado.", "", "success");
 			$("#modal_info_complementaria").modal("hide");
 		}
 	});
 }

 function consultarIdCreaUsuario(){
 	var crea_id = "";
 	$.ajax({
 		async : false,
 		url: url_service_inventario,
 		type: 'POST',
 		dataType: 'html',
 		data: {usuario:session, opcion:'consultar_crea_usuario'},
 		success: function(datos)
 		{
 			crea_id = datos;
 		}
 	});
 	return crea_id;
 }

 function evaluarOpciones(id_lugar){
 	if(consultarIdCreaUsuario() == 0){
 		if (rol != 14) {
 			$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones, .registro-fotografico").hide();
 			// tabla_inventario.column(12).visible(false);
 		}
 	}
 	else{
 		if(id_lugar != consultarIdCreaUsuario()){
 			$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones, .registro-fotografico").hide();
 			// tabla_inventario.column(12).visible(false);
 		}
 		else{
 			// tabla_inventario.column(12).visible(true);
 			$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones, .registro-fotografico").show();
 			$(".editar, .dar-baja, .quitar-baja").hide();
 		}
 	}

 	$('#tabla-lista-inventario').on( 'draw.dt', function () {
 		if(consultarIdCreaUsuario() == 0){
 			if (rol != 14) {
 				$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones, .registro-fotografico").hide();
 				// tabla_inventario.column(12).visible(false);
 			}
 		}
 		else{
 			if(id_lugar != consultarIdCreaUsuario()){
 				$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones, .registro-fotografico").hide();
 				// tabla_inventario.column(12).visible(false);
 			}
 			else{
 				// tabla_inventario.column(12).visible(true);
 				$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones, .registro-fotografico").show();
 				$(".editar, .dar-baja, .quitar-baja").hide();
 			}
 		}
 	});	
 }