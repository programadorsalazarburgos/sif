var url_controller = "../../Controlador/Organizaciones/C_FAS_Organizaciones.php";
var url_controller_routed = '../../src/Organizaciones/OrganizacionesController/';
var pdfData = null;
var session = "";
var session_type = "";
var id_seguimiento_propuesta = "";
$(document).ready(function(){

	var items = [
	'Alimentación',
	'Alojamiento',
	'Alquiler',
	'Divulgación',
	'Duplicación de Documentos',
	'Gastos Administrativos',
	'Logistica de Eventos',
	'Materiales para Procesos de Formación',
	'Personal Docente',
	'Piezas Cominicativas',
	'Producción de Mate',
	'Recuros Humano',
	'Tramite de Permisos',
	'Transporte',
	'Vigilancia de Eventos',
	];

	var convenciones = [
	'ALM',
	'ALJ',
	'ALQ',
	'DVU',
	'DPD',
	'GA',
	'LGE',
	'MPF',
	'PD',
	'PC',
	'PM',
	'RH',
	'TDP',
	'TP',
	'VE',
	];

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

	$('#SL_Rubro').on('change', function(e){
		e.preventDefault();
		if ($(this).val()) {
			if (!$(this).val().includes("1")) {
				$('#table_rubro_1').attr('hidden', true);
				$('#table_rubro_1 input').attr('disabled', true);
				$('#table_rubro_1 select').attr('disabled', true);
			}
			else
			{
				$('#table_rubro_1').removeAttr('hidden');
				$('#table_rubro_1 input').removeAttr('disabled');
				$('#table_rubro_1 select').removeAttr('disabled');
			}
			if (!$(this).val().includes("2")) {
				$('#table_rubro_2').attr('hidden', true);
				$('#table_rubro_2 input').attr('disabled', true);
				$('#table_rubro_2 select').attr('disabled', true);
			}
			else
			{
				$('#table_rubro_2').removeAttr('hidden');
				$('#table_rubro_2 input').removeAttr('disabled');
				$('#table_rubro_2 select').removeAttr('disabled');
			}
			if (!$(this).val().includes("3")) {
				$('#table_rubro_3').attr('hidden', true);
				$('#table_rubro_3 input').attr('disabled', true);
				$('#table_rubro_3 select').attr('disabled', true);
			}
			else
			{
				$('#table_rubro_3').removeAttr('hidden');
				$('#table_rubro_3 input').removeAttr('disabled');
				$('#table_rubro_3 select').removeAttr('disabled');
			}
			if (!$(this).val().includes("4")) {
				$('#table_rubro_4').attr('hidden', true);
				$('#table_rubro_4 input').attr('disabled', true);
				$('#table_rubro_4 select').attr('disabled', true);
			}
			else
			{
				$('#table_rubro_4').removeAttr('hidden');
				$('#table_rubro_4 input').removeAttr('disabled');
				$('#table_rubro_4 select').removeAttr('disabled');
			}
			if (!$(this).val().includes("5")) {
				$('#table_rubro_5').attr('hidden', true);
				$('#table_rubro_5 input').attr('disabled', true);
				$('#table_rubro_5 select').attr('disabled', true);
			}
			else
			{
				$('#table_rubro_5').removeAttr('hidden');
				$('#table_rubro_5 input').removeAttr('disabled');
				$('#table_rubro_5 select').removeAttr('disabled');
			}
			if (!$(this).val().includes("6")) {
				$('#table_rubro_6').attr('hidden', true);
				$('#table_rubro_6 input').attr('disabled', true);
				$('#table_rubro_6 select').attr('disabled', true);
			}
			else
			{
				$('#table_rubro_6').removeAttr('hidden');
				$('#table_rubro_6 input').removeAttr('disabled');
				$('#table_rubro_6 select').removeAttr('disabled');
			}
		}

	});
	var meses = parent.getParametroDetalle(8);
	var mesesArray = [];
	$.each(meses,function (key,mes) {
		mesesArray[mes.VC_Descripcion] = mes;
	})

	function refreshColumnsBloqued(organizacion) {
		if (organizacion != null) {
			let datasAjax = {
				p1: {
					'idOrganizacion': organizacion.PK_Id_Organizacion,
					'idSeguimientoPropuesta': organizacion.PK_Id_Tabla,
				}
			};
			$.ajax({
				url: url_controller_routed+"getLastApprovedProyeccionPk",
				type: 'POST',
				dataType: 'json',
				data: datasAjax,
				success: function (proyeccionFormato) {
					if (proyeccionFormato.length > 0 ) {
						proyeccionFormatoJson = proyeccionFormato[0];
						var numberMonth = mesesArray[proyeccionFormatoJson.LAST_TX_PERIODO].FK_Value;
						console.log(proyeccionFormatoJson);
					}
				},
				async : false
			});
		}
	}

	var idUsuario = $("#id_usuario").val();
	var organizacion = null;
	var datos = {
		'opcion':'getOrganizacionData',
		'idUsuario': idUsuario
	};
	$.ajax({
		async: false,
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(datos){
			try{
				organizacion = JSON.parse(datos);
				$('#p_organizacion').text(organizacion.VC_Nom_Organizacion);
				id_seguimiento_propuesta = organizacion.PK_Id_Tabla;
				refreshColumnsBloqued(organizacion);
			}
			catch(ex){}
		}
	});

	var rowNumbDesem = 0;
	var table_desembolsos = $("#table_desembolsos").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});

	var rowNumbAdiciones = 0;
	var table_adiciones = $("#table_adiciones").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});

	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});

	$('#a-add-item-0').on('click', function(e){
		e.preventDefault();
		rowNumbAdiciones++;
		table_adiciones.row($("#table_adiciones tr").eq(-1)).remove().draw();
		var descripcion="INICIAL";
		if(rowNumbAdiciones>1){
			descripcion = "ADICIÓN"
		}
		table_adiciones.row.add([
			rowNumbAdiciones,
			descripcion,
			'<input value="0" style="width:99%" class="change-event" id="TX_AD_IDARTES_0" data-identify="TX_AD_IDARTES_0" name="TX_AD_IDARTES_0_'+rowNumbAdiciones+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_AD_ASOCIADO_1" data-identify="TX_AD_ASOCIADO_1" name="TX_AD_ASOCIADO_1_'+rowNumbAdiciones+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_AD_TOTAL_2" data-identify="TX_AD_TOTAL_2" name="TX_AD_TOTAL_2_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_AD_PORCENTAJE_3" data-identify="TX_AD_TOTAL_3" name="TX_AD_TOTAL_3_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>'
			]).draw();
			table_adiciones.row.add( [
			'',
			'TOTAL',
			'<input value="0" style="width:99%" class="change-event" id="TX_ADT_IDARTES_0" data-identify="TX_ADT_IDARTES_0" name="TX_ADT_IDARTES_0_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" class="change-event" id="TX_ADT_ASOCIADO_1" data-identify="TX_ADT_ASOCIADO_1" name="TX_ADT_ASOCIADO_1_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" class="change-event" id="TX_ADT_TOTAL_2" data-identify="TX_ADT_TOTAL_2" name="TX_ADT_TOTAL_2_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_ADT_PORCENTAJE_3" data-identify="TX_ADT_PORCENTAJE_3" name="TX_ADT_PORCENTAJE_3_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>'
			]).draw();
		calcularValorColumna($('#TX_ADT_IDARTES_0'),$("[data-identify='TX_AD_IDARTES_0']"));
		calcularValorColumna($('#TX_ADT_ASOCIADO_1'),$("[data-identify='TX_AD_ASOCIADO_1']"));
		calcularValorColumna($('#TX_ADT_TOTAL_2'),$("[data-identify='TX_AD_TOTAL_2']"));

		calcularAdicionesFila( $("#table_adiciones"),rowNumbAdiciones);
	});
	$('#a-add-item-0').click();

	$('#a-delete-item-0').on('click', function(e){
		e.preventDefault();
		if (rowNumbAdiciones > 1) {
			rowNumbAdiciones--;
			table_adiciones.row($( "#table_adiciones tr").eq(-1)).remove().draw();
			table_adiciones.row.add( [
				'',
				'Total',
				'<input value="0" style="width:99%" id="TX_ADT_IDARTES_0" data-identify="TX_ADT_IDARTES_0" name="TX_ADT_IDARTES_0_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_ADT_ASOCIADO_1" data-identify="TX_ADT_ASOCIADO_1" name="TX_ADT_ASOCIADO_1_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_ADT_TOTAL_2" data-identify="TX_ADT_TOTAL_2" name="TX_ADT_TOTAL_2_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_ADT_PORCENTAJE_3" data-identify="TX_ADT_PORCENTAJE_3" name="TX_ADT_PORCENTAJE_3_'+rowNumbAdiciones+'" type="text" maxlength="100" readonly>'
				]).draw();
			table_adiciones.row($( "#table_adiciones tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_ADT_IDARTES_0'),$("[data-identify='TX_AD_IDARTES_0']"));
			calcularValorColumna($('#TX_ADT_ASOCIADO_1'),$("[data-identify='TX_AD_ASOCIADO_1']"));
			calcularValorColumna($('#TX_ADT_TOTAL_2'),$("[data-identify='TX_AD_TOTAL_2']"));

			calcularAdicionesFila( $("#table_adiciones"),rowNumbAdiciones);
		}
	});

	$( "#table_adiciones" ).delegate( "input", "change", function() {
		if ($( this ).val() == '' ) $( this ).val(0);
		if ($( this ).attr('data-identify') == 'TX_AD_IDARTES_0' ) {
			calcularAdicionesFila( $("#table_adiciones"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_ADT_IDARTES_0'),$("[data-identify='TX_AD_IDARTES_0']"));
		}
		if ($( this ).val() == '' ) $( this ).val(0);
		if ($( this ).attr('data-identify') == 'TX_AD_ASOCIADO_1' ) {
			calcularAdicionesFila( $("#table_adiciones"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_ADT_ASOCIADO_1'),$("[data-identify='TX_AD_ASOCIADO_1']"));
		}
		if ($( this ).attr('data-identify') == 'TX_AD_TOTAL_2' ) {
			calcularAdicionesFila( $("#table_adiciones"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_ADT_TOTAL_2'),$("[data-identify='TX_AD_TOTAL_2']"));
		}
		if ($( this ).attr('data-identify') == 'TX_AD_PORCENTAJE_3' ) {
			calcularAdicionesFila( $("#table_adiciones"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_ADT_PORCENTAJE_3'),$("[data-identify='TX_AD_PORCENTAJE_3']"));
		}
		calcularAdicionesFila( $("#table_adiciones"),rowNumbAdiciones);
	});

	$('#a-add-des').on('click', function(e){
		e.preventDefault();
		rowNumbDesem++;
		table_desembolsos.row($( "#table_desembolsos tr").eq(-1)).remove().draw();
		table_desembolsos.row.add([
			rowNumbDesem,
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_0" data-identify="TX_TD_0" name="TX_TD_0_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_1" data-identify="TX_TD_1" name="TX_TD_1_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_2" data-identify="TX_TD_2" name="TX_TD_2_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_3" data-identify="TX_TD_3" name="TX_TD_3_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_4" data-identify="TX_TD_4" name="TX_TD_4_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_5" data-identify="TX_TD_5" name="TX_TD_5_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_6" data-identify="TX_TD_6" name="TX_TD_6_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_7" data-identify="TX_TD_7" name="TX_TD_7_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_8" data-identify="TX_TD_8" name="TX_TD_8_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_9" data-identify="TX_TD_9" name="TX_TD_9_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_10" data-identify="TX_TD_10" name="TX_TD_10_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_11" data-identify="TX_TD_11" name="TX_TD_11_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_12" data-identify="TX_TD_12" name="TX_TD_12_'+rowNumbDesem+'" type="text" maxlength="100">',
			'<input value="0" style="width:99%" class="change-event" id="TX_TD_13" data-identify="TX_TD_13" name="TX_TD_13_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_desembolsos.row.add( [
			'Total Desembolso',
			'<input value="0" style="width:99%" id="TX_TDT_0" data-identify="TX_TDT_0" name="TX_TDT_0_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_1" data-identify="TX_TDT_1" name="TX_TDT_1_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_2" data-identify="TX_TDT_2" name="TX_TDT_2_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_3" data-identify="TX_TDT_3" name="TX_TDT_3_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_4" data-identify="TX_TDT_4" name="TX_TDT_4_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_5" data-identify="TX_TDT_5" name="TX_TDT_5_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_6" data-identify="TX_TDT_6" name="TX_TDT_6_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_7" data-identify="TX_TDT_7" name="TX_TDT_7_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_8" data-identify="TX_TDT_8" name="TX_TDT_8_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_9" data-identify="TX_TDT_9" name="TX_TDT_9_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_10" data-identify="TX_TDT_10" name="TX_TDT_10_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_11" data-identify="TX_TDT_11" name="TX_TDT_11_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_12" data-identify="TX_TDT_12" name="TX_TDT_12_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			'<input value="0" style="width:99%" id="TX_TDT_13" data-identify="TX_TDT_13" name="TX_TDT_13_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_TDT_0'),$("[data-identify='TX_TD_0']"));
		calcularValorColumna($('#TX_TDT_1'),$("[data-identify='TX_TD_1']"));
		calcularValorColumna($('#TX_TDT_2'),$("[data-identify='TX_TD_2']"));
		calcularValorColumna($('#TX_TDT_3'),$("[data-identify='TX_TD_3']"));
		calcularValorColumna($('#TX_TDT_4'),$("[data-identify='TX_TD_4']"));
		calcularValorColumna($('#TX_TDT_5'),$("[data-identify='TX_TD_5']"));
		calcularValorColumna($('#TX_TDT_6'),$("[data-identify='TX_TD_6']"));
		calcularValorColumna($('#TX_TDT_7'),$("[data-identify='TX_TD_7']"));
		calcularValorColumna($('#TX_TDT_8'),$("[data-identify='TX_TD_8']"));
		calcularValorColumna($('#TX_TDT_9'),$("[data-identify='TX_TD_9']"));
		calcularValorColumna($('#TX_TDT_10'),$("[data-identify='TX_TD_10']"));
		calcularValorColumna($('#TX_TDT_11'),$("[data-identify='TX_TD_11']"));
		calcularValorColumna($('#TX_TDT_12'),$("[data-identify='TX_TD_12']"));
		calcularValorColumna($('#TX_TDT_13'),$("[data-identify='TX_TD_13']"));

		calcularDesembolsoFila( $("#table_desembolsos"),rowNumbDesem);
	});
	//
	$('#a-delete-des').on('click', function(e){
		e.preventDefault();
		if (rowNumbDesem > 1) {
			rowNumbDesem--;
			table_desembolsos.row($( "#table_desembolsos tr").eq(-1)).remove().draw();
			table_desembolsos.row.add( [
				'Total Desembolso',
				'<input value="0" style="width:99%" id="TX_TDT_0" data-identify="TX_TDT_0" name="TX_TDT_0_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_1" data-identify="TX_TDT_1" name="TX_TDT_1_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_2" data-identify="TX_TDT_2" name="TX_TDT_2_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_3" data-identify="TX_TDT_3" name="TX_TDT_3_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_4" data-identify="TX_TDT_4" name="TX_TDT_4_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_5" data-identify="TX_TDT_5" name="TX_TDT_5_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_6" data-identify="TX_TDT_6" name="TX_TDT_6_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_7" data-identify="TX_TDT_7" name="TX_TDT_7_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_8" data-identify="TX_TDT_8" name="TX_TDT_8_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_9" data-identify="TX_TDT_9" name="TX_TDT_9_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_10" data-identify="TX_TDT_10" name="TX_TDT_10_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_11" data-identify="TX_TDT_11" name="TX_TDT_11_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_12" data-identify="TX_TDT_12" name="TX_TDT_12_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				'<input value="0" style="width:99%" id="TX_TDT_13" data-identify="TX_TDT_13" name="TX_TDT_13_'+rowNumbDesem+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_desembolsos.row($( "#table_desembolsos tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_TDT_0'),$("[data-identify='TX_TD_0']"));
			calcularValorColumna($('#TX_TDT_1'),$("[data-identify='TX_TD_1']"));
			calcularValorColumna($('#TX_TDT_2'),$("[data-identify='TX_TD_2']"));
			calcularValorColumna($('#TX_TDT_3'),$("[data-identify='TX_TD_3']"));
			calcularValorColumna($('#TX_TDT_4'),$("[data-identify='TX_TD_4']"));
			calcularValorColumna($('#TX_TDT_5'),$("[data-identify='TX_TD_5']"));
			calcularValorColumna($('#TX_TDT_6'),$("[data-identify='TX_TD_6']"));
			calcularValorColumna($('#TX_TDT_7'),$("[data-identify='TX_TD_7']"));
			calcularValorColumna($('#TX_TDT_8'),$("[data-identify='TX_TD_8']"));
			calcularValorColumna($('#TX_TDT_9'),$("[data-identify='TX_TD_9']"));
			calcularValorColumna($('#TX_TDT_10'),$("[data-identify='TX_TD_10']"));
			calcularValorColumna($('#TX_TDT_11'),$("[data-identify='TX_TD_11']"));
			calcularValorColumna($('#TX_TDT_12'),$("[data-identify='TX_TD_12']"));
			calcularValorColumna($('#TX_TDT_13'),$("[data-identify='TX_TD_13']"));
			calcularDesembolsoFila( $("#table_desembolsos"),rowNumbDesem);
			actualizarTotales();
		}
	});
	$('#a-add-des').click();

	$( "#table_desembolsos" ).delegate( "input", "change", function() {
		if ($( this ).val() == '' ) $( this ).val(0);
		if ($( this ).attr('data-identify') == 'TX_TD_0' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_0'),$("[data-identify='TX_TD_0']"));
		}
		if ($( this ).val() == '' ) $( this ).val(0);
		if ($( this ).attr('data-identify') == 'TX_TD_1' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_1'),$("[data-identify='TX_TD_1']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_2' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_2'),$("[data-identify='TX_TD_2']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_3' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_3'),$("[data-identify='TX_TD_3']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_4' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_4'),$("[data-identify='TX_TD_4']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_5' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_5'),$("[data-identify='TX_TD_5']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_6' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_6'),$("[data-identify='TX_TD_6']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_7' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_7'),$("[data-identify='TX_TD_7']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_8' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_8'),$("[data-identify='TX_TD_8']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_9' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_9'),$("[data-identify='TX_TD_9']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_10' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_10'),$("[data-identify='TX_TD_10']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_11' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_11'),$("[data-identify='TX_TD_11']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_12' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_12'),$("[data-identify='TX_TD_12']"));
		}
		if ($( this ).attr('data-identify') == 'TX_TD_13' ) {
			calcularDesembolsoFila( $("#table_desembolsos"),parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_TDT_13'),$("[data-identify='TX_TD_13']"));
		}
		calcularDesembolsoFila( $("#table_desembolsos"),rowNumbDesem);
		actualizarTotales();
	});
	function calcularAdicionesFila(table,row) {
		$(table).children()[1].children[row].children[4].children[0].value = 0;
		for (var i = 2; i <= 3; i++) {
			$(table).children()[1].children[row].children[4].children[0].value = formatMoney(parseInt(deformatMoney($(table).children()[1].children[row].children[4].children[0].value)) + parseInt(deformatMoney($( table ).children()[1].children[row].children[i].children[0].value)),'$');
		}
			$(table).children()[1].children[row].children[5].children[0].value = ((parseInt(deformatMoney($(table).children()[1].children[row].children[3].children[0].value))*100)/parseInt(deformatMoney($(table).children()[1].children[row].children[2].children[0].value))).toFixed(1)+'%';
	}
	function calcularDesembolsoFila(table,row) {
		$( table ).children()[1].children[row].children[14].children[0].value = 0;
		for (var i = 1; i <= 13; i++) {
			$( table ).children()[1].children[row].children[14].children[0].value = formatMoney(parseInt(deformatMoney($( table ).children()[1].children[row].children[14].children[0].value)) + parseInt(deformatMoney($( table ).children()[1].children[row].children[i].children[0].value)),'$');
		}

	}
	function calcularValorColumna(resultado,columna) {
		$(resultado).val(0);
		$( columna ).each(function( index, element ) {
			$(resultado).val(formatMoney(parseInt(deformatMoney($(resultado).val())) + parseInt(deformatMoney($( element ).val())),"$") );
		});
	}

	function calcularPresupuestoFila(table,row) {
		var presupuesto = parseInt(deformatMoney($( table ).children()[1].children[row].children[5].children[0].value));
		var adicion = parseInt(deformatMoney($( table ).children()[1].children[row].children[6].children[0].value));
		var traslado = parseInt(deformatMoney($( table ).children()[1].children[row].children[8].children[0].value));
		var resultado = presupuesto + adicion - traslado;
		$( table ).children()[1].children[row].children[10].children[0].value =  formatMoney(resultado,"$");
	}

	function calcularSaldoFila(table,row) {
		$( table ).children()[1].children[row].children[24].children[0].value =  0;
		for (var i = 11; i <= 23; i++) {
			$( table ).children()[1].children[row].children[24].children[0].value =
			formatMoney(parseInt(deformatMoney($( table ).children()[1].children[row].children[24].children[0].value)) +
				parseInt(deformatMoney($( table ).children()[1].children[row].children[i].children[0].value)),'$');
		}
	}
	function calcularDisponibleFila(table,row) {
		var presupuesto = parseInt(deformatMoney($( table ).children()[1].children[row].children[10].children[0].value));
		var acumulado = parseInt(deformatMoney($( table ).children()[1].children[row].children[24].children[0].value));
		var resultado = presupuesto - acumulado;
		$( table ).children()[1].children[row].children[25].children[0].value =  formatMoney(resultado,"$");
	}

	function formatMoney(n, currency) {
		var number = n.toFixed(0).replace(/(\d)(?=(\d{3})+(?!\d)\.)/g, "$1,");
		// return currency+" ";
		var amount = number;
		var locale = 'es';
		var options = {style: 'currency', currency: 'cop', minimumFractionDigits: 0, maximumFractionDigits: 0};
		var formatter = new Intl.NumberFormat(locale, options);
		var formated = formatter.format(amount);
		formated = formated.substring(0,formated.length-4);
		return  currency+" "+formated;
	}
	function deformatMoney(text) {
		var deformated = text.replace(/\$/g, "").replace(/\ /g, "").replace(/\,/g, "").replace(/\./g, "");
		return deformated;
	}

	$( "table" ).delegate( "input", "focus", function() {
		if ($( this ).hasClass( "change-event" )) $( this ).val(deformatMoney($( this ).val()));
	});
	$( "table" ).delegate( "input", "blur", function() {
		if ($( this ).hasClass( "change-event" )) $( this ).val(formatMoney(parseFloat(deformatMoney($( this ).val())),"$"));
	});
	$( "body" ).delegate( ".change-event", "blur", function() {
		$( this ).val(formatMoney(parseFloat(deformatMoney($( this ).val())),"$"));
	});

	function selectItems() {
		var select = '';
		for (var i = 0; i < items.length; i++) {
			select = select +'<option value="'+i+'" >'+items[i]+'</option>';
		}
		return select;
	}


	var rowNumb1 = 0;
	var table_items_proyeccion_1 = $("#table_items_proyeccion_1").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});
	$('#a-add-item-1').on('click', function(e){
		e.preventDefault();
		rowNumb1++;
		table_items_proyeccion_1.row($( "#table_items_proyeccion_1 tr").eq(-1)).remove().draw()	;
		table_items_proyeccion_1.row.add( [
			rowNumb1,
			'<input required style="width:99%" id="TX_T1_1" data-identify="TX_T1_1" name="TX_T1_1_'+rowNumb1+'" type="text" maxlength="100">',
			'<select style="width: 99%;" id="SL_T1_2" data-identify="SL_T1_2" name="SL_T1_2_'+rowNumb1+'" title="Seleccionar Item" required>'
			+selectItems()+	'</select>',
			'<input required style="width:99%" value="0" id="TX_T1_25" data-identify="TX_T1_25" name="TX_T1_25_'+rowNumb1+'" type="number" min="1">',
			'<input required style="width:99%" id="TX_T1_26" data-identify="TX_T1_26" name="TX_T1_26_'+rowNumb1+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T1_3" data-identify="TX_T1_3" name="TX_T1_3_'+rowNumb1+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T1_4" data-identify="TX_T1_4" name="TX_T1_4_'+rowNumb1+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T1_5" data-identify="TX_T1_5" name="TX_T1_5_'+rowNumb1+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T1_6" data-identify="TX_T1_6" name="TX_T1_6_'+rowNumb1+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T1_7" data-identify="TX_T1_7" name="TX_T1_7_'+rowNumb1+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T1_8" data-identify="TX_T1_8" name="TX_T1_8_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_85" data-identify="TX_T1_85" name="TX_T1_85_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_9" data-identify="TX_T1_9" name="TX_T1_9_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_10" data-identify="TX_T1_10" name="TX_T1_10_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_11" data-identify="TX_T1_11" name="TX_T1_11_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_12" data-identify="TX_T1_12" name="TX_T1_12_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_13" data-identify="TX_T1_13" name="TX_T1_13_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_14" data-identify="TX_T1_14" name="TX_T1_14_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_15" data-identify="TX_T1_15" name="TX_T1_15_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_16" data-identify="TX_T1_16" name="TX_T1_16_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_17" data-identify="TX_T1_17" name="TX_T1_17_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_18" data-identify="TX_T1_18" name="TX_T1_18_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_19" data-identify="TX_T1_19" name="TX_T1_19_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_20" data-identify="TX_T1_20" name="TX_T1_20_'+rowNumb1+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_21" data-identify="TX_T1_21" name="TX_T1_21_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T1_22" data-identify="TX_T1_22" name="TX_T1_22_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_items_proyeccion_1.row.add( [
			'TOTAL',
			'',
			'',
			'',
			'',
			'<input style="width:99%" id="TX_T1T_3" data-identify="TX_T1T_3" name="TX_T1T_3_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_4" data-identify="TX_T1T_4" name="TX_T1T_4_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T1T_6" data-identify="TX_T1T_6" name="TX_T1T_6_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T1T_8" data-identify="TX_T1T_8" name="TX_T1T_8_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_85" data-identify="TX_T1T_85" name="TX_T1T_85_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_9" data-identify="TX_T1T_9" name="TX_T1T_9_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_10" data-identify="TX_T1T_10" name="TX_T1T_10_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_11" data-identify="TX_T1T_11" name="TX_T1T_11_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_12" data-identify="TX_T1T_12" name="TX_T1T_12_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_13" data-identify="TX_T1T_13" name="TX_T1T_13_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_14" data-identify="TX_T1T_14" name="TX_T1T_14_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_15" data-identify="TX_T1T_15" name="TX_T1T_15_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_16" data-identify="TX_T1T_16" name="TX_T1T_16_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_17" data-identify="TX_T1T_17" name="TX_T1T_17_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_18" data-identify="TX_T1T_18" name="TX_T1T_18_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_19" data-identify="TX_T1T_19" name="TX_T1T_19_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_20" data-identify="TX_T1T_20" name="TX_T1T_20_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_21" data-identify="TX_T1T_21" name="TX_T1T_21_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T1T_22" data-identify="TX_T1T_22" name="TX_T1T_22_'+rowNumb1+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_T1T_3'),$("[data-identify='TX_T1_3']"));
		calcularValorColumna($('#TX_T1T_4'),$("[data-identify='TX_T1_4']"));
		calcularValorColumna($('#TX_T1T_6'),$("[data-identify='TX_T1_6']"));
		calcularValorColumna($('#TX_T1T_8'),$("[data-identify='TX_T1_8']"));
		calcularValorColumna($('#TX_T1T_85'),$("[data-identify='TX_T1_85']"));
		calcularValorColumna($('#TX_T1T_9'),$("[data-identify='TX_T1_9']"));
		calcularValorColumna($('#TX_T1T_10'),$("[data-identify='TX_T1_10']"));
		calcularValorColumna($('#TX_T1T_11'),$("[data-identify='TX_T1_11']"));
		calcularValorColumna($('#TX_T1T_12'),$("[data-identify='TX_T1_12']"));
		calcularValorColumna($('#TX_T1T_13'),$("[data-identify='TX_T1_13']"));
		calcularValorColumna($('#TX_T1T_14'),$("[data-identify='TX_T1_14']"));
		calcularValorColumna($('#TX_T1T_15'),$("[data-identify='TX_T1_15']"));
		calcularValorColumna($('#TX_T1T_16'),$("[data-identify='TX_T1_16']"));
		calcularValorColumna($('#TX_T1T_17'),$("[data-identify='TX_T1_17']"));
		calcularValorColumna($('#TX_T1T_18'),$("[data-identify='TX_T1_18']"));
		calcularValorColumna($('#TX_T1T_19'),$("[data-identify='TX_T1_19']"));
		calcularValorColumna($('#TX_T1T_20'),$("[data-identify='TX_T1_20']"));
		calcularValorColumna($('#TX_T1T_21'),$("[data-identify='TX_T1_21']"));
		calcularValorColumna($('#TX_T1T_22'),$("[data-identify='TX_T1_22']"));
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			endDate: '+0d',
			autoclose: true,
		});
	});
	//

	$('#a-delete-item-1').on('click', function(e){
		e.preventDefault();
		if (rowNumb1 > 1) {
			rowNumb1--;
			table_items_proyeccion_1.row($( "#table_items_proyeccion_1 tr").eq(-1)).remove().draw();
			table_items_proyeccion_1.row.add( [
				'TOTAL',
				'',
				'',
				'',
				'',
				'<input style="width:99%" id="TX_T1T_3" data-identify="TX_T1T_3" name="TX_T1T_3_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_4" data-identify="TX_T1T_4" name="TX_T1T_4_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T1T_6" data-identify="TX_T1T_6" name="TX_T1T_6_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T1T_8" data-identify="TX_T1T_8" name="TX_T1T_8_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_85" data-identify="TX_T1T_85" name="TX_T1T_85_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_9" data-identify="TX_T1T_9" name="TX_T1T_9_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_10" data-identify="TX_T1T_10" name="TX_T1T_10_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_11" data-identify="TX_T1T_11" name="TX_T1T_11_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_12" data-identify="TX_T1T_12" name="TX_T1T_12_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_13" data-identify="TX_T1T_13" name="TX_T1T_13_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_14" data-identify="TX_T1T_14" name="TX_T1T_14_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_15" data-identify="TX_T1T_15" name="TX_T1T_15_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_16" data-identify="TX_T1T_16" name="TX_T1T_16_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_17" data-identify="TX_T1T_17" name="TX_T1T_17_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_18" data-identify="TX_T1T_18" name="TX_T1T_18_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_19" data-identify="TX_T1T_19" name="TX_T1T_19_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_20" data-identify="TX_T1T_20" name="TX_T1T_20_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_21" data-identify="TX_T1T_21" name="TX_T1T_21_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T1T_22" data-identify="TX_T1T_22" name="TX_T1T_22_'+rowNumb1+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_items_proyeccion_1.row($( "#table_items_proyeccion_1 tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_T1T_3'),$("[data-identify='TX_T1_3']"));
			calcularValorColumna($('#TX_T1T_4'),$("[data-identify='TX_T1_4']"));
			calcularValorColumna($('#TX_T1T_6'),$("[data-identify='TX_T1_6']"));
			calcularValorColumna($('#TX_T1T_8'),$("[data-identify='TX_T1_8']"));
			calcularValorColumna($('#TX_T1T_85'),$("[data-identify='TX_T1_85']"));
			calcularValorColumna($('#TX_T1T_9'),$("[data-identify='TX_T1_9']"));
			calcularValorColumna($('#TX_T1T_10'),$("[data-identify='TX_T1_10']"));
			calcularValorColumna($('#TX_T1T_11'),$("[data-identify='TX_T1_11']"));
			calcularValorColumna($('#TX_T1T_12'),$("[data-identify='TX_T1_12']"));
			calcularValorColumna($('#TX_T1T_13'),$("[data-identify='TX_T1_13']"));
			calcularValorColumna($('#TX_T1T_14'),$("[data-identify='TX_T1_14']"));
			calcularValorColumna($('#TX_T1T_15'),$("[data-identify='TX_T1_15']"));
			calcularValorColumna($('#TX_T1T_16'),$("[data-identify='TX_T1_16']"));
			calcularValorColumna($('#TX_T1T_17'),$("[data-identify='TX_T1_17']"));
			calcularValorColumna($('#TX_T1T_18'),$("[data-identify='TX_T1_18']"));
			calcularValorColumna($('#TX_T1T_19'),$("[data-identify='TX_T1_19']"));
			calcularValorColumna($('#TX_T1T_20'),$("[data-identify='TX_T1_20']"));
			calcularValorColumna($('#TX_T1T_21'),$("[data-identify='TX_T1_21']"));
			calcularValorColumna($('#TX_T1T_22'),$("[data-identify='TX_T1_22']"));
			actualizarTotales();
		}
	});
$('#a-add-item-1').click();

$( "#table_items_proyeccion_1" ).delegate( "input", "change", function() {
	if ($( this ).val() == '' && !$(this).hasClass('datepicker-class') ) $( this ).val(0);
		// if (!$( this ).hasClass( "change-event" )) $( this ).val(formatMoney(parseFloat($( this ).val()),"$"));
		var tableSelected = $("#table_items_proyeccion_1");
		if ($( this ).attr('data-identify') == 'TX_T1_3' ) {
			calcularValorColumna($('#TX_T1T_3'),$("[data-identify='TX_T1_3']"));
			calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_T1T_8'),$("[data-identify='TX_T1_8']"));
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_4' ) {
			calcularValorColumna($('#TX_T1T_4'),$("[data-identify='TX_T1_4']"));
			calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_T1T_8'),$("[data-identify='TX_T1_8']"));
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_6' ) {
			calcularValorColumna($('#TX_T1T_6'),$("[data-identify='TX_T1_6']"));
			calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_T1T_8'),$("[data-identify='TX_T1_8']"));
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}

		if ($( this ).attr('data-identify') == 'TX_T1_8' ) { 
			calcularValorColumna($('#TX_T1T_8'),$("[data-identify='TX_T1_8']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_85' ) {
			calcularValorColumna($('#TX_T1T_85'),$("[data-identify='TX_T1_85']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_9' ) {
			calcularValorColumna($('#TX_T1T_9'),$("[data-identify='TX_T1_9']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_10' ) {
			calcularValorColumna($('#TX_T1T_10'),$("[data-identify='TX_T1_10']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_11' ) {
			calcularValorColumna($('#TX_T1T_11'),$("[data-identify='TX_T1_11']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_12' ) {
			calcularValorColumna($('#TX_T1T_12'),$("[data-identify='TX_T1_12']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_13' ) {
			calcularValorColumna($('#TX_T1T_13'),$("[data-identify='TX_T1_13']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_14' ) {
			calcularValorColumna($('#TX_T1T_14'),$("[data-identify='TX_T1_14']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_15' ) {
			calcularValorColumna($('#TX_T1T_15'),$("[data-identify='TX_T1_15']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_16' ) {
			calcularValorColumna($('#TX_T1T_16'),$("[data-identify='TX_T1_16']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_17' ) {
			calcularValorColumna($('#TX_T1T_17'),$("[data-identify='TX_T1_17']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_18' ) {
			calcularValorColumna($('#TX_T1T_18'),$("[data-identify='TX_T1_18']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_19' ) {
			calcularValorColumna($('#TX_T1T_19'),$("[data-identify='TX_T1_19']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_20' ) {
			calcularValorColumna($('#TX_T1T_20'),$("[data-identify='TX_T1_20']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_21' ) {
			calcularValorColumna($('#TX_T1T_21'),$("[data-identify='TX_T1_21']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T1_22' ) {
			calcularValorColumna($('#TX_T1T_22'),$("[data-identify='TX_T1_22']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		calcularSaldoFila(tableSelected,rowNumb1);
		calcularDisponibleFila(tableSelected,rowNumb1);
		actualizarTotales();
	});
	//


	var rowNumb2 = 0;
	var table_items_proyeccion_2 = $("#table_items_proyeccion_2").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});
	$('#a-add-item-2').on('click', function(e){
		e.preventDefault();
		rowNumb2++;
		table_items_proyeccion_2.row($( "#table_items_proyeccion_2 tr").eq(-1)).remove().draw();
		table_items_proyeccion_2.row.add( [
			rowNumb2,
			'<input required style="width:99%" id="TX_T2_1" data-identify="TX_T2_1" name="TX_T2_1_'+rowNumb2+'" type="text" maxlength="100">',
			'<select style="width: 99%;" id="SL_T2_2" data-identify="SL_T2_2" name="SL_T2_2_'+rowNumb2+'" title="Seleccionar Item" required>'
			+selectItems()+	'</select>',
			'<input required style="width:99%" value="0" id="TX_T2_25" data-identify="TX_T2_25" name="TX_T2_25_'+rowNumb2+'" type="number" min="1">',
			'<input required style="width:99%" id="TX_T2_26" data-identify="TX_T2_26" name="TX_T2_26_'+rowNumb2+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T2_3" data-identify="TX_T2_3" name="TX_T2_3_'+rowNumb2+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T2_4" data-identify="TX_T2_4" name="TX_T2_4_'+rowNumb2+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T2_5" data-identify="TX_T2_5" name="TX_T2_5_'+rowNumb2+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T2_6" data-identify="TX_T2_6" name="TX_T2_6_'+rowNumb2+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T2_7" data-identify="TX_T2_7" name="TX_T2_7_'+rowNumb2+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T2_8" data-identify="TX_T2_8" name="TX_T2_8_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_85" data-identify="TX_T2_85" name="TX_T2_85_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_9" data-identify="TX_T2_9" name="TX_T2_9_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_10" data-identify="TX_T2_10" name="TX_T2_10_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_11" data-identify="TX_T2_11" name="TX_T2_11_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_12" data-identify="TX_T2_12" name="TX_T2_12_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_13" data-identify="TX_T2_13" name="TX_T2_13_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_14" data-identify="TX_T2_14" name="TX_T2_14_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_15" data-identify="TX_T2_15" name="TX_T2_15_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_16" data-identify="TX_T2_16" name="TX_T2_16_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_17" data-identify="TX_T2_17" name="TX_T2_17_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_18" data-identify="TX_T2_18" name="TX_T2_18_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_19" data-identify="TX_T2_19" name="TX_T2_19_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_20" data-identify="TX_T2_20" name="TX_T2_20_'+rowNumb2+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_21" data-identify="TX_T2_21" name="TX_T2_21_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T2_22" data-identify="TX_T2_22" name="TX_T2_22_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_items_proyeccion_2.row.add( [
			'TOTAL',
			'',
			'',
			'',
			'',
			'<input style="width:99%" id="TX_T2T_3" data-identify="TX_T2T_3" name="TX_T2T_3_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_4" data-identify="TX_T2T_4" name="TX_T2T_4_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T2T_6" data-identify="TX_T2T_6" name="TX_T2T_6_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T2T_8" data-identify="TX_T2T_8" name="TX_T2T_8_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_85" data-identify="TX_T2T_85" name="TX_T2T_85_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_9" data-identify="TX_T2T_9" name="TX_T2T_9_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_10" data-identify="TX_T2T_10" name="TX_T2T_10_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_11" data-identify="TX_T2T_11" name="TX_T2T_11_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_12" data-identify="TX_T2T_12" name="TX_T2T_12_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_13" data-identify="TX_T2T_13" name="TX_T2T_13_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_14" data-identify="TX_T2T_14" name="TX_T2T_14_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_15" data-identify="TX_T2T_15" name="TX_T2T_15_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_16" data-identify="TX_T2T_16" name="TX_T2T_16_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_17" data-identify="TX_T2T_17" name="TX_T2T_17_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_18" data-identify="TX_T2T_18" name="TX_T2T_18_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_19" data-identify="TX_T2T_19" name="TX_T2T_19_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_20" data-identify="TX_T2T_20" name="TX_T2T_20_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_21" data-identify="TX_T2T_21" name="TX_T2T_21_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T2T_22" data-identify="TX_T2T_22" name="TX_T2T_22_'+rowNumb2+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_T2T_3'),$("[data-identify='TX_T2_3']"));
		calcularValorColumna($('#TX_T2T_4'),$("[data-identify='TX_T2_4']"));
		calcularValorColumna($('#TX_T2T_6'),$("[data-identify='TX_T2_6']"));
		calcularValorColumna($('#TX_T2T_8'),$("[data-identify='TX_T2_8']"));
		calcularValorColumna($('#TX_T2T_85'),$("[data-identify='TX_T2_85']"));
		calcularValorColumna($('#TX_T2T_9'),$("[data-identify='TX_T2_9']"));
		calcularValorColumna($('#TX_T2T_10'),$("[data-identify='TX_T2_10']"));
		calcularValorColumna($('#TX_T2T_11'),$("[data-identify='TX_T2_11']"));
		calcularValorColumna($('#TX_T2T_12'),$("[data-identify='TX_T2_12']"));
		calcularValorColumna($('#TX_T2T_13'),$("[data-identify='TX_T2_13']"));
		calcularValorColumna($('#TX_T2T_14'),$("[data-identify='TX_T2_14']"));
		calcularValorColumna($('#TX_T2T_15'),$("[data-identify='TX_T2_15']"));
		calcularValorColumna($('#TX_T2T_16'),$("[data-identify='TX_T2_16']"));
		calcularValorColumna($('#TX_T2T_17'),$("[data-identify='TX_T2_17']"));
		calcularValorColumna($('#TX_T2T_18'),$("[data-identify='TX_T2_18']"));
		calcularValorColumna($('#TX_T2T_19'),$("[data-identify='TX_T2_19']"));
		calcularValorColumna($('#TX_T2T_20'),$("[data-identify='TX_T2_20']"));
		calcularValorColumna($('#TX_T2T_21'),$("[data-identify='TX_T2_21']"));
		calcularValorColumna($('#TX_T2T_22'),$("[data-identify='TX_T2_22']"));
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			endDate: '+0d',
			autoclose: true,
		});
	});
	//

	$('#a-delete-item-2').on('click', function(e){
		e.preventDefault();
		if (rowNumb2 > 1) {
			rowNumb2--;
			table_items_proyeccion_2.row($( "#table_items_proyeccion_2 tr").eq(-1)).remove().draw();
			table_items_proyeccion_2.row.add( [
				'TOTAL',
				'',
				'',
				'',
				'',
				'<input style="width:99%" id="TX_T2T_3" data-identify="TX_T2T_3" name="TX_T2T_3_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_4" data-identify="TX_T2T_4" name="TX_T2T_4_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T2T_6" data-identify="TX_T2T_6" name="TX_T2T_6_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T2T_8" data-identify="TX_T2T_8" name="TX_T2T_8_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_85" data-identify="TX_T2T_85" name="TX_T2T_85_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_9" data-identify="TX_T2T_9" name="TX_T2T_9_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_10" data-identify="TX_T2T_10" name="TX_T2T_10_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_11" data-identify="TX_T2T_11" name="TX_T2T_11_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_12" data-identify="TX_T2T_12" name="TX_T2T_12_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_13" data-identify="TX_T2T_13" name="TX_T2T_13_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_14" data-identify="TX_T2T_14" name="TX_T2T_14_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_15" data-identify="TX_T2T_15" name="TX_T2T_15_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_16" data-identify="TX_T2T_16" name="TX_T2T_16_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_17" data-identify="TX_T2T_17" name="TX_T2T_17_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_18" data-identify="TX_T2T_18" name="TX_T2T_18_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_19" data-identify="TX_T2T_19" name="TX_T2T_19_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_20" data-identify="TX_T2T_20" name="TX_T2T_20_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_21" data-identify="TX_T2T_21" name="TX_T2T_21_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T2T_22" data-identify="TX_T2T_22" name="TX_T2T_22_'+rowNumb2+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_items_proyeccion_2.row($( "#table_items_proyeccion_2 tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_T2T_3'),$("[data-identify='TX_T2_3']"));
			calcularValorColumna($('#TX_T2T_4'),$("[data-identify='TX_T2_4']"));
			calcularValorColumna($('#TX_T2T_6'),$("[data-identify='TX_T2_6']"));
			calcularValorColumna($('#TX_T2T_8'),$("[data-identify='TX_T2_8']"));
			calcularValorColumna($('#TX_T2T_85'),$("[data-identify='TX_T2_85']"));
			calcularValorColumna($('#TX_T2T_9'),$("[data-identify='TX_T2_9']"));
			calcularValorColumna($('#TX_T2T_10'),$("[data-identify='TX_T2_10']"));
			calcularValorColumna($('#TX_T2T_11'),$("[data-identify='TX_T2_11']"));
			calcularValorColumna($('#TX_T2T_12'),$("[data-identify='TX_T2_12']"));
			calcularValorColumna($('#TX_T2T_13'),$("[data-identify='TX_T2_13']"));
			calcularValorColumna($('#TX_T2T_14'),$("[data-identify='TX_T2_14']"));
			calcularValorColumna($('#TX_T2T_15'),$("[data-identify='TX_T2_15']"));
			calcularValorColumna($('#TX_T2T_16'),$("[data-identify='TX_T2_16']"));
			calcularValorColumna($('#TX_T2T_17'),$("[data-identify='TX_T2_17']"));
			calcularValorColumna($('#TX_T2T_18'),$("[data-identify='TX_T2_18']"));
			calcularValorColumna($('#TX_T2T_19'),$("[data-identify='TX_T2_19']"));
			calcularValorColumna($('#TX_T2T_20'),$("[data-identify='TX_T2_20']"));
			calcularValorColumna($('#TX_T2T_21'),$("[data-identify='TX_T2_21']"));
			calcularValorColumna($('#TX_T2T_22'),$("[data-identify='TX_T2_22']"));
			actualizarTotales();
		}
	});
$('#a-add-item-2').click();

$( "#table_items_proyeccion_2" ).delegate( "input", "change", function() {
	if ($( this ).val() == '' && !$(this).hasClass('datepicker-class') ) $( this ).val(0);
		// if (!$( this ).hasClass( "change-event" )) $( this ).val(formatMoney(parseFloat($( this ).val()),"$"));
		var tableSelected = $("#table_items_proyeccion_2");
		if ($( this ).attr('data-identify') == 'TX_T2_3' ) {
			calcularValorColumna($('#TX_T2T_3'),$("[data-identify='TX_T2_3']"));
			calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_T2T_8'),$("[data-identify='TX_T2_8']"));
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_4' ) {
			calcularValorColumna($('#TX_T2T_4'),$("[data-identify='TX_T2_4']"));
			calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_T2T_8'),$("[data-identify='TX_T2_8']"));
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_6' ) {
			calcularValorColumna($('#TX_T2T_6'),$("[data-identify='TX_T2_6']"));
			calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularValorColumna($('#TX_T2T_8'),$("[data-identify='TX_T2_8']"));
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_8' ) {
			calcularValorColumna($('#TX_T2T_8'),$("[data-identify='TX_T2_8']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_85' ) {
			calcularValorColumna($('#TX_T2T_85'),$("[data-identify='TX_T2_85']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_9' ) {
			calcularValorColumna($('#TX_T2T_9'),$("[data-identify='TX_T2_9']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_10' ) {
			calcularValorColumna($('#TX_T2T_10'),$("[data-identify='TX_T2_10']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_11' ) {
			calcularValorColumna($('#TX_T2T_11'),$("[data-identify='TX_T2_11']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_12' ) {
			calcularValorColumna($('#TX_T2T_12'),$("[data-identify='TX_T2_12']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_13' ) {
			calcularValorColumna($('#TX_T2T_13'),$("[data-identify='TX_T2_13']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_14' ) {
			calcularValorColumna($('#TX_T2T_14'),$("[data-identify='TX_T2_14']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_15' ) {
			calcularValorColumna($('#TX_T2T_15'),$("[data-identify='TX_T2_15']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_16' ) {
			calcularValorColumna($('#TX_T2T_16'),$("[data-identify='TX_T2_16']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_17' ) {
			calcularValorColumna($('#TX_T2T_17'),$("[data-identify='TX_T2_17']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_18' ) {
			calcularValorColumna($('#TX_T2T_18'),$("[data-identify='TX_T2_18']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_19' ) {
			calcularValorColumna($('#TX_T2T_19'),$("[data-identify='TX_T2_19']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_20' ) {
			calcularValorColumna($('#TX_T2T_20'),$("[data-identify='TX_T2_20']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_21' ) {
			calcularValorColumna($('#TX_T2T_21'),$("[data-identify='TX_T2_21']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		if ($( this ).attr('data-identify') == 'TX_T2_22' ) {
			calcularValorColumna($('#TX_T2T_22'),$("[data-identify='TX_T2_22']"));
			calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
			calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		}
		calcularSaldoFila(tableSelected,rowNumb2);
		calcularDisponibleFila(tableSelected,rowNumb2);
		actualizarTotales();
	});
	//


	var rowNumb3 = 0;
	var table_items_proyeccion_3 = $("#table_items_proyeccion_3").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});
	$('#a-add-item-3').on('click', function(e){
		e.preventDefault();
		rowNumb3++;
		table_items_proyeccion_3.row($( "#table_items_proyeccion_3 tr").eq(-1)).remove().draw()	;
		table_items_proyeccion_3.row.add( [
			rowNumb3,
			'<input required style="width:99%" id="TX_T3_1" data-identify="TX_T3_1" name="TX_T3_1_'+rowNumb3+'" type="text" maxlength="100">',
			'<select style="width: 99%;" id="SL_T3_2" data-identify="SL_T3_2" name="SL_T3_2_'+rowNumb3+'" title="Seleccionar Item">'
			+selectItems()+	'</select>',
			'<input required style="width:99%" value="0" id="TX_T3_25" data-identify="TX_T3_25" name="TX_T3_25_'+rowNumb3+'" type="number" min="1">',
			'<input required style="width:99%" id="TX_T3_26" data-identify="TX_T3_26" name="TX_T3_26_'+rowNumb3+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T3_3" data-identify="TX_T3_3" name="TX_T3_3_'+rowNumb3+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T3_4" data-identify="TX_T3_4" name="TX_T3_4_'+rowNumb3+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T3_5" data-identify="TX_T3_5" name="TX_T3_5_'+rowNumb3+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T3_6" data-identify="TX_T3_6" name="TX_T3_6_'+rowNumb3+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T3_7" data-identify="TX_T3_7" name="TX_T3_7_'+rowNumb3+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T3_8" data-identify="TX_T3_8" name="TX_T3_8_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_85" data-identify="TX_T3_85" name="TX_T3_85_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_9" data-identify="TX_T3_9" name="TX_T3_9_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_10" data-identify="TX_T3_10" name="TX_T3_10_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_11" data-identify="TX_T3_11" name="TX_T3_11_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_12" data-identify="TX_T3_12" name="TX_T3_12_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_13" data-identify="TX_T3_13" name="TX_T3_13_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_14" data-identify="TX_T3_14" name="TX_T3_14_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_15" data-identify="TX_T3_15" name="TX_T3_15_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_16" data-identify="TX_T3_16" name="TX_T3_16_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_17" data-identify="TX_T3_17" name="TX_T3_17_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_18" data-identify="TX_T3_18" name="TX_T3_18_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_19" data-identify="TX_T3_19" name="TX_T3_19_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_20" data-identify="TX_T3_20" name="TX_T3_20_'+rowNumb3+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_21" data-identify="TX_T3_21" name="TX_T3_21_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T3_22" data-identify="TX_T3_22" name="TX_T3_22_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_items_proyeccion_3.row.add( [
			'TOTAL',
			'',
			'',
			'',
			'',
			'<input style="width:99%" id="TX_T3T_3" data-identify="TX_T3T_3" name="TX_T3T_3_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_4" data-identify="TX_T3T_4" name="TX_T3T_4_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T3T_6" data-identify="TX_T3T_6" name="TX_T3T_6_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T3T_8" data-identify="TX_T3T_8" name="TX_T3T_8_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_85" data-identify="TX_T3T_85" name="TX_T3T_85_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_9" data-identify="TX_T3T_9" name="TX_T3T_9_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_10" data-identify="TX_T3T_10" name="TX_T3T_10_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_11" data-identify="TX_T3T_11" name="TX_T3T_11_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_12" data-identify="TX_T3T_12" name="TX_T3T_12_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_13" data-identify="TX_T3T_13" name="TX_T3T_13_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_14" data-identify="TX_T3T_14" name="TX_T3T_14_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_15" data-identify="TX_T3T_15" name="TX_T3T_15_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_16" data-identify="TX_T3T_16" name="TX_T3T_16_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_17" data-identify="TX_T3T_17" name="TX_T3T_17_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_18" data-identify="TX_T3T_18" name="TX_T3T_18_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_19" data-identify="TX_T3T_19" name="TX_T3T_19_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_20" data-identify="TX_T3T_20" name="TX_T3T_20_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_21" data-identify="TX_T3T_21" name="TX_T3T_21_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T3T_22" data-identify="TX_T3T_22" name="TX_T3T_22_'+rowNumb3+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_T3T_3'),$("[data-identify='TX_T3_3']"));
		calcularValorColumna($('#TX_T3T_4'),$("[data-identify='TX_T3_4']"));
		calcularValorColumna($('#TX_T3T_6'),$("[data-identify='TX_T3_6']"));
		calcularValorColumna($('#TX_T3T_8'),$("[data-identify='TX_T3_8']"));
		calcularValorColumna($('#TX_T3T_85'),$("[data-identify='TX_T3_85']"));
		calcularValorColumna($('#TX_T3T_9'),$("[data-identify='TX_T3_9']"));
		calcularValorColumna($('#TX_T3T_10'),$("[data-identify='TX_T3_10']"));
		calcularValorColumna($('#TX_T3T_11'),$("[data-identify='TX_T3_11']"));
		calcularValorColumna($('#TX_T3T_12'),$("[data-identify='TX_T3_12']"));
		calcularValorColumna($('#TX_T3T_13'),$("[data-identify='TX_T3_13']"));
		calcularValorColumna($('#TX_T3T_14'),$("[data-identify='TX_T3_14']"));
		calcularValorColumna($('#TX_T3T_15'),$("[data-identify='TX_T3_15']"));
		calcularValorColumna($('#TX_T3T_16'),$("[data-identify='TX_T3_16']"));
		calcularValorColumna($('#TX_T3T_17'),$("[data-identify='TX_T3_17']"));
		calcularValorColumna($('#TX_T3T_18'),$("[data-identify='TX_T3_18']"));
		calcularValorColumna($('#TX_T3T_19'),$("[data-identify='TX_T3_19']"));
		calcularValorColumna($('#TX_T3T_20'),$("[data-identify='TX_T3_20']"));
		calcularValorColumna($('#TX_T3T_21'),$("[data-identify='TX_T3_21']"));
		calcularValorColumna($('#TX_T3T_22'),$("[data-identify='TX_T3_22']"));
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			endDate: '+0d',
			autoclose: true,
		});
	});
	//

	$('#a-delete-item-3').on('click', function(e){
		e.preventDefault();
		if (rowNumb3 > 1) {
			rowNumb3--;
			table_items_proyeccion_3.row($( "#table_items_proyeccion_3 tr").eq(-1)).remove().draw();
			table_items_proyeccion_3.row.add( [
				'TOTAL',
				'',
				'',
				'',
				'',
				'<input style="width:99%" id="TX_T3T_3" data-identify="TX_T3T_3" name="TX_T3T_3_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_4" data-identify="TX_T3T_4" name="TX_T3T_4_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T3T_6" data-identify="TX_T3T_6" name="TX_T3T_6_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T3T_8" data-identify="TX_T3T_8" name="TX_T3T_8_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_85" data-identify="TX_T3T_85" name="TX_T3T_85_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_9" data-identify="TX_T3T_9" name="TX_T3T_9_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_10" data-identify="TX_T3T_10" name="TX_T3T_10_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_11" data-identify="TX_T3T_11" name="TX_T3T_11_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_12" data-identify="TX_T3T_12" name="TX_T3T_12_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_13" data-identify="TX_T3T_13" name="TX_T3T_13_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_14" data-identify="TX_T3T_14" name="TX_T3T_14_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_15" data-identify="TX_T3T_15" name="TX_T3T_15_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_16" data-identify="TX_T3T_16" name="TX_T3T_16_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_17" data-identify="TX_T3T_17" name="TX_T3T_17_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_18" data-identify="TX_T3T_18" name="TX_T3T_18_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_19" data-identify="TX_T3T_19" name="TX_T3T_19_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_20" data-identify="TX_T3T_20" name="TX_T3T_20_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_21" data-identify="TX_T3T_21" name="TX_T3T_21_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T3T_22" data-identify="TX_T3T_22" name="TX_T3T_22_'+rowNumb3+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_items_proyeccion_3.row($( "#table_items_proyeccion_3 tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_T3T_3'),$("[data-identify='TX_T3_3']"));
			calcularValorColumna($('#TX_T3T_4'),$("[data-identify='TX_T3_4']"));
			calcularValorColumna($('#TX_T3T_6'),$("[data-identify='TX_T3_6']"));
			calcularValorColumna($('#TX_T3T_8'),$("[data-identify='TX_T3_8']"));
			calcularValorColumna($('#TX_T3T_85'),$("[data-identify='TX_T3_85']"));
			calcularValorColumna($('#TX_T3T_9'),$("[data-identify='TX_T3_9']"));
			calcularValorColumna($('#TX_T3T_10'),$("[data-identify='TX_T3_10']"));
			calcularValorColumna($('#TX_T3T_11'),$("[data-identify='TX_T3_11']"));
			calcularValorColumna($('#TX_T3T_12'),$("[data-identify='TX_T3_12']"));
			calcularValorColumna($('#TX_T3T_13'),$("[data-identify='TX_T3_13']"));
			calcularValorColumna($('#TX_T3T_14'),$("[data-identify='TX_T3_14']"));
			calcularValorColumna($('#TX_T3T_15'),$("[data-identify='TX_T3_15']"));
			calcularValorColumna($('#TX_T3T_16'),$("[data-identify='TX_T3_16']"));
			calcularValorColumna($('#TX_T3T_17'),$("[data-identify='TX_T3_17']"));
			calcularValorColumna($('#TX_T3T_18'),$("[data-identify='TX_T3_18']"));
			calcularValorColumna($('#TX_T3T_19'),$("[data-identify='TX_T3_19']"));
			calcularValorColumna($('#TX_T3T_20'),$("[data-identify='TX_T3_20']"));
			calcularValorColumna($('#TX_T3T_21'),$("[data-identify='TX_T3_21']"));
			calcularValorColumna($('#TX_T3T_22'),$("[data-identify='TX_T3_22']"));
			actualizarTotales();
		}
	});
$('#a-add-item-3').click();

$( "#table_items_proyeccion_3" ).delegate( "input", "change", function() {
	if ($( this ).val() == '' && !$(this).hasClass('datepicker-class') ) $( this ).val(0);
	var tableSelected = $("#table_items_proyeccion_3");
	if ($( this ).attr('data-identify') == 'TX_T3_3' ) {
		calcularValorColumna($('#TX_T3T_3'),$("[data-identify='TX_T3_3']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T3T_8'),$("[data-identify='TX_T3_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_4' ) {
		calcularValorColumna($('#TX_T3T_4'),$("[data-identify='TX_T3_4']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T3T_8'),$("[data-identify='TX_T3_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_6' ) {
		calcularValorColumna($('#TX_T3T_6'),$("[data-identify='TX_T3_6']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T3T_8'),$("[data-identify='TX_T3_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_8' ) {
		calcularValorColumna($('#TX_T3T_8'),$("[data-identify='TX_T3_8']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_85' ) {
		calcularValorColumna($('#TX_T3T_85'),$("[data-identify='TX_T3_85']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_9' ) {
		calcularValorColumna($('#TX_T3T_9'),$("[data-identify='TX_T3_9']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_10' ) {
		calcularValorColumna($('#TX_T3T_10'),$("[data-identify='TX_T3_10']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_11' ) {
		calcularValorColumna($('#TX_T3T_11'),$("[data-identify='TX_T3_11']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_12' ) {
		calcularValorColumna($('#TX_T3T_12'),$("[data-identify='TX_T3_12']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_13' ) {
		calcularValorColumna($('#TX_T3T_13'),$("[data-identify='TX_T3_13']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_14' ) {
		calcularValorColumna($('#TX_T3T_14'),$("[data-identify='TX_T3_14']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_15' ) {
		calcularValorColumna($('#TX_T3T_15'),$("[data-identify='TX_T3_15']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_16' ) {
		calcularValorColumna($('#TX_T3T_16'),$("[data-identify='TX_T3_16']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_17' ) {
		calcularValorColumna($('#TX_T3T_17'),$("[data-identify='TX_T3_17']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_18' ) {
		calcularValorColumna($('#TX_T3T_18'),$("[data-identify='TX_T3_18']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_19' ) {
		calcularValorColumna($('#TX_T3T_19'),$("[data-identify='TX_T3_19']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_20' ) {
		calcularValorColumna($('#TX_T3T_20'),$("[data-identify='TX_T3_20']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_21' ) {
		calcularValorColumna($('#TX_T3T_21'),$("[data-identify='TX_T3_21']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T3_22' ) {
		calcularValorColumna($('#TX_T3T_22'),$("[data-identify='TX_T3_22']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	calcularSaldoFila(tableSelected,rowNumb3);
	calcularDisponibleFila(tableSelected,rowNumb3);
	actualizarTotales();
});
	//


	var rowNumb4 = 0;
	var table_items_proyeccion_4 = $("#table_items_proyeccion_4").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});
	$('#a-add-item-4').on('click', function(e){
		e.preventDefault();
		rowNumb4++;
		table_items_proyeccion_4.row($( "#table_items_proyeccion_4 tr").eq(-1)).remove().draw()	;
		table_items_proyeccion_4.row.add( [
			rowNumb4,
			'<input required style="width:99%" id="TX_T4_1" data-identify="TX_T4_1" name="TX_T4_1_'+rowNumb4+'" type="text" maxlength="100">',
			'<select style="width: 99%;" id="SL_T4_2" data-identify="SL_T4_2" name="SL_T4_2_'+rowNumb4+'" title="Seleccionar Item">'
			+selectItems()+	'</select>',
			'<input required style="width:99%" value="0" id="TX_T4_25" data-identify="TX_T4_25" name="TX_T4_25_'+rowNumb4+'" type="number" min="1">',
			'<input required style="width:99%" id="TX_T4_26" data-identify="TX_T4_26" name="TX_T4_26_'+rowNumb4+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T4_3" data-identify="TX_T4_3" name="TX_T4_3_'+rowNumb4+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T4_4" data-identify="TX_T4_4" name="TX_T4_4_'+rowNumb4+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T4_5" data-identify="TX_T4_5" name="TX_T4_5_'+rowNumb4+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T4_6" data-identify="TX_T4_6" name="TX_T4_6_'+rowNumb4+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T4_7" data-identify="TX_T4_7" name="TX_T4_7_'+rowNumb4+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T4_8" data-identify="TX_T4_8" name="TX_T4_8_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_85" data-identify="TX_T4_85" name="TX_T4_85_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_9" data-identify="TX_T4_9" name="TX_T4_9_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_10" data-identify="TX_T4_10" name="TX_T4_10_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_11" data-identify="TX_T4_11" name="TX_T4_11_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_12" data-identify="TX_T4_12" name="TX_T4_12_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_13" data-identify="TX_T4_13" name="TX_T4_13_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_14" data-identify="TX_T4_14" name="TX_T4_14_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_15" data-identify="TX_T4_15" name="TX_T4_15_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_16" data-identify="TX_T4_16" name="TX_T4_16_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_17" data-identify="TX_T4_17" name="TX_T4_17_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_18" data-identify="TX_T4_18" name="TX_T4_18_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_19" data-identify="TX_T4_19" name="TX_T4_19_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_20" data-identify="TX_T4_20" name="TX_T4_20_'+rowNumb4+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_21" data-identify="TX_T4_21" name="TX_T4_21_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T4_22" data-identify="TX_T4_22" name="TX_T4_22_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_items_proyeccion_4.row.add( [
			'TOTAL',
			'',
			'',
			'',
			'',
			'<input style="width:99%" id="TX_T4T_3" data-identify="TX_T4T_3" name="TX_T4T_3_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_4" data-identify="TX_T4T_4" name="TX_T4T_4_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T4T_6" data-identify="TX_T4T_6" name="TX_T4T_6_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T4T_8" data-identify="TX_T4T_8" name="TX_T4T_8_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_85" data-identify="TX_T4T_85" name="TX_T4T_85_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_9" data-identify="TX_T4T_9" name="TX_T4T_9_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_10" data-identify="TX_T4T_10" name="TX_T4T_10_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_11" data-identify="TX_T4T_11" name="TX_T4T_11_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_12" data-identify="TX_T4T_12" name="TX_T4T_12_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_13" data-identify="TX_T4T_13" name="TX_T4T_13_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_14" data-identify="TX_T4T_14" name="TX_T4T_14_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_15" data-identify="TX_T4T_15" name="TX_T4T_15_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_16" data-identify="TX_T4T_16" name="TX_T4T_16_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_17" data-identify="TX_T4T_17" name="TX_T4T_17_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_18" data-identify="TX_T4T_18" name="TX_T4T_18_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_19" data-identify="TX_T4T_19" name="TX_T4T_19_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_20" data-identify="TX_T4T_20" name="TX_T4T_20_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_21" data-identify="TX_T4T_21" name="TX_T4T_21_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T4T_22" data-identify="TX_T4T_22" name="TX_T4T_22_'+rowNumb4+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_T4T_3'),$("[data-identify='TX_T4_3']"));
		calcularValorColumna($('#TX_T4T_4'),$("[data-identify='TX_T4_4']"));
		calcularValorColumna($('#TX_T4T_6'),$("[data-identify='TX_T4_6']"));
		calcularValorColumna($('#TX_T4T_8'),$("[data-identify='TX_T4_8']"));
		calcularValorColumna($('#TX_T4T_85'),$("[data-identify='TX_T4_85']"));
		calcularValorColumna($('#TX_T4T_9'),$("[data-identify='TX_T4_9']"));
		calcularValorColumna($('#TX_T4T_10'),$("[data-identify='TX_T4_10']"));
		calcularValorColumna($('#TX_T4T_11'),$("[data-identify='TX_T4_11']"));
		calcularValorColumna($('#TX_T4T_12'),$("[data-identify='TX_T4_12']"));
		calcularValorColumna($('#TX_T4T_13'),$("[data-identify='TX_T4_13']"));
		calcularValorColumna($('#TX_T4T_14'),$("[data-identify='TX_T4_14']"));
		calcularValorColumna($('#TX_T4T_15'),$("[data-identify='TX_T4_15']"));
		calcularValorColumna($('#TX_T4T_16'),$("[data-identify='TX_T4_16']"));
		calcularValorColumna($('#TX_T4T_17'),$("[data-identify='TX_T4_17']"));
		calcularValorColumna($('#TX_T4T_18'),$("[data-identify='TX_T4_18']"));
		calcularValorColumna($('#TX_T4T_19'),$("[data-identify='TX_T4_19']"));
		calcularValorColumna($('#TX_T4T_20'),$("[data-identify='TX_T4_20']"));
		calcularValorColumna($('#TX_T4T_21'),$("[data-identify='TX_T4_21']"));
		calcularValorColumna($('#TX_T4T_22'),$("[data-identify='TX_T4_22']"));
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			endDate: '+0d',
			autoclose: true,
		});
	});
	//

	$('#a-delete-item-4').on('click', function(e){
		e.preventDefault();
		if (rowNumb4 > 1) {
			rowNumb4--;
			table_items_proyeccion_4.row($( "#table_items_proyeccion_4 tr").eq(-1)).remove().draw();
			table_items_proyeccion_4.row.add( [
				'TOTAL',
				'',
				'',
				'',
				'',
				'<input style="width:99%" id="TX_T4T_3" data-identify="TX_T4T_3" name="TX_T4T_3_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_4" data-identify="TX_T4T_4" name="TX_T4T_4_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T4T_6" data-identify="TX_T4T_6" name="TX_T4T_6_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T4T_8" data-identify="TX_T4T_8" name="TX_T4T_8_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_85" data-identify="TX_T4T_85" name="TX_T4T_85_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_9" data-identify="TX_T4T_9" name="TX_T4T_9_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_10" data-identify="TX_T4T_10" name="TX_T4T_10_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_11" data-identify="TX_T4T_11" name="TX_T4T_11_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_12" data-identify="TX_T4T_12" name="TX_T4T_12_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_13" data-identify="TX_T4T_13" name="TX_T4T_13_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_14" data-identify="TX_T4T_14" name="TX_T4T_14_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_15" data-identify="TX_T4T_15" name="TX_T4T_15_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_16" data-identify="TX_T4T_16" name="TX_T4T_16_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_17" data-identify="TX_T4T_17" name="TX_T4T_17_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_18" data-identify="TX_T4T_18" name="TX_T4T_18_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_19" data-identify="TX_T4T_19" name="TX_T4T_19_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_20" data-identify="TX_T4T_20" name="TX_T4T_20_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_21" data-identify="TX_T4T_21" name="TX_T4T_21_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T4T_22" data-identify="TX_T4T_22" name="TX_T4T_22_'+rowNumb4+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_items_proyeccion_4.row($( "#table_items_proyeccion_4 tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_T4T_3'),$("[data-identify='TX_T4_3']"));
			calcularValorColumna($('#TX_T4T_4'),$("[data-identify='TX_T4_4']"));
			calcularValorColumna($('#TX_T4T_6'),$("[data-identify='TX_T4_6']"));
			calcularValorColumna($('#TX_T4T_8'),$("[data-identify='TX_T4_8']"));
			calcularValorColumna($('#TX_T4T_85'),$("[data-identify='TX_T4_85']"));
			calcularValorColumna($('#TX_T4T_9'),$("[data-identify='TX_T4_9']"));
			calcularValorColumna($('#TX_T4T_10'),$("[data-identify='TX_T4_10']"));
			calcularValorColumna($('#TX_T4T_11'),$("[data-identify='TX_T4_11']"));
			calcularValorColumna($('#TX_T4T_12'),$("[data-identify='TX_T4_12']"));
			calcularValorColumna($('#TX_T4T_13'),$("[data-identify='TX_T4_13']"));
			calcularValorColumna($('#TX_T4T_14'),$("[data-identify='TX_T4_14']"));
			calcularValorColumna($('#TX_T4T_15'),$("[data-identify='TX_T4_15']"));
			calcularValorColumna($('#TX_T4T_16'),$("[data-identify='TX_T4_16']"));
			calcularValorColumna($('#TX_T4T_17'),$("[data-identify='TX_T4_17']"));
			calcularValorColumna($('#TX_T4T_18'),$("[data-identify='TX_T4_18']"));
			calcularValorColumna($('#TX_T4T_19'),$("[data-identify='TX_T4_19']"));
			calcularValorColumna($('#TX_T4T_20'),$("[data-identify='TX_T4_20']"));
			calcularValorColumna($('#TX_T4T_21'),$("[data-identify='TX_T4_21']"));
			calcularValorColumna($('#TX_T4T_22'),$("[data-identify='TX_T4_22']"));
			actualizarTotales();
		}
	});
$('#a-add-item-4').click();

$( "#table_items_proyeccion_4" ).delegate( "input", "change", function() {
	if ($( this ).val() == '' && !$(this).hasClass('datepicker-class') ) $( this ).val(0);
	var tableSelected = $("#table_items_proyeccion_4");
	if ($( this ).attr('data-identify') == 'TX_T4_3' ) {
		calcularValorColumna($('#TX_T4T_3'),$("[data-identify='TX_T4_3']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T4T_8'),$("[data-identify='TX_T4_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_4' ) {
		calcularValorColumna($('#TX_T4T_4'),$("[data-identify='TX_T4_4']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T4T_8'),$("[data-identify='TX_T4_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_6' ) {
		calcularValorColumna($('#TX_T4T_6'),$("[data-identify='TX_T4_6']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T4T_8'),$("[data-identify='TX_T4_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_8' ) {
		calcularValorColumna($('#TX_T4T_8'),$("[data-identify='TX_T4_8']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_85' ) {
		calcularValorColumna($('#TX_T4T_85'),$("[data-identify='TX_T4_85']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_9' ) {
		calcularValorColumna($('#TX_T4T_9'),$("[data-identify='TX_T4_9']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_10' ) {
		calcularValorColumna($('#TX_T4T_10'),$("[data-identify='TX_T4_10']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_11' ) {
		calcularValorColumna($('#TX_T4T_11'),$("[data-identify='TX_T4_11']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_12' ) {
		calcularValorColumna($('#TX_T4T_12'),$("[data-identify='TX_T4_12']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_13' ) {
		calcularValorColumna($('#TX_T4T_13'),$("[data-identify='TX_T4_13']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_14' ) {
		calcularValorColumna($('#TX_T4T_14'),$("[data-identify='TX_T4_14']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_15' ) {
		calcularValorColumna($('#TX_T4T_15'),$("[data-identify='TX_T4_15']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_16' ) {
		calcularValorColumna($('#TX_T4T_16'),$("[data-identify='TX_T4_16']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_17' ) {
		calcularValorColumna($('#TX_T4T_17'),$("[data-identify='TX_T4_17']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_18' ) {
		calcularValorColumna($('#TX_T4T_18'),$("[data-identify='TX_T4_18']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_19' ) {
		calcularValorColumna($('#TX_T4T_19'),$("[data-identify='TX_T4_19']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_20' ) {
		calcularValorColumna($('#TX_T4T_20'),$("[data-identify='TX_T4_20']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_21' ) {
		calcularValorColumna($('#TX_T4T_21'),$("[data-identify='TX_T4_21']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T4_22' ) {
		calcularValorColumna($('#TX_T4T_22'),$("[data-identify='TX_T4_22']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	calcularSaldoFila(tableSelected,rowNumb4);
	calcularDisponibleFila(tableSelected,rowNumb4);
	actualizarTotales();
});
	//

	var rowNumb5 = 0;
	var table_items_proyeccion_5 = $("#table_items_proyeccion_5").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});
	$('#a-add-item-5').on('click', function(e){
		e.preventDefault();
		rowNumb5++;
		table_items_proyeccion_5.row($( "#table_items_proyeccion_5 tr").eq(-1)).remove().draw();
		table_items_proyeccion_5.row.add( [
			rowNumb5,
			'<input required style="width:99%" id="TX_T5_1" data-identify="TX_T5_1" name="TX_T5_1_'+rowNumb5+'" type="text" maxlength="100">',
			'<select style="width: 99%;" id="SL_T5_2" data-identify="SL_T5_2" name="SL_T5_2_'+rowNumb5+'" title="Seleccionar Item">'
			+selectItems()+	'</select>',
			'<input required style="width:99%" value="0" id="TX_T5_25" data-identify="TX_T5_25" name="TX_T5_25_'+rowNumb5+'" type="number" min="1">',
			'<input required style="width:99%" id="TX_T5_26" data-identify="TX_T5_26" name="TX_T5_26_'+rowNumb5+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T5_3" data-identify="TX_T5_3" name="TX_T5_3_'+rowNumb5+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T5_4" data-identify="TX_T5_4" name="TX_T5_4_'+rowNumb5+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T5_5" data-identify="TX_T5_5" name="TX_T5_5_'+rowNumb5+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T5_6" data-identify="TX_T5_6" name="TX_T5_6_'+rowNumb5+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T5_7" data-identify="TX_T5_7" name="TX_T5_7_'+rowNumb5+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T5_8" data-identify="TX_T5_8" name="TX_T5_8_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_85" data-identify="TX_T5_85" name="TX_T5_85_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_9" data-identify="TX_T5_9" name="TX_T5_9_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_10" data-identify="TX_T5_10" name="TX_T5_10_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_11" data-identify="TX_T5_11" name="TX_T5_11_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_12" data-identify="TX_T5_12" name="TX_T5_12_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_13" data-identify="TX_T5_13" name="TX_T5_13_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_14" data-identify="TX_T5_14" name="TX_T5_14_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_15" data-identify="TX_T5_15" name="TX_T5_15_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_16" data-identify="TX_T5_16" name="TX_T5_16_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_17" data-identify="TX_T5_17" name="TX_T5_17_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_18" data-identify="TX_T5_18" name="TX_T5_18_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_19" data-identify="TX_T5_19" name="TX_T5_19_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_20" data-identify="TX_T5_20" name="TX_T5_20_'+rowNumb5+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_21" data-identify="TX_T5_21" name="TX_T5_21_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T5_22" data-identify="TX_T5_22" name="TX_T5_22_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_items_proyeccion_5.row.add( [
			'TOTAL',
			'',
			'',
			'',
			'',
			'<input style="width:99%" id="TX_T5T_3" data-identify="TX_T5T_3" name="TX_T5T_3_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_4" data-identify="TX_T5T_4" name="TX_T5T_4_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T5T_6" data-identify="TX_T5T_6" name="TX_T5T_6_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T5T_8" data-identify="TX_T5T_8" name="TX_T5T_8_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_85" data-identify="TX_T5T_85" name="TX_T5T_85_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_9" data-identify="TX_T5T_9" name="TX_T5T_9_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_10" data-identify="TX_T5T_10" name="TX_T5T_10_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_11" data-identify="TX_T5T_11" name="TX_T5T_11_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_12" data-identify="TX_T5T_12" name="TX_T5T_12_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_13" data-identify="TX_T5T_13" name="TX_T5T_13_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_14" data-identify="TX_T5T_14" name="TX_T5T_14_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_15" data-identify="TX_T5T_15" name="TX_T5T_15_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_16" data-identify="TX_T5T_16" name="TX_T5T_16_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_17" data-identify="TX_T5T_17" name="TX_T5T_17_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_18" data-identify="TX_T5T_18" name="TX_T5T_18_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_19" data-identify="TX_T5T_19" name="TX_T5T_19_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_20" data-identify="TX_T5T_20" name="TX_T5T_20_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_21" data-identify="TX_T5T_21" name="TX_T5T_21_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T5T_22" data-identify="TX_T5T_22" name="TX_T5T_22_'+rowNumb5+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_T5T_3'),$("[data-identify='TX_T5_3']"));
		calcularValorColumna($('#TX_T5T_4'),$("[data-identify='TX_T5_4']"));
		calcularValorColumna($('#TX_T5T_6'),$("[data-identify='TX_T5_6']"));
		calcularValorColumna($('#TX_T5T_8'),$("[data-identify='TX_T5_8']"));
		calcularValorColumna($('#TX_T5T_85'),$("[data-identify='TX_T5_85']"));
		calcularValorColumna($('#TX_T5T_9'),$("[data-identify='TX_T5_9']"));
		calcularValorColumna($('#TX_T5T_10'),$("[data-identify='TX_T5_10']"));
		calcularValorColumna($('#TX_T5T_11'),$("[data-identify='TX_T5_11']"));
		calcularValorColumna($('#TX_T5T_12'),$("[data-identify='TX_T5_12']"));
		calcularValorColumna($('#TX_T5T_13'),$("[data-identify='TX_T5_13']"));
		calcularValorColumna($('#TX_T5T_14'),$("[data-identify='TX_T5_14']"));
		calcularValorColumna($('#TX_T5T_15'),$("[data-identify='TX_T5_15']"));
		calcularValorColumna($('#TX_T5T_16'),$("[data-identify='TX_T5_16']"));
		calcularValorColumna($('#TX_T5T_17'),$("[data-identify='TX_T5_17']"));
		calcularValorColumna($('#TX_T5T_18'),$("[data-identify='TX_T5_18']"));
		calcularValorColumna($('#TX_T5T_19'),$("[data-identify='TX_T5_19']"));
		calcularValorColumna($('#TX_T5T_20'),$("[data-identify='TX_T5_20']"));
		calcularValorColumna($('#TX_T5T_21'),$("[data-identify='TX_T5_21']"));
		calcularValorColumna($('#TX_T5T_22'),$("[data-identify='TX_T5_22']"));
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			endDate: '+0d',
			autoclose: true,
		});
	});
	//

	$('#a-delete-item-5').on('click', function(e){
		e.preventDefault();
		if (rowNumb5 > 1) {
			rowNumb5--;
			table_items_proyeccion_5.row($( "#table_items_proyeccion_5 tr").eq(-1)).remove().draw();
			table_items_proyeccion_5.row.add([
				'TOTAL',
				'',
				'',
				'',
				'',
				'<input style="width:99%" id="TX_T5T_3" data-identify="TX_T5T_3" name="TX_T5T_3_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_4" data-identify="TX_T5T_4" name="TX_T5T_4_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T5T_6" data-identify="TX_T5T_6" name="TX_T5T_6_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T5T_8" data-identify="TX_T5T_8" name="TX_T5T_8_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_85" data-identify="TX_T5T_85" name="TX_T5T_85_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_9" data-identify="TX_T5T_9" name="TX_T5T_9_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_10" data-identify="TX_T5T_10" name="TX_T5T_10_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_11" data-identify="TX_T5T_11" name="TX_T5T_11_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_12" data-identify="TX_T5T_12" name="TX_T5T_12_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_13" data-identify="TX_T5T_13" name="TX_T5T_13_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_14" data-identify="TX_T5T_14" name="TX_T5T_14_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_15" data-identify="TX_T5T_15" name="TX_T5T_15_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_16" data-identify="TX_T5T_16" name="TX_T5T_16_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_17" data-identify="TX_T5T_17" name="TX_T5T_17_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_18" data-identify="TX_T5T_18" name="TX_T5T_18_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_19" data-identify="TX_T5T_19" name="TX_T5T_19_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_20" data-identify="TX_T5T_20" name="TX_T5T_20_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_21" data-identify="TX_T5T_21" name="TX_T5T_21_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T5T_22" data-identify="TX_T5T_22" name="TX_T5T_22_'+rowNumb5+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_items_proyeccion_5.row($( "#table_items_proyeccion_5 tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_T5T_3'),$("[data-identify='TX_T5_3']"));
			calcularValorColumna($('#TX_T5T_4'),$("[data-identify='TX_T5_4']"));
			calcularValorColumna($('#TX_T5T_6'),$("[data-identify='TX_T5_6']"));
			calcularValorColumna($('#TX_T5T_8'),$("[data-identify='TX_T5_8']"));
			calcularValorColumna($('#TX_T5T_85'),$("[data-identify='TX_T5_85']"));
			calcularValorColumna($('#TX_T5T_9'),$("[data-identify='TX_T5_9']"));
			calcularValorColumna($('#TX_T5T_10'),$("[data-identify='TX_T5_10']"));
			calcularValorColumna($('#TX_T5T_11'),$("[data-identify='TX_T5_11']"));
			calcularValorColumna($('#TX_T5T_12'),$("[data-identify='TX_T5_12']"));
			calcularValorColumna($('#TX_T5T_13'),$("[data-identify='TX_T5_13']"));
			calcularValorColumna($('#TX_T5T_14'),$("[data-identify='TX_T5_14']"));
			calcularValorColumna($('#TX_T5T_15'),$("[data-identify='TX_T5_15']"));
			calcularValorColumna($('#TX_T5T_16'),$("[data-identify='TX_T5_16']"));
			calcularValorColumna($('#TX_T5T_17'),$("[data-identify='TX_T5_17']"));
			calcularValorColumna($('#TX_T5T_18'),$("[data-identify='TX_T5_18']"));
			calcularValorColumna($('#TX_T5T_19'),$("[data-identify='TX_T5_19']"));
			calcularValorColumna($('#TX_T5T_20'),$("[data-identify='TX_T5_20']"));
			calcularValorColumna($('#TX_T5T_21'),$("[data-identify='TX_T5_21']"));
			calcularValorColumna($('#TX_T5T_22'),$("[data-identify='TX_T5_22']"));
			actualizarTotales();
		}
	});
$('#a-add-item-5').click();

$( "#table_items_proyeccion_5" ).delegate( "input", "change", function() {
	if ($( this ).val() == '' && !$(this).hasClass('datepicker-class') ) $( this ).val(0);
	var tableSelected = $("#table_items_proyeccion_5");
	if ($( this ).attr('data-identify') == 'TX_T5_3' ) {
		calcularValorColumna($('#TX_T5T_3'),$("[data-identify='TX_T5_3']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T5T_8'),$("[data-identify='TX_T5_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_4' ) {
		calcularValorColumna($('#TX_T5T_4'),$("[data-identify='TX_T5_4']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T5T_8'),$("[data-identify='TX_T5_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_6' ) {
		calcularValorColumna($('#TX_T5T_6'),$("[data-identify='TX_T5_6']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T5T_8'),$("[data-identify='TX_T5_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_8' ) {
		calcularValorColumna($('#TX_T5T_8'),$("[data-identify='TX_T5_8']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_85' ) {
		calcularValorColumna($('#TX_T5T_85'),$("[data-identify='TX_T5_85']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_9' ) {
		calcularValorColumna($('#TX_T5T_9'),$("[data-identify='TX_T5_9']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_10' ) {
		calcularValorColumna($('#TX_T5T_10'),$("[data-identify='TX_T5_10']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_11' ) {
		calcularValorColumna($('#TX_T5T_11'),$("[data-identify='TX_T5_11']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_12' ) {
		calcularValorColumna($('#TX_T5T_12'),$("[data-identify='TX_T5_12']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_13' ) {
		calcularValorColumna($('#TX_T5T_13'),$("[data-identify='TX_T5_13']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_14' ) {
		calcularValorColumna($('#TX_T5T_14'),$("[data-identify='TX_T5_14']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_15' ) {
		calcularValorColumna($('#TX_T5T_15'),$("[data-identify='TX_T5_15']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_16' ) {
		calcularValorColumna($('#TX_T5T_16'),$("[data-identify='TX_T5_16']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_17' ) {
		calcularValorColumna($('#TX_T5T_17'),$("[data-identify='TX_T5_17']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_18' ) {
		calcularValorColumna($('#TX_T5T_18'),$("[data-identify='TX_T5_18']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_19' ) {
		calcularValorColumna($('#TX_T5T_19'),$("[data-identify='TX_T5_19']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_20' ) {
		calcularValorColumna($('#TX_T5T_20'),$("[data-identify='TX_T5_20']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_21' ) {
		calcularValorColumna($('#TX_T5T_21'),$("[data-identify='TX_T5_21']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T5_22' ) {
		calcularValorColumna($('#TX_T5T_22'),$("[data-identify='TX_T5_22']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	calcularSaldoFila(tableSelected,rowNumb5);
	calcularDisponibleFila(tableSelected,rowNumb5);
	actualizarTotales();
});
	//

	var rowNumb6 = 0;
	var table_items_proyeccion_6 = $("#table_items_proyeccion_6").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});
	$('#a-add-item-6').on('click', function(e){
		e.preventDefault();
		rowNumb6++;
		table_items_proyeccion_6.row($( "#table_items_proyeccion_6 tr").eq(-1)).remove().draw()	;
		table_items_proyeccion_6.row.add( [
			rowNumb6,
			'<input required style="width:99%" id="TX_T6_1" data-identify="TX_T6_1" name="TX_T6_1_'+rowNumb6+'" type="text" maxlength="100">',
			'<select style="width: 99%;" id="SL_T6_2" data-identify="SL_T6_2" name="SL_T6_2_'+rowNumb6+'" title="Seleccionar Item">'
			+selectItems()+	'</select>',
			'<input required style="width:99%" value="0" id="TX_T6_25" data-identify="TX_T6_25" name="TX_T6_25_'+rowNumb6+'" type="number" min="1">',
			'<input required style="width:99%" id="TX_T6_26" data-identify="TX_T6_26" name="TX_T6_26_'+rowNumb6+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T6_3" data-identify="TX_T6_3" name="TX_T6_3_'+rowNumb6+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T6_4" data-identify="TX_T6_4" name="TX_T6_4_'+rowNumb6+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T6_5" data-identify="TX_T6_5" name="TX_T6_5_'+rowNumb6+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T6_6" data-identify="TX_T6_6" name="TX_T6_6_'+rowNumb6+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_T6_7" data-identify="TX_T6_7" name="TX_T6_7_'+rowNumb6+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_T6_8" data-identify="TX_T6_8" name="TX_T6_8_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_85" data-identify="TX_T6_85" name="TX_T6_85_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_9" data-identify="TX_T6_9" name="TX_T6_9_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_10" data-identify="TX_T6_10" name="TX_T6_10_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_11" data-identify="TX_T6_11" name="TX_T6_11_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_12" data-identify="TX_T6_12" name="TX_T6_12_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_13" data-identify="TX_T6_13" name="TX_T6_13_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_14" data-identify="TX_T6_14" name="TX_T6_14_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_15" data-identify="TX_T6_15" name="TX_T6_15_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_16" data-identify="TX_T6_16" name="TX_T6_16_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_17" data-identify="TX_T6_17" name="TX_T6_17_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_18" data-identify="TX_T6_18" name="TX_T6_18_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_19" data-identify="TX_T6_19" name="TX_T6_19_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_20" data-identify="TX_T6_20" name="TX_T6_20_'+rowNumb6+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_21" data-identify="TX_T6_21" name="TX_T6_21_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_T6_22" data-identify="TX_T6_22" name="TX_T6_22_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_items_proyeccion_6.row.add( [
			'TOTAL',
			'',
			'',
			'',
			'',
			'<input style="width:99%" id="TX_T6T_3" data-identify="TX_T6T_3" name="TX_T6T_3_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_4" data-identify="TX_T6T_4" name="TX_T6T_4_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T6T_6" data-identify="TX_T6T_6" name="TX_T6T_6_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_T6T_8" data-identify="TX_T6T_8" name="TX_T6T_8_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_85" data-identify="TX_T6T_85" name="TX_T6T_85_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_9" data-identify="TX_T6T_9" name="TX_T6T_9_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_10" data-identify="TX_T6T_10" name="TX_T6T_10_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_11" data-identify="TX_T6T_11" name="TX_T6T_11_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_12" data-identify="TX_T6T_12" name="TX_T6T_12_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_13" data-identify="TX_T6T_13" name="TX_T6T_13_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_14" data-identify="TX_T6T_14" name="TX_T6T_14_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_15" data-identify="TX_T6T_15" name="TX_T6T_15_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_16" data-identify="TX_T6T_16" name="TX_T6T_16_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_17" data-identify="TX_T6T_17" name="TX_T6T_17_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_18" data-identify="TX_T6T_18" name="TX_T6T_18_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_19" data-identify="TX_T6T_19" name="TX_T6T_19_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_20" data-identify="TX_T6T_20" name="TX_T6T_20_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_21" data-identify="TX_T6T_21" name="TX_T6T_21_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_T6T_22" data-identify="TX_T6T_22" name="TX_T6T_22_'+rowNumb6+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_T6T_3'),$("[data-identify='TX_T6_3']"));
		calcularValorColumna($('#TX_T6T_4'),$("[data-identify='TX_T6_4']"));
		calcularValorColumna($('#TX_T6T_6'),$("[data-identify='TX_T6_6']"));
		calcularValorColumna($('#TX_T6T_8'),$("[data-identify='TX_T6_8']"));
		calcularValorColumna($('#TX_T6T_85'),$("[data-identify='TX_T6_85']"));
		calcularValorColumna($('#TX_T6T_9'),$("[data-identify='TX_T6_9']"));
		calcularValorColumna($('#TX_T6T_10'),$("[data-identify='TX_T6_10']"));
		calcularValorColumna($('#TX_T6T_11'),$("[data-identify='TX_T6_11']"));
		calcularValorColumna($('#TX_T6T_12'),$("[data-identify='TX_T6_12']"));
		calcularValorColumna($('#TX_T6T_13'),$("[data-identify='TX_T6_13']"));
		calcularValorColumna($('#TX_T6T_14'),$("[data-identify='TX_T6_14']"));
		calcularValorColumna($('#TX_T6T_15'),$("[data-identify='TX_T6_15']"));
		calcularValorColumna($('#TX_T6T_16'),$("[data-identify='TX_T6_16']"));
		calcularValorColumna($('#TX_T6T_17'),$("[data-identify='TX_T6_17']"));
		calcularValorColumna($('#TX_T6T_18'),$("[data-identify='TX_T6_18']"));
		calcularValorColumna($('#TX_T6T_19'),$("[data-identify='TX_T6_19']"));
		calcularValorColumna($('#TX_T6T_20'),$("[data-identify='TX_T6_20']"));
		calcularValorColumna($('#TX_T6T_21'),$("[data-identify='TX_T6_21']"));
		calcularValorColumna($('#TX_T6T_22'),$("[data-identify='TX_T6_22']"));
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			endDate: '+0d',
			autoclose: true,
		});
	});
	//

	$('#a-delete-item-6').on('click', function(e){
		e.preventDefault();
		if (rowNumb6 > 1) {
			rowNumb6--;
			table_items_proyeccion_6.row($( "#table_items_proyeccion_6 tr").eq(-1)).remove().draw();
			table_items_proyeccion_6.row.add([
				'TOTAL',
				'',
				'',
				'',
				'',
				'<input style="width:99%" id="TX_T6T_3" data-identify="TX_T6T_3" name="TX_T6T_3_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_4" data-identify="TX_T6T_4" name="TX_T6T_4_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T6T_6" data-identify="TX_T6T_6" name="TX_T6T_6_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_T6T_8" data-identify="TX_T6T_8" name="TX_T6T_8_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_85" data-identify="TX_T6T_85" name="TX_T6T_85_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_9" data-identify="TX_T6T_9" name="TX_T6T_9_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_10" data-identify="TX_T6T_10" name="TX_T6T_10_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_11" data-identify="TX_T6T_11" name="TX_T6T_11_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_12" data-identify="TX_T6T_12" name="TX_T6T_12_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_13" data-identify="TX_T6T_13" name="TX_T6T_13_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_14" data-identify="TX_T6T_14" name="TX_T6T_14_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_15" data-identify="TX_T6T_15" name="TX_T6T_15_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_16" data-identify="TX_T6T_16" name="TX_T6T_16_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_17" data-identify="TX_T6T_17" name="TX_T6T_17_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_18" data-identify="TX_T6T_18" name="TX_T6T_18_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_19" data-identify="TX_T6T_19" name="TX_T6T_19_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_20" data-identify="TX_T6T_20" name="TX_T6T_20_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_21" data-identify="TX_T6T_21" name="TX_T6T_21_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_T6T_22" data-identify="TX_T6T_22" name="TX_T6T_22_'+rowNumb6+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_items_proyeccion_6.row($( "#table_items_proyeccion_6 tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_T6T_3'),$("[data-identify='TX_T6_3']"));
			calcularValorColumna($('#TX_T6T_4'),$("[data-identify='TX_T6_4']"));
			calcularValorColumna($('#TX_T6T_6'),$("[data-identify='TX_T6_6']"));
			calcularValorColumna($('#TX_T6T_8'),$("[data-identify='TX_T6_8']"));
			calcularValorColumna($('#TX_T6T_85'),$("[data-identify='TX_T6_85']"));
			calcularValorColumna($('#TX_T6T_9'),$("[data-identify='TX_T6_9']"));
			calcularValorColumna($('#TX_T6T_10'),$("[data-identify='TX_T6_10']"));
			calcularValorColumna($('#TX_T6T_11'),$("[data-identify='TX_T6_11']"));
			calcularValorColumna($('#TX_T6T_12'),$("[data-identify='TX_T6_12']"));
			calcularValorColumna($('#TX_T6T_13'),$("[data-identify='TX_T6_13']"));
			calcularValorColumna($('#TX_T6T_14'),$("[data-identify='TX_T6_14']"));
			calcularValorColumna($('#TX_T6T_15'),$("[data-identify='TX_T6_15']"));
			calcularValorColumna($('#TX_T6T_16'),$("[data-identify='TX_T6_16']"));
			calcularValorColumna($('#TX_T6T_17'),$("[data-identify='TX_T6_17']"));
			calcularValorColumna($('#TX_T6T_18'),$("[data-identify='TX_T6_18']"));
			calcularValorColumna($('#TX_T6T_19'),$("[data-identify='TX_T6_19']"));
			calcularValorColumna($('#TX_T6T_20'),$("[data-identify='TX_T6_20']"));
			calcularValorColumna($('#TX_T6T_21'),$("[data-identify='TX_T6_21']"));
			calcularValorColumna($('#TX_T6T_22'),$("[data-identify='TX_T6_22']"));
			actualizarTotales();
		}
	});
$('#a-add-item-6').click();

$( "#table_items_proyeccion_6" ).delegate( "input", "change", function() {
	if ($( this ).val() == '' && !$(this).hasClass('datepicker-class') ) $( this ).val(0);
	var tableSelected = $("#table_items_proyeccion_6");
	if ($( this ).attr('data-identify') == 'TX_T6_3' ) {
		calcularValorColumna($('#TX_T6T_3'),$("[data-identify='TX_T6_3']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T6T_8'),$("[data-identify='TX_T6_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_4' ) {
		calcularValorColumna($('#TX_T6T_4'),$("[data-identify='TX_T6_4']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T6T_8'),$("[data-identify='TX_T6_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_6' ) {
		calcularValorColumna($('#TX_T6T_6'),$("[data-identify='TX_T6_6']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_T6T_8'),$("[data-identify='TX_T6_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_8' ) {
		calcularValorColumna($('#TX_T6T_8'),$("[data-identify='TX_T6_8']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_85' ) {
		calcularValorColumna($('#TX_T6T_85'),$("[data-identify='TX_T6_85']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_9' ) {
		calcularValorColumna($('#TX_T6T_9'),$("[data-identify='TX_T6_9']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_10' ) {
		calcularValorColumna($('#TX_T6T_10'),$("[data-identify='TX_T6_10']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_11' ) {
		calcularValorColumna($('#TX_T6T_11'),$("[data-identify='TX_T6_11']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_12' ) {
		calcularValorColumna($('#TX_T6T_12'),$("[data-identify='TX_T6_12']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_13' ) {
		calcularValorColumna($('#TX_T6T_13'),$("[data-identify='TX_T6_13']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_14' ) {
		calcularValorColumna($('#TX_T6T_14'),$("[data-identify='TX_T6_14']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_15' ) {
		calcularValorColumna($('#TX_T6T_15'),$("[data-identify='TX_T6_15']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_16' ) {
		calcularValorColumna($('#TX_T6T_16'),$("[data-identify='TX_T6_16']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_17' ) {
		calcularValorColumna($('#TX_T6T_17'),$("[data-identify='TX_T6_17']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_18' ) {
		calcularValorColumna($('#TX_T6T_18'),$("[data-identify='TX_T6_18']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_19' ) {
		calcularValorColumna($('#TX_T6T_19'),$("[data-identify='TX_T6_19']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_20' ) {
		calcularValorColumna($('#TX_T6T_20'),$("[data-identify='TX_T6_20']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_21' ) {
		calcularValorColumna($('#TX_T6T_21'),$("[data-identify='TX_T6_21']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_T6_22' ) {
		calcularValorColumna($('#TX_T6T_22'),$("[data-identify='TX_T6_22']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	calcularSaldoFila(tableSelected,rowNumb6);
	calcularDisponibleFila(tableSelected,rowNumb6);
	actualizarTotales();
});
	//


	var rowNumbAsoc = 0;
	var table_items_asociado = $("#table_items_asociado").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	$('[data-toggle="tooltip"]').tooltip({
		"animation": 1
	});
	$('#a-add-asoc').on('click', function(e){
		e.preventDefault();
		rowNumbAsoc++;
		table_items_asociado.row($( "#table_items_asociado tr").eq(-1)).remove().draw()	;
		table_items_asociado.row.add( [
			rowNumbAsoc,
			'<input required style="width:99%" id="TX_TA_1" data-identify="TX_TA_1" name="TX_TA_1_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input required style="width:99%" id="TX_TA_2" data-identify="TX_TA_2" name="TX_TA_2_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" id="TX_TA_25" data-identify="TX_TA_25" name="TX_TA_25_'+rowNumbAsoc+'" type="number" min="1">',
			'<input required style="width:99%" id="TX_TA_26" data-identify="TX_TA_26" name="TX_TA_26_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_TA_3" data-identify="TX_TA_3" name="TX_TA_3_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input required style="width:99%" value="0" class="change-event" id="TX_TA_4" data-identify="TX_TA_4" name="TX_TA_4_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_TA_5" data-identify="TX_TA_5" name="TX_TA_5_'+rowNumbAsoc+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_TA_6" data-identify="TX_TA_6" name="TX_TA_6_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input required style="width:99%" type="text" id="TX_TA_7" data-identify="TX_TA_7" name="TX_TA_7_'+rowNumbAsoc+'" class=" datepicker-class" readonly maxlength="100" placeholder="dd/mm/aaaa" >',
			'<input required style="width:99%" value="0" class="change-event" id="TX_TA_8" data-identify="TX_TA_8" name="TX_TA_8_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_85" data-identify="TX_TA_85" name="TX_TA_85_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_9" data-identify="TX_TA_9" name="TX_TA_9_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_10" data-identify="TX_TA_10" name="TX_TA_10_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_11" data-identify="TX_TA_11" name="TX_TA_11_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_12" data-identify="TX_TA_12" name="TX_TA_12_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_13" data-identify="TX_TA_13" name="TX_TA_13_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_14" data-identify="TX_TA_14" name="TX_TA_14_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_15" data-identify="TX_TA_15" name="TX_TA_15_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_16" data-identify="TX_TA_16" name="TX_TA_16_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_17" data-identify="TX_TA_17" name="TX_TA_17_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_18" data-identify="TX_TA_18" name="TX_TA_18_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_19" data-identify="TX_TA_19" name="TX_TA_19_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_20" data-identify="TX_TA_20" name="TX_TA_20_'+rowNumbAsoc+'" type="text" maxlength="100">',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_21" data-identify="TX_TA_21" name="TX_TA_21_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" value="0" class="change-event" id="TX_TA_22" data-identify="TX_TA_22" name="TX_TA_22_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			]).draw();
		table_items_asociado.row.add( [
			'TOTAL ASOCIADO',
			'',
			'',
			'',
			'',
			'<input style="width:99%" id="TX_TAT_3" data-identify="TX_TAT_3" name="TX_TAT_3_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_4" data-identify="TX_TAT_4" name="TX_TAT_4_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_TAT_6" data-identify="TX_TAT_6" name="TX_TAT_6_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'',
			'<input style="width:99%" id="TX_TAT_8" data-identify="TX_TAT_8" name="TX_TAT_8_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_85" data-identify="TX_TAT_85" name="TX_TAT_85_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_9" data-identify="TX_TAT_9" name="TX_TAT_9_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_10" data-identify="TX_TAT_10" name="TX_TAT_10_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_11" data-identify="TX_TAT_11" name="TX_TAT_11_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_12" data-identify="TX_TAT_12" name="TX_TAT_12_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_13" data-identify="TX_TAT_13" name="TX_TAT_13_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_14" data-identify="TX_TAT_14" name="TX_TAT_14_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_15" data-identify="TX_TAT_15" name="TX_TAT_15_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_16" data-identify="TX_TAT_16" name="TX_TAT_16_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_17" data-identify="TX_TAT_17" name="TX_TAT_17_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_18" data-identify="TX_TAT_18" name="TX_TAT_18_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_19" data-identify="TX_TAT_19" name="TX_TAT_19_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_20" data-identify="TX_TAT_20" name="TX_TAT_20_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_21" data-identify="TX_TAT_21" name="TX_TAT_21_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			'<input style="width:99%" id="TX_TAT_22" data-identify="TX_TAT_22" name="TX_TAT_22_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
			]).draw();
		calcularValorColumna($('#TX_TAT_3'),$("[data-identify='TX_TA_3']"));
		calcularValorColumna($('#TX_TAT_4'),$("[data-identify='TX_TA_4']"));
		calcularValorColumna($('#TX_TAT_6'),$("[data-identify='TX_TA_6']"));
		calcularValorColumna($('#TX_TAT_8'),$("[data-identify='TX_TA_8']"));
		calcularValorColumna($('#TX_TAT_85'),$("[data-identify='TX_TA_85']"));
		calcularValorColumna($('#TX_TAT_9'),$("[data-identify='TX_TA_9']"));
		calcularValorColumna($('#TX_TAT_10'),$("[data-identify='TX_TA_10']"));
		calcularValorColumna($('#TX_TAT_11'),$("[data-identify='TX_TA_11']"));
		calcularValorColumna($('#TX_TAT_12'),$("[data-identify='TX_TA_12']"));
		calcularValorColumna($('#TX_TAT_13'),$("[data-identify='TX_TA_13']"));
		calcularValorColumna($('#TX_TAT_14'),$("[data-identify='TX_TA_14']"));
		calcularValorColumna($('#TX_TAT_15'),$("[data-identify='TX_TA_15']"));
		calcularValorColumna($('#TX_TAT_16'),$("[data-identify='TX_TA_16']"));
		calcularValorColumna($('#TX_TAT_17'),$("[data-identify='TX_TA_17']"));
		calcularValorColumna($('#TX_TAT_18'),$("[data-identify='TX_TA_18']"));
		calcularValorColumna($('#TX_TAT_19'),$("[data-identify='TX_TA_19']"));
		calcularValorColumna($('#TX_TAT_20'),$("[data-identify='TX_TA_20']"));
		calcularValorColumna($('#TX_TAT_21'),$("[data-identify='TX_TA_21']"));
		calcularValorColumna($('#TX_TAT_22'),$("[data-identify='TX_TA_22']"));
		$(".datepicker-class").datepicker({
			format: 'dd/mm/yyyy',
			weekStart: 1,
			language: 'es',
			endDate: '+0d',
			autoclose: true,
		});
	});
	//

	$('#a-delete-asoc').on('click', function(e){
		e.preventDefault();
		if (rowNumbAsoc > 1) {
			rowNumbAsoc--;
			table_items_asociado.row($( "#table_items_asociado tr").eq(-1)).remove().draw();
			table_items_asociado.row.add( [
				'TOTAL ASOCIADO',
				'',
				'',
				'',
				'',
				'<input style="width:99%" id="TX_TAT_3" data-identify="TX_TAT_3" name="TX_TAT_3_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_4" data-identify="TX_TAT_4" name="TX_TAT_4_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_TAT_6" data-identify="TX_TAT_6" name="TX_TAT_6_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'',
				'<input style="width:99%" id="TX_TAT_8" data-identify="TX_TAT_8" name="TX_TAT_8_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_85" data-identify="TX_TAT_85" name="TX_TAT_85_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_9" data-identify="TX_TAT_9" name="TX_TAT_9_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_10" data-identify="TX_TAT_10" name="TX_TAT_10_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_11" data-identify="TX_TAT_11" name="TX_TAT_11_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_12" data-identify="TX_TAT_12" name="TX_TAT_12_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_13" data-identify="TX_TAT_13" name="TX_TAT_13_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_14" data-identify="TX_TAT_14" name="TX_TAT_14_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_15" data-identify="TX_TAT_15" name="TX_TAT_15_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_16" data-identify="TX_TAT_16" name="TX_TAT_16_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_17" data-identify="TX_TAT_17" name="TX_TAT_17_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_18" data-identify="TX_TAT_18" name="TX_TAT_18_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_19" data-identify="TX_TAT_19" name="TX_TAT_19_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_20" data-identify="TX_TAT_20" name="TX_TAT_20_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_21" data-identify="TX_TAT_21" name="TX_TAT_21_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				'<input style="width:99%" id="TX_TAT_22" data-identify="TX_TAT_22" name="TX_TAT_22_'+rowNumbAsoc+'" type="text" maxlength="100" readonly>',
				]).draw();
			table_items_asociado.row($( "#table_items_asociado tr").eq(-2)).remove().draw();
			calcularValorColumna($('#TX_TAT_3'),$("[data-identify='TX_TA_3']"));
			calcularValorColumna($('#TX_TAT_4'),$("[data-identify='TX_TA_4']"));
			calcularValorColumna($('#TX_TAT_6'),$("[data-identify='TX_TA_6']"));
			calcularValorColumna($('#TX_TAT_8'),$("[data-identify='TX_TA_8']"));
			calcularValorColumna($('#TX_TAT_85'),$("[data-identify='TX_TA_85']"));
			calcularValorColumna($('#TX_TAT_9'),$("[data-identify='TX_TA_9']"));
			calcularValorColumna($('#TX_TAT_10'),$("[data-identify='TX_TA_10']"));
			calcularValorColumna($('#TX_TAT_11'),$("[data-identify='TX_TA_11']"));
			calcularValorColumna($('#TX_TAT_12'),$("[data-identify='TX_TA_12']"));
			calcularValorColumna($('#TX_TAT_13'),$("[data-identify='TX_TA_13']"));
			calcularValorColumna($('#TX_TAT_14'),$("[data-identify='TX_TA_14']"));
			calcularValorColumna($('#TX_TAT_15'),$("[data-identify='TX_TA_15']"));
			calcularValorColumna($('#TX_TAT_16'),$("[data-identify='TX_TA_16']"));
			calcularValorColumna($('#TX_TAT_17'),$("[data-identify='TX_TA_17']"));
			calcularValorColumna($('#TX_TAT_18'),$("[data-identify='TX_TA_18']"));
			calcularValorColumna($('#TX_TAT_19'),$("[data-identify='TX_TA_19']"));
			calcularValorColumna($('#TX_TAT_20'),$("[data-identify='TX_TA_20']"));
			calcularValorColumna($('#TX_TAT_21'),$("[data-identify='TX_TA_21']"));
			calcularValorColumna($('#TX_TAT_22'),$("[data-identify='TX_TA_22']"));
		}
	});
$('#a-add-asoc').click();

$( "#table_items_asociado" ).delegate( "input", "change", function() {
	if ($( this ).val() == '' && !$(this).hasClass('datepicker-class') ) $( this ).val(0);
	var tableSelected = $("#table_items_asociado");
	if ($( this ).attr('data-identify') == 'TX_TA_3' ) {
		calcularValorColumna($('#TX_TAT_3'),$("[data-identify='TX_TA_3']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_TAT_8'),$("[data-identify='TX_TA_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_4' ) {
		calcularValorColumna($('#TX_TAT_4'),$("[data-identify='TX_TA_4']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_TAT_8'),$("[data-identify='TX_TA_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_6' ) {
		calcularValorColumna($('#TX_TAT_6'),$("[data-identify='TX_TA_6']"));
		calcularPresupuestoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularValorColumna($('#TX_TAT_8'),$("[data-identify='TX_TA_8']"));
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_8' ) {
		calcularValorColumna($('#TX_TAT_8'),$("[data-identify='TX_TA_8']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_85' ) {
		calcularValorColumna($('#TX_TAT_85'),$("[data-identify='TX_TA_85']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_9' ) {
		calcularValorColumna($('#TX_TAT_9'),$("[data-identify='TX_TA_9']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_10' ) {
		calcularValorColumna($('#TX_TAT_10'),$("[data-identify='TX_TA_10']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_11' ) {
		calcularValorColumna($('#TX_TAT_11'),$("[data-identify='TX_TA_11']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_12' ) {
		calcularValorColumna($('#TX_TAT_12'),$("[data-identify='TX_TA_12']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_13' ) {
		calcularValorColumna($('#TX_TAT_13'),$("[data-identify='TX_TA_13']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_14' ) {
		calcularValorColumna($('#TX_TAT_14'),$("[data-identify='TX_TA_14']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_15' ) {
		calcularValorColumna($('#TX_TAT_15'),$("[data-identify='TX_TA_15']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_16' ) {
		calcularValorColumna($('#TX_TAT_16'),$("[data-identify='TX_TA_16']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_17' ) {
		calcularValorColumna($('#TX_TAT_17'),$("[data-identify='TX_TA_17']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_18' ) {
		calcularValorColumna($('#TX_TAT_18'),$("[data-identify='TX_TA_18']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_19' ) {
		calcularValorColumna($('#TX_TAT_19'),$("[data-identify='TX_TA_19']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_20' ) {
		calcularValorColumna($('#TX_TAT_20'),$("[data-identify='TX_TA_20']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_21' ) {
		calcularValorColumna($('#TX_TAT_21'),$("[data-identify='TX_TA_21']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	if ($( this ).attr('data-identify') == 'TX_TA_22' ) {
		calcularValorColumna($('#TX_TAT_22'),$("[data-identify='TX_TA_22']"));
		calcularSaldoFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
		calcularDisponibleFila(tableSelected,parseInt($($( this).parent().parent()[0].children[0]).text())-1);
	}
	calcularSaldoFila(tableSelected,rowNumbAsoc);
	calcularDisponibleFila(tableSelected,rowNumbAsoc);
});
	//



	var table_totales = $("#table_totales").DataTable({
		"paging":   false,
		"ordering": false,
		"info":     false,
		"searching": false,
		"resize":true,
	});
	table_totales.row.add( [
		'TOTAL IDARTES',
		'',
		'',
		'',
		'',
		'<input style="width:99%" id="TX_TIT_3" data-identify="TX_TIT_3" name="TX_TIT_3" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_4" data-identify="TX_TIT_4" name="TX_TIT_4" type="text" maxlength="100" readonly>',
		'',
		'<input style="width:99%" id="TX_TIT_6" data-identify="TX_TIT_6" name="TX_TIT_6" type="text" maxlength="100" readonly>',
		'',
		'<input style="width:99%" id="TX_TIT_8" data-identify="TX_TIT_8" name="TX_TIT_8" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_85" data-identify="TX_TIT_85" name="TX_TIT_85" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_9" data-identify="TX_TIT_9" name="TX_TIT_9" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_10" data-identify="TX_TIT_10" name="TX_TIT_10" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_11" data-identify="TX_TIT_11" name="TX_TIT_11" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_12" data-identify="TX_TIT_12" name="TX_TIT_12" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_13" data-identify="TX_TIT_13" name="TX_TIT_13" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_14" data-identify="TX_TIT_14" name="TX_TIT_14" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_15" data-identify="TX_TIT_15" name="TX_TIT_15" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_16" data-identify="TX_TIT_16" name="TX_TIT_16" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_17" data-identify="TX_TIT_17" name="TX_TIT_17" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_18" data-identify="TX_TIT_18" name="TX_TIT_18" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_19" data-identify="TX_TIT_19" name="TX_TIT_19" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_20" data-identify="TX_TIT_20" name="TX_TIT_20" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_21" data-identify="TX_TIT_21" name="TX_TIT_21" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TIT_22" data-identify="TX_TIT_22" name="TX_TIT_22" type="text" maxlength="100" readonly>',
		]).draw();
	table_totales.row.add( [
		'SALDO EN CAJA',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'<input style="width:99%" id="TX_TCT_85" data-identify="TX_TCT_85" name="TX_TCT_85" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_9" data-identify="TX_TCT_9" name="TX_TCT_9" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_10" data-identify="TX_TCT_10" name="TX_TCT_10" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_11" data-identify="TX_TCT_11" name="TX_TCT_11" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_12" data-identify="TX_TCT_12" name="TX_TCT_12" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_13" data-identify="TX_TCT_13" name="TX_TCT_13" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_14" data-identify="TX_TCT_14" name="TX_TCT_14" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_15" data-identify="TX_TCT_15" name="TX_TCT_15" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_16" data-identify="TX_TCT_16" name="TX_TCT_16" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_17" data-identify="TX_TCT_17" name="TX_TCT_17" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_18" data-identify="TX_TCT_18" name="TX_TCT_18" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_19" data-identify="TX_TCT_19" name="TX_TCT_19" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_20" data-identify="TX_TCT_20" name="TX_TCT_20" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TCT_21" data-identify="TX_TCT_21" name="TX_TCT_21" type="text" maxlength="100" readonly>',
		'',
		]).draw();
	table_totales.row.add( [
		'ACUMULADO EGRESOS',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'',
		'<input style="width:99%" id="TX_TET_85" data-identify="TX_TET_85" name="TX_TET_85" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_9" data-identify="TX_TET_9" name="TX_TET_9" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_10" data-identify="TX_TET_10" name="TX_TET_10" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_11" data-identify="TX_TET_11" name="TX_TET_11" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_12" data-identify="TX_TET_12" name="TX_TET_12" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_13" data-identify="TX_TET_13" name="TX_TET_13" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_14" data-identify="TX_TET_14" name="TX_TET_14" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_15" data-identify="TX_TET_15" name="TX_TET_15" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_16" data-identify="TX_TET_16" name="TX_TET_16" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_17" data-identify="TX_TET_17" name="TX_TET_17" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_18" data-identify="TX_TET_18" name="TX_TET_18" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_19" data-identify="TX_TET_19" name="TX_TET_19" type="text" maxlength="100" readonly>',
		'<input style="width:99%" id="TX_TET_20" data-identify="TX_TET_20" name="TX_TET_20" type="text" maxlength="100" readonly>',
		'',
		'',
		]).draw();

	function actualizarTotales() {
		$('#TX_TIT_3').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_3').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_3').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_3').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_3').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_3').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_3').val()||'0')),"$"));
		$('#TX_TIT_4').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_4').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_4').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_4').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_4').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_4').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_4').val()||'0')),"$"));
		$('#TX_TIT_6').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_6').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_6').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_6').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_6').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_6').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_6').val()||'0')),"$"));
		$('#TX_TIT_8').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_8').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_8').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_8').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_8').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_8').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_8').val()||'0')),"$"));
		$('#TX_TIT_85').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_85').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_85').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_85').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_85').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_85').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_85').val()||'0')),"$"));
		$('#TX_TIT_9').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_9').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_9').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_9').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_9').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_9').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_9').val()||'0')),"$"));
		$('#TX_TIT_10').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_10').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_10').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_10').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_10').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_10').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_10').val()||'0')),"$"));
		$('#TX_TIT_11').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_11').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_11').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_11').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_11').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_11').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_11').val()||'0')),"$"));
		$('#TX_TIT_12').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_12').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_12').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_12').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_12').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_12').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_12').val()||'0')),"$"));
		$('#TX_TIT_13').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_13').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_13').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_13').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_13').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_13').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_13').val()||'0')),"$"));
		$('#TX_TIT_14').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_14').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_14').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_14').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_14').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_14').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_14').val()||'0')),"$"));
		$('#TX_TIT_15').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_15').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_15').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_15').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_15').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_15').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_15').val()||'0')),"$"));
		$('#TX_TIT_16').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_16').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_16').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_16').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_16').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_16').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_16').val()||'0')),"$"));
		$('#TX_TIT_17').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_17').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_17').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_17').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_17').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_17').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_17').val()||'0')),"$"));
		$('#TX_TIT_18').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_18').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_18').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_18').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_18').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_18').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_18').val()||'0')),"$"));
		$('#TX_TIT_19').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_19').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_19').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_19').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_19').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_19').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_19').val()||'0')),"$"));
		$('#TX_TIT_20').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_20').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_20').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_20').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_20').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_20').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_20').val()||'0')),"$"));
		$('#TX_TIT_21').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_21').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_21').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_21').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_21').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_21').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_21').val()||'0')),"$"));
		$('#TX_TIT_22').val(formatMoney(parseInt(deformatMoney($('#TX_T1T_22').val()||'0'))+parseInt(deformatMoney($('#TX_T2T_22').val()||'0'))+parseInt(deformatMoney($('#TX_T3T_22').val()||'0'))+parseInt(deformatMoney($('#TX_T4T_22').val()||'0'))+parseInt(deformatMoney($('#TX_T5T_22').val()||'0'))+parseInt(deformatMoney($('#TX_T6T_22').val()||'0')),"$"));
		
		$('#TX_TCT_85').val(formatMoney(parseInt(deformatMoney($('#TX_TDT_0').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_85').val()||'0')),"$"));
		$('#TX_TCT_9').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_85').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_1').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_9').val()||'0')),"$"));
		$('#TX_TCT_10').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_9').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_2').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_10').val()||'0')),"$"));
		$('#TX_TCT_11').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_10').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_3').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_11').val()||'0')),"$"));
		$('#TX_TCT_12').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_11').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_4').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_12').val()||'0')),"$"));
		$('#TX_TCT_13').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_12').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_5').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_13').val()||'0')),"$"));
		$('#TX_TCT_14').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_13').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_6').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_14').val()||'0')),"$"));
		$('#TX_TCT_15').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_14').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_7').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_15').val()||'0')),"$"));
		$('#TX_TCT_16').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_15').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_8').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_16').val()||'0')),"$"));
		$('#TX_TCT_17').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_16').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_9').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_17').val()||'0')),"$"));
		$('#TX_TCT_18').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_17').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_10').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_18').val()||'0')),"$"));
		$('#TX_TCT_19').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_18').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_11').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_19').val()||'0')),"$"));
		$('#TX_TCT_20').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_19').val()||'0'))+parseInt(deformatMoney($('#TX_TDT_12').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_20').val()||'0')),"$"));
		//$('#TX_TCT_21').val(formatMoney(parseInt(deformatMoney($('#TX_TDT_13').val()||'0'))-parseInt(deformatMoney($('#TX_TIT_21').val()||'0')),"$"));
		$('#TX_TCT_21').val(formatMoney(parseInt(deformatMoney($('#TX_TCT_20').val()||'0')),"$"));

		$('#TX_TET_85').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_85').val()||'0')),"$"));
		$('#TX_TET_9').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_9').val()||'0'))+parseInt(deformatMoney($('#TX_TET_85').val()||'0')),"$"));
		$('#TX_TET_10').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_10').val()||'0'))+parseInt(deformatMoney($('#TX_TET_9').val()||'0')),"$"));
		$('#TX_TET_11').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_11').val()||'0'))+parseInt(deformatMoney($('#TX_TET_10').val()||'0')),"$"));
		$('#TX_TET_12').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_12').val()||'0'))+parseInt(deformatMoney($('#TX_TET_11').val()||'0')),"$"));
		$('#TX_TET_13').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_13').val()||'0'))+parseInt(deformatMoney($('#TX_TET_12').val()||'0')),"$"));
		$('#TX_TET_14').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_14').val()||'0'))+parseInt(deformatMoney($('#TX_TET_13').val()||'0')),"$"));
		$('#TX_TET_15').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_15').val()||'0'))+parseInt(deformatMoney($('#TX_TET_14').val()||'0')),"$"));
		$('#TX_TET_16').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_16').val()||'0'))+parseInt(deformatMoney($('#TX_TET_15').val()||'0')),"$"));
		$('#TX_TET_17').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_17').val()||'0'))+parseInt(deformatMoney($('#TX_TET_16').val()||'0')),"$"));
		$('#TX_TET_18').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_18').val()||'0'))+parseInt(deformatMoney($('#TX_TET_17').val()||'0')),"$"));
		$('#TX_TET_19').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_19').val()||'0'))+parseInt(deformatMoney($('#TX_TET_18').val()||'0')),"$"));
		$('#TX_TET_20').val(formatMoney(parseInt(deformatMoney($('#TX_TIT_20').val()||'0'))+parseInt(deformatMoney($('#TX_TET_19').val()||'0')),"$"));

	}




	$('#a-save-informe-proyeccion').on('click', function(e){ 

		e.preventDefault();
		var datos = $('#FORM_INFORME_PROYECCION').serializeArray();

		var proyeccionFormato = "";
		
		proyecto = $('#SL_Proyecto').val();

		var periodo = "";
		$('#SL_Periodo_Proyeccion :selected').each(function(i, selected){
			periodo = periodo + $(selected).text()+",";
		});
		periodo = periodo.slice(0, -1);

		var rubros = "";
		$('#SL_Rubro :selected').each(function(i, selected){
			rubros = rubros + $(selected).val()+",";
		});
		rubros = rubros.slice(0, -1);

		datos.push({
			"name":'opcion',
			"value":'guardarInformeProyeccion'
		});

		datos.push({
			"name":'proyecto',
			"value":proyecto
		});

		datos.push({
			"name":'periodo',
			"value":periodo
		});
		datos.push({
			"name":'rubros',
			"value":rubros
		});
		datos.push({
			"name":'organizacionId',
			"value": organizacion.PK_Id_Organizacion
		});
		datos.push({
			"name":'idUsuario',
			"value": idUsuario
		});
		datos.push({
			"name":'id_seguimiento_propuesta',
			"value": id_seguimiento_propuesta
		});
		$.ajax({
			url: url_controller,
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(result){
				if (result == 1) {
					bootbox.alert("El formato se ha guardado correctamente.",function(){
						organizacionId = $("#SL_Organizacion").val();
						// $("#SL_Organizacion").val("0");
						// $("#SL_Organizacion").val(organizacionId);
						// $("#SL_Organizacion").change();
						// $("#tab_consulta_formatos").click();
						$("#tab_consulta_formatos").click();
						consultar_formatos_organizacion(session);
						refreshColumnsBloqued(organizacion);
					});
				}
			},error: function(result){
				console.log("Error: "+result);
			}
		});

	});

	$(document).delegate( ".abrir_informe", "click", function() {
		if ($(this).data("tipo-informe") == 'PROYECCIÓN Y SEGUIMIENTO DEL GASTO') {
			$("#tab_proyeccion_gasto").click();
			cargarFormatoProyeccionGasto($(this).data("id-informe-gestion"));
		}
	});
	$(document).delegate( ".descargar_informe", "click", function() {
		if ($(this).data("tipo-informe") == 'PROYECCIÓN Y SEGUIMIENTO DEL GASTO') {
			var pdfData = cargarPDFProyeccionGasto($(this).data("id-informe-gestion"));
			console.log(pdfData);
			pdfMake.createPdf(pdfData).download('proyeccionyseguimiento.pdf');
		}
	});
	
	function cargarFormatoProyeccionGasto(idInforme) {
		$('#FORM_INFORME_PROYECCION')[0].reset();
		var datos = {
			'opcion': 'getInformeProyeccion',
			'idInforme': idInforme
		};

		$.ajax({
			url: url_controller,
			data: datos,
			type: 'POST',
			success: function (informe) {
				datos_informe = JSON.parse(informe);
				datos_informe.TX_Caja = JSON.parse(datos_informe.TX_Caja);
				datos_informe.TX_Egresos = JSON.parse(datos_informe.TX_Egresos);
				datos_informe.TX_Grupos = JSON.parse(datos_informe.TX_Grupos);
				datos_informe.TX_Total_Asociado = JSON.parse(datos_informe.TX_Total_Asociado);
				datos_informe.TX_Total_Idartes = JSON.parse(datos_informe.TX_Total_Idartes);
				id_seguimiento_propuesta = datos_informe.id_seguimiento_propuesta;
				$("#SL_Proyecto").val(datos_informe.FK_Proyecto).trigger("change");
				var perido = datos_informe.TX_Periodo.split(",");
				$.each(perido, function (i) {
					if (perido[i] != '') {
						$("#SL_Periodo_Proyeccion option").filter(function() { return $(this).text() == perido[i] }).prop('selected', true);
					}
				});
				$("#SL_Anio_Proyeccion").val(datos_informe.IN_Anio);
				$("#SL_Rubro option:selected").removeAttr("selected");
				var rubros = datos_informe.VC_Rubros.split(",");
				$.each(rubros, function (i) {
					if (rubros[i] != '') {
						$("#SL_Rubro option[value='" + rubros[i]+ "']").prop('selected', true);
						$("#SL_Rubro").change();
					}

				});
				for (var i = 0; i < 50; i++) {
					$('#a-delete-des').click();
					$('#a-delete-asoc').click();
					$('#a-delete-item-0').click();
					$('#a-delete-item-1').click();
					$('#a-delete-item-2').click();
					$('#a-delete-item-3').click();
					$('#a-delete-item-4').click();
					$('#a-delete-item-5').click();
					$('#a-delete-item-6').click();

				}

				//$('#input-ejecucion-anterior').val(formatMoney(parseFloat(datos_informe.desembolsos[0].TX_ejecucion_anterior),'$'));
				for (var i = 0; i < datos_informe.desembolsos.length-2; i++) {
					$('#a-add-des').click();
				}
				$.each(datos_informe.desembolsos, function (posicion, desembolso) {
					desembolso.TX_Datos = JSON.parse(desembolso.TX_Datos);
					$.each(desembolso.TX_Datos, function (key, value) {
						$("[name='"+key+"']").val(formatMoney(parseFloat(value),'$'));
					});
				});

				// for (var i = 0; i < datos_informe.desembolsos.length-2; i++) {
				// 	$('#a-add-des').click();
				// }
				var cantidadItems = [0,0,0,0,0,0,0,0];
				var cantidadItemsAsociado = 0;
				$.each(datos_informe.aportes, function (posicion, aporte) {
					if (aporte.IN_Tipo == 1 )
						cantidadItems[aporte.IN_Tabla]++;
					if (aporte.IN_Tipo == 2 )
						cantidadItemsAsociado ++;
					if (cantidadItems[aporte.IN_Tabla]>2 && aporte.IN_Tipo == 1 ) {
						$('#a-add-item-'+aporte.IN_Tabla).click();
					}
					if (cantidadItemsAsociado > 2 && aporte.IN_Tipo == 2 ) {
						$('#a-add-asoc').click();
					}
				});
				$.each(datos_informe.aportes, function (posicion, aporte) {
					contieneFecha = false;
					if (aporte.TX_Datos.includes("SL_")) contieneFecha = true;
					if (aporte.TX_Datos.includes("TX_TA_")) contieneFecha = false;
					aporte.TX_Datos = JSON.parse(aporte.TX_Datos);
					var inicial = 0;
					$.each(aporte.TX_Datos, function (key, value) {
						inicial++;
						contienePorcentaje = false;
						if (value.includes("%")) contienePorcentaje = true;
						if ((!key.includes("TX_AD") && inicial < 5) || (contieneFecha && (inicial == 7 || inicial == 9))) {
							$("[name='"+key+"']").val(value);
						}
						else{
							if (value.indexOf("/") != -1 || contienePorcentaje) {
								$("[name='"+key+"']").val(value);
							} 
							else
								$("[name='"+key+"']").val(formatMoney(parseFloat(value),'$'));
						}
					});
				});

				$.each(datos_informe.TX_Caja, function (key, value) {
					$("[name='"+key+"']").val(formatMoney(parseFloat(value),'$'));
				});
				$.each(datos_informe.TX_Egresos, function (key, value) {
					$("[name='"+key+"']").val(formatMoney(parseFloat(value),'$'));
				});
				$.each(datos_informe.TX_Grupos, function (key, value) {
					$("[name='"+key+"']").val(value);
				});
				$.each(datos_informe.TX_Total_Asociado, function (key, value) {
					$("[name='"+key+"']").val(formatMoney(parseFloat(value),'$'));
				});
				$.each(datos_informe.TX_Total_Idartes, function (key, value) {
					$("[name='"+key+"']").val(formatMoney(parseFloat(value),'$'));
				});
				$('.selectpicker').selectpicker('refresh');

			}
		});
}
function cargarPDFProyeccionGasto(idInforme) {
	var datos = {
		'opcion': 'getInformeProyeccion',
		'idInforme': idInforme
	};
	var datosPdf;
	$.ajax({
		url: url_controller,
		data: datos,
		async: false,
		type: 'POST',
		success: function (informe) {
			datos_informe = JSON.parse(informe);
			datos_informe.TX_Caja = JSON.parse(datos_informe.TX_Caja);
			datos_informe.TX_Egresos = JSON.parse(datos_informe.TX_Egresos);
			datos_informe.TX_Grupos = JSON.parse(datos_informe.TX_Grupos);
			datos_informe.TX_Total_Asociado = JSON.parse(datos_informe.TX_Total_Asociado);
			datos_informe.TX_Total_Idartes = JSON.parse(datos_informe.TX_Total_Idartes);
			var perido = datos_informe.TX_Periodo.split(",");
			var rubros = datos_informe.VC_Rubros.split(",");
			datos_informe_pdf = [];
			datos_informe_pdf.periodo = datos_informe.TX_Periodo;
			datos_informe_pdf.anio = datos_informe.IN_Anio;
			datos_informe_pdf.tableInicialyAdiciones = [];
			datos_informe_pdf.tableInicialyAdiciones.push(
				['INICIAL Y ADICIONES','IDARTES','ASOCIADO','TOTAL APORTES','% APORTE ASOCIADO FRENTE AL APORTE DE IDARTES'],
				);
			datos_informe_pdf.tableDesembolso = [];
			datos_informe_pdf.tableDesembolso.push(
				['DESEMBOLSO','DESEMBOLSOS ANTERIORES','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE','VALOR'],
				);
			datos_informe.desembolsoFinal = 0;
			$.each(datos_informe.desembolsos, function (posicion, desembolso) {
				datos_informe.desembolsoFinal++;
				desembolso.TX_Datos = JSON.parse(desembolso.TX_Datos);
				contieneTotal = false;
				if (JSON.stringify(desembolso.TX_Datos).includes("TX_TDT_")) contieneTotal = true;
				desembolsoData = [];
				if (!contieneTotal){
					desembolsoData.push(desembolso.IN_Numero_Desembolso);
				}
				else
				{
					desembolsoData.push('Total Desembolsos');
				}
				$.each(desembolso.TX_Datos, function (key, value) {
						// if(!(key.includes("TX_TD_1_")) && !(key.includes("TX_TD_2_")) && !(key.includes("TX_TDT_1_")) && !(key.includes("TX_TDT_2_")))
						// {
							desembolsoData.push(formatMoney(parseFloat(value),''));
						// }
					});
				datos_informe_pdf.tableDesembolso.push(desembolsoData);
			});

				/*datos_informe_pdf.ejecucionAnterior = formatMoney(parseFloat(datos_informe.desembolsos[0].TX_ejecucion_anterior),'');
				console.log(datos_informe_pdf.ejecucionAnterior);
				datos_informe_pdf.ejecucionAnterior = datos_informe_pdf.ejecucionAnterior != " "  && datos_informe_pdf.ejecucionAnterior != "" ? datos_informe_pdf.ejecucionAnterior : '0';*/
				datos_informe_pdf.tableAportesIdartes = [];
				datos_informe_pdf.tableAportesIdartes.push(
					['ITEMS PRESUPUESTO ORGANIZACIÓN','IIF','CANTIDAD','UNIDAD DE MEDIDA','PRESUPUESTO INICIAL','ADICIONES','FECHA','TRASLADOS','FECHA','TOTAL PRESUPUESTO','ACUMULADO PERIODOS ANTERIORES',
					'ENERO\n   '+datos_informe.TX_Grupos.TX_Grupos_Enero,
					'FEBRERO\n   '+datos_informe.TX_Grupos.TX_Grupos_Febrero,
					'MARZO\n   '+datos_informe.TX_Grupos.TX_Grupos_Marzo,
					'ABRIL\n   '+datos_informe.TX_Grupos.TX_Grupos_Abril,
					'MAYO\n   '+datos_informe.TX_Grupos.TX_Grupos_Mayo,
					'JUNIO\n   '+datos_informe.TX_Grupos.TX_Grupos_Junio],
					);

				datos_informe_pdf.tableAportesIdartes2 = [];
				datos_informe_pdf.tableAportesIdartes2.push(
					['ITEMS PRESUPUESTO ORGANIZACIÓN','IIF','CANTIDAD','UNIDAD DE MEDIDA','PRESUPUESTO INICIAL','ADICIONES','FECHA','TRASLADOS','FECHA','TOTAL PRESUPUESTO',
					'JULIO\n   '+datos_informe.TX_Grupos.TX_Grupos_Julio,
					'AGOSTO\n   '+datos_informe.TX_Grupos.TX_Grupos_Agosto,
					'SEPTIEMBRE\n   '+datos_informe.TX_Grupos.TX_Grupos_Septiembre,
					'OCTUBRE\n   '+datos_informe.TX_Grupos.TX_Grupos_Octubre,
					'NOVIEMBRE\n   '+datos_informe.TX_Grupos.TX_Grupos_Noviembre,
					'DICIEMBRE\n   '+datos_informe.TX_Grupos.TX_Grupos_Diciembre,
					'TOTAL ACUMULADO',
					'SALDO FINAL DISPONIBLE'],
					);
				datos_informe_pdf.tableAportesAsociado = [];
				datos_informe_pdf.tableAportesAsociado2 = [];
				datos_informe_pdf.tableAportesAsociado.push(
					['ITEMS PRESUPUESTO ORGANIZACIÓN','ÍTEMS DEL INFORME FINANCIERO','CANTIDAD','UNIDAD DE MEDIDA','PRESUPUESTO INICIAL','ADICIONES','FECHA','TRASLADOS','FECHA','TOTAL PRESUPUESTO','ACUMULADO PERIODOS ANTERIORES','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO'],
					);
				datos_informe_pdf.tableAportesAsociado2.push(
					['ITEMS PRESUPUESTO ORGANIZACIÓN','ÍTEMS DEL INFORME FINANCIERO','CANTIDAD','UNIDAD DE MEDIDA','PRESUPUESTO INICIAL','ADICIONES','FECHA','TRASLADOS','FECHA','TOTAL PRESUPUESTO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE','TOTAL ACUMULADO','SALDO FINAL DISPONIBLE'],
					);
				datos_informe_pdf.finalesIdartes = [];
				datos_informe_pdf.finalesAportes = [];
				var posicionAporte = 0;
				var posicionAporteAsociado = 0;
				$.each(datos_informe.aportes, function (posicion, aporte) {
					if (aporte.IN_Tipo == 1 && aporte.IN_Tabla >0) posicionAporte++;
					if (aporte.IN_Tipo == 2 && aporte.IN_Tabla >0) posicionAporteAsociado++;

					contineneFecha = false;
					esTotal = false;
					aporteInicialyAdiciones =[];
					aporteTotal =[];
					aporteTotal2 =[];
					if (aporte.TX_Datos.includes("SL_")) contineneFecha = true;
					if (aporte.TX_Datos.includes("TX_TA_")) contineneFecha = true;
					if (aporte.TX_Datos.includes("TX_T"+aporte.IN_Tabla+"T_")) esTotal = true;
					if (aporte.TX_Datos.includes("TX_TAT")) esTotal = true;

					aporte.TX_Datos = JSON.parse(aporte.TX_Datos);
					var inicial = 0;
					if (!esTotal) {
						$.each(aporte.TX_Datos, function (key, value) {
							inicial++;
							
							if(key.includes("TX_AD") && key.substring(key.length-1,key.length)==1 && inicial==1){
								aporteInicialyAdiciones.push("INICIAL");
							}
							if(key.includes("TX_AD") && key.substring(key.length-1,key.length)>1 && inicial==1){
								if(key.includes("TX_ADT")){
									aporteInicialyAdiciones.push("TOTAL");
								}
								else{
									aporteInicialyAdiciones.push("ADICIÓN");
								}
							}

							if ((!key.includes("TX_AD") && inicial < 5) || (contineneFecha && (inicial == 7 || inicial == 9))) {
							//if (inicial < 5 || (contineneFecha && (inicial == 7 || inicial == 9))) {
								if((key.includes("SL_T1_2_")) || (key.includes("SL_T2_2_")) || (key.includes("SL_T3_2_")) || (key.includes("SL_T4_2_")) || (key.includes("SL_T5_2_"))|| (key.includes("SL_T6_2_")))
								{
									aporteTotal.push(convenciones[value]);
									aporteTotal2.push(convenciones[value]);
								}else{
									if (!key.includes("Grupos")) {
										aporteTotal.push(value);
										aporteTotal2.push(value);
									}									
								}
							}
							else{
								if(key.includes("TX_AD")){
									aporteInicialyAdiciones.push(formatMoney(parseFloat(value),''));
									//console.log(aporteInicialyAdiciones);
								}
								else{
									if(!(key.includes("_9_")) &&  !(key.includes("_85_")) && !(key.includes("_10_")) && !(key.includes("_11_")) && !(key.includes("_12_")) && !(key.includes("_13_")) && !(key.includes("_14_")))
									{
										aporteTotal2.push(formatMoney(parseFloat(value),''));
									}
									if(!(key.includes("_15_")) && !(key.includes("_16_")) && !(key.includes("_17_")) && !(key.includes("_18_")) && !(key.includes("_19_")) && !(key.includes("_20_")) && !(key.includes("_21_")) && !(key.includes("_22_")) && !(key.includes("_25_")) && !(key.includes("_26_")))
									{
										if (key.includes("_9_")) {
											if (aporte.TX_Datos[key.replace("_9_", "_85_")] == undefined) {
												aporteTotal.push(formatMoney(parseFloat(0),''));
											}
										}
										aporteTotal.push(formatMoney(parseFloat(value),''));
									}
								}
							}
						});
					}
					else
					{
						if (aporte.IN_Tipo == 1){
							datos_informe_pdf.finalesIdartes.push(posicionAporte);
						}
						else{
							datos_informe_pdf.finalesAportes.push(posicionAporteAsociado);
						}
						aporteTotal.push({text:{text: 'TOTAL'},colSpan: 2,});
						aporteTotal2.push({text:{text: 'TOTAL'},colSpan: 2,});
						aporteTotal.push('');
						aporteTotal.push('');
						aporteTotal.push('');
						aporteTotal2.push('');
						aporteTotal2.push('');
						aporteTotal2.push('');
						var j = 0;
						$.each(aporte.TX_Datos, function (key, value) {
							if (j === 2 || j === 3 ) {
								aporteTotal.push('');
								aporteTotal2.push('');
							}
							// if(!(key.includes("TX_T1T_9_")) && !(key.includes("TX_T2T_9_")) && !(key.includes("TX_T3T_9_")) && !(key.includes("TX_T4T_9_")) && !(key.includes("TX_T5T_9_")) && !(key.includes("TX_TAT_9_")) && !(key.includes("TX_T1T_10_")) && !(key.includes("TX_T2T_10_")) && !(key.includes("TX_T3T_10_")) && !(key.includes("TX_T4T_10_")) && !(key.includes("TX_T5T_10_")) && !(key.includes("TX_TAT_10_")))
							// if(!(key.includes("_9_")) &&  !(key.includes("_85_")) && !(key.includes("_10_")))
							// {
								if(!(key.includes("_9_")) &&  !(key.includes("_85_")) && !(key.includes("_10_")) && !(key.includes("_11_")) && !(key.includes("_12_")) && !(key.includes("_13_")) && !(key.includes("_14_")))
								{
									aporteTotal2.push(formatMoney(parseFloat(value),''));
								}
								if(!(key.includes("_15_")) && !(key.includes("_16_")) && !(key.includes("_17_")) && !(key.includes("_18_")) && !(key.includes("_19_")) && !(key.includes("_20_")) && !(key.includes("_21_")) && !(key.includes("_22_")) && !(key.includes("_25_")) && !(key.includes("_26_")))
								{
									if (key.includes("_9_")) {
										if (aporte.TX_Datos[key.replace("_9_", "_85_")] == undefined) {
											aporteTotal.push(formatMoney(parseFloat(0),''));
										}
									}
									aporteTotal.push(formatMoney(parseFloat(value),''));
								}
								j++;
							// }
						});
					}
					if (aporteTotal.length != 0)
					{
						if (aporte.IN_Tipo == 1){
							datos_informe_pdf.tableAportesIdartes.push(aporteTotal);
							datos_informe_pdf.tableAportesIdartes2.push(aporteTotal2);
						}
						else{
							datos_informe_pdf.tableAportesAsociado.push(aporteTotal);
							datos_informe_pdf.tableAportesAsociado2.push(aporteTotal2);
						}
					}
					if(aporteInicialyAdiciones.length > 1){
						datos_informe_pdf.tableInicialyAdiciones.push(aporteInicialyAdiciones);
					}
				});
				// datos_informe_pdf.tableAportesIdartes.push([{text:{text: ''},colSpan: 21,  margin: [0, 2, 0, 2],   border: [false, false, false, false],},'','','','','','','','','','','','','','','','','','','','',''],);
				aportesAux = [];
				aportesAux2 = [];
				aportesAux.push({text:{text: 'TOTAL IDARTES'},colSpan: 2,});
				aportesAux2.push({text:{text: 'TOTAL IDARTES'},colSpan: 2,});
				aportesAux.push('');
				aportesAux.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux2.push('');
				aportesAux2.push('');
				var j = 0;
				$.each(datos_informe.TX_Total_Idartes, function (key, value) {
					if (j === 2 || j === 3 ) {
						aportesAux.push('');
						aportesAux2.push('');
					}
					// if(!(key.includes("TX_TIT_9")) && !(key.includes("TX_TIT_10"))){
						if(!(key.includes("_9")) && !(key.includes("_85")) && !(key.includes("_10")) && !(key.includes("_11")) && !(key.includes("_12")) && !(key.includes("_13")) && !(key.includes("_14")))
						{
							aportesAux2.push(formatMoney(parseFloat(value),''));
						}
						if(!(key.includes("_15")) && !(key.includes("_16")) && !(key.includes("_17")) && !(key.includes("_18")) && !(key.includes("_19")) && !(key.includes("_20")) && !(key.includes("_21")) && !(key.includes("_22")) && !(key.includes("_25")) && !(key.includes("_26")))
						{
							if (key.includes("_9")) {
								if (datos_informe.TX_Total_Idartes[key.replace("_9", "_85")] == undefined) {
									aportesAux.push(formatMoney(parseFloat(0),''));
								}
							}
							aportesAux.push(formatMoney(parseFloat(value),''));
						}
						//console.log(key);
						j++;
					// }
				});
				datos_informe_pdf.tableAportesIdartes2.push(aportesAux2);
				datos_informe_pdf.tableAportesIdartes.push(aportesAux);
				aportesAux = [];
				aportesAux2 = [];
				aportesAux.push({text:{text: 'TOTAL CAJA'},colSpan: 8,});
				aportesAux2.push({text:{text: 'TOTAL CAJA'},colSpan: 8,});
				aportesAux.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				j = 0;
				$.each(datos_informe.TX_Caja, function (key, value) {
					// if(!(key.includes("TX_TCT_9")) && !(key.includes("TX_TCT_10"))){
						if(!(key.includes("_9")) && !(key.includes("_85")) && !(key.includes("_10")) && !(key.includes("_11")) && !(key.includes("_12")) && !(key.includes("_13")) && !(key.includes("_14")))
						{
							aportesAux2.push(formatMoney(parseFloat(value),''));
						}
						if(!(key.includes("_15")) && !(key.includes("_16")) && !(key.includes("_17")) && !(key.includes("_18")) && !(key.includes("_19")) && !(key.includes("_20")) && !(key.includes("_21")) && !(key.includes("_22")) && !(key.includes("_25")) && !(key.includes("_26")))
						{
							if (key.includes("_9")) {
								if (datos_informe.TX_Caja[key.replace("_9", "_85")] == undefined) {
									aportesAux.push(formatMoney(parseFloat(0),''));
								}
							}
							aportesAux.push(formatMoney(parseFloat(value),''));
						}
					// }
				});
				aportesAux2.push('');
				datos_informe_pdf.tableAportesIdartes.push(aportesAux);
				datos_informe_pdf.tableAportesIdartes2.push(aportesAux2);
				aportesAux = [];
				aportesAux2 = [];
				aportesAux.push({text:{text: 'TOTAL EGRESOS'},colSpan: 8,});
				aportesAux2.push({text:{text: 'TOTAL EGRESOS'},colSpan: 8,});
				aportesAux.push('');
				aportesAux.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux2.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				aportesAux.push('');
				aportesAux2.push('');
				j = 0;
				$.each(datos_informe.TX_Egresos, function (key, value) {
					// if(!(key.includes("TX_TET_9")) && !(key.includes("TX_TET_10"))){
						if(!(key.includes("_9")) && !(key.includes("_85")) && !(key.includes("_10")) && !(key.includes("_11")) && !(key.includes("_12")) && !(key.includes("_13")) && !(key.includes("_14")))
						{
							aportesAux2.push(formatMoney(parseFloat(value),''));
						}
						if(!(key.includes("_15")) && !(key.includes("_16")) && !(key.includes("_17")) && !(key.includes("_18")) && !(key.includes("_19")) && !(key.includes("_20")) && !(key.includes("_21")) && !(key.includes("_22")) && !(key.includes("_25")) && !(key.includes("_26")))
						{
							if (key.includes("_9")) {
								if (datos_informe.TX_Egresos[key.replace("_9", "_85")] == undefined) {
									aportesAux.push(formatMoney(parseFloat(0),''));
								}
							}
							aportesAux.push(formatMoney(parseFloat(value),''));
						}
					// }
				});
				aportesAux2.push({text:{text: ''},colSpan: 2});
				aportesAux2.push('');
				datos_informe_pdf.tableAportesIdartes.push(aportesAux);
				datos_informe_pdf.tableAportesIdartes2.push(aportesAux2);

				posicionAporte++;
				posicionAporte++;
				datos_informe_pdf.finalesIdartes.push(posicionAporte);
				posicionAporte++;
				datos_informe_pdf.finalesIdartes.push(posicionAporte);
				posicionAporte++;
				datos_informe_pdf.finalesIdartes.push(posicionAporte);
				datos_informe_pdf.VC_Convenio = datos_informe.VC_Convenio != null ? datos_informe.VC_Convenio : "N/R";
				datos_informe_pdf.VC_Nom_Organizacion = datos_informe.VC_Nom_Organizacion != null ? datos_informe.VC_Nom_Organizacion : "N/R";
				//Evaluación del Estado del Formato.
				if (datos_informe.IN_Aprobacion=='' || datos_informe.IN_Aprobacion===null) {
					datos_informe_pdf.Estado = "Sin Revisar";
				}
				else{
					if (datos_informe.IN_Aprobacion=='1') {
						datos_informe_pdf.Estado = 'Aprobado';
					}
					else
					{
						datos_informe_pdf.Estado = 'No Aprobado';
					}
				}
				console.log(datos_informe_pdf);
				datosPdf = generarPDFProyeccionGasto(datos_informe_pdf);
			}
		});
return datosPdf;
}
function generarPDFProyeccionGasto(datos_informe_pdf) {
	datos_informe_pdf.tableConvenciones = [];
	datos_informe_pdf.tableConvenciones.push(
		['ALM: Alimentación','ALJ: Alojamiento','ALQ: Alquiler','DVU: Divulgación','DPD: Duplicación de documentos','LGE: Logística de eventos','MPF: Materiales para procesos de formación','PD: Personal docente','PC: Piezas comunicativas','PM: Producción de mate','RH: Recurso humano','TDP: Trámite de permisos','TP: Transporte','VE: Vigilancia de eventos'],
		);
	pdfData = {
		pageSize: 'Legal',
		pageOrientation: 'landscape',
		pageMargins:[40,125,40,40],
		header:
		{
			widths: ['20%','65%', '*'],
			margin:40,
			columns: [
			{
				image: 'data:image/png;base64,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',
				height:80,
				width:120,
			},
			{
				text: 'PROYECCIÓN Y SEGUIMIENTO DEL GASTO\nOrganización: '+datos_informe_pdf.VC_Nom_Organizacion+'\nN. Convenio:'+datos_informe_pdf.VC_Convenio,alignment:'center', style: 'header',
			},
			{
				image: 'data:image/jpeg;base64,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',
				height:85,
				width:120,
			}
			]
		},
		content: [
		{
			text: '\nPeriodo:'+datos_informe_pdf.periodo+' - '+datos_informe_pdf.anio+' / Estado: '+datos_informe_pdf.Estado,alignment:'center', style: 'subheader',
		},
		{
			style: 'tableTitulos',
			table: {
				widths: ['100%'],
				body: [
				['APORTE DE IDARTES'],
				]
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableAportes',
			table: {
				body: datos_informe_pdf.tableInicialyAdiciones
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0 || i == datos_informe.tableInicialyAdiciones) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableDesembolso',
			table: {
				body: datos_informe_pdf.tableDesembolso
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0 || i == datos_informe.desembolsoFinal) ?  '#CCCCCC' : null; }
			}
		},
		/*{
			style: 'tableDesembolso',
			table: {
				body: [
				['Ejecución Anterior',datos_informe_pdf.ejecucionAnterior]
				],
			},
			margin: [0, 0, 0, 0],
			layout: {
				fillColor: function (i, node) { return ( i === 0 || i == datos_informe.desembolsoFinal) ?  '#CCCCCC' : null; }
			}
		},*/
		{
			style: 'tableTitulos',
			table: {
				widths: ['100%'],
				body: [
				['PRIMER SEMESTRE'],
				]
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableAportes',
			table: {
				//widths: ['*','2%','*','*','5%','*','5%','*','*','*','*','*','*','*','*'],
				body:
				datos_informe_pdf.tableAportesIdartes
			},
			layout: {

				fillColor: function (i, node) { return ( i === 0 || datos_informe_pdf.finalesIdartes.includes(i)) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableTitulos',
			table: {
				widths: ['100%'],
				body: [
				['SEGUNDO SEMESTRE'],
				]
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableAportes',
			table: {
				body:
				datos_informe_pdf.tableAportesIdartes2
			},
			layout: {

				fillColor: function (i, node) { return ( i === 0 || datos_informe_pdf.finalesIdartes.includes(i)) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableTitulos',
			table: {
				widths: ['100%'],
				body: [
				['CONVENCIONES ÍTEMS DEL INFORME FINANCIERO (IIF)']
				]
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableAportes',
			table: {
				body:
				datos_informe_pdf.tableConvenciones
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#ffffff' : null; }
			}
		},
		{
			style: 'tableTitulos',
			table: {
				widths: ['100%'],
				body: [
				['APORTE DEL ASOCIADO'],
				]
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableTitulos',
			table: {
				widths: ['100%'],
				body: [
				['PRIMER SEMESTRE'],
				]
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableAportes',
			table: {
				//widths: ['*','*','*','*','*','*','*','*','*','*','*','*','*','*','*'],
				body:
				datos_informe_pdf.tableAportesAsociado

			},
			layout: {
				fillColor: function (i, node) { return ( i === 0 || datos_informe_pdf.finalesAportes.includes(i)) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableTitulos',
			table: {
				widths: ['100%'],
				body: [
				['SEGUNDO SEMESTRE'],
				]
			},
			layout: {
				fillColor: function (i, node) { return ( i === 0) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableAportes',
			table: {
				body:
				datos_informe_pdf.tableAportesAsociado2

			},
			layout: {
				fillColor: function (i, node) { return ( i === 0 || datos_informe_pdf.finalesAportes.includes(i)) ?  '#CCCCCC' : null; }
			}
		},
		{
			style: 'tableRepresentante',
			table: {
				widths: ['50%'],
				body: [
				[{text:"",border:[false,false,false,false]}],
				[{text:'________________________________________________',border:[false,false,false,false],margin:[5,0,0,0]}],
				[{text:'Representante Legal',border:[false,false,false,false],margin:[5,0,0,0]}],
				[{text:'Nombre:',border:[false,false,false,false],margin:[5,0,0,0]}],

				]
			},
		}
		],
		styles: {
			header: {
				fontSize: 18,
				bold: true,
				margin: [0, 0, 0, 10]
			},
			subheader: {
				fontSize: 13,
				bold: true,
				margin: [0, 10, 0, 5]
			},
			tableDesembolso: {
				fontSize: 8,
				margin: [0, 5, 0, 8]
			},
			tableAportes: {
				fontSize: 7,
				margin: [0, 0, 0, 10]
			},
			tableRepresentante: {
				fontSize: 10,
				margin: [0, 0, 0, 10]
			},
			tableTitulos: {
				fontSize:11,
				margin: [0, 10, 0, 6]
			},
			tableHeader: {
				bold: true,
				fontSize: 13,
				color: 'black'
			}
		},
	}
	return pdfData;
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

}); //////////// END DOCUMENT READY ////////////
