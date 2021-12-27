var url_ok_obj = '../../src/Administracion/Controlador/AdministracionController.php';
$(function(){
	$("#SL_modulo").html(getModulos()).selectpicker("refresh");
	$("#SL_modulo_actividad_editar").html(getModulos()).selectpicker("refresh");
	$("#SL_modulo_uxa").html(getModulos()).selectpicker("refresh");
	$("#form_nueva_actividad").submit(function(event){
		event.preventDefault();
		var datos = {
			'funcion': 'crearActividad',
			p1: {
				"nombre": $("#nombre_nueva_actividad").val(),
				"pagina": $("#pagina_nueva_actividad").val(),
				"id_modulo": $("#SL_modulo").val()
			},
			p2: parent.IdUsuario
		};
		$.ajax({
			url:url_ok_obj,
			type:'POST',
			data: datos
		}).done(function(data){
			$("#modal-nueva-actividad").modal("hide");
			if(data == 1){
				parent.mostrarAlerta('success','Guardado','Actividad Creada! Ahora debes asignarla a los usuarios');
			}else{
				parent.mostrarAlerta('error','Fallo ' + data,'No se ha podido crear la actividad');
			}
		}).fail(function (data){
			console.log("Error" + data);
		});
	});

	$("#SL_modulo_uxa").change(function(){
		cargarActividadesModulo($(this).val());
	});

	$("#BT_consultar_usuarios_actividad").click(function(){
		var id_actividad = $("#SL_actividad_uxa").val();
		cargarUsuariosActividadAsignada(id_actividad);
	});

	getOptionActividadesActivas();

	$("#SL_actividad_editar").change(cargarDatosActividadEditar);
	cargarDatosActividadEditar();

	$("#form_editar_actividad").submit(function(event){
		event.preventDefault();
		var datos = {
			'funcion': 'actualizarActividad',
			p1: {
				"nombre": $("#nombre_actividad_editar").val(),
				"pagina": $("#page_actividad_editar").val(),
				"id_modulo": $("#SL_modulo_actividad_editar").val(),
				"id_actividad": $("#SL_actividad_editar").val(),
				"estado": $("#CH_mantenimiento").prop('checked')?2:1
			},
			p2: parent.idUsuario
		};
		$.ajax({
			url:url_ok_obj,
			type:'POST',
			data: datos
		}).done(function(data){
			if(data == 1){
				parent.mostrarAlerta('success','Guardado','Actividad Actualizada! Ahora los datos del menu se mostrarán así.');
				id_actividad = $("#SL_actividad_editar").val();
				getOptionActividadesActivas();
				$("#SL_actividad_editar").val(id_actividad).selectpicker('refresh');
			}else{
				parent.mostrarAlerta('error','Fallo ','No se ha podido editar la actividad');
				console.log(data);
			}
		}).fail(function (data){
			console.log("Error" + data);
		});
	});

	$("#BT_desactivar_actividad").click(desactivarActividad);
});

function getModulos(){
	var r = "";
	datos = {
		'funcion': 'getOptionModulos',
	};
	$.ajax({
		url:url_ok_obj,
		type:'POST',
		data: datos,
		async:false
	}).done(function(data){
		r += data;
	}).fail(function(data){
		console.log("Error" + data);
	});
	return r;
}

function cargarActividadesModulo(id_modulo){
	datos = {
			'funcion' : 'getOptionActividadesDeModulo',
			'p1' :  id_modulo
		};
	$.ajax({
		url:url_ok_obj,
		type:'POST',
		data: datos,
		async:false
	}).done(function(data){
		$("#SL_actividad_uxa").html(data).selectpicker("refresh");
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function cargarUsuariosActividadAsignada(id_actividad){
	datos = {
			'funcion' : 'consltarTablaUsuariosIndividualAsignadosActividad',
			'p1' : id_actividad
		};
	$.ajax({
		url:url_ok_obj,
		type:'POST',
		data: datos,
		beforeSend: function(){
			$("#resultado_usuarios_actividad").html("<div class='alert alert-warning' role='alert'><center>Cargando datos, espere por favor...</center></div>");
		},
		async:false
	}).done(function(data){
		$("#resultado_usuarios_actividad").html(data);
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function getOptionActividadesActivas(){
	datos = {
		funcion:'getOptionActividadesActivas'
	};
	$.ajax({
		url:url_ok_obj,
		type:'POST',
		data: datos,
		async:false
	}).done(function(data){
		$("#SL_actividad_editar").html(data).selectpicker('refresh');
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function cargarDatosActividadEditar(){
	datos = {
		'funcion':'consultarDatosActividad',
		'p1': $("#SL_actividad_editar").val()
	};
	$.ajax({
		url:url_ok_obj,
		type:'POST',
		data: datos,
		async:false
	}).done(function(data){
		try{
			data = $.parseJSON(data);
			$("#nombre_actividad_editar").val(data.VC_Nom_Actividad);
			$("#page_actividad_editar").val(data.VC_Page);
			$("#SL_modulo_actividad_editar").val(data.FK_Modulo).selectpicker("refresh");
			if(data.estado==2)
				$("#CH_mantenimiento").bootstrapToggle('on');
			else
				$("#CH_mantenimiento").bootstrapToggle('off')
		} catch (ex) {
			console.log("Error" + ex.message);
			parent.mostrarAlerta('error','Error','No se pudo consultar los datos de la actividad seleccionada');
		}
	}).fail(function(data){
		console.log("Error" + data);
	});
}

function desactivarActividad(){
	parent.alertify.confirm("¿Esta seguro que desea desactivar la actividad?","Todos los usuarios que tienen acceso a la actividad dejaran de tenerla.",
		function(){
			datos = {
				funcion: 'desactivarActividad',
				p1: $("#SL_actividad_editar").val(),
				p2: parent.IdUsuario
			};
			$.ajax({
				url:url_ok_obj,
				type:'POST',
				data:datos
			}).done(function(data){
				if(data == 1){
					parent.mostrarAlerta('success','Desactivada','Actividad desactivada correctamente, ya no estará disponible para los usuarios');
				}else{
					parent.mostrarAlerta('error','Fallo ' + data,'No se ha podido desactivar la actividad');
				}
				getOptionActividadesActivas();
				cargarDatosActividadEditar();
			}).fail(function(data){
				console.log("Error" + data);
			})
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Actividad Eliminada OK',
				html: '<small>Se ha eliminado la actividad satisfactoriamente del sistema</small>',
				type: 'success',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		},
		function(){
			parent.swal({
				confirmButtonColor: '#3f9a9d',
				title: 'Eliminación Cancelada',
				html: '<small>Se ha cancelado la eliminación de la actividad.</small>',
				type: 'error',
				confirmButtonText: 'Aceptar',
				showCancelButton: false
			}).catch(parent.swal.noop);
		})
}