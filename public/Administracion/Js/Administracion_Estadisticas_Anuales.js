var url_administracion_controller = '../../src/ConsultasReportes/Controlador/AdministracionController.php';
var url_options_controller = '../../src/General/Controlador/OptionsController.php';

$(function(){
	idUsuario = $("#id_usuario").val();
	
	tabla_areas_artisticas = $('#tabla_areas_artisticas').DataTable({
		"processing": true,
		"bDeferRender": true,
        //"sAjaxSource": "../../Controlador/Infraestructura/Inventario/file.json",
        "responsive": true,
        "paging": false,
        "ordering": false,
        "info": false,
        "language": {
        	"lengthMenu": "Ver _MENU_ registros por pagina",
        	"zeroRecords": "No hay información para ser mostrada, Realice una consulta.",
        	"info": "Mostrando pagina _PAGE_ de _PAGES_",
        	"infoEmpty": "No hay registros disponibles",
        	"infoFiltered": "(filtered from _MAX_ total records)",
        	"search": "Filtrar"
        }
    });
	
	$.ajax({
			url: url_options_controller,
			type: 'POST',
			dataType: "JSON",
			data: {
				'funcion' : 'getAniosEstadisticas'
			},
			async: false
		}).done(function(data){
			$.each(data, function (i) {
					$('#SL_ANIO').append($('<option>', {
						value : data[i].PK_Anio,
						text : data[i].PK_Anio
					}));
				});
			$("#SL_ANIO").selectpicker("refresh");
		}).fail(function(result){
		      console.log("Error: "+result);
		});

	var areas_artisticas = parent.getParametroDetalle(6);
	var datos = [];
	tabla_areas_artisticas.clear().draw();
	$.each(areas_artisticas, function(i){
		datos.push([areas_artisticas[i].VC_Descripcion,"<input type='number' id='TX_AA_"+i+"' name='TX_AA_"+i+"' value='0' class='form-control cifra_area'>"]);
	});
	datos.push(["<b>TOTAL</b>","<label id='LB_TOTAL' name='LB_TOTAL'></label>"]);
	datos.push(["<b>DISPONIBLE</b>","<label id='LB_DISPONIBLE' name='LB_DISPONIBLE'>"]);
	tabla_areas_artisticas.rows.add(datos).draw();

	$(".cifra_area").on("change", function(){
		var suma_artistas = 0;
		cantidad_artistas = parseInt($("#TX_TOTAL_AF").val());

		$.each($(".cifra_area"), function(i){
			suma_artistas += parseInt($(this).val());
		});
		if (suma_artistas > cantidad_artistas) {
			alert("Ha excedido la cantidad de artistas, máximo "+cantidad_artistas);
		}
		$("#LB_TOTAL").html("<b>"+suma_artistas+"</b>");
		$("#LB_DISPONIBLE").html("<b>"+(cantidad_artistas-suma_artistas)+"</b>");
	});
});
