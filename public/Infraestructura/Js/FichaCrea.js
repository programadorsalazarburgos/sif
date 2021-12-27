var session = "";
var rol = "";
var tipo_archivo = "";
var tabla_archivos = "";
var tabla_espacios = "";
var contador_auxiliares_operativos = 0;
var seccion = "";
var url_service = '../../src/Administracion/Controlador/AparienciaController.php'; 
var url_service_inventario = '../../Controlador/Infraestructura/Inventario/C_Inventario.php';
var url_service_infraestructura = '../../src/Infraestructura/Controlador/InfraestructuraController.php';
$(document).ready(function(){
	//ALIMENTA LAS LISTAS DESPLEGABLES
	$("#SL_CREA").change(function(){
		$("#div_jumbotron").hide();
		cargaInformacionCrea($("#SL_CREA").val());
		if(rol != 3 && rol != 4 && rol != 6 && rol != 8 && rol != 10 && rol != 14 && rol != 17 && rol != 18 && rol != 21){
			$(".span-edit").prop('hidden','hidden');
		}
		$("#botones-"+seccion).prop('hidden','hidden');
	});

	$("body").delegate("#BT_REGISTRO_FOTOGRAFICO,#BT_EDITAR_FOTOGRAFIAS","click",function(){
		tipo_archivo = 'REGISTRO_FOTOGRAFICO';
		cargaTablaArchivosCrea($("#SL_CREA").val(),tipo_archivo);
		$("#modal-titulo").html('REGISTRO FOTOGRÁFICO');
		$("#modal_archivos").modal("show");
	});

	$("body").delegate("#BT_PLANOS_ARQUITECTONICOS","click",function(){
		tipo_archivo = 'PLANOS_ARQUITECTONICOS';
		cargaTablaArchivosCrea($("#SL_CREA").val(),tipo_archivo);
		$("#modal-titulo").html('PLANOS ARQUITECTÓNICOS');
		$("#modal_archivos").modal("show");
	});

	$("body").delegate("#BT_ARRENDAMIENTOS","click",function(){
		tipo_archivo = 'ARRENDAMIENTOS';
		cargaTablaArchivosCrea($("#SL_CREA").val(),tipo_archivo);
		$("#modal-titulo").html('ARRENDAMIENTOS');
		$("#modal_archivos").modal("show");
	});
	
	$("body").delegate("#BT_TERRITORIAL","click",function(){
		tipo_archivo = 'TERRITORIAL';
		cargaTablaArchivosCrea($("#SL_CREA").val(),tipo_archivo);
		$("#modal-titulo").html('TERRITORIAL');
		$("#modal_archivos").modal("show");
	});

	$("body").delegate("#BT_ESPACIOS","click",function(){
		cargarTablaSalones($("#SL_CREA").val());
		$("#modal_espacios").modal("show");
	});
	$("body").delegate(".span-areas-artisticas","click",function(){
		// cargarTablaSalones($("#SL_CREA").val());
		$("#modal_areas_artisticas").modal("show");
	});

	$("body").delegate(".eliminar-archivo","click",function(){
		var datos={
			'function':'deleteArchivoCrea',
			'id_crea':$("#SL_CREA").val(),
			'id_archivo': $(this).attr('data-id-archivo'),
			'nombre_archivo': $(this).attr('data-nombre-archivo'),
			'tipo_archivo': $(this).attr('data-tipo-archivo'),
			'usuario': session
		}
		var tipo_archivo = $(this).attr('data-tipo-archivo');
		alertify.confirm('Confirmar Acción', 'Desea eliminar el archivo '+$(this).attr('data-nombre-archivo')+'?', 
			function(){
				$.ajax({
					async : false,
					url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function()
					{
						cargaTablaArchivosCrea($("#SL_CREA").val(),tipo_archivo);
						recargarCarouselFotografico($("#SL_CREA").val());
					}
				});
			}, 
			function(){});
	});

	$("body").delegate(".a-eliminar-espacio","click",function(){
		var datos={
			'function':'deleteEspacioCrea',
			'id_espacio':$(this).attr('data-id-espacio'),
		}

		parent.swal({
			title: "Confirmar Acción",
			text: "Desea eliminar el espacio "+$(this).attr('data-nombre-espacio')+"?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Si, Estoy seguro!',
			cancelButtonText: "No, cancelar!",
		}).then((result) => {
			if (result) {
				var datos={
					funcion:'eliminarEspacioCREA',
					p1:{
						'id_espacio':$(this).attr('data-id-espacio'),
						'usuario': session
					}
				};
				$.ajax({
					url: url_service_infraestructura,
					type : 'POST',
					dataType : 'html',
					data: datos,
					success : function(res) {
						if(res==1){
							parent.swal("Eliminado", "", "success");
							cargarTablaSalones($("#SL_CREA").val());
						}
						else {
							if(res == 2){
								parent.swal("No se pudo eliminar pero se INACTIVÓ.", "Existen sesiones asociadas a este espacio.", "error");
								cargarTablaSalones($(this).attr('data-id-espacio'));
							}
							else{
								parent.swal("No pudo ser eliminado", "Algo salió mal", "error");
							}
						}	
					},
					error : function(xhr, status) {
						swal('','error','error');
					}
				});
			}
		});
	});

	$("#FORM_ESPACIOS").submit(function(e){
		e.preventDefault();
		
		parent.swal({
			title: "Confirmar Acción",
			text: "Desea guardar el espacio "+$("#TX_NOMBRE_ESPACIO").val()+"?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Si, Estoy seguro!',
			cancelButtonText: "No, cancelar!",
		}).then((result) => {
			if (result) {
				var datos={
					funcion:'guardarEspacioCREA',
					p1:{
						'id_crea':$("#SL_CREA").val(),
						'nombre_espacio': $("#TX_NOMBRE_ESPACIO").val(),
						'nivel': $("#SL_NIVEL").val(),
						'usuario': session
					}
				};
				$.ajax({
					url: url_service_infraestructura,
					type : 'POST',
					dataType : 'html',
					data: datos,
					success : function(res) {
						if(res==1){
							parent.swal("Guardado", "", "success");
							cargarTablaSalones($("#SL_CREA").val());
							$("#FORM_ESPACIOS")[0].reset();
						}
						else{
							parent.swal("No se pudo guardar", "Algo salió mal", "error");
						}
					},
					error : function(xhr, status) {
						swal('','error','error');
					}
				});
			}
		});
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

	$('#SL_CREA').html(parent.getOptionsClanes());
	$('#SL_CREA').val(consultarIdCreaUsuario()).selectpicker("refresh");
	if(consultarIdCreaUsuario()!= 0){	
		$('#SL_CREA').trigger("change");
	}
	tabla_archivos = $('#tabla-archivos').DataTable({
		"responsive": true,
		"paging":   true,
		"ordering": true,
		"info":     false,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información para mostrar, Realize una consulta.",
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
			title: 'Reporte de Archivos'
		},
		{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Archivos'
		},
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Archivos'
		}
		]
	});

	tabla_espacios = $('#tabla-espacios').DataTable({
		"responsive": true,
		"paging":   true,
		"ordering": true,
		"info":     false,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información para mostrar, Realize una consulta.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		},
		columnDefs: [
		{
			"targets": [ 0, 1 ],
			"visible": false,
			"searchable": false
		}],
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'copyHtml5',
			text: 'Copiar',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Espacios'
		},
		{
			extend: 'excelHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Espacios'
		},
		{
			extend: 'pdfHtml5',
			exportOptions: {
				columns: ':visible'
			},
			title: 'Reporte de Espacios'
		}
		]
	});

	$(document).delegate('.a-edit','click', function(){
		seccion = $(this).attr('data-seccion');
		$("."+seccion).toggleClass('input-edit');
		ro   = $("."+seccion).prop('readonly'); //Valor actual del Read Only.
		$("."+seccion).prop('readonly', !ro);

		if(ro === undefined){
			$("#botones-"+seccion).removeAttr('hidden');
			if(seccion=='asistentes-administrativos'){
				$('.div-sl-administrativos').removeAttr('hidden');
				$('.div-asistentes-administrativos').prop('hidden','hidden');
				listarAsistentesAdministrativos();
			}
			if(seccion=='auxiliares-operativos'){
				$('.div-sl-auxiliares').removeAttr('hidden');
				$('.div-auxiliares-operativos').prop('hidden','hidden');
				listarAuxiliaresOperativos();
			}
		}else{
			if(ro){
				$("#botones-"+seccion).removeAttr('hidden');
				if(seccion=='info-general'){
					$('#span-sl-administrador').removeAttr('hidden');
					$('#span-tx-administrador').prop('hidden','hidden');
					$('#span-sl-localidades').removeAttr('hidden');
					$('#span-tx-localidad').prop('hidden','hidden');
					$('#span-sl-zonas').removeAttr('hidden');
					$('#span-tx-zona').prop('hidden','hidden');
					listarCoordinadoresCrea();
					listarLocalidades();
					listarZonas();
				}
				if(seccion=='asistentes-administrativos'){
					$('.div-sl-administrativos').removeAttr('hidden');
					$('.div-asistentes-administrativos').prop('hidden','hidden');
					listarAsistentesAdministrativos();
				}
				if(seccion=='auxiliares-operativos'){
					$('.div-sl-auxiliares').removeAttr('hidden');
					$('.div-auxiliares-operativos').prop('hidden','hidden');
					listarAuxiliaresOperativos();
				}
			}else{
			// $("#save-"+seccion).prop('hidden','hidden');
			$("#botones-"+seccion).prop('hidden','hidden');
			if(seccion=='info-general'){
				$('#span-sl-administrador').prop('hidden','hidden');
				$('#span-tx-administrador').removeAttr('hidden');
				$('#span-sl-localidades').prop('hidden','hidden');
				$('#span-tx-localidad').removeAttr('hidden');
				$('#span-sl-zonas').prop('hidden','hidden');
				$('#span-tx-zona').removeAttr('hidden');
			}
			if(seccion=='asistentes-administrativos'){
				$('.div-sl-administrativos').prop('hidden','hidden');
				$('.div-asistentes-administrativos').removeAttr('hidden');
			}
			if(seccion=='auxiliares-operativos'){
				$('.div-sl-auxiliares').prop('hidden','hidden');
				$('.div-auxiliares-operativos').removeAttr('hidden');
			}
		}
	}
});

	$(document).delegate('.a-save','click', function(){
		var seccion = $(this).attr('data-seccion');
		var formulario = $("#fm-"+seccion).serializeArray();
		var funcion = "";
		switch(seccion){
			case 'info-general':
			funcion = "updateFichaCreaInfoGeneral";
			break;
			case 'asistentes-administrativos':
			funcion = "updateFichaCreaAsistentesAdministrativos";
			formulario.push({
				name:'fk_asistentes_administrativos',
				value:$("#SL_ASISTENTES_ADMINISTRATIVOS").val().join()
			});
			break;
			case 'emergencias':
			funcion = "updateFichaCreaEmergencias";
			break;
			case 'auxiliares-operativos':
			funcion = "updateFichaCreaAuxiliaresOperativos";
			formulario.push({
				name:'fk_auxiliares_operativos',
				value:$("#SL_AUXILIARES_OPERATIVOS").val().join()
			});
			break;
		}
		//console.log(JSON.stringify(formulario));
		formulario.push({
			name:'id_crea',
			value:$("#SL_CREA").val()
		},{
			"name": "usuario",
			"value": session
		},
		{
			"name": "function",
			"value": funcion
		}
		);
		bootbox.confirm({
			message: "Confirma que Desea Continuar?",
			buttons: {
				confirm: {
					label: 'Guardar',
					className: 'btn-success'
				},
				cancel: {
					label: 'Cancelar',
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				if(result==true){
					$.ajax({
						url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
						type: 'POST',
						data: formulario,
						success: function(data)
						{
							alertify.alert("Realizado");
							$("."+seccion).toggleClass('input-edit');
							$("."+seccion).prop('readonly', true);
							$("#botones-"+seccion).prop('hidden','hidden');
							if(seccion=='info-general'){
								$('#span-sl-administrador').prop('hidden','hidden');
								$('#span-tx-administrador').removeAttr('hidden');
								$('#span-sl-localidades').prop('hidden','hidden');
								$('#span-tx-localidad').removeAttr('hidden');
								$('#span-sl-zonas').prop('hidden','hidden');
								$('#span-tx-zona').removeAttr('hidden');
								$('#TX_ADMINISTRADOR').val($('#SL_ADMINISTRADOR option:selected').text());
								$('#TX_LOCALIDAD').val($('#SL_LOCALIDAD option:selected').text());
								$('#TX_ZONA').val($('#SL_ZONA option:selected').text());
								$("#TX_FK_Coordinador_Crea").val($('#SL_ADMINISTRADOR option:selected').val());
								$("#TX_FK_Localidad").val($('#SL_LOCALIDAD option:selected').val());
								$("#TX_FK_Zona").val($('#SL_ZONA option:selected').val());
								$("#botones-emergencias").prop('hidden','hidden');
								$("#botones-auxiliares-operativos").prop('hidden','hidden');
								$("#botones-asistentes-administrativos").prop('hidden','hidden');
							}
							if(seccion=='asistentes-administrativos'){
								$('.div-sl-administrativos').prop('hidden','hidden');
								$('.div-asistentes-administrativos').removeAttr('hidden');
								$("#TX_FK_Asistentes_Administrativos").val($('#SL_ASISTENTES_ADMINISTRATIVOS').val().join());
								$("#SL_CREA").change();
								$("#botones-info-general").prop('hidden','hidden');
								$("#botones-emergencias").prop('hidden','hidden');
								$("#botones-auxiliares-operativos").prop('hidden','hidden');
							}
							if(seccion=='auxiliares-operativos'){
								$('.div-sl-auxiliares').prop('hidden','hidden');
								$('.div-auxiliares-operativos').removeAttr('hidden');
								$("#TX_FK_Auxiliares_Operativos").val($('#SL_AUXILIARES_OPERATIVOS').val().join());
								$("#SL_CREA").change();
								$("#botones-info-general").prop('hidden','hidden');
								$("#botones-emergencias").prop('hidden','hidden');
								$("#botones-asistentes-administrativos").prop('hidden','hidden');
							}
						}
					});
				}
				else{

				}
			}
		});
	});

	$("#FORM_ARCHIVOS").on('submit', function(e){
		e.preventDefault();
		identificacion_estudiante = $("#TB_Identificacion").val();
		if(($("#archivos_crea"))[0].files.length > 20){
			alert("Se permiten MÁXIMO 20 fotografías por envío.");
		}
		else{
			var combinedSize = 0;
			for(var i=0;i<($("#archivos_crea"))[0].files.length;i++) {
				combinedSize += (($("#archivos_crea"))[0].files[i].size);
			}
			if(combinedSize>20971520){
				alert("El tamaño de los archivos a enviar excede el limite establecido: 30 Megabytes.");
			}
			else{
				bootbox.confirm({
					message: "Confirma que Desea Continuar?",
					buttons: {
						confirm: {
							label: 'Subir',
							className: 'btn-success'
						},
						cancel: {
							label: 'Cancelar',
							className: 'btn-danger'
						}
					},
					callback: function (result) {
						if(result==true){
							if(($("#archivos_crea"))[0].files.length > 0){
								uploadFiles(e,tipo_archivo);
							}
							$("#FORM_ARCHIVOS")[0].reset();
							$("archivos_adjuntos").html="";
							document.getElementById('archivos_adjuntos').innerHTML = "";
							newp = document.createElement('p');
							newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
							newp.innerHTML= "<strong>Estos son TODOS los archivos que se van a enviar:</strong><p>No ha seleccionado ninguno...</p>";
							document.getElementById('archivos_adjuntos').appendChild(newp); 
						}   
						else{

						}
					}
				});
			}
		}
	});//FIN FORM SUBMIT

	$('input[type=file]').on('change', prepareUpload);

// PREPARE UPLOAD DE ARCHIVOS
// Grab the files and set them to our variable
function prepareUpload(event)
{
	files = event.target.files;
	document.getElementById('archivos_adjuntos').innerHTML = "";
	newp = document.createElement('p');
	newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
	newp.innerHTML= "<strong>Estos son los archivos que se van a enviar:</strong>";
	document.getElementById('archivos_adjuntos').appendChild(newp);
	$.each(files, function(index, value) {
		newp = document.createElement('p');
		newp.style.cssText = 'font-size:14px; padding:0cm 0cm 0cm 0cm; margin:0cm 0cm 0cm;';
		newp.innerHTML= files[index]["name"];
		document.getElementById('archivos_adjuntos').appendChild(newp);
			//console.log(files[index]["name"]);
		});
}

function uploadFiles(event,tipo_archivo)
{
		event.stopPropagation(); // Stop stuff happening
		event.preventDefault(); // Totally stop stuff happening

		// START A LOADING SPINNER HERE

		// Create a formdata object and add the files
		var data = new FormData();
		$.each(files, function(key, value)
		{
			data.append(key, value);
		});

		data.append("function", 'subirArchivosCrea');
		data.append("id_crea", $("#SL_CREA").val());
		data.append("tipo_archivo", tipo_archivo);
		data.append("usuario", session);

		$.ajax({
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php?files',
			type: 'POST',
			data: data,
			cache: false,
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			beforeSend: function(){
				parent.mostrarCargando();
			},
			success: function(data)
			{
				parent.cerrarCargando();
				//$("#modal_fotografias").modal('hide');
				cargaTablaArchivosCrea($("#SL_CREA").val(),tipo_archivo);
				recargarCarouselFotografico($("#SL_CREA").val());
			}
		});//FIN AJAX SUBIR DOCUMENTOS ESTUDIANTE.
	}//FIN FUNCION UPLOADFILES HABILITANTES

	function cargaInformacionCrea(id_crea){
		if ($("#SL_CREA").val() == ""){
			$("#div_ficha_crea").hide();    
		}else{
			$("#div_ficha_crea").hide();    
			$("#div_ficha_crea").show("slow");
			var datos={
				'function':'getInfoGeneral',
				'id_crea':$("#SL_CREA").val()
			}
			$.ajax({
				async : false,
				url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(ficha)
				{
					$('#div_informacion_general').html('');
					$('#div_informacion_general').append(ficha);
				}
			});
			
			var datos={
				'function':'getInfoAsistentes',
				'id_crea':$("#SL_CREA").val()
			}
			$.ajax({
				async : false,
				url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(asistentes)
				{
					$('#div_asistentes_administrativos').html('');
					$('#div_asistentes_administrativos').append(asistentes);
				}
			});

			var datos={
				'function':'getInfoAuxiliaresOperativos',
				'id_crea':$("#SL_CREA").val()
			}
			$.ajax({
				async : false,
				url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(auxiliares)
				{
					$('#div_auxiliares_operativos').html('');
					$('#div_auxiliares_operativos').append(auxiliares);
				}
			});

			var datos={
				'function':'getInfoComplementaria',
				'id_crea':$("#SL_CREA").val()
			}
			$.ajax({
				async : false,
				url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(emergencias)
				{
					$('#div_general').html('');
					$('#div_general').append(emergencias);
				}
			});

			var datos={
				'function':'getCarouselFotograficoCrea',
				'id_crea':$("#SL_CREA").val(),
				'tipo_archivo':'REGISTRO_FOTOGRAFICO'
			}
			$.ajax({
				async : false,
				url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(registro_fotografico)
				{
					$('#div_carousel').html('');
					$('#div_carousel').append(registro_fotografico);
				}
			});

			contador_auxiliares_operativos = $("#TX_CONTADOR_AUXILIARES").val();
			contador_auxiliares_operativos++;
			$("#crear_fila").on('click', function(){
				var newdiv = document.createElement('div');
				newdiv.id = "div_aux_"+contador_auxiliares_operativos;
				newdiv.className = "col-sm-12 col-md-12 col-lg-12 div-content";
				newdiv.innerHTML = "<div class='col-sm-6 col-md-6 col-lg-6'><input id='TX_NOMBRE_AUXILIAR_OPERATIVO_"+contador_auxiliares_operativos+"' name='TX_NOMBRE_AUXILIAR_OPERATIVO_"+contador_auxiliares_operativos+"' type='text' class='form-control auxiliares-operativos'></div><div class='col-sm-6 col-md-6 col-lg-6'>Celular: <label><input id='TX_CELULAR_AUXILIAR_OPERATIVO_"+contador_auxiliares_operativos+"' name='TX_CELULAR_AUXILIAR_OPERATIVO_"+contador_auxiliares_operativos+"' type='text' class='form-control auxiliares-operativos'></div>";
				document.getElementById('contenedor_auxiliares_operativos').appendChild(newdiv);
				contador_auxiliares_operativos++;
			});
			$("#eliminar_fila").on('click', function(){
				if (contador_auxiliares_operativos>2) {
					contador_auxiliares_operativos--;
					$('#div_aux_'+contador_auxiliares_operativos).remove();
				};
			});

			
			var datos = {
				funcion : 'getEstadisticasCREAAreasArtisticas',
				p1: (new Date()).getFullYear(),
				p2: $("#SL_CREA").val()
			};
			$.ajax({
				url: url_service,
				type: 'POST',
				data: datos,
				dataType: 'json',
				success: function(data){ 
					try{
						var DANZA_AE =0;
						var MUSICA_AE =0;
						var ARTES_PLASTICAS_AE =0;
						var LITERATURA_AE =0;
						var TEATRO_AE =0;
						var AUDIOVISUALES_AE =0;
						var ARTES_ELECTRONICAS_AE =0;

						var DANZA_EC =0;
						var MUSICA_EC =0;
						var ARTES_PLASTICAS_EC =0;
						var LITERATURA_EC =0;
						var TEATRO_EC =0;
						var AUDIOVISUALES_EC =0;
						var ARTES_ELECTRONICAS_EC =0;

						var DANZA_LC =0;
						var MUSICA_LC =0;
						var ARTES_PLASTICAS_LC =0;
						var LITERATURA_LC =0;
						var TEATRO_LC =0;
						var AUDIOVISUALES_LC =0;
						var ARTES_ELECTRONICAS_LC =0;

						$.each(data, function(i) 
						{
							if(data[i].LINEA=='AE'){
								DANZA_AE += (data[i].TIPO=="DANZA") ? parseInt(data[i].TALLERES):0;
								MUSICA_AE += (data[i].TIPO=="MÚSICA") ? parseInt(data[i].TALLERES):0;
								ARTES_PLASTICAS_AE += (data[i].TIPO=="ARTES PLÁSTICAS") ? parseInt(data[i].TALLERES):0;
								LITERATURA_AE += (data[i].TIPO=="LITERATURA") ? parseInt(data[i].TALLERES):0;
								TEATRO_AE += (data[i].TIPO=="TEATRO") ? parseInt(data[i].TALLERES):0;
								AUDIOVISUALES_AE += (data[i].TIPO=="AUDIOVISUALES") ? parseInt(data[i].TALLERES):0;
								ARTES_ELECTRONICAS_AE += (data[i].TIPO=="ARTES ELECTRÓNICAS") ? parseInt(data[i].TALLERES):0;
							}

							if(data[i].LINEA=='EC'){
								DANZA_EC += (data[i].TIPO=="DANZA") ? parseInt(data[i].TALLERES):0;
								MUSICA_EC += (data[i].TIPO=="MÚSICA") ? parseInt(data[i].TALLERES):0;
								ARTES_PLASTICAS_EC += (data[i].TIPO=="ARTES PLÁSTICAS") ? parseInt(data[i].TALLERES):0;
								LITERATURA_EC += (data[i].TIPO=="LITERATURA") ? parseInt(data[i].TALLERES):0;
								TEATRO_EC += (data[i].TIPO=="TEATRO") ? parseInt(data[i].TALLERES):0;
								AUDIOVISUALES_EC += (data[i].TIPO=="AUDIOVISUALES") ? parseInt(data[i].TALLERES):0;
								ARTES_ELECTRONICAS_EC += (data[i].TIPO=="ARTES ELECTRÓNICAS") ? parseInt(data[i].TALLERES):0;
							}

							if(data[i].LINEA=='LC'){
								DANZA_LC += (data[i].TIPO=="DANZA") ? parseInt(data[i].TALLERES):0;
								MUSICA_LC += (data[i].TIPO=="MÚSICA") ? parseInt(data[i].TALLERES):0;
								ARTES_PLASTICAS_LC += (data[i].TIPO=="ARTES PLÁSTICAS") ? parseInt(data[i].TALLERES):0;
								LITERATURA_LC += (data[i].TIPO=="LITERATURA") ? parseInt(data[i].TALLERES):0;
								TEATRO_LC += (data[i].TIPO=="TEATRO") ? parseInt(data[i].TALLERES):0;
								AUDIOVISUALES_LC += (data[i].TIPO=="AUDIOVISUALES") ? parseInt(data[i].TALLERES):0;
								ARTES_ELECTRONICAS_LC += (data[i].TIPO=="ARTES ELECTRÓNICAS") ? parseInt(data[i].TALLERES):0;
							}
						});

						var chart = AmCharts.makeChart("chartdiv_areas_artisticas", {
							"type": "serial",
							"theme": "none",
							"legend": {
								"autoMargins": false,
								"borderAlpha": 0.2,
								"equalWidths": false,
								"horizontalGap": 10,
								"markerSize": 10,
								"useGraphSettings": true,
								"valueAlign": "left",
								"valueWidth": 0
							},
							"dataProvider": [{
								"linea": "ARTE EN LA ESCUELA",
								"DANZA": DANZA_AE,
								"MUSICA": MUSICA_AE,
								"ARTES PLASTICAS": ARTES_PLASTICAS_AE,
								"LITERATURA": LITERATURA_AE,
								"TEATRO": TEATRO_AE,
								"AUDIOVISUALES": AUDIOVISUALES_AE,
								"ARTES ELECTRÓNICAS": ARTES_ELECTRONICAS_AE
							}, {
								"linea": "EMPRENDE CREA",
								"DANZA": DANZA_EC,
								"MUSICA": MUSICA_EC,
								"ARTES PLASTICAS": ARTES_PLASTICAS_EC,
								"LITERATURA": LITERATURA_EC,
								"TEATRO": TEATRO_EC,
								"AUDIOVISUALES": AUDIOVISUALES_EC,
								"ARTES ELECTRÓNICAS": ARTES_ELECTRONICAS_EC
							},{
								"linea": "LABORATORIO CREA",
								"DANZA": DANZA_LC,
								"MUSICA": MUSICA_LC,
								"ARTES PLASTICAS": ARTES_PLASTICAS_LC,
								"LITERATURA": LITERATURA_LC,
								"TEATRO": TEATRO_LC,
								"AUDIOVISUALES": AUDIOVISUALES_LC,
								"ARTES ELECTRÓNICAS": ARTES_ELECTRONICAS_LC
							}],
							"valueAxes": [{
								"stackType": "100%",
								"axisAlpha": 0,
								"gridAlpha": 0,
								"labelsEnabled": false,
								"position": "left"
							}],
							"graphs": [{
								"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]] TALLERES</b> ([[percents]]%)</span>",
								"fillAlphas": 0.9,
								"fontSize": 11,
								"labelText": "DANZA [[percents]]%",
								"lineAlpha": 0.5,
								"title": "DANZA",
								"type": "column",
								"valueField": "DANZA"
							}, {
								"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]] TALLERES</b> ([[percents]]%)</span>",
								"fillAlphas": 0.9,
								"fontSize": 11,
								"labelText": "MÚSICA [[percents]]%",
								"lineAlpha": 0.5,
								"title": "MÚSICA",
								"type": "column",
								"valueField": "MUSICA"
							}, {
								"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]] TALLERES</b> ([[percents]]%)</span>",
								"fillAlphas": 0.9,
								"fontSize": 11,
								"labelText": "ARTES PLÁSTICAS [[percents]]%",
								"lineAlpha": 0.5,
								"title": "ARTES PLÁSTICAS",
								"type": "column",
								"valueField": "ARTES PLASTICAS"
							}, {
								"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]] TALLERES</b> ([[percents]]%)</span>",
								"fillAlphas": 0.9,
								"fontSize": 11,
								"labelText": "LITERATURA [[percents]]%",
								"lineAlpha": 0.5,
								"title": "LITERATURA",
								"type": "column",
								"valueField": "LITERATURA"
							}, {
								"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]] TALLERES</b> ([[percents]]%)</span>",
								"fillAlphas": 0.9,
								"fontSize": 11,
								"labelText": "TEATRO [[percents]]%",
								"lineAlpha": 0.5,
								"title": "TEATRO",
								"type": "column",
								"valueField": "TEATRO"
							}, {
								"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]] TALLERES</b> ([[percents]]%)</span>",
								"fillAlphas": 0.9,
								"fontSize": 11,
								"labelText": "AUDIOVISUALES [[percents]]%",
								"lineAlpha": 0.5,
								"title": "AUDIOVISUALES",
								"type": "column",
								"valueField": "AUDIOVISUALES"
							},{
								"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]] TALLERES</b> ([[percents]]%)</span>",
								"fillAlphas": 0.9,
								"fontSize": 11,
								"labelText": "ARTES ELECTRÓNICAS [[percents]]%",
								"lineAlpha": 0.5,
								"title": "ARTES ELECTRÓNICAS",
								"type": "column",
								"valueField": "ARTES ELECTRÓNICAS"
							}],
							"marginTop": 30,
							"marginRight": 0,
							"marginLeft": 0,
							"marginBottom": 40,
							"autoMargins": false,
							"categoryField": "linea",
							"categoryAxis": {
								"gridPosition": "start",
								"axisAlpha": 0,
								"gridAlpha": 0
							},
							"export": {
								"enabled": true
							}
						});
}catch(err){
	console.error("Error al leer estadísticas de Localidades: "+err.message);
}              
} 
});

var datos = {
	funcion : 'getEstadisticasEmprendeCreaTipoGrupo',
	p1: (new Date()).getFullYear(),
	p2: $("#SL_CREA").val()
};
$.ajax({
	url: url_service,
	type: 'POST',
	data: datos,
	dataType: 'json',
	success: function(data){ 
		try{
			var MANOS_A_LA_OBRA =0;
			var SUBETE_A_LA_ESCENA =0;
			var VACACIONAL =0;
			var ENSAMBLE =0;

			$.each(data, function(i) 
			{
				MANOS_A_LA_OBRA += (data[i].TIPO=="Emprende - Manos a la obra") ? parseInt(data[i].TALLERES):0;
				SUBETE_A_LA_ESCENA += (data[i].TIPO=="Emprende - Subete a la escena") ? parseInt(data[i].TALLERES):0;
				VACACIONAL += (data[i].TIPO=="Emprende - Vacacional") ? parseInt(data[i].TALLERES):0;
				ENSAMBLE += (data[i].TIPO=="Ensamble") ? parseInt(data[i].TALLERES):0;
			});

			var chart = AmCharts.makeChart("chartdiv_emprende_crea",
			{
				"type": "serial",
				"theme": "light",
				"dataProvider": [{
					"name": "MANOS A LA OBRA",
					"points": MANOS_A_LA_OBRA,
					"color": "#7F8DA9",
					"bullet": "https://i.pinimg.com/originals/ac/1b/e8/ac1be8555898cb2fc1c753ef207e7e03.png"
				}, {
					"name": "SUBETE A LA ESCENA",
					"points": SUBETE_A_LA_ESCENA,
					"color": "#FEC514",
					"bullet": "http://www.planetariodebogota.gov.co/sites/default/files/styles/large/public/fotos_eventos/IMAGEN%20subete%20a%20la%20escena_4.jpg?itok=cyT844wT"
				}, {
					"name": "VACACIONAL",
					"points": VACACIONAL,
					"color": "#DB4C3C",
					"bullet": "https://upload.wikimedia.org/wikipedia/commons/b/bf/Venstre_DK_V.png"
				}, {
					"name": "ENSAMBLE",
					"points": ENSAMBLE,
					"color": "#DAF0FD",
					"bullet": "https://vignette.wikia.nocookie.net/colombia/images/f/fa/E.png/revision/latest?cb=20130405022411&path-prefix=es"
				}],
				"valueAxes": [{
					"axisAlpha": 0,
					"dashLength": 4,
					"position": "left"
				}],
				"startDuration": 1,
				"graphs": [{
					"balloonText": "<span style='font-size:13px;'>[[category]]: <b>[[value]]</b></span>",
					"bulletOffset": 10,
					"bulletSize": 52,
					"colorField": "color",
					"cornerRadiusTop": 8,
					"customBulletField": "bullet",
					"fillAlphas": 0.8,
					"lineAlpha": 0,
					"type": "column",
					"valueField": "points"
				}],
				"marginTop": 0,
				"marginRight": 0,
				"marginLeft": 0,
				"marginBottom": 0,
				"autoMargins": false,
				"categoryField": "name",
				"categoryAxis": {
					"axisAlpha": 0,
					"gridAlpha": 0,
					"inside": true,
					"tickLength": 0
				},
				"export": {
					"enabled": true
				}
			});
		}catch(err){
			console.error("Error al leer estadísticas de Localidades: "+err.message);
		}              
	} 
});
}
}

function cargaTablaArchivosCrea($id_crea,$tipo_archivo){
		//Llena la tabla con el listado de Archivos del CREA segun el TIPO indicado.
		var datos={
			'function':'getArchivosCrea',
			'id_crea':$("#SL_CREA").val(),
			'tipo_archivo':$tipo_archivo
		}
		$.ajax({
			async : false,
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(archivos_tabla)
			{
				// if($tipo_archivo == 'REGISTRO_FOTOGRAFICO'){
					tabla_archivos.destroy();
					$('#tbody-archivos').html('');
					$('#tbody-archivos').append(archivos_tabla);
					tabla_archivos = $('#tabla-archivos').DataTable({
						"responsive": true,
						"paging":   true,
						"ordering": true,
						"info":     false,
						"language": {
							"lengthMenu": "Ver _MENU_ registros por pagina",
							"zeroRecords": "No hay información para mostrar, Realize una consulta.",
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
							title: 'Reporte de Archivos'
						},
						{
							extend: 'excelHtml5',
							exportOptions: {
								columns: ':visible'
							},
							title: 'Reporte de Archivos'
						},
						{
							extend: 'pdfHtml5',
							exportOptions: {
								columns: ':visible'
							},
							title: 'Reporte de Archivos'
						}
						]
					});
				// }
			}
		});
		if(rol != 3 && rol != 4 && rol != 6 && rol != 8 && rol != 10 && rol != 14 && rol != 17 && rol != 18 && rol != 21){
			$(".span-eliminar-archivo").prop('hidden','hidden');
		}
	}

	function recargarCarouselFotografico($id_crea){
		var datos={
			'function':'getCarouselFotograficoCrea',
			'id_crea':$("#SL_CREA").val(),
			'tipo_archivo':'REGISTRO_FOTOGRAFICO'
		}
		$.ajax({
			async : false,
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(registro_fotografico)
			{
				$('#div_carousel').html('');
				$('#div_carousel').append(registro_fotografico);
			}
		});
	}

	function initMap() {
		alert("AA");
		var uluru = {lat: 4.6780539, lng: -74.1043849};
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 4,
			center: uluru
		});
		var marker = new google.maps.Marker({
			position: uluru,
			map: map
		});
	}

	function listarCoordinadoresCrea(){
		var datos={
			'function':'getCoordinadoresCrea'
		}
		$.ajax({
			async : false,
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(data)
			{
				$('#SL_ADMINISTRADOR').html(data);
				var FK_Coordinador = $("#TX_FK_Coordinador_Crea").val();
				$("#SL_ADMINISTRADOR option").filter(function() { return $(this).val() == FK_Coordinador; }).prop('selected', true);
			}
		});
	}

	function listarLocalidades(){
		var datos={
			'function':'getLocalidades'
		}
		$.ajax({
			async : false,
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(data)
			{
				$('#SL_LOCALIDAD').html(data);
				var FK_Localidad = $("#TX_FK_Localidad").val();
				$("#SL_LOCALIDAD option").filter(function() { return $(this).val() == FK_Localidad; }).prop('selected', true);
			}
		});
	}

	function listarZonas(){
		var datos={
			'function':'getZonas'
		}
		$.ajax({
			async : false,
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(data)
			{
				$('#SL_ZONA').html(data);
				var FK_Zona = $("#TX_FK_Zona").val();
				$("#SL_ZONA option").filter(function() { return $(this).val() == FK_Zona; }).prop('selected', true);
			}
		});
	}

	function listarAsistentesAdministrativos(){
		var datos={
			'function':'getAsistentesAdministrativos'
		}
		$.ajax({
			async : false,
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(data)
			{
				$('#SL_ASISTENTES_ADMINISTRATIVOS').html(data);
				$('#SL_ASISTENTES_ADMINISTRATIVOS').selectpicker('refresh');
				var FK_Asistentes_Administrativos = $("#TX_FK_Asistentes_Administrativos").val();
				vector_asistentes_administraticos = FK_Asistentes_Administrativos.split(',');
				for(i=0;i<vector_asistentes_administraticos.length;i++){
					$("#SL_ASISTENTES_ADMINISTRATIVOS option").filter(function() { return $(this).val() == vector_asistentes_administraticos[i]; }).prop('selected', true);
					$("#SL_ASISTENTES_ADMINISTRATIVOS").selectpicker('refresh');
				}
			}
		});
	}

	function listarAuxiliaresOperativos(){
		var datos={
			'function':'getAuxiliaresOperativos'
		}
		$.ajax({
			async : false,
			url: '../../Controlador/Infraestructura/Ficha/C_Ficha_Crea.php',
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(data)
			{
				$('#SL_AUXILIARES_OPERATIVOS').html(data);
				$('#SL_AUXILIARES_OPERATIVOS').selectpicker('refresh');
				var FK_Auxiliares = $("#TX_FK_Auxiliares_Operativos").val();
				vector_auxiliares_operativos = FK_Auxiliares.split(',');
				for(i=0;i<vector_auxiliares_operativos.length;i++){
					$("#SL_AUXILIARES_OPERATIVOS option").filter(function() { return $(this).val() == vector_auxiliares_operativos[i]; }).prop('selected', true);
					$("#SL_AUXILIARES_OPERATIVOS").selectpicker('refresh');
				}
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

	function cargarTablaSalones($id_crea){
		//Llena la tabla con el listado de Archivos del CREA segun el TIPO indicado.
		var datos={
			funcion:'getEspaciosCrea',
			p1:{
				'id_crea': $("#SL_CREA").val(),
			}
		}
		$.ajax({
			async : false,
			url: url_service_infraestructura,
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(espacios_tabla)
			{
				tabla_espacios.destroy();
				$('#tbody-espacios').html('');
				$('#tbody-espacios').append(espacios_tabla);
				tabla_espacios = $('#tabla-espacios').DataTable({
					"responsive": true,
					"paging":   true,
					"ordering": true,
					"info":     false,
					columnDefs: [
					{
						"targets": [ 0, 1, 5, 6 ],
						"visible": false,
						"searchable": false
					}],
					"language": {
						"lengthMenu": "Ver _MENU_ registros por pagina",
						"zeroRecords": "No hay información para mostrar, Realize una consulta.",
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
						title: 'Reporte de Archivos'
					},
					{
						extend: 'excelHtml5',
						exportOptions: {
							columns: ':visible'
						},
						title: 'Reporte de Archivos'
					},
					{
						extend: 'pdfHtml5',
						exportOptions: {
							columns: ':visible'
						},
						title: 'Reporte de Archivos'
					}
					]
				});
				// }
			}
		});
		if(rol != 3 && rol != 4 && rol != 6 && rol != 8 && rol != 10 && rol != 14 && rol != 17 && rol != 18 && rol != 21){
			$(".a-eliminar-espacio").prop('hidden','hidden');
		}
	}
});
