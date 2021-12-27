var hoyServidor = parent.obtenerFechaHora(false);
var hoy = new Date(hoyServidor.getFullYear(),hoyServidor.getMonth(),hoyServidor.getDate()); 
$(function(){
	getOptionsMisGruposTransicion();

	$("#TB_fecha_sesion").datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		language: 'es',
		startDate: new Date('2019-9-10'),
		endDate: hoy,
		autoclose: true,
		title: 'Fecha de la sesión'
	});

	$('#TB_fecha_sesion').on('change', function(e){
		e.preventDefault();
		var horario = $("#SL_grupo").find(':selected').data('horario');
		var dia_clase = $(this).val();
		var d = new Date(dia_clase);
		$("#TB_horas_sesion").val('0');
		for (var i = 0; i < horario.length; i ++) {
			if(d.getUTCDay() ==parseInt(horario[i]['dia'])){
				inicioMinutos = parseInt(horario[i]['hora_inicio'].substr(3,2));
				inicioHoras = parseInt(horario[i]['hora_inicio'].substr(0,2));

				finMinutos = parseInt(horario[i]['hora_fin'].substr(3,2));
				finHoras = parseInt(horario[i]['hora_fin'].substr(0,2));

				transcurridoMinutos = finMinutos - inicioMinutos;
				transcurridoHoras = finHoras - inicioHoras;

				if (transcurridoMinutos < 0) {
				transcurridoHoras--;
				transcurridoMinutos = 60 + transcurridoMinutos;
				}

				horas = transcurridoHoras.toString();
				minutos = transcurridoMinutos.toString();

				if (horas.length < 2) {
				horas = "0"+horas;
				}

				if (horas.length < 2) {
				horas = "0"+horas;
				}
				$("#TB_horas_sesion").val(horas);
			}
		}
		// console.log(d.getUTCDay());
	});

	$("#SL_grupo").on('change', function(e){
		e.preventDefault();
		var horario = $("#SL_grupo").find(':selected').data('horario');
		var dias_no_clase = [];
		for (var i = 0; i < horario.length; i ++) {
			dias_no_clase[i] = parseInt(horario[i]['dia']);
		}
		$("TB_fecha_sesion").datepicker('destroy');
		$("#TB_fecha_sesion").datepicker({
			format: 'yyyy-mm-dd',
			weekStart: 1,
			language: 'es',
			startDate: new Date('2019-9-10'),
			endDate: hoy,
			autoclose: true,
			title: 'Fecha de la sesión'
		});
		$('#TB_fecha_sesion').datepicker('setDaysOfWeekHighlighted',dias_no_clase);
		
		var datos = {
			'p1': {
				'id_grupo':$(this).val()
			}
		};
		$.ajax({
			url: '../../src/GestionClan/GestionClanController/consultarListadoBeneficiariosGrupoTransicion',
			type: 'POST',
			data: datos,
			async: true
		}).done(function(data){
			$("#div_table_mayores").html("");
			$("#div_table_menores").html("");
			try{
				var html_table_mayores = "<table class='table' id='table_mayores'><thead><tr><th>Documento</th><th>Nombre</th><th>Asistencia</th></tr></thead><tbody>";
				var html_table_menores = "<table class='table' id='table_menores'><thead><tr><th>Documento</th><th>Nombre</th><th>Asistencia</th></tr></thead><tbody>";
				data = $.parseJSON(data);
				for (var i = data.mayores.length - 1; i >= 0; i--) {
					html_table_mayores += "<tr><td>"+data.mayores[i]['IN_Identificacion']+"</td><td>"+data.mayores[i]['VC_Primer_Apellido']+" "+data.mayores[i]['VC_Segundo_Apellido']+" "+data.mayores[i]['VC_Primer_Nombre']+" "+data.mayores[i]['VC_Segundo_Nombre']+"</td><td><input type='checkbox' class='asistencia_clase' data-toggle='toggle' data-id_beneficiario='"+data.mayores[i]['id']+"' data-tipo_beneficiario='mayor'></td></tr>";
				}
				for (var i = data.menores.length - 1; i >= 0; i--) {
					html_table_menores += "<tr><td>"+data.menores[i]['IN_Identificacion']+"</td><td>"+data.menores[i]['VC_Primer_Apellido']+" "+data.menores[i]['VC_Segundo_Apellido']+" "+data.menores[i]['VC_Primer_Nombre']+" "+data.menores[i]['VC_Segundo_Nombre']+"</td><td><input type='checkbox' class='asistencia_clase' data-toggle='toggle' data-id_beneficiario='"+data.menores[i]['id']+"' data-tipo_beneficiario='menor'></td></tr>";
				}
				html_table_mayores += "</tbody></table>";
				html_table_menores += "</tbody></table>";
				$("#div_table_mayores").html(html_table_mayores);
				$("#div_table_menores").html(html_table_menores);
				var table_mayores = $("#table_mayores").DataTable({ 
					"pageLength": 100,
					"language": {
						"lengthMenu": "Ver _MENU_ registros por pagina",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando pagina _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtered from _MAX_ total records)",
						"search": "Filtrar"
					},
					dom: 'Bfrtip'
				}).on( 'draw', function () {
					$('.asistencia_clase').bootstrapToggle({
						on: 'SÍ',
						off: 'NO',
						onstyle: 'success',
						offstyle: 'danger'
					});
				}).draw();

				$("#tbody_table_menores").html(html_table_menores);
				var table_menores = $("#table_menores").DataTable({ 
					"pageLength": 100,
					"language": {
						"lengthMenu": "Ver _MENU_ registros por pagina",
						"zeroRecords": "No hay información, lo sentimos.",
						"info": "Mostrando pagina _PAGE_ de _PAGES_",
						"infoEmpty": "No hay registros disponibles",
						"infoFiltered": "(filtered from _MAX_ total records)",
						"search": "Filtrar"
					},
					dom: 'Bfrtip'
				}).on( 'draw', function () {
					$('.asistencia_clase').bootstrapToggle({
						on: 'SÍ',
						off: 'NO',
						onstyle: 'success',
						offstyle: 'danger'
					});
				}).draw();
				// console.log(data);
			}catch(ex){
				parent.mostrarAlerta("error","error","No se pudo decodificar el JSON de beneficiarios");
				console.log("Excepcion: " + ex + data);
		    	console.log(data);
			}
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido cargar los beneficiarios del grupo");
		    console.log(data);
		});
	});
	
	$("#BT_guardar_asistencia").click(function(ev){
		var fecha_sesion = $("#TB_fecha_sesion").val();
		if(fecha_sesion == ""){
			parent.mostrarAlerta("warning","Seleccione fecha","Debe seleccionar una fecha de sesión.");
		}else{
			if ($("#TB_horas_sesion").val() == 0){
				parent.mostrarAlerta("warning","Indique horas de sesion","Las horas de sesión deben ser superiores a cero.");
			}else{
				datos = {
					p1: {
						'id_grupo' : $("#SL_grupo").val(),
						'fecha_clase': $("#TB_fecha_sesion").val()
					},
					p2: {
						'tipo_grupo' : 'transicion',
					}
				};
				$.ajax({
					url: '../../src/ArtistaFormador/RegistrarAsistenciaController/validarFechaSesionClase',
					type:'POST',
					data: datos,
					beforeSend: function(){
						parent.mostrarCargando();
					},
					async: false
				}).done(function(data){
					parent.cerrarCargando();
					if(data == 1){
						parent.mostrarAlerta('error','Duplicidad de asistencia', 'Ya se registró asistencia para el día seleccionado!', function(){ $("#TB_fecha_sesion").focus(); });
					}else{
						var CH_asistencia_clase = new Array();
						$('.asistencia_clase').each(function() {
							CH_asistencia_clase.push(new Array($(this).data('id_beneficiario'),($(this).prop('checked')?1:0),$(this).data('tipo_beneficiario')));
						});
						var datos1 = {
							'p1': {
								'id_usuario':parent.idUsuario,
								'id_grupo':$("#SL_grupo").val(),
								'id_crea': $("#SL_grupo").find(':selected').data('id_crea'),
								'fecha_sesion':fecha_sesion,
								'observacion':$("#TX_observaciones").val(),
								'horas_clase':$("#TB_horas_sesion").val(),
								'asistencia':CH_asistencia_clase
							}
						}
						$.ajax({
							url: '../../src/ArtistaFormador/RegistrarAsistenciaController/RegistrarAsistenciaGrupoTransicion',
							type: 'POST',
							data: datos1,
							async: true
						}).done(function(data){
							parent.mostrarAlerta("success","Asistencia Guardada","Se ha registrado la asistencia " + data + " correctamente.");
						    console.log(data);
						}).fail(function(data){
							parent.mostrarAlerta("warning","Error","No se ha podido cargar los grupos");
						    console.log(data);
						});
					}
				}).fail(function(jqXHR,textStatus){
					parent.mostrarAlerta('error','Error','No se ha podido verificar si ya existe un registro de asistencia-sesión de clase para la fecha seleccionada : ' + textStatus);
				});
			}
		}
	});

	function getOptionsMisGruposTransicion(){
		var datos = {
			'p1': {
				'id_usuario':parent.idUsuario
			}
		};
		$.ajax({
			url: '../../src/GestionClan/GestionClanController/getOptionsMisGruposTransicion',
			type: 'POST',
			data: datos,
			async: true
		}).done(function(data){
		    $("#SL_grupo").html(data).selectpicker("refresh").trigger('change');
		}).fail(function(data){
			parent.mostrarAlerta("warning","Error","No se ha podido cargar los grupos");
		    console.log(data);
		});
	}
});