var url_service = '../../Controlador/Administracion/C_Asignacion_Actividades.php';
$(function(){


	$("#TB_buscar_usuario").keyup(function(e){
	    if(e.keyCode == 13){
			buscarUsuarios();
		}
	});
	$("#BT_buscar").click(function(){
		buscarUsuarios();
	});
	$("body").delegate(".seleccionar_usuario","click",function(){
		var id_usuario = $(this).data("id_usuario");
		var nombre_usuario = $(this).data("nombre_usuario");
		$("#TB_nombre_usuario").val(nombre_usuario);
		$("#TB_nombre_usuario").data("id_usuario",id_usuario);
		cargarModulos(id_usuario);
	});
	$("body").delegate(".cargar_actividades_modulo","click",function(){
		var id_usuario = $("#TB_nombre_usuario").data("id_usuario");
		var id_modulo = $(this).data("id_modulo");
		cargarActividadesModulo(id_modulo,id_usuario);
	});
	$("#actividades_usuarios").delegate(".permiso_actividad","change",function(){
		var id_usuario = $(this).data("id_usuario");
		var id_actividad = $(this).data("id_actividad");
		var permiso = Number($(this).is(':checked'));
		datos = {
			opcion: 'update_permiso_actividad',
			id_usuario: id_usuario,
			id_actividad: id_actividad,
			permiso: permiso
		}
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			success: function(data){
				
			}
		});
	});

	getOptionsRoles();
	getOptionsModulos();
	$("#SL_modulo").change(getOptionsActividades);
	$("#SL_rol").change(getTotalUsuariosRolActividad);
	$("#SL_actividad").change(getTotalUsuariosRolActividad);

	$("#Bt_mostrar_usuarios_rol_con_actividad").click(mostrarUsuariosRolActividad);
	$("#BT_asignar_actividad_rol").click(saveAsignacionActividadUsuariosRol);
	$("#BT_remover_actividad_rol").click(removerActividadUsuariosRol);
});
function buscarUsuarios(){
	$("#resultado_busqueda").show();
	$("#actividades_usuarios").hide();
	var texto = $("#TB_buscar_usuario").val();
	if(texto.length > 3){
		datos = {
			opcion:'buscar_usuario',
			texto:texto
		};
		$.ajax({
			url:url_service,
			type:'POST',
			data: datos,
			beforeSend: function(){
				$("#resultado_busqueda").html("<div class='alert alert-warning' role='alert'><center>Cargando datos, espere por favor...</center></div>");
			},
			success: function(data){
				$("#resultado_busqueda").html(data);
			}
		});
	}else{
		$("#resultado_busqueda").html("<div class='alert alert-danger' role='alert'>Ingrese un mínimo de 4 caracteres</div>");
	}
}

function cargarModulos(id_usuario){
	$("#resultado_busqueda").hide("slow");
	$("#actividades_usuarios").show("slow");
	datos = {
		opcion:'cargar_modulos'
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		beforeSend: function(){
			$("#actividades_usuarios").html("<div class='alert alert-warning' role='alert'><center>Cargando datos, espere por favor...</center></div>");
		},
		success: function(data){
			$("#actividades_usuarios").html(data);
		}
	});
}

function cargarActividadesModulo(id_modulo,id_usuario){
	datos = {
			opcion:'cargar_actividades_modulo',
			id_modulo: id_modulo,
			id_usuario: id_usuario
		};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		beforeSend: function(){
			$("#modulo_" + id_modulo).html("<div class='alert alert-warning' role='alert'><center>Cargando datos, espere por favor...</center></div>");
		},
		success: function(data){
			$("#modulo_" + id_modulo).html(data);
			$('.permiso_actividad').bootstrapToggle();
		}
	});
}

function getOptionsRoles(){
	datos = {
		opcion: 'get_option_roles'
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		$("#SL_rol").html(data);
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function getOptionsModulos(){
	datos = {
		opcion: 'get_option_modulos'
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		$("#SL_modulo").html(data);
		getOptionsActividades();
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function getOptionsActividades(){
	datos = {
		opcion: 'get_option_actividades',
		id_modulo: $("#SL_modulo").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		$("#SL_actividad").html(data);
		getTotalUsuariosRolActividad();
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function getTotalUsuariosRolActividad(){
	datos = {
		opcion: 'get_total_usuarios_rol_actividad',
		id_tipo_usuario: $("#SL_rol").val(),
		id_actividad: $("#SL_actividad").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		$("#span_total_usuarios_rol_actividad").text(data);
		$("#div_table_usuarios_rol_actividad").hide();
		getTotalUsuariosRol();
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function getTotalUsuariosRol(){
	datos = {
		opcion: 'get_total_usuarios_rol',
		id_tipo_usuario: $("#SL_rol").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		$("#span_total_usuarios_rol").text(data);
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function mostrarUsuariosRolActividad(){
	datos = {
		opcion: 'get_usuarios_rol_actividad',
		id_tipo_usuario: $("#SL_rol").val(),
		id_actividad: $("#SL_actividad").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		$("#div_table_usuarios_rol_actividad").show('fast');
		var table_usuarios_rol_actividad = $("#table_usuarios_rol_actividad").DataTable();
    	table_usuarios_rol_actividad.clear();

    	$("#table_usuarios_rol_actividad").html(data);

		table_usuarios_rol_actividad.destroy();
	    $("#table_usuarios_rol_actividad").DataTable({
	        responsive: true,
	        iDisplayLength: '10',
	        "language": {
	            "lengthMenu": "Ver _MENU_ registros por pagina",
	            "zeroRecords": "No hay información, lo sentimos.",
	            "info": "Mostrando pagina _PAGE_ de _PAGES_",
	            "infoEmpty": "No hay registros disponibles",
	            "infoFiltered": "(filtered from _MAX_ total records)",
	            "search": "Filtrar"
	        }
	    });
    table_usuarios_rol_actividad.draw();
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function saveAsignacionActividadUsuariosRol(){
	datos = {
		opcion: 'asignar_actividades_usuarios_rol',
		id_tipo_usuario: $("#SL_rol").val(),
		id_actividad: $("#SL_actividad").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		parent.mostrarAlerta("success","Actividad Adignada","Se ha adignado la actividad a todos los usuarios con el rol indicado.");
		getTotalUsuariosRolActividad();
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function removerActividadUsuariosRol(){
	datos = {
		opcion: 'remover_actividades_usuarios_rol',
		id_tipo_usuario: $("#SL_rol").val(),
		id_actividad: $("#SL_actividad").val()
	};
	$.ajax({
		url:url_service,
		type:'POST',
		data: datos,
		async: false,
		beforeSend: function(){
			
		}
	}).done(function(data){
		parent.mostrarAlerta("error","Actividad Removida","Se ha removido satisfactoriamente la actividad a todos los usuarios con el rol indicado.");
		getTotalUsuariosRolActividad();
	}).fail(function(data){
		console.log("Error" + data);
	});
}