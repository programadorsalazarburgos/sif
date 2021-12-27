var url_obj_planeacion = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
var table_historico_planeacion = "";
var session = "";
$(document).ready(function(){
	var date = new Date();
	var month = date.getMonth();
	var year = date.getFullYear();
	meses = parent.getParametroDetalle(8);
	$("#SL_MES_INICIAL, #SL_MES_FINAL").html("").selectpicker("refresh");
	$.each(meses, function (i) {
		$('#SL_MES_INICIAL, #SL_MES_FINAL').append($('<option>', {
			value : meses[i].FK_Value,
			text : meses[i].VC_Descripcion
		}));
	});
	$("#SL_MES_INICIAL, #SL_MES_FINAL").selectpicker("refresh");
	$("#SL_MES_INICIAL").val(1).selectpicker("refresh");
	$("#SL_MES_FINAL").val(month).selectpicker("refresh");
	// $("#SL_MES_INICIAL").attr("disabled", "disabled");
	years = parent.getParametroDetalle(7);
	$("#SL_YEAR").html("").selectpicker("refresh");
	$.each(years, function (i) {
		$('#SL_YEAR').append($('<option>', {
			value : years[i].FK_Value,
			text : years[i].VC_Descripcion
		}));
	});
	$("#SL_YEAR").selectpicker("refresh");
	$("#SL_YEAR").val(year).selectpicker("refresh");
	//$("#SL_YEAR").attr("disabled", "disabled");

	table_historico_planeacion = $('#table_historico_planeacion').DataTable({
		"processing": true,
		"bDeferRender": true,
        //"sAjaxSource": "../../Controlador/Infraestructura/Inventario/file.json",
        "responsive": true,
        "paging":   true,
        "ordering": true,
        "info":     false,
        "order": [3, 'desc'],
        "language": {
        	"lengthMenu": "Ver _MENU_ registros por pagina",
        	"zeroRecords": "No hay información para ser mostrada, Realice una consulta.",
        	"info": "Mostrando pagina _PAGE_ de _PAGES_",
        	"infoEmpty": "No hay registros disponibles",
        	"infoFiltered": "(filtered from _MAX_ total records)",
        	"search": "Filtrar"
        },
        "columnDefs": [{
        	"targets": "_all",
        	"className": "text-center",
        }],
        dom: 'Bfrtip',
        buttons: [
        {
        	text: 'Copiar',
        	extend: 'copyHtml5',
        	exportOptions: {
        		columns: ':visible'
        	},
        	title: 'Reporte de Planeación'
        },
        {
        	text: 'Mostrar/Ocultar',
        	extend: 'colvis'
        }
        ]
    });

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php',
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
		},
		async : false
	});

	$("#SL_DIA_INICIAL").html('');
	$("#SL_DIA_FINAL").html('');
	for(var dia=1; dia <=31; dia++){
		$("#SL_DIA_INICIAL").append("<option value="+dia+">"+dia+"</option>");
		$("#SL_DIA_FINAL").append("<option value="+dia+">"+dia+"</option>");
	}

	$("#DOWNLOAD_PLANEACION").on("click", function(e){
		e.preventDefault();
		var anio = $("#SL_YEAR").val();
		var mes_inicial = $("#SL_MES_INICIAL").val();
		var dia_inicial = $("#SL_DIA_INICIAL").val();
		var mes_final = $("#SL_MES_FINAL").val();
		var dia_final = $("#SL_DIA_FINAL").val();
		var asistencias = $("#SL_ASISTENCIAS").val();
		var linea_atencion = $("#SL_LINEA_ATENCION").val();
		var mensaje = "";
		var funcion ="";
		if(linea_atencion == "AE"){
			funcion = "getPlaneacionArteEnLaEscuela";
		}
		if(linea_atencion == "IC"){
			funcion = "getPlaneacionEmprendeCrea";
		}
		if(linea_atencion == "CV"){
			funcion = "getPlaneacionLaboratorioCrea";
		}
		if(mes_final==month+1 && anio == new Date().getFullYear()){
			mensaje = linea_atencion+'?<br>Tenga en cuenta que está intentando descargar un reporte de un mes que no ha finalizado.';
		}
		else{
			mensaje = linea_atencion+'?';
		}
		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'CONFIRMAR ACCIÓN',
			html: '<small>Desea realizar la consulta de planeación para <br><strong>'+mensaje+'</strong></small>',
			type: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			confirmButtonText: 'SI',
			cancelButtonText: 'NO',
			showCancelButton: true,
		}).then(() => {
			$("#modal_enviando").modal("show");
			datos = {
				'funcion': funcion,
				'p1': anio,
				'p2': mes_inicial+'-'+dia_inicial,
				'p3': mes_final+'-'+dia_final,
				'p4': asistencias,
				'p5': session
			};
			$.ajax({
				async : true,
				url: url_obj_planeacion,
				type: 'POST',
				dataType: 'html',
				data: datos,
				beforeSend:function(){
					$("#modal_enviando").modal("show");
				},
				complete:function(){
					$("#modal_enviando").modal("hide");
				},
				success: function(result)
				{
					$('#download_file').attr("href", '../../uploadedFiles/ConsultasReportes/ReportesPlaneacion/'+anio+'/'+result);
					document.getElementById('download_file').click();
					if(linea_atencion == "AE"){
						parent.swal("","El Reporte de planeación Arte en la Escuela ha sido generado.","");	
					}
					if(linea_atencion == "IC"){
						parent.swal("","El Reporte de planeación Impulso Colectivo ha sido generado.","");	
					}
					if(linea_atencion == "CV"){
						parent.swal("","El Reporte de planeación Converge ha sido generado.","");
					}
				}
			});
		},() => {}).catch(parent.swal.noop);
	});

	$("body").delegate( ".eliminar", "click", function() {
		var año= $(this).attr("data-anio");
		var mes= $(this).attr("data-mes");
		var linea_atencion= $(this).attr("data-linea_atencion");
		var id_registro = $(this).attr("data-id_registro");
		var url = $(this).attr("data-url");
		parent.swal({
			confirmButtonColor: '#3f9a9d',
			title: 'CONFIRMAR ACCIÓN',
			html: 'Desea eliminar este informe de Planeación de '+linea_atencion+' de '+mes+' del '+año+'?',
			type: 'warning',
			allowOutsideClick: false,
			allowEscapeKey: false,
			confirmButtonText: 'SI',
			cancelButtonText: 'NO',
			showCancelButton: true,
		}).then(() => {
			$("#modal_enviando").modal("show");
			datos = {
				'funcion': 'eliminarReportePlaneacion',
				'p1': id_registro,
				'p2': url,
				'p3': session
			};
			$.ajax({
				async : true,
				url: url_obj_planeacion,
				type: 'POST',
				dataType: 'html',
				data: datos,
				beforeSend:function(){
					$("#modal_enviando").modal("show");
				},
				complete:function(){
					$("#modal_enviando").modal("hide");
				},
				success: function(result)
				{
					if(result == 1){
						parent.swal("","El Reporte de planeación de "+linea_atencion+" ha sido eliminado.","success");
						$("#li_historico_planeacion").click();
					}
					else{
						parent.swal("","El Reporte de planeación de "+linea_atencion+" no pudo ser eliminado.","error");
					}
				}
			});
		},() => {}).catch(parent.swal.noop);
	});

	$("#li_historico_planeacion").on('click', function(){
		var datos = {
			'funcion': 'getHistoricoPlaneacion'
		};
		table_historico_planeacion.clear().draw();
		$.ajax({
			url: url_obj_planeacion,
			data: datos,
			type: 'POST',
			success: function (info) {
				table_historico_planeacion.clear().draw();
				table_historico_planeacion.rows.add($(info)).draw();
			},
			async : false
		});
	});
});