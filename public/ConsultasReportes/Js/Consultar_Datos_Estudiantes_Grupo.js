var url_ok_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
var nombre_grupo_actual = "Datos Estudiantes Grupo";
$(function(){

	var table_estudiante = $("#table_estudiante").DataTable({
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

			title: nombre_grupo_actual
		}
		]
	});
	
	$("#SL_grupo").change(function(){
		$("#SL_area").trigger('change');
	});

	$("#SL_area").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh').change(function(){
		if (($("#SL_grupo").val() != null) && ($(this).val() != null)){
			table_estudiante.clear().draw();
			var datos = {
				funcion : 'consultarDatosEstudiantesGrupo',
				p1 : {
					'id_grupo' : $("#SL_grupo").val(),
					'id_area' : $(this).val()
				}
			};	
			$.ajax({
				url: url_ok_obj,
				type: 'POST',
				data: datos,
				async: false
			}).done(function(data){	
				table_estudiante.rows.add($(data)).draw();

			}).fail(function(result){
				parent.alertify.alert("Error","No se han podido cargar los datos detallados de los estudiantes");
				console.log("Error: "+result);
			});
			nombre_grupo_actual = ('Datos Estudiantes Grupo ' + $("#SL_grupo").find(':selected').data('tipo_grupo') + "-" + $("#SL_grupo").val());
		}
	}).trigger('change');
	$("#SL_crea").html(parent.getOptionsClanes()).selectpicker('refresh').change(function(){
		$("#SL_grupo").html(parent.getOptionGruposDeUnCrea($(this).val())).selectpicker('refresh');
	}).trigger('change');
});