var url_controller = '../../Controlador/Administracion/C_Envio_Notificaciones.php';
$(function(){
	idUsuario = $("#id_usuario").val();
	$('#SL_Icon').on('change', function(e){
		e.preventDefault();
		$('#I_Icon').removeClass();
		$('#I_Icon').addClass($(this).val());
		// $('#I_Icon').s
		$('#TX_Icon').val($(this).val());

	});
	$('#TX_Icon').on('change', function(e){
		e.preventDefault();
		$('#I_Icon').removeClass();
		if ($(this).val() == '') {
			$(this).val('fa-2x fa fa-bullhorn');
		}
		$('#I_Icon').addClass($(this).val());
	});
	$("#FM_Send_Notification").on('submit', function(e){
		e.preventDefault();
		var datos = $(this).serializeArray();
		// console.log(JSON.stringify(datos));
		$('#SL_User_Type :selected').each(function(i, selected){
			var notificacion = {
				vc_url:$('#SL_Url').val(),
				vc_icon:$('#TX_Icon').val(),
				vc_contenido:$('#TX_Content').val()
			}
			role = $(selected).val();
			window.parent.sendNotificationRole(notificacion,role);
		}); 
		parent.mostrarAlerta("success","Mensaje del Sistema","Se ha enviado la notificacion correctamente");
		/*var box1 = bootbox.alert("Se ha enviado la notificacion correctamente");
		box1.css({
			'top': '30%',
			'margin-top': '15%'
		});*/
	});
	$("#select-programa").html("");
	var programas = parent.getParametroDetalle(1);
	$.each(programas, function (i) {
		$('#select-programa').append($('<option>', {
			value : programas[i].PK_Id_Tabla,
			text : programas[i].VC_Descripcion
		}));
	});
	$("#SL_Url").html(parent.getOptionsActividades());
	$('#select-programa').on('change', function(e){
		e.preventDefault();
		//console.log($(this).val());
		$("#SL_User_Type").html("");
		var roles = null;
		if ($(this).val() != null){

			if ($(this).val().includes("100")){ // 100 hace referencia a perfiles Crea en la tabla parametro detalle

				if ($(this).val().includes("101")){ // 100 hace referencia a perfiles Nidos en la tabla parametro detalle
					roles = parent.getParametroDetalle(4);
				}
				else{
					roles = parent.getParametroDetalle(2);
				}
			}
			else{
				if ($(this).val().includes("101")){
					roles = parent.getParametroDetalle(3);
				}
			}

			if (roles != null)
				$.each(roles, function (i) {
					$('#SL_User_Type').append($('<option>', {
						value : roles[i].FK_Value,
						text : roles[i].VC_Descripcion
					}));
				});
		}

		$('.selectpicker').selectpicker('refresh');
	});
	$('.selectpicker').selectpicker('refresh');
});
