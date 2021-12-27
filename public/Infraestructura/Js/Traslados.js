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
 var id_crea = "";
 var id_elemento = "";
 var descripcion = "";
 var id_tipo_elemento = "";
 var id_tipo_bien = "";
 var estado_baja = "";
 var seleccionados = {};
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
		}
	});
 	
 	$("#SL_CREA").on('change',function(){
 		var lugares_origen = [];
        $("#SL_CREA option:selected").each(function (){
            lugares_origen.push(this.text);
        });
        $("#TXT_ORIGEN").val("Origen: "+lugares_origen);
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

 	$("#BT_SELECCIONADOS").on('click', function(){
 		$("#tabla-items-seleccionados tbody").html('');
 		Object.keys(seleccionados).forEach(function(key) {
 			console.log(key, seleccionados[key]);
 			$("#tabla-items-seleccionados").append("<tr><td>"+seleccionados[key].placa+"</td><td>"+seleccionados[key].elemento+"</td>"+"<td>"+seleccionados[key].tipo_bien+"</td>"+"<td>"+seleccionados[key].descripcion+"</td>"+"<td>"+seleccionados[key].cantidad+"</td>"+"<td>"+seleccionados[key].estado+"</td></tr>");
 		});
 		// var lugares_origen = $("#SL_CREA").text();
 		// lugares_origen = lugares_origen.join();
 		// $("#TXT_ORIGEN").val("Origen: "+lugares_origen);
 		$("#TXT_SOLICITANTE").val("Solicitante: "+$("#nombre_usuario", parent.document).text());
 		$("#modal-seleccionados").modal("show");
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
		}
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
        	"targets": [ 0, 1, 4, 9, 10, 11, 14, 15],
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
        }
        ],
        "drawCallback": function( settings ) {
        	$('.seleccionar').bootstrapToggle({
        		on: 'SÍ',
        		off: 'NO',
        		onstyle: 'success',
        		offstyle: 'danger'
        	});
        }
    });
 	$('#tabla-lista-inventario').on( 'page.dt', function () {
 		
 	});

 	$('#SL_CREA').html(parent.getOptionsLugarInventario());
 	$('#SL_CREA').val(consultarIdCreaUsuario()).selectpicker("refresh");

 	$('#MODAL_SL_DESTINO').html(parent.getOptionsLugarInventario());
 	$('#MODAL_SL_CREA').html(parent.getOptionsLugarInventario());

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
			$('#SL_TIPO_BIEN').selectpicker("refresh");
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
				$('#SL_ELEMENTO').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#SL_ELEMENTO').selectpicker("refresh");
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
				$('#SL_TIPO_ELEMENTO').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
			$('#SL_TIPO_ELEMENTO').selectpicker("refresh");
		}
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
				$('#SL_ESTADO_BIEN').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
				$('#SL_Estado_Observacion').append("<option value="+datos[i].FK_Value+">"+datos[i].VC_Descripcion+"</option>");
			});
		}
	});

 	$(document).delegate(".seleccionar", "change", function(){
 		// if($(this).prop("checked")){
 		// 	seleccionados.push(
 		// 		{id: $(this).data('id_inventario'), name: "Douglas Adams", type: "comedy"}
 		// 		);
 		// 	seleccionados.push("id"=>$(this).data('id_inventario'));
 		// }
 		// else{
 		// 	seleccionados.splice( $.inArray($(this).data('id_inventario'), seleccionados),1);
 		// }
 		// $("#cantidad_seleccionados").html(seleccionados.length);
 		// var animation_name = 'animated heartBeat';
 		// var animation_end = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
 		// $("#cantidad_seleccionados").addClass(animation_name).one(animation_end, function(){ 
 		// 	$(this).removeClass(animation_name);
 		// });
 	});

 	$("#tabla-lista-inventario").on('click','.opciones', function () 
 	{
 		var datosTabla=tabla_inventario.row($(this).parent()).data();
 		// alert(datosTabla);
 		if ($(this).attr('id') === 'btn-seleccionar')
 		{	
 			ident = datosTabla[0];
 			if(!($(this).find(".seleccionar").prop("checked"))){
 				seleccionados[ident] = {
 					id_origen: datosTabla[2],
 					placa: datosTabla[5],
 					elemento: datosTabla[6],
 					tipo_bien: datosTabla[4],
 					descripcion: datosTabla[7],
 					cantidad: datosTabla[3],
 					estado: datosTabla[8]
 				};
 			}
 			else{
 				delete seleccionados[ident];
 			}
 			$("#cantidad_seleccionados").html(Object.keys(seleccionados).length);
 			var animation_name = 'animated heartBeat';
 			var animation_end = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
 			$("#cantidad_seleccionados").addClass(animation_name).one(animation_end, function(){ 
 				$(this).removeClass(animation_name);
 			});
 			console.log(seleccionados);
 		}
 	});

 	$('#FORM_CONSULTA_INVENTARIO').on('submit', function(e){
 		e.preventDefault();
 		$("#modal_enviando").modal("show");
 		parent.mostrarCargando();
 		if ($('#CHECKBOX_TIPO_CONSULTA').prop("checked") == true){
 			placa = $('#TXT_PLACA').val();
 			id_crea = $('#SL_CREA').val();
 			id_crea = id_crea.join();
 			id_elemento = "";
 			descripcion = "";
 			id_tipo_elemento = "";
 			id_tipo_bien = "";
 			estado_baja = "";
 		}else{
 			placa = "NULL";
 			id_crea = $('#SL_CREA').val();
 			id_crea = id_crea.join();
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
				'fk_id_clan':id_crea || "NULL",
				'fk_id_elemento':id_elemento || "NULL",
				'vc_descripcion':descripcion || "NULL",
				'fk_id_tipo_bien':id_tipo_bien || "NULL",
				'in_estado_baja':estado_baja || -1
			},
			p2: "traslados"
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
					evaluarOpciones(id_crea);
					$('.seleccionar').bootstrapToggle({
						on: 'SÍ',
						off: 'NO',
						onstyle: 'success',
						offstyle: 'danger'
					});
					parent.cerrarCargando();
				},
				async : true
			});
		},500);
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
 });

 function reloadTablaInventarios(){
 	$("#modal_enviando").modal("show");
 	if ($('#CHECKBOX_TIPO_CONSULTA').prop("checked") == true){
 		placa = $('#TXT_PLACA').val();
 		id_crea = $('#SL_CREA').val();
 		id_crea = id_crea.join();
 		id_elemento = "";
 		descripcion = "";
 		id_tipo_elemento = "";
 		id_tipo_bien = "";
 		estado_baja = "";
 	}else{
 		placa = "NULL";
 		id_crea = $('#SL_CREA').val();
 		id_crea = id_crea.join();
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
 			'fk_id_clan':id_crea || "NULL",
 			'fk_id_elemento':id_elemento || "NULL",
 			'vc_descripcion':descripcion || "NULL",
 			'fk_id_tipo_bien':id_tipo_bien || "NULL",
 			'in_estado_baja':estado_baja || -1
 		}
 	};

 	$.ajax({
 		url: url_ok_obj,
 		type: 'POST',
 		dataType: 'html',
 		data: datos,
 		success: function(datos)
 		{
 			tabla_inventario.rows.add($(datos)).draw(); 			
 			evaluarOpciones(id_crea);		
 			$("#modal_enviando").modal("hide");
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

 function evaluarOpciones(id_crea){
 	if(consultarIdCreaUsuario() == 0){
 		if (rol != 14) {
 			$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones").hide();
 			// tabla_inventario.column(12).visible(false);
 		}
 	}
 	else{
 		if(id_crea != consultarIdCreaUsuario()){
 			$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones").hide();
 			// tabla_inventario.column(12).visible(false);
 		}
 		else{
 			// tabla_inventario.column(12).visible(true);
 			$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones").show();
 			$(".editar, .dar-baja, .quitar-baja").hide();
 		}
 	}

 	$('#tabla-lista-inventario').on( 'draw.dt', function () {
 		if(consultarIdCreaUsuario() == 0){
 			if (rol != 14) {
 				$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones").hide();
 				// tabla_inventario.column(12).visible(false);
 			}
 		}
 		else{
 			if(id_crea != consultarIdCreaUsuario()){
 				$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones").hide();
 				// tabla_inventario.column(12).visible(false);
 			}
 			else{
 				// tabla_inventario.column(12).visible(true);
 				$(".editar, .dar-baja, .quitar-baja, .traslado, .observaciones, .asignaciones").show();
 				$(".editar, .dar-baja, .quitar-baja").hide();
 			}
 		}
 	});	
 }