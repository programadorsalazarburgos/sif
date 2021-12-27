var url_service = '../../Controlador/Territorial/C_Registrar_Asistencia_Laboratorio_Clan.php';
var files;
$(function(){
	$("#fecha_taller").datepicker({
		format: 'yyyy-mm-dd',
    	language: 'es',
    	endDate: '+0d',
    	autoclose: true,
    	title: 'Fecha del Taller'
	});
	$("#SL_Clan").html(getClanes());
	$("#SL_Area_Artistica").html(getAreasArtisticas());
	$("#SL_Lugar_Atencion").html(getLugaresAtencion());
	setMaxDate();

	$("#observaciones").focusin(function(){
		validarTallerExistente();
	});

	$("#form_nueva_asistencia").submit(function(event){
		event.stopPropagation();
		event.preventDefault();
		var datos = ($(this).serialize());
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			success: function(data){
				$("#mensaje_operacion").hide();
				$("#mensaje_operacion").html("<div class='alert alert-success fade-in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Asistencia Registrada!</b> Consulte su historial de asistencias.</div>");
				$("#mensaje_operacion").show("slow");
				$("#modal-nueva-asitencia").modal('hide');
				//guardarAsistentes(data);
				uploadFiles(event);
			}
		})
	});

	$("#form_editar_taller").submit(function(event){
		event.stopPropagation();
		event.preventDefault();
		var datos = $(this).serialize();
		$.ajax({
			url:url_service,
			type: 'POST',
			data: datos,
			success: function(data){
				console.log(data + "asdf");
				uploadFiles(event);
				$("#modal-editar_taller").hide();
				alert("Se ha cambiado satisfactoriamente el archivo soporte.");
			}
		});
	});

	$("#archivo_soporte").change(function(){
		files = event.target.files;
		var data = new FormData();
		$.each(files, function(key, value)
		{
			data.append(key, value);
		});
	});

	$("#archivo_soporte_editado").change(function(){
		files = event.target.files;
		var data = new FormData();
		$.each(files, function(key, value)
		{
			data.append(key, value);
		});
	});

	/*
	$("#numero_personas").focusout(function(){
		var total_personas = $(this).val();
		$("#detalle_asistentes").html(getInputsDetallePersonas(total_personas));
		$('.tiene_documento').bootstrapToggle({
			on: 'SÍ',
			off: 'NO',
			onstyle: 'success',
			offstyle: 'danger'
		});
	});
	*/
	$("#detalle_asistentes").delegate(".tiene_documento","change",function(){
		var numero_documento = $(this).data("documento");
		var estado = 0;
		if($(this).is(':checked')){
			estado = 1;
			$("#documento_" + numero_documento).removeAttr("disabled");
			$("#documento_" + numero_documento).val("");
		}else{
			$("#documento_" + numero_documento).attr("disabled","disabled");
			$("#documento_" + numero_documento).val("PV_IDARTES");
			estado = 0;
		}
	});

	$("#btn_ver_historico").click(function(){
		var id_artista_formador = $(this).data("id_artista_formador");
		var datos = {
			'opcion':'get_historial_artista_formador',
			'id_artista_formador':id_artista_formador
		};
		var table_talleres = $("#table_mi_historial").DataTable();
		table_talleres.clear();
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			success: function(data){
				$("#table_mi_historial").html(data);
			},
			async: false
		});
		table_talleres.destroy();
	    $("#table_mi_historial").DataTable({
	        responsive: true,
	        "language": {
	            "lengthMenu": "Ver _MENU_ registros por pagina",
	            "zeroRecords": "No hay información, lo sentimos.",
	            "info": "Mostrando pagina _PAGE_ de _PAGES_",
	            "infoEmpty": "No hay registros disponibles",
	            "infoFiltered": "(filtered from _MAX_ total records)",
	            "search": "Filtrar"
	        }
	    });
	    table_talleres.draw();
	});

	$("#table_mi_historial").delegate(".edtiar_taller","click",function(){
		var id_taller = $(this).data("id_taller");
		$("#id_taller_editado").val(id_taller);
		console.log("editar archivo taller: " + id_taller);
	});

});

function setMaxDate(){
	var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    document.getElementById("fecha_taller").setAttribute("max",maxDate);
}

function getInputsDetallePersonas(total_personas){
	var i = 1;
	var mostrar = "<fieldset><legend>Detalle de asistencias</legend>";
	while(i <= parseInt(total_personas)){
		mostrar += "<div class='row'>";
		mostrar += "<div class='col-xs-1'></div>";
		mostrar += getInputDocumento(i);
		mostrar += "</div>";
		i++;
	}
	mostrar += "</fieldest><hr>";
	return mostrar;
}

function uploadFiles(event){
	event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening
	var data = new FormData();
	$.each(files, function(key, value)
	{
		data.append(key, value);
	});
	$.ajax({
        url: url_service + '?files',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'html',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        beforeSend: function(){
    		
 		},
        success: function(data)
        {
        	console.log(data);
        	if(data == 'no_subio'){
        		alert("El archivo no subio por un error interno del servidor. Por favor comuniquese con el equipo de soporte para subir el archivo manualmente.");
        	}
        },
        error: function(data){
        	console.log("Error: " + data);
        }
    });
}

function getClanes(){
	var mostrar = "";
	var datos = {'opcion':'get_clanes'};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}

function getAreasArtisticas(){
	var mostrar = "";
	var datos = {'opcion':'get_areas_artisticas'};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}

function getLugaresAtencion(){
	var mostrar = "";
	var datos = {'opcion':'get_lugares_atencion'};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	})
	return mostrar;
}

function getInputDocumento(numero){
	r = "<div class='col-xs-2'><input type='checkbox' checked='checked' class='tiene_documento' data-documento='" + numero + "' id='tiene_documento_" + numero + "'></div>"
	r += "<div class='col-xs-3'><input type='text' placeholder='Documento' required='required' class='form-control' id='documento_" + numero + "'></div>";
	r += "<div class='col-xs-6'><input type='text' placeholder='Nombre' required='required' class='form-control' id='nombre_" + numero + "'></div>";
	return r;
}

function guardarAsistentes(id_registro_asistencia){
	var total = $("#numero_personas").val();
	var i = 1;
	while (i <= total){
		if($("#tiene_documento_" + i).is(':checked')){
			tiene_documento = 1;
		}else{
			tiene_documento = 0;
		}
		var datos = {
			'opcion':'guardar_asistencia',
			'id_registro_asistencia':id_registro_asistencia,
			'tiene_documento': tiene_documento,
			'documento_persona':$("#documento_" + i).val(),
			'nombre_persona':$("#nombre_" + i).val()
		};

		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			success: function(data){
				console.log(data);
			},
			async: false
		});
		i++;
	}
}

function validarTallerExistente(){
	datos = {
		'opcion': 'validar_taller_existente',
		'id_clan': $("#SL_Clan").val(),
		'id_area_artistica': $("#SL_Area_Artistica").val(),
		'id_lugar_atencion' : $("#SL_Lugar_Atencion").val(),
		'fecha_taller' : $("#fecha_taller").val(),
		'id_artista_formador' : $("#btn_ver_historico").data("id_artista_formador")
	};
	$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			success: function(data){
				if(data != ""){
					alert("Ya se ha registrado información de taller para este día así: \n" + data);
					$("#SL_Clan").focus();
				}
			}
		});
}