var url_ter = '../../../src/Territorial/Controlador/AsignarPersonaTerritorioController.php';
var url_sis = '../../../src/PedagogicoNidos/SistematizacionController/';
ids_territorios = "";
ids_duplas = "";
ids_campos = "";
ids_meses = "";
ids = "";
$(document).ready(function() {

	$('a[href="#div-descarga-sistematizacion"]').click(function() {
		$("#SL_Territorio_Des").html(consultarTerritorios()).selectpicker("refresh");
		$("#SL_Dupla_Des").html(getOptionsDuplas()).selectpicker("refresh");
		$("#SL_Mes_Des").html(parent.getOptionsMes()).selectpicker("refresh");
	});

	$("#SL_Territorio").html(consultarTerritorios()).selectpicker("refresh");
	$("#SL_Mes").html(parent.getOptionsMes()).selectpicker("refresh");
	$("#SL_Dupla").html(getOptionsDuplas()).selectpicker("refresh");
	$("#SL_Campo").html(getOptionsCampos()).selectpicker("refresh");

	$("#SL_Territorio").change(function() {
		concatenarIds("#SL_Territorio");
		$("#SL_Dupla").html(getOptionsDuplas(ids)).selectpicker("refresh");
	});

	$("#SL_Territorio_Des").change(function() {
		concatenarIds("#SL_Territorio_Des");
		$("#SL_Dupla_Des").html(getOptionsDuplas(ids)).selectpicker("refresh");
	});

	function concatenarIds(input){
		ids="";
		$(input+" :selected").each(function(i, selected) {
			if (ids == "") {
				if(input == "#SL_Campo"){
					switch ($(selected).val()) {
						case 'TX_Ninos_Ins':
						ids = $(selected).val()+" AS 'Hallazgos entorno institucional: Niños/niñas'";
						break;
						case 'TX_Agentes_Ins':
						ids = $(selected).val()+" AS 'Hallazgos entorno institucional: Agentes educativos'";
						break;
						case 'TX_Ninos_Fam':
						ids = $(selected).val()+" AS 'Hallazgos entorno familiar: Niños/niñas'";
						break;
						case 'TX_Agentes_Fam':
						ids = $(selected).val()+" AS 'Hallazgos entorno familiar: Agentes educativos'";
						break;
						case 'TX_Familias_Fam':
						ids = $(selected).val()+" AS 'Hallazgos entorno familiar: Familias'";
						break;
						case 'TX_Mujeres_Fam':
						ids = $(selected).val()+" AS 'Hallazgos entorno familiar: Mujeres gestantes'";
						break;
						case 'TX_Ninos_Com':
						ids = $(selected).val()+" AS 'Hallazgos comunidad: Niños/niñas'";
						break;
						case 'TX_Familias_Com':
						ids = $(selected).val()+" AS 'Hallazgos comunidad: Familias'";
						break;
						case 'TX_Aprendizajes_Creacion':
						ids = $(selected).val()+" AS 'Reflexiones de los artistas: Desde la creación'";
						break;
						case 'TX_Aprendizajes_Personales':
						ids = $(selected).val()+" AS 'Reflexiones de los artistas: Aprendizajes personales'";
						break;
						case 'TX_Otros_Aspectos':
						ids = $(selected).val()+" AS 'Reflexiones de los artistas: Otros aspectos'";
						break;
						default:
						ids = $(selected).val()+" AS '"+$(selected).val().substring(3).replace("_", " ")+"'";
					}
				}else{
					ids = $(selected).val();
				}
			}else{
				if(input == "#SL_Campo"){
					switch ($(selected).val()) {
						case 'TX_Ninos_Ins':
						ids += "," + $(selected).val()+" AS 'Hallazgos entorno institucional: Niños/niñas'";
						break;
						case 'TX_Agentes_Ins':
						ids += "," + $(selected).val()+" AS 'Hallazgos entorno institucional: Agentes educativos'";
						break;
						case 'TX_Ninos_Fam':
						ids += "," + $(selected).val()+" AS 'Hallazgos entorno familiar: Niños/niñas'";
						break;
						case 'TX_Agentes_Fam':
						ids += "," + $(selected).val()+" AS 'Hallazgos entorno familiar: Agentes educativos'";
						break;
						case 'TX_Familias_Fam':
						ids += "," + $(selected).val()+" AS 'Hallazgos entorno familiar: Familias'";
						break;
						case 'TX_Mujeres_Fam':
						ids += "," + $(selected).val()+" AS 'Hallazgos entorno familiar: Mujeres gestantes'";
						break;
						case 'TX_Ninos_Com':
						ids += "," + $(selected).val()+" AS 'Hallazgos comunidad: Niños/niñas'";
						break;
						case 'TX_Familias_Com':
						ids += "," + $(selected).val()+" AS 'Hallazgos comunidad: Familias'";
						break;
						case 'TX_Aprendizajes_Creacion':
						ids += "," + $(selected).val()+" AS 'Reflexiones de los artistas: Desde la creación'";
						break;
						case 'TX_Aprendizajes_Personales':
						ids += "," + $(selected).val()+" AS 'Reflexiones de los artistas: Aprendizajes personales'";
						break;
						case 'TX_Otros_Aspectos':
						ids += "," + $(selected).val()+" AS 'Reflexiones de los artistas: Otros aspectos'";
						break;
						default:
						ids += "," + $(selected).val()+" AS '"+$(selected).val().substring(3).replace("_", " ")+"'";
					}
				}else{
					ids += "," + $(selected).val();
				}
			}
		});
		return ids;
	}

	/*-----------------Función para obtener todos los territorios-----------------------*/
	function consultarTerritorios() {
		var mostrar = "";
		var datos = {
			funcion: 'getOptionsTerritorios'
		};
		$.ajax({
			url: url_ter,
			type: 'POST',
			data: datos,
			success: function(data) {
				mostrar += data
			},
			async: false
		});
		return mostrar;
	}

	function getOptionsDuplas(ids_territorios=0){
		var mostrar = "";
		var datos = {
			'p1': ids_territorios
		};
		$.ajax({
			url: url_sis+"getOptionsDuplas",
			type: 'POST',
			data: datos,
			success: function(data) {
				mostrar += data
			},
			async: false
		});
		return mostrar;

	}

	function getOptionsCampos(){
		var mostrar = "";
		var datos = {
		};
		$.ajax({
			url: url_sis+"getOptionsCampos",
			type: 'POST',
			data: datos,
			success: function(data) {
				mostrar += data
			},
			async: false
		});
		return mostrar;
	}

	function getInformacionSistematizacion(ids_territorios, ids_duplas, ids_campos,ids_meses){
		parent.mostrarCargando();
		var datos = {
			p1: ids_territorios,
			p2: ids_duplas,
			p3: ids_campos,
			p4: ids_meses,
		};
		$.ajax({
			url: url_sis+"getInformacionSistematizacion",
			type: 'POST',
			data: datos,
			success: function(data) {
				$("#div-info-sistematizacion").html(data);
				
				$("#tabla-info-sistematizacion").DataTable({
					autoWidth: false,
					responsive: true,
					pageLength: 100,
					dom: 'Blfrtip',
					buttons: [{
						extend: 'excel',
						text: 'Descargar datos',
						filename: 'Datos sistematización'
					}],
					"language": {
						"lengthMenu": "Ver _MENU_ registros por página",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando página _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtrado de un total de _MAX_ registros)",
						"search": "Filtrar",
						"paginate": {
							"first": "Primera",
							"last": "Ultima",
							"next": "Siguiente",
							"previous": "Anterior"
						},
					}
				});
				parent.cerrarCargando();
			},
			async: true
		});
	}

	function getSistematizaciones(ids_territorios, ids_duplas, ids_meses){
		var datos = {
			p1: ids_territorios,
			p2: ids_duplas,
			p3: ids_meses,
		};
		$.ajax({
			url: url_sis+"getSistematizaciones",
			type: 'POST',
			data: datos,
			success: function(data) {
				$("#div-info-descarga").html(data);

				$("#tabla-descarga-sistematizacion").DataTable({
					autoWidth: false,
					responsive: true,
					pageLength: 100,
					"language": {
						"lengthMenu": "Ver _MENU_ registros por página",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando página _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtrado de un total de _MAX_ registros)",
						"search": "Filtrar",
						"paginate": {
							"first": "Primera",
							"last": "Ultima",
							"next": "Siguiente",
							"previous": "Anterior"
						},
					}
				});
			},
			async: false
		});

	}

	$("#BTN_Consultar_Info").click(function(){
		ids_territorios = concatenarIds("#SL_Territorio");
		ids_duplas = concatenarIds("#SL_Dupla");
		ids_campos = concatenarIds("#SL_Campo");
		ids_meses = concatenarIds("#SL_Mes");
		if(ids_campos == ""){
			parent.swal("Advertencia", "Debe seleccionar por lo menos una opción del listado de campos", "warning");
		}else{
			getInformacionSistematizacion(ids_territorios, ids_duplas, ids_campos, ids_meses);
		}
	});

	$("#BTN_Consultar_Sis").click(function(){
		ids_territorios = concatenarIds("#SL_Territorio_Des");
		ids_duplas = concatenarIds("#SL_Dupla_Des");
		ids_meses = concatenarIds("#SL_Mes_Des");
		if(ids_territorios == "" && ids_duplas == "" && ids_meses == ""){
			parent.swal("Advertencia", "Debe seleccionar por lo menos una opción de los filtros", "warning");
		}else{
			getSistematizaciones(ids_territorios, ids_duplas, ids_meses);
		}
	});

	$("body").on("click", "#tabla-descarga-sistematizacion button", function(){
		if($(this).hasClass('images')){
			var c_dupla = $($(this).closest("tr").children()[0]).text();
			var title_banco = "Banco de imágenes - Dupla "+c_dupla.substring(0, c_dupla.indexOf(" "))+" - "+$($(this).closest("tr").children()[1]).text();
			$(".modal-title").html("").html(title_banco);
			getCarouselImages($(this).attr("data-sistematizacion"));
		}else{
			if($(this).attr("data-total") == 2){
				$(this).closest("tbody").find("#div-info-artistas").html("").html("<div id='div-artistas-oculto'>"+
					"<div class='img-artista' id='img-artista-1'></div>"+
					"<div class='img-artista' id='img-artista-2'></div>"+
					"</div>");
			}
			if($(this).attr("data-total") == 3){
				$(this).closest("tbody").find("#div-info-artistas").html("").html("<div id='div-artistas-oculto'>"+
					"<div class='img-artista' id='img-artista-1' style='width: 150px; height: 150px;'></div>"+
					"<div class='img-artista' id='img-artista-2' style='width: 150px; height: 150px;'></div>"+
					"<div class='img-artista' id='img-artista-3' style='width: 150px; height: 150px;'></div>"+
					"</div>");
			}
			if($(this).attr("data-total") == 4){
				$(this).closest("tbody").find("#div-info-artistas").html("").html("<div id='div-artistas-oculto'>"+
					"<div class='img-artista' id='img-artista-1' style='width: 110px; height: 110px;'></div>"+
					"<div class='img-artista' id='img-artista-2' style='width: 110px; height: 110px;'></div>"+
					"<div class='img-artista' id='img-artista-3' style='width: 110px; height: 110px;'></div>"+
					"<div class='img-artista' id='img-artista-4' style='width: 110px; height: 110px;'></div>"+
					"</div>");
			}
			procesarPdfSistematizacion($(this).attr("data-sistematizacion"), $(this).attr("data-parte"));
		}
	});
});