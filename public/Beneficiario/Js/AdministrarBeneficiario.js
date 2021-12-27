var url_ok_obj = '../../src/Beneficiario/BeneficiarioController/';
$(function(){
	$('.mayuscula').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	$("#pestanas_acciones_beneficiario").hide();
	$("#div_table_estudiante").hide();
	$("#div_datos_estudiante_seleccionado").hide();
	$("#div_edicion_estudiante").hide();
	$("#nro_documento").focus();
	$(".buscar_beneficiario").keyup(function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if (code==13) {
			$("#BT_buscar_estudiante").trigger("click");
			e.preventDefault();
		}
	});

	$("#div_campo_busqueda_nombres").hide();
	$("#CH_tipo_consulta_estudiante").change(function() {
		$("#resultado_busqueda_estudiantes").hide('fast');
		if($(this).prop('checked')){
			$("#div_campo_busqueda_documento").hide("fast");
			$("#div_campo_busqueda_nombres").show("slow");
			$("#nro_documento").val("");
			$("#apellido1").focus();
		}else{
			$("#div_campo_busqueda_nombres").hide("fast");
			$("#div_campo_busqueda_documento").show("slow");
			$("#apellido1").val("");
			$("#apellido2").val("");
			$("#nombre1").val("");
			$("#nombre2").val("");
			$("#nro_documento").focus();
		}
	});

	$("#nav_historial_estudiante").click(function(){
		
	});

	var table_estudiante = $("#table_estudiante").DataTable({ 
		responsive: true, 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip' 
	});

	var table_grupos_estudiante = $("#table_grupos_estudiante").DataTable({ 
		responsive: true, 
		iDisplayLength: '10', 
		"language": { 
			"lengthMenu": "Ver _MENU_ registros por pagina", 
			"zeroRecords": "No hay información, lo sentimos.", 
			"info": "Mostrando pagina _PAGE_ de _PAGES_", 
			"infoEmpty": "No hay registros disponibles", 
			"infoFiltered": "(filtered from _MAX_ total records)", 
			"search": "Filtrar" 
		}, 
		dom: 'Bfrtip' 
	});

	$("#TX_documento").keyup(function(e){
		if(e.keyCode == 13){
			$("#BT_buscar_estudiante").trigger("click");
		}
	});

	$("#SL_eps").html(parent.getOptionsParametroDetalle(16)).selectpicker('refresh');
	$("#SL_grupo_poblacional").html(parent.getOptionsParametroDetalle(14)).selectpicker('refresh');
	$("#SL_localidad").html(parent.getOptionsParametroDetalle(19)).selectpicker('refresh');
	$("#SL_crea").html(parent.getOptionsClanes()).selectpicker('refresh');
	$("#SL_colegio").html(parent.getOptionsColegios()).selectpicker('refresh');
	$("#SL_grado").html(parent.getOptionsGrados()).selectpicker('refresh');
	$("#SL_tipo_discapacidad").html(parent.getOptionsParametroDetalle(10)).selectpicker('refresh');
	$("#SL_tipo_poblacion_victima").html(parent.getOptionsParametroDetalle(9)).selectpicker('refresh');
	$("#SL_grupo_sanguineo").html(parent.getOptionsParametroDetalle(15)).selectpicker('refresh');
	$("#SL_jornada").html(parent.getOptionsParametroDetalle(11)).selectpicker('refresh');
	$("#SL_etnia").html(parent.getOptionsParametroDetalle(33)).selectpicker("refresh");

	$("#BT_buscar_estudiante").click(function(){
		consultarTabla();
	});

	$("#consultar_datos_basicos").click(function(){
		var datos = {
			p1: $("#id_estudiante").val()
		}
		$.ajax({
			url: url_ok_obj+'consultarDatosBasicosEstudiante',
			type: 'POST',
			data: datos, 
			async: false
		}).done(function(data){
			try{
				data = $.parseJSON(data);
				data = data[0];
				var mostrar = "<ul class='list-group'>";
				mostrar += "<li class='list-group-item'><b>Tipo Identificación:</b> " + data['tipo_identificacion'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Identificación:</b> " + data['IN_Identificacion'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Primer Apellido:</b> " + data['VC_Primer_Apellido'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Segundo Apellido:</b> " + data['VC_Segundo_Apellido'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Primer Nombre:</b> " + data['VC_Primer_Nombre'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Segundo Nombre:</b> " + data['VC_Segundo_Nombre'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Genero:</b> " + data['CH_Genero'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Teléfono:</b> " + data['VC_Telefono'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Celular:</b> " + data['VC_Celular'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Correo:</b> " + data['VC_Correo'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Dirección:</b> " + data['VC_Direccion'] + "</li>";
				mostrar += "<li class='list-group-item' id='LI_fecha_nacimiento'><b>Fecha Nacimiento:</b> " + data['DD_F_Nacimiento'] + " <button type='button' class='btn btn-warning' id='BT_modificar_fecha_nacimiento' data-fecha_nacimiento='"+data['DD_F_Nacimiento']+"' data-toggle='modal' data-target='#modal_fecha_nacimiento'>Modificar</button></li>";
				mostrar += "<li class='list-group-item'><b>Fecha Registro SIF:</b> " + data['DA_Fecha_Registro'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Origen:</b> " + data['VC_Tipo_Estudiante'] + "</li>";
				mostrar += "</ul>";
				//console.log(data);
				$("#div_datos_basicos").html(mostrar);
			}catch(e){
				console.log(e);
			}
		}).fail(function(result){
			console.log(result);
		});
	});

	$("#div_datos_basicos").delegate("#BT_modificar_fecha_nacimiento","click",function(){
		var fecha_nacimiento = $(this).data('fecha_nacimiento');
		$("#TB_fecha_nacimiento").datepicker({
			format: 'yyyy-mm-dd',
			weekStart: 1,
			language: 'es',
			setDate: new Date(''+fecha_nacimiento),
			endDate: new Date('2019-12-31'),
			autoclose: true,
			title: 'Fecha de nacimiento'
		}).val(fecha_nacimiento);
	});

	$("#BT_actualizar_fecha_nacimiento").click(function(ev){
		var datos = {
			'p1':{
				'id_estudiante':$("#id_estudiante").val(),
				'fecha_nacimiento':$("#TB_fecha_nacimiento").val(),
				'id_usuario':parent.idUsuario
			}
		}
		$.ajax({
			url: url_ok_obj+'actualizarFechaNacimiento',
			type: 'POST',
			data: datos, 
			async: false
		}).done(function(data){
			if(data == 1){
				$("#LI_fecha_nacimiento").html('<b>Fecha Nacimiento:</b> '+datos.p1.fecha_nacimiento);
				parent.mostrarAlerta("success","Fecha actualizada","Se ha actualizado correctamente la fecha de nacimiento");
			}else{
				parent.mostrarAlerta("error","No se pudo actualizar","Algo sucedió y no se pudo actualizar la fecha de nacimiento, intente nuevamente");
				console.log(data);
			}
		}).fail(function(result){
			console.log(result);
		});
	});

	$("#consultar_archivos").click(function(){
		var datos = {
			p1: $("#id_estudiante").data('nro_documento')
		}
		$.ajax({
			url: url_ok_obj+'consultarAnioEstudianteArchivo',
			type: 'POST',
			data: datos, 
			async: false
		}).done(function(data){
			$("#SL_anio_archivos").html(data).selectpicker("refresh").trigger("change");
		}).fail(function(result){
			console.log(result);
		});
	});

	$("#SL_anio_archivos").change(function(){
		var datos = {
			p1: $("#id_estudiante").data('nro_documento'),
			p2: $("#SL_anio_archivos").val()
		}
		$.ajax({
			url: url_ok_obj+'consultarEstudianteArchivo',
			type: 'POST',
			data: datos, 
			async: false
		}).done(function(data){
			try{
				var array_extensiones = ["png","jpg","jpeg","bmp","gif"];
				var tipo_documento_subido_beneficiario = {
					'documento_identificacion':"Identificación",
					'permiso_uso_imagen':"Permiso Uso De Imágen",
					'eps':"EPS",
					'recibo_publico':"Recibo Publico"
				};
				data = $.parseJSON(data);
				var mostrar = "<div class='row'>";
				mostrar += '<ul class="thumbnails">';
				for (var i = data.length - 1; i >= 0; i--) {
					var imagen_archivo_actual = null;
					var extension_archivo = data[i]['VC_Nombre_Archivo'].split(".");
					nombre_archivo_actual = extension_archivo[0];
					extension_archivo = extension_archivo[extension_archivo.length-1];
					if((array_extensiones.includes(extension_archivo))){
						var d = new Date();
						var n = d.getMilliseconds();
						imagen_archivo_actual = '../../uploadedFiles/' + data[i]['VC_Url']+'?v='+n;
					}else{
						imagen_archivo_actual = '../imagenes/img_descargar.png';
					}
					mostrar += '<div class="col-xs-12 col-md-3">';
						mostrar += '<a title="Descargar documento ' + tipo_documento_subido_beneficiario[nombre_archivo_actual] + '" download="' + $("#id_estudiante").data('nro_documento') + "_" + data[i]['VC_Nombre_Archivo'] + '" href="../../uploadedFiles/' + data[i]['VC_Url'] + '">';
							mostrar += '<div class="thumbnail">';
								mostrar += '<div class="caption">';
									mostrar += '<p>Documento ' + tipo_documento_subido_beneficiario[nombre_archivo_actual] + '</p>';
								mostrar += '</div>';
								mostrar += '<img data-src="holder.js/300x200" src="' + imagen_archivo_actual + '" alt="' + data[i]['VC_Nombre_Archivo'] + '">';
							mostrar += '</div>';
						mostrar += '</a>';
					mostrar += '</div>';
/*
					mostrar += '<div class="col-xs-6 col-md-4">';
					mostrar += '<img src="' + imagen_archivo_actual + '" class="img-thumbnail" alt="' + data[i]['VC_Nombre_Archivo'] + '">'
					mostrar += data[i]['VC_Nombre_Archivo'];
					mostrar += '</a></div>';*/
				}
				mostrar += '</ul>';
				mostrar += "</div>";
				$("#div_informacion_archivos").html(mostrar);
			}catch(e){
				console.log(e);
			}
		}).fail(function(result){
			console.log(result);
		});
	});

	$("#consultar_detalle_anio").click(function(){
		var datos = {
			p1: $("#id_estudiante").val()
		}
		$.ajax({
			url: url_ok_obj+'consultarAnioDetalleEstudiante',
			type: 'POST',
			data: datos, 
			async: false
		}).done(function(data){
			$("#SL_anio_detalle_anio").html(data).selectpicker("refresh").trigger("change");
		}).fail(function(result){
			console.log(result);
		});
	})

	$("#SL_anio_detalle_anio").change(function(){
		var datos = {
			p1: $("#id_estudiante").val(),
			p2: $("#SL_anio_detalle_anio").val()
		};
		$.ajax({
			url: url_ok_obj+'consultarEstudianteDetalleAnio',
			type: 'POST',
			data: datos, 
			async: false
		}).done(function(data){
			try{
				data = $.parseJSON(data);
				data = data[0];
				var mostrar = "<ul class='list-group'>";
				mostrar += "<li class='list-group-item'><b>EPS: </b> " + data['EPS'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Grupo Poblacional:</b> " + data['GRUPO_POBLACIONAL'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Localidad:</b> " + data['LOCALIDAD'] + "</li>";
				mostrar += "<li class='list-group-item'><b>RH:</b> " + data['RH'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Crea:</b> " + data['VC_Nom_Clan'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Colegio:</b> " + data['VC_Nom_Colegio'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Grado:</b> " + data['GRADO'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Discapacidad:</b> " + data['TIPO_DISCAPACIDAD'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Poblacion Victima:</b> " + data['POBLACION_VICTIMA'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Identificación Acudiente:</b> " + data['IDENTIFICACION_ACUDIENTE'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Nombre Acudiente:</b> " + data['NOMBRE_ACUDIENTE'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Teléfono Acudiente:</b> " + data['TELEFONO_ACUDIENTE'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Barrio:</b> " + data['TX_Barrio'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Enfermedades:</b> " + data['TX_Enfermedades'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Tipo Afiliación:</b> " + data['TX_Tipo_Afiliacion'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Etnia:</b> " + data['ETNIA'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Observaciones:</b> " + data['TX_observaciones'] + "</li>";
				mostrar += "<li class='list-group-item'><b>Jornada:</b> " + data['JORNADA'] + "</li>";
				mostrar += "</ul>";
				$("#div_informacion_detalle_anio").html(mostrar);
			}catch(e){
				console.log(e);
				parent.mostrarAlerta("error","Error","No se ha podido consultar la inoformación detalle anio");
			}
		}).fail(function(result){
			console.log(result);
			parent.mostrarAlerta("error","Error","No se ha podido consultar la inoformación detalle anio");
		});
		var linea_atencion = ["arte_escuela","emprende_clan","laboratorio_clan"];
		var linea_atencion_acronimo = {"arte_escuela" : "AE","emprende_clan" : "EC","laboratorio_clan" : "LC"};
		var html_mostrar_grupos = "";
		for (var i = linea_atencion.length - 1; i >= 0; i--) {
			var datos = {
				"p1" : {
					"id_estudiante" : $("#id_estudiante").val(),
					"anio" : $("#SL_anio_detalle_anio").val(),
					"tipo_grupo" : linea_atencion[i]
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarGruposBeneficiarioAnio',
				type: 'POST',
				data: datos, 
				async: false
			}).done(function(data){
				try{
					data = $.parseJSON(data);
					for (var j = 0; j < data.length; j++){
						html_mostrar_grupos += "<tr>";
						html_mostrar_grupos += "<td>" + data[j]["FK_clan"] + "</td>";
						html_mostrar_grupos += "<td>" + linea_atencion_acronimo[linea_atencion[i]] + "-" + data[j]["PK_Grupo"] + "</td>";
						html_mostrar_grupos += "<td>" + data[j]["Artista_Formador"] + "</td>";
						html_mostrar_grupos += "<td>" + data[j]["DT_fecha_ingreso"] + "</td>";
						html_mostrar_grupos += "<td>" + data[j]["Usuario_Ingreso"] + "</td>";
						html_mostrar_grupos += "<td>" + data[j]["DT_fecha_retiro"] + "</td>";
						html_mostrar_grupos += "<td>" + data[j]["Usuario_Retiro"] + "</td>";
						html_mostrar_grupos += "</tr>"
					}
				}catch(e){
					console.log(e);
					parent.mostrarAlerta("error","Error","No se ha podido consultar la inoformación detalle anio");
				}
			}).fail(function(result){
				console.log(result);
				parent.mostrarAlerta("error","Error","No se ha podido consultar la inoformación detalle anio");
			});
		}
		table_grupos_estudiante.clear().draw();
		table_grupos_estudiante.rows.add($(html_mostrar_grupos)).draw(); 
	});

	var numeroregex = /^([0-9]+)$/;
	$.validator.addMethod("validNumber", function( value, element ) {
		return this.optional( element ) || numeroregex.test( value );
	});

	validatorForm = $('#form_edicion_detalle').validate({
		rules: {
			SL_grupo_poblacional: {
				required: true
			},
			SL_etnia: {
				required: true
			},
			SL_tipo_discapacidad: {
				required: true
			},
			SL_tipo_poblacion_victima: {
				required: true
			},
			SL_estrato: {
				required: true
			},
			SL_crea: {
				required: true
			},
			SL_localidad: {
				required: true
			},
			/*TX_telefono_acudiente: {
				validNumber: true
			},*/    
			TX_identificacion_acudiente: {
				validNumber: true
			}
		},
		messages:
		{ 
			SL_grupo_poblacional: {
				required: "Este campo es requerido (NINGUNO)"
			},
			SL_etnia: {
				required: "Este campo es requerido (NO APLICA)"
			},
			SL_tipo_discapacidad: {
				required: "Este campo es requerido (NO APLICA)"
			},
			SL_tipo_poblacion_victima: {
				required: "Este campo es requerido (NO APLICA)"
			},
			SL_estrato: {
				required: "Este campo es requerido"
			},
			SL_crea: {
				required: "Este campo es requerido"
			},
			SL_localidad: {
				required: "Este campo es requerido"
			},
			TX_telefono_acudiente: {
				validNumber: "Este campo solo debe contener números",
			},
			TX_identificacion_acudiente: {
				validNumber: "Este campo solo debe contener números",
			}
		},
		errorPlacement : function(error, element) {
			if ($(element).is( "select" ))
				$(element).parent().parent().find('.help-block').html(error.html());
			else
				$(element).parent().find('.help-block').html(error.html());
		},
		highlight : function(element) {
			if ($(element).is( "select" ))
				$(element).parent().parent().removeClass('has-success').addClass('has-error');
			else
				$(element).parent().removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			if ($(element).is( "select" )){	
				$(element).parent().parent().removeClass('has-error').addClass('has-success');
				$(element).parent().parent().find('.help-block').html('');
			}
			else
				$(element).parent().removeClass('has-error').addClass('has-success');
			$(element).parent().find('.help-block').html('');
		}
	});

		function consultarTabla() {

			var  nro_documento = null,apellido1=null,apellido2=null,nombre1=null,nombre2=null;
			if(!($("#CH_tipo_consulta_estudiante").prop('checked'))){
				if($("#nro_documento").val() != ""){
					nro_documento = $("#nro_documento").val();
				}else{
					parent.alertify.alert("Advertencia",$("#p_mensaje").html());
					return;
				}
			}else{
				if($("#apellido1").val() != ""){
					apellido1=$("#apellido1").val();
					text_busqueda = $("#apellido1").val();
					if($("#apellido2").val() != ""){
						text_busqueda += " " + $("#apellido2").val()
						apellido2=$("#apellido2").val();
					}
					if($("#nombre1").val() != ""){
						text_busqueda += " " + $("#nombre1").val()
						nombre1=$("#nombre1").val();
					}
					if($("#nombre2").val() != ""){
						text_busqueda += " " + $("#nombre2").val()
						nombre2=$("#nombre2").val();
					}
				}else{
					parent.alertify.alert("Advertencia",$("#p_mensaje").html());
					return;
				}
			}
			datos = {
				p1: { 
					'in_identificacion': nro_documento,
					'vc_primer_apellido':apellido1,  
					'vc_segundo_apellido':apellido2,
					'vc_primer_nombre':nombre1,
					'vc_segundo_nombre':nombre2, 
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarTablaEstudiante',
				type: 'POST',
				data: datos, 
				async: false
			}).done(function(data){
				if(data.length == 0){
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'No hay concidencias.',
						html: "<small>No se han encontrado resultados para el número de documento o nombre indicado.</small>",
						type: 'error',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					}).catch(parent.swal.noop);
				}
				table_estudiante.clear().draw();
				table_estudiante.rows.add($(data)).draw(); 
			}).fail(function(result){
				console.log(result);
			});
			$("#div_table_estudiante").show("slow");
		}
		$("table").delegate(".cargar_datos_estudiante","click",(function(){
			var self = this;
			$("#id_estudiante").data('tipo_estudiante',$(this).data('tipo_estudiante'));
			$("#form_edicion_detalle")[0].reset();
			$('.selectpicker').selectpicker('refresh');	
			var datosTabla = table_estudiante.row(($(this).parent()).parent()).data();
			$("#id_estudiante").val($(self).data('id_estudiante'));
			$("#id_estudiante").data('nro_documento',datosTabla[0]);
			$("#L_Nombre_Estudiante").text(datosTabla[1]);
			$("#L_Numero_Documento").text(datosTabla[0]);
			$("#div_busqueda_estudiante").hide("slow");
			$("#div_table_estudiante").hide("slow");
			$("#div_datos_estudiante_seleccionado").show("slow");
			$("#pestanas_acciones_beneficiario").show("slow");
		}));

		$("#nav_modificar_estudiante").click(function(){
			var datos = {
				'p1' : $("#id_estudiante").val(),
				'p2' : (new Date).getFullYear()
			};
			$.ajax({
				url: url_ok_obj+'consultarEstudianteDetalleAnio',
				type: 'POST',
				data: datos,
				async: true
			}).done(function(data){
				if(data == '0'){
					parent.swal({
						confirmButtonColor: '#3f9a9d',
						title: 'No hay registro 2021.',
						html: "<small>Este estudiante no tiene registro para el año "+(new Date).getFullYear()+". <br>Se creará un nuevo registro con los datos que diligencie a continuación y podrá ser modificado en cualquier momento.</small>",
						type: 'warning',
						confirmButtonText: 'Aceptar',
						showCancelButton: false,
					}).catch(parent.swal.noop);
					desactivarCamposSIMAT(false);
					$("#tipo_operacion").val("crearRegistroDetalleAnio");
				}else{
					try{
						var detalle_anio = $.parseJSON(data)[0];
						$("#tipo_operacion").val("actualizarRegistroDetalleAnio");
						$("#SL_localidad").val(detalle_anio['FK_Localidad']).selectpicker('refresh');
						$("#SL_grupo_poblacional").val(detalle_anio['FK_Grupo_Poblacional']).selectpicker('refresh');
						$("#SL_crea").val(detalle_anio['FK_clan']).selectpicker('refresh');
						$("#SL_jornada").val(detalle_anio['jornada']).selectpicker('refresh');
						$("#SL_tipo_discapacidad").val(detalle_anio['FK_tipo_discapacidad']).selectpicker('refresh');
						$("#SL_estrato").val(detalle_anio['IN_estrato']).selectpicker('refresh');
						$("#SL_etnia").val(detalle_anio['TX_etnia']).selectpicker('refresh');
						$("#SL_eps").val(detalle_anio['FK_Eps']).selectpicker('refresh');
						$("#SL_grupo_sanguineo").val(detalle_anio['FK_RH']).selectpicker('refresh');
						$("#SL_colegio").val(detalle_anio['FK_colegio']).selectpicker('refresh');
						$("#SL_grado").val(detalle_anio['FK_grado']).selectpicker('refresh');
						$("#SL_tipo_poblacion_victima").val(detalle_anio['FK_tipo_poblacion_victima']).selectpicker('refresh');

						$("#TX_identificacion_acudiente").val(detalle_anio['IDENTIFICACION_ACUDIENTE']);
						$("#TX_telefono_acudiente").val(detalle_anio['TELEFONO_ACUDIENTE']);
						$("#TX_nombre_acudiente").val(detalle_anio['NOMBRE_ACUDIENTE']);
						$("#TX_barrio").val(detalle_anio['TX_Barrio']);
						$("#SL_tipo_afiliacion").val(detalle_anio['TX_Tipo_Afiliacion']).selectpicker('refresh');
						$("#TX_enfermedades").val(detalle_anio['TX_Enfermedades']);
						$("#TX_observaciones").val(detalle_anio['TX_observaciones']);
					}catch(e){
						console.log(e);
					}
					if($("#id_estudiante").data("tipo_estudiante") == 'MATRICULA'){
						desactivarCamposSIMAT(true);
					}else{
						desactivarCamposSIMAT(false);
					}
				}
			}).fail(function(result){
				console.log("Error: "+result);
			});
			$("#div_edicion_estudiante").show("slow");
		});

		$("#nav_modificar_documentos").click(function(){
			$("#panel_modificar_documentos").html(obtenerFormularioCompletarDatos('DocumentosEmprendeAnio'));
			$("[id^='FILE_archivo_beneficiario_']").removeAttr("required");
		});

		$("#panel_modificar_documentos").delegate("#form_formulario_completar_documentos_emprende","submit",function(e){
		e.preventDefault();
		var data_form = new FormData();
		try{
            documento_beneficiario_identificacion = $("#FILE_archivo_beneficiario_emprende_identificacion")[0].files;
          }catch(err){
            console.log(err);
          }
          try{
            documento_beneficiario_recibo_publico = $("#FILE_archivo_beneficiario_emprende_recibo_publico")[0].files;
          }catch(err){
            console.log(err);
          }
          try{
            documento_beneficiario_eps = $("#FILE_archivo_beneficiario_emprende_eps")[0].files;
          }catch(err){
            console.log(err);
          }
          try{
            documento_beneficiario_uso_imagen = $("#FILE_archivo_beneficiario_emprende_uso_imagen")[0].files;
          }catch(err){
            console.log(err);
          }
		try{
			data_form.append(0, documento_beneficiario_identificacion[0]);
		}catch(err){
			console.log(err);
		}
		try{
			data_form.append(1, documento_beneficiario_recibo_publico[0]);
		}catch(err){
			console.log(err);
		}
		try{
			data_form.append(2, documento_beneficiario_eps[0]);
		}catch(err){
			console.log(err);
		}
		try{
			data_form.append(3, documento_beneficiario_uso_imagen[0]);
		}catch(err){
			console.log(err);
		}
		if(documento_beneficiario_identificacion.length == 0 && documento_beneficiario_recibo_publico.length == 0 && documento_beneficiario_eps.length == 0 && documento_beneficiario_uso_imagen.length == 0){
			parent.mostrarAlerta("warning","Documentos vacios","Debe seleccionar por lo menos un documento.");
		}else{
			var datos_beneficiario = {
				'id_beneficiario' : $("#id_estudiante").data('nro_documento'),
				'id_usuario' : parent.idUsuario
			};
			data_form.append("p1",JSON.stringify(datos_beneficiario));
			$.ajax({
				url: url_ok_obj+'subirArchivosBeneficiarioAnioActual',
				type: 'POST',
				data: data_form,
				processData: false, // Don't process the files
	      		contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				async: false
			}).done(function(data){
				if(data == 1){
					parent.mostrarAlerta("success","Documentos creados","Se han creado subido los documentos correctamente.");
				}
			}).fail(function(data){
				parent.mostrarAlerta("warning","Error","No se ha podido crear el detalle_anio para este año: " + id_beneficiario);
				console.log(data);
			});
		}
	});
		
		$("#BT_buscar_otro_beneficiario").click(function(){
			$("#div_busqueda_estudiante").show("slow");
			$("#div_datos_estudiante_seleccionado").hide("fast");
			$(".nav-item").removeClass("active");
			$("[id^=panel_]").removeClass("active");
			$("#pestanas_acciones_beneficiario").hide("fast");
		});

		$("#form_edicion_detalle").on('submit', function(e){
			desactivarCamposSIMAT(false);
			e.preventDefault();
			var valid = $('#form_edicion_detalle').valid();
			if (valid) {
				var tipo_operacion = $("#tipo_operacion").val();
				var data = {};
				$(this).serializeArray().map(function(x){data[x.name] = x.value;});
				var datos = {
					'p1' : data
				};
				$.ajax({
					url: url_ok_obj+tipo_operacion,
					type: 'POST',
					data: datos,
					async: false
				}).done(function(data){
					if (data == 1) {
						tipo = "";
						if (tipo_operacion = "crearRegistroDetalleAnio") tipo = "creado";
						if (tipo_operacion = "actualizarRegistroDetalleAnio") tipo = "modificado";
						parent.swal({
							confirmButtonColor: '#3f9a9d',
							html: '<small>Se ha '+tipo+' el registro para el año '+(new Date).getFullYear()+' del estudiante seleccionado.</small>',
							type: 'success',
							confirmButtonText: 'Aceptar',
							showCancelButton: false,
						}).then(() => {
							consultarTabla();
							$("#div_edicion_estudiante").hide("slow")
							$("#div_busqueda_estudiante").show("slow");
						}).catch(parent.swal.noop);
					}
					else{
						parent.swal({
							confirmButtonColor: '#3f9a9d',
							title: 'Ha ocurrido un Error',
							html: '<small>Intente nuevamente.</small>',
							type: 'error',
							confirmButtonText: 'Aceptar',
							showCancelButton: false
						}).catch(parent.swal.noop);
					}
					desactivarCamposSIMAT(true);
				}).fail(function(result){
					console.log("Error: "+result);
				});
			}
			else
				validatorForm.focusInvalid();
		});
		function desactivarCamposSIMAT(estado_desactivacion){
			if(estado_desactivacion){
				$("#SL_estrato").attr("disabled","disabled").prop('disabled', true).selectpicker('refresh');
				$("#SL_tipo_poblacion_victima").attr("disabled","disabled").prop('disabled', true).selectpicker('refresh');
				$("#SL_tipo_discapacidad").attr("disabled","disabled").prop('disabled', true).selectpicker('refresh');
				$("#SL_etnia").attr("disabled","disabled").prop('disabled', true).selectpicker('refresh');
				$("#SL_jornada").attr("disabled","disabled").prop('disabled', true).selectpicker('refresh');
				$("#SL_grado").attr("disabled","disabled").prop('disabled', true).selectpicker('refresh');
			}else{
				$("#SL_estrato").removeAttr("disabled").attr("required","required").prop('disabled', false).selectpicker('refresh');
				$("#SL_tipo_poblacion_victima").removeAttr("disabled").attr("required","required").prop('disabled', false).selectpicker('refresh');
				$("#SL_tipo_discapacidad").removeAttr("disabled").attr("required","required").prop('disabled', false).selectpicker('refresh');
				$("#SL_etnia").removeAttr("disabled").attr("required","required").prop('disabled', false).selectpicker('refresh');
				$("#SL_jornada").removeAttr("disabled").attr("required","required").prop('disabled', false).selectpicker('refresh');
				$("#SL_grado").removeAttr("disabled").attr("required","required").prop('disabled', false).selectpicker('refresh');
			}
		}

		function obtenerFormularioCompletarDatos(tipo_formulario){
			var mostrar = '';
			var datos = {
				p1: {
					'tipo_formulario': tipo_formulario
				}
			}
			$.ajax({
				url: url_ok_obj+'obtenerFormulario',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				mostrar += data;
			}).fail(function(data){
				parent.mostrarAlerta("warning","Error","No se ha podido cargar el formulario: " + tipo_formulario);
				console.log(data);
			});
			return mostrar;
		}
	});