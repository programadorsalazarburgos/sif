var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Asistencia_Colegio.php';
var url_service_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(document).ajaxStart(function() { Pace.restart(); });
$(document).ready(function(){ 
	$("#SL_clan").html(parent.getOptionsClanes()).change(cargarColegiosCrea);
	$("#SL_clan").trigger('change'); 
	$("#SL_colegio").change(cargarMesesSesionesClaseColegio);
	$("#SL_Ano").change(cargarMesesSesionesClaseColegio);  
	//cargarMesesSesionesClaseColegio();

	$("#BT_consultar_asistencias").on('click',function(e){
		e.preventDefault();
		var consulta=true;

		if(($("#SL_mes").val()>$("#SL_mesh").val())){

			parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese las fechas de manera correcta");     
			consulta=false; 

		}

		if($("#SL_area").val()==null){
			parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese el(las) área(s) Artística(s)");     
			consulta=false;			

		}		
		if($("#SL_colegio").val()==null){
			parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese el(los) colegio(s)");     
			consulta=false;			

		}		
		if(consulta)   
			consultarAsistenciasMesPorArea(); 

		//setTimeout(function(){consultarAsistenciasMesPorArea()}, 1000);
	});
}); 

function cargarColegiosCrea(){
	//console.log($(this).val());
	var id_clan = "";
	$('#SL_clan :selected').each(function(i, selected){ 
		if(id_clan=="") id_clan = $(selected).val();
		else id_clan += ","+$(selected).val();
	});
	if(id_clan.indexOf(",")==-1){
		$("#SL_colegio").html(parent.getOptionsColegiosCrea(id_clan,0)).selectpicker('refresh');
	}
} 

function cargarMesesSesionesClaseColegio(){
	var colegios = $("#SL_colegio").val();
	//console.log(colegios);  
	if(colegios==null)
		return false;
	var anio =  $("#SL_Ano").val(); 
	var linea = $("#SL_linea").val();

	var id_clan = "";
	$('#SL_clan :selected').each(function(i, selected){ 
		if(id_clan=="") id_clan = $(selected).val();
		else id_clan += ","+$(selected).val();
	});

	if(colegios.length==1 && linea=='AE' && id_clan.indexOf(",")==-1 ){	   
		var datos = {
			funcion: 'getMesSesionesClaseColegio',
			p1: colegios[0],
			p2: anio  
		};
		$.ajax({
			url: url_service_obj,
			type: 'POST',
			data: datos,
			success: function(data){
				$("#SL_mes").html(data).selectpicker('refresh');
				$("#SL_mesh").html(data).selectpicker('refresh'); 
			},
			async: false
		});
	}   
	else{
		var hoy = new Date();
		var options="";
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
		$("#SL_mesh").html(options).selectpicker('refresh');  
	}
	//Áreas Artísticas por Colegio
	var id_colegios = "";
	$('#SL_colegio :selected').each(function(i, selected){ 
		if(id_colegios=="") id_colegios = $(selected).val();
		else id_colegios += ","+$(selected).val();
	}); 
	if(id_colegios=='0'){
		$("#SL_area").html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
	}
	else{
		$("#SL_area").html(parent.getOptionsAreasArtisticasPorColegio(id_colegios)).selectpicker('refresh');   
	}

}

function consultarAsistenciasMesPorArea(){
	
	//$("#table_asistencia thead").html(getEncabezadosSesionesClase());
 	parent.mostrarCargando();
	var id_colegios = "";
	$('#SL_colegio :selected').each(function(i, selected){ 
		if(id_colegios=="") id_colegios = $(selected).val();
		else id_colegios += ","+$(selected).val();
	}); 

	var id_areas = "";
	$('#SL_area :selected').each(function(i, selected){ 
		if(id_areas=="") id_areas = $(selected).val();
		else id_areas += ","+$(selected).val();
	});	
	var linea = $("#SL_linea").val();

	var id_clan = "";
	$('#SL_clan :selected').each(function(i, selected){ 
		if(id_clan=="") id_clan = $(selected).val();
		else id_clan += ","+$(selected).val();
	}); 

	var datos_area = {
	    funcion: 'consultarTotalMesPorArea', 
	    p1: {
	    	areas: id_areas, 
	    	mesini: $("#SL_mes").val(),
	    	mesfin: $("#SL_mesh").val(), 
	    	anio: $("#SL_Ano").val(),
	    	tipo_grupo: linea,
	    	clan: id_clan
	    }

	};

	var datos_atencion = {
	    funcion: 'consultarAsistenciasMesPorArea', 
	    p1: {
	    	areas: id_areas, 
	    	mesini: $("#SL_mes").val(),
	    	mesfin: $("#SL_mesh").val(), 
	    	anio: $("#SL_Ano").val(),
	    	tipo_grupo: linea,
	    	clan: id_clan
	    }

	};	
	if(linea=='arte_escuela' && id_clan.indexOf(",")==-1){
		datos_atencion.p1.colegio=id_colegios;
		datos_area.p1.colegio=id_colegios;
	}else{
		datos_atencion.p1.colegio="";
		datos_area.p1.colegio="";		
	}	

	$.ajax({ 
	url: url_service_obj, 
	type: 'POST', 
	data: datos_area,  
	success: function(data){ 
	  	$("#LB_Atendidos").html(data); 
	    $("#table_total_area").DataTable({
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
	        "order": [],
	        buttons: [
	            {
	                extend: 'excel',
	                exportOptions: {
	                    columns: ':visible'
	            	},
	            	title: 'Total Acumulado de Asistencias por Área - Colegio'
	            }
	        ]
	    }).draw(); 	  	
	},  
	async: false 
	});  
	if(id_clan.indexOf(",")==-1){
		$.ajax({
			url: url_service_obj, 
			type: 'POST',
			data: datos_atencion,
			success: function(data){			
				$("#BT_consultar_asistencias").removeAttr("disabled");		
				$("#div_table_asistencia").html(data);
			    $("#table_asistencia").DataTable({
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
			            	title: 'Asistencias clase Colegio - Área  del mes'
			            }
			        ]
			    }).draw();
			    parent.cerrarCargando();
			},
			error: function(result){ 
	      		console.error("Error: "+result);   
	    	}  
		});	
	}else{
		parent.cerrarCargando();
	}
}

function getEncabezadosSesionesClase(){
	var mostrar = "";
	var datos = {
		opcion: 'get_encabezados_sesiones_asistencia_clase_colegio_mes',
		id_colegio: $("#SL_colegio").val(),
		mes_anio : $("#SL_mes").val(),
		mes_anioh : $("#SL_mesh").val() 
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		beforeSend: function(){
			$("#BT_consultar_asistencias").prop('disabled', true);
		},
		success: function(data){
			mostrar = data;
		},
		async: false
	});
	return mostrar;
}