//var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Grupos.php';
var url_service = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(function(){

	var id_usuario=$("#id_usuario").val();
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
			}
		}); 
	} 
	$("#SL_organizacion").html(parent.getOptionsOrganizacionesRol(id_usuario));

	$("#BT_cargar_datos").click(function(){
		
		var organizacion = "";
		$('#SL_organizacion :selected').each(function(i, selected){ 
			if(organizacion=="")
				organizacion = $(selected).val();	
			else
				organizacion += ","+$(selected).val();
		});		
		$("#modal_enviando").modal("show");
		var anio=$('#SL_Ano').val();
		cargarHorasArtistas(organizacion,anio);

		
	});

	
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	} );	



});

function cargarHorasArtistas(organizacion,anio){
	$("#table_horas_artista > tbody").html("");	
	var datos = {
		'funcion': 'getHorasArtistaMes',
		'p1': organizacion,
		'p2': anio
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			if ( $.fn.dataTable.isDataTable( '#table_horas_artista' ) )
			    $("#table_horas_artista").DataTable().destroy();  	
		
			$("#table_horas_artista > tbody").html(data); 
			if ( $.fn.dataTable.isDataTable( '#table_horas_artista' ) ) {
			    table_horas_artista = $("#table_horas_artista").DataTable();  			
			}
			else {
				table_horas_artista = $("#table_horas_artista").DataTable({
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

						title: 'Reporte Completo AF-'+new Date().toLocaleString().replace(/\//g,'-').replace(/:/g,'-') 
					}
					],
				});
			}					 
			table_horas_artista.draw();

			$("#modal_enviando").modal("hide");
		},
		async: true
	});
	
}


