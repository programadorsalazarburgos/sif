var url_controller_fas = "../../Controlador/Organizaciones/C_FAS_Organizaciones.php";
var session = "";
var session_type = "";
var numeros = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30'];
var contador_obligaciones = 2;
var contador_obligaciones_asociado = 2;
var bandera_existencia_info_contractual = "";
var bandera_existencia_seguimiento_propuesta = "";
var bandera_ultimo_informe=0;
var id_periodo = "";
var pdfData;
var id_pk_tabla = 0;
var tipoInforme = 0;
var year="";
$(document).ready(function(){

	if(!alertify.myAlert){
	  //define a new dialog
	  alertify.dialog('myAlert',function factory(){
	  	return{
	  		main:function(message){
	  			this.message = message;
	  		},
	  		setup:function(){
	  			return {
	  			buttons:[{text: "cool!", key:27/*Esc*/}],
	  			focus: { element:0 }
	  		};
	  	},
	  	prepare:function(){
	  		this.setContent(this.message);
	  	}
	  }});
	}

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

	cargarEncabezado(session,1,'');
	$("#crear_fila_objetivo").on('click', function(){
		agregar_fila();
	});
	$("#eliminar_fila_objetivo").on('click', function(){
		eliminar_fila();
	});
	$("#crear_fila_obligacion").on('click', function(){
		agregar_fila();
		agregar_fila_recursos_idartes();
	});
	$("#eliminar_fila_obligacion").on('click', function(){
		eliminar_fila();
		eliminar_fila_recursos_idartes();
	});
	$("#crear_fila_recursos_idartes").on('click', function(){
		agregar_fila_recursos_idartes();
	});
	$("#eliminar_fila_recursos_idartes").on('click', function(){
		eliminar_fila_recursos_idartes();
	});
	$("#crear_fila_recursos_asociado").on('click', function(){
		agregar_fila_recursos_asociado();
	});
	$("#eliminar_fila_recursos_asociado").on('click', function(){
		eliminar_fila_recursos_asociado();
	});
	$(".conquien").on('click', function(){
		abrirmodal(this.id);
	});

	$('[data-toggle="tooltip"]').tooltip();

	$(".leer_obligacion").on('click', function(){
		var id_obligacion = $(this).parent().attr('id').split("_");
		id_obligacion = id_obligacion[1];
		parent.swal("Obligación Específica "+id_obligacion,$("#obligacion_especifica_"+id_obligacion).val(),"");
	});

	// $("#TX_Poblacion_Beneficiada").on('click', function(){
	// 	abrirmodal(this.id);
	// });
	$(".folios_tb1, .folios_tb2").on('click', function(){
		var id = this.id;
		var values = "";
		var numero_informe = id.split("_");
		var nombre_elemento = "SL_Informe_"+numero_informe[1]+"_"+numero_informe[2];
		var cantidad_informes = 0;
		$("#modal_folios #modal_body").html('');
		$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			//values += $(selected).val()+";";
			$("#modal_folios #modal_body").append("<div id='div_folios_informe_"+$(selected).val()+"' class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'><p style='text-align:right'>Folio Informe "+$(selected).val()+":</p></div><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><input id='folios_informe_"+$(selected).val()+"' name='folios_informe_"+$(selected).val()+"' type='text' class='form-control'></div></div>");
		});
		//alert(cantidad_informes);
		$("#modal_folios").modal('show');
		if (numero_informe[1]=="tb1") {
			abrirmodalfoliosidartes(this.id);
		}
		if (numero_informe[1]=="tb2") {
			abrirmodalfoliosasociado(this.id);
		}
	});

	$(".estado_check").on('change', function(){
		if(this.checked){
			$("#div_conquien_"+$(this).data("id")).show();
			$("#conquien_"+$(this).data("id")).prop('required', true);
			$("#descripcion_conquien_"+$(this).data("id")).prop('required', true);
		}
		else{
			$("#conquien_"+$(this).data("id")).prop('required', false);
			$("#descripcion_conquien_"+$(this).data("id")).prop('required', false);
			$("#div_conquien_"+$(this).data("id")).hide();
		}
	});

	$(".readonly").on('keydown paste', function(e){
		e.preventDefault();
	});

	$("#modal_con_quien").find("#capturar_beneficiarios").on('click', function(){
		var B_Mujeres = $("#modal_con_quien #BH_Mujeres").val(); if (B_Mujeres == "") { B_Mujeres="0"};
		var B_Hombres = $("#modal_con_quien #BH_Hombres").val(); if (B_Hombres == "") { B_Hombres="0"};
		var B_P_Infancia = $("#modal_con_quien #BH_P_Infancia").val(); if (B_P_Infancia == "") { B_P_Infancia="0"};
		var B_Infancia = $("#modal_con_quien #BH_Infancia").val(); if (B_Infancia == "") { B_Infancia="0"};
		var B_Adolescencia = $("#modal_con_quien #BH_Adolescencia").val(); if (B_Adolescencia == "") { B_Adolescencia="0"};
		var B_Juventud = $("#modal_con_quien #BH_Juventud").val(); if (B_Juventud == "") { B_Juventud="0"};
		var B_Adulto = $("#modal_con_quien #BH_Adulto").val(); if (B_Adulto == "") { B_Adulto="0"};
		var B_Adulto_Mayor = $("#modal_con_quien #BH_Adulto_Mayor").val(); if (B_Adulto_Mayor == "") { B_Adulto_Mayor="0"};
		var B_Campesinos = $("#modal_con_quien #BH_Campesinos").val(); if (B_Campesinos == "") { B_Campesinos="0"};
		var B_Artesanos = $("#modal_con_quien #BH_Artesanos").val(); if (B_Artesanos == "") { B_Artesanos="0"};
		var B_Discapacidad = $("#modal_con_quien #BH_Discapacidad").val(); if (B_Discapacidad == "") { B_Discapacidad="0"};
		var B_LGBTI = $("#modal_con_quien #BH_LGBTI").val(); if (B_LGBTI == "") { B_LGBTI="0"};
		var B_Reinsertados = $("#modal_con_quien #BH_Reinsertados").val(); if (B_Reinsertados == "") { B_Reinsertados="0"};
		var B_Victimas = $("#modal_con_quien #BH_Victimas").val(); if (B_Victimas == "") { B_Victimas="0"};
		var B_Dezplazamiento = $("#modal_con_quien #BH_Dezplazamiento").val(); if (B_Dezplazamiento == "") { B_Dezplazamiento="0"};
		var B_Habitantes_Calle = $("#modal_con_quien #BH_Habitantes_Calle").val(); if (B_Habitantes_Calle == "") { B_Habitantes_Calle="0"};
		var B_Medios_Comunitarios = $("#modal_con_quien #BH_Medios_Comunitarios").val(); if (B_Medios_Comunitarios == "") { B_Medios_Comunitarios="0"};
		var B_Pueblo_Raizal = $("#modal_con_quien #BH_Pueblo_Raizal").val(); if (B_Pueblo_Raizal == "") { B_Pueblo_Raizal="0"};
		var B_Afrodescendientes = $("#modal_con_quien #BH_Afrodescendientes").val(); if (B_Afrodescendientes == "") { B_Afrodescendientes="0"};
		var B_Pueblo_Gitano = $("#modal_con_quien #BH_Pueblo_Gitano").val(); if (B_Pueblo_Gitano == "") { B_Pueblo_Gitano="0"};
		var B_Indigenas = $("#modal_con_quien #BH_Indigenas").val(); if (B_Indigenas == "") { B_Indigenas="0"};
		var B_Otras_Etnias = $("#modal_con_quien #BH_Otras_Etnias").val(); if (B_Otras_Etnias == "") { B_Otras_Etnias="0"};
		var B_Estrato_Uno = $("#modal_con_quien #BH_Estrato_Uno").val(); if (B_Estrato_Uno == "") { B_Estrato_Uno="0"};
		var B_Estrato_Dos = $("#modal_con_quien #BH_Estrato_Dos").val(); if (B_Estrato_Dos == "") { B_Estrato_Dos="0"};
		var B_Estrato_Tres = $("#modal_con_quien #BH_Estrato_Tres").val(); if (B_Estrato_Tres == "") { B_Estrato_Tres="0"};
		var B_Estrato_Cuatro = $("#modal_con_quien #BH_Estrato_Cuatro").val(); if (B_Estrato_Cuatro == "") { B_Estrato_Cuatro="0"};
		var B_Estrato_Cinco = $("#modal_con_quien #BH_Estrato_Cinco").val(); if (B_Estrato_Cinco == "") { B_Estrato_Cinco="0"};
		var B_Estrato_Seis = $("#modal_con_quien #BH_Estrato_Seis").val(); if (B_Estrato_Seis == "") { B_Estrato_Seis="0"};
		var beneficiarios = B_Mujeres+","+B_Hombres+","+B_P_Infancia+","+B_Infancia+","+B_Adolescencia+","+B_Juventud+","+B_Adulto+","+B_Adulto_Mayor+","+B_Campesinos+","+B_Artesanos+","+B_Discapacidad+","+B_LGBTI+","+B_Reinsertados+","+B_Victimas+","+B_Dezplazamiento+","+B_Habitantes_Calle+","+B_Medios_Comunitarios+","+B_Pueblo_Raizal+","+B_Afrodescendientes+","+B_Pueblo_Gitano+","+B_Indigenas+","+B_Otras_Etnias+","+B_Estrato_Uno+","+B_Estrato_Dos+","+B_Estrato_Tres+","+B_Estrato_Cuatro+","+B_Estrato_Cinco+","+B_Estrato_Seis;
		var sumatoria_beneficiarios_sexo = parseInt(B_Mujeres)+parseInt(B_Hombres);
		var sumatoria_beneficiarios_ciclo_vital = parseInt(B_P_Infancia)+parseInt(B_Infancia)+parseInt(B_Adolescencia)+parseInt(B_Juventud)+parseInt(B_Adulto)+parseInt(B_Adulto_Mayor);
		var sumatoria_beneficiarios_sector_social = parseInt(B_Campesinos)+parseInt(B_Artesanos)+parseInt(B_Discapacidad)+parseInt(B_LGBTI)+parseInt(B_Reinsertados)+parseInt(B_Victimas)+parseInt(B_Dezplazamiento)+parseInt(B_Habitantes_Calle)+parseInt(B_Medios_Comunitarios);
		var sumatoria_beneficiarios_etnia = parseInt(B_Pueblo_Raizal)+parseInt(B_Afrodescendientes)+parseInt(B_Pueblo_Gitano)+parseInt(B_Indigenas)+parseInt(B_Otras_Etnias);
		var sumatoria_beneficiarios_estrato = parseInt(B_Estrato_Uno)+parseInt(B_Estrato_Dos)+parseInt(B_Estrato_Tres)+parseInt(B_Estrato_Cuatro)+parseInt(B_Estrato_Cinco)+parseInt(B_Estrato_Seis);
		escribir_conquien(beneficiarios, sumatoria_beneficiarios_sexo, sumatoria_beneficiarios_ciclo_vital, sumatoria_beneficiarios_sector_social, sumatoria_beneficiarios_etnia, sumatoria_beneficiarios_estrato);
		$("#modal_con_quien").modal('hide');
	});

$("#modal_folios").find("#capturar_folios").on('click', function(){
	var id = $("#id_celda_folios").val();
	var valores = "";
	var numero_informe = id.split("_");
	var nombre_elemento = "SL_Informe_"+numero_informe[1]+"_"+numero_informe[2];
	var cantidad_informes = 0;
	$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			valores += $("#modal_folios #folios_informe_"+$(selected).val()).val()+";";
		});
	escribir_folios(valores);
	$("#modal_folios").modal('hide');
});


$("#FORM_INFORME_GESTION").on('submit', function(e){
	e.preventDefault();
	var FORMULARIO = $(this).serializeArray();
	var mes = $("#SL_Periodo_Informe option:selected").text();
	var numero_obligaciones = contador_obligaciones-1;
	var numero_obligaciones_asociado = contador_obligaciones_asociado-1;
	var Obligaciones_Especificas = {};
	for(i=1;i<=numero_obligaciones;i++){
		var nombre_elemento = "Obligacion_"+i;
		Obligaciones_Especificas[nombre_elemento] = $("#obligacion_especifica_"+i).val();
	}
	json_Obligaciones_Especificas = JSON.stringify(Obligaciones_Especificas);

	var actividades = {};
	for(i=1;i<=numero_obligaciones;i++){
		var nombre_elemento = "actividades_obligacion_"+i;
		actividades[nombre_elemento] = $("#actividad_obligacion_"+i).val();
	}
	json_actividades = JSON.stringify(actividades);

	var json_detalle = {};
	var detalle_actividades = [];
	var contenido_detalle = "";
	for(i=1;i<=numero_obligaciones;i++){
		var nombre_elemento = "detalle_actividades_obligacion_"+i;
			//var contenido_detalle = "";
			detalle_actividades['actividades'] = $("#actividad_obligacion_"+i).val();
			detalle_actividades['como'] = $("#como_"+i).val();
			detalle_actividades['cuando'] = $("#cuando_"+i).val();
			detalle_actividades['donde'] = $("#donde_"+i).val();
			//detalle_actividades['conquien'] = $("#beneficiarios_"+i).val();
			detalle_actividades['descripcion_conquien'] = $("#descripcion_conquien_"+i).val();
			detalle_actividades['analisis_metas'] = $("#analisis_metas_"+i).val();
			detalle_actividades['analisis_indicadores'] = $("#analisis_indicadores_"+i).val();
			detalle_actividades['analisis_impacto'] = $("#analisis_impacto_"+i).val();
			detalle_actividades['aspectos_a_destacar'] = $("#aspectos_"+i).val();
			detalle_actividades['dificultades'] = $("#dificultades_"+i).val();
			detalle_actividades['otros'] = $("#otros_"+i).val();
			detalle_actividades['anexos'] = $("#anexos_"+i).val();
			json_detalle[nombre_elemento] = {
				actividades: detalle_actividades['actividades'],
				como: detalle_actividades['como'],
				cuando: detalle_actividades['cuando'],
				donde: detalle_actividades['donde'],
				conquien: detalle_actividades['conquien'],
				descripcion_conquien: detalle_actividades['descripcion_conquien'],
				analisis_metas: detalle_actividades['analisis_metas'],
				analisis_indicadores: detalle_actividades['analisis_indicadores'],
				analisis_impacto: detalle_actividades['analisis_impacto'],
				aspectos_a_destacar: detalle_actividades['aspectos_a_destacar'],
				dificultades: detalle_actividades['dificultades'],
				otros: detalle_actividades['otros'],
				anexos: detalle_actividades['anexos']
			};
		}
		json_detalle = JSON.stringify(json_detalle);

		var cifras_recursos = [];
		var json_cifras_recursos = {};
		//Si se va a enviar el ultimo informe del convenio entonces construye los Json de Cifras de Recursos.
		if(bandera_ultimo_informe==1){
			for(i=1;i<=numero_obligaciones;i++){
				var nombre_elemento = "cifras_recursos_obligacion_"+i;
				cifras_recursos['recursos_idartes'] = $("#recursos_idartes_tb1_"+i).val();
				cifras_recursos['recursos_asociado'] = $("#recursos_asociado_tb1_"+i).val();
				cifras_recursos['informes'] = $("#SL_Informe_tb1_"+i).val();
				cifras_recursos['folio'] = $("#folio_tb1_"+i).val();
				json_cifras_recursos[nombre_elemento] = {
					recursos_idartes: cifras_recursos['recursos_idartes'],
					recursos_asociado: cifras_recursos['recursos_asociado'],
					informes: cifras_recursos['informes'],
					folio: cifras_recursos['folio']
				};
			}
			for(i=1;i<=numero_obligaciones_asociado;i++){
				var nombre_elemento = "cifras_recursos_obligacion_asociado_"+i;
				cifras_recursos['descripcion_obligacion_asociado'] = $("#descripcion_obligacion_asociado_"+i).val();
				cifras_recursos['recursos_idartes'] = $("#recursos_idartes_tb2_"+i).val();
				cifras_recursos['recursos_asociado'] = $("#recursos_asociado_tb2_"+i).val();
				cifras_recursos['informes'] = $("#SL_Informe_tb2_"+i).val();
				cifras_recursos['folio'] = $("#folio_tb2_"+i).val();
				json_cifras_recursos[nombre_elemento] = {
					descripcion_obligacion_asociado: cifras_recursos['descripcion_obligacion_asociado'],
					recursos_idartes: cifras_recursos['recursos_idartes'],
					recursos_asociado: cifras_recursos['recursos_asociado'],
					informes: cifras_recursos['informes'],
					folio: cifras_recursos['folio']
				};
			}
			json_cifras_recursos = JSON.stringify(json_cifras_recursos);
		}

		var numeroInforme= $("#SL_Numero_Informe").val()+" de "+$("#SL_Total_Informes").val();
		// var anexos = "";
		// $('#SL_Anexos :selected').each(function(i, selected){
		// 	anexos += $(selected).val()+";";
		// });
		if(jQuery.isEmptyObject(json_cifras_recursos)){
			json_cifras_recursos = "";
		}
		FORMULARIO.push(
		{
			"name":'opcion',
			"value":'guardarInformeGestion'
		},
		{
			"name":'id_usuario',
			"value":session
		},
		{
			"name":'json_Obligaciones_Especificas',
			"value":json_Obligaciones_Especificas
		},
		{
			"name":'json_actividades',
			"value":json_actividades
		},
		{
			"name":'json_detalle',
			"value":json_detalle
		},
		{
			"name":'json_cifras_recursos',
			"value":json_cifras_recursos
		},
		{
			"name":'Numero_Informe',
			"value":numeroInforme
		},
		{
			"name":'bandera_existencia_info_contractual',
			"value":bandera_existencia_info_contractual
		},
		{
			"name":'bandera_ultimo_informe',
			"value":bandera_ultimo_informe
		},
		{
			"name":'mes',
			"value":mes
		},
		{
			"name":'bandera_existencia_seguimiento_propuesta',
			"value":bandera_existencia_seguimiento_propuesta
		}
		);
		// console.log(FORMULARIO);

		$.ajax({
			url: url_controller_fas,
			data: FORMULARIO,
			type: 'POST',
			success: function(){
				parent.swal("","Informe de Gestión Realizado.","success");
				$("#FORM_INFORME_GESTION")[0].reset();
				for(i=1;i<=numero_obligaciones_asociado;i++){
					$("#eliminar_fila_recursos_asociado").click();
				}
				for(i=1;i<=numero_obligaciones;i++){
					$("#eliminar_fila_obligacion").click();
					$("#tab_consulta_formatos").click();
					// consultar_formatos_organizacion(session);
					$("#SL_Convenios_Organizacion").trigger("change");
				}
				cargarEncabezado(session,1,'');
			},
			async : false
		});
	});//FIN SUBMIT FORMULARIO

bandera_ultimo_informe = 0;
$("#SL_Numero_Informe, #SL_Total_Informes").on('change', function(){
	if($("#SL_Numero_Informe").val() == $("#SL_Total_Informes").val())
	{
		alertify.alert("Mensaje","Acaba de indicar que esté es el último informe del Convenio.<br>Se le habilitaron los Numerales 2 y 3 para que los diligencie.");
		$("#div_numeral_dos").show();
		$("#div_numeral_tres").show();
			//Poner o quitar required a los campos.
			$('.required').prop('required', function(){
				return  $(this).is(':visible');
			});
			bandera_ultimo_informe = 1;
		}
		else
		{
			$("#div_numeral_dos").hide();
			$("#div_numeral_tres").hide();
			//Poner o quitar required a los campos.
			$('.required').prop('required', function(){
				return  $(this).is(':visible');
			});
			bandera_ultimo_informe = 0;
		}
	});

$(document).delegate(".observaciones",'click', function() {
	$("#MODAL_OBSERVACION_FAS #modal_titulo_observacion").html("OBSERVACIONES DEL FORMATO");
	$("#P_Observacion_FA").summernote('disable');
	$("#P_Observacion_FA").summernote('code',$(this).data('observaciones'));
});

$(document).delegate( ".abrir_informe", "click", function() {

	if ($(this).data("tipo-informe") == 'INFORME DE GESTIÓN') {
		$("#tab_informe_gestion").click();
		cargarInformeGestion($(this).data("id-informe-gestion"));
	}
});
$(document).delegate( ".descargar_informe", "click", function() {

	if ($(this).data("tipo-informe") == 'INFORME DE GESTIÓN') {
		var pdfData = cargarPDFInformeGestion($(this).data("id-informe-gestion"));
			//pdfMake.createPdf(pdfData).download('informedegestion.pdf');
			//cargarInformeGestion($(this).data("id-informe-gestion"));
		}
	});
$(document).delegate(".estado_formato", "change", function() {
	var estado = "";
	var id_informe_gestion = $(this).data("id-informe-gestion");
	if ($(this).data("tipo-informe") == 'INFORME DE GESTIÓN') {
		if(this.checked){
			estado = "1";
			actualizarEstadoFAS('INFORME DE GESTIÓN',id_informe_gestion,estado, session);
		}
		else{
			estado = "0";
			actualizarEstadoFAS('INFORME DE GESTIÓN',id_informe_gestion,estado, session);
		}
	}
	if ($(this).data("tipo-informe") == 'PROYECCIÓN Y SEGUIMIENTO DEL GASTO') {
		if(this.checked){
			estado = "1";
			actualizarEstadoFAS('PROYECCIÓN Y SEGUIMIENTO DEL GASTO',id_informe_gestion,estado, session);
		}
		else{
			estado = "0";
			actualizarEstadoFAS('PROYECCIÓN Y SEGUIMIENTO DEL GASTO',id_informe_gestion,estado, session);
		}
	}
});

$('.selectpicker').selectpicker();
});

function agregar_fila(){
	//ROWS DE OBLIGACIONES Y ACTIVIDADES.
	var newtr = document.createElement('tr');
	newtr.id = "tr_obligacion_"+contador_obligaciones;
	newtr.innerHTML = "<td style='padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;'><label id='nombre_"+contador_obligaciones+"' name='nombre_"+contador_obligaciones+"'>"+numeros[contador_obligaciones-1]+"</label></td>"+"<td style='padding:0px'><textarea id='obligacion_especifica_"+contador_obligaciones+"' name='obligacion_especifica_"+contador_obligaciones+"' class='form-control' rows=6 placeholder='Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico)' required></textarea></td>"+"<td style='padding:0px'><textarea id='actividad_obligacion_"+contador_obligaciones+"' name='actividad_obligacion_"+contador_obligaciones+"' class='form-control' rows=6 placeholder='Actividades que realizó para cumplir la obligación Específica.'></textarea></td>";
	document.getElementById('contenedor_obligaciones_especificas').appendChild(newtr);

	//ROWS DE DETALLE DE ACTIVIDADES.
	var newrow = document.createElement('tr');
	newrow.id = "tr_titulo_"+contador_obligaciones;
	newrow.innerHTML = "<td style='padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;'><label id='nombreobj_"+contador_obligaciones+"'>Detalle de Actividades de Obligación Específica "+contador_obligaciones+" <i class='fas fa-stream btn btn-success leer_obligacion' style='color:white' data-toggle='tooltip' title='Leer Obligación'></i></label></td>";
	document.getElementById('contenedor_detalle').appendChild(newrow);
	//COMO? CUANDO? DONDE?
	var newrow = document.createElement('tr');
	newrow.setAttribute('class', 'col-md-12');
	newrow.id = "tr_como_cuando_donde_"+contador_obligaciones;
	newrow.innerHTML = "<td class='col-md-4' style='padding: 0px; float: inherit;'><label>COMO?</label><textarea id='como_"+contador_obligaciones+"' name='como_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>"+"<td class='col-md-4' style='padding: 0px; float: inherit;'><label>CUANDO?</label><textarea id='cuando_"+contador_obligaciones+"' name='cuando_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>"+"<td class='col-md-4' style='padding: 0px; float: inherit;'><label>DONDE?</label><textarea id='donde_"+contador_obligaciones+"' name='donde_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>";
	document.getElementById('contenedor_detalle').appendChild(newrow);
	//CON QUIEN? ANALISIS METAS PROPUESTAS //ANALISIS INDICADORES
	var newrow = document.createElement('tr');
	newrow.setAttribute('class', 'col-md-12');
	newrow.id = "tr_conquien_metas_indicadores_"+contador_obligaciones;
	newrow.innerHTML = "<td class='col-md-4' style='padding: 0px; float: inherit;'><div id='div_conquien_"+contador_obligaciones+"'><label>CON QUIEN?</label><textarea id='descripcion_conquien_"+contador_obligaciones+"' name='descripcion_conquien_"+contador_obligaciones+"' class='form-control' rows='3' placeholder='Descripción de la población beneficiada - Describir la metodología para el conteo de asistentes.'></textarea></div></td>"+"<td class='col-md-4' style='padding: 0px; float: inherit;'><label>ANALISIS DE METAS</label><textarea id='analisis_metas_"+contador_obligaciones+"' name='analisis_metas_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>"+"<td class='col-md-4' style='padding: 0px; float: inherit;'><label>ANALISIS DE INDICADORES</label><textarea id='analisis_indicadores_"+contador_obligaciones+"' name='analisis_indicadores_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>";
	document.getElementById('contenedor_detalle').appendChild(newrow);
	//ANALISIS DE IMPACTO //ASPECTOS A DESTACAR //DIFICULTADES
	var newrow = document.createElement('tr');
	newrow.setAttribute('class', 'col-md-12');
	newrow.id = "tr_impacto_aspectos_dificultades_"+contador_obligaciones;
	newrow.innerHTML = "<td class='col-md-4' style='padding: 0px; float: inherit;'><label>ANALISIS DE IMPACTO</label><textarea id='analisis_impacto_"+contador_obligaciones+"' name='analisis_impacto_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>"+"<td class='col-md-4' style='padding: 0px; float: inherit;'><label>ASPECTOS A DESTACAR</label><textarea id='aspectos_"+contador_obligaciones+"' name='aspectos_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>"+"<td class='col-md-4' style='padding: 0px; float: inherit;'><label>DIFICULTADES</label><textarea id='dificultades_"+contador_obligaciones+"' name='dificultades_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>";
	document.getElementById('contenedor_detalle').appendChild(newrow);
	//OTROS //ANEXOS
	var newrow = document.createElement('tr');
	newrow.setAttribute('class', 'col-md-12');
	newrow.id = "tr_otros_anexos_"+contador_obligaciones;
	newrow.innerHTML = "<td class='col-md-6' style='padding: 0px; float: inherit;'><label>OTROS</label><textarea id='otros_"+contador_obligaciones+"' name='otros_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>"+"<td class='col-md-6' style='padding: 0px; float: inherit;'><label>ANEXOS DE ESTA OBLIGACION </label><textarea id='anexos_"+contador_obligaciones+"' name='anexos_"+contador_obligaciones+"' class='form-control' rows='3'></textarea></td>";
	document.getElementById('contenedor_detalle').appendChild(newrow);

	$('.estado_check').bootstrapToggle();
	$(".estado_check").on('change', function(){
		if(this.checked){
			$("#div_conquien_"+$(this).data("id")).show();
			$("#conquien_"+$(this).data("id")).prop('required', true);
			$("#descripcion_conquien_"+$(this).data("id")).prop('required', true);
		}
		else{
			$("#conquien_"+$(this).data("id")).prop('required', false);
			$("#conquien_"+$(this).data("id")).val("");
			$("#beneficiarios_"+$(this).data("id")).val("");
			$("#descripcion_conquien_"+$(this).data("id")).prop('required', false);
			$("#descripcion_conquien_"+$(this).data("id")).val("");
			$("#div_conquien_"+$(this).data("id")).hide();
		}
	});
	$(".conquien").on('click', function(){
		abrirmodal(this.id);
	});
	
	$('[data-toggle="tooltip"]').tooltip();

	$(".leer_obligacion").on('click', function(){
		var id_obligacion = $(this).parent().attr('id').split("_");
		id_obligacion = id_obligacion[1];
		parent.swal("Obligación Específica "+id_obligacion,$("#obligacion_especifica_"+id_obligacion).val(),"");
	});
}

function eliminar_fila(){
	if (contador_obligaciones>2) {
		contador_obligaciones--;
		$('#tr_obligacion_'+contador_obligaciones).remove();
		$('#tr_titulo_'+contador_obligaciones).remove();
		$('#tr_como_cuando_donde_'+contador_obligaciones).remove();
		$('#tr_conquien_metas_indicadores_'+contador_obligaciones).remove();
		$('#tr_impacto_aspectos_dificultades_'+contador_obligaciones).remove();
		$('#tr_otros_anexos_'+contador_obligaciones).remove();
	}
}

function agregar_fila_recursos_idartes(){
	var newtr = document.createElement('tr');
	newtr.id = "tr_obligaciones_recursos_idartes_"+contador_obligaciones;
	newtr.innerHTML = "<td style='padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;'><label id='nombre_"+contador_obligaciones+"'>"+contador_obligaciones+"</label></td><td style='padding: 0px;'><input type='text' id='recursos_idartes_tb1_"+contador_obligaciones+"' name='recursos_idartes_tb1_"+contador_obligaciones+"' class='form-control required' placeholder='0' oninput='onlynumber(this.id)' required></td><td style='padding: 0px;'><input id='recursos_asociado_tb1_"+contador_obligaciones+"' name='recursos_asociado_tb1_"+contador_obligaciones+"' class='form-control required' placeholder='0' oninput='onlynumber(this.id)' required></textarea></td><td style='padding: 0px;'><select id='SL_Informe_tb1_"+contador_obligaciones+"' name='SL_Informe_tb1_"+contador_obligaciones+"' class='form-control selectpicker required' multiple required><option value='1'>Informe 1</option><option value='2'>Informe 2</option><option value='3'>Informe 3</option><option value='4'>Informe 4</option><option value='5'>Informe 5</option><option value='6'>Informe 6</option><option value='7'>Informe 7</option><option value='8'>Informe 8</option><option value='9'>Informe 9</option><option value='10'>Informe 10</option><option value='11'>Informe 11</option><option value='12'>Informe 12</option><option value='13'>Informe 13</option><option value='14'>Informe 14</option><option value='15'>Informe 15</option><option value='16'>Informe 16</option></select></td><td style='padding: 0px;'><input type='text' id='folio_tb1_"+contador_obligaciones+"' name='folio_tb1_"+contador_obligaciones+"' class='form-control folios_tb1 required' required></textarea></td>";
	document.getElementById('contenedor_obligaciones_idartes').appendChild(newtr);
	$(".selectpicker").selectpicker('refresh');
	$(".folios_tb1").on('click', function(){
		var id = this.id;
		var values = "";
		var numero_informe = id.split("_");
		var nombre_elemento = "SL_Informe_"+numero_informe[1]+"_"+numero_informe[2];
		var cantidad_informes = 0;
		$("#modal_folios #modal_body").html('');
		$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			//values += $(selected).val()+";";
			$("#modal_folios #modal_body").append("<div id='div_folios_informe_tb1_"+$(selected).val()+"' class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'><p style='text-align:right'>Folio Informe "+$(selected).val()+":</p></div><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><input id='folios_informe_"+$(selected).val()+"' name='folios_informe_"+$(selected).val()+"' type='number' class='form-control' min='0' value='0'></div></div>");
		});
		//alert(cantidad_informes);
		$("#modal_folios").modal('show');
		abrirmodalfoliosidartes(this.id);

	});
	$('.required').prop('required', function(){
		return  $(this).is(':visible');
	});
	contador_obligaciones++;

}

function agregar_fila_recursos_asociado(){
	var newtr = document.createElement('tr');
	newtr.id = "tr_obligaciones_recursos_asociado_"+contador_obligaciones_asociado;
	newtr.innerHTML = "<td style='padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;'><textarea id='descripcion_obligacion_asociado_"+contador_obligaciones_asociado+"' name='descripcion_obligacion_asociado_"+contador_obligaciones_asociado+"' class='form-control' rows='1'></textarea></td><td style='padding: 0px;'><input type='text' id='recursos_idartes_tb2_"+contador_obligaciones_asociado+"' name='recursos_idartes_tb2_"+contador_obligaciones_asociado+"' class='form-control required' placeholder='0' oninput='onlynumber(this.id)' required></td><td style='padding: 0px;'><input id='recursos_asociado_tb2_"+contador_obligaciones_asociado+"' name='recursos_asociado_tb2_"+contador_obligaciones_asociado+"' class='form-control required' placeholder='0' oninput='onlynumber(this.id)' required></textarea></td><td style='padding: 0px;'><select id='SL_Informe_tb2_"+contador_obligaciones_asociado+"' name='SL_Informe_tb2_"+contador_obligaciones_asociado+"' class='form-control selectpicker required' multiple required><option value='1'>Informe 1</option><option value='2'>Informe 2</option><option value='3'>Informe 3</option><option value='4'>Informe 4</option><option value='5'>Informe 5</option><option value='6'>Informe 6</option><option value='7'>Informe 7</option><option value='8'>Informe 8</option><option value='9'>Informe 9</option><option value='10'>Informe 10</option><option value='11'>Informe 11</option><option value='12'>Informe 12</option><option value='13'>Informe 13</option><option value='14'>Informe 14</option><option value='15'>Informe 15</option><option value='16'>Informe 16</option></select></td><td style='padding: 0px;'><input type='text' id='folio_tb2_"+contador_obligaciones_asociado+"' name='folio_tb2_"+contador_obligaciones_asociado+"' class='form-control folios_tb2 required' required></textarea></td>";
	document.getElementById('contenedor_obligaciones_asociado').appendChild(newtr);
	$(".selectpicker").selectpicker('refresh');
	$(".folios_tb2").on('click', function(){
		var id = this.id;
		var values = "";
		var numero_informe = id.split("_");
		var nombre_elemento = "SL_Informe_"+numero_informe[1]+"_"+numero_informe[2];
		var cantidad_informes = 0;
		$("#modal_folios #modal_body").html('');
		$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			//values += $(selected).val()+";";
			$("#modal_folios #modal_body").append("<div id='div_folios_informe_tb2_"+$(selected).val()+"' class='col-xs-12 col-sm-12 col-md-12 col-lg-12'><div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'><p style='text-align:right'>Folio Informe "+$(selected).val()+":</p></div><div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><input id='folios_informe_"+$(selected).val()+"' name='folios_informe_"+$(selected).val()+"' type='number' class='form-control' min='0' value='0'></div></div>");
		});
		//alert(cantidad_informes);
		$("#modal_folios").modal('show');
		abrirmodalfoliosasociado(this.id);
	});
	contador_obligaciones_asociado++;
}

//Esta funcion no se ejecuta con esa condicion de contador_obligaciones>2 ya que no se hace el contador_obligaciones-- porque estos deben ser exactamente los mismos de las obligaciones de arriba.
function eliminar_fila_recursos_idartes(){
	if (contador_obligaciones>1) {
		$('#tr_obligaciones_recursos_idartes_'+contador_obligaciones).remove();
	}
}

function eliminar_fila_recursos_asociado(){
	if (contador_obligaciones_asociado>2) {
		contador_obligaciones_asociado--;
		$('#tr_obligaciones_recursos_asociado_'+contador_obligaciones_asociado).remove();
	}
}

function onlynumber(id){
	document.getElementById(id).value = document.getElementById(id).value.replace(/[^0-9.]/g, '');
	document.getElementById(id).value = document.getElementById(id).value.replace(/(\.*)\./g, '$1');
}

function cargarInformeGestion(id_informe_gestion){
	$("#FORM_INFORME_GESTION")[0].reset();

	var datos = {
		'opcion': 'getInformeGestion',
		'id_informe_gestion': id_informe_gestion //Aquí se envía el ID del informe que se quiere consultar.
	};

	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (informe_gestion) {
			datos_informe = JSON.parse(informe_gestion);
			if (informe_gestion != 'null') {
				cargarEncabezado(datos_informe.FK_Id_Organizacion,1, id_informe_gestion);
				$("#div_agregar_eliminar").hide();
				var numero_rows = Object.keys(JSON.parse(datos_informe.TX_Detalle_Actividades)).length;
				var detalle_actividades = JSON.parse(datos_informe.TX_Detalle_Actividades);
				// var nombre_item = "";
				var numero_informe = datos_informe.VC_Informe.split(" ");
				$('#SL_Numero_Informe').val('');
				$("#SL_Numero_Informe option[value='" + numero_informe[0]+ "']").prop('selected', true);
				$("#SL_Total_Informes option[value='" + numero_informe[2]+ "']").prop('selected', true);
				//Si los numeros de informes son los mismos deben cargarse los puntos 2 y 3.
				if($("#SL_Numero_Informe").val() == $("#SL_Total_Informes").val())
				{
					bandera_ultimo_informe = 1;
					$("#div_numeral_dos").show();
					$("#div_numeral_tres").show();
					setTimeout(function(){ 
						$('.required').prop('required', function(){
							return  $(this).is(':visible');
						});
					}, 500);
				}
				else
				{
					$("#div_numeral_dos").hide();
					$("#div_numeral_tres").hide();
					setTimeout(function(){ 
						$('.required').prop('required', function(){
							return  $(this).is(':visible');
						}); 
					}, 500);
				}
				$("#SL_Periodo_Informe option").filter(function() { return $(this).text() == datos_informe.VC_Periodo }).prop('selected', true);
				$("#SL_Periodo_Informe").selectpicker("refresh");
				$("#SL_Anio_Informe").val(datos_informe.IN_Anio).selectpicker("refresh");
				$("#TX_Correo").val(datos_informe.VC_Correo);

				for(i=1;i<=numero_rows;i++){
					if(session_type!=11){
						if(i<=numero_rows && contador_obligaciones <= numero_rows){
							agregar_fila();
							agregar_fila_recursos_idartes();
						}
					}
					nombre_item = "#actividad_obligacion_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].actividades);
					nombre_item = "#como_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].como);
					nombre_item = "#cuando_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].cuando);
					nombre_item = "#donde_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].donde);
					nombre_item = "#conquien_"+i;
					// if(detalle_actividades["detalle_actividades_obligacion_"+i].conquien!=""){
					// 	$("#check_conquien_"+i).bootstrapToggle('on');
					// 	var array_conquien = detalle_actividades["detalle_actividades_obligacion_"+i].conquien.split(",");
					// 	var suma_sexo = parseInt(array_conquien[0])+parseInt(array_conquien[1]);
					// 	var suma_ciclo= parseInt(array_conquien[2])+parseInt(array_conquien[3])+parseInt(array_conquien[4])+parseInt(array_conquien[5])+parseInt(array_conquien[6])+parseInt(array_conquien[7]);
					// 	var suma_sector_social=parseInt(array_conquien[8])+parseInt(array_conquien[9])+parseInt(array_conquien[10])+parseInt(array_conquien[11])+parseInt(array_conquien[12])+parseInt(array_conquien[13])+parseInt(array_conquien[14])+parseInt(array_conquien[15])+parseInt(array_conquien[16]);
					// 	var suma_etnia= parseInt(array_conquien[17])+parseInt(array_conquien[18])+parseInt(array_conquien[19])+parseInt(array_conquien[20])+parseInt(array_conquien[21]);
					// 	var suma_estrato= parseInt(array_conquien[22])+parseInt(array_conquien[23])+parseInt(array_conquien[24])+parseInt(array_conquien[25])+parseInt(array_conquien[26])+parseInt(array_conquien[27]);
					// 	nombre_item = "#conquien_"+i;
					// 	$(nombre_item).val("Sexo:"+suma_sexo+', Ciclo Vital:'+suma_ciclo+', Sector Social:'+suma_sector_social+', Etnia:'+suma_etnia+', Estrato:'+suma_estrato);
					// 	nombre_item = "#beneficiarios_"+i;
					// 	$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].conquien);
					// 	nombre_item = "#descripcion_conquien_"+i;
					// 	$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].descripcion_conquien);
					// }
					nombre_item = "#descripcion_conquien_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].descripcion_conquien);

					nombre_item = "#analisis_metas_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].analisis_metas);
					nombre_item = "#analisis_indicadores_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].analisis_indicadores);
					nombre_item = "#analisis_impacto_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].analisis_impacto);
					nombre_item = "#aspectos_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].aspectos_a_destacar);
					nombre_item = "#dificultades_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].dificultades);
					nombre_item = "#otros_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].otros);
					nombre_item = "#anexos_"+i;
					$(nombre_item).val(detalle_actividades["detalle_actividades_obligacion_"+i].anexos);
				}
				// var anexos = datos_informe.VC_Anexos.split(";");
				// numero_anexos = anexos.length;
				// $.each(anexos, function (i) {
				// 	if (anexos[i] != '') {
				// 		$("#SL_Anexos option[value='" + anexos[i]+ "']").prop('selected', true);
				// 	}
				// 	//$('#SL_Anexos').prop('disabled', 'disabled');
				// 	$("#TX_OTROS_ANEXOS").val(anexos[numero_anexos-1]);
				// 	$('#SL_Anexos').selectpicker('refresh');
				// });
			}
			else{
        		//$("#div_agregar_eliminar").show();
        		//bandera_existencia_info_contractual = 0;
        	}
        },
        async : false
    });
$('.required').prop('required', function(){
	return  $(this).is(':visible');
});
}

//Consulta la informacion del PDF que se generará
function cargarPDFInformeGestion(id_informe_gestion){
	var datos = {
		'opcion': 'getInformeGestion',
		'id_informe_gestion': id_informe_gestion //Aquí se envía el ID del informe que se quiere consultar.
	};
	var datosPDF = "";
	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (informe_gestion) {
			datos_informe = JSON.parse(informe_gestion);
			if (informe_gestion != 'null') {
				var numero_rows = Object.keys(JSON.parse(datos_informe.TX_Detalle_Actividades)).length;
				var detalle_actividades = JSON.parse(datos_informe.TX_Detalle_Actividades);
				var numero_informe = datos_informe.VC_Informe.split(" ");
				var periodo = datos_informe.VC_Periodo;
				var año = datos_informe.IN_Anio;
				var correo = datos_informe.VC_Correo;
			}
			datosPDF = generarPDFInformeGestion(datos_informe.FK_Id_Organizacion, id_informe_gestion);
		},
		async : false
	});
	return datosPDF;
}

function cargarEncabezado(organizacion, bandera, id_informe_gestion){
	var datos = {
		'opcion': 'getInfoContractual',
		'id_organizacion': organizacion,
		'id_informe_gestion': id_informe_gestion //Aquí se envía el ID del informe de gestión que se quiere consultar.
	};

	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (data) {
			encabezado = JSON.parse(data);
			if ( JSON.parse(data) != null && encabezado.TX_Obligaciones_Idartes != null){
				$("#div_agregar_eliminar").hide();
				var numero_obligaciones = Object.keys(JSON.parse(encabezado.TX_Obligaciones_Idartes)).length;
				var datos_cifras = "";
				var numero_obligaciones_asociado = "";
				if(encabezado.TX_Cifras_Recursos != ""){
					numero_obligaciones_asociado = Object.keys(JSON.parse(encabezado.TX_Cifras_Recursos)).length;
					datos_cifras = JSON.parse(encabezado.TX_Cifras_Recursos);
				}
				//Al vector de obligaciones_asociado le restamos el de obligaciones, asi conocemos cuantas son las obligaciones con cargo al asociado.
				bandera_existencia_seguimiento_propuesta = encabezado.id_seguimiento_propuesta;
				bandera_existencia_info_contractual = encabezado.id_info_contractual;
				numero_obligaciones_asociado = numero_obligaciones_asociado - numero_obligaciones;
				var obligaciones_especificas = JSON.parse(encabezado.TX_Obligaciones_Idartes);
				var nombre_item = "";
				 //Se almacena el PK_Id_Tabla que retorna la funcion, si se envía un id_informe_gestion el PK_Id_Tabla es el de tb_organizacion_info_contractual (para registrar el informe de gestion), sino entonces es de tb_organizacion_seguimiento_propuesta (para registrar la info contractual).
				//Id_Seguimiento_Propuesta = encabezado.Id_Seguimiento_Propuesta;
				$("#TXTA_NOMBRE_PROYECTO").val(encabezado.TX_Nombre_Proyecto);
				$("#TXTA_NOMBRE_PROYECTO").prop("readonly", true);
				$("#TX_Nombre_Representante").val(encabezado.VC_Representante_Legal);
				$("#TX_Nombre_Representante").prop("readonly", true);
				$("#TXTA_OBJETO_CONTRATO").val(encabezado.TX_Objeto_Contrato);
				$("#TXTA_OBJETO_CONTRATO").prop("readonly", true);
				//Limpia la vista para volver a cargar el encabezado y las obligaciones.
				for(k=1;k<=30;k++){eliminar_fila();eliminar_fila_recursos_idartes();}
					for(i=1;i<=numero_obligaciones;i++){
						if (bandera == 1){
							if(i<numero_obligaciones){
								agregar_fila();
								agregar_fila_recursos_idartes();
							}
						}
						if(datos_cifras!=""){
							nombre_item = "#TXTA_Actividades_Realizadas";
							$(nombre_item).val(encabezado.TX_Actividades_Realizadas);
							nombre_item = "#TX_Artistas_Beneficiados";
							$(nombre_item).val(encabezado.IN_Artistas_Beneficiados);
							nombre_item = "#TX_Difusion";
							$(nombre_item).val(encabezado.TX_Difusion);
							nombre_item = "#TXTA_Poblacion_Beneficiada";
						//Calcula los totales por categoria. (Sexo, Ciclo Vital, Sector Social, Etnia, Estrato)
						// var vector_poblacion = encabezado.TX_Poblacion_Beneficiada.split(",");
						// var sumatoria_beneficiarios_sexo = parseInt(vector_poblacion[0])+parseInt(vector_poblacion[1]);
						// var sumatoria_beneficiarios_ciclo_vital= parseInt(vector_poblacion[2])+parseInt(vector_poblacion[3])+parseInt(vector_poblacion[4])+parseInt(vector_poblacion[5])+parseInt(vector_poblacion[6])+parseInt(vector_poblacion[7]);
						// var sumatoria_beneficiarios_sector_social = parseInt(vector_poblacion[8])+parseInt(vector_poblacion[9])+parseInt(vector_poblacion[10])+parseInt(vector_poblacion[11])+parseInt(vector_poblacion[12])+parseInt(vector_poblacion[13])+parseInt(vector_poblacion[14])+parseInt(vector_poblacion[15])+parseInt(vector_poblacion[16]);
						// var sumatoria_beneficiarios_etnia = parseInt(vector_poblacion[17])+parseInt(vector_poblacion[18])+parseInt(vector_poblacion[19])+parseInt(vector_poblacion[20])+parseInt(vector_poblacion[21]);
						// var sumatoria_beneficiarios_estrato = parseInt(vector_poblacion[22])+parseInt(vector_poblacion[23])+parseInt(vector_poblacion[24])+parseInt(vector_poblacion[25])+parseInt(vector_poblacion[26])+parseInt(vector_poblacion[27]);
						// $(nombre_item).val("Sexo:"+sumatoria_beneficiarios_sexo+','+" Ciclo Vital:"+sumatoria_beneficiarios_ciclo_vital+','+" Sector Social:"+sumatoria_beneficiarios_sector_social+','+" Etnia:"+sumatoria_beneficiarios_etnia+','+" Estrato:"+sumatoria_beneficiarios_estrato);
						$(nombre_item).val(encabezado.TX_Poblacion_Beneficiada);
						// nombre_item = "#beneficiarios_Poblacion";
						// $(nombre_item).val(encabezado.TX_Poblacion_Beneficiada);
						//Llena la tabla de obligaciones con cargo al idartes.
						nombre_item = "#recursos_idartes_tb1_"+i;
						$(nombre_item).val(datos_cifras["cifras_recursos_obligacion_"+i].recursos_idartes);
						nombre_item = "#recursos_asociado_tb1_"+i;
						$(nombre_item).val(datos_cifras["cifras_recursos_obligacion_"+i].recursos_asociado);
						var informes = datos_cifras["cifras_recursos_obligacion_"+i].informes;
						for (index = 0; index <= informes.length; ++index) {
							$("#SL_Informe_tb1_"+i+" option[value='" + informes[index]+ "']").prop('selected', true);
							$(".selectpicker").selectpicker('refresh');
						}
						nombre_item = "#folio_tb1_"+i;
						$(nombre_item).val(datos_cifras["cifras_recursos_obligacion_"+i].folio);
						$(nombre_item).prop("readonly", true);
					}
					else{
						$(".selectpicker").selectpicker('refresh');
					}
					nombre_item = "#obligacion_especifica_"+i;
					$(nombre_item).val(obligaciones_especificas["Obligacion_"+i]);
					$(nombre_item).prop("readonly", true);
				}
				for(k=1;k<=30;k++){eliminar_fila_recursos_asociado();}
					for(j=1;j<=numero_obligaciones_asociado;j++){
						if (bandera == 1){
							if(j<numero_obligaciones_asociado){
								agregar_fila_recursos_asociado();
							}
						}
						if(datos_cifras!=""){
						//llena la tabla de obligaciones con cargo al asociado.
						nombre_item = "#descripcion_obligacion_asociado_"+j;
						$(nombre_item).val(datos_cifras["cifras_recursos_obligacion_asociado_"+j].descripcion_obligacion_asociado);
						nombre_item = "#recursos_idartes_tb2_"+j;
						$(nombre_item).val(datos_cifras["cifras_recursos_obligacion_asociado_"+j].recursos_idartes);
						nombre_item = "#recursos_asociado_tb2_"+j;
						$(nombre_item).val(datos_cifras["cifras_recursos_obligacion_asociado_"+j].recursos_asociado);
						var informes = datos_cifras["cifras_recursos_obligacion_asociado_"+j].informes;
						for (index = 0; index <= informes.length; ++index) {
							$("#SL_Informe_tb2_"+j+" option[value='" + informes[index]+ "']").prop('selected', true);
							$(".selectpicker").selectpicker('refresh');
						}
						nombre_item = "#folio_tb2_"+j;
						$(nombre_item).val(datos_cifras["cifras_recursos_obligacion_asociado_"+j].folio);
						$(nombre_item).prop("readonly", true);
					}
				}
			}
			else{
				$("#div_agregar_eliminar").show();
				bandera_existencia_info_contractual = 0;
			}
		},
		async : false
	});//FIN AJAX GET ENCABEZADOS.
}

function cargarPDFEncabezado(organizacion){
	var datos = {
		'opcion': 'getInfoContractual',
		'id_organizacion': organizacion,
		'id_informe_gestion': '2017'
	};

	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (data) {
			encabezado = JSON.parse(data);
			if ( JSON.parse(data) != null) {
				$("#div_agregar_eliminar").hide();
				var numero_obligaciones = Object.keys(JSON.parse(encabezado.TX_Obligaciones_Idartes)).length;
				var datos_cifras = "";
				var numero_obligaciones_asociado = "";
				if(encabezado.TX_Cifras_Recursos != ""){
					numero_obligaciones_asociado = Object.keys(JSON.parse(encabezado.TX_Cifras_Recursos)).length;
					datos_cifras = JSON.parse(encabezado.TX_Cifras_Recursos);
				}
				//Al vector de obligaciones_asociado le restamos el de obligaciones, asi conocemos cuantas son las obligaciones con cargo al asociado.
				numero_obligaciones_asociado = numero_obligaciones_asociado - numero_obligaciones;
				var obligaciones_especificas = JSON.parse(encabezado.TX_Obligaciones_Idartes);
				var nombre_proyecto = encabezado.TX_Nombre_Proyecto;
				var representante_legal = encabezado.VC_Representante_Legal;
				var objeto_contrato = encabezado.TX_Objeto_Contrato;
			}
		},
		async : false
	});//FIN AJAX GET ENCABEZADOS.
}

function generarPDFInformeGestion(organizacion, id_informe_gestion) {
	var datos = {
		'opcion': 'getInfoContractual',
		'id_organizacion': organizacion,
		'id_informe_gestion': id_informe_gestion
	};

	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (datos) {
			infocontractual = JSON.parse(datos);
		},
		async : false
	});

	var datos = {
		'opcion': 'getInformeGestion',
		'id_informe_gestion': id_informe_gestion //Aquí se envía el ID del informe que se quiere consultar.
	};

	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (datos) {
			informegestion = JSON.parse(datos);
			console.log(informegestion);
		},
		async : false
	});

	construirPDFInformeGestion(infocontractual, informegestion);
}
function construirPDFInformeGestion(infocontractual, informegestion) {
	var imageAlcaldia;
	var imageClan;
	var estado;
	if(infocontractual!=null){
	}
	else{
		alertify.alert("No es posible generar este PDF, es necesario que la Organización haya diligenciado el Seguimiento a la Propuesta al menos una vez, ya que este PDF incluye información que se extrae de allí.");
	}
	if (informegestion.IN_Aprobacion=='' || informegestion.IN_Aprobacion===null) {
		estado = "Sin Revisar";
	}
	else{
		if (informegestion.IN_Aprobacion=='1') {
			estado = 'Aprobado';
		}
		else
		{
			estado = 'No Aprobado';
		}
	}

	if(infocontractual.VC_Areas != null){
		var areas_artisticas = infocontractual.VC_Areas.split(";");
		var vector_areas_artisticas = "";
		for(i=0;i<(areas_artisticas.length)-1;i++){
			switch(areas_artisticas[i]){
				case "1":
				vector_areas_artisticas+="(DANZA) ";
				break;
				case "2":
				vector_areas_artisticas+="(MÚSICA) ";
				break;
				case "3":
				vector_areas_artisticas+="(ARTES PLÁSTICAS) ";
				break;
				case "4":
				vector_areas_artisticas+="(LITERATURA) ";
				break;
				case "5":
				vector_areas_artisticas+="(TEATRO) ";
				break;
				case "6":
				vector_areas_artisticas+="(AUDIOVISUALES) ";
				break;
				default:
				vector_areas_artisticas+="----";
			}
		}	
	}
	else{
		parent.swal("","Las ÁREAS ARTÍSTICAS de este convenio no han sido diligenciadas en el formato SEGUIMIENTO A LA PROPUESTA, El informe saldrá con el texto AREAS 'SIN ESPECIFICAR'","warning");
		var vector_areas_artisticas = "SIN ESPECIFICAR";
	}
	
	obligaciones_idartes = [];
	detalle_actividades_obligacion = [];
	var numero_rows = Object.keys(JSON.parse(infocontractual.TX_Obligaciones_Idartes)).length;
	for(i=1;i<=numero_rows;i++){
		var Obligaciones_Idartes = JSON.parse(infocontractual.TX_Obligaciones_Idartes);
		var Detalle_Actividades = JSON.parse(informegestion.TX_Detalle_Actividades);
		// var poblacion_actividad = Detalle_Actividades["detalle_actividades_obligacion_"+i].conquien.split(",");
		var poblacion_actividad = Detalle_Actividades["detalle_actividades_obligacion_"+i].descripcion_conquien;
		// var poblacion_reportada = "";
		// var vector_nombres_beneficiarios = ["Mujeres","Hombres","Primera infancia (0-5 años)","Infancia (6–11 años)","Adolescencia (12–13 años)","Juventud (14–26 años)","Adulto (27–59 años)","Adulto Mayor (60 años +)","Campesinos","Artesanos","Personas con discapacidad","LGBTI","Reinsertados","Víctimas","Desplazados","Habitantes de calle","Medios comunitarios","Pueblo Raizal","Afrodescendientes","Rrom - gitano","Indígenas","Otras etnias","Estrato 1","Estrato 2","Estrato 3","Estrato 4","Estrato 5","Estrato 6"];

		// for(j=0;j<=27;j++){
		// 	if(poblacion_actividad[j]!="0"){
		// 		poblacion_reportada += vector_nombres_beneficiarios[j]+":"+poblacion_actividad[j]+"\n";
		// 	}
		// }
		obligaciones_idartes.push(
		{
			style: 'tableExample',
			table: {
				widths: ['25%','25%','15%','*'],
				body: [
				[{
					text:[{text: i+'. '+Obligaciones_Idartes["Obligacion_"+i]}],
					style: 'bgcolor',
					rowSpan:11
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].actividades,alignment:'justify'}],
					rowSpan:11
				},{
					text:[{text: 'COMO',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].como,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'CUANDO',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].cuando,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'DONDE',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].donde,alignment:'justify'}],
				}],
				[{},{},{
					text:[{text: 'DESCRIPCION CONQUIEN',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].descripcion_conquien,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'ANALISIS METAS',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].analisis_metas,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'ANALISIS INDICADORES',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].analisis_indicadores,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'ANALISIS IMPACTO',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].analisis_impacto,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'ASPECTOS A DESTACAR',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].aspectos_a_destacar,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'DIFICULTADES',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].dificultades,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'OTROS',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].otros,alignment:'justify'}],
				}],[{},{},{
					text:[{text: 'ANEXOS',alignment:'justify'}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].anexos,alignment:'justify'}],
				}],
				]
			}
		}
		);
	}
	var datos_cifras = "";
	var obligaciones_recursos = "";
	var poblacion_actividad_informe_final = infocontractual.TX_Poblacion_Beneficiada;
	// var poblacion_actividad_informe_final = infocontractual.TX_Poblacion_Beneficiada.split(",");
	// var poblacion_reportada_informe_final = "";
	// var vector_nombres_beneficiarios_informe_final = ["Mujeres","Hombres","Primera infancia (0-5 años)","Infancia (6–11 años)","Adolescencia (12–13 años)","Juventud (14–26 años)","Adulto (27–59 años)","Adulto Mayor (60 años +)","Campesinos","Artesanos","Personas con discapacidad","LGBTI","Reinsertados","Víctimas","Desplazados","Habitantes de calle","Medios comunitarios","Pueblo Raizal","Afrodescendientes","Rrom - gitano","Indígenas","Otras etnias","Estrato 1","Estrato 2","Estrato 3","Estrato 4","Estrato 5","Estrato 6"];
	// for(j=0;j<=27;j++){
	// 	if(poblacion_actividad_informe_final[j]!="0"){
	// 		poblacion_reportada_informe_final += vector_nombres_beneficiarios_informe_final[j]+":"+poblacion_actividad_informe_final[j]+"\n";
	// 	}
	// }
	var periodo = informegestion.VC_Informe.split(" ");

	if(infocontractual.TX_Actividades_Realizadas!="" && (periodo[0]==periodo[2])){
		datos_cifras = {
			style: 'tableExample',
			table: {
				widths: ['25%','*'],
				body: [
				[{
					text:{text: 'ITEM',style: 'tableHeader'},
				},{
					text:{text: 'CANTIDAD TOTAL *Al finalizar el proyecto*',style: 'tableHeader'},
				}
				],
				[{
					text:{text: 'Actividades Realizadas'},
				},{
					text:{text: infocontractual.TX_Actividades_Realizadas},
				}
				],
				[{
					text:{text: 'Población Beneficiada'},
				},{
					text:{text: poblacion_actividad_informe_final},
				}
				],
				[{
					text:{text: 'Artistas Beneficiados'},
				},{
					text:{text: infocontractual.IN_Artistas_Beneficiados},
				}
				],
				[{
					text:{text: 'PÁGINAS WEB Y/O LINKS EN LOS QUE SE REALIZÓ DIFUSIÓN AL PROYECTO', style:'tableHeaderCenter'},
					colSpan:2
				},{
				}
				],[{
					text:{text: infocontractual.TX_Difusion},
					colSpan:2
				},{
				}
				]
				]
			},
		};

		obligaciones_recursos = [];
		var numero_obligaciones_idartes = Object.keys(JSON.parse(infocontractual.TX_Obligaciones_Idartes)).length;
		//Esta varaible almacena la cantidad total de los recursos que se ingresaron tanto para Obligaciones con cargo al Idartes, como para el Asociado.
		var numero_obligaciones_recursos = Object.keys(JSON.parse(infocontractual.TX_Cifras_Recursos)).length;
		var datos_recursos = JSON.parse(infocontractual.TX_Cifras_Recursos);
		//Restamos el numero de Obligaciones Totales el numero de obligaciones de idartes para conocer la cantidad del asociado.
		var numero_obligaciones_asociado = numero_obligaciones_recursos - numero_obligaciones_idartes;
		//Cargamos los recursos de la Obligaciones con cargo al Idartes.
		var Obligaciones_Idartes = JSON.parse(infocontractual.TX_Obligaciones_Idartes);
		var informes = "";
		var folios = "";
		var string_informes = "";
		var string_folios = "";
		for(i=1;i<=numero_obligaciones_idartes;i++){
			string_informes = "";
			string_folios = "";
			informes = datos_recursos["cifras_recursos_obligacion_"+i].informes;
			cantidad_informes = informes.length;
			for(k=0;k<cantidad_informes;k++){
				string_informes += "Informe No."+informes[k]+'\n';
			}

			folios = datos_recursos["cifras_recursos_obligacion_"+i].folio.split(";");
			cantidad_folios = folios.length;
			for(m=0;m<cantidad_folios-1;m++){
				string_folios += "Folio "+folios[m]+'\n';
			}
			obligaciones_recursos.push(
			{
				style: 'tableExample',
				table: {
					widths: ['3%','37%','15%','15%','15%','15%'],
					body: [
					[{
						text:[{text: i}],
						style: 'bgcolor',
					},{
						text:[{text: Obligaciones_Idartes["Obligacion_"+i]}],
					},{
						text:[{text: datos_recursos["cifras_recursos_obligacion_"+i].recursos_idartes,alignment:'justify'}],
					},{
						text:[{text: datos_recursos["cifras_recursos_obligacion_"+i].recursos_asociado,alignment:'justify'}],
					},{
						text:[{text: string_informes,alignment:'justify'}],
					},{
						text:[{text: string_folios,alignment:'justify'}],
					}],
					]
				}
			}
			);
		}
		for(i=1;i<=numero_obligaciones_asociado;i++){
			informes = datos_recursos["cifras_recursos_obligacion_asociado_"+i].informes;
			cantidad_informes = informes.length;
			string_informes="";
			for(k=0;k<cantidad_informes;k++){
				string_informes += "Informe No."+informes[k]+'\n';
			}

			folios = datos_recursos["cifras_recursos_obligacion_asociado_"+i].folio.split(";");
			cantidad_folios = folios.length;
			string_folios="";
			for(m=0;m<cantidad_folios-1;m++){
				string_folios += "Folio "+folios[m]+'\n';
			}
			obligaciones_recursos.push(
			{
				style: 'tableExample',
				table: {
					widths: ['3%','37%','15%','15%','15%','15%'],
					body: [
					[{
						text:[{text: i+numero_obligaciones_idartes}],
						style: 'bgcolor',
					},{
						text:[{text: datos_recursos["cifras_recursos_obligacion_asociado_"+i].descripcion_obligacion_asociado}],
					},{
						text:[{text: datos_recursos["cifras_recursos_obligacion_asociado_"+i].recursos_idartes,alignment:'justify'}],
					},{
						text:[{text: datos_recursos["cifras_recursos_obligacion_asociado_"+i].recursos_asociado,alignment:'justify'}],
					},{
						text:[{text: string_informes,alignment:'justify'}],
					},{
						text:[{text: string_folios,alignment:'justify'}],
					}],
					]
				}
			}
			);
		}
	}
	else{
		datos_cifras = {
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{
					text:{text: 'NOTA IMPORTANTE: Este numeral estará disponible para diligenciar en el último Informe del Convenio.' ,style: 'tableHeader'},
				}
				],
				]
			},
		};
		obligaciones_recursos = {
			style: 'tableExample',
			table: {
				widths: ['*'],
				body: [
				[{
					text:{text: 'NOTA IMPORTANTE: Este numeral estará disponible para diligenciar en el último Informe del Convenio.' ,style: 'tableHeader'},
				}
				],
				]
			},
		};
	}

	anexos_obligaciones = [];
	detalle_actividades_obligacion = [];
	var numero_rows = Object.keys(JSON.parse(infocontractual.TX_Obligaciones_Idartes)).length;
	for(i=1;i<=numero_rows;i++){
		var Detalle_Actividades = JSON.parse(informegestion.TX_Detalle_Actividades);
		anexos_obligaciones.push(
		{
			style: 'tableExample',
			table: {
				widths: ['15%','*'],
				body: [
				[{
					text:[{text: 'Anexos Obligación '+i}],
					style: 'bgcolor',
				},{
					text:[{text: Detalle_Actividades["detalle_actividades_obligacion_"+i].anexos,alignment:'justify'}],
				}],
				]
			}
		}
		);
	}

	var anio_convenio = infocontractual.DA_Inicio.split('-');
	var Supervisor = '';
	var Leyenda_Minuta = '';

	if(anio_convenio[0]=='2017'){
		Supervisor = 'JAIME CERON SILVA';
		Leyenda_Minuta = 'La supervisión y control de ejecución del convenio, será ejercida por EL ORDENADOR DEL GASTO, en todo caso éste podrá en cualquier momento asignarla a otro funcionario, al igual que definirá los apoyos a la supervisión.';
	}
	if(anio_convenio[0]=='2018'){
		Supervisor = 'FABIO MARTINEZ MOSQUERA';
		Leyenda_Minuta = 'El control y vigilancia de la ejecución y cumplimiento de las obligaciones pactadas en el contrato, será ejercido por, FABIO MARTINEZ MOSQUERA, profesional especializado de la Subdirección de Formación Artística. En todo caso el ORDENADOR DEL GASTO respectivo podrá en cualquier momento asignarla a otro funcionario, así como disponer lo pertinente en cuanto se refiere a apoyos a la supervisión. El supervisor está autorizado para impartir instrucciones al contratista sobre asuntos de su responsabilidad y éste se encuentra obligado a cumplirlas. Igualmente, el ORDENADOR DEL GASTO podrá variar unilateralmente la designación del supervisor, comunicando su decisión por escrito al CONTRATISTA.';
	}

	pdfData = {
		pageOrientation: 'landscape',
		pageSize: 'Legal',
		pageMargins:[40,115,40,40],
		header: function(currentPage, pageCount)
		{
			return{
				margin:40,
				widths: ['20%','*', '20%'],

				columns: [
				{
					style: 'tableExample',
					table: {
						widths: ['20%','60%','20%'],
						body: [
						[{
							image: 'data:image/jpeg;base64,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bAAAAAAASW50cmJvb2wAAAAAAEJja2dPYmpjAAAAAQAAAAAAAFJHQkMAAAADAAAAAFJkICBkb3ViQG/gAAAAAAAAAAAAR3JuIGRvdWJAb+AAAAAAAAAAAABCbCAgZG91YkBv4AAAAAAAAAAAAEJyZFRVbnRGI1JsdAAAAAAAAAAAAAAAAEJsZCBVbnRGI1JsdAAAAAAAAAAAAAAAAFJzbHRVbnRGI1B4bEBiwAAAAAAAAAAACnZlY3RvckRhdGFib29sAQAAAABQZ1BzZW51bQAAAABQZ1BzAAAAAFBnUEMAAAAATGVmdFVudEYjUmx0AAAAAAAAAAAAAAAAVG9wIFVudEYjUmx0AAAAAAAAAAAAAAAAU2NsIFVudEYjUHJjQFkAAAAAAAAAAAAQY3JvcFdoZW5QcmludGluZ2Jvb2wAAAAADmNyb3BSZWN0Qm90dG9tbG9uZwAAAAAAAAAMY3JvcFJlY3RMZWZ0bG9uZwAAAAAAAAANY3JvcFJlY3RSaWdodGxvbmcAAAAAAAAAC2Nyb3BSZWN0VG9wbG9uZwAAAAAAOEJJTQPtAAAAAAAQAJYAAAABAAIAlgAAAAEAAjhCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQQNAAAAAAAEAAAAWjhCSU0EGQAAAAAABAAAAB44QklNA/MAAAAAAAkAAAAAAAAAAAEAOEJJTScQAAAAAAAKAAEAAAAAAAAAAjhCSU0D9QAAAAAASAAvZmYAAQBsZmYABgAAAAAAAQAvZmYAAQChmZoABgAAAAAAAQAyAAAAAQBaAAAABgAAAAAAAQA1AAAAAQAtAAAABgAAAAAAAThCSU0D+AAAAAAAcAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAAThCSU0EAgAAAAAABAAAAAA4QklNBDAAAAAAAAIBAThCSU0ELQAAAAAABgABAAAABzhCSU0ECAAAAAAAEAAAAAEAAAJAAAACQAAAAAA4QklNBB4AAAAAAAQAAAAAOEJJTQQaAAAAAANNAAAABgAAAAAAAAAAAAABmgAAAlgAAAAM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UGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxNy0wNi0yMlQxMToyODowOC0wNTowMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAxNy0wNi0yMlQxMToyOTo1OS0wNTowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTctMDYtMjJUMTE6Mjk6NTktMDU6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpkZjU1ZGRkZC0xNTM3LWNhNDktYTdiZS1lNjk4NDU5ZjI3YmQiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDpkMjc2NTVlMi01NzY3LTExZTctYjUyNC1iZTdiMmE5ZTE5N2EiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpjYzY1NDNhNy03NTBiLWYzNDQtOGQ0ZS1jNTNlOTY3ZWQzOTMiIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmNjNjU0M2E3LTc1MGItZjM0NC04ZDRlLWM1M2U5NjdlZDM5MyIgc3RFdnQ6d2hlbj0iMjAxNy0wNi0yMlQxMToyODowOC0wNTowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpmNDg0MjUwNS04OWM3LTIzNGEtODc2MC05OGY3YmM4YzYyNjciIHN0RXZ0OndoZW49IjIwMTctMDYtMjJUMTE6Mjk6NTktMDU6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY29udmVydGVkIiBzdEV2dDpwYXJhbWV0ZXJzPSJmcm9tIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AgdG8gaW1hZ2UvanBlZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iZGVyaXZlZCIgc3RFdnQ6cGFyYW1ldGVycz0iY29udmVydGVkIGZyb20gYXBwbGljYXRpb24vdm5kLmFkb2JlLnBob3Rvc2hvcCB0byBpbWFnZS9qcGVnIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpkZjU1ZGRkZC0xNTM3LWNhNDktYTdiZS1lNjk4NDU5ZjI3YmQiIHN0RXZ0OndoZW49IjIwMTctMDYtMjJUMTE6Mjk6NTktMDU6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6ZjQ4NDI1MDUtODljNy0yMzRhLTg3NjAtOThmN2JjOGM2MjY3IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOmNjNjU0M2E3LTc1MGItZjM0NC04ZDRlLWM1M2U5NjdlZDM5MyIgc3RSZWY6b3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOmNjNjU0M2E3LTc1MGItZjM0NC04ZDRlLWM1M2U5NjdlZDM5MyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAg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',
							height:60,
							width:120,
							alignment: 'center'
						},{
							text: 'GESTIÓN JURÍDICA\nFORMATO - INFORME DE GESTIÓN CONVENIOS DE ASOCIACIÓN',alignment:'center', style: 'header',
						},{
							style: 'tableExample',
							table: {
								widths: ['100%'],
								body: [
								[{
									text:[{text: 'Código: 1AP-GJU-F-48',style: 'tableHeaderEncabezado'}],
								}],
								[{
									text:[{text: 'Fecha: 05/06/2015',style: 'tableHeaderEncabezado'}],
								}],
								[{
									text:[{text: 'Versión: 2',style: 'tableHeaderEncabezado'}],
								}],
								[{
									text:[{text: 'Página: '+currentPage+' de '+pageCount,style: 'tableHeaderEncabezado'}],
								}],
								]
							}
						}],
						]
					}
				}
				]
			}
		},
		footer: function(currentPage, pageCount) {
			return {
				margin:10,
				columns: [
				{
					fontSize: 9,
					text:[
					{
						text: '--------------------------------------------------------------------------' +
						'\n',
						margin: [0, 20]
					},
					{
						text: 'SICREA, Formato Informe de Gestión, ' + currentPage.toString() + ' de ' + pageCount,
					}
					],
					alignment: 'center'
				}
				]
			};

		},
		content: [
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*'],
				body: [
				[{
					text:{text: 'SELECCIONE SEGUN EL CASO: ',style: 'tableHeader'},
				},{
					text:[{text: 'REGISTRE NO. DEL CONTRATO',style: 'tableHeader'}],
				},{
					text:[{text: 'DATOS GENERALES',style: 'tableHeader'}],
				}],
				[{
					text:{text: 'Convenio de Asociación'},
				},{
					text:[{text: infocontractual.VC_Convenio}],
				},{
					text:[{text: 'FECHA ACTA DE INICIO: '},{text: infocontractual.DA_Inicio}],
				}],
				[{
					text:{text: 'Contrato de Prestación de Servicios de Apoyo a la Gestión – Persona Jurídica'},
				},{
					text:[{text: 'No. N/A'}],
				},{
					text:[{text: 'FECHA DE TERMINACIÓN: '},{text: infocontractual.DA_Fin}],
				}],
				[{
					text:{text: 'Contrato de Apoyo Concertado'},
				},{
					text:[{text: 'No. N/A'}],
				},{
					text:[{text: 'NIT: '},{text: infocontractual.VC_Nit}],
				}],
				[{
					text:{text: 'Nombre del Proyecto'},
				},{
					text:[{text: infocontractual.TX_Nombre_Proyecto}],
				},{
					text:[{text: 'Area(s): '},{text: "\n"+vector_areas_artisticas}],
					rowSpan:2
				}],
				[{
					text:{text: 'Nombre de la Organización'},
				},{
					text:[{text: infocontractual.VC_Nom_Organizacion}],
				},{}],
				[{
					text:{text: 'Representante Legal'},
				},{
					text:[{text: infocontractual.VC_Representante_Legal}],
				},{
					text:[{text: 'Estado:'},{text: estado}]
				}
				],

				]
			}
		},
		{text:'\n'},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*','*','*'],
				body: [
				[{
					text:[{text: 'Número del Presente Informe: ',style: 'tableHeader'}],
				},{
					text:[{text: informegestion.VC_Informe}],
				}]
				]
			}
		},
		{text:'\n'},
		{
			style: 'tableExample',
			table: {
				widths: ['*','*','*','*','*'],
				body: [
				[{
					text:[{text: 'Periodo del Informe: ',style: 'tableHeader'}],
				},{
					text:[{text: informegestion.VC_Periodo+" - "+informegestion.IN_Anio}],
				}]
				]
			}
		},
		{text:'\n'},
		{text:'Supervisor: '+Supervisor},
		{text:'\n'},
		{text:Leyenda_Minuta},
		{text:'\n'},
		{text:'OBJETO DEL CONTRATO: '+infocontractual.TX_Objeto_Contrato},
		{text:'\n'},
		{text:'Correo Electrónico: '+informegestion.VC_Correo,
		pageBreak: 'after',
		pageOrientation: 'landscape'
	},
	{text:'1. CUMPLIMIENTO Y EVALUACIÓN DE ACTIVIDADES', style: 'titulo'},
	{
		style: 'tableExample',
		pageBreak: 'before',
		table: {
			widths: ['25%','25%','15%','*'],
			body: [
			[{
				text:[{text: 'OBLIGACIÓN',style: 'tableHeader'}],
			},{
				text:[{text: 'ACTIVIDADES',style: 'tableHeader'}],
				colSpan:2
			},{},{
				text:[{text: 'DESCRIPCIÓN',style: 'tableHeader'}],
			}]
			]
		}
	},
	obligaciones_idartes,
	{
		style: 'tableExample',
		pageBreak: 'before',
		table: {
			widths: ['*'],
			body: [
			[{
				text:{text: '2. REPORTE CONSOLIDADO DE DATOS Y CIFRAS',style: 'subtitulo'},
			}
			],
			]
		},
	},
	datos_cifras,
	{
		style: 'tableExample',
		pageBreak: 'before',
		table: {
			widths: ['*'],
			body: [
			[{
				text:{text: '3. OBLIGACIONES ESPECÍFICAS',style: 'subtitulo'},
			}
			],
			]
		},
	},
	{
		style: 'tableExample',
		table: {
			widths: ['3%','37%','15%','15%','15%','15%'],
			body: [
			[{
				text:[{text: 'OBLIGACIÓN ESPECÍFICA'}],
				colSpan:2,
				style: 'bgcolor',
			},{
				text:[{text: ''}],
			},{
				text:[{text: 'RECURSOS IDARTES'}],
				style: 'bgcolor',
			},{
				text:[{text: 'RECURSOS PROPIOS'}],
				style: 'bgcolor',
			},{
				text:[{text: 'INFORME'}],
				style: 'bgcolor',
			},{
				text:[{text: 'FOLIO'}],
				style: 'bgcolor',
			}],
			]
		}
	},
	obligaciones_recursos,
	{text:'\n'},
	{
		style: 'tableExample',
		table: {
			widths: ['*'],
			body: [
			[{
				text:{text: '4. ANEXOS',style: 'subtitulo'},
			}
			],
			]
		},
	},
	anexos_obligaciones,
	{text: '\n'},
	{text: '\n'},
	{text: '\n'},
	{text: 'Coordialmente,'},
	{text: '\n'},
	{text: '________________________________________________'},
	{text: 'Representante Legal'},
	{text: 'Nombre:'},
	{text: 'No. Folios: '},
	],
	images:
	{
		image_alcaldia: "",
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
			margin: [0, 10, 0, 10],
		},
		titulo: {
			fontSize: 40,
			bold: true,
			margin: [0, 150, 0, 10],
			alignment : 'center'
		},
		subtitulo: {
			fontSize: 18,
			bold: true,
			margin: [0, 0, 0, 10],
			alignment : 'center'
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
			fontSize: 15
		},
		tableHeaderEncabezado: {
			bold: true,
			fontSize: 10,
			fontSize: 10,
		},
		tableHeaderCenter: {
			bold: true,
			fontSize: 15,
			alignment : 'center'
		},
		version_formato: {
			bold: true,
			fontSize: 15,
			alignment:'right'
		},
	},
	defaultStyle: {
		fontSize: 12
	}
}
// convertImgToBase64("../imagenes/logo_alcaldia_bogota.jpg", function(base64Img){
// 	imageAlcaldia = base64Img;
// });
// convertImgToBase64("../imagenes/clan.jpg", function(base64Img){
// 	imageClan = base64Img;
// 	pdfData.images["image_alcaldia"]=imageAlcaldia;
// 	pdfData.images["image_clan"]=imageClan;
//  pdfMake.createPdf(pdfData).download("FormatoInformeGestion.pdf");
// });
pdfMake.createPdf(pdfData).download("FormatoInformeGestion.pdf");
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

function escribir_conquien(beneficiarios, sumatoria_beneficiarios_sexo, sumatoria_beneficiarios_ciclo_vital, sumatoria_beneficiarios_sector_social, sumatoria_beneficiarios_etnia, sumatoria_beneficiarios_estrato){
	var id = $("#id_celda_sumatoria_conquien").val();
	$("#"+id).val("Sexo:"+sumatoria_beneficiarios_sexo+','+" Ciclo Vital:"+sumatoria_beneficiarios_ciclo_vital+','+" Sector Social:"+sumatoria_beneficiarios_sector_social+','+" Etnia:"+sumatoria_beneficiarios_etnia+','+" Estrato:"+sumatoria_beneficiarios_estrato);
	$("#"+id).prop('readonly', true);

	var input_sumatoria = id.split("_");
	var id_input_beneficiarios = "beneficiarios_"+input_sumatoria[1];
	$('input[name="'+id_input_beneficiarios+'"]').val(beneficiarios);
}

function escribir_folios(valores){
	var id = $("#id_celda_folios").val();
	$("#"+id).val(valores);
	$("#"+id).prop('readonly', true);
}

function abrirmodal(boton){
	$("#modal_con_quien").modal('show');
	$('body').css('height', '100');
	var id = boton;
	var input_sumatoria = id.split("_");
	$("#id_celda_sumatoria_conquien").val(id);
	var id_input_beneficiarios = "beneficiarios_"+input_sumatoria[1];
	var beneficiarios = $("#"+id_input_beneficiarios).val();

	if(beneficiarios != "")
	{
		var vector_beneficiarios = beneficiarios.split(",");
		$("#BH_Mujeres").val(vector_beneficiarios[0]);
		$("#BH_Hombres").val(vector_beneficiarios[1]);
		$("#BH_P_Infancia").val(vector_beneficiarios[2]);
		$("#BH_Infancia").val(vector_beneficiarios[3]);
		$("#BH_Adolescencia").val(vector_beneficiarios[4]);
		$("#BH_Juventud").val(vector_beneficiarios[5]);
		$("#BH_Adulto").val(vector_beneficiarios[6]);
		$("#BH_Adulto_Mayor").val(vector_beneficiarios[7]);
		$("#BH_Campesinos").val(vector_beneficiarios[8]);
		$("#BH_Artesanos").val(vector_beneficiarios[9]);
		$("#BH_Discapacidad").val(vector_beneficiarios[10]);
		$("#BH_LGBTI").val(vector_beneficiarios[11]);
		$("#BH_Reinsertados").val(vector_beneficiarios[12]);
		$("#BH_Victimas").val(vector_beneficiarios[13]);
		$("#BH_Dezplazamiento").val(vector_beneficiarios[14]);
		$("#BH_Habitantes_Calle").val(vector_beneficiarios[15]);
		$("#BH_Medios_Comunitarios").val(vector_beneficiarios[16]);
		$("#BH_Pueblo_Raizal").val(vector_beneficiarios[17]);
		$("#BH_Afrodescendientes").val(vector_beneficiarios[18]);
		$("#BH_Pueblo_Gitano").val(vector_beneficiarios[19]);
		$("#BH_Indigenas").val(vector_beneficiarios[20]);
		$("#BH_Otras_Etnias").val(vector_beneficiarios[21]);
		$("#BH_Estrato_Uno").val(vector_beneficiarios[22]);
		$("#BH_Estrato_Dos").val(vector_beneficiarios[23]);
		$("#BH_Estrato_Tres").val(vector_beneficiarios[24]);
		$("#BH_Estrato_Cuatro").val(vector_beneficiarios[25]);
		$("#BH_Estrato_Cinco").val(vector_beneficiarios[26]);
		$("#BH_Estrato_Seis").val(vector_beneficiarios[27]);
	}
	else{
		$("#BH_Mujeres").val(0);
		$("#BH_Hombres").val(0);
		$("#BH_P_Infancia").val(0);
		$("#BH_Infancia").val(0);
		$("#BH_Adolescencia").val(0);
		$("#BH_Juventud").val(0);
		$("#BH_Adulto").val(0);
		$("#BH_Adulto_Mayor").val(0);
		$("#BH_Campesinos").val(0);
		$("#BH_Artesanos").val(0);
		$("#BH_Discapacidad").val(0);
		$("#BH_LGBTI").val(0);
		$("#BH_Reinsertados").val(0);
		$("#BH_Victimas").val(0);
		$("#BH_Dezplazamiento").val(0);
		$("#BH_Habitantes_Calle").val(0);
		$("#BH_Medios_Comunitarios").val(0);
		$("#BH_Pueblo_Raizal").val(0);
		$("#BH_Afrodescendientes").val(0);
		$("#BH_Pueblo_Gitano").val(0);
		$("#BH_Indigenas").val(0);
		$("#BH_Otras_Etnias").val(0);
		$("#BH_Estrato_Uno").val(0);
		$("#BH_Estrato_Dos").val(0);
		$("#BH_Estrato_Tres").val(0);
		$("#BH_Estrato_Cuatro").val(0);
		$("#BH_Estrato_Cinco").val(0);
		$("#BH_Estrato_Seis").val(0);
	}
}

function abrirmodalfoliosidartes(boton){
	$("#modal_folios").modal('show');
	$('body').css('height', '100');
	var id = boton;
	var input_sumatoria = id.split("_");
	$("#id_celda_folios").val(id);
	var id_input_folios = "folio_tb1_"+input_sumatoria[2];
	var folios = $("#"+id_input_folios).val();
	folios = folios.split(";");
	var nombre_elemento = "SL_Informe_tb1_"+input_sumatoria[2];
	if(folios != "")
	{
		$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			//values += $(selected).val()+";";
			$("#folios_informe_"+$(selected).val()).val(folios[i]);
		});
	}
	else{
		$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			//values += $(selected).val()+";";
			$("#folios_informe_"+$(selected).val()).val('');
		});
	}
}

function abrirmodalfoliosasociado(boton){
	$("#modal_folios").modal('show');
	$('body').css('height', '100');
	var id = boton;
	var input_sumatoria = id.split("_");
	$("#id_celda_folios").val(id);
	var id_input_folios = "folio_tb2_"+input_sumatoria[2];
	var folios = $("#"+id_input_folios).val();
	folios = folios.split(";");
	var nombre_elemento = "SL_Informe_tb2_"+input_sumatoria[2];
	if(folios != "")
	{
		$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			//values += $(selected).val()+";";
			$("#folios_informe_"+$(selected).val()).val(folios[i]);
		});
	}
	else{
		$('#'+nombre_elemento+' :selected').each(function(i, selected){
			//cantidad_informes += 1;
			//values += $(selected).val()+";";
			$("#folios_informe_"+$(selected).val()).val('');
		});
	}
}

function actualizarEstadoFAS(tipo_formato,id_formato,estado, session){
	var datos = {
		'opcion': 'actualizarEstadoFAS',
		'tipo_formato': tipo_formato,
		'id_formato': id_formato,
		'estado': estado,
		'usuario': session
	};

	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (datos) {
			parent.swal("","El estado del Formato ha sido actualizado","success");
		},
		async : false
	});
}

function consultarSeguimientoPropuesta(){
	var datos = {
		'opcion': 'consultarSeguimientoPropuesta',
		'id_organizacion': session
	};

	$.ajax({
		url: url_controller_fas,
		data: datos,
		type: 'POST',
		success: function (datos) {
			if(datos != "null"){
				datos = JSON.parse(datos);
				bandera_existencia_seguimiento_propuesta = datos.PK_Id_Tabla;
			}
			else{
				parent.swal("","Para diligenciar FORMATOS ADMINISTRATIVOS debe primero haber diligenciado el <br>SEGUIMIENTO A LA PROPUESTA correspondiente al nuevo convenio en la actividad SEGUIMIENTO PROPUESTA","error");
				setTimeout(function(){
					$('.nav-tabs a[href="#consulta-archivos"]').tab('show');
					window.document.body.style.width = '100%';
					if (!parent.window.$('#btn_menu_show').children().hasClass('fa-angle-double-left'))
					{
						parent.window.$('#btn_menu_show').click();
					}
				}, 500);
				
			}
		},
		async : false
	});
}
