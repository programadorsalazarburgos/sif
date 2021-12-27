var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php';
var url_ok_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
var pdfData;
var guardarObservacionOption = false;
var codigoGrupo;
$(function(){

	if(!alertify.myAlert){
		alertify.dialog('myAlert',function factory(){
			return{
				main:function(message){
					this.message = message;
				},
				setup:function(){
					return { 
						buttons:[{text: "cool!", key:27}],
						focus: { element:0 }
					};
				},
				prepare:function(){
					this.setContent(this.message);
				}
			}});
	}

	var lineaAtencion;
	var id_grupo;
	$("#SL_clan").html(parent.getOptionsClanes());

	$("#gruposArteEscuela").click(function(){
		var id_clan = "";
		$('#SL_clan :selected').each(function(i, selected){ 
			if(id_clan=="") id_clan = $(selected).val();
			else id_clan += ","+$(selected).val();
		});
		var anos = "";
		$('#SL_Ano :selected').each(function(i, selected){ 
			if(anos=="") anos = $(selected).val();
			else anos += "," +$(selected).val();
		});		

		if (id_clan == "" || anos=="") {
			$("#grupos_arte_escuela").removeClass('active');
			alertify.alert('Por Favor', 'Seleccione al menos un crea y un año de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarGruposArteEscuela(id_clan,anos);
		}
	});

	$("#gruposEmprendeClan").click(function(){
		var id_clan = "";
		$('#SL_clan :selected').each(function(i, selected){ 
			if(id_clan=="") id_clan = $(selected).val();
			else id_clan += ","+$(selected).val();
		});
		var anos = "";
		$('#SL_Ano :selected').each(function(i, selected){ 
			if(anos=="") anos = $(selected).val();
			else anos += "," +$(selected).val();
		});	
		if (id_clan == "" || anos=="") {
			$("#grupos_emprende_clan").removeClass('active');
			alertify.alert('Por Favor', 'Seleccione al menos un crea y un año de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarGruposEmprendeClan(id_clan,anos);
		}
	});

	$("#gruposLaboratorioClan").click(function(){
		var id_clan = "";
		$('#SL_clan :selected').each(function(i, selected){ 
			if(id_clan=="") id_clan = $(selected).val();
			else id_clan += ","+$(selected).val();
		});
		var anos = "";
		$('#SL_Ano :selected').each(function(i, selected){ 
			if(anos=="") anos = $(selected).val();
			else anos += "," +$(selected).val();
		});	
		if (id_clan == "" || anos=="") {
			$("#grupos_laboratorio_clan").removeClass('active');
			alertify.alert('Por Favor', 'Seleccione al menos un crea y un año de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarGruposLaboratorioClan(id_clan,anos);
		}
	});

	$("#table_grupos_arte_escuela").delegate(".consultar_listado_estudiantes_grupo_arte_escuela","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: AE-" + id_grupo);
		cargarEstudiantesGrupo('arte_escuela',id_grupo);
	});

	$("#table_grupos_emprende_clan").delegate(".consultar_listado_estudiantes_grupo_emprende_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: EC-" + id_grupo);
		cargarEstudiantesGrupo('emprende_clan',id_grupo);
	});

	$("#table_grupos_laboratorio_clan").delegate(".consultar_listado_estudiantes_grupo_laboratorio_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: LC-" + id_grupo);
		cargarEstudiantesGrupo('laboratorio_clan',id_grupo);
	});

	$("#table_grupos_arte_escuela").delegate(".consultar_caracterizaciones_grupo_arte_escuela","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_car_ae").hide();
		$("#title_modal_caracterizaciones_grupo").text("Caracterizaciones del grupo: AE-" + id_grupo);
		cargarCaracterizacionesGrupoArteEscuela(id_grupo);
	});

	$("#table_grupos_emprende_clan").delegate(".consultar_caracterizaciones_grupo_emprende_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_car_ec").hide();
		$("#title_modal_caracterizaciones_grupo_ec").text("Caracterizaciones del grupo: EC-" + id_grupo);
		cargarCaracterizacionesGrupoEmprendeClan(id_grupo);
	});

	$("#table_grupos_laboratorio_clan").delegate(".consultar_caracterizaciones_grupo_laboratorio_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_car_ec").hide();
		$("#title_modal_caracterizaciones_grupo_lc").text("Caracterizaciones del grupo: LC-" + id_grupo);
		cargarCaracterizacionesGrupoLaboratorioClan(id_grupo);
	});
	var lineaAtencion;
	var id_grupo;
	$("#table_grupos_arte_escuela").delegate(".consultar_planeacion_grupo_arte_escuela","click",function(){
		id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_ae").hide();
		lineaAtencion = "arte_escuela" ;
		$("#title_modal_planeacion_grupo").text("Planeación del grupo: AE-" + id_grupo);
		cargarPlaneacionesGrupoArteEscuela(id_grupo);
	});

	$("#table_grupos_emprende_clan").delegate(".consultar_planeacion_grupo_emprende_clan","click",function(){
		id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_ec").hide();
		lineaAtencion = "emprende_clan" ;
		$("#title_modal_planeacion_grupo_ec").text("Planeación del grupo: EC-" + id_grupo);
		cargarPlaneacionesGrupoEmprendeClan(id_grupo);
	});

	$("#table_grupos_laboratorio_clan").delegate(".consultar_planeacion_grupo_laboratorio_crea","click",function(){
		id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_lc").hide();
		lineaAtencion = "laboratorio_clan" ;
		$("#title_modal_planeacion_grupo_lc").text("Planeación del grupo: LC-" + id_grupo);
		cargarPlaneacionesGrupoLaboratorioClan(id_grupo);
	});

	$("#table_grupos_arte_escuela").delegate(".consultar_valoracion_grupo_arte_escuela","click",function(){
		id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_Valoracion_ae").hide();
		$('#DIV_Anexo_ae').hide();
		lineaAtencion = "arte_escuela" ;
		$("#title_modal_valoracion_grupo").text("Valoración del grupo: AE-" + id_grupo);
		cargarValoraciones(id_grupo,lineaAtencion);
	});

	$("#table_grupos_emprende_clan").delegate(".consultar_valoracion_grupo_emprende_clan","click",function(){
		id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_Valoracion_ec").hide();
		$('#DIV_Anexo_ec').hide();
		lineaAtencion = "emprende_clan" ;
		$("#title_modal_valoracion_grupo_ec").text("Valoración del grupo: EC-" + id_grupo);
		cargarValoraciones(id_grupo,lineaAtencion);
	});

	$("#table_grupos_arte_escuela").delegate(".descargar_observaciones","click",function(){
		id_grupo = $(this).data("id_grupo");
		tipo = $(this).data("tipo");
		lineaAtencion = 'arte_escuela';
		descargarObservaciones(id_grupo,tipo,lineaAtencion);
	});

	$("#table_grupos_emprende_clan").delegate(".descargar_observaciones","click",function(){
		id_grupo = $(this).data("id_grupo");
		tipo = $(this).data("tipo");
		lineaAtencion = 'emprende_clan';
		descargarObservaciones(id_grupo,tipo,lineaAtencion);
	});

	$("#table_grupos_laboratorio_clan").delegate(".descargar_observaciones","click",function(){
		id_grupo = $(this).data("id_grupo");
		tipo = $(this).data("tipo");
		lineaAtencion = 'laboratorio_clan';
		descargarObservaciones(id_grupo,tipo,lineaAtencion);
	});

	$("#BT_ver_caracterizacion").on('click', function(){
		var id_caracterizacion = $("#SL_Caracterizaciones_Grupo_Arte_Escuela").val();
		//alert(id_caracterizacion);
		window.open("../../Controlador/ConsultasReportes/C_PDF_Caracterizacion.php?id_caracterizacion="+id_caracterizacion);
	});

	$("#BT_ver_caracterizacion_ec").on('click', function(){
		var id_caracterizacion = $("#SL_Caracterizaciones_Grupo_Emprende_Clan").val();
		//alert(id_caracterizacion);
		window.open("../../Controlador/ConsultasReportes/C_PDF_Caracterizacion.php?id_caracterizacion="+id_caracterizacion);
	});

	$("#BT_ver_caracterizacion_lc").on('click', function(){
		var id_caracterizacion = $("#SL_Caracterizaciones_Grupo_Laboratorio_Clan").val();
		//alert(id_caracterizacion);
		window.open("../../Controlador/ConsultasReportes/C_PDF_Caracterizacion.php?id_caracterizacion="+id_caracterizacion);
	});

	$(document).on('change','#SL_Planeacion_Grupo_Arte_Escuela',function(e){
		e.preventDefault();
		var planeacionId = $(this).val();
		if ($.isNumeric(planeacionId)) {
			generarReportePlaneacion(planeacionId);  
			$("#DIV_Observacion_ae").show();
		}
		else{
			$("#DIV_Observacion_ae").hide();
		}

	});    

	$(document).on('change','#SL_Planeacion_Grupo_Emprende_Clan',function(e){
		e.preventDefault();
		var planeacionId = $(this).val();
		if ($.isNumeric(planeacionId)) {
			generarReportePlaneacion(planeacionId);
			$("#DIV_Observacion_ec").show();
		}
		else{
			$("#DIV_Observacion_ec").hide();
		}
	});

	$(document).on('change','#SL_Planeacion_Grupo_Laboratorio_Clan',function(e){
		e.preventDefault();
		var planeacionId = $(this).val();
		if ($.isNumeric(planeacionId)) {
			generarReportePlaneacion(planeacionId);
			$("#DIV_Observacion_lc").show();
		}
		else{
			$("#DIV_Observacion_lc").hide();
		}
	});

	$('.asistencia_clase').bootstrapToggle({
		on: 'SÍ',
		off: 'NO',
		onstyle: 'success',
		offstyle: 'danger'
	});
	$(document).on('change','#SL_Caracterizaciones_Grupo_Arte_Escuela',function(e){
		e.preventDefault();
		var caracterizacionId = $(this).val();
		if ($.isNumeric(caracterizacionId)) {
			cargarCaracterizacion(caracterizacionId);
			$("#DIV_Observacion_car_ae").show();
		}
		else{
			$("#DIV_Observacion_car_ae").hide();
		}
	});

	$(document).on('change','#SL_Caracterizaciones_Grupo_Emprende_Clan',function(e){
		e.preventDefault();
		var caracterizacionId = $(this).val();
		if ($.isNumeric(caracterizacionId)) {
			cargarCaracterizacion(caracterizacionId);
			$("#DIV_Observacion_car_ec").show();
		}
		else{
			$("#DIV_Observacion_car_ec").hide();
		}
	});

	$(document).on('change','#SL_Caracterizaciones_Grupo_Laboratorio_Clan',function(e){
		e.preventDefault();
		var caracterizacionId = $(this).val();
		if ($.isNumeric(caracterizacionId)) {
			cargarCaracterizacion(caracterizacionId);
			$("#DIV_Observacion_car_lc").show();
		}
		else{
			$("#DIV_Observacion_car_lc").hide();
		}
	});

	$(document).on('change','#SL_Valoracion_Grupo_Arte_Escuela',function(e){
		e.preventDefault();
		var valoracionId = $(this).val();
		if ($.isNumeric(valoracionId)) {   
			cargarValoracion(valoracionId);
			$("#DIV_Observacion_Valoracion_ae").show();
			$('#DIV_Anexo_ae').show();
		}
		else{
			$("#DIV_Observacion_Valoracion_ae").hide();
			$('#DIV_Anexo_ae').hide();
		}
	});    

	$(document).on('change','#SL_Valoracion_Grupo_Emprende_Clan',function(e){
		e.preventDefault();
		var valoracionId = $(this).val();
		if ($.isNumeric(valoracionId)) {   
			cargarValoracion(valoracionId);
			$("#DIV_Observacion_Valoracion_ec").show();
			$('#DIV_Anexo_ec').show();
		}
		else{
			$("#DIV_Observacion_Valoracion_ec").hide();
			$('#DIV_Anexo_ec').hide();
		}
	});

	$("#BT_ver_Planeacion_ae").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Planeación AE-'+codigoGrupo+'.pdf'); 
	});
	$("#BT_ver_Planeacion_ec").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Planeación EC-'+codigoGrupo+'.pdf'); 
	});
	$("#BT_ver_Planeacion_lc").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Planeación LC-'+codigoGrupo+'.pdf'); 
	});
	$("#BT_ver_Valoracion_ae").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Valoración AE-'+codigoGrupo+'.pdf'); 
	});
	$("#BT_ver_Valoracion_ec").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Valoración EC-'+codigoGrupo+'.pdf'); 
	});

	$('#IN_Estado_car_ae').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_car_ae").serializeArray();
		guardarObservacionCaracterizacion(datos);
	});
	$('#IN_Estado_car_ec').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_car_ec").serializeArray();
		guardarObservacionCaracterizacion(datos);
	});
	$('#IN_Estado_car_lc').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_car_lc").serializeArray();
		guardarObservacionCaracterizacion(datos);
	});
	$('#IN_Estado_pl_ae').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_ae").serializeArray();
		guardarObservacionPlaneacion(datos);
	});
	$('#IN_Estado_pl_ec').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_ec").serializeArray();
		guardarObservacionPlaneacion(datos);
	});
	$('#IN_Estado_pl_lc').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_lc").serializeArray();
		guardarObservacionPlaneacion(datos);
	});
	$('#IN_Estado_val_ae').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_Valoracion_ae").serializeArray();
		guardarObservacionValoracion(datos);
	});
	$('#IN_Estado_val_ec').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_Valoracion_ec").serializeArray();
		guardarObservacionValoracion(datos);
	});
	$('#IN_Estado_val_lc').on('change', function(e){
		e.preventDefault();
		guardarObservacionOption = false;
		var datos = $("#FORM_Observacion_Valoracion_lc").serializeArray();
		guardarObservacionValoracion(datos);
	});


	$("#FORM_Observacion_ae").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionPlaneacion(datos);

		var idFormato = $('#SL_Planeacion_Grupo_Arte_Escuela').val();
		generarReportePlaneacion(idFormato);  
	});
	
	$("#FORM_Observacion_ec").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionPlaneacion(datos);

		var idFormato = $('#SL_Planeacion_Grupo_Emprende_Clan').val();
		generarReportePlaneacion(idFormato);
	});
	$("#FORM_Observacion_lc").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionPlaneacion(datos);

		var idFormato = $('#SL_Planeacion_Grupo_Laboratorio_Clan').val();
		generarReportePlaneacion(idFormato);
	});
	
	$("#FORM_Observacion_Valoracion_ae").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionValoracion(datos);

		var idFormato = $('#SL_Valoracion_Grupo_Arte_Escuela').val();
		cargarValoracion(idFormato);
	});
	
	$("#FORM_Observacion_Valoracion_ec").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionValoracion(datos);

		var idFormato = $('#SL_Valoracion_Grupo_Emprende_Clan').val();
		cargarValoracion(idFormato);
	});
	
	$("#FORM_Observacion_car_ae").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionCaracterizacion(datos);

		var idFormato = $('#SL_Caracterizaciones_Grupo_Arte_Escuela').val();
		cargarCaracterizacion(idFormato);
		
	});
	
	$("#FORM_Observacion_car_ec").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionCaracterizacion(datos);

		var idFormato = $('#SL_Caracterizaciones_Grupo_Emprende_Clan').val();
		cargarCaracterizacion(idFormato);
	});

	$("#FORM_Observacion_car_lc").on('submit',function(e){
		e.preventDefault();
		guardarObservacionOption = true;
		var datos = $(this).serializeArray();
		guardarObservacionCaracterizacion(datos);

		var idFormato = $('#SL_Caracterizaciones_Grupo_Laboratorio_Clan').val();
		cargarCaracterizacion(idFormato);
	});
	
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	} );	
});
function cargarCaracterizacion(caracterizacionId) {
	var datos = {
		'opcion': 'getCaracterizacion',
		'caracterizacionId': caracterizacionId
	};
	$.ajax({
		async: false,
		url:url_service,
		type:'POST',
		data: datos,
		success: function(datos){
			dataJson = JSON.parse(datos)[0];
			var estado = "off"; 
			if (dataJson.IN_Estado == 1) {
				estado = "on";
			} else {
				estado = "off";
			}
			if (dataJson.FK_Id_Linea_Atencion == 'arte_escuela'){
				$('#TXT_Observacion_car_ae').val(dataJson.TX_Observacion);
				$('#IN_Estado_car_ae').bootstrapToggle(estado);
			}
			if (dataJson.FK_Id_Linea_Atencion == 'emprende_clan'){
				$('#TXT_Observacion_car_ec').val(dataJson.TX_Observacion);
				$('#IN_Estado_car_ec').bootstrapToggle(estado);
			}
			if (dataJson.FK_Id_Linea_Atencion == 'laboratorio_clan'){
				$('#TXT_Observacion_car_lc').val(dataJson.TX_Observacion);
				$('#IN_Estado_car_lc').bootstrapToggle(estado);
			}
		}
	}); 

}
function guardarObservacionPlaneacion(datos) {
	var idUsuario = $('#id_usuario').val();
	var url_controller = '../../Controlador/Pedagogico/C_Planeacion_Grupo.php';
	datos.push({
		name: 'opcion', 
		value: "guardarObservacionPlaneacion"
	});
	datos.push({
		name: 'idUsuario', 
		value: idUsuario
	});
	$.ajax({
		async: false,
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(datos){
			var box1;
			if (guardarObservacionOption)
			{
				if (datos == 'false' )           
					box1 = bootbox.alert("A Ocurrido un Error Intente Nuevamente");
				else
					box1 = bootbox.alert("Se ha registrado la observación y aprobación correctamente");

				box1.css({
					'top': '14%'
				}); 
			}
		}
	}); 
}
function guardarObservacionValoracion(datos) {
	var idUsuario = $('#id_usuario').val();
	var url_controller = '../../Controlador/Pedagogico/C_Valoracion_Grupo.php';
	datos.push({
		name: 'opcion', 
		value: "guardarObservacion"
	});
	datos.push({
		name: 'idUsuario', 
		value: idUsuario
	});
	$.ajax({
		async: false,
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(datos){
			var box1;
			if (guardarObservacionOption)
			{
				if (datos == 'false')           
					box1 = bootbox.alert("A Ocurrido un Error Intente Nuevamente");
				else
					box1 = bootbox.alert("Se ha registrado la observación y aprobación correctamente");

				box1.css({
					'top': '14%'
				}); 
			}
		}
	}); 
}
function guardarObservacionCaracterizacion(datos) {
	var idUsuario = $('#id_usuario').val();
	datos.push({
		name: 'opcion', 
		value: "guardarObservacionCaracterizacion"
	});
	datos.push({
		name: 'idUsuario', 
		value: idUsuario
	});
	$.ajax({
		async: false,
		url:url_service,
		type:'POST',
		data: datos,
		success: function(datos){
			var box1;
			if (guardarObservacionOption)
			{
				if (datos == 'false')           
					box1 = bootbox.alert("A Ocurrido un Error Intente Nuevamente");
				else
					box1 = bootbox.alert("Se ha registrado la observación y aprobación correctamente");

				box1.css({
					'top': '14%'
				}); 
			}
		}
	}); 
}

function cargarGruposArteEscuela(id_clan,anos){
	window.parent.$("#modal_enviando").modal("show");
	var table_grupos_arte_escuela = $("#table_grupos_arte_escuela").DataTable();
	table_grupos_arte_escuela.clear();
	/*var datos = {
		'opcion': 'get_grupo_arte_escuela',
		'id_clan': id_clan
	};*/
	var datos = {
		funcion: 'getEstudiantesArteEscuelaByCrea',
		p1: id_clan,
		p2: anos
	};	
	$.ajax({
		//url: url_service,
		url: url_ok_obj,  
		type: 'POST',
		data: datos,
		success: function(data){
			$("#div_table_grupos_arte_escuela").html(data);
			table_grupos_arte_escuela.destroy();
			$("#table_grupos_arte_escuela").DataTable({
				responsive: true,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
					"search": "Filtrar"
				},
				dom: 'Bfrtip',
				buttons: [
				{
					extend: 'excelHtml5',

					title: 'Grupos SICLAN - Arte en la escuela'
				}
				]
			});
			table_grupos_arte_escuela.draw();
			window.parent.$("#modal_enviando").modal("hide");
		},
		async: true
	});
}

function cargarGruposEmprendeClan(id_clan,anos){
	window.parent.$("#modal_enviando").modal("show");
	var table_grupos_emprende_clan = $("#table_grupos_emprende_clan").DataTable();
	table_grupos_emprende_clan.clear();
	/*var datos = {
		'opcion': 'get_grupo_emprende_clan',
		'id_clan': id_clan
	};*/
	var datos = { 
		funcion: 'getEstudiantesGruposEmprendeByCrea',
		p1: id_clan,
		p2: anos
	};		 
	$.ajax({
		//url: url_service,
		url: url_ok_obj, 
		type: 'POST',
		data: datos,
		success: function(data){
			$("#div_table_grupos_emprende_clan").html(data);
			table_grupos_emprende_clan.destroy();
			$("#table_grupos_emprende_clan").DataTable({
				responsive: true,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
					"search": "Filtrar"
				},
				dom: 'Bfrtip',
				buttons: [
				{
					extend: 'excelHtml5',

					title: 'Grupos SICLAN - Emprende CLAN'
				}
				]
			});
			table_grupos_emprende_clan.draw();
			window.parent.$("#modal_enviando").modal("hide");
		},
		async: true
	});
}

function cargarGruposLaboratorioClan(id_clan,anos){
	window.parent.$("#modal_enviando").modal("show");
	var table_grupos_laboratorio_clan = $("#table_grupos_laboratorio_clan").DataTable();
	table_grupos_laboratorio_clan.clear(); 
	/*var datos = {
		'opcion': 'get_grupo_laboratorio_clan',
		'id_clan': id_clan
	};*/
	var datos = {
		funcion: 'getEstudiantesGruposLaboratorioByCrea',
		p1: id_clan,
		p2: anos 
	};	
	$.ajax({
		//url: url_service,
		url: url_ok_obj, 
		type: 'POST',
		data: datos,
		success: function(data){
			$("#div_table_grupos_laboratorio_clan").html(data);
			table_grupos_laboratorio_clan.destroy();
			$("#table_grupos_laboratorio_clan").DataTable({
				responsive: true,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
					"search": "Filtrar"
				},
				dom: 'Bfrtip',
				buttons: [
				{
					extend: 'excelHtml5',

					title: 'Grupos SICLAN - Laboratorio CLAN'
				}
				]
			});
			table_grupos_laboratorio_clan.draw();
			window.parent.$("#modal_enviando").modal("hide");
		},
		async: true
	});
}

function cargarEstudiantesGrupo(tipo_grupo,id_grupo){
	var table_listado_estudiantes_grupo = $("#table_listado_estudiantes_grupo").DataTable();
	table_listado_estudiantes_grupo.clear();
	var pre_grupo = '';
	if(tipo_grupo == 'arte_escuela'){
		var datos = {
			'opcion': 'get_estudiantes_grupo_arte_escuela',
			'id_grupo': id_grupo
		};
		pre_grupo = 'AE';
	}else if(tipo_grupo == 'emprende_clan'){
		var datos = {
			'opcion': 'get_estudiantes_grupo_emprende_clan',
			'id_grupo': id_grupo
		};
		pre_grupo = 'EC';
	}else if(tipo_grupo == 'laboratorio_clan'){
		var datos = {
			'opcion': 'get_estudiantes_grupo_laboratorio_clan',
			'id_grupo': id_grupo
		};
		pre_grupo = 'LC';
	}
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#table_listado_estudiantes_grupo").html(data);
		},
		async: false
	});

	table_listado_estudiantes_grupo.destroy();
	$("#table_listado_estudiantes_grupo").DataTable({
		responsive: true,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información, lo sentimos.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(Filtrado de un total de _MAX_ registros)",
			"search": "Filtrar"
		},
		dom: 'Bfrtip',
		buttons: [
		{
			extend: 'excel',

			title: 'Listado estudiantes grupo '+ pre_grupo +'-' + id_grupo
		}
		]
	});
	table_listado_estudiantes_grupo.draw();
}

function cargarCaracterizacionesGrupoArteEscuela(id_grupo){

	var datos = {
		'opcion': 'get_Catacterizaciones_Grupo_Arte_Escuela',
		'id_grupo': id_grupo
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#SL_Caracterizaciones_Grupo_Arte_Escuela").html(data);
		},
		async: false
	});
}

function cargarCaracterizacionesGrupoEmprendeClan(id_grupo){

	var datos = {
		'opcion': 'get_Catacterizaciones_Grupo_Emprende_Clan',
		'id_grupo': id_grupo
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#SL_Caracterizaciones_Grupo_Emprende_Clan").html(data);
		},
		async: false
	});
}

function cargarCaracterizacionesGrupoLaboratorioClan(id_grupo){

	var datos = {
		'opcion': 'get_Catacterizaciones_Grupo_Laboratorio_Clan',
		'id_grupo': id_grupo
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#SL_Caracterizaciones_Grupo_Laboratorio_Clan").html(data);
		},
		async: false
	});
}

function cargarPlaneacionesGrupoArteEscuela(id_grupo){

	var datos = {
		'opcion': 'get_Planeaciones_Grupo_Arte_Escuela',
		'id_grupo': id_grupo
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#SL_Planeacion_Grupo_Arte_Escuela").html(data);
		},
		async: false
	});
}

function cargarPlaneacionesGrupoEmprendeClan(id_grupo){

	var datos = {
		'opcion': 'get_Planeaciones_Grupo_Emprende_Clan',
		'id_grupo': id_grupo
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#SL_Planeacion_Grupo_Emprende_Clan").html(data);
		},
		async: false
	});
}

function cargarPlaneacionesGrupoLaboratorioClan(id_grupo){

	var datos = {
		'opcion': 'get_Planeaciones_Grupo_Laboratorio_Clan',
		'id_grupo': id_grupo
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#SL_Planeacion_Grupo_Laboratorio_Clan").html(data);
		},
		async: false
	});
}

function  cargarValoraciones(id_grupo,lineaAtencion){

	var datos = {
		'opcion': 'getValoraciones',
		'lineaAtencion': lineaAtencion,
		'id_grupo': id_grupo
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			if (lineaAtencion == 'arte_escuela') {
				$("#SL_Valoracion_Grupo_Arte_Escuela").html(data);
			}
			if (lineaAtencion == 'emprende_clan') {
				$("#SL_Valoracion_Grupo_Emprende_Clan").html(data);
			}
		},
		async: false
	});
}

function getOptionsClanes(){
	var mostrar = "";
	datos = {
		funcion: 'getOptionsClanes'
	};
	$.ajax({
		url: url_ok_obj,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
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
function generarReportePlaneacion(planeacionId) {
	var datos = {
		'opcion': 'getPlaneacion',
		'planeacionId': planeacionId
	};
	var dataJson;
	$.ajax({
		async: false,
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			dataJson = JSON.parse(data)[0];
			codigoGrupo=dataJson.FK_grupo;
			dataJson.VC_Acciones = JSON.parse(dataJson.VC_Acciones);
			
		}
	});
	dataJson.horario = getHorario(dataJson.FK_grupo,dataJson.FK_Id_Linea_atencion);
	dataJson.referentes = [];
	var referentes = dataJson.VC_Referentes.split(";");
	$.each(referentes, function (i) {
		if (referentes[i] != '') {
			dataJson.referentes.push(referentes[i]);
		}
	});    
	if (dataJson.FK_Ciclo == 0) {
		dataJson.VC_Ciclo = '';
	}
	var estado = "off"; 
	if (dataJson.IN_Estado == 1) {
		estado = "on";
	} else {
		estado = "off";
	}
	dataJson.estado = '';
	if (dataJson.IN_Estado == null) {
		dataJson.estado = "Sin Revisar";
	}
	else{
		if (dataJson.IN_Estado == 1) {
			dataJson.estado = 'Aprobado';
		}
		else
		{
			dataJson.estado = 'No Aprobado';
		}
	}
	dataJson.FK_Ciclo = getCiclo(dataJson.FK_Ciclo); 
	if (dataJson.FK_Id_Linea_atencion == 'arte_escuela'){
		$('#TXT_Observacion_ae').val(dataJson.VC_Observacion);
		dataJson = getGeneral(dataJson);
		dataJson.Entidad = getEntidad(dataJson.FK_grupo,1);
		dataJson.FK_grupo_nombre = "AE-"+dataJson.FK_grupo; 
		dataJson.lineaAtencion = 'Arte en la Escuela';
		$('#IN_Estado_pl_ae').bootstrapToggle(estado);
	}
	if (dataJson.FK_Id_Linea_atencion == 'emprende_clan'){
		$('#TXT_Observacion_ec').val(dataJson.VC_Observacion);
		dataJson = getGeneral(dataJson);
		dataJson.Entidad = getEntidad(dataJson.FK_grupo,2);
		dataJson.FK_grupo_nombre = "EC-"+dataJson.FK_grupo; 
		dataJson.lineaAtencion = 'EMPRENDE CREA';
		$('#IN_Estado_pl_ec').bootstrapToggle(estado);
	}
	if (dataJson.FK_Id_Linea_atencion == 'laboratorio_clan'){
		$('#TXT_Observacion_lc').val(dataJson.VC_Observacion);
		dataJson = getGeneral(dataJson);
		dataJson.Entidad = getEntidad(dataJson.FK_grupo,2);
		dataJson.FK_grupo_nombre = "LC-"+dataJson.FK_grupo; 
		dataJson.lineaAtencion = 'LABORATORIO CREA';
		$('#IN_Estado_pl_lc').bootstrapToggle(estado);
	}
	if (dataJson.VC_Articulacion == null ) {
		dataJson.VC_Articulacion = 'DILIGENCIA AFA/AF por IED ';
	}
	dataJson.recursos = getRecursos(dataJson.VC_Recursos);
	dataJson.nombreFormador = getFormador(dataJson.FK_Id_Usuario_Registro);
	dataJson.VC_Metodologia = dataJson.VC_Metodologia.replace(/;/g, ", ")+".";
	generarPdfPlaneacion(dataJson);
}
function getRecursos(recursos) {
	var recursosString = '';
	var datos = {
		'opcion':'getRecursos',
		'recursos': recursos
	};
	$.ajax({
		async: false,
		url:url_service,
		type:'POST',
		data: datos,
		success: function(datos){
			recursosData = JSON.parse(datos);
			$.each(recursosData, function (i) {
				recursosString = recursosString+recursosData[i].VC_Nombre+ ', '
			});  
			recursosString = recursosString.substr(0,recursosString.length-2);
		}
	}); 
	recursosVec = recursos.split(';');
	if (recursosVec[recursosVec.length-1] != '') {
		recursosString = recursosString + ', '+recursosVec[recursosVec.length-1];
	}
	recursosString+='.';
	return recursosString;
}
function getFormador(formadorId) {
	var formador = '';
	var url_controller = '../../Controlador/Pedagogico/C_Planeacion_Grupo.php';
	var datos = {
		'opcion':'getFormador',
		'idUsuario': formadorId
	};
	$.ajax({
		async: false,
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(datos){
			item = JSON.parse(datos)[0];
			formador = item.VC_Primer_Nombre+' '+item.VC_Segundo_Nombre+' '+item.VC_Primer_Apellido+' '+item.VC_Segundo_Apellido;
		}
	}); 
	return formador;
}

function getEntidad(codigoGrupoEntidad,linea){//linea 1: arte en la escuela, 2: emprende clan, 3:Laboratorio Clan.
	var result = "";
	var datos = {
		'opcion':'getEntidad',
		'idGrupo': codigoGrupoEntidad,
		'linea': linea
	};
	var url_controller = '../../Controlador/Pedagogico/C_Planeacion_Grupo.php';
	$.ajax({
		async: false,
		url:url_controller,
		type:'POST',
		data: datos,
		success: function(data){
			result = JSON.parse(data)[0];
			if (result.VC_Nom_Organizacion == null) {
				result.VC_Nom_Organizacion = "Sin Organización";
			} 
		}
	})
	return result;
}
function getGeneral(dataJson) {
	var url_controller = '../../Controlador/Pedagogico/C_Planeacion_Grupo.php';
	$.ajax({
		async : false,
		url: url_controller,
		type: 'POST',
		dataType: 'json',
		data: {idGrupo: dataJson.FK_grupo,tipoGrupo:dataJson.FK_Id_Linea_atencion,opcion:'getCInformacionGrupo'},
		success: function(datos)
		{
			dataJson.VC_Nom_Area = datos[0].VC_Nom_Area;
			dataJson.colegioText = 'COLEGIO:';
			dataJson.colegio = datos[0].VC_Nom_Colegio;
			dataJson.VC_Nom_Clan = datos[0].VC_Nom_Clan;
			if(datos[0].IN_lugar_atencion == 1){
				dataJson.lugar_atencion = "COLEGIO";
			}else{
				if(datos[0].IN_lugar_atencion == 2){
					dataJson.lugar_atencion = "CREA";        
				}
				else{
					if(datos[0].IN_lugar_atencion == 3) {
						dataJson.lugar_atencion = "CREA y COLEGIO";              
					}
				}
			}
			if (dataJson.FK_Id_Linea_atencion == 'emprende_clan') {
				dataJson.lugar_atencion = "CREA";
				dataJson.colegioText = 'MODALIDAD:';
				dataJson.colegio = datos[0].VC_Nom_Modalidad;
			}
			if (dataJson.FK_Id_Linea_atencion == 'laboratorio_clan') {
				dataJson.lugar_atencion = datos[0].VC_Nombre_Lugar;
				dataJson.colegio = "No Aplica";
			}
		}
	});
	return dataJson;
}
function getCiclo(ciclo) {
	ciclo = ciclo.replace("0","No Aplica");
	ciclo = ciclo.replace("1","I");
	ciclo = ciclo.replace("2","II");
	ciclo = ciclo.replace("3","III");
	ciclo = ciclo.replace("4","IV");
	return ciclo;
}
function getHorario(codigo_grupo,linea) {//linea 1: arte en la escuela, 2: emprende clan
	if (linea == 'arte_escuela') {
		opcion = 'getHorarioGrupoArteEscuela';
	}
	if (linea == 'emprende_clan') {
		opcion = 'getHorarioGrupoEmprendeClan';
	}
	if (linea == 'laboratorio_clan') {
		opcion = 'getHorarioGrupoLaboratorioClan';
	}
	var horario = '';
	$.ajax({
		async : false,
		url: '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php',
		type: 'POST',
		dataType: 'html',
		data: {opcion: opcion  , codigo_grupo:codigo_grupo},
		success: function(INFO)
		{
			if(INFO){
				horario= INFO;
			}
		}
	});
	return horario.replace(/<br>/g,' ');
}
function generarPdfPlaneacion(dataJson)
{
	var imageBogota;
	var imageClan;
	pdfData = {
		content: [
		{
			style: 'tableExample',
			table: {
				widths: ['20%','55%', '*'],

				body: [
				[
				{
					image: 'data:image/png;base64,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',
					height:60,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nFORMATO DE PLANEACIÓN',alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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',
					//height:60,
					//width:120,
					border: [false, false, false, false]
				},

				]
				]

			}

		},
		{
			style: 'tableExample',
			table: {
				widths: ['33%','33%', '33%'],
				body: [
				[{
					text:[{text: 'LINEA DE ATENCIÓN: ',style: 'tableHeader'},"\n",{text:dataJson.lineaAtencion}],
					colSpan: 2,
				},{},{
					text:[{text: 'LUGAR DE ATENCIÓN: ',style: 'tableHeader'},"\n",{text:dataJson.lugar_atencion}],
				}],
				[{
					text:[{text: 'CREA: ',style: 'tableHeader'},"\n",{text:dataJson.VC_Nom_Clan}],
				},{
					text:[{text: 'ÁREA: ',style: 'tableHeader'},"\n",{text:dataJson.VC_Nom_Area}],
				},{
					text:[{text: 'CURSO: ',style: 'tableHeader'},"\n",{text:dataJson.FK_grupo_nombre}],
				}],
				[{
					text:[{text: 'ARTISTA FORMADOR: ',style: 'tableHeader'},"\n",{text:dataJson.nombreFormador}],
				},{
					text:[{text: dataJson.colegioText,style: 'tableHeader'},"\n",{text:dataJson.colegio}],
				},{
					text:[{text: 'CICLO: ',style: 'tableHeader'},"\n",{text:dataJson.FK_Ciclo}],
				}],
				[{
					text:[{text: 'ENTIDAD/ORGANIZACIÓN: ',style: 'tableHeader'},"\n",{text:dataJson.Entidad.VC_Nom_Organizacion}],
					colSpan: 3
				},
				{},
				{}
				],
				[{
					text:[{text: 'HORARIO DE GRUPO: ',style: 'tableHeader'},"\n",{text:dataJson.horario}],
					colSpan: 2
				},{},
				{
					text:[{text: 'FECHA DE ELABORACIÓN: ',style: 'tableHeader'},"\n",{text:dataJson.DA_Fecha_Registro}],
				}],
				[{
					text:[{text: 'ESTADO: ',style: 'tableHeader'},"\n",{text:dataJson.estado}],
					colSpan: 3
				},{},
				{}]
				]
			}
		},
		{text: '\n'},
		{
			style: 'tableExample',
			table: {
				widths: ['50%','50%'],
				body: [
				[{
					text:[{text: 'OBJETIVO DE FORMACIÓN: ',style: 'tableHeader'},"\n\n",{text:dataJson.VC_Objetivo}],

				},{
					text:[{text: 'PREGUNTA ORIENTADORA: ',style: 'tableHeader'},"\n\n",{text:dataJson.VC_Pregunta}],
				}],
				[[{text: 'PERSPECTIVA PEDAGÓGICA: ',style: 'tableHeader'},"\n",{text:dataJson.VC_Descripcion}],
				{   rowSpan: 2,text:[{text: 'FUNDAMENTACIÓN METODOLÓGICA: ',style: 'tableHeader'},"\n\n",{text:dataJson.VC_Metodologia}]}
				],[
				{text:[{text: 'RESULTADOS ',style: 'tableHeader'},"\n\n",{text:dataJson.VC_Resultados}]},''
				],
				[{
					text:[{text: 'TEMAS PROPUESTOS: ',style: 'tableHeader'},"\n\n",{text:dataJson.VC_Temas}],

				},{
					text:[{text: 'RECURSOS FUNGIBLES Y TECNOLÓGICOS: ',style: 'tableHeader'},"\n\n",{text:dataJson.recursos}],
				}],
				[{
					stack: [
					{text: 'REFERENTES: ',style: 'tableHeader'},
					{
						ul: dataJson.referentes
					}
					]
				},{
					text:[{text: 'PROPUESTA DE CIRUCLACIÓN (MUESTRAS LOCALES Y FINALES): ',style: 'tableHeader'},"\n\n",{text:dataJson.VC_Propuesta_Circulacion}],
				}]
				]
			}
		},
		{text: '\n\n'},
		{

			style: 'tableExample',
			table: {
				widths: ['20%','80%'],
				body: [
				
				[{
					text:[{text: 'ACCIONES EN EL AULA: ',style: 'tableHeader',alignment:'center'}],
					colSpan: 2,
				},{}
				],
				[{rowSpan: 4, text: [{text: 'MES 1\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_1}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_2}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_3}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_4}]}],
				[{rowSpan: 4, text: [{text: 'MES 2\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_5}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_6}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_7}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_8}]}],
				],

			}
		},
		{text: '\n\n\n\n'},
		{

			style: 'tableExample',
			table: {
				widths: ['20%','80%'],
				body: [
				
				[{
					text:[{text: 'ACCIONES EN EL AULA: ',style: 'tableHeader',alignment:'center'}],
					colSpan: 2,
				},{}
				],
				[{rowSpan: 4, text: [{text: 'MES 3\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_9}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_10}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_11}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_12}]}],
				[{rowSpan: 4, text: [{text: 'MES 4\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_13}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_14}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_15}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_16}]}],
				[{rowSpan: 4, text: [{text: 'MES 5\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_17}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_18}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_19}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_20}]}],
				[{rowSpan: 4, text: [{text: 'MES 6\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_21}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_22}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_23}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_24}]}],
				[{rowSpan: 4, text: [{text: 'MES 7\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_25}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_26}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_27}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_28}]}],
				[{rowSpan: 4, text: [{text: 'MES 8\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_29}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_30}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_31}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_32}]}],
				[{rowSpan: 4, text: [{text: 'MES 9\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_33}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_34}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_35}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_36}]}],
				[{rowSpan: 4, text: [{text: 'MES 10\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_37}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_38}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_39}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_40}]}],
				[{rowSpan: 4, text: [{text: 'MES 11\n ACCIONES:',style: 'tableHeader'}]},
				{text: [{text: 'SEMANA 1:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_41}]}],['',
				{text: [{text: 'SEMANA 2:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_42}]}],['',
				{text: [{text: 'SEMANA 3:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_43}]}],['',
				{text: [{text: 'SEMANA 4:\n',style: 'tableHeader'},{text:dataJson.VC_Acciones.semana_44}]}],
				],

			}
		},
		{text: '\n'},
		{text: '\n APORTES DE LAS ÁREAS ARTÍSTICAS DEL PROGRAMA CLAN IDARTES A LAS IEDs \n \n ',style:'subheader',alignment:'center'},
		{
			style: 'tableExample', 
			table: {
				widths: ['100%'],
				body: [
				[{
					text:[{text: 'ARTICULACIÓN CON EL PROYECTO EDUCATIVO INSTITUCIONAL (PEI)',style: 'tableHeader',alignment:'center'}],
				}],
				[{
					text:[{text: dataJson.VC_Articulacion,alignment:'left'}],
				}],
				[{
					text:[{text: 'ARTICULACIÓN CON LOS CICLOS DE EDUCACIÓN ',style: 'tableHeader',alignment:'center'}],
				}],
				[{
					stack: [
					{text:[{text: 'CICLO: '+dataJson.FK_Ciclo+' \n',style: 'tableHeader',alignment:'left'}],},
					{
						text:dataJson.VC_Ciclo
					}]
				}],
				]
			}
		},
		],
		images:
		{
			image_bogota: "data:image/jpeg;base64,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",
			image_clan: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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"
		},
		styles: {
			header: {
				fontSize: 15,
				bold: true,
				margin: [0, 0, 0, 10]
			},
			subheader: {
				fontSize: 12,
				bold: true,
				margin: [0, 10, 0, 5]
			},
			tableExample: {
				margin: [0, 5, 0, 15]
			},
			tableHeader: {
				bold: true,
				fontSize: 10,
				color: 'black'
			}
		},
		defaultStyle: {
			fontSize: 10
		}
	}
	/*convertImgToBase64("../imagenes/bogotaPdf.jpg", function(base64Img){
		imageBogota = base64Img;
	});
	convertImgToBase64("../imagenes/logo-crea-header.png", function(base64Img){
		imageClan = base64Img; 
		pdfData.images["image_bogota"]=imageBogota;
		pdfData.images["image_clan"]=imageClan;
		
	});*/
}

function cargarValoracion(valoracionId)
{
	var datos = {
		'opcion': 'getValoracion',
		'valoracionId': valoracionId
	};
	var dataJson;
	var dataJsonBasic;
	$.ajax({
		async: false,
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			dataJson = JSON.parse(data);
			dataJsonBasic= dataJson[0];
		}
	});
	dataJsonBasic.estado = '';
	codigoGrupo=dataJsonBasic.FK_Grupo;
	if (dataJsonBasic.IN_Estado == null) {
		dataJsonBasic.estado = "Sin Revisar";
	}
	else{
		if (dataJsonBasic.IN_Estado == '1') {
			dataJsonBasic.estado = 'Aprobado';
		}
		else
		{
			dataJsonBasic.estado = 'No Aprobado';
		}
	}
	var estado = "off"; 
	if (dataJsonBasic.IN_Estado == 1) {
		estado = "on";
	} else {
		estado = "off";
	}
	if (dataJsonBasic.FK_Linea_Atencion == 'arte_escuela') {		
		dataJsonBasic.VC_Grupo = 'AE-'+dataJsonBasic.FK_Grupo;
		$('#TXT_Observacion_Valoracion_ae').val(dataJsonBasic.TX_Observacion);
		if (dataJsonBasic.VC_Nombre_Archivo != undefined) {
			$('#DIV_Anexo_ae').html("<a class='btn btn-danger' data-id-archivo='"+valoracionId+"' download='"+dataJsonBasic.VC_Nombre_Archivo+"' href='../../public/Pedagogico/"+dataJsonBasic.VC_URL+"'><span class='fa fa-download'></span> Descargar Anexo</a>");
		}
		$('#IN_Estado_val_ae').bootstrapToggle(estado);
	}
	if (dataJsonBasic.FK_Linea_Atencion == 'emprende_clan') {		
		dataJsonBasic.VC_Grupo = 'EC-'+dataJsonBasic.FK_Grupo;
		$('#TXT_Observacion_Valoracion_ec').val(dataJsonBasic.TX_Observacion);
		if (dataJsonBasic.VC_Nombre_Archivo != undefined) {
			$('#DIV_Anexo_ec').html("<a class='btn btn-danger' data-id-archivo='"+valoracionId+"' download='"+dataJsonBasic.VC_Nombre_Archivo+"' href='../../public/Pedagogico/"+dataJsonBasic.VC_URL+"'><span class='fa fa-download'></span> Descargar Anexo</a>");
		}
		$('#IN_Estado_val_ec').bootstrapToggle(estado);
	}
	dataJsonBasic.horario = getHorario(dataJsonBasic.FK_Grupo,dataJsonBasic.FK_Linea_Atencion);
	dataJsonBasic.FK_Ciclo = getCiclo(dataJsonBasic.FK_Ciclo);
	dataJsonBasic.FK_Ciclo = dataJsonBasic.FK_Ciclo.replace("CICLO ", "");
	if (dataJsonBasic.TX_Gesto_Cognitivo == '' ) {
		dataJsonBasic.TX_Gesto_Cognitivo = "Explora, desarrolla y comprende los lenguajes propios de las áreas artísticas, con el objetivo de fortalecer y consolidar los procesos de creación.";
	}
	estudiantes = [];
	$.each(dataJson, function (i) {

		estudiantes.push(
		{
			style: 'tableExample',
			table: {
				widths: ['4%','18.9%','5.5%','8%','12.3%','12.3%','12.3%','26.72%'],
				body: [
				[{
					alignment:'center',
					text:[{text:(i+1),style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: dataJson[i].VC_Nombre_Estudiante,style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: dataJson[i].VC_Descripcion_Grado,style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: dataJson[i].TX_Asistencia,style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: getDesempeno(dataJson[i].IN_Val_Cognitivo),style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: getDesempeno(dataJson[i].IN_Val_Actitudinal),style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: getDesempeno(dataJson[i].IN_Val_Convivencial),style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: dataJson[i].TX_Recomendacion,style: 'tableHeader'}],
				}],
				]
			}
		});
	}); 

	generarPdfValoracion(dataJsonBasic,dataJson,estudiantes);
}
function getDesempeno(desempeno) {
	if (desempeno == 1) {
		return 'Bajo';
	}
	if (desempeno == 2) {
		return 'Básico';
	}
	if (desempeno == 3) {
		return 'Alto';
	}
	if (desempeno == 4) {
		return 'Superior';
	}
}
function generarPdfValoracion(dataJsonBasic,dataJson,estudiantes)
{
	var imageBogota;
	var imageClan;
	pdfData = {
		pageOrientation: 'landscape',
		content: [
		{
			style: 'tableExample',
			table: {
				widths: ['100%'],
				body: [
				[{
					border: [true, true, true, false],

					text:[{text: 'COLEGIO '+dataJsonBasic.VC_Colegio,style: 'tableHeader',alignment: 'center'}],
				}],
				[{
					border: [true, false, true, false],
					text:[{text: 'VALORACIÓN PROCESOS DE FORMACIÓN ARTÍSTICA ',style: 'tableHeader',alignment: 'center'}],
				}],
				[{
					border: [true, false, true, false],
					text:[{text: 'GRUPO '+dataJsonBasic.VC_Grupo,style: 'tableHeader',alignment: 'center'}],
				}],
				[{
					border: [true, false, true, true],
					text:[{text: 'PROGRAMA CREA - IDARTES',style: 'tableHeader',alignment: 'center'}],
				}],
				]
			},
		}, 
		{
			style: 'tableExample',
			table: {
				widths: ['50%','50%'],
				body: [
				[{
					text:[{text: 'CREA: ',style: 'tableHeader'},{text:dataJsonBasic.VC_Nom_Clan}],
				},{
					text:[{text: 'ARTISTA FORMADOR: ',style: 'tableHeader'},{text:dataJsonBasic.VC_Nombre_Artista_Formador}],
				}],
				[{
					text:[{text: 'ENTIDAD/ORGANIZACIÓN: ',style: 'tableHeader'},{text:dataJsonBasic.VC_Entidad}],
				},{
					text:[{text: 'ÁREA ARTÍSTICA: ',style: 'tableHeader'},{text:dataJsonBasic.VC_Nom_Area}],
				}],
				[{
					text:[{text: 'HORARIO DEL GRUPO: ',style: 'tableHeader'},{text:dataJsonBasic.horario}],
				},{
					text:[{text: 'PERIODO: ',style: 'tableHeader'},{text:dataJsonBasic.FK_Periodo}],
				}],
				[{
					text:[{text: 'CICLO: ',style: 'tableHeader'},{text:dataJsonBasic.FK_Ciclo}],
				},
				{
					text:[{text: 'FECHA: ',style: 'tableHeader'},{text:dataJsonBasic.DA_Fecha}],   
				}
				],
				[{
					text:[{text: 'ESTADO: ',style: 'tableHeader'},{text:dataJsonBasic.estado}],
					colSpan: 2
				},{}
				]
				]
			},
		},
		{
			style: 'tableExample',
			table: {
				widths: ['19%','19%','12%','12%','12%','26%'],
				body: [
				[
				{
					style:'centerImage',
					alignment:'center',
					image: 'data:image/png;base64,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',
					height:60,
					width:120,
					rowSpan:2,
					border: [true, true, false, true],
				},{
					style:'centerImage',
					alignment:'center',
					image: 'image_clan',
					//height:60,
					//width:120,
					rowSpan:2,
					border: [false, true, true, true],
				},{
					alignment:'center',
					text:[{text: 'COGNITIVO ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'ACTITUDINAL ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'CONVIVENCIAL ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'RECOMENDACIONES Y OBSERVACIONES ',style: 'tableHeader'}],
				}],
				[{},
				{},{
					text:[{text: dataJsonBasic.TX_Gesto_Cognitivo,style: 'tableHeader'}],
				},{
					text:[{text: 'Participa y demuestra interés en las actividades propuestas para el desarrollo del proceso de formación. ',style: 'tableHeader'}],
				},{
					text:[{text: 'Contribuye en la creación de un ambiente constructivo para el desarrollo de las actividades artísticas y formativas. ',style: 'tableHeader'}],
				},{
					text:[{text: 'Sugerencias sobre el desempeño del estudiante en el centro de interés: experiencias relevantes, dificultades específicas y/o anotaciones adicionales. ',style: 'tableHeader'},],
				}],
				]
			},
		},
		{
			style: 'tableExample',
			table: {
				widths: ['4%','18.9%','5.5%','8%','12.3%','12.3%','12.3%','26.72%'],
				body: [
				[{
					alignment:'center',
					text:[{text: 'N°',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'NOMBRES Y APELLIDOS ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'CURSO ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'ASISTENCIA ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'DESEMPEÑO ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'DESEMPEÑO ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: 'DESEMPEÑO ',style: 'tableHeader'}],
				},{
					alignment:'center',
					text:[{text: ' ',style: 'tableHeader'}],
				}],
				]
			},
		},
		estudiantes
		],        
		images:
		{
			image_bogota: "data:image/jpeg;base64,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",
			image_clan: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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"
		},
		styles: {
			header: {
				fontSize: 15,
				bold: true,
				margin: [0, 0, 0, 10]
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
				fontSize: 10,
				color: 'black',
			},
			centerImage: {
				margin: [0, 40, 0, 0]
			},
			paddingBottom: function(i, node) { return 2; }
		},
		defaultStyle: {
			fontSize: 10
		}
	}
/*	convertImgToBase64("../imagenes/bogotaPdf.jpg", function(base64Img){
		imageBogota = base64Img;
	});
	convertImgToBase64("../imagenes/logo-crea-header.png", function(base64Img){
		imageClan = base64Img;
		pdfData.images["image_bogota"]=imageBogota;
		pdfData.images["image_clan"]=imageClan;
		
	});*/
}

function descargarObservaciones(id_grupo,tipo,lineaAtencion) {
	var datos = {
		'opcion': 'getObservaciones',
		'grupoId': id_grupo,
		'tipo':tipo,
		'lineaAtencion': lineaAtencion
	};
	var observacionData;
	var observacion;
	$.ajax({
		async: false,
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			observacionData = JSON.parse(data);
			observacion = observacionData[0];
			
		}
	});
	observacion.horario = getHorario(observacion.FK_grupo,observacion.FK_Id_Linea_atencion);
	observacion.tipo = tipo;
	if (tipo == 'caracterizacion') {
		observacion.tipoTitulo = 'CARACTERIZACIÓN';
	}
	if (tipo == 'planeacion') {
		observacion.tipoTitulo = 'PLANEACIÓN';
	}
	if (tipo == 'valoracion') {
		observacion.tipoTitulo = 'VALORACIÓN';
	}
	observacion.tipo = tipo;
	if (observacion.FK_Ciclo == 0) {
		observacion.VC_Ciclo = '';
	}
	observacion.estado = '';
	if (observacion.IN_Estado == null) {
		observacion.estado = "Sin Revisar";
	}
	else{
		if (observacion.IN_Estado == 1) {
			observacion.estado = 'Aprobado';
		}
		else
		{
			observacion.estado = 'No Aprobado';
		}
	}
	observacion.FK_Ciclo = getCiclo(observacion.FK_Ciclo); 
	if (observacion.FK_Id_Linea_atencion == 'arte_escuela'){
		observacion = getGeneral(observacion);
		observacion.Entidad = getEntidad(observacion.FK_grupo,1);
		observacion.FK_grupo_nombre = "AE-"+observacion.FK_grupo; 
		observacion.lineaAtencion = 'Arte en la Escuela';
	}
	if (observacion.FK_Id_Linea_atencion == 'emprende_clan'){
		observacion = getGeneral(observacion);
		observacion.Entidad = getEntidad(observacion.FK_grupo,2);
		observacion.FK_grupo_nombre = "EC-"+observacion.FK_grupo; 
		observacion.lineaAtencion = 'Emprende CREA';
	}
	if (observacion.FK_Id_Linea_atencion == 'laboratorio_clan'){
		observacion = getGeneral(observacion);
		observacion.Entidad = getEntidad(observacion.FK_grupo,3);
		observacion.FK_grupo_nombre = "LC-"+observacion.FK_grupo; 
		observacion.lineaAtencion = 'Laboratorio CREA';
	}

	registros = [];
	$.each(observacionData, function (i) {
		observacionData[i].estado = '';
		if (observacionData[i].IN_Estado == null) {
			observacionData[i].estado = "Sin Revisar";
		}
		else{
			if (observacionData[i].IN_Estado == 1) {
				observacionData[i].estado = 'Aprobado';
			}
			else
			{
				observacionData[i].estado = 'No Aprobado';
			}
		}
		registros.push(
		{
			style: 'tableData',
			table: {
				widths: ['20%','21%','11%','21%','26%'],
				body: [
				[{
					text:[{text: observacionData[i].VC_Primer_Nombre + " " + 
					observacionData[i].VC_Segundo_Nombre + " " + 
					observacionData[i].VC_Primer_Apellido + " " + 
					observacionData[i].VC_Segundo_Apellido}],
				},{
					text:[{text: observacionData[i].DA_Fecha_Registro}],
				},{
					text:[{text: observacionData[i].estado}],
				},{
					text:[{text: observacionData[i].DT_AFA_Cambio}],
				},{
					text:[{text: observacionData[i].TX_Observacion}],
				}],
				]
			}
		});
	}); 
	observacion.registros = registros;	
	$.ajax({
		async: false,
		url:"../../Controlador/Administracion/C_Notificaciones.php",
		type:'POST',
		data: {opcion:'getDate'},
		success: function(fecha){
			observacion.DT_Fecha = fecha;
		}
	});	
	generarPdfObservacion(observacion);

}

function generarPdfObservacion(observacionData) {
	var imageBogota;
	var imageClan;
	var pdfDataObser = {
		content: [
		{
			style: 'tableExample',
			table: {
				widths: ['20%','55%', '*'],

				body: [
				[
				{
					image: 'data:image/png;base64,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',
					height:60,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nOBSERVACIONES '+observacionData.tipoTitulo,alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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',
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
				widths: ['33%','33%', '33%'],
				body: [
				[{
					text:[{text: 'LINEA DE ATENCIÓN: ',style: 'tableHeader'},"\n",{text:observacionData.lineaAtencion}],
					colSpan: 2,
				},{},{
					text:[{text: 'LUGAR DE ATENCIÓN: ',style: 'tableHeader'},"\n",{text:observacionData.lugar_atencion}],
				}],
				[{
					text:[{text: 'CLAN: ',style: 'tableHeader'},"\n",{text:observacionData.VC_Nom_Clan}],
				},{
					text:[{text: 'ÁREA: ',style: 'tableHeader'},"\n",{text:observacionData.VC_Nom_Area}],
				},{
					text:[{text: 'GRUPO: ',style: 'tableHeader'},"\n",{text:observacionData.FK_grupo_nombre}],
				}],
				[{
					text:[{text: 'ENTIDAD/ORGANIZACIÓN: ',style: 'tableHeader'},"\n",{text:observacionData.Entidad.VC_Nom_Organizacion}],
					colSpan: 3
				},
				{},
				{}
				],
				[{
					text:[{text: 'HORARIO DE GRUPO: ',style: 'tableHeader'},"\n",{text:observacionData.horario}],
					colSpan: 2
				},{},
				{
					text:[{text: 'FECHA DE REPORTE: ',style: 'tableHeader'},"\n",{text:observacionData.DT_Fecha}],
				}],
				]
			}
		}, 
		{
			style: 'tableData',
			table: {
				widths: ['20%','21%','11%','21%','26%'],
				body: [
				[{
					text:[{text: 'Artista Formador',style: 'tableHeader'}],
				},{
					text:[{text: 'Fecha de Generación',style: 'tableHeader'}],
				},{
					text:[{text: 'Estado',style: 'tableHeader'}],
				},{
					text:[{text: 'Fecha Observación',style: 'tableHeader'}],
				},{
					text:[{text: 'Observación',style: 'tableHeader'}],
				}]
				]
			}
		},
		observacionData.registros,
		],
		images:
		{
			image_bogota: "data:image/jpeg;base64,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",
			image_clan: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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"
		},
		styles: {
			header: {
				fontSize: 13,
				bold: true,
				margin: [0, 0, 0, 10]
			},
			subheader: {
				fontSize: 12,
				bold: true,
				margin: [0, 10, 0, 5]
			},
			tableExample: {
				margin: [0, 0, 0, 10]
			},
			tableData: {
				margin: [0, -0.2, 0, -1]
			},
			tableHeader: {
				bold: true,
				fontSize: 10,
				color: 'black'
			}
		},
		defaultStyle: {
			fontSize: 10
		}
	}/*
	convertImgToBase64("../imagenes/bogotaPdf.jpg", function(base64Img){
		imageBogota = base64Img;
	});
	convertImgToBase64("../imagenes/logo-crea-header.png", function(base64Img){
		imageClan = base64Img;
		pdfDataObser.images["image_bogota"] = imageBogota;
		pdfDataObser.images["image_clan"] = imageClan;
	});*/
	pdfMake.createPdf(pdfDataObser).download('Observacion '+observacionData.FK_grupo_nombre+' '+observacionData.tipo+'.pdf');
}