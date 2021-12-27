var url_service = '../../Controlador/ConsultasReportes/C_Consultar_Asistencia_Colegio.php';
var url_service_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(document).ajaxStart(function() { Pace.restart(); });
$(document).ready(function(){ 
	$("#SL_clan").html(parent.getOptionsClanes()).change(cargarColegiosCrea);
	//$("#SL_clan").trigger('change'); 
	$("#SL_colegio").on('change',function(){
		cargarMesesSesionesClaseColegio();
	});
	$("#SL_Ano").on('change',function(){
		//cargarMesesSesionesClaseColegio();
	});
	//cargarMesesSesionesClaseColegio();

	$("#BT_consultar_asistencias").on('click',function(e){
		e.preventDefault();
		if(parseInt($("#SL_mes").val())<=parseInt($("#SL_mesh").val()))
			consultarAsistenciasMes(); 
		else{
			parent.mostrarAlerta("error","Mensaje del sistema",'Mes Hasta no puede ser menor que Mes Desde');
		} 
		//setTimeout(function(){consultarAsistenciasMes()}, 1000);
	});
}); 

function cargarColegiosCrea(){
	//console.log($(this).val());
	$("#SL_colegio").html(parent.getOptionsColegiosCreaNew($(this).val().join(),$("#SL_Ano").val())).selectpicker('refresh');

} 

function cargarMesesSesionesClaseColegio(){
	var colegios = $("#SL_colegio").val().join();
	//console.log(colegios);
	if(colegios==null)
		return false;
	var anio =  $("#SL_Ano").val(); 
	if(colegios.length>0){	   
		var datos = {
			funcion: 'getMesSesionesClaseColegio',
			p1: colegios,
			p2: anio,
			p3: $("#SL_clan").val().join()
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
}

function consultarAsistenciasMes(){
	
	//$("#table_asistencia thead").html(getEncabezadosSesionesClase());
 	parent.mostrarCargando();
	var id_colegios = "";
	$('#SL_colegio :selected').each(function(i, selected){ 
		if(id_colegios=="") id_colegios = $(selected).val();
		else id_colegios += ","+$(selected).val();
	});
	
	var datos_atencion = {
	    funcion: 'getConsultaColegioMes', 
	    p1: id_colegios, 
	    p2: $("#SL_mes").val(), 
	    p3: $("#SL_mesh").val(), 
	    p4: $("#SL_Ano").val(),
	    p5: $("#SL_clan").val().join()
	};
	var datos = { 
	    funcion: 'getAtendidosMesColegio', 
	    p1: id_colegios, 
	    p2: $("#SL_mes").val(), 
	    p3: $("#SL_mesh").val(), 
	    p4: $("#SL_Ano").val(),
	    p5: $("#SL_clan").val().join() 
	}; 
	  $.ajax({ 
	    url: url_service_obj, 
	    type: 'POST', 
	    data: datos, 
	    success: function(data){ 
	    	//console.log(data);
	    	var datos = JSON.parse(data);
	    	var mensaje="Total Atendidos (Con asistencia): "+datos[0].datos+"<br>Total Inscritos (Con o sin asistencia): "+datos[1].datos+"<br>Porcentaje de Atendidos/Inscritos: "+Math.round((datos[0].datos/datos[1].datos*100)*100)/100+"%"; 	    	  
	    	console.log(mensaje);
	      	$("#LB_Atendidos").html(mensaje);  
	    },  
	    async: false 
	  });

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
		            	title: 'Asistencias clase Colegio X del mes'
		            }
		        ]
		    }).draw();
		    parent.cerrarCargando(); 
		},
		error: function(result){ 
      		console.error("Error: "+result);   
    	}  
	});	
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