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

	$("#consolidadoGrupsClan").click(function(){
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
			$("#total_grupos_clan").removeClass('active');
			alertify.alert('Por Favor', 'Seleccione al menos un crea y un año de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarTotalGruposClan(id_clan,anos);
		}
	});

	$("#table_grupos_arte_escuela").delegate(".consultar_listado_estudiantes_grupo_arte_escuela","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: AE-" + id_grupo);
		cargarEstudiantesGrupo('arte_escuela',id_grupo);
	});

	$("#table_grupos_emprende_clan").delegate(".consultar_listado_estudiantes_grupo_emprende_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: IC-" + id_grupo);
		cargarEstudiantesGrupo('emprende_clan',id_grupo);
	});

	$("#table_grupos_laboratorio_clan").delegate(".consultar_listado_estudiantes_grupo_laboratorio_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: CV-" + id_grupo);
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
		$("#title_modal_caracterizaciones_grupo_ec").text("Caracterizaciones del grupo: IC-" + id_grupo);
		cargarCaracterizacionesGrupoEmprendeClan(id_grupo);
	});

	$("#table_grupos_laboratorio_clan").delegate(".consultar_caracterizaciones_grupo_laboratorio_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_car_ec").hide();
		$("#title_modal_caracterizaciones_grupo_lc").text("Caracterizaciones del grupo: CV-" + id_grupo);
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
		$("#title_modal_planeacion_grupo_ec").text("Planeación del grupo: IC-" + id_grupo);
		cargarPlaneacionesGrupoEmprendeClan(id_grupo);
	});

	$("#table_grupos_laboratorio_clan").delegate(".consultar_planeacion_grupo_laboratorio_crea","click",function(){
		id_grupo = $(this).data("id_grupo");
		$("#DIV_Observacion_lc").hide();
		lineaAtencion = "laboratorio_clan" ;
		$("#title_modal_planeacion_grupo_lc").text("Planeación del grupo: CV-" + id_grupo);
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
		$("#title_modal_valoracion_grupo_ec").text("Valoración del grupo: IC-" + id_grupo);
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
		pdfMake.createPdf(pdfData).download('Planeación IC-'+codigoGrupo+'.pdf'); 
	});
	$("#BT_ver_Planeacion_lc").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Planeación CV-'+codigoGrupo+'.pdf'); 
	});
	$("#BT_ver_Valoracion_ae").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Valoración AE-'+codigoGrupo+'.pdf'); 
	});
	$("#BT_ver_Valoracion_ec").click(function(e){
		e.preventDefault();
		pdfMake.createPdf(pdfData).download('Valoración IC-'+codigoGrupo+'.pdf'); 
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
		funcion: 'getGruposArteEscuelaByCrea',
		p1: id_clan,
		p2: anos
	};
	$.ajax({
		//url: url_service,
		url: url_ok_obj,  
		type: 'POST',
		data: datos,
		success: function(data){
			$("#table_grupos_arte_escuela").html(data);
			table_grupos_arte_escuela.destroy();
			$("#table_grupos_arte_escuela").DataTable({
				/*responsive: true,*/
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

					title: 'Grupos SIF - Arte en la escuela'
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
		funcion: 'getGruposEmprendeCreaByCrea',
		p1: id_clan,
		p2: anos
	};		 
	$.ajax({
		//url: url_service,
		url: url_ok_obj, 
		type: 'POST',
		data: datos,
		success: function(data){
			$("#table_grupos_emprende_clan").html(data);
			table_grupos_emprende_clan.destroy();
			$("#table_grupos_emprende_clan").DataTable({
				/*responsive: true,*/
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

					title: 'Grupos SIF - IMPULSO COLECTIVO'
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
		funcion: 'getGruposLaboratorioCreaByCrea',
		p1: id_clan,
		p2: anos 
	};	
	$.ajax({
		//url: url_service,
		url: url_ok_obj, 
		type: 'POST',
		data: datos,
		success: function(data){
			$("#table_grupos_laboratorio_clan").html(data);
			table_grupos_laboratorio_clan.destroy();
			$("#table_grupos_laboratorio_clan").DataTable({
				/*responsive: true,*/
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

					title: 'Grupos SIF - CONVERGE'
				}
				]
			});
			table_grupos_laboratorio_clan.draw();
			window.parent.$("#modal_enviando").modal("hide");
		},
		async: true
	});
}

function cargarTotalGruposClan(id_clan,anos){
	window.parent.$("#modal_enviando").modal("show");
	var table_total_grupos_clan = $("#table_total_grupos_clan").DataTable();
	table_total_grupos_clan.clear(); 
	/*var datos = {
		'opcion': 'get_grupo_laboratorio_clan',
		'id_clan': id_clan
	};*/
	var datos = {
		funcion: 'getTotalGruposClan',
		p1: id_clan,
		p2: anos 
	};	
	$.ajax({
		//url: url_service,
		url: url_ok_obj, 
		type: 'POST',
		data: datos,
		success: function(data){
			$("#table_total_grupos_clan").html(data);
			table_total_grupos_clan.destroy();
			$("#table_total_grupos_clan").DataTable({
				/*responsive: true,*/
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

					title: 'Grupos SIF - Consolidado'
				}
				]
			});
			table_total_grupos_clan.draw();
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
		dataJson.FK_grupo_nombre = "IC-"+dataJson.FK_grupo; 
		dataJson.lineaAtencion = 'IMPULSO COLECTIVO';
		$('#IN_Estado_pl_ec').bootstrapToggle(estado);
	}
	if (dataJson.FK_Id_Linea_atencion == 'laboratorio_clan'){
		$('#TXT_Observacion_lc').val(dataJson.VC_Observacion);
		dataJson = getGeneral(dataJson);
		dataJson.Entidad = getEntidad(dataJson.FK_grupo,2);
		dataJson.FK_grupo_nombre = "CV-"+dataJson.FK_grupo; 
		dataJson.lineaAtencion = 'CONVERGE';
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
					image: 'alcaldia_bogota_logo',
					height:60,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nFORMATO DE PLANEACIÓN',alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'image_clan',
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
			alcaldia_bogota_logo: "data:image/png;base64,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",
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
		pdfData.images["alcaldia_bogota_logo"]=imageBogota;
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
		dataJsonBasic.VC_Grupo = 'IC-'+dataJsonBasic.FK_Grupo;
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
					image: 'alcaldia_bogota_logo',
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
			alcaldia_bogota_logo: "data:image/png;base64,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",
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
		pdfData.images["alcaldia_bogota_logo"]=imageBogota;
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
		observacion.FK_grupo_nombre = "IC-"+observacion.FK_grupo; 
		observacion.lineaAtencion = 'Impulso Colectivo';
	}
	if (observacion.FK_Id_Linea_atencion == 'laboratorio_clan'){
		observacion = getGeneral(observacion);
		observacion.Entidad = getEntidad(observacion.FK_grupo,3);
		observacion.FK_grupo_nombre = "CV-"+observacion.FK_grupo; 
		observacion.lineaAtencion = 'Converge';
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
					image: 'alcaldia_bogota_logo',
					height:60,
					width:120,
					border: [false, false, false, false]
				},
				{
					text: '\nOBSERVACIONES '+observacionData.tipoTitulo,alignment:'center', style: 'header',
					border: [false, false, false, false]
				},
				{
					image: 'image_clan',
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
			alcaldia_bogota_logo: "data:image/png;base64,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",
			image_clan: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABBCAYAAAAzOl11AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDozMUZGNkY4MkZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDozMUZGNkY4M0ZENzAxMUU3OUE2NEQ0OEQyMjQ1OTJEQSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjMxRkY2RjgwRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjMxRkY2RjgxRkQ3MDExRTc5QTY0RDQ4RDIyNDU5MkRBIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+uMYxfgAADCNJREFUeNrsXQ2YVUUZ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'
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
		pdfDataObser.images["alcaldia_bogota_logo"] = imageBogota;
		pdfDataObser.images["image_clan"] = imageClan;
	});*/
	pdfMake.createPdf(pdfDataObser).download('Observacion '+observacionData.FK_grupo_nombre+' '+observacionData.tipo+'.pdf');
}