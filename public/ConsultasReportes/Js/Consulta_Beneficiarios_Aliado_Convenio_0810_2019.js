//var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php';
var url_service = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';

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

	$("#SL_Mes_Desde").html(parent.getOptionParametroDetalle(8));
	$("#SL_Mes_Hasta").html(parent.getOptionParametroDetalle(8));
	
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	} );	

	$("#BT_CONSULTAR").on("click", function(){
		var mes_desde = $("#SL_Mes_Desde").val();
		var mes_hasta = $("#SL_Mes_Hasta").val();
		cargarAliadosBeneficiariosConvenioSeguridad_0810_2019(mes_desde, mes_hasta);
	});
});

function cargarAliadosBeneficiariosConvenioSeguridad_0810_2019(mes_desde, mes_hasta){
	window.parent.$("#modal_enviando").modal("show");
	$("#div_table_aliados_convenio > tbody").html("");
	var datos = {
		'funcion': 'getBeneficariosAliadosConvenio_0810_2019',
		p1: mes_desde,
		p2: mes_hasta
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#div_table_aliados_convenio").html(data);
			var tabla = $("#table_aliados_beneficiarios").DataTable({
				"pageLength": 100,
				"language": {
					"lengthMenu": "Ver _MENU_ registros por pagina",
					"zeroRecords": "No hay información, lo sentimos.",
					"info": "Mostrando pagina _PAGE_ de _PAGES_",
					"infoEmpty": "No hay registros disponibles",
					"infoFiltered": "(filtered from _MAX_ total records)",
					"search": "Filtrar"
				},
				autoWidth: false,
				dom: 'Bfrtip',
				buttons: [
				{
					extend: 'excel',
					exportOptions: {
						columns: ':visible'
					},
					title: 'Beneficiarios por Aliado - Laboratorio Crea (Convenio 0810-2019)'
				},
				]
			}).draw();
			window.parent.$("#modal_enviando").modal("hide"); 
		},
		async: true
	});
} 