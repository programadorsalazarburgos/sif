var url_service = '../../src/Administracion/Controlador/AdministracionController.php';
var session = '';
var contador = 0;
$(function(){
	$('[data-toggle="tooltip"]').tooltip(); 
	$("#SL_PARAMETRO").html(parent.getParametros());
	var tabla_parametro_detalle = $('#table_parametro_detalle').DataTable({
		"responsive": true,
		"paging":   true,
		"ordering": true,
		"info":     false,
		"language": {
			"lengthMenu": "Ver _MENU_ registros por pagina",
			"zeroRecords": "No hay información que mostrar, Realize una consulta.",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtered from _MAX_ total records)",
			"search": "Filtrar"
		}
	});

	$("#SL_PARAMETRO").on('change',function(){
		var datos = parent.getParametroDetalleActivoInactivo($(this).val());
		var tabla_parametro_detalle = $('#table_parametro_detalle').DataTable();
		tabla_parametro_detalle.clear().draw();
		var estado_crea = '';
		var estado_nidos = '';
		contador = 0;
		$.each(datos, function(i) 
		{
			if(datos[i].IN_Estado == 0){
				estado_crea = "<i style='color:#b70000' class='far fa-times-circle fa-3x btn estado' data-id-parametro='"+datos[i].PK_Id_Tabla+"' data-programa='CREA' data-estado='0'></i>";
			}
			else{
				estado_crea = "<i style='color:#009f99' class='fas fa-check-square fa-3x btn estado' data-id-parametro='"+datos[i].PK_Id_Tabla+"' data-programa='CREA' data-estado='1'></i>";
			}
			if(datos[i].IN_Estado_Nidos == 0){
				estado_nidos = "<i style='color:#b70000' class='far fa-times-circle fa-3x btn estado' data-id-parametro='"+datos[i].PK_Id_Tabla+"' data-programa='NIDOS' data-estado='0'></i>";
			}
			else{
				estado_nidos = "<i style='color:#009f99' class='fas fa-check-square fa-3x btn estado' data-id-parametro='"+datos[i].PK_Id_Tabla+"' data-programa='NIDOS' data-estado='1'></i>";
			}
			tabla_parametro_detalle.row.add( [
				"<center>"+datos[i].VC_Descripcion+"</center>",
				"<center>"+datos[i].FK_Value+"</center>",
				"<center>"+estado_crea+"</center>",
				"<center>"+estado_nidos+"</center>",
				""
				]).draw();
			$('[data-toggle="tooltip"]').tooltip(
			{
				"animation": 1
			});
		});
	}).selectpicker("refresh");

	$("body").delegate('.estado', 'click', function(){
		var estado = $(this).data('estado');
		var id_parametro = $(this).data('id-parametro');
		var programa = $(this).data('programa');
		if(estado == 0){
			var datos = {
				funcion:'actualizarEstadoParametroDetalle',
				p1:{
					'id_parametro' : id_parametro,
					'programa': programa,
					'estado': '1'
				}
			};
			$.ajax({
				url: url_service,
				type: 'POST',
				data: datos,
				dataType: 'html',
				success: function(resultado){
					if(resultado == 1){
						parent.swal("","Realizado","success");
						$("#SL_PARAMETRO").trigger('change');
					}
					else{
						parent.swal("","No pudo actualizarse el estado","error");
					}
				},
				async: false
			});
		}
		else{
			var datos = {
				funcion:'actualizarEstadoParametroDetalle',
				p1:{
					'id_parametro' : id_parametro,
					'programa': programa,
					'estado': '0'
				}
			};
			$.ajax({
				url: url_service,
				type: 'POST',
				data: datos,
				dataType: 'html',
				success: function(resultado){
					if(resultado == 1){
						parent.swal("","Realizado","success");
						$("#SL_PARAMETRO").trigger('change');
					}
					else{
						parent.swal("","No pudo actualizarse el estado","error");
					}
				},
				async: false
			});
		}
	});

	$("body").delegate('.estado-nuevo-parametro', 'click', function(){
		var estado = $(this).data('estado');
		var programa = $(this).data('programa');
		if(estado == 0){
			$(this).css('color', '#009f99');
			$(this).removeClass('far fa-times-circle');
			$(this).addClass('fas fa-check-square');
			$(this).data('estado','1');
		}
		else{
			$(this).css('color', '#b70000');
			$(this).removeClass('fas fa-check-square');
			$(this).addClass('far fa-times-circle');
			$(this).data('estado','0');
		}
	});

	$("#BT_NUEVO_PARAMETRO").on('click', function(){
		parent.swal({
			title: 'Ingrese el nuevo Parámetro',
			input: 'text',
			showCancelButton: true,
			confirmButtonText:'Guardar',
			cancelButtonText:'Cancelar',
		}).then(function (parametro) {
			if(parametro!=""){
				var datos = {
					funcion:'saveNuevoParametro',
					p1:{
						'parametro' : parametro.toUpperCase()
					}
				};
				$.ajax({
					url: url_service,
					type: 'POST',
					data: datos,
					dataType: 'json',
					success: function(resultado){
						if(resultado == 1){
							parent.swal("","Párametro creado","success");
							$("#SL_PARAMETRO").html(parent.getParametros()).selectpicker("refresh");
						}
						else{
							parent.swal("","El Párametro no pudo ser creado","error");
						}
					},
					async: false
				});
			}
			else{
				parent.swal("","No ha ingresado el nombre del parámetro","error");
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
		var creados = 0;
		var crear = 0;
		if($("#SL_PARAMETRO").val()!=""){
			$("input[data-accion='crear']").each(function() {
				var nombre_parametro_detalle = $(this).val();
				var numero = $(this).attr('id').split("_");
				numero = numero[4];
				var valor_parametro_detalle = $("#tx_valor_nuevo_parametro_"+numero).val();
				var estado_crea = $("#estado_nuevo_parametro_crea_"+numero).data('estado');
				var estado_nidos = $("#estado_nuevo_parametro_nidos_"+numero).data('estado');
				var datos = {
					funcion:'crearParametroDetalle',
					p1:{
						'id_parametro' : $("#SL_PARAMETRO").val(),
						'nombre_parametro_detalle' : nombre_parametro_detalle,
						'valor_parametro_detalle': valor_parametro_detalle,
						'estado_crea' : estado_crea,
						'estado_nidos': estado_nidos
					}
				};
				$.ajax({
					url: url_service,
					type: 'POST',
					data: datos,
					dataType: 'json',
					success: function(resultado){
						if(resultado == 1){
							creados++;
						}
						else{

						}
					},
					async: false
				});
			});

			if(contador==creados){
				$("#SL_PARAMETRO").trigger('change');
			}else{
				parent.swal("","No se pudo completar la acción, Algo salió mal.","error");
			}
		}
		else{
			parent.swal("","Debe seleccionar un PARÁMETRO de la lista.","warning");
		}
	});

	$('#table_parametro_detalle').on("click", ".delete", function(){
		var tabla_parametro_detalle = $('#table_parametro_detalle').DataTable();
		tabla_parametro_detalle.row($(this).parents('tr')).remove().draw(false);	
		contador--;
		if(contador==0){
			$("#BT_Guardar").addClass("hidden");
		}
	});
	$("#dias_subsanacion_nav").click(function(){
		var datos = {
			funcion:'consultarFormAdministrarDiasSubsanacion'
		};
		$.ajax({
			url: url_service,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			$("#div_administrar_dias_subsanacion").html(data);
		}).fail(function(data){
			parent.mostrarAlerta("error","error","No se pudo consultar el formulario de administrar días de subsanación");
			console.log(data);
		});
	});
	$("#div_administrar_dias_subsanacion").delegate("#BT_actualizar_dias_subsanacion","click",function(){
		if($("#IN_ultimos_xx_dias").val() == "" || $("#IN_primeros_xx_dias").val() == "" || $("#IN_ultimos_xx_dias").val() >5 || $("#IN_primeros_xx_dias").val() > 5 || $("#IN_ultimos_xx_dias").val() < 0 || $("#IN_primeros_xx_dias").val() < 0)
		{
			parent.mostrarAlerta("warning","Advertencia","Los días de subsanación deben ser entre 0 y 5 y no pueden estar vacios");
		}
		else
		{
			parent.swal({
				title: '¿Está seguro?',
				text: "Este cambio afectar a TODOS los artistas formadores",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Sí!',
				cancelButtonText: 'Cancelar y verificar datos'
			}).then(function(){
				guardarNuevosDiasSubsanacion();
			}, function(dismiss){
				console.log("Cancelada la promesa");
				return false;
			});
		}
	});

	function guardarNuevosDiasSubsanacion(){
		var datos = {
			funcion:'guardarNuevosDiasSubsanacion',
			p1:{
				'ultimo_dia_mes' : $("#IN_ultimos_xx_dias").val(),
				'primer_dia_mes' : $("#IN_primeros_xx_dias").val(),
				'id_usuario' : parent.idUsuario
			}
		};
		$.ajax({
			url: url_service,
			type: 'POST',
			data: datos,
			async: false
		}).done(function(data){
			console.log(data);
			parent.mostrarAlerta("success","Guardado","Se han actualizado los datos de los días de inicio y fin para las subsanaciones.")
		}).fail(function(data){
			parent.mostrarAlerta("error","error","No se ha podido actualizar los días de inicio y fin para las subsanaciones");
		});
	}
});

function agregar_Fila(){
	contador++;
	$("#BT_Guardar").removeClass("hidden");
	var tabla_parametro_detalle = $('#table_parametro_detalle').DataTable();
	tabla_parametro_detalle.row.add( [
		"<input id='tx_nombre_nuevo_parametro_"+contador+"' type='text' class='form-control' data-accion='crear' style='margin-top:5%;'>",
		"<input id='tx_valor_nuevo_parametro_"+contador+"' type='text' class='form-control' style='margin-top:5%;'>",
		"<center><i id='estado_nuevo_parametro_crea_"+contador+"' style='color:#009f99;' class='fas fa-check-square fa-3x btn estado-nuevo-parametro' data-estado='1'></i></center>",
		"<center><i id='estado_nuevo_parametro_nidos_"+contador+"' style='color:#009f99;' class='fas fa-check-square fa-3x btn estado-nuevo-parametro' data-estado='1'></i></center>",
		"<center><button class='delete btn btn-danger fa fa-times-circle fa-2x' style='margin-top:5%;'></button></center>"
		]).draw();
}
