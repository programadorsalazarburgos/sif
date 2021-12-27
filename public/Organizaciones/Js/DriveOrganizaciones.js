var url_controller = '../../Controlador/Organizaciones/C_Formatos_Administrativos.php';
var session = "";
var session_type = "";
var year = "";
var organizacion = "";
$(document).ready(function(){ 

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php',
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
		},
		async : false
	});


	$.ajax({
		url: '../../Controlador/Consultas/getSession.php',
		data: {requested: 'session_usertype'},
		dataType: 'json',
		success: function (data) {
			session_type = data;
		},
		async : false
	});

	$("#convenios_2017").on('click', function(e){
		e.preventDefault();
		$("#div_convenios_2017").toggle('slow');
		$("#div_convenios_2018").hide();
		$("#div_convenios_2019").hide();
	});
	$("#convenios_2018").on('click', function(e){
		e.preventDefault();
		$("#div_convenios_2017").hide();
		$("#div_convenios_2018").toggle('slow');
		$("#div_convenios_2019").hide();
	});
	$("#convenios_2019").on('click', function(e){
		e.preventDefault();
		$("#div_convenios_2017").hide();
		$("#div_convenios_2018").hide();
		$("#div_convenios_2019").toggle('slow');
	});

	if(session_type == 11){
		$(".gdrivelink[data-id-organizacion='"+session+"']").removeClass("disabled");	
	}
	else{
		$(".gdrivelink").removeClass("disabled");
	}

	
});