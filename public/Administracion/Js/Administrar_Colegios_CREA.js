var url_service = '../../src/Administracion/Controlador/AdministracionController.php';
var session = '';
$(function(){
	var id_usuario=$("#id_usuario").val(); 
	$("#SL_CREA").html(parent.getOptionsClanes());
	$("#SL_Colegios").html(parent.getOptionsColegios());
	
	$("#SL_CREA").on('change',function(){
		getIdColegiosCrea($(this).val());
	}).selectpicker("refresh");

	$('#SL_Colegios').on('changed.bs.select', function (e, clickedIndex, newValue, oldValue) {
		var val_selected = $(this).find('option').eq(clickedIndex).val();
		$("#SL_Colegios > option:selected").each(function() {
			if(!newValue){
				$("#colegio_"+val_selected).css('color','red');
				$("#colegio_"+val_selected).attr('data-accion','eliminar');
				$("#colegio_"+val_selected).css('text-decoration','line-through');
				$("#colegio_nuevo_"+val_selected).remove();
			}
			else{
				if($("#colegio_"+this.value).length == 0 && $("#colegio_nuevo_"+this.value).length == 0){
					$("#div_colegios_asociados").append("<div id='colegio_nuevo_"+this.value+"' data-accion='asociar' data-id-colegio='"+this.value+"'>"+this.text+"<br></div>");
					$("#colegio_nuevo_"+val_selected).css('color','green');
				}
				else{
					$("#colegio_"+val_selected).css('color','black');
					$("#colegio_"+val_selected).attr('data-accion','ninguna');
					$("#colegio_"+val_selected).css('text-decoration','none');
				}
			}
		});
	});

	$.ajax({
		url: '../../Controlador/Consultas/getSession.php',
		data: {requested: 'session_username'},
		dataType: 'json',
		success: function (data) {
			session = data;
		},
		async : false
	});

	$("#BT_Guardar").on('click', function(){
		var asociar = 0;
		var asociados = 0;
		var eliminar = 0;
		var eliminados = 0;
		$("div[data-accion='asociar']").each(function() {
			asociar++;
			var id_colegio = $(this).attr('data-id-colegio');
			var datos = {
				funcion:'asociarColegioCrea',
				p1:{
					'id_crea' : $("#SL_CREA").val(),
					'id_colegio' : id_colegio,
					'id_usuario': session
				}
			};
			$.ajax({
				url: url_service,
				type: 'POST',
				data: datos,
				dataType: 'json',
				success: function(resultado){
					if(resultado == 1){
						asociados++;
					}
					else{
					}
				},
				async: false
			});
		});
		$("div[data-accion='eliminar']").each(function() {
			eliminar++;
			var id_colegio = $(this).attr('data-id-colegio');
			var datos = {
				funcion:'eliminarColegioCrea',
				p1:{
					'id_crea' : $("#SL_CREA").val(),
					'id_colegio' : id_colegio,
					'id_usuario': session
				}
			};
			$.ajax({
				url: url_service,
				type: 'POST',
				data: datos,
				dataType: 'json',
				success: function(resultado){
					if(resultado == 1){
						eliminados++;
					}
					else{
					}
				},
				async: false
			});
		});
		var total = asociar+eliminar;
		var total_ejecutados = asociados+eliminados;
		if(total_ejecutados==total){
			$("#SL_CREA").trigger('change');
		}else{
			parent.swal("","Los colegios del CREA NO fueron actualizados.","error");
		}
	});
});

function getIdColegiosCrea(id_crea){
	var mostrar = "";
	var datos = {
		funcion: 'getIdColegiosCrea',
		p1:{
			'id_crea' : id_crea
		}
	};
	parent.mostrarCargando();
	$.ajax({
		url: url_service,
		type: 'POST',
		data: datos,
		dataType: 'json',
		success: function(datos){
			$("#div_colegios_asociados").html('');
			$("#SL_Colegios").val('').selectpicker("refresh");
			$.each(datos, function(i) {
				$("#SL_Colegios option").filter(function() { return $(this).val() == datos[i].PK_Id_Colegio; }).prop('selected', true);
				$("#SL_Colegios").selectpicker("refresh");
				$("#div_colegios_asociados").append("<div id='colegio_"+datos[i].PK_Id_Colegio+"' data-accion='ninguna' data-id-colegio='"+datos[i].PK_Id_Colegio+"'>"+datos[i].VC_Nom_Colegio+"<br></div>");
			});
			parent.cerrarCargando();	
		},
		async: true
	});
	return mostrar;
}


