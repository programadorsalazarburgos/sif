var url_ok_obj = '../../src/PedagogicoCREA/EvaluacionController/';
$(function(){

	// var table_resultado_evaluacion = $("#table_resultado_evaluacion").DataTable({
	// 	iDisplayLength: '10',
	// 	"language": {
	// 		"lengthMenu": "Ver _MENU_ registros por pagina",
	// 		"zeroRecords": "No hay información, lo sentimos.",
	// 		"info": "Mostrando pagina _PAGE_ de _PAGES_",
	// 		"infoEmpty": "No hay registros disponibles",
	// 		"infoFiltered": "(filtered from _MAX_ total records)",
	// 		"search": "Filtrar"
	// 	},
	// 	dom: 'Bfrtip'
	// });

	$("#SL_tipo_reporte").change(function(){
		var opcion = $(this).val();
		cargarTipoFiltro(opcion);
		$("#SL_tipo_evaluacion").selectpicker('refresh');
	});
	$("#SL_anio_reporte").change(function(){
		$("#SL_tipo_reporte").trigger("change");
	});
	$("#BT_ver_resultados_evaluaciones").click(function(){
		switch($("#SL_tipo_reporte").val()){
			case '1':
			getDataResultadoEvaluacionArtistaFormadorEvaluadoPorEstudiante('individual');
			break;
			case '2':
			getDataResultadoEvaluacionArtistaFormadorEvaluadoPorFuncionario('individual');
			break;
			case '4':
			getDataResultadoEvaluacionArtistaFormadorEvaluadoPorEstudiante('completo');
			break;
			case '5':
			getDataResultadoEvaluacionArtistaFormadorEvaluadoPorFuncionario('completo');
			break;
			default:
			console.log("Opcion no valida en tipo reporte");
			parent.mostrarAlerta("warning","Advertencia","Seleccione una opción valida para el reporte usando los seleccionables");
			break;
		}
	});

	function cargarTipoFiltro(opcion){
		var objeto_evaluado = "";
		switch(opcion){
			case '1':
			objeto_evaluado = getArtistasFormadoresEvaluadosPorEstudiante();
			break;
			case '2':
			objeto_evaluado = getArtistasFormadoresEvaluadosPorFuncionario();
			break;
			case '4':
			case '5':
			$("#SL_tipo_evaluacion").html("<option>Todos(as).</option>").selectpicker('refresh');
			break;
			default:
			$("#LB_tipo_evaluacion").html("<div class='alert alert-danger' role='alert'>Opción seleccionada no valida</div>");
			$("#SL_tipo_evaluacion").html("<option>Seleccione un tipo de reporte</option>").selectpicker('refresh');
			break;
		}
	}

	function getArtistasFormadoresEvaluadosPorFuncionario(){
		$("#LB_tipo_evaluacion").html("Artista formador Evaluado:");
		var datos = {
			'p1' : {
				'anio' : $("#SL_anio_reporte").val()
			}
		};
		$.ajax({
			url: url_ok_obj + 'getOptionsArtistasFormadoresEvaluadosPorFuncionario',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#SL_tipo_evaluacion").html(data).selectpicker('refresh');
		}).fail(function(data){
			console.log("Error: "+data);
		});
	}

	function getArtistasFormadoresEvaluadosPorEstudiante(){
		$("#LB_tipo_evaluacion").html("Artista Formador Evaluado:");
		var datos = {
			'p1' : {
				'anio' : $("#SL_anio_reporte").val()
			}
		};
		$.ajax({
			url: url_ok_obj + 'getOptionsArtistasFormadoresEvaluadosPorEstudiante',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#SL_tipo_evaluacion").html(data).selectpicker('refresh');
		}).fail(function(data){
			console.log("Error: "+data);
		});
	}

	function getDataResultadoEvaluacionArtistaFormadorEvaluadoPorEstudiante(opcion){
		if(opcion == 'individual'){
			var artista_formador = ($("#SL_tipo_evaluacion").val());
			var datos = {
				'p1' : {
					'id_artista_formador' : artista_formador,
					'anio' : $("#SL_anio_reporte").val()
				}
			};
		}else if(opcion == 'completo'){
			var datos = {
				'p1' : {
					'anio' : $("#SL_anio_reporte").val()
				}
			};
		}
		$.ajax({
			url:url_ok_obj + 'consultarResultadoEvaluacionEstudiantesArtistaFormador',
			type:'POST',
			data: datos
		}).done(function(data){
			$("#table_resultado_evaluacion").html(data);
			//table_resultado_evaluacion.clear().draw();
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido consultar los resultados de la evaluación.")
			console.log(data);
		});
	}

	function getDataResultadoEvaluacionArtistaFormadorEvaluadoPorFuncionario(opcion){
		if(opcion == 'individual'){
			var artista_formador = $("#SL_tipo_evaluacion").val();
			var datos = {
				'p1' : {
					'id_artista_formador' : artista_formador,
					'anio' : $("#SL_anio_reporte").val()
				}
			};
		}else if(opcion == 'completo'){
			var datos = {
				'p1' : {
					'anio' : $("#SL_anio_reporte").val()
				}
			};
		}
		$.ajax({
			url:url_ok_obj + 'consultarResultadoEvaluacionFuncionarioArtistaFormador',
			type:'POST',
			data: datos
		}).done(function(data){
			$("#table_resultado_evaluacion").html(data);
			//table_resultado_evaluacion.clear().draw();
		}).fail(function(data){
			parent.mostrarAlerta("error","Error","No se ha podido consultar los resultados de la evaluación.")
			console.log(data);
		});
		console.log(datos);
	}
});