var url_service_obj = '../../src/ConsultasReportes/Controlador/ConsultasReportesController.php';
$(document).ready(function(){ 
	
	cargarMeses(); 
	$("#SL_Ano").change(cargarMeses); 

	$("#BT_consultar_asignaciones").on('click',function(e){
		e.preventDefault();	
		var consulta=true;
	
		if(parseInt($("#SL_mes").val())>parseInt($("#SL_mesh").val())){
			parent.mostrarAlerta("error","Mensaje del sistema",'Mes Hasta no puede ser menor que Mes Desde'); 
			consulta=false;			
			
		}
		if(consulta){
			consultarAsignaciones();
		} 
		//setTimeout(function(){consultarAsignaciones()}, 1000);
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

function consultarAsignaciones(){
	
	//$("#table_asignaciones thead").html(getEncabezadosSesionesClase()); 
	parent.mostrarCargando();     
	var linea = $("#SL_linea").val();
	var tipo_grupo="";
	if(linea=='AE')
		tipo_grupo="arte_escuela";
	else if(linea=='IC')
		tipo_grupo="emprende_clan";
	else
		tipo_grupo="laboratorio_clan";

	var datos = { 
	    funcion: 'getAsignaciones', 
	    p1: tipo_grupo, 
	    p2: $("#SL_Ano").val(), 
	    p3: $("#SL_mes").val(), 
	    p4: $("#SL_mesh").val()
	}; 

	$.ajax({ 
		url: url_service_obj, 
		type: 'POST', 
		data: datos, 
		success: function(data){ 
			$("#BT_consultar_asignaciones").removeAttr("disabled");		
			$("#div_table_asignaciones").html(data);	
		    $("#table_asignaciones").DataTable({
		        "pageLength": 100,
		        "language": {
		            "lengthMenu": "Ver _MENU_ registros por pagina",
		            "zeroRecords": "No hay informaci??n, lo sentimos.",
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
		            	title: 'Asignaciones '+linea+' X rango de '+$("#SL_mes option:selected").text()+' a '+$("#SL_mesh option:selected").text()+' de '+$("#SL_Ano").val()
		            }
		        ]
		    }).draw();  
		    parent.cerrarCargando();	
				
			
		},  
		async: false 
	});
}
