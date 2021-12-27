var url_controller = '../../Controlador/Organizaciones/C_Formatos_Administrativos.php';
var url_controller_seguimiento_propuesta = "../../Controlador/Organizaciones/C_Seguimiento_Organizaciones.php";
var session = "";
var session_type = "";
var tabla_archivos = "";
var listado_archivos = "";
var year = "";
var organizacion = "";
var tab_activa = "a-consultar"
$(document).ready(function(){ 
	$('[data-toggle="tooltip"]').tooltip();
	var idUsuario = $('#id_usuario').val();
	var files = {};
	$("#Form_Archivos").on('submit', function(e){
		e.preventDefault();
		if($("#SL_Convenios_Organizacion").val()==""){
			parent.swal("","Porfavor seleccione el convenio al cual pertenece(n) el(los) archivo(s)","warning");
		}
		else{
			files = uploadFiles(e,files,idUsuario);
		}
	});
	
	$('input[type=file]').on('change', function(e){
		e.preventDefault();
		var key = $(this).attr('id');
		var filesData = e.target.files;
		if (key == 'anexos_archivo_seg'){
			$.each(filesData, function(index, element)
			{
				index++;
				files[key+'_'+index] = element;
			});
		}
		else
			files[key]= filesData[0];
	});

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

	$("#SL_Anio").html("");
	$('#SL_Anio').append(parent.getOptionsAnio());
	$("#SL_Anio").selectpicker("refresh");

	$("#SL_Mes").html("");
	$('#SL_Mes').append(parent.getOptionsMes());
	$("#SL_Mes").selectpicker("refresh");

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
	
	$("#SL_Year").on('change', function(){
		$("#SL_Organizacion").html("");
		$("#SL_Organizacion").append("<option value=''>Seleccione la Organización</option>");
		$("#SL_Organizacion").selectpicker("refresh");
		year = $(this).val();
		var datos = {
			'opcion': 'getOrganizacionesAnio',
			'year': year
		};
		$.ajax({
			url: url_controller, 
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					informacion.forEach(cargarOrganizaciones);
				}
				else{
				}
			},
			async : false
		});
	});

	$("#SL_Organizacion").on('change', function(){
		$("#body_archivos").html("");
		listado_archivos = "";
		organizacion = $(this).val();
		var datos = {
			'opcion': 'getArchivosOrganizacion',
			'organizacion': organizacion, //Aquí se envía el Id del Usuario (Coordinador Organización).
			'year': year+'%'
		};
		$.ajax({
			url: url_controller, 
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {					
					informacion.forEach(cargarArchivos);
				}
				tabla_archivos.clear().draw();
				tabla_archivos.rows.add($(listado_archivos)).draw();
			},
			async : false
		});
		
		$(document).delegate(".revision",'click', function() {
			$("#MODAL_REVISION #modal_titulo").html("REVISIÓN DEL ARCHIVO");
			id_archivo = $(this).data("id-archivo");
			$("#TXA_Observacion_Archivo").val($(this).data('observaciones'));
			var checked = $(this).data('aprobacion');
			if (checked=="1") {
				checked = "on";
			}
			else{
				checked = "off";
			}
			$("#IN_Aprobacion").bootstrapToggle(checked);
		});

		$(".estado_archivo").bootstrapToggle();
	});

	$(document).delegate(".observaciones",'click', function() {
		$("#MODAL_OBSERVACION #modal_titulo_observacion").html("OBSERVACIONES DEL ARCHIVO");
		$("#P_Observacion").html($(this).data('observaciones'));
	});
	
	$(document).delegate(".anexos",'click', function() {
		$("#MODAL_ANEXOS #modal_titulo_anexo").html("ANEXOS DEL ARCHIVO <strong>"+$(this).data('nombre-archivo')+"</strong>");
		$("#body_anexos").html("");
		var datos = {
			'opcion': 'getAnexosArchivo',
			'id_archivo': $(this).data('id-archivo'),
		};
		$.ajax({
			url: url_controller, 
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

	$("#BT_Guardar_Observacion").on('click', function(){
		var observacion_seguimiento = $("#TXA_Observacion_Archivo").val();
		var aprobacion = $("#IN_Aprobacion").prop("checked");
    		//alert(observacion_seguimiento+"-"+aprobacion);
    		var datos = {
    			'opcion': 'guardarRevisionArchivo',
    			'id_persona': session,
			'id_archivo': id_archivo, //Aquí se envía el Id de la Tabla tb_organizacion_seguimiento_propuesta_periodo que se va a actualizar.
			'observacion': observacion_seguimiento,
			'aprobacion': aprobacion
		};
		$.ajax({
			url: url_controller, 
			data: datos,
			type: 'POST',
			success: function (info) {
				bootbox.alert("Acción Realizada", function(){
					if(aprobacion == true){
						aprobacion = 1;
					}else{
						aprobacion = 0;
					}
					$("#MODAL_REVISION").modal('hide');
	        			//$("#BT_Abrir_Observaciones_"+id_periodo).data('observaciones', observacion_seguimiento);
	        			//$("#BT_Abrir_Observaciones_"+id_periodo).data('aprobacion', aprobacion);
	        			organizacion = $("#SL_Organizacion").val();
	        			$("#SL_Organizacion").val("0");
	        			$("#SL_Organizacion").val(organizacion);
	        			$("#SL_Organizacion").change();
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

	$('#a-consultar').on('click',function(e){
		if(session_type == 11){
			cargarArchivosSubidosOrganizacion();
		}
	});

	if(session_type == 11){
		organizacion = session;
		$("#body_archivos").html("");
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
			// if(tab_activa != "a-consultar"){
			// 	$("#SL_Convenios_Organizacion").selectpicker('hide');
			// }else{
			// 	$("#SL_Convenios_Organizacion").selectpicker('show');
			// 	$("#SL_Convenios_Organizacion").trigger('change');
			// }
		});
		year = $("#SL_Convenios_Organizacion").val();
	}
	else{
		$("#body_archivos").html("");
		$("#SL_Year").selectpicker('show');
		$("#SL_Organizacion").selectpicker('show');

		$("#SL_Convenios_Organizacion").selectpicker('hide');
	}

	$("#SL_Convenios_Organizacion").on('change', function(){
		if(tab_activa == "a-consultar"){
			cargarArchivosSubidosOrganizacion();
		}
	});
});//FIN DOCUMENT READY

function cargarArchivosSubidosOrganizacion(){
	listado_archivos = "";
	var datos = {
		'opcion': 'getArchivosOrganizacion',
		'tipo': session_type,
		'organizacion': organizacion, 
		'year': $("#SL_Convenios_Organizacion").val()+'%'
	};
	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (info) {
			informacion = JSON.parse(info);
			if (info != 'null') {
				informacion.forEach(cargarArchivos);
			}
			tabla_archivos.clear().draw();
			tabla_archivos.rows.add($(listado_archivos)).draw();
		},
		async : false
	});
	$(".revision").addClass("disabled");
	$(".estado_archivo").bootstrapToggle();
}

function uploadFiles(event,files,idUsuario)
{
	var datos = {};
	var data = new FormData();
	$.each(files, function(key, value)
	{
		data.append(key, value);
	});
	data.append("opcion","subirArchivosSeguimiento");
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
		url:url_controller+'?files',
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

function cargarOrganizaciones(item, index) {
	$("#SL_Organizacion").append("<option value="+item.PK_Id_Organizacion+">"+item.VC_Nom_Organizacion+"</option>");
	$("#SL_Organizacion").selectpicker("refresh");
}

function cargarArchivos(item, index) {
	var url = item.VC_URL;
	if (item.VC_Tipo == 'SEGUIMIENTO ORGANIZACIONES') {
		if(item.IN_Estado_Final==1){
			if(item.TX_Observacion != "" && item.TX_Observacion != null && item.IN_Aprobacion==0){
				listado_archivos += "<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='../../public/Organizaciones/"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-warning observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Pendiente</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>FINAL</span></td></tr>";	
			}else{
				if (item.IN_Aprobacion == 1) {
					listado_archivos += "<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='../../public/Organizaciones/"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-success observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Aprobado</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>FINAL</span></td></tr>";
				}
				else{
					listado_archivos += "<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='../../public/Organizaciones/"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-info observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Vacio</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' checked data-id-archivo='"+item.PK_Id_Tabla+"'><span hidden>FINAL</span></td></tr>";
				}
			}
		}
		else{
			if(item.TX_Observacion != "" && item.TX_Observacion != null && item.IN_Aprobacion==0){
				listado_archivos += "<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='../../public/Organizaciones/"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-warning observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Pendiente</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-archivo='"+item.PK_Id_Tabla+"'></td></tr>";	
			}else{
				if (item.IN_Aprobacion == 1) {
					listado_archivos += "<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='../../public/Organizaciones/"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-success observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Aprobado</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-archivo='"+item.PK_Id_Tabla+"'></td></tr>";
				}
				else{
					listado_archivos += "<tr><td>"+item.VC_Nombre_Archivo+"</td><td>"+item.VC_Tipo+"</td><td>"+item.DA_Subida+"</td><td>"+item.VC_Mes+"/"+item.IN_Anio+"</td><td><a class='btn btn-danger abrir_archivo' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='../../public/Organizaciones/"+item.VC_URL+"'><span class='fa fa-download'></span></a></td><td><a class='btn btn-warning anexos' data-toggle='modal' data-target='#MODAL_ANEXOS' data-id-archivo='"+item.PK_Id_Tabla+"' data-nombre-archivo='"+item.VC_Nombre_Archivo+"'>Anexos</a></td><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-archivo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observacion+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-info observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observacion+"'><span class='fa fa-eye'></span> Vacio</a></td><td><input data-toggle='toggle' data-onstyle='success' data-offstyle='danger' data-on='SI' data-off='NO' type='checkbox' class='estado_archivo' type='checkbox' id='check_estado_"+item.PK_Id_Tabla+"' name='check_estado_"+item.PK_Id_Tabla+"' data-id-archivo='"+item.PK_Id_Tabla+"'></td></tr>";
				}
			}	
		}
		$(".estado_archivo").bootstrapToggle();
	}
}

function cargarAnexos(item, index) {
	var url = item.VC_URL;
	$("#MODAL_ANEXOS").find("#body_anexos").append("<tr><td>"+item.VC_Nombre_Archivo+"</td><td><a class='btn btn-danger' data-id-archivo='"+item.PK_Id_Tabla+"' download='"+item.VC_Nombre_Archivo+"' href='../../public/Organizaciones/"+item.VC_URL+"'><span class='fa fa-download'></span></a></td></tr>");
}

function actualizarEstadoArchivo(id_archivo,estado, usuario){
	var datos = {
		'opcion': 'actualizarEstadoArchivo',
		'id_archivo': id_archivo,
		'estado': estado,
		'usuario': usuario
	};

	$.ajax({
		url: url_controller,
		data: datos,
		type: 'POST',
		success: function (datos) {
			parent.swal("","El estado del archivo ha sido actualizado","success");
		},
		async : false
	});
}