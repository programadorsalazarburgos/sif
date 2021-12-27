var url_controller = "../../Controlador/Organizaciones/C_Seguimiento_Organizaciones.php"
var session = "";
var session_type = "";
var numeros = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20'];
var nombres = ['1er Objetivo','2º Objetivo','3er Objetivo','4º Objetivo','5º Objetivo','6º Objetivo','7º Objetivo','8º Objetivo','9º Objetivo','10º Objetivo','11º Objetivo','12º Objetivo','13º Objetivo','14º Objetivo','15º Objetivo','16º Objetivo','17º Objetivo','18º Objetivo','19º Objetivo','20º Objetivo'];
var contador_objetivos = 2;
var contador_objetivos_V2 = 2;
var contador_objetivos_V3 = 2;
var contador_indicadores_V3 = 2;
var bandera_existencia = "";
var bandera_existencia_indicadores = "";
var id_periodo = "";
var pdfData;
var year="";
$(document).ready(function(){

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php', 
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
			datos_usuario = $.parseJSON(parent.consultarDatosBasicosUsuario(session))[0];
			$(".NOMBRE").html(datos_usuario['VC_Primer_Nombre']+" "+datos_usuario['VC_Segundo_Nombre']+" "+datos_usuario['VC_Primer_Apellido']+" "+datos_usuario['VC_Segundo_Apellido']);
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


	$("#TX_Fecha_Inicio, #TX_Fecha_Fin").datepicker({
		format: 'yyyy/mm/dd',
		viewMode: 'months'
	});

	$("#TX_Fecha_Inicio_V2, #TX_Fecha_Fin_V2").datepicker({
		format: 'yyyy/mm/dd',
		viewMode: 'months'
	});

	$("#TX_Fecha_Inicio_V3, #TX_Fecha_Fin_V3").datepicker({
		format: 'yyyy/mm/dd',
		viewMode: 'months'
	});

	$("#crear_fila_objetivo").on('click', function(){
		agregar_fila();
	});
	$("#eliminar_fila_objetivo").on('click', function(){
		eliminar_fila();
	});

	$("#crear_fila_objetivo_V2").on('click', function(){
		agregar_fila_V2();
	});
	$("#eliminar_fila_objetivo_V2").on('click', function(){
		eliminar_fila_V2();
	});

	$("#crear_fila_objetivo_V3").on('click', function(){
		agregar_fila_obj_V3();
	});
	$("#eliminar_fila_objetivo_V3").on('click', function(){
		eliminar_fila_obj_V3();
	});

	$("#crear_fila_indicador_V3").on('click', function(){
		agregar_fila_ind_V3();
	});
	$("#eliminar_fila_indicador_V3").on('click', function(){
		eliminar_fila_ind_V3();
	});

	$("#tab_relizar_seguimiento_v1").on('click', function(){
		$("#FORM_SEGUIMIENTO")[0].reset();
		cargarEncabezadoV1(session,1,'');
	});

	$("#tab_relizar_seguimiento_v2").on('click', function(){
		$("#FORM_SEGUIMIENTO_V2")[0].reset();
		cargarEncabezadoV2(session,1,'');
	});

	$("#tab_relizar_seguimiento_v3").on('click', function(){
		$("#FORM_SEGUIMIENTO_V3")[0].reset();
		cargarEncabezadoV3(session,1,'');
	});

	$("#FORM_SEGUIMIENTO").on('submit', function(e){
		e.preventDefault();
		if(($("#TX_Fecha_Inicio").val()!="") && ($("#TX_Fecha_Fin").val()!="")){
			var FORMULARIO = $(this).serializeArray();
			var numero_objetivos = contador_objetivos-1;
			var objetivos_especificos = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "objetivo_"+i;
				objetivos_especificos[nombre_elemento] = $("#objetivo_"+i).val();
			}
			json_objetivos_especificos = JSON.stringify(objetivos_especificos);
			
			var actividades = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "actividad_obj_"+i;
				actividades[nombre_elemento] = $("#actividad_obj_"+i).val();
			}
			json_actividades = JSON.stringify(actividades);
			
			var metas = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "metas_obj_"+i;
				metas[nombre_elemento] = $("#metas_obj_"+i).val();
			}
			json_metas = JSON.stringify(metas);
			
			var indicadores = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "indicador_obj_"+i;
				indicadores[nombre_elemento] = $("#indicador_obj_"+i).val();
			}
			json_indicadores = JSON.stringify(indicadores);
			
			var areas_artisticas = "";
			$('#SL_Areas :selected').each(function(i, selected){ 
				areas_artisticas = areas_artisticas + $(selected).val()+";";
			});
			
			var porcentajes = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "porcentaje_"+i;
				porcentajes[nombre_elemento] = $("#porcentaje_"+i).val();
			}
			json_porcentajes = JSON.stringify(porcentajes);
			
			var cumplimiento = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "cumplimiento_"+i;
				cumplimiento[nombre_elemento] = $("#cumplimiento_"+i).val();
			}
			json_cumplimiento = JSON.stringify(cumplimiento);
			
			var propuestas= $("#TXTA_PROPUESTA_PEDAGOGICA").val()+"|"+$("#TXTA_PROPUESTA_METODOLOGICA").val();
			var hallazgos = $("#TXTA_HALLAZGOS_PEDAGOGICOS").val()+"|"+$("#TXTA_HALLAZGOS_METODOLOGICOS").val();
			var transformaciones = $("#TXTA_TRANSFORMACIONES_PEDAGOGICAS").val()+"|"+$("#TXTA_TRANSFORMACIONES_METODOLOGICAS").val();
			FORMULARIO.push(
			{
				"name":'opcion',
				"value":'guardarSeguimiento'
			},
			{
				"name":'json_objetivos_especificos',
				"value":json_objetivos_especificos
			},
			{
				"name":'json_actividades',
				"value":json_actividades
			},
			{
				"name":'json_metas',
				"value":json_metas
			},
			{
				"name":'json_indicadores',
				"value":json_indicadores
			},
			{
				"name":'areas',
				"value":areas_artisticas
			},
			{
				"name":'id_usuario',
				"value":session
			},
			{
				"name":'json_porcentajes',
				"value":json_porcentajes
			},
			{
				"name":'json_cumplimiento',
				"value":json_cumplimiento
			},{
				"name":'propuestas',
				"value":propuestas
			},{
				"name":'hallazgos',
				"value":hallazgos
			},{
				"name":'transformaciones',
				"value":transformaciones
			},{  
				"name":'bandera_existencia',
				"value":bandera_existencia
			},{  
				"name":'version',
				"value":1
			}
			);
			
			$.ajax({
				url: url_controller, 
				data: FORMULARIO,
				type: 'POST',
				success: function(){
					parent.swal({
						title: 'Realizado',
						text: "Seguimiento a la propuesta Guardado!",
						type: 'success',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Continuar'
					}).then((result) => {
						$("#tab_consultar_seguimientos").click();
						$("#SL_Convenios_Organizacion").trigger("change");
					});
				},
				async : false
			});
		}
		else{
			alert("Debe especificar FECHA de INICIO y FIN del Convenio");
			$("#TX_Fecha_Inicio").focus();
		}
	});

	$("#FORM_SEGUIMIENTO_V2").on('submit', function(e){
		e.preventDefault();
		if(($("#TX_Fecha_Inicio_V2").val()!="") && ($("#TX_Fecha_Fin_V2").val()!="")){
			var FORMULARIO = $(this).serializeArray();
			var numero_objetivos = contador_objetivos_V2-1;
			var objetivos_especificos = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "objetivo_"+i;
				objetivos_especificos[nombre_elemento] = $("#objetivo_"+i+"_V2").val();
			}
			json_objetivos_especificos = JSON.stringify(objetivos_especificos);
			
			var actividades = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "actividad_obj_"+i;
				actividades[nombre_elemento] = $("#actividad_obj_"+i+"_V2").val();
			}
			json_actividades = JSON.stringify(actividades);
			
			var areas_artisticas = "";
			$('#SL_Areas_V2 :selected').each(function(i, selected){ 
				areas_artisticas = areas_artisticas + $(selected).val()+";";
			});

			var propuestas= $("#TXTA_PROPUESTA_PEDAGOGICA_V2").val()+"|"+$("#TXTA_PROPUESTA_METODOLOGICA_V2").val();
			var avances_formacion = $("#TXTA_AVANCES_V2").val()+"|"+$("#TXTA_FORMACION_V2").val();
			var aportes_articulacion = $("#TXTA_APORTES_V2").val()+"|"+$("#TXTA_ARTICULACION_V2").val();
			FORMULARIO.push(
			{
				"name":'opcion',
				"value":'guardarSeguimientoV2'
			},
			{
				"name":'json_objetivos_especificos',
				"value":json_objetivos_especificos
			},
			{
				"name":'json_actividades',
				"value":json_actividades
			},
			{
				"name":'areas',
				"value":areas_artisticas
			},
			{
				"name":'id_usuario',
				"value":session
			},{
				"name":'propuestas',
				"value":propuestas
			},{
				"name":'avances_formacion',
				"value":avances_formacion
			},{
				"name":'aportes_articulacion',
				"value":aportes_articulacion
			},{  
				"name":'bandera_existencia',
				"value":bandera_existencia
			},{
				"name":'version',
				"value":2
			},{
				"name":'bandera_actualizar',
				"value":1
			});
			
			$.ajax({
				url: url_controller, 
				data: FORMULARIO,
				type: 'POST',
				success: function(){
					parent.swal({
						title: 'Realizado',
						text: "Seguimiento a la propuesta Guardado!",
						type: 'success',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Continuar'
					}).then((result) => {
						$("#tab_consultar_seguimientos").click();
						$("#SL_Convenios_Organizacion").trigger("change");
					});
				},
				async : false
			});
		}
		else{
			alert("Debe especificar FECHA de INICIO y FIN del Convenio");
			$("#TX_Fecha_Inicio_V2").focus();
		}
	});

	$("#FORM_SEGUIMIENTO_V3").on('submit', function(e){
		e.preventDefault();
		if(($("#TX_Fecha_Inicio_V3").val()!="") && ($("#TX_Fecha_Fin_V3").val()!="")){
			var FORMULARIO = $(this).serializeArray();
			var numero_objetivos = contador_objetivos_V3-1;
			var numero_indicadores = contador_indicadores_V3-1;
			var objetivos_especificos = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "objetivo_"+i;
				objetivos_especificos[nombre_elemento] = $("#objetivo_"+i+"_V3").val();
			}
			json_objetivos_especificos = JSON.stringify(objetivos_especificos);
			
			var actividades = {};
			for(i=1;i<=numero_objetivos;i++){
				var nombre_elemento = "actividad_obj_"+i;
				actividades[nombre_elemento] = $("#actividad_obj_"+i+"_V3").val();
			}
			json_actividades = JSON.stringify(actividades);

			var indicadores = {};
			for(i=1;i<=numero_indicadores;i++){
				var nombre_elemento = "indicador_"+i;
				indicadores[nombre_elemento] = {};
				indicadores[nombre_elemento]['descripcion'] = $("#ind_"+i+"_V3").val();
				indicadores[nombre_elemento]['formula'] = $("#formula_ind_"+i+"_V3").val();
			}
			json_indicadores = JSON.stringify(indicadores);

			var cumplimiento = {};
			for(i=1;i<=numero_indicadores;i++){
				var nombre_elemento = "cumplimiento_indicador_"+i;
				cumplimiento[nombre_elemento] = $("#cumplimiento_ind_"+i+"_V3").val();
			}
			json_cumplimiento = JSON.stringify(cumplimiento);
			
			var areas_artisticas = "";
			$('#SL_Areas_V3 :selected').each(function(i, selected){ 
				areas_artisticas = areas_artisticas + $(selected).val()+";";
			});

			var propuestas= $("#TXTA_PROPUESTA_PEDAGOGICA_V3").val()+"|"+$("#TXTA_PROPUESTA_METODOLOGICA_V3").val();
			var avances_formacion = $("#TXTA_AVANCES_V3").val()+"|"+$("#TXTA_FORMACION_V3").val();
			var aportes_articulacion = $("#TXTA_APORTES_V3").val()+"|"+$("#TXTA_ARTICULACION_V3").val();
			FORMULARIO.push(
			{
				"name":'opcion',
				"value":'guardarSeguimientoV3'
			},
			{
				"name":'json_objetivos_especificos',
				"value":json_objetivos_especificos
			},
			{
				"name":'json_actividades',
				"value":json_actividades
			},
			{
				"name":'json_indicadores',
				"value":json_indicadores
			},
			{
				"name":'json_cumplimiento',
				"value":json_cumplimiento
			},
			{
				"name":'areas',
				"value":areas_artisticas
			},
			{
				"name":'id_usuario',
				"value":session
			},{
				"name":'propuestas',
				"value":propuestas
			},{
				"name":'avances_formacion',
				"value":avances_formacion
			},{
				"name":'aportes_articulacion',
				"value":aportes_articulacion
			},{  
				"name":'bandera_existencia',
				"value":bandera_existencia
			},{
				"name":'version',
				"value":3
			},{
				"name":'bandera_existencia_indicadores',
				"value":bandera_existencia_indicadores
			});
			
			$.ajax({
				url: url_controller, 
				data: FORMULARIO,
				type: 'POST',
				success: function(){
					parent.swal({
						title: 'Realizado',
						text: "Seguimiento a la propuesta Guardado!",
						type: 'success',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Continuar'
					}).then((result) => {
						$("#tab_consultar_seguimientos").click();
						$("#SL_Convenios_Organizacion").trigger("change");
					});
				},
				async : false
			});
		}
		else{
			alert("Debe especificar FECHA de INICIO y FIN del Convenio");
			$("#TX_Fecha_Inicio_V3").focus();
		}
	});
	
	//EVENTOS DEL CONSULTAR SEGUIMIENTOS
	$("#SL_Year").on('change', function(){
		$("#SL_Organizacion").html("");
		$("#SL_Organizacion").append("<option value=''>Seleccione la Organización</option>");
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
				$("#SL_Organizacion").selectpicker("refresh");
			},
			async : false
		});
	});

	$("#SL_Organizacion").on('change', function(){
		while(contador_objetivos-1>1){
			eliminar_fila();
		}
		$("#body_seguimientos").html("");
		organizacion = $(this).val();
		var datos = {
			'opcion': 'getSeguimientosOrganizacionAnioConvenio',
			'organizacion': organizacion, //Aquí se envía el Id del Usuario (Coordinador Organización).
			'year': year
		};
		$.ajax({
			url: url_controller, 
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					try {
						tabla_seguimientos.clear();
					}
					catch(err) {
					}

					if ( $.fn.dataTable.isDataTable( '#tabla_seguimientos' ) ) {
						tabla_seguimientos = $('#tabla_seguimientos').DataTable().destroy();
					}

					informacion.forEach(cargarSeguimientos);

					if ( $.fn.dataTable.isDataTable( '#tabla_seguimientos' ) ) {
						tabla_seguimientos = $('#tabla_seguimientos').DataTable();
					}
					else{
						tabla_seguimientos = $('#tabla_seguimientos').DataTable({
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
								title: 'Listado de Seguimientos a la Propuesta por Organización'
							}
							],
						});
					}
					tabla_seguimientos.draw();
				}
				else{

				}
			},
			async : false
		});

		$(document).delegate(".revision",'click', function() {
			$("#MODAL_REVISION #modal_titulo").html("REVISIÓN DEL SEGUIMIENTO");
			id_periodo = $(this).data("id-periodo");
			$("#TXA_Observacion_Seguimiento").val($(this).data('observaciones'));
			var checked = $(this).data('aprobacion');
			if (checked=="1") {
				checked = "on";
			}
			else{
				checked = "off";
			}
			$("#IN_Aprobacion").bootstrapToggle(checked);
		});
	});

	$(document).delegate(".observaciones",'click', function() {
		$("#MODAL_OBSERVACION #modal_titulo_observacion").html("OBSERVACIONES DEL SEGUIMIENTO");
		$("#P_Observacion").html($(this).data('observaciones'));
	});

	$(document).delegate( ".abrir_seguimiento", "click", function() {
		if($(this).data("in-version")==1){
			$("#tab_relizar_seguimiento_v1").click();
			cargarSeguimientoPeriodoV1($(this).data("id-periodo"));
		}
		if($(this).data("in-version")==2){
			$("#tab_relizar_seguimiento_v2").click();
			cargarSeguimientoPeriodoV2($(this).data("id-periodo"));	
		}
		if($(this).data("in-version")==3){
			$("#tab_relizar_seguimiento_v3").click();
			cargarSeguimientoPeriodoV3($(this).data("id-periodo"));	
		}
	});

	$(document).delegate( ".descargar_seguimiento", "click", function() {
		var id_organizacion = "";
		if(session_type==11){
			id_organizacion = session;
		}
		else{
			id_organizacion = $("#SL_Organizacion").val();
		}
		if($(this).data("in-version")==1){
			generarPDFSeguimientoPeriodoV1(id_organizacion,$(this).data("id-periodo"));
		}
		if($(this).data("in-version")==2){
			generarPDFSeguimientoPeriodoV2(id_organizacion,$(this).data("id-periodo"));
		}
		if($(this).data("in-version")==3){
			generarPDFSeguimientoPeriodoV3(id_organizacion,$(this).data("id-periodo"));
		}
	});

	$("#BT_Guardar_Observacion").on('click', function(){
		var observacion_seguimiento = $("#TXA_Observacion_Seguimiento").val();
		var aprobacion = $("#IN_Aprobacion").prop("checked");
    		//alert(observacion_seguimiento+"-"+aprobacion);
    		var datos = {
    			'opcion': 'guardarRevisionSeguimiento',
    			'id_persona': session,
			'id_periodo': id_periodo, //Aquí se envía el Id de la Tabla tb_organizacion_seguimiento_propuesta_periodo que se va a actualizar.
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

	$("#FM_REPORTE_CONSOLIDADO").on('submit', function(e){
		e.preventDefault();
		var id_organizacion = "";
		if(session_type==11)//SI ES UNA ORGANIZACION ENTONCES ENVIA EL ID DE LA SESSION DE LA ORGANIZACION.
		{
			id_organizacion = session;
			anio = $("#SL_Convenios_Organizacion").val();
			generarPDFReporteConsolidadoSeguimientos(id_organizacion,anio);
		}
		else//SINO ES UNA ORGANIZACIÓN ENVIA EL VALOR DEL SELECT ORGANIZACION
		{
			id_organizacion = $("#SL_Organizacion").val();
			anio = $("#SL_Year").val();
			generarPDFReporteConsolidadoSeguimientos(id_organizacion,anio);
		}
	});

	if(session_type == 11){
		$("#SL_Year").hide();
		$("#SL_Organizacion").selectpicker('hide');
		$("#SL_Convenios_Organizacion").selectpicker('show');
		$("#SL_Convenios_Organizacion").prop('required', true);
		
		cargarEncabezadoV1(session,1,'');
		cargarEncabezadoV2(session,1,'');
		cargarEncabezadoV3(session,1,'');

		var datos = {
			'opcion': 'getConveniosOrganizacion',
			'id_organizacion': session
		};
		$.ajax({
			url: url_controller, 
			data: datos,
			type: 'POST',
			dataType: 'json',
			success: function (info) {
				$.each(info, function (i) {
					var id_convenio = info[i].PK_Id_Tabla;
					$('#SL_Convenios_Organizacion').append($('<option>', {
						value : id_convenio,
						text : info[i].VC_Convenio
					}));
				});
				$("#SL_Convenios_Organizacion").selectpicker("refresh");
			},
			async : false
		});
	}
	else{
		$("#SL_Year").show();
		$("#SL_Organizacion").selectpicker('show');
		$("#SL_Convenios_Organizacion").selectpicker('hide');
		$("#SL_Convenios_Organizacion").prop('required', false);
		$("#tab_relizar_seguimiento_v1").removeClass("hidden");
		$("#tab_relizar_seguimiento_v2").removeClass("hidden");
		$("#tab_relizar_seguimiento_v3").removeClass("hidden");
	}

	$("#SL_Convenios_Organizacion").on('change', function(){
		organizacion = session;
		var datos = {
			'opcion': 'getSeguimientosOrganizacion',
			'organizacion': organizacion, //Aquí se envía el Id del Usuario (Coordinador Organización).
			'id_convenio': $("#SL_Convenios_Organizacion").val()
		};
		$.ajax({
			url: url_controller, 
			data: datos,
			type: 'POST',
			success: function (info) {
				informacion = JSON.parse(info);
				if (info != 'null') {
					try {
						tabla_seguimientos.clear();
					}
					catch(err) {
					}

					if ( $.fn.dataTable.isDataTable( '#tabla_seguimientos' ) ) {
						tabla_seguimientos = $('#tabla_seguimientos').DataTable().destroy();
					}

					informacion.forEach(cargarSeguimientos);

					if ( $.fn.dataTable.isDataTable( '#tabla_seguimientos' ) ) {
						tabla_seguimientos = $('#tabla_seguimientos').DataTable();
					}
					else{
						tabla_seguimientos = $('#tabla_seguimientos').DataTable({
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
								title: 'Listado de Seguimientos a la Propuesta por Organización'
							}
							],
						});
					}
					tabla_seguimientos.draw();
				}
				else{

				}
			},
			async : false
		});
		$(".revision").addClass("disabled");
	});
});

function agregar_fila(){
	var newtr = document.createElement('tr');
	newtr.id = "tr_objetivo"+contador_objetivos;
	newtr.innerHTML = "<td style='padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;'><label id='nombre_"+contador_objetivos+"' name='nombre_"+contador_objetivos+"'>"+numeros[contador_objetivos-1]+"</label></td>"+"<td style='padding:0px'><textarea id='objetivo_"+contador_objetivos+"' name='objetivo_"+contador_objetivos+"' class='form-control' rows=6 placeholder='Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico)' required></textarea></td>"+"<td style='padding:0px'><textarea id='actividad_obj_"+contador_objetivos+"' name='actividad_obj_"+contador_objetivos+"' class='form-control' rows=6 placeholder='Relacionadas en la propuesta con relación al objetivo general' required></textarea></td>"+"<td style='padding:0px'><textarea id='metas_obj_"+contador_objetivos+"' name='metas_obj_"+contador_objetivos+"' class='form-control' rows=6 placeholder='Relacionadas en la propuesta con relación al objetivo general' required></textarea></td>"+"<td style='padding:0px'><textarea id='indicador_obj_"+contador_objetivos+"' name='indicador_obj_"+contador_objetivos+"' class='form-control' rows=6 placeholder='* Nombre&#10;* Fórmula&#10;* Estado Inicial&#10;* Valor esperado' required></textarea></td>";
	document.getElementById('contenedor_objetivos').appendChild(newtr);
	var newrow = document.createElement('tr');
	newrow.id = "tr_cumplimiento"+contador_objetivos;
	newrow.innerHTML = "<td style='padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;'><label id='nombreobj_"+contador_objetivos+"' name='nombreobj_"+contador_objetivos+"'>"+numeros[contador_objetivos-1]+"</label></td>"+"<td style='padding:0px'><textarea id='porcentaje_"+contador_objetivos+"' name='porcentaje_"+contador_objetivos+"' class='form-control' rows=4 placeholder='* Fórmula&#10;* Estado Actual' required></textarea></td>"+"<td style='padding:0px'><textarea id='cumplimiento_"+contador_objetivos+"' name='cumplimiento_"+contador_objetivos+"' class='form-control' rows=4 placeholder='Describa de manera detallada y precisa las actividades realizadas para el desarrollo del objetivo de acuerdo al porcentaje de cumplimiento indicado (dónde, cómo, cuándo)' required></textarea></td>";
	document.getElementById('contenedor_cumplimiento').appendChild(newrow);
	contador_objetivos++;
}

function eliminar_fila(){
	if (contador_objetivos>2) {
		contador_objetivos--;
		$('#tr_objetivo'+contador_objetivos).remove();
		$('#tr_cumplimiento'+contador_objetivos).remove();
	}
}

function agregar_fila_V2(){
	var newtr = document.createElement('tr');
	newtr.id = "tr_objetivo"+contador_objetivos_V2+"_V2";
	newtr.innerHTML = "<td style='padding:0px; background-color:#009f9969; text-align:center; vertical-align: middle;'><label id='nombre_"+contador_objetivos_V2+"_V2' name='nombre_"+contador_objetivos_V2+"_V2'>"+numeros[contador_objetivos_V2-1]+"</label></td>"+"<td style='padding:0px'><textarea id='objetivo_"+contador_objetivos_V2+"_V2' name='objetivo_"+contador_objetivos_V2+"_V2' class='form-control' rows=6 placeholder='Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico)' required></textarea></td>"+"<td style='padding:0px'><textarea id='actividad_obj_"+contador_objetivos_V2+"_V2' name='actividad_obj_"+contador_objetivos_V2+"_V2' class='form-control' rows=6 placeholder='Relacionadas en la propuesta con relación al objetivo general' required></textarea></td>";
	document.getElementById('contenedor_objetivos_V2').appendChild(newtr);
	contador_objetivos_V2++;
}

function eliminar_fila_V2(){
	if (contador_objetivos_V2>2) {
		contador_objetivos_V2--;
		$('#tr_objetivo'+contador_objetivos_V2+"_V2").remove();
		$('#tr_cumplimiento'+contador_objetivos_V2+"_V2").remove();
	}
}

function agregar_fila_obj_V3(){
	var newtr = document.createElement('tr');
	newtr.id = "tr_objetivo"+contador_objetivos_V3+"_V3";
	newtr.innerHTML = "<td style='padding:0px; background-color:#009f9969; text-align:center; vertical-align: middle;'><label id='nombre_"+contador_objetivos_V3+"_V3' name='nombre_"+contador_objetivos_V3+"_V3'>"+numeros[contador_objetivos_V3-1]+"</label></td>"+"<td style='padding:0px'><textarea id='objetivo_"+contador_objetivos_V3+"_V3' name='objetivo_"+contador_objetivos_V3+"_V3' class='form-control' rows=6 placeholder='Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico)' required></textarea></td>"+"<td style='padding:0px'><textarea id='actividad_obj_"+contador_objetivos_V3+"_V3' name='actividad_obj_"+contador_objetivos_V3+"_V3' class='form-control' rows=6 placeholder='Relacionadas en la propuesta con relación al objetivo general' required></textarea></td>";
	document.getElementById('contenedor_objetivos_V3').appendChild(newtr);
	contador_objetivos_V3++;
}

function eliminar_fila_obj_V3(){
	if (contador_objetivos_V3>2) {
		contador_objetivos_V3--;
		$('#tr_objetivo'+contador_objetivos_V3+"_V3").remove();
		$('#tr_cumplimiento'+contador_objetivos_V3+"_V3").remove();
	}
}

function agregar_fila_ind_V3(){
	var newtr = document.createElement('tr');
	newtr.id = "tr_indicador_"+contador_indicadores_V3+"_V3";
	newtr.innerHTML = "<td style='padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;'><label id='nombre_ind_"+contador_indicadores_V3+"_V3' name='nombre_ind_"+contador_indicadores_V3+"_V3'>"+numeros[contador_indicadores_V3-1]+"</label></td>"+"<td style='padding:0px'><textarea id='ind_"+contador_indicadores_V3+"_V3' name='ind_"+contador_indicadores_V3+"_V3' class='form-control' rows=4 placeholder='* Descripción textual del indicador' required></textarea></td>"+"<td style='padding:0px'><textarea id='formula_ind_"+contador_indicadores_V3+"_V3' name='formula_ind_"+contador_indicadores_V3+"_V3' class='form-control' rows=4 placeholder='* Fórmula de medición o pregunta del indicador' required></textarea></td>"+"<td style='padding:0px'><textarea id='cumplimiento_ind_"+contador_indicadores_V3+"_V3' name='cumplimiento_ind_"+contador_indicadores_V3+"_V3' class='form-control' rows=4 placeholder='Describa de manera detallada y precisa el estado actual de cumplimiento del indicador de acuerdo a la fórmula indicada.' required></textarea></td>";
	document.getElementById('contenedor_indicadores_V3').appendChild(newtr);
	contador_indicadores_V3++;
}

function eliminar_fila_ind_V3(){
	if (contador_indicadores_V3>2) {
		contador_indicadores_V3--;
		$('#tr_indicador_'+contador_indicadores_V3+"_V3").remove();
	}
}

function cargarOrganizaciones(item, index) {
	$("#SL_Organizacion").append("<option value="+item.FK_Coordinador+">"+item.VC_Nom_Organizacion+"</option>");
    //console.log(item.VC_Nom_Organizacion);
}

function cargarSeguimientos(item, index) {

	if(item.TX_Observaciones != "" && item.TX_Observaciones != null && item.IN_Aprobacion==0){
		$("#tabla_seguimientos").append("<tr><td>"+item.VC_Primer_Nombre+" "+item.VC_Segundo_Nombre+" "+item.VC_Primer_Apellido+" "+item.VC_Segundo_Apellido+"</td><td>"+item.VC_Periodo+"</td><td>"+item.DA_Registro+"</td><td><a class='btn btn-danger descargar_seguimiento' data-id-periodo='"+item.PK_Id_Tabla+"' data-in-version='"+item.IN_Version+"'><span class='fa fa-download'></span> PDF</a></td><td><a class='btn btn-danger abrir_seguimiento' data-id-periodo='"+item.PK_Id_Tabla+"' data-in-version='"+item.IN_Version+"'><span class='fa fa-folder-open'></span> Editar</a><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-periodo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-warning observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Pendiente</a></td></tr>")	
	}else{
		if (item.IN_Aprobacion == 1) {
			$("#tabla_seguimientos").append("<tr><td>"+item.VC_Primer_Nombre+" "+item.VC_Segundo_Nombre+" "+item.VC_Primer_Apellido+" "+item.VC_Segundo_Apellido+"</td><td>"+item.VC_Periodo+"</td><td>"+item.DA_Registro+"</td><td><a class='btn btn-danger descargar_seguimiento' data-id-periodo='"+item.PK_Id_Tabla+"' data-in-version='"+item.IN_Version+"'><span class='fa fa-download'></span> PDF</a></td><td><a class='btn btn-danger abrir_seguimiento' data-id-periodo='"+item.PK_Id_Tabla+"' data-in-version='"+item.IN_Version+"'><span class='fa fa-folder-open'></span> Editar</a><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-periodo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-success observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Aprobado</a></td></tr>")	
		}
		else{
			$("#tabla_seguimientos").append("<tr><td>"+item.VC_Primer_Nombre+" "+item.VC_Segundo_Nombre+" "+item.VC_Primer_Apellido+" "+item.VC_Segundo_Apellido+"</td><td>"+item.VC_Periodo+"</td><td>"+item.DA_Registro+"</td><td><a class='btn btn-danger descargar_seguimiento' data-id-periodo='"+item.PK_Id_Tabla+"' data-in-version='"+item.IN_Version+"'><span class='fa fa-download'></span> PDF</a></td><td><a class='btn btn-danger abrir_seguimiento' data-id-periodo='"+item.PK_Id_Tabla+"' data-in-version='"+item.IN_Version+"'><span class='fa fa-folder-open'></span> Editar</a><td><a class='btn btn-success revision' id='BT_Abrir_Observaciones_"+item.PK_Id_Tabla+"' data-toggle='modal' data-target='#MODAL_REVISION' data-id-periodo='"+item.PK_Id_Tabla+"' data-observaciones='"+item.TX_Observaciones+"' data-aprobacion='"+item.IN_Aprobacion+"'><span class='fa fa-pencil'></span> Observar</a></td><td><a class='btn btn-info observaciones' data-toggle='modal' data-target='#MODAL_OBSERVACION' data-observaciones='"+item.TX_Observaciones+"'><span class='fa fa-eye'></span> Vácio</a></td></tr>")
		}
	}
}

function cargarSeguimientoPeriodoV1(id_periodo_org){
	var datos = {
		'opcion': 'getSeguimientoPeriodo',
		'id_periodo': id_periodo_org //Aquí se envía el ID del periodo que se quiere consultar.
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (seguimiento) {
			var datos_seguimiento = JSON.parse(seguimiento);
			if (seguimiento != 'null') {
				cargarEncabezadoV1(datos_seguimiento.FK_Id_Organizacion,1,id_periodo_org);
				$("#div_agregar_eliminar").hide();
				var numero_rows = Object.keys(JSON.parse(datos_seguimiento.TX_Porcentaje)).length;
				var porcentajes = JSON.parse(datos_seguimiento.TX_Porcentaje); 
				var cumplimientos = JSON.parse(datos_seguimiento.TX_Cumplimiento);
				var nombre_item = "";
				$("#TX_Periodo").val(datos_seguimiento.VC_Periodo);
				$("#TX_Numero_Grupos").val(datos_seguimiento.IN_Grupos);
				for(i=1;i<=numero_rows;i++){
					if(session_type!=11){
						if(i<=numero_rows && contador_objetivos-1 <= numero_rows){
							agregar_fila();
						}
					}
					nombre_item = "#porcentaje_"+i;
					nombre_objetivo = "#porcentaje_"+i;
					$(nombre_item).val(porcentajes["porcentaje_"+i]);
        			//$(nombre_item).prop("readonly", true);

        			nombre_item = "#cumplimiento_"+i;
        			nombre_actividad = "#cumplimiento_"+i;
        			$(nombre_item).val(cumplimientos["cumplimiento_"+i]);
					//$(nombre_item).prop("readonly", true);
				}

				var hallazgos = datos_seguimiento.TX_Hallazgos.split("|");
				$("#TXTA_HALLAZGOS_PEDAGOGICOS").val(hallazgos[0]);
				$("#TXTA_HALLAZGOS_METODOLOGICOS").val(hallazgos[1]);
				var transformaciones = datos_seguimiento.TX_Transformaciones.split("|");
				$("#TXTA_TRANSFORMACIONES_PEDAGOGICAS").val(transformaciones[0]);
				$("#TXTA_TRANSFORMACIONES_METODOLOGICAS").val(transformaciones[1]);
			}
			else{
        		//$("#div_agregar_eliminar").show();
        		//bandera_existencia = 0;
        	}
        },
        async : false
    });
}

function cargarSeguimientoPeriodoV2(id_periodo_org){
	var datos = {
		'opcion': 'getSeguimientoPeriodo',
		'id_periodo': id_periodo_org //Aquí se envía el ID del periodo que se quiere consultar.
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (seguimiento) {
			var datos_seguimiento = JSON.parse(seguimiento);
			if (datos_seguimiento != 'null') {
				cargarEncabezadoV2(datos_seguimiento.FK_Id_Organizacion,1,id_periodo_org);
				$("#div_agregar_eliminar_V2").hide();
				$("#TX_Periodo_V2").val(datos_seguimiento.VC_Periodo);
				$("#TX_Numero_Grupos_V2").val(datos_seguimiento.IN_Grupos);
				var avances_formacion = datos_seguimiento.TX_Avances_Formacion.split("|");
				$("#TXTA_AVANCES_V2").val(avances_formacion[0]);
				$("#TXTA_FORMACION_V2").val(avances_formacion[1]);
				var aportes_articulacion = datos_seguimiento.TX_Aportes_Articulacion.split("|");
				$("#TXTA_APORTES_V2").val(aportes_articulacion[0]);
				$("#TXTA_ARTICULACION_V2").val(aportes_articulacion[1]);
			}
			else{
        		//$("#div_agregar_eliminar").show();
        		//bandera_existencia = 0;
        	}
        },
        async : false
    });
}

function cargarSeguimientoPeriodoV3(id_periodo_org){
	var datos = {
		'opcion': 'getSeguimientoPeriodo',
		'id_periodo': id_periodo_org
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (seguimiento) {
			var datos_seguimiento = JSON.parse(seguimiento);
			if (datos_seguimiento != 'null') {
				cargarEncabezadoV3(datos_seguimiento.FK_Id_Organizacion,1,id_periodo_org);
				$("#div_agregar_eliminar_V3").hide();
				$("#TX_Periodo_V3").val(datos_seguimiento.VC_Periodo);
				$("#TX_Numero_Grupos_V3").val(datos_seguimiento.IN_Grupos);
				var avances_formacion = datos_seguimiento.TX_Avances_Formacion.split("|");
				$("#TXTA_AVANCES_V3").val(avances_formacion[0]);
				$("#TXTA_FORMACION_V3").val(avances_formacion[1]);
				var aportes_articulacion = datos_seguimiento.TX_Aportes_Articulacion.split("|");
				$("#TXTA_APORTES_V3").val(aportes_articulacion[0]);
				$("#TXTA_ARTICULACION_V3").val(aportes_articulacion[1]);
				var numero_cumplimiento_indicadores = Object.keys(JSON.parse(datos_seguimiento.TX_Cumplimiento)).length;
				var cumplimientos = JSON.parse(datos_seguimiento.TX_Cumplimiento);
				var nombre_item = "";
				for(i=1;i<=numero_cumplimiento_indicadores;i++){
					nombre_item = "#cumplimiento_ind_"+i+"_V3";
					$(nombre_item).val(cumplimientos["cumplimiento_indicador_"+i]);
				}
			}
			else{
        		//$("#div_agregar_eliminar").show();
        		//bandera_existencia = 0;
        	}
        },
        async : false
    });
}

function cargarEncabezadoV1(organizacion, bandera, id_seguimiento_periodo){
	var datos = {
		'opcion': 'getEncabezadoSeguimiento',
		'id_organizacion': organizacion,
		'id_periodo': id_seguimiento_periodo //Aquí se envía el ID del periodo que se quiere consultar.
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (data) {
			encabezado = JSON.parse(data);
			if (data != 'null') {
				var anio_inicio_convenio = encabezado.DA_Inicio.substring(0,4);
				if(anio_inicio_convenio == '2017'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v2").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v1").removeClass("hidden");
				}
				if(anio_inicio_convenio == '2018'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v1").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v2").removeClass("hidden");
				}
				if(anio_inicio_convenio == '2019'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v1").addClass("hidden");
						$("#tab_relizar_seguimiento_v2").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v3").removeClass("hidden");
				}

				$("#div_agregar_eliminar").hide();
				$("#TX_NIT").val(encabezado.VC_Nit);
				$("#TX_NIT").prop("readonly", true);
				$("#TX_Numero_Convenio").val(encabezado.VC_Convenio);
				$("#TX_Numero_Convenio").prop("readonly", true);
				$("#TX_Fecha_Inicio").val(encabezado.DA_Inicio);
				$("#TX_Fecha_Inicio").prop("readonly", true);
				$("#TX_Fecha_Fin").val(encabezado.DA_Fin);
				$("#TX_Fecha_Fin").prop("readonly", true);
				//IF PARA EVALUAR SI EL SEGUIMIENTO TENIA LOS ITEMS DE METAS E INDICADORES.
				var array_propuestas = encabezado.TX_Propuesta.split("|");
				var areas_encabezado = encabezado.VC_Areas.split(";");
				$("#TXTA_PROPUESTA_PEDAGOGICA").val(array_propuestas[0]);
				$("#TXTA_PROPUESTA_METODOLOGICA").val(array_propuestas[1]);
				$("#TXTA_PROPUESTA_PEDAGOGICA").prop("readonly", true);
				$("#TXTA_PROPUESTA_METODOLOGICA").prop("readonly", true);
				$('#SL_Areas').val('');
				$.each(areas_encabezado, function (i) {
					if (areas_encabezado[i] != '') {
						$("#SL_Areas option[value='" + areas_encabezado[i]+ "']").prop('selected', true);
					}
					$('#SL_Areas').prop('disabled', 'disabled');
				});
				$('#SL_Areas').selectpicker("refresh");
				$("#TXTA_OBJETIVO_GRAL").val(encabezado.TX_Objetivo_General);
				$("#TXTA_OBJETIVO_GRAL").prop("readonly", true);
				if(encabezado.TX_Metas != null){
					var numero_rows = Object.keys(JSON.parse(encabezado.TX_Objetivos_Especificos)).length;
					var objetivos_especificos = JSON.parse(encabezado.TX_Objetivos_Especificos); 
					var actividades = JSON.parse(encabezado.TX_Actividades); 
					var metas = JSON.parse(encabezado.TX_Metas); 
					var indicadores = JSON.parse(encabezado.TX_Indicadores); 
					for(k=1;k<=30;k++){
						eliminar_fila();
					}
					var nombre_item = "";
					for(i=1;i<=numero_rows;i++){
						if (bandera == 1){if(i<numero_rows){agregar_fila();}}
						nombre_item = "#objetivo_"+i;
						nombre_objetivo = "#objetivo_"+i;
						$(nombre_item).val(objetivos_especificos["objetivo_"+i]);
						$(nombre_item).prop("readonly", true);

						nombre_item = "#actividad_obj_"+i;
						nombre_actividad = "#actividad_obj_"+i;
						$(nombre_item).val(actividades["actividad_obj_"+i]);
						$(nombre_item).prop("readonly", true);

						nombre_item = "#metas_obj_"+i;
						nombre_metas = "#metas_obj_"+i;
						$(nombre_item).val(metas["metas_obj_"+i]);
						$(nombre_item).prop("readonly", true);

						nombre_item = "#indicador_obj_"+i;
						nombre_objetivo = "#indicador_obj_"+i;
						$(nombre_item).val(indicadores["indicador_obj_"+i]);
						$(nombre_item).prop("readonly", true);
					}
					bandera_existencia = encabezado.PK_Id_Tabla;
				}
				else{
					$("#div_agregar_eliminar").show();
					bandera_existencia = encabezado.PK_Id_Tabla;
				}
			}
			else{
				$("#tab_relizar_seguimiento_v1").removeClass("hidden");
				$("#tab_relizar_seguimiento_v2").removeClass("hidden");
				$("#tab_relizar_seguimiento_v3").removeClass("hidden");
				$("#div_agregar_eliminar").show();
				bandera_existencia = 0;
			}
		},
		async : false
	});
}

function cargarEncabezadoV2(organizacion, bandera, id_seguimiento_periodo){
	var datos = {
		'opcion': 'getEncabezadoSeguimiento',
		'id_organizacion': organizacion,
		'id_periodo': id_seguimiento_periodo
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (data) {
			encabezado = JSON.parse(data);
			if (data != 'null') {
				var anio_inicio_convenio = encabezado.DA_Inicio.substring(0,4);
				if(anio_inicio_convenio == '2017'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v2").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v1").removeClass("hidden");
				}
				if(anio_inicio_convenio == '2018'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v1").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v2").removeClass("hidden");
				}
				if(anio_inicio_convenio == '2019'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v3").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v3").removeClass("hidden");
				}
				$("#div_agregar_eliminar_V2").hide();
				$("#TX_NIT_V2").val(encabezado.VC_Nit);
				$("#TX_NIT_V2").prop("readonly", true);
				$("#TX_Numero_Convenio_V2").val(encabezado.VC_Convenio);
				$("#TX_Numero_Convenio_V2").prop("readonly", true);
				$("#TX_Fecha_Inicio_V2").val(encabezado.DA_Inicio);
				$("#TX_Fecha_Inicio_V2").prop("readonly", true);
				$("#TX_Fecha_Fin_V2").val(encabezado.DA_Fin);
				$("#TX_Fecha_Fin_V2").prop("readonly", true);				
				
				if(encabezado.TX_Objetivo_General){
					$("#TXTA_OBJETIVO_GRAL_V2").val(encabezado.TX_Objetivo_General);
					$("#TXTA_OBJETIVO_GRAL_V2").prop("readonly", true);	
				}
				
				if(encabezado.TX_Propuesta != null){
					var array_propuestas = encabezado.TX_Propuesta.split("|");
					$("#TXTA_PROPUESTA_PEDAGOGICA_V2").val(array_propuestas[0]);
					$("#TXTA_PROPUESTA_METODOLOGICA_V2").val(array_propuestas[1]);
					$("#TXTA_PROPUESTA_PEDAGOGICA_V2").prop("readonly", true);
					$("#TXTA_PROPUESTA_METODOLOGICA_V2").prop("readonly", true);
				}

				if(encabezado.VC_Areas != null){
					var areas_encabezado = encabezado.VC_Areas.split(";");
					$('#SL_Areas_V2').val('');
					$.each(areas_encabezado, function (i) {
						if (areas_encabezado[i] != '') {
							$("#SL_Areas_V2 option[value='" + areas_encabezado[i]+ "']").prop('selected', true);
						}
						$('#SL_Areas_V2').prop('disabled', 'disabled');
					});
					$('#SL_Areas_V2').selectpicker("refresh");
				}
				
				//IF PARA EVALUAR SI EL SEGUIMIENTO TENIA LOS ITEMS DE METAS E INDICADORES.
				if(encabezado.TX_Objetivos_Especificos != null){
					var numero_rows = Object.keys(JSON.parse(encabezado.TX_Objetivos_Especificos)).length;
					var objetivos_especificos = JSON.parse(encabezado.TX_Objetivos_Especificos); 
					var actividades = JSON.parse(encabezado.TX_Actividades); 
					
					for(k=1;k<=30;k++){
						eliminar_fila_V2();
					}
					var nombre_item = "";
					for(i=1;i<=numero_rows;i++){
						if (bandera == 1){if(i<numero_rows){agregar_fila_V2();}}
						nombre_item = "#objetivo_"+i+"_V2";
						nombre_objetivo = "#objetivo_"+i+"_V2";
						$(nombre_item).val(objetivos_especificos["objetivo_"+i]);
						$(nombre_item).prop("readonly", true);

						nombre_item = "#actividad_obj_"+i+"_V2";
						nombre_actividad = "#actividad_obj_"+i+"_V2";
						$(nombre_item).val(actividades["actividad_obj_"+i]);
						$(nombre_item).prop("readonly", true);
					}
					bandera_existencia = encabezado.PK_Id_Tabla;
				}
				else{
					$("#div_agregar_eliminar_V2").show();
					bandera_existencia = encabezado.PK_Id_Tabla;
				}
			}
			else{
				$("#tab_relizar_seguimiento_v1").removeClass("hidden");
				$("#tab_relizar_seguimiento_v2").removeClass("hidden");
				$("#tab_relizar_seguimiento_v3").removeClass("hidden");
				$("#div_agregar_eliminar_V2").show();
				bandera_existencia = 0;
			}
		},
		async : false
	});
}

function cargarEncabezadoV3(organizacion, bandera, id_seguimiento_periodo){
	var datos = {
		'opcion': 'getEncabezadoSeguimiento',
		'id_organizacion': organizacion,
		'id_periodo': id_seguimiento_periodo
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (data) {
			encabezado = JSON.parse(data);
			if (data != 'null') {
				var anio_inicio_convenio = encabezado.DA_Inicio.substring(0,4);
				if(anio_inicio_convenio == '2017'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v2").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v1").removeClass("hidden");
				}
				if(anio_inicio_convenio == '2018'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v1").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v2").removeClass("hidden");
				}
				if(anio_inicio_convenio == '2019'){
					if(id_seguimiento_periodo == ''){
						$("#tab_relizar_seguimiento_v3").addClass("hidden");
					}
					$("#tab_relizar_seguimiento_v3").removeClass("hidden");
				}
				$("#div_agregar_eliminar_V3").hide();
				$("#div_agregar_eliminar_indicador_V3").hide();
				$("#TX_NIT_V3").val(encabezado.VC_Nit);
				$("#TX_NIT_V3").prop("readonly", true);
				$("#TX_Numero_Convenio_V3").val(encabezado.VC_Convenio);
				$("#TX_Numero_Convenio_V3").prop("readonly", true);
				$("#TX_Fecha_Inicio_V3").val(encabezado.DA_Inicio);
				$("#TX_Fecha_Inicio_V3").prop("readonly", true);
				$("#TX_Fecha_Fin_V3").val(encabezado.DA_Fin);
				$("#TX_Fecha_Fin_V3").prop("readonly", true);				
				
				if(encabezado.TX_Objetivo_General){
					$("#TXTA_OBJETIVO_GRAL_V3").val(encabezado.TX_Objetivo_General);
					$("#TXTA_OBJETIVO_GRAL_V3").prop("readonly", true);	
				}
				
				if(encabezado.TX_Propuesta != null){
					var array_propuestas = encabezado.TX_Propuesta.split("|");
					$("#TXTA_PROPUESTA_PEDAGOGICA_V3").val(array_propuestas[0]);
					$("#TXTA_PROPUESTA_METODOLOGICA_V3").val(array_propuestas[1]);
					$("#TXTA_PROPUESTA_PEDAGOGICA_V3").prop("readonly", true);
					$("#TXTA_PROPUESTA_METODOLOGICA_V3").prop("readonly", true);
				}

				if(encabezado.VC_Areas != null){
					var areas_encabezado = encabezado.VC_Areas.split(";");
					$('#SL_Areas_V3').val('');
					$.each(areas_encabezado, function (i) {
						if (areas_encabezado[i] != '') {
							$("#SL_Areas_V3 option[value='" + areas_encabezado[i]+ "']").prop('selected', true);
						}
						$('#SL_Areas_V3').prop('disabled', 'disabled');
					});
					$('#SL_Areas_V3').selectpicker("refresh");
				}
				
				if(encabezado.TX_Objetivos_Especificos != null){
					var numero_rows = Object.keys(JSON.parse(encabezado.TX_Objetivos_Especificos)).length;
					var objetivos_especificos = JSON.parse(encabezado.TX_Objetivos_Especificos); 
					var actividades = JSON.parse(encabezado.TX_Actividades); 
					
					for(k=1;k<=30;k++){
						eliminar_fila_obj_V3();
					}
					var nombre_item = "";
					for(i=1;i<=numero_rows;i++){
						if (bandera == 1){if(i<numero_rows){agregar_fila_obj_V3();}}
						nombre_item = "#objetivo_"+i+"_V3";
						nombre_objetivo = "#objetivo_"+i+"_V3";
						$(nombre_item).val(objetivos_especificos["objetivo_"+i]);
						$(nombre_item).prop("readonly", true);

						nombre_item = "#actividad_obj_"+i+"_V3";
						nombre_actividad = "#actividad_obj_"+i+"_V3";
						$(nombre_item).val(actividades["actividad_obj_"+i]);
						$(nombre_item).prop("readonly", true);
					}
					bandera_existencia = encabezado.PK_Id_Tabla;
				}
				else{
					$("#div_agregar_eliminar_V3").show();
					bandera_existencia = encabezado.PK_Id_Tabla;
				}

				if(encabezado.TX_Indicadores != null){
					var numero_rows_indicadores = Object.keys(JSON.parse(encabezado.TX_Indicadores)).length;
					var indicadores = JSON.parse(encabezado.TX_Indicadores); 
					
					for(k=1;k<=30;k++){
						eliminar_fila_ind_V3();
					}
					var nombre_item = "";
					for(i=1;i<=numero_rows_indicadores;i++){
						if (bandera == 1){if(i<numero_rows_indicadores){agregar_fila_ind_V3();}}
						nombre_item = "#ind_"+i+"_V3";
						nombre_indicador = "#ind_"+i+"_V3";
						$(nombre_item).val(indicadores["indicador_"+i].descripcion);
						$(nombre_item).prop("readonly", true);

						nombre_item = "#formula_ind_"+i+"_V3";
						nombre_indicador = "#formula_ind_"+i+"_V3";
						$(nombre_item).val(indicadores["indicador_"+i].formula);
						$(nombre_item).prop("readonly", true);
					}
					bandera_existencia_indicadores = numero_rows_indicadores;
				}
				else{
					$("#div_agregar_eliminar_indicador_V3").show();
					bandera_existencia_indicadores = 0;
				}
			}
			else{
				$("#tab_relizar_seguimiento_v1").removeClass("hidden");
				$("#tab_relizar_seguimiento_v2").removeClass("hidden");
				$("#tab_relizar_seguimiento_v3").removeClass("hidden");
				$("#div_agregar_eliminar_V3").show();
				bandera_existencia = 0;
			}
		},
		async : false
	});
}

//Consulta todos los seguimientos enviados por la organizacion a lo largo del tiempo para construir un PDF CONSOLIDADO.
function generarPDFReporteConsolidadoSeguimientos(id_organizacion,anio) {
	if (session_type == 11){
		year = $("#SL_Convenios_Organizacion").val();
	}
	else{
		year = $("#SL_Year").val();
	}

	var datos = {
		'opcion': 'getEncabezadoConsolidadoSeguimientos',
		'id_organizacion': id_organizacion,
		'anio': year //Aquí se envía el año del convenio para traer su encabezado.
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (datos) {
			encabezado = JSON.parse(datos);
			objetivos = [];
			propuesta_pedagogica_metodologica=[];
			contenido=[];

			var numero_rows = Object.keys(JSON.parse(encabezado.TX_Objetivos_Especificos)).length;
			for(i=1;i<=numero_rows;i++){
				var objetivos_especificos = JSON.parse(encabezado.TX_Objetivos_Especificos); 
				var actividades = JSON.parse(encabezado.TX_Actividades); 
				var metas = JSON.parse(encabezado.TX_Metas); 
				var indicadores = JSON.parse(encabezado.TX_Indicadores);
				var propuesta = encabezado.TX_Propuesta.split("|");
				objetivos.push(
				{
					style: 'tableExample',
					table: {
						widths: ['*','*','*','*','*'],
						body: [
						[
						{
							text:[{text: 'OBJETIVO '+i,style: 'tableHeader'}],
						},{
							text:[{text: objetivos_especificos["objetivo_"+i],style: 'tableHeader'}],
						},{
							text:[{text: actividades["actividad_obj_"+i],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: metas["metas_obj_"+i],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: indicadores["indicador_obj_"+i],style: 'tableHeader',alignment:'justify'}],
						}],

						]
					}
				}				
				);	
			}
			propuesta_pedagogica_metodologica.push(
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{
						text:[{text: 'Perspectiva Pedagógica (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[0],style: 'tableHeader',alignment:'justify'}],
						style: 'bgcolor',
					}
					],
					[{
						text:[{text: 'Fundamentación Metodológica (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[1],style: 'tableHeader',alignment:'justify'}],
						style: 'bgcolor'
					}
					]
					]
				}
			}
			);
		},
		async : false
	});

	var datos = {
		'opcion': 'getPeriodosSeguimientosOrganizacion',
		'id_organizacion': id_organizacion,
		'year': year+"%"
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (datos) {
			datosparse = JSON.parse(datos);
			contenido = [];

			var numero_rows = (Object.keys(datosparse).length);
			var numero_objetivos = Object.keys(JSON.parse(datosparse[0].TX_Porcentaje)).length;
			for(i=1;i<=numero_rows;i++){
				var porcentajes = JSON.parse(datosparse[i-1].TX_Porcentaje); 
				var cumplimientos = JSON.parse(datosparse[i-1].TX_Cumplimiento);
				var hallazgos = datosparse[i-1].TX_Hallazgos.split("|");
				var transformaciones = datosparse[i-1].TX_Transformaciones.split("|");

				var detalle = [];
				for(j=1;j<=numero_objetivos;j++){
					detalle.push(
					{
						style: 'tableExample',
						table: {
							widths: ['10%','45%','45%'],
							body: [

							[{
								text:[{text: 'Objetivo '+j ,style: 'tableHeader',alignment:'center'}],
							},{
								text:[{text: porcentajes['porcentaje_'+j],style: 'tableHeader',alignment:'justify'}],
							},{
								text:[{text: cumplimientos['cumplimiento_'+j],style: 'tableHeader',alignment:'justify'}],
							}
							],
							]
						}
					}
					);
				}

				contenido.push(
					{text: '\n'},
					{
						style: 'tableExample',
						table: {
							widths: ['10%','45%','45%'],
							body: [

							[{
								text:[{text: 'Periodo Reportado: '+datosparse[i-1].VC_Periodo,style: 'tableHeader',alignment:'center'}],
								style: 'bgcolor',
								colSpan: 3
							},{},{}
							],
							[{
								text:[{text: 'Número de Grupos Atendidos: '+datosparse[i-1].IN_Grupos,style: 'tableHeader',alignment:'center'}],
								colSpan: 3,
							},{},{}
							],
							[{
								text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
							},{
								text:[{text: 'Indicadores',style: 'tableHeader',alignment:'center'}],
							},{
								text:[{text: 'Cumplimiento',style: 'tableHeader',alignment:'center'}],
							},
							]
							]
						}
					},
					detalle,
					{
						style: 'tableExample',
						table: {
							widths: ['20%','*','*'],
							body: [
							[{
								text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
							},{
								text:[{text: 'Hallazgos',style: 'tableHeader',alignment:'center'}],
							},{
								text:[{text: 'Transformaciones',style: 'tableHeader',alignment:'center'}],
							}
							],
							[{
								text:[{text: 'Perspectivas Pedagógicas' ,style: 'tableHeader',alignment:'center'}],
								style: 'bgcolor'
							},{
								text:[{text: hallazgos[0],style: 'tableHeader',alignment:'justify'}],
								style: 'bgcolor',
							},{
								text:[{text: transformaciones[0],style: 'tableHeader',alignment:'justify'}],
								style: 'bgcolor'
							}
							],
							[{
								text:[{text: 'Fundamentación Metodológica ' ,style: 'tableHeader',alignment:'center'}],
								style: 'bgcolor'
							},{
								text:[{text: hallazgos[1],style: 'tableHeader',alignment:'justify'}],
								style: 'bgcolor'
							},{
								text:[{text: transformaciones[1],style: 'tableHeader',alignment:'justify'}],
								style: 'bgcolor'
							}
							],
							]
						}
					}
					);	
			}

					//construirPDF(objetivos,contenido);
				},
				async : false
			});
	construirPDF(objetivos,propuesta_pedagogica_metodologica,contenido);

}
function generarPDFSeguimientoPeriodoV1(id_organizacion,id_seguimiento_periodo) {
	var datos = {
		'opcion': 'getEncabezadoSeguimiento',
		'id_organizacion': id_organizacion,
		'id_periodo': id_seguimiento_periodo //Aquí se envía el ID del periodo que se quiere consultar.
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (datos) {
			encabezado = JSON.parse(datos);
			objetivos = [];
			propuesta_pedagogica_metodologica=[];
			contenido=[];

			var numero_rows = Object.keys(JSON.parse(encabezado.TX_Objetivos_Especificos)).length;
			for(i=1;i<=numero_rows;i++){
				var objetivos_especificos = JSON.parse(encabezado.TX_Objetivos_Especificos); 
				var actividades = JSON.parse(encabezado.TX_Actividades); 
				var metas = JSON.parse(encabezado.TX_Metas); 
				var indicadores = JSON.parse(encabezado.TX_Indicadores);
				var propuesta = encabezado.TX_Propuesta.split("|");
				objetivos.push(
				{
					style: 'tableExample',
					table: {
						widths: ['*','*','*','*','*'],
						body: [
						[
						{
							text:[{text: 'OBJETIVO '+i,style: 'tableHeader'}],
						},{
							text:[{text: objetivos_especificos["objetivo_"+i],style: 'tableHeader'}],
						},{
							text:[{text: actividades["actividad_obj_"+i],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: metas["metas_obj_"+i],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: indicadores["indicador_obj_"+i],style: 'tableHeader',alignment:'justify'}],
						}],

						]
					}
				}				
				);	
			}
			propuesta_pedagogica_metodologica.push(
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{
						text:[{text: 'Perspectiva Pedagógica (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[0],style: 'tableHeader',alignment:'justify'}],
						style: 'bgcolor',
					}
					],
					[{
						text:[{text: 'Fundamentación Metodológica (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[1],style: 'tableHeader',alignment:'justify'}],
						style: 'bgcolor'
					}
					]
					]
				}
			}
			);
		},
		async : false
	});

	var datos = {
		'opcion': 'getSeguimientoPeriodo',
		'id_periodo': id_seguimiento_periodo
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		beforeSend: function(){
			parent.mostrarCargando();
		},
		success: function (datos) {
			datosparse = JSON.parse(datos);
			contenido = [];

			var numero_objetivos = Object.keys(JSON.parse(datosparse.TX_Porcentaje)).length;
			console.log(numero_objetivos);
			var porcentajes = JSON.parse(datosparse.TX_Porcentaje); 
			var cumplimientos = JSON.parse(datosparse.TX_Cumplimiento);
			var hallazgos = datosparse.TX_Hallazgos.split("|");
			var transformaciones = datosparse.TX_Transformaciones.split("|");
			var aprobacion = "";
			if(datosparse.IN_Aprobacion==null){
				aprobacion="SIN REVISAR";
			}
			if(datosparse.IN_Aprobacion==0){
				aprobacion="NO APROBADO";
			}
			if(datosparse.IN_Aprobacion==1){
				aprobacion="APROBADO";
			}
			var detalle = [];
			for(j=1;j<=numero_objetivos;j++){
				detalle.push(
				{
					style: 'tableExample',
					table: {
						widths: ['10%','45%','45%'],
						body: [

						[{
							text:[{text: 'Objetivo '+j ,style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: porcentajes['porcentaje_'+j],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: cumplimientos['cumplimiento_'+j],style: 'tableHeader',alignment:'justify'}],
						}
						],
						]
					}
				}
				);
			}

			contenido.push(
				{text: '\n'},
				{
					style: 'tableExample',
					table: {
						widths: ['10%','45%','45%'],
						body: [
						[{
							text:[{text: 'Estado: '+aprobacion,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor',
							colSpan: 3
						},{},{}
						],
						[{
							text:[{text: 'Periodo Reportado: '+datosparse.VC_Periodo,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor',
							colSpan: 3
						},{},{}
						],
						[{
							text:[{text: 'Número de Grupos Atendidos: '+datosparse.IN_Grupos,style: 'tableHeader',alignment:'center'}],
							colSpan: 3,
						},{},{}
						],
						[{
							text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Indicadores',style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Cumplimiento',style: 'tableHeader',alignment:'center'}],
						},
						]
						]
					}
				},
				detalle,
				{
					style: 'tableExample',
					table: {
						widths: ['20%','*','*'],
						body: [
						[{
							text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Hallazgos',style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Transformaciones',style: 'tableHeader',alignment:'center'}],
						}
						],
						[{
							text:[{text: 'Perspectivas Pedagógicas' ,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: hallazgos[0],style: 'tableHeader',alignment:'justify'}],
							style: 'bgcolor',
						},{
							text:[{text: transformaciones[0],style: 'tableHeader',alignment:'justify'}],
							style: 'bgcolor'
						}
						],
						[{
							text:[{text: 'Fundamentación Metodológica ' ,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: hallazgos[1],style: 'tableHeader',alignment:'justify'}],
							style: 'bgcolor'
						},{
							text:[{text: transformaciones[1],style: 'tableHeader',alignment:'justify'}],
							style: 'bgcolor'
						}
						],
						]
					}
				}
				);	
					//construirPDF(objetivos,contenido);
					parent.cerrarCargando();
				},
				async : false
			});
	construirPDF(objetivos,propuesta_pedagogica_metodologica,contenido);

}

function generarPDFSeguimientoPeriodoV2(id_organizacion,id_seguimiento_periodo) {
	var datos = {
		'opcion': 'getEncabezadoSeguimiento',
		'id_organizacion': id_organizacion,
		'id_periodo': id_seguimiento_periodo //Aquí se envía el ID del periodo que se quiere consultar.
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (datos) {
			encabezado = JSON.parse(datos);
			objetivos = [];
			propuesta_pedagogica_metodologica=[];
			contenido=[];

			var numero_rows = Object.keys(JSON.parse(encabezado.TX_Objetivos_Especificos)).length;
			for(i=1;i<=numero_rows;i++){
				var objetivos_especificos = JSON.parse(encabezado.TX_Objetivos_Especificos); 
				var actividades = JSON.parse(encabezado.TX_Actividades);
				var propuesta = encabezado.TX_Propuesta.split("|");
				objetivos.push(
				{
					style: 'tableExample',
					table: {
						widths: ['*','*','*'],
						body: [
						[
						{
							text:[{text: 'OBJETIVO '+i,style: 'tableHeader'}],
						},{
							text:[{text: objetivos_especificos["objetivo_"+i],style: 'tableHeader'}],
						},{
							text:[{text: actividades["actividad_obj_"+i],style: 'tableHeader',alignment:'justify'}],
						}],

						]
					}
				}				
				);	
			}
			propuesta_pedagogica_metodologica.push(
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{
						text:[{text: 'Perspectiva Pedagógica (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[0],style: 'tableHeader',alignment:'justify'}],
					}
					],
					[{
						text:[{text: 'Metodología (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[1],style: 'tableHeader',alignment:'justify'}],
					}
					]
					]
				}
			}
			);
		},
		async : false
	});

	var datos = {
		'opcion': 'getSeguimientoPeriodo',
		'id_periodo': id_seguimiento_periodo
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		beforeSend: function(){
			parent.mostrarCargando();
		},
		success: function (datos) {
			datosparse = JSON.parse(datos);
			contenido = [];
			var avances_formacion = datosparse.TX_Avances_Formacion.split("|");
			var aportes_articulacion = datosparse.TX_Aportes_Articulacion.split("|");
			var aprobacion = "";
			if(datosparse.IN_Aprobacion==null){
				aprobacion="SIN REVISAR";
			}
			if(datosparse.IN_Aprobacion==0){
				aprobacion="NO APROBADO";
			}
			if(datosparse.IN_Aprobacion==1){
				aprobacion="APROBADO";
			}

			contenido.push(
				{text: '\n'},
				{
					style: 'tableExample',
					table: {
						widths: ['10%','45%','45%'],
						body: [
						[{
							text:[{text: 'Estado: '+aprobacion,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor',
							colSpan: 3
						},{},{}
						],
						[{
							text:[{text: 'Periodo Reportado: '+datosparse.VC_Periodo,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor',
							colSpan: 3
						},{},{}
						],
						[{
							text:[{text: 'Número de Grupos Atendidos: '+datosparse.IN_Grupos,style: 'tableHeader',alignment:'center'}],
							colSpan: 3,
						},{},{}
						],
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['20%','*','*'],
						body: [
						[{
							text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Avances en el desarrollo y relación con los indicadores referidos a las nociones de Cuerpo, Territorio, Juego y Creación',style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: 'Formación (acciones que evidencian la implementación de la metodología propuesta por la organización)',style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						}
						],
						[{
							text:[{text: 'AVANCES EN EL DESARROLLO DE LA PROPUESTA PEDAGÓGICA' ,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: avances_formacion[0],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: avances_formacion[1],style: 'tableHeader',alignment:'justify'}],
						}
						],
						[{
							text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Aportes al Programa Crea en cuanto a la formación y otros aspectos',style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Articulación en territorio (GPT, Coordinación Crea, IED)',style: 'tableHeader',alignment:'center'}],
						}
						],
						[{
							text:[{text: 'APORTES DE LA ORGANIZACIÓN' ,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: aportes_articulacion[0],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: aportes_articulacion[1],style: 'tableHeader',alignment:'justify'}],
						}
						],
						]
					}
				}
				);	
					//construirPDF(objetivos,contenido);
					parent.cerrarCargando();
				},
				async : false
			});
	construirPDFV2(objetivos,propuesta_pedagogica_metodologica,contenido);
}

function generarPDFSeguimientoPeriodoV3(id_organizacion,id_seguimiento_periodo) {
	var datos = {
		'opcion': 'getEncabezadoSeguimiento',
		'id_organizacion': id_organizacion,
		'id_periodo': id_seguimiento_periodo //Aquí se envía el ID del periodo que se quiere consultar.
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		success: function (datos) {
			encabezado = JSON.parse(datos);
			objetivos = [];
			indicadores = [];
			propuesta_pedagogica_metodologica=[];
			contenido=[];

			var numero_rows = Object.keys(JSON.parse(encabezado.TX_Objetivos_Especificos)).length;
			for(i=1;i<=numero_rows;i++){
				var objetivos_especificos = JSON.parse(encabezado.TX_Objetivos_Especificos); 
				var actividades = JSON.parse(encabezado.TX_Actividades);
				var propuesta = encabezado.TX_Propuesta.split("|");
				objetivos.push(
				{
					style: 'tableExample',
					table: {
						widths: ['*','*','*'],
						body: [
						[
						{
							text:[{text: 'OBJETIVO '+i,style: 'tableHeader'}],
							border: [true, true, true, false]
						},{
							text:[{text: objetivos_especificos["objetivo_"+i],style: 'tableHeader'}],
							border: [true, true, true, false]
						},{
							text:[{text: actividades["actividad_obj_"+i],style: 'tableHeader',alignment:'justify'}],
							border: [true, true, true, false]
						}],

						]
					}
				}				
				);	
			}
			indicadores.push(
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{
						text:[{text: 'INDICADORES' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor',
						border: [true, true, true, false]
					}]
					]
				}
			},
			{
				style: 'tableExample',
				table: {
					widths: ['*','*','*'],
					body: [
					[{
						text:[{text: '',style: 'tableHeader'}],
						border: [true, true, true, false]			
					},{
						text:[{text: 'Descripción',style: 'tableHeader'}],
						border: [true, true, true, false]
					},{
						text:[{text: 'Fórmula',style: 'tableHeader'}],
						border: [true, true, true, false]
					}]
					]
				}
			},
			);
			if(!encabezado.TX_Indicadores){ parent.swal("Debe diligenciar los INDICADORES para poder descargar el PDF.","","error"); }
			var numero_indicadores = Object.keys(JSON.parse(encabezado.TX_Indicadores)).length;
			for(i=1;i<=numero_indicadores;i++){
				var indicadores_convenio = JSON.parse(encabezado.TX_Indicadores);
				var cumplimiento = JSON.parse(encabezado.TX_Cumplimiento); 
				indicadores.push(
				{
					style: 'tableExample',
					table: {
						widths: ['*','*','*'],
						body: [
						[
						{
							text:[{text: 'INDICADOR '+i,style: 'tableHeader'}],
							border: [true, true, true, false]
						},{
							text:[{text: indicadores_convenio["indicador_"+i].descripcion,style: 'tableHeader'}],
							border: [true, true, true, false]
						},{
							text:[{text: indicadores_convenio["indicador_"+i].formula,style: 'tableHeader',alignment:'justify'}],
							border: [true, true, true, false]
						}],
						]
					}
				}				
				);	
			}
			propuesta_pedagogica_metodologica.push(
			{
				style: 'tableExample',
				table: {
					widths: ['*'],
					body: [
					[{
						text:[{text: 'Perspectiva Pedagógica (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[0],style: 'tableHeader',alignment:'justify'}],
					}
					],
					[{
						text:[{text: 'Metodología (Propuesta)' ,style: 'tableHeader',alignment:'center'}],
						style: 'bgcolor'
					}],[{
						text:[{text: propuesta[1],style: 'tableHeader',alignment:'justify'}],
					}
					]
					]
				}
			}
			);
		},
		async : false
	});

	var datos = {
		'opcion': 'getSeguimientoPeriodo',
		'id_periodo': id_seguimiento_periodo
	};

	$.ajax({
		url: url_controller, 
		data: datos,
		type: 'POST',
		beforeSend: function(){
			parent.mostrarCargando();
		},
		success: function (datos) {
			datosparse = JSON.parse(datos);
			contenido = [];
			cumplimientos = [];
			var avances_formacion = datosparse.TX_Avances_Formacion.split("|");
			var aportes_articulacion = datosparse.TX_Aportes_Articulacion.split("|");
			var aprobacion = "";
			if(datosparse.IN_Aprobacion==null){
				aprobacion="SIN REVISAR";
			}
			if(datosparse.IN_Aprobacion==0){
				aprobacion="NO APROBADO";
			}
			if(datosparse.IN_Aprobacion==1){
				aprobacion="APROBADO";
			}

			var numero_cumplimientos = Object.keys(JSON.parse(datosparse.TX_Cumplimiento)).length;
			for(i=1;i<=numero_cumplimientos;i++){
				var cumplimientos_periodo = JSON.parse(datosparse.TX_Cumplimiento);
				cumplimientos.push(
				{
					style: 'tableExample',
					table: {
						widths: ['10%','*'],
						body: [
						[
						{
							text:[{text: 'INDICADOR '+i,style: 'tableHeader'}],
							border: [true, true, true, false]
						},{
							text:[{text: cumplimientos_periodo["cumplimiento_indicador_"+i],style: 'tableHeader'}],
							border: [true, true, true, false]
						}],
						]
					}
				}				
				);	
			}

			contenido.push(
				{text: '\n'},
				{
					style: 'tableExample',
					table: {
						widths: ['10%','45%','45%'],
						body: [
						[{
							text:[{text: 'Estado: '+aprobacion,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor',
							colSpan: 3
						},{},{}
						],
						[{
							text:[{text: 'Periodo Reportado: '+datosparse.VC_Periodo,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor',
							colSpan: 3
						},{},{}
						],
						[{
							text:[{text: 'Número de Grupos Atendidos: '+datosparse.IN_Grupos,style: 'tableHeader',alignment:'center'}],
							colSpan: 3,
							border: [true, true, true, false]
						},{},{}
						],
						]
					}
				},
				{
					style: 'tableExample',
					table: {
						widths: ['*'],
						body: [
						[{
							text:[{text: 'CUMPLIMIENTO INDICADORES' ,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor',
							border: [true, true, true, false]
						}]
						]
					}
				},
				cumplimientos,
				{
					style: 'tableExample',
					table: {
						widths: ['20%','*','*'],
						body: [
						[{
							text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Avances en el desarrollo y relación con los indicadores referidos a las nociones de Cuerpo, Territorio, Juego y Creación',style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: 'Formación (acciones que evidencian la implementación de la metodología propuesta por la organización)',style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						}
						],
						[{
							text:[{text: 'AVANCES EN EL DESARROLLO DE LA PROPUESTA PEDAGÓGICA' ,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: avances_formacion[0],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: avances_formacion[1],style: 'tableHeader',alignment:'justify'}],
						}
						],
						[{
							text:[{text: '' ,style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Aportes al Programa Crea en cuanto a la formación y otros aspectos',style: 'tableHeader',alignment:'center'}],
						},{
							text:[{text: 'Articulación en territorio (GPT, Coordinación Crea, IED)',style: 'tableHeader',alignment:'center'}],
						}
						],
						[{
							text:[{text: 'APORTES DE LA ORGANIZACIÓN' ,style: 'tableHeader',alignment:'center'}],
							style: 'bgcolor'
						},{
							text:[{text: aportes_articulacion[0],style: 'tableHeader',alignment:'justify'}],
						},{
							text:[{text: aportes_articulacion[1],style: 'tableHeader',alignment:'justify'}],
						}
						],
						]
					}
				}
				);
			parent.cerrarCargando();
		},
		async : false
	});
construirPDFV3(objetivos,indicadores,propuesta_pedagogica_metodologica,contenido);
}

function construirPDF(objetivos,propuesta_pedagogica_metodologica,contenido) {
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
					image: 'data:image/jpeg;base64,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RQAUUUUAFFFFABRRRQAYHp7fh6UUUUBZLZWCiiigBv3l9M/406iigAooooAKMD0oooFZdkN3r6/of8KdRRQMMD0ooooAKKKKACiiijbYAooooAKKKKACiiigLLe2vcKKKKACm7F9P1P+NOooE0nuk/UKKKKBhRgHqM0UUfpt5AN2L6fqf8adTVbdnjGKdQFl2/r+kgooooAMAdBiiiigBuxfT9T/AI0bF9P1P+NOooCy7f1/SQ3cvTPHpg/4U6iigBu75se369fyx+tBVW5PPv8A5yKdRQA35P8AZ/SnUUUBZLZWCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooppdR1YUAOoqGW4hhTzJXCL6n646DNHmwf34/zFAE1FQLNE0jxo4Lx9UBH8h/n2pwmjbOGx/n8RQBLRTHdE+8wX3P/wCo1EtxDJv2Oj+XjzP8/wCPAoAsUVX+0J6fqKl8xP7woAfRUHnxbUfeNkmPL469v8jqPSnpKkn3D+OO9AXXf+v6aJKKZ5if3hRvHof0/wAaAH0VF5nzY7Y6d8eufX2//XSebFt3bxjPl/j9MZzjn6UASb19f0P+FG9fX9D/AIUzzk37O/r/AJ7+3XHvxUZurceWPMT95/qh6/4c/T86CPaQ/mRZoqLz4v74/X/CneYgHLcep9vw5oLH0xvlVj9Sfx60pZV4PHt/nArgviX8RvCHwn8A+LPiT461e20Xwn4L0LUfEmu6pcSAQ2+naRbPeXbZ5yQlsVxjknJxkkAHZtM6q7742Qj91s7H3657/gOKtKcrz9D/AJ+lfNf7Lv7T/wAN/wBrb4Y2fxd+FEuoXngnVLq5tdK1S8tfIg1IWnW6tP8AZ6ZGO2cDjH0as22ISTNGmBmU9h2/yeeKALNFNVt2eMYo3r6/of8ACgB1FQ+fFvEe8Fj/AD/p/n3p/mJ/eFAXW19ewioc8/l6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',
					height:60,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nFORMATO DE SUPERVISIÓN DE ORGANIZACIONES',alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'data:image/jpeg;base64,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',
					height:60,
					width:120,
					border: [false, false, false, false]
				},

				]
				]

			}

		},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*','*'],
				body: [
				[{
					text:[{text: 'ORGANIZACIÓN: ',style: 'tableHeader'},{text:encabezado.VC_Nom_Organizacion}],
					colSpan: 4
				},{},{},{}],
				[{
					text:[{text: 'NIT: ',style: 'tableHeader'},{text:encabezado.VC_Nit}],
				},{
					text:[{text: 'NÚMERO DE CONVENIO: ',style: 'tableHeader'},{text:encabezado.VC_Convenio}],
				},{
					text:[{text: 'INICIO: ',style: 'tableHeader'},{text:encabezado.DA_Inicio}],
				},{
					text:[{text: 'FIN: ',style: 'tableHeader'},{text:encabezado.DA_Fin}],
				}],
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*','*','*'],
				body: [
				[{
					text:[{text: '',style: 'tableHeader'}],				
				},{
					text:[{text: 'Propuesta',style: 'tableHeader'}],
				},{
					text:[{text: 'Actividades',style: 'tableHeader'}],
				},{
					text:[{text: 'Metas',style: 'tableHeader'}],
				},{
					text:[{text: 'Indicadores',style: 'tableHeader'}],
				}],
				[{
					text:[{text: 'OBJETIVO GENERAL'}],
					style: 'bgcolor',
				},{
					text:[{text: encabezado.TX_Objetivo_General,alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: ' ',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: '',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: '',alignment:'justify'}],
					style: 'bgcolor',
				}],
				
				]
			}
		},
		objetivos,
		propuesta_pedagogica_metodologica,
		{text: '\n'},
		contenido,		
		{text: '\n'},
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
				fontSize: 12,
				bold: true,
				margin: [0, 10, 0, 5]
			},
			tableExample: {
				margin: [0, 0, 0, 0]
			},
			tableHeader: {
				bold: true,
				fontSize: 10
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
		pdfMake.createPdf(pdfData).download("FormatoSupervisionOrganizacion.pdf"); 
	});
}

function construirPDFV2(objetivos,propuesta_pedagogica_metodologica,contenido) {
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
					height:60,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nFORMATO DE SUPERVISIÓN DE ORGANIZACIONES',alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'data:image/jpeg;base64,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',
					height:60,
					width:120,
					border: [false, false, false, false]
				},

				]
				]

			}

		},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*','*'],
				body: [
				[{
					text:[{text: 'ORGANIZACIÓN: ',style: 'tableHeader'},{text:encabezado.VC_Nom_Organizacion}],
					colSpan: 4
				},{},{},{}],
				[{
					text:[{text: 'NIT: ',style: 'tableHeader'},{text:encabezado.VC_Nit}],
				},{
					text:[{text: 'NÚMERO DE CONVENIO: ',style: 'tableHeader'},{text:encabezado.VC_Convenio}],
				},{
					text:[{text: 'INICIO: ',style: 'tableHeader'},{text:encabezado.DA_Inicio}],
				},{
					text:[{text: 'FIN: ',style: 'tableHeader'},{text:encabezado.DA_Fin}],
				}],
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*'],
				body: [
				[{
					text:[{text: '',style: 'tableHeader'}],				
				},{
					text:[{text: 'Descripcion',style: 'tableHeader'}],
				},{
					text:[{text: 'Actividades',style: 'tableHeader'}],
				}],
				[{
					text:[{text: 'OBJETIVO GENERAL'}],
					style: 'bgcolor',
				},{
					text:[{text: encabezado.TX_Objetivo_General,alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: ' ',alignment:'justify'}],
					style: 'bgcolor',
				}],
				]
			}
		},
		objetivos,
		propuesta_pedagogica_metodologica,
		{text: '\n'},
		contenido,		
		{text: '\n'},
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
				fontSize: 12,
				bold: true,
				margin: [0, 10, 0, 5]
			},
			tableExample: {
				margin: [0, 0, 0, 0]
			},
			tableHeader: {
				bold: true,
				fontSize: 10
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
		pdfMake.createPdf(pdfData).download("FormatoSupervisionOrganizacion.pdf"); 
	});
}

function construirPDFV3(objetivos,indicadores,propuesta_pedagogica_metodologica,contenido) {
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
					height:60,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nFORMATO DE SUPERVISIÓN DE ORGANIZACIONES',alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'data:image/jpeg;base64,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',
					height:60,
					width:120,
					border: [false, false, false, false]
				},

				]
				]

			}

		},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*','*'],
				body: [
				[{
					text:[{text: 'ORGANIZACIÓN: ',style: 'tableHeader'},{text:encabezado.VC_Nom_Organizacion}],
					colSpan: 4,
					border: [false, false, false, false]
				},{},{},{}],
				[{
					text:[{text: 'NIT: ',style: 'tableHeader'},{text:encabezado.VC_Nit}],
					border: [false, false, false, false]
				},{
					text:[{text: 'NÚMERO DE CONVENIO: ',style: 'tableHeader'},{text:encabezado.VC_Convenio}],
					border: [false, false, false, false]
				},{
					text:[{text: 'INICIO: ',style: 'tableHeader'},{text:encabezado.DA_Inicio}],
					border: [false, false, false, false]
				},{
					text:[{text: 'FIN: ',style: 'tableHeader'},{text:encabezado.DA_Fin}],
					border: [false, false, false, false]
				}],
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{
					text:[{text: 'OBJETIVOS' ,style: 'tableHeader',alignment:'center'}],
					style: 'bgcolor',
					border: [true, true, true, false]
				}]
				]
			}
		},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*'],
				body: [
				[{
					text:[{text: '',style: 'tableHeader'}],				
				},{
					text:[{text: 'Descripción',style: 'tableHeader'}],
				},{
					text:[{text: 'Actividades',style: 'tableHeader'}],
				}],
				[{
					text:[{text: 'OBJETIVO GENERAL'}],
					style: 'bgcolor',
					border: [true, true, true, false]
				},{
					text:[{text: encabezado.TX_Objetivo_General,alignment:'justify'}],
					style: 'bgcolor',
					border: [true, true, true, false]
				},{
					text:[{text: ' ',alignment:'justify'}],
					style: 'bgcolor',
					border: [true, true, true, false]
				}],
				]
			}
		},
		objetivos,
		indicadores,
		propuesta_pedagogica_metodologica,
		{text: '\n'},
		contenido,
		{text: '\n'},
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
				fontSize: 12,
				bold: true,
				margin: [0, 10, 0, 5]
			},
			tableExample: {
				margin: [0, 0, 0, 0]
			},
			tableHeader: {
				bold: true,
				fontSize: 10
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
		pdfMake.createPdf(pdfData).download("FormatoSupervisionOrganizacion.pdf"); 
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