var url_service_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(document).ajaxStart(function() { Pace.restart(); });
$(document).ready(function(){ 
	$("#SL_clan").html(parent.getOptionsClanes());
	cargarMeses(); 
	$("#SL_Ano").change(cargarMeses); 

	$("#BT_consultar_asistencias").on('click',function(e){
		e.preventDefault();	
		var consulta=true;

		if($("#SL_clan").val()==null){
			parent.mostrarAlerta("error","Mensaje del sistema",'Por favor seleccione el Crea'); 
			consulta=false;
		}	
		if(parseInt($("#SL_mes").val())>parseInt($("#SL_mesh").val())){
			parent.mostrarAlerta("error","Mensaje del sistema",'Mes Hasta no puede ser menor que Mes Desde'); 
			consulta=false;			
			
		}
		if(consulta){
			consultarAsistenciasMesEC();
		} 
		//setTimeout(function(){consultarAsistenciasMesEC()}, 1000);
	});
}); 

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
	$("#SL_mesh").html(options).selectpicker('refresh');  
	
}

function consultarAsistenciasMesEC(){
	
	//$("#table_asistencia thead").html(getEncabezadosSesionesClase()); 
	var linea = $("#SL_linea").val();
	var tipo_grupo="";
	if(linea=='EC')
		tipo_grupo="emprende_clan";
	else
		tipo_grupo="laboratorio_clan";

	var id_clan = "";
	$('#SL_clan :selected').each(function(i, selected){ 
		if(id_clan=="") id_clan = $(selected).val();
		else id_clan += ","+$(selected).val();
	});   	
	var datos_atencion = {
	    funcion: 'getConsultaAsistencia'+linea+'Mes', 
	    p1: id_clan, 
	    p2: $("#SL_mes").val(), 
	    p3: $("#SL_mesh").val(), 
	    p4: $("#SL_Ano").val()  
	};
	var datos = { 
	    funcion: 'getAtendidosMesECYLC', 
	    p1: id_clan, 
	    p2: $("#SL_mes").val(), 
	    p3: $("#SL_mesh").val(), 
	    p4: $("#SL_Ano").val(),
	    p5: tipo_grupo
	}; 


	$.ajax({ 
		url: url_service_obj, 
		type: 'POST', 
		data: datos, 
		success: function(data){ 
			//console.log(data);
			var consultaTabla=true;
			var datos = JSON.parse(data); 
			var mensaje="";
			if(datos[0].datos==0 || datos[1].datos==0 ){
				mensaje="No hay datos para los datos indicados";
				consultaTabla=false;
			}  
			else
				mensaje="Total Atendidos (Con asistencia): "+datos[0].datos+"<br>Total Reportados (Con o sin asistencia): "+datos[1].datos+"<br>Porcentaje de Atendidos/Reportados: "+Math.round((datos[0].datos/datos[1].datos*100)*100)/100+"%";
		  	$("#LB_Atendidos").html(mensaje);  
			if(consultaTabla){
				parent.mostrarCargando();
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
					            	title: 'Asistencias '+linea+' X de mes'
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
			else{
				$("#div_table_asistencia").html("");  
			}
		},  
		async: false 
	});
}
