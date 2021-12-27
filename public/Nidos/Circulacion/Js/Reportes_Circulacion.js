var url_ok_obj = '../../../src/CirculacionNidos/Controlador/RegistroBeneficiariosController.php';
var url_asis = '../../../src/Beneficiarios/Controlador/RegistroAsistenciaController.php';
var url_aten_vir = '../../../src/CirculacionNidos/Controlador/AtencionesVirtualesController.php';
var url_ofer_cir = '../../../src/CirculacionNidos/Controlador/OfertaCirculacionController.php';      

var options_mes = "";

$(document).ready(function() {
	getMes();
	getTipoPersona();

	$("#SL_Mes_Reporte_Beneficiarios").html(options_mes).selectpicker("refresh");
	$("#SL_Mes_Reporte").html(options_mes).selectpicker("refresh");
	$("#SL_Mes_Reporte_Atenciones_virtuales").html(options_mes).selectpicker("refresh");
	$("#SL_Mes_Reporte_Pandora").html(options_mes).selectpicker("refresh");
	$("#SL_Mes_Reporte_Pdf").html(options_mes).selectpicker("refresh");
	$("#SL_Dupla").html(getEquiposCirculacion).selectpicker("refresh");
	$("#SL_Mes_Reporte_Beneficiarios").change(function() {
		$("#SL_Evento_Consulta_Beneficiarios").html(getEventosEquipo($("#SL_Mes_Reporte_Beneficiarios").val())).selectpicker("refresh");
	}).selectpicker("refresh");

	var tabla_reporte_evento_beneficiarios = $("#tabla-reporte-evento-beneficiarios").DataTable({
		autoWidth: false,
		responsive: true,
		pageLength: 100,
		paging: false,
		info: false,
		dom: 'Bfrtip',
		buttons: [
		'excel'
		],
		"language": {
			"lengthMenu": "Ver _MENU_ registros por página",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		}
	});

	tabla_config = {
		paging: false,
		scrollX: true,
		scrollCollapse: true,
		fixedColumns:{
			leftColumns: 3,
		},
		scrollY: "600px",
		dom: 'Bfrtip',
		buttons: [
		'excel'
		],
		"language": {
			"lengthMenu": "Ver _MENU_ registros por página",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		}
	};

	tabla_reporte_evento = $("#tabla-reporte-evento").DataTable(tabla_config);
	tabla_reporte_pandora = $("#tabla-reporte-pandora").DataTable(tabla_config);
	tabla_reporte_atenciones_virtuales = $("#tabla-reporte-atenciones-virtuales").DataTable(tabla_config);

	function getTipoPersona() {
		var datos = {
			funcion: 'getTipoPersona',
			'p1': parent.idUsuario
		};
		$.ajax({
			url: url_asis,
			type: 'POST',
			data: datos,
			dataType: 'json',
			success: function(data) {
				tipo_persona = data['FK_Tipo_Persona'];
			},
			async: false
		});
	}

	function getMes(){
		var datos = {
			funcion: 'getOptionsMes'
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			success: function(data) {
				options_mes += data
			},
			async: false
		});
		return options_mes;
	}

	function getEventosEquipo(select_mes){
		var mostrar = "";
		var datos = {
			funcion: 'consultarEventosEquipo',
			'p1': select_mes,
			'p2': parent.idUsuario,
			'p3': tipo_persona
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			success: function(data) {
				mostrar += data
			},
			async: false
		});
		return mostrar;
	}

	function getEquiposCirculacion() {
		var mostrar = "";
		var datos = {
			funcion: 'getOptionsEquipos'
		};
		$.ajax({
			url: url_ofer_cir,
			type: 'POST',
			data: datos,
			success: function(data) {
				mostrar += data
			},
			async: false
		});
		return mostrar;
	}

	$('#form-reporte-evento-beneficiarios').on('submit', function (event) {
		event.preventDefault();
		$("#div-reporte-evento-beneficiarios").show();
		tabla_reporte_evento_beneficiarios.clear().draw();
		var datos = {
			funcion: 'getReporteBeneficiariosEvento',
			'p1':  $("#SL_Evento_Consulta_Beneficiarios").val(),
			'p2': $("#SL_Mes_Reporte_Beneficiarios").val()
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			dataType: 'html',
			success: function(data) {
				tabla_reporte_evento_beneficiarios.rows.add($(data)).draw();
				$($.fn.dataTable.tables(true)).DataTable()
				.columns.adjust()
				.responsive.recalc()
			},
			async: false
		});
	});

	$('#form-reporte-consolidado').on('submit', function (event) {
		event.preventDefault();
		getReporteEvento();
	});

	function getReporteEvento(){
		$("#div-reporte-evento").show();
		tabla_reporte_evento.clear().draw();

		var datos = {
			funcion: 'getReporteEvento',
			'p1': $("#SL_Mes_Reporte").val(),
			'p2': ""
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			success: function(data) {
				tabla_reporte_evento.rows.add($(data)).draw();
			},
			async: false
		});
	}

	function getReportePdf(){
		var mostrar = ""
		var datos = {
			funcion: 'getReportePdf',
			p1: $("#SL_Dupla").val(),
			p2: $("#SL_Mes_Reporte_Pdf").val(),
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			dataType: 'json',
			success: function(data) {
				mostrar = data;
			},
			error: function(){

			},
			async: false
		});
		return mostrar;
	}

	$('#form-reporte-atenciones-virtuales').on('submit', function (event) {
		event.preventDefault();
		$("#div-reporte-atenciones-virtuales").show();
		
		tabla_reporte_atenciones_virtuales.clear().draw();
		var datos = {
			funcion: 'consultarTotalAtencionesMes',
			'p1': $("#SL_Mes_Reporte_Atenciones_virtuales").val()
		};
		$.ajax({
			url: url_aten_vir,
			type: 'POST',
			data: datos,
			success: function(data) {
				tabla_reporte_atenciones_virtuales.rows.add($(data)).draw();
			},
			async: false
		});
	});

	$('#form-reporte-pandora').on('submit', function (event) {
		event.preventDefault();
		$("#div-reporte-pandora").show();

		tabla_reporte_pandora.clear().draw();
		var datos = {
			funcion: 'getReportePandora',
			'p1': $("#SL_Mes_Reporte_Pandora").val()
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			success: function(data) {
				tabla_reporte_pandora.rows.add($(data)).draw();
			},
			async: false
		});
	});

	$("#tabla-reporte-evento").on("click", ".aprobar", function(){
		let texto = $(this).attr("data-texto");
		let texto_confirmacion;
		texto_confirmacion = $(this).attr("data-texto") == "aprobar" ? "aprobó" : "desaprobó"

		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'Aprobar evento',
			html: "<small>¿Está seguro que quiere "+texto+" el evento?</small>",
			type: 'warning',
			confirmButtonText: 'Si',
			cancelButtonText: 'No',
			showCancelButton: true, 
			width: 800,
		}).then(() => {
			$.ajax({
				url: url_ok_obj,
				type: 'POST',
				data: {
					funcion: "aprobarEvento",
					p1: $(this).attr("data-id-evento"),
					p2: $(this).attr("data-estado")
				},
				success: function(data) {
					parent.swal("Operación exitosa", "Se "+texto_confirmacion+" el evento", "success");
					getReporteEvento();
				},
				error: function(data){
					parent.swal("Error", "No se pudo "+texto+" el evento, por favor vuelva a intentarlo", "error");
				},
				async: false
			}); 
		},(confirm) => {
			if (confirm == "cancel"){
			}
		}).catch(parent.swal.noop);
	});

	$('#form-reporte-pdf').on('submit', function (event) {
		event.preventDefault();
		datos_pdf = getReportePdf();

		let texto_mes = $("#SL_Mes_Reporte_Pdf option:selected").text().substring(0,1).toUpperCase() + $("#SL_Mes_Reporte_Pdf option:selected").text().substring(1).toLowerCase();
		let nombre_equipo_temporal = $("#SL_Dupla option:selected").text().substring(0, $("#SL_Dupla option:selected").text().indexOf(" -- "));
		let nombre_equipo = nombre_equipo_temporal.substring(0,1).toUpperCase() + nombre_equipo_temporal.substring(1).toLowerCase();

		datos_pdf.nombre_equipo = nombre_equipo;
		datos_pdf.infoequipo = [];
		datos_pdf.infobasica = [];
		datos_pdf.asistencianuevos = [];
		datos_pdf.enfoquenuevos = [];
		datos_pdf.asistenciatotal = [];
		datos_pdf.enfoquetotal = [];

		datos_pdf.infoequipo.push({
			table: {
				widths: [80,80,80,"*"],
				body: [
				[{text: "EQUIPO:", fontSize: 9.5, bold: true},{text: nombre_equipo, fontSize: 9.5},{text: "ARTISTAS:", fontSize: 9.5, bold: true},{text: datos_pdf["ARTISTAS"], fontSize: 9.5}],
				[{text: "TIPO DUPLA:", fontSize: 9.5, bold: true},{text: "Circulación", fontSize: 9.5},{text: "TERRITORIO:", fontSize: 9.5, bold: true},{text: datos_pdf["TERRITORIO"], fontSize: 9.5}],
				[{text: "GESTOR:", fontSize: 9.5, bold: true},{text: datos_pdf["GESTOR"], fontSize: 9.5},{text: "EAAT:", fontSize: 9.5, bold: true},{text: datos_pdf["EAAT"], fontSize: 9.5}]
				]
			},
		});

		datos_pdf.infobasica.push({
			table: {
				widths:[99,"*","*",99],
				body: [
				[{text: "NÚMERO DE GRUPOS", style: "header"},{text: "NÚMERO DE EXPERIENCIAS", style: "header"},{text: "BENEFICIARIOS ATENDIDOS", style: "header"},{text: "MES REPORTE", style: "header"}],
				[{text: datos_pdf["TOTAL_GRUPOS"], style: "text", alignment: "center"},{text: datos_pdf["TOTAL_EXPERIENCIAS"], style: "text", alignment: "center"},{text: datos_pdf["TOTAL_R"], style: "text", alignment: "center"},{text: texto_mes, style: "text", alignment: "center"}],
				]
			}
		});

		datos_pdf.asistencianuevos.push({
			table: {
				widths: [45,45,60,45,45,60,70,"*"],
				body: [
				[{colSpan: 3, text: "TOTAL NIÑOS", style: "header"},{},{},{colSpan: 3, text: "TOTAL NIÑAS", style: "header"},{},{},{rowSpan: 2, text: "\nGESTANTES", style: "header"},{rowSpan: 2, text: "\nTOTAL", style: "header"}
				],
				[{text: "Niños de\n1 a 3", style: "header"},{text: "Niños de\n4 a 6", style: "header"},{text: "Niños fuera\nde rango", style: "header"},{text: "Niñas de\n1 a 3", style: "header"},{text: "Niñas de\n4 a 6", style: "header"},{text: "Niñas fuera\nde rango", style: "header"},{},{}],
				[{text: datos_pdf["NINOS_DE_0_3_ANIOS_N"], style: "text", alignment: "center"},{text: datos_pdf["NINOS_DE_4_6_ANIOS_N"], style: "text", alignment: "center"},{text: datos_pdf["NINOS_FUERA_RANGO_N"], style: "text", alignment: "center"},{text: datos_pdf["NINAS_DE_0_3_ANIOS_N"], style: "text", alignment: "center"},{text: datos_pdf["NINAS_DE_4_6_ANIOS_N"], style: "text", alignment: "center"},{text: datos_pdf["NINAS_FUERA_RANGO_N"], style: "text", alignment: "center"},{text: datos_pdf["GESTANTES_N"], style: "text", alignment: "center"},{text: datos_pdf["TOTAL_N"], style: "text", alignment: "center"}]
				]
			}
		});

		datos_pdf.enfoquenuevos.push({
			table: {
				widths:[99,140,140,99],
				body: [
				[{text: "Afrodescendientes", style: "header"},{text: "Comunidad rural o campesina", style: "header"},{text: "Condición de discapacidad", style: "header"},{text: "Conflicto armado", style: "header"}],
				[{text: datos_pdf["AFRODESCENDIENTE_N"], style: "text", alignment: "center"},{text: datos_pdf["CAMPESINA_N"], style: "text", alignment: "center"},{text: datos_pdf["DISCAPACIDAD_N"], style: "text", alignment: "center"},{text: datos_pdf["CONFLICTO_N"], style: "text", alignment: "center"}],
				[{text: "Indígenas", style: "header"},{text: "Menores privados de la libertad", style: "header"},{text: "Raizales", style: "header"},{text: "Rom", style: "header"}],
				[{text: datos_pdf["INDIGENA_N"], style: "text", alignment: "center"},{text: datos_pdf["PRIVADOS_N"], style: "text", alignment: "center"},{text: datos_pdf["RAIZALES_N"], style: "text", alignment: "center"},{text: datos_pdf["ROM_N"], style: "text", alignment: "center"}],
				]
			}
		});

		datos_pdf.asistenciatotal.push({
			table: {
				widths: [45,45,60,45,45,60,70,"*"],
				body: [
				[{colSpan: 3, text: "TOTAL NIÑOS", style: "header"},{},{},{colSpan: 3, text: "TOTAL NIÑAS", style: "header"},{},{},{rowSpan: 2, text: "\nGESTANTES", style: "header"},{rowSpan: 2, text: "\nTOTAL", style: "header"}
				],
				[{text: "Niños de\n1 a 3", style: "header"},{text: "Niños de\n4 a 6", style: "header"},{text: "Niños fuera\nde rango", style: "header"},{text: "Niñas de\n1 a 3", style: "header"},{text: "Niñas de\n4 a 6", style: "header"},{text: "Niñas fuera\nde rango", style: "header"},{},{}],
				[{text: datos_pdf["NINOS_DE_0_3_ANIOS_R"], style: "text", alignment: "center"},{text: datos_pdf["NINOS_DE_4_6_ANIOS_R"], style: "text", alignment: "center"},{text: datos_pdf["NINOS_FUERA_RANGO_R"], style: "text", alignment: "center"},{text: datos_pdf["NINAS_DE_0_3_ANIOS_R"], style: "text", alignment: "center"},{text: datos_pdf["NINAS_DE_4_6_ANIOS_R"], style: "text", alignment: "center"},{text: datos_pdf["NINAS_FUERA_RANGO_R"], style: "text", alignment: "center"},{text: datos_pdf["GESTANTES_R"], style: "text", alignment: "center"},{text: datos_pdf["TOTAL_R"], style: "text", alignment: "center"}]
				]
			}
		});

		datos_pdf.enfoquetotal.push({
			table: {
				widths:[99,140,140,99],
				body: [
				[{text: "Afrodescendientes", style: "header"},{text: "Comunidad rural o campesina", style: "header"},{text: "Condición de discapacidad", style: "header"},{text: "Conflicto armado", style: "header"}],
				[{text: datos_pdf["AFRODESCENDIENTE_R"], style: "text", alignment: "center"},{text: datos_pdf["CAMPESINA_R"], style: "text", alignment: "center"},{text: datos_pdf["DISCAPACIDAD_R"], style: "text", alignment: "center"},{text: datos_pdf["CONFLICTO_R"], style: "text", alignment: "center"}],
				[{text: "Indígenas", style: "header"},{text: "Menores privados de la libertad", style: "header"},{text: "Raizales", style: "header"},{text: "Rom", style: "header"}],
				[{text: datos_pdf["INDIGENA_R"], style: "text"},{text: datos_pdf["PRIVADOS_R"], style: "text"},{text: datos_pdf["RAIZALES_R"], style: "text"},{text: datos_pdf["ROM_R"], style: "text"}],
				]
			}
		});
		generarPdf(datos_pdf);
	});
	//
	function generarPdf(datos_pdf){
		var dd = {
			content: [
			{
				table: {
					widths: [100,"*","*",90],
					body: [
					[{rowSpan: 2, image: "logo_alcaldia", width: 100, alignment: "center"},{colSpan: 2, text: "ARTE PARA LA PRIMERA INFANCIA - PROGRAMA NIDOS IDARTES", alignment: "center", style: "header"},{},{rowSpan: 2, image: "logo_nidos", width: 80, alignment: "center"}],
					["",{colSpan: 2, text: "CONSOLIDADO MENSUAL EVENTOS POR EQUIPO", alignment: "center", style: "header"},{},""],
					]
				},
			},
			{
				text: "INFORMACIÓN DEL EQUIPO",
				alignment: "center",
				margin: [0, 15, 0, 5],
				bold: true,
				fontSize: 12
			},
			datos_pdf.infoequipo,
			{
				text: "INFORMACIÓN BÁSICA",
				alignment: "center",
				margin: [0, 15, 0, 5],
				bold: true,
				fontSize: 12
			},
			datos_pdf.infobasica,
			{
				text: "ASISTENCIA BENEFICIARIOS NUEVOS",
				alignment: "center",
				margin: [0, 20, 0, 5],
				bold: true,
				fontSize: 12
			},
			datos_pdf.asistencianuevos,
			{
				text: "ENFOQUE DIFERENCIAL",
				alignment: "center",
				margin: [0, 10, 0, 5],
				bold: true,
				fontSize: 12
			},
			datos_pdf.enfoquenuevos,
			{
				text: "ASISTENCIA TOTAL BENEFICIARIOS",
				alignment: "center",
				margin: [0, 20, 0, 5],
				bold: true,
				fontSize: 12
			},
			datos_pdf.asistenciatotal,
			{
				text: "ENFOQUE DIFERENCIAL",
				alignment: "center",
				margin: [0, 10, 0, 5],
				bold: true,
				fontSize: 12
			},
			datos_pdf.enfoquetotal
			],
			images:{
				logo_nidos: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAigAAAEECAYAAAACi89VAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAOEVJREFUeNrsnX+QHMd13/sORwAkQd1BAin+1C0kWT8s2beIqNCSKN4CJf84q2QsLVc5Fca5hZyUXVKKWDiVChRX6fbyj5kqOdhjqpSkKiXMVRKVy1Uu7klmTo4SYo6SkyiyjT1HtiwrJPZCWhAlmrylSBFHAbz023mDm5ubnemZ6ZmdH99P1WBxu7OzPd093d9+/fr12Pb2tgAAAADyzNaJs1PypSqPmsfHPXl0DzzxSBc5lR/GIFAAAADkVJTU5UudRcm0wlc25NGUQqWD3INAAQAAAHSKErKSNFmYTEa4BImUhhQpJnITAgUAAACIK0xq8qUlj9mIl1ij70OYQKAAAAAAWRAmxIoUJnXkZr6YQBYAAADIoDAhp9e2POY1XK6BHM0fsKAAAADImjgha4chovmYuFk+8MQjECg5ZBxZAAAAIEPihKwmj2kSJ4SJXM0nmOIBAACQBWFCUzq0/HdW86V7yF0IFAAAACCqODHlMZPA5SFQcgqmeAAAAIyaTkLiRBx44hEIFAgUAAAAIBzsczKLnABusIoHAADAqMQJrdZ5LOGfOQorSj6BBQUAAMAoxAn5nRgp/FQFuQ2BAgAAAKhCUzuTyAYwDKziAQCAvNKZIyuEvZtvxfFJlw9T1Fd7WUs2b/g3n9LPVQVioUCgAAAASE2YNPnwskLMOs5dEWStqK9mqZNup/hbU6gw+QRTPAAAkC9xYlsEFoTaFMlJeVyQ3+vKozbq5LP1JMlVO8eFtXOxTRWVBgIFAABAOuLEHTOErCSLjmNZHhuuc2ZYqHTkURnhXTSTvPiBJx6h/HFaaCqoOPkEy4wBACBf4sRpNVkU1vTNps93SBC4/T36g/frq0aat8Ard3oiWefYY/wbLzpEyxgqEAQKAACAZAQKOb06LScPSoFhW0NIhDinMnosZjoD8WKdQ1aFk66rLsvPGykKFPqt8wn/zBkpSNrytygPpm3RIt/rohLlC0zxAABA9sVJS+yd1qnL90l0XJLHaWH5ddjHPAuBHn93UwqR+kDUWNYTm3n5uZHindRS+I0KvzoFCRxlIVAAAABoFif2ih038yxM/KCplAUWKvWBxcWytKy7RIqZ0t3UU/iNqodAqaEiQaAAAADQS0PE99mg7z/G1pJN7rCdK11mk7akbJ04WxHpBGab9RAoAAIFAABAAgJFF2R1MQf/q6+SSFne9VmyIqWScr45HYdrqEYQKAAAAHRhObfOaL7qzECk0NSR5SC75hIpjYTuJjWRsHXiLP0WLCgQKAAAABIiqSBjOyLF8gtx+qS0eXlyrjnwxCObqD4QKAAAAPIlUHZEikVN7KzuIT8Rg8ULABAoAAAA9lBJ+PokUuxAbzXX+80C5eMsqhIECgAAgPwIFIL8TiiqLPlsnHG8v1CEqR5mHVUJAgUAAED+ODfYSLC+SoHfnE6zOncdHqVPCPxRIFAAAADkFNvvpCF2/FFmNe6AnOaqmi6v5AEQKAAAAHIO7VvTEvXVnktMtHRcnHcZTpOK4/+woECgAAAAyDGnOVib0/dkVqMvykpK90Eh/Z2bEiImCgQKAAAAjfRG8JsUbdYdkr6iUTikgXvVjomqlD/Gtre3kQsAAJBFrJ2IF0acimWOOKuFrRNnSXRNp3kDB554ZGxUmXfHA6ftzR4bjvumVUWty08udVDJhwMLCgAAZJfeiH9/Xac4YdKOr7I8ImFSk4ch//sii0ynKKM4M4/Jz1uo4sOBBQUAALKKtYLmwoh+fUOQL4oVxI063Ip82ZSj/tgOp1snzpLl4GRK93E8LQddtpbUWYTN7BJ6lqPulNi7t9JRmac9VPa9TCALAAAgo9RXab+cUfxyf9DR7ogT6lhJVJhCjwWkwdeaSfg+VtIQJyzeWixObP8diidjUL45RR2f23HcO32njcoOgQIAAHljPYWO3I0dWdbG4DTMyA62HXfETxv5cZySJEXKOguhJIVJg3/D6ZRLwoT8S0w+p0rTPcKynpAFqs1/91jMYM+jIcAHBQAAsk3aS2QXpTgxHJ0wje6d0zGtmJ36lC1ShLX/TxI+IiROaknsaEwWEPIdkQdd+7xLnJySAoTuqUviRR4kQi4KitRr+aGcI78UtqjYaeuhinsDHxQAAMgynbmG2B3TI0lWpDipuywEXr99OIovClkThDW9UZffvy68tk6ctac5dKzuWSIRpVuc3L/6OKWx8fxX/qra/5P/Nyydp/iV7mXS53Ibjns9rMOvp4hgigcAADIuUVISKLumRFhMDPtd8kNpRfiNGnfMprx+3Z4GkWKC7rEjhUqDrxtWqJDPjEHCQF5Lm0VCihI79H/TTtPYxL6+z1dUy8m+vxWIk+HAggIAAJmXKHNkbVD11TgurEiw50J28FUOc2+LE9PHCkDnV8J2rvK6dE3nlMiivMYeoSOFSpWFQVXsDbpmQ74elC8mCxxtSGFSZVEy7/7slb/+vvjeH2ibdaMpIQMVHAIFAADyKlCaioJjQ4qMCn+HphlOK4saWjEkrvuImAqC6Aw5fIYQJ3TdFz3TLMWIbU0ZFWwt8VoivIur/VfFxue+qutnMb3jA5xkAQAg+6h23j3H/8ky0Vf4zhlbnDh+S8VaE3a5cW3I+zTdcYGsK7y6JTQkfthxNc4SaBIn54PufWLyRrH/yKHXNJQppncgUAAAIOdYS37XQwkZK4ZJkIWDwti3HR29IdSnkqbZiTauQLGZZaFCK2CaHC8kSJhUeZURCTNaJRNnqqeieuLUfZX9GkoVYe4DgJMsAADkAxIP50J+hzpvsip4+ZLsCmPPYdfnh432HddyLjlucLpULRQqzPB90pLcDRYfpofYqbruaz2tiKy3/PSd4oWv/t/Xr750Jc4gHwIlAFhQAAAgH6h0aLuDfg23ovSFw6LBlhC/TQnb7CNC52043p9VtHTQOVGWENN3ZjltzmPWQ3QZMfM3VMC02z723jj9J6Z3IFAAAKAgWCtsVgLOqnq8Z3iKk50w9n7LiXddlztVt1BS8fuop5BDcS0S1TAn3/iWN4rJ979lVGmFQAEAAJApwu/ZslfYXA9jz5YNU+EqTTsCrAcNhe/XEs6X9VFsuHfkI++SQuVw2K/1IVAgUAAAoFhYq202InzT4NclO4y9YwPASYXv01RLlx1S3UuXJxWcZZPeudhQPdGx4kfLHji3f/xYWJHSwfQOBAoAABSRVgRh02Fx4pyOce6oq8K0GB5Xpe4jCDIzveOI8bLgkebZSJ3owQlx50PvDzPdA+sJBAoAABQS6uD6ob/lECe8nHhWY5pO+jjL1hLOD6XpHY8AdBWdiaDpnjsfujfImtKXaYVAgUABAIACYjm3Ru7keDpmPomUhXxfF0YEcZII5DhL1pTpT35YvOnEO64cvGvymbHxsR+5xCVQBHFQAAAgfxhRRIbiih1VaC+cithZPkzCp+36PefnSdGJK07uX328prVjnbyRgrkdlMc99PfrV66Kre+/JK6+dOXLqLrqwIICAAB5w3KWXRYhpnocHbUONi4/uVSTBwkQO8LtDAugXSlNOCd8p3fSspwEdrQHJ8i60l//Z//491B5IVAAAKDoIqUhLAvGoopQ0bxyxCkKnFaThuu8WsK50M66OHGA6R0IFAAAKD4DawX5o9RXWw6h0k2pk6wOEStui0nSy4s7McSJOeR+IFAyAnxQAAAgnxiyIyarSOvyk4Mpn5bCd8jioMNBlmKfGJefXGqI3ZFkaQPBqny/m8LyYs9w8REtJ3SdNdffXRZcOiww/a/NfRQCBQIFAABKAXV4FM+DdgAmP5Am75czFBYOFOhNh+PqvLyWl9ipOTr3VC0SIcXJdXEjxYMhvFcDte5ffZxE2HndaQXBYIoHAADyiVOMzLBQUdkXJ+nOsuEQKqkJlLCWExJrKuexeNmImdY2qisECgAAlIIga4kPRsJJm+HpnSSXF3tN74SNjBuGXozvbkiR00WNhUABAIAyE9gRsuVgI+F0JG0xcFtPSHSFiYy7nmKZYHonIvBBAQCAYtAPYVWhTvN0gmlJLTgbi5Owjr+DDQPpVeys4CGLjJFAKHoDVTMasKAAAEAxCNOx5rnTvD69E1Gc2AJqgUXaLB+0JPqxIXsKRZ2iwfQOBAoAAJQL3lPHifK0Ck/z9HN6652Y4iSIhsd7m3HSCqKBKR4AAMifOKm6BMmS6qoUV+c5n8Pb7yQoTsKy7hAvduwUJwZqKwQKAACURZzUueObdHSSrYij+7wJlBWhL9hcGCi/TRIhmLKBQAEAAOCNyaN1EihLYhBJNtI+O2YO773mEGZJUXG/IUVJT8RbagwiMLa9vY1cAACAHGE7cvrt5Kt4HRIps8jRXazRTs0B+UZTbFMsZmxB09a8IWPpmbh/9XE7o3OFVLRmXjM9h3meqFmTH3ZqEKr8sFPe2AGXyJGv6xjx0f+7cRtmPx5d3Kp4jaJKRPfhhQNoaDOMxvoPgbIXWoJcE7uXINuCxS+vOiL6ah89dOb82q7uYHPJHDH2of/yh3mtoDQX2ZAdZ+4aUilQ8pbnazKfawmMACksd9SIkzTvbggrboHWOiAFSktYSxDBzgZq1PD2bIEIAVMMeHBwETkRm2XeODENEeIczFVdA7qwzzX1RZssXjI36M+zDwqtWTdpIyc4LeWqQaSHigRAXCc3eiDP0bXkNclpDubVZJj1GjlKEbdhixV6DqVgMZFVuXwWK8iJjIsTS5DYx2xiz3Vnzh74dVm4mFK09EaZsXm2oNjQFEA9T1M+ZbWgcOTGhQTrATkLxg6xDQtK5Pynet1hwdJDlmRSlNS5o0t6rxyIk3iipM5lRMfkCO9vw36mpVhJPaZLEQSKzRnZieZix8iyCRQ2IxsiuY28dqWVHuo41hQIFC3YU3AdiJWRCpIpR0d3EjmSYXHSmaOyomnvRkbFY5/FSictsVIkgTKoMFTAWfdLKZNAYWezTsqjAHqQahECV0GgJAP5ixlSqCCqZnrCpMYd3ahH4BAnwcKkIvRMe6ctVozBUV9NzMWiaHFQqICrUgDU8ug8W8BGkh7g8yP4aWqQTWqko4oUoBUauZ9kvxVq1Npwsk3kebOtJS2B6Zvsi5N8ChNnG3t6cHTmyFralkLF0P0jRdyLh6YReryUF4x2BHd+xA+QydNLIBvYG7T1yEoljylkiR5hwv5dPX7mIE6yL06ovLo5FSdefe55eU+bg/uypqogUAI6p4u0wgfP00gaTBoZdDJSD0weWYJsPZ8QKnqFyYLAVE72xQmtyOnMFbW8rj/X8h7bbCGCQPHhvBQpbTxXqdPJ0MM3KbCjaB6ECgYTECZFFyfUF10Qxbdw2dM/l+Q9G3EsKuMlqFinySlVHhilpdN4UsM5k7Fkzcp0NVE6mW7QzkuR0pUHpuT8ny/qJLsQJqlyJpY4IUtCZ67LnXbZmBeWRSXS1M94STKJVsx04ZeSeONZEdYyuSzSwlRP5iFhe1GKlDamffY+W7xvDnxM0uVUrNhKnbkqC8qZEuehc+onVP8wXqJMooeaLCl1PHPJiYAMj+omMyyewG5opAlryo44oefqksCeOWlD0zpGDHHSEFbwQli6dtrgcwNrkhUdFwLFI4MekyKlhbqivRGlEW/WPdIhUPI1oLjIMWnK+kyR1cSezgHpi5NGTHFyHuLEE7ImXVDxTxkvaQYtSJFiwC9FK40cpHGS5/BBjp5VKVI6ZZvycfiazKAK5FacAH9s/5Q6BIp35tCUTwX1pDQChcAUX/4YbAxahikfXqFjYPQ9MuI6xNYhTsINGoW1IzMEigc0OiHn2RrqSaxGtZKjkR72I8nvs0oipVbg54isRKYoRvCuPKLDIdZANoaCQua3IVD8FdwFBHWLRa46DY5yC3L6rBYxZgpHPO4JTOmMqpM8HtMhlsRlluI/5QUKkb8JgRIMBXWD+o1GJWfpxeqQnD+rRRIp7G9ionMbCbSPTFWKEzPmdajvwPLvcGxIcdLyOwECZTfzUqR04TwbmlrO0ovyhUjJkjiBv8losHc978W6ihXbA1PH4WkFnQCBshfbLwWj7OJSQRZApGRInIDREH+vrp0diUE4NlR2P4ZA8cYO6tZAViiRN4sEBApECsQJsAekcURKW8D6FQUlUQeB4q+usdmg+kMOwChFSg3iBKQqUqxoqJjaCY+S9QQCRQ3abLADvxRf1nOW3k0UWeHo5CFOCsRJoUQKBq/RaKmeCIGixiBQFPxSCtPhd1FkhYMsnkaWI87Kzg9BvIoiUqxosbAch2dN1XoCgRKh8iKoGwQVyPQzamQxYRznxEAR5aIOqVhGMMiJRivMyRAo4UdpFNQNm87txsxZetG4FJeTWdtg0BEhFs6U+WBelpm/SKmvUhuyiKwKBVlPQvUVECjROIfNBnfRg0ABGWIhY/4oECf543TgxqJWkLF1ZJUyoQcOECgxVLawpnwgUvJlQVm//OQSpniKTyZ2QOaROHwV8kmbp+b8aCCblAhtPYFAiQ81PL2yO89yJMa8jCQMVNtSMC1GHECLnWJPoyhyy8Dx2tdpFlM9qkR6FiFQ9FTiiwjqlpuOv4MqWxpOjyo+Cu/wDTFcjEGof+eavameNRZNZ+Rx3HWc4s9WUkzzShTrCTGB+qcNCupW/drcR8vqQEsd/7mMp3E59r4bIG/QFMsoLJyGgN9JYYSuFJydgA0Fqd2/MMI0bnBdN/x2B97bag92YSYRX+cjiTobuU+EBUVzRZYipZR+KdzxL2c8mS1U0fKNgB9d3Ep10CA7M/q9WWR9oQia6jFH2P4tDkR4fbUdSpxY6d6UR0ceDXnQ/T3I99HXNSiU1408KIRA0Q81TGXdbDDLAgDWk/LSSsthlqd2IISLh4pPU0tjx67KqcEUU1hhMlywWGLF2q+MpoM2RtknQKAkV5nJklIv002zAMiiwxg1GohdU14mUyx/bB5XXGiqp+bTufdEuuHvT4WJyhpSqGwOrl1ftYXKWpRBYRzrCQRK8o3iY1KklGo0JUUK3W/WVvQ0sLS49DQfXdyqJPkD3Hlh87hi01b4PA0rynJi4mSvWCGhQnWbnGzDWFRi930QKMmzUMKgbg2RvqlzGItSnGDlDpgUyU+9GMjmwjPjG8DNmmpJw4qS/sCX/Gx2LCpB7ftSXOsJBEp62EHdKmW4WSkIuiIbAYyW2aIDwKCJTcoXhTutaWRxKWgHbCiYtBVlWUfnH0OokBCnvmzYdH5fl4CCQElReQvLebZWEpHSYaU9SnHSQLUDDhLxReHOqo3sRT3iDjxpK4o5eqk/8FEhEXJM7J3Sb+ty2oVASb9i01r5UqzwkQKBlPZxkf50zyLECRhCM6FrwjG2ZPVIwYpSXIGyI1S68qD+zLam9HXeOwTK6IRKKeDgRjWRjuMsPRzHMa0D/J69Rxe3tIlX7qSwQqycbXiQFSWZuCijnN4ZniZqc48N8kTXkmcIFJCSSOnKw1bZSVlTluRRCYj2CIDQLCiSir4JclCPRmhFyR6WNcXQeUkIFJCmUCGVXRW6IxUKcVReu4mlxECRGY1LjlvIztIyyQJ1eIcdLX4IgEABIxIpPfYPoQ6CnGhXIlxmhb97mK6FCLEgyug37gV4t2Ks3Ck3QQLV0P6LnblaWTIXmwWCUQmVTX54DW7s6aEj64ptMqW/6Zwu/00ipIcpHKCJugaRAt8TME1tl0+7RKsZdUcXprpbinYQAgVkRbCYZXnoQDY6lkcXt6oPLxzoRvky77mDDQEB0RjadpHDaGeORMq81t/rzLUz6SyrGUzxAADK3LFEBdYTYDMf4CyrO5L15OCanbnCRyeHQAEAlJVajO/WkX1AqT7QDsH6Vy9S4E+j6CIFAgUAUFYireaRo2XylYJzLHASZFFLYj8w2pjSlCKlsIE/IVAAAGWmFuE7DWQbcItd9ktKU6AMflceF6VIaRXRmgInWRAfejjyhhX5EAASKEbY2oNsAyHrkpnwby8IsuKQ86zGvXAgUEARWMhhmiFQgN2pKIPpHRAgXI0hAyJazUNB25Jc+TXJbfGC/K3lQVrqq2aeMxRTPACAMkPLjcOYxmvIMhCxbqQpFmhZ8wUpVHo8/VOBQAEAgOJ1LBAoQIVJDjiZBYFyXYALy6pySYoUcqht5MlXBQIFAFB2wqyCgEAB0erH6KdbaHrpvKCo3J05Iw+rfyBQAAAQKAqw/wl2LgZxBOx6BtJIdZimgGj1TzfLVhUIFABA2alo6nwACBK73Yyll5YpZ9aqAoECACg7M5o6HwAmA+KhdLOabpFBqwoECgCg9ChGlK0gp0BMIdvNQfozY1WBQAEAADXxgd2LQRkEis1eq0rKIFAbACXmbZNfF0duvCTuvvn/XH/v2Vd+Sjz/6lHxVP8+CBQmwGwPgJpAsQK29UX+nK0tq4odqTalaLUQKACUjAP7XhHVW78kjh35oti/70d7Pr/r0F8MXl+7dpO4+Pwvie4PPia2rt1caoEiML0D1Any3SArSl6tcXa02uZg+ocicicoVDDFA0CJuPXGS+Lvv6Mp7nvz73mKEyf0OZ1H59P3MCoGQIkg8VGEfXJIqJwWlp9KYhsVQqAAUCJx8vG3/ba4Zf8PQn2PzqfvFVykBAmQKdQgoIluge7FtqiQUGlCoAAAQvOG/d8fiIwgq8kw6HsFFylTMT8H4Doc1K9MkFA5x860NQgUAIAyP3vPUmRx4hQpD9z5H8qahZjiAboEb7fA903OtBcGzrQapn0gUAAoOHcf+uZ1x9e40HVo5Q8AIDKbJbhH8k8x48ZQgUABoOhD/yNf0nq9dx9+ApkKAAhihkVKAwIFAODJWzVbPN4KCwoAgeMCZMEA8k05z0uSIVAAADsk5dRawmXH6HBAGPz8LzZLmB/zUqR0wvqlIFAbAAWGgrLl6boZHwkmk5eH9ot3zx0Vb7nvdnHzG28cvPdCry++c+EZ8fRXn0UlLhr1VVrpUsY7PymsKZ+aanA3CBQAABgRJEyO/9N7xb4b9gkxtvP+kbdPiXd8ZFr86IUr4suL/0P8zcXvI7NAEZgJI1IwxQNAgSlBiPpci5OPfPo+sW//bnHi5KY3HhS/vHRCfPA3ZpBhoEgixVA5EQIFgALzg1ePJnLdZ19+b9myck3nxd5w+80Dy4kq73vo3eLnP/MBVOgikFBY+JxxkjcehEABoMw8rXlX4qfLtctxItz/qaplOQkBTfnAkpIbTJ/P4HBtcTpoCTIECgAF56mX7sv09TJCatE9ySn2bbP3RPouWVLuOnYbKjUoChRxtgKBAkBJ+dYLJ8Tzr1a0XIuuQ9crIKkt/YwrMOYWP4RKDYoCrY4zIFAAKDFfeeZ0pq6TQ3q6LnTr2+O5IByctJYlg5wK3vqqKf89JY8+smnA7LCdkCFQACgB5Cz7lWcejilOHk7M6TYDBE3xaBMotDInDmNjY+L+T8KNIctcfnLJvz7VV8lqUJHHIoTKgJaX8zAECgAlgaZmHu99Wrx27aZQ36Pz6XsFndoJHvGqfa7M7e85EvsaBycPiLd++G5U6jxDcUDqqy0IlQE01dOEQAGgxDzVv0984a/bymKDzqPznyr+yp1ewOfdrCX4XT83jQqdTcItSYdQsWm6rSiIJAtAyXjptdsG0zVff+7vDTb+u/vmb4oD+16+/vnWtUPi2VfeO1hOTOeWgYcXDgQJFG0WFApff+Tt8UNhTH/gTlTmbBKtrliRVVvCmu5osEWhTOvKbStKCwIFAAgV0f3BxwZHyVkPOoF8Cu54IFsOwhP794lbf+Kw+MF3XkRlzhbxrW2Wj4oxCAkvBImV+ZLkXcMpUDDFAwAoOz1dQkaFZ7v69tXZf+gGlF4RBcqOUDHlQZ32YXmckcdGwfNuWoqyOgQKAACE61C0dDzPf0dfyJW7qwjalmPBG0aokJ9KWx4V+ddxeSwXOP8gUAAAYBQCZevl17A7cYEJXGIcX6wU3aoCgQIAAKMQKMS3vnwJuV5M1lL7peJaVSbZ9wYCBQBQavoKK3jskbEZ5sK/Mj58M8BvrV4SV/pbsRK+vb0tXvreKyjBbGGO5Fd3W1UoSu16zvMRAgUAgA4liRHyz4yNi8+O7xd3j40NPedrn4tnkKGIshAoECguobI5WAFUX6VQwxT2eUnkcwoIAgUAUHrCqoSOyklnxm/Y9eoFWVH6f/NyrMTDlyVbhLWyJSxWevJo8hTQgyLN6af4VCFQAABlpxPy/MAOiKwn941ZTevHx/b5WlFWP/PH4tqPX4+U8Ge+8T2UXrZYyWzK6qsdedSEZVXJg68K+aFMQaAAAMoK+Z+EsqDwCg1fk7nbauJnRaEgaxc++41Iif/Gf/pLlGC2MDOfQsuq0siJUKlCoAAA0KFo+t5POqwnNmRF+Zmx4U0tTfX8t9/5uvqvbwvx1NozmN7JHp3cpHRHqBwT2XWorUCgAADQoWj63q+Pe+8e4mdFsUXK47/9NXH1tWuD1Tl+4mTz2R+K//6vvoHSyxbrl59c6uUu1fXVLjvULkGgAABAzgWK7Ijoe3t2nCVfE7KWeEFWFT8rCkGbCH6+viL+4otPDYTKQI+8vlus/OkXviX+40OPD4K9gUxh5Dr15ExrBX3LFNgsEABQyhHvwwsH4sScpw5p1+6BQVYS+vxXr/nHPiHhceF3/2Rw3HXstkEoe1pKTAemdIondjMmUtocIO1kRlJUgUABAGDEG1Og+FlPbGwryv/aVlu1Q4IEoiQXrORyesebVpYECqZ4AAAQKCHh1TzXnQuDrCdhzwOlErvZgXxSMhTYDQIFAFC6EW/M6R2bNv2jYj2xISvKzymeC3LBBvskFYluVhICgQIAwIg3ArJjouv0f2Us3Ez5wj5YUVCXIFAgUAAAwDXifXjhgLYR751i7N/9+ng4i8hdYsx3I0GQG2glVxvZAIGyp5ERHsv8AAAgzRHvH00cELeIsdDfgy9KIWhffnLJf6qwM1dBNkWmm1eB0pMHFfw6yhAAEKZT0XWhrRNnp6Q4+c0o34UVJfcEW086cw3qZOVrPWf3VstIOjZzO8XztbmPbnJGLuNZAQAosKzJOdaGgltNRv0yrCj5FrqB1hMhGlw/HpMixcyFNaUzNyX/nc1KcnLtg0IiRR5UCZbwvAAAAmjpuhBZT1igRIasKJ8YRyiqHKJiPam5Onr6/yX5fotFQFZpZigtZiGcZKVIoUw9hecGADAEsp70NF6vLmJYT2zOSIHyhgg+LGCkqFpPvFgQ5KJgTf9kC0tULWQoRZuFWcUjRYohrJ0Z4TwLAHDTyuL1boEVJW9Q3JNWQEdfkf/O+5xBwva8PC87QsUSJ9mK51Jf7RZqmbEUKbR+mzIazrMAAJslndaTrRNnqVOZ1nU9WqYMK0puUBEUquJ1moXKJk/9VEYkTii9F4QGi6BG1uifwsVBcYiUNTxLAJSevsio9cQGVpTcQHvumAGdPYmM+ZDXJWFAUyvko9JJzapCv0NWnGxN69gMgsUV8qmwV/jcv/q4EaGyAACKQ0vnyh3d1hMbsqJ8/vWr4iWxjRLLrtBVEQ5GzN85OTg6c+dJEAlr2sUU9dWeJlFCg/e62FlhlFXMwgoUh1BpSJFCSuwcni8ASse6FCe6I322kkgoWVGa4xPiX77+Y5RaNmkoBGWjzl/nEt2Twt5ZuDO3wVYF+9iUosX0SQutFKoKK14YHbrTliz11U7hBQqLlLYUKT1WtpN4zgAoDVqXTCZlPbGhaZ7Pb18Vz27DipIxVhQ3BDQSTMM0HycdIqSw+W3/pxR78UiR0mEFiRU+AJQDcow1dY+ik070p/e/ASWXLTaUyr0z10xSvJaMTqkECosUMotVBFb4AFCGTqWl84JbJ87SACdRE/k3j/yk+N9veQClly3qivvttJBVWuiL+qpROoHCIgXh8QEoQaeiOaS9SLID+rPDbxNfuO+M+OP3/Kp4+toVlF52OCPFSVfhPPJzgvuAHnb5jJVubRuLFHKepdfTqA8AFIpFKU66Oi+YlPXk0s1vFt98+y+K705Vrr+38eLTKMFssCzFSbCDtbUR4ElklzaMUgsUh1Bp8gqf86gTABSCFSlOWglcV+s1vYTJdTF09VWU4uhZl+KkoSBOpkSyjrGlE4Xu5dTjZc4NhMcHoDidikjAiVWn9eTyTbf2vzRzSvzXez/pKU6I5374XZTk6OtRTfFccubE1I4ePAMqjpc9VxAeH4BCNG6NBPxOhA7Rc+WGm14231kXX3z/P5kcJkyI7798GSU5+npUV9gI0F61M4ss00bbKxjdOPIF4fEByDl13X4nxNaJs6QmIkeitoXJ8gf/+aFv334suHd89QWU5GjFSU2Kk56COKEAaAj+qY8NKU5aXh9gA4gdkYLw+ADkj1MJxDuxaUUSNhM39v/n235+UoqSQ2G+99zLmN4ZsTgJFrmW34mJLNNKY9gHsKDsFSqUWWeQEwDkQpwYSVw4ivXk2vjE1p+95YEt40NnJ1UsJnsECvxPsi1OLEicwO9EH4t+IfthQfEWKQiPD0BJxQnTCiNM1u/+oFi/50MHXps4GL2nvPIiSjXL4qQzR/VtBtmmjfVhUzsQKMEipSNFSk1YntoIYQxAScSJqvVECpMrUpiMxRUmNrCgpNw5WuJEzbG6M9cSmPrXCUV7rgWdBIHiL1K6UqSQQ5QJ5QxA8cUJE7jJ4F/ece8Pv/7Wn70lpjChETyN3ntP/e1fXZOvHxew2KYBLYaohxAnDfnvArJNG4PVUqK+Gpj/ECjBImWTLSltKGgARtqo0VLiTpI/snXiLDlBNoZ9/tSt731ZCpNDPzw4dUvI0WKPBzqbLEq6u5dFz4jff0D8GwGLbdIsKwVh2y1OEMxT73Nck+JEaVoNAkVRpAgrPH4PShqA1KEOPpGlxB6Q9WTSR5j4rcxZZyHS5WMzzAoj8oW444HTVRYpiLGhv2Nsyjw2Qn6vhqwbjTiBQAkvVFosUqCoAUiHNZHM5n97YOvJrumd705Vnjff+eARhzC5Pi0jdqwiPZm+no408LRDTQqVFgZD2hhEGQ6xUmeH+mqDnWPpgGUrRXECgRJNpBi8h48pMF8MQJIsJrS3zjCuW09euPm2575x9CPf673pnWTNGDItkxyyM21JkWKiY4zNkjxayv4m3iKFyqHCjrJNtPvRBGJYcQKBEl2k2M6z1HjBeRYAvdCUTiPBAGx7cFhPyGLTuuNLv2X+0ogzQXaqJk/5UMeIndcj1CHKQ21XpCWxljWF/BGxg7EaAwuoikOsFwjUFl2k9ATC4wOQxIi3mqY4YUig1A888UhNHmZWMoNG/vIg4XScO12gWIe0ipMdkdKTR53LA/u3+UNB2GpRxQkBC0o8kYLw+ABoHPGOQJgMkKKEBhy9rGYOd7YV9k3BNMPw0XorEWGyV6jQb1R5lQ+VCabhXM+yX4RYVWBB0SNUqJKeQk4AEBpyniNfk8qoxEmeIN+UQccoxDJyY1eHeErmTS0VcbJbqBhcHotcl8vO4iA/NIgTAhYUfSKFnGfJomJgdAOAEtTJNtNyPC2QSOnRCJWtKXTk1np7cOJGMXPn3xVH3/QO8cabjgz+dnLl6qviD/58eViUXRIEZDFpj/QmrCkM8k+hdDRFOS1cZL1qDKbANAKBolekIDw+AGrCpKVraS6ESv6EyntuPyY+MH1cHL7pTWJi/Iah5x2YOCge+ju/Kf712mecb2/w/XZirc6BUNElTFq6LCYQKMmLFITHB8B7tEsNdxsWk0SFSlNYkXAz2TG+/ci7Rf29D4kb9u2P2hkaEYKtjVKoNLhMijZgTVSYQKAkK1IQHh8AR6eSwv45ECqWUBmM3KVYaXDnOJKItJMHD4t33fbT4tZDtw/EyJ2T94gD+w6K/fsOiLGxsVDX2jc+cVW+vD9SoLXRC5WBKJdipc7lkeflyTTI6AzuJ0JMEwiUjIkUgfD4oJzQ8ksSJB1M44xMrFD+G1KoVKir5M4xUYsu+Y988OgJ8VN33DsQJTf4TN2E6qTGJ76dO3GyV6x0Bp17Z67CZUFHXqwqa/bzHGfJMARKNoUKwuODokMjK5NHVyZESaaESs8exTvESk33SP7ET3xUvO/uD5GYiHyNa69f/bEQY1v7xvf9rePtL8vjbGEKxHIibQlrCqjKQqUmsucOsGI/z7odXyFQsidSEB4fFAmykNgb4pkpbeIHNIoV+lsKlhp3jlU+Qo/oyWryifuagymdKGxvb1+9tn3t21LY/M6+8YnHS+WfZE2TWHs/WZaVmuNI27qyxv2TmbRfSViBYnDC8kTuRmgO59lGDh+loPxeRPNfGOzN8GxMx+smxEihBIvpbPulYJlyiJUpsbOTb9VrYPXmW+4Uv/a+T0Z1eCW/kq+PjY39g99q3dwrfWFYVgqDDxIsdllQGVT4qGoY4JIQ2XQMMHpp+ZNEYUwqWDypAAAAAuFposqdb7jn0D+891O/PzY2fqPHaVfkQR3LjUMuQ5//Iyl2/zNyNAKWtaXietcWlT2PAWVvlNM0ECgAAABS49HFre/Jlzd7fPScPP69PP6F8HYheFkeH4YlDqiAUPcAAADCiBPDQ5y8Jo8/ksLjdvn6G0PEyWsQJwACBQAAQBLipCJfPu7x0QUpPH5Bfv6Q/L+Xx+yP5fEJiBMAgQIAACAJPiuPQ673niNxwv8nh3kvr9lvw+cEQKAAAABIio+4/iaH14E4YevKXR7foXM+hqwDECgAAAC0w9M37mWuf+qYtvmUPA56fPVbCN4HIFAAAAAkhdsKQk6v/9bx9y8M+d7vIusABAoAAICkOOD6+1WXX8ktHt/pw/cEQKAAAABIEtr09FXH3+4I0k97fOcZZBuICvbiAQCAlLh/9XE7hDmxSVtg5CXtDy8c+HP5ctOji1ufka/L8u8N1ym/LI/PCWsZMvUtr8jj11DqICqIJAsAAMkLExIlLeHaRVgKlLEi3q8UMVXEPAEQKACE7yyoo6gJa9OsVp5GsWBomdaFvTOsEG1Zpp0Mpa0hX857fVZUgYJnFugAUzygbA0ddRYLjreo0ZtCzuS6TCvy5THHW7PyvWNZ6MRkOmpDxAntKotOVi0Pm65nlqxRFeQMBAoARcPdsE0iSwpXpiJDorPl+nuJLQCbKDZl3GU5jSyBQMkUdzxwmiqpwZWVHu7G5SeX8JCDsPRcf/eRJblnU/G9tEf+JJxmHW+tSGHSRHHFLt8NZEk5yNMyYzLrneQH/qTY8YQHQBnZQRg8il3jo4ZcyX2Z0lTJKUeZnsqIj0LF9XcbpRUJemaXHeVbR5aUA0zxgDJ2aBjFFlN4GhlPJnxOopXtwGKOnCgfCNQGAADpdbQAAEWGWlDueOB0zf7/5SeXzCR+XP4GTdNsyuv3RnHz7NdyPWiSTEfqIxyep67wnz3ZiPUSuPZmhlY0iKTSw/c7lda9quYvx8CY4k7K1PTbiQf84vIKXSeTrNMplatdXplKe9Jl7ry+rnqaVP2P2f6MNB1AnV1xUGSH3RBWLIEZj3Np7q8VRqzI69UdD1TbdmqV7zf5d8gbuy/fn/IRELY5vu5K17o83LEOOioig8VXS+x2YCP6fM1W0qKJl7u2xF6PdHIAM4QVy2FT8VpNbgCo0WpzTIi2x7VXRMIxBLgxsueIN+174fcmvfJatRPgBtSuD1071gX/ZttRnscCBMOuehmUz+7zheW34s7fPt9L25XWpti7UmiFf9eMkL+BdTdEfnrmA8ecsNPdl+9PKVyrwumqe9xvn+tBYqtXXPWuE1TH3ecLy3ma0t9wpT/U8+jKU3ebReXuTFc3KF6Lox7Vh7TLoZ9pR3th1+fqkDq1xtc2I5YH/c68x8frnJ9G1DSHaBsbXKazQ9LRylLMHOAhUNiS0RFqy7eWZefdUBQopqNiLMrvteR7hrvSyvfHhnyfHpqFEPezJq9VC0gTVfRzAdehBrWWhEWFGxzKg5MBp9LDU1PoPOl+L7ga1KByPBWmcQh5f+4y6wv/pbx9vs9u2GtTkCuP+yeO+zWq8jvO6ISL8txWwO8663FQ/i7bQmFIhxK5HGQ6qDM5rVJ3FfNzTz7I9/Y8n0HBxBTTFSptEerdrrZGoUzd9TSoXFWfxzCRL9fk9WoBYscQakvhleuSK43a2wu/wHTuZ0VetxEhzceDRBMLJEPhGQyVDpAu444RhOra8nnu5MMyxRaVeY9GaxhhR1ubAeKkoSBOBDcIpjy/kkCetxXEieAHy4xwfZVyPM8j3jSYVMnrKOlhsZf26Ccof6l+P6bYMCqXA48gT6vW3Yj52Qz5fNqd6OkQdcHkcssa0wrPo0pd07JsnfPoMaEep+e8cwojgfaippjumqI4GTwrLG6ToK34DNrpaEEOZFegOJdtDZbpyeMoWzaOCcuM6CRKYZ4Wu73s6ZpnhM9yYfn7VMmO87HkMVI97jzk+XUfcTIl9i7zO0P3yPd5mK/pbEy1Vlp+eOddjRmNBsZ4lHqUR2rXG0UejURhyZE3ZzwazjQfyA1Og7Ms+xryuutowOk3FlVGV5pw1r9Fv1GyPB7k806JvTEcWgr1Zsp1Xp9Htc56sxIzP5uu7yxzen2X87N5fNmRriW7TvMz5b5nSltWR6sbnN7jXGbLrs9nFTrqqqNerLk+W3S1WQ2ffN3ktDjLg9J0mPP2QY/rt2LW51j1lDF88vS4R56eTmiw1HS0Met2n+Z4XtzpaGZUOJeaCRYCXdmBU+Wckv83XCKBOoG6/Nxpxp0kP44IzrOTXGnqqt+1z5O/J1wjNSPk77vnxs+wALJ/Z7CUja0ms47RsM7G1H2tXeZu8h2wHRMdaW2I8Msn3Z20ySZw03HdtGIJeJnGTZ5KiJsee/R3xvb9SAn379H99DxGjntMx/K8jqt8a4r1xll3W06TO/uc1F3THPUIz6ZdXo2Q0zBNvifD6f/CZW543HNdZC8miFc97ci0Uz6cc7Ujpo+w6PG92tNIFxyfhRIQVMbyGvTfnlt0szDsuMp8NuK975nC4TLrOp4xEmdTflNcPK0yrfDse+Wp1vpA9ZetexX3vXEZNfiZXXDU/6qIZrUGCVtQqIPuuMWJh8ksLiROKkmtClIY2bitM4H36VzNpAHntda8OgF+mJ2m5LCNzoqXBYF/y1m+kylN8zS8GjVOT9uVnijB906lLE42vH6PG8F1j47bq3wND5GlWnf7PvdrxMzPdRHBR4TuiTrfYc65HvecRVpD6mlb7Lb2pRogkupVgEWw7RIJYdurdS//Es6Lll8bGtTGhsjTWkJ5Zwb4zrR92meQJYGigI7ObJTh6Z0Pz5rPeUmmz9kZ+TU6vRi/4de5mAmUaVBnHiY9YU2sy0k5+4ZI87DP1n1Gm2H9ZiqK5duLmZ/NBGN1ZDryc8BKjiwHWKskWJ97MdNiKubpqKZWMKWTd4FCvhvsXBrXGXGDrDQZue9ZH8tII6U0NLzmPPm9pKZf0haHvYSvP4ppgp5i/ibW0ftYRuLU3fUkfHcorTxdMCuAznyt8BRSK6ttQoDYJeviIh/NEeRfQ2A6J/NMeAkSYZm6ajzq0dWwZK0yXGC/llFB1pQXeY4ZRGsAyxg6nObKLyZQb7QMHlg8OdsP7DyrSZC48nWmAM9uWgEVk+rTQFoChZ1DSY3P53Q0nQR9MXrz7hqqKch63fUJPAjiC742OtXIwsQrSCTIk0DhQG2mTyHanWSRHpJ1hVFjJ2GfmRWFTgQ7oIJIdTetvV+8grs52OA6XkMnEUn0nQ8YvFAnPIPc8hR2fn0aPUObEH4ZFyg8peMuSDs0dce54kaeu12Q+7YjxY5y8y5abYNtw0FYqMOvZWXjuSHB3da4/TDtlT0ekVuBf75WPMTJBg9YTHt6c0gkZWAJeM8+zelrFTLyL0hboIi95q/1DHTeSdPNwP1h63UQhV7GdsV1OzieGsHKqiLScv1NgcWa2BFZSdxRnzbtIep7yJ38CZSau8Hx6rzZ0gJAGFBnit0RTLk6gjUfcYK6EI6Ku10ukjjhlV32lh+6rclVj7yDOMmpQNn1IPgEURv1dEQvZoO36fPwu8VYhc/ZTGLDQJX0Z3XL95DMBESfrOAR1F5vrtfdFFY5uTsC0+fcGoouFLMu4beZ0XbZry7WfJauVxIUr7vq5bAYN2xpARlm3KNzrnm859zmfiRIoeDupBshL+FsrKeHxUHh9y8Ja173ouZIss4VOY1hez/wBloXOQ2Xcl7HmqqfpbSHTh7pukRfzafBvV53I0bmjcOwdNGzCkfOcDgjrc4OiZlUEdna18hUefa5/s4oCtsobCoKkRaqWfYFirtytJ2dsmOFTxYaGOeGaCdl2sJUMLeK7rjFB++27D6vl9AD7LnrLDsTOgO0rOe8ji3QPTkbWA7e5a5TK3gclRv+jluksAgwEqy7e/AQlLPOsqZXdqI9jyKMJUqFu63g8jdFhlZGcX1wCquTtMLLI92dgHuNi7veG87nhYPcZaVPAz5McGVxetdToY06iNkwyLJw0tn5yXQ2uYJTpWwPm5LhDRHJgjHrEAh0nxv8XXqI3DEclj0sN3HT33Q0KpTXl+TD4rfkrQjLjBdYqATlDfBu+DtcR2acdVe+Z9fdqkdHtZySzwI5b86HLGsQjOFqD+y2Iuvpbrv6E6ob8z7p3gjYZiBq3i24BoMXUCdzaEHhDn0pD4ll/5hTrrcn+UGmByFoTrHhUviCRcmshzhZF5qntbjDaHh8NDNEnCyXZEXEKUzvBOJXdyeTrrs+tDzSBeK3FYbIofWUd2xeVjy9LxLwoWGfvUXUogIIFO747X0R+j4V6Yyr4qmMzrpD/h9HpNCDe1xEiLDK1pCKwgNEnyey1JpHC8cC0k/5vSjPbSjm8brje36jkZ6jjNdF8kudNwIaCvr8eAgR1nWVUVRU8ytsPVY9z10OKvWmy5YSpbqraD1ZDpkPwzqDWkB9ps8edNxzEpadsG1N16M++I3Io7RjocvZRS1g8LjBAzZnfe6FqP8q9TnstQW3W2cChOuaCLdzdqh0sFA6E9CnLbqeJ4R+yBhj29u749SwX0bNVWhmFuOi8Gqbqtjx2m6rptOx51B1VPfKToxVsduj3cyzNcEVkItWH9Qce2FUHR2UWdK9dHTksbveD+oN1d9RLkV17BdTQTlrzVevtioX7QT7ftRcos1Mc2WiRxq6nAbElMmbQAFAt0BBrgAAAAjLOLIAAAAAABAoAAAAAAAQKAAAAACAQAEAAAAAgEABAAAAQNGYQBYAzTjjaWB5KQAAgEj8fwEGAAduYzJrVudzAAAAAElFTkSuQmCC',
				logo_alcaldia: 'data:image/png;base64,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'

			},
			styles: {
				header: {
					fontSize: 9.5,
					bold: true,
					alignment: "center"
				},
				text:{
					fontSize: 9.5,
					alignment: "center"
				},
			}

		};
		pdfMake.createPdf(dd).download("reporte_consolidado_eventos_"+datos_pdf.nombre_equipo+".pdf");
	}
});