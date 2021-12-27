var url_notificacion = '../src/Administracion/Controlador/NotificacionController.php';   
var url_aparincia = '../src/Administracion/Controlador/AparienciaController.php'; 
var notificacionQuantity = 0;
var socket = null;       
var session ="";
$(function(){
	idUsuario = $("#id_usuario").val();
	idRol = $("#id_rol").val();
	var info = {};
	info.userId = idUsuario;
	info.room = getRomFromUserType(idRol); 
	try{

		$.getScript($('#socket_io').val()+"/socket.io/socket.io.js", function() { 
			socket = io.connect($('#socket_io').val());   
			socket.emit('token', info);
			socket.on('notificacion', function(notificacion){
				refreshNotificaciones(idUsuario);
				/*if (notificacion.PK_Notificacion_Id != undefined) {
					notificacionQuantity++;
					$('#SP_Notificaciones').html(notificacionQuantity);
					$('#LI_NA').html("");
					$('#UL_Notificaciones').prepend(
						'<li>'+
						'<a class="notificacion-temp" href="'+notificacion.VC_Url+'" data-content="'+notificacion.PK_Notificacion_Id+'" target="ventana_iframe">'+
						'<h5 style="font-size: 15px; white-space:pre-wrap;"><i class="'+notificacion.VC_Icon+'"></i>'+
						'<i> &nbsp;'+notificacion.VC_Contenido+'</i></h5>'+
						'<h6 class= "text-right"><i>'+notificacion.DT_Fecha+'</i></h6>'+
						'</a>'+
						'</li>'					
						);
					}*/
				});
		});   		
	} catch (ex) {
		console.log(ex.message);
	}

	$.ajax({
		url: '../Controlador/Consultas/getSession.php', 
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
		},
		async : false
	});
	refreshNombreImagen(session);
	/*var datos = {	
		'opcion':'getNombreUsuarioImagen',
		'idUsuario': session
	};
	$.ajax({
		url: url_aparincia,
		type:'POST',
		data: datos,
		dataType: "json",
		success: function(datos_usuario) {
			usuario = datos_usuario; 			
			$("#nombre_usuario").html(usuario.nombre_usuario);
			$('#imagenUsuario').css('background-image', 'url("'+usuario.TX_Foto_Perfil+'")');
		},
		async : false
	});*/

	refreshNotificaciones(idUsuario);
	$(document).delegate('.notificacion-temp','click', function(e){
		if ($(this).data('content')!= undefined) {	
			var notificationId = $(this).data('content');
			// console.log(notificationId);
			/*var datos = {	
				'opcion':'setNotificationUser',
				'idUsuario': idUsuario,
				'notificationId': notificationId
			};*/
			var datos = {	
				'funcion':'setNotificationUser',
				'p1': idUsuario,
				'p2': notificationId
			};			
			$.ajax({
				async: true,
				url:url_notificacion,
				type:'POST',
				data: datos,
				success: function(data){
					refreshNotificaciones(idUsuario);
				}
			});
		}
	});
	$(document).delegate('#a-marcar-leidas','click', function(e){
		e.preventDefault();
		let idUsuario = $("#id_usuario").val();
		var datos = {
			'funcion':'setNotificacionesLeidas', 
			'p1': idUsuario
		}	
		$.ajax({
			async: true,
			url:url_notificacion,
			type:'POST',
			data: datos,
			success: function(data){		
				if (data)
					refreshNotificaciones(idUsuario);
			}
		});

	});
});

function sendNotificationUser(notificacion) {
	try{
		var datos=new Object();
		datos.p1 = new Object();
		if (notificacion != null) {	
			datos.p1.vc_url = notificacion.VC_Url;
			datos.p1.vc_icon = notificacion.VC_Icon;
			datos.p1.vc_contenido = notificacion.VC_Contenido;
			//datos.p1.titulo = notificacion.titulo;
			if(notificacion.email == undefined)
				datos.p3=0;
			else	
				datos.p3=notificacion.email;
			//datos.opcion="saveNotificationUser";
			datos.p2=notificacion.userId; 
			datos.funcion="saveNotificationUser";
			$.ajax({
				async: false,
				//url:"../Controlador/Administracion/C_Notificaciones.php",
				url: url_notificacion,
				type:'POST',
				data: datos,
				success: function(data){
					notificacion.PK_Notificacion_Id = data;
				}
			});
			$.ajax({
				async: false,
				//url:"../Controlador/Administracion/C_Notificaciones.php",
				url: url_notificacion,
				type:'POST',
				//data: {opcion:'getDate'},
				data: {funcion:'getDate'},
				success: function(fecha){
					notificacion.DT_Fecha = fecha;
				}
			});
			if (socket != null ){
				socket.emit('sendNotificationUser', notificacion);
			}
		}
	} catch (ex) {
		console.log(ex.message);
	}

}
function sendNotificationRole(notificacion,role) {
	try{
		var datos = new Object(); 
		if (notificacion != null) {	
			datos.p1 = notificacion; 
			if(notificacion.email == undefined)
				datos.p3=0;
			else	
				datos.p3=notificacion.email;    			 
			//datos.opcion="saveNotificationRole";
			datos.funcion="saveNotificationRole";
			datos.p2=role;   
			$.ajax({
				async: false,
				//url:"../Controlador/Administracion/C_Notificaciones.php",
				url: url_notificacion,
				type:'POST',
				data: datos,
				success: function(data){
					notificacion.PK_Notificacion_Id = data;
				}
			});
			$.ajax({
				async: false,
				//url:"../Controlador/Administracion/C_Notificaciones.php",
				type:'POST',
				//data: {opcion:'getDate'},
				data: {funcion:'getDate'},
				success: function(fecha){
					notificacion.DT_Fecha = fecha;
				}
			});
			notificacion.room = getRomFromUserType(role);
			if (socket != null ){
				socket.emit('sendNotificationRole', notificacion);
			}
		}
	} catch (ex) {
		console.log(ex.message);
	}

}

function refreshNotificaciones(idUsuario) {
	$('#SP_Notificaciones').html("");
	notificacionQuantity = 0;
	$('#UL_Notificaciones').html('<li class="divider"></li><li class="text-center"><b><a target="ventana_iframe" href="../public/Administracion/Notificaciones.php">Ver Todas</a></b></li>');
	
	/*var datos = {
		'opcion':'getNotifiaciones',
		'idUsuario': idUsuario
	};*/
	var datos = {
		'funcion':'getNotificacionesData', 
		'p1': idUsuario
	}	
	$.ajax({
		async: true,
		url:url_notificacion,
		type:'POST',
		data: datos,
		success: function(data){			
			notificaciones = JSON.parse(data);
			if (notificaciones.length != 0 && notificaciones != false ) {
				notificacionQuantity = notificaciones.length;
				$('#SP_Notificaciones').html(notificaciones.length);
				try{
					$.each(notificaciones, function (i) {
						if (i <= 50) {

							$('#UL_Notificaciones').prepend(
								'<li>'+
								'<a class="notificacion-temp" href="'+notificaciones[i].VC_Url+'" data-content="'+notificaciones[i].PK_Notificacion_Id+'" target="ventana_iframe">'+
								'<h5 style="font-size: 15px; white-space:pre-wrap;"><i class="'+notificaciones[i].VC_Icon+'"></i>'+
								'<i> &nbsp;'+notificaciones[i].VC_Contenido+'</i></h5>'+
								'<h6 class= "text-right"><i>'+notificaciones[i].DT_Fecha+'</i></h6>'+
								'</a>'+
								'</li>'					
								);
						}
					}); 
					$('#UL_Notificaciones').prepend('<li class="text-center"><b><a target="ventana_iframe" href="#" id="a-marcar-leidas">Marcar todas como leidas</a></b></li><li style="margin: 1px 0;" class="divider"></li>');
				}
				catch(e){
					
				}
			}
			else
			{
				$('#UL_Notificaciones').prepend('<li class="text-center" id="LI_NA">Usted no tiene notificaciones nuevas actualmente</li>');
			}
			
		}
	});
}


function getRomFromUserType(userType) {
	types = {
		"T1": 'Formador',//Formador
		"T2": 'FormadorAfa',//Formador AFA
		"T3": 'CoordClan',//Coordinador Clan
		"T4": 'GestTerr',//Gestor Territorial
		"T5": 'AsesorPed',//Asesor Pedagógico
		"T6": 'GerClan',//Gerente Clan
		"T8": 'AsisAdmin',//Asistente Administrativo
		"T10": 'EquipoCoorClan',//Equipo Coordinación Clan
		"T11": 'CoordOrgan'//Coordinador de Organización
	};
	return types["T"+userType];
}
