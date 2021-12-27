var url_service_obj = '../../src/Administracion/Controlador/AdministracionController.php';
var bandera_existencia = 0;
var contador_checked = 0;
var contador_areas_organizaciones = 1;
var session = "";
var cargos = ["Sin datos"];
$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip({
		position: { my: "center bottom", at: "center top" }
	});

	if(!alertify.myAlert){ 
   //define a new dialog 
   alertify.dialog('myAlert',function factory(){ 
   	return{ 
   		main:function(message){
   			this.message = message; 
   		}, 
   		setup:function(){ 
   			return {  
   			buttons:[{text: "cool!", key:27/*Esc*/}], 
   			focus: { element:0 } 
   		}; 
   	}, 
   	prepare:function(){ 
   		this.setContent(this.message); 
   	} 
   }}); 
}

$('#SL_AREA_ARTISTICA_1').html(parent.getOptionsAreasArtisticas()).selectpicker('refresh');
$('#SL_ORGANIZACION_1').html(parent.getOptionsOrganizaciones()).selectpicker('refresh');
$('#SL_Organizacion').append(parent.getOptionsOrganizaciones()).selectpicker('refresh');
$('#SL_TIPO_ARTISTA_1').html(parent.getOptionsParametroDetalle(32)).selectpicker('refresh');
$('#SL_TIPO_IDENTIFICACION').html(parent.getOptionsTiposDeIdentificacion());
$('#SL_TIPO_IDENTIFICACION').selectpicker('refresh');
$('#SL_SEXO').html(parent.getOptionsGenero());
$('#SL_SEXO').selectpicker('refresh');
$("#SL_ZONAS").html(parent.consultarZonas()).selectpicker('refresh');

$('.mayuscula').keyup(function(){
	$(this).val($(this).val().toUpperCase());
});

$("#tab_consulta_usuarios").click(function(ev){
	// $.ajax({
	// 	url: '../../src/GestionClan/GestionClanController/consultarZonas',
	// 	type: 'POST',
	// 	data: {},
	// 	async: true
	// }).done(function(result){
	// 	console.log(result)
	// 	$("#SL_ZONAS").html(result).selectpicker('refresh');
	// }).fail(function(result){
	// 	console.log("Error: "+result);
	// });
});

tabla_info_completa_usuarios = $("#tabla-info-completa-usuarios").DataTable({
	autoWidth: false,
	responsive: true,
	pageLength: 50,
	paging: true,
	info: false,
	dom: 'Bfrtip',
	buttons: [
	'excel'
	],
	"language": {
		"lengthMenu": "Ver _MENU_ registros por página",
		"zeroRecords": "No hay información, lo sentimos.",
		"info": "Mostrando pagina _PAGE_ de _PAGES_",
		"infoEmpty": "No hay registros disponibles",
		"infoFiltered": "(filtered from _MAX_ total records)",
		"search": "Filtrar"
	}
});

$('a[href="#consulta_info_completa_usuarios"]').click(function() {
	parent.mostrarCargando();
	$.ajax({
		url: url_service_obj,
		type: 'POST',
		dataType: 'json',
		data:{
			funcion: 'infoCompletaUsuarios'
		},
		success: function(data) {
			tabla_info_completa_usuarios.clear().draw();
			tabla_info_completa_usuarios.rows.add($(data["REGISTRO"])).draw();
			$($.fn.dataTable.tables(true)).DataTable()
			.columns.adjust()
			.responsive.recalc();
			parent.cerrarCargando();
		},
		error: function(data){
			parent.swal("Error", "No se pudo obtener la información solicitada, por favor intentelo nuevamente", "error");
		},
		async: true
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

listarCargos();

$("#TB_Cargo").on("keydown", function () {
	$( "#TB_Cargo" ).autocomplete('option', 'source', cargos);
});

$( "#TB_Cargo" ).autocomplete({
	source: cargos
});


  // name validation
  var nombresregex = /^[A-Za-zÁÉÍÓÚñáéíóúÑ ]+$/;

  $.validator.addMethod("validname", function( value, element ) {
  	return this.optional( element ) || nombresregex.test( value );
  }); 

	// valid email pattern
	var eregex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
	$.validator.addMethod("validemail", function( value, element ) {
		return this.optional( element ) || eregex.test( value );
	});

	var numeroidentifiacionregex = /^(?=.*[0-9])([a-zA-Z0-9]+)$/;
	$.validator.addMethod("validIdentification", function( value, element ) {
		return this.optional( element ) || numeroidentifiacionregex.test( value );
	});

	var numeroregex = /^([0-9]+)$/;
	$.validator.addMethod("validNumber", function( value, element ) {
		return this.optional( element ) || numeroregex.test( value );
	});

	var ruleSet1 = {
		required: true,
		validname: true,
		minlength: 3,
		maxlength: 50
	};
	var ruleSet2 = {
		required: false,
		validname: true,
		minlength: 3,
		maxlength: 50
	};
	var validator = $("#register-form").validate({
		rules:
		{
			var_id:{
				required: true
			},
			SL_PERFIL: {
				required: true
			},
			SL_TIPO_IDENTIFICACION: {
				required: true
			},
			TB_NIdentificacion: {
				required: true,
				validIdentification: true,
				maxlength: 20
			},
			TB_PNombre: ruleSet1,
			TB_SNombre: ruleSet2,
			TB_PApellido: ruleSet1,
			TB_SApellido: ruleSet2,
			TB_FNacimiento: {
				required: true
			},
			SL_SEXO:{
				required: true
			},
			TB_Celular: {
				required: true,
				validNumber: true,
				minlength: 7,
				maxlength: 10
			},
			TB_Correo: {
				required: true,
				validemail: true,
				maxlength: 50
			},
			TB_Cargo: {
				required: true,
				maxlength: 60
			}
		},
		messages:
		{ 
			var_id: {
				required: "Por favor seleccione un Programa"
			},
			SL_PERFIL: {
				required: "Por favor seleccione un perfil de usuario"
			},
			SL_TIPO_IDENTIFICACION: {
				required: "Por favor seleccione un tipo de identificación"
			},
			TB_NIdentificacion: {
				required: "Por favor ingrese un número de identificación",
				validIdentification: "El número de identificación solo debe contener números y/o letras",
				maxlength: "Por favor no ingrese más de 20 dígitos"
			},
			TB_PNombre: {
				required: "Por favor ingrese el primer nombre",
				validname: "El primer nombre solo debe contener letras y/o espacios",
				minlength: "El primer nombre es muy corto",
				maxlength: "Por favor no ingrese más de 50 caracteres"
			},
			TB_SNombre: {
				validname: "El segundo nombre solo debe contener letras y/o espacios",
				minlength: "El segundo nombre es muy corto",
				maxlength: "Por favor no ingrese más de 50 caracteres"
			},
			TB_PApellido: {
				required: "Por favor ingrese el primer apellido",
				validname: "El primer apellido solo debe contener letras y/o espacios",
				minlength: "El primer apellido es muy corto",
				maxlength: "Por favor no ingrese más de 50 caracteres"
			},
			TB_SApellido: {
				validname: "El segundo apellido solo debe contener letras y/o espacios",
				minlength: "El segundo apellido es muy corto",
				maxlength: "Por favor no ingrese más de 50 caracteres"
			},
			TB_FNacimiento: {
				required: "Por favor indique una fecha de nacimiento"
			},
			SL_SEXO: {
				required: "Por favor seleccione un genero"
			},
			TB_Celular: {
				required: "Por favor ingrese un número de Celular",
				validNumber: "El celular solo debe contener números",
				minlength: "El número de celular es muy corto",
				maxlength: "Por favor no ingrese más de 10 dígitos"
			},
			TB_Correo: {
				required: "Por favor ingrese un Email",
				validemail: "Ingrese un Email válido",
				maxlength: "Por favor no ingrese más de 50 caracteres" 
			},
			TB_Cargo: {
				required: "Por favor ingrese un Cargo",
				maxlength: "Por favor no ingrese más de 60 caracteres"
			}
		},
		errorPlacement : function(error, element) {
			$(element).closest('.form-group').find('.help-block').html(error.html());
		},
		highlight : function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			$(element).closest('.form-group').find('.help-block').html('');
		}
	});

	$('.areas_organizaciones').each(function() {
		$(this).rules('add', {
			required: true,
			number: true,
			messages: {
				required:  "Por favor seleccione una opción.",
			}
		});
	});

	$('.searchable-container .items').on("change",function() {
		var programa = [];
		var perfiles = [];
		contador_checked = 0;
		//console.log(contador_checked);
		$("#SL_PERFIL").html("");
		$('#SL_PERFIL').selectpicker("refresh");
		$('input:checked').each(function() {
			if($(this).val()== "CREA"){
				contador_checked++;
				$('#SL_PERFIL').append(parent.getOptionsPerfiles("2"));
				$("#SL_PERFIL").selectpicker({title: 'Seleccione un perfil de usuario'}).selectpicker('render');
				$('#SL_PERFIL').selectpicker("refresh");
			}
			if($(this).val()== "NIDOS"){
				contador_checked++;
				$('#SL_PERFIL').append(parent.getOptionsPerfiles("3"));
				$("#SL_PERFIL").selectpicker({title: 'Seleccione un perfil de usuario'}).selectpicker('render');
				$('#SL_PERFIL').selectpicker("refresh");
			}
			if($(this).val()== "CULTURAS"){
				contador_checked++;
				$('#SL_PERFIL').append(parent.getOptionsPerfiles("98"));
				$("#SL_PERFIL").selectpicker({title: 'Seleccione un perfil de usuario'}).selectpicker('render');
				$('#SL_PERFIL').selectpicker("refresh");
			}
			if(contador_checked == 3){
				$('#SL_PERFIL').append(parent.getOptionsPerfiles("4"));
				$("#SL_PERFIL").selectpicker({title: 'Seleccione un perfil de usuario'}).selectpicker('render');
				$('#SL_PERFIL').selectpicker("refresh");
			}
		});
	});

	$("#a-add").on('click', function(){
		contador_areas_organizaciones++;
		$("#contenedor-areas-organizaciones").append("<div id='row_"+contador_areas_organizaciones+"' class='col-md-12'><div class='col-md-4'><div class='form-group'><div class='input-group'><div class='input-group-addon' style='color:Tomato'><span class='fab fa-adn'></span></div><select id='SL_AREA_ARTISTICA_"+contador_areas_organizaciones+"' name='SL_AREA_ARTISTICA"+contador_areas_organizaciones+"' class='form-control selectpicker areas_organizaciones' data-live-search='true' title='Área Artística' data-toggle='tooltip' data-placement='top'></select></div><span class='help-block' id='error'></span></div></div><div class='col-md-4'><div class='form-group'><div class='input-group'><div class='input-group-addon'><span class='fas fa-dot-circle' style='color:Tomato'></span></div><select id='SL_ORGANIZACION_"+contador_areas_organizaciones+"' name='SL_ORGANIZACION_"+contador_areas_organizaciones+"' class='form-control selectpicker areas_organizaciones' data-live-search='true' title='Organización' data-toggle='tooltip' data-placement='top'></select></div><span class='help-block' id='error'></span></div></div><div class='col-md-4'><div class='form-group'><div class='input-group'><div class='input-group-addon'><span class='fas fa-dot-circle' style='color:Tomato'></span></div><select id='SL_TIPO_ARTISTA_"+contador_areas_organizaciones+"' name='SL_TIPO_ARTISTA_"+contador_areas_organizaciones+"' class='form-control selectpicker areas_organizaciones' data-live-search='true' title='Tipo Artista' data-toggle='tooltip' data-placement='top'></select></div><span class='help-block' id='error'></span></div></div></div>");
		$('.areas_organizaciones').each(function() {
			$(this).rules('add', {
				required: true,
				number: true,
				messages: {
					required:  "Por favor seleccione una opción.",
				}
			});
		});
		$("#SL_AREA_ARTISTICA_"+contador_areas_organizaciones).html(parent.getOptionsAreasArtisticas()).selectpicker("refresh");
		$("#SL_ORGANIZACION_"+contador_areas_organizaciones).html(parent.getOptionsOrganizaciones()).selectpicker("refresh");
		$("#SL_TIPO_ARTISTA_"+contador_areas_organizaciones).html(parent.getOptionsParametroDetalle(32)).selectpicker("refresh");
	});
	$("#a-delete").on('click', function(){
		if(contador_areas_organizaciones>1){
			$("#row_"+contador_areas_organizaciones).remove();
			contador_areas_organizaciones--;
		}
	});

	$("#modal_organizaciones").find("#capturar_organizaciones").on('click', function(){
		var valores = "";
		var nombre_elemento = "SL_AREAS_ARTISTICAS";
		$('#'+nombre_elemento+' :selected').each(function(i, selected){ 
			valores += $("#modal_organizaciones #SL_Organizacion_Area_"+$(selected).val()).val()+";";     
		});
		escribir_organizaciones(valores);
		$("#modal_organizaciones").modal('hide');
	});

	var ident = "";
	$("#SL_PERFIL").on('change', function(){
		if($(this).val()==1){
			contador_areas_organizaciones = 1;
			validarExistenciaUsuario($('#TB_NIdentificacion').val());
			$("#div_informacion_artistica").show('slow');
			$(".areas_organizaciones").prop('required', true);
			//$("#TB_Organizaciones").prop('required', true);
		}else{
			$("#div_informacion_artistica").hide('slow');
			$('.areas_organizaciones').val("");
			$('.areas_organizaciones').selectpicker("refresh");
			$(".areas_organizaciones").removeAttr('required');
			limpiarAreasOrganizaciones();
			contador_areas_organizaciones = 0;
		}
	});
	$(".readonly").on('keydown paste', function(e){
		e.preventDefault();
	});
	$("#TB_FNacimiento").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#TB_NIdentificacion").on('blur', function() {
		resetFormulario();
		validarExistenciaUsuario($(this).val());
	});

	$('#BTN_RESET').on('click', function(e){
		e.preventDefault();
		resetFormulario(1);
	});
	
	$("#register-form").on('submit', function(e){
		e.preventDefault();
		if ($(this).valid()) {
			alertify.confirm('Confirmar acción', 'Confirma que desea continuar?',
				function(){ 
					if (bandera_existencia == 0) {
						var formulario = $("#register-form").serializeArray();
						datos = {
							funcion: 'registrarUsuario', 
							p1: formulario,
							p2: contador_areas_organizaciones,
							p3: contador_checked // Si es 1 cambian los indices de los items del Formulario Serializado. (Empieza en 1)
						};
						console.log(formulario);
						$.ajax({
							async : false,
							url: url_service_obj,
							type: 'POST',
							dataType: 'html',
							data: datos,
							success: function(retorno)
							{
								var mensaje = "El usuario fue registrado.<br><br>Datos de Acceso:<br><br>"+retorno;
								alertify.alert("SIF notifica que:",mensaje);
								resetFormulario(1);
								listarCargos();
							}
						});
					}
					else{
						var formulario = $("#register-form").serializeArray();
						datos = {
							funcion: 'actualizarUsuario', 
							p1: formulario,
							p2: contador_areas_organizaciones,
							p3: bandera_existencia, //Aquí va el ID del Usuario que se modificará.
							p4: contador_checked // Si es 2 cambian los indices de los items del Formulario Serializado. (Empieza en 2)
						};
						$.ajax({
							async : false,
							url: url_service_obj,
							type: 'POST',
							dataType: 'html',
							data: datos,
							success: function(retorno)
							{
								var mensaje = "El usuario fue actualizado.<br><br>Datos de Acceso:<br><br>"+retorno;
								alertify.alert("SIF notifica que:",mensaje);
								resetFormulario(1);
								listarCargos();
								$("#TB_Organizaciones").prop('readonly', false);
								$("#BTN_SUBMIT").html("Registrar");
								$("#BTN_SUBMIT").removeClass("btn-success");
								$("#BTN_SUBMIT").addClass("btn-primary");
							}
						});
					}
				}
				,function(){
				});
		}
	});
	
	var contador=0;
	var tabla_usuarios="";
	tabla_usuarios = $("#tabla_usuarios").DataTable({
		destroy: true,
		"language": {
			"lengthMenu": "Mostrar _MENU_ registros por pagina",
			"zeroRecords": "Ningun resultado...",
			"info": "Mostrando pagina _PAGE_ de _PAGES_",
			"infoEmpty": "Ningun resultado...",
			"infoFiltered": "(Filtrado de un total de _MAX_ registros)"
		}
	});
	$("#form_consultar_usuarios").on('submit', function(e){
		contador++;
		e.preventDefault();
		var organizacion = $("#SL_Organizacion").val();
		parent.mostrarCargando();
		var datos = {
			funcion:'getUsuariosOrganizacion',
			p1:{
				'organizacion': organizacion,
			}
		};
		tabla_usuarios.clear().draw();
		$.ajax({
			url: url_service_obj,
			type: 'POST',
			dataType: 'html',
			data: datos,
			success: function(usuarios)
			{
				tabla_usuarios.rows.add($(usuarios)).draw();
				tabla_usuarios.columns([0]).visible(false);
				parent.cerrarCargando();
			}
	 });//CIERRA AJAX
  });//CIERRA SUBMIT CONSULTAR USUARIOS

	$('#tabla_usuarios').on( 'click', 'a', function () 
	{
		var datosTabla=tabla_usuarios.row(($(this).parent()).parent()).data();
		ident = datosTabla[0];

		if ($(this).attr('id') === 'activacion')
		{
			parent.swal({
				title: "Seguro desea activar el usuario "+datosTabla[2]+"?",
				input: 'text',
				inputValue: 'Inicio de contrato 00-00-2019',
				showCancelButton: true,
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'Enviar',
			}).then((result) => {
				var datos = {
					funcion:'cambiarEstadoUsuario',
					p1:{
						'estado': 1,
						'id_usuario':ident,
						'justificacion':result,
						'id_usuario_administrador': session
					}
				};

				$.ajax({
					async : false,
					url: url_service_obj,
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function(retorno)
					{
						if(retorno == 2){
							parent.swal('Realizado','Se ha activado al usuario','success');
							setTimeout(function(){ 
								$("#form_consultar_usuarios").submit();
							}, 1000);
						}
						else{
							parent.swal('Error','No se puedo realizar la acción','error');
						}
					}
				});
			}).catch(parent.swal.noop);
		}
		if ($(this).attr('id') === 'desactivacion')
		{
			parent.swal({
				title: "Seguro desea desactivar el usuario "+datosTabla[2]+"?",
				input: 'text',
				inputValue: 'Terminación de contrato 00-00-2019',
				showCancelButton: true,
				cancelButtonText: 'Cancelar',
				confirmButtonText: 'Enviar',
			}).then((result) => {
				var datos = {
					funcion:'cambiarEstadoUsuario',
					p1:{
						'estado': 0,
						'id_usuario':ident,
						'justificacion':result,
						'id_usuario_administrador': session
					}
				};

				$.ajax({
					async : false,
					url: url_service_obj,
					type: 'POST',
					dataType: 'html',
					data: datos,
					success: function(retorno)
					{
						if(retorno == 2){
							parent.swal('Realizado','Se ha desactivado al usuario','success');
							setTimeout(function(){ 
								$("#form_consultar_usuarios").submit();
							}, 1000);
						}
						else{
							parent.swal('Error','No se puedo realizar la acción','error');
						}
					}
				});
			}).catch(parent.swal.noop);
		}
		if ($(this).attr('id') === 'restablecer')
		{
			parent.swal({
				title: 'Confirma la acción?',
				text: "Se reestablecera la contraseña del Usuario "+datosTabla[2]+". La nueva contraseña será el NÚMERO DE IDENTIFICACIÓN, Esta seguro?",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'SI, Restablecer',
				cancelButtonText: 'NO'
			}).then((result) => {
				if (result) {
					var datos = {
						funcion:'actualizarPassword',
						p1:{
							'id_persona': ident,
							'password':datosTabla[1],
							'id_session': session
						}
					};
					$.ajax({
						async : false,
						url: url_service_obj,
						type: 'POST',
						dataType: 'html',
						data: datos,
						success: function(retorno)
						{
							if(retorno == 1){
								parent.swal('Realizado','LA CONTRASEÑA DEL USUARIO HA SIDO REESTABLECIDA','success');
							}
							else{
								if (retorno == '-1') {
									parent.swal('Sin cambios','La contraseña es el número de documento','warning');	
								}else{
									parent.swal('Error','La acción no pudo ser realizada','error');	
								}
							}
						}
					});
				}
			}).catch(parent.swal.noop);
		}
		if ($(this).attr('id') === 'perfil')
		{
			cantidad_organizaciones = 0;
			$("#modal_perfil").modal('show');
			$("#modal_perfil").find('.modal-title').html("");
			$("#modal_perfil").find('.modal-title').append("Perfil del Usuario "+datosTabla[2]);
			var datos = {
				funcion:'consultarOrganizacionesFormador',
				p1:{
					'id_usuario': ident
				}
			};
			$.ajax({
				async : false,
				url: url_service_obj,
				type: 'POST',
				dataType: 'json',
				data: datos,
				success: function(retorno)
				{
					$("#tabla_organizaciones_usuario").html("");
					$("#tabla_organizaciones_usuario").append(
						"<thead><tr><th class=col-xs-1 col-sm-1 col-md-1 col-lg-1>Id Registro</th><th class=col-xs-1 col-sm-1 col-md-1 col-lg-1>Organización</th><th class=col-xs-1 col-sm-1 col-md-1 col-lg-1>Area Artística</th><th class=col-xs-1 col-sm-1 col-md-1 col-lg-1>Perfil</th></tr></thead><tbody>"
						);
					$.each(retorno, function(i) 
					{
						cantidad_organizaciones++;
						$("#tabla_organizaciones_usuario").append("<tr><td class=col-xs-1 col-sm-1 col-md-1 col-lg-1><p id=id_registro_"+i+">"+retorno[i].PK_Id_Tabla+"</p></td><td class=col-xs-5 col-sm-5 col-md-5 col-lg-5>"+retorno[i].VC_Nom_Organizacion+"</td></td><td class=col-xs-5 col-sm-5 col-md-5 col-lg-5>"+retorno[i].VC_Descripcion+"</td><td class=col-xs-1 col-sm-1 col-md-1 col-lg-1><select id=perfil_"+i+" name=perfil class=form-control><option value=''>N/A</option><option value=A>A</option><option value=B>B</option><option value=C>C</option><option value=D>D</option></select></td></tr>");
						var nombre_perfil = "perfil_"+i;
						$("#"+nombre_perfil+" option").filter(function() { return $(this).text() == retorno[i].VC_Perfil; }).prop('selected', true);
					});
				}
			});
		}
		if ($(this).attr('id') === 'zona')
		{
			$("#div_zonas").html("");
			$("#modal_zona").modal('show');
			$("#modal_zona").find('.modal-title').html("");
			$("#modal_zona").find('.modal-title').append("Zonas del Usuario "+datosTabla[2]);
			$.ajax({
				url: '../../src/GestionClan/GestionClanController/consultarZonasFormador',
				type: 'POST',
				data: {p1:{'id_artista_formador':ident}},
				async: true
			}).done(function(result){
				try{
					data = $.parseJSON(result);
					if(data.length > 0){
						var json_zonas = data[0]['JSON_zona'];
						json_zonas = $.parseJSON(json_zonas)
						$("#SL_ZONAS").selectpicker("val",json_zonas);
						console.log(json_zonas);
					}else{
						// parent.mostrarAlerta('warning','Sin categorizar','El usuario no tiene zonas asignadas');
						$("#SL_ZONAS").selectpicker('deselectAll');
					}
				}catch(ex){
					parent.mostrarAlerta('error','Error','No se pudo decodificar JSON de zonas');
				}
			}).fail(function(result){
				console.log("Error: "+result);
			});
		}
	});

$("#guardar-perfil").on('click',function(){
	if(cantidad_organizaciones>0){
		for(i=0;i<cantidad_organizaciones;i++)
		{
			var id_registro = "id_registro_"+i;
			var nombre_perfil = "perfil_"+i;
			var nombre_fecha = "fecha_"+i;

			valor_id = $("#"+id_registro).text();
			valor_perfil = $("#"+nombre_perfil).val();
			valor_fecha = $("#"+nombre_fecha).val();

			var datos = {
				funcion:'actualizarPerfilFormador',
				p1:{
					'id_registro': valor_id,
					'perfil':valor_perfil
				}
			};
			$.ajax({
				async : false,
				url: url_service_obj,
				type: 'POST',
				dataType: 'html',
				data: datos,
				success: function(retorno)
				{
					if(i==(cantidad_organizaciones-1)){
						parent.swal("","La información del perfil ha sido guardada", "success");
						$("#modal_perfil").modal('hide');
					}
				}
			});

		}
	}
	else
	{
		parent.swal("","El usuario no tiene organizacion(es) asociadas","warning");
	}
});

$("#guardar-zonas").on('click',function(e){
	e.preventDefault();
	zona_guardar = [];
	$("#SL_ZONAS  :selected").each(function(){
		// bandera++;
		zona_guardar.push($(this).attr('value'));
		// var datos = {id_persona:ident, id_zona:$(this).attr('value'), bandera:bandera};
		// $.ajax({
		// 	async : false,
		// 	url: '../../src/GestionClan/GestionClanController/GuardarZonasUsuario',
		// 	type: 'POST',
		// 	dataType: 'html',
		// 	data: {p1:datos},
		// 	success: function(retorno)
		// 	{
		// 		if(bandera==$("#SL_ZONAS :selected").length){
		// 			bootbox.alert('Se han guardado las zonas del Usuario').find('.modal-content').css({
		// 				'background-color' : 'rgb(26,170,0)', 
		// 				'color': '#fff',
		// 				'font-size': '4em', 
		// 				'font-weight' : 'bold',
		// 				'margin-top': function (){
		// 					var w = $( window ).height();
		// 					var b = $(".modal-dialog").height();
		// 		 // should not be (w-h)/2
		// 		 var h = (w-b)/2;
		// 		 return h+"px";
		// 		}
		// 		 });//CIERRA BOOTBOX
		// 			$("#modal_zona").modal('hide');
		// 		}
		// 	}
	 //  });//CIERRA AJAX
		 //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));
		});
	if(zona_guardar.length == 0){
		parent.mostrarAlerta("warning","Zonas vacias","Debe seleccionar mínimo una (01) zona.");
	}else{
		var datos = {
			p1:{
				'id_artista_formador':ident,
				'id_usuario': parent.idUsuario,
				'zonas':zona_guardar
			}
		}
		$.ajax({
			url: '../../src/GestionClan/GestionClanController/GuardarZonasUsuario',
			type: 'POST',
			data: datos,
			async: false
		}).done(function(result){
			if(result == 1){
				parent.mostrarAlerta("success","Zonas guardadas","Se han guardado correctamente las zonas del artista formador.");
			}else{
				parent.mostrarAlerta("error","No se pudo actualizar las zonas del formador","Ocurrió un error al intentar guardar las zonas del formador.");
			}
		}).fail(function(result){
			console.log("Error: "+result);
		});
	}
	
	});//CIERRA GUARDAR ZONAS 

$("#tabla_usuarios").delegate(".ver_observaciones_usuario","click",function(){
	var id_usuario = $(this).data("id_usuario");
	var table_observaciones = "";
	datos = {
		funcion: 'consultarObservacionesUsuario', 
		p1: {
			id_usuario: id_usuario
		}
	};
	$.ajax({
		url: url_service_obj,
		type:'POST',
		data: datos,
		async: false
	}).done(function(data){
		table_observaciones += data;
	}).fail(function(data){
		console.log("fail" + data);
	});
	alertify.alert("Historial de observaciones",table_observaciones);
});
});

function escribir_organizaciones(valores){
	var id = "TB_Organizaciones";
	$("#"+id).val(valores);
	$("#"+id).prop('readonly', true);
}

function abrirmodalorganizaciones(){
	$("#modal_organizaciones").modal('show');
	$('body').css('height', '100');
	var organizaciones = $("#TB_Organizaciones").val();
	organizaciones = organizaciones.split(";");
	var nombre_elemento = "SL_AREAS_ARTISTICAS";
	if(organizaciones != "")
	{
		$('#'+nombre_elemento+' :selected').each(function(i, selected){ 
		//cantidad_informes += 1;
		//values += $(selected).val()+";";
		$("#SL_Organizacion_Area_"+$(selected).val()).val(organizaciones[i]);
		$("#SL_Organizacion_Area_"+$(selected).val()).selectpicker("refresh");
	});
	}
	else{
		$('#'+nombre_elemento+' :selected').each(function(i, selected){ 
		//cantidad_informes += 1;
		//values += $(selected).val()+";";
		$("#SL_Organizacion_Area_"+$(selected).val()).val('');
		$("#SL_Organizacion_Area_"+$(selected).val()).selectpicker("refresh");
	});
	}
}

function validarExistenciaUsuario(identificacion){
	datos = {
		funcion: 'consultarExistenciaUsuario', 
		p1: identificacion
	};
	$.ajax({
		async : false,
		url: url_service_obj,
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(INFO)
		{
			if(INFO[0]){
				bandera_existencia = INFO[0].PK_Id_Persona;
				$("#BTN_SUBMIT").html("ACTUALIZAR");
				$("#BTN_SUBMIT").removeClass("btn-info");
				$("#BTN_SUBMIT").addClass("btn-success");
				alertify.alert("SIF notifica que:","Ya se encuentra registrado un usuario con el mismo documento, podrá actualizar su información a continuación.");
				$("#SL_TIPO_IDENTIFICACION").val(INFO[0].FK_Tipo_Identificacion);
				$("#SL_TIPO_IDENTIFICACION").selectpicker('refresh');
				$("#TB_PNombre").val(INFO[0].VC_Primer_Nombre);
				$("#TB_SNombre").val(INFO[0].VC_Segundo_Nombre);
				$("#TB_PApellido").val(INFO[0].VC_Primer_Apellido);
				$("#TB_SApellido").val(INFO[0].VC_Segundo_Apellido);
				$("#TB_FNacimiento").val(INFO[0].DD_F_Nacimiento);
				$("#SL_SEXO").val(INFO[0].FK_Id_Genero);
				$("#SL_SEXO").selectpicker('refresh');
				$("#TB_Celular").val(INFO[0].VC_Celular);
				$("#TB_Correo").val(INFO[0].VC_Correo);
				$("#TB_Cargo").val(INFO[0].VC_Cargo);
				if ($('#SL_PERFIL').val()==1) {
					cargarAreasArtisticasOrganizaciones(INFO[0].PK_Id_Persona);	
				}
			}
			else{
				bandera_existencia = 0;
				$("#BTN_SUBMIT").html("Registrar");
				$("#BTN_SUBMIT").removeClass("btn-success");
				$("#BTN_SUBMIT").addClass("btn-primary");
			}
		}
  });//FIN AJAX
}

function resetFormulario(parametro){
	if(parametro == 1){
		$("#TB_NIdentificacion").val("");
		$("#SL_PERFIL").val("");
		$("#SL_PERFIL").selectpicker("refresh");
	}
	$(".has-error").removeClass("has-error");
	$(".has-success").removeClass("has-success");
	$('.help-block').html('');
	$("#TB_PNombre").val("");
	$("#TB_SNombre").val("");
	$("#TB_PApellido").val("");
	$("#TB_SApellido").val("");
	$("#TB_FNacimiento").val("");
	$("#SL_SEXO").val("");
	$("#SL_SEXO").selectpicker("refresh");
	$("#SL_TIPO_IDENTIFICACION").val("");
	$("#SL_TIPO_IDENTIFICACION").selectpicker("refresh");
	$("#SL_SEXO").val("");
	$("#SL_SEXO").selectpicker("refresh");
	$("#TB_Celular").val("");
	$("#TB_Correo").val("");
	$("#TB_Cargo").val("Contratista");
	$('.areas_organizaciones').each(function() {
		$(this).val("");
		$(this).selectpicker("refresh");
	});
	$('#TB_Organizaciones').val("");
	$("#BTN_SUBMIT").html("Registrar");
	$("#BTN_SUBMIT").removeClass("btn-success");
	$("#BTN_SUBMIT").addClass("btn-primary");	
}

function cargarAreasArtisticasOrganizaciones($id_persona){
	var datos = {
		funcion: 'consultarAreasOrganizacionesPersona',
		p1: $id_persona
	}
	$.ajax({
		async : false,
		url: url_service_obj,
		type: 'POST',
		dataType: 'json',
		data: datos,
		success: function(areas_organizaciones)
		{
			limpiarAreasOrganizaciones();
			var organizaciones = "";
			$('.areas_organizaciones').val("");
			$('.areas_organizaciones').selectpicker('refresh');
			var indice = 0;
			$.each(areas_organizaciones, function(i) 
			{	
				indice = i+1;
				if(indice>1){
					$("#a-add").click();
				}
				$("#SL_AREA_ARTISTICA_"+indice+" option").filter(function() { return $(this).val() == areas_organizaciones[i].FK_Area_Artistica; }).prop('selected', true);
				$("#SL_AREA_ARTISTICA_"+indice).selectpicker("refresh");
				$("#SL_ORGANIZACION_"+indice+" option").filter(function() { return $(this).val() == areas_organizaciones[i].FK_Organizacion; }).prop('selected', true);
				$("#SL_ORGANIZACION_"+indice).selectpicker("refresh");
				$("#SL_TIPO_ARTISTA_"+indice+" option").filter(function() { return $(this).val() == areas_organizaciones[i].FK_Tipo_Artista; }).prop('selected', true);
				$("#SL_TIPO_ARTISTA_"+indice).selectpicker("refresh");
			});
		}
	});
}

function limpiarAreasOrganizaciones(){
	for(i=contador_areas_organizaciones;i>1;i--){
		$("#a-delete").click();
	}
}

function listarCargos(){
	resultado = parent.getCargos();
	cargos = [''];
	$.each(resultado, function(i)
	{
		cargos.push(resultado[i].VC_Cargo);
	});
}