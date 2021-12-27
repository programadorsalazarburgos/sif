$(window).load(function(){ 
	$("#precarga").hide();
	$("#div_body").show();
});

$(document).ready(function(){
	$("#usuario, #password").on('keyup', function(){
		$("#div_alerta").hide();
	});

	$("#FORM_LOGIN").on('submit', function(event){
		event.preventDefault();
		var formulario = $("#FORM_LOGIN").serializeArray();
		$.ajax({
            	url: 'controlador/C_IniciarSesion.php',
            	type: 'POST',
            	data: formulario,
            	cache: false,
            	async: false,
            	dataType: 'html',
            	success: function(data)
            	{
               		if(data != "" && data != "NULL"){
            			$(location).prop('href', 'http://localhost/SIF/ConvocatoriaOrganizaciones/menuorganizacion.php')
            		}
            		else{
            			$("#div_alerta").show();
            		}
            	}	
        	});
	});
});