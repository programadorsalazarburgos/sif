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
	$("#SL_Year").html(parent.getOptionParametroDetalle(7));
	$("#SL_Mes").html(parent.getOptionParametroDetalle(8));
	
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	} );	

	$("#BT_CONSULTAR").on("click", function(){
		var anio = $("#SL_Year").val();
		var mes = $("#SL_Mes").val();
		if (anio == "" || mes == "") {
			parent.swal("","Debe seleccionar AÑO y MES.","warning");
		}else{
			cargarGruposLaboratorioClan(anio, mes);
		}
	});
});

function cargarGruposLaboratorioClan(anio, mes){
	window.parent.$("#modal_enviando").modal("show");
	$("#table_grupos_laboratorio_clan > tbody").html("");
	var datos = {
		'funcion': 'getAsistenciasMesConvenio_0810_2019',
		p1: mes,
		p2: anio
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#div_table_grupos_laboratorio_clan").html(data);
			var tabla = $("#table_asistencia").DataTable({
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
					title: 'Asistencias Mensual por Grupos - Laboratorio Crea (Convenio de Seguridad)'
				},
				]
			}).draw();
			window.parent.$("#modal_enviando").modal("hide"); 
		},
		async: true
	});
} 