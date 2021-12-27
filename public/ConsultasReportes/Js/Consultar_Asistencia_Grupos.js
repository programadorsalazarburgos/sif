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
	$("#SL_clan").html(parent.getOptionsClanes());

	$("#gruposArteEscuela").click(function(){
		var id_clan = "";
		$('#SL_clan :selected').each(function(i, selected){ 
			if(id_clan=="") id_clan = $(selected).val();
			else id_clan += ","+$(selected).val();
		});
		var anio = $("#SL_Ano").val();
		if (id_clan == "") {
			$("#grupos_arte_escuela").removeClass('active');
			alertify.alert('Por Favor', 'Seleccione al menos un crea y un año de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{ 
			cargarGruposArteEscuela(id_clan,anio);
		}
	});

	$("#gruposEmprendeClan").click(function(){
		var id_clan = "";
		$('#SL_clan :selected').each(function(i, selected){ 
			if(id_clan=="") id_clan = $(selected).val();
			else id_clan += ","+$(selected).val();
		});
		var anio = $("#SL_Ano").val();
		if (id_clan == "") {
			$("#grupos_emprende_clan").removeClass('active');
			alertify.alert('Por Favor', 'Seleccione al menos un crea y un año de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarGruposEmprendeClan(id_clan,anio);
		}
	});

	$("#gruposLaboratorioClan").click(function(){
		var id_clan = "";
		$('#SL_clan :selected').each(function(i, selected){ 
			if(id_clan=="") id_clan = $(selected).val();
			else id_clan += ","+$(selected).val();
		});
		var anio = $("#SL_Ano").val();
		if (id_clan == "") {
			$("#grupos_laboratorio_clan").removeClass('active');
			alertify.alert('Por Favor', 'Seleccione al menos un crea y un año de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarGruposLaboratorioClan(id_clan,anio);
		}
	});



	/*$("#table_grupos_arte_escuela").delegate(".consultar_listado_estudiantes_grupo_arte_escuela","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: AE-" + id_grupo);
		cargarEstudiantesGrupo('arte_escuela',id_grupo);
	});

	$("#table_grupos_emprende_clan").delegate(".consultar_listado_estudiantes_grupo_emprende_clan","click",function(){
		var id_grupo = $(this).data("id_grupo");
		$("#title_modal_estudiantes_grupo").text("Listado de estudiantes del grupo: EC-" + id_grupo);
		cargarEstudiantesGrupo('emprende_clan',id_grupo);
	});*/
	
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
		$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
	} );	



});

function cargarGruposArteEscuela(id_clan,anio){
	window.parent.$("#modal_enviando").modal("show");
	$("#table_grupos_arte_escuela > tbody").html("");	
	var datos = {
		'funcion': 'getAsistenciasMesAE',
		'p1': id_clan,
		'p2': anio 
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){    
			$("#div_table_grupos_arte_escuela").html(data);
		    $("#table_asistencia_grupo_ae").DataTable({
		        "pageLength": 100,
		        "language": {
		            "lengthMenu": "Ver _MENU_ registros por pagina",
		            "zeroRecords": "No hay información, lo sentimos.",
		            "info": "Mostrando pagina _PAGE_ de _PAGES_",
		            "infoEmpty": "No hay registros disponibles",
		            "infoFiltered": "(filtered from _MAX_ total records)",
		            "search": "Filtrar"
		        },
		        dom: 'Bfrtip',
		        buttons: [
		            {
		                extend: 'excel',
		                exportOptions: {
		                    columns: ':visible'
		            	},
		            	title: 'Asistencias Mensual Columnado Grupos - Arte en la Escuela'
		            }
		        ]
		    }).draw();
		    //$("#modal_enviando").modal('hide');  
			window.parent.$("#modal_enviando").modal("hide"); 
		},
		async: true
	});
	
}

function cargarGruposEmprendeClan(id_clan,anio){
	window.parent.$("#modal_enviando").modal("show");
	$("#table_grupos_emprende_clan > tbody").html("");
	var datos = {
		'funcion': 'getAsistenciasMesEC', 
		'p1': id_clan,
		'p2': anio 
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#div_table_grupos_emprende_clan").html(data);
		    $("#table_asistencia_grupo_ec").DataTable({
		        "pageLength": 100,
		        "language": {
		            "lengthMenu": "Ver _MENU_ registros por pagina",
		            "zeroRecords": "No hay información, lo sentimos.",
		            "info": "Mostrando pagina _PAGE_ de _PAGES_",
		            "infoEmpty": "No hay registros disponibles",
		            "infoFiltered": "(filtered from _MAX_ total records)",
		            "search": "Filtrar"
		        },
		        dom: 'Bfrtip',
		        buttons: [
		            {
		                extend: 'excel',
		                exportOptions: {
		                    columns: ':visible'
		            	},
		            	title: 'Asistencias Mensual Columnado Grupos - Emprende Crea'
		            }
		        ]
		    }).draw();
			window.parent.$("#modal_enviando").modal("hide");
		},
		async: true
	});

	
}  

function cargarGruposLaboratorioClan(id_clan,anio){
	window.parent.$("#modal_enviando").modal("show");
	$("#table_grupos_emprende_clan > tbody").html("");
	var datos = {
		'funcion': 'getAsistenciasMesLC', 
		'p1': id_clan,
		'p2': anio 
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#div_table_grupos_laboratorio_clan").html(data);
		    $("#table_asistencia_grupo_lc").DataTable({
		        "pageLength": 100,
		        "language": {
		            "lengthMenu": "Ver _MENU_ registros por pagina",
		            "zeroRecords": "No hay información, lo sentimos.",
		            "info": "Mostrando pagina _PAGE_ de _PAGES_",
		            "infoEmpty": "No hay registros disponibles",
		            "infoFiltered": "(filtered from _MAX_ total records)",
		            "search": "Filtrar"
		        },
		        dom: 'Bfrtip',
		        buttons: [
		            {
		                extend: 'excel',
		                exportOptions: {
		                    columns: ':visible'
		            	},
		            	title: 'Asistencias Mensual Columnado Grupos - Laboratorio Crea'
		            }
		        ]
		    }).draw();
			window.parent.$("#modal_enviando").modal("hide");   
		},
		async: true
	});

	
} 