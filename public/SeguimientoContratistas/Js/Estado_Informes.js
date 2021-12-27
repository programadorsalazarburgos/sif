
$(document).ready(function () {
	var url_controller = '../../src/SeguimientoContratistas/InformePagoController/';


	$("#SL_Mes_Informe").html(consultarMesesInformes()).selectpicker('refresh');

	function consultarMesesInformes() {
		var r = "<option>Sin datos</option>";
		$.ajax({
			url: url_controller + "consultarMesesInformes",
			type: 'POST',
			dataType: 'html',
			async: false,
			success: function (result) {
				console.log(result);
				r = result;
			}, error: function (result) {
				console.error("Error: " + result);
			}
		});
		return r;
	}


	/*$('#btn-consultar').on('click', function (e) {
		e.preventDefault();
		refreshListado();
	});*/



	/*function refreshListado() {
		parent.mostrarCargando();
		let datosGetAjax = {
			p1: {
				"fechaFin": $('#fecha-periodo').val(),
				"nIdentificacion": "",
				"estado": "",
				"tipo": ["3"],
				"estadoLista": $('#select-estado-lista').val(),
				"estadoListaDoc": $('#select-estado-lista-doc').val(),
				"historico": $('#input-historico').is(":checked"),
			},
			p2: 'consulta_informe_pago'
		};
		tableListado.clear().draw();
		$.ajax({
			url: url_controller + "getListadoInformes",
			type: 'POST',
			dataType: 'html',
			data: datosGetAjax,
			async: true,
			success: function (result) {
				tableListado.rows.add($(result)).draw();
				$('[data-toggle="tooltip"]').tooltip();
				parent.cerrarCargando();
			}, error: function (result) {
				console.error("Error: " + result);
			}
		});
	} */

	var table_reporte_evento = $("#table-trazabilidad-informe").DataTable({
		pageLength: 50,
		lengthChange: false,
		responsive: true,
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excel',
			text: 'Descargar datos',
			filename: 'Datos'
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
				"last": "Última",
				"next": "Siguiente",
				"previous": "Anterior"
			},
		}
	  });

	$("#BT_Trazabilidad_Informe").click(function(){
		//$("#div-reporte-evento").show();
		getTrazabilidadInforme();
	  });
	  
	  /////////////////////////////////////
	  
	  function getTrazabilidadInforme() {
		parent.mostrarCargando();
		table_reporte_evento.clear().draw();
		var datos = {
		  'p1': $("#TX_Numero_Contrato").val(),
		  'p2': $("#SL_Mes_Informe").val()
		};
		$.ajax({
		  url: url_controller + "getTrazabilidadInforme",
		  type: 'POST',
		  data: datos,
		  success: function(data) {
			table_reporte_evento.rows.add($(data)).draw();
			parent.cerrarCargando();
		  },
		  async: true
		})
	  }








});

