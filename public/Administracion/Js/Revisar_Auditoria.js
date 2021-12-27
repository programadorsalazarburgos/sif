var url_ok_obj = '../../src/Administracion/Controlador/AuditoriaController.php';
$(function(){
	$("#nav_inicios_sesion").click(function(){
		$("#SL_mes_anio_auditoria_inicios_sesion").html(cargarSelectFechaIniciosSesion()).change(mostrarTablaIniciosSesion).selectpicker('refresh');
		$("#SL_usuario_auditoria_inicios_sesion").html(cargarSelectUsuarios()).val(parent.idUsuario).change(mostrarTablaIniciosSesion).selectpicker('refresh').trigger("change");
		mostrarTablaIniciosSesion();
	});

	$("#nav_acciones_grupos").click(function(){
		$("#SL_crea").html(parent.getOptionsClanes()).change(mostrarTablaAuditoriaGrupo).selectpicker('refresh');
		$("#SL_mes_anio_auditoria_grupo").html(cargarSelectFechaIniciosSesion()).change(mostrarTablaAuditoriaGrupo).selectpicker('refresh');
		$("#SL_grupo").html(parent.getOptionGruposDeUnCrea($("#SL_crea").val())).change(mostrarTablaAuditoriaGrupo).selectpicker('refresh');
		mostrarTablaAuditoriaGrupo();
	});

	$("#nav_acciones_circulacion").click(function(){
		$("#SL_mes_anio_auditoria_circulacion").html(cargarSelectFechaIniciosSesion()).change(mostrarTablaAuditoriaCirculacion).selectpicker('refresh');
		$("#SL_evento").html(parent.getOptionsEventosActivos(0)).change(mostrarTablaAuditoriaCirculacion).selectpicker('refresh');
		mostrarTablaAuditoriaCirculacion();
	});

	$("#TX_busqueda_estudiante").keyup(function(e){
		if(e.keyCode == 13){
			$("#BT_buscar_estudiante").trigger("click");
		}
	});

	$("#BT_buscar_estudiante").click(function(){
		consultarTablaEstudiante();
	});

	$("table").delegate(".cargar_datos_estudiante_auditoria","click",function(){

	});




	var table_acciones_estudiante = $("#table_acciones_estudiante").DataTable({
			responsive: true,
			iDisplayLength: '10',
			"order":[],
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
								exportOptions: {
										columns: ':visible'
							},
							title: 'Auditoria estudiante '
						}
				]
	});

	

	

	function cargarSelectUsuarios(){
		var mostrar = "";
		var datos = {
			'funcion': 'consultarUsuariosQueTienenLogLogin',
		};
		$.ajax({
			url:url_ok_obj,
			type:'POST',
			data: datos,
			async: false
		}).done(function(data){
			mostrar += data;
		}).fail(function(data){
			console.log(data);
			alertify.alert("Error","No se ha podido cargar los usuarios para verificar inicios de sesión." + data);
		});
		return mostrar;
	}

	function cargarSelectFechaIniciosSesion(){
		var option = "";
		var months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
		var f = new Date();
		for (var i = f.getMonth() +1; i >= 2; i--) {
			option += "<option value='" + "2019" + "-" + ((i < 10)?'0':'') + i + "'>" + months[i-1] + " de " + 2019 + "</option>";
		}
		return option;
	}

	function mostrarTablaIniciosSesion(){
		var datos = {
			'funcion': 'consultarTablaLogLoginUsuario',
			p1:{
				id_usuario: $("#SL_usuario_auditoria_inicios_sesion").val(),
				mes_anio: $("#SL_mes_anio_auditoria_inicios_sesion").val()
			}
		};
		$.ajax({
			url:url_ok_obj,
			type:'POST',
			data: datos
		}).done(function(data){
			$("#div_table_log_login").html(data); 
			$("#table_log_login").DataTable({
					responsive: true,					
					iDisplayLength: '10',
					"order":[],
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
										exportOptions: {
												columns: ':visible'
									},
									title: 'Auditoria usuario'
								}
						]
			}).draw();      
		}).fail(function(data){
			console.log(data);
		});
	}

	function mostrarTablaAuditoriaGrupo(){
		var datos = {
			'funcion': 'consultarAuditoria',
			p1: {
				mes_anio: $("#SL_mes_anio_auditoria_grupo").val(),
				id_clan: $("#SL_crea").val(),
				id_registro: $("#SL_grupo").val(),
				tipo_grupo: $("#SL_grupo").find(':selected').data('tipo_grupo')
			},
			p2: 'grupo',
			p3: 'table_acciones_grupo'
		};
		$.ajax({
			url:url_ok_obj,
			type:'POST',
			data: datos
		}).done(function(data){
			$("#div_table_acciones_grupo").html(data); 
			$("#table_acciones_grupo").DataTable({
				responsive: true,
				iDisplayLength: '10',
				"order":[],
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
									exportOptions: {
											columns: ':visible'
								},
								title: 'Auditoria grupo ' + $("#SL_grupo").val()
							}
					]
			}).draw();
		}).fail(function(data){
			console.log(data);
		});
	}

	function mostrarTablaAuditoriaCirculacion(){
		var datos = {
			'funcion': 'consultarAuditoria',
			p1: {
				mes_anio: $("#SL_mes_anio_auditoria_circulacion").val(),
				id_registro: $("#SL_evento").val()
			},
			p2: 'circulacion',
			p3: 'table_acciones_circulacion'
		};
		$.ajax({
			url:url_ok_obj,
			type:'POST',
			data: datos
		}).done(function(data){

			$("#div_table_acciones_circulacion").html(data); 
			$("#table_acciones_circulacion").DataTable({
				responsive: true,
				iDisplayLength: '10',
				"order":[],
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
									exportOptions: {
											columns: ':visible'
								},
								title: 'Auditoria evento '// + $("#SL_grupo").val()
							}
					]
			}).draw(); 
		}).fail(function(data){
			console.log(data);
		});
	}

	function consultarTablaEstudiante() {
		var datos = {
			'funcion' : 'consultarTablaEstudiante',
			'p1' : $("#TX_busqueda_estudiante").val()
		};
		$.ajax({
			url: url_ok_obj,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#div_table_estudiante").html(data);
			$("#table_estudiante").DataTable({
				responsive: true,
				iDisplayLength: '10',
				"order":[],
				"language": {
						"lengthMenu": "Ver _MENU_ registros por pagina",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando pagina _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtered from _MAX_ total records)",
						"search": "Filtrar"
				} 
			}).draw();			
		}).fail(function(result){
			console.log("Error: "+result);
		});
	}
});
