var url_service = '../../Controlador/Administracion/C_Solicitud_Soporte.php';
$(function(){
	cargarDatosUsuario();
	$("#BT_enviar_solicitud").click(function(){
		if($("#TX_solicitud").val() == ""){
			alert("Debe diligenciar el detalle de la solicitud");
		}else{
			agregarSolicitudSoporte();
		}
	});
	$("#ver_historico").click(function(){
		cargarHistoricoSolicitudes();
	});
	$("#SL_tipo_soporte").html(getTiposSoporte());
});

function cargarDatosUsuario(){
	datos = {
		opcion: 'get_datos_usuario',
		id_usuario: $("#id_usuario").val()
	}
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		success: function(data){
			d = $.parseJSON(data);
			$("#TB_nombre_usuario").val(d['nombre']);
			$("#TB_identificacion_usuario").val(d['identificacion']);
			$("#TB_correo_usuario").val(d['correo']);
		},
		async: false
	});
}

function agregarSolicitudSoporte(){
	var datos = {
		opcion: 'add_solicitud_soporte',
		id_usuario: $("#id_usuario").val(),
		id_tipo_soporte: $("#SL_tipo_soporte").val(),
		solicitud: $("#TX_solicitud").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			alert("Se ha enviado correctamente su solicitud, recuerde verificar la respuesta en la pestaña de 'Historico mis soportes'");
			$("#TX_solicitud").val("");
		}
	});
}

function cargarHistoricoSolicitudes(){
	var table_historico_solicitudes = $("#table_historico_solicitudes").DataTable();
	table_historico_solicitudes.clear();
	var datos = {
		opcion: 'get_historico_solicitudes',
		id_usuario: $("#id_usuario").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#table_historico_solicitudes").html(data);
		},
		async: false
	});
	table_historico_solicitudes.destroy();
    $("#table_historico_solicitudes").DataTable({
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
    table_historico_solicitudes.draw();
}

function getTiposSoporte(){
	var mostrar = "";
	var datos = {
		opcion: 'get_tipo_soporte'
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			mostrar += data;
		},
		async: false
	});
	return mostrar;
}