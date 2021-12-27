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

	cargarMeses();
	$("#SL_Ano").change(cargarMeses); 
	$("#SL_clan").html(parent.getOptionsClanes());
	$("#gruposArteEscuela").click(function(e){
		var id_clan=obtenerListaCrea();
		var anio = $("#SL_Ano").val();
		var mes = $("#SL_mes").val();
		if (id_clan == "") {
			alertify.alert('Por Favor', 'Seleccione al menos un Crea de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarNovedadesArteEscuela(id_clan,anio,mes);
		}
	});

	$("#gruposEmprendeClan").click(function(e){ 
		var id_clan=obtenerListaCrea();
		var anio = $("#SL_Ano").val();
		var mes = $("#SL_mes").val();
		if (id_clan == "") {
			alertify.alert('Por Favor', 'Seleccione al menos un Crea de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{			
			cargarNovedadesEmprendeClan(id_clan,anio,mes);
		}
	});

	$("#gruposLaboratorioClan").click(function(e){
		var id_clan=obtenerListaCrea();
		var anio = $("#SL_Ano").val();  
		var mes = $("#SL_mes").val();
		if (id_clan == "") {
			alertify.alert('Por Favor', 'Seleccione al menos un Crea de la lista desplegable!', function(){ $('.selectpicker').selectpicker('toggle'); });
		}else{
			cargarNovedadesLaboratorioClan(id_clan,anio,mes);
		}
	});

	function obtenerListaCrea(){
		var id_clan = "";
		$('#SL_clan :selected').each(function(i, selected){ 
			if(id_clan=="")
				id_clan = $(selected).val();	
			else
				id_clan += ","+$(selected).val();
		});
		return id_clan;		
	}

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

function cargarNovedadesArteEscuela(id_clan,anio,mes){
	window.parent.$("#modal_enviando").modal("show");
	$("#table_grupos_arte_escuela > tbody").html("");	
	var datos = {
		'funcion': 'getNovedadesAFAE',
		'p1': id_clan,
		'p2':anio,
		'p3':mes
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			if ( $.fn.dataTable.isDataTable( '#table_grupos_arte_escuela' ) )
			    $("#table_grupos_arte_escuela").DataTable().destroy();  	
		
			$("#table_grupos_arte_escuela > tbody").html(data); 
			if ( $.fn.dataTable.isDataTable( '#table_grupos_arte_escuela' ) ) {
			    table_grupos_arte_escuela = $("#table_grupos_arte_escuela").DataTable();  			
			}
			else {
				table_grupos_arte_escuela = $("#table_grupos_arte_escuela").DataTable({
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
						title: 'Asistencias Mensual Columnado Grupos - Arte en la Escuela' 
					},
					{
						extend: 'pdfHtml5',
						text: 'PDF',
						title: 'Asistencias Mensual Columnado Grupos - Arte en la Escuela',
						orientation: 'landscape',
						pageSize: 'LEGAL'
					}
					],
				});
			}					 
			table_grupos_arte_escuela.draw();			
			window.parent.$("#modal_enviando").modal("hide"); 
		},
		async: true
	});
	
}

function cargarNovedadesEmprendeClan(id_clan,anio,mes){
	window.parent.$("#modal_enviando").modal("show");
	$("#table_grupos_emprende_clan > tbody").html("");
	var datos = {
		'funcion': 'getNovedadesAFEC', 
		'p1': id_clan,
		'p2':anio,
		'p3':mes
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			if ( $.fn.dataTable.isDataTable( '#table_grupos_emprende_clan' ) )
			    $("#table_grupos_emprende_clan").DataTable().destroy();  	
		
			$("#table_grupos_emprende_clan > tbody").html(data); 
			if ( $.fn.dataTable.isDataTable( '#table_grupos_emprende_clan' ) ) {
			    table_grupos_emprende_clan = $("#table_grupos_emprende_clan").DataTable();  			
			}
			else {
				table_grupos_emprende_clan = $("#table_grupos_emprende_clan").DataTable({
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
						title: 'Asistencias Mensual Columnado Grupos - Impulso Crea'
					},
					{
						extend: 'pdfHtml5',
						text: 'PDF',
						title: 'Asistencias Mensual Columnado Grupos - Impulso Crea',
						orientation: 'landscape',
						pageSize: 'LEGAL'
					}
					],
				});
			}					 
			table_grupos_emprende_clan.draw();
			window.parent.$("#modal_enviando").modal("hide"); 
		},
		async: true
	});

	
}


function cargarNovedadesLaboratorioClan(id_clan,anio,mes){
	window.parent.$("#modal_enviando").modal("show");
	$("#table_grupos_laboratorio_clan > tbody").html("");
	var datos = {
		'funcion': 'getNovedadesAFLC', 
		'p1': id_clan,
		'p2':anio,
		'p3':mes
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			if ( $.fn.dataTable.isDataTable( '#table_grupos_laboratorio_clan' ) )
			    $("#table_grupos_laboratorio_clan").DataTable().destroy();  	
		
			$("#table_grupos_laboratorio_clan > tbody").html(data); 
			if ( $.fn.dataTable.isDataTable( '#table_grupos_laboratorio_clan' ) ) {
			    table_grupos_laboratorio_clan = $("#table_grupos_laboratorio_clan").DataTable();  			
			}
			else {
				table_grupos_laboratorio_clan = $("#table_grupos_laboratorio_clan").DataTable({
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
						title: 'Asistencias Mensual Columnado Grupos - Converge Crea'
					},
					{
						extend: 'pdfHtml5',
						text: 'PDF',
						title: 'Asistencias Mensual Columnado Grupos - Converge Crea',
						orientation: 'landscape',
						pageSize: 'LEGAL'
					}
					],
				});
			}					 
			table_grupos_laboratorio_clan.draw();
			window.parent.$("#modal_enviando").modal("hide"); 
		},
		async: true 
	});	
}

function cargarMeses(){
	var hoy = new Date();
	var options="";
	var anio =  $("#SL_Ano").val();   
	var mes = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
	if(anio < hoy.getFullYear()){
		for(i=0;i<=11;i++)
			 options+="<option value='"+(i+1)+"'>"+mes[i]+"</option>";
	}
	else{
		for(i=0;i<=hoy.getMonth();i++)
			 options+="<option value='"+(i+1)+"'>"+mes[i]+"</option>";			
	}
	$("#SL_mes").html(options).selectpicker('refresh');
	
}


/*function cargarEstudiantesGrupo(tipo_grupo,id_grupo){
	var table_listado_estudiantes_grupo = $("#table_listado_estudiantes_grupo").DataTable();
	table_listado_estudiantes_grupo.clear();
	var pre_grupo = '';
	if(tipo_grupo == 'arte_escuela'){
		var datos = {
			'opcion': 'get_estudiantes_grupo_arte_escuela',
			'id_grupo': id_grupo
		};
		pre_grupo = 'AE';
	}else if(tipo_grupo == 'emprende_clan'){
		var datos = {
			'opcion': 'get_estudiantes_grupo_emprende_clan',
			'id_grupo': id_grupo
		};
		pre_grupo = 'EC';
	}
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#table_listado_estudiantes_grupo").html(data);
		},
		async: false
	});

	table_listado_estudiantes_grupo.destroy();
	$("#table_listado_estudiantes_grupo").DataTable({
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

			title: 'Listado estudiantes grupo '+ pre_grupo +'-' + id_grupo
		}
		]
	});
	table_listado_estudiantes_grupo.draw();
}*/
