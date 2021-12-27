 var url_service = '../src/Administracion/Controlador/AparienciaController.php'; 
$(document).ready(function(){
	var datos = {
		funcion : 'getModulosRol',
		p1: $("#id_usuario").val()
	};
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		success: function(data){
			$("#contenedorIconos").html(data);
			//console.log(data);
		},
		async: true
	});	
	$("body").on("click",".iconosInicio",function(){		
		$("#tituloModulo").html($(this).data('nombremodulo'));
		var datos = {
			funcion : 'getActividadesModuloUsuario',
			p1: $("#id_usuario").val(),
			p2: $(this).data("modulo")
		};
		$.ajax({
			url: url_service,
			type: 'POST',
			data: datos,
			success: function(data){
				$("#actividades").html(data);
			},
			async: true
		});	
	});

});