
var url_ok_obj = '../../src/GestionClan/GestionClanController/';

var hoy = new Date(), y = hoy.getFullYear(), m = hoy.getMonth();
var primerDia = new Date(y, m, 1);
var UltimoDia = new Date(y, m + 2, 0);	
if(hoy.getUTCDate()<=10)
	primerDia= new Date(y, m-1, 1); 


$(document).ready(function(){ 
	$("#SL_linea").change(function(){
		$("#SL_clan").trigger("change");
	}); 
	$("#SL_clan").html(parent.getOptionsClanes()).change(cargarColegiosCrea);
	$("#SL_clan").selectpicker('refresh');
	$("#SL_clan").trigger('change'); 
	$("#SL_colegio").change(cargarGruposColegio);  
	$("#SL_novedad").html(parent.getOptionsNovedades()).selectpicker('refresh');
	setCalendar("#fecha",primerDia,UltimoDia,"Fecha Inicial"); 
	$("#BT_registrar_novedades").on('click',function(e){
		e.preventDefault();

		var consulta=true;
		var linea = $("#SL_linea").val();
		var colegioCrea="";

		if($("#SL_clan").val()==""){ 
			parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese el Crea");     
			consulta=false;			

		}	

		if(($("#SL_novedad").val().length==0)){

			parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese el tipo de novedad");     
			consulta=false;

		}

		if($("#TX_observacion").val()==""){
			parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese la observación");     
			consulta=false;			
		}
		if(($("#fecha").val().length==0)){

			parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese la fecha de manera correcta");     
			consulta=false;

		}
		if($("#SL_grupo").val().length==0){
			parent.mostrarAlerta("error","Datos incorrectos","Por favor ingrese por lo menos un grupo");     
			consulta=false;			
		}
		if(linea=='arte_escuela'){
			if($("#SL_colegio").val().length==0){
				parent.mostrarAlerta("error","Datos incorrectos","Por favor Ingrese el(los) colegio(s)");     
				consulta=false;			

			}				
		}



		// validat tx_observacion 
		if(consulta)   {
			//generar registro

			registrarNovedadMasiva(); 
		}

	});
}); 

function cargarColegiosCrea(){
	//console.log($(this).val());
	$("#SL_colegio").html(parent.getOptionsColegiosCrea($(this).val(),0)).selectpicker('refresh');
} 

function cargarGruposColegio(){
	var id_colegios = "";
	$('#SL_colegio :selected').each(function(i, selected){ 
		if(id_colegios=="") id_colegios = $(selected).val();
		else id_colegios += ","+$(selected).val();
	}); 
	var linea = $("#SL_linea").val();
	var colegioCrea="";
	if(linea=='arte_escuela')
		colegioCrea = id_colegios;
	else
		colegioCrea = $("#SL_clan").val();
	$("#SL_grupo").html(parent.getOptionsGruposDeUnColegio(linea,colegioCrea)).selectpicker('refresh');

}

function registrarNovedadMasiva(){	

	var grupos = "";
	$('#SL_grupo :selected').each(function(i, selected){ 
		if(grupos=="") grupos = $(selected).val();
		else grupos += ","+$(selected).val();
	}); 

	var asistencia=0;
	if($("#CH_asistencia").prop("checked"))
		asistencia=1;



	var datos_atencion = {
	    p1: {
	    	id_grupo: grupos,
	    	fecha_novedad: $("#fecha").val(),
	    	tipo_grupo: $("#SL_linea").val(),
	    	id_novedad: $("#SL_novedad").val(),
	    	estado_asistencia:asistencia,
			observacion:$("#TX_observacion").val(),
			id_usuario: $("#id_usuario").val(),
			novedad: $("#SL_novedad option:selected").text()
	    }

	};	
	
	$.ajax({
		url: url_ok_obj+'registrarNovedadMasiva',
		type: 'POST',
		data: datos_atencion,
		success: function(data){			
			parent.mostrarAlerta('success','Mensaje del sistema',data);			
			//console.log(data);		    
		},
		error: function(result){ 
      		console.error("Error: "+result);   
    	}  
	});	
}

function setCalendar(selector,minimo,maximo,titulo){
	if(typeof(minimo)=='number') minimo='-' + minimo + 'd';				
	if(typeof(maximo)=='number') maximo='+' + maximo + 'd';
	$(selector).datepicker('destroy');
	$(selector).datepicker({
		format: 'yyyy-mm-dd',
		startDate: minimo,
		endDate: maximo,
		weekStart: 1,
    	language: 'es',
    	autoclose: true,
    	title: titulo
	});
} 