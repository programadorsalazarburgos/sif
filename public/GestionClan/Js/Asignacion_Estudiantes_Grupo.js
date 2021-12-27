var servicio_simat = "https://sif.idartes.gov.co/ws-simat/index.php/"; 
var servicio_aula = "https://creaencasa.idartes.gov.co/ws-aula/index.php/"; 
// asdf
/*var servicio_simat = "http://localhost:4321/ws-simat/index.php/";*/
var url_ok_obj = '../../src/GestionClan/GestionClanController/';
var url_asignacion_obj = '../../src/GestionClan/AsignacionController/';
var url_beneficiario_controller = '../../src/Beneficiario/BeneficiarioController/';
var url_service_options = '../../src/General/Controlador/OptionsController.php';
var id_grupo_asignar_estudiante = 0;
var fallaBusquedaDocumento=false;
var fallaBusquedaNombres=false;
var mensaje = "Estudiante ";
var linea_atencion = "";
var datos_beneficiario = {};
// var bioseguridad = [];

datos_beneficiario['experiencia'] = 0;
datos_beneficiario['experiencia_academia'] = 0;
datos_beneficiario['experiencia_empirica'] = 0;
$(function(){

	$('.mayuscula').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});

	var table_grupos_arte_escuela = $("#table_grupos_arte_escuela").DataTable({
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

	var table_grupos_emprende_clan = $("#table_grupos_emprende_clan").DataTable({
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

	var table_grupos_laboratorio_clan = $("#table_grupos_laboratorio_clan").DataTable({
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

	var table_remover_estudiante = $("#table_remover_estudiante").DataTable({
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

	var table_estudiante_ensamble = $("#table_estudiante_ensamble").DataTable({
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

	$(".tipo_linea_atencion").click(function(){
		$("#tipo_grupo_temp").val($(this).data('tipo_grupo'));
	});

	$("#datos_estudiante").hide();
	$("#datos_estudiante_emprende_clan").hide();
	$("#datos_estudiante_laboratorio_clan").hide();
	$("#datos_detallados_estudiante").hide();
	$("#datos_detallados_estudiante_emprende_clan").hide();
	$("#datos_detallados_estudiante_laboratorio_clan").hide();

	$("#div_cargando_datos_estudiantes").hide();
	$("#div_cargando_datos_estudiantes_emprende_clan").hide();
	$("#div_cargando_datos_estudiantes_laboratorio_clan").hide();
	$("#div_curso").hide();

	$("table").delegate(".add_estudiantes","click",function(){
		tipo_grupo = $("#tipo_grupo_temp").val();
		var id_grupo = $(this).data("id_grupo");
		var tipo_grupo_atencion = $(this).data("tipo_grupo_atencion");
		id_grupo_asignar_estudiante = id_grupo;
		$("#title_modal_agregar_estudiante").html("Asignar estudiante a grupo de " + $(this).data('acronimo_linea_atencion') +"-"+ id_grupo);
		$("#BT_asignar_estudiante_grupo").data("id_grupo",id_grupo);
		$("#BT_asignar_estudiante_grupo").data("tipo_grupo",tipo_grupo);
		$("#tipo_grupo_temp").data("id_grupo",id_grupo);
		$("#tipo_grupo_temp").data("tipo_grupo_atencion",tipo_grupo_atencion);
		$("#table_resultado_busqueda").DataTable().clear().draw();
		$("#nro_documento").val("");
		$("#datos_estudiante").hide();
		$("#datos_detallados_estudiante").hide();			
		cargarColegioPorGrupo(id_grupo);
		cargarGrados();	
		$("#SL_grado").val("");
		$("#div_mensaje").show('slow');
		$("#div_campo_busqueda_documento").show('slow');
		$("#div_campo_busqueda_nombres").hide('fast');
		$("#div_campo_busqueda_grado").hide('fast');
		$("#resultado_busqueda_estudiantes").hide('fast');
		$("#CH_tipo_consulta_estudiante").bootstrapToggle("off");
		$("#nav_individual").removeClass("active");
		$("#nav_grado").removeClass("active");
		$("#nav_individual").addClass("active");		
	});

	$("table").delegate(".remover_estudiantes","click",function(){
		$("#BT_cancelar_retiro_estudiante").trigger("click");
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_remover_estudiante").html("Remover estudiante(s) del grupo: " + $(this).data('acronimo_linea_atencion') +"-" + id_grupo);
		$("#BT_remover_beneficiarios_masivo_grupo").data("id_grupo",id_grupo)
		cargarEstudiantesParaRemoverEnGrupo(id_grupo,$(this).data('tipo_grupo'));
	});

	$("#div_campo_busqueda_nombres").hide();
	$("#div_campo_busqueda_grado").hide();
	$("#CH_tipo_consulta_estudiante").change(function() {
		$("#resultado_busqueda_estudiantes").hide('fast');
		if($(this).prop('checked')){
			$("#div_campo_busqueda_documento").hide("fast");
			$("#div_campo_busqueda_nombres").show("slow");
			$("#nro_documento").val("");
			$("#apellido1").focus();
			$("#SL_grado").val("");
		}else{
			$("#div_campo_busqueda_nombres").hide("fast");
			$("#div_campo_busqueda_documento").show("slow");
			$("#apellido1").val("");
			$("#apellido2").val("");
			$("#nombre1").val("");
			$("#nombre2").val("");
			$("#nro_documento").focus();
			$("#SL_grado").val("");
		}
	});
	$("#form_buscar_estudiante").submit(function(e){
		var tipo_grupo = $("#tipo_grupo_temp").val();
		linea_atencion = tipo_grupo;
		var tipo_origen_estudiante = "ninguno";
		e.preventDefault();
		var resulatado_array = [];
		mostrarResultadoBusqueda(resulatado_array,tipo_grupo,tipo_origen_estudiante);
		
		$(".opcion_crear_estudiante").show();
		if ($("#nav_grado").attr("class") == "active") {
			if($("#SL_grado").val() == ""){
				parent.mostrarAlerta("warning","Advertencia","Seleccione un Grado");
				return;
			}
			else{
				var datos = {
					vc_usuario: 'admin',
					vc_contrasena: '1234',
					codigo_dane: $("#div_colegio").data("dane_colegio"),
					id_grado: $("#SL_grado").val()
				};
				$.ajax({
					url: servicio_simat+"obtenerEstudiantesDaneGrado",
					type: "POST",
					async: false,
					cache: false,
					dataType: "json",
					data: datos,
				}).done(function(data){
					if(data.length==0){
						fallaBusquedaNombres=true;
					}
					else{
						resulatado_array = data;
						tipo_origen_estudiante = "Matricula";
						fallaBusquedaNombres=false;
					}
				}).fail(function(data){
					parent.mostrarAlerta("error","Lo sentimos","No se ha podido consultar el webservice, por favor intente nuevamente en unos segundos y si el problema persiste contactese con el equipo de soporte");
					console.log(data);
				});

			
			}
		}
		else{
			if(!($("#CH_tipo_consulta_estudiante").prop('checked'))){
				if($("#nro_documento").val() == ""){									
					parent.mostrarAlerta("warning","Advertencia",$("#p_mensaje").html());
					return;
				}
				else{
					var datos = {
						vc_usuario: 'admin',
						vc_contrasena: '1234',
						nro_documento: $("#nro_documento").val()
					};
					$.ajax({
						url: servicio_simat+"obtenerEstudiantePorDocumento",
						type: "POST",
						async: false,
						cache: false,
						dataType: "json",
						data: datos,
					}).done(function(data){
						if(data.length==0){
							fallaBusquedaNombres=true;
						}
						else{
							resulatado_array = data;
							tipo_origen_estudiante = "Matricula";
							fallaBusquedaNombres=false;
						}
					}).fail(function(data){
						parent.mostrarAlerta("error","Lo sentimos","No se ha podido consultar el webservice, por favor intente nuevamente en unos segundos y si el problema persiste contactese con el equipo de soporte");
						console.log(data);
					});
				}
			}
			else{
				if($("#apellido1").val() != ""){
					var datos = {
						vc_usuario: 'admin',
						vc_contrasena: '1234',
						apellido1: $("#apellido1").val()
					};

					if($("#apellido2").val() != "")
						datos.apellido2 = $("#apellido2").val()
					if($("#nombre1").val() != "")
						datos.nombre1 = $("#nombre1").val()
					if($("#nombre2").val() != "")
						datos.nombre2 = $("#nombre2").val()
					$.ajax({
						url: servicio_simat+"obtenerEstudiantePorNombres",
						type: "POST",
						async: false,
						cache: false,
						dataType: "json",
						data: datos,
					}).done(function(data){
						if(data.length==0){
							fallaBusquedaNombres=true;
						}
						else{
							resulatado_array = data;
							tipo_origen_estudiante = "Matricula";
							fallaBusquedaNombres=false;
							
						}
					}).fail(function(data){
						parent.mostrarAlerta("error","Lo sentimos","No se ha podido consultar el webservice, por favor intente nuevamente en unos segundos y si el problema persiste contactese con el equipo de soporte");
						console.log(data);
					});
				}else{
					parent.mostrarAlerta("warning","Advertencia",$("#p_mensaje").html());
					return;
				}
			}
		}
		if(resulatado_array.length == 0){
			var datos = {
			vc_usuario: 'guest',
			vc_password: '$2y$10$GUalVWp41M1a7r3LLXkWsOowIAi7jqNffl34mfKa1m8NLT0mxQrEy',
			identificacion: $("#nro_documento").val()			
			};
			$.ajax({
				url: servicio_aula+"obtenerEstudiante",
				type: "POST",
				async: false,
				cache: false,
				dataType: "json",
				data: datos,
			}).done(function(data){
				if(data.length==0){
					fallaBusquedaNombres=true;
				}
				else{
					resulatado_array = data;
					tipo_origen_estudiante = "Creaencasa";
					fallaBusquedaNombres=false;
				}
			}).fail(function(data){
				parent.mostrarAlerta("error","Lo sentimos","No se ha podido consultar el webservice, por favor intente nuevamente en unos segundos y si el problema persiste contactese con el equipo de soporte");
				console.log(data);
			});
		}
		if(resulatado_array.length == 0){
			var text_busqueda="";
			var  nro_documento = null,apellido1=null,apellido2=null,nombre1=null,nombre2=null;
			if(!($("#CH_tipo_consulta_estudiante").prop('checked'))){
				if($("#nro_documento").val() != ""){
					nro_documento = $("#nro_documento").val();
				}else{
					parent.mostrarAlerta("warning","Advertencia",$("#p_mensaje").html());
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
					parent.mostrarAlerta("warning","Advertencia",$("#p_mensaje").html());
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
				},
				p2: {
					'tipo_grupo' : tipo_grupo,
					'id_grupo' : $("#tipo_grupo_temp").data("id_grupo"),
					'tipo_grupo_atencion' : linea_atencion
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarEstudianteEnTbEstudiante',
				type:'POST',
				data: datos,
				async:false
			}).done(function(data){

				var table_resultado_busqueda_obj = null;
				if ( $.fn.dataTable.isDataTable( '#table_resultado_busqueda') ) {
					table_resultado_busqueda_obj = $('#table_resultado_busqueda').DataTable().destroy();
				}
				if (data.length > 0) {
					$("#table_resultado_busqueda > tbody").html(data);
					resulatado_array = [1];
				}else{
					console.log("Ningun resultado para " + text_busqueda);
				}

				if ( $.fn.dataTable.isDataTable( '#table_resultado_busqueda') ) {
					table_resultado_busqueda_obj = $('#table_resultado_busqueda').DataTable();
				}
				else{
					table_resultado_busqueda_obj = $('#table_resultado_busqueda').DataTable({
						"language": {
							"lengthMenu": "Ver _MENU_ registros por pagina",
							"zeroRecords": "No hay información, lo sentimos.",
							"info": "Mostrando pagina _PAGE_ de _PAGES_",
							"infoEmpty": "No hay registros disponibles",
							"infoFiltered": "(Filtrados de _MAX_ total registros)",
							"infoFiltered": "(filtered from _MAX_ total records)",
							"search": "Filtrar"
						}
					});
				}
				table_resultado_busqueda_obj.draw();
				$("#datos_detallados_estudiante").hide();
				$("#resultado_busqueda_estudiantes").show();
				$("#datos_estudiante").show();
			    //table_resultado_busqueda.draw();
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta("error",'Error','No se ha podido cargar los datos de los estudiantes ' + textStatus);
			});
		}else{
			$("#div_cargando_datos_estudiantes").hide();
			$("#datos_detallados_estudiante").hide('fast');
			$("#datos_estudiante").show('slow');
			$("#resultado_busqueda_estudiantes").show('fast');
			mostrarResultadoBusqueda(resulatado_array,tipo_grupo,tipo_origen_estudiante);
		}
		if(resulatado_array.length == 0){
			parent.mostrarAlerta("warning","Lo sentimos","No se han encontrado coincidencias en la información de Matricula Estudiantil ni en el Histórico de estudiantes atendidos por CREA.<br><br><strong>Si desea puede registrar el Estudiante mediante Formulario.</strong>");
			mostrarResultadoBusqueda(resulatado_array,tipo_grupo,tipo_origen_estudiante);
			$("#resultado_busqueda_estudiantes").show('fast');
			$("opcion_crear_estudiante").show('fast');
			linea_atencion = tipo_grupo;
			$("#bt_mostrar_formulario_registro_estudiante").trigger("click");
		}else{
			$(".opcion_crear_estudiante").hide('fast');
		}
	});

	$("#contenido_modal_formulario_completar_detalle_anio").delegate("#form_formulario_completar_detalle_anio","submit",function(e){
		e.preventDefault();
		datos_beneficiario['id_localidad'] = $("#SL_localidad_detalle_anio").val();
		datos_beneficiario['id_eps'] = $("#SL_eps_detalle_anio").val();
		datos_beneficiario['id_grupo_poblacional'] = $("#SL_grupo_poblacional_detalle_anio").val();
		datos_beneficiario['id_crea'] = $("#SL_crea_detalle_anio").val();
		datos_beneficiario['id_colegio'] = $("#SL_colegio_detalle_anio").val();
		datos_beneficiario['id_jornada'] = $("#SL_jornada_detalle_anio").val();
		datos_beneficiario['id_grado'] = $("#SL_grado_detalle_anio").val();
		datos_beneficiario['id_tipo_discapacidad'] = $("#SL_tipo_discapacidad_detalle_anio").val();
		datos_beneficiario['id_tipo_poblacion_victima'] = $("#SL_poblacion_victima_detalle_anio").val();
		datos_beneficiario['identificacion_acudiente'] = $("#TX_numero_documento_acudiente_detalle_anio").val();
		datos_beneficiario['nombre_acudiente'] = $("#TX_nombre_acudiente_detalle_anio").val();
		datos_beneficiario['telefono_acudiente'] = $("#TX_telefono_acudiente_detalle_anio").val();
		datos_beneficiario['barrio'] = $("#TX_barrio_detalle_anio").val();
		datos_beneficiario['estrato'] = $("#IN_estrato_detalle_anio").val();
		datos_beneficiario['sisben'] = $("#IN_puntaje_sisben_detalle_anio").val();
		datos_beneficiario['tipo_afiliacion'] = $("#SL_tipo_afiliacion_detalle_anio").val();
		datos_beneficiario['id_etnia'] = $("#SL_etnia_detalle_anio").val();
		datos_beneficiario['enfermedades'] = $("#TX_enfermedades_detalle_anio").val();
		datos_beneficiario['observaciones_detalle_anio'] = $("#TX_observaciones_asignacion_estudiante").val();
		datos_beneficiario['id_area_artistica_interes'] = $("#SL_area_artistica_interes_detalle_anio").val();
		datos_beneficiario['experiencia_anios'] = $("#IN_experiencia_anios_detalle_anio").val();
		datos_beneficiario['id_estudiante'] = $("#BT_asignar_estudiante_grupo").data('id_estudiante');
		datos_beneficiario['id_usuario'] = parent.idUsuario;
		var data_form = new FormData();
		data_form.append("p1",JSON.stringify(datos_beneficiario));
		$.ajax({
			url: url_asignacion_obj+'crearRegistroDetalleAnio',
			type: 'POST',
			data: data_form,
			processData: false, // Don't process the files
      		contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			async: false
		}).done(function(data){
			if(data == 1){
				// asignarEstudianteGrupo($("#BT_asignar_estudiante_grupo").data('id_estudiante'),tipo_grupo, bioseguridad);
				asignarEstudianteGrupo($("#BT_asignar_estudiante_grupo").data('id_estudiante'),tipo_grupo);
				$(".modal").modal("hide");
			}
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido crear el detalle_anio para este año: " + id_beneficiario);
			console.log(data);
		});
	});

	$("#contenido_modal_formulario_completar_detalle_anio").delegate("#form_formulario_completar_documentos_emprende","submit",function(e){
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
			parent.mostrarAlerta("warning","Documentos vacios","Debe subir por lo menos un documento.");
		}else{
			var datos_beneficiario = {
				'id_beneficiario' : $("#BT_asignar_estudiante_grupo").data('identificacion_beneficiario'),
				'id_usuario' : parent.idUsuario
			};
			data_form.append("p1",JSON.stringify(datos_beneficiario));
			$.ajax({
				url: url_beneficiario_controller+'subirArchivosBeneficiarioAnioActual',
				type: 'POST',
				data: data_form,
				processData: false, // Don't process the files
	      		contentType: false, // Set content type to false as jQuery will tell the server its a query string request
				async: false
			}).done(function(data){
				if(data == 1){
					$(".modal").modal("hide");
					parent.mostrarAlerta("success","Documentos creados","Se han creado subido los documentos correctamente.");
					$("#modal_agregar_estudiante_grupo").modal("show");
				}
				console.log(data);
			}).fail(function(data){
				parent.mostrarAlerta("warning","Error","No se ha podido crear el detalle_anio para este año: " + id_beneficiario);
				console.log(data);
			});
		}
	});

	$("#contenido_modal_formulario_completar_detalle_anio").delegate("#SL_tipo_experiencia_detalle_anio","change",function(){

		switch($(this).val()){
			case '1':
				datos_beneficiario['experiencia_empirica'] = 1;
				datos_beneficiario['experiencia_academia'] = 0;
				break;
			case '2':
				datos_beneficiario['experiencia_empirica'] = 0;
				datos_beneficiario['experiencia_academia'] = 1;
				break;
			case '3':
				datos_beneficiario['experiencia_empirica'] = 1;
				datos_beneficiario['experiencia_academia'] = 1;
				break;
			default:
				console.log("No se ha podido determinar el tipo de experiencia que tiene el beneficiario");
				parent.mostrarAlerta("danger","Error","No se ha podido determinar el tipo de experiencia que tiene el beneficiario");
				break;
		}
	});

	function mostrarResultadoBusqueda(datos,tipo_grupo,origen_estudiante){
		//Para que limpie la pantalla ante una nueva consulta+
		if ( $.fn.dataTable.isDataTable( '#table_resultado_busqueda') )
			$("#table_resultado_busqueda").DataTable().destroy();

		if ( $.fn.dataTable.isDataTable( '#table_resultado_busqueda') ) {
			table_resultado_busqueda = $("#table_resultado_busqueda").DataTable();
		}
		else {
			table_resultado_busqueda = $("#table_resultado_busqueda").DataTable({
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No se han encontrado registros de estudiante.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				}
			});
		}
		table_resultado_busqueda.clear();
		if(datos.length == 0){
			
		}else{
			if(origen_estudiante == 'Matricula'){
				$.each(datos, function(i){
					var boton = "";
					var id_localidad=0;
					var id_grupo_actual_estudiante = validarExistenciaEstudianteEnGrupo(datos[i].NRO_DOCUMENTO,tipo_grupo)
					if(id_grupo_actual_estudiante != 0 && $("#tipo_grupo_temp").data("tipo_grupo_atencion") != "Emprende - Vacacional"){
						boton = "<a class='btn btn-info' href='#'>En grupo " + id_grupo_actual_estudiante  + "</a>";
					}else{
						boton = "<a class='cargar_datos_estudiante btn btn-success' data-id_grupo='" + $("#tipo_grupo_temp").data("id_grupo") + "' data-id_estudiante='" + datos[i].NRO_DOCUMENTO + "' data-nombre_estudiante='" + datos[i].APELLIDO1+' '+datos[i].APELLIDO2+' '+datos[i].NOMBRE1+' '+datos[i].NOMBRE2 + "' data-id_grado='" + datos[i].GRADO + "' data-id_tipo_jornada='" + datos[i].TIPO_JORNADA + "' data-tipo_documento='" + datos[i].TIPO_DOCUMENTO + "' data-primer_nombre='" + datos[i].NOMBRE1 + "' data-segundo_nombre='" + datos[i].NOMBRE2 + "' data-primer_apellido='" + datos[i].APELLIDO1 + "' data-segundo_apellido='" + datos[i].APELLIDO2 + "' data-tipo_origen='simat' data-fecha_nacimiento='" + datos[i].FECHA_NACIMIENTO + "' data-genero='" + datos[i].GENERO + "' data-direccion_residencia='" + datos[i].DIRECCION_RESIDENCIA + "' data-telefono='" + datos[i].TEL + "' data-pob_vict_conf='" + datos[i].POB_VICT_CONF + "' data-tipo_discapacidad='" + datos[i].TIPO_DISCAPACIDAD + "' data-codigo_dane='" + datos[i].CODIGO_DANE + "' data-fuente='MATRICULA' data-etnia='" + datos[i].ETNIA + "' data-correo='" + '' + "' data-estrato='" + datos[i].ESTRATO + "' data-id_localidad='" + id_localidad + "' data-sisben='" + (datos[i].SISBEN == ''?0.0:datos[i].SISBEN) + "'  href='#'>Cargar Datos"+ "<sup><b> " + origen_estudiante + "</b></sup><sub>";
						boton += ((origen_estudiante == 'matricula')?'':('MES: ' + datos[i].mes + "-" + datos[i].ANO_INF)) + "</sub></a>";
					}
					var fila = table_resultado_busqueda.row.add( [
						datos[i].NRO_DOCUMENTO,
						datos[i].APELLIDO1+' '+datos[i].APELLIDO2+' '+datos[i].NOMBRE1+' '+datos[i].NOMBRE2,
						datos[i].GRADO_NOMBRE,datos[i].COLEGIO_NOMBRE,
						boton
						]).draw().node();
				});
			}else if(origen_estudiante == 'Creaencasa'){
				$.each(datos, function(i){
					// settear algunos valores por defecto
					datos[i].sisben = 0;
					// datos[i].tipo_identificacion = 2;
					datos[i].id_grado = 0;
					datos[i].id_jornada = 0;
					datos[i].id_etnia = 0;
					datos[i].enfoque = 0;
					datos[i].estrato = 0;
					var boton = "";
					var id_grupo_actual_estudiante = validarExistenciaEstudianteEnGrupo(datos[i].identificacion,tipo_grupo);
					if(id_grupo_actual_estudiante != 0){
						boton = "<a class='btn btn-info' href='#'>En grupo " + id_grupo_actual_estudiante  + "</a>";
					}else{
						boton = "<a class='cargar_datos_estudiante btn btn-info' data-id_grupo='" + $("#tipo_grupo_temp").data("id_grupo") + "' data-id_estudiante='" + datos[i].identificacion + "' data-nombre_estudiante='" + datos[i].primer_apellido+' '+datos[i].segundo_apellido+' '+ datos[i].primer_nombre+' '+ datos[i].segundo_nombre + "' data-id_grado='" + datos[i].id_grado + "' data-id_tipo_jornada='" + datos[i].id_jornada + "' data-tipo_documento='" + datos[i].tipo_identificacion + "' data-primer_nombre='" + datos[i].primer_nombre + "' data-segundo_nombre='" + datos[i].segundo_nombre + "' data-primer_apellido='" + datos[i].primer_apellido + "' data-segundo_apellido='" + datos[i].segundo_apellido + "' data-tipo_origen='creaencasa' data-fecha_nacimiento='" + datos[i].fecha_nacimiento + "' data-genero='" + datos[i].genero.substring(0,1) + "' data-direccion_residencia='" + datos[i].direccion + "' data-telefono='" + datos[i].telefono + "' data-pob_vict_conf='" + datos[i].enfoque + "' data-tipo_discapacidad='" + datos[i].enfoque + "' data-codigo_dane='" + datos[i].nombres + "' data-etnia='" + datos[i].id_etnia + "' data-fuente='CREAENCASA' data-id_localidad='" + datos[i].id_localidad + "' data-estrato='" + datos[i].estrato + "' data-correo='" + datos[i].correo + "' data-sisben='" + (datos[i].sisben == ''?0.0:datos[i].sisben) + "'  href='#'>Cargar Datos"+ "<sub><b>CREAENCASA</b></sub></a>";
					}
					var fila = table_resultado_busqueda.row.add( [
						datos[i].identificacion,
						datos[i].primer_apellido+' '+datos[i].segundo_apellido+' '+datos[i].primer_nombre+' '+datos[i].segundo_nombre,
						' ',' ', //datos[i].GRADO_NOMBRE,datos[i].COLEGIO_NOMBRE,
						boton
						]).draw().node();
				});
			}
		}

		$("#datos_estudiante").show();
	}

	$('input[name=radio_consulta]').on('change', function(){
		$("#datos_estudiante").hide('slow');
		$("#datos_estudiante_emprende_clan").hide('slow');
	});

	$("table").delegate(".cargar_datos_estudiante","click",function(){
		if(linea_atencion == "emprende_clan"){
			var id_beneficario;
			if($(this).data('tipo_origen') != 'simat'){
				id_beneficario = $(this).data("id_estudiante");
				$("#BT_asignar_estudiante_grupo").data('identificacion_beneficiario',$(this).data("identificacion_beneficiario"));
			}else{
				id_beneficario = consultarIDEstudiantePorDocumento($(this).data("id_estudiante"));
				$("#BT_asignar_estudiante_grupo").data('identificacion_beneficiario',$(this).data("id_estudiante"));
			}
			if(validarExistenciaDocumentosAnio(id_beneficario)){
				var nombre = $(this).data("nombre_estudiante");
				var id_estudiante = $(this).data("id_estudiante");
				$("#label_nombre_estudiante").val(nombre);
				$("#label_nombre_estudiante").data("id_estudiante",id_estudiante);
				$("#BT_asignar_estudiante_grupo").data("id_estudiante",id_estudiante);
				$("#BT_asignar_estudiante_grupo").data("tipo_documento",$(this).data("tipo_documento"));
				$("#BT_asignar_estudiante_grupo").data("identificacion_estudiante",$(this).data("id_estudiante"));
				$("#BT_asignar_estudiante_grupo").data("primer_nombre",$(this).data("primer_nombre"));
				$("#BT_asignar_estudiante_grupo").data("segundo_nombre",$(this).data("segundo_nombre"));
				$("#BT_asignar_estudiante_grupo").data("primer_apellido",$(this).data("primer_apellido"));
				$("#BT_asignar_estudiante_grupo").data("segundo_apellido",$(this).data("segundo_apellido"));
				$("#BT_asignar_estudiante_grupo").data("fecha_nacimiento",$(this).data("fecha_nacimiento"));
				$("#BT_asignar_estudiante_grupo").data("genero",$(this).data("genero"));
				$("#BT_asignar_estudiante_grupo").data("direccion_residencia",$(this).data("direccion_residencia"));
				$("#BT_asignar_estudiante_grupo").data("telefono",$(this).data("telefono"));
				$("#BT_asignar_estudiante_grupo").data("pob_vict_conf",$(this).data("pob_vict_conf"));
				$("#BT_asignar_estudiante_grupo").data("tipo_discapacidad",$(this).data("tipo_discapacidad"));
				$("#BT_asignar_estudiante_grupo").data("etnia",$(this).data("etnia"));
				$("#BT_asignar_estudiante_grupo").data("id_grado",$(this).data('id_grado'));
				$("#BT_asignar_estudiante_grupo").data("id_jornada",$(this).data('id_tipo_jornada'));
				$("#BT_asignar_estudiante_grupo").data("estrato",$(this).data('estrato'));
				$("#BT_asignar_estudiante_grupo").data("sisben",$(this).data('sisben'));
				$("#BT_asignar_estudiante_grupo").data("id_localidad",$(this).data('id_localidad'));
				$("#BT_asignar_estudiante_grupo").data("correo",$(this).data('correo'));
				$("#BT_asignar_estudiante_grupo").data("tipo_origen",$(this).data('tipo_origen'));
				$("#BT_asignar_estudiante_grupo").data("fuente",$(this).data('fuente'));
				consultarIDColegioPorCodigoDANE($(this).data("codigo_dane"));

				$("#datos_detallados_estudiante").show('slow');
				$("#resultado_busqueda_estudiantes").hide('fast');
			}else{
				parent.mostrarAlerta("warning","No tiene Documentos","El beneficiario <b>NO</b> tiene documentos de este año, por favor súbalos para continuar el procedimiento de asignación.");
				$("#contenido_modal_formulario_completar_detalle_anio").html(obtenerFormularioCompletarDatos('DocumentosEmprendeAnio'));
				$("#modal_agregar_estudiante_grupo").modal("hide");
				$("#modal_formulario_completar_detalle_anio").modal("show");
				if(linea_atencion == "laboratorio_clan"){
					$("#FILE_archivo_beneficiario_emprende_identificacion").removeAttr("required");
					$("#FILE_archivo_beneficiario_emprende_recibo_publico").removeAttr("required");
					$("#FILE_archivo_beneficiario_emprende_eps").removeAttr("required");
				}
			}
		}else{
			var nombre = $(this).data("nombre_estudiante");
			var id_estudiante = $(this).data("id_estudiante");
			if($(this).data('tipo_origen') != 'simat'){
				id_beneficario = $(this).data("id_estudiante");
				$("#BT_asignar_estudiante_grupo").data('identificacion_beneficiario',$(this).data("identificacion_beneficiario"));
			}else{
				id_beneficario = consultarIDEstudiantePorDocumento($(this).data("id_estudiante"));
				$("#BT_asignar_estudiante_grupo").data('identificacion_beneficiario',$(this).data("id_estudiante"));
			}
			$("#label_nombre_estudiante").val(nombre);
			$("#label_nombre_estudiante").data("id_estudiante",id_estudiante);
			$("#BT_asignar_estudiante_grupo").data("id_estudiante",id_estudiante);
			$("#BT_asignar_estudiante_grupo").data("tipo_documento",$(this).data("tipo_documento"));
			$("#BT_asignar_estudiante_grupo").data("identificacion_estudiante",$(this).data("id_estudiante"));
			$("#BT_asignar_estudiante_grupo").data("primer_nombre",$(this).data("primer_nombre"));
			$("#BT_asignar_estudiante_grupo").data("segundo_nombre",$(this).data("segundo_nombre"));
			$("#BT_asignar_estudiante_grupo").data("primer_apellido",$(this).data("primer_apellido"));
			$("#BT_asignar_estudiante_grupo").data("segundo_apellido",$(this).data("segundo_apellido"));
			$("#BT_asignar_estudiante_grupo").data("fecha_nacimiento",$(this).data("fecha_nacimiento"));
			$("#BT_asignar_estudiante_grupo").data("genero",$(this).data("genero"));
			$("#BT_asignar_estudiante_grupo").data("direccion_residencia",$(this).data("direccion_residencia"));
			$("#BT_asignar_estudiante_grupo").data("telefono",$(this).data("telefono"));
			$("#BT_asignar_estudiante_grupo").data("pob_vict_conf",$(this).data("pob_vict_conf"));
			$("#BT_asignar_estudiante_grupo").data("tipo_discapacidad",$(this).data("tipo_discapacidad"));
			$("#BT_asignar_estudiante_grupo").data("etnia",$(this).data("etnia"));
			$("#BT_asignar_estudiante_grupo").data("id_grado",$(this).data('id_grado'));
			$("#BT_asignar_estudiante_grupo").data("id_jornada",$(this).data('id_tipo_jornada'));
			$("#BT_asignar_estudiante_grupo").data("estrato",$(this).data('estrato'));
			$("#BT_asignar_estudiante_grupo").data("sisben",$(this).data('sisben'));
			$("#BT_asignar_estudiante_grupo").data("id_localidad",$(this).data('id_localidad'));
			$("#BT_asignar_estudiante_grupo").data("correo",$(this).data('correo'));
			$("#BT_asignar_estudiante_grupo").data("tipo_origen",$(this).data('tipo_origen'));
			$("#BT_asignar_estudiante_grupo").data("fuente",$(this).data('fuente'));
			consultarIDColegioPorCodigoDANE($(this).data("codigo_dane"));

			$("#datos_detallados_estudiante").show('slow');
			$("#resultado_busqueda_estudiantes").hide('fast');
		}
	});

	$("body").delegate("#BT_asignar_estudiante_grupo","click", function(e){
		tipo_grupo = $("#tipo_grupo_temp").val();
		// if ($("#sl_pregunta_uno").val()!="" && $("#sl_pregunta_dos").val()!="" && $("#sl_pregunta_tres").val()!="" && $("#sl_pregunta_cuatro").val()!="") {
		// 	bioseguridad = [$("#sl_pregunta_uno").val(), $("#sl_pregunta_dos").val().join(), $("#sl_pregunta_tres").val(), $("#sl_pregunta_cuatro").val()];
		// 	bioseguridad = JSON.stringify(bioseguridad);
		if($(this).data('tipo_origen') == 'simat'){
			datos = {
				p1: {
					'nro_documento': $("#BT_asignar_estudiante_grupo").data("identificacion_estudiante")
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarIdEstudianteByDocumento',
				type:'POST',
				data: datos,
				async:false,
				beforeSend: function(){
					console.log("Mostrando cargando...");
					parent.mostrarCargando();
				}
			}).done(function(data){
				var id_estudiante = 0;
				if(data == "0"){
					id_estudiante = crearEstudiante(tipo_grupo);
				}else{
					id_estudiante = data;
				}
				if (!validarEstudianteDetalleAnio(id_estudiante)){
					crearRegistroDetalleAnioBeneficiarioSIMAT(id_estudiante);
					mensaje += " (Registro <b>(con datos de SIMAT)</b> Detalle Anio para año actual creado) ";
				}
				if(tipo_grupo == "emprende_clan" || tipo_grupo == "laboratorio_clan"){
					if(validarExistenciaDocumentosAnio(id_estudiante)){
						// asignarEstudianteGrupo(id_estudiante, tipo_grupo, bioseguridad);
						asignarEstudianteGrupo(id_estudiante, tipo_grupo);
					}else{
						parent.mostrarAlerta("warning","No tiene Documentos","El beneficiario <b>NO</b> tiene documentos de este año, por favor subalos para continuar el procedimiento de asignación.");
						$("#contenido_modal_formulario_completar_detalle_anio").html(obtenerFormularioCompletarDatos('DocumentosEmprendeAnio'));
						$("#modal_agregar_estudiante_grupo").modal("hide");
						$("#modal_formulario_completar_detalle_anio").modal("show");
						if(tipo_grupo == "laboratorio_clan"){
							$("#FILE_archivo_beneficiario_emprende_identificacion").removeAttr("required");
							$("#FILE_archivo_beneficiario_emprende_recibo_publico").removeAttr("required");
							$("#FILE_archivo_beneficiario_emprende_eps").removeAttr("required");
						}
					}

				}else{
					// asignarEstudianteGrupo(id_estudiante, tipo_grupo, bioseguridad);
					asignarEstudianteGrupo(id_estudiante, tipo_grupo);
				}
				parent.cerrarCargando();
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta("error",'Error','No se ha podido asignar el estudiante al grupo ' + textStatus);
			});
		}else if($(this).data('tipo_origen') == 'creaencasa'){
			datos = {
				p1: {
					'nro_documento': $("#BT_asignar_estudiante_grupo").data("identificacion_estudiante")
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarIdEstudianteByDocumento',
				type:'POST',
				data: datos,
				async:false,
				beforeSend: function(){
					console.log("Mostrando cargando...");
					parent.mostrarCargando();
				}
			}).done(function(data){
				var id_estudiante = 0;
				if(data == "0"){
					id_estudiante = crearEstudiante(tipo_grupo);
				}else{
					id_estudiante = data;
				}
				// asignarEstudianteGrupo(id_estudiante, tipo_grupo, bioseguridad);
				asignarEstudianteGrupo(id_estudiante, tipo_grupo);
			});
		}else if($(this).data('tipo_origen') == 'historico_crea'){
			// asignarEstudianteGrupo($(this).data('id_estudiante'), tipo_grupo, bioseguridad);
			asignarEstudianteGrupo($(this).data('id_estudiante'), tipo_grupo);
		}
		// }
		// else{
		// 	parent.mostrarAlerta("warning","Cuestionario de Bioseguridad","Para poder asignar el Beneficiario al grupo, debe diligenciar todo el Cuestionario de Bioseguridad.");
		// }
		mensaje = "Estudiante ";
	});

	$("#BT_cancelar_retiro_estudiante").click(function(){
		$("#table_estudiantes_remover").show("fast");
		$("#justificacion_remover_estudiante").hide("slow");
	});

	$("#BT_remover_beneficiarios_masivo_grupo").click(function(){
		var id_grupo = $(this).data("id_grupo");
		var tipo_grupo = $("#tipo_grupo_temp").val();
		var justificacion_retiro = $("#SL_justificacion_remover_estudiante").val();
		parent.swal({
			title: 'Va a remover beneficiarios de forma masiva',
			text: "¿Está seguro?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, remover beneficiarios!',
			cancelButtonText: 'Cancelar y verificar datos'
		}).then(function(){
			var CH_remover_beneficiario = new Array();
			$('.remover_estudiante_grupo_masivo').each(function() {
				CH_remover_beneficiario.push(new Array($(this).data('id_estudiante'),$(this).prop('checked')));
			});
			datos = {
				p1: {
					'CH_beneficiario': CH_remover_beneficiario,
					'id_grupo': id_grupo,
					'tipo_grupo': tipo_grupo,
					'justificacion': justificacion_retiro,
					'id_usuario': parent.idUsuario
				}
			};
			$.ajax({
				url:url_ok_obj+'removerBeneficiarioMasivo',
				type:'POST',
				data: datos
			}).done(function(data){
				parent.mostrarAlerta("success","Beneficiarios Retirados","Se han retirado satisfactoriamente los beneficiarios de forma masiva.");
				cargarEstudiantesParaRemoverEnGrupo(id_grupo,tipo_grupo);
				cargarTablaGrupos(tipo_grupo);
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('error','Error','No se ha podido modificar la asistencia ' + textStatus);
			});
		}, function(dismiss){
			console.log("Cancelada la promesa");
			return false;
		});
	});

	$("table").delegate(".remover_estudiante_grupo","click",function(){
		var id_estudiante = $(this).data("id_estudiante");
		var id_grupo = $(this).data("id_grupo");
		var nombre_estudiante = $(this).data('nombre_estudiante');
		$("#label_nombre_estudiante_retirar_grupo").text(nombre_estudiante);
		$("#BT_remover_estudiante_grupo").data("id_estudiante",id_estudiante);
		$("#BT_remover_estudiante_grupo").data("id_grupo",id_grupo);
		$("#justificacion_remover_estudiante").show("slow");
		$("#table_estudiantes_remover").hide("fast");
	});

	$("#BT_remover_estudiante_grupo").click(function(){
		var id_estudiante = $(this).data("id_estudiante");
		var id_grupo = $(this).data("id_grupo");
		var tipo_grupo = $("#tipo_grupo_temp").val();
		var justificacion_retiro = $("#SL_justificacion_remover_estudiante").val();
		removerEstudianteGrupo(id_estudiante,id_grupo,justificacion_retiro);
		$("#table_estudiantes_remover").show("fast");
		$("#justificacion_remover_estudiante").hide("slow");
	});

	$("#BT_cancelar_retiro_estudiante").click(function(){
		$("#table_estudiantes_remover").show("fast");
		$("#justificacion_remover_estudiante").hide("slow");
	});

	$("#SL_crea_cargar_grupos").html(parent.getOptionsClanes()).selectpicker("refresh").change(function(){
		cargarTablaGrupos($("#tipo_grupo_temp").val());
	}).trigger("change");

	$("#SL_justificacion_remover_estudiante").html(getRazonesRetiroEstudiante()).change(function(){
		var valor_select = $(this).val();
		if (valor_select == "Otro") {
			var cual_razon = "";
			parent.swal({
				title: "Escriba la razón del retiro:",
				input: 'text',
				showCancelButton: true,
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'Enviar',
			}).then((result) => {
				cual_razon = "Retirado por otro - " + result;
				$("#SL_justificacion_remover_estudiante").append("<option val='" + cual_razon +"'>" + cual_razon + "</option>").val(cual_razon).selectpicker("refresh");
			}).catch(parent.swal.noop);
		}
	}).selectpicker("refresh");
	$("#justificacion_remover_estudiante").hide();

	$("#table_grupos_emprende_clan").delegate(".add_estudiante_ensamble","click",function(){
		$("#id_grupo_ensamble").val($(this).data('id_grupo'));
		$("#SL_clan_grupo_ensamble_seleccionar_estudiante").html(parent.getOptionsClanes()).val($("#SL_crea_cargar_grupos").val()).selectpicker("refresh").trigger("change");
	});
	$("#SL_clan_grupo_ensamble_seleccionar_estudiante").change(function(){
		$("#SL_grupo_ensamble_seleccionar_estudiante").html(parent.getOptionGruposDeUnCrea($(this).val())).selectpicker('refresh');
		$("#SL_grupo_ensamble_seleccionar_estudiante").trigger("change");
	});

	$("#SL_grupo_ensamble_seleccionar_estudiante").change(function(){
		datos = {
			p1: {
				'id_grupo': $(this).val(),
				'estado': 1,
				'tipo_mostrar': 'ensamble'
			},p2: 'emprende_clan'
		};
		$.ajax({
			url: url_ok_obj+'consultarEstudiantesPorEstadoGrupo',
			type:'POST',
			data: datos,
			async:false
		}).done(function(data){
			table_estudiante_ensamble.clear().draw();
			table_estudiante_ensamble.rows.add($(data)).draw();
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido consultar los estudiantes activos del grupo ' + textStatus);
		});
	});

	$("#table_estudiante_ensamble").delegate(".asignar_estudiante_grupo_ensamble","click",function(){
		datos = {
			p1: {
				'id_grupo': $("#id_grupo_ensamble").val(),
				'id_estudiante': $(this).data('id_estudiante'),
				'id_usuario': parent.idUsuario,
				// 'bioseguridad': '[]',
				'observacion' : "Ensamble"
			},p2: 'emprende_clan'
		};
		$.ajax({
			url: url_asignacion_obj+'asignarEstudianteGrupo',
			type:'POST',
			data: datos,
			async:false
		}).done(function(data){
			if(data != 1){
				parent.mostrarAlerta("warning","Algo inesperado ha ocurrido","Error! Por favor verifique el listado de estudiantes, al parecer no se ha podido asignar este estudiante al grupo pues ya estaba registrado");
			}else{
				parent.mostrarAlerta("success","Estudiante asignado","El estudiante fue asignado al <b>Grupo Ensamble</b>");
				cargarTablaGrupos($("#tipo_grupo_temp").val());
			}
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido asignar el estudiante. ' + textStatus);
		});
	});

	$(".nav-item").click(function(){
		cargarTablaGrupos($(this).data('tipo_grupo'));
	});

	$("#contenido_modal_formulario_completar_detalle_anio").delegate("[name^='FILE_archivo_beneficiario']","change",function(){
		var nombres_archivos = "";
		var files = $("input[name^='FILE_archivo_beneficiario_emprende']");
		for (var i = 0, f; f = files[i]; i++) {
			try{
				nombres_archivos += (files[i].files[0]['name']) + "<br>";
			}catch(err){
				console.log(err);
			}
		}
		$("#archivos_adjuntos_beneficiario_emprende").html(nombres_archivos);
	});

	$("#nav_grado").click(function(){
		$("#div_campo_busqueda_grado").show('slow');
		$("#div_campo_busqueda_nombres").hide('fast');
		$("#div_campo_busqueda_documento").hide('fast');
		$("#div_mensaje").hide('fast');
		$("#resultado_busqueda_estudiantes").hide('fast');
	});

	$("#nav_individual").click(function(){
		$("#div_mensaje").show('slow');
		$("#div_campo_busqueda_documento").show('slow');
		$("#div_campo_busqueda_nombres").hide('fast');
		$("#div_campo_busqueda_grado").hide('fast');
		$("#resultado_busqueda_estudiantes").hide('fast');
		$("#CH_tipo_consulta_estudiante").bootstrapToggle("off");
	});

	function cargarTablaGrupos(tipo_grupo){
		var datos = {
			p1 : {
				'id_crea': $("#SL_crea_cargar_grupos").val(),
				'tipo_grupo' : tipo_grupo
			}
		};
		$.ajax({
			url: url_ok_obj+'consultarTablaGrupos',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			switch (tipo_grupo) {
				case 'arte_escuela':
				table_grupos_arte_escuela.clear().draw();
				table_grupos_arte_escuela.rows.add($(data)).draw();
				$("#menu_busqueda").show();
				break;
				case 'emprende_clan':
				table_grupos_emprende_clan.clear().draw();
				table_grupos_emprende_clan.rows.add($(data)).draw();
				$("#menu_busqueda").hide();
				break;
				case 'laboratorio_clan':
				table_grupos_laboratorio_clan.clear().draw();
				table_grupos_laboratorio_clan.rows.add($(data)).draw();
				$("#menu_busqueda").hide();
				break;
				default:
				console.log("Tipo grupo para cargar tabla no valido");
				break;
			}
		}).fail(function(textStatus){
			console.log(textStatus);
			parent.mostrarAlerta("error",'Error','No se ha podido cargar la tabla de grupos. ' + textStatus);
		});
	}

	function cargarGrados(){
		var datos = {
			funcion : "getOptionsGrados"
		}

		$.ajax({
			url: url_service_options,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#SL_grado").html(data).selectpicker("refresh");	;			
		});
	}	

	function cargarColegioPorGrupo(id_grupo){
		var datos = {
			p1 : {
				'id_grupo': id_grupo
			}
		};

		$.ajax({
			url: url_ok_obj+'getColegiosGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			datos = $.parseJSON(data);
			$("#div_colegio").html(datos[0]['VC_Nom_Colegio']);		
			$("#div_colegio").data("dane_colegio",datos[0]['VC_DANE_12']);
		});
	}

	function cargarEstudiantesParaRemoverEnGrupo(id_grupo,tipo_grupo){
		datos = {
			p1: {
				'id_grupo': id_grupo,
				'estado': 1,
				'tipo_mostrar' : 'remover'
			},p2: tipo_grupo
		};
		$.ajax({
			url: url_ok_obj+'consultarEstudiantesPorEstadoGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			table_remover_estudiante.draw().on( 'draw', function () {
				$('.remover_estudiante_grupo_masivo').bootstrapToggle({
					on: 'SÍ',
					off: 'NO',
					onstyle: 'danger',
					offstyle: 'success'
				});
			});
			table_remover_estudiante.clear().draw();
			table_remover_estudiante.rows.add($(data)).draw();
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido consultar los estudiantes para remover del grupo" + data);
		});
	}

	function removerEstudianteGrupo(id_estudiante,id_grupo,justificacion_retiro){
		var datos = {
			p1:{
				'id_estudiante': id_estudiante,
				'id_grupo': id_grupo,
				'tipo_grupo': $("#tipo_grupo_temp").val(),
				'justificacion': justificacion_retiro,
				'id_usuario': parent.idUsuario
			}
		};
		$.ajax({
			url: url_asignacion_obj+'removerEstudianteGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			cargarTablaGrupos($("#tipo_grupo_temp").val());
			cargarEstudiantesParaRemoverEnGrupo(id_grupo,$("#tipo_grupo_temp").val());
			parent.mostrarAlerta("success","Estudiante removido","Ha sido removido exitosamente del grupo AE-" + id_grupo);
		});
	}

	function getRazonesRetiroEstudiante(){
		var mostrar = "";
		var razon = parent.getParametroDetalle(29);
		for (var i = 0; i < razon.length; i++) {
			mostrar += "<option value='" + razon[i]['VC_Descripcion'] + "'>" + razon[i]['VC_Descripcion'] + "</option>";
		}
		mostrar += "<option value='Otro'>Otro</option>";
		return mostrar;
	}

	function validarExistenciaEstudianteEnGrupo(nro_documento,tipo_grupo){
		$id_grupo = 0;
		datos = {
			p1: {
				'nro_documento': nro_documento,
				'tipo_grupo' : tipo_grupo
			}
		};
		$.ajax({
			url: url_asignacion_obj+'consultarGruposActivosEstudiantePorDocumento',
			type:'POST',
			data: datos,
			async:false
		}).done(function(data){
			$id_grupo = data;
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido cargar los grupos en los cuales se encuentra activo el estudiante. ' + textStatus);
		});
		return $id_grupo;
	}

	function crearEstudiante(tipo_grupo){
		var date = new Date();
		var year = date.getFullYear();
		datos = {
			p1: {
				'nro_documento': $("#BT_asignar_estudiante_grupo").data('id_estudiante'),
				'tipo_documento': $("#BT_asignar_estudiante_grupo").data("tipo_documento"),
				'primer_nombre': $("#BT_asignar_estudiante_grupo").data("primer_nombre"),
				'segundo_nombre': $("#BT_asignar_estudiante_grupo").data("segundo_nombre"),
				'primer_apellido': $("#BT_asignar_estudiante_grupo").data("primer_apellido"),
				'segundo_apellido': $("#BT_asignar_estudiante_grupo").data("segundo_apellido"),
				'fecha_nacimiento': $("#BT_asignar_estudiante_grupo").data("fecha_nacimiento"),
				'genero': $("#BT_asignar_estudiante_grupo").data("genero"),
				'direccion_residencia': $("#BT_asignar_estudiante_grupo").data("direccion_residencia"),
				'correo': $("#BT_asignar_estudiante_grupo").data("correo"),
				'telefono': $("#BT_asignar_estudiante_grupo").data("telefono"),
				'celular': '',
				'fuente': $("#BT_asignar_estudiante_grupo").data("fuente"),
				'id_usuario': parent.idUsuario,
				'anio':year,
				'id_crea': $("#SL_crea_cargar_grupos").val(),
				'id_colegio': $("#BT_asignar_estudiante_grupo").data("id_colegio"),
				'id_grado': $("#BT_asignar_estudiante_grupo").data("id_grado"),
				'id_jornada': $("#BT_asignar_estudiante_grupo").data("id_jornada"),
				'tipo_afiliacion': '',
				'nombre_acudiente': '',
				'identificacion_acudiente': '',
				'telefono_acudiente': '',
				'id_grupo_poblacional': '6',
				'id_eps': '0',
				'rh': '9',
				'enfermedades': '',
				'id_localidad': $("#BT_asignar_estudiante_grupo").data("id_localidad"),
				'barrio': '',
				'id_tipo_poblacion_victima': $("#BT_asignar_estudiante_grupo").data("pob_vict_conf"),
				'id_tipo_discapacidad': $("#BT_asignar_estudiante_grupo").data("tipo_discapacidad"),
				'id_etnia': $("#BT_asignar_estudiante_grupo").data("etnia"),
				'estrato': $("#BT_asignar_estudiante_grupo").data("estrato"),
				'sisben': $("#BT_asignar_estudiante_grupo").data("sisben"),
				'observaciones_detalle_anio': $("#TX_observaciones_asignacion_estudiante").val()
			}
		};
		var id_estudiante = "";
		mensaje = "Estudiante ";
		$.ajax({
			url: url_asignacion_obj+'crearEstudiante',
			type:'POST',
			data: datos,
			async:false
		}).done(function(data){
			id_estudiante = data;
			mensaje += "creado en el sistema y ";
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido asignar el estudiante al grupo ' + textStatus);
			console.log('No se ha podido asignar el estudiante al grupo ' + textStatus);
		});
		return id_estudiante;
	}

	/* Metodo generalizado para los 3 tipos de Grupo */
	// function asignarEstudianteGrupo(id_estudiante, tipo_grupo, bioseguridad){
	function asignarEstudianteGrupo(id_estudiante, tipo_grupo){
		if (validarEstudianteDetalleAnio(id_estudiante))
		{
			var datos = {
				p1: {
					'id_estudiante': id_estudiante,
					'id_grupo' : $("#BT_asignar_estudiante_grupo").data("id_grupo"),
					'observacion' : $("#TX_observaciones_asignacion_estudiante").val(),
					// 'bioseguridad' : bioseguridad,
					'id_usuario': parent.idUsuario
				},
				p2: tipo_grupo
			};
			$.ajax({
				url: url_asignacion_obj+'asignarEstudianteGrupo',
				type:'POST',
				data: datos,
				async:false
			}).done(function(data){
				if(data == 1){
					parent.mostrarAlerta("success","Beneficiario Asignado","");
					console.log(1);
					// parent.mostrarAlerta("success","Exito", mensaje + "asignado al grupo.");
					//$("#modal_agregar_estudiante_grupo").modal("hide");
				}else if(data == 2){
					parent.mostrarAlerta("success","Beneficiario Asignado","");
					// parent.mostrarAlerta("success","Reintegro exitoso","El estudiante ya había sido asignado anteriormente a este grupo y fue removido, se ha reintegrado al grupo satisfactoriamente.");
					console.log(2);
				}else{
					parent.mostrarAlerta("error","Error","No se ha podido asignar el estudiante al grupo");
					console.log("No se ha podido asignar el estudiante al grupo");
				}
				$("#resultado_busqueda_estudiantes").hide('fast');
				$("#datos_detallados_estudiante").hide('fast');
				//parent.mostrarAlerta("success","Beneficiario Asignado","");
				$("#sl_pregunta_uno").val("").selectpicker("refresh");
				$("#sl_pregunta_dos").val("").selectpicker("refresh");
				$("#sl_pregunta_tres").val("").selectpicker("refresh");
				$("#sl_pregunta_cuatro").val("").selectpicker("refresh");
				$("#TX_observaciones_asignacion_estudiante").val("");
				cargarTablaGrupos($("#tipo_grupo_temp").val());
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta('error','Error','No se ha podido asignar el estudiante al grupo ' + textStatus);
			});
		}else{
			parent.mostrarAlerta("warning","Falta información de este año","Este estudiante fue creado en años anteriores. <b><i>No se encuentra en SIMAT</i></b> y falta actualizar los datos para este año.<br>Por favor actualice los datos de este estudiante a continuación.");
			$("#contenido_modal_formulario_completar_detalle_anio").html(obtenerFormularioCompletarDatos('DetalleAnio'));
			$("#modal_agregar_estudiante_grupo").modal("hide");
			$("#modal_formulario_completar_detalle_anio").modal("show");
			try{
				$("#SL_crea_detalle_anio").html(parent.getOptionsClanes()).val($("#SL_crea_cargar_grupos").val()).change(function(){
					$("#SL_colegio_detalle_anio").html(parent.getOptionsColegiosCrea($(this).val(),0)).selectpicker("refresh");
				}).trigger("change");
				$("#SL_colegio_detalle_anio").html(parent.getOptionsColegiosCrea($("#SL_crea_detalle_anio").val(),0));
				$("#SL_grado_detalle_anio").html(parent.getOptionsGrados());
				$("#SL_grupo_poblacional_detalle_anio").html(parent.getOptionsGPoblacional());
				$("#SL_eps_detalle_anio").html(parent.getOptionsEPS());
				$("#SL_localidad_detalle_anio").html(parent.getOptionsLocalidad());
				
				$("#SL_jornada_detalle_anio").html(parent.getOptionsParametroDetalle(11));
				$("#SL_poblacion_victima_detalle_anio").html(parent.getOptionsParametroDetalle(9));
				$("#SL_tipo_discapacidad_detalle_anio").html(parent.getOptionsParametroDetalle(10));
				$("#SL_etnia_detalle_anio").html(parent.getOptionsParametroDetalle(33));

				$("#div_tiene_experiencia_detalle_anio").hide();
				$("#SL_area_artistica_interes_detalle_anio").html(parent.getOptionsAreasArtisticas());
				$("#CH_area_artistica_interes_experiencia_detalle_anio").bootstrapToggle({
					on: 'SÍ TIENE',
					off: 'NO TIENE',
					onstyle: 'success',
					offstyle: 'danger'
				}).change(function(){
					if($(this).prop("checked")){
						$("#div_tiene_experiencia_detalle_anio").show("slow");
						datos_beneficiario['experiencia'] = 1;
					}else{
						datos_beneficiario['experiencia'] = 0;
						datos_beneficiario['experiencia_academia'] = 0;
						datos_beneficiario['experiencia_empirica'] = 0;
						$("#div_tiene_experiencia_detalle_anio").hide("slow");
					}
				});
			}catch(err){

			}finally{
				$(".selectpicker").selectpicker("refresh");
				precargarDatosBeneficiarioAnioAnterior(id_estudiante);
				switch(tipo_grupo){
					case 'arte_escuela':
						$("#SL_tipo_afiliacion_detalle_anio").attr("required","required");
						break;
					case 'emprende_clan':
						$("#SL_tipo_afiliacion_detalle_anio").attr("required","required");
						break;
					case 'laboratorio_clan':
						$("#SL_tipo_afiliacion_detalle_anio").removeAttr("required");
						break;
					default:
						console.log("No se reconoce el tipo grupo");
						break;
				}
			}
		}
	}

	function consultarIDColegioPorCodigoDANE(codigo_dane){
		$.ajax({
			url: url_ok_obj+'consultarIDColegioPorCodigoDANE',
			type: 'POST',
			data: {
				'p1': codigo_dane
			},
			async: false
		}).done(function(resultado){
			$("#BT_asignar_estudiante_grupo").data("id_colegio",resultado);
		}).fail(function(result){
			console.log(result);
			parent.mostrarAlerta("error","Error","No se ha podido consultar el id colegio segun el código dane");
		});
	}

	$('iframe').ready(function(){
		var d = getUrlVars();
		if(d["option_ext"] == "remover_estudiante"){
			$("#BT_remover_beneficiarios_masivo_grupo").data("id_grupo",d["id_grupo"]);
			irDirectoARemoverEstudiante(d["tipo_grupo"],d["id_grupo"],d["identificacion_estudiante"]);
		}
	});

	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}

	function irDirectoARemoverEstudiante(tipo_grupo,id_grupo,identificacion_estudiante){
		$(".nav-item").removeClass("active");
		$(".tab-pane").removeClass("active");
		var datos = {
			p1:{
				tipo_grupo: tipo_grupo,
				id_grupo: id_grupo
			}
		}
		$.ajax({
			url: url_ok_obj+'consultarIDCreaPorGrupo',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			console.log(data);
			var tipo_grupo_lt = '';
			$("#SL_crea_cargar_grupos").val(data).trigger("change").selectpicker("refresh");
			$("#nav_"+tipo_grupo).addClass("active").trigger("click");
			$("#modal_remover_estudiante_grupo").modal("show");
			cargarEstudiantesParaRemoverEnGrupo(id_grupo,tipo_grupo);
			$("#title_modal_remover_estudiante").html("Remover estudiante(s) del grupo: " + tipo_grupo + " -" + id_grupo);
			$("#grupos_"+tipo_grupo).addClass("active");
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido precargar los datos del estudiante para remover del grupo");
			console.error(data);
		});
		$("#table_grupos_" + tipo_grupo).DataTable().search(id_grupo).draw();
		$("#table_remover_estudiante").DataTable().search(identificacion_estudiante).draw();
	}

	function validarEstudianteDetalleAnio(id_estudiante){
		var resultado_validacion = false;
		var datos = {
			p1: id_estudiante
		}
		$.ajax({
			url: url_asignacion_obj+'validarEstudianteDetalleAnio',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data == 1){
				resultado_validacion = true;
			}else{
				resultado_validacion = false;
			}
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido validar la existencia detalle_anio para el beneficiario.");
			console.log("No se ha podido validar la existencia detalle_anio para el beneficiario.");
			console.error(data);
		});
		return resultado_validacion;
	}

	function crearRegistroDetalleAnioBeneficiarioSIMAT(id_estudiante){
		var datos_beneficiario = {
			'id_localidad': '0',
			'id_eps': '0',
			'rh': '9',
			'id_grupo_poblacional': '6',
			'tipo_afiliacion': '',
			'nombre_acudiente': '',
			'identificacion_acudiente': '',
			'telefono_acudiente': '',
			'barrio': '',
			'enfermedades': '',
			'id_area_artistica_interes': '1',
			'experiencia' : '0',
			'experiencia_academia' : '0',
			'experiencia_empirica' : '0',
			'experiencia_anios' : '0',
			'id_estudiante': id_estudiante,
			'id_tipo_poblacion_victima': $("#BT_asignar_estudiante_grupo").data("pob_vict_conf"),
			'id_tipo_discapacidad': $("#BT_asignar_estudiante_grupo").data("tipo_discapacidad"),
			'id_usuario': parent.idUsuario,
			'id_crea': $("#SL_crea_cargar_grupos").val(),
			'id_colegio': $("#BT_asignar_estudiante_grupo").data("id_colegio"),
			'id_grado': $("#BT_asignar_estudiante_grupo").data("id_grado"),
			'id_jornada': $("#BT_asignar_estudiante_grupo").data("id_jornada"),
			'id_etnia': $("#BT_asignar_estudiante_grupo").data("etnia"),
			'estrato': $("#BT_asignar_estudiante_grupo").data("estrato"),
			'sisben': $("#BT_asignar_estudiante_grupo").data("sisben"),
			'observaciones_detalle_anio': $("#TX_observaciones_asignacion_estudiante").val()
		};
		var data_form = new FormData();
		data_form.append("p1",JSON.stringify(datos_beneficiario));
		$.ajax({
			url: url_asignacion_obj+'crearRegistroDetalleAnio',
			type:'POST',
			data: data_form,
			processData: false, // Don't process the files
      		contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			async:false
		}).done(function(data){
			console.log(data);
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido crear el registro DetalleAnio');
			console.log('Error','No se ha podido crear el registro DetalleAnio');
		});
	}

	function obtenerFormularioCompletarDatos(tipo_formulario){
		var mostrar = '';
		var datos = {
			p1: {
				'tipo_formulario': tipo_formulario
			}
		}
		$.ajax({
			url: url_beneficiario_controller+'obtenerFormulario',
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

	function precargarDatosBeneficiarioAnioAnterior(id_beneficiario){
		$("#BT_asignar_estudiante_grupo").data('id_estudiante',id_beneficiario)
		var datos = {
			p1: id_beneficiario,
			p2: ((new Date).getFullYear())-1
		};
		$.ajax({
			url: url_beneficiario_controller+'consultarEstudianteDetalleAnio',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			try{
				data = $.parseJSON(data)[0];
				$("#SL_colegio_detalle_anio").val(data['FK_colegio']);
				$("#SL_grado_detalle_anio").val(data['FK_grado']);
				$("#SL_jornada_detalle_anio").val(data['jornada']);
				$("#SL_poblacion_victima_detalle_anio").val(data['FK_tipo_poblacion_victima']);
				$("#SL_tipo_discapacidad_detalle_anio").val(data['FK_tipo_discapacidad']);
				$("#SL_etnia_detalle_anio").val(data['TX_etnia']);
				$("#TX_nombre_acudiente_detalle_anio").val(data['NOMBRE_ACUDIENTE']);
				$("#TX_numero_documento_acudiente_detalle_anio").val(data['IDENTIFICACION_ACUDIENTE']);
				$("#TX_telefono_acudiente_detalle_anio").val(data['TELEFONO_ACUDIENTE']);
				$("#SL_grupo_poblacional_detalle_anio").val(data['FK_Grupo_Poblacional']);
				$("#SL_tipo_afiliacion_detalle_anio").val(data['TX_Tipo_Afiliacion']);
				$("#SL_eps_detalle_anio").val(data['FK_Eps']);
				$("#TX_enfermedades_detalle_anio").val(data['TX_Enfermedades']);
				$("#SL_localidad_detalle_anio").val(data['FK_Localidad']);
				$("#TX_barrio_detalle_anio").val(data['TX_Barrio']);
				$("#IN_estrato_detalle_anio").val(data['IN_estrato']);
				$("#IN_puntaje_sisben_detalle_anio").val(data['sisben']);
				$("#SL_area_artistica_interes_detalle_anio").val(data['FK_area_artistica_interes']);
				$("#IN_experiencia_anios_detalle_anio").val(data['IN_anios_experiencia']);
				if(data['IN_tiene_experiencia'] == 1){
					if(data['IN_experiencia_empirica'] == 1 && data['IN_experiencia_academica'] == 0){
							$("#SL_tipo_experiencia_detalle_anio").val(1).selectpicker("refresh");
						}else if(data['IN_experiencia_empirica'] == 0 && data['IN_experiencia_academica'] == 1){
							$("#SL_tipo_experiencia_detalle_anio").val(2).selectpicker("refresh");
						}else if(data['IN_experiencia_empirica'] == 1 && data['IN_experiencia_academica'] == 1){
							$("#SL_tipo_experiencia_detalle_anio").val(3).selectpicker("refresh");
						}
						$("#CH_area_artistica_interes_experiencia_detalle_anio").bootstrapToggle('on');
				}else{
					$("#CH_area_artistica_interes_experiencia_detalle_anio").bootstrapToggle("off");
				}
			}catch(err){
				parent.mostrarAlerta("warning","Falta información","No se ha podido cargar datos del año anterior. Por favor diligencie todo el formulario para completar la información del Beneficiario.");
			}finally{
				$(".selectpicker").selectpicker("refresh");
			}
			console.log(data);
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido consultar los datos del año anterior del beneficiario: " + id_beneficiario);
			console.log(data);
		});		
	}

	function validarExistenciaDocumentosAnio(id_beneficiario){
		var resultado = false;
		var datos = {
			p1: id_beneficiario
		}
		$.ajax({
			url: url_beneficiario_controller+'validarExistenciaDocumentosAnio',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			if(data != 0){
				resultado = true;
			}
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido consultar si el beneficiario tiene documentos para este año: " + id_beneficiario);
			console.log("warning","Error","No se ha podido consultar si el beneficiario tiene documentos para este año: " + id_beneficiario);
			console.log(data);
		});
		// return resultado;
		return true;
	}

	function consultarIDEstudiantePorDocumento(numero_documento){
		var resultado = "";
		var datos = {
			p1: numero_documento
		};
		$.ajax({
			url: url_beneficiario_controller+'consultarIDEstudiantePorDocumento',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			resultado = data;
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido consultar si el beneficiario tiene documentos para este año: " + id_beneficiario);
			console.log(data);
		});
		return resultado;
	}
});
