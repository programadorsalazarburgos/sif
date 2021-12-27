var url_service = '../src/Administracion/Controlador/AparienciaController.php';
var tokencode = '';
// var remoteip = '';
$(document).ready(function(){
	grecaptcha.ready(function() {
		grecaptcha.execute('6Leao9gUAAAAAOgHuJ391BALdwcw20KNCSu750p7', {action: 'homepage'}).then(function(token) {
			tokencode = token;
		});
	});
	// $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
	// 	remoteip = data.geobytesremoteip;
	// });
	$('.mayuscula').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});
	
	$("#password, #username").on('keyup', function(){
		$("#div_alerta").hide();
		$("#div_alerta_recaptcha").hide();
	});

	$("#ver_encuestas").on('click', function(){
		$("#DIV_PANEL_BODY").hide();
		$("#DIV_ENCUESTAS").show();
	});

	$("#volver").on('click',function(){
		$("#DIV_ENCUESTAS").hide();
		$("#DIV_PANEL_BODY").show();
	});

	$("#login").on('submit', function(event){
		event.preventDefault();

		grecaptcha.execute('6Leao9gUAAAAAOgHuJ391BALdwcw20KNCSu750p7', {action: 'homepage'}).then(function(token) {
			tokencode = token;
		});
		
		var formularioJson = getFormData($("#login"));
		var datos = new FormData();
		formularioJson.password = sha1(md5($('#password').val()));
		var datos = {
			'funcion' : "validarEntrada",
			'p1' : formularioJson,
			'p2' : tokencode
		};
		$.ajax({
			url: url_service,
			type: 'POST',
			dataType: 'json',
			data: datos,
			success: function(result)
			{
					//console.log("Los dados son:"+ result);
					if(result.estado=='1'){
						$(location).prop('href', 'Inicio.php')
					}
					else{
						$("#div_alerta_recaptcha").hide();
						if(result.estado != '1'){
							$("#span-error").html(result.mensaje);
						}
						$("#div_alerta").show();
					}
				}
			});
	});
});