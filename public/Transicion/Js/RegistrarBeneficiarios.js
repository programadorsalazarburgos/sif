var url_ok_obj = '../../src/GestionClan/GestionClanController/';
var url_beneficiario_controller = '../../src/Beneficiario/BeneficiarioController/';
var url_asignacion_obj = '../../src/GestionClan/AsignacionController/';
var servicio_simat = "https://sif.idartes.gov.co/ws-simat/index.php/";

var id_grupo_transicion_asignar = 0;

$(function(){
	var table_grupos = $("#table_grupos").DataTable({
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

	var datos = {
		p1 : {}
	};
	$.ajax({
		url: url_ok_obj+'consultarTablaGruposTransicion',
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		// console.log(data);
		table_grupos.clear().draw();
		table_grupos.rows.add($(data)).draw();
	}).fail(function(textStatus){
		console.log(textStatus);
		parent.mostrarAlerta("error",'Error','No se ha podido cargar la tabla de grupos. ' + textStatus);
	});

	$("#table_grupos").delegate(".asignar_beneficiario_grupo","click",function(ev){
		id_grupo_transicion_asignar = $(this).data("id_grupo");
	});

	$("#resultado_busqueda_estudiantes").hide();
	$("#datos_detallados_estudiante").hide();
	$("#div_campo_busqueda_nombres").hide();

	$("#CH_tipo_consulta_estudiante").change(function(ev){
		$("#resultado_busqueda_estudiantes").hide('fast');
		$("#datos_detallados_estudiante").hide('fast');
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
		var tipo_grupo = "transicion";
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
					'tipo_grupo' : 'transicion',
					'id_grupo' : id_grupo_transicion_asignar,
					'tipo_grupo_atencion' : 'transicion'
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
					'tipo_grupo' : 'transicion',
					'id_grupo' : id_grupo_transicion_asignar,
					'tipo_grupo_atencion' : 'transicion'
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarEstudianteEnTbBeneficiarioNidos',
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
		}
		if(resulatado_array.length == 0){
			parent.mostrarAlerta("warning","Lo sentimos","No se han encontrado coincidencias en la información de Matricula Estudiantil, el historico de beneficiarios atendidos por CREA ni el historico de beneficiarios NIDOS.");
			mostrarResultadoBusqueda(resulatado_array,tipo_grupo,tipo_origen_estudiante);
			$("#resultado_busqueda_estudiantes").show('fast');
			$("opcion_crear_estudiante").show('fast');
			linea_atencion = tipo_grupo;
		}else{
			$(".opcion_crear_estudiante").hide('fast');
		}
	});

	$("table").delegate(".cargar_datos_estudiante","click",function(){
		var nombre = $(this).data("nombre_estudiante");
		var id_estudiante = $(this).data("id_estudiante");
		if($(this).data('tipo_origen') == 'historico_crea'){
			id_beneficario = $(this).data("id_estudiante");
			$("#BT_asignar_estudiante_grupo").data('identificacion_beneficiario',$(this).data("identificacion_beneficiario"));
		}else if($(this).data('tipo_origen') == 'historico_nidos'){
			console.log("Nidos");
		}else{
			console.log("simat");
			id_beneficario = consultarIDEstudiantePorDocumento($(this).data("id_estudiante"));
			console.log(id_beneficario);
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
		$("#BT_asignar_estudiante_grupo").data("id_grupo_poblacional",$(this).data('id_grupo_poblacional'));
		$("#BT_asignar_estudiante_grupo").data("tipo_origen",$(this).data('tipo_origen'));

		$("#datos_detallados_estudiante").show('slow');
		$("#resultado_busqueda_estudiantes").hide('fast');
	});

	$("#BT_asignar_estudiante_grupo").click(function(event){
		event.preventDefault();
		var tipo_origen = $(this).data('tipo_origen');
		var id_estudiante = 0;
		console.log(tipo_origen);
		if(tipo_origen != 'historico_crea'){
			datos = {
				p1: {
					'nro_documento': $("#BT_asignar_estudiante_grupo").data("identificacion_estudiante")
				}
			};
			$.ajax({
				url: url_ok_obj+'consultarIdEstudianteByDocumento',
				type:'POST',
				data: datos,
				async:false
			}).done(function(data){
				if(data == "0"){
					id_estudiante = crearEstudiante(tipo_origen);
				}else{
					id_estudiante = data;
				}
			}).fail(function(jqXHR,textStatus){
				parent.mostrarAlerta("error",'Error','No se ha podido asignar el estudiante al grupo ' + textStatus);
			});
		}else{
			id_estudiante = $(this).data('id_estudiante');
		}
		var datos = {
			p1: {
				'id_grupo': id_grupo_transicion_asignar,
				'id_beneficario': id_estudiante,
				'id_usuario': parent.idUsuario,
				'observaciones': $("#TX_observaciones_asignacion_estudiante").val()
			}
		};
		$.ajax({
			url: url_ok_obj+'asignarBeneficiarioGrupoTransicion',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			console.log(data);
			$("#BT_buscar_estudiante").trigger("click");

			var datos = {
				p1 : {}
			};
			$.ajax({
				url: url_ok_obj+'consultarTablaGruposTransicion',
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){
				// console.log(data);
				table_grupos.clear().draw();
				table_grupos.rows.add($(data)).draw();
			}).fail(function(textStatus){
				console.log(textStatus);
				parent.mostrarAlerta("error",'Error','No se ha podido cargar la tabla de grupos. ' + textStatus);
			});

		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido podido asignar el beneficiario al grupo ");
			console.log(data);
		});
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
			$.each(datos, function(i){
				var boton = "";
				var id_grupo_actual_estudiante = validarExistenciaEstudianteEnGrupo(datos[i].NRO_DOCUMENTO,tipo_grupo);
				if(id_grupo_actual_estudiante != 0){
					boton = "<a class='btn btn-warning'>En grupo " + id_grupo_actual_estudiante  + "</a>";
				}else{
					boton = "<a class='cargar_datos_estudiante btn btn-success' data-id_grupo='" + $("#tipo_grupo_temp").data("id_grupo") + "' data-id_estudiante='" + datos[i].NRO_DOCUMENTO + "' data-nombre_estudiante='" + datos[i].APELLIDO1+' '+datos[i].APELLIDO2+' '+datos[i].NOMBRE1+' '+datos[i].NOMBRE2 + "' data-id_grado='" + datos[i].GRADO + "' data-id_tipo_jornada='" + datos[i].TIPO_JORNADA + "' data-tipo_documento='" + datos[i].TIPO_DOCUMENTO + "' data-primer_nombre='" + datos[i].NOMBRE1 + "' data-segundo_nombre='" + datos[i].NOMBRE2 + "' data-primer_apellido='" + datos[i].APELLIDO1 + "' data-segundo_apellido='" + datos[i].APELLIDO2 + "' data-tipo_origen='simat' data-fecha_nacimiento='" + datos[i].FECHA_NACIMIENTO + "' data-genero='" + datos[i].GENERO + "' data-direccion_residencia='" + datos[i].DIRECCION_RESIDENCIA + "' data-telefono='" + datos[i].TEL + "' data-pob_vict_conf='" + datos[i].POB_VICT_CONF + "' data-tipo_discapacidad='" + datos[i].TIPO_DISCAPACIDAD + "' data-codigo_dane='" + datos[i].CODIGO_DANE + "' data-etnia='" + datos[i].ETNIA + "' data-estrato='" + datos[i].ESTRATO + "' data-id_grupo_poblacional='0' data-sisben='" + (datos[i].SISBEN == ''?0.0:datos[i].SISBEN) + "'  href='#'>Cargar Datos"+ "<sup><b> " + origen_estudiante + "</b></sup><sub>";
					boton += ((origen_estudiante == 'matricula')?'':('MES: ' + datos[i].mes + "-" + datos[i].ANO_INF)) + "</sub></a>";
				}
				var fila = table_resultado_busqueda.row.add( [
					datos[i].NRO_DOCUMENTO,
					datos[i].APELLIDO1+' '+datos[i].APELLIDO2+' '+datos[i].NOMBRE1+' '+datos[i].NOMBRE2,
					datos[i].GRADO_NOMBRE,datos[i].COLEGIO_NOMBRE,
					boton
					]).draw().node();
			});
		}
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

	function crearEstudiante(tipo_origen){
		var date = new Date();
		// parent.mostrarAlerta("warning","Beneficiario nuevo","Se creará el beneficiario de origen " + tipo_origen);
		var year = date.getFullYear();
		if (tipo_origen == 'simat') {
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
					'correo': '',
					'telefono': $("#BT_asignar_estudiante_grupo").data("telefono"),
					'celular': '',
					'fuente': 'MATRICULA',
					'id_usuario': parent.idUsuario,
					'anio':year,
					'id_crea': '1',
					'id_colegio': '0', // $("#BT_asignar_estudiante_grupo").data("id_colegio"),
					'id_grado': '0', //$("#BT_asignar_estudiante_grupo").data("id_grado"),
					'id_jornada': '0', // $("#BT_asignar_estudiante_grupo").data("id_jornada"),
					'tipo_afiliacion': '',
					'nombre_acudiente': '',
					'identificacion_acudiente': '',
					'telefono_acudiente': '',
					'id_grupo_poblacional': '6',
					'id_eps': '0',
					'rh': '9',
					'enfermedades': '',
					'id_localidad': '0',
					'barrio': '',
					'id_tipo_poblacion_victima': $("#BT_asignar_estudiante_grupo").data("pob_vict_conf"),
					'id_tipo_discapacidad': $("#BT_asignar_estudiante_grupo").data("tipo_discapacidad"),
					'id_etnia': $("#BT_asignar_estudiante_grupo").data("etnia"),
					'estrato': $("#BT_asignar_estudiante_grupo").data("estrato"),
					'sisben': $("#BT_asignar_estudiante_grupo").data("sisben"),
					'observaciones_detalle_anio': $("#TX_observaciones_asignacion_estudiante").val()
				}
			};
		}else if (tipo_origen == 'historico_nidos') {
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
					'direccion_residencia': '0', // $("#BT_asignar_estudiante_grupo").data("direccion_residencia"),
					'correo': '',
					'telefono': '0', // $("#BT_asignar_estudiante_grupo").data("telefono"),
					'celular': '',
					'fuente': 'NIDOS',
					'id_usuario': parent.idUsuario,
					'anio':year,
					'id_crea': '1',
					'id_colegio': '0', // $("#BT_asignar_estudiante_grupo").data("id_colegio"),
					'id_grado': '0', //$("#BT_asignar_estudiante_grupo").data("id_grado"),
					'id_jornada': '0', // $("#BT_asignar_estudiante_grupo").data("id_jornada"),
					'tipo_afiliacion': '',
					'nombre_acudiente': '',
					'identificacion_acudiente': '',
					'telefono_acudiente': '',
					'id_grupo_poblacional': $("#BT_asignar_estudiante_grupo").data("id_grupo_poblacional"),
					'id_eps': '0',
					'rh': '9',
					'enfermedades': '',
					'id_localidad': '0',
					'barrio': '',
					'id_tipo_poblacion_victima': '0', //$("#BT_asignar_estudiante_grupo").data("pob_vict_conf"),
					'id_tipo_discapacidad': '0', //$("#BT_asignar_estudiante_grupo").data("tipo_discapacidad"),
					'id_etnia': '0', // $("#BT_asignar_estudiante_grupo").data("etnia"),
					'estrato': $("#BT_asignar_estudiante_grupo").data("estrato"),
					'sisben': '0', // $("#BT_asignar_estudiante_grupo").data("sisben"),
					'observaciones_detalle_anio': $("#TX_observaciones_asignacion_estudiante").val()
				}
			};
		}
		var id_estudiante = "";
		mensaje = "Estudiante ";
		$.ajax({
			url: url_asignacion_obj+'crearEstudiante',
			type:'POST',
			data: datos,
			async:false
		}).done(function(data){
			id_estudiante = data;
			// mensaje += "creado en el sistema y ";
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido asignar el estudiante al grupo ' + textStatus);
		});
		return id_estudiante;
	}

	function validarExistenciaEstudianteEnGrupo(nro_documento,tipo_grupo){
		$id_grupo = 0;
		var datos_consulta = {
			p1: {
				'nro_documento': nro_documento,
				'tipo_grupo' : tipo_grupo
			}
		};
		$.ajax({
			url: url_asignacion_obj+'consultarGruposActivosEstudiantePorDocumento',
			type:'POST',
			data: datos_consulta,
			async:false
		}).done(function(data){
			$id_grupo = data;
		}).fail(function(jqXHR,textStatus){
			parent.mostrarAlerta("error",'Error','No se ha podido cargar los grupos en los cuales se encuentra activo el estudiante. ' + textStatus);
		});
		return $id_grupo;
	}

	$("#datos_estudiante").show();
});