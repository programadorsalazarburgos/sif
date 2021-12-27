var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Asistencia_Formador.php';
$(function(){

	if(!alertify.myAlert){
	  //define a new dialog
	  alertify.dialog('myAlert',function factory(){
	    return{
	      main:function(message){
	        this.message = message;
	      },
	      setup:function(){
	          return { 
	            buttons:[{text: "cool!", key:27/*Esc*/}],
	            focus: { element:0 }
	          };
	      },
	      prepare:function(){
	        this.setContent(this.message);
	      }
	  }});
	}

	inicializar();
	$("#SL_clan").change(getAllGruposClan).selectpicker('refresh');
	$("#SL_grupo").change(getMesesNovedadesGrupo);
	$("#SL_mes_anio").change(getTableNovedadesGrupo);
	getAllGruposClan();
});

function inicializar(){
	getClanes();
	getAllGruposClan();
	getMesesNovedadesGrupo();
}

function getClanes(){
	var mostrar = "";
	var datos = {
		'opcion': 'get_clan'
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		mostrar += data;
		$("#SL_clan").html(data);
	}).fail(function(jqXHR,textStatus){
		alertify.alert('Error','No se ha podido cargar los Clan.' + textStatus);
	});
	return mostrar;
}

function getAllGruposClan(){
	var mostrar = "";
	var datos = {
		'opcion': 'get_all_grupos_clan',
		'id_clan': $("#SL_clan").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		mostrar += data;
		$("#SL_grupo").html(data).selectpicker('refresh');
		getMesesNovedadesGrupo();
		getTableNovedadesGrupo();
	}).fail(function(jqXHR,textStatus){
		alertify.alert('Error','No se ha podido cargar los grupos.' + textStatus);
	});
	return mostrar;
}

function getMesesNovedadesGrupo(){
	var mostrar = "";
	var datos = {
		'opcion': 'get_meses_novedades_grupo',
		'id_grupo': $("#SL_grupo").val(),
		'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		mostrar += data;
		$("#SL_mes_anio").html(data).selectpicker('refresh');
		getTableNovedadesGrupo();
	}).fail(function(jqXHR,textStatus){
		alertify.alert('Error','No se ha podido cargar los meses que ha tenido novedades el grupo.' + textStatus);
	});
	return mostrar;
}

function getTableNovedadesGrupo(){
	var mostrar = "";
	var table_novedades = $("#table_novedades").DataTable();
	table_novedades.clear();
	var datos = {
		'opcion': 'get_table_novedades_grupo',
		'id_grupo': $("#SL_grupo").val(),
		'tipo_grupo' : $("#SL_grupo").find(':selected').data('tipo_grupo'),
		'mes_anio' : $("#SL_mes_anio").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		async: false
	}).done(function(data){
		mostrar += data;
		$("#table_novedades").html(data);
	}).fail(function(jqXHR,textStatus){
		alertify.alert('Error','No se ha podido cargar los meses que ha tenido novedades el grupo.' + textStatus);
	});
	table_novedades.destroy();
    $("#table_novedades").DataTable({
        responsive: true,
        iDisplayLength: '50',
        "language": {
            "lengthMenu": "Ver _MENU_ registros por pagina",
            "zeroRecords": "No hay información, lo sentimos.",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Filtrar"
        }
    });
    table_novedades.draw();
	return mostrar;
}