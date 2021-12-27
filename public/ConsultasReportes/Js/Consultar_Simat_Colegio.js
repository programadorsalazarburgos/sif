var servicio_simat = "https://sif.idartes.gov.co/ws-simat/index.php/";
$(document).ajaxStart(function() { Pace.restart(); });
$(document).ready(function(){
	$("#SL_clan").html(parent.getOptionsClanes()).change(cargarColegiosCrea);
	$("#SL_clan").trigger('change');  
	//cargarMesesSesionesClaseColegio();

	$("#BT_consultar_simat").on('click',consultarSimatPorDane);
}); 

function cargarColegiosCrea(){
	//console.log($(this).val());
	$("#SL_colegio").html(parent.getOptionsColegiosCrea($(this).val(),1)).selectpicker('refresh');    
} 
 
function consultarSimatPorDane(){
	
	//$("#table_asistencia thead").html(getEncabezadosSesionesClase());
 	parent.mostrarCargando();

	/*var id_colegios = "";
	$('#SL_colegio :selected').each(function(i, selected){ 
		if(id_colegios=="") id_colegios = $(selected).val();
		else id_colegios += ","+$(selected).val();
	});   	*/
	var id_colegios = $('#SL_colegio').val();
	var datos = {
		vc_usuario: 'admin',
		vc_contrasena: '1234',
		codigo_dane:  id_colegios
	};
 
	$.ajax({
		url: servicio_simat+"obtenerEstudiantesPorDane", 
		type: 'POST',
		data: datos,
		success: function(data){			
			$("#BT_consultar_simat").removeAttr("disabled");		
			$("#div_table_simat").html(data);
		    $("#table_simat").DataTable({
		    	responsive: true,
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
		            	title: 'Simat por colegio ' + $('#SL_colegio :selected').text()
		            }
		        ]
		    }).draw();
		    parent.cerrarCargando();
		},
		error: function(result){ 
      		console.log("Error: "+result);   
    	}  
	});	
}
